<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\PurchaseReturnDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Commercial\Models\Purchase;
use App\Modules\Config\Models\Lookup;
use App\Modules\StoreInventory\Models\Inventory;
use App\Modules\StoreInventory\Models\PurchaseReturn;
use App\Modules\StoreInventory\Models\PurchaseReturnDetails;
use App\Modules\StoreInventory\Models\Stores;
use Carbon\Carbon;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends BaseController
{
    public $model;
    public $store;

    public function __construct(PurchaseReturn $model)
    {
        $this->middleware('permission:purchase_return.index|purchase_return.create|purchase_return.edit|purchase_return.delete|purchase_return.report|purchase_return.product_wise_report', ['only' => ['index','show']]);
        $this->middleware('permission:purchase_return.create', ['only' => ['create','store']]);
        $this->middleware('permission:purchase_return.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:purchase_return.delete', ['only' => ['delete']]);
        $this->middleware('permission:purchase_return.report', ['only' => ['purchaseReturnReport','purchaseReturnReportView']]);
        $this->middleware('permission:purchase_return.product_wise_report', ['only' => ['productWisePurchaseReturnReport','productWisePurchaseReturnReportView']]);

        $this->model = $model;
        $this->store = new Stores();
    }

    public function index(PurchaseReturnDataTable $dataTable)
    {
        $this->setPageTitle('Purchase Return', 'List of all Purchase Return');
        return $dataTable->render('StoreInventory::purchaseReturn.index');
    }

    public function create()
    {
        $stores = $this->store->treeList();
        $this->setPageTitle('Create Purchase Return', 'Create Purchase Return');
        return view('StoreInventory::purchaseReturn.create', compact('stores'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'date' => 'required|date',
            'supplier_id' => 'required|integer',
            'product' => 'required|array',
            'grand_total' => 'required|min:1',
        ]);
        $params = $request->except('_token');

        try {
            DB::beginTransaction();
            $invoice = new PurchaseReturn();
            $maxSlNo = $invoice->maxSlNo($supplier_id = $params['supplier_id']);
            $year = Carbon::now()->year;
            $invNo = "RTN-$supplier_id-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

            $invoice->max_sl_no = $maxSlNo;
            $invoice->return_no = $invNo;
            $invoice->purchase_id =  $params['invoice_no'];
            $invoice->store_id = Stores::DEFAULT_WAREHOUSE;
            $invoice->supplier_id = $params['supplier_id'];
            $invoice->amount = $grand_total = $params['grand_total'];
            $invoice->date = $date = $params['date'];
            $invoice->created_by = $created_by = auth()->user()->id;
            if ($invoice->save()) {
                $invoice_id = $invoice->id;
                $i = 0;
                $isAnyItemIsMissing = false;
                foreach ($params['product']['temp_product_id'] as $product_id) {
                    $stock_qty = $params['product']['temp_stock_qty'][$i];
                    $return_price = $params['product']['temp_return_price'][$i];
                    $return_qty = $params['product']['temp_return_qty'][$i];
                    $row_return_price = $params['product']['temp_row_return_price'][$i];
                    $stock_qty = \App\Modules\StoreInventory\Models\Inventory::closingStockWithStore($product_id, $invoice->store_id);
                    if ($stock_qty > 0) {
                        $inventory = new Inventory();
                        $inventory->store_id = Stores::DEFAULT_WAREHOUSE;
                        $inventory->product_id = $product_id;
                        $inventory->stock_in = 0;
                        $inventory->stock_out = $return_qty;
                        $inventory->ref_type = Inventory::REF_PURCHASE_RETURN;
                        $inventory->ref_id = $invoice_id;
                        $inventory->date = $date;
                        $inventory->created_by = $created_by;
                        if ($inventory->save()) {
                            $invoiceDetails = new PurchaseReturnDetails();
                            $invoiceDetails->return_id = $invoice_id;
                            $invoiceDetails->product_id = $product_id;
                            $invoiceDetails->qty = $return_qty;
                            $invoiceDetails->price = $return_price;
                            $invoiceDetails->row_total = $row_return_price;
                            $invoiceDetails->save();
                        }
                    } else {
                        $isAnyItemIsMissing = true;
                    }
                    $i++;
                }


                if($grand_total >= $params['invoice_due']){
                    $purchase = Purchase::findOrFail($invoice->purchase_id);
                    if ($purchase) {
                        $purchase->full_paid = Purchase::PAID;
                        $purchase->save();
                    }
                }
                DB::commit();
                if ($isAnyItemIsMissing == false) {
                    $data = new PurchaseReturn();
                    $data = $data->where('id', '=', $invoice_id);
                    $data = $data->first();

                    $returnHTML = view('StoreInventory::purchaseReturn.voucher', compact('data'))->render();
                    return $this->responseJson(false, 200, "Purchase Return Created Successfully.", $returnHTML);
                } else {
                    DB::rollback();
                    return $this->responseJson(true, 200, "Voucher not found!");
                }
            } else {
                return $this->responseJson(true, 200, "Voucher not found!");
            }

        } catch (QueryException $exception) {
            DB::rollback();
            throw new InvalidArgumentException($exception->getMessage());
            //return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
        }
    }

    public function voucher(Request $request)
    {
        if ($request->has('id')) {
            $data = new PurchaseReturn();
            $data = $data->where('id', '=', $request->id);
            $data = $data->first();
            if ($data) {
                $returnHTML = view('StoreInventory::purchaseReturn.voucher', compact('data'))->render();
                return $this->responseJson(false, 200, "", $returnHTML);
            } else {
                return $this->responseJson(true, 200, "Voucher not found!");
            }
        } else {
            return $this->responseJson(true, 200, "Please insert 55 no!");
        }
    }

    public function purchaseReturnReport()
    {
        $this->setPageTitle('Purchase Return Report', 'Purchase Return Report');
        return view('StoreInventory::reports.purchase-return-report');
    }

    public function purchaseReturnReportView(Request $request):?jsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $supplier_id = trim($request->supplier_id);
            $data = new PurchaseReturn();
            $data = $data->where('date','>=',$start_date);
            $data = $data->where('date','<=',$end_date);
            if ($supplier_id > 0) {
                $data = $data->where('supplier_id', '=', $supplier_id);
            }
            $data = $data->orderby('id', 'desc');
            $data = $data->get();

        }

        $returnHTML = view('StoreInventory::reports.purchase-return-report-view', compact('data', 'start_date', 'end_date', 'supplier_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function productWisePurchaseReturnReport()
    {
        $this->setPageTitle('Product Wise Purchase Return Report', 'Product Wise Purchase Return Report');
        return view('StoreInventory::reports.product-wise-purchase-return-report');
    }

    public function productWisePurchaseReturnReportView(Request $request):?jsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $product_id = trim($request->product_id);
            if ($product_id > 0) {
                $data = DB::table('purchase_returns as p')
                    ->select(DB::raw('p.date, pd.name, sum(pdt.qty) as qty, pdt.price, sum(pdt.row_total) as amount'))
                    ->leftJoin('purchase_return_details as pdt', 'p.id', '=', 'pdt.return_id')
                    ->leftJoin('products as pd', 'pdt.product_id', '=', 'pd.id')
                    ->where(DB::raw("p.date"), ">=", $start_date)
                    ->where(DB::raw("p.date"), "<=", $end_date)
                    ->orderBy(DB::raw("p.date"),'DESC')
                    ->where(DB::raw("pdt.product_id"), "=", $product_id)
                    ->groupBy(DB::raw("pdt.product_id"))
                    ->get();
            }
            else
            {
                $data = DB::table('purchase_returns as p')
                    ->select(DB::raw('p.date, pd.name, sum(pdt.qty) as qty, pdt.price, sum(pdt.row_total) as amount'))
                    ->leftJoin('purchase_return_details as pdt', 'p.id', '=', 'pdt.return_id')
                    ->leftJoin('products as pd', 'pdt.product_id', '=', 'pd.id')
                    ->where(DB::raw("p.date"), ">=", $start_date)
                    ->where(DB::raw("p.date"), "<=", $end_date)
                    ->groupBy(DB::raw("pdt.product_id"))
                    ->get();
            }

        }

        $returnHTML = view('StoreInventory::reports.product-wise-purchase-return-report-view', compact('data', 'start_date', 'end_date', 'product_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

}

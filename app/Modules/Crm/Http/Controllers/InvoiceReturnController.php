<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\InvoiceReturnDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Config\Models\Lookup;
use App\Modules\Crm\Models\Invoice;
use App\Modules\Crm\Models\InvoiceReturn;
use App\Modules\Crm\Models\InvoiceReturnDetails;
use App\Modules\StoreInventory\Models\Inventory;
use App\Modules\StoreInventory\Models\Stores;
use Carbon\Carbon;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceReturnController extends BaseController
{
    public $model;
    public $store;

    public function __construct(InvoiceReturn $model)
    {
        $this->model = $model;
        $this->store = new Stores();
    }

    public function index(InvoiceReturnDataTable $dataTable)
    {
        $this->setPageTitle('Invoice Return', 'List of all Invoice Return');
        return $dataTable->render('Crm::invoice-return.index');
    }


    public function create()
    {
        $stores = $this->store->treeList();
        $this->setPageTitle('Create Invoice Return', 'Create Invoice Return');
        return view('Crm::invoice-return.create', compact('stores'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'date' => 'required|date',
            'store_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'product' => 'required|array',
            'grand_total' => 'required|min:1',
        ]);
        $params = $request->except('_token');
        try {
            $store = Stores::findOrFail($store_id = $params['store_id']);
            DB::beginTransaction();
            $return = new InvoiceReturn();
            $maxSlNo = $return->maxSlNo($store_id);
            $year = Carbon::now()->year;
            $invNo = "INV-RTN-$store->code-$year-" . str_pad($maxSlNo, 6, '0', STR_PAD_LEFT);
            $return->max_sl_no = $maxSlNo;
            $return->return_no = $invNo;
            $return->invoice_id = $params['invoice_no'];
            $return->store_id = $store_id;
            $return->customer_id = $params['customer_id'];
            $return->return_amount = $grand_total = $params['grand_total'];
            $return->date = $date = $params['date'];
            $return->created_by = $created_by = auth()->user()->id;
            if ($return->save()) {
                $return_id = $return->id;
                $i = 0;
                foreach ($params['product']['temp_product_id'] as $product_id) {
                    $return_price = $params['product']['temp_return_price'][$i];
                    $return_qty = $params['product']['temp_return_qty'][$i];
                    $row_return_price = $params['product']['temp_row_return_price'][$i];
                    $inventory = new Inventory();
                    $inventory->store_id = $store_id;
                    $inventory->product_id = $product_id;
                    $inventory->stock_in = $return_qty;
                    $inventory->stock_out = 0;
                    $inventory->ref_type = Inventory::REF_INVOICE_RETURN;
                    $inventory->ref_id = $return_id;
                    $inventory->date = $date;
                    $inventory->created_by = $created_by;
                    if ($inventory->save()) {
                        $returnDetails = new InvoiceReturnDetails();
                        $returnDetails->return_id = $return_id;
                        $returnDetails->product_id = $product_id;
                        $returnDetails->qty = $return_qty;
                        $returnDetails->price = $return_price;
                        $returnDetails->row_total = $row_return_price;
                        $returnDetails->save();
                    }
                    $i++;
                }


                if ($grand_total >= $params['invoice_due']) {
                    $invoice = Invoice::findOrFail($return->invoice_id);
                    if ($invoice) {
                        $invoice->full_paid = Invoice::PAID;
                        $invoice->save();
                    }
                }
                DB::commit();

                $data = new InvoiceReturn();
                $data = $data->where('id', '=', $return_id);
                $data = $data->first();

                $returnHTML = view('Crm::invoice-return.voucher', compact('data'))->render();
                return $this->responseJson(false, 200, "Invoice Return Created Successfully.", $returnHTML);

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
            $data = new InvoiceReturn();
            $data = $data->where('id', '=', $request->id);
            $data = $data->first();
            if ($data) {
                $returnHTML = view('Crm::invoice-return.voucher', compact('data'))->render();
                return $this->responseJson(false, 200, "", $returnHTML);
            } else {
                return $this->responseJson(true, 200, "Voucher not found!");
            }
        } else {
            return $this->responseJson(true, 200, "Please insert Return no!");
        }
    }

    public function invoiceReturnReport()
    {
        $stores = $this->store->treeList();
        $cash_credit = Lookup::items('cash_credit');
        $this->setPageTitle('Return Report', 'Return Report');
        return view('Crm::invoice-return.invoice-return-report', compact('stores', 'cash_credit'));
    }

    public function invoiceReturnReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $store_id = trim($request->store_id);
            $customer_id = trim($request->customer_id);
            $data = new Invoicereturn();
//            $data = $data->whereBetween('date', ["'$start_date'", "'$end_date'"]);
            $data = $data->where('date', '>=', $start_date);
            $data = $data->where('date', '<=', $end_date);
            if ($customer_id > 0) {
                $data = $data->where('customer_id', '=', $customer_id);
            }
            if ($store_id > 0) {
                $data = $data->where('store_id', '=', $store_id);
            }
            $data = $data->orderby('date', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('Crm::invoice-return.invoice-return-report-view', compact('data', 'start_date', 'end_date', 'store_id', 'customer_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function customerReturnReport()
    {
        $stores = $this->store->treeList();
        $cash_credit = Lookup::items('cash_credit');
        $this->setPageTitle('Customer Sales Report', 'Customer Return Report');
        return view('Crm::invoice-return.customer-return-report', compact('stores', 'cash_credit'));
    }

    public function customerReturnReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $store_id = trim($request->store_id);
            $customer_id = trim($request->customer_id);
            $data = new InvoiceReturn();
//            $data = $data->whereBetween('date', ["'$start_date'", "'$end_date'"]);
            $data = $data->where('date', '>=', $start_date);
            $data = $data->where('date', '<=', $end_date);
            if ($customer_id > 0) {
                $data = $data->where('customer_id', '=', $customer_id);
            }
            if ($store_id > 0) {
                $data = $data->where('store_id', '=', $store_id);
            }
            $data = $data->select('invoice_returns.*', DB::raw('count(*) as return_count, sum(return_amount) as customer_total'));
            $data = $data->groupBy('customer_id');
            $data = $data->orderby('date', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('Crm::invoice-return.customer-return-report-view', compact('data', 'start_date', 'end_date', 'store_id', 'customer_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}

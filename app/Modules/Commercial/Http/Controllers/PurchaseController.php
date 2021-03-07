<?php

namespace App\Modules\Commercial\Http\Controllers;


use App\DataTables\InvoiceDataTable;
use App\DataTables\PurchaseDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Accounting\Models\MoneyReceipt;
use App\Modules\Accounting\Models\SuppliersPayment;
use App\Modules\Commercial\Models\Purchase;
use App\Modules\Commercial\Models\PurchaseDetails;
use App\Modules\Commercial\Models\Suppliers;
use App\Modules\Config\Models\Lookup;
use App\Modules\StoreInventory\Models\Inventory;
use App\Modules\StoreInventory\Models\Product;
use App\Modules\StoreInventory\Models\Stores;
use App\Traits\UploadAble;
use Carbon\Carbon;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends BaseController
{
    use UploadAble;

    public $model;
    public $supplier;
    public $products;
    public $lookup;

    public function __construct(Purchase $model)
    {
        $this->model = $model;
        $this->supplier = new Suppliers();
        $this->products = new Product();
        $this->lookup = new Lookup();
    }

    /**
     * @param PurchaseDataTable $dataTable
     * @return Factory|View
     */
    public function index(PurchaseDataTable $dataTable)
    {
        $this->setPageTitle('Purchase', 'List of all purchases');
        return $dataTable->render('Commercial::purchases.index');
    }

    public function create()
    {
        $payment_type = Lookup::items('payment_method');
        $cash_credit = Lookup::items('cash_credit');
        $bank = Lookup::items('bank');
        $this->setPageTitle('Create Purchase', 'Create Purchase');
        return view('Commercial::purchases.create', compact('payment_type', 'cash_credit', 'bank'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'date' => 'required|date',
            'supplier_id' => 'required|integer',
            'cash_credit' => 'required|integer',
            'product' => 'required|array',
        ]);
        $params = $request->except('_token');

        try {
            $invoice = new Purchase();
            $maxSlNo = $invoice->maxSlNo();
            $year = Carbon::now()->year;
            $store_id = 1;
            $supplier_id = $params['supplier_id'];
            $invNo = "PO-$supplier_id-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

            $invoice->payment_type = $cash_credit = $params['cash_credit'];
            $invoice->max_sl_no = $maxSlNo;
            $invoice->invoice_no = $invNo;
            $invoice->supplier_id = $params['supplier_id'];
            $invoice->others_charge = 0;
            $invoice->is_receive = 1;
            $invoice->grand_total = $grand_total = $params['grand_total'];
            $invoice->date = $date = $params['date'];
            $invoice->created_by = $created_by = auth()->user()->id;
            if ($invoice->save()) {
                $invoice_id = $invoice->id;
                $i = 0;
                foreach ($params['product']['temp_product_id'] as $product_id) {
                    $stock_qty = $params['product']['temp_stock_qty'][$i];
                    $purchase_price = $params['product']['temp_purchase_price'][$i];
                    $purchase_qty = $params['product']['temp_purchase_qty'][$i];
                    $row_purchase_price = $params['product']['temp_row_purchase_price'][$i];
                    $stock = Inventory::closingStock($product_id);

                    $inventory = new Inventory();
                    $inventory->store_id = $store_id;
                    $inventory->product_id = $product_id;
                    $inventory->stock_in = $purchase_qty;
                    $inventory->stock_out = 0;
                    $inventory->ref_type = Inventory::REF_PURCHASE;
                    $inventory->ref_id = $invoice_id;
                    $inventory->date = $date;
                    $inventory->created_by = $created_by;
                    if ($inventory->save()) {
                        $invoiceDetails = new PurchaseDetails();
                        $invoiceDetails->purchase_id = $invoice_id;
                        $invoiceDetails->product_id = $product_id;
                        $invoiceDetails->qty = $purchase_qty;
                        $invoiceDetails->purchase_price = $purchase_price;
                        $invoiceDetails->others_charges = 0;
                        $invoiceDetails->row_total = $row_purchase_price;
                        if ($invoiceDetails->save())
                        {
                            $price = Product::productAvaragePrice($product_id);
                            $stockValue = $stock*$price;
                            $totalStock = $stock + $purchase_qty;
                            $avgPrice = ($stockValue+$row_purchase_price)/$totalStock;
                            $product = Product::find($product_id);
                            $product->avg_price = $avgPrice;
                            $product->save();
                        }
                    }
                    $i++;
                }
                if ($cash_credit == Lookup::CASH) {
                    $payment_type = $params['payment_method'];
                    $bank_id = $params['bank_id'];
                    $cheque_no = $params['cheque_no'];
                    $cheque_date = $params['cheque_date'];
                    $manual_mr_no = $params['manual_mr_no'];
                    $mr = new SuppliersPayment();
                    $max_mr_no = $mr->maxSlNo($supplier_id);
                    $mr_no = "PR-$supplier_id-$year-" . str_pad($maxSlNo, 3, '0', STR_PAD_LEFT);

                    $mr->supplier_id = $supplier_id;
                    $mr->max_sl_no = $max_mr_no;
                    $mr->pr_no = $mr_no;
                    $mr->manual_pr_no = $manual_mr_no;
                    $mr->payment_type = $payment_type;
                    $mr->amount = $grand_total;
                    $mr->date = $date;
                    $mr->payment_by = $created_by;
                    $mr->created_by = $created_by;
                    $mr->po_no = $invoice_id;
                    if ($payment_type !== Lookup::PAYMENT_CASH) {
                        $mr->bank_id = $bank_id;
                        $mr->cheque_no = $cheque_no;
                        $mr->cheque_date = $cheque_date;
                    }
                    if ($mr->save()) {
                        $invoice->full_paid = Purchase::PAID;
                        $invoice->save();
                    }
                }
                return $this->responseRedirectToWithParameters('commercial.purchase.voucher', ['id' => $invoice->id], 'Purchased created successfully', 'success', false, false);
            } else {
                return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
            }

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
            //return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
        }
    }

    public function voucher($id)
    {
        $invoice = Purchase::findOrFail($id);
        $invoice_no = $invoice->invoice_no;
        $this->setPageTitle('PO No-' . $invoice_no, 'Purchase Preview : ' . $invoice_no);

        return view('Commercial::purchases.voucher', compact('invoice', 'id'));
    }

    public function getDuePurchaseList(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('supplier_id')) {
            $supplier_id = trim($request->supplier_id);
            $data = new Purchase();
            $data = $data->where('supplier_id', '=', $supplier_id);
            $data = $data->where('full_paid', '=', Purchase::NOT_PAID);
            $data = $data->orderby('id', 'asc');
            $data = $data->get();
        }

        $payment_type = Lookup::items('payment_method');
        $cash_credit = Lookup::items('cash_credit');
        $bank = Lookup::items('bank');
        $returnHTML = view('Accounting::supplierPayment.due-purchase-list', compact('data', 'cash_credit', 'bank', 'payment_type'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function getDuePurchaseListWithDue(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('supplier_id')) {
            $supplier_id = trim($request->supplier_id);
            $data = new Purchase();
            $data = $data->where('supplier_id', '=', $supplier_id);
            $data = $data->where('full_paid', '=', Purchase::NOT_PAID);
            $data = $data->orderby('id', 'asc');
            $data = $data->get();
        }

        if (count($data) >0) {
            foreach ($data as $dt) {
                $mrAmount = \App\Modules\Accounting\Models\SuppliersPayment::totalMrAmountOfInvoice($dt->id);
                $returnAmount = \App\Modules\StoreInventory\Models\PurchaseReturn::totalReturnAmountOfPurchase($dt->id);
                $totalMrWithReturn = $mrAmount + $returnAmount;
                $due_amount = $dt->grand_total - $totalMrWithReturn;
                if ($due_amount > 0) {
                    $response[] = array("id" => $dt->id, "label" => $dt->invoice_no, "name" => $dt->invoice_no, 'due' => $due_amount);
                }

            }
        } else {
            $response[] = array("id" => '', "label" => 'No data found!', "name" => '', 'due' => '');
        }

        return response()->json($response);
    }

}

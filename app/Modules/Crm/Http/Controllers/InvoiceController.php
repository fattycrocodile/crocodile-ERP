<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\InvoiceDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Accounting\Models\MoneyReceipt;
use App\Modules\Config\Models\Lookup;
use App\Modules\Crm\Models\Invoice;
use App\Modules\Crm\Models\InvoiceDetails;
use App\Modules\Crm\Models\InvoiceReturn;
use App\Modules\Crm\Models\SellOrder;
use App\Modules\StoreInventory\Models\Inventory;
use App\Modules\StoreInventory\Models\Stores;
use App\Traits\UploadAble;
use Carbon\Carbon;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InvoiceController extends BaseController
{
    use UploadAble;

    public $model;
    public $store;
    public $lookup;

    public function __construct(Invoice $model)
    {
        $this->middleware('permission:invoice.index|invoice.create|invoice.edit|invoice.delete|invoice.report|invoice.customer_sales_report', ['only' => ['index','show']]);
        $this->middleware('permission:invoice.create', ['only' => ['create','store']]);
        $this->middleware('permission:invoice.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:invoice.delete', ['only' => ['delete']]);
        $this->middleware('permission:invoice.report', ['only' => ['invoiceReport','invoiceReportView']]);
        $this->middleware('permission:invoice.customer_sales_report', ['only' => ['customerSalesReport','customerSalesReportView']]);

        $this->model = $model;
        $this->store = new Stores();
        $this->lookup = new Lookup();
    }

    /**
     * @param InvoiceDataTable $dataTable
     * @return Factory|View
     */
    public function index(InvoiceDataTable $dataTable)
    {
        $this->setPageTitle('Invoice', 'List of all invoices');
        return $dataTable->render('Crm::invoice.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $stores = $this->store->treeList();
        $payment_type = Lookup::items('payment_method');
        $cash_credit = Lookup::items('cash_credit');
        $bank = Lookup::items('bank');
        $this->setPageTitle('Create Invoice', 'Create Invoice');
        return view('Crm::invoice.create', compact('stores', 'payment_type', 'cash_credit', 'bank'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'date' => 'required|date',
            'store_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'cash_credit' => 'required|integer',
            'product' => 'required|array',
//            'grand_total' => 'required|min:1',
        ]);
        $params = $request->except('_token');

        try {
            DB::beginTransaction();
            $invoice = new Invoice();
            $maxSlNo = $invoice->maxSlNo($store_id = $params['store_id']);
            $year = Carbon::now()->year;
            $store = Stores::findOrFail($store_id);
            $invNo = "INV-$store->code-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

            $invoice->cash_credit = $cash_credit = $params['cash_credit'];
            $invoice->max_sl_no = $maxSlNo;
            $invoice->invoice_no = $invNo;
            $invoice->order_id = isset($params['order_id']) ? $params['order_id'] : NULL;
            $invoice->store_id = $params['store_id'];
            $invoice->customer_id = $customer_id =  $params['customer_id'];
            $invoice->discount_amount = 0;
            $invoice->grand_total = $grand_total = $params['grand_total'];
            $invoice->date = $date = $params['date'];
            $invoice->created_by = $created_by = auth()->user()->id;
            if ($invoice->save()) {
                $invoice_id = $invoice->id;
                $i = 0;
                $isAnyItemIsMissing = false;
                foreach ($params['product']['temp_product_id'] as $product_id) {
                    $stock_qty = $params['product']['temp_stock_qty'][$i];
                    $sell_price = $params['product']['temp_sell_price'][$i];
                    $sell_qty = $params['product']['temp_sell_qty'][$i];
                    $row_sell_price = $params['product']['temp_row_sell_price'][$i];
                    $stock_qty = \App\Modules\StoreInventory\Models\Inventory::closingStockWithStore($product_id, $invoice->store_id);
                    if ($stock_qty > 0) {
                        $inventory = new Inventory();
                        $inventory->store_id = $store_id;
                        $inventory->product_id = $product_id;
                        $inventory->stock_in = 0;
                        $inventory->stock_out = $sell_qty;
                        $inventory->ref_type = Inventory::REF_INVOICE;
                        $inventory->ref_id = $invoice_id;
                        $inventory->date = $date;
                        $inventory->created_by = $created_by;
                        if ($inventory->save()) {
                            $invoiceDetails = new InvoiceDetails();
                            $invoiceDetails->invoice_id = $invoice_id;
                            $invoiceDetails->product_id = $product_id;
                            $invoiceDetails->qty = $sell_qty;
                            $invoiceDetails->sell_price = $sell_price;
                            $invoiceDetails->discount = 0;
                            $invoiceDetails->row_total = $row_sell_price;
                            $invoiceDetails->save();
                        }
                    } else {
                        $isAnyItemIsMissing = true;
                    }
                    $i++;
                }
                if ($cash_credit == Lookup::CASH) {
                    $payment_type = $params['payment_method'];
                    $bank_id = $params['bank_id'];
                    $cheque_no = $params['cheque_no'];
                    $cheque_date = $params['cheque_date'];
                    $manual_mr_no = $params['manual_mr_no'];
                    $mr = new MoneyReceipt();
                    $max_mr_no = $mr->maxSlNo($store_id);
                    $mr_no = "MR-$store->code-$year-" . str_pad($maxSlNo, 3, '0', STR_PAD_LEFT);

                    $mr->max_sl_no = $max_mr_no;
                    $mr->mr_no = $mr_no;
                    $mr->manual_mr_no = $manual_mr_no;
                    $mr->store_id = $store_id;
                    $mr->collection_type = $payment_type;
                    $mr->amount = $grand_total;
                    $mr->date = $date;
                    $mr->received_by = $created_by;
                    $mr->created_by = $created_by;
                    $mr->customer_id = $customer_id;
                    $mr->invoice_id = $invoice_id;
                    if ($payment_type !== Lookup::PAYMENT_CASH) {
                        $mr->bank_id = $bank_id;
                        $mr->cheque_no = $cheque_no;
                        $mr->cheque_date = $cheque_date;
                    }
                    if ($mr->save()) {
                        $invoice->full_paid = Invoice::PAID;
                        $invoice->save();
                    }
                }
                if ($invoice->order_id > 0) {
                    SellOrder::query()->where('id', '=', $invoice->order_id)->first()->update(['is_invoice' => SellOrder::INV_CREATED]);
                }
                DB::commit();
                if ($isAnyItemIsMissing == false) {
                    return $this->responseRedirectToWithParameters('crm.invoice.voucher', ['id' => $invoice->id], 'Invoice created successfully', 'success', false, false);
                } else {
                    DB::rollback();
                    return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
                }
            } else {
                return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
            }

        } catch (QueryException $exception) {
            DB::rollback();
            throw new InvalidArgumentException($exception->getMessage());
            //return $this->responseRedirectBack('Error occurred while creating invoice.', 'error', true, true);
        }
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        try {
            $brands = Invoice::findOrFail($id);
            $this->setPageTitle('Brands', 'Edit Brands : ' . $brands->name);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
        return view('StoreInventory::brands.edit', compact('brands'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);
        $params = $request->except('_token');
        try {
            $brand = Invoice::findOrFail($params['id']);
            $collection = collect($params)->except('_token');
            $logo = $brand->logo;
            if ($collection->has('logo') && ($params['logo'] instanceof UploadedFile)) {
                if ($brand->logo != null) {
                    $this->deleteOne($brand->logo);
                }
                $logo = $this->uploadOne($params['logo'], 'brands');
            }
            $merge = $collection->merge(compact('logo'));
            $brand->update($merge->all());

            if (!$brand) {
                return $this->responseRedirectBack('Error occurred while updating invoice.', 'error', true, true);
            }
            return $this->responseRedirect('crm.invoice.index', 'invoice updated successfully', 'success', false, false);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Invoice::find($id);
        $logo = $data->logo;
        if ($data->delete()) {
            if ($logo != null) {
                $this->deleteOne($logo);
            }
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Record has been deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'status_code' => 200,
                'message' => 'Please try again!',
            ]);
        }
    }

    public function voucher($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice_no = $invoice->invoice_no;
        $this->setPageTitle('Invoice No-' . $invoice_no, 'Invoice Preview : ' . $invoice_no);

        return view('Crm::invoice.voucher', compact('invoice', 'id'));
    }


    public function getDueInvoiceList(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('customer_id')) {
            $customer_id = trim($request->customer_id);
            $data = new Invoice();
            $data = $data->where('customer_id', '=', $customer_id);
            $data = $data->where('full_paid', '=', Invoice::NOT_PAID);
            $data = $data->orderby('id', 'asc');
            $data = $data->get();
        }

        $payment_type = Lookup::items('payment_method');
        $cash_credit = Lookup::items('cash_credit');
        $bank = Lookup::items('bank');
        $returnHTML = view('Crm::invoice.due-invoice-list', compact('data', 'cash_credit', 'bank', 'payment_type'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function getDueInvoiceJsonList(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('customer_id')) {
            $customer_id = trim($request->customer_id);
            $data = new Invoice();
            $data = $data->where('customer_id', '=', $customer_id);
            $data = $data->where('full_paid', '=', Invoice::NOT_PAID);
            $data = $data->orderby('id', 'asc');
            $data = $data->get();
        }

        if (!$data->isEmpty()) {
            foreach ($data as $dt) {
                $mrAmount = \App\Modules\Accounting\Models\MoneyReceipt::totalMrAmountOfInvoice($dt->id);
                $returnAmount = InvoiceReturn::totalReturnAmountOfInvoice($dt->id);
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

    public function invoiceReport()
    {
        $stores = $this->store->treeList();
        $cash_credit = Lookup::items('cash_credit');
        $this->setPageTitle('Sales Report', 'Sales Report');
        return view('Crm::invoice.invoice-report', compact('stores', 'cash_credit'));
    }

    public function invoiceReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $store_id = trim($request->store_id);
            $customer_id = trim($request->customer_id);
            $data = new Invoice();
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

        $returnHTML = view('Crm::invoice.invoice-report-view', compact('data', 'start_date', 'end_date', 'store_id', 'customer_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function customerSalesReport()
    {
        $stores = $this->store->treeList();
        $cash_credit = Lookup::items('cash_credit');
        $this->setPageTitle('Customer Sales Report', 'Customer Sales Report');
        return view('Crm::invoice.customer-sales-report', compact('stores', 'cash_credit'));
    }

    public function customerSalesReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $store_id = trim($request->store_id);
            $customer_id = trim($request->customer_id);
            $data = new Invoice();
//            $data = $data->whereBetween('date', ["'$start_date'", "'$end_date'"]);
            $data = $data->where('date', '>=', $start_date);
            $data = $data->where('date', '<=', $end_date);
            if ($customer_id > 0) {
                $data = $data->where('customer_id', '=', $customer_id);
            }
            if ($store_id > 0) {
                $data = $data->where('store_id', '=', $store_id);
            }
            $data = $data->select('invoices.*', DB::raw('count(*) as invoice_count, sum(grand_total) as customer_total'));
            $data = $data->groupBy('customer_id');
            $data = $data->orderby('date', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('Crm::invoice.customer-sales-report-view', compact('data', 'start_date', 'end_date', 'store_id', 'customer_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}

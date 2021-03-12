<?php

namespace App\Modules\Accounting\Http\Controllers;


use App\DataTables\SupplierPaymentDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Accounting\Models\SuppliersPayment;
use App\Modules\Commercial\Models\Purchase;
use App\Modules\Commercial\Models\Suppliers;
use App\Modules\Config\Models\Lookup;
use App\Modules\StoreInventory\Models\Stores;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class SuppliersPaymentController extends BaseController
{
    public $model;
    public $store;

    public function __construct(SuppliersPayment $model)
    {
        $this->model = $model;
        $this->store = new Stores();
    }

    public function index(SupplierPaymentDataTable $dataTable)
    {
        $this->setPageTitle('Supplier Payment', 'List of all Payment');
        return $dataTable->render('Accounting::supplierPayment.index');
    }

    public function create()
    {
        $stores = $this->store->treeList();
        $this->setPageTitle('Create Payment Receipt', 'Create payment Receipt');
        return view('Accounting::supplierPayment.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'supplier_id' => 'required|integer',
            'payment_method' => 'required|integer',
            'grand_total' => 'required|min:1',
        ]);
        $params = $request->except('_token');
        if ($validator->passes()) {
            try {
                $year = date('y');
                $date = $params['date'];
                $store_id = 1;
                $supplier_id = $params['supplier_id'];
                $payment_method = $params['payment_method'];
                $bank_id = $params['bank_id'];
                $cheque_no = $params['cheque_no'];
                $cheque_date = $params['cheque_date'];
                $manual_mr_no = $params['manual_mr_no'];
                $i = 0;
                $mr = new SuppliersPayment();
                $maxSlNo = $mr->maxSlNo($supplier_id);
                $invNo = "PR-$store_id-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);
                foreach ($params['mr']['invoice_id'] as $invoice) {
                    $invoice_total = $params['mr']['invoice_total'][$i];
                    $invoice_due = $params['mr']['invoice_due'][$i];
                    $row_due = $params['mr']['row_due'][$i];
                    $payment_amount = $params['mr']['payment_amount'][$i];
                    $discount_amount = $params['mr']['discount_amount'][$i];
                    if ($payment_amount > 0 || $discount_amount > 0) {

                        $model = new SuppliersPayment();
                        $model->max_sl_no = $maxSlNo;
                        $model->pr_no = $invNo;
                        $model->manual_pr_no = $manual_mr_no;
                        $model->po_no = $invoice;
                        $model->payment_type = $payment_method;
                        $model->amount = $payment_amount > 0 ? $payment_amount : 0;
                        $model->discount = $discount_amount > 0 ? $discount_amount : 0;
                        $model->date = $date;
                        $model->bank_id = $bank_id;
                        $model->cheque_no = $cheque_no;
                        $model->cheque_date = $cheque_date;
                        $model->payment_by = $created_by = auth()->user()->id;
                        $model->created_by = $created_by;
                        $model->supplier_id = $supplier_id;
                        $model->save();
                        $id = $model->id;
                        if ($row_due <= 0) {
                            $invoice = Purchase::findOrFail($invoice);
                            if ($invoice) {
                                $invoice->full_paid = Purchase::PAID;
                                $invoice->save();
                            }
                        }
                    }
                    $i++;
                }
                $data = new SuppliersPayment();
                $data = $data->where('id', '=', $id);
                $data = $data->get();
                if ($data) {
                    $returnHTML = view('Accounting::supplierPayment.voucher', compact('data'))->render();
                    return $this->responseJson(false, 200, "Payment Created Successfully.", $returnHTML);
                } else {
                    return $this->responseJson(true, 200, "Voucher not found!");
                }
            } catch (QueryException $exception) {
                throw new InvalidArgumentException($exception->getMessage());

            }
        }
        return $this->responseJson(true, 200, "Something is wrong", $validator->errors()->all());
    }

    public function voucher(Request $request)
    {
        if ($request->has('pr_no')) {
            $data = new SuppliersPayment();
            $data = $data->where('pr_no', '=', $request->pr_no);
            $data = $data->get();
            if ($data) {
                $returnHTML = view('Accounting::supplierPayment.voucher', compact('data'))->render();
                return $this->responseJson(false, 200, "", $returnHTML);
            } else {
                return $this->responseJson(true, 200, "Voucher not found!");
            }
        } else {
            return $this->responseJson(true, 200, "Please insert 55 no!");
        }
    }

    public function paymentReport()
    {
        $stores = $this->store->treeList();
        $cash_credit = Lookup::items('cash_credit');
        $banks = Lookup::items('bank');
        $collection_types = Lookup::items('payment_method');
        $this->setPageTitle('Payment Report', 'Payment Report');
        return view('Accounting::reports.payment-report', compact('stores', 'cash_credit', 'banks', 'collection_types'));
    }

    public function paymentReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $supplier_id = trim($request->supplier_id);
            $payment_type = trim($request->payment_type);
            $bank_id = trim($request->bank_id);
            $data = new SuppliersPayment();
            $data = $data->where('date', '>=', $start_date);
            $data = $data->where('date', '<=', $end_date);
            if ($supplier_id > 0) {
                $data = $data->where('supplier_id', '=', $supplier_id);
            }
            if ($payment_type > 0) {
                $data = $data->where('payment_type', '=', $payment_type);
            }
            if ($bank_id > 0) {
                $data = $data->where('bank_id', '=', $bank_id);
            }
            $data = $data->orderby('date', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('Accounting::reports.payment-report-view', compact('data', 'start_date', 'end_date', 'supplier_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function supplierDueReport()
    {
        $this->setPageTitle('Supplier Due Report', 'Supplier Due Report');
        return view('Accounting::reports.supplier-due-report');
    }

    public function supplierDueReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('date')) {
            $date = trim($request->date);
            $supplier_id = trim($request->supplier_id);
            $data = new Suppliers();
            if ($supplier_id > 0) {
                $data = $data->where('id', '=', $supplier_id);
            }
            $data = $data->orderby('name', 'asc');
            $data = $data->get();

        }

        $returnHTML = view('Accounting::reports.supplier-due-report-view', compact('data', 'date', 'supplier_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

}

<?php

namespace App\Modules\Accounting\Http\Controllers;


use App\DataTables\MoneyReceiptDataTable;
use App\Http\Controllers\BaseController;
use App\Model\User\User;
use App\Modules\Accounting\Models\MoneyReceipt;
use App\Modules\Config\Models\Lookup;
use App\Modules\Crm\Models\Invoice;
use App\Modules\StoreInventory\Models\Stores;
use App\Traits\UploadAble;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;
use Validator;


class MoneyReceiptController extends BaseController
{
    use UploadAble;

    public $model;
    public $store;

    public function __construct(MoneyReceipt $model)
    {
        $this->middleware('permission:money_receipt.index|money_receipt.create|money_receipt.edit|money_receipt.delete|money_receipt.collection_report', ['only' => ['index','show']]);
        $this->middleware('permission:money_receipt.create', ['only' => ['create','store']]);
        $this->middleware('permission:money_receipt.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:money_receipt.delete', ['only' => ['delete']]);
        $this->middleware('permission:money_receipt.collection_report', ['only' => ['collectionReport','collectionReportView']]);

        $this->model = $model;
        $this->store = new Stores();
    }

    /**
     * @param MoneyReceiptDataTable $dataTable
     * @return Factory|View
     */
    public function index(MoneyReceiptDataTable $dataTable)
    {
        $this->setPageTitle('MoneyReceipt', 'List of all mr');
        return $dataTable->render('Accounting::moneyReceipt.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            $stores =  Stores::where('id', '=', $store_id)->get();
        }else {
            $stores = Stores::all();
        }
        $this->setPageTitle('Create MR', 'Create Money Receipt');
        return view('Accounting::moneyReceipt.create', compact('stores'));
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws Throwable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'store_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'payment_method' => 'required|integer',
            'grand_total' => 'required|min:1',
        ]);
        $params = $request->except('_token');
        if ($validator->passes()) {
            try {
                $year = date('y');
                $date = $params['date'];
                $store_id = $params['store_id'];
                $customer_id = $params['customer_id'];
                $payment_method = $params['payment_method'];
                $bank_id = $params['bank_id'];
                $cheque_no = $params['cheque_no'];
                $cheque_date = $params['cheque_date'];
                $manual_mr_no = $params['manual_mr_no'];
                $i = 0;
                $mr = new MoneyReceipt();
                $store = Stores::findOrFail($store_id);
                $maxSlNo = $mr->maxSlNo($store_id);
                $invNo = "MR-$store->code-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);
                foreach ($params['mr']['invoice_id'] as $invoice) {
                    $invoice_total = $params['mr']['invoice_total'][$i];
                    $invoice_due = $params['mr']['invoice_due'][$i];
                    $row_due = $params['mr']['row_due'][$i];
                    $payment_amount = $params['mr']['payment_amount'][$i];
                    $discount_amount = $params['mr']['discount_amount'][$i];
                    if ($payment_amount > 0 || $discount_amount > 0) {

                        $model = new MoneyReceipt();
                        $model->max_sl_no = $maxSlNo;
                        $model->mr_no = $invNo;
                        $model->manual_mr_no = $manual_mr_no;
                        $model->store_id = $store_id;
                        $model->invoice_id = $invoice;
                        $model->collection_type = $payment_method;
                        $model->amount = $payment_amount > 0 ? $payment_amount : 0;
                        $model->discount = $discount_amount > 0 ? $discount_amount : 0;
                        $model->date = $date;
                        $model->bank_id = $bank_id;
                        $model->cheque_no = $cheque_no;
                        $model->cheque_date = $cheque_date;
                        $model->received_by = $created_by = auth()->user()->id;
                        $model->created_by = $created_by;
                        $model->customer_id = $customer_id;
                        $model->save();
                        if ($row_due <= 0) {
                            $invoice = Invoice::findOrFail($invoice);
                            if ($invoice) {
                                $invoice->full_paid = Invoice::PAID;
                                $invoice->save();
                            }
                        }
                    }
                    $i++;
                }
                $data = new MoneyReceipt();
                $data = $data->where('mr_no', '=', $invNo);
                $data = $data->get();
                if ($data) {
                    $returnHTML = view('Accounting::MoneyReceipt.voucher', compact('data'))->render();
                    return $this->responseJson(false, 200, "MR Created Successfully.", $returnHTML);
                } else {
                    return $this->responseJson(true, 200, "Voucher not found!");
                }
            } catch (QueryException $exception) {
                throw new InvalidArgumentException($exception->getMessage());

            }
        }
        return $this->responseJson(true, 200, "Something is wrong", $validator->errors()->all());
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        try {
            $brands = MoneyReceipt::findOrFail($id);
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
            $brand = MoneyReceipt::findOrFail($params['id']);
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
                return $this->responseRedirectBack('Error occurred while updating MoneyReceipt.', 'error', true, true);
            }
            return $this->responseRedirect('crm.MoneyReceipt.index', 'MoneyReceipt updated successfully', 'success', false, false);
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
        $data = MoneyReceipt::find($id);
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

    public function voucher(Request $request)
    {
        if ($request->has('mr_no')) {
            $data = new MoneyReceipt();
            $data = $data->where('mr_no', '=', $request->mr_no);
            $data = $data->get();
            if ($data) {
                $returnHTML = view('Accounting::moneyReceipt.voucher', compact('data'))->render();
                return $this->responseJson(false, 200, "", $returnHTML);
            } else {
                return $this->responseJson(true, 200, "Voucher not found!");
            }
        } else {
            return $this->responseJson(true, 200, "Please insert mr no!");
        }
    }

    public function collectionReport()
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            $stores =  Stores::where('id', '=', $store_id)->get();
        }else {
            $stores = Stores::all();
        }
        $cash_credit = Lookup::items('cash_credit');
        $banks = Lookup::items('bank');
        $collection_types = Lookup::items('payment_method');
        $this->setPageTitle('Collection Report', 'Collection Report');
        return view('Accounting::moneyReceipt.collection-report', compact('stores', 'cash_credit', 'banks', 'collection_types'));
    }

    public function collectionReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $store_id = trim($request->store_id);
            $customer_id = trim($request->customer_id);
            $collection_type = trim($request->collection_type);
            $bank_id = trim($request->bank_id);
            $data = new MoneyReceipt();
//            $data = $data->whereBetween('date', ["'$start_date'", "'$end_date'"]);
            $data = $data->where('date', '>=', $start_date);
            $data = $data->where('date', '<=', $end_date);
            if ($customer_id > 0) {
                $data = $data->where('customer_id', '=', $customer_id);
            }
            if ($store_id > 0) {
                $data = $data->where('store_id', '=', $store_id);
            }
            $user_store_id = User::getStoreId(auth()->user()->id);
            if ($user_store_id > 0){
                $data = $data->where('store_id', '=', $user_store_id);
            }
            if ($collection_type > 0) {
                $data = $data->where('collection_type', '=', $collection_type);
            }
            if ($bank_id > 0) {
                $data = $data->where('bank_id', '=', $bank_id);
            }
            $data = $data->orderby('date', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('Accounting::moneyReceipt.collection-report-view', compact('data', 'start_date', 'end_date', 'store_id', 'customer_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}

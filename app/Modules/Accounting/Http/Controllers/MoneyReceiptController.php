<?php

namespace App\Modules\Accounting\Http\Controllers;


use App\DataTables\MoneyReceiptDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Accounting\Models\MoneyReceipt;
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
use Validator;


class MoneyReceiptController extends BaseController
{
    use UploadAble;

    public $model;
    public $store;

    public function __construct(MoneyReceipt $model)
    {
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
        $stores = $this->store->treeList();
        $this->setPageTitle('Create MR', 'Create Money Receipt');
        return view('Accounting::moneyReceipt.create', compact('stores'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
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
                    if ($row_due <= 0){
                        $invoice = Invoice::findOrFail($invoice);
                        if ($invoice){
                            $invoice->full_paid = Invoice::PAID;
                            $invoice->save();
                        }
                    }
                    $i++;
                }
                /*$data = MoneyReceipt::query()
                    ->where(['store_id', '=', $store_id], ['max_sl_no', '=', $maxSlNo], ['customer_id', '=', $customer_id])
                    ->get();*/
                $data = 'TEST';
                return $this->responseJson(false, 200, "MR Created Successfully.", $data);
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

    public function voucher($id)
    {
        $MoneyReceipt = MoneyReceipt::findOrFail($id);
        $MoneyReceipt_no = $MoneyReceipt->MoneyReceipt_no;
        $this->setPageTitle('MoneyReceipt No-' . $MoneyReceipt_no, 'MoneyReceipt Preview : ' . $MoneyReceipt_no);

        return view('Crm::MoneyReceipt.voucher', compact('MoneyReceipt', 'id'));
    }
}

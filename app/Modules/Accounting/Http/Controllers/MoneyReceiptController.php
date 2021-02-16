<?php

namespace App\Modules\Accounting\Http\Controllers;


use App\DataTables\MoneyReceiptDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Accounting\Models\MoneyReceipt;
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
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

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
            $MoneyReceipt = new MoneyReceipt();
            $maxSlNo = $MoneyReceipt->maxSlNo($store_id = $params['store_id']);
            $year = Carbon::now()->year;
            $store = Stores::findOrFail($store_id);
            $invNo = "INV-$store->code-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

            $MoneyReceipt->cash_credit = $cash_credit = $params['cash_credit'];
            $MoneyReceipt->max_sl_no = $maxSlNo;
            $MoneyReceipt->MoneyReceipt_no = $invNo;
            $MoneyReceipt->store_id = $params['store_id'];
            $MoneyReceipt->customer_id = $params['customer_id'];
            $MoneyReceipt->discount_amount = 0;
            $MoneyReceipt->grand_total = $grand_total = $params['grand_total'];
            $MoneyReceipt->date = $date = $params['date'];
            $MoneyReceipt->created_by = $created_by = auth()->user()->id;
            if ($MoneyReceipt->save()) {
                $MoneyReceipt_id = $MoneyReceipt->id;
                $i = 0;
                foreach ($params['product']['temp_product_id'] as $product_id) {
                    $stock_qty = $params['product']['temp_stock_qty'][$i];
                    $sell_price = $params['product']['temp_sell_price'][$i];
                    $sell_qty = $params['product']['temp_sell_qty'][$i];
                    $row_sell_price = $params['product']['temp_row_sell_price'][$i];

                    $inventory = new Inventory();
                    $inventory->store_id = $store_id;
                    $inventory->product_id = $product_id;
                    $inventory->stock_in = 0;
                    $inventory->stock_out = $sell_qty;
                    $inventory->ref_type = Inventory::REF_MoneyReceipt;
                    $inventory->ref_id = $MoneyReceipt_id;
                    $inventory->date = $date;
                    $inventory->created_by = $created_by;
                    if ($inventory->save()) {
                        $MoneyReceiptDetails = new MoneyReceiptDetails();
                        $MoneyReceiptDetails->MoneyReceipt_id = $MoneyReceipt_id;
                        $MoneyReceiptDetails->product_id = $product_id;
                        $MoneyReceiptDetails->qty = $sell_qty;
                        $MoneyReceiptDetails->sell_price = $sell_price;
                        $MoneyReceiptDetails->discount = 0;
                        $MoneyReceiptDetails->row_total = $row_sell_price;
                        $MoneyReceiptDetails->save();
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
                    $mr->MoneyReceipt_id = $MoneyReceipt_id;
                    if ($payment_type !== Lookup::PAYMENT_CASH) {
                        $mr->bank_id = $bank_id;
                        $mr->cheque_no = $cheque_no;
                        $mr->cheque_date = $cheque_date;
                    }
                    if ($mr->save()) {
                        $MoneyReceipt->full_paid = MoneyReceipt::PAID;
                        $MoneyReceipt->save();
                    }
                }
                return $this->responseRedirectToWithParameters('crm.MoneyReceipt.voucher', ['id'=>$MoneyReceipt->id], 'MoneyReceipt created successfully', 'success', false, false);
            } else {
                return $this->responseRedirectBack('Error occurred while creating MoneyReceipt.', 'error', true, true);
            }

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
            //return $this->responseRedirectBack('Error occurred while creating MoneyReceipt.', 'error', true, true);
        }
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

        return view('Crm::MoneyReceipt.voucher', compact('MoneyReceipt','id'));
    }
}

<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\SellOrderDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Config\Models\Lookup;
use App\Modules\Crm\Models\SellOrder;
use App\Modules\Crm\Models\SellOrderDetails;
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

class SellOrderController extends BaseController
{
    use UploadAble;

    public $model;
    public $store;
    public $lookup;

    public function __construct(SellOrder $model)
    {
        $this->model = $model;
        $this->store = new Stores();
        $this->lookup = new Lookup();
    }

    /**
     * @param SellOrderDataTable $dataTable
     * @return Factory|View
     */
    public function index(SellOrderDataTable $dataTable)
    {
        $this->setPageTitle('Sales Order', 'List of all orders');
        return $dataTable->render('Crm::sell-order.index');
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
        $this->setPageTitle('Create Order', 'Create order');
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
            $invoice = new SellOrder();
            $maxSlNo = $invoice->maxSlNo($store_id = $params['store_id']);
            $year = Carbon::now()->year;
            $store = Stores::findOrFail($store_id);
            $invNo = "INV-$store->code-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

            $invoice->cash_credit = $cash_credit = $params['cash_credit'];
            $invoice->max_sl_no = $maxSlNo;
            $invoice->invoice_no = $invNo;
            $invoice->store_id = $params['store_id'];
            $invoice->customer_id = $params['customer_id'];
            $invoice->discount_amount = 0;
            $invoice->grand_total = $grand_total = $params['grand_total'];
            $invoice->date = $date = $params['date'];
            $invoice->created_by = $created_by = auth()->user()->id;
            if ($invoice->save()) {
                $invoice_id = $invoice->id;
                $i = 0;
                foreach ($params['product']['temp_product_id'] as $product_id) {
                    $stock_qty = $params['product']['temp_stock_qty'][$i];
                    $sell_price = $params['product']['temp_sell_price'][$i];
                    $sell_qty = $params['product']['temp_sell_qty'][$i];
                    $row_sell_price = $params['product']['temp_row_sell_price'][$i];

                    $invoiceDetails = new SellOrderDetails();
                    $invoiceDetails->invoice_id = $invoice_id;
                    $invoiceDetails->product_id = $product_id;
                    $invoiceDetails->qty = $sell_qty;
                    $invoiceDetails->sell_price = $sell_price;
                    $invoiceDetails->discount = 0;
                    $invoiceDetails->row_total = $row_sell_price;
                    $invoiceDetails->save();

                    $i++;
                }

                return $this->responseRedirectToWithParameters('crm.sell.order.voucher', ['id' => $invoice->id], 'Invoice created successfully', 'success', false, false);
            } else {
                return $this->responseRedirectBack('Error occurred while creating order.', 'error', true, true);
            }

        } catch (QueryException $exception) {
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
            $brands = SellOrder::findOrFail($id);
            $this->setPageTitle('Orders', 'Edit Order : ' . $brands->name);
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
            $brand = SellOrder::findOrFail($params['id']);
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
        $data = SellOrder::find($id);
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
        $order = SellOrder::findOrFail($id);
        $order_no = $order->order_no;
        $this->setPageTitle('Order No-' . $order_no, 'Order Preview : ' . $order_no);

        return view('Crm::sell-order.voucher', compact('order', 'id'));
    }
}

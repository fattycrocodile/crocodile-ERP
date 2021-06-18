<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\SellOrderDataTable;
use App\Http\Controllers\BaseController;
use App\Model\User\User;
use App\Modules\Config\Models\Lookup;
use App\Modules\Crm\Models\Customers;
use App\Modules\Crm\Models\Invoice;
use App\Modules\Crm\Models\SellOrder;
use App\Modules\Crm\Models\SellOrderDetails;
use App\Modules\StoreInventory\Models\Stores;
use App\Modules\SupplyChain\Models\Area;
use App\Modules\SupplyChain\Models\Territory;
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

class SellOrderController extends BaseController
{
    use UploadAble;

    public $model;
    public $store;
    public $lookup;

    public function __construct(SellOrder $model)
    {
        $this->middleware('permission:sales_order.index|sales_order.create|sales_order.edit|sales_order.delete|sales_order.report|sales_order.invoice_create', ['only' => ['index','show']]);
        $this->middleware('permission:sales_order.create', ['only' => ['create','store']]);
        $this->middleware('permission:sales_order.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sales_order.delete', ['only' => ['delete']]);
        $this->middleware('permission:sales_order.report', ['only' => ['orderReport','orderReportView']]);
        $this->middleware('permission:sales_order.invoice_create', ['only' => ['invoiceCreate']]);


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
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            $stores =  Stores::where('id', '=', $store_id)->get();
        }else {
            $stores = Stores::all();
        }
//        $stores = $this->store->treeList();
        $payment_type = Lookup::items('payment_method');
        $cash_credit = Lookup::items('cash_credit');
        $bank = Lookup::items('bank');
        $this->setPageTitle('Create Order', 'Create order');
        return view('Crm::sell-order.create', compact('stores', 'payment_type', 'cash_credit', 'bank'));
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
            'product' => 'required|array',
        ]);
        $params = $request->except('_token');

        try {
            $order = new SellOrder();
            $maxSlNo = $order->maxSlNo($store_id = $params['store_id']);
            $year = Carbon::now()->year;
            $store = Stores::findOrFail($store_id);
            $invNo = "ORD-$store->code-$year-" . str_pad($maxSlNo, 8, '0', STR_PAD_LEFT);

            $customer = Customers::findOrFail($params['customer_id']);
            $territory = Territory::findOrFail($customer->territory_id);
            $area = Area::findOrFail($territory->area_id);
            $order->max_sl_no = $maxSlNo;
            $order->order_no = $invNo;
            $order->store_id = $params['store_id'];
            $order->customer_id = $params['customer_id'];

            $order->area_id = $area ? $area->id : NULL;
            $order->area_employee_id = $area ? $area->employee_id : NULL;
            $order->territory_id = $customer ? $customer->territory_id : NULL;
            $order->territory_employee_id = $territory ? $territory->employee_id : NULL;

            $order->discount_amount = 0;
            $order->grand_total = $grand_total = $params['grand_total'];
            $order->date = $date = $params['date'];
            $order->created_by = $created_by = auth()->user()->id;
            if ($order->save()) {
                $order_id = $order->id;
                $i = 0;
                foreach ($params['product']['temp_product_id'] as $product_id) {
                    $sell_price = $params['product']['temp_sell_price'][$i];
                    $sell_qty = $params['product']['temp_sell_qty'][$i];
                    $row_sell_price = $params['product']['temp_row_sell_price'][$i];

                    $orderDetails = new SellOrderDetails();
                    $orderDetails->order_id = $order_id;
                    $orderDetails->product_id = $product_id;
                    $orderDetails->qty = $sell_qty;
                    $orderDetails->sell_price = $sell_price;
                    $orderDetails->discount = 0;
                    $orderDetails->row_total = $row_sell_price;
                    $orderDetails->save();

                    $i++;
                }

                return $this->responseRedirectToWithParameters('crm.sales.order.voucher', ['id' => $order->id], 'Orders created successfully', 'success', false, false);
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
        return view('Crm::sell-order.edit', compact('brands'));
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
        ]);
        $params = $request->except('_token');
        try {
            $brand = SellOrder::findOrFail($params['id']);
            $collection = collect($params)->except('_token');
            $logo = $brand->logo;
            $merge = $collection->merge(compact('logo'));
            $brand->update($merge->all());

            if (!$brand) {
                return $this->responseRedirectBack('Error occurred while updating invoice.', 'error', true, true);
            }
            return $this->responseRedirect('Crm::sell-order.index', 'Order updated successfully', 'success', false, false);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function invoiceCreate($id)
    {
        try {
            $order = SellOrder::findOrFail($id);
            $stores = $this->store->treeList();
            $payment_type = Lookup::items('payment_method');
            $cash_credit = Lookup::items('cash_credit');
            $bank = Lookup::items('bank');
            $this->setPageTitle('Orders', 'Create invoice- Order No: : ' . $order->order_no);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
        return view('Crm::sell-order.invoice-create', compact('order', 'stores', 'payment_type', 'cash_credit', 'bank'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = SellOrder::find($id);
        if ($data) {
            DB::table('sell_order_details')->where('order_id', $id)->delete();
            if ($data->delete()) {
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'Order has been deleted successfully!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status_code' => 200,
                    'message' => 'Please try again!',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'status_code' => 200,
                'message' => 'Order Not Found!',
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

    public function orderReport()
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            $stores =  Stores::where('id', '=', $store_id)->get();
        }else {
            $stores = Stores::all();
        }
        $this->setPageTitle('Order Report', 'Order Report');
        return view('Crm::sell-order.order-report', compact('stores'));
    }

    public function orderReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $store_id = trim($request->store_id);
            $customer_id = trim($request->customer_id);
            $data = new SellOrder();
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
            $data = $data->orderby('date', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('Crm::sell-order.order-report-view', compact('data', 'start_date', 'end_date', 'store_id', 'customer_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function areaOrderReport()
    {
        $this->setPageTitle('Area Wise Order Report', 'Area Wise Order Report');
        return view('SupplyChain::reports.area-wise-order-report');
    }

    public function areaOrderReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $area_id = trim($request->area_id);
            $data = new SellOrder();
            $data = $data->where('date', '>=', $start_date);
            $data = $data->where('date', '<=', $end_date);
            if ($area_id > 0) {
                $data = $data->where('area_id', '=', $area_id);
            }
            $user_store_id = User::getStoreId(auth()->user()->id);
            if ($user_store_id > 0){
                $data = $data->where('store_id', '=', $user_store_id);
            }
            $data = $data->orderby('date', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('SupplyChain::reports.area-wise-order-report-view', compact('data', 'start_date', 'end_date', 'area_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}

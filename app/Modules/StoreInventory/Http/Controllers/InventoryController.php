<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\InventoryDataTable;
use App\Http\Controllers\BaseController;
use App\Model\User\User;
use App\Modules\Config\Models\Lookup;
use App\Modules\StoreInventory\Models\Inventory;
use App\Modules\StoreInventory\Models\Product;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends BaseController
{

    public $model;
    public $store;
    public $lookup;

    public function __construct(Inventory $model)
    {
        $this->middleware('permission:inventory.index|inventory.create|inventory.edit|inventory.delete|inventory.report|inventory.value_report|inventory.ledger_report', ['only' => ['index','show']]);
        $this->middleware('permission:inventory.create', ['only' => ['create','store']]);
        $this->middleware('permission:inventory.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:inventory.delete', ['only' => ['delete']]);
        $this->middleware('permission:inventory.report', ['only' => ['stockReport','stockReportView']]);
        $this->middleware('permission:inventory.value_report', ['only' => ['stockValueReport','stockValueReportView']]);
        $this->middleware('permission:inventory.ledger_report', ['only' => ['stockLedgerReport','stockLedgerReportView']]);

        $this->model = $model;
        $this->store = new Stores();
        $this->lookup = new Lookup();
    }

    public function index(InventoryDataTable $dataTable)
    {
        $this->setPageTitle('Inventory', 'List of all stock ledger');
        return $dataTable->render('StoreInventory::inventory.index');
    }


    public function getProductStockQty(Request $request): ?JsonResponse
    {
        $response = array();
        if ($request->has('search')) {
            $search = trim($request->search);
            $data = new Inventory();

            $data = $data->select(DB::raw('sum(stock_in) as stock_in'), DB::raw('sum(stock_out) as stock_out'));
            if ($search != '') {
                $data = $data->where('product_id', '=', $search);
            }
            if ($request->has('store_id')) {
                $store_id = trim($request->store_id);
                if ($store_id > 0) {
                    $data = $data->where('store_id', '=', $store_id);
                }
            }
            $data = $data->limit(1);
            $data = $data->orderby('id', 'desc');
            $data = $data->first();
            if ($data) {
                $stock_in = $data->stock_in;
                $stock_out = $data->stock_out;
                $closing_balance = $stock_in - $stock_out;
                $response = array("stock_in" => $stock_in, "stock_out" => $stock_out, "closing_balance" => $closing_balance);
            } else {
                $response = array("stock_in" => 0, "stock_out" => 0, "closing_balance" => 0);
            }
        } else {
            $response = array("stock_in" => 0, "stock_out" => 0, "closing_balance" => 0);
        }
        return response()->json($response);
    }

    public function stockReport()
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            $stores =  Stores::where('id', '=', $store_id)->get();
        }else {
            $stores = Stores::all();
        }
        $this->setPageTitle('Stock Report', 'Stock Report');
        return view('StoreInventory::inventory.stock-report', compact('stores'));
    }

    public function stockReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $store_id = trim($request->store_id);
            $user_store_id = User::getStoreId(auth()->user()->id);
            if ($user_store_id > 0){
                $store_id =  $user_store_id;
            }
            $product_id = trim($request->product_id);
            $data = new Product();
            if ($product_id > 0) {
                $data = $data->where('id', '=', $product_id);
            }
            $data = $data->orderby('name', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('StoreInventory::inventory.stock-report-view', compact('data', 'start_date', 'end_date', 'store_id', 'product_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function stockValueReport()
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            $stores =  Stores::where('id', '=', $store_id)->get();
        }else {
            $stores = Stores::all();
        }
        $this->setPageTitle('Stock Value Report', 'Stock Value Report');
        return view('StoreInventory::inventory.stock-value-report', compact('stores'));
    }

    public function stockValueReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $store_id = trim($request->store_id);
            $user_store_id = User::getStoreId(auth()->user()->id);
            if ($user_store_id > 0){
                $store_id =  $user_store_id;
            }
            $product_id = trim($request->product_id);
            $data = new Product();
            if ($product_id > 0) {
                $data = $data->where('id', '=', $product_id);
            }
            $data = $data->orderby('name', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('StoreInventory::inventory.stock-value-report-view', compact('data', 'start_date', 'end_date', 'store_id', 'product_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function stockLedgerReport()
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0){
            $stores =  Stores::where('id', '=', $store_id)->get();
        }else {
            $stores = Stores::all();
        }
        $this->setPageTitle('Stock Ledger Report', 'Stock Value Report');
        return view('StoreInventory::inventory.stock-ledger-report', compact('stores'));
    }

    public function stockLedgerReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
            $store_id = trim($request->store_id);
            $product_id = trim($request->product_id);

            $data = new Inventory();

            $data = $data->where('date', '>=', $start_date);
            $data = $data->where('date', '<=', $end_date);
            if ($product_id > 0) {
                $data = $data->where('product_id', '=', $product_id);
            }
            if ($store_id > 0) {
                $data = $data->where('store_id', '=', $store_id);
            }
            $user_store_id = User::getStoreId(auth()->user()->id);
            if ($user_store_id > 0){
                $data = $data->where('store_id', '=', $user_store_id);
            }
//            $data = $data->select('inventories.*', DB::raw('sum(stock_in) as total_stock_in, sum(stock_out) as total_stock_out'));
            $data = $data->orderby('date', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('StoreInventory::inventory.stock-ledger-report-view', compact('data', 'start_date', 'end_date', 'store_id', 'product_id'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}

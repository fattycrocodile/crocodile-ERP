<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\InventoryDataTable;
use App\Http\Controllers\BaseController;
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
        $stores = $this->store->treeList();
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
        $stores = $this->store->treeList();
        $this->setPageTitle('Stock Report', 'Stock Value Report');
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
}

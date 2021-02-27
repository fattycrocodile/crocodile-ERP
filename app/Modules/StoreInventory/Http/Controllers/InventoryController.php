<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\InventoryDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Modules\StoreInventory\Models\Inventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends BaseController
{

    public $model;

    public function __construct(Inventory $model)
    {
        $this->model = $model;
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
}

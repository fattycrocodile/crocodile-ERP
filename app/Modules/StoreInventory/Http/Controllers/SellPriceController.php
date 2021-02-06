<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\SellpricesDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\SellPrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellPriceController extends BaseController
{

    public $model;

    public function __construct(SellPrice $model)
    {
        $this->model = $model;
    }
    public function index(SellpricesDataTable $dataTable)
    {
        $this->setPageTitle('Products Price', 'List of Products price');
        return $dataTable->render('StoreInventory::sellprices.index');
    }

    public function create()
    {
        $this->setPageTitle('Add Products Price', 'Add a Products price');
        return view('StoreInventory::sellprices.create');
    }

    public function store()
    {
        $this->setPageTitle('Add Products Price', 'Add a Products price');
        return view('StoreInventory::sellprices.create');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = SellPrice::find($id);
        if ($data->delete()) {
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

    public function getProductPrice(Request $request): ?JsonResponse
    {
        $response = array();
        if ($request->has('search')) {
            $search = trim($request->search);
            $data = new SellPrice();
            $data = $data->select('*');
            if ($search != '') {
                $data = $data->where('product_id', '=', $search);
            }
            $data = $data->where('status', '=', SellPrice::PRICE_ACTIVE);
            $data = $data->limit(1);
            $data = $data->orderby('id', 'desc');
            $data = $data->first();
//            dd($data);
            if ($data) {
                $response = array("sell_price" => $data->sell_price, "whole_sell_price" => $data->whole_sell_price, "min_sell_price" => $data->min_sell_price, "min_whole_sell_price" => $data->min_whole_sell_price);
            } else {
                $response = array("sell_price" => 0, "whole_sell_price" => 0, "min_sell_price" => 0, "min_whole_sell_price" => 0);
            }
        } else {
            $response = array("sell_price" => 0, "whole_sell_price" => 0, "min_sell_price" => 0, "min_whole_sell_price" => 0);
        }
        return response()->json($response);
    }
}

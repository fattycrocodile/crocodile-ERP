<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\SellpricesDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\SellPrice;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellPriceController extends BaseController
{

    public $model;

    public function __construct(SellPrice $model)
    {
        $this->middleware('permission:sell_price.index|sell_price.create|sell_price.edit|sell_price.delete', ['only' => ['index','show']]);
        $this->middleware('permission:sell_price.create', ['only' => ['create','store']]);
        $this->middleware('permission:sell_price.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sell_price.delete', ['only' => ['delete']]);

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

    public function store(Request $req)
    {
        $req->validate([
            'product_id' => 'required',
            'sell_price' => 'required',
            'min_whole_sell_price' => 'required',
        ]);

        try {
            DB::table('sell_prices')->where('status', '=', SellPrice::PRICE_ACTIVE)->where('product_id', '=', $req->product_id)->update(['status' => SellPrice::PRICE_INACTIVE]);
            $sellPrice = new SellPrice();
            $sellPrice->product_id = $req->product_id;
            $sellPrice->sell_price = $req->sell_price;
            $sellPrice->whole_sell_price = $req->whole_sell_price;
            $sellPrice->min_sell_price = $req->min_sell_price;
            $sellPrice->min_whole_sell_price = $req->min_whole_sell_price;
            $sellPrice->date = date('Y-m-d');
            if ($sellPrice->save()) {
                return $this->responseRedirect('storeInventory.sellprices.index', 'Price added successfully', 'success', false, false);
            } else {
                return $this->responseRedirectBack('Error occurred while creating Sell Price.', 'error', true, true);
            }
        } catch (QueryException $exception) {
            //dd($exception);
            return $this->responseRedirectBack('Error occurred while creating Sell Price.', 'error', true, true);
        }

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

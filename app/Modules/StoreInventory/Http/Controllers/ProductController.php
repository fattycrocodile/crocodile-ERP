<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\Brand;
use App\Modules\StoreInventory\Models\Category;
use App\Modules\StoreInventory\Models\Product;
use App\Modules\StoreInventory\Models\SellPrice;
use App\Modules\StoreInventory\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(ProductsDataTable $dataTable)
    {
        $this->setPageTitle('Products', 'List of Products');
        return $dataTable->render('StoreInventory::products.index');
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $units = Unit::all();
        $this->setPageTitle('Create Products', 'Create new Products');
        return view('StoreInventory::products.create', compact('categories', 'brands', 'units'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|min:5',
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit_id' => 'required',
            'code' => 'required',
            'min_stock_qty' => 'required',
            'min_order_qty' => 'required',
            'sell_price' => 'required',
            'whole_sell_price' => 'required',
            'description' => 'required',
        ]);
        $product = new Product();
        $sellPrice = new SellPrice();
        $product->name = $req->name;
        $product->description = $req->description;
        $product->category_id = $req->category_id;
        $product->brand_id = $req->brand_id;
        $product->unit_id = $req->unit_id;
        $product->min_stock_qty = $req->min_stock_qty;
        $product->min_order_qty = $req->min_order_qty;
        $product->code = $req->code;
        $product->created_by = auth()->user()->id;
        $product->updated_by = auth()->user()->id;

        $sellPrice->sell_price = $req->sell_price;
        $sellPrice->whole_sell_price = $req->whole_sell_price;
        $sellPrice->min_sell_price = $req->min_sell_price;
        $sellPrice->min_whole_sell_price = $req->min_whole_sell_price;
        $sellPrice->created_by = auth()->user()->id;
        $sellPrice->updated_by = auth()->user()->id;
        $sellPrice->date = date('Y-m-d');

        if (!$product->save()) {
            return $this->responseRedirectBack('Error occurred while creating Product.', 'error', true, true);
        } else {
            $sellPrice->product_id = $product->id;
            if ($sellPrice->save()) {
                return $this->responseRedirect('storeInventory.products.index', 'Product added successfully', 'success', false, false);
            } else {
                return $this->responseRedirectBack('Error occurred while creating Product.', 'error', true, true);
            }
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        $units = Unit::all();
        $sellPrice = SellPrice::where('product_id', '=', $id)->where('status', '=', 1)->orderby('id', 'desc')->first();
        $this->setPageTitle('Edit product', 'Edit a Product');
        return view('StoreInventory::products.edit', compact('product', 'categories', 'brands', 'units', 'sellPrice'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|min:5',
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit_id' => 'required',
            'code' => 'required',
            'min_stock_qty' => 'required',
            'min_order_qty' => 'required',
            'sell_price' => 'required',
            'whole_sell_price' => 'required',
            'description' => 'required',
        ]);
        $product = Product::find($id);
        $sellPrice = new SellPrice();
        $product->name = $req->name;
        $product->description = $req->description;
        $product->category_id = $req->category_id;
        $product->brand_id = $req->brand_id;
        $product->unit_id = $req->unit_id;
        $product->min_stock_qty = $req->min_stock_qty;
        $product->min_order_qty = $req->min_order_qty;
        $product->code = $req->code;
        $product->created_by = auth()->user()->id;
        $product->updated_by = auth()->user()->id;

        $sellPrice->sell_price = $req->sell_price;
        $sellPrice->whole_sell_price = $req->whole_sell_price;
        $sellPrice->min_sell_price = $req->min_sell_price;
        $sellPrice->min_whole_sell_price = $req->min_whole_sell_price;
        $sellPrice->created_by = auth()->user()->id;
        $sellPrice->updated_by = auth()->user()->id;
        $sellPrice->date = date('Y-m-d');

        if (!$product->update()) {
            return $this->responseRedirectBack('Error occurred while editing Product.', 'error', true, true);
        } else {
            $sellPrice->product_id = $id;
            if ($sellPrice->save()) {
                return $this->responseRedirect('storeInventory.products.index', 'Product updated successfully', 'success', false, false);
            } else {
                return $this->responseRedirectBack('Error occurred while editing Product.', 'error', true, true);
            }
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Product::find($id);
        if ($data->sellPrice()->delete() && $data->delete()) {
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

    public function getProductListByName(Request $request)
    {
        if ($request->has('term')) {
            $data = Product::where("name", "LIKE", "%{$request->term}%")
                ->get();

            return response()->json($data);
        }
        return NULL;
    }
}

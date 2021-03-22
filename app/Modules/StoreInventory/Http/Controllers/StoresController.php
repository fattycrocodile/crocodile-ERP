<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\StoresDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoresController extends BaseController
{
    public $model;

    public function __construct()
    {
        $this->middleware('permission:store.index|store.create|store.edit|store.delete', ['only' => ['index','show']]);
        $this->middleware('permission:store.create', ['only' => ['create','store']]);
        $this->middleware('permission:store.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:store.delete', ['only' => ['delete']]);
        $this->model = new Stores;
    }

    public function index(StoresDataTable $dataTable)
    {
        $this->setPageTitle('Products', 'List of Products');
        return $dataTable->render('StoreInventory::stores.index');
    }

    public function create()
    {
        $this->setPageTitle('Create Store', 'Create new Store');
        return view('StoreInventory::stores.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|min:5',
            'contact' => 'required',
            'address' => 'required',
            'code' => 'required',
            'pad_header' => 'mimes:jpg,jpeg,png|max:1000',
            'pad_footer' => 'mimes:jpg,jpeg,png|max:1000',
            'pad' => 'mimes:jpg,jpeg,png|max:2000',

        ]);

        $store = new Stores();

        if ($req->hasFile('pad_header')) {
            $file = $req->file('pad_header');
            $path = 'public/uploads/stores/pad_header';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $store->pad_header = $path . '/' . $file_name;
        }

        if ($req->hasFile('pad_footer')) {
            $file = $req->file('pad_footer');
            $path = 'public/uploads/stores/pad_footer';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $store->pad_footer = $path . '/' . $file_name;
        }

        if ($req->hasFile('pad')) {
            $file = $req->file('pad');
            $path = 'public/uploads/stores/pad';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $store->pad = $path . '/' . $file_name;
        }

        $store->name = $req->name;
        $store->address = $req->address;
        $store->contact = $req->contact;
        $store->code = $req->code;
        $store->created_by = auth()->user()->id;
        $store->updated_by = auth()->user()->id;

        if (!$store->save()) {
            return $this->responseRedirectBack('Error occurred while creating Store.', 'error', true, true);
        }
        else
        {
            return $this->responseRedirect('storeInventory.stores.index', 'Store added successfully', 'success', false, false);
        }
    }

    public function edit($id)
    {
        $store = Stores::findOrFail($id);
        $this->setPageTitle('Edit product', 'Edit a Product');
        return view('StoreInventory::stores.edit', compact('store'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|min:5',
            'contact' => 'required',
            'address' => 'required',
            'code' => 'required',
            'pad_header' => 'mimes:jpg,jpeg,png|max:1000',
            'pad_footer' => 'mimes:jpg,jpeg,png|max:1000',
            'pad' => 'mimes:jpg,jpeg,png|max:2000',
        ]);

        $store = Stores::find($id);
        if ($req->hasFile('pad_header')) {
            $file = $req->file('pad_header');
            $path = 'public/uploads/stores/pad_header';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            if (file_exists($store->pad_header)) {
                unlink($store->pad_header);
            }
            $store->pad_header = $path . '/' . $file_name;
        }

        if ($req->hasFile('pad_footer')) {
            $file = $req->file('pad_footer');
            $path = 'public/uploads/stores/pad_footer';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            if (file_exists($store->pad_footer)) {
                unlink($store->pad_footer);
            }
            $store->pad_footer = $path . '/' . $file_name;
        }

        if ($req->hasFile('pad')) {
            $file = $req->file('pad');
            $path = 'public/uploads/stores/pad';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            if (file_exists($store->pad)) {
                unlink($store->pad);
            }
            $store->pad = $path . '/' . $file_name;
        }

        $store->name = $req->name;
        $store->address = $req->address;
        $store->contact = $req->contact;
        $store->code = $req->code;
        $store->updated_by = auth()->user()->id;

        if (!$store->update()) {
            return $this->responseRedirectBack('Error occurred while editing Store.', 'error', true, true);
        }
        else
        {
            return $this->responseRedirect('storeInventory.stores.index', 'Store updated successfully', 'success', false, false);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Stores::find($id);
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
}

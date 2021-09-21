<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\DataTables\WarrantyDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Modules\StoreInventory\Models\Category;
use App\Modules\StoreInventory\Models\Warranty;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WarrantyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $category;

    public function __construct()
    {
        $this->middleware('permission:category.index|category.create|category.edit|category.delete', ['only' => ['index','show']]);
        $this->middleware('permission:category.create', ['only' => ['create','store']]);
        $this->middleware('permission:category.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category.delete', ['only' => ['delete']]);

        $this->category = new Category;
    }

    /**
     * @param WarrantyDataTable $dataTable
     * @return Factory|View
     */
    public function index(WarrantyDataTable $dataTable)
    {
        $this->setPageTitle('Warranties', 'List of all Warranties');
        return $dataTable->render('StoreInventory::warranties.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $this->setPageTitle('Warranties', 'Create warranty');
        return view('StoreInventory::warranties.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $warranties = new Warranty();

        $warranties->name = $request->name;
        $warranties->description = $request->description;
        $warranties->created_by = auth()->user()->id;

        if (!$warranties->save()) {
            return $this->responseRedirectBack('Error occurred while creating warranty.', 'error', true, true);
        }
        return $this->responseRedirect('storeInventory.warranties.index', 'Warranty added successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $warranties = Warranty::findOrFail($id);
        $this->setPageTitle('Edit Warranties', 'Edit Warranty : ' . $warranties->name);
        return view('StoreInventory::warranties.edit', compact('warranties'));
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

        $warranties = Warranty::findOrFail($request->id);
        $warranties->name = $request->name;
        $warranties->description = $request->description;
        $warranties->updated_by = auth()->user()->id;

        if (!$warranties->update()) {
            return $this->responseRedirectBack('Error occurred while updating Warranties.', 'error', true, true);
        }
        return $this->responseRedirect('storeInventory.warranties.index', 'Warranties Edited successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Warranty::find($id);
        if($data->delete()) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Record has been deleted successfully!',
            ]);
        } else{
            return response()->json([
                'success' => false,
                'status_code' => 200,
                'message' => 'Please try again!',
            ]);
        }
    }
}

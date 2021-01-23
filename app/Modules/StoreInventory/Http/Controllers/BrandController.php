<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\Brand;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

use DataTables;

class BrandController extends BaseController
{

    /**
     * @return Factory|View
     */
    public function index()
    {
        $brands = [];
        $this->setPageTitle('Brands', 'List of all brands');
        return view("StoreInventory::brands.index", compact('brands'));
    }

    public function getBrands(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $brands = [];
        $this->setPageTitle('brands', 'Create Category');
        return view('storeInventory.brands.create', compact('brands'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'parent_id' => 'required|not_in:0',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);
        $params = $request->except('_token');
        $category = $this->categoryRepository->createCategory($params);
        if (!$category) {
            return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
        }
        return $this->responseRedirect('storeInventory.brands.index', 'Category added successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $targetCategory = $this->categoryRepository->findCategoryById($id);
//        $brands = $this->categoryRepository->listbrands();
        $brands = $this->categoryRepository->treeList();
        $this->setPageTitle('brands', 'Edit Category : ' . $targetCategory->name);
        return view('storeInventory.brands.edit', compact('brands', 'targetCategory'));
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
            'parent_id' => 'required|not_in:0',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);
        $params = $request->except('_token');
        $category = $this->categoryRepository->updateCategory($params);
        if (!$category) {
            return $this->responseRedirectBack('Error occurred while updating category.', 'error', true, true);
        }
        return $this->responseRedirectBack('Category updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $category = $this->categoryRepository->deleteCategory($id);
        if (!$category) {
            return $this->responseRedirectBack('Error occurred while deleting category.', 'error', true, true);
        }
        return $this->responseRedirect('storeInventory.brands.index', 'Category deleted successfully', 'success', false, false);
    }
}

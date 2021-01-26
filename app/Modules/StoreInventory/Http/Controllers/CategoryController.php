<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategoryController extends BaseController
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $categories = Category::where('root_id', '>', 0)->get();
        $this->setPageTitle('Categories', 'List of all categories');
        return view('StoreInventory::categories.index', compact('categories'));
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $categories = Category::all();
        $this->setPageTitle('Categories', 'Create Category');
        return view('StoreInventory::categories.create', compact('categories'));
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
            'root_id' => 'required|not_in:0',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $category = new Category();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'public/uploads/categories';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $category->image = $path . '/' . $file_name;
        }
        $category->name = $request->name;
        $category->root_id = $request->root_id;
        $category->created_by = auth()->user()->id;

        if (!$category->save()) {
            return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
        }
        return $this->responseRedirect('storeInventory.categories.index', 'Category added successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $targetCategory = Category::findOrFail($id);
        $categories = Category::all();
        $this->setPageTitle('Edit Categories', 'Edit Category : ' . $targetCategory->name);
        return view('StoreInventory::categories.edit', compact('categories', 'targetCategory'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|max:191',
            'root_id' => 'required|not_in:0',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'public/uploads/categories';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            if (file_exists($category->image)) {
                unlink($category->image);
            }

            $category->image = $path . '/' . $file_name;
        }
        $category->name = $request->name;
        $category->root_id = $request->root_id;
        $category->updated_by = auth()->user()->id;

        if (!$category->update()) {
            return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
        }
        return $this->responseRedirect('storeInventory.categories.index', 'Category added successfully', 'success', false, false);
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
        return $this->responseRedirect('admin.categories.index', 'Category deleted successfully', 'success', false, false);
    }
}

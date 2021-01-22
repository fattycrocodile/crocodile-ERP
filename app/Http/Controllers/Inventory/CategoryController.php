<?php

namespace App\Http\Controllers\Accounting\Accounting\Accounting\Accounting\Accounting\Commercial\Commercial\Commercial\Commercial\Config\Config\Config\Crm\Crm\Crm\Crm\Crm\Crm\Crm\Hr\Hr\Hr\Hr\Hr\Hr\Hr\Inventory;

use App\Http\Controllers\Accounting\Accounting\Accounting\Accounting\Accounting\Commercial\Commercial\Commercial\Commercial\Config\Config\Config\Crm\Crm\Crm\Crm\Crm\Crm\Crm\Hr\Hr\Hr\Hr\Hr\Hr\Hr\BaseController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategoryController extends BaseController
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $categories = [];
        $this->setPageTitle('Categories', 'List of all categories');
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $categories = [];
        $this->setPageTitle('Categories', 'Create Category');
        return view('admin.categories.create', compact('categories'));
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
        return $this->responseRedirect('admin.categories.index', 'Category added successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $targetCategory = $this->categoryRepository->findCategoryById($id);
//        $categories = $this->categoryRepository->listCategories();
        $categories = $this->categoryRepository->treeList();
        $this->setPageTitle('Categories', 'Edit Category : ' . $targetCategory->name);
        return view('admin.categories.edit', compact('categories', 'targetCategory'));
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
        return $this->responseRedirect('admin.categories.index', 'Category deleted successfully', 'success', false, false);
    }
}

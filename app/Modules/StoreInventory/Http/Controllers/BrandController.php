<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\BrandsDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\Brand;
use App\Traits\UploadAble;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class BrandController extends BaseController
{
    use UploadAble;

    public $model;

    public function __construct(Brand $model)
    {
        $this->middleware('permission:brand.index|brand.create|brand.edit|brand.delete', ['only' => ['index','show']]);
        $this->middleware('permission:brand.create', ['only' => ['create','store']]);
        $this->middleware('permission:brand.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:brand.delete', ['only' => ['delete']]);

        $this->model = $model;
    }


    /**
     * @param BrandsDataTable $dataTable
     * @return Factory|View
     */
    public function index(BrandsDataTable $dataTable)
    {
        $this->setPageTitle('Brands', 'List of all brands');
        return $dataTable->render('StoreInventory::brands.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $brands = [];
        $this->setPageTitle('Create Brands', 'Create Brands');
        return view('StoreInventory::brands.create', compact('brands'));
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
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);
        $params = $request->except('_token');

        try {
            $collection = collect($params);
            $logo = null;
            if ($collection->has('logo') && ($params['logo'] instanceof  UploadedFile)) {
                $logo = $this->uploadOne($params['logo'], 'brands');
            }

            $merge = $collection->merge(compact('logo'));
            $brand = new Brand($merge->all());
            if ($brand->save()){
                return $this->responseRedirect('storeInventory.brands.index', 'Brand added successfully', 'success', false, false);
            } else {
                return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
            }

        } catch (QueryException $exception) {
            //throw new InvalidArgumentException($exception->getMessage());
            return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
        }
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        try {
            $brands =  Brand::findOrFail($id);
            $this->setPageTitle('Brands', 'Edit Brands : ' . $brands->name);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
        return view('StoreInventory::brands.edit', compact('brands'));
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
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);
        $params = $request->except('_token');
        try {
            $brand = Brand::findOrFail($params['id']);
            $collection = collect($params)->except('_token');
            $logo = $brand->logo;
            if ($collection->has('logo') && ($params['logo'] instanceof  UploadedFile)) {
                if ($brand->logo != null) {
                    $this->deleteOne($brand->logo);
                }
                $logo = $this->uploadOne($params['logo'], 'brands');
            }
            $merge = $collection->merge(compact('logo'));
            $brand->update($merge->all());

            if (!$brand) {
                return $this->responseRedirectBack('Error occurred while updating brand.', 'error', true, true);
            }
            return $this->responseRedirect('storeInventory.brands.index','Brand updated successfully', 'success', false, false);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Brand::find($id);
        $logo = $data->logo;
        if($data->delete()) {
            if ($logo != null) {
                $this->deleteOne($logo);
            }
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

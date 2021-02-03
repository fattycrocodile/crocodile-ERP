<?php

namespace App\Modules\Crm\Http\Controllers;

use App\DataTables\InvoiceDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Crm\Models\Invoice;
use App\Modules\StoreInventory\Models\Stores;
use App\Traits\UploadAble;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InvoiceController extends BaseController
{
    use UploadAble;
    public $model;
    public $store;

    public function __construct(Invoice $model)
    {
        $this->model = $model;
        $this->store = new Stores();
    }

    /**
     * @param InvoiceDataTable $dataTable
     * @return Factory|View
     */
    public function index(InvoiceDataTable $dataTable)
    {
        $this->setPageTitle('Invoice', 'List of all invoices');
        return $dataTable->render('Crm::invoice.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $stores = $this->store->treeList();
        $this->setPageTitle('Create Invoice', 'Create Invoice');
        return view('Crm::invoice.create', compact('stores'));
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
            $brand = new Invoice($merge->all());
            if ($brand->save()){
                return $this->responseRedirect('crm.invoice.index', 'invoice added successfully', 'success', false, false);
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
            $brands =  Invoice::findOrFail($id);
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
            $brand = Invoice::findOrFail($params['id']);
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
                return $this->responseRedirectBack('Error occurred while updating invoice.', 'error', true, true);
            }
            return $this->responseRedirect('crm.invoice.index','invoice updated successfully', 'success', false, false);
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
        $data = Invoice::find($id);
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

<?php

namespace App\Modules\SupplyChain\Http\Controllers;

use App\DataTables\AreaDataTable;
use App\Http\Controllers\BaseController;
use App\Model\User\User;
use App\Modules\StoreInventory\Models\Category;
use App\Modules\StoreInventory\Models\Stores;
use App\Modules\SupplyChain\Models\Area;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AreaController extends BaseController
{
    public $area;
    public $stores;

    public function __construct()
    {
        $this->middleware('permission:area.index|area.create|area.edit|area.delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:area.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:area.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:area.delete', ['only' => ['delete']]);

        $this->area = new Area();
        $this->stores = new Stores();
    }

    /**
     * @param AreaDataTable $dataTable
     * @return Factory|View
     */
    public function index(AreaDataTable $dataTable)
    {
        $this->setPageTitle('Areas', 'List of all area');
        return $dataTable->render('SupplyChain::area.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0) {
            $stores = Stores::where('id', '=', $store_id)->get();
        } else {
            $stores = Stores::all();
        }
        $this->setPageTitle('Area', 'Create Area');
        return view('SupplyChain::area.create', compact('stores'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'store_id' => 'required',
            'name' => 'required|max:191',
            'code' => 'required|unique:areas',
        ]);

        $area = new Area();

        $area->store_id = $request->store_id;
        $area->name = $request->name;
        $area->code = $request->code;
        $area->address = $request->address;
        $area->contact_no = $request->contact_no;
        $area->created_by = auth()->user()->id;

        if (!$area->save()) {
            return $this->responseRedirectBack('Error occurred while creating area.', 'error', true, true);
        }
        return $this->responseRedirect('supplyChain.area.index', 'Area added successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $targetArea = Area::findOrFail($id);
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0) {
            $stores = Stores::where('id', '=', $store_id)->get();
        } else {
            $stores = Stores::all();
        }
        $this->setPageTitle('Edit Area', 'Edit Area : ' . $targetArea->name);
        return view('SupplyChain::area.edit', compact('stores', 'targetArea'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'store_id' => 'required',
            'name' => 'required|max:191',
        ]);

        $area = Area::findOrFail($id);

        $area->store_id = $request->store_id;
        $area->name = $request->name;
        $area->code = $request->code;
        $area->address = $request->address;
        $area->contact_no = $request->contact_no;
        $area->updated_by = auth()->user()->id;

        if (!$area->update()) {
            return $this->responseRedirectBack('Error occurred while updating area.', 'error', true, true);
        }
        return $this->responseRedirect('supplyChain.area.index', 'Area Edited successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Area::find($id);
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

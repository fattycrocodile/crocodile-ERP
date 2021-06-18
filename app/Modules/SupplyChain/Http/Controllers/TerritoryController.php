<?php

namespace App\Modules\SupplyChain\Http\Controllers;

use App\DataTables\AreaDataTable;
use App\DataTables\TerritoryDataTable;
use App\Http\Controllers\BaseController;
use App\Model\User\User;
use App\Modules\Hr\Models\Employees;
use App\Modules\StoreInventory\Models\Stores;
use App\Modules\SupplyChain\Models\Area;
use App\Modules\SupplyChain\Models\Territory;
use Faker\Provider\Base;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TerritoryController extends BaseController
{
    public $area;
    public $territory;

    public function __construct()
    {
        $this->middleware('permission:territory.index|territory.create|territory.edit|territory.delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:territory.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:territory.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:territory.delete', ['only' => ['delete']]);

        $this->area = new Area();
        $this->territory = new Territory();
    }

    /**
     * @param TerritoryDataTable $dataTable
     * @return Factory|View
     */
    public function index(TerritoryDataTable $dataTable)
    {
        $this->setPageTitle('Territory', 'List of all territory');
        return $dataTable->render('SupplyChain::territory.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $areas = Area::all();
        $employees = Employees::all();
        $this->setPageTitle('Territory', 'Create Territory');
        return view('SupplyChain::territory.create', compact('areas', 'employees'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'area_id' => 'required',
            'name' => 'required|max:191',
            'code' => 'required|unique:territory',
        ]);

        $territory = new Territory();

        $territory->area_id = $request->area_id;
        $territory->name = $request->name;
        $territory->code = $request->code;
        $territory->address = $request->address;
        $territory->contact_no = $request->contact_no;
        $territory->employee_id = $request->employee_id;
        $territory->created_by = auth()->user()->id;

        if (!$territory->save()) {
            return $this->responseRedirectBack('Error occurred while creating territory.', 'error', true, true);
        }
        return $this->responseRedirect('supplyChain.territory.index', 'Territory added successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $targetterritory = Territory::findOrFail($id);

        $areas = Area::all();
        $employees = Employees::all();
        $this->setPageTitle('Edit Territory', 'Edit Territory : ' . $targetterritory->name);
        return view('SupplyChain::territory.edit', compact('areas', 'targetterritory', 'employees'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'area_id' => 'required',
            'name' => 'required|max:191',
        ]);

        $territory = Territory::findOrFail($id);

        $territory->area_id = $request->area_id;
        $territory->name = $request->name;
        $territory->code = $request->code;
        $territory->address = $request->address;
        $territory->contact_no = $request->contact_no;
        $territory->employee_id = $request->employee_id;
        $territory->updated_by = auth()->user()->id;

        if (!$territory->update()) {
            return $this->responseRedirectBack('Error occurred while updating territory.', 'error', true, true);
        }
        return $this->responseRedirect('supplyChain.territory.index', 'Territory Edited successfully', 'success', false, false);
    }


    public function getTerritoryListByName(Request $request): ?JsonResponse
    {
        $response = array();
        if ($request->has('search')) {
            $search = trim($request->search);
            $area_id = trim($request->area_id);
            $data = new Territory();
            $data = $data->select('id', 'name','code');
            if ($search != '') {
                $data = $data->where('name', 'like', '%' . $search . '%');
            }
            if ($area_id != '') {
                $data = $data->where('area_id', 'like', '%' . $area_id . '%');
            }
            $data = $data->limit(20);
            $data = $data->orderby('name', 'asc');
            $data = $data->get();
            if (!$data->isEmpty()) {
                foreach ($data as $dt) {
                    $response[] = array("value" => $dt->id, "label" => $dt->name, 'name' => $dt->name, 'code' => $dt->code);
                }
            } else {
                $response[] = array("value" => '', "label" => 'No data found!', 'name' => '', 'code' => '');
            }
        } else {
            $response[] = array("value" => '', "label" => 'No data found!', 'name' => '', 'code' => '');
        }
        return response()->json($response);
    }

    public function getTerritoryListByCode(Request $request): ?JsonResponse
    {
        $response = array();
        if ($request->has('search')) {
            $search = trim($request->search);
            $area_id = trim($request->area_id);
            $data = new Territory();
            $data = $data->select('id', 'name','code');
            if ($search != '') {
                $data = $data->where('code', 'like', '%' . $search . '%');
            }
            if ($area_id != '') {
                $data = $data->where('area_id', 'like', '%' . $area_id . '%');
            }
            $data = $data->limit(20);
            $data = $data->orderby('name', 'asc');
            $data = $data->get();
            if (!$data->isEmpty()) {
                foreach ($data as $dt) {
                    $response[] = array("value" => $dt->id, "label" => $dt->name, 'name' => $dt->name, 'code' => $dt->code);
                }
            } else {
                $response[] = array("value" => '', "label" => 'No data found!', 'name' => '', 'code' => '');
            }
        } else {
            $response[] = array("value" => '', "label" => 'No data found!', 'name' => '', 'code' => '');
        }
        return response()->json($response);
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Territory::find($id);
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

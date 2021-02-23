<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\UnitsDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnitController extends BaseController
{
    public function index(UnitsDataTable $dataTable)
    {
        $units = Unit::all();
        $this->setPageTitle('Units', 'List of Units');
        return $dataTable->render('StoreInventory::units.index');
    }

    public function create()
    {
        $this->setPageTitle('Create Units', 'Create new Units');
        return view('StoreInventory::units.create');
    }

    public function store(Request $req)
    {
        $validate = $req->validate([
            'name' => 'required|unique:units|min:2'
        ]);
        $units = new Unit();
        $units->name = $req->name;
        $units->description = $req->description;
        $units->created_by = auth()->user()->id;
        $units->updated_by = auth()->user()->id;

        if (!$units->save()) {
            return $this->responseRedirectBack('Error occurred while creating Unit.', 'error', true, true);
        }
        return $this->responseRedirect('storeInventory.units.index', 'Unit added successfully', 'success', false, false);
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $this->setPageTitle('Edit Unit', 'Edit a unit');
        return view('StoreInventory::units.edit', compact('unit'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|min:2'
        ]);
        $units = Unit::findOrFail($id);
        $units->name = $req->name;
        $units->description = $req->description;
        $units->updated_by = auth()->user()->id;

        if (!$units->update()) {
            return $this->responseRedirectBack('Error occurred while Editing Unit.', 'error', true, true);
        }
        return $this->responseRedirect('storeInventory.units.index', 'Unit Updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Unit::find($id);
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

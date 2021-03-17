<?php

namespace App\Modules\Hr\Http\Controllers;
use App\DataTables\DesignationsDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Hr\Models\Designations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DesignationsController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission:designation.index|designation.create|designation.edit|designation.delete', ['only' => ['index','show']]);
        $this->middleware('permission:designation.create', ['only' => ['create','store']]);
        $this->middleware('permission:designation.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:designation.delete', ['only' => ['delete']]);
    }

    public function index(DesignationsDataTable $dataTable)
    {
        $this->setPageTitle('Designations List','List of Designations');
        return $dataTable->render('Hr::designations.index');
    }

    public function create()
    {
        $this->setPageTitle('Add Designation','Add Designation to List of Designations');
        return view('Hr::designations.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' =>'required',
        ]);

        $designations = new Designations();
        $designations->name = $req->name;
        $designations->created_by = auth()->user()->id;
        $designations->updated_by = auth()->user()->id;

        if (!$designations->save()) {
            return $this->responseRedirectBack('Error occurred while adding Designation.', 'error', true, true);
        }
        return $this->responseRedirect('hr.designations.index', 'Designation added successfully', 'success', false, false);
    }

    public function edit($id)
    {
        $designation = Designations::find($id);
        $this->setPageTitle('Edit Designation','Edit a Designation from List of Designations');
        return view('Hr::designations.edit',compact('designation'));
    }

    public function update(Request $req,$id)
    {
        $req->validate([
            'name' =>'required',
        ]);

        $designations = Designations::findOrFail($id);
        $designations->name = $req->name;
        $designations->status = $req->status;
        $designations->updated_by = auth()->user()->id;


        if (!$designations->update()) {
            return $this->responseRedirectBack('Error occurred while editing Designation.', 'error', true, true);
        }
        return $this->responseRedirect('hr.designations.index', 'Designation updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Designations::find($id);
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

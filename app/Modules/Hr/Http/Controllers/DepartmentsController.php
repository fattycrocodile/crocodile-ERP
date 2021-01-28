<?php

namespace App\Modules\Hr\Http\Controllers;

use App\DataTables\DepartmentsDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Hr\Models\Departments;
use App\Modules\Hr\Models\Designations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentsController extends BaseController
{
    public function index(DepartmentsDataTable $dataTable)
    {
        $this->setPageTitle('Departments List','List of Departments');
        return $dataTable->render('Hr::departments.index');
    }

    public function create()
    {
        $this->setPageTitle('Add Department','Add Department to List of Departments');
        return view('Hr::departments.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' =>'required',
        ]);

        $department = new Departments();
        $department->name = $req->name;
        $department->created_by = auth()->user()->id;
        $department->updated_by = auth()->user()->id;

        if (!$department->save()) {
            return $this->responseRedirectBack('Error occurred while adding Department.', 'error', true, true);
        }
        return $this->responseRedirect('hr.departments.index', 'Department added successfully', 'success', false, false);
    }

    public function edit($id)
    {
        $department = Departments::find($id);
        $this->setPageTitle('Edit Department','Edit a Department from List of Departments');
        return view('Hr::departments.edit',compact('department'));
    }

    public function update(Request $req,$id)
    {
        $req->validate([
            'name' =>'required',
        ]);

        $department = Departments::findOrFail($id);
        $department->name = $req->name;
        $department->status = $req->status;
        $department->updated_by = auth()->user()->id;


        if (!$department->update()) {
            return $this->responseRedirectBack('Error occurred while editing Department.', 'error', true, true);
        }
        return $this->responseRedirect('hr.departments.index', 'Department updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Departments::find($id);
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

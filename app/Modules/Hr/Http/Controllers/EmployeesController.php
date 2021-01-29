<?php

namespace App\Modules\Hr\Http\Controllers;

use App\DataTables\EmployeesDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Config\Models\Lookup;
use App\Modules\Hr\Models\Departments;
use App\Modules\Hr\Models\Designations;
use App\Modules\Hr\Models\Employees;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeesController extends BaseController
{
    public function index(EmployeesDataTable $dataTable)
    {
        $this->setPageTitle('Employees', 'List of Employees');
        return $dataTable->render('Hr::employees.index');
    }

    public function create()
    {
        $departments = Departments::all();
        $designations = Designations::all();
        $genders = Lookup::where('type','=','gender')->get();
        $religions = Lookup::where('type','=','religion')->get();
        $marital_status = Lookup::where('type','=','marital_status')->get();
        $stores = Stores::all();
        $this->setPageTitle('Create Employees', 'Create new Employees');
        return view('Hr::employees.create', compact('departments', 'designations', 'genders','religions','marital_status','stores'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'f_name' => 'required',
            'full_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'marital_status' => 'required',
            'religion' => 'required',
            'contact_no' => 'required',
            'permanent_address' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:1000',
            'department_id' => 'required',
            'designation_id' => 'required',
            'join_date' => 'required',
            'cv_file' => 'mimes:doc,docx,pdf|max:3000'
        ]);
        $employee = new Employees();


        if ($req->hasFile('cv_file')) {
            $file = $req->file('cv_file');
            $path = 'public/uploads/employees/cv';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $employee->cv_file = $path . '/' . $file_name;
        }

        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $path = 'public/uploads/employees/picture';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            $employee->image = $path . '/' . $file_name;
        }

        $employee->f_name = $req->f_name;
        $employee->l_name = $req->l_name;
        $employee->full_name = $req->full_name;
        $employee->gender = $req->gender;
        $employee->dob = $req->dob;
        $employee->marital_status = $req->marital_status;
        $employee->religion = $req->religion;
        $employee->email = $req->email;
        $employee->contact_no = $req->contact_no;
        $employee->present_address = $req->present_address;
        $employee->permanent_address = $req->permanent_address;
        $employee->department_id = $req->department_id;
        $employee->designation_id = $req->designation_id;
        $employee->join_date = $req->join_date;
        $employee->appointment_date = $req->appointment_date;
        $employee->permanent_date = $req->permanent_date;
        $employee->skills = $req->skills;
        $employee->tin = $req->tin;
        $employee->bank_acc_no = $req->bank_acc_no;
        $employee->bank_name = $req->bank_name;
        $employee->store_id = $req->store_id;
        $employee->created_by = auth()->user()->id;
        $employee->updated_by = auth()->user()->id;


        if (!$employee->save()) {
            return $this->responseRedirectBack('Error occurred while creating Employee.', 'error', true, true);
        }
        else
        {
            return $this->responseRedirect('hr.employees.index', 'Employee added successfully', 'success', false, false);
        }
    }

    public function edit($id)
    {
        $employee = Employees::findOrFail($id);
        $departments = Departments::all();
        $designations = Designations::all();
        $genders = Lookup::where('type','=','gender')->get();
        $religions = Lookup::where('type','=','religion')->get();
        $marital_status = Lookup::where('type','=','marital_status')->get();
        $stores = Stores::all();
        $this->setPageTitle('Edit Employee', 'Edit a Employee');
        return view('Hr::employees.edit', compact('employee','departments', 'designations', 'genders','religions','marital_status','stores'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'f_name' => 'required',
            'full_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'marital_status' => 'required',
            'religion' => 'required',
            'contact_no' => 'required',
            'permanent_address' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:1000',
            'department_id' => 'required',
            'designation_id' => 'required',
            'join_date' => 'required',
            'cv_file' => 'mimes:doc,docx,pdf|max:3000'
        ]);
        $employee = Employees::findOrFail($id);


        if ($req->hasFile('cv_file')) {
            $file = $req->file('cv_file');
            $path = 'public/uploads/employees/cv';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            if (file_exists($employee->cv_file)) {
                unlink($employee->cv_file);
            }

            $employee->cv_file = $path . '/' . $file_name;
        }

        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $path = 'public/uploads/employees/picture';
            $file_name = time() . rand(00, 99) . '.' . $file->getClientOriginalName();
            $file->move($path, $file_name);
            if (file_exists($employee->image)) {
                unlink($employee->image);
            }

            $employee->image = $path . '/' . $file_name;
        }

        $employee->f_name = $req->f_name;
        $employee->l_name = $req->l_name;
        $employee->full_name = $req->full_name;
        $employee->gender = $req->gender;
        $employee->dob = $req->dob;
        $employee->marital_status = $req->marital_status;
        $employee->religion = $req->religion;
        $employee->email = $req->email;
        $employee->contact_no = $req->contact_no;
        $employee->present_address = $req->present_address;
        $employee->permanent_address = $req->permanent_address;
        $employee->department_id = $req->department_id;
        $employee->designation_id = $req->designation_id;
        $employee->join_date = $req->join_date;
        $employee->appointment_date = $req->appointment_date;
        $employee->permanent_date = $req->permanent_date;
        $employee->skills = $req->skills;
        $employee->tin = $req->tin;
        $employee->bank_acc_no = $req->bank_acc_no;
        $employee->bank_name = $req->bank_name;
        $employee->store_id = $req->store_id;
        $employee->updated_by = auth()->user()->id;

        if (!$employee->update()) {
            return $this->responseRedirectBack('Error occurred while editing Employee.', 'error', true, true);
        }
        else
        {
            return $this->responseRedirect('hr.employees.index', 'Employee updated successfully', 'success', false, false);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = Employees::find($id);
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

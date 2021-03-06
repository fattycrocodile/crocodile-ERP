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
    public $department;
    public $designation;
    public $lookup;
    public $model;
    public $stores;

    public function __construct(Employees $model)
    {
        $this->model = $model;
        $this->department = new Departments();
        $this->designation = new Designations();
        $this->lookup = new Lookup();
        $this->stores = new Stores();
    }

    public function index(EmployeesDataTable $dataTable)
    {
        $this->setPageTitle('Employees', 'List of Employees');
        return $dataTable->render('Hr::employees.index');
    }

    public function create()
    {
        $departments = Departments::all();
        $designations = Designations::all();
        $genders = Lookup::where('type', '=', 'gender')->get();
        $religions = Lookup::where('type', '=', 'religion')->get();
        $marital_status = Lookup::where('type', '=', 'marital_status')->get();
        $stores = Stores::all();
        $this->setPageTitle('Create Employees', 'Create new Employees');
        return view('Hr::employees.create', compact('departments', 'designations', 'genders', 'religions', 'marital_status', 'stores'));
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
        } else {
            return $this->responseRedirect('hr.employees.index', 'Employee added successfully', 'success', false, false);
        }
    }

    public function edit($id)
    {
        $employee = Employees::findOrFail($id);
        $departments = Departments::all();
        $designations = Designations::all();
        $genders = Lookup::where('type', '=', 'gender')->get();
        $religions = Lookup::where('type', '=', 'religion')->get();
        $marital_status = Lookup::where('type', '=', 'marital_status')->get();
        $stores = Stores::all();
        $this->setPageTitle('Edit Employee', 'Edit a Employee');
        return view('Hr::employees.edit', compact('employee', 'departments', 'designations', 'genders', 'religions', 'marital_status', 'stores'));
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
        } else {
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


    public function getEmployeesListByName(Request $request): ?JsonResponse
    {
        $response = array();
        if ($request->has('search')) {
            $search = trim($request->search);
            $data = new Employees();
            $data = $data->select('id', 'full_name', 'designation_id', 'department_id');
            if ($search != '') {
                $data = $data->where('full_name', 'like', '%' . $search . '%');
            }
            if ($request->has('department_id')) {
                $designation_id = trim($request->designation_id);
                if ($designation_id > 0) {
                    $data = $data->where('designation_id', '=', $designation_id);
                }
            }
            if ($request->has('department_id')) {
                $department_id = trim($request->department_id);
                if ($department_id > 0) {
                    $data = $data->where('department_id', '=', $department_id);
                }
            }
            $data = $data->limit(20);
            $data = $data->orderby('full_name', 'asc');
            $data = $data->get();
            if (!$data->isEmpty()) {
                foreach ($data as $dt) {
                    $response[] = array(
                        "value" => $dt->id,
                        "label" => $dt->full_name,
                        "designation_id" => $dt->designation_id,
                        "department_id" => $dt->department_id,
                        'designation' => isset($dt->designation->name) ? $dt->designation->name : '',
                        'department' => isset($dt->department->name) ? $dt->department->name : '',
                    );
                }
            } else {
                $response[] = array("value" => '', "label" => 'No data found!', 'designation' => '', 'department_id' => '', 'department' => '');
            }
        } else {
            $response[] = array("value" => '', "label" => 'No data found!', "designation" => '', 'department_id' => '', 'department' => '');
        }
        return response()->json($response);
    }

    public function employeesReport()
    {
        $stores = $this->stores->treeList();
        $department = $this->department->treeList();
        $designation = $this->designation->treeList();
        $genders = Lookup::items('gender');
        $religions = Lookup::items('religion');
        $marital_status = Lookup::items('marital_status');
        $this->setPageTitle('Employees Report', 'Employees Report');
        return view('Hr::employees.employees-report', compact('stores', 'department', 'designation', 'genders', 'religions', 'marital_status'));
    }

    public function employeesReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = new Employees();
        if ($request->has('store_id')) {
            $store_id = $request->store_id;
            if ($store_id > 0)
                $data = $data->where('store_id', '=', $store_id);
        }
        if ($request->has('store_id')) {
            $store_id = $request->store_id;
            if ($store_id > 0)
                $data = $data->where('store_id', '=', $store_id);
        }
        if ($request->has('department_id')) {
            $department_id = $request->department_id;
            if ($department_id > 0)
                $data = $data->where('department_id', '=', $department_id);
        }
        if ($request->has('designation_id')) {
            $designation_id = $request->designation_id;
            if ($designation_id > 0)
                $data = $data->where('designation_id', '=', $designation_id);
        }
        if ($request->has('gender_id')) {
            $gender_id = $request->gender_id;
            if ($gender_id > 0)
                $data = $data->where('gender_id', '=', $gender_id);
        }
        if ($request->has('religion_id')) {
            $religion_id = $request->religion_id;
            if ($religion_id > 0)
                $data = $data->where('religion_id', '=', $religion_id);
        }
        if ($request->has('marital_status')) {
            $marital_status = $request->marital_status;
            if ($marital_status > 0)
                $data = $data->where('marital_status', '=', $marital_status);
        }
        if ($request->has('status')) {
            $status = $request->status;
            if ($status != "")
                $data = $data->where('status', '=', $status);
        }
        if ($request->has('full_name')) {
            $full_name = trim($request->full_name);
            if ($full_name != "")
                $data = $data->where('full_name', 'like', '%' . $full_name . '%');
        }
        if ($request->has('contact_no')) {
            $contact_no = trim($request->contact_no);
            if ($contact_no != "")
                $data = $data->where('contact_no', 'like', '%' . $contact_no . '%');
        }

        $data = $data->orderby('full_name', 'asc');
        $data = $data->get();

        $returnHTML = view('Hr::employees.employees-report-view', compact('data'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}

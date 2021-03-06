<?php

namespace App\Modules\Hr\Http\Controllers;

use App\DataTables\SalarySetupDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Config\Models\Lookup;
use App\Modules\Hr\Models\Departments;
use App\Modules\Hr\Models\Designations;
use App\Modules\Hr\Models\Employees;
use App\Modules\Hr\Models\SalarySetup;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SalarySetupController extends BaseController
{
    public $model;
    public $lookup;
    public $department;
    public $designation;
    public $employee;

    public function __construct(SalarySetup $model)
    {
        $this->model = $model;
        $this->lookup = new Lookup();
        $this->department = new Departments();
        $this->designation = new Designations();
        $this->employee = new Employees();
    }

    /**
     * @param SalarySetupDataTable $dataTable
     * @return Factory|View
     */
    public function index(SalarySetupDataTable $dataTable)
    {
        $this->setPageTitle('Salary Setup', 'List of all salary configuration');
        return $dataTable->render('Hr::salary-setup.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $departments = $this->department->treeList();
        $designations = $this->designation->treeList();
        $this->setPageTitle('Salary Entry', 'Salary Entry');
        return view('Hr::salary-setup.create', compact('departments', 'designations'));
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'effective_date' => 'required|date',
            'salary' => 'required|array',
        ]);
        $params = $request->except('_token');
        try {
            $year = date('y');
            $effective_date = $params['effective_date'];
            $i = 0;
            foreach ($params['salary']['employee_id'] as $employee_id) {
                $department_id = $params['salary']['department_id'][$i];
                $designation_id = $params['salary']['designation_id'][$i];
                $basic_amount = $params['salary']['basic_amount'][$i];
                $home_allowance = $params['salary']['home_allowance'][$i];
                $medical_allowance = $params['salary']['medical_allowance'][$i];
                $ta = $params['salary']['ta'][$i];
                $da = $params['salary']['da'][$i];
                $other_allowances = $params['salary']['other_allowances'][$i];
                $total_salary = $params['salary']['total_salary'][$i];

                if ($total_salary > 0) {
                    $model = new SalarySetup();
                    $model->employee_id = $employee_id;
                    $model->department_id = $department_id;
                    $model->designation_id = $designation_id;
                    $model->effective_date = $effective_date;
                    $model->basic_amount = $basic_amount;
                    $model->home_allowance = $home_allowance;
                    $model->medical_allowance = $medical_allowance;
                    $model->ta = $ta;
                    $model->da = $da;
                    $model->other_allowances = $other_allowances;
                    $model->total_amount = $total_salary;
                    $model->created_by = auth()->user()->id;
                    $model->save();
                }
                $i++;
            }
            return $this->responseJson(false, 200, "Salary Saved Successfully!");
        } catch (QueryException $exception) {
//            throw new InvalidArgumentException($exception->getMessage());
            return $this->responseJson(true, 200, "Server problem!");
        }
        return $this->responseJson(true, 200, "Please try again!");
//        return $this->responseJson(true, 200, "Something is wrong", $validator->errors()->all());
    }

    public function edit($id)
    {
        $data = SalarySetup::findOrFail($id);
        $this->setPageTitle('Edit Salary', 'Edit a salary');
        return view('Hr::salary-setup.edit', compact('data'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'effective_date' => 'required|date',
            'total_salary' => 'required|min:1'
        ]);
        $model = SalarySetup::findOrFail($id);
        $model->effective_date = $req->effective_date;
        $model->basic_amount = $req->basic_amount;
        $model->home_allowance = $req->home_allowance;
        $model->medical_allowance = $req->medical_allowance;
        $model->ta = $req->ta;
        $model->da = $req->da;
        $model->other_allowances = $req->other_allowances;
        $model->total_amount = $req->total_salary;
        $model->updated_by = auth()->user()->id;

        if (!$model->update()) {
            return $this->responseRedirectBack('Error occurred while Editing salary.', 'error', true, true);
        }
        return $this->responseRedirect('hr.salary.index', 'Salary Updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = SalarySetup::find($id);
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


    public function getEmployeesListForSalary(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        $effective_date = $request->effective_date;
        if ($effective_date != "") {
            $data = new Employees();
            $data = $data->select('id', 'full_name', 'designation_id', 'department_id');
            if ($request->has('department_id')) {
                $department_id = trim($request->department_id);
                if ($department_id > 0)
                    $data = $data->where('department_id', '=', $department_id);
            }
            if ($request->has('designation_id')) {
                $designation_id = trim($request->designation_id);
                if ($designation_id > 0)
                    $data = $data->where('designation_id', '=', $designation_id);
            }
            if ($request->has('employee_id')) {
                $employee_id = trim($request->employee_id);
                if ($employee_id > 0)
                    $data = $data->where('id', '=', $employee_id);
            }
            $data = $data->where('status', '=', Employees::ACTIVE);
            $data = $data->orderby('full_name', 'asc');
            $data = $data->get();

            $returnHTML = view('Hr::salary-setup.employee-salary-entry', compact('data', 'effective_date'))->render();
            return $this->responseJson(false, 200, "DATA FOUND", $returnHTML);
        } else {
            return $this->responseJson(true, 200, "DATA NOT FOUND");
        }
    }
}

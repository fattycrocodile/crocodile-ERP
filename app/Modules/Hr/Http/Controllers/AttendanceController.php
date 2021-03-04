<?php

namespace App\Modules\Hr\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Config\Models\Lookup;
use App\Modules\Hr\Models\Attendance;
use App\Modules\Hr\Models\Departments;
use App\Modules\Hr\Models\Designations;
use App\Modules\Hr\Models\Employees;
use App\Traits\UploadAble;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;
use Validator;

class AttendanceController extends BaseController
{
    use UploadAble;

    public $model;
    public $lookup;
    public $department;
    public $designation;

    public function __construct(Attendance $model)
    {
        $this->model = $model;
        $this->lookup = new Lookup();
        $this->department = new Departments();
        $this->designation = new Designations();
    }

    /**
     * @param AttendanceDataTable $dataTable
     * @return Factory|View
     */
    public function index(AttendanceDataTable $dataTable)
    {
        $this->setPageTitle('Attendance', 'List of all Attendance');
        return $dataTable->render('Hr::attendance.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $departments = $this->department->treeList();
        $designations = $this->designation->treeList();
        $this->setPageTitle('Attendance Entry', 'Attendance Entry');
        return view('Hr::attendance.create', compact('departments', 'designations'));
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws Throwable|Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);
        $params = $request->except('_token');
        try {
            $year = date('y');
            $date = $params['date'];
            $i = 0;
            foreach ($params['attendance']['employee_id'] as $employee_id) {
                $in_time = $params['attendance']['in_time'][$i];
                $out_time = $params['attendance']['out_time'][$i];
                $remarks = $params['attendance']['remarks'][$i];

                if ($in_time != "") {
//                    echo $in_time;
                    $model = Attendance::where('employee_id', '=', $employee_id)->where('date', '=', $date)->first();
                    if (!$model)
                        $model = new Attendance();
                    else
                        $model->updated_by = auth()->user()->id;
                    $model->employee_id = $employee_id;
                    $model->date = $date;
                    $model->in_time = $in_time;
                    $model->out_time = $out_time;
                    $model->comments = $remarks;
                    $model->created_by = auth()->user()->id;
                    $model->save();
                }
                $i++;
            }
            return $this->responseJson(false, 200, "Attendance Saved Successfully!");
        } catch (QueryException $exception) {
//            throw new InvalidArgumentException($exception->getMessage());
            return $this->responseJson(true, 200, "Server problem!");
        }
        return $this->responseJson(true, 200, "Please try again!");
//        return $this->responseJson(true, 200, "Something is wrong", $validator->errors()->all());
    }


    public function getEmployeesListForAttendance(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        $date = $request->date;
        if ($date != "") {
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

            $returnHTML = view('Hr::Attendance.employee-attendance-entry', compact('data', 'date'))->render();
            return $this->responseJson(false, 200, "DATA FOUND", $returnHTML);
        } else {
            return $this->responseJson(true, 200, "DATA NOT FOUND");
        }
    }
}

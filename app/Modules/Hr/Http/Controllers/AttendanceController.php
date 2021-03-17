<?php

namespace App\Modules\Hr\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Config\Models\Lookup;
use App\Modules\Hr\Models\Attendance;
use App\Modules\Hr\Models\Departments;
use App\Modules\Hr\Models\Designations;
use App\Modules\Hr\Models\Employees;
use App\Modules\StoreInventory\Models\Stores;
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
    public $stores;

    public function __construct(Attendance $model)
    {
        $this->middleware('permission:attendance.index|attendance.create|attendance.edit|attendance.delete|attendance.report', ['only' => ['index','show']]);
        $this->middleware('permission:attendance.create', ['only' => ['create','store']]);
        $this->middleware('permission:attendance.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:attendance.delete', ['only' => ['delete']]);
        $this->middleware('permission:attendance.report', ['only' => ['attendanceReport','attendanceReportView']]);

        $this->model = $model;
        $this->lookup = new Lookup();
        $this->department = new Departments();
        $this->designation = new Designations();
        $this->stores = new Stores();
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

    public function attendanceReport()
    {
        $stores = $this->stores->treeList();
        $department = $this->department->treeList();
        $designation = $this->designation->treeList();
        $genders = Lookup::items('gender');
        $religions = Lookup::items('religion');
        $marital_status = Lookup::items('marital_status');
        $this->setPageTitle('Employees Attendance Report', 'Employees Attendance Report');
        return view('Hr::attendance.attendance-report', compact('stores', 'department', 'designation', 'genders', 'religions', 'marital_status'));
    }

    public function attendanceReportView(Request $request): ?JsonResponse
    {
        $response = array();
        $data = NULL;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = trim($request->start_date);
            $end_date = trim($request->end_date);
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

            $data = $data->orderby('join_date', 'asc');
            $data = $data->get();
        }

        $returnHTML = view('Hr::attendance.attendance-report-view', compact('data','start_date', 'end_date'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}

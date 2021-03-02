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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
            $data = $data->where('status', '=', Employees::ACTIVE);
            $data = $data->orderby('full_name', 'asc');
            $data = $data->get();

            $returnHTML = view('Hr::Attendance.employee-attendance-entry', compact('data', 'date'))->render();
            return $this->responseJson(false, 200, "DATA FOUND", $returnHTML);
        } else{
            return $this->responseJson(true, 200, "DATA NOT FOUND");
        }
    }
}

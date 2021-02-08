<?php

namespace App\Modules\Hr\Http\Controllers;

use App\DataTables\LeaveApplicationsDataTable;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Carbon;
use App\Modules\Hr\Models\Employees;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveApplicationController extends BaseController
{
    public function index(LeaveApplicationsDataTable $dataTable)
    {
        $this->setPageTitle('Leave Applications','List of Leave Applications');
        return $dataTable->render('Hr::leave.index');
    }

    public function create()
    {
        $this->setPageTitle('Apply for Leave','Apply for Leaves');
        return view('Hr::leave.create');
    }

    public function store(Request $req)
    {
        $req->validate([
           'employee_id' =>'required',
            'from_date' =>'required',
            'to_date' => 'required',
            'subject' =>'required',
        ]);

        $fdate = new \DateTime($req->from_date);
        $todate = Carbon::parse($req->to_date)->addDays(1);
        $tdate = $todate;

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($fdate, $interval, $tdate);

        foreach ($period as $dt) {
            echo $date = $dt->format("Y-m-d");
        }
    }
}

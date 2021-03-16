<?php

namespace App\Modules\Hr\Http\Controllers;

use App\DataTables\LeaveApplicationsDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Hr\Models\LeaveApplication;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use App\Modules\Hr\Models\Employees;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $leave = new LeaveApplication();
        $sl_no = $leave->maxLeaveNo();

        $leave->sl_no = "LV-" . str_pad($sl_no, 4, '0', STR_PAD_LEFT);
        $leave->employee_id = $req->employee_id;
        $leave->from_date = $req->from_date;
        $leave->to_date = $req->to_date;
        $leave->subject = $req->subject;
        $leave->description = $req->description;
        $leave->application_date = date('Y-m-d');
        $leave->status = 0;
        $leave->leave_date = $req->from_date;
        $leave->created_by = auth()->user()->id;
        $leave->updated_by = auth()->user()->id;


        try {
                if($leave->save())
                {
                    return $this->responseRedirect('hr.leaves.index', 'Leave Application Submitted successfully', 'success', false, false);
                }
                else{
                    return $this->responseRedirectBack('Error occurred while submitting Leave Application.', 'error', true, true);
                }
        }
        catch (QueryException $exception)
        {
            //return $exception;
            return $this->responseRedirectBack('Error occurred while submitting Leave Application.', 'error', true, true);
        }
    }

    public function edit($id)
    {
        $this->setPageTitle('Edit Leave','Edit selected leave');
        $leave = LeaveApplication::find($id);
        return view('Hr::leave.edit',compact('leave'));
    }

    public function update(Request $req,$id)
    {
        $req->validate([
            'employee_id' =>'required',
            'from_date' =>'required',
            'to_date' => 'required',
            'subject' =>'required',
        ]);

        $leave = LeaveApplication::find($id);
        $leave->employee_id = $req->employee_id;
        $leave->from_date = $req->from_date;
        $leave->to_date = $req->to_date;
        $leave->subject = $req->subject;
        $leave->description = $req->description;
        $leave->status = 0;
        $leave->leave_date = $req->from_date;
        $leave->updated_by = auth()->user()->id;


        try {
            if($leave->update())
            {
                return $this->responseRedirect('hr.leaves.index', 'Leave Application updated successfully', 'success', false, false);
            }
            else{
                return $this->responseRedirectBack('Error occurred while updating Leave Application.', 'error', true, true);
            }
        }
        catch (QueryException $exception)
        {
            return $exception;
            //return $this->responseRedirectBack('Error occurred while updating Leave Application.', 'error', true, true);
        }
    }

    public function approve(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            try {
                $leave = LeaveApplication::findOrFail($id);
                if ($leave->status != LeaveApplication::APPROVE) {

                    $leave->id = $id;
                    $leave->status = LeaveApplication::APPROVE;
                    $leave->updated_by = auth()->user()->id;
                    if ($leave->save()) {
                        return $this->responseJson(false, 200, "Leave Approved Successfully.");
                    } else {
                        return $this->responseJson(true, 200, "Please Try again");
                    }

                }

            } catch (QueryException $exception) {
                throw new InvalidArgumentException($exception->getMessage());
            }
        }
    }

    /*public function store(Request $req)
    {
        $req->validate([
           'employee_id' =>'required',
            'from_date' =>'required',
            'to_date' => 'required',
            'subject' =>'required',
        ]);

        $fdate = new \DateTime($req->from_date);
        $tdate = Carbon::parse($req->to_date)->addDays(1);

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($fdate, $interval, $tdate);
        $leaves = new LeaveApplication();
        $sl_no = $leaves->maxLeaveNo();

        try {
            foreach ($period as $dt) {
                $leave = new LeaveApplication();
                $leave->sl_no = "LV-" . str_pad($sl_no, 4, '0', STR_PAD_LEFT);
                $leave->employee_id = $req->employee_id;
                $leave->from_date = $req->from_date;
                $leave->to_date = $req->to_date;
                $leave->subject = $req->subject;
                $leave->description = $req->description;
                $leave->application_date = date('Y-m-d');
                $leave->status = 0;
                $date = $dt->format("Y-m-d");
                $leave->leave_date = $date;
                $leave->created_by = auth()->user()->id;
                $leave->updated_by = auth()->user()->id;
                $leave->save();
            }
            return $this->responseRedirect('hr.leaves.index', 'Leave Application Submitted successfully', 'success', false, false);
        }
        catch (QueryException $exception)
        {
            return $this->responseRedirectBack('Error occurred while submitting Leave Application.', 'error', true, true);
        }
    }*/
}

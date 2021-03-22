<?php

namespace App\Modules\Hr\Models;


use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class LeaveApplication extends Model
{
    protected $table = 'leave_applications';
    protected $guarded = [];

    const APPROVE = 1;
    const PENDING = 0;
    const DENY = 2;
    public function maxLeaveNo()
    {
        $model = DB::select(DB::raw('SELECT MAX(CONVERT(SUBSTRING_INDEX(sl_no,"-",-1),UNSIGNED INTEGER)) AS num FROM `leave_applications`'));
        return $model ? $model[0]->num + 1 : 1;
    }

    public static function findLeave($date, $employee_id)
    {
        $data = new LeaveApplication();
        $data = $data->where('from_date', '<=', $date);
        $data = $data->where('to_date', '>=', $date);
        $data = $data->where('employee_id', '=', $employee_id);
        $data = $data->where('status', '=', self::APPROVE);
        $data = $data->first();
        return $data ? 1 : 0;
    }

    public static function findApprovedLeave($stat_date,$end_date, $employee_id)
    {
        $data = DB::table('leave_applications');
        $data = $data->select(DB::raw('sum(DATEDIFF(to_date,from_date)+1) as day'))
                    ->where('from_date','>=',$stat_date)
                    ->where('to_date','<=',$end_date)
                    ->where('employee_id', '=', $employee_id)
                    ->where('status', '=', self::APPROVE)->first();
        $datafh = DB::table('leave_applications');
        $datafh = $datafh->select(DB::raw('sum(DATEDIFF(to_date,"'.$stat_date.'")+1) as day'))
            ->where('from_date','<',$stat_date)
            ->where('to_date','>=',$stat_date)
            ->where('to_date','<=',$end_date)
            ->where('employee_id', '=', $employee_id)
            ->where('status', '=', self::APPROVE)->first();

        $datalh = DB::table('leave_applications');
        $datalh = $datalh->select(DB::raw('sum(DATEDIFF(from_date,"'.$end_date.'")+1) as day'))
            ->where('from_date','>=',$stat_date)
            ->where('from_date','<=',$end_date)
            ->where('to_date','>',$end_date)
            ->where('employee_id', '=', $employee_id)
            ->where('status', '=', self::APPROVE)->first();

        return $data->day+$datafh->day+$datalh->day;
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }
}

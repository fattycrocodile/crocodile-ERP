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

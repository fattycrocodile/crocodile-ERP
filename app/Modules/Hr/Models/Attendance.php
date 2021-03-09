<?php

namespace App\Modules\Hr\Models;


use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $guarded=[];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public static function dailyAttendanceStatusOfEmployee($date, $employee_id){
        $data = new Attendance();
        $data = $data->where('date', '=', $date);
        $data = $data->where('employee_id', '=', $employee_id);
        $data = $data->first();
        return $data ? 1 : 0;
    }
}

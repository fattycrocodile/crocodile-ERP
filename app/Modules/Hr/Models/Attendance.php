<?php

namespace App\Modules\Hr\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }

    public static function dailyAttendanceStatusOfEmployee($date, $employee_id)
    {
        $data = new Attendance();
        $data = $data->where('date', '=', $date);
        $data = $data->where('employee_id', '=', $employee_id);
        $data = $data->first();
        return $data ? 1 : 0;
    }

    public static function totalAttendanceOfEmployeeInDateRange($dateFrom, $dateTo, $employee_id)
    {
        $data = new Attendance();
        $data = $data->select(DB::raw('count(*) as total'));
        $data = $data->where('date', '>=', $dateFrom);
        $data = $data->where('date', '<=', $dateTo);
        $data = $data->where('employee_id', '=', $employee_id);
        $data = $data->first();
        return $data ? $data->total : 0;
    }

    public static function totalAttendanceOfEmployeeInDate($date)
    {
        $data = new Attendance();
        $data = $data->select(DB::raw('count(*) as total'));
        $data = $data->where('date', '=', $date);
        $data = $data->first();
        return $data ? $data->total : 0;
    }
}

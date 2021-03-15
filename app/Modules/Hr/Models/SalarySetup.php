<?php

namespace App\Modules\Hr\Models;


use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalarySetup extends Model
{

    protected $table = 'salary_setups';
    protected $guarded = [];


    public static function getSalary($first_date, $employee_id)
    {
        $data = DB::table('salary_setups')
            ->where('effective_date', '<=', $first_date)
            ->where('employee_id', '=', $employee_id)
            ->orderByDesc('effective_date')
            ->first();
        if (!$data){
            $data = DB::table('salary_setups')
                ->where('effective_date', '>=', $first_date)
                ->where('employee_id', '=', $employee_id)
                ->orderBy('effective_date', 'asc')
                ->first();
        }
        $basic_amount = $data ? $data->basic_amount : 0;
        $home_allowance = $data ? $data->home_allowance : 0;
        $medical_allowance = $data ? $data->medical_allowance : 0;
        $ta = $data ? $data->ta : 0;
        $da = $data ? $data->da : 0;
        $other_allowances = $data ? $data->other_allowances : 0;
        $total_amount = $data ? $data->total_amount : 0;

        return [
            'basic_amount' => $basic_amount,
            'home_allowance' => $home_allowance,
            'medical_allowance' => $medical_allowance,
            'ta' => $ta,
            'da' => $da,
            'other_allowances' => $other_allowances,
            'total_amount' => $total_amount,
        ];
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designations::class, 'designation_id');
    }

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }
}

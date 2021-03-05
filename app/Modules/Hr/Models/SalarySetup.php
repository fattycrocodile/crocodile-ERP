<?php

namespace App\Modules\Hr\Models;


use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class SalarySetup extends Model
{

    protected $table = 'salary_setups';
    protected $guarded=[];

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

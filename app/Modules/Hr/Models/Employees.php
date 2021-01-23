<?php

namespace App\Modules\Hr\Models;


use App\Modules\StoreInventory\Models\Stores;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $guarded=[];

    public function department()
    {
        return $this->belongsTo(Departments::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designations::class);
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveApplication()
    {
        return $this->hasMany(LeaveApplication::class);
    }

    public function salarySetup()
    {
        return $this->hasMany(SalarySetup::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}

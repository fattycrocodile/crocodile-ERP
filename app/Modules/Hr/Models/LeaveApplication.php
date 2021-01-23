<?php

namespace App\Modules\Hr\Models;


use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    protected $guarded=[];

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

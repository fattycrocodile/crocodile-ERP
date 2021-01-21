<?php

namespace App\Model\Hr;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class SalarySetup extends Model
{
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
        return $this->belongsTo(Employees::class);
    }
}

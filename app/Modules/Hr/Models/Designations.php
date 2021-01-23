<?php

namespace App\Modules\Hr\Models;


use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Designations extends Model
{
    protected $guarded=[];

    public function employees()
    {
        return $this->hasMany(Employees::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Modules\Hr\Models;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';
    protected $guarded = [];


    const ACTIVE = 1;
    const INACTIVE = 0;

    public function treeList()
    {
        return Departments::orderByRaw('name ASC')
            ->get();
    }

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

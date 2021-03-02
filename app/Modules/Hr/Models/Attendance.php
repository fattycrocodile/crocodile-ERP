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
}

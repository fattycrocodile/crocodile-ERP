<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded=[];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }
}

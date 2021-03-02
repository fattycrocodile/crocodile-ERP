<?php

namespace App\Modules\Hr\Models;


use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeaveApplication extends Model
{
    protected $table = 'leave_applications';
    protected $guarded=[];

    public function maxLeaveNo()
    {
        $model= DB::select(DB::raw('SELECT MAX(CONVERT(SUBSTRING_INDEX(sl_no,"-",-1),UNSIGNED INTEGER)) AS num FROM `leave_applications`'));
        return $model? $model[0]->num + 1 : 1;
    }

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

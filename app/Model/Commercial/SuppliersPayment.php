<?php

namespace App\Model\Commercial;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class SuppliersPayment extends Model
{
    protected $guarded=[];

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    public function paymentBy()
    {
        return $this->belongsTo(User::class);
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

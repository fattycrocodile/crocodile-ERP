<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    protected $guarded=[];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function purchaseReturnDetails()
    {
        return $this->hasMany(PurchaseReturnDetails::class);
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

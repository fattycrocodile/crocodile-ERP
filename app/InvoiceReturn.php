<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceReturn extends Model
{
    protected $guarded=[];

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceReturnDetails()
    {
        return $this->hasMany(InvoiceReturnDetails::class);
    }
}

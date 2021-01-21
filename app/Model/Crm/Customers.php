<?php

namespace App\Model\Crm;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $guarded=[];

    public function sellOrders()
    {
        return $this->hasMany(SellOrder::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoiceReturn()
    {
        return $this->hasMany(InvoiceReturn::class);
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

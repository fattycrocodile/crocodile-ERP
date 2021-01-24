<?php

namespace App\Modules\Crm\Models;

use App\Model\User\User;
use App\Modules\StoreInventory\Models\Stores;
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

    public function store()
    {
        return $this->belongsTo(Stores::class);
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

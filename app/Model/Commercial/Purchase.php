<?php

namespace App\Model\Commercial;

use App\Model\Inventory\PurchaseReturn;
use App\Model\Inventory\ReceivePurchase;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded=[];

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function purchaseReturn()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function receivePurchase()
    {
        return $this->hasMany(ReceivePurchase::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function CreatedBy()
    {
        return $this->belongsTo(User::class);
    }
}

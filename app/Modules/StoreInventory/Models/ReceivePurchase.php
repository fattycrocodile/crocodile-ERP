<?php

namespace App\Modules\StoreInventory\Models;

use App\Model\Commercial\Purchase;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class ReceivePurchase extends Model
{
    protected $guarded=[];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function receivePurchaseDetails()
    {
        return $this->hasMany(ReceivePurchaseDetails::class);
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

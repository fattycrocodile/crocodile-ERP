<?php

namespace App\Model\Inventory;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class StoreTransfer extends Model
{
    protected $guarded=[];

    public function storeTransferDetails()
    {
        return $this->hasMany(StoreTransferDetails::class);
    }

    public function sendStore()
    {
        return $this->belongsTo(Stores::class);
    }

    public function receiveStore()
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

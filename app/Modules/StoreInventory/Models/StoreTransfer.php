<?php

namespace App\Modules\StoreInventory\Models;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class StoreTransfer extends Model
{
    protected $guarded=[];

    const IS_RECEIVED = 1;
    const IS_PENDING = 0;

    public function maxSlNo($store_id){

        $maxSn = $this->where('send_store_id','=',$store_id)->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public function storeTransferDetails()
    {
        return $this->hasMany(StoreTransferDetails::class,'transfer_id','id');
    }

    public function sendStore()
    {
        return $this->belongsTo(Stores::class);
    }

    public function receiveStore()
    {
        return $this->belongsTo(Stores::class,'rcv_store_id','id');
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

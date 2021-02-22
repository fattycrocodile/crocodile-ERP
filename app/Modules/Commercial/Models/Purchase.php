<?php

namespace App\Modules\Commercial\Models;

use App\Modules\StoreInventory\Models\PurchaseReturn;
use App\Modules\StoreInventory\Models\ReceivePurchase;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded=[];

    const PAID = 1;
    const NOT_PAID = 0;

    protected $table = 'purchases';

    public function maxSlNo(){

        $maxSn = $this->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

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

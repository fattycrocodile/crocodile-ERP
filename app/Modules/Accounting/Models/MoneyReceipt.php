<?php

namespace App\Modules\Accounting\Models;

use App\Model\User\User;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Database\Eloquent\Model;

class MoneyReceipt extends Model
{
    protected $table = 'money_receipts';
    protected $guarded = [];

    public function maxSlNo($store_id)
    {
        $maxSn = $this->where('store_id', '=', $store_id)->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }
}

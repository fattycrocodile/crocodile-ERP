<?php

namespace App\Modules\StoreInventory\Models;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class SellPrice extends Model
{

    protected $table = 'sell_prices';
    protected $guarded=[];

    const PRICE_ACTIVE = 1;
    const PRICE_INACTIVE = 0;

    public function product()
    {
        return $this->belongsTo(Product::class);
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

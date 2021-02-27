<?php

namespace App\Modules\StoreInventory\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTransferDetails extends Model
{
    protected $guarded=[];

    public $timestamps = false;

    public function storeTransfer()
    {
        return $this->belongsTo(Stores::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

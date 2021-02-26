<?php

namespace App\Modules\StoreInventory\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetails extends Model
{
    protected $guarded=[];
    public $timestamps = false;

    public function purchaseReturn()
    {
        return $this->belongsTo(PurchaseReturn::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

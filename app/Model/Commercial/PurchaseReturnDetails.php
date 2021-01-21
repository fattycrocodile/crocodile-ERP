<?php

namespace App\Model\Commercial;

use App\Model\Inventory\Product;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetails extends Model
{
    protected $guarded=[];

    public function purchaseReturn()
    {
        return $this->belongsTo(PurchaseReturn::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

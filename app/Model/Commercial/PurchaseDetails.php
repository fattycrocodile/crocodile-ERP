<?php

namespace App\Model\Commercial;

use App\Model\Inventory\Product;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    protected $guarded=[];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

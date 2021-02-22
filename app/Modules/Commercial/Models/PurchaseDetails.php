<?php

namespace App\Modules\Commercial\Models;

use App\Modules\StoreInventory\Models\Product;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    protected $guarded=[];
    public $timestamps = false;

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

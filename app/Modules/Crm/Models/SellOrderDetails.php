<?php

namespace App\Modules\Crm\Models;

use App\Modules\StoreInventory\Models\Product;
use Illuminate\Database\Eloquent\Model;

class SellOrderDetails extends Model
{

    protected $table = 'sell_order_details';
    protected $guarded=[];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(SellOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

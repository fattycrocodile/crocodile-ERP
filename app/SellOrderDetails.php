<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellOrderDetails extends Model
{
    protected $guarded=[];

    public function sellOrder()
    {
        return $this->belongsTo(SellOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

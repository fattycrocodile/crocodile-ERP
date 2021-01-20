<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivePurchaseDetails extends Model
{
    protected $guarded=[];

    public function receivePurchase()
    {
        return $this->belongsTo(ReceivePurchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

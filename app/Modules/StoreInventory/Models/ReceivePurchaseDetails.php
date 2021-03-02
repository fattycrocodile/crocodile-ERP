<?php

namespace App\Modules\StoreInventory\Models;

use Illuminate\Database\Eloquent\Model;

class ReceivePurchaseDetails extends Model
{
    protected $table = 'receive_purchase_details';
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

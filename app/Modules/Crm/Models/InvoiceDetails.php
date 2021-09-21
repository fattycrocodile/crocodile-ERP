<?php

namespace App\Modules\Crm\Models;

use App\Modules\StoreInventory\Models\Product;
use App\Model\User\User;
use App\Modules\StoreInventory\Models\Warranty;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $guarded=[];
    public $timestamps = false;

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }
}

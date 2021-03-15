<?php

namespace App\Modules\Commercial\Models;


use App\Modules\Accounting\Models\SuppliersPayment;
use App\Modules\StoreInventory\Models\PurchaseReturn;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Suppliers extends Model
{
    protected $table = 'suppliers';
    protected $guarded=[];

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }

    public function purchaseReturn()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function supplierPayment()
    {
        return $this->hasMany(SuppliersPayment::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}

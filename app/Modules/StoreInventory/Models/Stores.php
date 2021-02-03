<?php

namespace App\Modules\StoreInventory\Models;

use App\Model\Accounting\MoneyReceipt;
use App\Model\Commercial\PurchaseReturn;
use App\Model\Crm\Customers;
use App\Model\Crm\Invoice;
use App\Model\Crm\InvoiceReturn;
use App\Model\Crm\SellOrder;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $guarded=[];

    public function sellOrder()
    {
        return $this->hasMany(SellOrder::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function InvoiceReturn()
    {
        return $this->hasMany(InvoiceReturn::class);
    }

    public function customer()
    {
        return $this->hasMany(Customers::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function sendStore()
    {
        return $this->hasMany(StoreTransfer::class);
    }

    public function receiveStore()
    {
        return $this->hasMany(StoreTransfer::class);
    }

    public function purchaseReturn()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function moneyReceipt()
    {
        return $this->hasMany(MoneyReceipt::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}

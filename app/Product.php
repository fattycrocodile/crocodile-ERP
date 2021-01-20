<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded=[];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function storeTransferDetails()
    {
        return $this->hasMany(StoreTransferDetails::class);
    }

    public function sellPrice()
    {
        return $this->hasMany(SellPrice::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function receivePurchaseDetails()
    {
        return $this->hasMany(ReceivePurchaseDetails::class);
    }

    public function purchaseReturnDetails()
    {
        return $this->hasMany(PurchaseReturnDetails::class);
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetails::class);
    }

    public function sellOrderDetails()
    {
        return $this->hasMany(SellOrderDetails::class);
    }

    public function invoiceReturnDetails()
    {
        return $this->hasMany(InvoiceReturnDetails::class);
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

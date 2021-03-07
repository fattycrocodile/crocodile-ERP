<?php

namespace App\Modules\StoreInventory\Models;


use App\Model\User\User;
use App\Modules\Commercial\Models\PurchaseDetails;
use App\Modules\Crm\Models\InvoiceDetails;
use App\Modules\Crm\Models\InvoiceReturnDetails;
use App\Modules\Crm\Models\SellOrderDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = [];


    public static function totalProductCount()
    {
        $data = DB::table('products')
            ->select(DB::raw('count(*) as total'))->first();
        return $data ? $data->total : 0;
    }

    public static function productAvaragePrice($product_id)
    {
        $data = DB::table('products')
            ->select(DB::raw('avg_price'))->where('id','=',$product_id)->first();
        return $data ? $data->avg_price : 0;
    }

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
        return $this->hasMany(SellPrice::class)->orderBy('id', 'desc');
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

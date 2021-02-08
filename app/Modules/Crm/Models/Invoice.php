<?php

namespace App\Modules\Crm\Models;

use App\Modules\StoreInventory\Models\Stores;
use App\Model\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded=[];

    public function maxSlNo($store_no){

        $maxSn = $this->where('store_id', '=', $store_no)->max('max_sl_no');
        return $maxSn ? $maxSn->max_sl_no + 1 : 1;
    }
    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetails::class);
    }
}

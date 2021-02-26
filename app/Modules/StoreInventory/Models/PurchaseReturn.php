<?php

namespace App\Modules\StoreInventory\Models;


use App\Model\User\User;
use App\Modules\Commercial\Models\Purchase;
use App\Modules\Commercial\Models\Suppliers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PurchaseReturn extends Model
{
    protected $guarded=[];

    public function maxSlNo($supplier_id){

        $maxSn = $this->where('supplier_id','=',$supplier_id)->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public static function totalReturnAmountOfPurchase($invoice_id)
    {
        $data = DB::table('purchase_returns')
            ->select(DB::raw('sum(amount) as return_amount'))
            ->where('purchase_id', '=', $invoice_id)->first();
        return $data ? $data->return_amount : 0;
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function purchaseReturnDetails()
    {
        return $this->hasMany(PurchaseReturnDetails::class,'return_id');
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

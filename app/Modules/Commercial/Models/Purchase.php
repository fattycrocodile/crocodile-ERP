<?php

namespace App\Modules\Commercial\Models;

use App\Modules\Accounting\Models\SuppliersPayment;
use App\Modules\StoreInventory\Models\PurchaseReturn;
use App\Modules\StoreInventory\Models\ReceivePurchase;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{
    protected $table = 'purchases';
    protected $guarded=[];

    const PAID = 1;
    const NOT_PAID = 0;


    public function maxSlNo(){

        $maxSn = $this->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public static function totalPurchaseAmountOfSupplierUpTo($date, $supplier_id)
    {
        $data = DB::table('purchases')
            ->select(DB::raw('sum(grand_total) as grand_total'))
            ->where('date', '<=', $date)
            ->where('supplier_id', '=', $supplier_id)->first();
        return $data ? $data->grand_total : 0;
    }

    public static function monthlyPurchase($year, $month)
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0) {
            return 0;
        }else{
            $data = DB::table('purchases')
                ->select(DB::raw('sum(grand_total) as total'))
                ->whereYear('date', '=', $year)
                ->whereMonth('date', '=', $month)->first();
            return $data ? round($data->total, 2) : 0;
        }
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function supplierPayment()
    {
        return $this->hasMany(SuppliersPayment::class,'id','po_no');
    }

    public function purchaseReturn()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function receivePurchase()
    {
        return $this->hasMany(ReceivePurchase::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function CreatedBy()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Modules\Accounting\Models;

use App\Modules\Commercial\Models\Purchase;
use App\Modules\Commercial\Models\Suppliers;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuppliersPayment extends Model
{
    protected $table = 'suppliers_payments';
    protected $guarded = [];

    /**
     * @param $store_id
     * @return int
     */
    public function maxSlNo($supplier_id)
    {
        $maxSn = $this->where('supplier_id', '=', $supplier_id)->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public static function totalMrAmountOfInvoice($invoice_id)
    {
        $data = DB::table('suppliers_payments')
            ->select(DB::raw('sum(amount) as amount'), DB::raw('sum(discount) as discount'))
            ->where('po_no', '=', $invoice_id)->first();
        return $data ? $data->amount + $data->discount : 0;
    }

    public static function mrInfo($invoice_id)
    {
        $product = SuppliersPayment::query();
        $product->where('po_no', '=', $invoice_id);
        $product->orderBy('id', 'asc');
        $data = $product->first();
        return $data;
    }

    public static function totalPurchasePaymentAmountOfSupplierUpTo($date, $supplier_id)
    {
        $data = DB::table('suppliers_payments')
            ->select(DB::raw('sum(amount) as amount'))
            ->where('date', '<=', $date)
            ->where('supplier_id', '=', $supplier_id)->first();
        return $data ? $data->amount : 0;
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class,'po_no','id');
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    public function paymentBy()
    {
        return $this->belongsTo(User::class);
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

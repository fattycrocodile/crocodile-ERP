<?php

namespace App\Modules\Crm\Models;

use App\Model\User\User;
use App\Modules\Accounting\Models\MoneyReceipt;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{

    const PAID = 1;
    const NOT_PAID = 0;

    protected $table = 'invoices';
    protected $guarded=[];

    public function maxSlNo($store_no){
        $maxSn = $this->where('store_id', '=', $store_no)->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public static function totalInvoiceAmountOfCustomerUpTo($date, $customer_id)
    {
        $data = DB::table('invoices')
            ->select(DB::raw('sum(grand_total) as grand_total'))
            ->where('date', '<=', $date)
            ->where('customer_id', '=', $customer_id)->first();
        return $data ? $data->grand_total : 0;
    }

    public static function totalInvoiceCount()
    {
        $data = DB::table('invoices')
            ->select(DB::raw('count(*) as total'))->first();
        return $data ? $data->total : 0;
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

    public function moneyReceipt()
    {
        return $this->hasMany(MoneyReceipt::class, 'invoice_id');
    }
}

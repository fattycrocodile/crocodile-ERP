<?php

namespace App\Modules\Crm\Models;

use App\Model\User\User;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvoiceReturn extends Model
{
    protected $table = 'invoice_returns';
    protected $guarded = [];

    public function maxSlNo($store_id)
    {
        $maxSn = $this->where('store_id', '=', $store_id)->max('store_id');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public static function totalReturnAmountOfInvoice($invoice_id)
    {
        $data = DB::table('invoice_returns')
            ->select(DB::raw('sum(return_amount) as return_amount'))
            ->where('invoice_id', '=', $invoice_id)->first();
        return $data ? $data->return_amount : 0;
    }

    public static function totalInvoiceReturnAmountOfCustomerUpTo($date, $customer_id)
    {
        $data = DB::table('invoice_returns')
            ->select(DB::raw('sum(return_amount) as return_amount'))
            ->where('date', '<=', $date)
            ->where('customer_id', '=', $customer_id)->first();
        return $data ? $data->return_amount : 0;
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

    public function invoiceReturnDetails()
    {
        return $this->hasMany(InvoiceReturnDetails::class, 'return_id');
    }
}

<?php

namespace App\Modules\Accounting\Models;

use App\Model\User\User;
use App\Modules\Crm\Models\Customers;
use App\Modules\Crm\Models\Invoice;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Double;

class MoneyReceipt extends Model
{
    protected $table = 'money_receipts';
    protected $guarded = [];

    /**
     * @param $store_id
     * @return int
     */
    public function maxSlNo($store_id)
    {
        $maxSn = $this->where('store_id', '=', $store_id)->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public static function totalMrAmountOfInvoice($invoice_id)
    {
        $mr = new MoneyReceipt();
        $data = $mr->where('invoice_id', '=', $invoice_id)->sum('amount');
        return $data;
    }

    public static function totalMrWithDiscountOfInvoice($invoice_id)
    {
        $data = DB::table('money_receipts')
            ->select(DB::raw('sum(amount) as amount'), DB::raw('sum(discount) as discount'))
            ->where('invoice_id', '=', $invoice_id)->first();
        return $data ? $data->amount + $data->discount : 0;
    }

    public static function mrInfo($invoice_id)
    {
        $product = MoneyReceipt::query();
        $product->where('invoice_id', '=', $invoice_id);
        $product->orderBy('id', 'asc');
        $data = $product->first();
        return $data;
    }

    public function store(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Stores::class);
    }

    public function receivedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoice(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

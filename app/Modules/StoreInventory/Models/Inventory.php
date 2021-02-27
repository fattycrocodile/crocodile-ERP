<?php

namespace App\Modules\StoreInventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    const REF_INVOICE = 1;
    const REF_PURCHASE = 2;
    const REF_PURCHASE_RETURN = 3;
    const REF_INVOICE_RETURN = 4;

    protected $table = 'inventories';
    protected $guarded = [];

    /**
     * @param $product_id
     * @param null $store_id
     * @return double|mixed
     */
    public static function closingStockWithStore($product_id, $store_id)
    {
        $data = DB::table('inventories')
            ->select(DB::raw('sum(stock_in) as stock_in'), DB::raw('sum(stock_out) as stock_out'))
            ->where('product_id', '=', $product_id)
            ->where('store_id', '=', $store_id)
            ->first();
        return $data ? ($data->stock_in - $data->stock_out) : 0;
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

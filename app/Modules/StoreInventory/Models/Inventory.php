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
    const REF_STORE_TRANSFER = 5;
    const REF_STORE_TRANSFER_RECEIVE = 6;

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

    public static function closingStock($product_id)
    {
        $data = DB::table('inventories')
            ->select(DB::raw('sum(stock_in) as stock_in'), DB::raw('sum(stock_out) as stock_out'))
            ->where('product_id', '=', $product_id)
            ->first();
        return $data ? ($data->stock_in - $data->stock_out) : 0;
    }

    public static function closingStockToDate($product_id,$date)
    {
        $data = DB::table('inventories')
            ->select(DB::raw('sum(stock_in) as stock_in'), DB::raw('sum(stock_out) as stock_out'))
            ->where('product_id', '=', $product_id)
            ->where('date', '<', $date)
            ->first();
        return $data ? ($data->stock_in - $data->stock_out) : 0;
    }

    public static function closingStockOfDate($product_id,$date)
    {
        $data = DB::table('inventories')
            ->select(DB::raw('sum(stock_in) as stock_in'), DB::raw('sum(stock_out) as stock_out'))
            ->where('product_id', '=', $product_id)
            ->where('date', '=', $date)
            ->first();
        return $data ? ($data->stock_in - $data->stock_out) : 0;
    }

    public static function openingStockWithStore($date, $product_id, $store_id = NULL)
    {
        $data = DB::table('inventories');
        $data = $data->select(DB::raw('sum(stock_in) as stock_in'), DB::raw('sum(stock_out) as stock_out'));
        $data = $data->where('date', '<=', $date);
        $data = $data->where('product_id', '=', $product_id);
        if ($store_id > 0)
            $data = $data->where('store_id', '=', $store_id);
        $data = $data->first();
        return $data ? ($data->stock_in - $data->stock_out) : 0;
    }

    public static function stockInOutWithStore($start_date, $end_date, $product_id, $store_id = NULL)
    {
        $stock = ['stock_in' => 0, 'stock_out' => 0];
        $data = DB::table('inventories');
        $data = $data->select(DB::raw('sum(stock_in) as stock_in'), DB::raw('sum(stock_out) as stock_out'));
        $data = $data->where('date', '>=', $start_date);
        $data = $data->where('date', '<=', $end_date);
        $data = $data->where('product_id', '=', $product_id);
        if ($store_id > 0)
            $data = $data->where('store_id', '=', $store_id);
        $data = $data->first();
        $stock['stock_in'] = $data ? ($data->stock_in) : 0;
        $stock['stock_out'] = $data ? ($data->stock_out) : 0;
        return $stock;
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

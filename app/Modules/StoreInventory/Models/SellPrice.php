<?php

namespace App\Modules\StoreInventory\Models;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SellPrice extends Model
{

    protected $table = 'sell_prices';
    protected $guarded = [];

    const PRICE_ACTIVE = 1;
    const PRICE_INACTIVE = 0;

    /**
     * @param $product_id
     * @param null $store_id
     * @return double|mixed
     */
    public static function minimumWholeSellPrice($product_id)
    {
        $data = DB::table('sell_prices')
            ->select('min_whole_sell_price')
            ->where('product_id', '=', $product_id)
            ->where('status', '=', self::PRICE_ACTIVE)
            ->orderByRaw('date desc, id desc')
            ->first();
        return $data ? ($data->min_whole_sell_price) : 0;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
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

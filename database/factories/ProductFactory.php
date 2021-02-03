<?php

/** @var Factory $factory */

use App\Modules\StoreInventory\Models\Product;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Model;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {

    
    return [
        'name' => $faker->city,
        'category_id' => 2,
        'brand_id' => 1,
        'unit_id' => 1,
        'code' => "S01-". str_pad($faker->unique()->numberBetween(1, 1000), 3, '0', STR_PAD_LEFT),
        'min_stock_qty' => $faker->numberBetween($min = 1, $max = 10),
        'min_order_qty' => $faker->numberBetween($min = 500, $max = 1000),
        'status' => 1,
        'created_by' => 1,
        'description'=> $faker->paragraph($nb =8),
        'created_at' => Carbon::now()->toDateTimeString(),
    ];
});

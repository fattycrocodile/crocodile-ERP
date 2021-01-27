<?php

/** @var Factory $factory */

use App\Modules\StoreInventory\Models\Category;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Model;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'root_id' => 1,
        'created_at' => Carbon::now()->toDateTimeString(),
        'created_by' => 1,
    ];
});

<?php

/** @var Factory $factory */

use App\Modules\StoreInventory\Models\Brand;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Model;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'description' => $faker->sentence(5),
        'logo' => $faker->imageUrl(),
        'created_by' => 1,
        'created_at' => Carbon::now()->toDateTimeString(),
    ];
});

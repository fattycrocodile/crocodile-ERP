<?php

/** @var Factory $factory */

use App\Modules\StoreInventory\Models\Stores;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Model;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Stores::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'address' => $faker->address,
        'code' => $faker->randomAscii,
        'contact' => $faker->phoneNumber,
        'status' => 1,
        'created_by' => 1,
        'created_at' => Carbon::now()->toDateTimeString(),
    ];
});

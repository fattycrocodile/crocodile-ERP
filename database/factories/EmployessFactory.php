<?php

/** @var Factory $factory */

use App\Modules\Hr\Models\Employees;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Model;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Employees::class, function (Faker $faker) {
    return [
        'f_name' => $firstName = $faker->firstName,
        'l_name' => $lastName =  $faker->lastName,
        'full_name' => "$firstName $lastName",
        'gender' => \App\Modules\Config\Models\Lookup::GENDER_MALE,
        'dob' => $faker->date(),
        'join_date' => $faker->date(),
        'appointment_date' => $faker->date(),
        'permanent_date' => $faker->date(),
        'tin' => $faker->randomNumber(),
        'bank_acc_no' => $faker->bankAccountNumber,
        'bank_name' => $faker->name,
        'marital_status' => \App\Modules\Config\Models\Lookup::MARTIAL_MARRIED,
        'religion' => \App\Modules\Config\Models\Lookup::RELIGION_ISLAM,
        'email' => $faker->email,
        'contact_no' => $faker->phoneNumber,
        'present_address' => $faker->address,
        'permanent_address' => $faker->secondaryAddress,
        'department_id' => 4,
        'designation_id' => 4,
        'created_by' => 1,
        'status' => Employees::ACTIVE,
        'created_at' => Carbon::now()->toDateTimeString(),
    ];
});

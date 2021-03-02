<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Modules\Hr\Models\Departments::create(
            [
                'name' => 'ACCOUNTS',
                'status' => \App\Modules\Hr\Models\Departments::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Departments::create(
            [
                'name' => 'ADMIN',
                'status' => \App\Modules\Hr\Models\Departments::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Departments::create(
            [
                'name' => 'BOARD OF DIRECTORS',
                'status' => \App\Modules\Hr\Models\Departments::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Departments::create(
            [
                'name' => 'Business Development',
                'status' => \App\Modules\Hr\Models\Departments::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Departments::create(
            [
                'name' => 'COMMERCIAL',
                'status' => \App\Modules\Hr\Models\Departments::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Departments::create(
            [
                'name' => 'Computer Operator',
                'status' => \App\Modules\Hr\Models\Departments::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Departments::create(
            [
                'name' => 'IT',
                'status' => \App\Modules\Hr\Models\Departments::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Departments::create(
            [
                'name' => 'MARKETING',
                'status' => \App\Modules\Hr\Models\Departments::ACTIVE,
            ]
        );

        \App\Modules\Hr\Models\Departments::create(
            [
                'name' => 'Official',
                'status' => \App\Modules\Hr\Models\Departments::ACTIVE,
            ]
        );

    }
}

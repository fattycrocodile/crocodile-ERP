<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DesignationsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Modules\Hr\Models\Designations::create(
            [
                'name' => 'CHAIRMAN AND MD',
                'status' => \App\Modules\Hr\Models\Designations::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Designations::create(
            [
                'name' => 'DIRECTOR',
                'status' => \App\Modules\Hr\Models\Designations::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Designations::create(
            [
                'name' => 'ASSISTANT MANAGER',
                'status' => \App\Modules\Hr\Models\Designations::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Designations::create(
            [
                'name' => 'COMPUTER OPT.',
                'status' => \App\Modules\Hr\Models\Designations::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Designations::create(
            [
                'name' => 'DELIVERY MAN',
                'status' => \App\Modules\Hr\Models\Designations::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Designations::create(
            [
                'name' => 'Executive',
                'status' => \App\Modules\Hr\Models\Designations::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Designations::create(
            [
                'name' => 'JR.EXECUTIVE',
                'status' => \App\Modules\Hr\Models\Designations::ACTIVE,
            ]
        );
        \App\Modules\Hr\Models\Designations::create(
            [
                'name' => 'Office Assistant',
                'status' => \App\Modules\Hr\Models\Designations::ACTIVE,
            ]
        );

        \App\Modules\Hr\Models\Designations::create(
            [
                'name' => 'Senior Executive',
                'status' => \App\Modules\Hr\Models\Designations::ACTIVE,
            ]
        );

    }
}

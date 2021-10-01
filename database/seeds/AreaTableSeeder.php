<?php

use Illuminate\Database\Seeder;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Modules\SupplyChain\Models\Area::create(
            [
                'store_id' => '1',
                'name' => 'Dhaka',
                'code' => 'DHK',
                'address' => 'Dhaka'
            ]
        );
    }
}

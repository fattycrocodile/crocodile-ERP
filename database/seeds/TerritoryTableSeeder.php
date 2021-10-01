<?php

use Illuminate\Database\Seeder;

class TerritoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Modules\SupplyChain\Models\Territory::create(
            [
                'area_id' => '1',
                'name' => 'Dhaka',
                'code' => 'DHK',
                'address' => 'Dhaka'
            ]
        );
    }
}

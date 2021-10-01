<?php

use App\Modules\StoreInventory\Models\Unit;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Unit::create([
            'name'          =>  'pcs',
            'description'   =>  'Pcs',
        ]);

    }
}

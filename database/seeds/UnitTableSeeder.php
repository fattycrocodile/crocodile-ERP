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
            'name'          =>  'kg',
            'description'   =>  'Kilogram',
        ]);
        Unit::create([
            'name'          =>  'gm',
            'description'   =>  'Gram',
        ]);
        Unit::create([
            'name'          =>  'box',
            'description'   =>  'Box',
        ]);
        Unit::create([
            'name'          =>  'pcs',
            'description'   =>  'Pcs',
        ]);
        Unit::create([
            'name'          =>  'ounce',
            'description'   =>  'Ounce',
        ]);
        Unit::create([
            'name'          =>  'ltr',
            'description'   =>  'Ltr',
        ]);

    }
}

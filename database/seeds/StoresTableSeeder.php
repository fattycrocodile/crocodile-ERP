<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoresTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Modules\StoreInventory\Models\Stores::create(
            [
                'name' => 'Main Warehouse',
                'address' => 'root',
                'code' => '1',
                'contact' => '01740929512'
            ]
        );
        \App\Modules\StoreInventory\Models\Stores::create(
            [
                'name' => 'Store-A',
                'address' => 'root',
                'code' => 'ST-A',
                'contact' => '01701224682'
            ]
        );
        \App\Modules\StoreInventory\Models\Stores::create(
            [
                'name' => 'Store-B',
                'address' => 'root',
                'code' => 'ST-B',
                'contact' => '01701224682'
            ]
        );

        /*factory(\App\Modules\StoreInventory\Models\Stores::class, 5)->create()->each(function($stores){
            $stores->save();
        });*/
    }
}

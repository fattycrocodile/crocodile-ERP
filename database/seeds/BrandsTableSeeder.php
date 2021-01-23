<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('brands')->insert([
//            'name' => Str::random(10),
//            'description' => Str::random(50),
//            'logo' => Str::random(5),
//        ]);

        factory(\App\Modules\StoreInventory\Models\Brand::class, 100)->create()->each(function($brand){
            $brand->save();
        });
    }
}

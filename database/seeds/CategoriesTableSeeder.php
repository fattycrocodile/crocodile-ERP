<?php
use App\Modules\StoreInventory\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name'          =>  'Root',
//            'description'   =>  'This is the root category, don\'t delete this one',
            'root_id'     =>  null,
        ]);

        factory('App\Modules\StoreInventory\Models\Category', 100)->create();
    }
}

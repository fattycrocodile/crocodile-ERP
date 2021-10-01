<?php
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(LookupTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(DesignationsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(ChartOfAccounts::class);
        $this->call(AreaTableSeeder::class);
        $this->call(TerritoryTableSeeder::class);
        //$this->call(UserSeeder::class);
    }
}

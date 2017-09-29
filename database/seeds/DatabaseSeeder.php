<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run() {
        $this->call(CountriesTableSeeder::class);
        $this->call(BusinessCategorySeeder::class);
        $this->call(BillingSeeder::class);
        $this->call(DataTestSeeder::class);
        $this->call(UserSeeder::class);
    }
}

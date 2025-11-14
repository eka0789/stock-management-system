<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DivisionSeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
            StockTransactionSeeder::class,
            RequestSeeder::class,
            PurchaseOrderSeeder::class,
        ]);
    }
}

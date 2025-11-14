<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\StockTransaction;

class StockTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $items = Item::all();

        foreach ($items as $item) {

            // Transaksi masuk (restock)
            StockTransaction::create([
                'item_id' => $item->id,
                'type' => 'in',
                'quantity' => 20,
                'source' => 'Seeder - Initial Stock',
            ]);

            // Transaksi keluar (pemakaian)
            StockTransaction::create([
                'item_id' => $item->id,
                'type' => 'out',
                'quantity' => rand(3, 10),
                'source' => 'Seeder - Usage',
            ]);
        }
    }
}

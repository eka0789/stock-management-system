<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\StockItem;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'sku' => 'BR-COF-001',
                'name' => 'Arabica Coffee Beans',
                'unit' => 'kg',
                'min_stock' => 5,
                'cost_price' => 120000,
                'note' => 'Biji kopi arabika premium'
            ],
            [
                'sku' => 'BR-MIL-002',
                'name' => 'Fresh Milk',
                'unit' => 'liter',
                'min_stock' => 10,
                'cost_price' => 18000,
                'note' => 'Susu fresh 1L'
            ],
            [
                'sku' => 'KT-CHO-003',
                'name' => 'Chocolate Powder',
                'unit' => 'kg',
                'min_stock' => 3,
                'cost_price' => 75000,
                'note' => null
            ],
            [
                'sku' => 'KT-FLR-004',
                'name' => 'Flour',
                'unit' => 'kg',
                'min_stock' => 8,
                'cost_price' => 9000,
                'note' => 'Tepung terigu'
            ],
            [
                'sku' => 'KT-SGR-005',
                'name' => 'Sugar',
                'unit' => 'kg',
                'min_stock' => 10,
                'cost_price' => 15000,
                'note' => null
            ],
            [
                'sku' => 'KT-BTR-006',
                'name' => 'Butter',
                'unit' => 'kg',
                'min_stock' => 4,
                'cost_price' => 48000,
                'note' => null
            ],
            [
                'sku' => 'SR-CUP-007',
                'name' => 'Paper Cup 12oz',
                'unit' => 'pcs',
                'min_stock' => 100,
                'cost_price' => 1200,
                'note' => 'Cup kertas untuk hot drink'
            ],
            [
                'sku' => 'SR-STR-008',
                'name' => 'Straw',
                'unit' => 'pcs',
                'min_stock' => 200,
                'cost_price' => 200,
                'note' => null
            ]
        ];

        foreach ($items as $data) {
            // Insert item
            $item = Item::create($data);

            // Insert stock awal otomatis
            StockItem::create([
                'item_id' => $item->id,
                'quantity' => 20 // stok awal default
            ]);
        }
    }
}

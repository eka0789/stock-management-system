<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\User;
use App\Models\Item;
use App\Models\StockTransaction;
use App\Models\StockItem;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        $finance = User::where('role', 'finance')->first();
        $items   = Item::all();

        // Generate PO number
        $poNumber = 'PO-' . date('Ymd') . '-' . str_pad(rand(1,9999), 4, '0', STR_PAD_LEFT);

        // Buat PO dengan nomor otomatis
        $po = PurchaseOrder::create([
            'po_number'     => $poNumber,
            'user_id'       => $finance->id,
            'supplier_name' => 'PT Sumber Makmur',
            'total_price'   => 0,
            'status'        => 'received',
        ]);

        $total = 0;

        foreach ($items->random(3) as $item) {

            $qty   = rand(5, 15);
            $price = $item->cost_price * $qty;
            $total += $price;

            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'item_id'           => $item->id,
                'quantity'          => $qty,
                'price'             => $item->cost_price
            ]);

            // Tambah stok otomatis
            StockTransaction::create([
                'item_id'  => $item->id,
                'type'     => 'in',
                'quantity' => $qty,
                'source'   => 'PO #' . $po->id,
            ]);

            // Update stock_items
            $stock = StockItem::firstOrCreate(
                ['item_id' => $item->id],
                ['quantity' => 0]
            );

            $stock->quantity += $qty;
            $stock->save();
        }

        // Total price update
        $po->update(['total_price' => $total]);
    }
}

<?php
namespace App\Services;

use App\Models\Item;
use App\Models\StockItem;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService
{
    /**
     * Increase stock (IN)
     * @param Item|int $item
     * @param float $qty
     * @param array $meta ['ref_type','ref_id','user_id','note']
     * @return StockItem
     */
    public function increase($item, float $qty, array $meta = [])
    {
        return DB::transaction(function() use($item,$qty,$meta){
            $itemModel = $item instanceof Item ? $item : Item::findOrFail($item);

            // create transaction log
            StockTransaction::create([
                'item_id' => $itemModel->id,
                'qty' => $qty,
                'type' => 'IN',
                'reference_type' => $meta['ref_type'] ?? null,
                'reference_id' => $meta['ref_id'] ?? null,
                'user_id' => $meta['user_id'] ?? null,
                'note' => $meta['note'] ?? null,
            ]);

            // update snapshot
            $stock = StockItem::lockForUpdate()->firstOrCreate(
                ['item_id' => $itemModel->id],
                ['quantity' => 0]
            );

            $stock->quantity = $stock->quantity + $qty;
        $stock->save();
        if ($stock->quantity <= $itemModel->min_stock) {
            // notify admins & purchasing (role: admin, finance)
            $receivers = User::whereIn('role', ['admin','finance'])->get();
            if($receivers->isNotEmpty()) {
                Notification::send($receivers, new LowStockNotification(
                    $itemModel->id,
                    $itemModel->name,
                    $stock->quantity,
                    $itemModel->min_stock
                ));
            }
            // low stock check (hook) - if below min_stock, log or dispatch notification
            Log::info("Low stock alert: item {$itemModel->id} qty {$stock->quantity}");
            // dispatch notification job here if needed
        }

        return $stock;
    });
    }

    /**
     * Decrease stock (OUT)
     */
    public function decrease($item, float $qty, array $meta = [])
    {
        return DB::transaction(function() use($item,$qty,$meta){
            $itemModel = $item instanceof Item ? $item : Item::findOrFail($item);

            $stock = StockItem::lockForUpdate()->firstOrCreate(
                ['item_id' => $itemModel->id],
                ['quantity' => 0]
            );

            // optionally prevent negative stock (you can choose to allow)
            if ($stock->quantity < $qty) {
                throw new \Exception("Insufficient stock for item ID {$itemModel->id}");
            }

            StockTransaction::create([
                'item_id' => $itemModel->id,
                'qty' => $qty,
                'type' => 'OUT',
                'reference_type' => $meta['ref_type'] ?? null,
                'reference_id' => $meta['ref_id'] ?? null,
                'user_id' => $meta['user_id'] ?? null,
                'note' => $meta['note'] ?? null,
            ]);

            $stock->quantity = $stock->quantity - $qty;
            $stock->save();

            if ($stock->quantity <= $itemModel->min_stock) {
                Log::info("Low stock alert: item {$itemModel->id} qty {$stock->quantity}");
            }

            return $stock;
        });
    }

    /**
     * Manual adjust (can be IN or OUT)
     * $delta positive -> IN, negative -> OUT
     */
    public function adjust($item, float $delta, array $meta = [])
    {
        return $delta >= 0
            ? $this->increase($item, $delta, $meta)
            : $this->decrease($item, abs($delta), $meta);
    }
}

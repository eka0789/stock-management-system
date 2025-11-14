<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use App\Models\StockItem;
use App\Notifications\LowStockNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class CheckLowStock extends Command
{
    protected $signature = 'stock:check-low';
    protected $description = 'Check items with stock <= min_stock and notify admins/finance';

    public function handle()
    {
        $items = Item::with('stock')->get();

        $notifyList = [];

        foreach ($items as $item) {
            $qty = optional($item->stock)->quantity ?: 0;
            if ($item->min_stock > 0 && $qty <= $item->min_stock) {
                $notifyList[] = $item;
            }
        }

        if (count($notifyList) === 0) {
            $this->info('No low-stock items found.');
            return 0;
        }

        $receivers = User::whereIn('role', ['admin','finance'])->get();
        foreach ($notifyList as $it) {
            Notification::send($receivers, new LowStockNotification(
                $it->id,
                $it->name,
                optional($it->stock)->quantity ?: 0,
                $it->min_stock
            ));
        }

        $this->info('Low-stock notifications dispatched for '.count($notifyList).' items.');
        return 0;
    }
}

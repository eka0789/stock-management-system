<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class LowStockNotification extends Notification
{
    use Queueable;

    public $itemId;
    public $itemName;
    public $currentQty;
    public $minStock;

    public function __construct($itemId, $itemName, $currentQty, $minStock)
    {
        $this->itemId = $itemId;
        $this->itemName = $itemName;
        $this->currentQty = $currentQty;
        $this->minStock = $minStock;
    }

    public function via($notifiable)
    {
        // database channel; add mail if you want email notifications
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'low_stock',
            'item_id' => $this->itemId,
            'item_name' => $this->itemName,
            'current_qty' => (float)$this->currentQty,
            'min_stock' => (float)$this->minStock,
            'message' => "Stok item '{$this->itemName}' rendah: {$this->currentQty} <= {$this->minStock}"
        ];
    }

    // optional: toMail() if you want email alerts
}


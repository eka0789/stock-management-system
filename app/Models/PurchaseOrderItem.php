<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'purchase_order_id', 'item_id',
        'qty_requested','qty_ordered','qty_received','price'
    ];

    public function po() {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }
}

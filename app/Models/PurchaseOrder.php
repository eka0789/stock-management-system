<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'po_number', 'request_id', 'user_id',
        'status', 'supplier_name', 'supplier_contact', 'due_date','total_price'
    ];

    public function request() {
        return $this->belongsTo(Request::class);
    }

    public function items() {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function finance() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

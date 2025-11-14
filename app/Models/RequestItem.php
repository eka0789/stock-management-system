<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    protected $fillable = [
        'request_id', 'item_id', 'qty_requested', 'qty_approved', 'note'
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

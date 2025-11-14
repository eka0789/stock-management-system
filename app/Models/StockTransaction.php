<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = [
        'item_id','qty','type','reference_type','reference_id','user_id','note'
    ];

    public function item() { return $this->belongsTo(Item::class); }
    public function user() { return $this->belongsTo(\App\Models\User::class); }
}

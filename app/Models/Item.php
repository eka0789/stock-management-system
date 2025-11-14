<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'sku','name','unit','min_stock','cost_price','note'
    ];

    public function stock()
{
    return $this->hasOne(\App\Models\StockItem::class, 'item_id');
}

    public function transactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}

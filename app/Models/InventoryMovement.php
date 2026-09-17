<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

#[Fillable([
    'product_id',
    'type',
    'quantity',
    'notes',
])]
class InventoryMovement extends Model
{
    protected $table = 'inventory_movements';

    public function product(){
        return $this->belongsTo(Product::class);
    }
}

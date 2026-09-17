<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

#[Fillable([
    'product_id',
    'type',
    'quantity',
    'notes',
])]
class InventoryMovement extends Model
{
    use HasFactory;
    
    protected $table = 'inventory_movements';

    public function product(){
        return $this->belongsTo(Product::class);
    }
}

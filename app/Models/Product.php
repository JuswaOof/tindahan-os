<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Category;
use App\Models\InventoryMovement;

#[Fillable([
    'category_id',
    'name',
    'sku',
    'description',
    'unit',
])]
class Product extends Model
{
    protected $table = 'products';

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function inventoryMovements(){
        return $this->hasMany(InventoryMovement::class);
    }
}

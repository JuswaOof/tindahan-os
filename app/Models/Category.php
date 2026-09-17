<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Product;

#[Fillable(['name', 'description'])]
class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    public function products(){
        return $this->hasMany(Product::class);
    }
}

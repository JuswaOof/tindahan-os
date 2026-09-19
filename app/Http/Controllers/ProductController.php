<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with('category')->paginate(2);
        $categories = Category::select('id', 'name')->get();

        return Inertia::render('Products/Index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255', 
                'unique:products,name'
            ],
            'sku' => [
                'required', 
                'string', 
                'max:255', 
                'unique:products,sku'
            ],
            'unit' => [
                'required', 
                'string', 
                'max:255'
            ],
            'category_id' => [
                'required', 
                'exists:categories,id'
            ],
            'description' => [
                'nullable', 
                'string'
            ],
        ]);

        Product::create($validated);

        return redirect()->route('products.index');
    }

    public function update(Request $request, Product $product){
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:products,name,' . $product->id,
            ],
            'sku' => [
                'required',
                'string',
                'max:255',
                'unique:products,sku,' . $product->id,
            ],
            'unit' => [
                'required',
                'string',
                'max:255',
            ],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $product->update($validated);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product){
        if ($product->inventoryMovements()->exists()) {
            return back()->with(
                'error',
                'Cannot delete a product that has inventory history.'
            );
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }
}

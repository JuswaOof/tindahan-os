<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Joshua Salcedo',
            'email' => 'joshofficialxxx@gmail.com',
            'password' => 'Password123!',
        ]);

        $plasticware = Category::create([
            'name' => 'Plasticware',
            'description' => 'Plastic household products',
        ]);

        $flour = Category::create([
            'name' => 'Flour',
            'description' => 'Different types of flour',
        ]);

        $basin = Product::create([
            'category_id' => $plasticware->id,
            'name' => 'Plastic Basin 20L',
            'sku' => 'BASIN-20L',
            'description' => '20-liter plastic basin',
            'unit' => 'piece',
        ]);

        $pail = Product::create([
            'category_id' => $plasticware->id,
            'name' => 'Plastic Pail 10L',
            'sku' => 'PAIL-10L',
            'description' => '10-liter plastic pail',
            'unit' => 'piece',
        ]);

        $allPurposeFlour = Product::create([
            'category_id' => $flour->id,
            'name' => 'All-Purpose Flour',
            'sku' => 'FLOUR-AP-1KG',
            'description' => '1kg all-purpose flour',
            'unit' => 'bag',
        ]);

        $breadFlour = Product::create([
            'category_id' => $flour->id,
            'name' => 'Bread Flour',
            'sku' => 'FLOUR-BREAD-1KG',
            'description' => '1kg bread flour',
            'unit' => 'bag',
        ]);

        InventoryMovement::create([
            'product_id' => $basin->id,
            'type' => 'stock_in',
            'quantity' => 50,
            'notes' => 'Initial stock',
        ]);

        InventoryMovement::create([
            'product_id' => $pail->id,
            'type' => 'stock_in',
            'quantity' => 40,
            'notes' => 'Initial stock',
        ]);

        InventoryMovement::create([
            'product_id' => $allPurposeFlour->id,
            'type' => 'stock_in',
            'quantity' => 30,
            'notes' => 'Initial stock',
        ]);

        InventoryMovement::create([
            'product_id' => $breadFlour->id,
            'type' => 'stock_in',
            'quantity' => 25,
            'notes' => 'Initial stock',
        ]);
    }
}

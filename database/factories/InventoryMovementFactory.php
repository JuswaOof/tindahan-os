<?php

namespace Database\Factories;

use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryMovement>
 */
class InventoryMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'type' => fake()->randomElement([
                'stock_in',
                'stock_out',
                'adjustment',
            ]),
            'quantity' => fake()->numberBetween(1, 100),
            'notes' => fake()->sentence(),
        ];
    }
}
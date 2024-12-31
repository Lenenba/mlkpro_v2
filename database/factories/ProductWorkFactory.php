<?php

namespace Database\Factories;

use App\Models\Work;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class ProductWorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'work_id' => Work::factory(),
            'product_id' => Product::factory(),
            'quantity_used' => $this->faker->numberBetween(1, 100),
            'unit' => $this->faker->randomElement(['pcs', 'kg', 'litres']),
        ];
    }
}

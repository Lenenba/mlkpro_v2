<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Work;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(), // Génère une instance de Customer associée
            'user_id' => User::factory(), // Génère une instance de Work associée
            'work_id' => Work::factory(), // Génère une instance de Work associée
            'number' => $this->faker->unique()->numerify('INV-####'), // Exemple : INV-1234
            'status' => $this->faker->randomElement(['draft', 'pending', 'paid']), // Statuts possibles
            'total' => $this->faker->randomFloat(2, 100, 10000), // Total entre 100 et 10 000
            'deleted_at' => null, // Support pour soft deletes
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

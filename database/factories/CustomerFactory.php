<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Associez un utilisateur à chaque client
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zip' => $this->faker->postcode(),
            'company_name' => $this->faker->company(),
            'description' => $this->faker->company(),
            'logo' => $this->generateFakeCompanyLogo(),
            'header_image' => $this->faker->imageUrl(1500, 500),
        ];
    }

    /**
     * Generate a fake company logo URL using One API Pro Placeholder Image Generator.
     *
     * @return string
     */
    private function generateFakeCompanyLogo(): string
    {
        $bgColor = ltrim($this->faker->hexColor(), '#'); // Couleur d'arrière-plan aléatoire sans le '#'
        $text = strtoupper(substr($this->faker->company(), 0, 3)); // Premières 3 lettres du nom de l'entreprise
        $width = 150;
        $height = 150;

        return "https://api.oneapipro.com/images/placeholder?text={$text}&width={$width}&height={$height}&color={$bgColor}";
    }
}

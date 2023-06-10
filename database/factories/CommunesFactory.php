<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Communes>
 */
class CommunesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_com' => $this->faker->numberBetween(1,10),
            'id_reg' => $this->faker->numberBetween(1,10),
            'description' => $this->faker->city,
            'status' => $this->faker->randomElement(['A', 'I', 'trash']),
            //
        ];
    }
}

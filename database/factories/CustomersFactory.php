<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\customers>
 */
class CustomersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => $this->faker->numerify('########'),
            'id_com' => $this->faker->numberBetween(1,10),
            'id_reg' => $this->faker->numberBetween(1,10),
            'email' => $this->faker->email,
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->address,
            'date_reg' => $this->faker->date().' '.$this->faker->time(),
            'status' => $this->faker->randomElement(['A', 'I', 'trash']),
        ];
    }
}

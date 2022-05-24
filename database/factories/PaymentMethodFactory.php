<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        $numbers = [0, 1];

        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text($maxNbChars = 50),
            'status' => $this->faker->randomElement($numbers),
        ];
    }
}

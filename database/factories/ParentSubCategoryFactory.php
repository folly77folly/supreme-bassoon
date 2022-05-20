<?php

namespace Database\Factories;

use App\Models\ParentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ParentSubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            //
            'name' => $this->faker->unique()->firstName,
            'description' => $this->faker->text($maxNbChars = 200),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Gender;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChildrenProfile>
 */
class ChildrenProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $genderIds = Gender::get('id');
        
        return [
            'user_id' => function(){
                $uid = User::factory()->create();
                return $uid->id;
            },
            'full_name' => $this->faker->name(),
            'gender_id' => $this->faker->randomElement($genderIds),
            'age' => $this->faker->randomNumber(1,100),
            'phone_number' => $this->faker->numerify('####-###-####'),

        ];
    }
}

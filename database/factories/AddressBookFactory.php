<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\City;
use App\Models\State;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AddressBook>
 */
class AddressBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        $stateIds = State::get('id');
        $cityIds = City::get('id');
        $numbers = [0, 1];
        return [
            'user_id' => function(){
                $uid = User::factory()->create();
                return $uid->id;
            },
            'full_name' => $this->faker->name(),
            'phone_no' => $this->faker->numerify('####-###-####'),
            'address' => $this->faker->text($maxNbChars = 50),
            'city_id' => $this->faker->randomElement($cityIds),
            'state_id' => $this->faker->randomElement($stateIds),
            'is_primary' => $this->faker->randomElement($numbers),

        ];
    }
}

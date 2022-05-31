<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            //'
            'user_id' => function() {
                $allUsers = User::all();
                if($allUsers->count() == 0){
                    $user = User::factory()->create();
                    return $user->id;
                }
                $userIds =  User::get('id');
                return $this->faker->randomElement($userIds);
            },
            'product_id' => function(){
                $product = Product::factory()->create();
                return $product->id;
            },
            'quantity' => $this->faker->randomNumber(1,10),
            'vendor_id' => function(){
                $vendor = Vendor::factory()->create();
                return $vendor->id;
            },
            'status' => true,
        ];
    }
}

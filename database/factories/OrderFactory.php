<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\AddressBook;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use App\Models\PaymentMethod;
use App\Models\DeliveryStatus;
use App\Models\ChildrenProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        if(User::get()->count() == 0){
            User::factory()->create();
        }
        if(ChildrenProfile::get()->count() == 0){
            ChildrenProfile::factory()->create();
        }
        if(AddressBook::get()->count() == 0){
            AddressBook::factory()->create();
        }
        $userIds = User::get('id');
        $childrenIds = ChildrenProfile::get('id');
        $addressBookIds = AddressBook::get('id');
        $paymentMethodIds = PaymentMethod::get('id');
        $deliveryStatusIds = DeliveryStatus::get('id');
        $orderStatusIds = OrderStatus::get('id');
        return [
            //
            'user_id' => $this->faker->randomElement($userIds),
            'children_profile_id' => $this->faker->randomElement($childrenIds),
            'address_book_id' => $this->faker->randomElement($addressBookIds),
            'payment_method_id' => $this->faker->randomElement($paymentMethodIds),
            'delivery_status_id' => $this->faker->randomElement($deliveryStatusIds),
            'order_status_id' => $this->faker->randomElement($orderStatusIds),
            'total_price' => $this->faker->numberBetween(100, 4000),
            'shipping_price' => $this->faker->numberBetween(100, 300),
            'trans_id' => Str::random(10),
            'reference' => Str::random(10),
            'delivery_date' => now(),
            'paid' => true,
            'approved' => true,
        ];
    }
}

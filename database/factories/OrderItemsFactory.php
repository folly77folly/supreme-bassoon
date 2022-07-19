<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        if(Product::get()->count() == 0){
            Product::factory()->count(10)->create();
        }

        if(Vendor::get()->count() == 0){
            Vendor::factory()->create();
        }

        if(Order::get()->count() == 0){
            Order::factory()->count(10)->create();
        }
        $productIds = Product::get();
        $vendorIds = Vendor::get();
        $orderIds = Order::get();

        $order = $this->faker->randomElement($orderIds);
        $product = $this->faker->randomElement($productIds);
        $vendor = $this->faker->randomElement($vendorIds);
        $quantity = $this->faker->numberBetween(10, 40);
        return [
            //
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'product_id' => $product->id,
            'vendor_id' => $product->vendor_id,
            'unit_price' => $product->price,
            'quantity' => $quantity,
            'total_amount' => $product->price * $quantity,
            'total_discount' => $product->unitDiscount * $quantity,
            'total_price' => ($product->price * $quantity) - ($product->unitDiscount * $quantity),
        ];
    }
}

<?php

namespace Tests\Feature\Order;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\AddressBook;
use App\Models\PaymentMethod;
use App\Models\ChildrenProfile;
use App\Service\CheckoutService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_create_an_order()
    {
        // $order = Order::factory()->create();
        $order = Cart::factory()->create();
        $user = User::factory()->create();
        $cart = Cart::factory()->create(
            ['user_id' => $user->id]
        );
        $addressBook = AddressBook::factory()->create();
        $paymentMethod = PaymentMethod::first();
        $product = Product::factory()->create();
        $childrenProfile = ChildrenProfile::factory()->create();
        $quantity = rand(3,10);
        $amount = round(($quantity * floatVal($product->price)),2);
        $tx_ref = "1655519942845";
        // var_dump(gettype($amount));
        $data = [
            "payment_method_id" => $paymentMethod->id,
            "amount" => doubleVal($amount),
            "address_book_id" => $addressBook->id,
            "children_profile_id" => $childrenProfile->id,
            "product_id" => $product->id,
            "quantity" => $quantity,
            "trans_id" => str()->random(10),
            "reference" => $tx_ref, //str()->random(10),
            "type" => 2
        ];
        $newAmount = (new CheckoutService)->expectedPayment($data);
        $data['amount'] = $newAmount;
        $response = $this->withAuthentication($user)->postJson($this->user_url.'checkout', $data);
        // dd($response);
        $response->assertStatus(201);
    }

    public function test_that_the_schema_of_order()
    {
        $this->assertTrue(Schema::hasColumn('orders',
            'total_price'
        ), 
        true);
    }

    public function test_that_admin_can_update_delivery_status()
    {
        $order = Order::factory()->create();
        $data = [
            'delivery_status_id' => 1,
        ];
        $response = $this->withAuthentication()->putJson($this->admin_url.'order/'.$order->id, $data);
        $response->assertOk();
    }

    public function test_that_admin_can_see_all_orders(){
        $response = $this->withAuthentication()->getJson($this->admin_url.'order');
        $response->assertOk();
    }
}

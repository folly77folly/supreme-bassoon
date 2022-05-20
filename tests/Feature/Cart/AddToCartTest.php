<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddToCartTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_add_to_cart()
    {
        $product = $this->createProduct();
        $data = [
            "product_id" => $product->id,
            "quantity" => 2
        ];
        $response = $this->withAuthentication()->postJson($this->user_url.'cart', $data);
        $response->assertStatus(201);
    }

    public function test_that_i_can_edit_cart()
    {
        $cart = Cart::factory()->create();
        $data = [
            "quantity" => 2
        ];

        $response = $this->withAuthentication()->putJson($this->user_url.'cart/'.$cart->product_id, $data);
        $response->assertOk();
    }

    public function test_that_i_can_view_my_cart()
    {
        $cart = Cart::factory()->count(3)->create();
        $response = $this->withAuthentication()->getJson($this->user_url.'cart');
        $response->assertOk();
    }

    public function test_that_i_can_increase_and_decrease_cart()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(
            ['user_id' => $user->id]
        );
        $cartInserted = Cart::find($cart->id);
        $type = [0, 1];
        // dd($cart, $cart->product_id);
        $data = [
            "product_id" => $cartInserted->product_id,
            "quantity" => 2,
            "type" => $type[1]
        ];

        $response = $this->withAuthentication($user)->postJson($this->user_url.'cart-quantity-update', $data);
        $response->assertOk();
    }

    public function test_that_i_can_remove_items_from_cart()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(
            ['user_id' => $user->id]
        );
        $response = $this->withAuthentication($user)->deleteJson($this->user_url.'cart/'.$cart->product_id);
        
        $response->assertOk();
    }
}

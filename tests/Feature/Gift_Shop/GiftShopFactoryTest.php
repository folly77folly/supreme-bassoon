<?php

namespace Tests\Feature\Gift_Shop;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\GiftShop;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GiftShopFactoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_the_schema_of_gift_shop()
    {
        $this->assertTrue(Schema::hasColumn('gift_shops',
            'slug'
        ), 
        true);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_create_gift_shop()
    {
        $admin = Admin::factory()->create();
        $data = [
            "name" => "club",
            "description" => "A football club like manchester united and arsenal",
        ];
        $response = $this->withAuthentication($admin)->postJson($this->admin_url.'gift-shop', $data);
        
        $response->assertStatus(201);
    }

    public function test_that_i_can_edit_gift_shop()
    {
        $admin = Admin::factory()->create();
        $giftShop = GiftShop::factory()->create();
        $data = [
            "name" => "Love",
            "description" => "All clubs are rich"
        ];
        $response = $this->withAuthentication($admin)->putJson($this->admin_url.'gift-shop/'.$giftShop->id, $data);
        
        $response->assertOk()
        ->assertJson([
            'data' => $data,
        ]);
    }

    public function test_that_i_can_view_gift_shop()
    {
        $giftShop = GiftShop::factory()->create();
        $response = $this->withAdminAuthentication()->getJson($this->admin_url.'gift-shop/'.$giftShop->id);
        
        $response->assertOk();
    }

    public function test_that_i_can_view_all_gift_shop()
    {
        $giftShop = GiftShop::factory()->create();
        $response = $this->withAdminAuthentication()->getJson($this->admin_url.'gift-shop');
        
        $response->assertOk();
    }

    public function test_that_i_can_delete_gift_shop()
    {
        $giftShop = GiftShop::factory()->create();
        $response = $this->withAdminAuthentication()->deleteJson($this->admin_url.'gift-shop/'.$giftShop->id);
        
        $response->assertOk();
    }
}

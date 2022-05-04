<?php

namespace Tests\Feature\Product_Category;

use Tests\TestCase;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_create_product_category()
    {
        $data = [
            "name" => "club",
            "description" => "A football club like manchester united and arsenal"
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson($this->admin_url.'product-category', $data);
        
        $response->assertStatus(201);
    }

    public function test_that_i_can_edit_product_category()
    {
        $productCategory = ProductCategory::factory()->create();
        $data = [
            "name" => "Love",
            "description" => "All clubs are rich"
        ];
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->putJson($this->admin_url.'product-category/'.$productCategory->id, $data);
        
        $response->assertOk()
        ->assertJson([
            'data' => $data,
        ]);
    }

    public function test_that_i_can_view_product_category()
    {
        $productCategory = ProductCategory::factory()->create();
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->getJson($this->admin_url.'product-category/'.$productCategory->id);
        
        $response->assertOk();
    }

    public function test_that_i_can_view_all_product_category()
    {
        $productCategory = ProductCategory::factory()->create();
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->getJson($this->admin_url.'product-category');
        
        $response->assertOk();
    }

    public function test_that_i_can_view_delete_product_category()
    {
        $productCategory = ProductCategory::factory()->create();
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->deleteJson($this->admin_url.'product-category/'.$productCategory->id);
        
        $response->assertOk();
    }
}

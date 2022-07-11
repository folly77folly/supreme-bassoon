<?php

namespace Tests\Feature\Product;

use Tests\TestCase;
use App\Models\Product;
use App\Models\ParentCategory;
use App\Models\ProductCategory;
use App\Models\ParentSubCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_the_schema_of_products()
    {
        $this->assertTrue(Schema::hasColumn('products',
            'name'
        ), 
        true);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_create_product()
    {
        $product = ProductCategory::factory()
                    ->has(ParentCategory::factory()
                    ->has(ParentSubCategory::factory()))
                    ->create();

        $parentSubCategory = ParentSubCategory::first()->id;

        $data = [
            "name" => "diapaper",
            "brand" => "Huggies",
            "description" => "This is the Description",
            "product_category_id" => $product->id,
            "parent_category_id" => $product->parentCategory[0]->id,
            "parent_sub_category_id" => $parentSubCategory,
            "retail_price" => 100.19,
            "markup_percentage" => 2.05,
            "price" => 102.24,
            "vendor_id" => 1,
            "gift_shops" => [1] ,
            "discount_percentage" =>  10,
            "stock_quantity" => 10,
            "images" => ["https://res.cloudinary.com/valenci007/image/upload/v1651322166/products/202204301236_whatsapp_image_2022_03_07_at_64149_pm.jpg", "https://res.cloudinary.com/valenci007/image/upload/v1651322166/products/202204301236_whatsapp_image_2022_03_07_at_64149_pm.jpg"],
            "limited_stock" =>  false
        ];

        $response = $this->withAuthentication()->postJson($this->admin_url.'parent-category', $data);
        
        $response->assertStatus(201);
    }

    public function test_that_i_can_edit_product()
    {
        $product = Product::factory()->create();
        $data = [
            "name" => "Love",
            "description" => "All clubs are rich"
        ];
        $response = $this->withAuthentication()->putJson($this->admin_url.'product/'.$product->id, $data);

        $response->assertOk();
    }

    public function test_that_i_can_view_product()
    {
        $product = Product::factory()->create();
        $response = $this->withAuthentication()->getJson($this->admin_url.'product/'.$product->id);
        
        $response->assertOk();
    }

    public function test_that_i_can_view_all_product()
    {
        $product = Product::factory()->create();
        $response = $this->withAuthentication()->getJson($this->admin_url.'product');
        
        $response->assertOk();
    }

    public function test_that_i_can_delete_product()
    {
        $product = Product::factory()->create();
        $response = $this->withAuthentication()->deleteJson($this->admin_url.'product/'.$product->id);
        
        $response->assertOk();
    }
}

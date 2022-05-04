<?php

namespace Tests\Feature\Parent_Category;

use Tests\TestCase;
use App\Models\ParentCategory;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParentCategoryTest extends TestCase
{

    public function test_that_the_schema_of_parent_category()
    {
        $this->assertTrue(Schema::hasColumn('parent_categories',
            'slug'
        ), 
        true);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_create_parent_category()
    {
        $productCategory = ProductCategory::factory()->create();
        $data = [
            "name" => "club",
            "description" => "A football club like manchester united and arsenal",
            'product_category_id' => $productCategory->id,
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson($this->admin_url.'parent-category', $data);
        
        $response->assertStatus(201);
    }

    public function test_that_i_can_edit_parent_category()
    {
        $parentCategory = ParentCategory::factory()->create();
        $data = [
            "name" => "Love",
            "description" => "All clubs are rich"
        ];
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->putJson($this->admin_url.'parent-category/'.$parentCategory->id, $data);
        
        $response->assertOk()
        ->assertJson([
            'data' => $data,
        ]);
    }

    public function test_that_i_can_view_parent_category()
    {
        $parentCategory = ParentCategory::factory()->create();
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->getJson($this->admin_url.'parent-category/'.$parentCategory->id);
        
        $response->assertOk();
    }

    public function test_that_i_can_view_all_parent_category()
    {
        $parentCategory = ParentCategory::factory()->create();
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->getJson($this->admin_url.'parent-category');
        
        $response->assertOk();
    }

    public function test_that_i_can_delete_parent_category()
    {
        $productCategory = ParentCategory::factory()->create();
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->deleteJson($this->admin_url.'parent-category/'.$productCategory->id);
        
        $response->assertOk();
    }

}

<?php

namespace Tests\Feature\Size;

use Tests\TestCase;
use App\Models\Size;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SizeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_create_size()
    {
        $data = [
            "size" => 10.5,
        ];
        $response = $this->withAuthentication()->postJson($this->admin_url.'size', $data);
        // dd($response);
        $response->assertStatus(201);
    }

    public function test_that_i_can_edit_size()
    {
        $size = Size::factory()->create();
        $editData = [
            'size' => 11.5
        ];
        $response = $this->withAuthentication()->putJson($this->admin_url.'size/'.$size->id, $editData);
        
        $response->assertOk()
        ->assertJson([
            'data' => $editData,
        ]);
    }

    public function test_that_i_can_view_Size()
    {
        $size = Size::factory()->create();
        $response = $this->withAuthentication()->getJson($this->admin_url.'size/'.$size->id);
        
        $response->assertOk();
    }

    public function test_that_i_can_view_all_Sizes()
    {
        $size = Size::factory()->create();
        $response = $this->withAuthentication()->getJson($this->admin_url.'size');
        
        $response->assertOk();
    }

    public function test_that_i_can_delete_Size()
    {
        $size = Size::factory()->create();
        $response = $this->withAuthentication()->deleteJson($this->admin_url.'size/'.$size->id);
        
        $response->assertOk();
    }
}

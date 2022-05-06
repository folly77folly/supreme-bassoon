<?php

namespace Tests\Feature\Color;

use Tests\TestCase;
use App\Models\Color;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ColorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_create_color()
    {
        $data = [
            "name" => "club",
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson($this->admin_url.'color', $data);
        
        $response->assertStatus(201);
    }

    public function test_that_i_can_edit_color()
    {
        $data = [
            "name" => "Love"
        ];
        $color = Color::create($data);
        $editData = [
            'name' => 'Dye'
        ];
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->putJson($this->admin_url.'color/'.$color->id, $editData);
        
        $response->assertOk()
        ->assertJson([
            'data' => $editData,
        ]);
    }

    public function test_that_i_can_view_color()
    {
        $color = Color::factory()->create();
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->getJson($this->admin_url.'color/'.$color->id);
        
        $response->assertOk();
    }

    public function test_that_i_can_view_all_colors()
    {
        $color = Color::factory()->create();
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->getJson($this->admin_url.'color');
        
        $response->assertOk();
    }

    public function test_that_i_can_delete_color()
    {
        $color = Color::factory()->create();
        $response = $this->withHeaders([
            'accept' => 'application/json',
        ])->deleteJson($this->admin_url.'color/'.$color->id);
        
        $response->assertOk();
    }
}

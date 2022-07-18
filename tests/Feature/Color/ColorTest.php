<?php

namespace Tests\Feature\Color;

use Tests\TestCase;
use App\Models\Admin;
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
        $admin = Admin::factory()->create();
        $data = [
            "name" => "club",
        ];
        $response = $this->withAuthentication($admin)->postJson($this->admin_url.'color', $data);
        
        $response->assertStatus(201);
    }

    public function test_that_i_can_edit_color()
    {
        $admin = Admin::factory()->create();
        $data = [
            "name" => "Love"
        ];
        $color = Color::create($data);
        $editData = [
            'name' => 'Dye'
        ];
        $response = $this->withAuthentication($admin)->putJson($this->admin_url.'color/'.$color->id, $editData);
        
        $response->assertOk()
        ->assertJson([
            'data' => $editData,
        ]);
    }

    public function test_that_i_can_view_color()
    {
        $admin = Admin::factory()->create();
        $color = Color::factory()->create();
        $response = $this->withAuthentication($admin)->getJson($this->admin_url.'color/'.$color->id);
        
        $response->assertOk();
    }

    public function test_that_i_can_view_all_colors()
    {
        $admin = Admin::factory()->create();
        $color = Color::factory()->create();
        $response = $this->withAuthentication($admin)->getJson($this->admin_url.'color');
        
        $response->assertOk();
    }

    public function test_that_i_can_delete_color()
    {
        $admin = Admin::factory()->create();
        $color = Color::factory()->create();
        $response = $this->withAuthentication($admin)->deleteJson($this->admin_url.'color/'.$color->id);
        
        $response->assertOk();
    }
}

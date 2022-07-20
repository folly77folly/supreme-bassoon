<?php

namespace Tests\Feature\Role;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_create_role()
    {
        $faker = \Faker\Factory::create();
        $faker->firstname();
        $name = $faker->firstname();
        $data = ['name' => $name];
        $response = $this->withAdminAuthentication()->postJson($this->admin_url.'role', $data);
        $response->assertCreated();
    }   

    public function test_that_i_can_view_role()
    {
        $role = Role::first();
        $response = $this->withAdminAuthentication()->getJson($this->admin_url.'role/'.$role->id);
        $response->assertOk();
    }  

    public function test_that_i_can_edit_role()
    {   $faker = \Faker\Factory::create();
        $faker->firstname();
        $name = $faker->firstname();
        $data = ['name' => $name];
        $role = Role::first();
        $response = $this->withAdminAuthentication()->putJson($this->admin_url.'role/'.$role->id, $data);
        $response->assertOk();
    } 

    public function test_that_i_can_delete_role()
    {
        $role = Role::first();
        $response = $this->withAdminAuthentication()->deleteJson($this->admin_url.'role/'.$role->id);
        $response->assertOk();
    }  
}

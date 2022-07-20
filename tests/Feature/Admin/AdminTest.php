<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_register_as_an_admin()
    {
        $role = Role::inRandomOrder()->first();
        $faker = \Faker\Factory::create();
        $data = [
            'email' => preg_replace('/@example\..*/', '@yopmail.com', $faker->unique()->safeEmail),
            'role_id' => $role->id
        ];

        $response = $this->withAuthentication()->postJson($this->admin_url.'register/', $data);

        $response->assertCreated();
    }

    public function test_that_i_can_login__as_admin()
    {
        $admin = Admin::factory()->create();
        $data = [
            'email' => $admin->email,
            'password' => 'password',
        ];

        $response = $this->withAuthentication()->postJson($this->admin_url.'login/', $data);
        $response->assertOk();
    }

    public function test_that_i_can_an_admin_can_resend()
    {
        $admin = Admin::factory()->create();
        $data = [
            'email' => $admin->email,
        ];

        $response = $this->withAuthentication()->postJson($this->admin_url.'resend-register-email/', $data);
        $response->assertOk();
    }
}

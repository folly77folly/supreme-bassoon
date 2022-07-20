<?php

namespace Tests\Feature\AdminDashboard;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_see_admin_dashboard()
    {
        $response = $this->withAuthentication()->getJson($this->admin_url.'admin-dashboard');
        $response->assertOk();
    }

    public function test_that_i_can_see_customers_on_dashboard()
    {
        $response = $this->withAuthentication()->getJson($this->admin_url.'customers');
        $response->assertOk();
    }

    public function test_that_i_can_see_a_customer()
    {
        $user = User::factory()->create();
        $response = $this->withAuthentication()->getJson($this->admin_url.'customers/'. $user->id);
        $response->assertOk();
    }

}

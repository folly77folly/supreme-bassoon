<?php

namespace Tests\Feature\MailingList;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailingListTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_add_email_to_mailing_list()
    {

        $data = [
            "email" => preg_replace('/@example\..*/', '@yopmail.com', $this->faker->unique()->safeEmail),
        ];
        $response = $this->withOutAuthentication()->postJson($this->user_url.'mailing-list', $data);
        
        $response->assertStatus(201);
    }

    public function test_that_admin_can_view_mailing_list()
    {
        $admin = Admin::factory()->create();

        $response = $this->withAuthentication($admin)->getJson($this->admin_url.'mailing-list');
        
        $response->assertStatus(200);

    }
}

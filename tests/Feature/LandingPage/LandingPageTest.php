<?php

namespace Tests\Feature\LandingPage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_see_landing_page()
    {
        $response = $this->withAuthentication()->getJson($this->user_url.'landing-page');
        $response->assertOk();
    }


    public function test_that_i_can_see_new_additions()
    {
        $response = $this->withAuthentication()->getJson($this->user_url.'landing-page-new-additions');
        $response->assertOk();
    }


    public function test_that_i_can_see_parent_category()
    {
        $response = $this->withAuthentication()->getJson($this->user_url.'landing-page-parent-category');
        $response->assertOk();
    }

    public function test_that_i_can_see_to_selling()
    {
        $response = $this->withAuthentication()->getJson($this->user_url.'landing-page-top-selling');
        $response->assertOk();
    }


}

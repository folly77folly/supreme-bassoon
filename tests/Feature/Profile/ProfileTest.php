<?php

namespace Tests\Feature\Profile;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_i_can_see_profile()
    {
        $vendor = Vendor::factory()->create();
        $vendorAdmin = Admin::where('email', $vendor->email)->first();
        $response = $this->withAdminAuthentication($vendorAdmin)->getJson($this->admin_url.'profile');
        $response->assertOk();
    }
}

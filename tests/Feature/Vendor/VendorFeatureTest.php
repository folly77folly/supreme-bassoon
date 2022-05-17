<?php

namespace Tests\Feature\Vendor;

use Tests\TestCase;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VendorFeatureTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    
    public function test_that_i_can_create_a_vendor()
    {
        $data = [
            "vendor_name" => "DemLAde",
            "contact_name" => "Shayo",
            "phone_no" => "+2346262322354",
            "email" => "sholaurti@gmail.com",
            "store_address" => "ibadan, Gra",
            "description" => "God is the best",
            "commission_fee" => 500,
        ];
        $response = $this->withHeaders([
            'Accept' => "application/json",
        ])->postJson('/api/admin/vendor', $data);

        $response->assertStatus(201);
    }

    public function test_that_i_can_update_a_vendor()
    {
        $vendor = Vendor::factory()->create();
        $data = [
            "vendor_name" => "DemLAde",
            "contact_name" => "Shayo",
            "phone_no" => "+2346262322354",
            "email" => "iamaqim@gmail.com",
            "store_address" => "ibadan, Gra",
            "description" => "God is the best",
            "commission_fee" => 500
        ];
       
        $response = $this->withHeaders([
            'Accept' => "application/json",
        ])->putJson('/api/admin/vendor/'.$vendor->slug, $data);
        $data['id'] = $vendor->id;
        $data['is_active'] = true;
        $data['contact_name'] = 'Shayo';
        $data['vendor_name'] = 'Demlade';
        $data['store_address'] = 'ibadan, Gra';
        $data['description'] = 'God is the best';
        $data['commission_fee'] = 500;
        $response->assertOk();
    }

    public function test_thant_i_can_view_a_vendor()
    {
        $vendor = Vendor::factory()->create();

        $response = $this->withHeaders([
            'Accept' => "application/json",
        ])->getJson('/api/admin/vendor/'.$vendor->slug);

        $response->assertOk();
    }

    public function test_thant_i_can_view_all_vendors()
    {
        $vendor = Vendor::factory()->create();

        $response = $this->withHeaders([
            'Accept' => "application/json",
        ])->getJson('/api/admin/vendor');

        $response->assertOk();
    }

    Public function test_that_i_can_delete_a_vendor()
    {
        $vendor = Vendor::factory()->create();

        $response = $this->withHeaders([
            'Accept' => "application/json",
        ])->deleteJson('/api/admin/vendor/'.$vendor->id);

        $response->assertOk();
    }

    
}

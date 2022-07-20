<?php

namespace Tests;

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;
    public $admin_url = '/api/admin/';
    public $user_url = '/api/';

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function createProduct(){
        return Product::factory()->create();
    }

    public function createUserToken(){

        $token = User::factory()->create()->createToken('api')->plainTextToken;
        return $token;
    }

    public function createAdminToken(){

        $token = Admin::factory()->create()->createToken('api')->plainTextToken;
        return $token;
    }

    public function withAuthentication($user = null){
        if($user){
            $token = $user->createToken('api')->plainTextToken;
        }else{
            $token = $this->createUserToken();
        }
       return $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
        ]);
    }

    public function withAdminAuthentication($admin = null){
        if($admin){
            $token = $admin->createToken('api')->plainTextToken;
        }else{
            $token = $this->createAdminToken();
        }
       return $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
        ]);
    }

    public function withoutAuthentication(){

       return $this->withHeaders([
            'Accept' => 'application/json',
        ]);
    }
}

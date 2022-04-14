<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register()
    {
        Artisan::call('migrate:fresh --seed');

        $response = $this->postJson('api/register',[
            "email" => "kingsconsult@gmail.com",
            "first_name" =>  "kings",
            "last_name" =>  "okpara",
            "password" =>  "Kings12345678@",
            "password_confirmation" =>  "Kings12345678@",
            "ip_address" =>  "",
            "phone_no" =>  "08066056233",
            "has_child" =>  1,
            "children" =>  [
                [
                    "full_name" => "ade sola",
                    "age" => 12,
                    "gender_id" => 1,
                ]
            ],
            "ip_address" => "jdhfhu448397493"
        ]);
        $response->assertCreated();
    }

    public function test_login()
    {
        Artisan::call('migrate:fresh --seed');
        $user = User::factory()->create();
        $data = [
            'email' => $user->email,
            'password' => 'password',
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createToken('user->email')->plainTextToken
        ])
            ->post('/api/login', $data);

        $response->assertStatus(200);
    }
}

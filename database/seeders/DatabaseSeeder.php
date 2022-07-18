<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            CouponTypeSeeder::class,
            GenderSeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            DeliveryStatusSeeder::class,
            PaymentMethodSeeder::class,
            OrderStatusSeeder::class
        ]);
        // dd(env('APP_ENV'));
        // dd(in_array(env('APP_ENV'), ['local', 'debug', 'development']));
        // if(in_array(env('APP_ENV'), ['local', 'debug', 'development']) ){

            Admin::factory()->create(['email' => 'super_admin@yopmail.com']);
            User::factory()->create(['email' => 'user@yopmail.com']);
            Product::factory()->count(10)->create();
            Order::factory()->count(10)->create();
        // }
    }
}

<?php

namespace Database\Seeders;

use App\Models\DeliveryStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeliveryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DeliveryStatus::truncate();
        DeliveryStatus::insert([
            [
            'name' => 'Order Placed'
            ],
            [
                'name' => 'Order Shipped'
            ],
            [
                'name' => 'Order Delivered'
            ],
            [
                'name' => 'Order Cancelled'
            ]

        ]);
    }
}

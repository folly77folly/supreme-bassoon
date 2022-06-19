<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $pending = new OrderStatus;
        $pending->name = 'pending';
        $pending->save();

        $completed = new OrderStatus;
        $completed->name = 'completed';
        $completed->save();

        $cancelled = new OrderStatus;
        $cancelled->name = 'cancelled';
        $cancelled->save();
    }
}

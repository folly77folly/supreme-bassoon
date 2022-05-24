<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_payment_method = new PaymentMethod;
        $first_payment_method->name = "Pay Now";
        $first_payment_method->description = "Pay with visa";
        $first_payment_method->save();
        
        $second_payment_method = new PaymentMethod;
        $second_payment_method->name = "Pay on delivery";
        $second_payment_method->description = "Pay on delivery";
        $second_payment_method->save();

        $third_payment_method = new PaymentMethod;
        $third_payment_method->name = "Pay with loyalty point";
        $third_payment_method->description = "You have a balance of 50034 bubble colony loyalty point";
        $third_payment_method->save();
    }
}

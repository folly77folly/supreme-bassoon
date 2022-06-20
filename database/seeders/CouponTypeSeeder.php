<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon_type;

class CouponTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupon_type = new Coupon_type;
        $coupon_type->name = 'flat';
        $coupon_type->save();


        $coupon_type = new Coupon_type;
        $coupon_type->name = 'percentage';
        $coupon_type->save();
    }
}

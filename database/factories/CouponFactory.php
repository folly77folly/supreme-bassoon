<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Coupon_type;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $couponTypeIds = Coupon_type::get('id');
        $active = [0, 1];
        $dates = ["2000-12-20 00:00:00", "2022-12-20 00:00:00", "2024-12-20 00:00:00", "2012-12-20 00:00:00"];
        $end_date = ["2023-12-20 00:00:00", "2023-12-20 00:00:00", "2024-12-20 00:00:00", "2025-12-20 00:00:00"];

        return [
            'coupon_code' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'coupon_description' => $this->faker->text($maxNbChars = 200),
            'coupon_type_id' => $this->faker->randomElement($couponTypeIds),
            'min_amount' =>  $this->faker->numberBetween(200, 5000),
            'usage_limit' => $this->faker->randomNumber(1,100),
            'emails_to_enjoy' => preg_replace('/@example\..*/', '@yopmail.com', $this->faker->unique()->safeEmail),
            'active' => $this->faker->randomElement($active),
            'start_date' => $this->faker->randomElement($dates),
            'end_date' => $this->faker->randomElement($dates),
        ];
    }
}

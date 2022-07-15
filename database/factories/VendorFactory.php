<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     

    public function definition()
    {
        $vendorName = $this->faker->name();
        $vendorSlug = Str::slug($vendorName, '_');
        
        return [
            'vendor_name' => $vendorName,
            'contact_name' => $this->faker->name(),
            'phone_no' => $this->faker->numerify('####-###-####'),
            'email' => preg_replace('/@example\..*/', '@yopmail.com', $this->faker->unique()->safeEmail),
            'store_address' => $this->faker->text($maxNbChars = 50),
            'description' => $this->faker->text($maxNbChars = 50),
            'slug' => $vendorSlug,
            'commission_fee' => $this->faker->randomNumber(1,2000)

        ];
    }
}



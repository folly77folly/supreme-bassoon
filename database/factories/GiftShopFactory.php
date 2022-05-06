<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftShop>
 */
class GiftShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->firstName,
            'description' => $this->faker->text($maxNbChars = 200),
            'banner_image' => 'https://res.cloudinary.com/valenci007/image/upload/v1651322166/products/202204301236_whatsapp_image_2022_03_07_at_64149_pm.jpg',
            'thumbnail_image' => 'https://res.cloudinary.com/valenci007/image/upload/v1651322166/products/202204301236_whatsapp_image_2022_03_07_at_64149_pm.jpg'
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Vendor;
use App\Models\GiftShop;
use App\Models\ParentCategory;
use App\Models\ProductCategory;
use App\Models\ParentSubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $productCategoryIds = ProductCategory::get('id');
        $parentCategoryIds = ParentCategory::get('id');
        $parentSubCategoryIds = ParentSubCategory::get('id');
        $vendorIds = Vendor::get('id');
        $giftShopIds = GiftShop::get();
        $retailPrice = $this->faker->numberBetween(0, 500);
        $markupPercent = $this->faker->numberBetween(0, 70);
        $price = $this->faker->numberBetween(0, 500);
        $discountPercent = $this->faker->numberBetween(0, 50);
        $stockQuantity = $this->faker->numberBetween(0, 50);
        $images = [
            'https://res.cloudinary.com/valenci007/image/upload/v1651322166/products/202204301236_whatsapp_image_2022_03_07_at_64149_pm.jpg',
            'https://res.cloudinary.com/valenci007/image/upload/v1651322166/products/202204301236_whatsapp_image_2022_03_07_at_64149_pm.jpg'
        ];
        return [
            //
            'name' => $this->faker->lastName,
            'brand' => $this->faker->firstName,
            'description' => $this->faker->firstName,
            'product_category_id' => $this->faker->randomElement($productCategoryIds),
            'parent_category_id' => $this->faker->randomElement($parentCategoryIds),
            'parent_sub_category_id' => $this->faker->randomElement($parentSubCategoryIds),
            'retail_price' => $retailPrice,
            'markup_percentage' => $markupPercent,
            'price' => $price,
            'vendor_id' => $this->faker->randomElement($vendorIds),
            'discount_percentage' => $discountPercent,
            'stock_quantity' => $stockQuantity,
            'gift_shops' => [$this->faker->randomElement($giftShopIds)->id],
            'images' => $images,
            'is_discounted' => $this->faker->randomElement([0,1]),
        ];
    }
}

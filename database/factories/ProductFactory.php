<?php

namespace Database\Factories;

use App\Models\Color;
use App\Models\Vendor;
use App\Models\GiftShop;
use Illuminate\Support\Str;
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
        if(GiftShop::get()->count() == 0){

            GiftShop::factory()->count(3)->create();
        }

        if(Vendor::get()->count() == 0){

            Vendor::factory()->count(3)->create();
        }
        if(Color::get()->count() == 0){
            Color::factory()->create();
        }
        if(ProductCategory::get()->count() == 0){

            $product = ProductCategory::factory()
            ->has(ParentCategory::factory()
            ->has(ParentSubCategory::factory()))
            ->count(3)
            ->create();
        }

        $productCategoryIds = ProductCategory::get('id');
        $parentCategoryIds = ParentCategory::get('id');
        $parentSubCategoryIds = ParentSubCategory::get('id');
        $vendorIds = Vendor::get('id');
        $colorIds = Color::get();
        $giftShopIds = GiftShop::get();
        $retailPrice = $this->faker->numberBetween(1, 500);
        $markupPercent = $this->faker->numberBetween(1, 70);
        $price = $retailPrice + (($markupPercent/100) * $retailPrice );//$this->faker->numberBetween(0, 500);
        $discountPercent = $this->faker->numberBetween(1, 50);
        $stockQuantity = $this->faker->numberBetween(1, 50);
        $images = [
            'https://res.cloudinary.com/valenci007/image/upload/v1661242019/products/202208230806_image10.jpg',
            'https://res.cloudinary.com/valenci007/image/upload/v1661241977/products/202208230806_image9.jpg',
            'https://res.cloudinary.com/valenci007/image/upload/v1661241936/products/202208230805_image8.jpg',
            'https://res.cloudinary.com/valenci007/image/upload/v1661241886/products/202208230804_image7.jpg',
            'https://res.cloudinary.com/valenci007/image/upload/v1661241843/products/202208230804_image6.jpg',
            'https://res.cloudinary.com/valenci007/image/upload/v1661241802/products/202208230803_image5.png',
            'https://res.cloudinary.com/valenci007/image/upload/v1661241664/products/202208230800_image4.jpg',
            'https://res.cloudinary.com/valenci007/image/upload/v1661241355/products/202208230755_image3.jpg',
            'https://res.cloudinary.com/valenci007/image/upload/v1661241292/products/202208230754_image2.jpg',
            'https://res.cloudinary.com/valenci007/image/upload/v1661240872/products/202208230747_image1.jpg',
        ];
        $randomImageIndex = array_rand($images);
        $lastName = $this->faker->lastName;
        $firstName = $this->faker->firstName;
        return [
            //
            'name' => $lastName,
            'brand' => $firstName,
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
            'colors' => [$this->faker->randomElement($colorIds)->id],
            'images' => $images,
            'main_image' => $images[$randomImageIndex],
            'is_discounted' => $this->faker->randomElement([0,1]),
            // 'slug' => Str::slug($lastName. ' ' .$firstName),
        ];
    }
}

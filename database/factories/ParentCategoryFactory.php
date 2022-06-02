<?php

namespace Database\Factories;

use App\Models\ParentCategory;
use App\Models\ProductCategory;
use App\Models\ParentSubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ParentCategoryFactory extends Factory
{
    // protected $model = ParentCategory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            //
            'name' => $this->faker->unique()->firstName,
            'description' => $this->faker->text($maxNbChars = 200),
            'product_category_id' => function(){
                $pc = ProductCategory::Factory()->create();
                return $pc->id;
            }
        ];
    }

    public function configure(){
        return $this->afterCreating(function(ParentCategory $parentCategory){
            ParentSubCategory::factory()->create([
                'parent_category_id' => $parentCategory->id,
            ]);
        });
    }
}

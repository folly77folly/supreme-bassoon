<?php
namespace App\Service;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Exceptions\ApiResponseException;
use App\Http\Requests\AdminUpdateDeliveryStatus;
use App\Models\ParentSubCategory;

class LandingPageService {

    public function landingPage():mixed
    {

        $parentCategory = ParentCategory::select(
            'id',
            'name',
            'banner_image',
            'thumbnail_image',
        )
        ->take(config('constants.RECORDS_TAKE.three'))->get();
        $products = Product::Where([
            'visibility' => true,
        ]);
        $newAdditions = $products->select(
            'id',
            'name',
            'brand',
            'price',
            'main_image',
        )
        ->inRandomOrder()->take(config('constants.RECORDS_TAKE.three'))->latest()->get();
        $parentSubCategory = ParentSubCategory::select(
            'id',
            'name',
            'banner_image',
            'thumbnail_image',
            'slug',
        )
        ->orderBy('name')->take(config('constants.RECORDS_TAKE.twentyFive'))->get();
        $sortedProducts = $products->get()->sortByDesc('sales_count');
        $result = $sortedProducts->values()->take(config('constants.RECORDS_TAKE.three'));
        return [
            'parent_category' => $parentCategory,
            'new_additions' => $newAdditions,
            'parent_sub_category' => $parentSubCategory,
            'top_selling' => $result,
        ];
    }

    public function allNewAdditions():mixed
    {
        $products = Product::visible()->inRandomOrder()->latest()->paginate(config('constants.PAGE_LIMIT.admin'));
        return $products;
    }

    public function allTopSellingProducts():mixed
    {
        $products = Product::visible()->inRandomOrder()->latest()->paginate(config('constants.PAGE_LIMIT.admin'));
        return $products;
    }

    public function parentCategory():mixed
    {
        $products = ParentCategory::active()->inRandomOrder()->get()->take(config('constants.RECORDS_TAKE.three'));
        return $products;
    }
}
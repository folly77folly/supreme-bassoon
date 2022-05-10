<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = []; 

    protected $casts = [
        'discounted' => 'boolean',
        'limited_stock' => 'boolean',
        'images' => 'array',
        'gift_shops' => 'array',
        'retail_price' => 'double',
        'price' => 'double',
        // 'discounted_price' => 'double',
        // 'price' => 'double',
    ];

    protected $appends = [
        'discounted_price',
        'product_name'
    ];



    public function images(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ['images' => bc_get_file_name_from_array_urls($value)],
            get: fn ($value) => bc_get_file_url_from_array(json_decode($value)),
        );
    }

    public function giftShops(): Attribute
    {
        return Attribute::make(
            get: fn($value) => bc_get__gift_shop_names_from_array(json_decode($value))
        );
    }

    public function getDiscountedPriceAttribute(){
        if(!$this->is_discounted){
            return 0.00;
        }
        $discountAmt = ($this->discount_percentage/100) * $this->price;
        $price = $this->price - $discountAmt;
        return round($price , 2);
    }

    public function getProductNameAttribute()
    {
        return $this->brand . ' ' .$this->name;
    }

}

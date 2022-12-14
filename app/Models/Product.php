<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = []; 
    // protected $keyType = 'string';

    protected $casts = [
        'discounted' => 'boolean',
        'limited_stock' => 'boolean',
        'images' => 'array',
        'gift_shops' => 'array',
        'colors' => 'array',
        'retail_price' => 'double',
        'price' => 'double',
        'commission_fee' => 'double',
        'discount_percentage' => 'double',
        'visibility' => 'boolean',
        'markup_percentage' => 'float',
    ];

    protected $appends = [
        'discounted_price',
        'product_name',
        'inventory_status',
        'unit_discount',
        'sales_count'
    ];


    // public static function boot(){
    //     parent::boot();
    //     static::creating(function($product){
    //         $product->slug = Str::slug($product->brand . ' ' .$product->name).'-' .now()->format('ymd');
    //         // $product->id = Str::uuid()->toString();
    //     });
    // }

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
            get: fn($value) => bc_get_gift_shop_names_from_array(json_decode($value))
        );
    }

    public function colors(): Attribute
    {
        return Attribute::make(
            get: fn($value) => bc_get_colors_from_array(json_decode($value))
        );
    }

    public function mainImage(): Attribute
    {
        return Attribute::make(
            set: fn($value) =>  bc_get_file_name_from_url($value),
            get: fn ($value) => bc_get_file_url_from_file($value),
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

    public function getInventoryStatusAttribute()
    {
        if($this->limited_stock){
            return 'Limited Stock';
        }
        if($this->stock_quantity > config('constants.STOCK_LIMIT')){
            return 'In stock';
        }

        if($this->stock_quantity < config('constants.STOCK_LIMIT')){
            return 'Out of stock';
        }

            
    }

    public function getUnitDiscountAttribute(){
        if(!$this->is_discounted){
            return 0.00;
        }
        $discountAmt = ($this->discount_percentage/100) * $this->price;
        return round($discountAmt , 2);
    }

    public function getSalesCountAttribute():int
    {
        $count = OrderItems::where('product_id', $this->id)->get()->count();
        return $count;
    }

    public function scopeVisible($query):mixed
    {
        return $query->where([
            'visibility' => true,
        ]);
    }

    public function orderItem(){

        return $this->hasMany(OrderItem::class);
    }

    public function vendor(){

        return $this->belongsTo(Vendor::class);
    }

    public function scopeProductOwner($query){
        if(auth()->user()->isVendor()){
            return $query->where('vendor_id',  auth()->user()->Vendor->id);
        }
    }

    // public function slug():Attribute
    // {
    //     return Attribute::make(
    //         set: fn($value) => ['slug' => Str::slug($value,'_'), 'name' => ($value)],
    //     );
    // }

    // public function setSlugAttribute()
    // {
    //     $this->attributes['slug'] = str_slug($this->brand , "-");
    // }
}

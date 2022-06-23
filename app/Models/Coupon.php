<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $casts = ['emails_to_enjoy' => 'array'];

    protected $appends = [
        'coupon_use_count',
    ];

    public function scopeActive($query)
    {
        return $query->where([
            'active' => true
        ]);
    }

    public function couponUsed(){
        return $this->hasMany(CouponUsed::class);
    }

    public function getCouponUseCountAttribute()
    {
        return CouponUsed::where('coupon_code', $this->coupon_code)->get()->count();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
        'paid' => 'boolean',
        'unit_price' => 'float',
        'total_amount' => 'float',
        'total_discount' => 'float',
        'total_price' => 'float',
        'send_for_review' => 'boolean',
        'reviewed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function deliveryStatus()
    {
        return $this->belongsTo(DeliveryStatus::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function scopeVendorOwner($query){
        if(auth()->user()->isVendor()){
            return $query->where('vendor_id',  auth()->user()->Vendor->id);
        }
    }
}

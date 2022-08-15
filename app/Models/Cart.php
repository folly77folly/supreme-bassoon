<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = [
        'total_amount',
        'total_discount',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function scopeActive($query){
        return $query->where([
            'status' => true,
            'completed' => false,
        ])->with(['product','vendor']);
    }

    public function getTotalAmountAttribute(){
        if($this->quantity <= 0){
            return 0;
        }
        return round(($this->quantity * $this->product->price), 2);
    }

    public function getTotalDiscountAttribute(){
        if($this->product->is_discounted){

            return round(($this->quantity * $this->product->discounted_price), 2);
        }
        return 0;
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $guarded =[];

    protected $casts = [
        'status' => 'boolean',
        'paid' => 'boolean',
    ];

    protected $appends =[
        'order_no',
    ];
    
    public function orderItem()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function getOrderNoAttribute(){
        return '#' . str_pad($this->id, 8, "0", STR_PAD_LEFT);
    }
}

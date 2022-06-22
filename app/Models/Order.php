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
        'delivery_date'
    ];
    
    public function orderItem()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function getOrderNoAttribute(){
        return '#' . str_pad($this->id, 8, "0", STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryStatus()
    {
        return $this->belongsTo(DeliveryStatus::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function getDeliveryDateAttribute()
    {
        $now = ($this->created_at);
        $shipRecord = explode('-', $this->delivery_days);
        $start = ($now->addDays($shipRecord[0]))->format('d M');
        $end = ($now->addDays($shipRecord[1]))->format('d M');
        $message = "Ready for delivery between {$start} & {$end}";
        return $message;
    }
}

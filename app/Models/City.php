<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class City extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $appends = [
        'shipping_delivery_date',
    ];

    protected $cast =[
        'shipping_delivery_date' => 'date'
    ];

    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    // public function shippingDays():Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => 
    //         explode('-', $value)
    //     );
    // }

    public function getShippingDeliveryDateAttribute()
    {
        $shipRecord = explode('-', $this->shipping_days);
        $start = (now()->addDays($shipRecord[0]))->format('d M');
        $end = (now()->addDays($shipRecord[1]))->format('d M');
        $message = "Ready for delivery between {$start} & {$end} ";
        return $message;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [

         'vendor_name', 
         'contact_name', 
         'phone_no', 
         'email', 
         'state_address', 
         'description', 
         'is_active',
         'commission_fee',
     ];


     //Define Casts here
     protected $casts = [
        'is_active' => 'boolean',
     ];

     public function order()
     {
         return $this->hasMany(Order::class);
     }

}

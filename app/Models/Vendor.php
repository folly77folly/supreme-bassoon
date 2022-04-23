<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

     protected $fillable = ['vendor_name', 'contact_name', 'phone_no', 'email', 'state_address', 'description', 'is_active'];

     protected $casts = [
        'is_active' => 'boolean',
     ];

}

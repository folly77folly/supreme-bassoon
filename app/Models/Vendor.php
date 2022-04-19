<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    //Define filable properties here
    protected $fillable = ['vendor_name', 'contact_name', 'phone_number', 'email', 'store_address', 'description'];
}

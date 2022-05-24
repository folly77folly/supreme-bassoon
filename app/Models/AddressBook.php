<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class AddressBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone_no',
        'address',
        'city_id',
        'state_id',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function user(){
        return $this->belongsTO(User::class, 'user_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftShop extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ['slug' => Str::slug($value,'_'), 'name' => ($value)],
            get: fn ($value) => ucfirst($value),
        );
    }

    public function scopeActive($query){
        return $query->where('is_active', true);
    }
}

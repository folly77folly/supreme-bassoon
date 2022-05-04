<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
      use HasFactory;

     protected $dates = ['deleted_at'];


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    protected $casts = [
        'is_active' => 'boolean',
    ];


    //Relationship function goes here
    public function parentCategory(){
        return $this->hasMany(ParentCategory::class);
    }


    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ['slug' => Str::slug($value, '_'), 'name' => ($value)],
            get: fn ($value) => ucfirst($value),
        );
    }



}

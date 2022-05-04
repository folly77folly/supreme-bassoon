<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentCategory extends Model
{
    use HasFactory;

    
    protected $guarded = [];

    protected $casts = [
      'is_active' => 'boolean',
  ];

    public function productCategory(){
      return $this->belongsTo(ProductCategory::class);
    }

    public function parentSubCategory()
    {
      return $this->hasMany(ParentSubCategory::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ['slug' => Str::slug($value,'_'), 'name' => ($value)],
            get: fn ($value) => ucfirst($value),
        );
    }
}

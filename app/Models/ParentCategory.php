<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
    use HasFactory;

    
    protected $fillable = ['name', 'product_category_id'];


    public function ProductCategory(){
      return $this->belongsTo(ProductCategory::class);
    }
}
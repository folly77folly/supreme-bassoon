<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductSubcategory;

class ProductCategory extends Model
{
      use HasFactory;

     protected $dates = ['deleted_at'];


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];


    //Relationship function goes here
    public function ProductSubcategory(){
        return $this->hasMany(ProductSubcategory::class);
    }


}

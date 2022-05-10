<?php
namespace App\Service;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ApiResponseException;

class ProductService{


    public function saveProduct($validatedData){
    try{
        $product = DB::transaction(function () use($validatedData) {
            $price = $this->getPrice($validatedData['retail_price'], $validatedData['markup_percentage']);
            if(floatVal($price) !== floatVal($validatedData['price'])){
                throw new ApiResponseException("Invalid Price, should be ${price}");
            }
        if($validatedData['discount_percentage'] > 0){
            $validatedData['is_discounted'] = true;
        }
        $product = Product::create($validatedData);
        return $product;

        });
          return $product; 
        }
        catch(Throwable $th){
            return $th;
        }
    }


    public function getPrice($retailPrice, $markupPercentage){

        if($markupPercentage > 0){
            $markupNaira = ($markupPercentage/100) * $retailPrice;
            $price = $markupNaira + $retailPrice;
            return round($price, 2);
        }
        return round($retailPrice, 2);
    }

    public function getAllProducts(){
        return Product::paginate(config('constants.PAGE_LIMIT.admin'));
    }

    public function getAProduct($id){
        $product = Product::find($id);
        if (!$product){
            throw new ApiResponseException('Product not found');
        }
        return $product;
    }
     

    public function EditProduct($validatedData, $id ){
        try{
            $newProduct  = Product::find($id);
            if(! $newProduct){
                throw new ApiResponseException('product not found');
            }
            $product = DB::transaction(function () use($validatedData, $newProduct) {
                if(array_key_exists('retail_price', $validatedData )){

                    $price = $this->getPrice($validatedData['retail_price'], $validatedData['markup_percentage']);
                    if(floatVal($price) !== floatVal($validatedData['price'])){
                        throw new ApiResponseException("Invalid Price, should be ${price}");
                    }
                }
            if(array_key_exists('discount_percentage', $validatedData)){

                if($validatedData['discount_percentage'] > 0){
                    $validatedData['is_discounted'] = true;
                }
            }
            $newProduct->fill($validatedData)->save();
            return $newProduct;
    
            });
              return $product; 
            }
            catch(Throwable $th){
                return $th;
            }
        }
}
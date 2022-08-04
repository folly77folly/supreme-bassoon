<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ViewProductController extends Controller
{
    public function ViewProduct($slug){
        $product = Product::where('slug', $slug)->get();
        if($product->count() == 0){
            return $this->apiResponse->failure("Product doesnt exist");
        }
        return $this->apiResponse->successWithData($product);
    }
}

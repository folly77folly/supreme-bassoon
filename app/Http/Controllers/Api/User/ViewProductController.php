<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ViewProductController extends Controller
{
    public function ViewProduct($product_id){
        $product = Product::findOrFail($product_id);
        return $this->apiResponse->successWithData($product);
    }
}

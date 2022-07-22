<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ViewProductController extends Controller
{
    public function ViewProduct(){
        $product = Product::all();
        return $this->apiResponse->successWithData($product);
    }
}

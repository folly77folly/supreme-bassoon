<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    //
    public function index(){

        $data = ProductCategory::where('is_active', true)->with('parentCategory')->get();
        return $this->apiResponse->successWithData($data, 'Get All Product Category Successfully');
    }
}

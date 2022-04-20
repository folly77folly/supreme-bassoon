<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Service\ApiResponseService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CategoryRequest;


class ProductCategoryController extends Controller
{   

   //Create Category 
    public function create(CategoryRequest $request){

        $data = ProductCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return $this->apiResponse->successwithData($data, 'Product Category Created Successfully');
    }

    public function index(){

        $data = ProductCategory::all();
        return $this->apiResponse->successwithData($data, 'Get All Product Category Successfully');
    }

    public function update(CategoryRequest $request, $id){

        $product = ProductCategory::find($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

         return $this->apiResponse->successwithData($product, 'Product Category Updated Successfully');
    }

    public function delete($id)
    {
        $product = ProductCategory::destroy($id);
        return $this->apiResponse->successwithData($product, 'Product Category Deleted Successfully');
    }

}
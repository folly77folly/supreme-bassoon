<?php

namespace App\Http\Controllers\Api\Admin;

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

        $product = ProductCategory::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

         return $this->apiResponse->successwithData($product, 'Product Category Updated Successfully');
    }

    //Delete Method
    public function delete($id)
    {
        $product = ProductCategory::destroy($id);
        return $this->apiResponse->successwithData($product, 'Product Category Deleted Successfully');
    }


    //Get all produc subtcategory related a product category method
    public function GetSubcategories($category_id){

           $ProductCategory = ProductCategory::find($category_id);
           if(!$ProductCategory){
              return $this->apiResponse->failure('Category not found');
           }

           $ProductSubCategory = ProductCategory::find($category_id)->ProductSubcategory;
           if(!$ProductSubCategory){
                return $this->apiResponse->failure('Category doesnt have sub-category');
           }

            return $this->apiResponse->successwithData($ProductSubCategory);
       

    }
    

 
}

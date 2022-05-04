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
    public function store(CategoryRequest $request){

        $formData = $request->validated();
        $data = ProductCategory::create($formData);
        return $this->apiResponse->created($data, 'Product Category Created Successfully');
    }

    public function index(){

        $data = ProductCategory::where('is_active', true)->with('parentCategory')->get();
        return $this->apiResponse->successWithData($data, 'Get All Product Category Successfully');
    }

    public function update(CategoryRequest $request, $id){
        $formData = $request->validated();
        $product = ProductCategory::findOrFail($id);
        $product->update($formData);

         return $this->apiResponse->successWithData($product, 'Product Category Updated Successfully');
    }

    //Delete Method
    public function destroy($id)
    {
        $product = ProductCategory::destroy($id);
        return $this->apiResponse->success('Product Category Deleted Successfully');
    }


    //Get all product category related a product category method
    public function show($category_id){

           $ProductCategory = ProductCategory::find($category_id);
           if(!$ProductCategory){
              return $this->apiResponse->failure('Category not found');
           }

            return $this->apiResponse->successWithData($ProductCategory->load('parentCategory'));

    }
    

 
}

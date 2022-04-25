<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use App\Service\ApiResponseService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\SubcategoryRequest;

class ProductSubcategoryController extends Controller
{
    public function create(SubcategoryRequest $request, $ProductCategoryId){

        $formData = $request->validated();

        $ProductCategory = ProductCategory::findOrFail($ProductCategoryId);
           
        $ProductSubCategory = ProductSubCategory::create([
            'name' => $request->name,
            'product_category_id' => $ProductCategory->id,
        ]);

        return $this->apiResponse->successwithData($ProductSubCategory, 'Product Subcategory Created Successfully');
           
    }

    //Show all product subcategories here
    public function index(){

        $data = ProductSubCategory::all();
        return $this->apiResponse->successwithData($data);

    }

    //Edit Product subcategory method
    public function update(SubcategoryRequest $request, $ProductCategoryId, $id){

        $formData = $request->validated();
        
        $ProductCategory = ProductCategory::find($ProductCategoryId);

        if($ProductCategory){

            $ProductSubcategoryId = ProductSubCategory::find($id);
            if($ProductSubcategoryId){

                $ProductSubcategoryId->update([
                  'name' => $request->name,
                  'product_category_id' => $ProductCategory->id,
               ]);

                return $this->apiResponse->successwithData($ProductSubcategoryId, 'Product Subcategory Updated Successfully');
            }else{
                return $this->apiResponse->failure('Product subcategory id not found');
            }

        }else{
            return $this->apiResponse->failure('No such product category id');
        }

    }

    //Delete Product Subcategory method here
    public function delete($id)
    {
        $product = ProductSubCategory::destroy($id);
        return $this->apiResponse->success('Product SubCategory Deleted Successfully');
    }


}


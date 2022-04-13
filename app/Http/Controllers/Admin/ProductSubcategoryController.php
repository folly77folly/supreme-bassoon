<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSubcategory;
use App\Models\ProductCategory;
use App\Service\ApiResponseService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\SubcategoryRequest;

class ProductSubcategoryController extends Controller
{
    public function create(SubcategoryRequest $request, $ProductCategoryId){

        $ProductCategory = ProductCategory::find($ProductCategoryId);

        if($ProductCategory){

           $ProductSubCategory = ProductSubcategory::create([
              'name' => $request->name,
              'product_category_id' => $ProductCategory->id,
           ]);

           return $this->apiResponse->successwithData($ProductSubCategory, 'Product Subcategory Created Successfully');

        }else{
            return $this->apiResponse->failure('No such product category id');
        }

    }

    //Show all product subcategories here
    public function index(){

        $data = ProductSubCategory::all();
        return $this->apiResponse->successwithData($data);

    }

    //Edit Product subcategory method
    public function update(SubcategoryRequest $request, $ProductCategoryId, $id){

        $ProductCategory = ProductCategory::find($ProductCategoryId);

        if($ProductCategory){

            $ProductSubcategoryId = ProductSubcategory::find($id);
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
        $product = ProductSubcategory::destroy($id);
        return $this->apiResponse->successwithData($product, 'Product SubCategory Deleted Successfully');
    }


}


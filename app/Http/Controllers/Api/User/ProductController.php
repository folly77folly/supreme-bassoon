<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Models\ProductCategory;
use App\Models\ParentSubCategory;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {   
        $product = Product::visible()->where('slug', $slug)->first();
        if(!$product){
            return $this->apiResponse->failure("Product not found");
        }
        return $this->apiResponse->successWithData($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function productByParentSubCategory($id)
    {
        $category = ParentSubCategory::find($id);
        if(!$category){
            return $this->apiResponse->failure('category is not found'); 
        }
        $products = Product::visible()->where('parent_sub_category_id', $id)->latest()->paginate(config('constants.PAGE_LIMIT.user'));
        return $this->apiResponse->successWithData($products);
    }

    public function productByParentCategory($id)
    {
        $category = ParentCategory::find($id);
        if(!$category){
            return $this->apiResponse->failure('category is not found'); 
        }
        $products = Product::visible()->where('parent_category_id', $id)->latest()->paginate(config('constants.PAGE_LIMIT.user'));
        return $this->apiResponse->successWithData($products);
    }

    public function productByProductCategory($id)
    {
        $category = ProductCategory::find($id);
        if(!$category){
            return $this->apiResponse->failure('category is not found'); 
        }
        $products = Product::visible()->where('product_category_id', $id)->latest()->paginate(config('constants.PAGE_LIMIT.user'));
        return $this->apiResponse->successWithData($products);
    }
}

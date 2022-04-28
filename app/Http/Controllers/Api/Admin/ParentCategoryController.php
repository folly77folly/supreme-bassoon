<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Models\ProductCategory;
use App\Service\ApiResponseService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ParentCategoryRequest;

class ParentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ParentCategory::paginate(5);
        return $this->apiResponse->successwithData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ParentCategoryRequest $request)
    {
         $formData = $request->validated();

         $ProductCategory = ProductCategory::findOrFail($request->product_category_id);
         $ParentCategory = ParentCategory::create([
            'name' => $request->name,
            'product_category_id' => $ProductCategory->id,
         ]);
        return $this->apiResponse->successwithData($ParentCategory, 'Parent Category Created Successfully');
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParentCategoryRequest $request, $id)
    {
        $formData = $request->validated();

        $ParentCategoryId = ParentCategory::find($id);
        $ParentCategoryId->update([
            'name' => $request->name,
            'product_category_id' => $request->product_category_id,
        ]);

        return $this->apiResponse->successwithData($ParentCategoryId, 'Parent Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ParentCategory::destroy($id);
        return $this->apiResponse->success('Parent Category Deleted Successfully');
    }
}

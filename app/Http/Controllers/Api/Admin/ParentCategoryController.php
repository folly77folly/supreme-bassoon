<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Models\ProductCategory;
use App\Service\ApiResponseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParentCategoryRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\EditParentCategoryRequest;

class ParentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ParentCategory::with('parentSubCategory')->paginate(config('constants.PAGE_LIMIT.admin'));
        return $this->apiResponse->successWithData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParentCategoryRequest $request)
    {
        //
        $formData = $request->validated();
        $ProductCategory = ProductCategory::find($request->product_category_id);
        $ParentCategory = $ProductCategory->parentCategory()->create($formData);

       return $this->apiResponse->created($ParentCategory, 'Parents Category Created Successfully');
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
        $ParentCategory = ParentCategory::findOrFail($id);
        $data = $ParentCategory->load('parentSubCategory');
        return $this->apiResponse->successWithData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditParentCategoryRequest $request, $id)
    {
        $formData = $request->validated();

        $ParentCategory = ParentCategory::findOrFail($id);
        $data = $ParentCategory->fill($request->all());

        return $this->apiResponse->successWithData($data, 'Parent Category Updated Successfully');
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

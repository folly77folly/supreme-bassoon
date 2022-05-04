<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Models\ParentSubCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditParentSubCategoryRequest;
use App\Http\Requests\SaveParentSubCategoryRequest;

class ParentSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ParentSubCategory::paginate(config('constants.PAGE_LIMIT.admin'));
        return $this->apiResponse->successWithData($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveParentSubCategoryRequest $request)
    {
        //
        $formData = $request->validated();
        $ParentCategory = ParentCategory::find($request->parent_category_id);
        $ParentSubCategory = $ParentCategory->parentSubCategory()->create($formData);

       return $this->apiResponse->created($ParentSubCategory, 'Parents Sub Category Created Successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ParentSubCategory = ParentSubCategory::findOrFail($id);
        return $this->apiResponse->successWithData($ParentSubCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditParentSubCategoryRequest $request, $id)
    {
        //
        $formData = $request->validated();

        $ParentCategory = ParentSubCategory::findOrFail($id);
        $ParentCategory->fill($request->all());
        $ParentCategory->save();

        return $this->apiResponse->successWithData($ParentCategory, 'Parent Category Updated Successfully');
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
}

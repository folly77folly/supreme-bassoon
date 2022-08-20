<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Models\ParentSubCategory;
use App\Http\Controllers\Controller;

class ParentSubCategoryController extends Controller
{
    //
    public function index()
    {
        $data = ParentSubCategory::paginate(config('constants.PAGE_LIMIT.user'));
        return $this->apiResponse->successWithData($data);
    }
}

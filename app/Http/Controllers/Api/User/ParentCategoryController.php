<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Http\Controllers\Controller;

class ParentCategoryController extends Controller
{
    //
    public function index()
    {
        $data = ParentCategory::with('parentSubCategory')->paginate(config('constants.PAGE_LIMIT.user'));
        return $this->apiResponse->successWithData($data);
    }
}

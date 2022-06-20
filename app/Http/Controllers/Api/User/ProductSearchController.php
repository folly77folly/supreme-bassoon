<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SearchProductRequest;
use App\Models\Product;

class ProductSearchController extends Controller
{
    public function searchProduct(SearchProductRequest $request){

        $formData = $request->validated();
        $search = $formData['search_name'];

        $products = Product::query()
        ->where('name', 'LIKE', "%{$search}%")
        ->orWhere('description', 'LIKE', "%{$search}%")
        ->paginate(config('constants.PAGE_LIMIT.user'));

        return $this->apiResponse->successWithData($products, 'Results of search');
    }
}

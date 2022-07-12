<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Http\Requests\CreateProductReviewsRequest;
use App\Http\Requests\EditProductReviewsRequest;
use Auth;

class ProductReviewController extends Controller
{
   //Create Product Review
   public function createReview(CreateProductReviewsRequest $request){
        $formData = $request->validated();
        $formData['user_id'] = Auth::id();
        $productReview = ProductReview::create($formData);
        return $this->apiResponse->created($productReview, 'Product Review saved successfully');
   }

   //Update Product Review
   public function updateReview(EditProductReviewsRequest $request, $id){
        $formData = $request->validated();
        $productReview = ProductReview::findOrFail($id);
        $productReview->update($formData);
        return $this->apiResponse->created($productReview, 'Product review updated successfully');
   }

   //Delete Product Review
   public function deleteReview($id){
        $city = ProductReview::destroy($id);
        return $this->apiResponse->success('City Deleted Successfully');
   }
}

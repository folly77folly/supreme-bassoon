<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\OrderItems;
use App\Http\Requests\CreateProductReviewsRequest;
use App\Http\Requests\EditProductReviewsRequest;
use Auth;

class ProductReviewController extends Controller
{
   //Create Product Review
   public function createReview(CreateProductReviewsRequest $request, $productId){
     
     $orderItem = OrderItems::where('User_id', Auth::id())
                    ->where('product_id', $productId)
                    ->count();
     if($orderItem == 0){
        return $this->apiResponse->failure("You're not allowed to write a review for a product you havent bought ");
     }

     $formData = $request->validated();
     $formData['user_id'] = Auth::id();
     $formData['product_id'] = $productId;
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
        return $this->apiResponse->success('Product Review Deleted Successfully');
   }

   //Get all product review under a oder item
   public function getReviews($id){
     $orderItem = OrderItems::findOrFail($id);
     $reviews = $orderItem->with('productReviews')->get();
     return $this->apiResponse->successWithData($reviews, 'Reviews retreived successfully');
   }

}

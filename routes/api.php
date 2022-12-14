<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\ChildrenProfileController;
use App\Http\Controllers\Api\User\AddressBookController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\WishlistController;
use App\Http\Controllers\Api\User\CityController;
use App\Http\Controllers\Api\User\VerificationController;
use App\Http\Controllers\Api\User\ForgotPasswordController;
use App\Http\Controllers\Api\User\PaymentMethodController;
use App\Http\Controllers\Api\User\ProductSearchController;
use App\Http\Controllers\Api\User\ViewProductController;
use App\Http\Controllers\Api\User\{
  CheckoutController,
  WebhookTransactionController,
  BuyNowController,
  CouponController,
  LandingPageController,
  ProductReviewController,
  ProductController,
  MailingListController,
  ProductCategoryController,
  ParentSubCategoryController,
  ParentCategoryController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| Unprotected Routes
|--------------------------------------------------------------------------
*/
//user Email Signup Route
Route::POST('/register', [AuthController::class, 'register']);
Route::POST('/login', [AuthController::class, 'login']);

//password Reset
Route::POST('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.reset');
Route::POST('auth/password/reset', [ForgotPasswordController::class, 'reset'])->name('password.reset');

//Email Verification
Route::GET('email/resend', [VerificationController::class, 'resend']);
Route::GET('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
// Route::POST('otp/verify', 'Api\User\VerificationController@verifyOTP')->name('verification.otp');

Route::POST('/webhook', [WebhookTransactionController::class, 'confirmTransfer']);

//Landing Page
Route::controller(LandingPageController::class)->group(function(){
  Route::GET('landing-page', 'index');
  Route::GET('landing-page-new-additions', 'getAllNewAdditions');
  Route::GET('landing-page-top-selling', 'getTopSellingProducts');
  Route::GET('landing-page-parent-category', 'getParentCategory');
});

Route::POST('mailing-list', [MailingListController::class, 'store']);

Route::get('product/{slug}', [ProductController::class, 'show']);
Route::get('parent-sub-category/{id}', [ProductController::class, 'productByParentSubCategory']);
Route::get('parent-category/{id}', [ProductController::class, 'productByParentCategory']);
Route::get('product-category/{id}', [ProductController::class, 'productByProductCategory']);

Route::get('parent-sub-category', [ParentSubCategoryController::class, 'index']);
Route::get('parent-category', [ParentCategoryController::class, 'index']);
Route::get('product-category', [ProductCategoryController::class, 'index']);

// 'product-category' => ProductCategoryController::class,
// 'parent-category' => ParentCategoryController::class,
// 'parent-sub-category' => ParentSubCategoryController::class,


/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::POST('logout', [AuthController::class, 'logout']);

    Route::apiResources([
      'children-profile' => ChildrenProfileController::class,
      'cart' => CartController::class,
      'address-book' => AddressBookController::class,
      'wishlist' => WishlistController::class,
      'checkout' => CheckoutController::class,

    ]);

    //Address Book
    Route::post('default-address-book/{id}', [AddressBookController::class, 'setDefault']);

    //WishList
    Route::post('wishlist/{product_id}', [WishlistController::class, 'storeWishlist']);

    //Payment Method Endpoint
    Route::get('payment-method', [PaymentMethodController::class, 'paymentMethod']);

    //Get City depending on state_id
    Route::get('state-city/{stateId}', [CityController::class, 'getCity']);

    //Product Search Route
    Route::post('search-product', [ProductSearchController::class, 'searchProduct']);

    // Cart
    Route::POST('cart-quantity-update', [CartController::class, 'quantityUpdate']);
    Route::GET('cart-summary', [CartController::class, 'showCartSummary']);

    //Coupon
    Route::controller(CouponController::class)->group(function(){
      Route::POST('coupon', 'couponValue');
    });

    Route::controller(ProductReviewController::class)->group(function(){
      Route::post('product-review/{productId}', 'createReview');
      Route::put('product-review/{id}', 'updateReview');
      Route::delete('product-review/{id}', 'deleteReview');
    });
});





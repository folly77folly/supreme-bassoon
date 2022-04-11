<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\VerificationController;
use App\Http\Controllers\Api\User\ForgotPasswordController;

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
Route::POST('otp/verify', 'Api\User\VerificationController@verifyOTP')->name('verification.otp');

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
});


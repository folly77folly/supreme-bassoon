<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\OtpRequest;
use App\Service\ApiResponseService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    // use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponseService $apiResponse)
    {
        $this->middleware('auth:sanctum')->only('resend', 'verifyOtp');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->apiResponse = $apiResponse;
    }

    public function verify(Request $request)
    {

        auth()->loginUsingId($request->route('id'));
        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {

            return $this->apiResponse->failure('Already Verified');  
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }


        // if ($response = $this->verified($request)) {
        // return response(["message"=>"Successfully Verified"]);
        // }
        $email = $request->user()->email;
        $base_url = env('FRONT_END_BASE_URL', 'http://127.0.0.1:3001');
        // $token = auth()->loginUsingId($request->route('id'));
        $accessToken = Auth()->user()->createToken($email)->plainTextToken;

        return redirect($base_url."/index?token=$accessToken");

    }

    public function resend(Request $request)
    {

        if ($request->user()->hasVerifiedEmail()) {
            return $this->apiResponse->failure('Already Verified');
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->apiResponse->failure('Verification Link Sent to your email address');
    }

    public function verifyOTP(OtpRequest $request)
    {
        $validatedData = $request->validated();

        auth()->loginUsingId($validatedData["id"]);

        if(!auth()->loginUsingId($validatedData["id"])){
            return $this->apiResponse->failure('Wrong User');
        }

        if (request()->user()->hasVerifiedEmail()) {
            return $this->apiResponse->failure('Already Verified'); 
        }

        if(request()->user()->otp != $validatedData["otp"])
        {
            return $this->apiResponse->failure('Validation Code is not correct');
        }

        $myUser = User::findOrFail(request()->user()->id);
        $myUser->email_verified_at = Carbon::now();
        $myUser->save();

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        return $this->apiResponse->success('User successfully verified');
    }
}

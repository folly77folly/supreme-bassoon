<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Collections\Constants;
use Illuminate\Auth\Passwords;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Passwords\CanResetPassword;

// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    // use CanResetPassword;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    public function sendPasswordResetNotification($token)
    {
        return $token;
    }

    // use SendsPasswordResetEmails;

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response([
            "status" => "failure",
            "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY,
            "message" => trans($response)
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    protected function sendResetLinkResponse(Request $request, $response)
    {
        $user = DB::table('users')->where('email', '=', $request->email)->first();
        // return $this->apiResponse->success(trans($response));
        return response([
            "status" => "success",
            "status_code" => Response::HTTP_OK,
            "password_reset_token" => $user->provider_id,
            "message" => trans($response)
        ], Response::HTTP_OK);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email:rfc,dns']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === 'passwords.sent'
            ? $this->apiResponse->success('Check your email for link')
            : $this->apiResponse->failure('Invalid Email Address');
    }

    public function reset(Request $request)
    {
        $credentials = request()->validate([
            'email' => 'required|email:rfc,dns',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);
        // dd($credentials);
        // $reset_password_status = Password::reset($credentials, function ($user, $password) {
        //     dd('uswe');
        //     $user->password = Hash::make($password);
        //     // $user->password = $password;
        //     $user->save();
        //     event(new PasswordReset($user));
        // });

        // dd(Password::PASSWORD_RESET);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );


        if ($status == Password::INVALID_TOKEN) {
            return $this->apiResponse->failure('Invalid token provided', Response::HTTP_BAD_REQUEST);
        }
        return $status === Password::PASSWORD_RESET ? $this->apiResponse->success('Password has been successfully changed'):$this->apiResponse->failure('Invalid Credentials');
        return $this->apiResponse->success('Password has been successfully changed', Response::HTTP_OK);
    }
}

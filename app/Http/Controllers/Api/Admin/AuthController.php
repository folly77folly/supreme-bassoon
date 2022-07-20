<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use Illuminate\Support\Str;
use App\Service\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminResetLinkRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRegisterRequest $request)
    {
        //
        $validatedData = $request->validated();
        $validatedData['password'] = "password";
        $adminUser = new AuthService($validatedData);
        $user = $adminUser->registerAdminUser($validatedData);

        $sentMsg = $adminUser->sendResetLinkEmail($validatedData['email']);
        return $sentMsg === 'passwords.sent'
            ? $this->apiResponse->created($user, 'The email link has been sent to the user')
            : $this->apiResponse->failure('User Created but email was not sent');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    /**
     * Login for admin
     */
    public function login(UserLoginRequest $request)
    {
        $validatedData = $request->validated();
        $authorizedUser = new AuthService($validatedData);
        $accessToken = $authorizedUser->adminAuthorize();
        if (!$accessToken){
            return $this->apiResponse->failure('Invalid email or password');
        }
        $admin = Admin::where('email', $validatedData['email'])->first();

        $data = [
            "auth" => [
                "token" => $accessToken,
            ],
            "role" => [
                "id" => $admin->role_id,
                "name" => $admin->role->name,
            ],
        ];
        return $this->apiResponse->successWithData($data);

    }

    public function reset(Request $request)
    {
        $credentials = request()->validate([
            'email' => 'required|email:rfc,dns',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

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
            return $this->apiResponse->failure('Invalid token provided');
        }
        return $status === Password::PASSWORD_RESET ? $this->apiResponse->success('Password has been successfully changed'):$this->apiResponse->failure('Invalid Credentials');
        return $this->apiResponse->success('Password has been successfully changed');
    }

    public function resendLink(AdminResetLinkRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = "password";
        $adminUser = new AuthService($validatedData);

        $sentMsg = $adminUser->sendResetLinkEmail($validatedData['email']);
        return $sentMsg === 'passwords.sent'
            ? $this->apiResponse->success('The email link has been sent to the user')
            : $this->apiResponse->failure('email was not sent');
    }


    public function forgotPassword(AdminResetLinkRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = "password";
        $adminUser = new AuthService($validatedData);
        $sentMsg = $adminUser->sendResetLinkEmail($validatedData['email']);

        return $sentMsg === 'passwords.sent'
            ? $this->apiResponse->success('The email link has been sent check your email')
            : $this->apiResponse->failure('email was not sent');
    }

}

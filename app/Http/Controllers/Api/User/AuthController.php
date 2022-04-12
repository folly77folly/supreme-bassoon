<?php

namespace App\Http\Controllers\Api\User;

use Throwable;
use App\Models\User;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\UserLoginRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function register(RegisterRequest $request)
    {

        try {
        $newUser = DB::transaction(function ()  use ($request) {
            // code...
            $validatedData = $request->validated();
            $validatedData["password"] = Hash::make($request["password"]);
            $userData = [
                'first_name' => strtolower($validatedData['first_name']),
                'last_name' => strtolower($validatedData['last_name']),
                'email' => strtolower($validatedData["email"]),
                'phone_no' => $validatedData["phone_no"],
                'password' => $validatedData["password"],
            ];
            $latestUser = User::create($userData);
            $user = User::find($latestUser->id);

            event(new Registered($user));
            
            // $accessToken = $user->createToken($userData['email'])->plainTextToken;
            // $accessToken = $user->createToken('token-name')->plainTextToken;

            // $data = [
            //     "auth" => [
            //         "token" => $accessToken,
            //     ],
            //     "profile" => [
            //         "first_name" => $user->first_name,
            //         "user_id" => $user->last_name,
            //         "phone_no" => $user->phone_no,
            //     ],
            //     "role" => [
            //         "id" => $user->role_id,
            //         "name" => $user->role->name,
            //     ],
            // ];
            // return $data;
        }, 2);
        return $this->apiResponse->success('Registration Successful Check your mail for verification link');
        } catch (Throwable $th) {
        DB::Rollback();
            return $this->apiResponse->exceptionFailure($th);
        }
    }

    public function login(UserLoginRequest $request)
    {

        $validatedData = $request->validated();
        $newUser = new AuthService($validatedData);
        $result = $newUser->authorize();
        
        if ($result['response'] == false) {
            return $this->apiResponse->failure($result['message'], Response::HTTP_UNAUTHORIZED);
        }

            Auth::login($result['user']);
            $accessToken = auth()->user()->createToken(auth()->user()->email)->plainTextToken;
            $user = auth()->user();
            if(!auth()->user()->hasVerifiedEmail()){
                return $this->apiResponse->failure('Email has not been verified');
            }
            $data = [
                "auth" => [
                    "token" => $accessToken,
                ],
                "profile" => [
                    "first_name" => $user->first_name,
                    "user_id" => $user->last_name,
                    "phone_no" => $user->phone_no,
                ],
                "role" => [
                    "id" => $user->role_id,
                    "name" => $user->role->name,
                ],
            ];
            return $this->apiResponse->successWithData($data, $result['message']);
    }

    public function logOut()
    {
        $user = Auth()->user()->tokens()->delete();
        return $this->apiResponse->success('Logout Successful');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::find(Auth()->user()->id);

        if (!Hash::check($validatedData["current_password"], $user->password)) {

            return response()->json([
                "status" => "failure",
                "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY,
                "message" => "Invalid current password",
            ], Response::HTTP_UNPROCESSABLE_ENTITY,);
        }

        $newPassword = $validatedData['new_password'];
        $user->password = Hash::make($newPassword);
        $user->save();
        return $this->apiResponse->successwithData('Password changed successfully', Response::HTTP_OK, $user);
    }
}
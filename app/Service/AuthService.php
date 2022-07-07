<?php
namespace App\Service;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct($validatedData)
    {
        $this->validatedData['email'] = strtolower($validatedData['email']);
        $this->validatedData['password'] = $validatedData['password'];
    }

    public function authorize()
    {
        $user = User::where('email', strtolower($this->validatedData['email']))->first();
        if(!$user){
            return [
                'response' => false,
                'message' => 'Email not registered'
            ];
        }elseif (!Auth()->attempt([
            'email' => $this->validatedData['email'] ,
            'password' => $this->validatedData['password'] ,
        ])){
            return [
                'response' => false,
                'message' => 'Invalid Password'
            ];
        }elseif (!Auth()->user()->is_active){
            return [
                'response' => false,
                'message' => 'Your account is inactive'
            ];
        }else{

            return [
                'response' => true,
                'message' => 'Login successful',
                'user' => $user,
            ];
        }


    }

    public function updateLastLogin($now)
    {
        User::where('email', $this->validatedData['email'])->update(['updated_at' =>  $now]);
    }

    public function adminAuthorize($request):mixed
    {
    
        if(!$this->verifyCredentials()){
            return false;
        }

        $user = Admin::where('email',  $this->validatedData['email'])->first();
        Auth::guard('admin')->login($user);
        $accessToken = $user->createToken( $this->validatedData['email'])->plainTextToken;
        return $accessToken;
    }

    private function verifyCredentials():bool
    {
        return Auth::guard('admin')->attempt([
            'email' => $this->validatedData['email'],
            'password' => $this->validatedData['password'],
        ]);
    }

    public function registerAdmin()
    {
        
    }

}

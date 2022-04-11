<?php
namespace App\Service;

use App\Models\User;

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

}

<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bail',
            'first_name' => ['required', 'max:20'],
            'last_name' => ['required', 'max:20'],
            'email'=> ['required','email:rfc,dns', 'unique:users'],
            "phone_no" => ['required', 'numeric','digits:11'],
            "has_child" => ['required'],
            'password'=> ['required','confirmed','min:8','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
            "ip_address" => ['filled'],
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'The password should be a combination of Uppercase, Lowercase, digits and special characters',
        ];
    }
}

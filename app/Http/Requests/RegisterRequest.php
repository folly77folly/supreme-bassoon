<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
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
            "has_child" => ['required','boolean'],
            'password'=> ['required','confirmed',Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()
            ],
            "ip_address" => ['filled'],
            'children.*.full_name' => ['required_if:has_child,1', 'max:40'],
            'children.*.gender_id' => ['required_if:has_child,1', 'integer', 'exists:genders,id'],
            'children.*.age' => ['required_if:has_child,1', 'integer', 'gt:0'],
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'The password should be a combination of Uppercase, Lowercase, digits and special characters',
            'children.*.full_name.required_if' => 'The children full name field is required when add child profile is true at position #:position.',
            'children.*.gender_id.required_if' => 'The children gender field is required when add child profile is true at position #:position.',
            'children.*.age.required_if' => 'The children age field is required when add child profile is true at position #:position.',
        ];
    }
}

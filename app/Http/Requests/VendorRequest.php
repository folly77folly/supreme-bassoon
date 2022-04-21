<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vendor_name'=> 'required|string',
            'contact_name'=> 'required',
            'phone_no' => 'required|regex:/^\+234[0-9]{10}/',
            'email'=> ['required','email:rfc,dns', 'unique:users'],
            'state_address' => 'required',
            'description' => 'required',
        ];
    }

    //Define error message
    public function messages(){

        return [

            'phone_no.regex' => '+234 is the acceptable format and number should contain 10 integers after +234, +234xxxxxxxxxx',

        ];
    }
}


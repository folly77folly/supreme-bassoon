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
            'vendor_name'=> 'required|string|max:400',
            'contact_name'=> 'required|max:400',
            'phone_no' => 'required|regex:/^\+234[0-9]{10}/|unique:vendors',
            'email'=> ['required','email:rfc,dns', 'unique:vendors'],
            'store_address' => 'required|max:400',
            'description' => 'required|max:400',
        ];
    }

    //Define error message
    public function messages(){

        return [

            'phone_no.regex' => '+234 is the acceptable format and number should contain 10 integers after +234, +234xxxxxxxxxx',

        ];
    }
}


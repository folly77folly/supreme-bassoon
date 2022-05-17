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
            'vendor_name'=> 'required|string|max:400|unique:vendors',
            'contact_name'=> 'required|max:400|unique:vendors',
            'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|unique:vendors|min:11|max:14',
            'email'=> ['required','email:rfc,dns', 'unique:vendors'],
            'store_address' => 'required|max:400',
            'description' => 'required|max:400',
        ];
    }

}


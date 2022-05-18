<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditVendorRequest extends FormRequest
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
            'vendor_name'=> 'nullable|string|max:400',
            'contact_name'=> 'nullable|max:400',
            'phone_no' => 'nullable|regex:/^\+234[0-9]{10}/',
            'email'=> ['nullable','email:rfc,dns'],
            'store_address' => 'nullable|max:400',
            'description' => 'nullable|max:400',
            'commission_fee' => ['nullable', 'numeric', 'gt:0'],
        ];
    }
}
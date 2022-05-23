<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveAddressBookRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|unique:address_books|min:11|max:14',
            'address' => 'required|max:400',
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:states,id',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveChildrenProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role_id == config('constants.ROLES.user');
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
            'gender_id' => 'required|exists:genders,id',
            'age' => 'required|numeric|min:2',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|unique:children_profiles|min:11|max:14',
        ];
    }
}

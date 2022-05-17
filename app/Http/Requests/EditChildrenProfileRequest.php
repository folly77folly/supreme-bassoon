<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditChildrenProfileRequest extends FormRequest
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
            'user_id' => ['exists:users,id'],
            'full_name' => ['string','max:255'],
            'gender_id' => ['exists:genders,id'],
            'age' => ['nullable'],
            'phone_number' => ['nullable']
        ];
    }
}

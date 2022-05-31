<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCityRequest extends FormRequest
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
            "name" => "nullable|string|max:255",
            "state_id" => "nullable|exists:states,id",
            "shipping_rate" => "nullable|max:200",
            "is_active" => "nullable",
        ];
    }
}

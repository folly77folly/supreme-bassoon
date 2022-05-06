<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditGiftShopRequest extends FormRequest
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
            //
            'name'=>['string', 'max:50', Rule::unique('gift_shops')->ignore($this->gift_shop)],
            'description' => ['nullable'],
            'banner_image' => ['nullable'],
            'thumbnail_image' => ['nullable'],
        ];
    }
}

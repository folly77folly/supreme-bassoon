<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveParentSubCategoryRequest extends FormRequest
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
            'name'=>'required|string|max:255|unique:parent_sub_categories,name',
            'parent_category_id' => 'required|exists:parent_categories,id',
            'description' => ['nullable'],
            'banner_image' => ['nullable'],
            'thumbnail_image' => ['nullable'],
        ];
    }
}

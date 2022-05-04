<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditParentCategoryRequest extends FormRequest
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
            //Validation rules goes here
            'name'=>['string','max:255',Rule::unique('parent_categories')->ignore(intVal($this->parent_category))],
            'product_category_id' => ['exists:product_categories,id'],
            'description' => ['nullable'],
            'banner_image' => ['nullable'],
            'thumbnail_image' => ['nullable'],
        ];
    }
}

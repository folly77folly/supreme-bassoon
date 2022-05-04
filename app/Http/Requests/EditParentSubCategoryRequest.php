<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditParentSubCategoryRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            //
            'name'=>['string','max:255', Rule::unique('parent_sub_categories')->ignore(intVal($this->parent_sub_category))],
            'parent_category_id' => ['exists:parent_categories,id'],
            'description' => ['nullable'],
            'banner_image' => ['nullable'],
            'thumbnail_image' => ['nullable'],
        ];
    }
}

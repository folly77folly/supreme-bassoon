<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentCategoryRequest extends FormRequest
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
            //Validation rules goes here
            'name'=>'required|string|max:255|unique:parent_categories',
            'product_category_id' => 'required'
        ];
    }
}

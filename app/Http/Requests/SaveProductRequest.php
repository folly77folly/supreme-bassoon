<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProductRequest extends FormRequest
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
            'name' => ['required', 'max:50'],
            'brand' => ['required', 'max:50'],
            'description' => ['required', 'max:500'],
            'product_category_id' => ['required','exists:product_categories,id'],
            'parent_category_id' => ['required','exists:parent_categories,id'],
            'parent_sub_category_id' => ['required','exists:parent_sub_categories,id'],
            'retail_price' => ['required', 'numeric','gt:0'],
            'markup_percentage' => ['required','numeric','gt:0'],
            'price' => ['required','numeric', 'gt:0'],
            'vendor_id' => ['required','exists:vendors,id'],
            'gift_shops.*' => ['nullable', 'integer', 'exists:gift_shops,id'],
            'colors.*' => ['nullable', 'integer', 'exists:colors,id'],
            'dimension' => ['nullable'],   
            'discount_percentage' => ['required'],
            'stock_quantity' => ['required'],
            'images.*' => ['required', 'url'],
            'main_image' => ['required', 'url'],
            'limited_stock' => ['required', 'boolean']
        ];
    }

    public function messages()
    {
        return [
            'gift_shops.*.exists' => 'The selected gift shop is invalid at position #:position.',
            'colors.*.exists' => 'The selected color is invalid at position #:position.',
        ];
    }
}

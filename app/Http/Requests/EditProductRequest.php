<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            'name' => ['nullable', 'max:50'],
            'brand' => ['nullable', 'max:50'],
            'description' => ['nullable', 'max:500'],
            'product_category_id' => ['nullable','exists:product_categories,id'],
            'parent_category_id' => ['nullable','exists:parent_categories,id'],
            'parent_sub_category_id' => ['nullable','exists:parent_sub_categories,id'],
            'retail_price' => ['nullable', 'numeric','gt:0'],
            'markup_percentage' => ['nullable','numeric','gt:0'],
            'price' => ['nullable','numeric', 'gt:0'],
            'vendor_id' => ['nullable','exists:vendors,id'],
            'gift_shops.*' => ['nullable', 'integer', 'exists:gift_shops,id'],
            'discount_percentage' => ['nullable'],
            'stock_quantity' => ['nullable'],
            'images.*' => ['nullable', 'url'],
            'limited_stock' => ['nullable', 'boolean']
        ];
    }
}

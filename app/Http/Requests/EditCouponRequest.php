<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCouponRequest extends FormRequest
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
           'coupon_code' => ['nullable', 'max:50'],
           'coupon_description' => ['nullable', 'max:250'],
           'coupon_type_id' => ['nullable', 'exists:coupon_types,id'],
           'min_amount' => ['nullable'],
           'usage_limit' => ['nullable'],
           'emails_to_enjoy' => ['nullable'],
           'active' => ['nullable'],
           'start_date' => ['nullable','date_format:Y-m-d'],
           'end_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today']
        ];
    }
}

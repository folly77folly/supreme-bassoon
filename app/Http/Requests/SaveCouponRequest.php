<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCouponRequest extends FormRequest
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
           'coupon_code' => ['nullable', 'max:50', 'unique:coupons'],
           'coupon_description' => ['required', 'max:250'],
           'coupon_type_id' => ['required', 'exists:coupon_types,id'],
           'min_amount' => ['required'],
           'usage_limit' => ['required'],
           'emails_to_enjoy' => ['nullable','array'],
           'emails_to_enjoy.*' => ['distinct','email:rfc,dns'],
           'active' => ['required'],
           'start_date' => ['required','date_format:Y-m-d'],
           'end_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today']
        ];
    }

    public function messages()
    {
        return  [ 
            // 'emails_to_enjoy' => 'The Email Address  is not correct when at position #:position.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GetCouponValueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role_id === config('constants.ROLES.user');
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
            'amount' => ['bail','required', 'numeric'],
            'address_book_id' => ['bail','required'],
            'children_profile_id' => ['bail','required'],
            'trans_id' => ['bail','required'],
            'reference' => ['bail','required', 'unique:orders,reference'],
            'product_id' => ['bail', 'required_if:type,2','uuid', 'exists:products,id'],
            'quantity' => ['bail', 'numeric','required_if:type,2','gt:0'],
            'type' => ['bail', 'required','numeric',Rule::in(1,2)],
            'coupon_code' => ['present', 'exists:coupons,coupon_code'],
        ];
    }
}

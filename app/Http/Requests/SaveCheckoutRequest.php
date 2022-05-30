<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCheckoutRequest extends FormRequest
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
            'payment_method_id' => ['bail','required', 'numeric'],
            'amount' => ['bail','required', 'numeric'],
            'address_book_id' => ['bail','required'],
            'children_profile_id' => ['bail','required'],
            'trans_id' => ['bail','required'],
            'reference' => ['bail','required', 'unique:orders,reference'],
        ];
    }
}

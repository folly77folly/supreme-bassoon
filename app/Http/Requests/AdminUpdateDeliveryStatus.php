<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateDeliveryStatus extends FormRequest
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
            'delivery_status_id' => ['bail', 'nullable', 'integer', 'exists:delivery_statuses,id'],
            'order_status_id' => ['bail', 'nullable', 'integer', 'exists:order_statuses,id'],
            'cost_price' => ['bail', 'numeric'],
            'vendor_fulfillment_id' => ['bail', 'nullable', 'exists:vendors,id'],
            'extra_notes' => ['bail', 'nullable', 'max:220'],
        ];
    }
}

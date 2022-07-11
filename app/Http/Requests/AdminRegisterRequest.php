<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return in_array(auth()->user()->role_id, config('constants.PERMISSION.admins'));
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
            'email' => ['required', 'email:rfc,dns', 'unique:admins'],
            'role_id' => ['required', 'exists:roles,id'],
        ];
    }
}

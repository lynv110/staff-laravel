<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => 'required|between:5,95',
            're_password' => 'same:password',
        ];
    }

    public function messages() {
        return [
            'password.required' => trans('common/common.error_required'),
            'password.between' => trans('common/common.error_between'),
            're_password.same' => trans('common/common.error_same'),
        ];
    }
}

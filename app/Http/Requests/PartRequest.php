<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PartRequest extends FormRequest
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
            'name' => 'required|between:5,95'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('part.error_name'),
            'name.between' => trans('part.error_name'),
        ];
    }

    /**
     * Return flash message if failed
     *
     * @return array
     */
    public function withValidator($validator){
        if ($validator->fails()) {
            flash_error(trans('main.error_form'));
        }
    }
}

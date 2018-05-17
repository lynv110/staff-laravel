<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class PositionRequest extends FormRequest
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
        $id = Request::input('id') ? Request::input('id') : null;

        return [
            'name' => 'required|between:5,95',
            'sort_permission' => 'required|min:1|max:120|position_exist:' . $id,
        ];
    }

    public function messages() {
        return [
            'name.required' => trans('position.error_name'),
            'name.between' => trans('position.error_name'),
            'sort_permission.required' => trans('position.error_sort_permission'),
            'sort_permission.max' => trans('position.error_sort_permission'),
            'sort_permission.min' => trans('position.error_sort_permission'),
            'sort_permission.position_exist' => trans('position.error_sort_permission_exit'),
        ];
    }

    public function withValidator($validator){
        if ($validator->fails()) {
            flash_error(trans('main.error_form'));
        }
    }
}

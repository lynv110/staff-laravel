<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class StaffRequest extends FormRequest
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
        $id = Request::input('id') ? Request::input('id') : 7;

        $rules = [
            'name' => 'required|between:2,32',
            'telephone' => 'required',
            'email' => 'required|staff_email_exist:' . $id,
            'username' => 'required|between:5,96|staff_username_exist:' . $id,
        ];

        if (!(int)$id){
            $rules['password'] = 'required|between:5,96';
        }

        return $rules;
    }

    public function messages() {

        $id = Request::has('id') ? Request::get('id') : null;

        $messages = [
            'name.required' => trans('staff.error_name'),
            'name.between' => trans('staff.error_name'),
            'telephone.required' => trans('staff.error_telephone'),
            'email.required' => trans('staff.error_email'),
            'email.staff_email_exist' => trans('staff.error_email_exist'),
            'username.required' => trans('staff.error_username'),
            'username.between' => trans('staff.error_username'),
            'username.staff_username_exist' => trans('staff.error_username_exist'),
        ];

        if (!(int)$id){
            $messages['password.required'] = trans('staff.error_password');
            $messages['password.between'] = trans('staff.error_password');
        }

        return $messages;
    }

    public function withValidator($validator){
        if ($validator->fails()) {
            flash_error(trans('main.error_form'));
        }
    }
}

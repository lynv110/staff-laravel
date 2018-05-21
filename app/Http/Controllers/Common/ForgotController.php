<?php

namespace App\Http\Controllers\Common;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\StaffModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ForgotController extends Controller
{
    private $staffModel;

    public function __construct(StaffModel $staffModel) {
        $this->staffModel = $staffModel;
    }

    public function getForgotForm() {

        return view('common.forgot');
    }

    public function forgot(ForgotPasswordRequest $request) {
        if ($this->staffModel->checkEmailExist($request->input('email'))) {

            $token = str_random(40);
            $this->staffModel->forgot($request->input('email'), $token);

            $info = [
                'email_to' => $request->input('email'),
                'subject' => trans('common/forgot.mail_heading'),
                'data' => [
                    'url' => url('change-password/' . $token),
                    'description' => trans('common/forgot.mail_description')
                ],
            ];

            $this->sendMail($info);

            Session::flash('flash_success', trans('common/forgot.text_success'));
            return redirect(route('_login'));
        } else {
            Session::flash('flash_error', trans('common/forgot.error_exist'));
            return redirect(route('_login'));
        }
    }

    public function getChangeForm($token) {
        if (!$token){
            return redirect('_login');
        }
        return view('common.change_password');
    }

    public function change($token, ChangePasswordRequest $request) {
        if ($this->staffModel->checkTokenExist($token)) {
            $this->staffModel->changePassword($request->input('password'), $token);

            Session::flash('flash_success', trans('common/forgot.text_change_success'));
            return redirect(route('_login'));
        } else {
            Session::flash('flash_error', trans('common/forgot.error_change'));
            return redirect(route('_login'));
        }
    }

    protected function sendMail($info) {

        $mail_init = [
            'name_from' => 'Staff Administrator',
            'name_to' => isset($info['name_to']) ? $info['name_to'] : '',
            'from' => 'admin@staff.com',
            'to' => isset($info['email_to']) ? $info['email_to'] : '',
            'subject' => isset($info['subject']) ? $info['subject'] : '',
        ];
        $data = [
            'url' => isset($info['data']['url']) ? $info['data']['url'] : '',
            'description' => isset($info['data']['description']) ? $info['data']['description'] : '',
        ];

        if (config('main.open_send_mail')) {
            mail_send($mail_init, $data, 'email.forgot');
        }
    }
}

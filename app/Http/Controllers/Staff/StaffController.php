<?php

namespace App\Http\Controllers\Staff;

use App\Facades\Staff;
use App\Http\Controllers\Controller;
use App\Models\PartModel;
use App\Models\PositionModel;
use App\Models\StaffModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller {

    private $positionModel;
    private $partModel;
    private $staffModel;

    public function __construct(PositionModel $positionModel, PartModel $partModel, StaffModel $staffModel) {
        $this->positionModel = $positionModel;
        $this->partModel = $partModel;
        $this->staffModel = $staffModel;
    }

    public function index() {
        if (!Staff::isRoot()) {
            flash_error(trans('staff.text_permission'));
            return redirect(route('_dashboard'));
        }

        $filterName = Request::get('filter_name') ? Request::get('filter_name') : '';
        $filterTelephone = Request::get('filter_telephone') ? Request::get('filter_telephone') : '';
        $filterEmail = Request::get('filter_email') ? Request::get('filter_email') : '';
        $filterStatus = Request::has('filter_status') ? Request::get('filter_status') : '';

        $filter = [
            'filter_name' => $filterName,
            'filter_status' => $filterStatus,
            'filter_telephone' => $filterTelephone,
            'filter_email' => $filterEmail,
            'sort' => 'name',
            'order' => 'asc',
            'paginate' => true,
        ];

        $data['staffs'] = $this->staffModel->getList($filter);

        $url = url('staff');

        if ($filterName || (isset($filterStatus) && $filterStatus != '' || $filterTelephone || $filterEmail) ) {

            $url .= '?filter';

            if ($filterName){
                $url .= '&filter_name=' . $filterName;
            }

            if ($filterTelephone){
                $url .= '&filter_telephone=' . $filterTelephone;
            }

            if ($filterEmail){
                $url .= '&filter_email=' . $filterEmail;
            }

            if ($filterStatus){
                $url .= '&filter_status=' . $filterStatus;
            }
        }

        $data['staffs']->setPath($url);

        $data['filter_name'] = $filterName;
        $data['filter_telephone'] = $filterTelephone;
        $data['filter_email'] = $filterEmail;
        $data['filter_status'] = $filterStatus;

        return view('staff.staff_list', $data);
    }

    public function getForm($id = null) {

        if ($id) {
            $info = $this->staffModel->getById((int)$id);
        }

        if (isset($id)) {
            $data['action'] = url('staff/edit/' . (int)$id);
        } else {
            $data['action'] = url('staff/add');
        }
        $data['reset_pass'] = 0;
        if (!empty($info)){
            $data['reset_pass'] = $id;
        }
        $data['cancel'] = url('staff');

        if (Request::old('name')) {
            $data['name'] = Request::old('name');
        } elseif (!empty($info)) {
            $data['name'] = $info->name;
        } else {
            $data['name'] = '';
        }

        if (Request::old('telephone')) {
            $data['telephone'] = Request::old('telephone');
        } elseif (!empty($info)) {
            $data['telephone'] = $info->telephone;
        } else {
            $data['telephone'] = '';
        }

        if (Request::old('address')) {
            $data['address'] = Request::old('address');
        } elseif (!empty($info)) {
            $data['address'] = $info->address;
        } else {
            $data['address'] = '';
        }

        if (Request::old('gender')) {
            $data['gender'] = Request::old('gender');
        } elseif (!empty($info)) {
            $data['gender'] = $info->gender;
        } else {
            $data['gender'] = 0;
        }

        if (Request::old('email')) {
            $data['email'] = Request::old('email');
        } elseif (!empty($info)) {
            $data['email'] = $info->email;
        } else {
            $data['email'] = '';
        }

        if (Request::old('avatar')) {
            $data['avatar'] = Request::old('avatar');
        } elseif (!empty($info)) {
            $data['avatar'] = $info->avatar;
        } else {
            $data['avatar'] = '';
        }

        if (Request::old('username')) {
            $data['username'] = Request::old('username');
        } elseif (!empty($info)) {
            $data['username'] = $info->username;
        } else {
            $data['username'] = '';
        }

        if (Request::old('password')) {
            $data['password'] = Request::old('password');
        } elseif (!empty($info)) {
            $data['password'] = $info->username;
        } else {
            $data['password'] = '';
        }

        if (Request::old('birthday')) {
            $data['birthday'] = Request::old('birthday');
        } elseif (!empty($info)) {
            $data['birthday'] = $info->birthday;
        } else {
            $data['birthday'] = '';
        }

        if (Request::old('part')) {
            $data['part'] = Request::old('part');
        } elseif (!empty($info)) {
            $parts = $this->staffModel->getIdPartByStaff($id);
            $data['part'] = [];
            if ($parts) {
                foreach ($parts as $part) {
                    $data['part'][] = $part->part_id;
                }
            }
        } else {
            $data['part'] = [];
        }

        $data['parts'] = $this->partModel->getList();

        if (Request::old('position')) {
            $data['position'] = Request::old('position');
        } elseif (!empty($info)) {
            $positions = $this->staffModel->getIdPositionByStaff($id);
            $data['position'] = [];
            if ($positions) {
                foreach ($positions as $position) {
                    $data['position'][] = $position->position_id;
                }
            }
        } else {
            $data['position'] = [];
        }

        $data['positions'] = $this->positionModel->getList();

        if (Request::old('status')) {
            $data['status'] = Request::old('status');
        } elseif (!empty($info)) {
            $data['status'] = $info->status;
        } else {
            $data['status'] = 1;
        }

        $data['text_modified'] = !empty($info) ? trans('main.text_edit') : trans('main.text_add');

        return view('staff.staff_form', $data);
    }

    public function info($id) {

        if (!$id) {
            flash_error(trans('main.error_error'));
            return redirect('staff');
        }

        $data['info'] = $this->staffModel->getById((int)$id);

        $data['cancel'] = url('staff');

        $parts = $this->staffModel->getPartByStaff($id);
        $data['parts'] = [];
        if ($parts) {
            foreach ($parts as $part) {
                $data['parts'][] = $part->name;
            }
        }

        $positions = $this->staffModel->getPositionByStaff($id);
        $data['positions'] = [];
        if ($positions) {
            foreach ($positions as $position) {
                $data['positions'][] = $position->name;
            }
        }

        $data['text_modified'] = trans('main.text_view_info');
        return view('staff.staff_info', $data);
    }

    public function add() {
        $validator = $this->validateForm();
        if ($validator->fails()) {
            flash_error(trans('main.error_form'));
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            $id = $this->staffModel->add(Request::all());

            $mail_init = [
                'name_from' => 'Staff Administrator',
                'from' => 'admin@staff.com',
                'to' => Request::input('email'),
                'subject' => trans('mail.welcome'),
                'view' => 'email.created_account',
            ];
            $info = [
                'name' => Request::input('name'),
                'url_login' => url('/'),
                'username' => Request::input('username'),
                'password' => Request::input('password'),
            ];

            mail_init($mail_init);
            mail_send($info);

            flash_success(trans('main.text_success_form'));

            switch (Request::input('_redirect')) {
                case 'add':
                    return redirect('staff/add');
                case 'edit':
                    return redirect('staff/edit/' . $id);
                default:
                    return redirect('staff');
            }
        }
    }

    public function edit($id) {
        if (!(int)$id) {
            flash_error(trans('main.error_error'));
            return redirect('staff');
        } else {
            $validator = $this->validateForm();
            if ($validator->fails()) {
                flash_error(trans('main.error_form'));
                return Redirect::back()->withErrors($validator)->withInput();
            } else {
                $this->staffModel->edit((int)$id, Request::all());
                flash_success(trans('main.text_success_form'));

                switch (Request::input('_redirect')) {
                    case 'add':
                        return redirect('staff/add');
                    case 'edit':
                        return redirect('staff/edit/' . (int)$id);
                    default:
                        return redirect('staff');
                }
            }
        }
    }

    public function delete() {
        if (!$this->validateDelete()){
            flash_warning(trans('main.error_delete'));
            return redirect('staff');
        }

        foreach (Request::input('id') as $id) {
            $this->staffModel->delete((int)$id);
        }

        flash_success(trans('main.text_success_form'));
        return redirect('staff');
    }

    public function resetPassword($id) {

        return redirect('staff');
    }

    protected function validateForm($id = null) {
        $rules = [
            'name' => 'required|between:2,32',
            'telephone' => 'required',
            'email' => 'required|email_exist:' . $id,
            'username' => 'required|between:5,96|username_exist:' . $id,
            'password' => 'required|between:5,96',
        ];

        $messages = [
            'name.required' => trans('staff.error_name'),
            'name.between' => trans('staff.error_name'),
            'telephone.required' => trans('staff.error_telephone'),
            'email.required' => trans('staff.error_email'),
            'email.email_exist' => trans('staff.error_email_exist'),
            'username.required' => trans('staff.error_username'),
            'username.between' => trans('staff.error_username'),
            'password.required' => trans('staff.error_password'),
            'password.between' => trans('staff.error_password'),
            'username.username_exist' => trans('staff.error_username_exist'),
        ];

        $validator = Validator::make(Request::all(), $rules, $messages);

        $validator->addExtension('email_exist', function ($attribute, $value, $parameters, $validator) {
            if ($staff = $this->staffModel->checkEmailExist($value)) {
                if (!is_null($parameters[0]) && $parameters[0]){
                    if ($parameters[0] != $staff->id){
                        return false;
                    }
                }else{
                    return false;
                }
            }
            return true;
        });

        $validator->addExtension('username_exist', function ($attribute, $value, $parameters, $validator) {
            if ($staff = $this->staffModel->checkUsernameExist($value)) {
                if (!is_null($parameters[0]) && $parameters[0]){
                    if ($parameters[0] != $staff->id){
                        return false;
                    }
                }else{
                    return false;
                }
            }
            return true;
        });

        return $validator;
    }

    protected function validateDelete() {
        if (!Request::input('id')) {
            return false;
        }
        return true;
    }
}
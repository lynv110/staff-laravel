<?php

namespace App\Http\Controllers\Staff;

use App\Facades\Staff;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\PartModel;
use App\Models\PositionModel;
use App\Models\StaffModel;
use Illuminate\Support\Facades\Request;

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

        if ($filterName || (isset($filterStatus) && $filterStatus != '' || $filterTelephone || $filterEmail)) {

            $url .= '?filter';

            if ($filterName) {
                $url .= '&filter_name=' . $filterName;
            }

            if ($filterTelephone) {
                $url .= '&filter_telephone=' . $filterTelephone;
            }

            if ($filterEmail) {
                $url .= '&filter_email=' . $filterEmail;
            }

            if ($filterStatus) {
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

        $data['id'] = $id;

        $data['reset_pass'] = 0;
        if (!empty($info)) {
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

        if (Request::old('avatar')) {
            $data['thumb'] = Request::old('avatar');
        } elseif (!empty($info)) {
            $data['thumb'] = image_fit($info->avatar, 100, 100);
        } else {
            $data['thumb'] = no_image();
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
            $data['password'] = '';
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

    public function add(StaffRequest $request) {
        $id = $this->staffModel->add(Request::all());

        $info = [
            'name_to' => Request::input('name'),
            'email_to' => html_entity_decode(Request::input('email'), ENT_QUOTES, 'UTF-8'),
            'subject' => trans('mail.welcome'),
            'data' => [
                'name' => Request::input('name'),
                'username' => Request::input('username'),
                'password' => Request::input('password'),
                'welcome' => trans('mail.welcome')
            ],
        ];

        $this->sendMail($info);

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

    public function edit($id, StaffRequest $request) {
        if (!(int)$id) {
            flash_error(trans('main.error_error'));
            return redirect('staff');
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

    public function delete() {
        if (!$this->validateExistId()) {
            flash_warning(trans('main.error_delete'));
            return redirect('staff');
        }

        foreach (Request::input('id') as $id) {
            $this->staffModel->delete((int)$id);
        }

        flash_success(trans('main.text_success_form'));
        return redirect('staff');
    }

    protected function validateExistId() {
        if (!Request::input('id')) {
            return false;
        }
        return true;
    }

    public function resetPassword($id = null) {

        if (!is_null($id) && $id) {
            $staff = $this->staffModel->getById((int)$id);
            if ($staff) {

                $password = str_random(mt_rand(6, 10));

                $this->staffModel->resetPassword($id, $password);

                $info = [
                    'name_to' => $staff->name,
                    'email_to' => $staff->email,
                    'subject' => trans('mail.reset_welcome'),
                    'data' => [
                        'name' => $staff->name,
                        'username' => $staff->username,
                        'password' => $password,
                        'welcome' => trans('mail.reset_welcome')
                    ],
                ];

                $this->sendMail($info);

                flash_success(trans('staff.text_success_reset'));
            } else {
                flash_error(trans('staff.error_not_exist'));
            }
        } else {
            if (!$this->validateExistId()) {
                flash_error(trans('staff.error_not_select'));
                return redirect('staff');
            }

            foreach (Request::input('id') as $id) {
                $staff = $this->staffModel->getById((int)$id);
                if ($staff) {

                    $password = str_random(mt_rand(6, 10));

                    $this->staffModel->resetPassword($id, $password);
                    $info = [
                        'name_to' => $staff->name,
                        'email_to' => $staff->email,
                        'subject' => trans('mail.reset_welcome'),
                        'data' => [
                            'name' => $staff->name,
                            'username' => $staff->username,
                            'password' => $password,
                            'welcome' => trans('mail.reset_welcome')
                        ],
                    ];

                    $this->sendMail($info);
                }
            }

            flash_success(trans('staff.text_success_reset'));
        }
        return redirect('staff');
    }

    protected function sendMail($info){

        $mail_init = [
            'name_from' => 'Staff Administrator',
            'name_to' => isset($info['name_to']) ? $info['name_to'] : '',
            'from' => 'admin@staff.com',
            'to' => isset($info['email_to']) ? $info['email_to'] : '',
            'subject' => isset($info['subject']) ? $info['subject'] : trans('email.hello'),
        ];
        $info = [
            'name' => isset($info['data']['name']) ? $info['data']['name'] : '',
            'url_login' => url('/'),
            'username' => isset($info['data']['username']) ? $info['data']['username'] : '',
            'password' => isset($info['data']['password']) ? $info['data']['password'] : '',
            'welcome' => isset($info['data']['welcome']) ? $info['data']['welcome'] : trans('email.hello'),
        ];

        mail_send($mail_init, $info, 'email.mail');
    }
}
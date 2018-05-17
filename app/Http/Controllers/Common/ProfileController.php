<?php

namespace App\Http\Controllers\Common;

use App\Facades\Staff;
use App\Http\Requests\StaffRequest;
use App\Models\StaffModel;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    private $staffModel;

    public function __construct(StaffModel $staffModel) {
        $this->staffModel = $staffModel;
    }

    public function info(){
        $data['info'] = $this->staffModel->getById(Staff::getId());

        $parts = $this->staffModel->getPartByStaff(Staff::getId());
        $data['parts'] = [];
        if ($parts) {
            foreach ($parts as $part) {
                $data['parts'][] = $part->name;
            }
        }

        $positions = $this->staffModel->getPositionByStaff(Staff::getId());
        $data['positions'] = [];
        if ($positions) {
            foreach ($positions as $position) {
                $data['positions'][] = $position->name;
            }
        }

        $data['text_modified'] = trans('main.text_view_info');
        return view('common.profile', $data);
    }

    public function getForm() {
        $info = $this->staffModel->getById(Staff::getId());

        $data['action'] = url('profile/edit');

        $data['cancel'] = url('profile');

        if (Request::old('name')) {
            $data['name'] = Request::old('name');
        } else {
            $data['name'] = $info->name;
        }

        if (Request::old('telephone')) {
            $data['telephone'] = Request::old('telephone');
        } else {
            $data['telephone'] = $info->telephone;
        }

        if (Request::old('address')) {
            $data['address'] = Request::old('address');
        } else {
            $data['address'] = $info->address;
        }

        if (Request::old('gender')) {
            $data['gender'] = Request::old('gender');
        } else {
            $data['gender'] = $info->gender;
        }

        if (Request::old('email')) {
            $data['email'] = Request::old('email');
        } else {
            $data['email'] = $info->email;
        }

        if (Request::old('avatar')) {
            $data['avatar'] = Request::old('avatar');
        } else {
            $data['avatar'] = $info->avatar;
        }

        if (Request::old('avatar')) {
            $data['thumb'] = Request::old('avatar');
        } else {
            $data['thumb'] = image_fit($info->avatar, 100, 100);
        }

        if (Request::old('username')) {
            $data['username'] = Request::old('username');
        } else {
            $data['username'] = $info->username;
        }

        if (Request::old('password')) {
            $data['password'] = Request::old('password');
        } else {
            $data['password'] = '';
        }

        if (Request::old('password2')) {
            $data['password2'] = Request::old('password2');
        } else {
            $data['password2'] = '';
        }

        if (Request::old('birthday')) {
            $data['birthday'] = Request::old('birthday');
        } else {
            $data['birthday'] = $info->birthday;
        }

        $data['text_modified'] = !empty($info) ? trans('main.text_edit') : trans('main.text_add');

        return view('common.profile_form', $data);
    }

    public function edit(StaffRequest $request){
        $this->staffModel->updateProfile(Request::all());

        flash_success(trans('main.text_success_form'));

        switch (Request::input('_redirect')) {
            case 'edit':
                return redirect('profile/edit');
            default:
                return redirect('profile');
        }
    }
}

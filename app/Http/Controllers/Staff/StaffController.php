<?php

namespace App\Http\Controllers\Staff;

use App\Facades\Staff;
use App\Http\Controllers\Controller;
use App\Models\PartModel;
use App\Models\PositionModel;
use App\Models\StaffModel;
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
        $filterStatus = Request::has('filter_status') ? Request::get('filter_status') : '';

        $filter = [
            'filter_name' => $filterName,
            'filter_status' => $filterStatus,
            'sort' => 'name',
            'order' => 'asc',
        ];

        $data['staffs'] = $this->staffModel->getList($filter);

        $url = url('staff');

        if ($filterName || (isset($filterStatus) && $filterStatus != '') ) {

            $url .= '?filter';

            if ($filterName){
                $url .= '&filter_name=' . $filterName;
            }

            if ($filterStatus){
                $url .= '&filter_status=' . $filterStatus;
            }
        }

        $data['staffs']->setPath($url);

        $data['filter_name'] = $filterName;
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

        if (Request::old('birthday')) {
            $data['birthday'] = Request::old('birthday');
        } elseif (!empty($info)) {
            $data['birthday'] = $info->birthday;
        } else {
            $data['birthday'] = '';
        }

        /*if (Request::old('part')) {
            $data['part'] = Request::old('part');
        } elseif (!empty($info)) {
            $data['part'] = [];//
        } else {
            $data['part'] = [];
        }*/

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

    public function add() {
        $validator = $this->validateForm();
        if ($validator->fails()) {
            flash_error(trans('main.error_form'));
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            $id = $this->staffModel->add(Request::all());
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

    protected function validateForm() {
        $rules = [
            'name' => 'required|between:5,95'
        ];

        $messages = [
            'name.required' => trans('staff.error_name'),
            'name.between' => trans('staff.error_name'),
        ];

        return Validator::make(Request::all(), $rules, $messages);
    }

    protected function validateDelete() {
        if (!Request::input('id')) {
            return false;
        }
        return true;
    }
}
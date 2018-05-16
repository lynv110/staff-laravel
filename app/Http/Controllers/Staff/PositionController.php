<?php

namespace App\Http\Controllers\Staff;

use App\Facades\Staff;
use App\Http\Controllers\Controller;
use App\Models\PositionModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller {
    private $positionModel;

    public function __construct(PositionModel $positionModel) {
        $this->positionModel = $positionModel;
    }

    public function index() {
        if (!Staff::isRoot()) {
            flash_error(trans('position.text_permission'));
            return redirect(route('_dashboard'));
        }

        $filterName = Request::get('filter_name') ? Request::get('filter_name') : '';
        $filterStatus = Request::has('filter_status') ? Request::get('filter_status') : '';

        $filter = [
            'filter_name' => $filterName,
            'filter_status' => $filterStatus,
            'sort' => 'name',
            'order' => 'asc',
            'paginate' => true,
        ];

        $data['positions'] = $this->positionModel->getList($filter);

        $url = url('position');

        if ($filterName || (isset($filterStatus) && $filterStatus != '') ) {

            $url .= '?filter';

            if ($filterName){
                $url .= '&filter_name=' . $filterName;
            }

            if ($filterStatus){
                $url .= '&filter_status=' . $filterStatus;
            }
        }

        $data['positions']->setPath($url);

        $data['filter_name'] = $filterName;
        $data['filter_status'] = $filterStatus;

        return view('staff.position_list', $data);
    }

    public function getForm($id = null) {

        if ($id) {
            $info = $this->positionModel->getById((int)$id);
        }

        if (isset($id)) {
            $data['action'] = url('position/edit/' . (int)$id);
        } else {
            $data['action'] = url('position/add');
        }

        $data['cancel'] = url('position');

        if (Request::old('name')) {
            $data['name'] = Request::old('name');
        } elseif (!empty($info)) {
            $data['name'] = $info->name;
        } else {
            $data['name'] = '';
        }

        if (Request::old('sort_order')) {
            $data['sort_order'] = Request::old('sort_order');
        } elseif (!empty($info)) {
            $data['sort_order'] = $info->sort_order;
        } else {
            $data['sort_order'] = 0;
        }

        if (Request::old('sort_permission')) {
            $data['sort_permission'] = Request::old('sort_permission');
        } elseif (!empty($info)) {
            $data['sort_permission'] = $info->sort_permission;
        } else {
            $data['sort_permission'] = 0;
        }

        if (Request::old('status')) {
            $data['status'] = Request::old('status');
        } elseif (!empty($info)) {
            $data['status'] = $info->status;
        } else {
            $data['status'] = 1;
        }

        $data['sort_permission_exist'] = [];
        if ($sortPermissions = $this->positionModel->getSortPermissions()) {
            foreach ($sortPermissions as $sortPermission) {
                $data['sort_permission_exist'][] = $sortPermission->sort_permission;
            }
        }

        $data['text_modified'] = !empty($info) ? trans('main.text_edit') : trans('main.text_add');

        return view('staff.position_form', $data);
    }

    public function add() {
        $validator = $this->validateForm();
        if ($validator->fails()) {
            flash_error(trans('main.error_form'));
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            $id = $this->positionModel->add(Request::all());
            flash_success(trans('main.text_success_form'));

            switch (Request::input('_redirect')) {
                case 'add':
                    return redirect('position/add');
                case 'edit':
                    return redirect('position/edit/' . $id);
                default:
                    return redirect('position');
            }
        }
    }

    public function edit($id) {
        if (!(int)$id) {
            flash_error(trans('main.error_error'));
            return redirect('position');
        } else {
            $validator = $this->validateForm($id);
            if ($validator->fails()) {
                flash_error(trans('main.error_form'));
                return Redirect::back()->withErrors($validator)->withInput();
            } else {
                $this->positionModel->edit((int)$id, Request::all());
                flash_success(trans('main.text_success_form'));

                switch (Request::input('_redirect')) {
                    case 'add':
                        return redirect('position/add');
                    case 'edit':
                        return redirect('position/edit/' . (int)$id);
                    default:
                        return redirect('position');
                }
            }
        }
    }

    public function delete() {
        if (!$this->validateDelete()){
            flash_error(trans('main.error_delete_option'));
            return redirect('position');
        }

        foreach (Request::input('id') as $id) {
            $this->positionModel->delete((int)$id);
        }

        flash_success(trans('main.text_success_form'));
        return redirect('position');
    }

    protected function validateForm($id = null) {
        $rules = [
            'name' => 'required|between:5,95',
            'sort_permission' => 'required|min:1|max:120|exist:' . $id,
        ];

        $messages = [
            'name.required' => trans('position.error_name'),
            'name.between' => trans('position.error_name'),
            'sort_permission.required' => trans('position.error_sort_permission'),
            'sort_permission.max' => trans('position.error_sort_permission'),
            'sort_permission.min' => trans('position.error_sort_permission'),
            'sort_permission.exist' => trans('position.error_sort_permission_exit'),
        ];

        $validator = Validator::make(Request::all(), $rules, $messages);

        $validator->addExtension('exist', function ($attribute, $value, $parameters, $validator) {
            if ($sortPermissions = $this->positionModel->getSortPermissions()) {
                $position = $parameters[0] ? $this->positionModel->getById($parameters[0]) : [];
                foreach ($sortPermissions as $sortPermission) {
                    if ($position) {
                        if (($value == $sortPermission->sort_permission) && ($value != $position->sort_permission)) {
                            return false;
                            break;
                        }
                    }else{
                        if ($value == $sortPermission->sort_permission) {
                            return false;
                            break;
                        }
                    }
                }
            }
            return true;
        });

        return $validator;
    }

    protected function validateDelete() {
        $ids = Request::input('id');
        if (!$ids) {
            return false;
        }

        $idsPositionUsed = $this->positionModel->getPositionIdUsed();
        $positionUsed = [];
        if ($idsPositionUsed) {
            foreach ($idsPositionUsed as $item) {
                $positionUsed[] = $item->position_id;
            }
        }

        foreach ($ids as $id) {
            if (in_array($id, $positionUsed)){
                return false;
            }
        }

        return true;
    }
}

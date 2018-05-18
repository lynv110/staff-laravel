<?php

namespace App\Http\Controllers\Staff;

use App\Facades\Staff;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
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

        $filterName = Request::get('filter_name') ? Request::get('filter_name') : '';
        $filterStatus = Request::has('filter_status') ? Request::get('filter_status') : '';

        $filter = [
            'filter_name' => $filterName,
            'filter_status' => $filterStatus,
            'sort' => 'sort_permission',
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

        $data['id'] = $id;

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

    public function add(PositionRequest $request) {
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

    public function edit($id, PositionRequest $request) {
        if (!(int)$id) {
            flash_error(trans('main.error_error'));
            return redirect('position');
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

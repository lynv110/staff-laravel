<?php

namespace App\Http\Controllers\Common;

use App\Facades\Staff;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\StaffModel;

class UpdatePasswordController extends Controller {

    private $staffModel;

    public function __construct(StaffModel $staffModel) {
        $this->staffModel = $staffModel;
    }

    public function getForm() {

        if (Staff::getChangedPassword()){
            return redirect(route('_dashboard'));
        }

        if (!Staff::isLogged()) {
            return redirect(route('_login'));
        }

        return view('common.update_password');
    }

    public function change(UpdatePasswordRequest $request) {
        $this->staffModel->updatePassword($request->input('password'));
        flash_success(trans('common/common.text_update_success'));
        return redirect(route('_dashboard'));
    }
}
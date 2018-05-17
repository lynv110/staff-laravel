<?php

namespace App\Providers;

use App\Models\PositionModel;
use App\Models\StaffModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationExtensionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->validatePosition();
        $this->validateStaff();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function validatePosition(){
        $positionModel = new PositionModel();

        Validator::extend('position_exist', function ($attribute, $value, $parameters, $validator) use ($positionModel){
            if ($sortPermissions = $positionModel->getSortPermissions()) {
                $position = $parameters[0] ? $positionModel->getById($parameters[0]) : [];
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
    }

    protected function validateStaff(){
        $staffModel = new StaffModel();

        Validator::extend('staff_email_exist', function ($attribute, $value, $parameters, $validator) use ($staffModel){
            if ($staff = $staffModel->checkEmailExist($value)) {
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

        Validator::extend('staff_username_exist', function ($attribute, $value, $parameters, $validator) use ($staffModel){
            if ($staff = $staffModel->checkUsernameExist($value)) {
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

        Validator::extend('staff_password', function ($attribute, $value, $parameters, $validator) use ($staffModel){
            if ($value && (strlen($value) < 5 || strlen($value) > 96)) {
                return false;
            }
            return true;
        });

    }
}

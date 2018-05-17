<?php

namespace App\Libraries;

use App\Models\LoginModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Staff {
    protected $id;
    protected $name;
    protected $telephone;
    protected $email;
    protected $changedPassword;
    protected $isRoot;
    protected $username;
    protected $password;
    protected $avatar;
    protected $attributes = ['id', 'name', 'telephone', 'email', 'changed_password', 'is_root', 'username', 'avatar', 'password'];

    private $loginModel;

    public function __construct(LoginModel $loginModel) {
        $this->loginModel = $loginModel;
        if (Session::has('staff_id') && Session::get('staff_id')) {
            $staff = $this->loginModel->getStaffById(Session::get('staff_id'));
            if ($staff) {
                foreach ($this->attributes as $attribute) {
                    $this->{camel_case($attribute)} = $staff->{$attribute};
                }
                $this->loginModel->updateLogged(Session::get('staff_id'));
            } else {
                $this->logout();
            }
        } else {
            foreach ($this->attributes as $attribute) {
                $this->{camel_case($attribute)} = '';
            }
        }
    }

    public function login($username, $password) {
        $staff = $this->loginModel->getStaffByUsername($username);
        if ($staff) {
            if (Hash::check($password, $staff->password)) {
                foreach ($this->attributes as $attribute) {
                    $this->{camel_case($attribute)} = $staff->{$attribute};
                }
                Session::put('staff_id', $this->id);
                return true;
            }
        }
        return false;
    }

    public function logout() {
        Session::flush();
        foreach ($this->attributes as $attribute) {
            $this->{camel_case($attribute)} = '';
        }
    }

    public function isLogged() {
        return $this->id;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function getChangedPassword() {
        return $this->changedPassword;
    }

    public function isRoot() {
        return $this->isRoot;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }
}
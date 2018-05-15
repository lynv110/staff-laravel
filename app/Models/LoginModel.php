<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class LoginModel
{
    private $table = 'staff';

    public function getStaffById($id){
        $staff = DB::table($this->table)->where('id', $id)->first();
        if (!$staff)
            return [];
        return $staff;
    }

    public function getStaffByUsername($username){
        $staff = DB::table($this->table)->where([
            ['username', $username],
            ['status', 1],
        ])->first();
        if (!$staff)
            return [];
        return $staff;
    }

    public function updateLogged($id){
        DB::table($this->table)->where('id', $id)->update([
            'login_at' => date('Y-m-d H:i:s', time())
        ]);
    }
}
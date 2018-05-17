<?php

namespace App\Models;

use App\Facades\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffModel {
    protected $tablePart = 'part';
    protected $tablePosition = 'position';
    protected $tableStaff = 'staff';
    protected $tableStaffPart = 'staff_part';
    protected $tableStaffPosition = 'staff_position';

    public function add($data) {
        $id = DB::table($this->tableStaff)->insertGetId([
            'name' => $data['name'],
            'telephone' => $data['telephone'],
            'address' => $data['address'],
            'gender' => (int)$data['gender'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
            'birthday' => $data['birthday'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'status' => (int)$data['status'],
            'changed_password' => 0,
            'is_root' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'modified_at' => date('Y-m-d H:i:s'),
        ]);

        if (isset($data['part'])) {
            foreach ($data['part'] as $part) {
                DB::table($this->tableStaffPart)->insert([
                    'staff_id' => $id,
                    'part_id' => $part,
                ]);
            }
        }

        if (isset($data['position'])) {
            foreach ($data['position'] as $position) {
                DB::table($this->tableStaffPosition)->insert([
                    'staff_id' => $id,
                    'position_id' => $position,
                ]);
            }
        }

        return $id;
    }

    public function edit($id, $data) {
        DB::table($this->tableStaff)->where('id', $id)->update([
            'name' => $data['name'],
            'telephone' => $data['telephone'],
            'address' => $data['address'],
            'gender' => (int)$data['gender'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
            'birthday' => $data['birthday'],
            'username' => $data['username'],
            'status' => (int)$data['status'],
            'is_root' => 0,
            'modified_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($this->tableStaffPart)->where('staff_id', $id)->delete();
        if (isset($data['part'])) {
            foreach ($data['part'] as $part) {
                DB::table($this->tableStaffPart)->insert([
                    'staff_id' => $id,
                    'part_id' => $part,
                ]);
            }
        }

        DB::table($this->tableStaffPosition)->where('staff_id', $id)->delete();
        if (isset($data['position'])) {
            foreach ($data['position'] as $position) {
                DB::table($this->tableStaffPosition)->insert([
                    'staff_id' => $id,
                    'position_id' => $position,
                ]);
            }
        }
    }

    public function delete($id) {
        DB::table($this->tableStaffPart)->where('staff_id', $id)->delete();
        DB::table($this->tableStaffPosition)->where('staff_id', $id)->delete();
        DB::table($this->tableStaff)->where('id', $id)->delete();
    }

    public function getList($data = []) {
        $where = 'is_root = 0';

        if (isset($data['filter_name']) && $data['filter_name']) {
            $explodes = explode(' ', $data['filter_name']);
            foreach ($explodes as $explode) {
                $explode = str_replace(['/', '\'', '"'], '', $explode);
                $where .= " AND name LIKE '%" . $explode . "%'";
            }
        }

        if (isset($data['filter_telephone']) && $data['filter_telephone']) {
            $where .= " AND telephone LIKE '%" . $data['filter_telephone'] . "%'";
        }

        if (isset($data['filter_email']) && $data['filter_email']) {
            $where .= " AND email = '" . $data['filter_email'] . "'";
        }

        if (isset($data['filter_status']) && ($data['filter_status'] != '')) {
            $where .= " AND status = '" . (int)$data['filter_status'] . "'";
        }

        $dataSort = [
            'name' => 'name',
            'status' => 'status',
            'created_at' => 'created_at',
        ];

        $order = '';
        if (isset($data['sort'])) {
            if (in_array($data['sort'], array_keys($dataSort))) {
                $order .= " " . $dataSort[$data['sort']] . "";
            } else {
                $order .= " name";
            }
        } else {
            $order .= " name";
        }

        if (isset($data['order']) && $data['order']) {
            if (strtolower($data['sort']) == 'desc') {
                $order .= " DESC";
            } else {
                $order .= " ASC";
            }
        } else {
            $order .= " ASC";
        }

        if (isset($data['paginate']) && $data['paginate']) {
            return DB::table($this->tableStaff)->whereRaw($where)->orderByRaw($order)->paginate(config('main.limit'));
        }

        return DB::table($this->tableStaff)->whereRaw($where)->orderByRaw($order)->get();
    }

    public function getById($id) {
        return DB::table($this->tableStaff)->where('id', $id)->first();
    }

    public function getIdPartByStaff($id) {
        return DB::table($this->tableStaffPart)->where('staff_id', $id)->get();
    }

    public function getIdPositionByStaff($id) {
        return DB::table($this->tableStaffPosition)->where('staff_id', $id)->get();
    }

    public function checkEmailExist($email) {
        return DB::table($this->tableStaff)->where('email', $email)->first();
    }

    public function checkUsernameExist($username) {
        return DB::table($this->tableStaff)->where('username', $username)->first();
    }

    public function getPartByStaff($id) {
        return DB::table($this->tableStaffPart)->select($this->tablePart . '.name')->leftJoin($this->tablePart, $this->tableStaffPart . '.part_id', '=', $this->tablePart . '.id')->where($this->tableStaffPart . '.staff_id', $id)->get();
    }

    public function getPositionByStaff($id) {
        return DB::table($this->tableStaffPosition)->select($this->tablePosition . '.name')->leftJoin($this->tablePosition, $this->tableStaffPosition . '.position_id', '=', $this->tablePosition . '.id')->where($this->tableStaffPosition . '.staff_id', $id)->get();
    }

    public function resetPassword($id, $password) {
        DB::table($this->tableStaff)->where('id', $id)->update([
            'password' => Hash::make($password),
            'changed_password' => 0,
            'modified_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function updateProfile($data) {
        DB::table($this->tableStaff)->where('id', Staff::getId())->update([
            'name' => $data['name'],
            'telephone' => $data['telephone'],
            'address' => $data['address'],
            'gender' => (int)$data['gender'],
            'avatar' => $data['avatar'],
            'birthday' => $data['birthday'],
            'username' => $data['username'],
            'modified_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($this->tableStaffPart)->where('staff_id', Staff::getId())->delete();
        if (isset($data['part'])) {
            foreach ($data['part'] as $part) {
                DB::table($this->tableStaffPart)->insert([
                    'staff_id' => Staff::getId(),
                    'part_id' => $part,
                ]);
            }
        }

        DB::table($this->tableStaffPosition)->where('staff_id', Staff::getId())->delete();
        if (isset($data['position'])) {
            foreach ($data['position'] as $position) {
                DB::table($this->tableStaffPosition)->insert([
                    'staff_id' => Staff::getId(),
                    'position_id' => $position,
                ]);
            }
        }

        if (isset($data['email'])) {
            DB::table($this->tableStaff)->where('id', Staff::getId())->update([
                'email' => $data['email'],
            ]);
        }

        if (isset($data['password'])) {
            DB::table($this->tableStaff)->where('id', Staff::getId())->update([
                'password' => Hash::make($data['password']),
            ]);
        }
    }
}
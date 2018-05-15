<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class StaffModel {
    protected $tablePart = 'part';
    protected $tablePosition = 'position';
    protected $tableStaff = 'staff';

    public function add($data) {
        return DB::table($this->tableStaff)->insertGetId([
            'name' => $data['name'],
            'telephone' => $data['telephone'],
            'address' => $data['address'],
            'gender' => (int)$data['gender'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
            'username' => $data['username'],
            'password' => $data['password'],
            'status' => (int)$data['status'],
            'changed_password' => 0,
            'is_root' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'modified_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function edit($id, $data) {
        DB::table($this->tableStaff)->where('id', $id)->update([
            'name' => $data['name'],
            'telephone' => $data['telephone'],
            'address' => $data['address'],
            'gender' => (int)$data['gender'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
            'username' => $data['username'],
            'password' => $data['password'],
            'status' => (int)$data['status'],
            'is_root' => 0,
            'modified_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function delete($id) {
        DB::table($this->tableStaff)->where('id', $id)->delete();
    }

    public function getList($data) {
        $where = 'is_root = 0';

        if ($data['filter_name']) {
            $explodes = explode(' ', $data['filter_name']);
            foreach ($explodes as $explode) {
                $explode = str_replace(['/', '\'', '"'], '', $explode);
                $where .= " AND name LIKE '%" . $explode . "%'";
            }
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
        if ($data['sort']) {
            if (in_array($data['sort'], array_keys($dataSort))) {
                $order .= " " . $dataSort[$data['sort']] . "";
            } else {
                $order .= " name";
            }
        } else {
            $order .= " name";
        }

        if ($data['order']) {
            if (strtolower($data['sort']) == 'desc') {
                $order .= " DESC";
            } else {
                $order .= " ASC";
            }
        } else {
            $order .= " ASC";
        }

        return DB::table($this->tableStaff)->whereRaw($where)->orderByRaw($order)->paginate(config('main.limit'));
    }

    public function getById($id) {
        return DB::table($this->tableStaff)->where('id', $id)->first();
    }
}
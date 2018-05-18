<?php

namespace App\Models;

use App\Facades\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PublicModel {
    protected $tableStaff = 'staff';

    public function getList($data = []) {
        $where = 'is_root = 0 AND status = 1';

        if (isset($data['filter_name']) && $data['filter_name']) {
            $explodes = explode(' ', $data['filter_name']);
            foreach ($explodes as $explode) {
                $explode = str_replace(['/', '\'', '"'], '', $explode);
                $where .= " AND name LIKE '%" . $explode . "%'";
            }
        }

        return DB::table($this->tableStaff)->whereRaw($where)->orderBy('name')->get();
    }

    public function getListWhereIn($field, $data) {

        return DB::table($this->tableStaff)->whereIn($field, $data)->orderBy('name')->get();
    }
}
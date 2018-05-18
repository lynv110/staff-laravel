<?php

namespace App\Models;

use App\Facades\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PublicModel {
    protected $tablePart = 'part';
    protected $tablePosition = 'position';
    protected $tableStaff = 'staff';
    protected $tableStaffPart = 'staff_part';
    protected $tableStaffPosition = 'staff_position';

    public function getList($data = []) {
        $where = 'is_root = 0 AND status = 1';

        if (isset($data['filter_name']) && $data['filter_name']) {
            $explodes = explode(' ', $data['filter_name']);
            foreach ($explodes as $explode) {
                $explode = str_replace(['/', '\'', '"'], '', $explode);
                $where .= " AND name LIKE '%" . $explode . "%'";
            }
        }

        return DB::table($this->tableStaff)->select('id', 'name')->whereRaw($where)->orderBy('name')->get();
    }
}
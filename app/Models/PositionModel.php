<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class PositionModel
{
    protected $tablePosition = 'position';

    public function add($data){
        return DB::table($this->tablePosition)->insertGetId([
            'name' => $data['name'],
            'sort_order' => (int)$data['sort_order'],
            'sort_permission' => (int)$data['sort_permission'],
            'status' => (int)$data['status'],
            'created_at' => date('Y-m-d H:i:s'),
            'modified_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function edit($id, $data){
        DB::table($this->tablePosition)->where('id', $id)->update([
            'name' => $data['name'],
            'sort_order' => (int)$data['sort_order'],
            'sort_permission' => (int)$data['sort_permission'],
            'status' => (int)$data['status'],
            'modified_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function delete($id){
        DB::table($this->tablePosition)->where('id', $id)->delete();
    }

    public function getList($data){
        $where = '1';

        if ($data['filter_name']){
            $explodes = explode(' ', $data['filter_name']);
            foreach ($explodes as $explode){
                $explode = str_replace(['/', '\'', '"'],'', $explode );
                $where .= " AND name LIKE '%" . $explode . "%'";
            }
        }

        if (isset($data['filter_status']) && ($data['filter_status'] != '')){
            $where .= " AND status = '" . (int)$data['filter_status'] . "'";
        }

        $data_sort = [
            'name' => 'name',
            'sort_order' => 'sort_order',
            'status' => 'status',
            'created_at' => 'created_at',
        ];

        $order = '';
        if ($data['sort']){
            if (in_array($data['sort'], array_keys($data_sort))){
                $order .= " " . $data_sort[$data['sort']] . "";
            }else{
                $order .= " name";
            }
        }else{
            $order .= " name";
        }

        if ($data['order']){
            if (strtolower($data['sort']) == 'desc'){
                $order .= " DESC";
            }else{
                $order .= " ASC";
            }
        }else{
            $order .= " ASC";
        }

        return DB::table($this->tablePosition)->whereRaw($where)->orderByRaw($order)->paginate(2);
    }

    public function getById($id){
        return DB::table($this->tablePosition)->where('id', $id)->first();
    }

    public function getSortPermissions(){
        return DB::table($this->tablePosition)->select('sort_permission')->get();
    }
}
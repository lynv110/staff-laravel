<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class PartModel
{
    protected $tablePart = 'part';

    public function add($data){
        return DB::table($this->tablePart)->insertGetId([
           'name' => $data['name'],
           'sort_order' => (int)$data['sort_order'],
           'status' => (int)$data['status'],
           'created_at' => date('Y-m-d H:i:s'),
           'modified_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function edit($id, $data){
        DB::table($this->tablePart)->where('id', $id)->update([
            'name' => $data['name'],
            'sort_order' => (int)$data['sort_order'],
            'status' => (int)$data['status'],
            'modified_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function delete($id){
        DB::table($this->tablePart)->where('id', $id)->delete();
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

        $dataSort = [
            'name' => 'name',
            'sort_order' => 'sort_order',
            'status' => 'status',
            'created_at' => 'created_at',
        ];

        $order = '';
        if ($data['sort']){
            if (in_array($data['sort'], array_keys($dataSort))){
                $order .= " " . $dataSort[$data['sort']] . "";
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

        return DB::table($this->tablePart)->whereRaw($where)->orderByRaw($order)->paginate(config('main.limit'));
    }

    public function getById($id){
        return DB::table($this->tablePart)->where('id', $id)->first();
    }
}
<?php
namespace CustomTable\Controllers;

use DB;
use vanhenry\manager\model\VDetailTable;

class BaseController
{
    public function __insertPivots($pivots, $itemId, $table)
    {
        $table = $table->table_map;
        foreach ($pivots as $key => $pivot) {
            $vdetail = VDetailTable::where(['parent_name' => $table, 'name' => $key])->first();
            if ($vdetail == null) {
                continue;
            }
            $defaultData = json_decode($vdetail->default_data, true);
            if (!is_array($defaultData)) {
                continue;
            }
            $pivot_table = $defaultData['pivot_table'];
            $target_field = $defaultData['target_field'];
            $origin_field = $defaultData['origin_field'];
            $pivotValues = array_filter(explode(',', $pivot));
            foreach ($pivotValues as $value) {
                \DB::table($pivot_table)->insert([
                    $origin_field => $itemId,
                    $target_field => $value,
                ]);
            }
        }
    }

    public function __updatePivots($pivots, $itemId, $table)
    {
        $table = $table->table_map;
        foreach ($pivots as $key => $pivot) {
            $vdetail = VDetailTable::where(['name' => $key, 'parent_name' => $table])->first();
            if ($vdetail == null) {
                continue;
            }
            $defaultData = json_decode($vdetail->default_data, true);
            if (!is_array($defaultData)) {
                continue;
            }
            $pivot_table = $defaultData['pivot_table'];
            $target_field = $defaultData['target_field'];
            $origin_field = $defaultData['origin_field'];
            $pivotValues = array_filter(explode(',', $pivot));
            foreach ($pivotValues as $value) {
                $pivotDb = \DB::table($pivot_table)->where([$origin_field => $itemId, $target_field => $value])->first();
                if ($pivotDb == null) {
                    \DB::table($pivot_table)->insert([
                        $origin_field => $itemId,
                        $target_field => $value,
                    ]);
                } else {
                    \DB::table($pivot_table)->where([$origin_field => $itemId, $target_field => $value]);
                }
            }
            /*xóa các bản ghi trong bảng pivot không tồn tại trong list user đã chọn*/
            if (count($pivotValues) > 0) {
                \DB::table($pivot_table)->where($origin_field, $itemId)->whereNotIn($target_field, $pivotValues)->delete();
            } else {
                \DB::table($pivot_table)->where($origin_field, $itemId)->delete();
            }
        }
    }

    public function __updateDataMapTable($rs_create, $id, $table)
    {
        $table = $table->table_map;

        if (!empty($rs_create) && count($rs_create) > 0) {
            $data = request()->all();
            $vdetail = VDetailTable::where(['parent_name' => $table, 'name' => array_key_first($rs_create)])->first();
            $defaultData = json_decode($vdetail->default_data, true);
            $dataCreate = [];
            foreach ($data as $key => $value) {
                if (in_array($key, $defaultData['field_duplicate'])) {
                    $dataCreate[$key] = $value;
                }
            }
            $tableInsert = $defaultData['table'];
            $dataCreate[$defaultData['field']] = reset($rs_create);
            $dataCreate[$defaultData['field_relationship']] = $id;
            $dataOld = DB::table($tableInsert)->where($defaultData['field_relationship'], $id)->first();
            if ($dataOld !== null) {
                DB::table($tableInsert)->update($dataCreate);
            } else {
                DB::table($tableInsert)->insert($dataCreate);
            }
        }
    }

    public function __insertCreateDataMapTable($rs_create, $id, $table)
    {
        $table = $table->table_map;
        if (!empty($rs_create) && count($rs_create) > 0) {
            $data = request()->all();
            $vdetail = VDetailTable::where(['parent_name' => $table, 'name' => array_key_first($rs_create)])->first();
            $defaultData = json_decode($vdetail->default_data, true);
            $dataCreate = [];
            foreach ($data as $key => $value) {
                if (in_array($key, $defaultData['field_duplicate'])) {
                    $dataCreate[$key] = $value;
                }
            }
            $tableInsert = $defaultData['table'];
            $dataCreate[$defaultData['field']] = reset($rs_create);
            $dataCreate[$defaultData['field_relationship']] = $id;
            DB::table($tableInsert)->insert($dataCreate);
        }
    }

    public function _updateOutRefernce($outs, $table, $id)
    {
        foreach ($outs as $k => $out) {
            if (is_array($out)) {
                $map = VDetailTable::where("parent_name", $table)->where("name", $k)->first();
                if ($map != null) {
                    $tableRef = $map->more_note;
                    $tableMap = $table . "_" . $tableRef;
                    if (!\Schema::hasTable($tableMap)) {
                        $tableMap = $tableRef . "_" . $table;
                    }
                    if (\Schema::hasTable($tableMap)) {
                        \DB::table($tableMap)->where(\Str::singular($table) . "_id", $id)->delete();
                        foreach ($out as $o) {
                            \DB::table($tableMap)->insert([\Str::singular($table) . "_id" => $id, \Str::singular($tableRef) . "_id" => $o]);
                        }
                    }
                }
            } else {
                $map = VDetailTable::where("parent_name", $table)->where("name", $k)->first();
                if ($map != null) {
                    $tableRef = $map->more_note;
                    $tableMap = $table . "_" . $tableRef;
                    if (!\Schema::hasTable($tableMap)) {
                        $tableMap = $tableRef . "_" . $table;
                    }
                    if (\Schema::hasTable($tableMap)) {
                        \DB::table($tableMap)->where(\Str::singular($table) . "_id", $id)->delete();
                        \DB::table($tableMap)->insert([\Str::singular($table) . "_id" => $id, \Str::singular($tableRef) . "_id" => $out]);
                    }
                }
            }
        }
    }
}

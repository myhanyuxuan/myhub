<?php
// +----------------------------------------------------------------------
// | 进销存模型--产品资料
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Cache;
use think\Db;
use think\image\Exception;
use think\Model;

class StockData extends Model
{
    static $cache_data = 'stock_data';//产品资料缓存标识
    protected $table = 'myhub_stock_data';

    public function _dcache_data(){
        Cache::rm(self::$cache_data);
    }

    public function insertData($data = []){
        try{
            $this->startTrans();
            $this->_check($data,'add');

            $classM = new StockClass();
            $class_list = $classM ->listData();
            $b_name = pinyin_long($class_list[$data['class_id']]['class_name']);

            $inserData = array();
            $inserData['class_id'] = $data['class_id'];
            $inserData['p_name'] = $data['p_name'];
            $inserData['bid'] = $b_name;
            $inserData['spec_id'] = $data['spec_id'];
            $inserData['unit_id'] = $data['unit_id'];
            $inserData['ctime'] = time();

            $r = $this->insertGetId($inserData);
            if(!$r){
                throw new Exception('数据添加失败');
            }
            $updatas = array();
            $updatas['bid'] = $b_name.str_pad($r,6,'0',STR_PAD_LEFT);

            $p = $this->update($updatas,array('id'=>$r));
            if(!$p){
                throw new Exception('数据添加失败');
            }
            $this->commit();

            $this->_dcache_data();
            ajax_data('添加成功');
        }catch(Exception $e){
            $this->rollback();
            ajax_error($e->getMessage());
        }
    }

    public function updataData($data = []){
        try{
            $this->_check($data,'edit');
            $updateData = array();
            $updateData['p_name'] = $data['p_name'];
            $updateData['spec_id'] = $data['spec_id'];
            $updateData['unit_id'] = $data['unit_id'];
            $updateData['etime'] = time();

            $result = $this->update($updateData,array('id'=>$data['id']));
            if(!$result){
                throw new Exception('操作失败');
            }

            $this->_dcache_data();
            ajax_data('操作成功');
        }catch(Exception $e){
            ajax_error($e->getMessage());
        }
    }

    public function deleteData($ids = []){
        $this->_dcache_data();
        foreach($ids as $v){
            $this->where(array('id'=>$v))->delete();
        }
    }

    public function listData($where = [],$field = '*',$page = 0,$order = 'ctime desc',$group = ''){
        $cache_list = Cache::get(self::$cache_data);
        if(!$cache_list){
            $list = Db::table($this->table)->field($field)->where($where)->page($page)->group($group)->order($order)->cache(self::$cache_data)->select();
            $cache_list = array();
            $classM = new StockClass();
            $class_list = $classM ->listData();
            $specM = new StockSpec();
            $spec_list = $specM ->listData();
            $unitM = new StockUnit();
            $unit_list = $unitM ->listData();
            foreach($list as $v){
                $cache_list[$v['id']] = $v;
                $cache_list[$v['id']]['class_name'] = $class_list[$v['class_id']]['class_name'];
                $cache_list[$v['id']]['spec_name'] = $spec_list[$v['spec_id']]['spec_name'];
                $cache_list[$v['id']]['unit_name'] = $unit_list[$v['unit_id']]['com_name'];
                $cache_list[$v['id']]['unit_attr'] = $unit_list[$v['unit_id']]['cap_name'];
            }
            Cache::set(self::$cache_data,$cache_list);
        }
        return $cache_list;
    }

    public function infoData($where = []){
        $list = $this->listData();
        if(!is_numeric($where['id'])){
            return NULL;
        }
        $info = $list[$where['id']];
        return $info;
    }

    protected function _check($data,$scene){
        if($scene == 'add'){
            if(!is_numeric($data['class_id']) || $data['class_id'] == 0){
                throw new Exception('产品大类不合法');
            }
        }
        if(empty($data['p_name'])){
            throw new Exception('产品名称不能为空');
        }
        $where = array();
        if($scene == 'edit'){
            if(!is_numeric($data['id'])){
                throw new Exception('修改id不合法');
            }
            $where['id'] = array('neq',intval($data['id']));
        }
        $where['p_name'] = $data['p_name'];
        $check_name = Db::table($this->table)->where($where)->find();
        if(!empty($check_name)){
            throw new Exception('该产品名称已存在');
        }
        if(!is_numeric($data['spec_id']) || $data['spec_id'] == 0){
            throw new Exception('产品大类不合法');
        }
        if(!is_numeric($data['unit_id']) || $data['unit_id'] == 0){
            throw new Exception('产品大类不合法');
        }
    }
}
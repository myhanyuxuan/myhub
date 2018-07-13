<?php
// +----------------------------------------------------------------------
// | 进销存模型--计量单位
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Cache;
use think\Db;
use think\image\Exception;
use think\Model;

class StockUnit extends Model
{
    static $cache_com = 'stock_unit';//计量单位缓存标识
    protected $table = 'myhub_stock_unit';

    public function _dcache_com(){
        Cache::rm(self::$cache_com);
    }

    public function insertData($data = []){
            try{
                $this->_check($data,'add');
                $inserData = array();
                $inserData['com_name'] = $data['com_name'];
                $inserData['cap_name'] = $data['cap_name'];
                $inserData['ctime'] = time();
                $r = $this->insertGetId($inserData);
                if(!$r){
                    throw new Exception('添加数据失败');
                }

                $this->_dcache_com();
                ajax_data('添加成功');
            }catch(Exception $e){
                ajax_error($e->getMessage());
            }
    }

    public function updataData($data = []){
        try{
            $this->_check($data,'edit');
            $updateData = array();
            $updateData['com_name'] = $data['com_name'];
            $updateData['cap_name'] = $data['cap_name'];
            $updateData['etime'] = time();
            $r = $this->update($updateData,array('id'=>$data['id']));
            if(!$r){
                throw new Exception('修改失败');
            }

            $this->_dcache_com();
            ajax_data('修改成功');
        }catch(Exception $e){
            ajax_error($e->getMessage());
        }
    }

    public function deleteData($ids = []){
        $this->_dcache_com();
        foreach($ids as $v){
            $this->where(array('id'=>$v))->delete();
        }
    }

    public function listData($where = [],$field = '*',$page = 0,$order = 'ctime desc',$group = ''){
        $cache_list = Cache::get(self::$cache_com);
        if(!$cache_list){
            $list =Db::table($this->table)->field($field)->where($where)->page($page)->group($group)->order($order)->cache(self::$cache_com)->select();
            $cache_list = array();
            foreach($list as $v){
                $cache_list[$v['id']] = $v;
            }
            Cache::set(self::$cache_com,$cache_list);
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
        if(empty($data['com_name'])){
            throw new Exception('单位名称不能为空');
        }
        $where = array();
        if($scene == 'edit'){
            if(!is_numeric($data['id'])){
                throw new Exception('修改id不合法');
            }
            $where['id'] = array('neq',intval($data['id']));
        }

        $where['com_name'] = $data['com_name'];
        $check_name = Db::table($this->table)->where($where)->find();
        if(!empty($check_name)){
            throw new Exception('该单位名称已存在');
        }
    }
}
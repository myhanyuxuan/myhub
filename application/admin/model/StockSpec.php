<?php
// +----------------------------------------------------------------------
// | 进销存模型--计量单位
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Cache;
use think\Db;
use think\image\Exception;
use think\Model;

class StockSpec extends Model
{
    static $cache_spec = 'stock_spec';//产品规格缓存标识
    protected $table = 'myhub_stock_spec';

    public function _dcache_spec(){
        Cache::rm(self::$cache_spec);
    }

    public function insertData($data = []){
            try{
                $this->_check($data,'add');
                $inserData = array();
                $inserData['spec_name'] = $data['spec_name'];
                $inserData['ctime'] = time();
                $r = $this->insertGetId($inserData);
                if(!$r){
                    throw new Exception('添加数据失败');
                }

                $this->_dcache_spec();
                ajax_data('添加成功');
            }catch(Exception $e){
                ajax_error($e->getMessage());
            }
    }

    public function updataData($data = []){
        try{
            $this->_check($data,'edit');
            $updateData = array();
            $updateData['spec_name'] = $data['spec_name'];
            $updateData['etime'] = time();
            $r = $this->update($updateData,array('id'=>$data['id']));
            if(!$r){
                throw new Exception('修改失败');
            }

            $this->_dcache_spec();
            ajax_data('修改成功');
        }catch(Exception $e){
            ajax_error($e->getMessage());
        }
    }

    public function deleteData($ids = []){
        $this->_dcache_spec();
        foreach($ids as $v){
            $this->where(array('id'=>$v))->delete();
        }
    }

    public function listData($where = [],$field = '*',$page = 0,$order = 'ctime desc',$group = ''){
        $cache_list = Cache::get(self::$cache_spec);
        if(!$cache_list){
            $cache_list =Db::table($this->table)->field($field)->where($where)->page($page)->group($group)->order($order)->cache(self::$cache_spec)->select();
            Cache::set(self::$cache_spec,$cache_list);
        }
        return $cache_list;
    }

    public function infoData($where = []){
        return $this->where($where)->find();
    }

    protected function _check($data,$scene){
        if(empty($data['spec_name'])){
            throw new Exception('规格名称不能为空');
        }
        $where = array();
        if($scene == 'edit'){
            if(!is_numeric($data['id'])){
                throw new Exception('修改id不合法');
            }
            $where['id'] = array('neq',intval($data['id']));
        }

        $where['spec_name'] = $data['spec_name'];
        $check_name = $this->infoData($where);
        if(!empty($check_name)){
            throw new Exception('该规格名称已存在');
        }
    }
}
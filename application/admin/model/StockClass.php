<?php
// +----------------------------------------------------------------------
// | 进销存模型--产品大类
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Cache;
use think\Db;
use think\image\Exception;
use think\Model;

class StockClass extends Model
{
    static $cache_class = 'stock_class';//产品大类缓存标识
    protected $table = 'myhub_stock_class';

    public function _dcache_class(){
        Cache::rm(self::$cache_class);
    }

    public function classBehavior($del_data = [],$new_id = [],$c_id = []){
        try{
            $this->startTrans();
            //新增
            if($new_id){

                $new = $this->_check($new_id,'add');
                $r = $this->insertAll($new);
                if(!$r){
                    throw new Exception('添加数据失败');
                }
            }
            //修改
            if($c_id){
                $u = $this->_check($c_id,'edit');
                foreach($u as $k=> $v){
                    $where = array('id'=>$k);
                    $r = $this->update($v,$where);
                    if(!$r){
                        throw new Exception('修改数据失败');
                    }
                }
            }
            //删除
            if($del_data){
                $dID = $this->_check($del_data,'delete');
                $ids = implode(',',$dID);
                $where = array('id'=>array('in',$ids));
                $r = $this->where($where)->delete();
                if(!$r){
                    throw new Exception('删除数据失败');
                }
            }

            $this->commit();
            $this->_dcache_class();
            ajax_data('编辑成功');
        }catch(Exception $e){
            $this->rollback();
            ajax_error($e->getMessage());
        }
    }

    public function listData($where = [],$field = '*',$page = 0,$order = 'id asc',$group = ''){
        $cache_list = Cache::get(self::$cache_class);
        if(!$cache_list){
            $list =Db::table($this->table)->field($field)->where($where)->page($page)->group($group)->order($order)->cache(self::$cache_class)->select();
            $cache_list = array();
            foreach($list as $v){
                $cache_list[$v['id']] = $v;
            }
            Cache::set(self::$cache_class,$cache_list);
        }
        return $cache_list;
    }

    protected function _check($data,$scene){
        switch($scene){
            case 'add':
                $new = array();
                foreach($data as $v){
                    $c_name = str_replace(' ','',$v);
                    if(!$c_name){
                        throw new Exception('分类不能为空');
                    }
                    $new[]['class_name'] = $c_name;
                }
                return $new;
                break;
            case 'edit':
                $u = array();
                foreach($data as $k=>$v){
                    if(preg_match('/\d+/',$k,$eid)){
                        if(!is_numeric($eid[0]) || $eid[0]<=0){
                            throw new Exception('修改分类不合法');
                        }
                    }
                    $c_name = str_replace(' ','',$v);
                    if(!$c_name){
                        throw new Exception('分类不能为空');
                    }
                    $u[$eid[0]]['class_name'] = $c_name;
                }
                return $u;
                break;
            case 'delete':
                $dID = array_filter(explode(',',$data));
                foreach($dID as $v){
                    if(!is_numeric($v)){
                        throw new Exception('删除分类不合法');
                    }
                }
                return $dID;
                break;
        }
        return false;
    }
}
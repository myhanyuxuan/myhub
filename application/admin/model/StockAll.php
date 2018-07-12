<?php
// +----------------------------------------------------------------------
// | 进销存模型
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Cache;
use think\Db;
use think\Model;

class StockAll extends Model
{
    static $cache_com = 'data_com_list';//计量单位缓存标识
    static $cache_spec = 'data_spec_list';//产品规格缓存标识
    static $cache_cate = 'data_cate_list';//产品大类缓存标识
    protected $table = 'myhub_stock_sales';
    protected $table_data_product = 'myhub_stock_data_product';
    protected $table_data_com = 'myhub_stock_data_com';
    protected $table_data_spec = 'myhub_stock_data_spec';
    protected $table_data_cate = 'myhub_stock_data_cate';

    public function _dcache_com(){
        Cache::rm(self::$cache_com);
    }
    public function _dcache_spec(){
        Cache::rm(self::$cache_spec);
    }
    public function _dcache_cate(){
        Cache::rm(self::$cache_cate);
    }

    //计量单位添加
    public function insertAttr($data = []){
        $this->_dcache_com();
        return $this->table($this->table_data_com)->insert($data);
    }
    public function insertSpec($data = []){
        $this->_dcache_spec();
        return $this->table($this->table_data_spec)->insert($data);
    }
    public function insertCate($data = []){
        $this->_dcache_cate();
        return $this->table($this->table_data_cate)->insertAll($data);
    }
    public function insertData($data = []){
        return $this->table($this->table_data_product)->insertGetId($data);
    }
    //计量单位修改
    public function updataAttr($data = [],$where = []){
        $this->_dcache_com();
        return $this->table($this->table_data_com)->where($where)->update($data);
    }
    public function updataSpec($data = [],$where = []){
        $this->_dcache_spec();
        return $this->table($this->table_data_spec)->where($where)->update($data);
    }
    public function updataData($data = [],$where = []){
        return $this->table($this->table_data_product)->where($where)->update($data);
    }
    //计量单位删除
    public function deleteAttr($ids = []){
        $this->_dcache_com();
        foreach($ids as $v){
            $this->table($this->table_data_com)->where(array('id'=>$v))->delete();
        }
    }
    public function deleteSpec($ids = []){
        $this->_dcache_spec();
        foreach($ids as $v){
            $this->table($this->table_data_spec)->where(array('id'=>$v))->delete();
        }
    }
    public function deleteData($ids = []){
        foreach($ids as $v){
            $this->table($this->table_data_product)->where(array('id'=>$v))->delete();
        }
    }
    //计量单位列表
    public function stockDataComList(){
        $cache_list = Cache::get(self::$cache_com);
        if(!$cache_list){
            $cache_list = Db::table($this->table_data_com)->order('id desc')->select();
            Cache::set(self::$cache_com,$cache_list);
        }
        return $cache_list;
    }
    public function stockDataSpecList(){
        $cache_list = Cache::get(self::$cache_spec);
        if(!$cache_list){
            $cache_list = Db::table($this->table_data_spec)->order('id desc')->select();
            Cache::set(self::$cache_spec,$cache_list);
        }
        return $cache_list;
    }
    public function stockDataCateList(){
        $cache_list = Cache::get(self::$cache_cate);
        if(!$cache_list){
            $cache_list = Db::table($this->table_data_cate)->order('id asc')->select();
            Cache::set(self::$cache_cate,$cache_list);
        }
        return $cache_list;
    }
    public function stockDataList($data = [],$field='*',$page=8)
    {
        return Db::table($this->table_data_product)->field($field)->where($data)->order('addtime desc')->paginate($page);
    }
    //计量单位详情
    public function infoAttr($where = []){
        return Db::table($this->table_data_com)->where($where)->find();
    }
    //计量单位详情
    public function infoSpec($where = []){
        return Db::table($this->table_data_spec)->where($where)->find();
    }
    public function infoData($where = []){
        return Db::table($this->table_data_product)->where($where)->find();
    }

    public function updata($data = [],$where = [],$field = []){
        return $this->update($data,$where,$field);
    }

    public function stockDataProductList($data = [],$field='*',$page=8){
        return $this->table($this->table_data_product)->field($field)->where($data)->order('id desc')->paginate($page);
    }
}
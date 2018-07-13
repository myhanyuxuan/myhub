<?php
// +----------------------------------------------------------------------
// | 进销存模型--产品资料
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Cache;
use think\Db;
use think\image\Exception;
use think\Model;

class StockKehu extends Model
{
    protected $table = 'myhub_stock_kehu';

    public function insertData($data = []){
        try{
            $this->_check($data,'add');
            $inserData = array();
            $inserData['kehu_name'] = $data['kehu_name'];
            $inserData['area_id'] = $data['area_id'];
            $inserData['address'] = $data['address'];
            $inserData['tel_phone'] = $data['tel_phone'];
            $inserData['tel_name'] = $data['tel_name'];
            if($data['tel_phone2']){
                $inserData['tel_phone2'] = $data['tel_phone2'];
            }
            if($data['qq']){
                $inserData['qq'] = $data['qq'];
            }
            if($data['weixin']){
                $inserData['weixin'] = $data['weixin'];
            }
            $inserData['ctime'] = time();
            $r = $this->insertGetId($inserData);
            if(!$r){
                throw new Exception('添加数据失败');
            }

            ajax_data('添加成功');
        }catch(Exception $e){
            ajax_error($e->getMessage());
        }
    }

    public function updataData($data = []){
        try{
            $this->_check($data,'edit');
            $updateData = array();
            $updateData['kehu_name'] = $data['kehu_name'];
            $updateData['area_id'] = $data['area_id'];
            $updateData['address'] = $data['address'];
            $updateData['tel_phone'] = $data['tel_phone'];
            $updateData['tel_name'] = $data['tel_name'];
            if($data['tel_phone2']){
                $updateData['tel_phone2'] = $data['tel_phone2'];
            }
            if($data['qq']){
                $updateData['qq'] = $data['qq'];
            }
            if($data['weixin']){
                $updateData['weixin'] = $data['weixin'];
            }
            $updateData['etime'] = time();

            $r = $this->update($updateData,array('id'=>$data['id']));
            if(!$r){
                throw new Exception('修改失败');
            }

            ajax_data('修改成功');
        }catch(Exception $e){
            ajax_error($e->getMessage());
        }
    }

    public function deleteData($ids = []){
        foreach($ids as $v){
            $this->where(array('id'=>$v))->delete();
        }
    }

    public function listData($where = [],$field='*',$page=8,$order = 'ctime desc'){
        return Db::table($this->table)->field($field)->where($where)->page($page)->order($order)->paginate($page);
    }

    public function infoData($where = [],$field = '*'){
        return Db::table($this->table)->field($field)->where($where)->find();
    }

    protected function _check($data,$scene){

        if(empty($data['kehu_name'])){
            throw new Exception('客户名称不能为空');
        }
        $where = array();
        if($scene == 'edit'){
            if(!is_numeric($data['id'])){
                throw new Exception('修改id不合法');
            }
            $where['id'] = array('neq',intval($data['id']));
        }
        $where['kehu_name'] = $data['kehu_name'];
        $check_name = $this->infoData($where,'kehu_name');
        if(!empty($check_name)){
            throw new Exception('该客户名称已存在');
        }
        if(!is_numeric($data['area_id']) || $data['area_id'] == 0){
            throw new Exception('请选择客户所在地区');
        }
        if(empty($data['address'])){
            throw new Exception('地址不能为空');
        }
        if(empty($data['tel_phone'])){
            throw new Exception('联系电话不能为空');
        }
        if(empty($data['tel_name'])){
            throw new Exception('联系人不能为空');
        }
    }
}
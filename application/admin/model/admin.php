<?php
// +----------------------------------------------------------------------
// | 管理员模型
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;

class Admin extends Model
{
    // 设置数据表（不含前缀）
    protected $name = 'admin';

    /*后台登录*/
    public function adminLogin($data=array()){

        $result = $this->where($data)->find();
        if($result){
            if($result['is_use'] != 0){
                $result['error'] = '该管理员已被禁用！';
                return $result;
            }
            Session::set('admin_name',$result['admin_name']);
            $updata = array();

            $updata['login_num'] = $result['login_num']+1;
            $updata['oldtime'] = time();
            $this->update($updata,array('id'=>$result['id']),'login_num,oldtime');
        }else{
            $result['error'] = '用户名或密码错误！';
        }
        return $result;
    }
}
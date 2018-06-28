<?php
// +----------------------------------------------------------------------
// | 管理员模型
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Cookie;

class Admin extends Model
{
    protected $table = 'myhub_admin';

    /*后台登录*/
    public function adminLogin($data = []){

        $result = $this->table($this->table)->where($data)->find();
        if(!$result){
            ajax_error('用户名或密码错误！');
        }
        if($result['is_use'] != 0){
            ajax_error('该管理员已被禁用！');
        }
        Cookie::set('admin_name',$result['admin_name'],432000);//保存5天
        $updata_data = array();

        $updata_data['login_num'] = $result['login_num']+1;
        $updata_data['oldtime'] = time();
        $updata_data = $this->updata($updata_data,array('id'=>$result['id']),'login_num,oldtime');

        if(!$updata_data){
            ajax_error('操作失败！');
        }
        ajax_data('登录成功！');
    }
    /*更新数据*/
    public function updata($data = [],$where = [],$field = []){
        return $updata = $this->update($data,$where,$field);
    }
}
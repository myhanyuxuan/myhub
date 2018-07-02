<?php
// +----------------------------------------------------------------------
// | 管理员模型
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Cookie;

class Gadmin extends Model
{
    protected $table = 'myhub_gadmin';

    /*更新数据*/
    public function updata($data = [],$where = [],$field = []){
        return $this->update($data,$where,$field);
    }
    /*管理员列表*/
    public function groupList($data = [],$field='*',$page=8)
    {
        return Db::table($this->table)->field($field)->where($data)->order('addtime desc')->paginate($page);
    }
}
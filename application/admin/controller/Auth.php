<?php
// +----------------------------------------------------------------------
// | 权限管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin;

class Auth extends Common
{
    /*管理员*/
    public function admin_list()
    {
        $model = new Admin();
        $admin_list = $model->adminList();
        $this->assign('admin_list',$admin_list);
        return $this ->fetch();
    }
    /*新增管理员*/
    public function admin_add(){
        $this->view->engine->layout(false);
        return $this ->fetch();
    }
}

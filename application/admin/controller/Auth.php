<?php
// +----------------------------------------------------------------------
// | 权限管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin;
use think\Request;

class Auth extends Common
{
    /*管理员*/
    public function admin_list()
    {
        $model = new Admin();
        $admin_list = $model->adminList();
        $this->assign('admin_list',$admin_list);

        $this -> top_menu('admin');
        return $this ->fetch();
    }

    /*新增管理员*/
    public function admin_add(Request $request){
        $this->view->engine->layout(false);
        return $this ->fetch();
    }

    /*权限组*/
    public function group_list(){
        $list = array();
        $this->assign('list',$list);

        $this -> top_menu('group');
        return $this ->fetch();
    }

    /*新增权限组*/
    public function group_add(Request $request){
        if($request->isPost()){
            ajax_data('操作成功');
        }
        $array = require(RUNTIME.'cache/menu.php');
        $this->assign('group_all',$array);
        $this->view->engine->layout(false);
        return $this ->fetch();
    }

    private function top_menu($menu_key='') {
        $menu_array = array(
            array('menu_key'=>'admin','menu_name'=>'管理员',	'menu_url'=>url('admin_list')),
            array('menu_key'=>'group','menu_name'=>'权限组',	'menu_url'=>url('group_list'))
        );
        $this->assign('member_menu',$menu_array);
        $this->assign('menu_key',$menu_key);
    }

}

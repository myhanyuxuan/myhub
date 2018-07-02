<?php
// +----------------------------------------------------------------------
// | 权限管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Gadmin;
use think\Request;

class Auth extends Common
{
    // 验证规则
    protected $rule = [
        ['gname', 'require'],
    ];
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

        $model = new Gadmin();
        if(input()){
            //删除数据
            if(input('ids/a')){
                $ids = input('ids/a');
                foreach($ids as $v){
                    $model->where(array('id'=>$v))->delete();
                }
                ajax_data('删除成功');
            }else{
                ajax_error('请选择要删除的数据');
            }
        }

        $group_list = $model->groupList();
        $this->assign('group_list',$group_list);

        $this -> top_menu('group');
        return $this ->fetch();
    }

    /*新增权限组*/
    public function group_add(Request $request){

        $array = require(RUNTIME.'cache/menu.php');

        if($request->isPost()){

            $check = $this->validate(
                ['权限组'=>$request->post('gname')],
                ['权限组'=>'require']
            );
            if(true !== $check){
                // 验证失败 输出错误信息
                ajax_error($check);
            }

            $limit_str = '';
            $model = new Gadmin();
            $permissions = $request->post('permission/a');

            if(is_array($permissions)){
                $limit_str = implode('|',$permissions);
            }
            $data['limits'] = encrypt($limit_str,MD5_KEY.md5($request->post('gname')));
            $data['gname'] = $request->post('gname');
            $data['addtime'] = time();
            if ($model->insert($data)){
                ajax_data('操作成功');
            }else {
                ajax_error('操作失败');
            }
            //ajax_data('操作成功');
        }
        $this->assign('group_all',$array);
        $this->view->engine->layout(false);
        return $this ->fetch();
    }

    public function check_gname(){
            $model = new Gadmin();
            $result = $model->where(array('gname'=>input('gname')))->find();
            if(!empty($result)){
                exit('false');
            }else{
                exit('true');
            }
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

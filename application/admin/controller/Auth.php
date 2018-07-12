<?php
// +----------------------------------------------------------------------
// | 权限管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Gadmin;
use think\Cookie;
use think\Db;
use think\image\Exception;
use think\Request;
use think\Validate;

class Auth extends Common
{
    //管理员模型
    protected $Admin;
    //权限组模型
    protected $Gadmin;
    //中间表
    protected $a_g;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->Admin = new Admin();
        $this->Gadmin = new Gadmin();
        $this->a_g = Db::table('myhub_admin_gadmin');
    }
/*=============================================================管理员================================================================*/
    /*管理员*/
    public function admin_list(Request $request)
    {
        //管理员列表
        $admin_list = $this->Admin->adminList();
        $show_pages = $admin_list->render();
        $admin_list = $admin_list->all();
        foreach($admin_list as $k => $v){
            if($v['id'] == 1 ){
                $admin_list[$k]['group_name'] = '';
                continue;
            }
            $gname = Db::table('myhub_admin_gadmin')->where(array('aid'=>$v['id']))->find();
            $admin_list[$k]['group_name'] = $gname['gname'];
        }
        $this->assign('admin_list',$admin_list);
        $this->assign('show_pages',$show_pages);

        $this->adminDelete($request->get('ids'));//删除

        $this -> top_menu('admin');
        return $this ->fetch();
    }
    /*新增管理员*/
    public function admin_add(Request $request){

        //权限组列表
        $group_list = $this->Gadmin->all();
        $this->assign('group_list',$group_list);
        $this->view->engine->layout(false);

        $this->adminAdd($request->post());//添加管理员

        return $this ->fetch();
    }
    /*编辑管理员*/
    public function admin_edit(Request $request){

        //权限组列表
        $group_list = $this->Gadmin->all();
        $this->assign('group_list',$group_list);

        if($request->param('id') > 0){
            $admin_info = $this->Admin->where(array('id'=>$request->param('id')))->find();
            if(!empty($admin_info)){
                $this->assign('admin_info',$admin_info);
            }
        }
        $this->view->engine->layout(false);

        $this->adminEdit($request->post());//编辑管理员

        return $this ->fetch();
    }
/*=============================================================权限组================================================================*/
    /*权限组*/
    public function group_list(Request $request){

        $this->groupDelete($request->get('ids/a'));//批量删除

        $group_list = $this->Gadmin->groupList();
        $this->assign('group_list',$group_list);
        $this -> top_menu('group');
        return $this ->fetch();
    }
    /*新增权限组*/
    public function group_add(Request $request){

        $group_all = require(RUNTIME.'cache/menu.php');
        $this->assign('group_all',$group_all);
        $this->view->engine->layout(false);

        $this->groupAdd($request->post());//添加权限组

        return $this ->fetch();
    }
    /*编辑权限组*/
    public function group_edit(Request $request){

        $group_all = require(RUNTIME.'cache/menu.php');
        $this->assign('group_all',$group_all);
        if($request->param('id') > 0){
            $group_info = $this->Gadmin->where(array('id'=>$request->param('id')))->find();
            if(!empty($group_info)){
                $hlimit = decrypt($group_info['limits'],MD5_KEY.md5($group_info['gname']));
                $group_info['limits'] = explode('|',$hlimit);
                $this->assign('group_info',$group_info);
            }
        }
        $this->view->engine->layout(false);

        $this->groupEdit($request->post());//编辑权限组

        return $this ->fetch();
    }

/*=============================================================admin================================================================*/
    private function adminAdd($post){

        if(!empty($post['params'])){
            $post = $post['params'];
            $gid = intval($post['gid']);
            if($gid <= 0){
                ajax_error('请勾选权限组权限');
            }
            try{
                //启动事务
                $this->Admin->startTrans();

                $data['admin_name'] = $post['admin_name'];
                $data['group_id'] = $post['gid'];
                $data['admin_psd'] = md5($post['password']);
                $data['addtime'] = time();
                $r = $this->Admin->insertGetId($data);
                if(!$r){
                    throw new Exception('操作失败');
                }
                $gname = $this->Gadmin->where(array('id'=>$post['gid']))->find();
                if(!$gname){
                    throw new Exception('操作失败');
                }
                $insert = array();
                $insert['aid'] = $r;
                $insert['gid'] = $post['gid'];
                $insert['gname'] = $gname['gname'];
                $a_g = $this->a_g->insert($insert);
                if(!$a_g){
                    throw new Exception('操作失败');
                }

                $this->Admin->commit();
                ajax_data('操作成功');
            }catch(Exception $e){
                //回滚事务
                $this->Admin->rollback();
                ajax_error($e->getMessage());
            }
        }
    }

    private function adminEdit($post){

        if(!empty($post['params'])){
            $post = $post['params'];
            $gid = intval($post['gid']);
            if($gid <= 0){
                ajax_error('请勾选权限组权限');
            }
            try{
                //启动事务
                $this->Admin->startTrans();
                $data['group_id'] = $post['gid'];
                if($post['password']){
                    $data['admin_psd'] = md5($post['password']);
                }
                $r = $this->Admin->update($data,array('id'=>$post['admin_id']));
                if(!$r){
                    throw new Exception('操作失败');
                }
                $gname = $this->Gadmin->where(array('id'=>$post['gid']))->find();
                $data_g['gid'] = $post['gid'];
                $data_g['gname'] = $gname['gname'];
                $g = $this->a_g->where(array('aid'=>$post['admin_id']))->update($data_g);
                if(!$g){
                    throw new Exception('操作失败');
                }

                $this->Admin->commit();
                ajax_data('操作成功');
            }catch(Exception $e){
                $this->Admin->rollback();
                ajax_error($e->getMessage());
            }
        }
    }

    private function adminDelete($ids){

        if($ids){
            try{
                //启动事务
                $this->Admin->startTrans();
                //删除 不支持批量删除
                $r = $this->Admin->where(array('id'=>$ids))->delete();
                if(!$r){
                    throw new Exception('操作失败');
                }
                $g = $this->a_g->where(array('aid'=>$ids))->delete();
                if(!$g){
                    throw new Exception('操作失败');
                }

                $this->Admin->commit();
                ajax_data('删除成功');
            }catch(Exception $e){
                $this->Admin->rollback();
                ajax_error($e->getMessage());
            }
        }
    }

/*=============================================================group================================================================*/
    private function groupAdd($post){

        if(!empty($post)){
            //验证
            $check = $this->validate(['权限组'=>$post['gname']],['权限组'=>'require']);
            if(true !== $check) ajax_error($check);

            $limit_str = '';
            $permissions = $post['permission'];
            if(empty($permissions)){
                ajax_error('请勾选权限组权限');
            }

            //组装已选权限
            if(is_array($permissions)){
                foreach($permissions as $k=>$v){
                    if($v == 'no'){
                        unset($permissions[$k]);
                    }
                }
                $limit_str = implode('|',$permissions);
            }
            $data['limits'] = encrypt($limit_str,MD5_KEY.md5($post['gname']));
            $data['gname'] = $post['gname'];
            $data['addtime'] = time();
            if ($this->Gadmin->insert($data)){
                ajax_data('操作成功');
            }else {
                ajax_error('操作失败');
            }
        }
    }

    private function groupEdit($post){

        if(!empty($post)){
            //验证
            $check = $this->validate(['权限组'=>$post['gname']],['权限组'=>'require']);
            if(true !== $check) ajax_error($check);

            $where = array();
            if (is_numeric($post['group_id'])){
                $where['id'] = array('neq',intval($post['group_id']));
            }
            $where['gname'] = $post['gname'];
            $result = $this->Gadmin->where($where)->find();
            if(!empty($result)){
                ajax_error('该权限名已存在');
            }

            $limit_str = '';
            $permissions = $post['permission'];
            if(empty($permissions)){
                ajax_error('请勾选权限组权限');
            }

            //组装已选权限
            if(is_array($permissions)){
                foreach($permissions as $k=>$v){
                    if($v == 'no'){
                        unset($permissions[$k]);
                    }
                }
                $limit_str = implode('|',$permissions);
            }
            $data['limits'] = encrypt($limit_str,MD5_KEY.md5($post['gname']));
            $data['gname'] = $post['gname'];
            if ($this->Gadmin->updata($data,array('id'=>$post['group_id']))){
                ajax_data('操作成功');
            }else {
                ajax_error('操作失败');
            }
        }
    }

    private function groupDelete($ids){

        if($ids){
            //批量删除
            foreach($ids as $v){
                $this->Gadmin->where(array('id'=>$v))->delete();
            }
            ajax_data('删除成功');
        }
    }

/*=============================================================其他方法================================================================*/
    /*验证字段*/
    public function check_gname(){
        $type = input('type');
        switch($type){
            case 'check_add':
                $result = $this->Gadmin->where(array('gname'=>input('gname')))->find();
                break;
            case 'check_edit':
                $where = array();
                if (is_numeric(input('gid'))){
                    $where['id'] = array('neq',intval(input('gid')));
                }
                $where['gname'] = input('gname');
                $result = $this->Gadmin->where($where)->find();
                break;
        }
        if(!empty($result)){
            exit('false');
        }else{
            exit('true');
        }
    }
    /*顶部导航*/
    private function top_menu($menu_key='') {
        $menu_array = array(
            array('menu_key'=>'admin','menu_name'=>'管理员',	'menu_url'=>url('admin_list'),'poss'=>'admin_list'),
            array('menu_key'=>'group','menu_name'=>'权限组',	'menu_url'=>url('group_list'),'poss'=>'group_list')
        );
        //过滤权限
        if($this->admin_info['group_id'] != 0){
            $ok_menu = array();
            foreach($menu_array as $k=>$v) {
                if (!in_array($v['poss'], $this->permission['ls_fun'])) {
                    unset($menu_array[$k]);
                    continue;
                }
                $ok_menu[] = $v['poss'];
            }
            if(!in_array(request()->action(),$ok_menu)){
                $this->error('你无访问权限');
            }
        }
        $curr_url = request()->url(true);
        Cookie::forever('last_url',$curr_url);
        Cookie::forever('is_con',request()->controller());

        $this->assign('member_menu',$menu_array);
        $this->assign('menu_key',$menu_key);
    }
}

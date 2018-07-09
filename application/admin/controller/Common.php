<?php
// +----------------------------------------------------------------------
// | 公共控制器
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Gadmin;
use think\Cache;
use think\Controller;
use think\image\Exception;
use think\Request;
use think\Cookie;

class Common extends Controller{
    protected $admin_info;//管理员信息
    protected $permission;//权限组

    public function __construct(Request $request)
    {

        parent::__construct($request);
        $getNav = $this->getNav();//菜单
        //判断是否登录
        if(!Cookie::get('admin_name') || $getNav == false){
            $this->success('请登录！','login/login','',1);
        }
        //记录当前访问的url
        if(!in_array($request->controller(),array('Index'))){
                //验证访问权限
            if(!$getNav['poss']){
                if(!in_array($request->controller(),$getNav['ls_con'])){
                    $this->error('你没有访问权限');
                }
            }
        }

        $this->assign('getNav',$getNav['array']);
        $this->assign('ls_con',$request->controller());
        $this->assign('ls_fun',$request->action());
        $this->assign('gadminInfo',$getNav['gadmin']);

        $this->view->engine->layout('layout/layout');
    }
    /*取得后台左侧菜单*/
    protected function getNav(){
        $array = require(RUNTIME.'cache/menu.php');
        $amodel = new Admin();
        $gmodel = new Gadmin();
        $admin_name = Cookie::get('admin_name');
        $this->admin_info = $amodel->adminInfo(array('admin_name'=>$admin_name),'id,group_id');
        if(!$this->admin_info){
            return false;
        }
        if($this->admin_info['group_id'] == 0){//过滤掉创始人
            foreach($array['left'] as $k=>$v){
                foreach($v['list'] as $k2=>$v2){
                    $array['left'][$k]['list'][$k2]['is_fun'] = true;
                }
            }

            $meuns = array();
            $meuns['array'] = $array;
            $meuns['poss'] = true;
            $meuns['gadmin'] = array('group_id'=>0,'gname'=>'创始人');
            return $meuns;
        }
        $gInfo = $gmodel->groupInfo(array('id'=>$this->admin_info['group_id']));
        if(!$gInfo){
            return false;
        }

        //获取管理员已有权限
        $group_arr = decrypt($gInfo['limits'],MD5_KEY.md5($gInfo['gname']));
        $group_arr = explode('|',$group_arr);
        $permission = $ls_con = $ls_fun = $ssg = array();
        foreach($group_arr as $k=>$v){
            $permission[] = explode(':',$v);
            $ls_con[] = $permission[$k][0];
            $ls_fun[] = $permission[$k][1];
        }
        $ls_con = array_unique($ls_con);
        $ls_fun = array_unique($ls_fun);

        //验证权限
        foreach($array['left'] as $k=>$v){
            if(!in_array($v['nav'],$ls_con)){
                continue;
            }
            $ssg['left'][$k] = $v;
            foreach($v['list'] as $k2=>$v2){
                if(!in_array(explode(',',$v2['args'])[2],$ls_fun)){
                    unset($ssg['left'][$k]['list'][$k2]);
                    continue;
                }
                $ssg['left'][$k]['list'][$k2] = $v2;
                $ssg['left'][$k]['list'][$k2]['is_fun'] = true;
            }
        }
        $array = $ssg;

        $meuns = array();
        $meuns['array'] = $array;
        $meuns['ls_con'] = $ls_con;
        $meuns['ls_fun'] = $ls_fun;
        $meuns['poss'] = false;
        $meuns['gadmin'] = array('group_id'=>$gInfo['id'],'gname'=>$gInfo['gname']);
        $this->permission = $meuns;
        return $meuns;
    }
}

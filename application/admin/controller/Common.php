<?php
// +----------------------------------------------------------------------
// | 公共控制器
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Cookie;

class Common extends Controller{

    public function __construct(Request $request)
    {

        parent::__construct($request);
        //判断是否登录
        if(!Cookie::get('admin_name')){
            $this->success('请登录！','login/login','',1);
        }
        $getNav = $this->getNav();//菜单
        //记录当前访问的url
        if($request->controller() != 'Index'){
            $cur_am = false;
            foreach($getNav['left'] as $v){
                if($v['nav'] != $request->controller()){
                    continue;
                }
                foreach($v['list'] as $v1){
                    $agrss = explode(',',$v1['args']);
                    if($agrss[2] != $request->action()){
                        continue;
                    }
                    $cur_am = true;
                }
            }
            if($cur_am){
                $curr_url = $request->url(true);
                Cookie::forever('last_url',$curr_url);
                Cookie::forever('is_con',$request->controller());
            }
        }

        $this->assign('getNav',$getNav);
        $this->assign('ls_con',$request->controller());
        $this->assign('ls_fun',$request->action());

        $this->view->engine->layout('layout/layout');
    }
    /*取得后台左侧菜单*/
    protected function getNav(){
        $array = require(RUNTIME.'cache/menu.php');

        return $array;
    }
}

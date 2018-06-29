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

        //记录当前访问的url
        if($request->controller() != 'Index'){
            $curr_url = $request->url(true);
            Cookie::forever('last_url',$curr_url);
            Cookie::forever('is_con',$request->controller());
        }

        $getNav = $this->getNav();//菜单
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

<?php
// +----------------------------------------------------------------------
// | 公共控制器
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

class Common extends Controller{
    public function __construct(Request $request)
    {

        parent::__construct($request);
        //判断是否登录
        if(!Session::get('admin_name')){
            $this->redirect('login/login');
        }
            $this->view->engine->layout('layout');
    }
}

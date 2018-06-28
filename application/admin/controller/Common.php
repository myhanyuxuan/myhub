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
            $this->view->engine->layout('layout');
    }
}

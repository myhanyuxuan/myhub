<?php
// +----------------------------------------------------------------------
// | 默认展示页面
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Cookie;

class Index extends Common
{
    /*首页*/
    public function index(Request $request)
    {
        //跳转到上次访问的url
        if($request->get('index') != 'ok'){
            $last_url = Cookie::get('last_url');
            if($last_url){
                $this->redirect($last_url);
            }
        }
        return $this ->fetch();
    }

}

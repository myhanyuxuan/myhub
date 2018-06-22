<?php
// +----------------------------------------------------------------------
// | 后台登录操作
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;
use think\image\Exception;
use think\Request;

class Login extends Controller
{
    /*首页*/
    public function index()
    {
        $this->redirect('login/login');
    }
    /*登录*/
    public function login(Request $request){

        if($request->post()){
            try{
                if(!captcha_check($request->param('code'))){
                   throw new Exception('验证码错误！');
                }
                $this->redirect('index/index');
            }catch(Exception $e){
                $this->error($e->getMessage());
            }
        }
            return $this ->fetch();
    }
}

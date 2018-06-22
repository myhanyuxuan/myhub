<?php
// +----------------------------------------------------------------------
// | 后台登录操作
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin;
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
                if(!captcha_check($request->post('code'))){
                   return json('验证码错误！');
                }
                $model = new Admin;
                $data = array();

                $data['admin_name'] = $request->post('admin_name');
                $data['admin_psd'] = md5($request->post('admin_psd'));
                $r = $model->adminLogin($data);
                if(!$r['error']){
                    $this->success('登录成功！','index/index');
                }else{
                    $this->error($r['error']);
                }
        }
            return $this ->fetch();
    }
}

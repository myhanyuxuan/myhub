<?php
// +----------------------------------------------------------------------
// | 后台登录操作
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin;
use think\Controller;
use think\image\Exception;
use think\Request;
use think\Cookie;

class Login extends Controller
{
    // 验证规则
    protected $rule = [
        ['admin_name', 'require', '请输入用户名！'],
        ['admin_psd', 'require', '请输入密码！'],
        ['code', 'require', '请输入验证码'],
    ];

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /*登录*/
    public function login(Request $request){
        if(Cookie::get('admin_name')){
            $this->success('登录成功！','index/index','',1);
        }
        $post = $request->param();
        if(!$post){
            return $this ->fetch();
        }

        $params = $post['params'];
        $check = $this->validate(
            ['用户名'=>$params['admin_name'], '密码'=>$params['admin_psd'], '验证码'=>$params['code']],
            ['用户名'=>'require', '密码'=>'require', '验证码'=>'require',]
        );
        if(true !== $check){
            // 验证失败 输出错误信息
            ajax_error($check);
        }

        if(!captcha_check($params['code'])){
            ajax_error('验证码错误！');
        }
        $model = new Admin();
        $data = array();

        $data['admin_name'] = $params['admin_name'];
        $data['admin_psd'] = md5($params['admin_psd']);
        $model->adminLogin($data);

        return false;
    }

    /*退出登录*/
    public function outlogin(){
        if(Cookie::get('admin_name')){
            Cookie::delete('admin_name');
        }
        $this->success('请登录！','login/login','',1);
    }
}

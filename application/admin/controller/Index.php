<?php
// +----------------------------------------------------------------------
// | 默认展示页面
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Request;

class Index extends Common
{
    /*首页*/
    public function index(Request $request)
    {
        return $this ->fetch();
    }

}

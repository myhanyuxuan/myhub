<?php
// +----------------------------------------------------------------------
// | 默认展示页面
// +----------------------------------------------------------------------
namespace app\admin\controller;

class Index extends Common
{
    /*首页*/
    public function index()
    {
        return $this ->fetch();
    }

}

<?php
// +----------------------------------------------------------------------
// | 默认展示页面
// +----------------------------------------------------------------------
namespace app\index\controller;

class Index extends Base
{
    /*首页*/
    public function index()
    {
        return $this ->fetch();
    }

}

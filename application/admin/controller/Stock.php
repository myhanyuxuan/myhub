<?php
// +----------------------------------------------------------------------
// | 进销存管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Cookie;

class Stock extends Common
{

    public function sales_list(Request $request)
    {


        return $this ->fetch();
    }

}

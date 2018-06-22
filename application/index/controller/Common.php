<?php
// +----------------------------------------------------------------------
// | 公共控制器
// +----------------------------------------------------------------------
namespace app\index\controller;

use think\Controller;
use think\Request;

class Common extends Controller{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->view->engine->layout('layout');
    }
}

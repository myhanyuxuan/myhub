<?php
// +----------------------------------------------------------------------
// | 进销存管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Request;

class Stock extends Common
{
    /*=============================================================销售管理================================================================*/
    public function sales_list(Request $request)
    {

        $this -> top_menu('sales');
        return $this ->fetch();
    }
    /*=============================================================采购管理================================================================*/
    public function buy_list(Request $request)
    {

        $this -> top_menu('buy');
        return $this ->fetch();
    }
    /*=============================================================库存管理================================================================*/
    public function stock_list(Request $request)
    {

        $this -> top_menu('stock');
        return $this ->fetch();
    }
    /*=============================================================数据管理================================================================*/
    public function data_list(Request $request)
    {

        $this -> top_menu('data');
        return $this ->fetch();
    }
    /*=============================================================其他方法================================================================*/
    /*顶部导航*/
    private function top_menu($menu_key='') {
        $menu_array = array(
            array('menu_key'=>'sales','menu_name'=>'销售管理',	'menu_url'=>url('sale_list'),'poss'=>'sale_list'),
            array('menu_key'=>'buy','menu_name'=>'采购管理',	'menu_url'=>url('buy_list'),'poss'=>'buy_list'),
            array('menu_key'=>'stock','menu_name'=>'库存管理',	'menu_url'=>url('stock_list'),'poss'=>'stock_list'),
            array('menu_key'=>'data','menu_name'=>'数据管理',	'menu_url'=>url('data_list'),'poss'=>'data_list')
        );
        //过滤权限
        if($this->admin_info['group_id'] != 0){
            $ok_menu = array();
            foreach($menu_array as $k=>$v) {
                if (!in_array($v['poss'], $this->permission['ls_fun'])) {
                    unset($menu_array[$k]);
                    continue;
                }
                $ok_menu[] = $v['poss'];
            }
            if(!in_array(request()->action(),$ok_menu)){
                $this->error('你无访问权限');
            }
            $curr_url = request()->url(true);
            Cookie::forever('last_url',$curr_url);
            Cookie::forever('is_con',request()->controller());
        }

        $this->assign('member_menu',$menu_array);
        $this->assign('menu_key',$menu_key);
    }

}

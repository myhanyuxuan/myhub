<?php
// +----------------------------------------------------------------------
// | 社区管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Cookie;

class Community extends Common
{
    /*首页*/
    public function community_list(Request $request)
    {
        $this -> top_menu('community');
        return $this ->fetch();
    }
    //按钮列表
    public function buttom(){
        $this -> top_menu('community');
        return $this ->fetch();
    }
    /*顶部导航*/
    private function top_menu($menu_key='') {
        $menu_array = array(
            array('menu_key'=>'community','menu_name'=>'社区中心',	'menu_url'=>url('community_list'),'poss'=>'community_list'),
            array('menu_key'=>'type','menu_name'=>'社区类型',	'menu_url'=>url('type_list'),'poss'=>'type_list')
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
        }
        $curr_url = request()->url(true);
        Cookie::forever('last_url',$curr_url);
        Cookie::forever('is_con',request()->controller());

        $this->assign('member_menu',$menu_array);
        $this->assign('menu_key',$menu_key);
    }
}

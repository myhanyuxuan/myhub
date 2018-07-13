<?php
// +----------------------------------------------------------------------
// | 进销存管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\StockClass;
use app\admin\model\StockData;
use app\admin\model\StockSpec;
use app\admin\model\StockUnit;
use think\Cookie;
use think\Db;
use think\Request;

class Stock extends Common
{
    static $data;
    //产品资料
    protected $stockData;
    //产品大类
    protected $stockClass;
    //计量单位
    protected $stockUnit;
    //产品规格
    protected $stockSpec;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->stockData = new StockData();
        $this->stockClass = new StockClass();
        $this->stockSpec = new StockSpec();
        $this->stockUnit = new StockUnit();
    }
    /*=============================================================销售管理================================================================*/
    public function sales_list(Request $request)
    {

        $this -> top_menu('sales');
        return $this ->fetch('stock/sales/sales_list');
    }
    /*=============================================================采购管理================================================================*/
    public function buy_list(Request $request)
    {

        $this -> top_menu('buy');
        return $this ->fetch('stock/buy/buy_list');
    }
    /*=============================================================库存管理================================================================*/
    public function stock_list(Request $request)
    {

        $this -> top_menu('stock');
        return $this ->fetch();
    }
    /*=============================================================数据管理================================================================*/
    //产品资料
    public function data_list(Request $request)
    {
        $this -> top_menu('data');
        if($request->param('type')){//客户资料，供货商资料，产品属性
           $fetch = $this->other_data($request->param('type'));
           return $this ->fetch($fetch);
        }

        $class_list = $this->stockClass->listData();//产品大类
        $this->assign('class_list',$class_list);

        $list = $this->stockData->listData();
        $this->assign('list',$list);

        //批量删除
        if($request->get('ids/a')){
            $this->stockData->deleteData($request->get('ids/a'));
            ajax_data('删除成功');
        }
        return $this ->fetch();
    }

    //产品资料新增
    public function data_add(Request $request){
        $this->view->engine->layout(false);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockData->insertData($data);
        }
        $this->assign('cateList',$this->stockClass->listData());
        $this->assign('specList',$this->stockSpec->listData());
        $this->assign('attrList',$this->stockUnit->listData());
        return $this ->fetch();
    }

    //产品资料编辑
    public function data_edit(Request $request){
        $this->view->engine->layout(false);
        $info = $this->stockData->infoData(array('id'=>$request->param('id')));
        $this->assign('info',$info);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockData->updataData($data);
        }

        $this->assign('cateList',$this->stockClass->listData());
        $this->assign('specList',$this->stockSpec->listData());
        $this->assign('attrList',$this->stockUnit->listData());
        return $this ->fetch();
    }

    //产品大类
    public function class_list(Request $request)
    {
        $this->view->engine->layout(false);
        $list = $this->stockClass->listData();
        $this->assign('list',$list);

        $del_datas =$request->post('del_data');
        $new_ids =$request->post('new_id/a');
        $c_ids =$request->post('c_id/a');
        if($del_datas || $new_ids || $c_ids){
            $this->stockClass->classBehavior($del_datas,$new_ids,$c_ids);
        }
        return $this ->fetch();
    }

    //计量单位新增
    public function unit_add(Request $request){
        $this->view->engine->layout(false);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockUnit->insertData($data);
        }
        return $this ->fetch();
    }

    //计量单位编辑
    public function unit_edit(Request $request){
        $this->view->engine->layout(false);
        $info = $this->stockUnit->infoData(array('id'=>$request->param('id')));
        $this->assign('info',$info);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockUnit->updataData($data);
        }
        return $this ->fetch();
    }

    //产品规格新增
    public function spec_add(Request $request){
        $this->view->engine->layout(false);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockSpec->insertData($data);
        }
        return $this ->fetch();
    }

    //产品规格编辑
    public function spec_edit(Request $request){
        $this->view->engine->layout(false);
        $info = $this->stockSpec->infoData(array('id'=>$request->param('id')));
        $this->assign('info',$info);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockSpec->updataData($data);
        }
        return $this ->fetch();
    }
    /*=============================================================其他方法================================================================*/
    public function other_data($type){
        switch($type){
            case 'kehu'://客户资料
                $list = $this->stocKehu->listData();
                $this->assign('list',$list);
                //批量删除
                if($this->request->get('ids/a')){
                    $this->stocKehu->deleteData($this->request->get('ids/a'));
                    ajax_data('删除成功');
                }
                $url = 'stock/supplier_list';
                break;
            case 'supplier'://供货商资料
                $list = $this->stockSupplier->listData();
                $this->assign('list',$list);
                //批量删除
                if($this->request->get('ids/a')){
                    $this->stockSupplier->deleteData($this->request->get('ids/a'));
                    ajax_data('删除成功');
                }
                $url = 'stock/supplier_list';
                break;
            case 'attr'://产品属性设置
                if($this->request->param('spec') == 1){//规格
                    $list = $this->stockSpec->listData();
                    $this->assign('list',$list);
                    //批量删除
                    if($this->request->get('ids/a')){
                        $this->stockSpec->deleteData($this->request->get('ids/a'));
                        ajax_data('删除成功');
                    }
                    $url = 'stock/spec_list';
                    return $url;
                }

                //计量单位
                $list = $this->stockUnit->listData();
                $this->assign('list',$list);
                //批量删除
                if($this->request->get('ids/a')){
                    $this->stockUnit->deleteData($this->request->get('ids/a'));
                    ajax_data('删除成功');
                }
                $url = 'stock/unit_list';
                break;
        }
        return $url;
    }

    /*顶部导航*/
    private function top_menu($menu_key='') {
        $menu_array = array(
            array('menu_key'=>'sales','menu_name'=>'销售管理',	'menu_url'=>url('sales_list'),'poss'=>'sales_list'),
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
        }
        $curr_url = request()->url(true);
        Cookie::forever('last_url',$curr_url);
        Cookie::forever('is_con',request()->controller());

        $this->assign('member_menu',$menu_array);
        $this->assign('menu_key',$menu_key);
    }

}

<?php
// +----------------------------------------------------------------------
// | 进销存管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\StockArea;
use app\admin\model\StockClass;
use app\admin\model\StockData;
use app\admin\model\StockKehu;
use app\admin\model\StockSales;
use app\admin\model\StockSpec;
use app\admin\model\StockSupplier;
use app\admin\model\StockUnit;
use think\Cookie;
use think\Db;
use think\Request;

class Stock extends Common
{
    static $data;
    //销售管理
    protected $stockSales;
    //产品资料
    protected $stockData;
    //客户资料
    protected $stockKehu;
    //供货商资料
    protected $stockSupplier;
    //地区大类
    protected $stockArea;
    //产品大类
    protected $stockClass;
    //计量单位
    protected $stockUnit;
    //产品规格
    protected $stockSpec;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->stockSales = new StockSales();
        $this->stockData = new StockData();
        $this->stockKehu = new StockKehu();
        $this->stockSupplier = new StockSupplier();
        $this->stockArea = new StockArea();
        $this->stockClass = new StockClass();
        $this->stockSpec = new StockSpec();
        $this->stockUnit = new StockUnit();
    }
    /*=============================================================销售管理================================================================*/
    public function sales_list(Request $request)
    {
        $list = $this->stockSales->listData();
        $this->assign('list',$list);
        $this -> top_menu('sales');
        return $this ->fetch();
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

        if(input('bid') || input('p_name') || input('c_id')){
            $list_new = array();
            foreach($list as $k => $v){
                if(input('c_id') && $v['class_id'] != input('c_id')){
                    continue;
                }
                if(input('bid') && strpos($v['bid'],input('bid')) === false){
                    continue;
                }
                if(input('p_name') && strpos($v['p_name'],input('p_name')) === false ){
                    continue;
                }
                $list_new[$v['id']] = $v;
            }
        }else{
            $list_new = $list;
        }

        $this->assign('list',$list_new);

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

    //地区大类
    public function area_list(Request $request)
    {
        $this->view->engine->layout(false);
        $list = $this->stockArea->listData();
        $this->assign('list',$list);

        $del_datas =$request->post('del_data');
        $new_ids =$request->post('new_id/a');
        $c_ids =$request->post('c_id/a');
        if($del_datas || $new_ids || $c_ids){
            $this->stockArea->classBehavior($del_datas,$new_ids,$c_ids);
        }
        return $this ->fetch();
    }

    //客户资料新增
    public function kehu_add(Request $request){
        $this->view->engine->layout(false);
        $area_list = $this->stockArea->listData();//地区大类
        $this->assign('area_list',$area_list);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockKehu->insertData($data);
        }
        return $this ->fetch();
    }

    //客户资料编辑
    public function kehu_edit(Request $request){
        $this->view->engine->layout(false);
        $area_list = $this->stockArea->listData();//地区大类
        $this->assign('area_list',$area_list);
        $info = $this->stockKehu->infoData(array('id'=>$request->param('id')));
        $this->assign('info',$info);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockKehu->updataData($data);
        }
        return $this ->fetch();
    }

    //供货商资料新增
    public function supplier_add(Request $request){
        $this->view->engine->layout(false);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockSupplier->insertData($data);
        }
        return $this ->fetch();
    }

    //供货商资料编辑
    public function supplier_edit(Request $request){
        $this->view->engine->layout(false);
        $info = $this->stockSupplier->infoData(array('id'=>$request->param('id')));
        $this->assign('info',$info);
        $data = $request->post('params/a');
        if(!empty($data)){
            $this->stockSupplier->updataData($data);
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
                $where = $this->_condition();
                $list = $this->stockKehu->listData($where);
                $this->assign('list',$list);
                $area_list = $this->stockArea->listData();//地区大类
                $this->assign('area_list',$area_list);
                //批量删除
                if($this->request->get('ids/a')){
                    $this->stockKehu->deleteData($this->request->get('ids/a'));
                    ajax_data('删除成功');
                }
                $url = 'stock/kehu_list';
                break;
            case 'supplier'://供货商资料
                $where = $this->_condition();
                $list = $this->stockSupplier->listData($where);
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
    public function _condition(){
        $where = array();
        if(input('area_id')){
            $where['area_id'] = input('area_id');
        }
        if(input('kehu_name')){
            $where['kehu_name'] = input('kehu_name');
        }
        if(input('supplier_name')){
            $where['supplier_name'] = input('supplier_name');
        }
        if(input('address')){
            $where['address'] = array('like',"%".input('address')."%");
        }
        if(input('tel_phone')){
            $where['tel_phone'] = input('tel_phone');
        }
        if(input('tel_name')){
            $where['tel_name'] = input('tel_name');
        }
        if(input('qq')){
            $where['qq'] = input('qq');
        }
        if(input('weixin')){
            $where['weixin'] = input('weixin');
        }
        return $where;
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

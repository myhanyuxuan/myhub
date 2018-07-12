<?php
// +----------------------------------------------------------------------
// | 进销存管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\StockAll;
use app\admin\model\StockSpec;
use app\admin\model\StockUnit;
use think\Cookie;
use think\Db;
use think\image\Exception;
use think\Request;

class Stock extends Common
{
    static $data;
    //计量单位
    protected $stockUnit;
    //产品规格
    protected $stockSpec;

    public function __construct(Request $request)
    {
        parent::__construct($request);
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

        //产品资料
        $cate_name = $spec_name = $com_name = $cap_name = '';
        $dataList = self::dataList();
        $cate_list = self::cate_list();
        $spec_list = self::spec_list();
        $attr_list = self::attr_list();
        $show_pages = $dataList->render();
        $dataList = $dataList->all();
        foreach($dataList as $k=>$v){
            foreach($cate_list as $v1){
                if($v['cate_id'] == $v1['id']){
                    $dataList[$k]['cate_name'] = $v1['cate_name'];
                }
            }

            foreach($spec_list as $v1){
                if($v['spec_id'] == $v1['id']){
                    $dataList[$k]['spec_name'] = $v1['spec_name'];
                }
            }

            foreach($attr_list as $v1){
                if($v['com_id'] == $v1['id']){
                    $dataList[$k]['com_name'] = $v1['com_name'];
                    $dataList[$k]['cap_name'] = $v1['cap_name'];
                }
            }
        }
        $this->assign('com_name',$com_name);
        $this->assign('cap_name',$cap_name);
        $this->assign('spec_name',$spec_name);
        $this->assign('cate_name',$cate_name);
        $this->assign('cateList',self::cate_list());
        $this->assign('dataList',$dataList);
        $this->assign('show_pages',$show_pages);
        $this->dataDelete($request->get('ids/a'));//批量删除

        return $this ->fetch('stock/data/data_list');
    }

    public function other_data($type){
        switch($type){
            case 'kehu'://客户资料
                self::kehu_list();
                return $this ->fetch('stock/data/kehu/kehu_list');
                break;
            case 'supplier'://供货商资料
                self::supplier_list();
                return $this ->fetch('stock/data/supplier/supplier_list');
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

    public function data_add(Request $request){

        $this->view->engine->layout(false);

        $this->dataAdd($request->post('params/a'));//添加

        $this->assign('cateList',self::cate_list());
        $this->assign('specList',self::spec_list());
        $this->assign('attrList',self::attr_list());
        return $this ->fetch('stock/data/data_add');
    }

    public function data_edit(Request $request){
        $info = $this->stock->infoData(array('id'=>$request->param('id')));
        $this->assign('info',$info);
        $this->view->engine->layout(false);
        $this->dataEdit($request->post('params/a'));
        $cate_list = self::cate_list();
        $cate_name = '';
        foreach($cate_list as $v){
            if($v['id'] == $info['cate_id']){
                $cate_name = $v['cate_name'];
            }
        }
        $this->assign('cate_name',$cate_name);
        $this->assign('specList',self::spec_list());
        $this->assign('attrList',self::attr_list());
        return $this ->fetch('stock/data/data_edit');
    }

    public function data_cate_list(){
        $this->view->engine->layout(false);
        $this->assign('cateList',self::cate_list());
        return $this ->fetch('stock/data/cate_list');
    }

    public function data_cate_edit(Request $request){
        $this->view->engine->layout(false);
        $this->dataCateSS($request->post('del_data'),$request->post('new_id/a'),$request->post('c_id/a'));
        return $this ->fetch('stock/data/cate_list');
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
    /*=============================================================attr================================================================*/
    private function dataCateSS($del_data,$new_id,$c_id){
            try{
                if($new_id){//新增
                    $new = array();
                    foreach($new_id as $v){
                        $c_name = str_replace(' ','',$v);
                        if(!$c_name){
                            throw new Exception('分类不能为空');
                        }
                        $new[]['cate_name'] = $c_name;
                    }

                        $r = $this->stock->insertCate($new);
                        if(!$r){
                            throw new Exception('添加数据失败');
                        }
                }
                if($c_id){//修改
                    $u = array();
                    foreach($c_id as $k=>$v){
                        if(preg_match('/\d+/',$k,$eid)){
                            if(!is_numeric($eid[0]) || $eid[0]<=0){
                                throw new Exception('修改分类不合法');
                            }
                        }

                        $c_name = str_replace(' ','',$v);
                        if(!$c_name){
                            throw new Exception('分类不能为空');
                        }
                        $u[$eid[0]]['cate_name'] = $c_name;
                    }
                    foreach($u as $k=> $v){
                        $where = array('id'=>$k);
                        $r = Db::table('myhub_stock_data_cate')->where($where)->update($v);
                        if($r < 0){
                            throw new Exception('修改数据失败');
                        }
                    }
                    $this->stock->_dcache_cate();

                }

                if($del_data){//删除
                    $dID = array_filter(explode(',',$del_data));
                    foreach($dID as $v){
                        if(!is_numeric($v)){
                            throw new Exception('删除分类不合法');
                        }
                    }
                    $ids = implode(',',$dID);
                    $where = array('id'=>array('in',$ids));
                    $r = Db::table('myhub_stock_data_cate')->where($where)->delete();
                    if(!$r){
                        throw new Exception('删除数据失败');
                    }
                    $this->stock->_dcache_cate();
                }

                ajax_data('编辑成功');
            }catch(Exception $e){
                ajax_error($e->getMessage());
            }
    }
    private function dataAdd($post){
        if(!empty($post)){
            try{
                $this->stock->startTrans();
                if(empty($post['p_name'])){
                    throw new Exception('产品名称不能为空');
                }
                $check_name = $this->stock->infoData(array('p_name'=>$post['p_name']));
                if(!empty($check_name)){
                    throw new Exception('该产品名称已存在');
                }
                $cate_list = self::cate_list();
                $cate_name = '';
                foreach($cate_list as $v){
                    if($v['id'] == $post['cate_id']){
                        $cate_name = pinyin_long($v['cate_name']);
                    }
                }
                $data = array();
                $data['cate_id'] = $post['cate_id'];
                $data['p_name'] = $post['p_name'];
                $data['bid'] = $cate_name;
                $data['spec_id'] = $post['spec_id'];
                $data['com_id'] = $post['com_id'];
                $data['addtime'] = time();
                $result = $this->stock->insertData($data);
                if(!$result){
                    throw new Exception('数据添加失败');
                }
                $updata = array();
                $updata['bid'] = $cate_name.str_pad($result,6,'0',STR_PAD_LEFT);

                $p = $this->stock->updataData($updata,array('id'=>$result));
                if(!$p){
                    throw new Exception('数据添加失败');
                }
                $this->stock->commit();
                ajax_data('操作成功');
            }catch(Exception $e){
                $this->stock->rollback();
                ajax_error($e->getMessage());
            }
        }
    }
    private function dataEdit($post){
        if(!empty($post)){
            try{
                if(empty($post['p_name'])){
                    throw new Exception('产品名称不能为空');
                }
                $where = array();
                if (is_numeric($post['id'])){
                    $where['id'] = array('neq',intval($post['id']));
                }
                $where['p_name'] = $post['p_name'];

                $check_name = $this->stock->infoData($where);
                if(!empty($check_name)){
                    throw new Exception('该产品名称已存在');
                }
                $data = array();
                $data['p_name'] = $post['p_name'];
                $data['spec_id'] = $post['spec_id'];
                $data['com_id'] = $post['com_id'];
                $result = $this->stock->updataData($data,array('id'=>$post['id']));
                if(!$result){
                    throw new Exception('操作失败');
                }
                ajax_data('操作成功');
            }catch(Exception $e){
                ajax_error($e->getMessage());
            }
        }
    }
    private function dataDelete($ids){
        if($ids){
            $this->stock->deleteData($ids);
            ajax_data('删除成功');
        }
    }
    /*=============================================================其他方法================================================================*/
    static function kehu_list(){
        echo 111;
    }
    static function supplier_list(){
        echo 222;
    }
    static function cate_list(){
        $stockM = new StockAll();
        return $stockM->stockDataCateList();
    }
    static function dataList(){
        $stockM = new StockAll();
        return $stockM->stockDataList();
    }
    static function attr_list(){
        $stockM = new StockAll();
        return $stockM->stockDataComList();
    }
    static function spec_list(){
        $stockM = new StockAll();
        return $stockM->stockDataSpecList();
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

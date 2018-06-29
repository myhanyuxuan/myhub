<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function ajax_data($datas, $code = 200) {
    $data = array();
    $data['version'] ='1.0.0';
    $data['code'] = $code;
    $data['datas'] = $datas;
    echo json_encode($data);die;
}

function ajax_error($message, $code = -200) {
    $datas = array('error' => $message);
    ajax_data($datas, $code);
}
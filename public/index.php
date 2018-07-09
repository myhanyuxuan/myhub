<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 定义缓存目录
define('RUNTIME', __DIR__ . '/../runtime/');
//定义md5_key
define('MD5_KEY','myhub_3073598');
//第三方类库
define('EXTEND','../extend/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';

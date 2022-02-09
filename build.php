<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 生成运行时目录
    '__file__' => ['common.php'],

    // 定义index模块的自动生成
    'admin'    => [
        '__file__'   => ['common.php'],
        '__dir__'    => [ 'controller', 'model', 'view'],
        'controller' => ['Index'],
        'model'      => ['Index'],
        'view'       => ['index/index'],
    ],
    // 。。。 其他更多的模块定义
];
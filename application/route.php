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
use think\Route;


//首页
Route::get('/admin/index','admin/Index/index');

Route::get('/admin/index/welcome','admin/Index/welcome');

Route::get('login','admin/Login/index');

//开始登录
Route::post('/admin/login','admin/Login/login');

//退出
Route::get('/admin/logout','admin/Login/logout');


//管理员
Route::get('/admin/administrator/index','admin/Administrator/index');
Route::rule('/admin/administrator/add','admin/Administrator/add','GET|POST');
Route::get('/admin/administrator/edit/:id','admin/Administrator/edit');
Route::post('/admin/administrator/update','admin/Administrator/update');
Route::post('/admin/administrator/delete','admin/Administrator/delete');



//角色管理

Route::get('/admin/role/index','admin/Role/index');
Route::rule('/admin/role/add','admin/Role/add','GET|POST');
Route::get('/admin/role/edit/:id','admin/Role/edit');
Route::post('/admin/role/update','admin/Role/update');
Route::post('/admin/role/delete','admin/Role/delete');


//权限管理

Route::get('/admin/auth/index','admin/Auth/index');
Route::rule('/admin/auth/add','admin/Auth/add','GET|POST');
Route::get('/admin/auth/edit/:id','admin/Auth/edit');
Route::post('/admin/auth/update','admin/Auth/update');
Route::post('/admin/auth/delete','admin/Auth/delete');


//资料管理
Route::get('/admin/file/index','admin/File/index');
Route::post('/admin/file/del','admin/File/del');
Route::post('/admin/file/chong','admin/File/chong');
Route::rule('/admin/file/edit','admin/File/edit','post|get');
Route::get('/admin/file/download','admin/File/download');
Route::post('/admin/file/createfile','admin/File/createFile');
Route::post('/admin/file/upload','admin/File/uploadFile');


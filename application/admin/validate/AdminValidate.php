<?php
namespace app\admin\validate;
use think\Validate;

class AdminValidate extends  Validate
{
    protected $rule =   [
        'username'=>'require|unique:administrator|alphaNum|max:20|min:5|token',
        'password'=>'require|alphaNum|max:20|min:5',
    ];
    
    protected $message  =   [
        'username.require' => '用户名不能为空！',
        'username.alphaNum'     => '用户名只能是字母和数字',
        'username.unique'   => '用户名已存在',
        'username.max'  => '用户名最大不超过20个字符',
        'username.min'  => '用户名不能小于5个字符',
        'username.token'  => '请勿重复提交',

        'password.require' => '密码不能为空！',
        'password.alphaNum'=> '密码只能是字母和数字',
        'password.max'  => '密码最大不超过20个字符',
        'password.min'  => '密码不能小于5个字符',
    ];
    

    
}













?>
<?php
namespace app\admin\controller;
use think\Request;
use think\Session;
use app\admin\controller\Base;
use think\Db;
class Index extends Base
{
    public function index()
    {

     $system=db('system')->field('id,name')->find();
    
     $this->assign('system',$system);
        
     return view();

    }


    public function welcome()
    {

    //当前登录时间
    $time=time();


    $this->assign('time',$time);

     return view();

    }






}

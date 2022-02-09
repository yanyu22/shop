<?php

namespace app\index\controller;

use think\Request;

class Index extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
		

      $cateList=db('cate')->field('cid,name,pid')->where('pid',0)->select();
      static $List=[];
      foreach($cateList as $k=>$v){


       $List[$k]=$v;

        $articelSe=db('article')->field('cate_id,id,title,create_time')->where('cate_id',$v['cid'])->where('create_time desc')->limit(5)->select();

      $List[$k]['cates']=$v;


      }


   
         return view();
    }

}

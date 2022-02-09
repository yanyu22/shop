<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
class Base extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function _initialize()
    {
	


  //查询导航栏
    $list= db('cate')->order('sort desc')->where('pid',0)->field('cid,name,pid,type')->where('static',1)->select();	

    $catelist=[];
    foreach($list as $k=>$v){

     //查子栏目
    $cates = db::name('cate')->where('pid',$v['cid'])->order('sort desc')->where('static',1)->select();
    $catelist[$k]=$v;

    $catelist[$k]['cates']=$cates;


    }



   //查询友情链接
	 $link= db('link')->order('link_sort desc')->select();		

	
	  //查询基本配置
	 $system=db('system')->find();
	

   //获取点击导航栏的id

    $cid=input('cid');

    if($cid){
         //查询当前栏目信息
    $cates=db('cate')->order('sort desc')->find($cid);
    $topcid='';
    if($cates['pid']==0){
        $topcid=$cates['cid'];
    }else{
        $topcid=$cates['pid'];
    }
    
    }else{
        $topcid=0;
    }
    

    
   //查询首页底部导航

   $dd = db('cate')->order('sort desc')->where('pid',0)->field('cid,name,pid,type')->where('static',1)->select();  
 

          //随机文章

    $suiji=db('article')->field('title,id')->orderRaw('rand()')->limit(6)->select();


   $footcate=db('cate')->field('cid,name,sort,static')->where('pid',0)->order('sort desc')->select();

    //查询轮播图
    $banner= db('banner')->order('banner_sort asc')->select();



    

   $this->assign('banner',$banner);
   $this->assign('suiji',$suiji);
   $this->assign('dd',$dd);
   $this->assign('footcate',$footcate);
   $this->assign('system',$system);
   $this->assign('list',$list);
   $this->assign('link',$link);
   $this->assign('catelist',$catelist);
   $this->assign('topcid',$topcid);
    }


}

<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use app\index\controller\Weizhi;
class Lianxi extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index($cid)
    {
        
   //查询点击栏目信息
	$cates=db('cate')->field('cid,name,pic,content,key,desc,seotitle,pid')->find($cid);

  

   //2.查询栏目对应的产品
      if($cates['pid']==0){

      //查所有栏目
      $cate = db::name('cate')->where('pid',$cates['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->where('static',1)->select();
       $cc=$cates;
      }else{
     
    //3.如果不是顶级栏目，就查询上级栏目
      $cc= db('cate')->where('cid',$cates['pid'])->field('cid,name,sort,pid,type')->find();
      //判断，如果查询的上级栏目等于0，那这个栏目就是二级栏目
       

      //查所有栏目
      $cate = db::name('cate')->where('pid',$cc['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->where('static',1)->select();

      }
    $weizhi=new Weizhi();

    $weizhi=$weizhi->weizhi($cid);
    $this->assign('weizhi',$weizhi);
    $this->assign('cates',$cates);     
    $this->assign('cate',$cate);  
    $this->assign('cc',$cc);     
        
        
return view();


    }


}

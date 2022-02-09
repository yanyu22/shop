<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use app\index\controller\Weizhi;
class Page extends Base
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


    if($cates['pid']==0){

   //根据主栏目ID。获取主栏目下所有子栏目
    $res=db('cate')->where(['pid'=>$cates['cid']])->field('cid,pid,name,sort,static,type')->where('static',1)->select();
    $dingji=db('cate')->field('cid,name,pic,content,key,desc,seotitle,pid')->find($cid);


    
    }else{

    //获取上级栏目ID
     $dingji=db('cate')->where('cid',$cates['pid'])->field('cid,pid,name,sort,static,type')->find();
  
    //根据主栏目ID。获取主栏目下所有子栏目
     $res=db('cate')->where(['pid'=>$dingji['cid']])->field('cid,pid,name,sort,static,type')->where('static',1)->select();
    }
    

        //随机推荐

    $suijiA=db('product')->field('title,id,create_time,pic')->orderRaw('rand()')->limit(8)->select();




//     $ccid='';
//     if($cates['pid']==0){
//         $ccid=$cates['cid'];
//     }else{
//         $ccid=$cates['pid'];
//     }

// dump($ccid);

    $weizhi=new Weizhi();
    $weizhi=$weizhi->weizhi($cid);
    $this->assign('suijiA',$suijiA);
    $this->assign('weizhi',$weizhi);
	$this->assign('res',$res);
    $this->assign('cates',$cates);
    $this->assign('dingji',$dingji);
   
    return view();
	   
	   
    }


}

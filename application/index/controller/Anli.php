<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use app\index\model\Anli as AnliModel;
class Anli extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index($cid)
    {

   //1.查询点击栏目信息
    $cates=db('cate')->field('name,cid,pic,desc,key,seotitle,pid')->find($cid);
  
    //2.查询栏目对应的
      if($cates['pid']==0){

      //查所有栏目
      $cate = db::name('cate')->where('pid',$cates['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->select();

     //如果顶级栏目=0，查询所有
      $Anli=db('Anli')->field('title,id,create_time,description,pic')->order('create_time desc')->paginate(6);
      $cc=$cates;
      }else{
     
    //3.如果不是顶级栏目，就查询上级栏目
      $cc= db('cate')->where('cid',$cates['pid'])->field('cid,name,sort,pid,type,pic')->find();

       //查询点击二级栏目id对应的
       $Anli=db('Anli')->where('cate_id',$cates['cid'])->order('create_time desc')->field('id,title,cate_id,description,create_time,pic')->paginate(6);
      //查所有栏目
      $cate = db::name('cate')->where('pid',$cc['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->select();
      }





   
   $weizhi=new Weizhi();
   $weizhi=$weizhi->weizhi($cid);
   $this->assign('cate',$cate);
   $this->assign('weizhi',$weizhi);
   $this->assign('Anli',$Anli);
   $this->assign('cates',$cates);
   $this->assign('cc',$cc);
   $this->assign('cid',$cid);
   
     return view();
	   
    }






    public function details($aid)
    {

    $Anli= db('Anli')->where('id',$aid)->find();//查询当前点击的数据

    $cat_find=db('cate')->where('cid',$Anli['cate_id'])->field('name,cid,pic,pid')->find();//上级栏目信息

       //查询栏目对应的产品
    if($cat_find['pid']==0){
     //如果顶级栏目
      $AnliList=db('cate')->where('pid',$cat_find['cid'])->field('cid,name,sort,type')->order('sort desc')->select();

      $cates=$cat_find;

    }else{
       $cates=db('cate')->where('cid',$cat_find['pid'])->field('name,cid,pic,pid')->find();//顶级栏目的信息
       //查询顶级下面子栏目
       $AnliList=db('cate')->where('pid',$cates['cid'])->field('cid,name,sort,type')->order('sort desc')->select();
    }

   //上级栏目高亮
   $ccid=$cat_find['cid'];
   
   
      //获取点击导航栏的id

    if($ccid){
         //查询当前栏目信息
    $cates=db('cate')->order('sort desc')->find($ccid);
    $topcid='';
    if($cates['pid']==0){
        $topcid=$cates['cid'];
    }else{
        $topcid=$cates['pid'];
    }
    
    }else{
        $topcid=0;
    }
   
    $suiJi=db('article')->field('id,title')->orderRaw('rand()')->limit(10)->select();;
    $AnliModel=new AnliModel();
        //阅读量
    $AnliModel->getview($aid);
    
        //上
    $shang=$AnliModel->getArticle($aid);

	  //下
	 $xia=$AnliModel->xiaArticle($aid);
   $weizhi=new Weizhi();
   $weizhi=$weizhi->weizhi($cat_find['cid']);
    $this->assign('ccid',$ccid); 
    $this->assign('cates',$cates); 
    $this->assign('cat_find',$cat_find);   
    $this->assign('Anli',$Anli);
    $this->assign('AnliList',$AnliList);
    $this->assign('xia',$xia);
    $this->assign('shang',$shang);
    $this->assign('weizhi',$weizhi);
     $this->assign('topcid',$topcid);
      $this->assign('suiJi',$suiJi);
       return view();
	   
	   
    }

	
	
	
	
	

}

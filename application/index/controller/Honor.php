<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use app\index\model\Honor as HonorModel;
class Honor extends Base
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
      $Honor=db('zizhi')->field('title,id,create_time,description,pic')->order('create_time desc')->paginate(8);
     //点击栏目信息赋值
      $cc=$cates;

      }else{
     
      //3.如果不是顶级栏目，就查询上级栏目的信息
      $cc= db('cate')->where('cid',$cates['pid'])->field('cid,name,sort,pid,type')->find();

      //查询点击二级栏目id对应
      $Honor=db('zizhi')->where('cate_id',$cates['cid'])->order('create_time desc')->field('id,title,cate_id,description,create_time,pic')->paginate(8);

      //查所有栏目
      $cate = db::name('cate')->where('pid',$cc['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->select();

      }



   
   $weizhi=new Weizhi();
   $weizhi=$weizhi->weizhi($cid);
   $this->assign('cate',$cate);
   $this->assign('weizhi',$weizhi);
   $this->assign('Honor',$Honor);
   $this->assign('cates',$cates);
   $this->assign('cc',$cc);
   return view();
	   
    }






    public function details($aid)
    {

    $Honor= db('zizhi')->where('id',$aid)->find();//查询当前点击的数据

    $cat_find=db('cate')->where('cid',$Honor['cate_id'])->field('name,cid,pic,pid')->find();//上级栏目信息
       //查询栏目对应的产品
    if($cat_find['pid']==0){
     //如果顶级栏目
      $HonorList=db('cate')->where('pid',$cat_find['cid'])->field('cid,name,sort,type')->order('sort desc')->select();

      $cates=$cat_find;

    }else{
       $cates=db('cate')->where('cid',$cat_find['pid'])->field('name,cid,pic,pid')->find();//顶级栏目的信息
       //查询顶级下面子栏目
       $HonorList=db('cate')->where('pid',$cates['cid'])->field('cid,name,sort,type')->order('sort desc')->select();
    }


    
    $HonorModel=new HonorModel();
        //阅读量
    $HonorModel->getview($aid);
    
        //上
    $shang=$HonorModel->getArticle($aid);

	  //下
   $xia=$HonorModel->xiaArticle($aid);
   $weizhi=new Weizhi();
   $weizhi=$weizhi->weizhi($cat_find['cid']);
    
    $this->assign('cates',$cates); 
    $this->assign('cat_find',$cat_find);   
    $this->assign('Honor',$Honor);
    $this->assign('HonorList',$HonorList);
    $this->assign('xia',$xia);
    $this->assign('shang',$shang);
    $this->assign('weizhi',$weizhi);
    return view();
	   
	   
    }

	
	
	
	
	

}

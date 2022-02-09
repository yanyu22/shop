<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use app\index\model\Article as ArticleModel;
use app\index\controller\Weizhi;
class Article extends Base
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
  

   //2.查询栏目对应的文章
      if($cates['pid']==0){

            //查所有栏目
      $cate = db::name('cate')->where('pid',$cates['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->select();

     //如果顶级栏目=0，查询所有文章
      $article=db('article')->field('title,id,create_time,description,pic,view,author')->order('create_time desc')->paginate(9);
      $cc=$cates;
      }else{
     
    //3.如果不是顶级栏目，就查询上级栏目
      $cc= db('cate')->where('cid',$cates['pid'])->field('cid,name,sort,pid,type,pic')->find();

       //查询点击二级栏目id对应的文章
       $article=db('article')->where('cate_id',$cates['cid'])->order('create_time desc')->field('id,title,cate_id,description,create_time,pic,view,author')->paginate(9);
      //查所有栏目
      $cate = db::name('cate')->where('pid',$cc['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->select();
      }
      
    // $ccid='';
    // if($cates['pid']==0){
    // $ccid=$cates['cid'];
    // }else{
    // $ccid=$cates['pid'];
    // }


   $suiJi=db('article')->field('id,title')->orderRaw('rand()')->limit(10)->select();;



   $weizhi=new Weizhi();
   $weizhi=$weizhi->weizhi($cid);



   $this->assign('cate',$cate);
   $this->assign('weizhi',$weizhi);
   $this->assign('article',$article);
   $this->assign('cates',$cates);
   $this->assign('cc',$cc);
   $this->assign('suiJi',$suiJi);
   $this->assign('cid',$cid);
     return view();
	   
    }



    public function details($aid)
    {
	

    ///查询当前文章
     $cates=db('article')->field('id,title,description,keywords,content,create_time,seoname,cate_id,view,author')->find($aid);

    
     //查询上级栏目
     $catesss=db('cate')->where('cid',$cates['cate_id'])->field('cid,name,pic,type,pid')->find();

     //判断是顶级还是二级
     if($catesss['pid']!==0){

      $cc= db('cate')->where('cid',$catesss['pid'])->field('cid,name,pid,type')->find();
  

      $cate = db::name('cate')->where('pid',$cc['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->where('static',1)->select();


     }else{

        $cate = db::name('cate')->where('pid',$catesss['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->where('static',1)->select();
         $cc=$catesss;
     }


     //随机推荐
    $ArticleModel= new ArticleModel();
    $suiJi=$ArticleModel->suiJi($aid);


         //上
	 $shang=$ArticleModel->getArticle($aid);

	  //下
	 $xia=$ArticleModel->xiaArticle($aid);


    //阅读量
    $ArticleModel->getsArticle($aid);
    //位置
    $weizhi=new Weizhi();
    
    //高亮
    //$ccid=$catesss['cid'];
    // $ccid='';
    // if($catesss['pid']==0){
    // $ccid=$catesss['cid'];
    // }else{
    // $ccid=$catesss['pid'];
    // }
   //高亮
   $ccid=$catesss['cid'];
    // dump($ccid);
        if($ccid){
         //查询当前栏目信息
    $catesA=db('cate')->order('sort desc')->find($ccid);
    $topcid='';
    if($catesA['pid']==0){
        $topcid=$catesA['cid'];
    }else{
        $topcid=$catesA['pid'];
    }
    
    }else{
        $topcid=0;
    }

    $weizhi=$weizhi->weizhi($catesss['cid']);
    $this->assign('weizhi',$weizhi);
 	$this->assign('shang',$shang);
  	$this->assign('xia',$xia);
	$this->assign('catesss',$catesss);
	$this->assign('cates',$cates);
    $this->assign('cate',$cate);
    $this->assign('cc',$cc);
    $this->assign('ccid',$ccid);
    $this->assign('topcid',$topcid);
    $this->assign('suiJi',$suiJi);
    return view();
	   
	   
    }

	
	
	
	
	

}

<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use app\index\controller\Weizhi;
use app\index\model\Product as productModel;
class product extends Base
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
  

   //2.查询栏目对应的商品
      if($cates['pid']==0){

            //查所有栏目
    $cate = db::name('cate')->where('pid',$cates['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->select();
    $cc=$cates;
     //如果顶级栏目=0，查询所有
    $product=db('product')->field('title,id,create_time,description,pic')->order('create_time desc')->paginate(6);

      }else{
     
    //3.如果不是顶级栏目，就查询上级栏目
      $cc= db('cate')->where('cid',$cates['pid'])->field('cid,name,sort,pid,type,pic')->find();

       //查询点击二级栏目id对应的
       $product=db('product')->where('cate_id',$cates['cid'])->order('create_time desc')->field('id,title,cate_id,description,create_time,pic')->paginate(6);
      //查所有栏目
      $cate = db::name('cate')->where('pid',$cc['cid'])->order('sort desc')->field('cid,name,sort,pid,type')->select();
      }



   
   $weizhi=new Weizhi();
   $weizhi=$weizhi->weizhi($cid);
   $this->assign('cate',$cate);
   $this->assign('weizhi',$weizhi);
   $this->assign('product',$product);
   $this->assign('cates',$cates);
   $this->assign('cid',$cid);
   $this->assign('cc',$cc);
     return view();
	   
    }






    public function details($aid)
    {
		

    $product=  db('product')->where('id',$aid)->find();//查询当前点击的数据


      if($product['duopic']){
        $product['duopic']=explode('==', $product['duopic']);
        }


	$cat_find=db('cate')->where('cid',$product['cate_id'])->field('name,cid,pic,pid')->find();//上级栏目信息


   //3.查询栏目对应的产品
    if($cat_find['pid']==0){
     //如果顶级栏目
      $productList=db('cate')->where('pid',$cat_find['cid'])->field('cid,name,sort,type')->order('sort desc')->select();
      $cates=$cat_find;
    }else{
       $cates=db('cate')->where('cid',$cat_find['pid'])->field('name,cid,pic,pid')->find();//顶级栏目的信息
       //5.查询顶级下面子栏目
       $productList=db('cate')->where('pid',$cates['cid'])->field('cid,name,sort,type')->order('sort desc')->select();
}

    //随机产品
    $suiji=db('product')->field('title,id,create_time,pic')->orderRaw('rand()')->limit(3)->select();

    //随机文章
    $suijiA=db('article')->field('title,id,create_time')->orderRaw('rand()')->limit(6)->select();

      //热门商品

    $remen=db('product')->field('title,id,create_time,pic')->order('view desc')->limit(6)->select();
    



    $productModel= new productModel();

    //上
	$shang=$productModel->getArticle($aid,$cat_find);


	  //下
	$xia=$productModel->xiaArticle($aid,$cat_find);

    $xg=$productModel->xgPro($aid);



    $weizhi=new Weizhi();

    $weizhi=$weizhi->weizhi($cat_find['cid']);

	$this->assign([

   'cat_find'=>$cat_find,
   'weizhi'=>$weizhi,
   'productList'=>$productList,
   'product'=>$product,
   'suiji'=>$suiji,
   'suijiA'=>$suijiA,
   'shang'=>$shang,
   'xia'=>$xia,
   'xg'=>$xg,
   'cates'=>$cates,
   'remen'=>$remen,	 
         ]);  

  return view();
	   
	   
    }

	
	
	
	
	

}

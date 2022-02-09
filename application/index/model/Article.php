<?php

namespace app\index\model;

use think\Model;
use think\Db;
class Article extends Model
{




public function getview($aid){
	
return $this->where('id',$aid)->setInc('view');
	
	
}


//随机推荐
// public  function  suiJi($cate){


//   foreach($cate as  $k=>$v){
//      $list[]= $v['cid'];

//   }
//    $ccid=implode(',',$list);


//  $where['cate_id'] = array("in",$ccid);

//   //如果顶级栏目=0，查询所有文章
//   $article=db('article')->field('title,id,cate_id')->where($where)->orderRaw('rand()')->limit(6)->select();

//    return $article;

// }
//相关随机获取
 public function suiJi($aid){
  
  //获取分类ID
  $cate_id=$this->where('id',$aid)->value('cate_id');

  $res=$this->where('cate_id',$cate_id)->field('id,title,cate_id')->orderRaw('rand()')->limit(8)->select();

   return $res;
  
  
 }





//上

 public function getArticle($aid){
  


   $res= $this->field(['id','title'])->where('id','<',$aid)->order('id desc')->limit(1)->find();

  if($res){

    return $res->toArray();

  }else{
   
     return $res="已经是最新的了";
   
  }
  
  
 }
 
 
 
 //下
  
 public function xiaArticle($aid){


 
   $res= $this->field(['id','title'])->where('id','>',$aid)->order('id asc')->limit(1)->find();


  if($res){

    return $res->toArray();

  }else{
   
     return $res="已经是最后一个了";
   
  }
  
  
 }
 
 
 //阅读量
 public function getsArticle($aid){

		$data=Db::name('article')->where('id',$aid)->setInc('view');

		$this->data;

	

		

	}

    public function weizhi($cid){
        $cateres=db('cate')->field('cid,pid,name,type')->select();
        $cates=db('cate')->field('cid,pid,name,type')->find($cid);
        $pid=$cates['pid'];
    
        if($pid){
            $arr=$this->_getparentsid($cateres,$pid);
        }
     $arr[]=$cates;

       
        return $arr;
    }
 


}

<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Honor extends Model
{




public function getview($aid){
	
return db('zizhi')->where('id',$aid)->setInc('view');
	
	
}



//上

 public function getArticle($aid){
  
   $res= db('zizhi')->where('id','<',$aid)->field(['id','title'])->order('id desc')->limit(1)->find();

  if($res){

    return $res;

  }else{
   
     return $res="已经是最新的了";
   
  }
  
  
 }
 
 
 
 //下
  
 public function xiaArticle($aid){
 
   $res= db('zizhi')->where('id','>',$aid)->field(['id','title'])->order('id asc')->limit(1)->find();


  if($res){

    return $res;

  }else{
   
     return $res="已经是最后一个了";
   
  }
  
  
 }

//相关
 public function xgArticle($aid){
  
  //获取分类ID
  $cate_id=db('zizhi')->where('id',$aid)->value('cate_id');

  $res=db('zizhi')->where('cate_id',$cate_id)->field('id,title,cate_id,pic')->orderRaw('rand()')->limit(6)->select();

   return $res;
  
  
 }





}

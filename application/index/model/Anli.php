<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Anli extends Model
{




public function getview($aid){
	
return $this->where('id',$aid)->setInc('view');
	
	
}



//上

 public function getArticle($aid){
  
   $res= $this->where('id','<',$aid)->field(['id','title'])->order('id desc')->limit(1)->find();

  if($res){

    return $res->toArray();

  }else{
   
     return $res="已经是最新的了";
   
  }
  
  
 }
 
 
 
 //下
  
 public function xiaArticle($aid){
 
   $res= $this->where('id','>',$aid)->field(['id','title'])->order('id asc')->limit(1)->find();


  if($res){

    return $res->toArray();

  }else{
   
     return $res="已经是最后一个了";
   
  }
  
  
 }

//相关
 public function xgArticle($aid){
  
  //获取分类ID
  $cate_id=$this->where('id',$aid)->value('cate_id');

  $res=$this->where('cate_id',$cate_id)->field('id,title,cate_id,pic')->orderRaw('rand()')->limit(6)->select();

   return $res;
  
  
 }


//位置

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


    public function _getparentsid($cateres,$pid){
        static $arr=array();
        foreach ($cateres as $k => $v) {
            if($v['cid'] == $pid){
    
                $arr[]=$v;

           
                $this->_getparentsid($cateres,$v['pid']);
            }
        }

        return $arr;
    }




}

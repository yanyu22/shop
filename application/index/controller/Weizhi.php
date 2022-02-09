<?php
namespace app\index\controller;
use think\Request;
use think\Db;
class Weizhi extends Base
{
 

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



?>
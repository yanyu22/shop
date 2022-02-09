<?php

namespace app\admin\model;

use think\Model;
use think\Db;
class Zizhi extends Model
{
      

    //开启自动写入时间
    protected $autoWriteTimestamp = true;
	
	

		
		public function ZizhiCate(){
			
	
			return 	db('cate')->field('cid,name,sort,pid')->select();
			
			
		}



    public function  addZizhi($aa){
  
      return   $this->save($aa);

}




public function getOne($id){
	
	
	return $this->where('id',$id)->find();
	
	
}


public  function UpdateSpecial($data,$id){
	
return 	$this->where('id',$id)->update($data);	
	
}


public function delcate($id){


			$res= $this->where('id',$id)->delete();

			if($res){

				$res=['status'=>'success','info'=>"删除成功"];

				}else{

				$res=['status'=>'fail','info'=>"删除失败"];



			}

			return $res;

}




}

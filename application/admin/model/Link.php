<?php

namespace app\admin\model;

use think\Model;

class Link extends Model
{
     public function LinkAll(){
		
		
	return 	$this->select();
		
	}
	
	
	
	    public function  addLink($aa){
  
      return   $this->save($aa);


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
	
	
	
	
	//查询一条栏目信息

public function  getOne($id){
	
return 	$this->where('id',$id)->find();
	

}
	
	
	
public  function updateLink($aa,$id){
	
return 	$this->where('id',$id)->update($aa);	
	
}
	
	
}

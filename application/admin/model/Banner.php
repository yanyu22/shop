<?php

namespace app\admin\model;

use think\Model;

class Banner extends Model
{
	

     //开启自动写入时间
     protected $autoWriteTimestamp = true;


   	public function BanAll(){
			
			
		return 	 $this->order('banner_sort asc')->select();
			
		}
	


		
public function addBanner($data){

   return   $this->save($data);


}
	
	
	public function getOne($id){
		
		return $this->where('id',$id)->find();

	}
		
	
public function upBanner($data,$id){


 return $this->where('id',$id)->update($data);
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

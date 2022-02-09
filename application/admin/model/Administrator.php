<?php

namespace app\admin\model;

use think\Model;
use think\Session;
class Administrator extends Model
{
	
	
	
	
   public  function checkAdmin($username,$password){
	   
	      
	   
	  //查询有没有这个用户名
	   $user=$this->where('username',$username)->find();
	
	   if(!$user){  
	   
		 return (['status'=>'fail','msg'=>'用户名不存在']);	
		 
	   }else{ 
	   
		 $pass=md5($password.$user['salt']);
		 
		 if($pass==$user['password']) {
			 
		     session('username',$username);
	         session('user_id',$user['id']);

			 return (['status'=>'success','msg'=>'登录成功']);
			 
			 
		  }else{
			  
			 return (['status'=>'fail','msg'=>'密码错误']);
		}
		
		
  
		   
	   }
	   
	   
	   
   }
   
   
   
   
   
   
   
   public function adminAll(){
	   
	   
	   return $this->select();
	   
	   
	   
   }
   
   
   



   
public function delAdmin($id){


			$res= $this->where('id',$id)->delete();

			if($res){

			    $data=db('admin_role')->where('user_id',$id)->delete();

				$res=['status'=>'success','info'=>"删除成功"];

				}else{

				$res=['status'=>'fail','info'=>"删除失败"];

			}

			return $res;

}



   
   
}

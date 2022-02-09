<?php

namespace app\admin\model;

use think\Model;

class System extends Model
{
   public   function BanFind(){
	   
	 return  $this->where('id',1)->find();
	   
	   
	   
   }
   
   
   
   
   
   
   public function updateMan($aa,$id){
	   
	   
	   return 	$this->where('id',$id)->update($aa);	
  
   }
   
   
   
   
   
}

<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Auth extends Model
{
      

    //开启自动写入时间
    protected $autoWriteTimestamp = true;
	
	
    public function  addAuth($aa){
  
      return   $this->save($aa);

}




public function getOne($id){
	
	
	return $this->where('id',$id)->find();
	
	
}


public  function UpdateAuth($data,$id){

return 	$this->where('id',$id)->update($data);	
	
}


public function delAuth($id){


     $data=$this->where('auth_pid',$id)->find();
		  if($data){
	  	//如果有子就不能删
		  return ['status'=>'fail','info'=>'此权限下（有子权限），不能删除'];
		 }

			$res= $this->where('id',$id)->delete();
			if($res){
				$res=['status'=>'success','info'=>"删除成功"];
				}else{
				$res=['status'=>'fail','info'=>"删除失败"];
			}

			return $res;

}




}

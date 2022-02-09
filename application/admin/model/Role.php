<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Role extends Model
{
	
public function delRole($id){

			$res= $this->where('id',$id)->delete();

			if($res){

			    $data=db('role_auth')->where('role_id',$id)->delete();

				$res=['status'=>'success','info'=>"删除成功"];

				}else{

				$res=['status'=>'fail','info'=>"删除失败"];

			}

			return $res;

}



   
   
}

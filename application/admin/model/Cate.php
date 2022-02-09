<?php
namespace app\admin\model;
use think\Model;
class Cate extends Model
{
	
    public function  addCate($aa){
      return   $this->save($aa);
}


public function cateAll(){
	
	
return 	$this->field('cid,name,sort,pid,type,static')->order('sort desc')->select();
	
}





//查询一条栏目信息

public function  getOne($id){
	
return 	$this->where('cid',$id)->find();
	
	
}


public  function updateCate($aa,$id){
	
return 	$this->where('cid',$id)->update($aa);	
	
}


public function delcate($id){


         //查询
         $data=$this->where('pid',$id)->find();
//dump(collection($data)->toArray());die;
		 	if($data){

		//如果有子栏目就不能删

		 return ['status'=>'fail','info'=>'此栏目（有子栏目），不能删除'];

		}
		
		 $cc=$this->where('cid',$id)->find();
		
		
		 	if($cc['pid'] == 0){

		//如果有子栏目就不能删

		 return ['status'=>'fail','info'=>'一级栏目不能删除，如需请联系管理员'];

		}
		

		//如果没有就删除

			$res= $this->where('cid',$id)->delete();

			if($res){

				$res=['status'=>'success','info'=>"删除栏目成功"];

				}else{

				$res=['status'=>'fail','info'=>"删除栏目失败"];



			}

			return $res;

}

}

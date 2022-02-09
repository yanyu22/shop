<?php

namespace app\admin\model;

use think\Model;
use think\Db;
class Article extends Model
{
      

    //开启自动写入时间
    protected $autoWriteTimestamp = true;



		public function articleAll(){
	
			
		return 	$this->alias('a')->join('cate w','a.cate_id = w.cid')->field('w.cid,w.name,a.id,a.title,a.cate_id,a.create_time,a.keywords,a.description,a.sex')->order('create_time desc')->paginate(10);
			
		}





		
		
		public function articleCate(){
			
	
			return 	db('cate')->field('cid,name,sort,pid')->select();
			
			
		}



    public function  addArticle($aa){
  
      return   $this->save($aa);

}




public function getOne($id){
	
	
	return $this->where('id',$id)->find();
	
	
}


public  function updateCate($data,$id){
	
return 	$this->where('id',$id)->update($data);	
	
}


public function delcate($id){


			$res= $this->where('id',$id)->delete();

			if($res){

				$res=['status'=>'success','info'=>"删除文章成功"];

				}else{

				$res=['status'=>'fail','info'=>"删除文章失败"];



			}

			return $res;

}




}

<?php

namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
use app\admin\model\Cate as CateModel;
use think\Db;
class Cate extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
		
		$CateModel=new CateModel();

        $dataa=$CateModel->cateAll();


	    $data=$this->getTree($dataa);



		$this->assign('data',$data);

		
       return view();
    }



	
     //递归函数
    private function getTree($dataa,$pid=0,$level=0){
	   static $list=[];
	
	    foreach ($dataa as $k=>$v){
		if($v['pid']==$pid){
			$v['level']=$level;
			$list[]=$v;
			unset($v[$k]);
			$this->getTree($dataa,$v['cid'],$level+1);
			
		}
		
	}
	




	return $list;
}




    public function create()
    {
		
	    $data=db('cate')->field('cid,name,pid')->select();
	    $aa=$this->getTree($data);


		$this->assign('aa',$aa);
        return view('add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $aa=$request->param();
		
		unset($aa['file']);
		
		
		if(isset($aa['pic'])){
			
		$str=$aa['pic'];
		$ccc=explode("\\", $str); ;
		$strr = join("/", $ccc);
		$aa['pic']=$strr;
	
		}
		
        $CateModel=new CateModel();
	
        $data=$CateModel->addCate($aa);

        if($data){

         return json(['status'=>'success','msg'=>'增加成功']);

        }

      return json(['status'=>'info','msg'=>'增加失败']);

    }



    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
		

		$CateModel=new CateModel();
		
		//查询顶级栏目
	  // $dataa=db('cate')->where('pid',0)->select();
  		$data=db('cate')->field('cid,name,pid')->select();
	    $dataa=$this->getTree($data);


	   
		$data=$CateModel->getOne($id);

		 $this->assign('data',$data);
		 $this->assign('dataa',$dataa);
         return view();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        
		
		 $aa=$request->param();
		 
		 if(isset($aa['pic'])){
			
		$str=$aa['pic'];
		$ccc=explode("\\", $str); ;
		$strr = join("/", $ccc);
		$aa['pic']=$strr;
	
		}
		 
		 
		  unset($aa['id']);
		  unset($aa['file']);
        $CateModel=new CateModel();

        $data=$CateModel->updateCate($aa,$id);

        if($data){

         return json(['status'=>'success','msg'=>'修改成功']);

        }

      return json(['status'=>'info','msg'=>'修改失败']);
		
		
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
		$CateModel=new CateModel();

        $res=$CateModel->delcate($id);

        return json($res);

    }
	
	
	
	
}

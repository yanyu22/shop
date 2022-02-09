<?php

namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
use app\admin\model\System as SystemModel;
class System extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
		
		$SystemModel=new SystemModel();
        $data=$SystemModel->BanFind();
		$this->assign('data',$data);
        return view();
		
        
    }



    public function update(Request $request, $id)
    {


         $aa=$request->param();
	

		if(isset($aa['logo'])){
			
		$aa['logo']=str_replace("\\", '/', $aa['logo']);
	
	}
			if(isset($aa['gongpic'])){
			
		$aa['gongpic']=str_replace("\\", '/', $aa['gongpic']);
		
			
	}
				if(isset($aa['Dlogo'])){
			
		$aa['Dlogo']=str_replace("\\", '/', $aa['Dlogo']);
		
			
	}

	
	
		 unset($aa['file']);
	
        $SystemModel=new SystemModel();

        $data=$SystemModel->updateMan($aa,$id);

        if($data){

         return json(['status'=>'success','msg'=>'修改成功']);

        }

      return json(['status'=>'info','msg'=>'修改失败']);
    }



}

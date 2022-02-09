<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
use app\admin\model\Banner as BannerModel;
class Banner extends Base
{
    public function index()
    {
		$BannerModel=new BannerModel();
    $data=$BannerModel->BanAll();

		$this->assign('data',$data);
		
        return view();
    }





    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
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
      	
      $data=$request->param();
	     unset($data['file']);

	   
	   if(isset($data['banner_pic'])){
		   
		 $str=$data['banner_pic'];
		    
	   $ccc=explode('\\', $str);
	   $star=join('/',$ccc);


	   $data['banner_pic']=$star;

		   
	   }
	   

	

        $BannerModel  =   new  BannerModel;
        $dataa= $BannerModel->addBanner($data);
       if($dataa){

         return ['status'=>'success','msg'=>'增加成功'];

        }

        return ['status'=>'error','msg'=>'增加失败'];
    }


    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
		
		$BannerModel=new BannerModel();
		$data=$BannerModel->getOne($id);

		$this->assign('data',$data);
		
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
		
		
	   $data=$request->param();
        unset($data['file']);


    if(isset($data['banner_pic'])){

	
	   //'//'转换		
       $str=$data['banner_pic'];
	   $ccc=explode('\\', $str);
	   $star=join('/',$ccc);
	   $data['banner_pic']='/'.$star;
	
    }


        $BannerModel  =   new  BannerModel;

          $dataa = $BannerModel->upBanner($data,$id);
        if($dataa){

          return ['status'=>'success','msg'=>'修改成功'];

        }

        return ['status'=>'success','msg'=>'修改失败'];
	

    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
          $BannerModel=new BannerModel();

        $res=$BannerModel->delcate($id);

        return json($res);
    }
}

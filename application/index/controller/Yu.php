<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use think\Validate;
class Yu extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index($cid)
    {

		//获取上级栏目ID
		$idd=db('cate')->where('cid',$cid)->value('pid');
		
		//查询上级栏目一条数据
		$cate=db('cate')->find($idd);
		
		//查询点击栏目信息
	    $cates=db('cate')->order('sort desc')->find($cid);


       //根据主栏目ID。获取主栏目下所有子栏目
        $res=db('cate')->where(['pid'=>$idd])->field('cid,pid,name,sort,static,type')->select();


      $cad=input('cid');







		$this->assign('res',$res);

	   $this->assign('cates',$cates);
       $this->assign('cad',$cad);
	   $this->assign('cate',$cate);
       return view();
	   
	   
    }


  
    public function save(Request $request)
    {

        $data=$request->only(['code','__token__']);

		$validate=new Validate;
		
		$rule=['code|验证码'=>'captcha|token'];
		
		if(!$validate->check($data,$rule)){
			return (['status'=>'fail','msg'=>$validate->getError()]);
		}
		

	     $res=$request->param();
		 
		 $res['create_time']=Date('Y-m-d H:i:s');
		 

	     unset($res['__token__']);
	     unset($res['code']);
		 

		 
		 $datas=db('make')->insert($res);

	   if($res){
		   
	 return (['status'=>'success','msg'=>'预约成功<br/>请保持电话畅通,我们会尽快与您联系！']);
   
	   }else{
		   
		   return (['status'=>'fail','msg'=>'预约失败']);
		   
	   }

    }

   
}

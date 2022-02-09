<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\Administrator as AdministratorModel;
use think\Validate;
use think\Session;
class Login extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
	
        return view();

    }

   
   
     public function login(Request $request)
    {
		//获取验证码
		$data=$request->only(['code','__token__']);

		$validate=new Validate;
		$rule=['code|验证码'=>'captcha|token'];
		if(!$validate->check($data,$rule)){
			return json(['status'=>'fail','msg'=>$validate->getError()]);
		}
		
		$username=$request->param('username','trim');
		$password=$request->param('password','trim');
		
		$AdministratorModel=new AdministratorModel();
        $res=$AdministratorModel->checkAdmin($username,$password);
		

		return ($res);

	   
    }
	
	
	
	public function logout(){
		
		
		session('username',null);
		$this->redirect('/login');
		
	}
   
   
   
   
   
   
}

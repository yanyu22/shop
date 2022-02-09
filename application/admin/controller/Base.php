<?php

namespace app\admin\controller;
use think\Controller;
use think\Request;

class Base extends Controller
{
	
	
  public function _initialize()
    {

       if(!session('username')){
		   $this->redirect('/login');
	   };

	 $user_id =session('user_id');
   $is_admin= db('administrator')->where('id',$user_id)->value('is_admin');


   if($is_admin){
   $menu=db('auth')->where('auth_ismenu',1)->select();
   $sun_auth=db('auth')->where('auth_ismenu',0)->select();
   $sun_auth=array_column($sun_auth,'auth_url');
   }else{

    $auth_ides=db('admin_role')->alias('a')->where('user_id',$user_id)
                                ->join('role_auth r','r.role_id = a.role_id')
                                ->value('auth_ids');
    $menu= db('auth')->where('id','in',$auth_ides)->where('auth_ismenu',1)->select();
    $sun_auth= db('auth')->where('id','in',$auth_ides)->where('auth_ismenu',0)->select();
    $sun_auth=array_column($sun_auth,'auth_url');
   }

   $new_menu=$this->subMenu($menu);


   $path=strtolower('/admin/'.request()->controller().'/'.request()->action());

   $url=['/admin/index/index'];

   if(!$is_admin && !in_array($path,$url)){

     $auth_id= db('auth')->where('auth_url',$path)->value('id');

     $auth_ides=db('admin_role')->alias('a')->where('user_id',$user_id)
                                ->join('role_auth r','r.role_id = a.role_id')
                                ->value('auth_ids');

     $auth_ides=explode(',',$auth_ides); 

    if(!in_array($auth_id,$auth_ides)){
      die('没有访问权限');

    }



   }





  $this->assign('sun_auth',$sun_auth);
  $this->assign('new_menu',$new_menu);


    }
	
	
	public function subMenu($menu){


       $new_menu=[];
		   foreach($menu as $k=>$v){

						     if($v['auth_pid']==0){

						     	  $new_menu[$k]=$v;
						     	  unset($menu[$k]);
						     }

						     foreach($menu as $kk=>$vv){
						        if($vv['auth_pid']==$v['id']){
						         $new_menu[$k]['sub'][]=$vv;

						        }


						     }


		    }

return  $new_menu;

	}












	

  
}

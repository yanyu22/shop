<?php
namespace app\admin\controller;
use app\admin\model\Administrator as AdministratorModel;
use think\Request;
use app\admin\controller\Base;
class Administrator extends Base
{

    public function index()
    {
		
       $data=db('administrator')->alias('a')
       ->join('admin_role c','a.id=c.user_id')
       ->join('role w','c.role_id=w.id')
       ->field('a.id,a.username,a.create_time,w.role_name,w.role_desc')
       ->paginate(10);

	    $this->assign('data',$data);
	
       return view();
	   
    }
	
	



    public function add()
    {
      

     if(request()->isPost()){

     	  $data=request()->param();
     	  $AdminValidate =validate('AdminValidate');
        if(!$AdminValidate->check($data)){
			  return json(['status'=>'fail','msg'=>$AdminValidate->getError()]);
  
			}

     	  $salt=mt_rand(0000,9999);
        $password=md5($data['password'].$salt);
        $caeate_time=time();
        $role_id=$data['role_id'];

 	     $user_id=db('administrator')->insertGetId(['username'=>$data['username'],'password'=>$password,'salt'=>$salt,'create_time'=> $caeate_time]);

        if($user_id){

        	$res= db('admin_role')->insert(['user_id'=>$user_id,'role_id'=>$role_id]);
		   if($res) {
					 return (['status'=>'success','msg'=>'添加成功']);

				  }else{
					  
					 return (['status'=>'fail','msg'=>'添加失败']);
				}


        }else{

        	 return (['status'=>'success','msg'=>'添加失败']);

        }

  
    

     }else{


      $role=db('role')->select();
      $this->assign('role',$role);
      return view('add');

     }



    }





    public function edit($id)
    {
		
							$data=db('administrator')->alias('a')->where('a.id',$id)
							   	->join('admin_role r','a.id=r.user_id')
							   	->field('a.id,a.username,r.role_id')
							   	->find();						
							   	$role=db('role')->select();

							  	$this->assign('data',$data); 
							  	$this->assign('role',$role);
						       return view();

						  }


	   

  

	
	public function update(Request $request,$id){


		  $data=$request->param();

		  $salt=mt_rand(0000,9999);
        $data['password']=md5($data['password'].$salt);
        $update_time=time();

        $aa=db('administrator')->where('id',$id)->update(['password'=>$data['password'],'salt'=>$salt,'create_time'=> $update_time]);

        if($aa){
		        $res= db('admin_role')->where('user_id',$id)->update(['role_id'=>$data['role_id'],'user_id'=>$id]);
				    if($res) {
							 return (['status'=>'success','msg'=>'更新成功']);

						  }else{
							  
							 return (['status'=>'fail','msg'=>'更新失败']);
						}


        }else{

        	 return (['status'=>'success','msg'=>'更新失败']);

        }







		
		
	  }


    public function delete($id)
    {

        $AdministratorModel=new AdministratorModel();
        $res=$AdministratorModel->delAdmin($id);
   

        return json($res);
    }


   



















   
 }

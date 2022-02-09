<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Role as RoleModel;
use think\Db;

class Role extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
     
	
     $role= db('role')->alias('a')->join('role_auth w','a.id = w.role_id')->field('a.id,a.role_name,w.auth_ids,w.role_id,a.role_desc')->select();
    
     foreach($role as $k=>$v){

     $admin=db('admin_role')->alias('a')->where('a.role_id',$v['id'])
     ->join('administrator w','a.user_id=w.id')->field('w.username')
     ->select();

     $admin=array_column($admin, 'username');
     $admin=implode(',',$admin);
     $role[$k]['admin']=$admin;

     }





     $this->assign('role',$role);

		
        return view();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function add()
    {



      if(request()->isPost()){

       $data= request()->param();

       $did=$data['auth_id'];

       $ddid=implode(",", $did);

       $role_id=db('role')->insertGetId(['role_name'=>$data['role_name'],'role_desc'=>$data['role_desc']]);

       if($role_id){

       $res= db('role_auth')->insert(['role_id'=>$role_id,'auth_ids'=>$ddid]);

       if($res){     
           return ['status'=>'success','msg'=>'添加成功'];
       }
       
          return ['status'=>'fail','msg'=>"增加失败"];
       }


        }else{

                       $pid_auth=db('auth')->field('id,auth_name')->where('auth_pid',0)->select();

                        foreach($pid_auth as $k=>$v){
                        $z_cate= db('auth')->where('auth_pid',$v['id'])->field('id,auth_name,auth_pid')->select();
                        $pid_auth[$k]['c_auth']=$z_cate;
                        foreach($z_cate as  $kk=>$vv){

                            $s_auth= db('auth')->where('auth_pid',$vv['id'])->field('id,auth_name,auth_pid')->select();

                            if($s_auth){
                            $pid_auth[$k]['c_auth'][$kk]['s_auth']= $s_auth;

                            }
                     
                         }


                       }

              $this->assign('pid_auth',$pid_auth);

                return view();


        }



    }

     /**
     * 递归函数
     */   
    
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
    



    public function edit($id)
    {
		  

       $role= db('role')->alias('a')->join('role_auth w','a.id = w.role_id')->field('a.id,a.role_desc,a.role_name,w.auth_ids,w.role_id')->where('a.id',$id)->find();
   
       $role['auth_ids']=explode(',',$role['auth_ids']);

       $pid_auth=db('auth')->field('id,auth_name')->where('auth_pid',0)->select();

       foreach($pid_auth as $k=>$v){

        $z_cate= db('auth')->where('auth_pid',$v['id'])->field('id,auth_name,auth_pid')->select();
        $pid_auth[$k]['c_auth']=$z_cate;
         foreach($z_cate as  $kk=>$vv){

         $s_auth= db('auth')->where('auth_pid',$vv['id'])->field('id,auth_name,auth_pid')->select();

            if($s_auth){
            $pid_auth[$k]['c_auth'][$kk]['s_auth']= $s_auth;

            }
     
         }


       }

   $this->assign('pid_auth',$pid_auth);
   $this->assign('role',$role);

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


       $data= request()->param();

       $did=$data['auth_id'];

       $ddid=implode(",", $did);

       $role_id=db('role')->where('id',$id)->update(['role_name'=>$data['role_name'],'role_desc'=>$data['role_desc']]);

       if($role_id){

       $res= db('role_auth')->where('role_id',$id)->update(['auth_ids'=>$ddid]);

       if($res){     
           return ['status'=>'success','msg'=>'更新成功'];
       }
       
          return ['status'=>'fail','msg'=>"更新失败"];
       }





	 }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    { 
	
	   $RoleModel=new RoleModel;

       $res=$RoleModel->delRole($id);
   

        return json($res);
      
    }
    
    
    

public function Role(){


$aa= db('Role')->where('cate_id',215)->field('id,title,cate_id,create_time')->order('create_time desc')->paginate(10);

 $this->assign('aa',$aa);

  return view();


}



    public function search(){
        
        
        $keywords  = input('keywords');

        if($keywords){
        
        $map['title']=['like','%'.$keywords.'%'];
        
        $search =db('Role')
        ->field('title,id,create_time')
        ->order('sort desc')
        ->where($map)
        ->paginate(10,false,$config=['query'=>array('keywords'=>$keywords)]); 
        
        

        
        $this->assign(array('search'=>$search,'keywords'=>$keywords));
        
        
        }

        $this->assign(array(
        'keywords'=>$keywords,

        ));
    
        
        return view();
        
        
    }







    
    
    
}

<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Auth as AuthModel;
class Auth extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
     
    $data=db('auth')->select();
    $auth=$this->getTree($data);

    $this->assign('auth',$auth);
    return view();
    }




    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function add(Request $request)
    {


   if(request()->isPost()){

       $data=$request->param();
       $AuthModel=new AuthModel;
       $res=$AuthModel->addAuth($data);
       
       if($res){ 
           return ['status'=>'success','msg'=>'添加成功'];
       }
          return ['status'=>'fail','msg'=>"增加失败"];
      }else{   
       $data=db('auth')->select();
       $auth=$this->getTree($data);
       $this->assign('auth',$auth);
        return view('add');
     }




    }

    
     //递归函数
    private function getTree($dataa,$pid=0,$level=0){
       static $list=[];
    
        foreach ($dataa as $k=>$v){
        
        if($v['auth_pid']==$pid){
            $v['level']=$level;
            $list[]=$v;
            unset($v[$k]);
            $this->getTree($dataa,$v['id'],$level+1);
            
        }
        
    }
    
    return $list;
}

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
		
		$data=db('Auth')->where('id',$id)->find();

        $aa=db('auth')->select();
        $res=$this->getTree($aa);
		$this->assign('data',$data);
        $this->assign('res',$res);
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
		$AuthModel=new AuthModel;
	    $res=$AuthModel->UpdateAuth($data,$id);
		
        if($res){
		  return ['status'=>'success','msg'=>'修改成功'];
	    }
		  return ['status'=>'fail','msg'=>'修改失败'];
	    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    { 
	
	   $AuthModel=new AuthModel;
       $res=$AuthModel->delAuth($id);

       return json($res);
      
    }
    
    
    

// public function Auth(){


// $aa= db('Auth')->where('cate_id',215)->field('id,title,cate_id,create_time')->order('create_time desc')->paginate(10);

//  $this->assign('aa',$aa);

//   return view();


// }



    public function search(){
        
        
        $keywords  = input('keywords');

        if($keywords){
        
        $map['title']=['like','%'.$keywords.'%'];
        
        $search =db('Auth')
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

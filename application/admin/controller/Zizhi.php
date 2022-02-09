<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Zizhi as ZizhiModel;
class Zizhi extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
     
	
    $zizhi= db('Zizhi')->alias('a')->join('cate w','a.cate_id = w.cid')->field('id,title,cate_id,name,create_time')->order('create_time desc')->paginate(10);
    

    $this->assign('zizhi',$zizhi);

		
        return view();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {

       $dataa=db('cate')->field('cid,name,pid')->select();

        $data=$this->getTree($dataa);
        $this->assign('data',$data);

        return view('add');
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
    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {

	$aa=$request->param();

        if(isset($aa['pic'])){

             $aa['pic']=str_replace("\\", '/', $aa['pic']);
        }

       unset($aa['file']);
       
	   $ZizhiModel=new ZizhiModel;
	   
	   $res=$ZizhiModel->addZizhi($aa);
	   
	   if($res){
		   
		   return ['status'=>'success','msg'=>'添加成功'];
	   }
	   
	      return ['status'=>'fail','msg'=>"增加失败"];
	   
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
		
		$data=db('Zizhi')->where('id',$id)->find();

        $aa=db('cate')->field('cid,name,pid')->select();
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


        if(isset($data['pic'])){
           
             $data['pic']='/'.str_replace("\\", '/', $data['pic']);
           
   
        }


	  unset($data['file']);


		$ZizhiModel=new ZizhiModel;

	    $res=$ZizhiModel->UpdateSpecial($data,$id);
		
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
	
	   $ZizhiModel=new ZizhiModel;

        $res=$ZizhiModel->delcate($id);

        return json($res);
      
    }
    
    
    

public function Zizhi(){


$aa= db('Zizhi')->where('cate_id',215)->field('id,title,cate_id,create_time')->order('create_time desc')->paginate(10);

 $this->assign('aa',$aa);

  return view();


}



    public function search(){
        
        
        $keywords  = input('keywords');

        if($keywords){
        
        $map['title']=['like','%'.$keywords.'%'];
        
        $search =db('Zizhi')
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

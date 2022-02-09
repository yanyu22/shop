<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\Article as ArticleModel;
use think\Db;
use app\admin\controller\Base;
class Article extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $ArticleModel=new ArticleModel();

        $data=$ArticleModel->articleAll();

        $aa=$ArticleModel->articleCate();
        $cate=$this->getTree($aa);


       $this->assign('cate',$cate);
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
        
        $ArticleModel=new ArticleModel();

        $data=$ArticleModel->articleCate();
        $res=$this->getTree($data);


        $this->assign('res',$res);
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
        
        
        $data=$request->param();


        if(isset($data['keywords'])){

        $data['keywords']=str_replace("，", ',', $data['keywords']);

        }

        if(isset($data['pic'])){

         $data['pic']=str_replace("\\", '/', $data['pic']);

        }


        unset($data['file']);
        $ArticleModel=new ArticleModel();
        $data=$ArticleModel->addArticle($data);
        
        if($data){
            
           return  ['status'=>'success','msg'=>"增加成功"];
            
        }
           return   ['status'=>'fail','msg'=>"增加失败"];
    }


    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        
        
        $ArticleModel=new ArticleModel();
        $data=$ArticleModel->getOne($id);
    
        if(isset($data['keywords'])){
        $data['keywords']=str_replace("，", ',', $data['keywords']);

        }
        $aa=$ArticleModel->articleCate();
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
    
        unset($data['file']);


        if(isset($data['keywords'])){

        $data['keywords']=str_replace("，", ',', $data['keywords']);


        }

        if(isset($data['pic'])){

         $data['pic']=str_replace("\\", '/', $data['pic']);

        }


        if(isset($data['pic'])){
            
         $data['pic']='/'.$data['pic'];
            
        }
        

        $ArticleModel=new ArticleModel();

        $data=$ArticleModel->updateCate($data,$id);

       if($data){

         return['status'=>'success','msg'=>"更新成功"];

        }

        return['status'=>'fail','msg'=>"更新失败"];
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $ArticleModel=new ArticleModel();

        $res=$ArticleModel->delcate($id);

        return json($res);
    }


   







}

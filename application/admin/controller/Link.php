<?php

namespace app\admin\controller;
use think\Request;
use app\admin\model\Link as LinkModel;
use app\admin\controller\Base;
class Link extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
		
		
		$LinkModel=new LinkModel();

        $res=$LinkModel->LinkAll();
	
		$this->assign('res',$res);
		
		
		
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
		
        $aa=$request->param();
	
	
       unset($aa['__token__']);
		 
        $LinkModel=new LinkModel();

        $data=$LinkModel->addLink($aa);

        if($data){
         return ['status'=>'success','msg'=>'增加友情链接成功'];
        }

      return ['status'=>'info','msg'=>'增加友情链接失败'];
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
          $LinkModel=new LinkModel();
		$data=$LinkModel->getOne($id);
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
          $aa=$request->param();
		 unset($aa['id']);
        $LinkModel=new LinkModel();

        $data=$LinkModel->updateLink($aa,$id);

        if($data){

         return json(['status'=>'success','msg'=>'修改成功']);

        }

      return json(['status'=>'info','msg'=>'修改失败']);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $LinkModel=new LinkModel();

        $res=$LinkModel->delcate($id);

        return json($res);
    }
}

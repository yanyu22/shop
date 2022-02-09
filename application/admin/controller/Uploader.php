<?php

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Config;
class Uploader extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function articleImg(Request $request)
    {
		
		//获取文件类型
        $validate=Config::get('ArticleImg.VALIDATE');
		//存储地址
        $path=Config::get('ArticleImg.ARTPATH');

        $file = $request->file('file');
		
        $res=$file->validate($validate)->move($path);

       if($res){

         $fileName=$res->getPathName();
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }




//案例
 public function AnliImg(Request $request)
    {
        $validate=Config::get('AnliImg.VALIDATE');
        $path=Config::get('AnliImg.ARTPATH');
        $file = $request->file('file');
        $res=$file->validate($validate)->move($path);
       if($res){

            $fileName=$res->getPathName();
    
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }


//荣誉资质
 public function zizhiImg(Request $request)
    {
        $validate=Config::get('ZizhiImg.VALIDATE');
    
        
        $path=Config::get('ZizhiImg.ARTPATH');

        $file = $request->file('file');
        $res=$file->validate($validate)->move($path);

       if($res){
           
          $fileName=$res->getPathName();
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }   




	
	//网站配置图片。logo,龚总好等
	
    public function systemImg(Request $request)
    {
		
		//获取文件类型
        $validate=Config::get('system.VALIDATE');
		//存储地址
        $path=Config::get('system.ARTPATH');

        $file = $request->file('file');
		
	
        $res=$file->validate($validate)->move($path);

       if($res){

         $fileName=$res->getPathName();
          $data=['code'=>'1','msg'=>'上传成功','info'=>$fileName];
       }else{

         $data=['code'=>'1','msg'=>$file->getError()];
    
       }

    return json($data);

    }
	


//轮播图
 public function bannerImg(Request $request)
    {
        $validate=Config::get('BannerImg.VALIDATE');
	
		
        $path=Config::get('BannerImg.ARTPATH');

        $file = $request->file('file');
        $res=$file->validate($validate)->move($path);

       if($res){
		   
          $fileName=$res->getPathName();
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }



//栏目banner
 public function CateImg(Request $request)
    {
        $validate=Config::get('CateImg.VALIDATE');
        $path=Config::get('CateImg.ARTPATH');
        $file = $request->file('file');
        $res=$file->validate($validate)->move($path);
       if($res){

            $fileName=$res->getPathName();
	
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }
	
	
	

//关于我们
 public function aboutusImg(Request $request)
    {
        $validate=Config::get('aboutusImg.VALIDATE');
        $path=Config::get('aboutusImg.ARTPATH');
        $file = $request->file('file');
        $res=$file->validate($validate)->move($path);
       if($res){

            $fileName=$res->getPathName();
	
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }


//特色课程


 public function productImg(Request $request)
    {
        $validate=Config::get('specialcolour.VALIDATE');
        $path=Config::get('specialcolour.ARTPATH');
        $file = $request->file('file');
        $res=$file->validate($validate)->move($path);
       if($res){

            $fileName=$res->getPathName();
	
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }


 public function scienceImg(Request $request)
    {
        $validate=Config::get('scienceImga.VALIDATE');
        $path=Config::get('scienceImga.ARTPATH');
        $file = $request->file('file');
        $res=$file->validate($validate)->move($path);
       if($res){

            $fileName=$res->getPathName();
	
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }

//园所环境
 public function yuansuoImg(Request $request)
    {
        $validate=Config::get('yaunsuoimG.VALIDATE');
        $path=Config::get('yaunsuoimG.ARTPATH');
        $file = $request->file('file');
        $res=$file->validate($validate)->move($path);
       if($res){

            $fileName=$res->getPathName();
	
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }

    
	
	
//图集

 public function tuji(Request $request)
    {

     if($this->request->isPost()){
                 $res['code']=1;
                 $res['msg'] = '上传成功！';
                 $file = $this->request->file('file');
                 $info = $file->move('../public/upload/admin/');
                 //halt( $info);
                 if($info){
                     $res['name'] = $info->getFilename();
                     $res['filepath'] = 'upload/admin/'.$info->getSaveName();
                 }else{
                     $res['code'] = 0;
                     $res['msg'] = '上传失败！'.$file->getError();
                 }
                 return $res;
             }

    }


	
	




	
	
//品牌管理
 public function brandImg(Request $request)
    {
        $validate=Config::get('brandImg.VALIDATE');
    
        
        $path=Config::get('brandImg.ARTPATH');

        $file = $request->file('file');
        $res=$file->validate($validate)->move($path);

       if($res){
           
          $fileName=$res->getPathName();
          $data=['status'=>'success','info'=>$fileName];
       }else{

         $data=['status'=>'fail','info'=>$file->getError()];
    
       }


    return json($data);

    }   

	
}

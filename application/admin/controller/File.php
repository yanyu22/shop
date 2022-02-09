<?php
namespace app\admin\controller;
use think\Request;
use app\admin\model\File as FileModel;
class File extends Base
{

    public function index($curr=null)
    {

        $curr=iconv('UTF-8', 'GB2312', $curr);

        //点击进入文件夹
         if($curr){
            //路径是否是目录
            if(file_exists($curr))
            //查看权限限制
   

            if(stripos($curr,ROOT_PATH)===0 && stripos($curr,ROOT_PATH."..")===false){
             chdir($curr);//打开文件夹

            }

         
          }

       //$file=ROOT_PATH.'public';
       //获取当前站点根目录
       $file=getcwd();
       //打开目录，返回句柄资源
       $dir=opendir($file);
       $data=[];
       $num=[];
       $num['filess']=0;
       $num['dir']=0;
       while($filename =readdir($dir)){

            if($filename!="." && $filename!=".."){

                //如果是目录，ico赋值
             if(is_dir($filename)){

                $arr['ico']="#icon-a-wenjianjiamulu";//赋值ico
                $arr['flag']=1;//目录
                $num['dir']++;//目录数量
              }else{
        
                $arr['ico']=$this->setico($filename);//赋值ico
                $arr['flag']=0;//文件
                $num['filess']++;//文件数量
              }
              $arr['curr']=getcwd()."\\".$filename;//当前目录+文件名+转换utf-8iconv('GB2312', 'UTF-8', getcwd()."\\".$filename);
              $arr['filename']=$filename;//文件名称
              $arr['size']=filesize($filename);//文件大小
              $arr['ctime']=filectime($filename);//创建时间
              $arr['mtime']=filemtime($filename);//修改时间
              $data[]=$arr;
            }
        }
        //转化一维数组并取flag字段
        $arrColum=array_column($data,'flag');
        //倒序排列---文件在上
        array_multisort($arrColum,SORT_DESC,$data);

        $this->assign([
        'curdir'=>$file,
        'data'=>$data,
        'num'=>$num,
        ]);
        return view();
    }

    

    private function setico($filename){

     $exc=strtoupper(substr($filename,strrpos($filename, ".")));
     $icon="";
     switch($exc){

     case ".HTML":
        $icon="#icon-HTML";
        break;

     case ".ZIP":
        $icon="#icon-zip-1";
        break;

     case ".PHP":
        $icon="#icon-php";
        break;
     case ".JS":
        $icon="#icon-js";
        break;

    case ".CSS":
        $icon="#icon-css";
        break;

    case ".TXT":
        $icon="#icon-txt";
        break;

    case ".PNG":
        $icon="#icon-PNGtubiao";
        break;

    case ".JPG":
        $icon="#icon-Jpg";
        break;

    case ".JPEG":
        $icon="#icon-JPEG";
        break;
        
    case ".JSON":
        $icon="#icon-JSON";
        break;
        

     default:
        $icon="#icon-wenjian";

    
    }
      return $icon;
    
}


public function del(){

if(request()->isAjax()){

   $dizhi=input('dizhi');
   $data=iconv('UTF-8', 'GB2312', urldecode($dizhi));   
   


   if(is_dir($data)){

      $scan=scandir($data);
     // 删除空文件夹
      if(count($scan)===2){
          @rmdir($data);
          return  json(['status'=>'success','msg'=>"删除(空)目录成功"]);   

      }else{

         return   json(['status'=>'fail','msg'=>"目录(不为空)失败"]);

      }

   }



   
   if(is_file($data)){
     @unlink($data);

        return  json(['status'=>'success','msg'=>"删除成功"]); 

      }else{

        return   json(['status'=>'fail','msg'=>"删除失败"]);

      }
        

}



}




//重命名
public function chong(){

if(request()->isAjax()){
//$file=iconv('UTF-8', 'GB2312', urldecode(input('file'))); 
$file=urldecode(input('file')); 

$filename=input('filename');
//$newfilename=iconv('UTF-8', 'GB2312', dirname($file).DS.$filename);
$newfilename=dirname($file).DS.$filename;

    //函数检查文件或目录是否存在。
    if(file_exists($newfilename)){
    
       return  json(['status'=>'error','msg'=>"文件名已存在"]); 

    }

    @rename($file,$newfilename);
    return  json(['status'=>'success','msg'=>"重命名成功"]);

}



}



//文件编辑
public function edit(){

        $file=urldecode(input('file')); 
        //判断是否存在
        if(empty($file) || !file_exists($file)){

            $this->error('操作异常');

        }


        $arr=['.PHP','.HTML','.JS','.CSS','.XML','.HTACCESS','.TXT'];
        /*
        strtoupper--小写转化为大写
        substr-----截取
        $file---字符串
        strrpos ---最后一次出现的位置
        */
        $res=strtoupper(substr($file,strrpos($file,".")));

        //比较
        if(!in_array($res,$arr)){

              $this->success('该文件类型不支持编辑');
             
        }

        if(request()->isPost()){

          $code=input('code');
          //打开要打开的文件,w所有
          $fp=fopen($file, 'w');
          //写入芯内容
          fwrite($fp,$code);//fputs
          //关闭文件
          fclose($fp);
          $this->success('文件保存成功','/admin/file/index');


        }


        $code=file_get_contents($file);//获取文件内容

        $this->assign('code',$code);

        return view();

}




//文件下载
public function download($curr=null){

      //解码
      $file= urldecode($curr);

      if(!file_exists($file)){

        return  json(['status'=>'error','msg'=>"文件不存在"]); 

      }

       $filename=basename($file);//获取文件名

       header("Content-Disposition: attachment; filename=".$filename);//指定请求头信息并且下载文件名字一样
       readfile($file);//readfile() 强制下载

}


//创建目录

/*

   *  @param  createfile //创建文件夹

   *  @param  createpath  // 创建的路径

   *  @param  file_exists() // 查看是否文件夹有同样的目录

   *  @param  file // 创建的的路径 基于文件夹 ./Public/Uploads/  下创建修改

   *  @param  mkdir // 创建文件夹的函数

   *  @param 2017/11/20  8:57

   */
//创建文件夹
public function createFile(){


    if(request()->isAjax()){
       //获取新文件夹名称
       $createfile=input('filename');
       //获取当前解码路径
       $createpath=urldecode(input('file'))."\\".$createfile;
       //$createpath = iconv('utf-8', 'gb2312', $aa);

       if(file_exists($createpath) == false){

        //检查是否有该文件夹，如果没有就创建，并给予最高权限
        if (mkdir($createpath)) {
           return  json(['status'=>'success','msg'=>"文件夹创建成功"]); 
        } else {
             return  json(['status'=>'error','msg'=>"文件夹创建失败"]); 
        }


    }else{

         return  json(['status'=>'error','msg'=>"文件夹已存在"]); 

    }


 }



}


//上传资料
public function uploadFile(){

    if(request()->isPost()){
       $path=input('path');
       $file = request()->file('file');
       $info = $file->move($path);
      if($info){

         return  json(['status'=>'success','msg'=>"上传成功"]); 


      }else{

        return  json(['status'=>'error','msg'=>"上传失败"]); 
      }

      

 }



}









}

<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpStudy\PHPTutorial\WWW\rbac\public/../application/admin\view\file\index.html";i:1644311933;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>文件管理</title>
	<link rel="stylesheet" href="/static/admin//lib/layui/css/layui.css">
	<script src="/static/admin/iconfont/iconfont.js"></script>
	<style>
		.fileicon i{font-size:1.8em;color:#FFE88C;-webkit-text-stroke: 1px #F1C95F;}
		.layui-table[lay-size="lg"] td, .layui-table[lay-size="lg"] th {
			padding: 15px 10px;
		}
		.filelink{color:#20A53A;}
		.filelink:hover{
			color:#333;
		}
		.cz{display:none;}
		tr:hover .cz{display: block;}



.my-icon{
  width: 1em;
  height: 1em;
  vertical-align: -0.15em;
  fill: currentColor; 
  overflow: hidden;
}



	</style>     
</head>
<body style="padding:15px;">
<div class="head-top">
	<button class="layui-btn layui-btn-sm layui-btn-primary">
	  <i class="layui-icon"><a href="?curr=<?php echo $curdir; ?>\..">上级目录<a/></i>
	</button>

		<button class="layui-btn layui-btn-sm layui-btn-primary">
	  <i class="layui-icon"><a href="javascript:;" onclick="createFile('<?php echo urlencode($curdir); ?>')">新建文件夹<a/></i>
	  </button>


		<button class="layui-btn layui-btn-sm layui-btn-primary" id="test1" >
	   <i  class="layui-icon">&#xe67c;</i>上传文件
	    <input type="hidden" id='cc'  name="idcard" value="<?php echo $curdir; ?>"  />
	  </button>


	<button class="layui-btn layui-btn-sm layui-btn-primary" id="reload">
	  <i class="layui-icon">&#x1002;</i>
	</button>
	<button class="layui-btn layui-btn-sm layui-btn-danger">当前路径：<?php echo $curdir; ?></button>
	<span class="layui-btn layui-btn-sm layui-btn-success" style="float:right;">共<?php echo $num['dir']; ?>个目录，<?php echo $num['filess']; ?>个文件</span>
</div>
<div class="file-list">
	<table class="layui-table" lay-size="lg" lay-skin="line">
	  <thead>
		<tr>
		  <th>文件名</th>
		  <th>文件大小</th>
		  <th>创建时间</th>
		  <th>最后修改时间</th>
		  <th style="text-align:right;width:300px;">操作</th>
		</tr> 
	  </thead>
	  <tbody>


<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
		<tr>
		  <td class="fileicon">

		  	<svg class="my-icon" aria-hidden="true">
  			<use xlink:href="<?php echo $v['ico']; ?>"></use>
			</svg>

		  	<a href="<?php echo !empty($v['flag'])?'?curr='. $v['curr']:'javascript:;'; ?>"> <?php echo $v['filename']; ?></a>
		  </td>
		  <td><?php echo !empty($v['flag'])?"目录":sizeFrlesss($v['size'],2); ?></td>
		  <td><?php echo date("Y-m-d H:s",$v['ctime']); ?></td>
		  <td><?php echo date("Y-m-d H:s",$v['mtime']); ?></td>
		  <td>
			<span class="cz">
				<a class="filelink" href="javascript:;" onclick="DeleteFile('<?php echo urlencode($v['curr']); ?>')">删除</a> |

				<?php if($v['flag']==0): ?>
				<a class="filelink" href="<?php echo url('/admin/file/edit'); ?>?file=<?php echo urlencode($v['curr']); ?>" >编辑</a> |
				<?php endif; ?>

				<a class="filelink" href="javascript:;" onclick="ReName('<?php echo urlencode($v['curr']); ?>','<?php echo basename($v['curr']); ?>')">重命名</a> |

				<?php if($v['flag']==0): ?>
				<a class="filelink" href="<?php echo url('/admin/file/download'); ?>?curr=<?php echo urlencode($v['curr']); ?>" >下载</a>
				<?php endif; ?>
			</span>
		  </td>
		</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>

	  </tbody>
	</table>
	<div class="page">
		<div class="layui-box layui-laypage layui-laypage-molv" style="float:right;" id="layui-laypage-4"><a href="javascript:;" class="layui-laypage-prev layui-disabled" data-page="0">上一页</a><span class="layui-laypage-curr"><em class="layui-laypage-em" style="background-color:#FF5722;"></em><em>1</em></span><a href="javascript:;" data-page="2">2</a><a href="javascript:;" data-page="3">3</a><a href="javascript:;" data-page="4">4</a><a href="javascript:;" data-page="5">5</a><span class="layui-laypage-spr">…</span><a href="javascript:;" class="layui-laypage-last" title="尾页" data-page="10">10</a><a href="javascript:;" class="layui-laypage-next" data-page="2">下一页</a></div>
	</div>
</div>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="/static/admin//lib/layui/layui.js" charset="utf-8"></script>

<script>

layui.use(['upload','layer'], function(){
var layer = layui.layer;
var upload = layui.upload;

  path=$('#cc').val();
  //执行实例
  var uploadInst = upload.render({

    elem: '#test1' //绑定元素
    ,url: '/admin/file/upload/' //上传接口
    ,accept: 'file' //允许上传的文件类型
    ,data: {'path':path}
    ,done: function(res){

     	 	if(res.status=='success'){

     	 	layer.msg(res.msg,{time:1000},function(){
			 	//言辞一秒刷心
        location.reload();
			    });


				 	}

    }
    ,error: function(){

        layer.msg(res.msg);

    }
  });




}); 




function DeleteFile(dizhi){




layer.confirm('确定要删除文件(目录)吗？', {icon: 3, title:'温馨提示'}, function(index){
 
 		$.ajax({
			 type:"post",
			 url:"/admin/file/del",
			 data:{'dizhi':dizhi},
			 success:function(res){
			 layer.msg(res.msg,{time:1000},function(){
			 	//言辞一秒刷心
        location.reload();
			 });

		 }


		}) 




 
});





}



function ReName(file,filename){

layer.prompt({
 
  value:filename,
  title: '请输入新的文件名'
}, function(value, index, elem){

 		$.ajax({
			 type:"post",
			 url:"/admin/file/chong",
			 data:{'file':file,'filename':value},
			 success:function(res){

				 layer.msg(res.msg,{time:1000},function(){
				 	//言辞一秒刷心
				 	if(res.status=='success'){
				 		  location.reload();
				 	}
	      
				 });

		 }


		}) 



});




}
	


//新建文件夹
function createFile(file){

layer.prompt({
  value:'',
  title: '请输入要创建的文件名'
}, function(value, index, elem){

 		$.ajax({
			 type:"post",
			 url:"/admin/file/createfile",
			 data:{'filename':value,'file':file},
			 success:function(res){

				 layer.msg(res.msg,{time:1000},function(){
				 	//言辞一秒刷心
				 	if(res.status=='success'){
				 		  location.reload();
				 	}
	      
				 });

		 }


		}) 



});




}








</script>
	<script>
	$(function(){
		$(window.parent.document).find('#righttitle').text($('title').text());
		$('#reload').on('click',function(){
			location.reload();
		})
	})
	</script>



</body>
</html>

<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpStudy\PHPTutorial\WWW\rbac\public/../application/admin\view\role\index.html";i:1644194704;}*/ ?>
<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/static/admin//css/font.css">
        <link rel="stylesheet" href="/static/admin//css/xadmin.css">
        <script src="/static/admin//lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/static/admin//js/xadmin.js"></script>
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">角色管理</a>
            <a>
              <cite>角色列表</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5">
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn"  style="display: <?php echo in_array('/admin/administrator/add',$sun_auth)?'':'none'; ?>;"  onclick="xadmin.open('添加角色','/admin/role/add',800,500)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                <tr>
                                  <th>
                                    <input type="checkbox" name=""  lay-skin="primary">
                                  </th>
                                  <th>ID</th>
                                  <th>角色名</th>
                                   <th>用户列表</th>
                                  <th>拥有权限规则</th>
                                  <th>描述</th>
                           
                                  <th>操作</th>
                              </thead>
                              <tbody>

                        <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>        
                                <tr>



                                  <td>
                                    <input type="checkbox" name=""  lay-skin="primary">
                                  </td>
                                  <td><?php echo $vo['id']; ?></td>
                                  <td><?php echo $vo['role_name']; ?></td>
                                   <td><?php echo $vo['admin']; ?></td>
                                  <td><?php echo $vo['auth_ids']; ?></td>
                                  <td><?php echo $vo['role_desc']; ?></td>
                               
                                  <td class="td-manage">



                                  <a style="display: <?php echo in_array('/admin/role/edit',$sun_auth)?'':'none'; ?>;"  onclick="xadmin.open('编辑','<?php echo url('/admin/role/edit/'.$vo['id']); ?>',800,500)" class="layui-btn layui-btn-warm">编辑</a>


              
                                  <a   style="display: <?php echo in_array('/admin/role/delete',$sun_auth)?'':'none'; ?>;"  onclick="member_del(this,'<?php echo $vo['id']; ?>')" href="javascript:;" class="layui-btn layui-btn-danger">删除</a>



                                  </td>

                                </tr>

                                <?php endforeach; endif; else: echo "" ;endif; ?>
                              </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
             
                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
<script>

  function member_del(obj, id) {



            layer.confirm('确认要删除吗？',function(index) {
                //发异步删除数据
                     $.post("<?php echo url('/admin/role/delete'); ?>",{id:id},function(res){
                     layer.msg(res.info,{time:1000},function(){
                      if(res.status=='success'){

                         $(obj).parents("tr").remove();
                      }
                  });
              },'json');
            
            });
        }

</script>






</html>
<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>微信菜单管理</title>
	<link rel="stylesheet" href="/sncss/web/css/compiled/new-user.css" type="text/css" media="screen" />  
	
</head>
<body>
   <div class="container-fluid">
            <div id="pad-wrapper" class="new-user">
                <div class="row-fluid header">
                    <h4>微信管理&nbsp;>&nbsp菜单管理</h4>
                </div>
                <div class="row-fluid form-wrapper">
                    <div class="row-fluid table">
                <table class="table table-hover" style="border-collapse:collapse;">
                 <thead >
                    <tr>
                    <th style="display: none"style="border:2px solid #ddd">PID</th>
                        <th style="border-bottom:2px solid #ddd;width:5%">ID</th>
                        <th style="border-bottom:2px solid #ddd;width:10%">名称</th>
                        <th style="border-bottom:2px solid #ddd;width:10%">类型</th>
                        <th style="border-bottom:2px solid #ddd;width:55%">链接</th>
                        <th style="border-bottom:2px solid #ddd;width:10% ">点击事件key</th>
                    <th class="span3 sortable" style="width:20%;border-bottom:2px solid #ddd;width:10%">
                         <span class="line"></span>操作
                     </th>
                    </tr>
                    </thead>
			
                    <tbody style="text-align:center;">
                    <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><tr>
							<td style="display: none"><?php echo ($menu["pid"]); ?></td>
                            <td parent="<?php echo ($menu["pid"]); ?>"><?php echo ($menu["menu_id"]); ?></td>
                            <td width="200" ><?php echo ($menu["menu_name"]); ?></td>
                            <td><?php echo ($menu["menu_type"]); ?></td>
                            <td><?php echo ($menu["view_url"]); ?></td>
                            <td><?php echo ($menu["event_key"]); ?></td>
                            <td style="text-align: center;">
                            <a href="<?php echo U('Index/medit',array('id'=>$menu['menu_id']));?>"class="btn btn-default btn-sm">修改</a>&nbsp 
                            <a class="btn btn-danger btn-sm" href="<?php echo U('Index/delmenu',array('id'=>$menu['menu_id']));?>" onclick="return confirm('你确定要删除吗？')">删除</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <table class="table table-hover">
                    <span style="font-size: 16px;color: red;">一级菜单最多为三个，二级菜单最多为五个</span>
                </table>
                <table class="table table-hover">
                    <span style="font-size: 16px;color: red;">如新增修改自定义菜单后,请点击下面的生成按钮重新生成，生成24小时后生效</span>
                     <a href="<?php echo U('Index/creatmenu');?>" class="btn-flat success pull-right" style="margin-right:150px;">重新生成菜单</a>
                    <a href="<?php echo U('Index/medit');?>" class="btn-flat error pull-right" style="margin-right:50px;"><span>&#43;</span>添加菜单</a>
                </table>
            </div>
                </div>
            </div>
        </div>
	<!-- scripts -->
    <script src="/sncss/web/js/jquery-latest.js"></script>
    <script src="/sncss/web/js/bootstrap.min.js"></script>
    <script src="/sncss/web/js/theme.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			var eqli = $("#dashboard-menu").children().eq(9);
			eqli.attr('class','active');
			$("#dashboard-menu .active .submenu").css("display","block");
		});
	 </script>	
	<script type="text/javascript">
        $(function () {
            var $buttons = $(".toggle-inputs button");
            var $form = $("form.new_user_form");
            $buttons.click(function () {
                var mode = $(this).data("input");
                $buttons.removeClass("active");
                $(this).addClass("active");

                if (mode === "inline") {
                    $form.addClass("inline-input");
                } else {
                    $form.removeClass("inline-input");
                }
            });
        });
    </script>
</body>
</html>
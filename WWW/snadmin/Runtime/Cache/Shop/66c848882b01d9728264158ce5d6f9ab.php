<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加子菜单</title>
</head>
<body>
	<div class="container-fluid">
	<div id="pad-wrapper" class="form-page">
		<div class="row-fluid header">
			<h3>微信管理&nbsp;>&nbsp;修改分类</h3>
		</div>
		<div class="row-fluid form-wrapper">
			<form action="/admin.php/Shop/Index/medit" method="post">
				<!-- left column -->
				<div class="span8 column">
					<input type="hidden" name="menu_id" value="<?php echo ($rsmenu['menu_id']); ?>" />
					<div class="field-box" style="width: 45%;">
						<div class="field-box">
							<label>上级目录:</label>
							<div class="ui-select span5">
								<select style="width: 100%" name="pid">
									<option value="0">作为一级菜单</option>
									<?php if(is_array($pidmenu)): $i = 0; $__LIST__ = $pidmenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pidmenu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($pidmenu["menu_id"]); ?>"
										<?php if($rsmenu['pid'] == $pidmenu['menu_id']): ?>selected=""<?php endif; ?>
										><?php echo ($pidmenu["menu_name"]); ?>
									</option><?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
							</div>
						</div>
						<label>菜单名称:</label> <input class="span5" type="text"
							data-toggle="tooltip" data-trigger="focus" title="请输入菜单名"
							data-placement="right" name="menu_name"
							value="<?php echo ($rsmenu['menu_name']); ?>" />
					</div>
					<div class="field-box">
						<label>类型:</label>
						<div class="ui-select span5">
							<select style="width: 100%" name="menu_type">
								<option value="none"
									<?php if($rsmenu['menu_type'] == 'none'): ?>selected=""<?php endif; ?>
									>一级菜单
								</option>
								<option value="view"
									<?php if($rsmenu['menu_type'] == 'view'): ?>selected=""<?php endif; ?>
									>超链接
								</option>
								<option value="click"
									<?php if($rsmenu['menu_type'] == 'click'): ?>selected=""<?php endif; ?>
									>点击事件
								</option>
							</select>
						</div>
					</div>
					<div class="field-box" style="width: 100%;">
						<label>点击事件key:</label> <input class="span2" type="text"
							data-toggle="tooltip" data-trigger="focus" title="此处为点击key"
							data-placement="right" name="event_key"
							value="<?php echo ($rsmenu['event_key']); ?>" />
					</div>
					<div class="field-box" style="width: 100%;">
						<label>链接URL:</label> <input class="span6" type="text"
							data-toggle="tooltip" data-trigger="focus" title="此处为链接"
							data-placement="right" name="view_url"
							value="<?php echo ($rsmenu['view_url']); ?>" />
					</div>
					<div class="field-box actions">
						<input type="submit" class="btn-glow primary" value="提交"><span>或</span>
						<input type="reset" value="重置" class="btn-glow primary">
					</div>
				</div>
			</form>
			<!-- right column -->
			<div class="span4 column pull-right">
				<div class="field-box">
					<h3>说明：</h3>
				</div>
				<div class="field-box">请填写正确的链接和名称</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- end main container --> <!-- scripts for this page --> <script
	src="__JS__/jquery-latest.js"></script> <script
	src="__JS__/bootstrap.min.js"></script> <script src="__JS__/theme.js"></script>
 <script type="text/javascript">
	$(document).ready(function(){
		var eqli = $("#dashboard-menu").children().eq(2);
		eqli.attr('class','active');
		$("#dashboard-menu .active .submenu").css("display","block");
	});
</script>
</body>
</html>
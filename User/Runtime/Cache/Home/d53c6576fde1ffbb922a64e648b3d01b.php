<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="/Public/web/css/lib.css?2">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
	<meta content="telephone=no" name="format-detection">
	<title>钱包</title>	
    <script src="/Public/web/js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="/Public/web/css/weui.min.css"/>
	<link rel="stylesheet" href="/Public/web/css/jquery-weui.min.css">
	<link href="/Public/web/css/font-awesome.min.css" rel="stylesheet">
	<link href="/Public/web/fonts/iconfont.css" rel="stylesheet">
	<script src="/Public/web/js/layer.js"></script>
</head>
<body>
	<!--顶部开始-->
	<div class="header">
		<span class="header_l"><a href="javascript:history.go(-1);"><i class="fa fa-chevron-left"></i></a></span>
		<span class="header_c">钱包</span>
		<span style="position: absolute;right: 10%;top: 0px;text-align:center;width:20%;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;font-size: 12px; "><?php echo ($nickname); ?></span>
		<span class="header_r"><a href="javascript:void(0)"><i class="fa fa-user"></i></a></span>
	</div>
	<div class="height40"></div>
	<!--顶部结束-->
<style>
	.user_sy li{
		width: 33.3%;
	}
</style>
	<div style="background-color: #06C1AE ;padding: 20px 0px;  width: 95%;overflow: hidden;color: #FFFFFF;font-size:1.5em;padding-right:5%">
		<a href="<?php echo U('/index.php/Home/Login/logout');?>" style="position:absolute;top:45px;left:19px;width:100px;height:50px;line-height:50px;text-align:center;color:#fff;font-size:12px">安全退出</a>
		<div style="width: 95%;float: right;text-align: center;overflow: hidden;text-align:right;"><p style="font-size:12px">可用生命树:</p><p style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;font-size:30px"><?php echo ($kymoney); ?></p></div>
		<!-- <div style="width:95%;float: right;text-align: center;overflow: hidden;text-align:right;"><p style="float:right"><span style="font-size:12px;display:inline-block;">冻结GEC:</span><span style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;float:right;font-size:1em"><?php echo ($djmoney); ?></span></p></div> -->
	</div>
<div class="weui_grids" style="background-color: #f9f9f9">
	<!-- <a href="/Index.php/Home/Info/mykuangche/" class="weui_grid js_grid" data-id="toast"> -->
		<!-- <div class="weui_grid_icon"> -->
			<!-- <i class="iconfont" style="color: #FE9400;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe601;</i> -->
		<!-- </div> -->
		<!-- <p class="weui_grid_label" style="margin-top: 12px">我的矿机</p> -->
	<!-- </a> -->
	<!-- <a href="/Index.php/Home/Info/myjiaoyi/" class="weui_grid js_grid" data-id="toast"> -->
		<!-- <div class="weui_grid_icon"> -->
			<!-- <i class="iconfont" style="color: #F4403C;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe63f;</i> -->
		<!-- </div> -->
		<!-- <p class="weui_grid_label" style="margin-top: 12px">我的交易</p> -->
	<!-- </a> -->
	<!-- <a href="/Index.php/Home/Info/kuangcheshouyi/" class="weui_grid js_grid" data-id="toast"> -->
	<!-- <div class="weui_grid_icon"> -->
		<!-- <i class="iconfont" style="color: #7E4BE5;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe628;</i> -->
	<!-- </div> -->
	<!-- <p class="weui_grid_label" style="margin-top: 12px">矿机收益</p> -->
<!-- </a> -->
	<!-- <a href="/Index.php/Home/Info/tgsy/" class="weui_grid js_grid" data-id="toast"> -->
		<!-- <div class="weui_grid_icon"> -->
			<!-- <i class="iconfont" style="color: #FEB900;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe603;</i> -->
		<!-- </div> -->
		<!-- <p class="weui_grid_label" style="margin-top: 12px">公会收益</p> -->
	<!-- </a> -->
	<!-- <a href="/Index.php/Home/Myuser/index/" class="weui_grid js_grid" data-id="toast"> -->
		<!-- <div class="weui_grid_icon"> -->
			<!-- <i class="iconfont" style="color: #1C91E2;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe85d;</i> -->
		<!-- </div> -->
		<!-- <p class="weui_grid_label" style="margin-top: 12px">矿工公会</p> -->
	<!-- </a> -->
	<!-- <a href="/Index.php/Home/info/qiugoulkc/" class="weui_grid js_grid" data-id="toast"> -->
		<!-- <div class="weui_grid_icon"> -->
			<!-- <i class="iconfont" style="color: #e64340;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe615;</i> -->
		<!-- </div> -->
		<!-- <p class="weui_grid_label" style="margin-top: 12px">求购GEC</p> -->
	<!-- </a> -->



	<a href="/Index.php/Home/info/zhuanrang/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #e64340;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe63a;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">转让生命树</p>
	</a> 



	<a href="/Index.php/Home/Info/tuiguangma/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #09B9F4;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe600;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">林场扩建
		</p>
	</a>
	<a href="/Index.php/Home/Info/myziliao/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #F63C86;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe684;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">个人资料</p>
	</a>
	<a href="/Index.php/Home/Info/mimaguanli/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #A4ABFE;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe681;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">密码管理</p>
	</a>
	<a href="/Index.php/Home/Info/lianxius/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #A4ABFE;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe687;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">联系我们</p>
	</a>
	<!-- <a href="/Index.php/Home/Index/help/" class="weui_grid js_grid" data-id="toast"> -->
			<!-- <div class="weui_grid_icon"> -->
				<!-- <i class="iconfont" style="color: #15D897;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe62e;</i> -->
			<!-- </div> -->
			<!-- <p class="weui_grid_label" style="margin-top: 12px">帮助中心</p> -->
	<!-- </a> -->
</div>
	



    	<div class="height55"></div>

<!--底部开始-->
<style>
	.footer ul li{
		width: 25%;
	}
</style>
	<div class="footer">
    <ul>
        
        <li style="width:50%"><a href="/Index.php/Shop/Index/" class="block"><i class="iconfont">&#xe604;</i>商城</a></li>
		<!-- <li><a href="/Index.php/Home/Info/mykuangche/" class="block"><i class="iconfont">&#xe601;</i>我的矿机</a></li> -->
		<!-- <li><a href="/Index.php/Home/Info/Index/" class="block"><i class="iconfont">&#xe645;</i>交易中心</a></li> -->
        <li style="width:49%" ><a href="/Index.php/Home/Index/Index/" class="block"><i class="iconfont">&#xe684;</i>钱包</a></li>
    </ul>
</div>
	<!--底部结束-->
	<script src="/Public/web/js/jquery-weui.min.js"></script>
		<p style="display:none;">
<script src="http://s95.cnzz.com/z_stat.php?id=1261438452&web_id=1261438452" language="JavaScript"></script>
</p>

</body>
</html>
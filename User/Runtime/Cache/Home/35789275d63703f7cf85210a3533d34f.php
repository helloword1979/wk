<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="/Public/web/css/lib.css?2">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
	<meta content="telephone=no" name="format-detection">
	<title>Personal Center</title>	
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
		<span class="header_c">Personal Center</span>
		<span style="position: absolute;right: 10%;top: 0px;text-align:center;width:20%;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;font-size: 12px; "><?php echo ($userData['ue_truename']); ?></span>
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
		<a href="<?php echo U('/index.php/Home/Login/logout');?>" style="position:absolute;top:45px;left:19px;width:100px;height:50px;line-height:50px;text-align:center;color:#fff;font-size:12px">Safe exit</a>
		<div style="width: 95%;float: right;text-align: center;overflow: hidden;text-align:right;"><p style="font-size:12px">Available GEC(GEC):</p><p style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;font-size:30px"><?php echo ($kymoney); ?></p></div>
		<div style="width:95%;float: right;text-align: center;overflow: hidden;text-align:right;"><p style="float:right"><span style="font-size:12px;display:inline-block;">Frozen GEC(GEC):</span><span style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;float:right;font-size:1em"><?php echo ($djmoney); ?></span></p></div>
	</div>
<div class="weui_grids" style="background-color: #f9f9f9">
	<a href="/Index.php/Home/Info/enmykuangche/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #FE9400;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe601;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">My mine</p>
	</a>
	<a href="/Index.php/Home/Info/enmyjiaoyi/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #F4403C;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe63f;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">My trade</p>
	</a>
	<a href="/Index.php/Home/Info/enkuangcheshouyi/" class="weui_grid js_grid" data-id="toast">
	<div class="weui_grid_icon">
		<i class="iconfont" style="color: #7E4BE5;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe628;</i>
	</div>
	<p class="weui_grid_label" style="margin-top: 12px">Mills machine</p>
</a>
	<a href="/Index.php/Home/Info/entgsy/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #FEB900;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe603;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">Guild earnings</p>
	</a>
	<a href="/Index.php/Home/Myuser/enindex/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color:#1C91E2;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe85d;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">Miners</p>
	</a>
	<!-- <a href="/Index.php/Home/info/enqiugoulkb/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #e64340;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe615;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">Buy GEC</p>
	</a>



	<a href="/Index.php/Home/info/enshouchu/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #e64340;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe63a;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">sale GEC</p>
	</a> -->



	<a href="/Index.php/Home/Info/entuiguangma/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #09B9F4;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe600;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">Extension code</p>
	</a>
	<a href="/Index.php/Home/Info/enmyziliao/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #F63C86;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe684;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">personal data</p>
	</a>
	<a href="/Index.php/Home/Info/enmimaguanli/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #A4ABFE;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe681;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">Password</p>
	</a>
	<a href="/Index.php/Home/Info/enlianxius/" class="weui_grid js_grid" data-id="toast">
		<div class="weui_grid_icon">
			<i class="iconfont" style="color: #A4ABFE;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe687;</i>
		</div>
		<p class="weui_grid_label" style="margin-top: 12px">Contact us</p>
	</a>
	<a href="/Index.php/Home/Index/enhelp/" class="weui_grid js_grid" data-id="toast">
			<div class="weui_grid_icon">
				<i class="iconfont" style="color: #15D897;display: block;width: 16px;margin:0 auto;font-size: 2em;margin-left: -2px;">&#xe62e;</i>
			</div>
			<p class="weui_grid_label" style="margin-top: 12px">Help center</p>
	</a>
</div>
	

	<table style="width: 90%;margin-left: 5%;color: #333333;margin-top: 20px;border-collapse:collapse;display:none;">
        <thead style="font-size: 12px; ">
		
            <tr style="height: 35px;line-height: 35px;">
                <th style="border-bottom:2px solid #ddd ;display:none;">number</th>
				<th  style="border-bottom:2px solid #ddd ">Machine name</th>
				 <th style="border-bottom:2px solid #ddd ">Model</th>
               
                <th style="border-bottom:2px solid #ddd ">Running time/(h)</th>
                <th style="border-bottom:2px solid #ddd ">income(GEC)</th>
               
            </tr>

        </thead>
        <tbody style="font-size: 10px;text-align: center">
		<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr style="line-height: 30px; height: 30px;">
                <td style="min-width: 9%;border-bottom:1px solid #ddd;display:none;"><?php echo ($aab=$v["ug_id"]); ?></td>
				<td style="min-width: 9%;border-bottom:1px solid #ddd "><?php echo ($v["kjmc"]); ?></td>
				
				<td style="min-width: 9%;border-bottom:1px solid #ddd "><?php echo ($v["kjbh"]); ?></td>
              
                <td style="border-bottom:1px solid #ddd "><?php echo (user_jj_ts($aab,$ztrs3)); ?></td>
                <td style="min-width: 20%;border-bottom:1px solid #ddd "><?php echo ($ztrs); echo (user_jj_lx($aab,$ztrs)); ?></td>
                
            </tr><?php endforeach; endif; ?>	
        </tbody>
    </table>






    	<div class="height55"></div>

<script>
	function changeMoney() {
		$.modal({
			title: "Conversion balance",
			text: "Three team sales<br/>Achieve2Million yuan，reward1000元！<br/>Achieve5Million yuan，reward3000元！<br/>Achieve8Million yuan，reward8000元！",
			buttons: [
				{ text: "1000", onClick: function(){
					ajaxChangeMoney(1);
				}
				},
				{ text: "3000", onClick: function(){
					ajaxChangeMoney(2);

				}
				},
				{ text: "8000", onClick: function(){
					ajaxChangeMoney(3);

				}
				},
				{ text: "cancel", className: "default", onClick: function(){ } },
			]
		});
	}
	
	function ajaxChangeMoney(data) {
		$.post('/index.php?s=/Home/User/changeMoney.html',{data:data},function (msg) {
			$.alert(msg,function () {
				location.reload();
			});
		});
	}
	function buy_again() {
		$.modal({
			title: "Re cast",
			text: "Please choose to shake Qian Shu",
			buttons: [
				{ text: "30", onClick: function(){
						ajaxBuyAgain(11);
					}
				},
				{ text: "300", onClick: function(){
					ajaxBuyAgain(12);

					}
				},
				{ text: "1200", onClick: function(){
					ajaxBuyAgain(13);

				}
				},
				{ text: "cancel", className: "default", onClick: function(){ } },
			]
		});
	}

	function ajaxBuyAgain(id) {
		$.ajax({
			url:'/index.php?s=/Home/User/buy_again.html',
			type:'post',
			data:{id:id},
			success:function (msg) {
				$.alert(msg,function () {
					location.reload();
				});

			}
		});
	}
    $(function(){

		//if(528 == 0){
		//	$.toptip('您还没有推荐人！',5000, 'success');
		//}
       // $.ajax({
       //     url:'/index.php?s=/Home/User/checkQueue.html',
       //     type:'post',
       //     dataType:'json',
       //     beforeSend:function(){
       //         $.showLoading("拼命更新中...");
       //     },
       //     success:function(res){
       //         if(res.code == 1){
       //             $.hideLoading();
       //         }else{
       //             location.reload();
       //         }
       //     }
       // }
       // );
    });
</script>
<!--底部开始-->
<style>
	.footer ul li{
		width: 25%;
	}
</style>
	<div class="footer">
		<ul>
            <li><a href="/Index.php/Shop/Index/enindex" class="block"><i class="iconfont">&#xe604;</i>Mills Mall</a></li>
			<li><a href="/Index.php/Home/Info/enmykuangche/" class="block"><i class="iconfont">&#xe601;</i>My mine</a></li>
            <li><a href="/Index.php/Home/Info/enIndex" class="block"><i class="iconfont">&#xe645;</i>Trading market</a></li>
            <li style="width:24%"><a href="/Index.php/Home/Index/enindex" class="block"><i class="iconfont">&#xe684;</i>Personal Center</a></li>
        </ul>
	</div>
	<!--底部结束-->
	<script src="/Public/web/js/jquery-weui.min.js"></script>
</body>
</html>
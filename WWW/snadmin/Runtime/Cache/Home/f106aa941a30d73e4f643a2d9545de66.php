<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			无标题文档
		</title>
		<link href="/sncss/css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div class="place">
			<span>
				位置：
			</span>
			<ul class="placeul">
				<li>
					<a href="#">
						首页
					</a>
				</li>
				<li>
					<a href="#">
						表单
					</a>
				</li>
			</ul>
		</div>
<!-- 		<div class="formbody">
			<div class="formtitle">
				<span>
				矿机收益
				</span>
			</div>
			<form id="form1" name="user" method="post" action="/admin.php/Home/Index/kjsy">
				<ul class="forminfo">
					<label>&nbsp;</label>
					<input type="submit" class="btn" value="立即发放" />
				</ul>
			</form>
			
			<br />
			
		</div> -->
		
			<div class="formbody">
			<div class="formtitle">
				<span>
				挂单额度设置
				</span>
			</div>
			
			<form id="form1" name="form1" method="post" action="/admin.php/Home/Index/settings">
				<input name="UE_account" type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>"
				/>
				<ul class="forminfo">
					<i>
					</i>
					</li>
<!-- added by skyrim -->
<!-- purpose: seperate masses and managers -->
<!-- version: 5.0 -->
					<li>
						<label>
						最低单价
						</label>
						<input name="min_danjia" type="text" id="min_danjia"
						class="dfinput" required="true" value="<?php echo ($min_danjia); ?>" />$
						
						<i>
						</i>
					</li>
					<li>
						<label>
						最高单价
						</label>
						<input name="max_danjia" type="text" id="max_danjia"
						class="dfinput" required="true" value="<?php echo ($max_danjia); ?>" />$
						
						<i>
						</i>
					</li>
					
					
						<label>
							&nbsp;
						</label>
						<input name="" type="submit" class="btn" value="确认保存" />
			</form>
			<br />
			<br />
			<br />
			<br />
			</ul>
		
		
		
		
		
		
		<div class="formtitle">
				<span>
					交易手续费
				</span>
			</div>
			
			<form id="form1" name="form1" method="post" action="/admin.php/Home/Index/settings">
				<input name="UE_account" type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>"
				/>
				<ul class="forminfo">
					<i>
					</i>
					</li>
<!-- added by skyrim -->
<!-- purpose: seperate masses and managers -->
<!-- version: 5.0 -->
					<li>
						<label>
							交易手续费
						</label>
						<input name="jiaoyi_shouxu" type="text" id="$jiaoyi_shouxu"
						class="dfinput" required="true" value=<?php echo $jiaoyi_shouxu*100?> />%
						
						<i>
						</i>
					</li>
						<label>
							&nbsp;
						</label>
						<input name="" type="submit" class="btn" value="确认保存" />
			</form>
			<br />
			<br />
			<br />
			<br />
			</ul>
		<div class="formbody">
		
			<div class="formtitle">
				<span>
					会员收益设置
				</span>
			</div>
			
			<form id="form1" name="form1" method="post" action="/admin.php/Home/Index/settings">
				<input name="UE_account" type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>"
				/>
				<ul class="forminfo">
					<i>
					</i>
					</li>
<!-- added by skyrim -->
<!-- purpose: seperate masses and managers -->
<!-- version: 5.0 -->
					<li>
						<label>
						正式会员
						</label>
						<span style="margin-left:48px">享受直推的<input name="ztlv" type="text" id="ztlv"
						class="dfinput" required="true" value=<?php echo $ztlv*100?> />%分红</span>
						
						<i>
						</i>
					</li>
					<br />
					<br />
					<li>
						<label>
						公会会长
						</label>
						直推<input name="ztrs" type="text" id="ztrs"
						class="dfinput" required="true" value="<?php echo ($ztrs); ?>" />人
						<br />
						<span  style="margin-left:73px">公会达<input name="ghrs" type="text" id="ghrs"
						class="dfinput" required="true" value="<?php echo ($ghrs); ?>" />人</span>
						<br />
						<span style="margin-left:38px">公会矿机算力<input name="ghkj" type="text" id="ghkj"
						class="dfinput" required="true" value="<?php echo ($ghkj); ?>" />成为会长</span>
						<br />
						<span style="margin-left:38px">享受交易佣金<input name="hzlv" type="text" id="hzlv"
						class="dfinput" required="true" value=<?php echo $hzlv*100?> />%的全球分红</span>
						
						<i>
						</i>
					</li>
					<br />
					<br />
					<li>
						<label>
						创业大使
						</label>
						<input name="cyhz" type="text" id="cyhz"
						class="dfinput" required="true" value="<?php echo ($cyhz); ?>" />个公会会长
						
						<br />
						<span style="margin-left:14px">公会矿机算力<input name="cykj" type="text" id="cykj"
						class="dfinput" required="true" value="<?php echo ($cykj); ?>" />成为创业大使</span>
						<br />
						<span style="margin-left:14px">享受交易佣金<input name="cylv" type="text" id="cylv"
						class="dfinput" required="true" value=<?php echo $cylv*100?> />%的全球分红</span>
						
						<i>
						</i>
					</li>
					<br />
					<br />
					<li>
						<label>
						环保大使
						</label>
						<input name="hbhz" type="text" id="hbhz"
						class="dfinput" required="true" value="<?php echo ($hbhz); ?>" />个创业大使
						
						<br />
						<span style="margin-left:14px">公会矿机算力<input name="hbkj" type="text" id="hbkj"
						class="dfinput" required="true" value="<?php echo ($hbkj); ?>" />成为环保大使</span>
						<br />
						<span style="margin-left:14px">享受交易佣金<input name="hblv" type="text" id="hblv"
						class="dfinput" required="true" value=<?php echo $hblv*100?> />%的全球分红</span>
						
						<i>
						</i>
					</li>
					<br />
					<br />
					<li>
						<label>
						国际大使
						</label>
						<input name="gjhz" type="text" id="gjhz"
						class="dfinput" required="true" value="<?php echo ($gjhz); ?>" />个环保大使
						
						<br />
						<span style="margin-left:14px">公会矿机算力<input name="gjkj" type="text" id="gjkj"
						class="dfinput" required="true" value="<?php echo ($gjkj); ?>" />成为国际大使</span>
						<br />
						<span style="margin-left:14px">享受交易佣金<input name="gjlv" type="text" id="gjlv"
						class="dfinput" required="true" value=<?php echo $gjlv*100?> />%的全球分红</span>
						
						<i>
						</i>
					</li>
					
					
						<label>
							&nbsp;
						</label>
						<input name="" type="submit" class="btn" value="确认保存" />
			</form>
			<br />
			<br />
			<br />
			<br />
			</ul>
			
		
		
			<div class="formtitle">
				<span>
					汇率转换设置
				</span>
			</div>
			
			<form id="form1" name="form1" method="post" action="/admin.php/Home/Index/settings">
				<input name="UE_account" type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>"
				/>
				<ul class="forminfo">
					<i>
					</i>
					</li>
<!-- added by skyrim -->
<!-- purpose: seperate masses and managers -->
<!-- version: 5.0 -->
					<li>
						<label>
						一美元
						</label>
						<input name="rmb_hl" type="text" id="min_tixian_money"
						class="dfinput" required="true" value="<?php echo ($rmb_hl); ?>" />人民币
						
						<i>
						</i>
					</li>
					<li>
						<label>
						一美元
						</label>
						<input name="btc_hl" type="text" id="min_tixian_money"
						class="dfinput" required="true" value="<?php echo ($btc_hl); ?>" />比特币
						
						<i>
						</i>
					</li>
					
					
						<label>
							&nbsp;
						</label>
						<input name="" type="submit" class="btn" value="确认保存" />
			</form>
			<br />
			<br />
			<br />
			<br />
			</ul>
		
		
		
		
		
		
			<div class="formtitle">
				<span>
					体现设置
				</span>
			</div>
			
			<form id="form1" name="form1" method="post" action="/admin.php/Home/Index/settings">
				<input name="UE_account" type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>"
				/>
				<ul class="forminfo">
					<i>
					</i>
					</li>
<!-- added by skyrim -->
<!-- purpose: seperate masses and managers -->
<!-- version: 5.0 -->
					<li>
						<label>
							最低体现额度
						</label>
						<input name="min_tixian_money" type="text" id="min_tixian_money"
						class="dfinput" required="true" value="<?php echo ($min_tixian_money); ?>" />
						
						<i>
						</i>
					</li>
						<label>
							&nbsp;
						</label>
						<input name="" type="submit" class="btn" value="确认保存" />
			</form>
			<br />
			<br />
			<br />
			<br />
			</ul>
			<div class="formtitle">
				<span>
					团队奖分成设置
				</span>
			</div>
			<form id="form1" name="form1" method="post" action="/admin.php/Home/Index/settings">
				<input name="UE_account" type="hidden" class="dfinput" value="<?php echo ($userdata['ue_account']); ?>"
				/>
				<ul class="forminfo">
					<i>
					</i>
					</li>
<!-- added by skyrim -->
<!-- purpose: seperate masses and managers -->
<!-- version: 5.0 -->
					<li>
						<label>
							会员提成
						</label>
						<input name="max_user_level" type="text" id="max_user_level"
						class="dfinput" required="true" value="<?php echo ($max_user_level); ?>" />
						代
						<i>
						</i>
					</li>
					<li>
						<label>
							最多可直推
						</label>
						<input name="max_user_zhitui" type="text" id="max_user_zhitui"
						class="dfinput" required="true" value="<?php echo ($max_user_zhitui); ?>" />
						个下线
						<i>
						</i>
					</li>
<!-- version: 5.0 -->
					<?php for( $i=1; $i<$settings['max_user_level']+1; $i++ ) { ?>
					<li>
						<label>
							会员<?php echo $i; ?>代
						</label>
						<input type="text" value="<?php echo $masses_share[$i]; ?>" id="masses_share[<?php echo $i; ?>]" class="dfinput"
						name="masses_share[<?php echo $i; ?>]" required="">
						%
					</li>
					<?php } ?>
					
					<?php for( $i=1; $i<$settings['max_jl_level']+1; $i++ ) { ?>
					<li>
						<label>
							经理<?php echo $i; ?>级
						</label>
						<input type="text" value="<?php echo $jl_share[$i]; ?>" id="jl_share[<?php echo $i; ?>]" class="dfinput"
						name="jl_share[<?php echo $i; ?>]" required="">
						%
					</li>
					<?php } ?>
					

				
						<label>
							&nbsp;
						</label>
						<input name="" type="submit" class="btn" value="确认保存" />
					</li>
				</ul>
			</form>
			<style>
				.pages a,.pages span { display:inline-block; padding:2px 5px; margin:0
				1px; border:1px solid #f0f0f0; -webkit-border-radius:3px; -moz-border-radius:3px;
				border-radius:3px; } .pages a,.pages li { display:inline-block; list-style:
				none; text-decoration:none; color:#58A0D3; } .pages a.first,.pages a.prev,.pages
				a.next,.pages a.end{ margin:0; } .pages a:hover{ border-color:#50A8E6;
				} .pages span.current{ background:#50A8E6; color:#FFF; font-weight:700;
				border-color:#50A8E6; }
			</style>
			<div class="pages">
				<br />
				<div align="right">
					<?php echo ($page); ?>
				</div>
			</div>
		</div>
	</body>

</html>
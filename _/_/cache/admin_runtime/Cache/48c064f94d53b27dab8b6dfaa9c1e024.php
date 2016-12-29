<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
			<?php if($withdrawal_count > 0): ?><script type="text/javascript">
					$(function(){
						$('#nav_4 > dd > #leftmenu_Order_withdraw', parent.document).html('提现记录 <label style="color:red">(' + <?php echo ($withdrawal_count); ?> + ')</label>')
					})
				</script><?php endif; ?>
			<?php if($unprocessed > 0): ?><script type="text/javascript">
					$(function(){
						if ($('#leftmenu_Credit_returnRecord', parent.document).length > 0) {
							var menu_html = $('#leftmenu_Credit_returnRecord', parent.document).html();
							menu_html = menu_html.split('(')[0];
							menu_html += ' <label style="color:red">(<?php echo ($unprocessed); ?>)</label>';
							$('#leftmenu_Credit_returnRecord', parent.document).html(menu_html);
						}
					})
				</script><?php endif; ?>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 
<script src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>

<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="<?php echo U('Admin/bonus_config',array('gid'=>2));?>" <?php if($gid == 2): ?>class="on"<?php endif; ?>>区域管理员</a>|
			<a href="<?php echo U('Admin/bonus_config',array('gid'=>3));?>" <?php if($gid == 3): ?>class="on"<?php endif; ?>>客户经理(代理商)</a>
		</ul>
	</div>
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<tbody>
				<tr>
					<td width="90">开启推广奖励：</td>
					<td width="90"><span class="cb-enable"><label class="cb-enable <?php if($info['open_promotion_reward'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="open_promotion_reward"><span>是</span><input type="radio" name="open_promotion_reward" value="1" <?php if($info['open_promotion_reward'] == 1): ?>checked="true"<?php endif; ?>"></label></span><span class="cb-disable"><label class="cb-disable <?php if($info['open_promotion_reward'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="open_promotion_reward"><span>否</span><input type="radio" name="open_promotion_reward" <?php if($info['open_promotion_reward'] == 0): ?>checked="true"<?php endif; ?> value="0"></label></span></td>
					<td width="200">默认奖励：<input type="text" class="input-text" style="width: 70px;" id="promotion_reward_rate" name="promotion_reward_rate" value="<?php echo $info['promotion_reward_rate']; ?>" /> <a id="chg_promotion_reward_rate" data-id="<?php echo $info['id']; ?>" style="color: red;cursor: pointer;">点击修改</a></td>
					<?php if (empty($info['platform_credit_open'])) { ?>
					<td width="150">平台服务费：<span style="color: red;font-weight: bold;"><?php echo $service_fee; ?>%</span></td>
					<?php } ?>
					<td>注意：这里用来分配的金额为平台收益 (服务费 — 提现备付金)，如果省、市、区级不设置则推广奖励为默认奖励<?php if (empty($info['platform_credit_open'])) { ?>，<span style="color: red;">为保证平台利益，推广奖励比率不要超出平台服务费比率</span><?php } ?>。</td>
				</tr>
			</tbody>
		</table>
	</div>
	<form id="myform" datas="my_<?php echo ($gid); ?>" method="post" action="<?php echo U('Admin/bonus_config');?>" refresh="true">

		<?php if($gid == 3): ?><input type="hidden" name="type" value="<?php echo ($gid); ?>" />
			<table cellpadding="0" cellspacing="0" class="table_form" width="100%" style="display:none;" id="tab_agent">
				<tbody>
					<tr>
						<th width="110" rowspan="2">自营店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="self_online" value="<?php echo ($config['agent']['self_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="self_offline" value="<?php echo ($config['agent']['self_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">平台店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="platform_online" value="<?php echo ($config['agent']['platform_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="platform_offline" value="<?php echo ($config['agent']['platform_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">海外店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="foreign_online" value="<?php echo ($config['agent']['foreign_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="foreign_offline" value="<?php echo ($config['agent']['foreign_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
				</tbody>
			</table><?php endif; ?>

		<?php if($gid == 2): ?><ul class="tab_ul">
				<li class="active"><a data-toggle="tab" href="#tab_province">省级</a></li>
				<li class=""><a data-toggle="tab" href="#tab_city">市级</a></li>
				<li class=""><a data-toggle="tab" href="#tab_county">区县级</a></li>
			</ul>
			<input type="hidden" name="type" value="<?php echo ($gid); ?>" />
			<input type="hidden" name="area_level" value="1" />
			<table cellpadding="0" cellspacing="0" class="table_form" width="100%" style="display:none;" id="tab_province">
				<tbody>
					<tr>
						<th width="110" rowspan="2">自营店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="self_online" value="<?php echo ($config['area']['province']['self_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="self_offline" value="<?php echo ($config['area']['province']['self_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">平台店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="platform_online" value="<?php echo ($config['area']['province']['platform_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="platform_offline" value="<?php echo ($config['area']['province']['platform_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">海外店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="foreign_online" value="<?php echo ($config['area']['province']['foreign_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="foreign_offline" value="<?php echo ($config['area']['province']['foreign_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
				</tbody>
			</table>

			<table cellpadding="0" cellspacing="0" class="table_form" width="100%" style="display:none;" id="tab_city">
				<tbody>
					<tr>
						<th width="110" rowspan="2">自营店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="self_online" value="<?php echo ($config['area']['city']['self_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="self_offline" value="<?php echo ($config['area']['city']['self_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">平台店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="platform_online" value="<?php echo ($config['area']['city']['platform_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="platform_offline" value="<?php echo ($config['area']['city']['platform_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">海外店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="foreign_online" value="<?php echo ($config['area']['city']['foreign_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="foreign_offline" value="<?php echo ($config['area']['city']['foreign_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
				</tbody>
			</table>

			<table cellpadding="0" cellspacing="0" class="table_form" width="100%" style="display:none;" id="tab_county">
				<tbody>
					<tr>
						<th width="110" rowspan="2">自营店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="self_online" value="<?php echo ($config['area']['county']['self_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="self_offline" value="<?php echo ($config['area']['county']['self_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">平台店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="platform_online" value="<?php echo ($config['area']['county']['platform_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="platform_offline" value="<?php echo ($config['area']['county']['platform_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">海外店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="foreign_online" value="<?php echo ($config['area']['county']['foreign_online']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="foreign_offline" value="<?php echo ($config['area']['county']['foreign_offline']); ?>" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
				</tbody>
			</table><?php endif; ?>

		<div class="btn" style="margin-top:20px;">
			<input type="button"  name="dosubmit" value="提交" class="button" />
			<input type="reset"  value="取消" class="button" />
		</div>
	</form>
</div>
<style type="text/css">
	.table-list {margin-bottom:10px;}
	.table_form{border:1px solid #ddd;}
	.table_form td a{color:#ff0000;margin:auto 4px;}
	.table_form th {padding-right:10px;}
	.tab_ul{border-color:#C5D0DC;margin-bottom:0!important;margin-left:0;position:relative;top:1px;border-bottom:1px solid #ddd;padding-left:0;list-style:none;}
	.tab_ul>li{position:relative;display:block;float:left;margin-bottom:-1px;}
	.tab_ul>li>a {position: relative; display: block; padding: 10px 15px; margin-right: 2px; line-height: 1.42857143; border: 1px solid transparent; border-radius: 4px 4px 0 0; padding: 7px 12px 8px; min-width: 100px; text-align: center; }
	.tab_ul>li>a, .tab_ul>li>a:focus {border-radius: 0!important; border-color: #c5d0dc; background-color: #F9F9F9; color: #999; margin-right: -1px; line-height: 18px; position: relative; }
	.tab_ul>li>a:focus, .tab_ul>li>a:hover {text-decoration: none; background-color: #eee; }
	.tab_ul>li>a:hover {border-color: #eee #eee #ddd; }
	.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {color: #555; background-color: #fff; border: 1px solid #ddd; border-bottom-color: transparent; cursor: default; }
	.tab_ul>li>a:hover {background-color: #FFF; color: #4c8fbd; border-color: #c5d0dc; }
	.tab_ul>li:first-child>a {margin-left: 0; }
	.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {color: #576373; border-color: #c5d0dc #c5d0dc transparent; border-top: 2px solid #4c8fbd; background-color: #FFF; z-index: 1; line-height: 18px; margin-top: -1px; box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15); }
	.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {color: #555; background-color: #fff; border: 1px solid #ddd; border-bottom-color: transparent; cursor: default; }
	.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {color: #576373; border-color: #c5d0dc #c5d0dc transparent; border-top: 2px solid #4c8fbd; background-color: #FFF; z-index: 1; line-height: 18px; margin-top: -1px; box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15); }
	.tab_ul:before,.tab_ul:after{content: " "; display: table; }
	.tab_ul:after{clear: both; }

	.tc {text-align:center;}
</style>
<script type="text/javascript">
$(function(){

	$('.table_form:eq(0)').show();
	$(".table_form:eq(1),.table_form:eq(2)").find("input").attr("disabled", "disabled");

	$('.tab_ul li a').click(function(){

		var self = $(this);
		self.closest('li').addClass('active').siblings('li').removeClass('active');

		if (self.attr('href') == '#tab_province') {
			$("input[name=area_level]").val(1);
		} else if (self.attr('href') == '#tab_city') {
			$("input[name=area_level]").val(2);
		} else if (self.attr('href') == '#tab_county') {
			$("input[name=area_level]").val(3);
		}

		$(".table_form").find("input").attr("disabled", "disabled");
		$(self.attr('href')).find("input").removeAttr("disabled");

		$(self.attr('href')).show().siblings('.table_form').hide();

	});

	$("input[name='dosubmit']").click(function(){
		var iptObj = $("#myform").find("input[type=text][disabled!=disabled]");
		$("#myform").submit();
	});

	$('.cb-enable').click(function(){
		if (!$(this).hasClass('selected')) {
			var id = $(this).data('id');
			var name = $(this).data('name');
			$.post("<?php echo U('Admin/chgBonusStatus'); ?>",{'status': 1, 'id': id,'name':name}, function(data){});
		}
	})


	$('.cb-disable').click(function(){
		if (!$(this).hasClass('selected')) {
			var id = $(this).data('id');
			var name = $(this).data('name');
			$.post("<?php echo U('Admin/chgBonusStatus'); ?>", {'status': 0, 'id': id,'name':name}, function (data) {});
		}
	})

	$('#chg_promotion_reward_rate').click(function(){
		var id = $(this).data('id');
		var promotion_reward_rate = $('#promotion_reward_rate').val();
		if (isNaN(promotion_reward_rate) || promotion_reward_rate == '') {
			window.top.msg(0,"默认推广奖励输入有误",true,'3');
			$('#promotion_reward_rate').val('');
			$('#promotion_reward_rate').focus();
			return false;
		}
		$.post("<?php echo U('Admin/chgPromotionRewardRate'); ?>", {'promotion_reward_rate': promotion_reward_rate, 'id': id}, function (data) {
				window.top.msg(1,"修改成功",true,'3');
				window.top.main_refresh();
				window.top.closeiframe();
			}
		);
	})
})
</script>
	</body>
</html>
<include file="Public:header"/>
<script src="{pigcms{$static_public}js/layer/layer.min.js"></script>

<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="{pigcms{:U('Admin/bonus_config',array('gid'=>2))}" <if condition="$gid eq 2">class="on"</if>>区域管理员</a>|
			<a href="{pigcms{:U('Admin/bonus_config',array('gid'=>3))}" <if condition="$gid eq 3">class="on"</if>>客户经理(代理商)</a>
		</ul>
	</div>
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<tbody>
				<tr>
					<td width="90">开启推广奖励：</td>
					<td width="90"><span class="cb-enable"><label class="cb-enable <if condition="$info['open_promotion_reward'] eq 1">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="open_promotion_reward"><span>是</span><input type="radio" name="open_promotion_reward" value="1" <if condition="$info['open_promotion_reward'] eq 1">checked="true"</if>"></label></span><span class="cb-disable"><label class="cb-disable <if condition="$info['open_promotion_reward'] eq 0">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="open_promotion_reward"><span>否</span><input type="radio" name="open_promotion_reward" <if condition="$info['open_promotion_reward'] eq 0">checked="true"</if> value="0"></label></span></td>
					<td width="200">默认奖励：<input type="text" class="input-text" style="width: 70px;" id="promotion_reward_rate" name="promotion_reward_rate" value="<?php echo $info['promotion_reward_rate']; ?>" /> <a id="chg_promotion_reward_rate" data-id="<?php echo $info['id']; ?>" style="color: red;cursor: pointer;">点击修改</a></td>
					<?php if (empty($info['platform_credit_open'])) { ?>
					<td width="150">平台服务费：<span style="color: red;font-weight: bold;"><?php echo $service_fee; ?>%</span></td>
					<?php } ?>
					<td>注意：这里用来分配的金额为平台收益 (服务费 — 提现备付金)，如果省、市、区级不设置则推广奖励为默认奖励<?php if (empty($info['platform_credit_open'])) { ?>，<span style="color: red;">为保证平台利益，推广奖励比率不要超出平台服务费比率</span><?php } ?>。</td>
				</tr>
			</tbody>
		</table>
	</div>
	<form id="myform" datas="my_{pigcms{$gid}" method="post" action="{pigcms{:U('Admin/bonus_config')}" refresh="true">

		<if condition="$gid eq 3">
			<input type="hidden" name="type" value="{pigcms{$gid}" />
			<table cellpadding="0" cellspacing="0" class="table_form" width="100%" style="display:none;" id="tab_agent">
				<tbody>
					<tr>
						<th width="110" rowspan="2">自营店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="self_online" value="{pigcms{$config['agent']['self_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="self_offline" value="{pigcms{$config['agent']['self_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">平台店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="platform_online" value="{pigcms{$config['agent']['platform_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="platform_offline" value="{pigcms{$config['agent']['platform_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">海外店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="foreign_online" value="{pigcms{$config['agent']['foreign_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="foreign_offline" value="{pigcms{$config['agent']['foreign_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
				</tbody>
			</table>
		</if>

		<if condition="$gid eq 2">
			<ul class="tab_ul">
				<li class="active"><a data-toggle="tab" href="#tab_province">省级</a></li>
				<li class=""><a data-toggle="tab" href="#tab_city">市级</a></li>
				<li class=""><a data-toggle="tab" href="#tab_county">区县级</a></li>
			</ul>
			<input type="hidden" name="type" value="{pigcms{$gid}" />
			<input type="hidden" name="area_level" value="1" />
			<table cellpadding="0" cellspacing="0" class="table_form" width="100%" style="display:none;" id="tab_province">
				<tbody>
					<tr>
						<th width="110" rowspan="2">自营店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="self_online" value="{pigcms{$config['area']['province']['self_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="self_offline" value="{pigcms{$config['area']['province']['self_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">平台店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="platform_online" value="{pigcms{$config['area']['province']['platform_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="platform_offline" value="{pigcms{$config['area']['province']['platform_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">海外店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="foreign_online" value="{pigcms{$config['area']['province']['foreign_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="foreign_offline" value="{pigcms{$config['area']['province']['foreign_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
				</tbody>
			</table>

			<table cellpadding="0" cellspacing="0" class="table_form" width="100%" style="display:none;" id="tab_city">
				<tbody>
					<tr>
						<th width="110" rowspan="2">自营店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="self_online" value="{pigcms{$config['area']['city']['self_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="self_offline" value="{pigcms{$config['area']['city']['self_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">平台店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="platform_online" value="{pigcms{$config['area']['city']['platform_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="platform_offline" value="{pigcms{$config['area']['city']['platform_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">海外店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="foreign_online" value="{pigcms{$config['area']['city']['foreign_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="foreign_offline" value="{pigcms{$config['area']['city']['foreign_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
				</tbody>
			</table>

			<table cellpadding="0" cellspacing="0" class="table_form" width="100%" style="display:none;" id="tab_county">
				<tbody>
					<tr>
						<th width="110" rowspan="2">自营店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="self_online" value="{pigcms{$config['area']['county']['self_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="self_offline" value="{pigcms{$config['area']['county']['self_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">平台店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="platform_online" value="{pigcms{$config['area']['county']['platform_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="platform_offline" value="{pigcms{$config['area']['county']['platform_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<th width="110" rowspan="2">海外店铺</th>
						<td width="120" class="tc">线上(%)</td>
						<td><input type="text" class="input-text" name="foreign_online" value="{pigcms{$config['area']['county']['foreign_online']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
					<tr>
						<td width="120" class="tc">线下(%)</td>
						<td><input type="text" class="input-text" name="foreign_offline" value="{pigcms{$config['area']['county']['foreign_offline']}" size="40" validate="number:true,range:[0,100]" tips="" /></td>
					</tr>
				</tbody>
			</table>
		</if>

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
<include file="Public:footer"/>
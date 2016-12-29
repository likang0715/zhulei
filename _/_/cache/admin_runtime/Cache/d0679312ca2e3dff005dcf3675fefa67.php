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

    <div id="nav" class="mainnav_title">
        <ul>
            <a href="<?php echo U('Credit/index');?>" class="on">积分概述</a>
            |
            <a href="<?php echo U('Credit/sendLog');?>" >积分发放流水</a>
            |
            <a href="<?php echo U('Credit/statistics');?>" >积分统计数据汇总</a>
        </ul>
    </div>

	<table cellpadding="0" cellspacing="0"  width="100%" class="frame_form" >

        <tr>
        <th width="150">开启平台积分：</th>
        <td class="radio_box">
			<span class="cb-enable status-enable"><label class="cb-enable <?php if($info['platform_credit_open'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="platform_credit_open"><span>启用</span><input type="radio" name="platform_credit_open" value="1" <?php if($info['platform_credit_open'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
			<span class="cb-disable status-disable"><label class="cb-disable <?php if($info['platform_credit_open'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="platform_credit_open" ><span>禁用</span><input type="radio" name="platform_credit_open" value="0" <?php if($info['platform_credit_open'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
		</td>
        </tr>
        <tr>
        <th width="160">强制平台店铺使用平台积分：</th>
      	<td class="radio_box">
			<span class="cb-enable status-enable"><label class="cb-enable <?php if($info['force_use_platform_credit'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="force_use_platform_credit"><span>启用</span><input type="radio" name="force_use_platform_credit" value="1" <?php if($info['force_use_platform_credit'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
			<span class="cb-disable status-disable"><label class="cb-disable <?php if($info['force_use_platform_credit'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="force_use_platform_credit"><span>禁用</span><input type="radio" name="force_use_platform_credit" value="0" <?php if($info['force_use_platform_credit'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
			<span>&nbsp;&nbsp; * 强制开启平台积分，会造成店铺不接受平台积分就无法正常交易</span>
		</td>
        </tr>
		<tr>
			<th width="150">充值现金余额最低限额：<br/><span style="color: grey;">(单位：元)</span></th>
			<td>
				<input type="text" class="input fl" name="min_margin_balance" id="min_margin_balance" placeholder="" style="width: 80px" validate="maxlength:20,required:true,number:true" tips="" value="<?php echo ($info["min_margin_balance"]); ?>" />
				&nbsp;
				<a id="chg_min_margin_balance" data-id="<?php echo $info['id']; ?>">点击修改</a>
				* 若商家平台充值现金余额低于该金额，平台将禁止店铺继续产生交易，若不设置将以交易时扣除的服务费为准。
			</td>
		</tr>
        <tr>
            <th width="150">平台充值现金余额不足通知：<br/><span style="color: grey;">(模板消息 + 短信 通知)</span></th>
            <td class="radio_box">
                <span class="cb-enable status-enable"><label class="cb-enable <?php if($info['recharge_notice_open'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="recharge_notice_open"><span>启用</span><input type="radio" name="recharge_notice_open" value="1" <?php if($info['recharge_notice_open'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
                <span class="cb-disable status-disable"><label class="cb-disable <?php if($info['recharge_notice_open'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="recharge_notice_open" ><span>禁用</span><input type="radio" name="recharge_notice_open" value="0" <?php if($info['recharge_notice_open'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
            </td>
        </tr>
        <tr>
            <th width="150">单日最大通知次数：<br/><span style="color: grey;">(单位：次数)</span></th>
            <td>
                <input type="text" class="input fl" name="recharge_notice_maxcount" id="recharge_notice_maxcount" size="3" placeholder="" validate="maxlength:20,required:true,number:true" tips="" value="<?php echo ($info["recharge_notice_maxcount"]); ?>" />
                &nbsp;
                <a id="chg_recharge_notice_maxcount" data-id="<?php echo $info['id']; ?>">点击修改</a>
                * 若商家平台充值现金余额不足，平台单日最大通知次数，若通知次数达到该值则不再提醒。
            </td>
        </tr>
		<tr>
			<th width="150">充值现金余额提现：</th>
			<td class="radio_box">
				<span class="cb-enable status-enable"><label class="cb-enable <?php if($info['open_margin_withdrawal'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="open_margin_withdrawal"><span>启用</span><input type="radio" name="open_margin_withdrawal" value="1" <?php if($info['open_margin_withdrawal'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
				<span class="cb-disable status-disable"><label class="cb-disable <?php if($info['open_margin_withdrawal'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="open_margin_withdrawal" ><span>禁用</span><input type="radio" name="open_margin_withdrawal" value="0" <?php if($info['open_margin_withdrawal'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
				<span>&nbsp;&nbsp; * 是否开启商家充值现金余额提现，如果开启商家可以把在平台充值的现金余额提现。</span>
			</td>
		</tr>
		<tr>
			<th width="150">充值现金余额最低提现额度：<br/><span style="color: grey;">(单位：元)</span></th>
			<td>
				<input type="text" class="input fl" name="margin_withdrawal_amount_min" id="margin_withdrawal_amount_min" size="3" placeholder="" validate="maxlength:20,required:true,number:true" tips="" value="<?php echo ($info["margin_withdrawal_amount_min"]); ?>" />
				&nbsp;
				<a id="chg_margin_withdrawal_amount_min" data-id="<?php echo $info['id']; ?>">点击修改</a>
				* 若 “充值现金余额提现” 配置项开启，商家单次最低提现额度限制，0为不限制。
			</td>
		</tr>
		<tr>
			<th width="150">用户互赠积分：<br/><span style="color: grey;">(用户积分池里的积分)</span></th>
			<td class="radio_box">
				<span class="cb-enable status-enable"><label class="cb-enable <?php if($info['open_user_give_point'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="open_user_give_point"><span>启用</span><input type="radio" name="open_user_give_point" value="1" <?php if($info['open_user_give_point'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
				<span class="cb-disable status-disable"><label class="cb-disable <?php if($info['open_user_give_point'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="open_user_give_point" ><span>禁用</span><input type="radio" name="open_user_give_point" value="0" <?php if($info['open_user_give_point'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
				<span>&nbsp;&nbsp; * 用户之间可以相互赠送自己积分池里未发放的积分，</span>
			</td>
		</tr>
		<tr>
			<th>用户互赠积分服务费(%)：<br/><span style="color: grey;">(单位：积分)</span></th>
			<td>
				<input type="text" class="input fl" name="give_point_service_fee" id="give_point_service_fee" size="3" placeholder="" validate="maxlength:20,required:true,number:true" tips="" value="<?php echo ($info["give_point_service_fee"]); ?>" />
				&nbsp;
				<a id="chg_give_point_service_fee" data-id="<?php echo $info['id']; ?>">点击修改</a>
				* 用户之间相互赠送积分时平台扣除的服务费。
			</td>
		</tr>
        <!-- <tr>
        <th width="150">开启店铺积分：</th>
      	<td class="radio_box">
			<span class="cb-enable status-enable"><label class="cb-enable <?php if($info['store_credit_open'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="store_credit_open"><span>启用</span><input type="radio" name="store_credit_open" value="1" <?php if($info['store_credit_open'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
			<span class="cb-disable status-disable"><label class="cb-disable <?php if($info['store_credit_open'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $info['id']; ?>" data-name="store_credit_open"><span>禁用</span><input type="radio" name="store_credit_open" value="0" <?php if($info['store_credit_open'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
		</td>
        </tr> -->
        <tr><th width="150">平台充值现金总额：</th><td><?php echo (($common_data[1]['value'])?($common_data[1]['value']):"0"); ?></td></tr>
        <tr><th width="150">用户分享积分总额：</th><td><?php echo (($user_share_point_max)?($user_share_point_max):"0"); ?></td></tr>
        <tr><th width="150">当前用户有效积分值：</th><td><?php echo (($user_point_balance)?($user_point_balance):"0"); ?></td></tr>
        <tr><th width="150">当前店铺有效积分值:</th><td><?php echo (($store_point_balance)?($store_point_balance):"0"); ?></td></tr>
        <tr><th width="150">店铺已变现积分:</th><td><?php echo (($store_point2money)?($store_point2money):"0"); ?></td></tr>
        <tr><th width="150">用户积分池总数:</th><td><?php echo (($user_point_pool)?($user_point_pool):"0"); ?></td></tr>
        <tr><th width="150">积分权数值：</th><td><?php echo ($info["credit_weight"]); ?></td></tr>
        <tr><th width="150">积分价值：</th><td>1 元 人民币 == <?php echo ($info["platform_credit_use_value"]); ?> 积分</td></tr>
        <tr><th width="150">积分生成比：</th><td>1 元 消费额 == <?php echo ($info["platform_credit_rule"]); ?> 积分</td></tr>
        <tr>
	        <th width="150">今日积分权数：</th>
			<td>
		        <input type="text" class="input fl" name="today_credit_weight" id="today_credit_weight" size="3" placeholder="" validate="maxlength:20,required:true,number:true" tips="" value="<?php echo ($info["today_credit_weight"]); ?>" />
		        &nbsp;
		        <a id="chg_today_credit_weight" data-id="<?php echo $info['id']; ?>">点击修改</a>
		        *  真实积分权数：<?php echo ($real_point_weight); ?>  (在计算发放积分时,如果权数值大于1,则取1)
	        </td>
        </tr>
        <tr><th width="150">昨日平台服务费：</th><td>￥ <?php echo (($day_platform_service_fee)?($day_platform_service_fee):"0"); ?></td></tr>
        <tr><th width="150">昨日备付金总额(单日)：</th><td>￥<?php echo (($cash_provision_balance_yestoday)?($cash_provision_balance_yestoday):"0"); ?> </td></tr>
        <tr><th width="150">当前剩余备付金：</th><td>￥<?php echo (($cash_provision_balance_now)?($cash_provision_balance_now):"0"); ?> (截止昨日备付金剩余 ￥<?php echo (($cash_provision_balance_until_yestoday)?($cash_provision_balance_until_yestoday):"0"); ?>,今日新增 ￥<?php echo (($cash_provision_balance_today)?($cash_provision_balance_today):"0"); ?>  ) <a href="<?php echo U('Credit/cashProvisionLog');?>" >点击查看流水</a></td></tr>


        <tr><th width="150">今日需发放积分点数最大值：</th><td><?php echo (($today_send_point_max)?($today_send_point_max):"0"); ?></td></tr>
       
      <?php if($info['auto_send'] == 0): ?><tr><th width="150">发送积分</th><td><input type="button" <?php if($release_count == 1): ?>value="今日已发送" disabled<?php else: ?>value="点击发送" style="cursor: pointer;"<?php endif; ?> >  *  默认9点发送积分值，请在9点之前修改 今日积分权数 <a href="<?php echo U('Credit/sendLog');?>" >点击查看发放流水</a></td></tr><?php endif; ?>	
	</table>

	</body>
</html>

<style>
.frame_form td{

	font-weight: 100;
	line-height: 24px;

}
.frame_form td a{

	color: #ff0000;
	margin: auto 4px;
	cursor: pointer;

}
</style>

<script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>


<script type="text/javascript">
	$(function() {

		$('.status-enable > .cb-enable').click(function(){
			if (!$(this).hasClass('selected')) {
				var id = $(this).data('id');
				var name = $(this).data('name');
				$.post("<?php echo U('Credit/chgStatus'); ?>",{'status': 1, 'id': id,'name':name}, function(data){});
			}
		})


		$('.status-disable > .cb-disable').click(function(){
			if (!$(this).hasClass('selected')) {
				var id = $(this).data('id');
				var name = $(this).data('name');
				$.post("<?php echo U('Credit/chgStatus'); ?>", {'status': 0, 'id': id,'name':name}, function (data) {});
			}
		})


		$('#chg_today_credit_weight').click(function(){
			  var id = $(this).data('id');
			  var today_credit_weight = $('#today_credit_weight').val();
			  $.post(
			  		"<?php echo U('Credit/chgTodayCreditWeight'); ?>",
			  		{'today_credit_weight': today_credit_weight, 'id': id},
			  		function (data) {
			  			window.top.msg(1,"修改成功",true,'3');window.top.main_refresh();window.top.closeiframe();
			  		}
			  	);
		})

		$('#chg_min_margin_balance').click(function(){
			var id = $(this).data('id');
			var min_margin_balance = $('#min_margin_balance').val();
			$.post(
				"<?php echo U('Credit/chgMinMarginBalance'); ?>",
				{'min_margin_balance': min_margin_balance, 'id': id},
				function (data) {
					window.top.msg(1,"修改成功",true,'3');window.top.main_refresh();window.top.closeiframe();
				}
			);
		});

        $('#chg_recharge_notice_maxcount').click(function(){
            var id = $(this).data('id');
            var recharge_notice_maxcount = $('#recharge_notice_maxcount').val();
            $.post(
                "<?php echo U('Credit/chgDayNoticeMaxcount'); ?>",
                {'recharge_notice_maxcount': recharge_notice_maxcount, 'id': id},
                function (data) {
                    window.top.msg(1,"修改成功",true,'3');window.top.main_refresh();window.top.closeiframe();
                }
            );
        });

		$('#chg_margin_withdrawal_amount_min').click(function() {
			var id = $(this).data('id');
			var margin_withdrawal_amount_min = $('#margin_withdrawal_amount_min').val();
			$.post(
				"<?php echo U('Credit/chgMarginWithdrawalAmountMin'); ?>",
				{'margin_withdrawal_amount_min': margin_withdrawal_amount_min, 'id': id},
				function (data) {
					window.top.msg(1,"修改成功",true,'3');window.top.main_refresh();window.top.closeiframe();
				}
			);
		});

		$('#chg_give_point_service_fee').click(function(){
			var id = $(this).data('id');
			var give_point_service_fee = $('#give_point_service_fee').val();
			$.post(
				"<?php echo U('Credit/chgGivePointServiceFee'); ?>",
				{'give_point_service_fee': give_point_service_fee, 'id': id},
				function (data) {
					window.top.msg(1,"修改成功",true,'3');window.top.main_refresh();window.top.closeiframe();
				}
			);
		});

		$(":button").click(function(){

            var loadi =layer.load('正在发送', 10000000000000);

            var user_count = "<?php echo ($user_count); ?>";   //用户总量

            var persend = 500;      //批量释放积分数量

            var pagesend = Math.ceil(parseInt(user_count) / parseInt(persend));

            var listpage = function(page,credit_weight,point_weight,release_id,users_count,points_count){
            	$.post(
                    "<?php echo U('Credit/sendPoints');?>",
                    {"page":page,"persend":persend,"credit_weight":credit_weight,"point_weight":point_weight,"release_id":release_id,"users_count":users_count,"points_count":points_count},
                    function(obj) {
                    	var users_count = obj.users_count;
                    	var points_count = obj.points_count;
                    	if(page < pagesend){
                    		var loadi = layer.load('正在发送('+(page*persend)+' / '+user_count+')');
                    		listpage(page+1,credit_weight,point_weight,release_id,users_count,points_count);
                    	}else{
                    		var id = "<?php echo $info['id']; ?>";
                    		$.post(
                    			"<?php echo U('Credit/afterSend'); ?>",
                    			{'users_count': users_count, 'points_count': points_count,'release_id':release_id,'id':id},
                    			function(data){
                    					layer.alert('发送成功', 6);
                    					layer.close(loadi);
                                        $(":button").val('今日已发送');
                    					$(":button").attr('disabled','true');
                    		},'json');
                    	}
                    },
                    'json'
            	)

            };

			 $.post(
			  		"<?php echo U('Credit/prepareSend'); ?>",
			  		{'user_count': user_count},
			  		function (data) {
			  			var data = data.sdata;
			  			var credit_weight = data.credit_weight;
			  			var point_weight = data.point_weight;
			  			var release_id = data.release_id;
			  			listpage(1,credit_weight,point_weight,release_id,0,0);
			  		},
			  		'json'
			  	);

        })


	})
</script>
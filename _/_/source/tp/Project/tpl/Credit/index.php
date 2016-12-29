<include file="Public:header"/>

    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Credit/index')}" class="on">积分概述</a>
            |
            <a href="{pigcms{:U('Credit/sendLog')}" >积分发放流水</a>
            |
            <a href="{pigcms{:U('Credit/statistics')}" >积分统计数据汇总</a>
        </ul>
    </div>

	<table cellpadding="0" cellspacing="0"  width="100%" class="frame_form" >

        <tr>
        <th width="150">开启平台积分：</th>
        <td class="radio_box">
			<span class="cb-enable status-enable"><label class="cb-enable <if condition="$info['platform_credit_open'] eq 1">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="platform_credit_open"><span>启用</span><input type="radio" name="platform_credit_open" value="1" <if condition="$info['platform_credit_open'] eq 1">checked="checked"</if> /></label></span>
			<span class="cb-disable status-disable"><label class="cb-disable <if condition="$info['platform_credit_open'] eq 0">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="platform_credit_open" ><span>禁用</span><input type="radio" name="platform_credit_open" value="0" <if condition="$info['platform_credit_open'] eq 0">checked="checked"</if>/></label></span>
		</td>
        </tr>
        <tr>
        <th width="160">强制平台店铺使用平台积分：</th>
      	<td class="radio_box">
			<span class="cb-enable status-enable"><label class="cb-enable <if condition="$info['force_use_platform_credit'] eq 1">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="force_use_platform_credit"><span>启用</span><input type="radio" name="force_use_platform_credit" value="1" <if condition="$info['force_use_platform_credit'] eq 1">checked="checked"</if> /></label></span>
			<span class="cb-disable status-disable"><label class="cb-disable <if condition="$info['force_use_platform_credit'] eq 0">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="force_use_platform_credit"><span>禁用</span><input type="radio" name="force_use_platform_credit" value="0" <if condition="$info['force_use_platform_credit'] eq 0">checked="checked"</if>/></label></span>
			<span>&nbsp;&nbsp; * 强制开启平台积分，会造成店铺不接受平台积分就无法正常交易</span>
		</td>
        </tr>
		<tr>
			<th width="150">充值现金余额最低限额：<br/><span style="color: grey;">(单位：元)</span></th>
			<td>
				<input type="text" class="input fl" name="min_margin_balance" id="min_margin_balance" placeholder="" style="width: 80px" validate="maxlength:20,required:true,number:true" tips="" value="{pigcms{$info.min_margin_balance}" />
				&nbsp;
				<a id="chg_min_margin_balance" data-id="<?php echo $info['id']; ?>">点击修改</a>
				* 若商家平台充值现金余额低于该金额，平台将禁止店铺继续产生交易，若不设置将以交易时扣除的服务费为准。
			</td>
		</tr>
        <tr>
            <th width="150">平台充值现金余额不足通知：<br/><span style="color: grey;">(模板消息 + 短信 通知)</span></th>
            <td class="radio_box">
                <span class="cb-enable status-enable"><label class="cb-enable <if condition="$info['recharge_notice_open'] eq 1">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="recharge_notice_open"><span>启用</span><input type="radio" name="recharge_notice_open" value="1" <if condition="$info['recharge_notice_open'] eq 1">checked="checked"</if> /></label></span>
                <span class="cb-disable status-disable"><label class="cb-disable <if condition="$info['recharge_notice_open'] eq 0">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="recharge_notice_open" ><span>禁用</span><input type="radio" name="recharge_notice_open" value="0" <if condition="$info['recharge_notice_open'] eq 0">checked="checked"</if>/></label></span>
            </td>
        </tr>
        <tr>
            <th width="150">单日最大通知次数：<br/><span style="color: grey;">(单位：次数)</span></th>
            <td>
                <input type="text" class="input fl" name="recharge_notice_maxcount" id="recharge_notice_maxcount" size="3" placeholder="" validate="maxlength:20,required:true,number:true" tips="" value="{pigcms{$info.recharge_notice_maxcount}" />
                &nbsp;
                <a id="chg_recharge_notice_maxcount" data-id="<?php echo $info['id']; ?>">点击修改</a>
                * 若商家平台充值现金余额不足，平台单日最大通知次数，若通知次数达到该值则不再提醒。
            </td>
        </tr>
		<tr>
			<th width="150">充值现金余额提现：</th>
			<td class="radio_box">
				<span class="cb-enable status-enable"><label class="cb-enable <if condition="$info['open_margin_withdrawal'] eq 1">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="open_margin_withdrawal"><span>启用</span><input type="radio" name="open_margin_withdrawal" value="1" <if condition="$info['open_margin_withdrawal'] eq 1">checked="checked"</if> /></label></span>
				<span class="cb-disable status-disable"><label class="cb-disable <if condition="$info['open_margin_withdrawal'] eq 0">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="open_margin_withdrawal" ><span>禁用</span><input type="radio" name="open_margin_withdrawal" value="0" <if condition="$info['open_margin_withdrawal'] eq 0">checked="checked"</if>/></label></span>
				<span>&nbsp;&nbsp; * 是否开启商家充值现金余额提现，如果开启商家可以把在平台充值的现金余额提现。</span>
			</td>
		</tr>
		<tr>
			<th width="150">充值现金余额最低提现额度：<br/><span style="color: grey;">(单位：元)</span></th>
			<td>
				<input type="text" class="input fl" name="margin_withdrawal_amount_min" id="margin_withdrawal_amount_min" size="3" placeholder="" validate="maxlength:20,required:true,number:true" tips="" value="{pigcms{$info.margin_withdrawal_amount_min}" />
				&nbsp;
				<a id="chg_margin_withdrawal_amount_min" data-id="<?php echo $info['id']; ?>">点击修改</a>
				* 若 “充值现金余额提现” 配置项开启，商家单次最低提现额度限制，0为不限制。
			</td>
		</tr>
		<tr>
			<th width="150">用户互赠积分：<br/><span style="color: grey;">(用户积分池里的积分)</span></th>
			<td class="radio_box">
				<span class="cb-enable status-enable"><label class="cb-enable <if condition="$info['open_user_give_point'] eq 1">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="open_user_give_point"><span>启用</span><input type="radio" name="open_user_give_point" value="1" <if condition="$info['open_user_give_point'] eq 1">checked="checked"</if> /></label></span>
				<span class="cb-disable status-disable"><label class="cb-disable <if condition="$info['open_user_give_point'] eq 0">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="open_user_give_point" ><span>禁用</span><input type="radio" name="open_user_give_point" value="0" <if condition="$info['open_user_give_point'] eq 0">checked="checked"</if>/></label></span>
				<span>&nbsp;&nbsp; * 用户之间可以相互赠送自己积分池里未发放的积分，</span>
			</td>
		</tr>
		<tr>
			<th>用户互赠积分服务费(%)：<br/><span style="color: grey;">(单位：积分)</span></th>
			<td>
				<input type="text" class="input fl" name="give_point_service_fee" id="give_point_service_fee" size="3" placeholder="" validate="maxlength:20,required:true,number:true" tips="" value="{pigcms{$info.give_point_service_fee}" />
				&nbsp;
				<a id="chg_give_point_service_fee" data-id="<?php echo $info['id']; ?>">点击修改</a>
				* 用户之间相互赠送积分时平台扣除的服务费。
			</td>
		</tr>
        <!-- <tr>
        <th width="150">开启店铺积分：</th>
      	<td class="radio_box">
			<span class="cb-enable status-enable"><label class="cb-enable <if condition="$info['store_credit_open'] eq 1">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="store_credit_open"><span>启用</span><input type="radio" name="store_credit_open" value="1" <if condition="$info['store_credit_open'] eq 1">checked="checked"</if> /></label></span>
			<span class="cb-disable status-disable"><label class="cb-disable <if condition="$info['store_credit_open'] eq 0">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="store_credit_open"><span>禁用</span><input type="radio" name="store_credit_open" value="0" <if condition="$info['store_credit_open'] eq 0">checked="checked"</if>/></label></span>
		</td>
        </tr> -->
        <tr><th width="150">平台充值现金总额：</th><td>{pigcms{$common_data[1]['value']|default="0"}</td></tr>
        <tr><th width="150">用户分享积分总额：</th><td>{pigcms{$user_share_point_max|default="0"}</td></tr>
        <tr><th width="150">当前用户有效积分值：</th><td>{pigcms{$user_point_balance|default="0"}</td></tr>
        <tr><th width="150">当前店铺有效积分值:</th><td>{pigcms{$store_point_balance|default="0"}</td></tr>
        <tr><th width="150">店铺已变现积分:</th><td>{pigcms{$store_point2money|default="0"}</td></tr>
        <tr><th width="150">用户积分池总数:</th><td>{pigcms{$user_point_pool|default="0"}</td></tr>
        <tr><th width="150">积分权数值：</th><td>{pigcms{$info.credit_weight}</td></tr>
        <tr><th width="150">积分价值：</th><td>1 元 人民币 == {pigcms{$info.platform_credit_use_value} 积分</td></tr>
        <tr><th width="150">积分生成比：</th><td>1 元 消费额 == {pigcms{$info.platform_credit_rule} 积分</td></tr>
        <tr>
	        <th width="150">今日积分权数：</th>
			<td>
		        <input type="text" class="input fl" name="today_credit_weight" id="today_credit_weight" size="3" placeholder="" validate="maxlength:20,required:true,number:true" tips="" value="{pigcms{$info.today_credit_weight}" />
		        &nbsp;
		        <a id="chg_today_credit_weight" data-id="<?php echo $info['id']; ?>">点击修改</a>
		        *  真实积分权数：{pigcms{$real_point_weight}  (在计算发放积分时,如果权数值大于1,则取1)
	        </td>
        </tr>
        <tr><th width="150">昨日平台服务费：</th><td>￥ {pigcms{$day_platform_service_fee|default="0"}</td></tr>
        <tr><th width="150">昨日备付金总额(单日)：</th><td>￥{pigcms{$cash_provision_balance_yestoday|default="0"} </td></tr>
        <tr><th width="150">当前剩余备付金：</th><td>￥{pigcms{$cash_provision_balance_now|default="0"} (截止昨日备付金剩余 ￥{pigcms{$cash_provision_balance_until_yestoday|default="0"},今日新增 ￥{pigcms{$cash_provision_balance_today|default="0"}  ) <a href="{pigcms{:U('Credit/cashProvisionLog')}" >点击查看流水</a></td></tr>


        <tr><th width="150">今日需发放积分点数最大值：</th><td>{pigcms{$today_send_point_max|default="0"}</td></tr>
       
      <if condition="$info['auto_send'] eq 0"> 
        <tr><th width="150">发送积分</th><td><input type="button" <if condition="$release_count eq 1"> value="今日已发送" disabled<else />value="点击发送" style="cursor: pointer;"</if> >  *  默认9点发送积分值，请在9点之前修改 今日积分权数 <a href="{pigcms{:U('Credit/sendLog')}" >点击查看发放流水</a></td></tr>
	 </if>	
	</table>

<include file="Public:footer"/>

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

<script type="text/javascript" src="{pigcms{$static_public}js/layer/layer.min.js"></script>


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

            var user_count = "{pigcms{$user_count}";   //用户总量

            var persend = 500;      //批量释放积分数量

            var pagesend = Math.ceil(parseInt(user_count) / parseInt(persend));

            var listpage = function(page,credit_weight,point_weight,release_id,users_count,points_count){
            	$.post(
                    "{pigcms{:U('Credit/sendPoints')}",
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
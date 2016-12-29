<include file="Public:header"/>
	
	<style type="text/css">
        .date-quick-pick {
            display: inline-block;
            color: #07d;
            cursor: pointer;
            padding: 2px 4px;
            border: 1px solid transparent;
            margin-left: 12px;
            border-radius: 4px;
            line-height: normal;
        }
        .date-quick-pick.current {
            background: #fff;
            border-color: #07d!important;
        }
        .date-quick-pick:hover{border-color:#ccc;text-decoration:none}

        .fxewm span{
			float: left;
			padding: 7px 10px 9px;
			font-weight: 100;
			text-align: left;
        }
        .fxewm img{
        	float: left;
        }
        .fxewm error{
        	float: left;
        }

    </style>
    
	<form id="myform" method="post" action="{pigcms{:U('Credit/upRules')}" refresh="true" frame="true" >
		 <div id="nav" class="mainnav_title">
	        <ul>
	            <a href="{pigcms{:U('Credit/rules')}" class="on">平台积分字段自定义</a>
	        </ul>
	    </div>	
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">

            <tr>
				<th width="180">平台积分前端展示名称：</th>
				<td>
					<input type="text" class="input fl" name="platform_credit_name" id="platform_credit_name" size="25" placeholder="" validate="maxlength:50,required:true" tips="e.g 成谋币 京东豆(用户和商家都显示一样的积分)" value="{pigcms{$info.platform_credit_name}" />
			    </td>
			</tr>

			<tr>
				<th width="180">平台积分发送点数展示名称：</th>
				<td>
					<input type="text" class="input fl" name="platform_credit_points" id="platform_credit_points" value="{pigcms{$info.platform_credit_points}" size="25" validate="maxlength:100" tips="用户可以获得的发放点数">
				</td>
			</tr>

		</table>

		<div id="nav" class="mainnav_title">
	        <ul>
	            <a href="{pigcms{:U('Credit/rules')}" class="on">平台财务参数设置</a>
	        </ul>
	    </div>	

		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			
			<tr>
				<th width="180">平台充值现金充值最小额度</th>
				<td>
					<input type="text" class="input fl" name="cash_min_amount" id="cash_min_amount" value="{pigcms{$info.cash_min_amount}" size="3" validate="required:true,number:true" tips="单次充值最低金额">
				</td>
			</tr>

			<tr>
				<th width="180">积分平台充值现金扣除比例：</th>
				<td>
					<input type="text" class="input fl" name="credit_deposit_ratio" id="credit_deposit_ratio" value="{pigcms{$info.credit_deposit_ratio}" size="3" validate="required:true,number:true,maxlength:6" tips="当店铺需要发送积分时，我们扣除积分值的百分比 例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除">
				</td>
			</tr>

			<tr>
				<th width="180">赠送积分存保金(%)：</th>
				<td>
					<input type="text" class="input fl" name="cash_provisions" id="cash_provisions" value="{pigcms{$info.cash_provisions}" size="3" validate="required:true,number:true,maxlength:6" tips="">&nbsp;&nbsp;
					<span style="color:red;margin-top: 5px;">平台开支(%):<?php echo number_format(100 - $info['cash_provisions'],2); ?></span>
				</td>
			</tr>

			<tr>
				<th width="180">积分流转手续费(%)：</th>
				<td>
					<input type="text" class="input fl" name="credit_flow_charges" id="credit_flow_charges" value="{pigcms{$info.credit_flow_charges}" size="3" validate="required:true,number:true,maxlength:6" tips="当用户消费积分到店铺时，平台扣除百分比积分 例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除">
				</td>
			</tr>

			<tr>
				<th width="180">店铺积分变现手续费(%)：</th>
				<td>
					<input type="text" class="input fl" name="storecredit_to_money_charges" id="storecredit_to_money_charges" value="{pigcms{$info.storecredit_to_money_charges}" size="3" validate="required:true,number:true,maxlength:6" tips="当店铺将店铺积分转为可提现金额时，消费的手续费 例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除">
				</td>
			</tr>

			<tr>
				<th width="180">线上订单最低现金比：</th>
				<td>
					<input type="text" class="input-text" name="online_trade_money" id="online_trade_money" value="{pigcms{$info.online_trade_money}" size="3" validate="required:true,number:true,maxlength:6" tips="例：填入：2，则代表2% 支付订单时按照设定的现金积分比例进行交易">
				</td>
			</tr>

			<tr>
				<th width="80">线上订单赠送积分基数</th>
				<td class="radio_box">
					<label style="float:left;width:80px" class="checkbox_status"><input type="radio" class="input_radio" name="online_trade_credit_type" <if condition="$info['online_trade_credit_type'] eq 0">checked="checked"</if> value="0" /> 订单全额</label>
					<label style="float:left;width:80px" class="checkbox_status"><input type="radio" class="input_radio" name="online_trade_credit_type" <if condition="$info['online_trade_credit_type'] eq 1">checked="checked"</if> value="1" validate=" maxlength:1" /> 现金部分</label>
				</td>
			</tr>

			<tr>
				<th width="180">线下做单最低现金比：</th>
				<td>
					<input type="text" class="input-text" name="offline_trade_money" id="offline_trade_money" value="{pigcms{$info.offline_trade_money}" size="3" validate="required:true,number:true,maxlength:6" tips="例：填入：2，则代表2% 支付时按照设定的现金积分比例进行交易">
				</td>
			</tr>

			<tr>
				<th width="80">线下用户做单赠送积分基数：</th>
				<td class="radio_box">
					<label style="float:left;width:80px" class="checkbox_status"><input type="radio" class="input_radio" name="offline_trade_credit_type" <if condition="$info['offline_trade_credit_type'] eq 0">checked="checked"</if> value="0" /> 订单全额</label>
					<label style="float:left;width:80px" class="checkbox_status"><input type="radio" class="input_radio" name="offline_trade_credit_type" <if condition="$info['offline_trade_credit_type'] eq 1">checked="checked"</if> value="1" validate=" maxlength:1" /> 现金部分</label>
					<img src="./source/tp/Project/tpl/Static/images/help.gif" class="tips_img" style="margin-top: -3px;" title="<label style='color:red'>线下用户做单：</label>线下做单积分部分使用用户可用积分抵现。" />
				</td>
			</tr>
			<tr>
				<th width="80">线下店铺做单赠送积分基数：</th>
				<td class="radio_box">
					<label style="float:left;width:80px" class="checkbox_status"><input type="radio" class="input_radio" name="offline_trade_store_type" <if condition="$info['offline_trade_store_type'] eq 0">checked="checked"</if> value="0" /> 订单全额</label>
					<label style="float:left;width:80px" class="checkbox_status"><input type="radio" class="input_radio" name="offline_trade_store_type" <if condition="$info['offline_trade_store_type'] eq 1">checked="checked"</if> value="1" validate=" maxlength:1" /> 现金部分</label>
					<img src="./source/tp/Project/tpl/Static/images/help.gif" class="tips_img" style="margin-top: -3px;" title="<label style='color:red'>线下店铺做单：</label>线下做单积分部分使用店铺可用积分代为抵现。" />
				</td>
			</tr>
		</table>

		<div id="nav" class="mainnav_title">
	        <ul>
	            <a href="{pigcms{:U('Credit/rules')}" class="on">抵现积分规则</a>
	            赠送积分是在平台订单 不可逆时才赠送积分到用户积分池中
	        </ul>
    	</div>


    	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">

            <tr>
				<th width="180">平台积分生成规则：<br>1元消费额对等的积分数</th>
				<td>
					<input type="text" class="input fl" name="platform_credit_rule" id="platform_credit_rule" size="3" placeholder="" validate="maxlength:50,required:true,number:true" tips="1 元 消费额 == xx 积分" value="{pigcms{$info.platform_credit_rule}" />
			    </td>
			</tr>

			 <tr>
				<th width="180">平台积分使用价值：<br>1元人民币对等的积分数</th>
				<td>
					<input type="text" class="input fl" name="platform_credit_use_value" id="platform_credit_use_value" size="3" placeholder="" validate="maxlength:50,required:true,number:true" tips="1 元 人民币 == xx 积分" value="{pigcms{$info.platform_credit_use_value}" />
			    </td>
			</tr>

			<tr>
				<th width="180">积分权数值：</th>
				<td>
					<input type="text" class="input fl" name="credit_weight" id="credit_weight" size="3" placeholder="" validate="maxlength:50,required:true,number:true" tips="用户积分池达到该值，才可释放出一个有效积分点数" value="{pigcms{$info.credit_weight}" />
			    </td>
			</tr>

			<tr>
				<th width="180">开启自动发送积分：</th>
				<td class="radio_box">
				<span class="cb-enable status-enable"><label class="cb-enable <if condition="$info['auto_send'] eq 1">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="auto_send"><span>是</span><input type="radio" name="auto_send" value="1" <if condition="$info['auto_send'] eq 1">checked="checked"</if> /></label></span>
				<span class="cb-disable status-disable"><label class="cb-disable <if condition="$info['auto_send'] eq 0">selected</if>" data-id="<?php echo $info['id']; ?>" data-name="auto_send" ><span>否</span><input type="radio" name="auto_send" value="0" <if condition="$info['auto_send'] eq 0">checked="checked"</if>/></label></span>
			</td>
			</tr>	

			<tr>
				<th width="180">每日默认自动发送积分时间：</th>
				<td>
					<input readonly="true" type="text" onfocus="WdatePicker({dateFmt:'HH'})" name="day_send_credit_time" class="input-text Wdate" style="width: 150px" value="{pigcms{$info.day_send_credit_time}" validate="maxlength:50,required:true" tips="每日自动发放积分的时间，单位：小时" />
			    </td>
			</tr>			

		</table>


		<div id="nav" class="mainnav_title">
	        <ul>
	            <a href="{pigcms{:U('Credit/rules')}" class="on">分享积分规则</a>
	            分享积分只能用于商城的积分店铺，积分店铺--平台运营
	        </ul>
    	</div>
		

    	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			
			<tr>
				<th width="180">分享二维码点击：</th>
				<td class="fxewm">
					<input type="text" class="input fl" name="share_qrcode_effective_click" id="share_qrcode_effective_click" size="3" placeholder="" validate="" value="{pigcms{$info.share_qrcode_effective_click}" /><span>有效点击数  送</span> <input type="text" class="input fl" name="share_qrcode_credit" id="share_qrcode_credit" size="3" placeholder="" validate="maxlength:50,required:true,number:true" tips="" value="{pigcms{$info.share_qrcode_credit}" /> <span>积分</span>
			    </td>
			</tr>

			<!-- <tr>
				<th width="180">分享二维码(送积分设置)：</th>
				<td>
					<input type="text" class="input fl" name="share_qrcode_credit" id="share_qrcode_credit" size="3" placeholder="" validate="maxlength:50,required:true,number:true" tips="分享二维码点击：xx有效点击数  送xx积分" value="{pigcms{$info.share_qrcode_credit}" />
			    </td>
			</tr> -->


			<tr>
				<th width="180">关注平台二维码送的积分(首次)：</th>
				<td>
					<input type="text" class="input fl" name="follow_platform_credit" id="follow_platform_credit" size="3" placeholder="" validate="maxlength:50,required:true,number:true" tips="首次关注送积分" value="{pigcms{$info.follow_platform_credit}" />
			    </td>
			</tr>


			<tr>
				<th width="180">推荐别人关注自身可得的积分(每次)：</th>
				<td>
					<input type="text" class="input fl" name="recommend_follow_self_credit" id="recommend_follow_self_credit" size="3" placeholder="" validate="maxlength:50,required:true,number:true" tips="每次推荐别人关注自身可得的积分" value="{pigcms{$info.recommend_follow_self_credit}" />
			    </td>
			</tr>
       

		</table>


		<div class="btn" style="margin-top:20px;">
			<input type="hidden" name="id" id="id" value="{pigcms{$info.id}" />
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>

		
	</form>

<include file="Public:footer"/>
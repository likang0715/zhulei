<volist name="order_all" id="vo_all">
<table align="center" cellpadding="0" cellspacing="0" class="table_style" style="width: 90%">
<tr>
	<td height="70">
		<table cellpadding="0" cellspacing="0" class="table_style" style="width: 100%">
			<tr>
				<td class="td01"><strong>商品订单</strong>&#12288;
					<font style="font-size:12px;color:#f00">
						([%vo_all.order_typename%])
					</font>
				</td>
				<td align="right"><img width="120" height="120" src="[%store.qcode%]?>"/></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>
<tr>
	<td>
		<table style="width: 100%" cellpadding="0" cellspacing="0" class="table_style">
			<tr>
				<td class="font02"><strong class="font02">订单号：[%vo_all.order_no%]</strong></td>
				<td class="font02" align="right"><strong>客户下单日期：[%vo_all.xd_time%]</strong></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>
<tr>
	<td align="center">
		<table style="width: 98%" cellpadding="5" cellspacing="0" class="table_style">
			<tr>
				<td class="font02"><strong>订购商品名称</strong></td>
				<td class="font02"><strong>单价</strong></td>
				<td class="font02"><strong>数量</strong></td>
				<td class="font02"><strong>小计</strong></td>
				<!-- <td class="font02"><strong>状态</strong></td> -->
			</tr>
			<volist name="vo_all[products_list]" id="vo">
				<tr>
					<td>
						<!--商品名称-->
						[%vo.name%]
						<!--赠品或分销-->
						[%vo.zp_or_fx%]
						<!--选择款式-->
						[%vo.skus_name%]			
					</td>
					<td>[%vo.pro_price%]</td>
					<td>[%vo.pro_num%]</td>
					<td>[%vo.xj%]</td>
					<!-- <td>[$vo.zhaungtai]</td> -->
				</tr>
				<tr class="msg-row">
					<td colspan="6">[%vo.comment%]<br></td>
				</tr>
			</volist>
		</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>
<tr>
	<td>
	<table cellpadding="3" cellspacing="0" class="table_style" style="width: 100%">
		<tr>
			<if condition="$vo_all['comment']==1">
				<td valign="top">买家留言：[%vo_all.comment%]</span></td>
			</if>
			<td style="width:300px;text-align:right" valign="top" class="font04">
				<table cellpadding="3" cellspacing="0" class="table_style" style="width: 100%">
					<tr>
						<td valign="top"> </td>
						<td style="width: 300px;text-align:right;line-height:22px;" valign="top">
						
							<span class="font04">商品小计：￥[%vo_all.order_xj%]</span><br/>
							<!--运费-->
							[%vo_all.postage%]
							<!-- 卖家改价 -->
							[%vo_all.maijiagaijia%]
							<!--满减-->
							[%vo_all.manjian%]
							<!-- 订单打折优惠 -->
							[%vo_all.zhehouyouhui%]
							<!-- 订单优惠券 -->
							[%vo_all.youhuiquan%]
							<!-- 订单其他折扣 -->
							[%vo_all.other_discount%]
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>
<tr>
	<td>
		<table cellpadding="3" cellspacing="0" class="table_style" style="width: 100%">
			<tr>
				<td></td>
				<td style="width: 300px;text-align:right" valign="top">
					<span class="font02"><strong>应收款：<span class="ui-money-income">￥</span><span class="order-total">[%vo_all.yingshoukuan%]</span></strong></span>
				</td>
			</tr>		
		</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>

<tr>
	<td>
		<table cellpadding="3" cellspacing="0" class="table_style" style="width: 100%">
			<tr>
				<td class="font04">
					客户姓名：[%vo_all.address_user%]
					<br />
					<if condition="$vo_all['address']['province']">
						客户地址：[%vo_all.addressdetail%] 
					</if>	
					<br />
					<if condition="$vo_all['address_tel']>1">
						联系电话：[%vo_all.address_tel%]
					</if>
				</td>
				<td valign="top"> </td>
			</tr>
		</table>
	</td>
</tr>
</table>
<hr align="center" width="90%" size="1" noshade class="NOPRINT" >
<!--分页-->
<div class="PageNext"></div>
</volist>

<volist name="order_all" id="vo_all">
<forpage>
	<div class="print1"> 
		<table cellspacing="0" cellpadding="0" width="900"  align="center"  > 
			<tbody>
				<tr> 
					<td colspan="4"> 
						<table cellspacing="0" cellpadding="0" width="900"  align="center"  >
							<tbody>
								<tr> 
									<td>
										<h1 class="orderTitle1"><center>xx公司（*可以填写公司名称）</center></h1> 
									</td> 
									<td>
										<span style="float:right"><h2 class="orderTitle1"></h2></span>
									</td> 
								</tr> 
							</tbody>
						</table> 
					</td> 
				</tr> 
			</tbody>
		</table> 		


		 <table cellspacing="0" cellpadding="0" width="900"  align="center"  > 
			<tbody>
				<tr> 
					<td width="79" align="right" valign="top"></td> 
					<td width="185" valign="top"></td> 
					<td colspan="2"></td> 
				</tr> 
				
				<tr> 
					<td align="right" valign="top">订货电话：</td> 
					<td valign="top">4000-111-222</td> 
					<td align="right" valign="top"> 联系人： [%vo_all.address_user%]</td> 
				</tr> 
				
				<tr> 
					<td align="right" valign="top">传  真：</td> 
					<td valign="top">011-121212121</td> 
					<td align="right" valign="top">电话：666666666</td> 
				</tr> 
				
				<tr> 
					<td align="right" valign="top">订货 Q群：</td> 
					<td valign="top"> 12345678</td> 
					<td align="right" valign="top">日期：[%vo_all.xd_time%]</td> 
				</tr> 
				
				<tr> 
					<td align="right" valign="top">订  单  号：</td>
					<td valign="top">[%vo_all.order_no%]</td> 
					<td align="right" valign="top">
						<if condition="$vo_all['address']['province']">
							送货地址：[%vo_all.addressdetail%] 
						</if>	
					</td> 
				</tr> 
				
			</tbody>
		</table> 

		<table border="1" cellspacing="0" cellpadding="0" width="900"  align="center"   class="t1" style="font-size:14px;"> 
			<tbody>
				<tr class="heads_tr"> 
					<td width="60" align="center">序号</td>
					<td width="400" align="center">商品名称</td> 
					<td width="60" align="center">数量</td>
					<td width="100" align="center">单价</td>  			
					<td width="60" align="center">小计</td> 
					<td width="220" align="center">(商家)备注</td> 
				</tr>  
	
				<volist name="vo_all[products_list.$is]" id="vo">	
					<tr> 
						<td align="center"><b>[%xh%]</b></td>
						<td align="center">[%vo.name%]</td>
						<td align="center">[%vo.pro_num%]</td>
						<td align="center">[%vo.pro_price%]</td>
						<td align="right">[%vo.xj%]</td> 
						<td align="center">[%vo.bak%]</td> 
					</tr> 
				</volist>
				
				<showone>
				<tr> 
					<td colspan="6" align="left">  
						<if condition="$vo_all['comment']==1">
							<td valign="top">买家留言：[%vo_all.comment%]</span></td>
						
					<br/>
					</if>
						<ul class="lists" style="width:90%;margin:auto auto;list-style:none">
							<li>
								商品小计：￥[%vo_all.order_xj%]
							</li>	
							<li>
								<!--运费-->
								[%vo_all.postage%]
							</li>		
							<li>
								<!-- 卖家改价 -->
								[%vo_all.maijiagaijia%]
							</li>	
							<li>
								<!--满减-->
								[%vo_all.manjian%]
							</li>	
							<li>
								<!-- 订单打折优惠 -->
								[%vo_all.zhehouyouhui%]
							</li>
							<li>
								<!-- 订单优惠券 -->
								[%vo_all.youhuiquan%]
							</li>
							<li>
								<!-- 订单其它折扣 -->
								[%vo_all.other_discount%]
							</li>		
						</ul>
					
					</td> 
				</tr>  
				
				<tr> 
					
					<td colspan="6" align="right" style="text-algin:right;">  
						[%vo_all.order_typename%]
						<span class="font02" style="margin:12px auto;display:inline-block;"><strong>应收款：<span class="ui-money-income">￥</span><span class="order-total">[%vo_all.yingshoukuan%]</span></strong></span>
					&#12288;&#12288;&#12288;
					</td>
				</tr>
				</showone>	
			</tbody>
		</table> 
	
		<table cellspacing="0" cellpadding="0" width="900"  align="center"   style="font-size:12px;"> 
			<tbody>
				<tr> 
					<td width="38" align="left" valign="middle">新品：</td> 
					<td width="731">其他描述，如不需要，可以删除！！！</td> 
				</tr> 
				<tr> 
					<td align="left" valign="top">通知：</td> 
					<td>您已成为了xxxxx的会员，用户名称为[[%vo_all.address_user%]]，登录密码请咨询客服，及时登录修改密码，自行查询商品、下订单！并修改、补充完善个人信息。</td> 
				</tr> 
				<tr> 
					<td align="left" valign="middle">注明：</td> 
					<td>以上货品请当面清点核对、签名、盖章，多谢合作！</td> 
				</tr> 
				<tr> 
					<td align="left" valign="middle">备注：</td> 
					<td>订货电话    xxxx-xxxxx    010-88888888    010-666666666</td> 
				</tr> 
				
				<tr> 
					<td colspan="2"> 第一联：回单（白） 第二联：客户（红） 第三联：存根（黄） 第四联：仓管（绿） </td> 
				</tr> 
				<tr> 
					<td style="font-size:16px;" colspan="2"><span style="display:inline-block;width:27%">客户签名：</span>              <span style="display:inline-block;width:27%">盖章：</span>              <span style="display:inline-block;width:27%">开单人：</span></td> 
				</tr> 
			</tbody>
		</table> 
	</div>
 	<hr align="center" width="90%" size="1" noshade class="NOPRINT" > 
	<!--分页-->
	<unshowone>
	<div class="PageNext"></div> 
	</unshowone>
</forpage>
</volist>
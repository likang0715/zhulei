<include file="Public:header"/>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="{pigcms{:U('Group/product')}">商品列表</a>					<a href="{pigcms{:U('Group/order_list',array('group_id'=>$now_group['group_id']))}" class="on">订单列表</a>				</ul>			</div>			<div style="margin:15px 0;">				<b>商家ID：</b>{pigcms{$now_merchant.mer_id}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>商家名称：</b>{pigcms{$now_merchant.name}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>联系电话：</b>{pigcms{$now_merchant.phone}<br/><br/>				<b>团购ID：</b>{pigcms{$now_group.group_id}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>团购名称：</b>{pigcms{$now_group.s_name}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>团购价：</b>￥{pigcms{$now_group.price|floatval=###}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>团购类型：</b>				<switch name="now_group['tuan_type']">					<case value="0">团购券</case>					<case value="1">代金券</case>					<case value="2">实物</case>				</switch>			</div>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<style>					.table-list td{line-height:22px;padding-top:5px;padding-bottom:5px;}					</style>					<table width="100%" cellspacing="0">						<colgroup>							<col/>							<col/>							<col/>							<col/>							<col/>							<col/>							<col width="100" align="center"/>						</colgroup>						<thead>							<tr>								<th>订单编号</th>								<th>订单信息</th>								<th>订单用户</th>								<th>查看用户信息</th>								<th>订单状态</th>								<th>时间</th>								<th class="textcenter">操作</th>							</tr>						</thead>						<tbody>							<if condition="is_array($order_list)">								<volist name="order_list" id="vo">									<tr>										<td>{pigcms{$vo.order_id}</td>										<td>数量：{pigcms{$vo.num}<br/>总价：￥{pigcms{$vo.total_money|floatval=###}</td>										<td>用户名：{pigcms{$vo.nickname}<br/>订单手机号：{pigcms{$vo.group_phone}</td>										<td>											<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('User/edit',array('uid'=>$vo['uid']))}','编辑用户信息',680,560,true,false,false,editbtn,'edit',true);">查看用户信息</a>										</td>										<td>											<if condition="$vo['paid']">												<if condition="$vo['status'] eq 0">													<font color="green">已付款</font>													<php>if($vo['tuan_type'] != 2){</php>														<font color="red">未消费</font>													<php>}else{</php>														<font color="red">未发货</font>													<php>}</php>												<elseif condition="$vo['status'] eq 1"/>													<php>if($vo['tuan_type'] != 2){</php>														<font color="green">已消费</font>													<php>}else{</php>														<font color="green">已发货</font>													<php>}</php>													<font color="red">待评价</font>												<else/>													<font color="green">已完成</font>												</if>											<else/>												<font color="red">未付款</font>											</if><br/>										</td>										<td>											下单时间：{pigcms{$vo['add_time']|date='Y-m-d H:i:s',###}<br/>											<if condition="$vo['paid']">付款时间：{pigcms{$vo['pay_time']|date='Y-m-d H:i:s',###}</if>										</td>										<td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Group/order_edit',array('order_id'=>$vo['order_id']))}','查看订单详情',600,460,true,false,false,false,'order_edit',true);">查看详情</a></td>									</tr>								</volist>								<tr><td class="textcenter pagebar" colspan="11">{pigcms{$pagebar}</td></tr>							<else/>								<tr><td class="textcenter red" colspan="11">列表为空！</td></tr>							</if>						</tbody>					</table>				</div>			</form>		</div><include file="Public:footer"/>
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>/wxapp/unitary/css/cymain.css" />
<div class="content">
	<div class="cLineB">
		<h4 class="left">一元购活动商品管理</h4>
		<div class="clr"></div>
	</div>
	
	<div class="cLine">
		<div class="pageNavigator left">
			<a href="user.php?c=unitary&a=add" title="新增活动商品" class="btnGrayS vm bigbtn"><if condition="$usertplid eq 2"><i class="fa fa-hand-o-right"></i><else /></if> 新增活动商品</a>
		</div>
		<!-- <div class="pageNavigator right">
			<form class="form" method="post"  action="">
				<input type="text" id="" class="px" placeholder="输入名称/关键词搜索"  name="nameorkeyword" value="{pigcms:$Think.post.nameorkeyword}" style="margin-top:10px">
				<input type="submit" value="搜索" id="" href="" class="btnGrayS" title="搜索">
			</form>
		</div> -->
		<script>
			$(function(){
				$(".radio").click(function(){
					var name = $(this).attr("name");
					var val = $(this).val();
					$.ajax({
						type:"POST",
						url:"{pigcms::U('Unitary/indexajax',array('token'=>token))}",
						dataType:"json",
						data:{
							token:"{pigcms:$token}",
							name:name,
							val:val
						},
						success:function(data){
							if(data.error == 0){
								alert("修改成功");
							}
						}
					});
				});
			});
		</script>
		<div class="clr"></div>
	</div>
	
	<div class="alert alert-success alert-dismissable">
		<if condition="$Think.session.is_syn neq 2">
		<if condition="$_SESSION['is_syn'] neq 1">
		温馨提示：本功能使用了模板消息中的"订单发货提醒"模板消息和"中奖结果通知"模板消息,模板消息编号为OPENTM200565259和TM00695。<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		开通微信支付功能的公众号在使用此功能的时候可以在"基本设置——微信模板消息"中配置对应的模板消息。<br/><br/>
		</if>
		</if>
		活动算法：活动开始以后，当商品的最后一元被购买，此时活动就会开奖。中奖号码的计算是取最后一元的购买者前100条全站记录（这个全站记录是指所有购买一元购的人的记录，并
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		不是单独一个活动的记录）的时间转化成数字（例如21:45:32.123转化后就是214532123）的总和，用这个总和与设置的价钱取余数，这余数加上100000组成最终的幸运号
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		码，（当全站记录没有100条时，则有几条取几条）。
	</div>
	<div class="msgWrap">
		<table class="ListProduct" border="0" cellspacing="0" cellpadding="0" width="100%">
			<thead>
				<th class="select">选择</th>
				<th width="120px">名称</th>
				<th width="90px">价格/元</th>
				<if condition="$_SESSION['is_syn'] eq 0">
				<th width="90px">关键字</th>
				</if>
				<th width="120px">活动状态</th>
				<th width="150px">创建时间</th>
				<th class="norightborder">操作</th>
			</thead>
			<tbody>
			
			</tbody>
		</table>
	</div>
	<div class="cLine">
		<div class="pageNavigator right">
			<div class="pages"></div>
		</div>
		<div class="clr"></div>
	</div>
</div>
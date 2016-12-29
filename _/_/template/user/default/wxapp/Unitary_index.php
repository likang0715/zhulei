<link rel="stylesheet" type="text/css" href="http://demo.pigcms.cn/tpl/User/default/common/css/style-1.css?id=103" />

<style>
.app{width:800px;}
.pages .active { background: #00A5FF; color: white !important; border-color: #ddd}
</style>

<div class="content">
	<div class="cLineB">
		<div class="clr"></div>
	</div>
	<div class="cLine">
		<div class="pageNavigator left">
			<a href="javascript:;" title="新增活动商品" class="btnGrayS vm bigbtn js-add-unitary"><if condition="$usertplid eq 2"><i class="fa fa-hand-o-right"></i><else /></if> 新增活动商品</a>
		</div>
		<!-- <div class="pageNavigator right">
			<form class="form" method="post"  action="">
				<input type="text" id="" class="px" placeholder="输入名称/关键词搜索"  name="nameorkeyword" value="{pigcms:$Think.post.nameorkeyword}" style="margin-top:10px">
				<input type="submit" value="搜索" id="" href="" class="btnGrayS" title="搜索">
			</form>
		</div> -->
		<script>
			$(function(){
				
				//添加商品
				widget_link_box($('.js-add-unitary'),'unitary',function(result){
					
				});

				//修改价格
				$(".norightborder .update_price").click(function(){
					$(this).parent().parent().find(".update_input_price").removeAttr("readonly").focus();
				});
				$(".update_input_price").keyup(function(){
					var re = /^[1-9]+[0-9]*]*$/;
					var val = $(this).val();
					//获取id
					var id = $(this).attr("data-id");
					if(!re.test(val)){
						alert('价格必须均为正整数');return;
					}
					$.post("user.php?c=unitary&a=update", {id:id,price:val},function(data){
						if(data.err_code)
						{
							alert(data.err_msg);
						}
				   });
				});

				$('.pages a').live('click',function(e){
					if(!$(this).hasClass('active')){
						load_page('.app__content',load_url,{page:'unitary_index',p:$(this).attr('data-page-num')},'');
					}
				});
			});
			
			function drop_confirm(msg, url)
			{
				if (confirm(msg)) {
					window.location.href = url;
				}
			}

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
		活动算法：活动开始以后，当商品的最后一元被购买，此时活动就会开奖。中奖号码的计算是取最后一元的购买者前100条全站记录（这个全站记录是指所有购买一元购的人的记录，并不是单独一个活动的记录）的时间转化成数字（例如21:45:32.123转化后就是214532123）的总和，用这个总和与设置的价钱取余数，这余数加上100000组成最终的幸运号码，（当全站记录没有100条时，则有几条取几条）。
	</div>
	<div class="msgWrap">
		<table class="ListProduct" border="0" cellspacing="0" cellpadding="0" width="100%">
			<thead>
				<th width="120px">名称</th>
				<th width="90px">价格/元</th>
				<th width="120px">活动状态</th>
				<th width="150px">创建时间</th>
				<th class="norightborder">操作</th>
			</thead>
			<tbody>
				<?php foreach($products as $product){ ?>
				<tr>
				<td><?php echo $product['name']; ?></td>
				<td><input type="text" value="<?php echo $product['price']; ?>" style="width:50px;" readonly class="update_input_price" data-id="<?php echo $product['id'];?>"/></td>
				<?php 
				if($product['state'] == 1)
				{
					echo "<td style='color:green'>开始-已有".$product['pay_count']."人</td>";
				}elseif($product['state'] == 2)
				{
					echo "<td style='color:blue'>结束-已有".$product['pay_count']."人</td>";
				}else
				{
					echo "<td style='color:red'>关闭-已有".$product['pay_count']."人</td>";
				}
				?>
				<td><?php echo date('Y-m-d H:i:s', $product['addtime']); ?></td>
				<td class="norightborder">
						<?php if($product['state'] == 0){ ?>
						<a href="javascript:;" class="update_price">修改</a>
						<?php }?>
						<?php if($product['state'] == 0){ ?>
						<a href="javascript:drop_confirm('开始后将不能修改价格，确定开始吗?','<?php dourl('Unitary:operate',array('token'=>$token,'unitaryid'=>$product['id'],'type'=>'start','p'=>$_GET['p']));?>')">开始</a>
						<?php }elseif($product['state'] == 1){ ?>
						<a href="javascript:drop_confirm('关闭后将不再手机上显示，确定关闭吗?','<?php dourl('Unitary:operate',array('token'=>$token,'unitaryid'=>$product['id'],'type'=>'stop','p'=>$_GET['p']));?>')">关闭</a>
						<?php }?>
						<a href="<?php dourl('Unitary:data',array('token'=>$token,'unitaryid'=>$product['id']));?>">数据</a>
						<?php if($product['state'] == 0 && $product['pay_count'] == 0){ ?>
						<a href="javascript:drop_confirm('您确定要删除【<?php echo $product['name'] ?>】吗?', '<?php dourl('Unitary:operate',array('token'=>$token,'unitaryid'=>$product['id'],'type'=>'del'));?>')">删除</a>
						<?php }?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="cLine">
		<div class="pageNavigator right">
			<div class="pages"><?php echo $page; ?></div>
		</div>
		<div class="clr"></div>
	</div>
</div>
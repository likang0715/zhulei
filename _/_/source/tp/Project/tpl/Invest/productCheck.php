<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
$(function(){
$("div").click(function(){
	var img=$(this).attr("img");
	if(img != undefined && img!=null){
		layer.open({
		  type: 1,
		  shade: false,
		  title: false, //不显示标题
		  area: ['60%', '60%'], //宽高
		  content:  '<img src="'+img+'" style="width:100%;"/>'
		});
	}
})
})
</script>
<style type="text/css">
body{word-break: break-all;}
</style>
	<form id="myform" method="post" action="{pigcms{:U('Invest/productCheck')}" >
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="120">ID</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $product_info['product_id'];  ?></div></td>
                		<th width="120">分类</th>
                		<td width="35%"><?php echo $product_info['classname']; ?></td>
			<tr/>
			<tr>
				<th style="width: 120px;">用户昵称</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $product_info['nickname']; ?></div></td>
				<th style="width: 120px;">联系电话</th>
				<td width="35%"><?php echo $product_info['sponsorPhone']; ?></td>
			</tr>
			<tr>
				<th width="120">自我介绍</th>
				<td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;"><?php echo $product_info['introduce']; ?></td>
			</tr>
			<tr>
				<th width="120">详细自我介绍</th>
				<td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;"><?php echo $product_info['sponsorDetails']; ?></td>
			</tr>
			<tr>
				<th width="120">微博/博客地址</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $product_info['weiBo']; ?></div></td>
				<th width="120">收款人或收款公司名称</th>
				<td width="35%"><?php echo $product_info['holderName']; ?></td>
			</tr>
			<tr>
				<th width="120">收款银行</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $bankNo_info[$product_info['bankNo']].$product_info['directBranch']; ?></div></td>
				<th width="120">银行卡号</th>
				<td width="35%"><?php echo $product_info['cardNo']; ?></td>
			</tr>
			<tr>
				<th width="120">联行号</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $product_info['bankCode']; ?></div></td>
				<th width="120">项目标签</th>
				<td width="35%">
				<?php
				$label=!empty($product_info['label']) ? explode(',', $product_info['label']) : array();
				foreach ($label as $k => $v) {
					$html.=$product_laber[$v].',';
				}
				$html=substr_replace($html, '', '-1');
				echo $html;
				?>
				</td>
			</tr>
			<tr>
				<th width="120">项目名称</th>
				<td width="35%"><?php echo $product_info['productName']; ?></td>
				<th width="120">项目类型</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $product_info['raiseType']==1 ? '回报众筹' : '公益捐助众筹'; ?></div></td>
			</tr>
			<tr>
				<th width="120">一句话说明</th>
				<td width="35%"><?php echo $product_info['productAdWord']; ?></td>
				<th width="120">筹资天数</th>
				<td width="35%"><?php echo $product_info['collectDays']==0 ? '无上限' : $product_info['collectDays'].'天'; ?></td>
			</tr>
			<?php if($product_info['collectDays']!=0){ ?>
			<tr>
				<th width="120">筹资金额</th>
				<td width="35%">不少于<?php echo $product_info['amount']; ?></td>
				<th width="120">筹资上限</th>
				<td width="35%">
				<div style="height:24px;line-height:24px;">
				<?php  echo !empty($product_info['toplimit']) ? '不少于'.$product_info['toplimit'].'%' : '无上限';  ?>
				</div>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<th width="120">预热图片</th>
				<td width="35%"><div img="<?php echo getAttachmentUrl($product_info['productThumImage']); ?>" style="height:44px;line-height:24px;color: green;"><?php echo getAttachmentUrl($product_info['productThumImage']);  ?></div></td>
				<th width="120">列表页图片</th>
				<td width="35%">
				<div img="<?php   echo getAttachmentUrl($product_info['productListImg']);      ?>" style="height:44px;line-height:24px;color: green;">
				<?php   echo getAttachmentUrl($product_info['productListImg']);      ?>
				</div>
				</td>
			</tr>
			<tr>
				<th width="120">首页图片</th>
				<td width="35%"><div img="<?php echo getAttachmentUrl($product_info['productFirstImg']);  ?>" style="height:44px;line-height:24px;color: green;"><?php echo getAttachmentUrl($product_info['productFirstImg']);   ?></div></td>
				<th width="120">项目图片</th>
				<td width="35%"><div img="<?php   echo getAttachmentUrl($product_info['productImage']);  	?>" style="height:44px;line-height:24px;color: green;">
				<?php   echo getAttachmentUrl($product_info['productImage']);  	?>
				</div></td>
			</tr>
			<tr>
				<th width="120">移动端图片</th>
				<td width="35%"><div img="<?php echo getAttachmentUrl($product_info['productImageMobile']);  ?>" style="height:44px;line-height:24px;color: green;">
				<?php echo getAttachmentUrl($product_info['productImageMobile']);  ?>
				</div></td>
				<th width="120">视频介绍</th>
				<td width="35%"><div style="height:24px;line-height:24px;">
				<?php   echo 	$product_info['videoAddr'];	?>
				</div></td>
			</tr>
			<tr>
				<th width="120">项目简介</th>
				<td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;"><?php echo $product_info['productSummary']; ?></td>
			</tr>
			<tr>
				<th width="120">申请时间</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo date('Y-m-d H:i:s',$product_info['time']); ?></div></td>
			</tr>
			<tr>
				<th width="120">项目详情</th>
				<td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;    word-break: break-all;"><?php echo $product_info['productDetails']; ?></td>
			</tr>
		</table>
		<input type="hidden" name="product_id" value="<?php echo $product_info['product_id'];  ?>"/>
		<div style="margin-left: 30%;">
			<div style="width: 40%;">
			<input type="submit" name="isTrue"  value="通过" class="button" />
			<input type="submit" name="isFalse" value="不通过" class="button" />
			</div>
		</div>
	</form>
<include file="Public:footer"/>
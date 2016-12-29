<div class="table-order-list">
	<?php if(!empty($order_list)){ ?>
	<?php foreach($order_list as $value){ ?>
	<div class="order-item" data-id="<?php echo $value['orderid'];?>">
		<div class="order-wechat">
			<div class="wechat-img">
				<img src="<?php echo $value['avatar'];?>">
			</div>
			<div class="wechat-nickname"><?php echo $value['nickname'];?></div>
		</div>
		<div class="order-info">
			<?php $etime=date('H',$value['dd_time'])+$value['sc'];?>
			<ul>
				<li>
					<label>姓名：</label>
					<span><?php echo $value['name'];?></span>
				</li>
				<li>
					<label>手机：</label>
					<span><?php echo $value['phone'];?></span>
				</li>
				<li>
					<label>茶桌：</label>
					<span><?php echo $value['tablename'];?></span>
				</li>
				<li>
					<label>到店时间：</label>
					<span><?php echo date('m-d H', $value['dd_time']); ?>:00</span>
				</li>
				<li>
					<label>使用时长：</label>
					<span><?php echo $value['sc'];?>小时</span>
				</li>
			</ul>
		</div>
		<div class="order-status"><?php echo $value['status'];?></div>
		<div class="order-edit"><a href="<?php echo dourl('meal:order_edit'); ?>&physical_id=<?php echo $value['physical_id'];?>&order_id=<?php echo $value['order_id'];?>" class="edit">编辑</a></div>
		<!-- <div class="order-edit"><a href="<?php echo dourl('meal:order_del'); ?>&physical_id=<?php echo $value['physical_id'];?>&order_id=<?php echo $value['order_id'];?>" class="delete">删除</a></div> -->
	</div>
	<?php } ?>
	<?php }else{ ?>
	<span class="no-result" style="display:block">没有找到相关记录</span>
	<?php } ?>
</div>
<?php
if ($pages) {
	?>
		<div class="pagenavi js-present_list_page" id="pages">
			<span class="total"><?php echo $pages ?></span>
		</div>
	<?php
}
?>

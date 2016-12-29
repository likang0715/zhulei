<div class="widget-list notice_switch_main">
	<!-- ▼ App card -->
	<div id="app-card" class="app-card">
		<div class="app-card-inner">
			<h3>通知开关</h3>
			<div>
				<p>通知开关功能可以让您根据自己店铺的实际情况，自由的开启和关闭订单通知，其中包括用户通知和商家通知。</p>
			</div>
		</div>
	</div>
	<!-- ▲ App card -->
	<?php if($_SESSION['user']['smscount']<100){?>
	<div id="app-tips" class="app-tips">
		<div class="app-tips-inner">
			温馨提示：您的短信仅剩<?php echo $_SESSION['user']['smscount'];?> 条啦，赶快去充值吧！<a href="<?php dourl('setting:notice');?>#notice_sms/0&layer=open" style="color: #07d;">立即充值</a>
		</div>
	</div>
	<? }?>
	<!-- ▼ Fourth Header -->
	<div id="fourth-header" class="fourth-header unselect">
		<div class="fourth-header-menu notice-switch-menu">
			<ul class="fourth-header-inner fourth-header-wrapper">
				<li class="active fourth-header-silde" data-msg="text"><a href="javascript:;">短信开关</a></li>
				<!-- <li class="fourth-header-silde" data-msg="voice"><a href="javascript:;"></a></li> -->
			</ul>
		</div>
	</div>
	<!-- ▲ Fourth Header -->
	<div class="ui-box">
		<?php if (count($total_config) > 0) { ?>
		<div class="notice_box js-notice-form">
			<?php foreach($notice_manage as $k=>$v) { ?>
			<div class="notice_item notice_item_<?php echo $v['id'];?>">
				<div class="notice_item_box">
					<h4><?php echo $v['name'];?></h4>
					<div class="notice_status">
						<input checked="checked" style="display:none" type="checkbox" class="checks0" name="<?php echo $v[id]?>" value="0">
						<input <?php if($store_notice_manage['has_power_arr'][$v['id']]) {if(in_array(1,$store_notice_manage['has_power_arr'][$v['id']])) {?> checked="checked" <?php }}?> type="checkbox" class="checks1 label_input" data-class="sms_status" id="sms_<?php echo $v[id]?>"  name="<?php echo $v[id]?>" value="1">
						<!-- <input <?php if($store_notice_manage['has_power_arr'][$v['id']]) {if(in_array(2,$store_notice_manage['has_power_arr'][$v['id']])) {?> checked="checked" <?php }}?>  type="checkbox" class="checks2 label_input" data-class="wechat_status" id="wechat_<?php echo $v[id]?>" name="<?php echo $v[id]?>" value="2">-->
						<!-- <a class="notice_setting_btn" href="javascript:;">设置</a> -->
					</div>
					<div class="notice_text">
						<p class="notice_text_box">(<?php echo $v['text'];?>)</p>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php }else{ ?>
		<span class="no-result" style="text-align:center;display:block">抱歉，您暂时不能使用该功能</span>
		<?php } ?>
	</div>
	<div class="js-list-footer-region ui-box"></div>
</div>

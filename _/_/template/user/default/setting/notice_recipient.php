<div class="widget-list notice_switch_main">
	<!-- ▼ App card -->
	<div id="app-card" class="app-card">
		<div class="app-card-inner">
			<h3>接收人设置</h3>
			<div>
				<p>接收人设置功能可以让您将不同的系统通知分配到不同的负责人，以快速处理用户的订单和预订等信息。</p>
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
				<li class="active fourth-header-silde" data-msg="sms"><a href="javascript:;">短信接收人</a></li>
				<!-- <li class="fourth-header-silde" data-msg="wechat"><a href="javascript:;"></a></li> -->
			</ul>
		</div>
	</div>
	<!-- ▲ Fourth Header -->
	<div class="ui-box">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label">
					<em class="required">*</em>
					店铺通知：
				</label>
				<div class="controls-box">
					<div class="controls fl">
						<input type="text" name="name_shop" placeholder="请输入姓名" value="<?php echo $people_shop['name'];?>" maxlength="11">
					</div>
					<div class="controls fl">
						<input type="text" name="mobile_shop" placeholder="请输入手机号" value="<?php echo $people_shop['mobile'];?>" maxlength="11">
					</div>
				</div>
				<p class="tips">该联系人负责接收<b>店铺和商品订单</b>等相关短信通知信息</p>
			</div>
			<hr>
			<div class="control-group">
				<label class="control-label">
					<em class="required">*</em>
					茶会通知：
				</label>
				<div class="controls-box">
					<div class="controls fl">
						<input type="text" name="name_enents" placeholder="请输入姓名" value="<?php echo $people_events['name'];?>" maxlength="11">
					</div>
					<div class="controls fl">
						<input type="text" name="mobile_enents" placeholder="请输入手机号" value="<?php echo $people_events['mobile'];?>" maxlength="11">
					</div>
				</div>
				<p class="tips">该联系人负责接收<b>茶会报名</b>等相关短信通知信息</p>
			</div>
			<hr>
			<div class="control-group">
				<label class="control-label">
					<em class="required">*</em>
					订座通知：
				</label>
				<?php if(!empty($store_physical)){ ?>
				<div class="controls-box">
					<?php foreach($store_physical as $value){ ?>
					<div class="controls mb16">
						<input type="text" class="js-input-tip js-store-tel" data-id="<?php echo $value['pigcms_id'];?>" placeholder="<?php echo $value['name'];?>接收人手机号" value="<?php echo $value['mobile'];?>" maxlength="11">
						<span class="input_tip<?php if(!$value['mobile']) echo " hide" ;?>"><?php echo $value['name'];?></span>
					</div>
					<?php } ?>
				</div>
				<p class="tips">该号码将用于接收对应门店<b>订座</b>等相关短信通知信息</p>
				<?php }else{ ?>
				<div class="controls">
					<span class="text">您还没有线下门店哦，<a href="<?php dourl('setting:store');?>#physical_store">去新建</a></span>
				</div>
				<?php } ?>
			</div>
			<div class="form-actions" style="margin-top:50px">
				<button type="button" class="ui-btn ui-btn-primary js-recipient-submit" data-text-loading="保存中...">保存</button>
			</div>
		</form>
	</div>
	<div class="js-list-footer-region ui-box"></div>
</div>

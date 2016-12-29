<style type="text/css">
	/* 本页样式reset */
	.app__content .form-actions { padding: 10px; }
	.widget-app-board-info { position: relative; }
	.pull-left { float: left; }
	.pull-right { float: right; }
	.ui-nav, .ui-nav2 { border: none; }
	.ui-nav li.active a { font-size: 16px; line-height: 40px; }
	.ui-nav-table li.active a { border-color: #ccc; }
	.widget-app-board { border: 1px solid rgba(255,255,255, 0.6); background-color: rgba(255,255,255, 0.6); }
	.check-on { border: 1px solid #6af; }
	.c-blue { color: #07d }
	.c-grey { color: #ccc; }
	.c-red { color: #f33; }
	.ui-input { width: 80px; }
	.ui-sep { border-right: 1px dashed #ccc;float: left;height: 30px;margin-left: 20px }
	.ui-sep:after { content: " "; }
	.ui-tip { float: left; color: #999; padding: 6px 0 0 20px; }
	.app-inner { padding-bottom: 20px; }
	.section-form .ui-nav { margin: 0; }
	.section-form .ui-box { margin: 0; }
	.app-actions { position: fixed; bottom: 0; width: 850px; padding-top: 20px; clear: both; text-align: center; z-index: 2; }
</style>
<div class="points-section">
<form class="section-form" onsubmit="return false;">

	<fieldset>

		<div class="ui-nav">
			<ul>
				<li class="js-app-nav auto active">
					<a href="#">订单提醒设置</a>
				</li>
			</ul>
		</div>

		<div class="widget-app-board ui-box">

			<div class="widget-app-board-info">
				<div class="clearfix">
					<div class="pull-left">
						<b class="c-blue">每次提示最长停留时间</b> <input type="text" name="order_notice_time" class="ui-input" value="<?php echo $store['order_notice_time'] ?>"> <b class="c-blue">秒</b><br>
						<b class="c-red">*默认取24小时内最新的一条已支付订单</b><br>
					</div>
				</div>
			</div>
			<!-- 积分兑换开关 -->
			<div class="widget-app-board-control limit">
				<label class="js-switch ui-switch pull-right js-shop-notice <?php if ($store['order_notice_open']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
			</div>

		</div>

	</fieldset>

	<div class="app-actions">
		<div class="form-actions">
			<input class="btn js-btn-notice-quit" type="button" value="取 消">
			<input class="btn btn-primary js-btn-notice" type="submit" value="保 存" data-loading-text="保 存...">
	    </div>
    </div>

</form>
</div>
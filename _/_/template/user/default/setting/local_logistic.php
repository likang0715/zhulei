<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="js-logistics">
    <div class="js-logistics-board">
		<div class="widget-app-board ui-box">
			<div class="widget-app-board-info">
				<h3>开启本地物流</h3>
				<div>
					<p>
						此物流需要设置门店、门店管理员、创建并绑定配送员。<br />
						<span style="color:red">当开启功能，将会允许使用您门店自建的配送系统发货。</span>
					</p>
				</div>
			</div>
			<div class="widget-app-board-control">
				<label class="js-switch js-local_logistic-status ui-switch <?php if ($store['open_local_logistics']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?> right"></label>
			</div>
		</div>
	</div>
</div>
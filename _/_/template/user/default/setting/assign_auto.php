<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="js-logistics">
    <div class="js-logistics-board">
		<div class="widget-app-board ui-box">
			<div class="widget-app-board-info">
				<h3>订单自动分配</h3>
				<div>
					<p>
						启用订单自动分配功能后，用户的货单会自动分配到拥有库存的最近门店仓库<br />
						<span style="color:red">当关闭此功能，需要主店铺手动分配货单。(某货品在所有门店都没有库存，则整个订单不会被分配)</span>
					</p>
				</div>
			</div>
			<div class="widget-app-board-control">
				<label class="js-switch js-auto_order-status ui-switch <?php if ($store['open_autoassign']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?> right"></label>
			</div>
		</div>
	</div>
</div>
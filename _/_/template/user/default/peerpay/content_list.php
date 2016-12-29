<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="widget-list">
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<a class="ui-btn ui-btn-primary js-fetchtxt-add">新建</a>
		</div>
	</div>
</div>

<div class="ui-box">
	<table class="ui-table ui-table-list" style="padding:0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr>
				<th class="cell-15">发起人的求助</th>
				<th class="cell-25 text-right">操作</th>
			</tr>
		</thead>
		<tbody class="js-list-body-region">
			<?php
			foreach($store_pay_agent_list as $store_pay_agent) {
			?>
				<tr class="js-peerpay_fetchtxt-detail js-id-<?php echo $store_pay_agent['agent_id'] ?>" data-id="<?php echo $store_pay_agent['agent_id'] ?>">
					<td><?php echo htmlspecialchars($store_pay_agent['content']) ?></td>
					<td class="text-right js-operate" data-id="<?php echo $store_pay_agent['agent_id'] ?>">
						<a href="javascript:void(0)" class="js-edit">编辑资料</a>
						<span>-</span>
						<a href="javascript:void(0);" class="js-delete">删除</a>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	<?php
	if(empty($store_pay_agent_list)) {
	?>
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关数据。</div>
			</div>
		</div>
	<?php
	}
	?>
</div>

<div class="js-list-footer-region ui-box"></div>
<!-- ▼ Main container -->
<style type="text/css">
.user_avatar { width: 50px; height: 50px; border-radius: 50%; border: 5px solid #fff; }
</style>

<div class="widget-list">
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<a href="javascript:void(0)" class="ui-btn ui-btn-primary js-back-btn">返回列表</a>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if ($yuser_list) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">序号</th>
					<th class="cell-15">用户</th>
					<th class="cell-25">手机号</th>
					<th class="cell-25">参与时间</th>
					<th class="cell-25">是否领取优惠</th>
					<th class="cell-15">领取的优惠劵</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php foreach($yuser_list as $val) { ?>
					<tr class="js-present-detail">
						<td><?php echo $val['id'] ?></td>
						<td>
							<img src="<?php echo getAttachmentUrl($val['avatar']); ?>" class="user_avatar">
							<br>
							<?php echo $val['name'] ?>
						</td>
						<td><?php echo $val['phone'] ?></td>
						<td><?php echo date('Y-m-d H:i:s', $val['addtime']) ?></td>
						<td><?php echo ($val['did'] == 1) ? '是' : '否'; ?></td>
						<td class="text-right">
						<?php if ($val['coupon']) {
							echo '面值'.$val['coupon']['face_money'].'元劵';
						} ?>
						</td>
					</tr>
				<?php } ?>
				<?php if ($page) { ?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="7">
								<div class="pagenavi js-order_page"><?php echo $page ?></div>
							</td>
						</tr>
					</thead>
				<?php } ?>
			</tbody>
		</table>
	<?php } else { ?>
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关数据。</div>
			</div>
		</div>
	<?php } ?>
</div>
<div class="js-list-footer-region ui-box"></div>
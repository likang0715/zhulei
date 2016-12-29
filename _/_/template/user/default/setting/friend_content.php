<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="js-friend">
    <div class="js-friend-board">
		<div class="widget-app-board ui-box">
			<div class="widget-app-board-info">
				<h3>送朋友功能</h3>
				<div>
					<p>
						启用送朋友功能后，用户下订单可以通过物流方式将产品配送给朋友，此功能受物流配送是否开启影响。<br />
						<span style="color:red">用户选择“送朋友”功能后，是不能使用货到付款功能</span>
					</p>
				</div>
			</div>
			<div class="widget-app-board-control">
				<label class="js-switch js-friend-status ui-switch <?php if ($store['open_friend']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?> right"></label>
			</div>
		</div>
	</div>
	
	<div class="js-selffetch-list">
		<div class="ui-box">
			<div class="ui-btn ui-btn-success"><a href="#friend/add" class="js-friend-address">新增公益地址</a></div>
		</div>
		<?php 
		if (!empty($commonweal_address_list)) {
		?>
			<table class="ui-table ui-table-list physical_list">
				<thead class="js-list-header-region tableFloatingHeaderOriginal">
					<tr class="widget-list-header">
						<th>收货人姓名</th>
						<th>联系地址</th>
						<th>联系电话</th>
						<th>是否默认</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody class="js-list-body-region">
					<?php 
					foreach ($commonweal_address_list as $commonweal_address) {
					?>
						<tr class="widget-list-item">
							<td><?php echo $commonweal_address['name'];?></td>
							<td><?php echo $commonweal_address['province_txt'] . $commonweal_address['city_txt'] . $commonweal_address['area_txt'] . $commonweal_address['address'];?></td>
							<td><?php echo $commonweal_address['tel'] ?></td>
							<td><?php echo $commonweal_address['default'] ? '是' : '否' ?></td>
							<td class="dianpu">
								<a href="#friend/edit/<?php echo $commonweal_address['id'] ?>" class="js-address-edit">编辑</a>
								<a href="javascript:" class="js-delete-edit" data-id="<?php echo $commonweal_address['id'];?>">删除</a>
							</td>

						</tr>
					<?php 
					}
					?>
				</tbody>
			</table>
		<?php 
		}else{
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
</div>
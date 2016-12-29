<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<input type="hidden" name="status" value="<?php echo $_REQUEST['status'] ?>" />
<input type="hidden" name="group_id" value="<?php echo $_REQUEST['group_id'] ?>" />
<div class="modal-header">
	<a class="close js-news-modal-dismiss">×</a>
	<!-- 顶部tab -->
	<ul class="module-nav modal-tab">
		<li class="<?php echo $_REQUEST['status'] == 1 ? 'active' : '' ?>"><a href="javascript:" class="js-modal-tab" data-status="1">出售中商品列表</a> |</li>
		<li class="<?php echo $_REQUEST['status'] == 2 ? 'active' : '' ?>"><a href="javascript:" class="js-modal-tab" data-status="2">仓库中商品列表</a> |</li>
		<li class="active">
			<select class="js-product_group" style="margin: 0px;">
				<option value="">请选择商品分组</option>
				<?php 
				foreach ($product_group_list as $product_group) {
					$selected = '';
					if ($_REQUEST['group_id'] == $product_group['group_id']) {
						$selected = 'selected="selected"';
					}
				?>
					<option value="<?php echo $product_group['group_id'] ?>" <?php echo $selected ?>><?php echo htmlspecialchars($product_group['group_name']) ?></option>
				<?php 
				}
				?>
			</select>
		</li>
	</ul>
</div>
<div class="modal-body">
	<div class="tab-content">
		<div id="js-module-feature" class="tab-pane module-feature active">
			<?php if($is_system){ ?>
			<div style="font-size:12px;margin-bottom:15px;">您登录了管理员帐号，已显示网站所有列表。（如需只显示该店铺，请在后台退出后再点击下方的“刷新”按钮。<a href="./admin.php" target="_blank" style="color:blue;">后台链接</a>）</div>
			<?php } ?>
			<table class="table">
				<colgroup>
					<col class="modal-col-title">
					<col class="modal-col-time" span="2">
					<col class="modal-col-action">
				</colgroup>
				<!-- 表格头部 -->
				<thead>
					<tr>
						<th class="title" style="background-color:#f5f5f5;">
							<div class="td-cont">
								<span>标题</span> <a class="js-update" href="javascript:window.location.reload();"></a>
							</div>
						</th>
						<th class="time" style="background-color:#f5f5f5;">
							<div class="td-cont">
								<span>价格</span>
							</div>
						</th>
						<th class="time" style="background-color:#f5f5f5;">
							<div class="td-cont">
								<span>购买数量</span>
							</div>
						</th>
						<th class="opts" style="background-color:#f5f5f5;">
							<div class="td-cont" style="padding:7px 0 3px 10px;">
								<form class="form-search" onsubmit="return false;">
									<div class="input-append">
										<input class="input-small js-modal-search-input" type="text" style="border-radius:4px 0px 0px 4px;" value="<?php echo htmlspecialchars($_REQUEST['keyword'])?>" /><a href="javascript:void(0);" class="btn js-fetch-page js-modal-search" style="color:white;border-radius:0 4px 4px 0;margin-left:0px;">搜</a>
									</div>
								</form>
							</div>
						</th>
					</tr>
				</thead>
				<!-- 表格数据区 -->
				<?php 
				foreach($product_list as $product) {
				?>
					<tr>
						<td class="title" style="max-width:300px;">
							<div class="td-cont">
								<a target="_blank" class="new_window" href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>"><?php echo $product['name']; ?></a>
							</div>
						</td>
						<td class="time">
							<div class="td-cont">
								<?php 
								if (empty($product['sku_list'])) {
								?>
									<input type="text" class="js-price" value="<?php echo $product['price'] ?>" old-value="<?php echo $product['price'] ?>" style="width:50px;" title="原价：<?php echo $product['origin_price'] ?>" />
								<?php 
								} else {
									echo $product['price'];
								}
								?>
							</div>
						</td>
						<td class="time">
							<div class="td-cont">
								<?php 
								if (empty($product['sku_list'])) {
								?>
									<input type="text" name="number" class="js-number" value="1" style="width:50px;" old-value="1" max-value="<?php echo $product['quantity'] ?>" />
									库存数：<?php echo $product['quantity'] ?>
								<?php 
								}
								?>
							</div>
						</td>
						<td class="opts">
							<div class="td-cont">
								<?php 
								if ($product['sku_list']) {
								?>
									<button class="js-open" data-id="<?php echo $product['product_id'];?>">展开</button>
								<?php 
								} else {
								?>
									<button class="btn js-choose" data-id="<?php echo $product['product_id'];?>" data-image="<?php echo $product['image'] ?>" data-title="<?php echo $product['name']; ?>" data-sku_id="" data-sku_data="" data-url="<?php echo $product['link'] ?>" data-price="<?php echo $product['price'] ?>">选取</button>
								<?php 
								}
								?>
							</div>
						</td>
					</tr>
					<?php 
					if ($product['sku_list']) {
					?>
						<tbody class="js-product-<?php echo $product['product_id'] ?>" style="display: none;">
							<?php 
							foreach ($product['sku_list'] as $sku) {
								$sku_arr = explode(';', $sku['properties']);
							?>
								<tr>
									<td class="title" style="max-width:300px;">
										&#12288;&#12288;规格：
										<?php 
										$sku_str = '';
										foreach ($sku_arr as $sku_tmp) {
											list($pid, $vid) = explode(':', $sku_tmp);
											echo '&#12288;' . $pid_list[$pid]['name'] . ':' . $vid_list[$vid]['value'];
											$sku_str .= '&#12288;' . $pid_list[$pid]['name'] . ':' . $vid_list[$vid]['value'];
										}
										?>
									</td>
									<td>
										<input type="text" class="js-price" value="<?php echo $sku['price'] ?>" old-value="<?php echo $sku['price'] ?>" style="width:50px;" title="原价：<?php echo $sku['origin_price'] ?>" />
									</td>
									<td class="time">
										<input type="text" name="number" class="js-number" value="1" style="width:50px;" old-value="1" max-value="<?php echo $sku['quantity'] ?>" />
										库存数：<?php echo $sku['quantity'] ?>
									</td>
									<td class="opts">
										<div class="td-cont">
											<button class="btn js-choose" data-id="<?php echo $product['product_id'];?>" data-image="<?php echo $product['image'] ?>" data-title="<?php echo $product['name']; ?>" data-sku_id="<?php echo $sku['sku_id'] ?>" data-sku_data="<?php echo $sku_str ?>" data-url="<?php echo $product['link'] ?>" data-price="<?php echo $sku['price'] ?>">选取</button>
										</div>
									</td>
								</tr>
							<?php 
							}
							?>
						</tbody>
				<?php 
					}
				}
				?>
			</table>
		</div>
	</div>
</div>
<div class="modal-footer">
	<div style="display:none; float:left;" class="js-confirm-choose pull-left">
		<input type="button" class="btn btn-primary" value="确定使用">
	</div>
	<div class="pagenavi js-page-list" style="margin-top:0;"><?php echo $page; ?></div>
</div>
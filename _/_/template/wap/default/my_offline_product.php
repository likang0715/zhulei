<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<section class="selectshop-list">
	<?php 
	if (!empty($product_list)) {
	?>
		<ul>
			<?php 
			foreach ($product_list as $product) {
			?>
				<li class="standard" data-name="<?php echo htmlspecialchars($product['name']) ?>" data-image="<?php echo $product['image'] ?>" data-product_id="<?php echo $product['product_id'] ?>">
					<div class="selectshop-list-con fl">
						<div class="selectshop-list-con-mar">
							<div class="selectshop-list-con-tit"><?php echo htmlspecialchars($product['name']) ?></div>
							<div class="orange selectshop-list-con-tit-price">￥<?php echo $product['price'] ?></div>
							<?php 
							if ($product['sku_list']) {
							?>
								<div class="pricecalculator standard-standard fl">
									选择规格
								</div>
							<?php 
							} else {
							?>
								<div class="pricecalculator fl js-product-price">
									<div class="pricecalculator-subtract fl pricecalculator-btn js-pricecalculator_reduce">-</div>
									<input class="fl pricecalculator-inp" type="text" value="1" readonly data-max_value="<?php echo $product['quantity'] ?>" />
									<div class="fl pricecalculator-add pricecalculator-btn js-pricecalculator_add">+</div>
									<div class="clear"></div>
								</div>
							<?php 
							}
							?>
						</div>
					</div>
					<div class="selectshop-list-left fl"><img src="<?php echo $product['image'] ?>" alt=""></div>
					<!-- 现在是没有选中状态，如果要选中状态将 select-no 改成 icon-ok-sign -->
					<?php 
					if (empty($product['sku_list'])) {
					?>
						<div class="selectshop-list-right fr select-no js-select_product_detail" data-price="<?php echo $product['price'] ?>" data-sku_id="0" data-sku_data=""></div>
					<?php 
					}
					?>
					<div class="clear"></div>
					<?php 
					if ($product['sku_list']) {
						foreach ($product['sku_list'] as $sku) {
							$sku_arr = explode(';', $sku['properties']);
					?>
							<div class="select-pric">
								<div class="fl class select-pric-left">
									<div>
										<?php 
										$sku_str = '';
										foreach ($sku_arr as $sku_tmp) {
											list($pid, $vid) = explode(':', $sku_tmp);
											echo '<span>' . $pid_list[$pid]['name'] . ':' . $vid_list[$vid]['value'] . '</span>';
											$sku_str .= '&nbsp;' . $pid_list[$pid]['name'] . ':' . $vid_list[$vid]['value'];
										}
										?>
									</div>
									<div class="pricecalculator pricecalculator-price fl js-product-price">
										<div class="pricecalculator-subtract fl pricecalculator-btn js-pricecalculator_reduce">-</div>
										<input class="fl pricecalculator-inp" type="text" value="1" readonly data-max_value="<?php echo $sku['quantity'] ?>" />
										<div class="fl pricecalculator-add pricecalculator-btn js-pricecalculator_add" >+</div>
										<div class="clear"></div>
									</div>
									<div class="orange fl selectshop-list-con-tit-price select-price">￥<?php echo $sku['price'] ?></div>
								</div>
								<!--！！！！！！！！！！！！-->
								<!-- 现在是选中状态，如果要变成未选中状态将 icon-ok-sign 改成 select-no -->
								<div class="select-no fr select-pric-right js-select_product_detail" data-price="<?php echo $sku['price'] ?>" data-sku_id="<?php echo $sku['sku_id'] ?>" data-sku_data="<?php echo $sku_str ?>"></div>
								<div class="clear"></div>
							</div>
					<?php 
						}
					}
					?>
				</li>
			<?php 
			}
			?>
		</ul>
	<?php 
	} else {
	?>
		<div style="margin: 10px auto; text-align: center;">
			暂无商品
		</div>
	<?php 
	}
	?>
</section>
<?php 
if ($p > 1 || $p < $max_page) {
?>
	<div class="select-page">
		<span class="fl js-page <?php echo $p > 1 ? '' : 'nopage' ?>" data-page="<?php echo $p - 1 ?>">上一页</span>
		<!-- nopage为不可用状态 -->
		<span class="fl js-page <?php echo $p < $max_page ? '' : 'nopage' ?>" data-page="<?php echo $p + 1 ?>">下一页</span>
		<div class="clear"></div>
	</div>
<?php 
}
?>
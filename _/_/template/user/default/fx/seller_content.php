<style type="text/css">
    .red {
        color:red;
    }
    .control-label {
        width: 90px;
        font-size: 12px;
    }
    .date-quick-pick {
        display: inline-block;
        color: #07d;
        cursor: pointer;
        padding: 2px 4px;
        border: 1px solid transparent;
        margin-left: 0px;
        border-radius: 4px;
    }
    input, textarea, .uneditable-input {
         width: 100px;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <!--<div class="widget-list-filter" style="border-bottom: 2px solid #DADADA;">
            <div class="filter-box">
                <div class="js-list-search">
                    审核状态：
                    <select class="fx-approve js-search-drp-approv" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="0">全部</option>
                        <option value="1">已审核</option>
                        <option value="2">未审核</option>
                    </select>
                    分销商等级：
                    <select class="fx-drp-level js-search-drp-leve" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="0">全部</option>
                        <?php /*if($max_level>=1) {*/?>
                            <?php /*for($levels = 1; $levels <=$max_level; $levels++){*/?>
                                <option value="<?php /*echo $levels; */?>"><?php /*echo $levels; */?>级分销商</option>
                            <?php /*}*/?>
                        <?php /*}*/?>
                    </select>

                </div>
            </div>
        </div>-->

        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                    分销商等级：
                    <select class="js-search-drp-level" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="*">全部</option>
                        <?php if($max_level>=1) {?>
                            <?php for($levels = 1; $levels <=$max_level; $levels++){?>
                                <option value="<?php echo $levels; ?>"><?php echo $levels; ?>级分销商</option>
                            <?php }?>
                        <?php }?>
                    </select>
                    推广级别：
                    <select class="js-search-drp-degree" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="*">全部</option>
                        <?php if(!empty($drp_degree_list)) {?>
                        <?php foreach($drp_degree_list as $d){?>
                        <option value="<?php echo $d['is_platform_degree_name']?>"><?php echo $d['name']?></option>
                        <?php }?>
                        <?php }?>
                    </select>
                    分销商名称：<input style="width:70px;" class="filter-box-search js-search js-fx-seller" type="text" placeholder="分销商名称" />&nbsp;&nbsp;

                    团队名称：<input style="width:70px;" class="filter-box-team filter-box-search js-search" type="text" placeholder="团队名称" />&nbsp;&nbsp;
                    审核状态：
                    <select class="js-search-drp-approve" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="*">全部</option>
                        <option value="0">未审核</option>
                        <option value="1">已审核</option>
                    </select>
                        <!--<span class="controls" style="margin-top:-33px;float:right;">
                            入驻时间：
                            <input type="text" name="start_time" value="" class="js-start-time" id="js-start-time" width="20px"/>
                            <span>至</span>
                            <input type="text" name="end_time" value="" class="js-end-time" id="js-end-time" width="20px"/>
                            <span class="date-quick-pick" data-days="7">最近7天</span>
                            <span class="date-quick-pick" data-days="30">最近30天</span>
                        </span>-->

                    <input style="margin-top:10px;" type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                    <input type="button" class="ui-btn ui-btn-primary js-dump-btn" value="分销商导出">
                </div>
            </div>
        </div>
    </div>

    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($sellers)) { ?>
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <tr class="widget-list-header">
                <th>LOGO</th>
				<th>分销店铺</th>
                <th>所属团队</th>
                <th style="text-align: center">推广级别</th>
                <th>联系电话</th>
                <th>状态</th>
                <th style="text-align: right">未对账佣金(元)</th>
                <th style="text-align: right">未对账订单</th>
                <th style="text-align: center">操作</th>
            </tr>
            </thead>
            <tbody class="js-list-body-region">
            <?php foreach ($sellers as $seller) { ?>
            <tr class="widget-list-item">
                <td class="goods-image-td">
                    <div class="goods-image">
                        <a href="<?php echo trim(option('config.wap_site_url'),'/'); ?>/home.php?id=<?php echo $seller['fx_store_id']; ?>" target="_blank">
                            <img src="<?php echo $seller['store_logo']; ?>" />
                        </a>
                    </div>
                </td>
                <td class="goods-meta">
				    <a class="new-window" href="<?php echo trim(option('config.wap_site_url'),'/'); ?>/home.php?id=<?php echo $seller['fx_store_id']; ?>" target="_blank">
						<?php echo $seller['store_name']; ?>
                    </a>
                    <br /><span style="color: orange"><?php echo $seller['drp_level']; ?>&nbsp;级分销商</span>
                </td>
                <td>
					<?php echo $seller['team_name']; ?>
                </td>
                <td>
                    <?php echo $seller['degree_name']; ?>
                </td>

                <td>
                    <?php echo $seller['tel']; ?>
                </td>
                <td>
                    <?php if ($seller['store_status'] == 5) { ?><span style="color:gray">已禁用</span><?php } else if (!empty($seller['drp_approve'])) { ?><span style="color:green">已审核</span><?php } else { ?><span style="color:red">未审核</span><?php } ?>
                </td>

                <td style="text-align: right">
                    <a href="<?php dourl('order:fx_bill_check', array('store_id' => $seller['fx_store_id'])); ?>"><?php echo $seller['uncheck_profit']; ?></a>
                </td>
                <td style="text-align: right">
                    <a href="<?php dourl('order:fx_bill_check', array('store_id' => $seller['fx_store_id'])); ?>"><?php echo $seller['uncheck_order']; ?></a>
                </td>
                <td style="text-align: center">
                    <?php if (!empty($seller['drp_approve'])) { ?>
                        <span class="gray" style="cursor: no-drop">审核</span>
                    <?php } else { ?>
                        <a href="javascript:;" class="js-drp-approve" data-id="<?php echo $seller['fx_store_id']; ?>">审核</a>
                    <?php } ?>
                    <span>-</span>
                    <a href="javascript:;" class="<?php if ($seller['store_status'] == 1) { ?>js-drp-disabled<?php } else if ($seller['store_status'] == 5) { ?>js-drp-enabled<?php } ?>" data-id="<?php echo $seller['fx_store_id']; ?>"><?php if ($seller['store_status'] == 1) { ?>禁用<?php } else if ($seller['store_status'] == 5) { ?>启用<?php } ?></a>
                    <a href="<?php dourl('my_seller_detail', array('store_id' => $seller['fx_store_id']));?>" class="js-drp-pprove" id="js-drp-approve" >层级关系</a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($sellers)) { ?>
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <input type="hidden" data-is="<?php echo $level;?>" class="page-is">
            <div class="js-page-list pagenavi ui-box"><?php echo $page; ?></div>
        </div>
    </div>
</div>


<style type="text/css">
	.platform-tag {
		display: inline-block;
		vertical-align: middle;
		padding: 3px 7px 3px 7px;
		background-color: #f60;
		color: #fff;
		font-size: 12px;
		line-height: 14px;
		border-radius: 2px;
	}
	.control-action {
		padding-top: 5px;
	}


 	.popover-inner {
		padding: 3px;
		width: 320px;
		overflow: hidden;
		background: #000000;
		background: rgba(0, 0, 0, 0.8);
		border-radius: 4px;
		-webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
		box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
	}
	.popover.bottom .arrow {
		/* left: 50%; */
		margin-left: 105px;
		border-left: 5px solid transparent;
		border-right: 5px solid transparent;
		border-bottom: 5px solid #000000;
	}
	.popover.bottom .arrow:after {
		top: 1px;
		border-bottom-color: #ffffff;
		border-top-width: 0;
	}
	.team-opt-wrapper .block-help>a:hover {
		background: #4b0;
		color:#fff
	}


	.block-help>a {
	  display: inline-block;
	  width: 16px;
	  height: 16px;
	  line-height: 18px;
	  border-radius: 8px;
	  font-size: 12px;
	  text-align: center;
	  background: #bbb;
	  color: #fff;
	}
	.block-help>a:after {
	  content: "?";
	}
	.hide{display:none}
	.bgcolor{
		background-color: lightblue;
	}
	.ui-table-order .content-row {
		border-bottom: 1px solid lightblue;
	}
	.order-no {
		color:#FF6600;
	}
	.cost-price {
		color:red;
	}
	.profit {
		color: green;
	}
</style>
<?php 
$config_order_return_date = option('config.order_return_date');
$config_order_complete_date = option('config.order_complete_date');
$version  = option('config.weidian_version');
if (!empty($orders)) {
?>
	<table class="ui-table-order">
		<thead class="js-list-header-region tableFloatingHeaderOriginal"><tr><th class="" colspan="2">商品</th>
			<th class="price-cell">单价/数量</th>
			<th class="aftermarket-cell">售后</th>
			<th class="customer-cell">买家</th>
			<th class="time-cell">
				<a href="javascript:;" class="orderby orderby_add_time" data-orderby="add_time">下单时间<span class="orderby-arrow desc"></span></a>
			</th>
			<th class="state-cell">
				订单状态
				<span class="block-help">
					<a href="javascript:void(0);" class="js-help-notes"></a>
					<div class="js-notes-cont hide">
						<p><strong>1.</strong>客户点击确认收货后，订单7天后可交易完成！</p>
						<p><strong>2.</strong>客户未点击确认收货，订单按沉淀期15天（默认）后可交易完成！</p>
						<p><strong>3.</strong>如产生退货机制，将于退货机制完成后，确认订单！</p>
					</div>
				</span>
			</th>
			<th class="pay-price-cell"><a href="javascript:;" class="orderby orderby_total" data-orderby="total">实付金额</a></th>
		</tr>
		</thead>
		<?php foreach ($orders as $order) { ?>
			<tbody>
			<tr class="separation-row">
				<td colspan="8"></td>
			</tr>
			<tr class="header-row">
				<td colspan="6">
					
					
						<div style="width:30px;display:inline-block;height:100%">&#12288;<input value="<?php echo $order['order_id'];?>" class="order_check" type="checkbox"></div>
						<div style="display:inline-block;">
					<div>
					
						<b class="order-no">订单号: <?php echo $order['order_no']; ?></b>
						<?php 
						if ($order['payment_method'] == 'codpay') {
						?>
							<span>支付方式 ：货到付款</span>
						<?php 
						} else if ($order['payment_method'] == 'peerpay') {
						?>
							<span>支付方式 ：找人代付</span>
						<?php
						}
						?>
						<div class="help" style="display:inline-block;">
							<span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;"><?php if (array_key_exists($order['payment_method'], $payment_method)) { ?><?php echo $payment_method[$order['payment_method']]; ?><?php } ?></span>
							<div class="js-notes-cont hide">
								该订单通过代销服务完成交易，请进入“收入/提现”页面，“微信支付”栏目查看收入或提现
							</div>
						</div>
						<?php if ($order['type'] == 3) { ?>
							<span class="platform-tag">分销</span>
							<span class="c-gray">
							订单来源：<?php echo $order['seller']; ?>
						</span>
						<?php } else if ($order['type'] == 5) { ?>
						<span class="platform-tag" style="background-color:#07d">批发</span>
							<span class="c-gray">
							订单来源：<?php echo $order['seller']; ?>
						<?php } ?>
					</div>
					<div class="clearfix">
						<?php if (!empty($order['trade_no'])) { ?>
						<div style="margin-top: 4px;margin-right: 20px;" class="pull-left">
							外部订单号: <span class="c-gray"><?php echo $order['trade_no']; ?></span>
						</div>
						<?php } ?>
						<?php if (!empty($order['third_id'])) { ?>
						<div style="margin-top: 4px;" class="pull-left">
							支付流水号: <span class="c-gray"><?php echo $order['third_id']; ?></span>
						</div>
						<?php } ?>
					</div>
					
					</div>
				</td>
				<td colspan="2" class="text-right">
					<div class="order-opts-container">
						<div class="js-memo-star-container memo-star-container"><div class="opts">
								<div class="td-cont message-opts">
									<div class="m-opts">
										<a href="<?php dourl('detail', array('id' => $order['order_id'])); ?>" class="js-order-detail new-window" target="_blank">查看详情</a>
										<span>-</span>
										<a class="js-memo-it" rel="popover" href="javascript:;" data-bak="<?php echo $order['bak']; ?>" data-id="<?php echo $order['order_id']; ?>">备注</a>
										<span>-</span>
										<?php if (empty($order['star'])) { ?>
										<a class="js-stared-it" href="javascript:;">加星</a>
										<?php } else { ?>
										<span class="js-stared-it stared"><img src="<?php echo TPL_URL; ?>/images/star-on.png"> x <?php echo $order['star']; ?></span>
										<?php } ?>
									</div>
									<div id="raty-action-<?php echo $order['order_id']; ?>" class="raty-action" style="display: none; cursor: pointer;">
										<img src="<?php echo TPL_URL;?>images/cancel-custom-off.png" data-id="<?php echo $order['order_id']; ?>" alt="x" title="去星" class="raty-cancel" />&nbsp;
										<img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="1" title="一星" />
										<img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="2" title="二星" />
										<img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="3" title="三星" />
										<img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="4" title="四星" />
										<img src="<?php echo TPL_URL;?>images/star-off.png" data-id="<?php echo $order['order_id']; ?>" class="star" alt="5" title="五星" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>

			<?php foreach ($order['products'] as $key => $product) {?>
				<tr class="content-row">
					<td class="image-cell">
						<img src="<?php echo $product['image']; ?>" />
					</td>
					<td class="title-cell">
						<p class="goods-title">
							<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>&store_id=<?php echo $order['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
								<?php echo $product['name']; ?>
							</a>
						</p>
						<p>
							<?php $skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; ?>
							<?php if ($skus) { ?>
								<?php foreach ($skus as $sku) { ?>
									<span class="goods-sku"><?php echo $sku['value']; ?></span>
								<?php } ?>
							<?php } ?>
							<?php if ($product['is_fx']) { ?><span class="platform-tag">分销</span><?php } ?>
						</p>
						<p>商品来源：<?php echo $product['from']; ?></p>
					</td>
					<td class="price-cell">
						<p><?php echo $product['pro_price']; ?></p>
						<p>(<?php echo $product['pro_num']; ?>件)</p>
						<?php if (!empty($order['is_fx']) || !empty($order['fx_order_id']) || !empty($order['user_order_id'])) { ?>
						<p class="cost-price">成本价：<?php echo $product['cost_price']; ?></p>
						<p class="profit">利润：<?php echo $product['profit']; ?></p>
						<?php } ?>
					</td>
					<td class="aftermarket-cell">
						<?php 
						if ($product['return_status'] > 0) {
						?>
							<p><a href="javascript:" class="js-return_order" data-order_no="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" data-pigcms_id="<?php echo $product['pigcms_id'] ?>">查看退货</a></p>
						<?php 
						}
						if ($product['rights_status'] > 0) {
						?>
							<p><a href="javascript:" class="js-rights_order" data-order_no="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" data-pigcms_id="<?php echo $product['pigcms_id'] ?>">售后维权</a></p>
						<?php 
						}
						?>
					</td>
					<?php if (count($order['products']) > 0 && $key == 0) { ?>
					<td class="customer-cell" rowspan="<?php echo count($order['products']); ?>">
						<?php if (empty($order['is_fans'])) { ?>
							<p>非粉丝</p>
						<?php } else if (!empty($order['address_user'])) { ?>
							<p class="user-name"><?php echo $order['address_user']; ?></p>
							<?php echo $order['address_tel']; ?>
						<?php } else { ?>
							<p><?php echo $order['buyer']; ?></p>
						<?php } ?>
					</td>
					<td class="time-cell" rowspan="<?php echo count($order['products']); ?>">
						<div class="td-cont">
							<?php echo date('Y-m-d H:i:s', $order['add_time']); ?>
						</div>
					</td>
					<td class="state-cell" rowspan="<?php echo count($order['products']); ?>">
						<div class="td-cont">
							<p class="js-order-state">
								<?php 
								if ($order['shipping_method'] == 'selffetch' && $order['status'] <= 2) {
									$address = unserialize($order['address']);
									echo '门店：' . $address['name'];
								} else {
									echo $order_status[$order['status']];
								}
								?>
							</p>
							<?php
							if (in_array($order['status'], array(0, 1))) {
							?>
								<p>
									<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-cancel-order">取消订单</a>
								</p>
							<?php
							}
							if ($order['is_supplier']) {
								if ($order['status'] == 2) {
									if ($order['shipping_method'] == 'selffetch') {
							?>
										<p>
											<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-selffetch-order" style="padding:4px 7px;">
												已<?php echo $_SESSION['store']['buyer_selffetch_name'] ? $_SESSION['store']['buyer_selffetch_name'] : '自提'?>
											</a>
										</p>
							<?php
									} else {
							?>
										<?php if (empty($order['is_packaged'])) { ?>
											<?php if($user_session['type'] == 1 && $is_local_logistic == 1) { ?>
											<!-- 门店管理员 -->
											<p class="testFunc">
												<?php if ($order['send_couriered']) { ?>
												<a href="javascript:;" class="btn btn-small" style="background-color: #bbb;cursor: no-drop">分配完毕</a>
												<?php } else { ?>
												<a href="javascript:;" class="btn btn-small js-express-phy-goods js-express-goods-<?php echo $order['order_id']; ?>" data-id="<?php echo $order['order_id']; ?>">分配配送</a>
												<?php } ?>
											</p>
											<?php } else { ?>
											<!-- 店主 -->
											<p>
												<a href="javascript:;" class="btn btn-small js-express-goods js-express-goods-<?php echo $order['order_id']; ?>" data-id="<?php echo $order['order_id']; ?>">发&nbsp;&nbsp;货</a>
											</p>
											<?php } ?>
										
											<!-- 货到付款/到店自提 禁止配送 -->
											<?php if ($order['payment_method'] != 'codpay' && $order['shipping_method'] != 'selffetch' && $is_local_logistic == 1) { ?>
												<?php if($user_session['type']==0 && in_array($order['is_assigned'], array(0, 1))) { ?>
												<p  class="testFunc">
	                                                <?php if(empty($version)){?>
													<a href="javascript:;" class="btn btn-small js-assign-physical" data-id="<?php echo $order['order_id']; ?>">分配门店</a>
	                                                <?php } ?>
												</p>
												<?php } else if ($user_session['type']==0 && !in_array($order['is_assigned'], array(0, 1))) { ?>
												<p  class="testFunc">
	                                                <?php if(empty($version)){?>
	                                                <a href="javascript:;" class="btn btn-small" style="background-color: #bbb;cursor: no-drop">分配完毕</a>
													<?php } ?>
												</p>
												<?php } ?>
											<?php } ?>

										<?php } ?>
										<?php
										if ($order['payment_method'] == 'codpay') {
										?>
											<p>
												<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-cancel-order">取消订单</a>
											</p>
										<?php
										}
										?>
							<?php
									}
								}
								// 货到付款，发货后，再收货前都可以取消订单
								if ($order['payment_method'] == 'codpay' && $order['status'] == 3) {
							?>
									<p>
										<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-cancel-order">取消订单</a>
									</p>
							<?php 
								}
								if ((($order['status'] == 7 && ($order['delivery_time'] + $config_order_return_date * 24 * 3600 < time() || $order['sent_time'] + $config_order_complete_date * 24 * 3600 < time())) || ($order['status'] == 3 && $order['sent_time'] + $config_order_complete_date * 24 * 3600 < time())) && $order['returning_count'] == 0) {
							?>
									<p>
										<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-complate-order">交易完成</a>
									</p>
							<?php
								} else if ($order['status'] == 3 && $order['sent_time'] + 15 * 24 * 3600 >= time()) {
							?>
									<p>
										<a href="javascript:;" class="btn btn-small" style="background-color: #bbb;cursor: no-drop">等待收货</a>
									</p>
							<?php
								} else if (($order['status'] == 7 && ($order['delivery_time'] + $config_order_return_date * 24 * 3600 > time() || $order['sent_time'] + $config_order_complete_date * 24 * 3600 > time())) || ($order['status'] == 3 && $order['sent_time'] + $config_order_complete_date * 24 * 3600 > time()) || $order['returning_count'] != 0) {
							?>
									<p>
										<a href="javascript:;" class="btn btn-small js-complater" disabled="disabled">交易完成</a>
									</p>
							<?php
								}
								if ($order['status'] == 6) {
							?>
									<p>
										<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-complate-order">交易完成</a>
									</p>
							<?php
								}
							}
							if ($order['shipping_method'] == 'friend') {
								echo '<span style="color:red">送朋友订单</span>';
							}
							?>
			<script>	
				var t2 = '';
				var t0 = '';
				 $('.js-help-notes').hover(function(){
					var content = $(this).next('.js-notes-cont').html();
					$('.popover-help-notes').remove();
					var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left-40) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + content + '</div></div></div>';
					$('body').append(html);
					$('.popover-help-notes').show();
				}, function(){
				t2 = setTimeout('hide2()', 200);
				})		
				$('.popover-help-notes').live('hover', function(event){
					if (event.type == 'mouseenter') {
						clearTimeout(t2);
					} else {
						clearTimeout(t2);
						hide2();
					}
				})
				function hide() {
					$('.popover-intro').remove();
				}
				function hide2() {
					$('.popover-help-notes').remove();
				}
				function msg_hide() {
					$('.notifications').html('');
					clearTimeout(t0);
				}	
			</script>						
						</div>
					</td>
					<td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
						<div class="td-cont text-center">
							<div>
								<p>
									<span class="order-total"><?php echo $order['total'] > 0 ? $order['total'] : $order['sub_total'] ?></span>
								</p>
								<p>
									<span class="c-gray">(含运费: <?php echo $order['postage']; ?>)</span>
								</p>
								<?php if (empty($order['is_fx'])) { ?>
								<?php  if ($order['status'] == 0 || $order['status'] == 1) { ?>
								<p>
								<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="js-change-price js-change-price-<?php echo $order['order_id']; ?>">修改价格</a>
								</p>
								<?php } ?>
								<?php } ?>
								<?php if (!empty($order['is_fx']) || !empty($order['fx_order_id']) || !empty($order['user_order_id'])) { ?>
								<p class="cost-price">成本：<?php echo $order['cost']; ?></p>
								<p class="profit">利润：<?php echo $order['profit']; ?></p>
								<p class="commission-detail"><a href="<?php dourl('fx:commission_detail', array('id' => $order['order_id'])); ?>">分润明细</a></p>
								<?php } ?>
							</div>
						</div>
					</td>
					<?php } ?>
				</tr>
			<?php } ?>
			<?php if ($order['bak'] != '') { ?>
				<tr class="remark-row">
					<td colspan="8">卖家备注：<?php echo $order['bak']; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		<?php } ?>
	</table>
<?php } ?>
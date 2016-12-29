<style type="text/css">
    .platform-tag { display: inline-block; vertical-align: middle; padding: 3px 7px 3px 7px; background-color: #f60; color: #fff; font-size: 12px; line-height: 14px; border-radius: 2px; }

    .control-action { padding-top: 5px; }

    /* 活动标签样式 */
    .activity-tag { display: inline-block; vertical-align: middle; padding: 3px 7px 3px 7px; background-color: #18bb73; color: #fff; font-size: 12px; line-height: 14px; border-radius: 2px 0 0 2px; position: relative; }
    .activity-tag:after { content: ''; border-top: 10px solid #18bb73; border-bottom: 10px solid #18bb73; border-left: 10px solid #18bb73; border-right: 10px solid transparent; position: absolute; top: 0px; right: -15px; }

    .activity-tag.bargain { background-color: #0C3E72; }
    .activity-tag.bargain:after { border-color: #0C3E72 transparent #0C3E72 #0C3E72; }

    .activity-tag.tuan { background-color:#fe5842 }
    .activity-tag.tuan:after { border-color: #fe5842 transparent #fe5842 #fe5842; }

    .activity-tag.presale { background-color:#FD7400 }
    .activity-tag.presale:after { border-color: #FD7400 transparent #FD7400 #FD7400; }

    .activity-tag.seckill { background-color:#D980BD }
    .activity-tag.seckill:after { border-color: #D980BD transparent #D980BD #D980BD; }

    .activity-tag.crowdfunding { background-color:#F5BE61 }
    .activity-tag.crowdfunding:after { border-color: #F5BE61 transparent #F5BE61 #F5BE61; }

    .activity-tag.unitary { background-color:#B743B3 }
    .activity-tag.unitary:after { border-color: #B743B3 transparent #B743B3 #B743B3; }

    .activity-tag.cutprice { background-color:#E71B1C }
    .activity-tag.cutprice:after { border-color: #E71B1C transparent #E71B1C #E71B1C; }

    .activity-tag.lottery { background-color:#18BB73 }
    .activity-tag.lottery:after { border-color: #18BB73 transparent #18BB73 #18BB73; }

    .activity-tag.shakelottery { background-color:#07814b }
    .activity-tag.shakelottery:after { border-color: #07814b transparent #07814b #07814b; }

    .activity-tag.helping { background-color:#009adb }
    .activity-tag.helping:after { border-color: #009adb transparent #009adb #009adb; }

    .popover-inner { padding: 3px; width: 320px; overflow: hidden; background: #000000; background: rgba(0, 0, 0, 0.8); border-radius: 4px; -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3); box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3); }
    .popover.bottom .arrow { /* left: 50%; */ margin-left: 105px; border-left: 5px solid transparent; border-right: 5px solid transparent; border-bottom: 5px solid #000000; }
    .popover.bottom .arrow:after { top: 1px; border-bottom-color: #ffffff; border-top-width: 0; }
    .team-opt-wrapper .block-help > a:hover { background: #4b0; color: #fff }
    .block-help > a { display: inline-block; width: 16px; height: 16px; line-height: 18px; border-radius: 8px; font-size: 12px; text-align: center; background: #bbb; color: #fff; }
    .block-help > a:after { content: "?"; }
    .hide { display: none }
    .bgcolor { background-color: lightblue; }
    .ui-table-order .content-row { border-bottom: 1px solid lightblue; }
    .order-no { color: #FF6600; }
    .cost-price { color: red; }
    .profit { color: green; }
    .return { color: gray; }
    .del-line { color: gray; text-decoration: line-through; }
    .return-info { color: red; }
    .sale-price { color: black; }

</style>
<?php
$config_order_return_date = option('config.order_return_date');
$config_order_complete_date = option('config.order_complete_date');
$version = option('config.weidian_version');

$product_debug = array();
$product_debug['product_id'] = 0;
$product_debug['name'] = '手工做单虚拟商品';
$product_debug['image'] = getAttachmentUrl('images/default_shop.png', true);
$product_debug['pro_price'] = 0;
$product_debug['pro_num'] = 1;
$product_debug['supplier_id'] = 0;
$product_debug['wholesale_product_id'] = 0;
$product_debug['from'] = '手工做单虚拟商品';
if (!empty($orders)) {
    ?>
    <table class="ui-table-order">
        <thead class="js-list-header-region tableFloatingHeaderOriginal">
        <tr>
            <th class="" colspan="2">商品</th>
            <th class="price-cell">单价/数量</th>
            <th class="aftermarket-cell">售后</th>
            <th class="customer-cell">买家/收货</th>
            <th class="time-cell">
                <a href="javascript:;" class="orderby orderby_add_time" data-orderby="add_time">下单时间<span
                        class="orderby-arrow desc"></span></a>
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


                    <div style="width:30px;display:inline-block;height:100%">&#12288;<input
                            value="<?php echo $order['order_id']; ?>" class="order_check" type="checkbox"></div>
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
							<span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;">
								<?php if ($order['use_deposit_pay']) { ?>保证金支付<?php } else if (array_key_exists($order['payment_method'], $payment_method)) { ?><?php echo $payment_method[$order['payment_method']]; ?><?php } ?>
							</span>
							<div class="js-notes-cont hide">
                                <?php echo $order['marketed_channel']; ?>
                            </div>
                            <?php 
                            if ($order['is_offline'] == 1 && empty($order['offline_type'])) {
                            ?>
								<span class="js-help-notes" style="cursor: help;">
                            		用户线下订单
                            	</span>
                            	<div class="js-notes-cont hide">
                            		店铺后台下的订单，使用用户的平台积分
                            	</div>
                             <?php 
                             } else if ($order['is_offline'] == 1 && $order['offline_type'] == 1) {
                             ?>
                             	<span class="js-help-notes " style="cursor: help;">
                            		店铺线下订单
                            	</span>
                            	<div class="js-notes-cont hide">
                            		店铺后台下的订单，使用店铺的平台积分
                            	</div>
                            <?php 
                            }
                            ?>
							<b>
                                <?php
                                if ($order['shipping_method'] == 'send_other') {
                                    echo '送他人订单';
                                }
                                if ($order['type'] == 6) {
                                	echo '团购订单';
                                } else if ($order['type'] == 7) {
                                	echo '<span class="platform-tag">预售订单';
									if($order['presale_order_id'] != $order['order_id']) {
										echo "(定金支付)";
									} else {
										echo "(尾款支付)";
									}
									echo "</span>";
                                }
                                ?>
							</b>
                                
                            </div>
                            <?php if ($order['type'] == 3 && empty($order['is_ws'])) { ?>
                                <span class="platform-tag">分销</span>
                                <span class="c-gray">
							订单来源：<?php echo $order['seller']; ?>
						    </span>
                            <?php } else if ($order['type'] == 5) { ?>
                            <span class="platform-tag" style="background-color:#07d">批发</span>
							<span class="c-gray">
							订单来源：<?php echo $order['seller']; ?></span>
                            <?php } ?>

                            <!-- 新活动订单标识 -->
                            <?php if ($order['type'] >= 50) { ?>
                                <?php echo M('Activity')->getOrderTag($order['type']); ?>
                            <?php } ?>
                        </div>
                        
						
						<div class="clearfix">
							<?php if ($order['type'] == 7) { ?>
								<?php if($order['presale_order_id'] && ($order['presale_order_id'] != $order['order_id'])) {?>
								<div style="margin-top: 4px;margin-right: 20px;" class="pull-left">
									<b>尾款支付订单号: <span class="c-gray"><?php echo $order['pre_order_no']; ?></span></b>
								</div>
								<?php }?>
							<?php } ?>
						</div>

                        <div class="clearfix">
                            <?php if (!empty($order['trade_no'])) { ?>
                                <div style="margin-top: 4px;margin-right: 20px;" class="pull-left">
                                    交易号: <span class="c-gray"><?php echo $order['trade_no']; ?></span>
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
                        <div class="js-memo-star-container memo-star-container">
                            <div class="opts">
                                <div class="td-cont message-opts">
                                    <div class="m-opts">
                                        <a href="<?php dourl('detail', array('id' => $order['order_id'])); ?>"
                                           class="js-order-detail new-window" target="_blank">查看详情</a>
                                        <span>-</span>
                                        <a class="js-memo-it" rel="popover" href="javascript:;"
                                           data-bak="<?php echo $order['bak']; ?>"
                                           data-id="<?php echo $order['order_id']; ?>">备注</a>
                                        <span>-</span>
                                        <?php if (empty($order['star'])) { ?>
                                            <a class="js-stared-it" href="javascript:;">加星</a>
                                        <?php } else { ?>
                                            <span class="js-stared-it stared"><img
                                                    src="<?php echo TPL_URL; ?>/images/star-on.png"> x <?php echo $order['star']; ?></span>
                                        <?php } ?>
                                    </div>
                                    <div id="raty-action-<?php echo $order['order_id']; ?>" class="raty-action"
                                         style="display: none; cursor: pointer;">
                                        <img src="<?php echo TPL_URL; ?>images/cancel-custom-off.png"
                                             data-id="<?php echo $order['order_id']; ?>" alt="x" title="去星"
                                             class="raty-cancel"/>&nbsp;
                                        <img src="<?php echo TPL_URL; ?>images/star-off.png"
                                             data-id="<?php echo $order['order_id']; ?>" class="star" alt="1"
                                             title="一星"/>
                                        <img src="<?php echo TPL_URL; ?>images/star-off.png"
                                             data-id="<?php echo $order['order_id']; ?>" class="star" alt="2"
                                             title="二星"/>
                                        <img src="<?php echo TPL_URL; ?>images/star-off.png"
                                             data-id="<?php echo $order['order_id']; ?>" class="star" alt="3"
                                             title="三星"/>
                                        <img src="<?php echo TPL_URL; ?>images/star-off.png"
                                             data-id="<?php echo $order['order_id']; ?>" class="star" alt="4"
                                             title="四星"/>
                                        <img src="<?php echo TPL_URL; ?>images/star-off.png"
                                             data-id="<?php echo $order['order_id']; ?>" class="star" alt="5"
                                             title="五星"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($order['drp_team'])) { ?>
                    <div class="drp-team" style="padding: 5px;margin-top: 5px;">
                        &nbsp;&nbsp;&nbsp;
                        <span class="c-gray" style="display: inline-block">所属团队：<a href="<?php dourl('fx:my_team_detail', array('id' => $order['drp_team_id'])); ?>"><?php echo $order['drp_team']; ?></a></span>
                    </div>
                    <?php } ?>
                </td>
            </tr>

            <?php 
            if ($order['is_offline'] && empty($order['products'])) {
            	$product_debug['pro_price'] = $order['sub_total'];
            	$order['products'][] = $product_debug;
            }
            foreach ($order['products'] as $key => $product) { ?>
                <tr class="content-row">
                    <td class="image-cell">
                        <img src="<?php echo $product['image']; ?>"/>
                    </td>
                    <td class="title-cell">
                        <p class="goods-title">
                        	<?php 
                        	if ($product['product_id']) {
                        	?>
                            <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>&store_id=<?php echo $order['store_id']; ?>"
                               target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                                <?php echo $product['name']; ?>
                            </a>
                            <?php 
                        	} else {
                        		echo $product['name'];
                        	}
                            ?>
                        </p>

                        <p>
                            <?php $skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; ?>
                            <?php if ($skus) { ?>
                                <?php foreach ($skus as $sku) { ?>
                                    <span class="goods-sku"><?php echo $sku['value']; ?></span>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($product['is_fx']) { ?><span
                                class="platform-tag">分销</span><?php } else if ($product['is_ws']) { ?><span
                                class="platform-tag" style="background-color:#07d">批发</span><?php } ?>
                        </p>

                        <p>商品来源：<?php echo $product['from']; ?></p>
                        <?php if ($product['subscribed_discount'] > 0) { ?>
                        <p style="color: green">关注店铺公众号享 <?php echo $product['subscribed_discount']; ?> 折优惠
                        <?php } ?>
                    </td>
                    <td class="price-cell">
                        <p><?php echo $product['pro_price']; ?></p>

                        <p>(<?php echo $product['pro_num']; ?>件)</p>
                        <?php if (!in_array($order['status'], array(0, 1, 5))) { ?>
                            <?php if (!empty($order['is_fx']) || !empty($order['fx_order_id']) || !empty($order['user_order_id'])) { ?>
                                <?php if (!empty($product['supplier_id']) || ($product['store_id'] != $_SESSION['store']['store_id'])) { ?>
                                    <p class="cost-price">成本价：<?php echo $product['cost_price']; ?></p>
                                <?php } ?>
                                <p class="profit <?php if ($product['return_status'] == 2) { ?>del-line<?php } ?>">
                                    利润：<?php echo $product['profit']; ?></p>
                                <?php if (!empty($product['sale_price'])) { ?>
                                    <p class="sale-price">零售价：<?php echo $product['sale_price']; ?></p>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <td class="aftermarket-cell">
                        <?php
                        if ($product['return_status'] > 0) {
                        ?>
                            <p>
                                <a href="javascript:" class="js-return_order" data-order_no="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" data-pigcms_id="<?php echo $product['pigcms_id'] ?>">查看退货</a>
                                <p class="return-info">
                                <?php if (!empty($product['return_status'])) { ?>
                                    买<?php echo $product['pro_num']; ?>件，退<?php echo $product['return_quantity']; ?>件
                                <?php } ?>
                                </p>
                            </p>
                        <?php
                        }
                        if ($product['rights_status'] > 0) {
                            ?>
                            <p><a href="javascript:" class="js-rights_order"
                                  data-order_no="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>"
                                  data-pigcms_id="<?php echo $product['pigcms_id'] ?>">售后维权</a></p>
                            <?php
                        }
                        ?>
                    </td>
                    <?php if (count($order['products']) > 0 && $key == 0) { ?>
                        <td class="customer-cell" rowspan="<?php echo count($order['products']); ?>">
                            <?php if (!empty($order['buyer'])) { ?>
                            <p><?php echo $order['buyer']; ?></p>
                            <?php } ?>
                            <?php if (!empty($order['address_user'])) { ?>
                                <p class="user-name"><?php echo $order['address_user']; ?></p>
                                <?php echo $order['address_tel']; ?>
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
                                        if ($order['type'] != 5) {
                                            echo $order_status[$order['status']];
                                        } else {
                                            echo $ws_alias_status[$order['status']];
                                        }
                                    }
                                    ?>
                                </p>
                                <?php
                                if (in_array($order['status'], array(0, 1)) && $order['type'] != 5) {
                                    ?>
                                    <p>
                                        <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>"
                                           class="btn btn-small js-cancel-order">取消订单</a>
                                    </p>
                                    <?php
                                }
                                if ($order['is_supplier']) {
                                    if ($order['status'] == 2) {
                                        if ($order['shipping_method'] == 'selffetch') {
                                        	if ($order['type'] == 6 && !$tuan_list[$order['data_id']]) {
                                        	?>
                                        		团购未结束
                                        	<?php 
                                        	} else {
                                            ?>
                                            <p>
                                                <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>"
                                                   class="btn btn-small js-selffetch-order" style="padding:4px 7px;">
                                                    已<?php echo $_SESSION['store']['buyer_selffetch_name'] ? $_SESSION['store']['buyer_selffetch_name'] : '自提' ?>
                                                </a>
                                            </p>
                                            <?php
                                        	}
                                        } else {
                                            ?>
                                            <?php if (empty($order['is_packaged'])) { ?>
											
                                                <?php if ($is_local_logistic == 1 && $user_session['type'] == 1) { ?>

                                                    <!-- 门店管理员 -->
                                                    <p>
                                                        <?php if ($order['send_couriered']) { ?>
                                                            <a href="javascript:;" class="btn btn-small"
                                                               style="background-color: #bbb;cursor: no-drop">分配完毕</a>
                                                        <?php } else if ($is_substore) { ?>
                                                            <a href="javascript:;"
                                                               class="btn btn-small js-express-phy-goods js-express-goods-<?php echo $order['order_id']; ?>"
                                                               data-id="<?php echo $order['order_id']; ?>">分配配送</a>
                                                        <?php } ?>
                                                    </p>
                                                <?php 
                                            	} else {
                                            		// 团购订单是否出现发货按钮
                                            		if (($order['type'] == 6 && $tuan_list[$order['data_id']]) || $order['type'] != 6) {
                                            	?>
                                                    <!-- 店主 -->
                                                    <p>
                                                        <a href="javascript:;"
                                                           class="btn btn-small js-express-goods js-express-goods-<?php echo $order['order_id']; ?>"
                                                           data-id="<?php echo $order['order_id']; ?>"
                                                           data-type="send_other">发&nbsp;&nbsp;货</a>
                                                    </p>
                                                <?php 
                                            		} else if ($order['type'] == 6 && !$tuan_list[$order['data_id']]) {
                                            	?>
                                            			<p>团购未结束</p>
                                            	<?php 
                                            		}
                                            	}
                                            	?>

                                                <!-- 货到付款/到店自提 禁止配送 -->
                                                <?php if ($order['shipping_method'] != 'send_other' && $order['payment_method'] != 'codpay' && $order['shipping_method'] != 'selffetch' && $is_local_logistic == 1) { ?>
                                                    <?php if ($user_session['type'] == 0 && in_array($order['is_assigned'], array(0, 1))) { ?>
                                                        <p>
                                                            <?php if (empty($version)) { ?>
                                                                <a href="javascript:;"
                                                                   class="btn btn-small js-assign-physical"
                                                                   data-id="<?php echo $order['order_id']; ?>">分配门店</a>
                                                            <?php } ?>
                                                        </p>
                                                    <?php } else if ($user_session['type'] == 0 && !in_array($order['is_assigned'], array(0, 1))) { ?>
                                                        <p>
                                                            <?php if (empty($version)) { ?>
                                                                <a href="javascript:;" class="btn btn-small"
                                                                   style="background-color: #bbb;cursor: no-drop">分配完毕</a>
                                                            <?php } ?>
                                                        </p>
                                                    <?php } ?>
                                                <?php } ?>

                                            <?php } ?>

                                            <?php
                                        }
                                    }
                                    // 货到付款，发货后，再收货前都可以取消订单(修改：收货前都可以取消)
                                    if ($order['payment_method'] == 'codpay' && $order['status'] <= 3) {
                                        ?>
                                        <p>
                                            <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>"
                                               class="btn btn-small js-cancel-order">取消订单</a>
                                        </p>
                                        <?php
                                    }
                                    // 货到付款增加确认收款
                                    $codpay_status = true;
                                    if ($order['payment_method'] == 'codpay' && in_array($order['status'], array(3, 7)) && $order['receive_time'] == 0) {
                                        $codpay_status = false;
                                        ?>
                                        <p>
                                            <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>"
                                               class="btn btn-small js-receive-order">确认收款</a>
                                        </p>
                                        <?php
                                    }

                                    if ($codpay_status && (($order['status'] == 7 && ($order['delivery_time'] + $config_order_return_date * 24 * 3600 < time() || $order['sent_time'] + $config_order_complete_date * 24 * 3600 < time())) || ($order['status'] == 3 && $order['sent_time'] + $config_order_complete_date * 24 * 3600 < time())) && $order['returning_count'] == 0) {
                                        ?>
										
									
										<?php 
										//预售 第一个订单 不允操作
										if(($order['type'] == 7 && ($order['presale_order_id'] != $order['order_id'])) || ($order['is_offline'] == 1 && $order['offline_type'] == 1 && $order['offline_status'] != 1)) {
											if ($order['is_offline'] == 1 && $order['offline_type'] == 1 && $order['offline_status'] == 2) {
										?>
												<p>
													线下订单，审核不通过
												</p>
										<?php 
											} else if ($order['is_offline'] == 1 && $order['offline_type'] == 1 && $order['offline_status'] == 0) {
										?>
												<p>
													线下订单，等待审核
												</p>
										<?php 
											} else {
										?>
												<p>
		                                            <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small " disabled="disabled">交易完成</a>
		                                        </p>
										<?php 
												}
											} else {
										?>
                                        <p>
                                            <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-complate-order">交易完成</a>
                                        </p>
										<?php }?>
										
										
										
                                        <?php
                                    } else if ($order['status'] == 3 && $order['sent_time'] + 15 * 24 * 3600 >= time()) {
                                        ?>
                                        <p>
                                            <a href="javascript:;" class="btn btn-small"
                                               style="background-color: #bbb;cursor: no-drop">等待收货</a>
                                        </p>
                                        <?php
                                    } else if ($codpay_status && ($order['status'] == 7 && ($order['delivery_time'] + $config_order_return_date * 24 * 3600 > time() || $order['sent_time'] + $config_order_complete_date * 24 * 3600 > time())) || ($order['status'] == 3 && $order['sent_time'] + $config_order_complete_date * 24 * 3600 > time()) || $order['returning_count'] != 0) {
                                        ?>
                                        <p>
                                            <a href="javascript:;" class="btn btn-small js-complater"
                                               disabled="disabled">交易完成</a>
                                        </p>
                                        <?php
                                    }
                                    if ($order['status'] == 6) {
                                        ?>
                                        <p>
                                            <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>"
                                               class="btn btn-small js-complate-order">交易完成</a>
                                        </p>
                                        <?php
                                    }
                                }
                                if ($order['shipping_method'] == 'friend') {
                                    echo '<span style="color:red">送朋友订单</span>';
                                }
                                ?>
                                <script type="text/javascript">
                                    var t2 = '';
                                    var t0 = '';
                                    $('.js-help-notes').hover(function () {
                                        var content = $(this).next('.js-notes-cont').html();
                                        $('.popover-help-notes').remove();
                                        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left - 40) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + content + '</div></div></div>';
                                        $('body').append(html);
                                        $('.popover-help-notes').show();
                                    }, function () {
                                        t2 = setTimeout('hide2()', 200);
                                    })
                                    $('.popover-help-notes').live('hover', function (event) {
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

                                <?php if (!empty($order['not_paid_orders'])) { ?>
                                    <!--引导给供货商付款-->
                                    <p>
                                        批发欠款:<br/><span
                                            style="color: red;"><?php echo $order['not_paid_total']; ?></span><br/>
                                        <a href="<?php dourl('fx:my_order', array('id' => $order['order_id'])); ?>">我要付款</a>
                                    </p>
                                <?php } ?>
                                <?php if (!empty($order['bond_pay_orders'])) { ?>
                                    <p>
                                        <?php if ($order['bond_pay_total'] > 0) { ?>
                                        扣保证金:<br/><span style="color: green;"><?php echo $order['bond_pay_total']; ?></span><br/>
                                        <?php  } ?>
                                        <a href="<?php dourl('fx:my_order', array('id' => $order['order_id'])); ?>#<?php echo $order['status']; ?>">查看详细</a>
                                    </p>
                                <?php } ?>
                            </div>
                        </td>
                        <td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
                            <div class="td-cont text-center">
                                <div>
                                    <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
                                        <?php if ($order['type'] != 3) { ?>
                                        <p>
                                            <span class="order-total">订单总额：<br/><?php echo $order['status'] > 0 || $order['total'] > 0 ? ($order['total'] < 0 ? 0 : $order['total']) : $order['sub_total'] ?></span>
                                        </p>
                                        <?php } else { ?>
                                            <p>零售总额：<br/><?php echo $order['pay_money']; ?></p>
                                        <?php } ?>
                                        <?php 
                                        if ($order['cash_money'] > 0) {
                                        ?>
                                        <p>
                                            <span class="order-total">抵现<?php echo $point_alias; ?>: <br/><a href="<?php echo dourl('trade:point_details'); ?>#cash_point"><?php echo $order['cash_money'] ?></a></span>
                                        </p>
                                        <?php } ?>
                                        <p>
                                            <span class="c-gray">(含运费: <?php echo $order['postage']; ?>)</span>
                                        </p>
                                        
                                        <?php if(($order['type'] == 7) && ($order['presale_order_id'] == $order['order_id'])) {?>
                                        <span class="c-gray">(已去预售折扣: ￥<?php echo $order['data_money']; ?>)</span>
                                        <?php }?>
                                        
                                        <?php 
                                        if ($order['type'] == 6 && $order['data_money'] > 0) {
                                        	if ($order['status'] == 4) {
                                        ?>
                                        		<span style="color: green; font-weight: bold;">(已退<?php echo $order['data_money'] ?>)</span>
                                        <?php 
                                        	} else {
                                        ?>
                                        		<span style="color: red; font-weight: bold;">(需退<?php echo $order['data_money'] ?>)</span>
                                        <?php 
                                        	}
                                        }
                                        ?>
                                        <?php if (empty($order['is_fx'])) { ?>
                                            <?php if (($order['status'] == 0 || $order['status'] == 1) && $order['type'] != 5) { ?>
                                                <p>
                                                    <a href="javascript:;" data-id="<?php echo $order['order_id']; ?>"
                                                       class="js-change-price js-change-price-<?php echo $order['order_id']; ?>">修改价格</a>
                                                </p>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (!in_array($order['status'], array(0, 1, 5))) { ?>
                                        <?php if (!empty($order['is_fx']) || !empty($order['fx_order_id']) || !empty($order['user_order_id'])) { ?>
                                            <!--<p class="cost-price">成本：<?php /*echo $order['cost']; */ ?></p>-->
                                            <?php if ($order['return'] > 0) { ?>
                                                <p class="return">退货减：<?php echo $order['return']; ?></p>
                                            <?php } ?>
                                            <?php if ($order['profit'] >= 0) { ?>
                                            <p class="profit">利润：<?php echo $order['profit']; ?></p>
                                            <?php } else { ?>
                                            <p class="profit" style="color: red;">亏损：<?php echo number_format(abs($order['profit']), 2, '.', ''); ?></p>
                                            <?php } ?>
                                            <p class="commission-detail">
                                                <a href="<?php dourl('fx:commission_detail', array('id' => $order['order_id'])); ?>">分润明细</a>
                                            </p>
                                        <?php } ?>
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
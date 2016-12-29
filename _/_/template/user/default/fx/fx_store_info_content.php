<?php $uid = $_SESSION['store']['uid'];?>
<div class="goods-list">
<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
    <div class="widget-list-filter">

        
    </div>
    <div class="ui-box settlement-info">
        <?php if(!empty($store_info['is_required_margin'])) {?>
        <h3 style="background: #F2F2F2;height:23px;padding:5px;margin-bottom:2px;">
            <p style="color:orange;">批发本店商品需要批发商审核，并在审核通过后交纳<span style="color:#f00">￥<?php echo $store_info['bond']?>元</span>保证金方可批发。</p>
        </h3>
        <?php }?>
        <div class="account-info">
            <img class="logo" src="<?php if ($store_info['logo'] == '' || $store_info['logo'] == './upload/images/') { ?><?php echo TPL_URL; ?>/images/logo.png<?php } else { ?><?php echo $store_info['logo']; ?><?php } ?>" />
            <div class="account-info-meta">
                <div class="info-item">
                    <label>店铺名：</label>
                    <a href="<?php echo $store_info['url']?>" target="_blank"><?php echo $store_info['name']; ?></a>
                </div>
                <div class="info-item">
                    <label>联系人：</label>
                    <span><?php if (!empty($store_info['linkman'])) { ?><?php echo $store_info['linkman']; ?><?php } else { ?>未填写<?php } ?></span>
                </div>
                <div class="info-item">
                    <label>手机号：</label>
                    <span><?php if (!empty($store_info['tel'])) { ?><?php echo $store_info['tel']; ?><?php } else { ?>未填写<?php } ?></span>
                </div>

            </div>

            <div class="account-info-meta">
                <div class="info-item">
                    <label>认证状态：</label>
                    <span><?php if ($store_info['approve']==0) { ?>未认证<?php }else if($store_info['approve']==1){?><span style="color:green">已认证</span><?php } else { ?><span style="color:red">认证不通过</span><?php } ?></span>
                </div>
				
				<div class="info-item">
                    <label>店铺状态：</label>
                    <span><?php if ($store_info['status']==1) { ?>正常<?php }else if($store_info['status']==2){?><span style="color:green">待审核</span><?php }else if($store_info['status']==3){?><span style="color:green">审核未通过</span><?php }else if($store_info['status']==4){?><span style="color:green">用户关闭</span><?php } else { ?><span style="color:red">供货商关闭分销商</span><?php } ?></span>
                </div>
				
                <div class="info-item">
                    <label>主营类目：</label>
                    <span><?php echo $sale_cate_name; ?></span>
                </div>
                <div class="info-item">
                    <label>添加时间：</label>
                    <span><?php echo date('Y-m-d ', $store_info['date_added']); ?></span>
                </div>
            </div>
			
			<div class="account-info-meta">
			 <div class="info-item">
                    <label>开户　银行：</label>
                    <span><?php echo $bank_name?$bank_name:'未填写'; ?></span>
                </div>
                <div class="info-item">
                    <label>银行　卡号：</label>
                    <span><?php echo $store_info['bank_card']?$store_info['bank_card']:'未填写'; ?></span>
                </div>
                <div class="info-item">
                    <label>开卡人姓名：</label>
                   <span><?php echo $store_info['bank_card_user']?$store_info['bank_card_user']:'未填写'; ?></span>
                </div>
                <div class="info-item">
                    <label>开　户　行：</label>
                    <span><?php echo $store_info['opening_bank']?$store_info['opening_bank']:'未填写'; ?></span>
                </div>
				
            </div>

            <div style="clear:both"></div>
        </div>
		
		
		
        <div class="widget-head">
        
        </div>
        <div style="clear:both"></div>
        <h4 style="background: #F2F2F2;height:30px;padding:5px;margin-bottom:2px;">
            店铺简介：<?php echo $store_info['intro']; ?>
        </h4>
    </div>
</div>
<div class="ui-box">
<table class="ui-table ui-table-list" style="padding: 0px;">
<?php if (!empty($products)) { ?>
<thead class="js-list-header-region tableFloatingHeaderOriginal">
<tr class="widget-list-header">
    <th class="checkbox cell-35" colspan="3">
        <label class="checkbox inline">
            <input type="checkbox" class="js-check-all">
            商品
        </label>
    </th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_price">批发价</a></th>
    <th class="cell-10 text-right">建议零售价</th>
    <th class="cell-10 text-right">利润</th>
    <th class="cell-8 text-right"><a href="javascript:;" data-orderby="stock_num">库存</a></th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="sold_num">销量</a></th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_count">人气</a></th>
    <th class="cell-15 text-right">操作</th>
</tr>
</thead>
<tbody class="js-list-body-region">
<?php foreach($products as $product) { ?>
<tr class="widget-list-item">
    <td class="checkbox">
        <?php if($product['uid'] == $uid) {?>
        <?php } else {?>
        <input type="checkbox" class="js-check-toggle" <?php if (in_array($product['product_id'], $fx_products)) { ?>disabled="true" <?php } ?> value="<?php echo $product['product_id']; ?>" />
        <?php }?>
    </td>

    <td class="goods-image-td">
        <div class="goods-image js-goods-image">
            <img src="<?php echo $product['image']; ?>" />
        </div>
    </td>
    <td class="goods-meta">
        <p class="goods-title">
            <?php if (in_array($product['product_id'], $wholesale_products) || in_array($product['product_id'], $fx_products)) { ?>
                <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>&store_id=<?php echo $_SESSION['store']['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                    <?php if (!empty($_POST['keyword'])) { ?>
                        <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $product['name']); ?>
                    <?php } else { ?>
                        <?php echo $product['name']; ?>
                    <?php } ?>
                </a>
            <?php } else { ?>
                <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>&store_id=<?php echo $product['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                    <?php if (!empty($_POST['keyword'])) { ?>
                        <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $product['name']); ?>
                    <?php } else { ?>
                        <?php echo $product['name']; ?>
                    <?php } ?>
                </a>
            <?php } ?>


        </p>
        <?php if ($product['is_recommend']) { ?>
        <img class="js-help-notes" src="<?php echo TPL_URL; ?>/images/jian.png" alt="推荐" width="19" height="19" /><br/>
        <?php } ?>
    </td>
    <?php if($type == 'wholesale') {?>
        <td class="text-right">
            <p>￥<?php echo $product['wholesale_price']; ?></p>
        </td>
        <td class="text-right">
            <p>￥<?php echo $product['sale_min_price']; ?></p>
            <p>- ￥<?php echo $product['sale_max_price']; ?></p>
        </td>
    <?php } else if($type == 'fx') { ?>
         <td class="text-right">
            <p>￥<?php echo $product['cost_price']; ?></p>
        </td>
        <td class="text-right">
            <p>￥<?php echo $product['min_fx_price']; ?></p>
            <p>- ￥<?php echo $product['max_fx_price']; ?></p>
        </td>
    <?php }?>
    <?php if($type == 'wholesale') {?>
    <td class="text-right">
        <p>￥<?php echo number_format($product['sale_min_price'] - $product['wholesale_price'], 2, '.', ''); ?></p>

        <p>- ￥<?php echo number_format($product['sale_max_price'] - $product['wholesale_price'], 2, '.', ''); ?></p>
    </td>
    <?php } else if($type == 'fx'){?>
     <td class="text-right">
        <p>￥<?php echo number_format($product['min_fx_price'] - $product['cost_price'], 2, '.', ''); ?></p>

        <p>- ￥<?php echo number_format($product['max_fx_price'] - $product['cost_price'], 2, '.', ''); ?></p>
    </td>
    <?php }?>
   
    <td class="text-right">
        <p><?php echo $product['quantity']; ?></p>
    </td>
    <td class="text-right">
        <?php echo $product['sales']; ?>
    </td>
    <td class="text-right">
        <?php echo $product['pv']; ?>
    </td>
    <td class="text-right">
        <p class="js-opts">
            <?php if (in_array($product['product_id'], $wholesale_products)) { ?>
                已添加
            <?php } else { ?>
                <?php if(!empty($store_info['is_required_to_audit']) && empty($store_info['is_required_margin']) && empty($is_authen)) {?>
                    <a>等待审核通过</a>
                <?php } else if (!empty($store_info['is_required_to_audit']) && empty($store_info['is_required_margin']) && !empty($is_authen)){?>
                    <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                <?php } else if(!empty($store_info['is_required_to_audit']) && !empty($store_info['is_required_margin']) && empty($is_authen)) {?>
                    <a>等待审核通过</a>
                <?php } else if (!empty($store_info['is_required_to_audit']) && !empty($store_info['is_required_margin']) && !empty($is_authen) && $bond['bond'] == 0){?>
                   <a>请交纳保证金</a>
                <?php } else if (!empty($store_info['is_required_to_audit']) && !empty($store_info['is_required_margin']) && !empty($is_authen) && $bond['bond'] > 0) {?>
                    <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                <?php } else if(empty($store_info['is_required_to_audit']) && empty($store_info['is_required_margin'])) { ?>
                    <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                <?php } else if(empty($store_info['is_required_to_audit']) && !empty($store_info['is_required_margin']) && $bond['bond'] > 0) {?>
                    <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                <?php } else if (empty($store_info['is_required_to_audit']) && !empty($store_info['is_required_margin']) && $bond['bond'] == 0) {?>
                    <a>请交纳保证金</a>
                <?php }?>
            <?php }?>
        </p>
    </td>
</tr>
<?php } ?>
</tbody>
<?php } ?>
</table>
    <div class="js-list-empty-region">

		<div>
		<form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
    <div class="clearfix">
        <div class="filter-groups">
            <div class="control-group">
                <label class="control-label">订单号：</label>
                <div class="controls">
                    <input type="text" name="order_no" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">交易号：</label>
                <div class="controls">
                    <input type="text" name="trade_no" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">收货人姓名：</label>
                <div class="controls">
                    <input type="text" name="user" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">收货人手机：</label>
                <div class="controls">
                    <input type="text" name="tel" />
                </div>
            </div>
        </div>
        <div class="pull-left">
            <div class="time-filter-groups clearfix">
                <div class="control-group">
                    <label class="control-label select">
                        <select name="time_type">
                            <option value="add_time">下单时间</option>
                            <option value="paid_time">付款时间</option>
                            <option value="sent_time">发货时间</option>
                            <option value="complate_time">签收时间</option>
                            <option value="cancel_time">关闭时间</option>
                            <option value="refund_time">退款时间</option>
                        </select>
                    </label>

                    <div class="controls">
                        <input type="text" name="start_time" value="" class="js-start-time" id="js-start-time" />
                        <span>至</span>
                        <input type="text" name="end_time" value="" class="js-end-time" id="js-end-time" />
                        <span class="date-quick-pick" data-days="7">最近7天</span>
                        <span class="date-quick-pick" data-days="30">最近30天</span>
                    </div>
                </div>
            </div>
            <div class="filter-groups">
                <div class="control-group">
                    <label class="control-label">订单类型：</label>
                    <div class="controls">
                        <select name="type" class="js-type-select">
                            <option value="*">全部</option>
                            <option value="0">普通订单</option>
                            <option value="1">代付订单</option>
                            <option value="3">分销订单</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">订单状态：</label>
                    <div class="controls">
                        <select name="status" class="js-state-select">
                            <option value="0">全部 (不包含临时单)</option>
                            <option value="1">待付款</option>
                            <option value="2">待发货</option>
                            <option value="3">已发货</option>
                            <option value="4">已完成</option>
                            <option value="5">已关闭</option>
                            <option value="6">退款中</option>
                            <option value="0">临时单</option>
                        </select>
                    </div>
                </div>
                <!--<div class="control-group">
                    <label class="control-label">微信昵称：</label>
                    <div class="controls">
                        <input type="text" name="weixin_user" />
                    </div>
                </div>-->
            </div>
            <div class="filter-groups">

                <div class="control-group">
                    <label class="control-label">付款方式：</label>
                    <div class="controls">
                        <select name="payment_method">
                            <option value="">全部</option>
                            <option value="weixin">微信安全支付</option>
                            <option value="alipay">支付宝支付</option>
                            <option value="CardPay">会员卡支付</option>
                            <option value="umpay">银行卡付款</option>
                            <option value="balance">余额支付</option>
                            <option value="codpay">货到付款/到店付款</option>
                            <option value="peerpay">找人代付</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">物流方式：</label>
                    <div class="controls">
                        <select name="shipping_method">
                            <option value="">全部</option>
                            <option value="express">快递发货</option>
                            <option value="selffetch">上门自提</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <div class="ui-btn-group">
                <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在筛选...">筛选</a>
		<!-- 		<a href="javascript:;" class="ui-btn" id="order_download" data-loading-text="正在下载...">导出订单</a>
 -->            </div>
        </div>
    </div>
</form>

<?php 
$config_order_return_date = option('config.order_return_date');
$config_order_complete_date = option('config.order_complete_date');
$version  = option('config.weidian_version');
if (!empty($orders)) {
?>

	<table class="ui-table-order" width="100%">
		<thead class="js-list-header-region tableFloatingHeaderOriginal"><tr><th class="" colspan="2">商品</th>
			<th class="price-cell">单价/数量</th>
			<th class="time-cell">
				<a href="javascript:;" class="orderby orderby_add_time" data-orderby="add_time">下单时间<span class="orderby-arrow desc"></span></a>
			</th>
			
                        <th class="price-cell" style="text-align:center">订单金额</a></th>
			<th class="price-cell" style="text-align:center">买    家</a></th>
			<th class="price-cell" style="text-align:center">操作</th>
		</tr>
		</thead>
		<?php foreach ($orders as $order) {?>
			<tbody>
			<tr class="separation-row">
				<td colspan="8"></td>
			</tr>
			<tr class="header-row">
				<td colspan="6">
					
					
						
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
					</td>
					
					<?php if (count($order['products']) > 0 && $key == 0) { ?>
					
					<td class="time-cell" rowspan="<?php echo count($order['products']); ?>">
						<div class="td-cont">
							<?php echo date('Y-m-d H:i:s', $order['add_time']); ?>
						</div>
					</td>
					
					<td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
						<div class="td-cont text-center">
							<div>
								<p>
									<span class="order-total"><?php echo $order['total'] > 0 ? $order['total'] : $order['sub_total'] ?></span>
								</p>
								
							</div>
						</div>
					</td>
					
					
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
					
					
					<td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
						<div class="td-cont text-center">
							<div>
<!--								<p>
									<?php if($order['status']==4){?><button data-id="<?php echo $order['order_id']?>" class="btn btn-small fx_bill_check" <?php if($order['is_check']==2){?>disabled<?php }?>>确认对帐</button><?php }else{?>
									<span style="color:gray">确认对帐</span>
									<?php } ?>
								</p>-->
								<p>
								<a href="/user.php?c=fx&a=commission_detail&id=<?php echo $order['order_id']; ?>&fx_store_id=<?php echo $order['store_id']?>" class="js-order-detail" target="_blank">分润明细</a>
								</p>
								
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
		</div>
		
    </div>
</div>
<div class="js-list-footer-region ui-box">
    <?php if (!empty($products)) { ?>
    <div class="widget-list-footer">
        <input type="hidden" data-store="<?php echo $store_id;?>" class="store_id">
        <div class="pagenavi"><?php echo $page; ?></div>
    </div>
    <?php } ?>
</div>
<div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div></div>
<script type="text/javascript">
    var t= '';
    $(function(){
        $('.js-help-notes').hover(function(){
            $('.popover-help-notes').remove();
            var help_content = $('.js-notes-cont').html();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 20) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + help_content + '</div></div></div>';
            $('body').append(html);
            $('.popover-help-notes').show();
        }, function(){
            t = setTimeout('hide()', 200);
        })

        $('.popover-help-notes').live('mouseleave', function(){
            clearTimeout(t);
            hide();
        })

        $('.popover-help-notes').live('mouseover', function(){
            clearTimeout(t);
        })

    })

    function hide() {
        $('.popover-help-notes').remove();
    }
	
</script>
</div>





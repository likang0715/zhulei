<style type="text/css">
    .ui-table-order tr {
        border: 1px solid #ccc;
    }

    .ui-table-order tr td {
        border: 1px solid #ddd;
    }

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

    .order-no {
        color:#FF6600;
    }
    .cost-price {
        color:red;
    }
    .profit {
        color: green;
    }


    .section-title .sub-title {
        font-weight: bold;
        height: 34px;
        line-height: 34px;
    }
    .order-no {
        color: #FF6600;
        float: left;
    }
    .store-name {
        float: left;
    }
    .profit {
        color:green;
        float: right;
    }
    .align-right {
        text-align: right!important;
    }
    .hide {
        display: none!important;
    }
    .open-close {
        display: inline-block;
        font-weight: normal;
        font-size: 12px;
        margin-left: 20px;
    }
    .tb-total {
        color:green;
        font-weight: bold;
    }

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
    .section-title .sub-title {
        /*font-size: 14px;*/
        font-weight: normal;
        height: 34px;
        line-height: 34px;
    }
    .order-no {
        width: 270px;
        color: #FF6600;
        float: left;
    }
    .postage {
        float: left;
    }
    .store-name {
        width: 250px;
        float: left;
        display:block;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }
    .profit {
        width: 200px;
        color:green;
        float: right;
        text-align: right;
    }
    .align-right {
        text-align: right!important;
    }
    .hide {
        display: none!important;
    }
    .open-close {
        display: inline-block;
        font-weight: normal;
        font-size: 12px;
        margin-left: 20px;
    }
    .tb-total {
        color:green;
        font-weight: bold;
    }
    .tb-cost-price {
        color:red;
        font-weight: bold;
    }
    .desc {
        padding:10px 0 0 10px;
        color:gray;
        border: 1px dashed #E4E4E4;
    }
</style>
<script>
$(function(){

	//导出分销商订单
    $(".js-dump-btn").live("click",function(){

        var order_no = $.trim($("input[name='order_no']").val());
        var fx_order_no = $.trim($("input[name='fx_order_no']").val());
        var delivery_user = $.trim($("input[name='delivery_user']").val());
        var start_time = $.trim($("input[name='start_time']").val());
        var end_time = $.trim($("input[name='end_time']").val());
        var supplier_id = $.trim($("select[name='supplier_id']").val());
        var status = $.trim($("select[name='state']").val());
        var delivery_tel = $.trim($("input[name='delivery_tel']").val());
        
	
    	var loadi =layer.load('正在查询', 10000000000000);
		//all: 全部
    	var levels = $("#select_level").val();
    	//alert(levels);return false;
    	$.post(
    			drp_checkout_url,
    			{"levels":levels,'order_no': order_no, 'fx_order_no': fx_order_no, 'delivery_user': delivery_user, 'start_time': start_time, 'end_time': end_time, 'supplier_id': supplier_id, 'status': status, 'delivery_tel': delivery_tel},
    			function(obj) {
    				layer.close(loadi);
    				  
    				 if(obj.msg>0) {
    					 layer.confirm('该指定条件下有 订单 '+obj.msg+' 条，确认导出？',function(index){
    					 	layer.close(index);
    					 	//location.href=drp_checkout_url+"&type=do_checkout&level="+levels;
    					 	window.open(drp_checkout_url+"&type=do_checkout&levels="+levels+'&order_no='+order_no+'&fx_order_no='+fx_order_no+'&delivery_user='+delivery_user+'&start_time='+start_time+'&end_time='+end_time+'&supplier_id='+supplier_id+'&status='+status+'&delivery_tel='+delivery_tel);
    					});
    				} else {
    					//layer.close(index);
    					layer.alert('该搜索条件下没有用户数据，无需导出！', 8); 
    				} 
    				
    			},
    			'json'
    	)	
    })
    
})
</script>
<div>
<div class="js-list-filter-region clearfix">
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
                        <label class="control-label">收货人姓名：</label>
                        <div class="controls">
                            <input type="text" name="delivery_user" />
                        </div>
                    </div>
                </div>
                <div class="pull-left">
                    <div class="time-filter-groups clearfix">
                        <div class="control-group">
                            <label class="control-label">下单时间：</label>
                            <div class="controls">
                                <input type="text" name="start_time" value="" class="js-start-time" id="js-start-time" />
                                <span>至</span>
                                <input type="text" name="end_time" value="" class="js-end-time" id="js-end-time" />
                                <span class="date-quick-pick" data-days="7">最近7天</span>
                                <span class="date-quick-pick" data-days="30">最近30天</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">收货人手机：</label>
                        <div class="controls">
                            <input type="text" name="delivery_tel" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="ui-btn-group">
                        <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在筛选...">筛选</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
	<div class="widget-list-filter">
		<div class="filter-box">
			<div class="js-list-search">
				<div style="text-align:right">
				<span style="background-color:#e5e5e5;display:inline-block;padding:2px;">
					<select id="select_level" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
						<option value="<?php echo $level;?>">导出当前筛选出条件的订单</option>
						<option value="all">导出全部分销订单</option>
					</select>
					<input type="button" class="ui-btn ui-btn-primary js-dump-btn" value="分销商订单导出">
				</span>
				</div>
			</div>
		</div>
	</div>
</div>
    
    
    
<div class="ui-box orders">

    <?php if (!empty($orders)) { ?>
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
                    <td colspan="8">
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

                            <?php if ($order['type'] == 3) { ?>
                                <span class="platform-tag">分销</span>
                                <span class="c-gray">
							来自于<span style="color: red"> <?php echo $order['drp_level']?> </span>级分销商：<?php echo $order['seller']; ?>
						</span>
                            <?php } else if ($order['type'] == 5) { ?>
                            <span class="platform-tag" style="background-color:#07d">批发</span>
							<span class="c-gray">
							经销商：<?php echo $order['seller']; ?>
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
                            <p>(<?php echo $product['pro_num']; ?>件)</p>
                            <?php if (!empty($order['is_fx']) || !empty($order['fx_order_id']) || !empty($order['user_order_id'])) { ?>
                            <p class="cost-price">给分销商的价格：<?php echo $product['cost_price']; ?></p>
                            <p class="profit">分销商零售价格:<?php echo $product['pro_price']; ?>
                                <?php } ?>
                        </td>
                        <td class="aftermarket-cell">
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
                                </div>
                            </td>
                            <td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
                                <div class="td-cont text-center">
                                    <div>

                                        <p>
                                            <span class="c-gray">(含运费: <span style="color:red;"><?php echo $order['postage']; ?></span>)</span>
                                        </p>
                                        <?php if (empty($order['is_fx'])) { ?>
                                            <?php  if ($order['status'] == 0 || $order['status'] == 1) { ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if (!empty($order['is_fx']) || !empty($order['fx_order_id']) || !empty($order['user_order_id'])) { ?>
                                            <p class="cost-price">该订单金额：<?php echo $order['sub_total'];?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                <tr class="separation-row">
                    <td colspan="8"></td>
                </tr>
                <tr class="header-row" style="border-bottom:solid 20px #ddd;">
                    <td colspan="8">
                    <div class="section">
                    </div>
                    <?php foreach ($commission_orders[$order['order_id']] as $comm_orders) { ?>

                        <?php $i=1; foreach($comm_orders as $comm_order):?>
                        <div class="section section-express">
                            <div class="section-title clearfix">
                                <div class="sub-title">
                                    <div class="store-name"><?php if (!empty($comm_order['seller_drp_level'])){ ?><span style="color: red"><?php echo $comm_order['seller_drp_level']; ?></span> 级分销商<?php } else { ?><?php if ($comm_order['is_wholesale']) { ?>经销商<?php } else { ?>供货商<?php } ?><?php } ?>：<a href="<?php echo $order['seller_store']; ?>" target="_blank"><?php echo $comm_order['seller']; ?></a></div>
                                    <div class="order-no"><?php if (empty($comm_order['user_order_id'])) { ?>主订单号<?php } else { ?>订单号<?php } ?>：<?php echo $comm_order['order_no']; ?></div>
                                    <div class="postage">运费：<?php echo $comm_order['supplier_postage']; ?></div>
                                    <div class="profit">利润：+<?php echo number_format($comm_order['profit'], 2, '.', ''); ?><span class="open-close"><a href="javascript:void(0);">+ 展开</a></span></div>
                                </div>
                            </div>
                            <div class="section-detail" style="display: none">
                                <table class="table order-goods">
                                    <thead>
                                    <tr>
                                        <th class="tb-thumb"></th>
                                        <th class="tb-name">商品名称</th>
                                        <th class="tb-pric align-right">成本价（元）</th>
                                        <?php if (!empty($comm_order['is_fx'])) { ?>
                                            <th class="tb-price align-right">零售价（元）</th>
                                        <?php } else if ($comm_order['type'] == 5) { ?>
                                            <th class="tb-price align-right">批发价（元）</th>
                                        <?php } else { ?>
                                            <th class="tb-price align-right">分销价（元）</th>
                                        <?php } ?>
                                        <th class="tb-num align-right">数量</th>
                                        <th class="tb-total align-right">利润（元）</th>
                                        <th class="tb-postage align-right">运费（元）</th>
                                    </tr>
                                    </thead>
                                    <tbody style="background-color:#f8f8f8;">
                                    <?php
                                    $key = 0;
                                    foreach ($comm_order['products'] as $product) { ?>
                                        <?php $skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; ?>
                                        <?php $comments = !empty($product['comment']) ? unserialize($product['comment']) : ''; ?>
                                        <tr data-order-id="<?php echo $comm_order['order_id']; ?>">
                                            <td class="tb-thumb" <?php if (!empty($comments)) { ?>rowspan="2"<?php } ?>><img src="<?php echo $product['image']; ?>" width="60" height="60" /></td>
                                            <td class="tb-name">
                                                <a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>&store_id=<?php echo $order['store_id']; ?>" class="new-window" target="_blank"><?php echo $product['name']; ?></a>
                                                <?php if ($skus) { ?>
                                                    <p>
                                                        <span class="goods-sku"><?php foreach ($skus as $sku) { ?><?php echo $sku['name']; ?>: <?php echo $sku['value']; ?>&nbsp;<?php } ?></span>
                                                        <?php if (!empty($product['return_status'])) { ?>
                                                            <span class="platform-tag" style="background-color: #999;">已退货 <?php if (!empty($product['return_quantity'])) { ?>x<?php echo $product['return_quantity']; ?><?php } ?></span>
                                                        <?php } ?>
                                                    </p>
                                                <?php } else { ?>

                                                    <?php if (!empty($product['return_status'])) { ?>
                                                        <p>
                                                            <span class="platform-tag" style="background-color: #999;">已退货 <?php if (!empty($product['return_quantity'])) { ?>x<?php echo $product['return_quantity']; ?><?php } ?></span>
                                                        </p>
                                                    <?php } ?>

                                                <?php } ?>
                                                <p><a href="javascript:void(0);">商品来源：<?php echo $product['from']; ?></a></p>
                                            </td>
                                            <td class="tb-price tb-cost-price align-right"><?php echo $product['cost_price']; ?></td>
                                            <td class="tb-price align-right"><?php echo $product['pro_price']; ?></td>
                                            <td class="tb-num align-right"><?php echo $product['pro_num']; ?></td>
                                            <?php if (empty($product['return_status'])) { ?>
                                                <td class="tb-total align-right">+<?php echo $product['profit']; ?></td>
                                            <?php } else { ?>
                                                <td class="tb-total align-right" style="color:#999;text-decoration:line-through"><?php echo $product['profit']; ?></td>
                                            <?php } ?>
                                            <?php if (count($comm_order['comment_count']) > 0 && $key == 0) { ?>
                                                <td class="tb-postage align-right" rowspan="<?php echo $comm_order['rows']; ?>">
                                                    <?php echo $comm_order['postage']; ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php if (!empty($comments)) { ?>
                                            <?php foreach ($comments as $comment) { ?>
                                                <tr class="msg-row">
                                                    <td colspan="5"><?php echo $comment['name']; ?>：<?php echo $comment['value']; ?><br></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $key++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            <?php $i++; endforeach; ?>
                    <?php } ?>
                    </td>
                </tr>
                </tbody>
            <?php } ?>
        </table>
    <?php } ?>
</div>
<div class="js-list-footer-region ui-box">
    <div>
        <div class="pagenavi">
            <?php echo $page; ?>
        </div>
    </div>
</div>
</div>


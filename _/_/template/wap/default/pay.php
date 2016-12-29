<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php if($is_point_mall == 1) {?>待支付积分的订单<?php } else {?>待付款的订单<?php }?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>
			var noCart=true,
				orderNo='<?php echo $nowOrder['order_no_txt'];?>',
				sub_total=<?php echo $nowOrder['sub_total'];?>,
				isLogin=!<?php echo intval(empty($wap_user));?>,
				selffetchList='<?php echo $selffetch_list ? json_encode($selffetch_list) : '';?>';

			var presale_type = "<?php  echo $presale_type ? $presale_type : '';?>"
		</script>
		<script src="<?php echo TPL_URL;?>js/pay.js?id=<?php echo time();?>"></script>
		<script src="http://api.map.baidu.com/api?v=1.2" type="text/javascript"></script>
		<script>
			var postage = '<?php echo $nowOrder['postage'] ?>';
			var is_logistics = <?php echo ($now_store['open_logistics'] || $is_all_supplierproduct) ? 'true' : 'false' ?>;
			var is_selffetch = <?php echo ($now_store['buyer_selffetch'] && $is_all_selfproduct) ? 'true' : 'false' ?>;
			var is_point = <?php echo $points_data ? 'true' : 'false' ?>;
			var points_data = <?php echo json_encode($points_data) ?>;
			var is_edit = <?php echo $nowOrder['status'] >= 1 ? 'false' : 'true' ?>;
			var pay_to_supplier = <?php echo !empty($pay_to_supplier) ? 'true' : 'false' ?>;
			var is_platform_point = <?php echo option('credit.platform_credit_open') ? 'true' : 'false' ?>;
			var is_force_platform_point = <?php echo option('credit.force_use_platform_credit') ? 'true' : 'false' ?>;
			var trade_money_percent = '<?php echo option('credit.online_trade_money') ? option('credit.online_trade_money') : 100 ?>';
			var credit_setting = <?php echo json_encode(option('credit')) ?>;
			var max_platform_point = <?php echo $max_platform_point + 0 ?>;
		</script>
		<style>
			.qrcodepay {display:none;margin:0 10px 10px 10px;}
			.qrcodepay .item1{background:#fff;border:1px solid #e5e5e5;}
			.qrcodepay .title{margin:0 10px;padding:10px 0;border-bottom:1px solid #efefef;}
			.qrcodepay .info{text-align:center;line-height:25px;font-size:12px;}
			.qrcodepay .qrcode{margin-bottom:10px;}
			.qrcodepay .qrcode img{width:200px;height:200px;}		
			.qrcodepay .item2 {background:#fff;border:1px solid #e5e5e5;margin:10px 0;line-height:40px;text-align:center;}
			.qrcodepay .item2 a{display:block;height:100%;width:100%;}
		</style>
	</head>
	<body>
		<div class="container js-page-content wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order">
					<div class="app-inner inner-order" id="js-page-content">
						<!-- 通知 -->
						<!-- 商品列表 -->
						<div class="block block-order block-border-top-none" data-id="<?php echo $nowOrder['order_id']; ?>" data-float-amount="<?php echo $nowOrder['float_amount']; ?>">
							<div class="header">
								<span>店铺：<?php echo $now_store['name'];?></span>
								<?php 
								if ($nowOrder['type'] == 6) {
									echo '<span class="c-orange">团购订单</span>';
								} else if ($nowOrder['type'] == 7) {
									echo '<span class="c-orange">预售订单</span>';
									if($nowOrder['order_id'] == $nowOrder['presale_order_id']) {
										echo '<span class="c-orange">（支付尾款）</span>';
									}
								}
								?>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<?php if(isset($_GET['orderName'])){?>
									<div class="block-item name-card name-card-3col clearfix">
										<div class="detail" style="margin-left:0px;">
											<a href="javascript:void(0)"><h3><?php echo $_GET['orderName'];?></h3></a>
										</div>
										<div class="right-col">
											<div class="price">￥<span><?php echo $nowOrder['sub_total']?></span></div>
											<div class="num">×<span class="num-txt">1</span></div>
										</div>
									</div>
								<?php
								}
								$discount_money = 0;
								$supplier_money = 0;

//								echo "<pre>";
//								print_r($nowOrder);
//								exit;
								foreach ($nowOrder['proList'] as $value) {
								?>
									<div class="block-item name-card name-card-3col clearfix js-product-detail">
										<a href="javascript:;" class="thumb">
											<img class="js-view-image" src="<?php echo $value['image'];?>" alt="<?php echo $value['name'];?>"/>
										</a>
										<div class="detail">
											<?php if($nowOrder['type'] == '7') {?>
											<a href="./presale.php?id=<?php echo $nowOrder['data_id'];?>"><h3><?php echo $value['name'];?></h3></a>
											<?php } else if ($value['product_id']){?>
											<a href="./good.php?id=<?php echo $value['product_id'];?>&store_id=<?php echo $tmp_store_id; ?>"><h3><?php echo $value['name'];?></h3></a>
											<?php } else {?>
												<h3><?php echo $value['name'];?></h3>
											<?php }?>
											<?php 
											if ($value['is_present']) {
												echo '<span style="color:#f60">赠品</span>';
											}
											?>
											<?php
												if($value['sku_data_arr']){
													foreach($value['sku_data_arr'] as $v){
											?>
														<p class="c-gray ellipsis"><?php echo $v['name'];?>：<?php echo $v['value'];?></p>
											<?php 
													}
												}
											?>
										</div>
										<div class="right-col">
											<?php if($nowOrder['is_point_order'] == '1') {?>
												<div class="price"><span class="point_ico"></span><span><?php echo intval($value['pro_price']);?></span></div>
											<?php } else if($nowOrder['type'] == '7' && ($value['is_present']!=1)) { ?>
												
												<div class="price">￥<span><?php echo number_format($product_price,2);?></span></div>
												
												
											<?php }else {?>
												<div class="price">￥<span><?php echo number_format($value['pro_price'],2);?></span></div>
											<?php }?>
											
											<div class="num">
												<?php
												$discount = 10; 
												if ($value['wholesale_supplier_id']) {
													$discount = $order_data['discount_list'][$value['wholesale_supplier_id']];
												} else {
													$discount = $order_data['discount_list'][$value['store_id']];
												}
												
												if ($value['discount'] > 0 && $value['discount'] <= 10) {
													$discount = $value['discount'];
												}
												
												if ($nowOrder['type'] == 7) { 
													$discount = 10;
												}
												if($nowOrder['type'] == 55){
													// 降价拍商品不打折
													$discount = 10;
												}
												if ($discount != 10 && $discount > 0) {
													$discount_money += $value['pro_num'] * $value['pro_price'] * (10 - $discount) / 10;
												?>
													<span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;"><?php echo $discount ?>折</span>
												<?php
													if (empty($value['wholesale_supplier_id'])) {
														$supplier_money += $value['pro_num'] * $value['pro_price'] * $discount / 10;
													}
												} else if (empty($value['wholesale_supplier_id'])) {
													$supplier_money += $value['pro_num'] * $value['pro_price'];
												}
												?>
												×<span class="num-txt"><?php echo $value['pro_num'];?></span>
											</div>
											<?php if($value['comment_arr']){?>
												<a class="link pull-right message js-show-message" data-comment='<?php echo json_encode($value['comment_arr']) ?>' href="javascript:;">查看留言</a>
											<?php } ?>
										</div>
									</div>
								<?php 
								}
								?>
							</div>
							<hr class="margin-0 left-10"/>
							<?php if($nowOrder['status'] == 0){ ?>
								<div class="order-message clearfix" id="js-order-message">
									<textarea class="js-msg-container font-size-12" placeholder="给卖家留言..."></textarea>
								</div>
							<?php }else{ ?>
								<div class="order-message">
									<span class="font-size-12">买家留言：</span><p class="message-content font-size-12"><?php echo $nowOrder['comment'] ? $nowOrder['comment'] : '无'?></p>
								</div>
								<hr class="margin-0 left-10"/>
							<?php } ?>
							<div class="bottom js-sub_total" data-supplier_money="<?php echo $supplier_money ?>">总价<span class="c-orange pull-right">￥<?php echo $nowOrder['sub_total']?></span></div>
						</div>
						<!-- 物流 -->
                        <div class="block express" id="js-logistics-container">
							<div class="block-item logistics">
								<h4 class="block-item-title">配送方式</h4>
								<div class="pull-left js-logistics-select">
									<?php 
									if ($now_store['open_logistics'] || $is_all_supplierproduct) {
									?>
										<button data-type="express" class="tag tag-big <?php if($nowOrder['shipping_method'] == 'express' || empty($nowOrder['shipping_method'])){ ?>tag-orange<?php } ?>" style="margin-top:-3px;">快递配送</button>
									<?php 
									}
									if ($is_all_selfproduct && $now_store['buyer_selffetch'] && $selffetch_list) {
									?>
										<?php if($nowOrder['type'] !=7) {?>
											<button data-type="selffetch" class="tag tag-big js-tabber-self-fetch <?php if($nowOrder['shipping_method'] == 'selffetch'){ ?>tag-orange<?php } ?>" style="margin-top:-3px;"><?php echo $now_store['buyer_selffetch_name'] ? $now_store['buyer_selffetch_name'] : '到店自提' ?></button>
										<?php }?>
									<?php 
									}
									?>
								</div>
							</div>
							<?php if($nowOrder['status'] < 1){ ?>
								<div class="js-logistics-content logistics-content js-express">
									<?php if($userAddress && $now_store['open_logistics']){ ?>
										<div>
											<div class="block block-form block-border-top-none block-border-bottom-none">
												<div class="js-order-address express-panel" style="padding-left:0;">
													<?php if($nowOrder['status'] == 0){ ?>
														<div class="opt-wrapper">
                                                            <a href="javascript:;" class="btn btn-xxsmall btn-green butn-edit-address" id="addList" style="margin-bottom: 5px;">切换</a><br />
															<a href="javascript:;" class="btn btn-xxsmall butn-edit-address js-edit-address" style="border-color: #f60;background-color: #f60;color: #fff;">修改</a>
														</div>
													<?php } ?>
													<ul>
														<li><span><?php echo $userAddress['name']; ?></span>, <?php echo $userAddress['tel']; ?></li>
														<li><?php echo $userAddress['province_txt']; ?> <?php echo $userAddress['city_txt']; ?> <?php echo $userAddress['area_txt']; ?></li>
														<li><?php echo $userAddress['address']; ?></li>
													</ul>
												</div>
											</div>
											<div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div>
										</div>
									<?php } else { ?>
										<div>
											<div class="js-order-address express-panel">
												<?php 
												if ($now_store['open_logistics']) {
												?>
													<div class="js-edit-address address-tip"><span>添加收货地址</span></div>
												<?php 
												} else if ($is_all_selfproduct && $now_store['buyer_selffetch'] && $selffetch_list) {
												?>
													<div class="js-selffetch-address address-tip"><span>选择门店</span></div>
												<?php 
												}
												?>
												
											</div>
										</div>
									<?php } ?>
								</div>
								<input type="hidden" name="address_id" id="address_id" value="<?php echo intval($userAddress['address_id']); ?>"/>
								<input type="hidden" name="selffetch_id" id="selffetch_id" value="0"/>
							<?php 
								}else{
									if($nowOrder['shipping_method'] == 'selffetch'){
							?>
										<div>
											<div class="block block-form block-border-top-none block-border-bottom-none">
												<div class="js-order-address express-panel" style="padding-left:0;">
													<ul>
														<li>门店：<span><?php echo $nowOrder['address']['name'];?></span>, <?php echo $nowOrder['address']['tel'];?>, 营业时间：<?php echo $nowOrder['address']['business_hours'] ?></li>
														<li><?php echo $nowOrder['address']['province'];?> <?php echo $nowOrder['address']['city'];?> <?php echo $nowOrder['address']['area'];?> </li>
														<li><?php echo $nowOrder['address']['address'];?></li>
													</ul>
												</div>
												<div class="clearfix block-item self-fetch-info-show">
													<label>预约人</label>
													<input class="txt txt-black ellipsis js-name" placeholder="到店人姓名" readonly value="<?php echo $nowOrder['address_user'];?>"/>
												</div>
												<div class="clearfix block-item self-fetch-info-show">
													<label>联系方式</label>
													<input type="text" class="txt txt-black ellipsis js-phone" placeholder="用于短信接收和便于卖家联系" readonly value="<?php echo $nowOrder['address_tel'];?>"/>
												</div>
												<div class="clearfix block-item self-fetch-info-show">
													<label class="pull-left">预约时间</label>
													<input style="width:125px" class="txt txt-black js-time pull-left date-time" type="date" placeholder="日期" value="<?php echo $nowOrder['address']['date'];?>" readonly/><input style="width:70px" class="txt txt-black js-time pull-left date-time" type="time" placeholder="时间" value="<?php echo $nowOrder['address']['time'];?>" readonly/>
												</div>
											</div>
										</div>
							<?php
									}else{
							?>
										<div>
											<div class="block block-form block-border-top-none block-border-bottom-none">
												<div class="js-order-address express-panel" style="padding-left:0;">
													<ul>
														<li><span><?php echo $nowOrder['address_user']; ?></span>, <?php echo $nowOrder['address_tel']; ?></li>
														<li><?php echo $nowOrder['address']['province'];?> <?php echo $nowOrder['address']['city'];?> <?php echo $nowOrder['address']['area'];?></li>
														<li><?php echo $nowOrder['address']['address'];?></li>
													</ul>
												</div>
											</div>
											<div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div>
										</div>
							<?php
									}
								}
							?>
						</div>
                        <!--收货地址切换 20160325-->
                        <style>
                            .addWindow{position: fixed;top: 0;right: 0;left: 0;bottom: 0;background: rgba(0,0,0,.7);visibility: hidden}
                            .addWindow .addBox{width: 90%;margin: 0 auto;background: #fff;border-radius: 5px;;position: relative}
                            .addWindow .addBox .addClosed{    position: absolute; right: 10px;top: 5px;font-size: 24px;color: #f60;}
                            .addWindow .addBox h3{font-size: 18px;font-weight: normal;text-align: center;padding: 15px 0}
                            .addWindow .addBox ul{padding: 0 15px;max-height: 332px;overflow: auto}
                            .addWindow .addBox ul li{padding: 10px 0;border-bottom: 1px dashed #e3e3e3;font-size: 14px}
                            .addWindow .addBox .checkSpan{float: left}
                            .addWindow .addBox .addInfo{overflow: hidden}
                            .addWindow .addBox .nameAndPhone{margin-bottom: 8px}
                            .addWindow .addBox .nameAndPhone .phone{float: right;margin-right: 5px}
                            .addWindow .addBox .nameAndPhone .name{float: left}
                            .addWindow .addBox .addInfo p{line-height: 20px;margin-right: 5px}
                            .addWindow .addBox ul li.on{background: #5D6A84;color: #fff}
                            .block{z-index: 1;}
                            div{ margin: 0;padding: 0;border: 0;font: inherit;font-size: 100%; vertical-align: baseline;z-index: 2;}
                        </style>
                        <div class="addWindow" style="visibility: hidden">
                            <div class="addBox">
                                <h3>切换收货地址</h3>
                                <ul class="addList">
                                    <?php foreach($userAddressList as $key => $address){?>
                                    <li class="clearfix">
                                        <label>
                                            <span class="checkSpan"><input data-address="<?php echo $address['address_id'];?>" <?php echo $address['default'] == 1 ? 'checked' : '';?> type="radio" name="address"/></span>
                                            <div  class="addInfo">
                                                <div class="nameAndPhone clearfix"><span class="phone"><?php echo $address['tel'];?></span><span class="name"><?php echo $address['name'];?></span></div>
                                                <p><?php echo $address['province_txt'];?> <?php echo $address['city_txt'];?> <?php echo $address['area_txt'];?></p>
                                            </div>
                                        </label>
                                    </li>
                                    <?php }?>
                                </ul>
                                <a href="javascript:;" class="addClosed">×</a>
                            </div>
                        </div>

                        <script>
                            function center(a) {
                                var wHeight = $(window).height();
                                var boxHeight = $(a).outerHeight(true);
                                var top = (wHeight - boxHeight) / 2;
                                $(a).css({
                                    "margin-top": top
                                });
                            }
                            $(function(){
                                $("#addList").live('click',function(){
                                    $(".addWindow").css("visibility",'visible');
                                });

                                $(".addWindow .addBox .addClosed").click(function(){
                                    $(".addWindow").css("visibility",'hidden');
                                });
                                $(".addWindow .addBox ul li").click(function(){
                                    $(this).addClass("on").siblings().removeClass("on");
                                });
                                center(".addWindow .addBox");
                            });

                            $('input[name="address"]').click(function(){
                                var address_id = $(this).data('address');
                                var post_url = './unitay_address.php?action=default';
                                $.post(post_url,{'address_id':address_id},function(data){
                                    console.log(data);
                                    if(data.err_code == 0){
                                        motify.log(data.err_msg);
                                        setTimeout(function(){
                                            window.location.href="<?php echo option('config.wap_site_url').'/pay.php?id='.$_GET['id'];?>";
                                        },1000);//延时2秒
                                    }else{
                                        motify.log(data.err_msg);
                                    }
                                });
                            });
                        </script>


                        <!--end-->
						<!-- 满减送 -->
						<?php
						$supplier_reward_money = 0;
						$supplier_coupon_money = 0;
						
						if ($order_data['reward_list'] && !in_array($nowOrder['type'],array(7,53))) {
						?>
							<div class="block">
								<div class="js-order-total block-item order-total reward_list" style="text-align:left;">
									<?php
									$reward_money = 0;
									foreach ($order_data['reward_list'] as $store_id => $reward_list) {
										foreach ($reward_list as $key => $reward) {
											if ($key === 'product_price_list') {
												continue;
											}
											if (isset($reward['content'])) {
												$reward = $reward['content'];
											}
											$reward_money += $reward['cash'];
											
											if ($now_store['store_id'] == $store_id || $now_store['top_supplier_id'] == $store_id) {
												$supplier_reward_money += $reward['cash'];
											}
									?>
											<p><span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;">满减</span><?php echo getRewardStr($reward) ?></p>
									<?php
										}
									}
									?>
								</div>
								<script>
									$(function(){
										var reward_list = $('.reward_list');
										if($.trim(reward_list.html())  == ''){
											reward_list.parent('.block').css('display','none');
										}
									});
								</script>
							</div>
						<?php
						}
						if ($order_data['user_coupon_list'] && !in_array($nowOrder['type'],array(7,53))) {
						?>
							<div>
								<div class="block js-card-container">
									<h4 class="list-title">使用优惠券：</h4>
									<div class="js-user_coupon block-item order-total" style="text-align:left;">
										<?php
										$user_coupon_money = 0;
										foreach ($order_data['user_coupon_list'] as $store_id => $user_coupon_list) {
										?>
											<p><input type="radio" class="js-user_coupon_input <?php echo $now_store['store_id'] == $store_id || $now_store['top_supplier_id'] == $store_id ? 'supplier' : '' ?>" name="user_coupon_id_<?php echo $store_id ?>" value="0" id="user_coupon_default_<?php echo $store_id ?>" /> <label for="user_coupon_default_<?php echo $store_id ?>" style="cursor:pointer;">不使用优惠券 <span style="display:none;">0</span></label></p>
										<?php
											foreach ($user_coupon_list as $key => $user_coupon_tmp) {
												$checked = '';
												if ($key == '0') {
													$checked = 'checked="checked"';
													$user_coupon_money += $user_coupon_tmp['face_money'];
													
													if ($now_store['store_id'] == $store_id || $now_store['top_supplier_id'] == $store_id) {
														$supplier_coupon_money += $user_coupon_tmp['face_money'];
													}
												}
										?>
												<p><input type="radio" class="js-user_coupon_input <?php echo $now_store['store_id'] == $store_id || $now_store['top_supplier_id'] == $store_id ? 'supplier' : '' ?>" name="user_coupon_id_<?php echo $store_id ?>" value="<?php echo $user_coupon_tmp['id'] ?>" <?php echo $checked ?> id="user_coupon_<?php echo $user_coupon_tmp['id'] ?>" /> <label for="user_coupon_<?php echo $user_coupon_tmp['id'] ?>" style="cursor:pointer;"><?php echo htmlspecialchars($user_coupon_tmp['cname']) ?> 优惠券金额：￥<span><?php echo $user_coupon_tmp['face_money'] ?></span></label></p>
										<?php
											}
										?>
											<hr />
										<?php
										}
										?>
									</div>
								</div>
							</div>
						<?php
						}
						
						if ($nowOrder['status'] > 0 && $user_coupon_list && !in_array($nowOrder['type'],array(53))) {
						?>
							<div>
								<div class="block js-card-container">
									<div class="js-user_coupon block-item order-total" style="text-align:left;">
										<?php 
										foreach ($user_coupon_list as $user_coupon) {
											$user_coupon_money += $user_coupon['money'];
										?>
											<p> 优惠券金额：￥<span><?php echo $user_coupon['money'] ?></span></label></p>
										<?php 
										}
										?>
									</div>
								</div>
							</div>
						<?php
						}
						if ($nowOrder['status'] == 0 && !in_array($nowOrder['type'],array(53))) {
						?>
							<div class="js-point-container" style="<?php echo option('credit.platform_credit_open') && $user['point_balance'] && $nowOrder['status'] == 0 ? '' : 'display: none;' ?>">
								<div class="block js-card-container">
									<h4 class="list-title">积分兑换：</h4>
									<div class="js-user_coupon block-item order-total" style="text-align:left;">
										<div style="clear: both; display: none;" class="js-point"  data-point="0" data-point_money="0" data-supplier_reward_money="<?php echo $supplier_reward_money ?>" data-supplier_coupon_money="<?php echo $supplier_coupon_money ?>">
											<div style="width: 28%; float: left;">
												<input type="checkbox" class="js-point_input" name="point" value="0" id="point_1" checked="checked" />
												<label style="cursor:pointer;" for="point_1">
													店铺积分
												</label>
											</div>
											<div style="width: 70%; float: right;">
												<span class="js-point_content" style="padding-left:10px;">加载中</span>
											</div>
										</div>
										
										<?php 
										if (option('credit.platform_credit_open') && $user['point_balance']) {
										?>
											<div style="clear: both;" class="js-platform_point-container">
												<div style="width: 28%; float: left;">
													<input type="checkbox" class="js-platform_point_input" name="point" value="0" id="point_2" checked="checked" old-value="0" />
													<label for="point_2" style="cursor:pointer;">
														<?php echo option('credit.platform_credit_name') ?>
													</label>
												</div>
												<div style="width: 70%; float: right;">
													<span style="padding-left: 10px;">
														使用<input type="text" name="platform_point" style="width: 50px;" value="0" readonly="readonly" />,抵现￥<span class="js-platform_point_use_money">0</span>
													</span>
													<br />
													<span style="padding-left: 10px;">
														(您有<span class="js-user_point_balance"><?php echo $user['point_balance'] ?></span>,可用<span class="js-platform_point_max">0</span>个)
													</span>
												</div>
											</div>
										<?php 
										}
										?>
									</div>
								</div>
							</div>
						
						<?php 
						}
						$platform_point_money = 0;
						if ($order_point || ($nowOrder['cash_point'] > 0 && $nowOrder['point2money_rate'] > 0 && !in_array($nowOrder['type'],array(53)))) {
						?>
							<div class="js-point" >
								<div class="block js-card-container">
									<div class="js-user_coupon block-item order-total" style="text-align:left;">
										<?php 
										if ($order_point) {
										?>
											<p>使用<?php echo $order_point['point'] ?>个积分，抵扣<?php echo $order_point['money'] ?>元</p>
										<?php 
										}
										if ($nowOrder['cash_point'] && $nowOrder['point2money_rate'] > 0) {
											$platform_point_money = $nowOrder['cash_point'] / $nowOrder['point2money_rate'];
										?>
											<p>使用<?php echo $nowOrder['cash_point'] ?>个<?php echo option('credit.platform_credit_name') ?>，抵扣<?php echo $nowOrder['cash_point'] / $nowOrder['point2money_rate'] ?>元</p>
										<?php 
										}
										?>
									</div>
								</div>
							</div>
						<?php 
						}
						?>
						
						<!-- 支付 -->
						<div class="js-step-topay <?php if($nowOrder['sub_total'] == '0.00' && $nowOrder['status']==0){ ?>hide<?php }?>">
							<div class="block">
								<div class="js-order-total block-item order-total">
									<?php 
									if (empty($pay_to_supplier)) {
									?>
										<?php if(in_array($nowOrder['type'],array(6,7,53))) {?>
											<p><?php  if($presale_type == 'presale_first_pay') {$nowOrder['postage'] = 0;}?>
												<span id="js-sub_total"><?php echo $nowOrder['sub_total'];?></span> + ￥<span id="js-postage"><?php echo number_format($nowOrder['postage'], 2, '.', '');?></span>运费
												<?php
											
												if ($presale_info['privileged_cash'] && ($nowOrder['order_id'] == $nowOrder['presale_order_id'])) {
													echo '- ￥<span id="js-presale_discount_money">'. number_format($presale_info['privileged_cash'], 2, '.', '') .'</span>元预售抵扣';
												}
												
												
												?>
												
											</p>										
										<?php } else {?>
										<p><?php  if($presale_type == 'presale_first_pay') {$nowOrder['postage'] = 0;}?>
											<span id="js-sub_total"><?php echo $nowOrder['sub_total'];?></span> + ￥<span id="js-postage"><?php echo number_format($nowOrder['postage'], 2, '.', '');?></span>运费
											<?php
											if ($reward_money) {
												echo ' - ￥<span id="js-reward">' . number_format($reward_money, 2, '.', '') . '</span>满减优惠';
											}
											if ($user_coupon_money) {
												echo ' - ￥<span id="js-user_coupon">' . number_format($user_coupon_money, 2, '.', '') . '</span>优惠券';
											}
											if ($discount_money) {
												echo ' - ￥<span id="js-discount_money">' . number_format($discount_money, 2, '.', '') . '</span>元折扣';
											}
//											if ($nowOrder['proList']['0']['after_subscribe_discount'] >=1 ) {
//												echo ' - ￥<span id="js-discount_money">' . number_format($nowOrder['proList']['0']['price']-$nowOrder['proList']['0']['pro_price'], 2, '.', '') . '</span>元折扣';
//											}
											?>
											<span class="js-point_money" style="display: <?php echo $order_point['money'] ? '' : 'none' ?>;">
												 - ￥<span><?php echo number_format($order_point['money'], 2, '.', '') ?></span>元积分抵扣
											</span>
											<span class="js-platform_point_money" style="display: <?php echo $platform_point_money ? 'block' : 'none;'?>">
												 - ￥<span><?php echo number_format($platform_point_money, 2, '.', '') ?></span>元<?php echo option('credit.platform_credit_name') ?>抵扣
											</span>
										</p>
										<?php }?>
										<strong class="js-real-pay c-red js-real-pay-temp" <?php echo !empty($nowOrder['float_amount']) && $nowOrder['float_amount'] < 0 ? '' : 'style="display: none;"' ?>>减免：￥<span id="js-float_amount"><?php echo number_format(abs($nowOrder['float_amount']), 2, '.', '') ?></span><br/></strong>
										
										<?php if(($nowOrder['type'] == 7 && ($nowOrder['order_id'] == $nowOrder['presale_order_id']))) {?>
											<strong class="js-real-pay c-orange js-real-pay-temp">需付：<span id="js-total"><?php echo number_format(($nowOrder['sub_total'] + $nowOrder['postage'] - $presale_info['privileged_cash']), 2, '.', ''); ?></span></strong>
										<?php } else {?>
											<strong class="js-real-pay c-orange js-real-pay-temp">需付：<span id="js-total"><?php echo number_format(($nowOrder['sub_total'] + $nowOrder['postage'] - $reward_money - $user_coupon_money), 2, '.', ''); ?></span></strong>
										<?php }?>
										
										
										<!--										<strong class="js-real-pay c-orange js-real-pay-temp">需付：￥<span id="js-total">--><?php //echo number_format(($nowOrder['sub_total'] + $nowOrder['postage'] - $reward_money - $user_coupon_money), 2, '.', ''); ?><!--</span></strong>-->
									<?php
									} else {
									?>
										<strong class="js-real-pay c-orange js-real-pay-temp">需付：￥<span id="js-total"><?php echo number_format(($nowOrder['total']), 2, '.', ''); ?></span></strong>
									<?php 
									}
									?>
								</div>
							</div>
							<div class="action-container sss" id="confirm-pay-way-opts">
								<input type="hidden" name="postage_list" value="" />
                                <?php if(!empty($sync_user)){ ?>
	                                <div style="margin-bottom:10px;">
	                                    <button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay btn-green go-pay">去付款</button>
	                                </div>
	                                <?php 
	                                if ($payList) {
	                                	foreach ($payList as $value) {
	                                		if ($value['type'] == 'offline') {
	                                ?>
												<div style="margin-bottom:10px;">
													<button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay <?php if($i==1){echo 'btn-green';}else{echo 'btn-white';}?>"><?php echo $value['name']?></button>
												</div>
	                                <?php
	                                		}
	                                	}
	                                }
	                                ?>
                                <?php }else{ ?>
                                <?php
									if($payList){
										$i=1;
										foreach($payList as $key => $value){
											// 团购、预售不支付货到付款和找人代付
											if (($nowOrder['type'] == 6 || $nowOrder['type'] == 7) && ($value['type'] == 'offline' || $value['type'] == 'peerpay')) {
												continue;
											}
											
											if ($value['type'] == 'offline' && $nowOrder['shipping_method'] == 'friend') {
												continue;
											}
								?>
											<div style="margin-bottom:10px;">
												<button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay <?php if($i==1){echo 'btn-green';}else{echo 'btn-white';}?>"><?php echo $value['name']?></button>
											</div>
								<?php
											if ($key == 0 && $value['type'] == 'peerpay') {
												break;
											}
											$i++;
										}
									}else{
										$i=1;
										foreach($payMethodList as $value){
											// 团购、预售不支付货到付款和找人代付
											if (($nowOrder['type'] == 6 || $nowOrder['type'] == 7) && ($value['type'] == 'offline' || $value['type'] == 'peerpay')) {
												continue;
											}
											
											if ($value['type'] == 'offline' && $nowOrder['shipping_method'] == 'friend') {
												continue;
											}
								?>
											<div style="margin-bottom:10px;">
												<button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay <?php if($i==1){echo 'btn-green';}else{echo 'btn-white';}?>"><?php echo $value['name']?></button>
											</div>
								<?php
											$i++;
										}
									}
								?>
                                <?php } ?>
								<?php
								if (option('credit.platform_credit_open') && $user['point_balance']) {
								?>
								<div class="point-pay" style="margin-bottom:10px;display: none;"><button type="button" data-pay-type="point" class="btn-pay btn btn-block btn-large btn-green">全额抵现</button></div>
								<?php } ?>
							</div>
							<div class="app-inner inner-order qrcodepay ddd" id="confirm-qrcode-pay">
								<div class="item1">
									<ul class="round" id="cross_pay">
										<li class="title mb" style="text-align:center">
											<span class="none">微信扫码支付</span>
										</li>
										<li class="info">遇到跨号支付？请使用扫码支付完成付款</li>
										<li class="qrcode">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
												<tr>
													<td style="text-align:center" >
														<img src="" id="pay-qrcode">
													</td>
												</tr>
												<tr>
													<td style="padding-top:10px;text-align:center">长按图片[识别二维码]付款</td>
												</tr>
											</table>
										</li>
									</ul>
								</div>
								<div class="item2"><a class="other-pay" href="./pay.php?id=<?php echo $nowOrder['order_no_txt'];?>" >其他支付方式</a></div>
							</div>
							<div class="action-container hide" id="get-present-btn">
								<div style="margin-bottom: 10px;">
									<button type="button" data-pay-type="couponpay" class="btn-pay btn btn-block btn-large btn-couponpay  btn-green">立即兑换</button>
								</div>
							</div>
							<!-- <div class="center action-tip js-pay-tip">支付完成后，如需退换货请及时联系卖家</div> -->
						</div>
					</div>

					<div class="app-inner inner-order peerpay-gift" style="display:none;" id="sku-message-poppage">
						<div class="js-list block block-list"></div>
						<h2>备注信息</h2>
						<ul class="block block-form js-message-container"></ul>
						<div class="action-container">
							<button class="btn btn-white btn-block js-cancel">查看订单详情</button>
						</div>
					</div>
				</div>
			</div>
			<div id="js-self-fetch-modal" class="modal order-modal"></div>
			<div class="js-modal modal order-modal">
				<div class="js-scene-coupon-list scene hide">
					<div class="js-coupon-ui coupon-ui coupon-list">
						<div class="block">
							<div class="coupon-container">
								<div id="coupon--0" class="js-not-use block-item order-coupon order-coupon-item active">
									<label class="label-check">
										<div class="label-check-img"></div>
										<div class="coupon-info">
											<span>不使用优惠</span>
										</div>
									</label>
								</div>
							</div>
						</div>
						<div class="js-code-container">
							<h4 class="list-title">使用优惠码：</h4>
							<div class="js-coupon-container coupon-container block">
								<div class="js-code-inputer block-item order-coupon order-coupon-item">
									<label class="label-check">
										<div class="label-check-img label-check-img-inputer"></div>
										<div class="coupon-inputer">
											<input class="js-code-txt txt txt-coupon-code" type="text" placeholder="请输入优惠码" autocapitalize="off" maxlength="15"/>
											<button class="js-valid-code tag tag-big tag-blue" type="button" disabled="">验证</button>
										</div>
										<div class="js-coupon-info coupon-info"></div>
									</label>
								</div>
								<div class="js-coupon-code-list"></div>
							</div>
						</div>
						<div class="js-card-container" style="display: none;">
							<h4 class="list-title">使用优惠券：</h4>
							<div class="js-coupon-container coupon-container block"></div>
						</div>
					</div>
				</div>
				<div class="js-scene-address-list scene">
					<div class="address-ui address-list">
						<h4 class="list-title text-right"><a class="js-cancel-address-list" href="javascript:;">取消</a></h4>
						<div class="block">
							<div class="js-address-container address-container">
								<div style="min-height: 80px;" class="loading"></div>
							</div>
							<div class="block-item">
								<h4 class="js-add-address add-address">增加收货地址</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="js-scene-address-fm scene"></div>
			</div>
			<div class="js-confirm-use-coupon confirm-use-coupon" style="display:none;">
				<span class="js-total-privilege">总优惠：¥0.00</span>
				<button type="button" class="js-confirm-coupon btn btn-blue btn-xsmall font-size-14">确定</button>
			</div>
			<?php $noFooterLinks=true; include display('footer');?>
		</div>
	</body>
</html>
<?php Analytics($nowOrder['store_id'], 'pay', '订单支付', $nowOrder['order_id']); ?>
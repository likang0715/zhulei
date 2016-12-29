<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
		<title><?php echo $cutprice['name'];?></title>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/cutprice/js/swipe.min.js"></script> 
		<link href="<?php echo TPL_URL;?>index_style/cutprice/css/base.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo TPL_URL;?>index_style/cutprice/css/showcase.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo TPL_URL;?>index_style/cutprice/css/auction.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			$(function () { new Swipe(document.getElementById('banner_box'), { speed: 500, auto: 3000, callback: function () { var lis = $(this.element).next("ol").children(); lis.removeClass("on").eq(this.index).addClass("on") } }) });
			<?php if($state == 'stop' && $cutprice['inventory'] > 0){?>
			var nowprice = <?php echo $cutprice['stopprice'];?>;
			<?php }?>
			$(function(){
				
				setInterval("buyers()",60000);
				$(".but_guize").click(function(){
					$("#guize").removeClass("hide");
					$("#guize .js-ok").click(function(){
						$("#guize").addClass("hide");
					});
				});
				<?php if($memberNotice == NULL){?>
				$(".but_buy").click(function(){
					// 检查活动是否正在进行
					$.get('/wap/cutprice.php?action=check_cutprice&id=<?php echo $cutprice['pigcms_id']?>',{},function(response){
						if(response.err_code==1){
							alert(response.err_msg);
						}else{
							inventory(1);
							$("#buy .txt").val(1);
							$("#buy button").removeClass("disabled");
							$("#buy .minus").addClass("disabled");
							
							$(".js-goods-price").html(nowprice);
							$("#buy").removeClass("hide");
							$("#buy .js-cancel").click(function(){
								$("#buy").addClass("hide");
							});
						}
					},'json');
				});
				<?php }?>
				$(".js-tabber button").click(function(){
					$(".js-tabber button").removeClass("active");
					$(this).addClass("active");
					var tabber = $(this).attr('tabber');
					if(tabber == 1){
						buyers();
						$('.js-auction-log').removeClass('hide');
						$('.js-goods-detail').addClass('hide');
					}else{
						$('.js-goods-detail').removeClass('hide');
						$('.js-auction-log').addClass('hide');
					}
				});
			});
			function buyers(){
				$.ajax({
					type:"POST",
					url:'?action=ajax&token=<?php echo $token;?>',
					dataType:"json",
					data:{
						type:'buyers',
						token:"<?php echo $token;?>",
						wecha_id:"<?php echo $wecha_id;?>",
						id:<?php echo $_GET['id'];?>
					},
					success:function(data){
						if(data.buyers != ''){
							$('.js-auction-log').html(data.buyers);
						}
					}
				});
			}
			var inventory_num = 0;
			function inventory(type){
				$.ajax({
					type:"POST",
					url:'?action=ajax&token=<?php echo $token;?>',
					dataType:"json",
					data:{
						type:'inventory',
						token:"<?php echo $token;?>",
						wecha_id:"<?php echo $wecha_id;?>",
						id:<?php echo $_GET['id'];?>
					},
					success:function(data){
						if(data.inventory > 0){
							inventory_num = data.inventory;
							if(type == 0){
								$(".js-remain-num").html(data.inventory);
								$(".stock-num").html(data.inventory);
								alertalert('还剩'+data.inventory+'个，赶快入手吧！');
							}else{
								$(".js-remain-num").html(data.inventory);
								$(".stock-num").html(data.inventory);
							}
						}else{
							location.reload();
						}
					}
				});
			}
		</script>

		<style>
body {font-family: "微软雅黑";}
	.layer {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.5);
        z-index: 9;
    }

    .layer_content {
         background: #fff;
		position: fixed;
		width: 15rem;
		left: 50%;
		top: 50%;
		text-align: center;
		z-index: 901;
		height: 19rem;
		margin-top: -8.5rem;
		margin-left: -7.5rem;

    }
    .layer_content .layer_title {
        font-size: .55rem;
        color: #fff;
        line-height: .9rem;
        padding: .3rem .5rem;
        background: #45a5cf;
        text-align: left;
        text-indent: 1.2rem;
    }
    .layer_content p {
        font-size: .55rem;
        color: #333333;
        line-height: 1.4rem;
    }
    .layer_content img {
        width: 8rem;
        margin: 1rem 0;
    }
    .layer_content p span {
        font-size: .45rem;
        color: #999;
        line-height: 0.9rem;
    }

    .layer_content button {
        background: #ff9c00;
        width: 5.5rem;
        height: 1.5rem;
        color: #fff;
        line-height: 1.5rem;
        border-radius: 1.5rem;
        margin: .6rem 0;
    }

    .layer_content i {
        background: url(/template/wap/default/ucenter/images/weidian_25.png) no-repeat;
        background-size: 1rem;
        height: 1.2rem;
        width: 1.24rem;
        display: inline-block;
        vertical-align: middle;
        position: absolute;
        right: -.5rem;
        top: -.5rem;
    }
			.window {
				width: 240px;
				position: fixed;
				display: none;
				margin: -50px auto 0 -120px;
				padding: 2px;
				top: 50%;
				left: 50%;
				border-radius: 0.6em;
				-webkit-border-radius: 0.6em;
				-moz-border-radius: 0.6em;
				background-color: rgba(255, 0, 0, 0.5);
				-webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
				-moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
				-o-box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
				font: 14px/1.5 Microsoft YaHei,Helvitica,Verdana,Arial,san-serif;
				z-index: 99999;
				bottom: auto;
			}

			.window .tip {
				overflow: auto;
				padding: 10px;
				color: #222222;
				text-shadow: 0 1px 0 #FFFFFF;
				border-radius: 0 0 0.6em 0.6em;
			}
			.window #txt {
				min-height: 30px;
				font-size: 15px;
				line-height: 22px;
				color: #FFF;
				text-align: center;
			}
			.buyer{width:100%;height:40px;padding:5px;line-height:30px;font-size:12px}
			.buyerinfo{float:left;width:33%;height:100%;text-align:center};
		</style>
	</head>
	<body>
		<?php echo $memberNotice==null?'':$memberNotice;?>
		<style>.box_swipe {overflow: hidden;position: relative;background-color: #fff;}.box_swipe>ol {height: 20px;position: relative;z-index: 10;margin-top: -35px;text-align: center;margin-bottom: 0;background-color: rgba(0,0,0,0.3);}.box_swipe>ol>li.on {background-color: #fff;}.box_swipe>ol>li {display: inline-block;margin: 6px 2px;width: 8px;height: 8px;background-color: #757575;border-radius: 8px;}</style>
		<div class="content " style="min-height: 13px;">
			<div>
				<div id="banner_box" class="box_swipe" style="visibility: visible;">
					<ul id="swipe-box">
						<li>
							<a href="<?php echo $cutprice['logourl1'];?>">
								<img src="/upload/<?php echo $pruduct_main['image'];?>" style="width: 100%;">
							</a>
						</li>
						<?php foreach($product_imgs as $img){?>
						<li>
							<a href="<?php echo $img['logourl2'];?>">
								<img src="/upload/<?php echo $img['image'];?>" style="width: 100%;">
							</a>
						</li>
						<?php }?>
					</ul>
					<ol>
						<li class="on"></li>
						<?php if($cutprice['logoimg2']){?>
						<li></li>
						<?php }?>
						
						<?php if($cutprice['logoimg3']){?>
						<li></li>
						<?php }?>
					</ol>
				</div>
			</div>
			<div class="goods-basic-info">
				<h2 class="font-size-16 c-black"><?php echo $cutprice['name']?></h2>
				<?php if($state == 'start' || $state == 'wait'){?>
				<p class="font-size-12 c-gray-dark clearfix">
					<span class="pull-left">
						当前价：
					</span>
					<span class="js-cur-price pull-left font-size-16 c-red cur-price">
						￥<?php echo $cutprice['nowprice'];?>
					</span>
					<span class="old-price line-through">
						原价：￥<?php echo $cutprice['original'];?>
					</span>
					<span class="old-price line-through">
						底价：￥<?php echo $cutprice['stopprice'];?>
					</span>
				</p>
				<?php }elseif($cutprice['inventory'] > 0){?>
					<span class="pull-left">
						当前价：
					</span>
					<span class="js-cur-price pull-left font-size-16 c-red cur-price">
						￥<?php echo $cutprice['stopprice'];?>
					</span>
					<span class="old-price line-through">
						原价：￥<?php echo $cutprice['original'];?>
					</span>
					<span class="old-price line-through">
						底价：￥<?php echo $cutprice['stopprice'];?>
					</span>
				<?php }?>
				<hr>
				<p class="font-size-12 c-black js-status clearfix relative">
					<?php if($state == 'start'){?>
					<span class="pull-left js-status-label">下次降价：</span>
					<span class="js-time-count-down font-size-16 pull-left"><?php echo $cutprice['min'];?>分<?php echo $cutprice['sec'];?>秒</span>
					<?php }?>
					<a class="font-size-12 badgebadge badge-rule but_guize" href="#">抢拍规则</a>
					<?php if($state == 'wait'){?>
					<span class="font-size-16 pull-left" style="color:red">未开始</span>
					<?php }?>
					<?php if($state == 'stop'){?>
					<span class="font-size-16 pull-left" style="color:red">已结束</span>
					<?php }?>
				</p>
				<?php if($state == 'start'){?>
				<p class="font-size-12 c-gray-dark clearfix">
					降价幅度：<span class="c-black">每<?php echo $cutprice['cuttime'];?>分钟降<?php echo $cutprice['cutprice'];?>元</span>
				</p>
				<?php }?>

			</div>
			<?php if($state == 'start'){?>
			<script type="text/javascript">
				var min = <?php echo $cutprice['min'];?>;
				var sec = <?php echo $cutprice['sec'];?>;
				var nowprice = <?php echo $cutprice['nowprice'];?>;
				var stopprice = <?php echo $cutprice['stopprice'];?>;
				$(function(){
					
					setInterval("inventory(0)",60000);
					
					down();
					
				});
				function down(){
					sec--;
					if(sec < 0){
						sec = 59;
						min--;
					}
					if(sec < 10){
						sec_c = '0'+sec;
					}else{
						sec_c = sec;
					}
					if(min < 10){
						min_c = '0'+min;
					}else{
						min_c = min;
					}
					if(min < 0){
						sec = 59;
						min = <?php echo $cutprice['cuttime']?> - 1;
						nowprice = nowprice - <?php echo $cutprice['cutprice'];?>;
						if(nowprice <= stopprice){
							location.reload();
						}else{
							$(".js-time-count-down").html('0'+min+'分'+sec+'秒');
							$(".js-cur-price").html('￥'+nowprice);
							setTimeout("down()",1000);
						}
					}else{
						$(".js-time-count-down").html(min_c+'分'+sec_c+'秒');
						setTimeout("down()",1000);
					}
					
				}
			</script>
			<?php }?>
			<?php if($state == 'start' || $state == 'wait' || $cutprice['inventory'] > 0){?>
			<div class="sku-detail">
				<div class="sku-detail-inner adv-opts-inner">
					<dl>
						<dt>库存：</dt>
						<dd class="js-remain-num"><?php echo $cutprice['inventory'];?></dd>
					</dl>
				</div>
			</div>
			<?php }?>
			<div class="js-components-container components-container">
				<div class="custom-store">
					<a class="custom-store-link clearfix" href="/wap/home.php?id=<?php echo $store_info['store_id']?>">
						<div class="custom-store-img"></div>
						<div class="custom-store-name"><?php echo $store_info['name']?></div>
						<span class="custom-store-enter">进入店铺</span>
					</a>
				</div>

				<div class="js-tabber tabber  red clearfix">
					<button class="active" tabber='0'>商品详情</button>
					<button class="" tabber='1'>中拍买家</button>
				</div>

				<div class="js-goods-detail goods-tabber-c">
					<div class="custom-richtext">
					<?php echo htmlspecialchars_decode($pruduct_main['info']);?>
					</div>
				</div>

				<div class="js-auction-log goods-tabber-c hide">
					<div><p style="text-align:center;line-height:60px;">还没有人抢到！</p></div>
				</div>

			</div>
			<div class="js-bottom-opts js-footer-auto-ele bottom-fix" style="z-index:0">
				<div class="btn-1-1">
					<?php if($state == 'wait'){?>
					<button class="btn disabled">未开始</button>
					<?php }?>
					<?php if($state == 'start' || ($cutprice['inventory'] > 0 && $state != 'wait'&&$state != 'stop')){?>
					<button class="btn btn-red but_buy">立即拿下</button>
					<?php }?>
					<?php if($state == 'stop' || $cutprice['inventory'] < 1){?>
					<button class="btn disabled">已结束</button>
					<?php }?>
				</div>
			</div>
		</div>
		<div class="js-footer" style="min-height: 1px;margin-bottom:60px">
			<div class="footer">
				<div class="copyright">
					<div class="ft-links">
					<a href="/wap/home.php?id=<?php echo $store_info['store_id']?>">店铺主页</a>
					<a href="/wap/ucenter.php?id=<?php echo $store_info['store_id']?>">个人中心</a>
					</div>
				</div>
			</div>
		</div>
		<div id="guize" class="hide">
			<div id="hei" style="height: 100%; position: fixed; top: 0px; left: 0px; right: 0px; z-index: 1000; opacity: 1; transition: none 0.2s ease; -webkit-transition: none 0.2s ease; background-color: rgba(0, 0, 0, 0.8);"></div>
			<div id="guizeinfo" class="popout-box" style="overflow: hidden; visibility: visible; position: fixed; z-index: 1000; transition: opacity 300ms ease; -webkit-transition: opacity 300ms ease; opacity: 1; top: 50%; left: 50%; -webkit-transform: translate3d(-50%, -50%, 0px); border-radius: 4px; width: 270px; padding: 15px; background: white;">
				<form class="form-dialog">
					<div class="header">
						<h2> <span>抢拍规则</span> </h2>
					</div>
					<fieldset class="body">
						<p class="font-size-14"><?php echo $cutprice['info'];?></p>
					</fieldset>
					<div class="action-container">
						<button type="button" class="js-ok btn btn-green btn-block">我知道了</button>
					</div>
				</form>
			</div>
		</div>
		<div class="window" id="windowcenter" style="margin-top:50px;">
			<div class="tip">
				<div id="txt"></div>
			</div>
		</div>
		<script type="text/javascript">
			function alertalert(title){ 
				$("#windowcenter").slideToggle("slow"); 
				$("#txt").html(title);
				setTimeout(function(){
					$("#windowcenter").slideUp(500)
				},3000);
			}
			$(function(){
				$("#buy .response-area-minus").click(function(){
					var goods_num = $("#buy .txt").val();
					goods_num--;
					if(goods_num*1 < 2){
						$("#buy button").removeClass("disabled");
						$("#buy .minus").addClass("disabled");
						if(goods_num*1 < 1){
							goods_num = 1;
						}
					}
					$("#buy .txt").val(goods_num);
					$("#buy .js-goods-price").html((nowprice*1)*(goods_num*1));
				});
				$("#buy .response-area-plus").click(function(){
					var goods_num = $("#buy .txt").val();
					var onebuynum = <?php echo $cutprice['onebuynum']?>;
					if(onebuynum > 0 && inventory_num - onebuynum > 0){
						if(goods_num*1 < onebuynum){
							goods_num++;
							$("#buy button").removeClass("disabled");
							if(goods_num*1 > onebuynum-1){
								goods_num = onebuynum;
								$("#buy .plus").addClass("disabled");
							}
						}else{
							goods_num = onebuynum;
							$("#buy .plus").addClass("disabled");
						}
					}else{
						if(goods_num*1 < inventory_num){
							goods_num++;
							$("#buy button").removeClass("disabled");
							if(goods_num*1 > inventory_num-1){
								goods_num = inventory_num;
								$("#buy .plus").addClass("disabled");
							}
						}else{
							goods_num = inventory_num;
							$("#buy .plus").addClass("disabled");
						}
					}
					$("#buy .txt").val(goods_num);
					$("#buy .js-goods-price").html((nowprice*1)*(goods_num*1));
				});
				$("#buy .js-confirm-it").click(function(){
					// 检查是否有收货地址
					$.get('/wap/cutprice.php?action=checkAddress',{},function(response){
						if(response.err_code==1){
							window.location.href='/wap/cutprice.php?action=myaddress&pigcms_id=<?php echo $cutprice['pigcms_id'];?>';
						}else{
							var goods_num = $("#buy .txt").val();
							var pigcms_id = <?php echo $cutprice['pigcms_id'];?>;
							var product_id = <?php echo $cutprice['product_id'];?>;
							var sku_id = <?php echo (int)$cutprice['sku_id'];?>;
							var store_id = <?php echo $cutprice['store_id']?>;
							$.post('/wap/saveorder.php',{'type':55,'pigcms_id':pigcms_id,'proId':product_id,'skuId':sku_id,'quantity':goods_num,'nowprice':nowprice,'storeId':store_id},function(response){
								if(response.err_code==0){
									window.location.href='/wap/pay.php?id='+response.err_msg+'&showwxpaytitle=1';
								}else{
									alert(response.err_msg);
								}
							},'json');
						}
					},'json');
					//window.location.href='/Wap/cutprice.php?action=saveorder&token=<?php echo $token;?>&id=<?php echo $_GET["id"];?>&num='+goods_num+'&nowprice='+nowprice;
				});
			});
		</script>
		<div id="buy" class="hide">
			<div id="" style="height: 100%; position: fixed; top: 0px; left: 0px; right: 0px; z-index: 1000; opacity: 1; transition: none 0.2s ease; -webkit-transition: none 0.2s ease; background-color: rgba(0, 0, 0, 0.8);"></div>
			<div id="" class="sku-layout sku-box-shadow" style="overflow: hidden; opacity: 1; bottom: 0px; left: 0px; right: 0px; height: 184px; position: fixed; z-index: 1000;">
				<div class="layout-title sku-box-shadow name-card sku-name-card">
					<div class="thumb"><img src="/upload/<?php echo $pruduct_main['image']?>" alt=""></div>
					<div class="detail goods-base-info clearfix">
						<p class="title c-black ellipsis"><?php echo $pruduct_main['name']?></p>
						<div class="goods-price clearfix">
							<div class="current-price c-black pull-left">
								<span class="price-name pull-left font-size-14 c-orange">￥</span><i class="js-goods-price price font-size-18 c-orange vertical-middle"><?php echo $cutprice['nowprice']?></i>
							</div>
						</div>
					</div> 
					<div class="js-cancel sku-cancel">
						<div class="cancel-img"></div>
					</div>
				</div>

				<div class="adv-opts layout-content" style="height: 124px;">
					<div class="goods-models js-sku-views block block-list block-border-top-none">
						<dl class="clearfix block-item">
							<dt class="model-title sku-num pull-left">
								<label>数量</label>
							</dt>
							<dd>
								<dl class="clearfix">
									<div class="quantity">
										<button class="minus disabled" type="button"></button>
										<input type="text" class="txt" value="1" readonly="">
										<button class="plus" type="button"></button>
										<div class="response-area response-area-minus"></div>
										<div class="response-area response-area-plus"></div>
										<div class="txtCover"></div>
									</div>
									<div class="stock pull-right font-size-12">
										<dt class="model-title stock-label pull-left">
											<label>剩余: </label>
										</dt>
										<dd class="stock-num">
											<?php echo $cutprice['inventory']?>
										</dd>
									</div>
								</dl>
							</dd>
						</dl>
						<div class="block-item block-item-messages" style="display: none;"></div>
					</div>
					<div class="confirm-action content-foot">
						<a href="javascript:;" class="js-confirm-it btn btn-block btn-orange-dark">下一步</a>
					</div>
				</div>
			</div>
		</div>
<?php if ($cutprice['state_subscribe'] == 0 && empty($subscribe)) {?>
    <aside>
        <div class="layer"></div>
        <div class="layer_content">
            <!-- <i class="close"></i> -->
            <div class="layer_title">亲，店家发现你还未关注店家的公众号，关注后才能参加店铺活动哦</div>
            <div class="layer_text">
                <p>第一步：长按二维码并识别</p>
                <img style="margin: 0 auto;" src="<?php echo $_result['ticket'];?>" >
                <p>第二步：打开图文再次进入本次活动</p>
            </div>
        </div>
    </aside>
<?php
}
?>
	</body>
</html>
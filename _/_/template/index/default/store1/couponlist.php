

<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/store.css">
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">

<!--[if lt IE 9]>
<script src="<?php echo TPL_URL;?>js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="<?php echo TPL_URL;?>js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}

</style>
<![endif]-->
<style>
.youhuiquan_shop{
    position: absolute;
    width: 95%;
    height: 159px;
    text-align: right;
    padding: 10px;
    background: rgba(0, 0, 0, 0.71);
    z-index: 9;
	display:none
}

.keyilin li{position:relative}
.youhiquan_shuoming {font-size: 16px;left: 91px; position: absolute;text-align: left;top: 14px;}
	#pageflip2 {RIGHT: 0px; FLOAT: right; POSITION: relative; TOP: 6px; }
	.pageflip .pageflipimg {Z-INDEX: 99; RIGHT: 0px; WIDTH: 0px; POSITION: absolute; TOP: 6px; HEIGHT: 0px; ms-interpolation-mode: bicubic}
	.pageflip .msg_block { z-index:2;RIGHT: 0px; BACKGROUND: url(<?php echo TPL_URL;?>images/ico/subscribe.png) no-repeat right top; OVERFLOW: hidden; WIDTH: 0px; POSITION: absolute; TOP: 6px; HEIGHT: 0px}

.youhiquan_linqu {
    font-size: 17px;
    left: 24px;
    line-height: 41px;
    margin-left: 10px;
    position: absolute;
    top: 24px;
    width: 27px;
}

.keyilin li {
    float: left;
    margin: 7px 11px 26px;
    width: 378px;
}
</style>
	<SCRIPT type=text/javascript>
		$(function(){
			$(".pageflip").hover(function() {
				var index = $(".pageflip").index($(this));
				$(this).find(".msg_block,.pageflipimg").stop().animate({
					width: '80px',
					height: '80px'
				}, 500);
			} , function() {
				$(".pageflipimg").stop().animate({
						width: '0',
						height: '0'
					}, 220);
				$(".msg_block").stop().animate({
						width: '0',
						height: '0'
					}, 200);
			});
			//url跳转
			$("#pages a").click(function () {
				var page = $(this).attr("data-page-num");
				changePage(page);

			});



		});

		
		function jumpPage() {
			var page = $("#jump_page").val();
			changePage(page);
		}
		
		function changePage(page) {
			if (page.length == 0) {
				return;
			}

			var re = /^[0-9]*[1-9][0-9]*$/;
			if (!re.test(page)) {
				alert("请填写正确的页数");
				return;
			}
			var tpage = "<?php echo $total_pages;?>";
			if(page > tpage) {page = tpage;}

			getCoupons(page);
			
			//var url = "<?php echo url('store:couponlist',array('storeid' => $store['store_id'])) ?>&page=" + page;
		
			//location.href = url;
		}	
	</SCRIPT>
 <div class="yuuhuiquan">
	<div class="youhuiquan_list">
		<div class="youhuiquan_title">可领取的优惠券<?php if(!count($coupon_list)) {?><span style="padding-left:20px; font-size:14px;">暂无</span><?php } ?></div>
		<?php if(count($coupon_list)>0) {?>
		<ul class="keyilin clearfix">
			<?php foreach($coupon_list as $k=>$v) {?>
				<li class="pageflip">
				<a href="javascript:show_detail(<?php echo $v['id'];?>)"><IMG class="pageflipimg" alt="" src="/template/index/default/js/page_flip.png" style="width: 0px; height: 0px;"></a>
				<div class="msg_block" style="width: 0px; height: 0px;"></div>
				<a href="javascript:void(0)" onclick="javascript:addCoupon(<?php echo $v['id'];?>)">
					<div class="youhuiquan_info  clearfix">
					<div class="youhui_centent">
						<div class="youhuiquan_shop youhuiquan_id_<?php echo $v['id']?>" onclick="hide_detail(<?php echo $v['id']?>)">
							<div class="youhuiquan_shop_title">券类型</div>
							<div class="youhuiquan_shop_list"><i>券类型:</i><span id="coupon_type_<?php echo $v['id']?>"></span></div>
							<div class="youhuiquan_shop_list"><i>面额:</i>￥<span id="coupon_money_<?php echo $v['id']?>">1000.00</span></div>
							<div class="youhuiquan_shop_list"><i>使用门槛: </i id="coupon_limit_<?php echo $v['id']?>">无使用限制</div>
							<div class="youhuiquan_shop_list"><i>有效期限:</i><span id="coupon_start_<?php echo $v['id']?>">2016-05-05</span>至<span id="coupon_end_<?php echo $v['id']?>">2016-06-02</span></div>
						</div>
					</div>


						<div class="youhiquan_linqu">点击领取</div>
						<div class="youhiquan_shuoming">订单金额满<?php echo $v['limit_money'];?>元即可使用</div>
						<div class="youhiquan_price">￥<span><?php echo $v['face_money']?></span></div>
						<div class="youhiquan_data">有效期限:<span><?php echo date("Y-m-d", $v['start_time']);?> </span>至<span><?php echo date("Y-m-d", $v['end_time']);?> </span></div>
					</div></a>
				</li>
			<?php }?>
		</ul>
		<?php }?>	
		<?php if(count($coupon_list)>0) {?>
		    <div class="page_list" id="pages">
			    <dl>
				    <?php echo $pages ?>
				    <dt>
					    <form onsubmit="return false;">
						    <span>跳转到:</span>
						    <input type="text" value="" id="jump_page" name="currentPage" class="J_topage page-skip">
						    <button onclick="javascript:jumpPage()">GO</button>
					    </form>
				    </dt>
			    </dl>
		    </div>
		<?php }?>
	</div>
</div>
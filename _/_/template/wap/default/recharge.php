<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商家充值</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/my_store_withdrawal.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/font-awesome.min.css">
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo TPL_URL; ?>js/jquery.ba-hashchange.js"></script>
	<script type="text/javascript">
		var store_id = "<?php echo $store['store_id']; ?>";
	</script>
	<style type="text/css">
		html{
			background: #f5f5f5;
		}
		.account-btn{
			width:50px;
		}
		.accountdiva:first-child{
			border-top: solid 1px #e1e1e1;
		}
		.buesscash-fl {
			width: 100px;
		}
		.to-money-div {
			display: none;
		}
		.withdrawal-money-div {
			display: none;
		}
		.cancel-btn {
			margin-top: 0px;
			background-color: lightgrey;
		}
	</style>
</head>
<body>
<!-- 导航条 -->
<div class="accountnav" style="margin-bottom: 10px;">
	<div class="fl accountnavli" data-hash="#point">帐号充值</div>
	<div class="clear"></div>
</div>

<div class="accountdiv">
	<div class="accountdiva">
		<div class="fl buesscash-fl">充值金额</div>
		<div class="fl"><input type="text" class="amount" id="amount" placeholder="最低充值金额<?php echo option('credit.cash_min_amount'); ?>元" /></div>
		<div class="clear"></div>
	</div>

	<div class="accountdiva" style="border: 0px;">
		<div class="fl buesscash-fl">充值方式</div>
		<div class="clear"></div>
	</div>
	
	<ul class="buesspaylist">
		<?php 
		$i = 0;
		foreach ($payMethodList as $key => $pay_method) {
			$class = '';
			if ($key == 'allinpay') {
				$class = 'yinlian';
			} else if ($key == 'platform_weixin') {
				$class = 'weixin';
			} else if ($key == 'platform_alipay') {
				$class = 'zhifubao';
			}
		?>
			<li>
				<div class="fl">
					<span class="fl <?php echo $class; ?> paytype"> <?php echo $pay_method['name']; ?></span>
					<div class="clear"></div>
				</div>
				<!--  选中样式：buess-pay-select-ok   未选中样式：buess-pay-select-no   -->
				<div class="fr <?php echo $i == 0 ? 'buess-pay-select-ok' : 'buess-pay-select-no'; ?> js-select" data-pay_type="<?php echo $key; ?>"></div>
				<div class="clear"></div>
			</li>
		<?php 
			$i++;
		}
		?>
	</ul>
	
	<div class="btn save-btn" id="dorecharge">立即充值</div>
</div>
</body>
<script type="text/javascript">
	$(function() {
		var min_margin_balance = "<?php echo option('credit.cash_min_amount'); ?>";
		$(".buesspaylist li").click(function() {
			$(".buesspaylist li").find(".js-select").removeClass("buess-pay-select-ok").addClass("buess-pay-select-no");
			$(this).find(".js-select").addClass("buess-pay-select-ok").removeClass("buess-pay-select-no");
		});
		
		$('#dorecharge').click(function () {
			var amount = $.trim($('#amount').val());
			var pay_type = $(".buess-pay-select-ok").data("pay_type");
			amount = parseInt(amount);
			if(isNaN(amount)){
				alert('充值金额不正确');
				return;
			}
			
			if (parseFloat(amount) < parseFloat(min_margin_balance)) {
				alert("充值金额不能少于" + min_margin_balance + "元");
				return;
			}
			
			window.location.href="?store_id=<?php echo $store['store_id']; ?>&amount="+amount+"&pay_type=" + pay_type + "&flag=1";
		});
	});
</script>
</html>
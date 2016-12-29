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
<div id="addAdress" class="modal order-modal active"><div>
<form class="js-address-fm address-ui address-fm">
<input type="hidden" id="active_id" value="<?php echo $pigcms_id;?>"/>
<div class="block" style="margin-bottom:10px;">
	<div class="block-item">
		<label class="form-row form-text-row">
			<em class="form-text-label">收货人</em>
			<span class="input-wrapper"><input type="text" name="user_name" id="user_name" class="form-text-input" value="" placeholder="名字"></span>
		</label>
	</div>
	<div class="block-item">
		<label class="form-row form-text-row">
			<em class="form-text-label">联系电话</em>
			<span class="input-wrapper"><input type="tel" name="tel" id="tel" class="form-text-input" value="" placeholder="手机或固话"></span>
		</label>
	</div>
	<div class="block-item">
		<div class="form-row form-text-row">
			<em class="form-text-label">选择地区</em>
			<div class="input-wrapper input-region js-area-select">
				<span>
					<select id="province" name="province" class="address-province">
						<option value="">选择省份</option>
					</select>
				</span>
				<span>
					<select id="city" name="city" class="address-city">
						<option>城市</option>
					</select>
				</span>
				<span>
					<select id="county" name="county" class="address-county">
						<option>区县</option>
					</select>
				</span>
			</div>
		</div>
	</div>
	<div class="block-item">
		<label class="form-row form-text-row">
			<em class="form-text-label">详细地址</em>
			<span class="input-wrapper"><input type="text" name="address" id="address" class="form-text-input" value="" placeholder="街道门牌信息"></span>
		</label>
	</div>
	<div class="block-item">
		<label class="form-row form-text-row">
			<em class="form-text-label">邮政编码</em>
			<span class="input-wrapper"><input type="tel" maxlength="6" name="zipcode" id="zipcode" class="form-text-input" value="" placeholder="邮政编码"></span>
		</label>
	</div>
</div>
<div>
	<div class="action-container">
		<a class="js-address-save btn btn-block btn-blue" href="javascript:;" onclick="save_address()">保存</a>
		<!--<a class="js-address-cancel btn btn-block">取消</a>-->
	</div>
</div>
</form>
</div>
</div>
</html>
<script type="text/javascript">
getProvinces('province','','省份');
$('#province').live('change',function(){
	if($(this).val() != ''){
		getCitys('city','province','','城市');
	}else{
		$('#city').html('<option>城市</option>');
	}
	$('#county').html('<option>区县</option>');
});

$('#city').live('change',function(){
	if($(this).val() != ''){
		getAreas('county','city','','区县');
	}else{
		$('#county').html('<option>区县</option>');
	}
});

// 保存收货地址
function save_address(){
	var name = $.trim($('#user_name').val());
	var tel = $.trim($('#tel').val());
	var province = $('#province').val();
	var city = $('#city').val();
	var area = $('#county').val();
	var address = $('#address').val();
	var zipcode = $.trim($('#zipcode').val());
	if(name == ''){
		motify.log('请填写收货人');
		return;
	}
	if(tel == ''){
		motify.log('请填写联系电话');
		return;
	}
	if(province == '' || city == '' || area == ''){
		motify.log('请选择省市区');
		return;
	}
	if(address == ''){
		motify.log('请填写收货地址');
		return;
	}
	$.post('/wap/address.php?action=add',{'name':name,'tel':tel,'province':province,'city':city,'area':area,'address':address,'zipcode':zipcode},function(response){
		if(response.err_code==0){
			var active_id = $('#active_id').val();
			window.location.href= '<?php echo $return_url;?>';
		}else{
			motify.log(response.err_msg);
		}
	},'json');
}
</script>
<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>维权申请-<?php echo $config[ 'site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/cart.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'] ?>/static/css/jquery.ui.css" />
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js"></script>
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script src="<?php echo TPL_URL;?>js/index2.js"></script>
<script src="<?php echo TPL_URL;?>js/rights_apply.js"></script>
<script>
var return_apply_url = "<?php echo url('order:return_apply') ?>";
</script>
<style>
.box{position:relative; float:left;}
.zclip {left:258px; top:36px;}
</style>
<!--[if lt IE 9]>
<script src="js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->
</head>
<body>
<?php include display( 'public:header_order');?>
<div class="order_content ">
	<div class="Breadcrumbs"> 您的位置：<a href="/">首页</a> &gt; <a href="<?php echo url('account:index') ?>">会员中心</a> &gt; <a href="<?php echo url('account:rights') ?>" class="current">维权</a> </div>
	<div class="order_zhuangtai clearfix">
		<div class="order_zhuangtai_txt">
			<span>维权申请</span>
		</div>
	</div>
	<div class="order_contetn_add">
		<div class="order_order">
			<div class="order_add_titele clearfix"><i>维权的宝贝信息</i></div>
			<ul class="order_add_table">
				<li class="order_product_title clearfix">
					<div class="product_1" style="width:756px;">商品</div>
					<div class="product_2">单价(元)</div>
					<div class="product_3">可申请维权数</div>
				</li>
				<li>
					<dl>
						<?php 
						foreach ($order['proList'] as $product) {
							if ($product['pigcms_id'] != $pigcms_id) {
								continue;
							}
						?>
							<dd class="clearfix">
								<div class="product_1 clearfix" style="width:756px;">
									<div class="order_product_img" style="height:78px;">
										<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>"><img src="<?php echo getAttachmentUrl($product['image']) ?>"></a>
									</div>
									<div class="order_product_txt">
										<div class="order_product_txt_name"><a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>"><?php echo htmlspecialchars($product['name']) ?></a></div>
										<?php 
										if (is_array($product['sku_data_arr'])) {
										?>
											<div class="order_product_txt_dec clearfix">
										<?php
												foreach ($product['sku_data_arr'] as $sku_data) {
										?>
													<div class="order_product_txt_dec_l"><?php echo $sku_data['name'] ?>:<span><?php echo $sku_data['value'] ?>&nbsp;</span></div>
										<?php 
											}
										?>
											</div>
										<?php
										}
										?>
									</div>
								</div>
								<div class="product_2" class="js-price"><?php echo $product['pro_price'] ?></div>
								<div class="product_3">
									<?php 
									if ($return_number) {
										echo '已退：' . $return_number . '件,还可退：' . ($product['pro_num'] - $return_number) . '件';
									} else {
										echo $product['pro_num'];
									}
									?>
								</div>
							</dd>
						<?php 
						}
						?>
					</dl>
				</li>
			</ul>
		</div>
	</div>
	<div class="order_order order_gengzong">
		<div class="order_add_titele ">维权申请信息</div>
		<div  class="order_gengzong_list">
			<div class="order_gengzong_select clearfix">
				<div class="order_gengzong_txt">维权理由:</div>
				<select class="js-type">
					<?php 
					foreach ($type_arr as $key => $type) {
					?>
						<option value="<?php echo $key ?>"><?php echo $type ?></option>
					<?php 
					}
					?>
				</select>
			</div>
			<div class="order_gengzong_select clearfix">
				<div class="order_gengzong_txt">手机号码:</div>
				<input style="border: 1px solid #2ecc9e; margin:0 15px; width:220px; height:32px;" id="phone" placeholder="请填写手机号方便与您联系" />
			</div>
			<div class="order_gengzong_select clearfix">
				<div class="order_gengzong_txt">维权原因:</div>
				<textarea style="border: 1px solid #2ecc9e; margin:0 15px; width:400px; height:80px;" id="content" placeholder="请填写维权原因"></textarea>
			</div>
			<div class="order_gengzong_select clearfix">
				<div class="order_gengzong_txt">维权数量:</div>
				<select name="pro_num">
					<?php 
					for ($i = 1; $i <= $product['pro_num'] - $return_number; $i++) {
					?>
						<option value="<?php echo $i ?>"><?php echo $i ?></option>
					<?php
					}
					?>
				</select>
			</div>
			
			<div class="order_gengzong_select clearfix">
				<div class="order_gengzong_txt">维权图片: 最多可上传5张</div>
				
			</div>
			<style>
			.js-image-list {padding:0px; margin:0px; list-style:none;}
			.js-image-list li {float:left; margin-left:5px; position: relative; border:1px solid #d9d9d9 }
			.js-image-list li img {width:100px; height:100px;}
			.js-image-list span {  background: url(<?php echo TPL_URL;?>/images/weidian_icon.png) 193px -412px; width: 15px; height: 15px; position: absolute; top: 0; right: 0;}
			</style>
			<div class="order_gengzong_select clearfix shop_pingjia_list" style="padding-left:70px;">
				<ul class="js-image-list" style="float:left; margin-right:5px;">
				</ul>
				<form enctype="multipart/form-data" id="upload_image_form" target="iframe_upload_image" method="post" action="<?php echo url('order:attachment') ?>">
					<div class="updat_pic" style="float:left;">
						<a href="javascript:" id="upload_jiahao"><img src="<?php echo TPL_URL;?>/images/jiahao.png" /></a>
						<input type="file" name="file" class="ehdel_upload" id="upload_image" style="display:none;" accept="image/*" />
						<p>0/5</p>
					</div>
				</form>
				<iframe name="iframe_upload_image" style="width:0px; height:0px; display:none;"></iframe>
			</div>
			<div class="order_gengzong_select clearfix" style="padding-left:100px; margin-bottom:20px;">
				<button class="js-submit" data-type="default">提交申请</button>
			</div>
		</div>
	</div>
</div>
<?php include display( 'public:footer');?>
</body>
</html>
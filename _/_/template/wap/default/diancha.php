<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
<head>
	<meta charset="utf-8"/>
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" content="<?php echo $config['seo_description'];?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="renderer" content="webkit">
	<meta name="format-detection" content="telephone=no" />
	<meta name="format-detection" content="email=no" />
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<title>点茶预约</title>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/order_table.css">
	<script src="<?php echo TPL_URL;?>/diancha/js/jquery-1.11.0.min.js"></script>
	<script src="<?php echo TPL_URL;?>/diancha/js/order_table.js"></script>
	<link href="<?php echo TPL_URL;?>/diancha/css/mobiscroll.core-2.5.2.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo TPL_URL;?>/diancha/css/mobiscroll.animation-2.5.2.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo TPL_URL;?>/diancha/css/mobiscroll.android-ics-2.5.2.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo TPL_URL;?>/diancha/js/mobiscroll.core-2.5.2.js"></script>
	<script src="<?php echo TPL_URL;?>/diancha/js/mobiscroll.core-2.5.2-zh.js"></script>
	<script src="<?php echo TPL_URL;?>/diancha/js/mobiscroll.datetime-2.5.1.js"></script>
	<script src="<?php echo TPL_URL;?>/diancha/js/mobiscroll.datetime-2.5.1-zh.js"></script>
	<script src="<?php echo TPL_URL;?>/diancha/js/mobiscroll.android-ics-2.5.2.js"></script>
	<script src="<?php echo TPL_URL;?>/diancha/js/Validform_v5.3.2_min.js"></script>
	<script>
	$(function () {
		var nowData=new Date();
		var opt= { 
			theme:'ios', 
			mode:'scroller', 
			display:'bottom', 
			preset : 'datetime', 
			minDate: new Date(nowData.getFullYear(),nowData.getMonth(),nowData.getDate(),nowData.getHours()+1,00), 
			maxDate:new Date(nowData.getFullYear(),nowData.getMonth(),nowData.getDate()+7,nowData.getHours(),00),
			stepMinute: 60,
			yearText:'年', 
			monthText:'月',
			dayText:'日',
			hourText:'时',
			minuteText:'分',
			lang:'zh',
			tap:true
		};
		$('.gotime').mobiscroll(opt);
	});
	</script>

</head>
<body class="order_table FastClick">
	
	<div class="order_table_t">
		<ul>
			<li class="order_type fast_type<?php if ($bid || $fid) {?><?php }else{?> cur_type<?php } ?>">快速预订</li>
			<li class="order_type normal_type<?php if ($bid || $fid) {?> cur_type<?php } ?>">个性预订</li>
		</ul>
	</div>
	<div class="order_main">
		<div class="fast_order<?php if ($bid || $fid) {?><?php }else{?> cur_order<?php } ?>">
			<form method="post" action="./yuyue.php?id=<?php echo $store_xq['store_id'];?>&pigcms_id=<?php echo $store_xq['pigcms_id'];?>" id="fast_order">
				<input  type="hidden" name="store_id" value="<?php echo $store_xq['store_id'];?>" />
				<input  type="hidden" name="pigcms_id" value="<?php echo $store_xq['pigcms_id'];?>" />
				<div class="order_table_store">
					<div class="store_info">
						<div class="store_logo"><img src="<?php echo $store_xq['images'];?>"></div>
						<div class="store_text">
							<a href="physical_show.php?id=<?php echo $store_xq['pigcms_id'];?>">
								<h4 class="store_title sl"><?php echo $store_xq['name'];?></h4>
								<span class="store_tel sl"><?php if($store_xq['phone1']){ echo $store_xq['phone1'];}?>-<?php echo $store_xq['phone2'];?></span>
								<span class="store_address sl"><?php echo $store_xq['address'];?></span>
							</a>
						</div>
					</div>
					<div class="store_more"><a href="<?php echo $now_url;?>">其它分店</a></div>
				</div>
				<div class="order_table_edit">
					<div class="edit_item">
						<div class="edit_title">姓名</div>
						<div class="edit_input">
							<input type="text" placeholder="请输入姓名" name="name" datatype="*" class="no-border">
						</div>
					</div>
					<div class="edit_item">
						<div class="edit_title">手机号</div>
						<div class="edit_input">
							<input type="text" placeholder="请输入手机号" name="tel" class="no-border" datatype="m">
						</div>
					</div>
					<div class="edit_item edit_num">
						<div class="edit_title">人数</div>
						<div class="edit_input">
							<span class="num_less">-</span>
							<input type="text" value="1" name="num" class="no-border" datatype="*" readonly>
							<span class="num_add">+</span>
						</div>
					</div>
					<div class="edit_item edit_gotime">
						<div class="edit_title">到店时间</div>
						<div class="edit_input">
							<input type="text" placeholder="请选择到店时间" name="gotime" class="no-border gotime" datatype="*">
						</div>
					</div>
				</div>
				<div class="order_table_submit">
					<input type="hidden" name="time" value="1">
					<input type="submit" class="order_submit" value="提交预约" disabled>
				</div>
			</form>
		</div>
		<div class="normal_order<?php if ($bid || $fid) {?> cur_order<?php } ?>">
			<form method="post" action="./yuyue.php?id=<?php echo $store_xq['store_id'];?>&pigcms_id=<?php echo $store_xq['pigcms_id'];?>" id="normal_order">
				<input  type="hidden" name="store_id" value="<?php echo $store_xq['store_id'];?>" />
				<input  type="hidden" name="pigcms_id" value="<?php echo $store_xq['pigcms_id'];?>" />
				<div class="order_table_store">
					<div class="store_info">
						<div class="store_logo"><img src="<?php echo $store_xq['images'];?>"></div>
						<div class="store_text">
							<a href="physical_show.php?id=<?php echo $store_xq['pigcms_id'];?>">
								<h4 class="store_title sl"><?php echo $store_xq['name'];?></h4>
								<span class="store_tel sl"><?php if($store_xq['phone1']){ echo $store_xq['phone1'];}?>-<?php echo $store_xq['phone2'];?></span>
								<span class="store_address sl"><?php echo $store_xq['address'];?></span>
							</a>
						</div>
					</div>
					<div class="store_more"><a href="<?php echo $now_url;?>">其它分店</a></div>
				</div>
				<div class="order_table_edit">
					<div class="edit_item">
						<div class="edit_title">姓名</div>
						<div class="edit_input">
							<input type="text" placeholder="请输入姓名" name="name" datatype="*" class="no-border">
						</div>
					</div>
					<div class="edit_item">
						<div class="edit_title">手机号</div>
						<div class="edit_input">
							<input type="text" placeholder="请输入手机号" name="tel" class="no-border" datatype="m">
						</div>
					</div>
					<div class="edit_item edit_num">
						<div class="edit_title">人数</div>
						<div class="edit_input">
							<span class="num_less">-</span>
							<input type="text" value="1" name="num" class="no-border" datatype="*" readonly>
							<span class="num_add">+</span>
						</div>
					</div>
					<div class="edit_item edit_gotime">
						<div class="edit_title">到店时间</div>
						<div class="edit_input">
							<input type="text" placeholder="请选择到店时间" name="gotime" class="no-border gotime" datatype="*">
						</div>
					</div>
					<div class="edit_item edit_time">
						<div class="edit_title">使用时长</div>
						<div class="edit_input">
							<input type="text" placeholder="请选择使用时长"  class="no-border show-value" datatype="*" readonly>
							<input type="hidden" name="time" class="no-border hide-value">
						</div>
						<div class="select_box">
							<div class="select_title">
								<h4 class="select_text">请选择使用时长</h4>
								<i class="close_btn"></i>
							</div>
							<div class="select_list type_text">
								<ul>
									<li data-value="1">1小时</li>
									<li data-value="2">2小时</li>
									<li data-value="3">3小时</li>
									<li data-value="4">4小时及以上</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="edit_item edit_table">
						<div class="edit_title">选择包厢</div>
						<div class="edit_input">
							<input type="text" placeholder="请选择包厢" name="table" value="" class="no-border show-value" datatype="*" readonly>
							<input type="hidden" name="cz_id" class="hide-value">
						</div>
						<div class="select_box">
							<div class="select_title">
								<h4 class="select_text">请选择包厢</h4>
								<i class="close_btn"></i>
							</div>
							<div class="select_list type_text">
								<ul>
									<?php foreach($list as $value){ ?>
									<li data-value="<?php echo $value['cz_id'];?>" <?php if($value['cz_id']==$bid){?>class="selected"<?php } ?>><?php echo $value['name'];?></li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="order_table_submit">
					<input type="submit" class="order_submit" value="提交预约" disabled>
				</div>
				<div class="body_dark"></div>
			</form>
		</div>
	</div>
	<script src="<?php echo TPL_URL;?>/diancha/js/fastclick.js"></script>
	<script>
	window.addEventListener('load', function () {
		var t = document.querySelectorAll('.FastClick');
		for (var i = 0; i < t.length; i++) {
			FastClick.attach(t[i]);
		};
	}, false);
	</script>
	
	
</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>
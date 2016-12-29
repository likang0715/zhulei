<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $chahui['name'];?></title>
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" content="<?php echo $config['seo_description'];?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="renderer" content="webkit">
	<meta name="format-detection" content="telephone=no" />
	<meta name="format-detection" content="email=no" />
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css?time=<?php echo time()?>" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/event_details.css">
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script src="<?php echo TPL_URL; ?>js/base.js"></script>
	<script src="<?php echo TPL_URL;?>/diancha/js/Validform_v5.3.2_min.js"></script>
</head>
<body class="event_details FastClick" style="max-width:640px;margin:0 auto;padding-bottom:45px;">
	<div class="event_thumb">
		<img src="../upload/<?php echo $chahui['images'];?>">
	</div>
	<div class="event_title c_main">
		<h3><?php echo $chahui['name'];?></h3>
		<span>预览:<?php echo $chahui['pv'];?>&nbsp;&nbsp;&nbsp;&nbsp;收藏:<?php echo $chahui['collect'];?></span>
	</div>
	<div class="event_info c_main">
		<div class="info_item info_main">
			<i class="info_icon"><img src="<?php echo TPL_URL;?>/diancha/images/main.png"></i>
			<span class="info_name">主 办 方：<?php echo $now_store['name'];?></span>
		</div>
		<div class="info_item info_time">
			<i class="info_icon"><img src="<?php echo TPL_URL;?>/diancha/images/time.png"></i>
			<span class="info_name">活动时间：<?php echo date('m-d H:i', strtotime($chahui['sttime']));?>至<?php echo date('m-d H:i', strtotime($chahui['endtime']));?></span>
		</div>
		<div class="info_item info_address">
			<i class="info_icon"><img src="<?php echo TPL_URL;?>/diancha/images/address.png"></i>
			<span class="info_name">活动地址：<?php echo $chahui['address'];?></span>
		</div>
		<div class="info_item info_ticket">
			<i class="info_icon"><img src="<?php echo TPL_URL;?>/diancha/images/ticket.png"></i>
			<span class="info_name">票&nbsp;&nbsp;&nbsp;&nbsp;价：<?php if($chahui['price']>0){ echo $chahui['price'];}else{echo '免费';}?></span>
		</div>
		<div class="info_item info_num">
			<i class="info_icon"><img src="<?php echo TPL_URL;?>/diancha/images/num.png"></i>
			<span class="info_name">人数上限：<?php echo $chahui['renshu'];?></span>
		</div>
	</div>
	<div class="event_con c_main">
		<?php echo $chahui['description'];?>
	</div>
	<div class="event_about c_main">
		<h3 class="event_about_t">相似活动</h3>
		<?php foreach($list as $value){ ?>
		<a href="<?php echo $value['url'];?>" class="cf about_tiem">
			<div class="item_thumb">
				<img src="../upload/<?php echo $value['images'];?>">
			</div>
			<div class="item_text">
				<h4 class="text_title"><?php echo $value['name'];?><span>&gt;</span></h4>
				<span class="text_span"><?php echo $value['address'];?></span>
				<p class="text_p"><?php echo $value['time'];?></p>
			</div>
		</a>
		<?php } ?>

	</div>
	<div class="event_bottom">
		<div class="event_bottom_nav">
			<ul>
				<li class="nav_more inner_border">
					<span class="more_toggle">更多</span>
					<div class="list_more_show" style="display:none">
						<ul>
							<li><a href="<?php echo $now_store['url'];?>">店铺首页</a></li>
							<li><a href="chorder.php?id=<?php echo $now_store['store_id'];?>">个人中心</a></li>
							<li><a href="<?php echo $now_store['ucenter_url'];?>">我的收藏</a></li>
							<li><a href="chahui.php">更多茶会</a></li>
						</ul>
					</div>
				</li>
				<li class="nav_collect inner_border">
					<?php if ($is_collect) { ?>
					<span class="shoucang on">已收藏</span>
					<?php } else { ?>
					<span class="shoucang">收藏</span>
					<?php } ?>
				</li>
				<li class="nav_submit inner_border" id="event_sign">立即报名</li>
			</ul>
		</div>
	</div>
	<div class="event_form">
		<form action="baoming.php" id="event_form" method="post">
			<input type="hidden" name="pigcms_id" value="<?php echo $chahui['physical_id'];?>">
			<input type="hidden" name="cid" value="<?php echo $chahui['pigcms_id'];?>">
			<input type="hidden" name="store_id" value="<?php echo $now_store['store_id'];?>">
			<div class="form_title">
				<h4 class="form_text">填写报名信息</h4>
				<i class="close_btn"></i>
			</div>
			<div class="form_input">
				<div class="event_name">
					<input type="text" name="name" placeholder="您的姓名" datatype="*">
				</div>
				<div class="event_tel">
					<input type="text" name="mobile" placeholder="您的手机号" datatype="m">
				</div>
				<div class="event_btn">
					<input type="submit" value="提交报名" disabled>
				</div>
			</div>
		</form>
	</div>
	<div class="body_dark"></div>
	<script type="text/javascript">
	function checkInput () {
		if($("#event_form").Validform().check(true)){
			$('.event_btn input').attr('disabled', false);
		}else{
			$('.event_btn input').attr('disabled', 'disabled');
		}
	}
	$(function() {
		$('.more_toggle').click(function() {
			$('.list_more_show').toggle();
		});
		$('#event_sign').click(function() {
			$('.event_form').show();
			$('.body_dark').show();
			checkInput ();
		});
		$('.close_btn').click(function() {
			$('.event_form').hide();
			$('.body_dark').hide();
		});
		$("#event_form input").on('blur change input propertychange',function() {
			checkInput ();
		});
		
		$('.shoucang').click(function(){
			var url = "collect.php?action=add&id=" + <?php echo $_GET['id']+0; ?> + "&type=3&store_id="+<?php echo $_GET['store_id'] ? $_GET['store_id'] : $now_store['store_id'] ?>;
			var number = parseInt($(this).find("span").html());
			$.get(url,function(data){
				motify.log(data.msg);
				if(data.status){
				//$('.goods_shoucang').find("span").html(number + 1);
			}
		},'json');
			
		}); 
	});
	</script>
	<script src="<?php echo TPL_URL;?>/diancha/js/fastclick.js"></script>
	<script>
	window.addEventListener('load', function () {
		var input = document.querySelectorAll('.FastClick');
		for (var i = 0; i < input.length; i++) {
			FastClick.attach(input[i]);
		};
	}, false);
	</script>
	<div class="container">
			<?php include display('footer');?>
		</div>
</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>
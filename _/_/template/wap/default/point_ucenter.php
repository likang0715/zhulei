<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>

<!DOCTYPE>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/base.css"/>
	<link href="<?php echo TPL_URL;?>ucenter/css/index.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/swiper.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/usercenter.css" type="text/css">

	<?php if($is_mobile){ ?>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css?time='<?php echo time();?>'"/>
	<?php }else{ ?>
		<link rel="stylesheet" href="?php echo TPL_URL;?>css/showcase_admin.css?time='<?php echo time();?>'"/>
	<?php } ?>


	<title>分销用户-个人中心</title>
	<script src="<?php echo TPL_URL;?>ucenter/js/swiper.min.js"></script>
	<script src="<?php echo TPL_URL;?>ucenter/js/rem.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>ucenter/js/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>ucenter/js/index.js"></script>
	<script src="<?php echo TPL_URL;?>js/base.js"></script>
</head>

<body>
<section class="userTop clearfix dTab" style="background-image:url('<?php echo  $now_ucenter['bg_pic'];?>');background-size:cover">

	<!-- 优礼库样式结构修改 start -->
	<div class="userTopInfo">
		<div class="fl userAvatar">
			<a href="##">
				<img class="mp-image" width="24" height="24" src="<?php echo !empty($avatar) ? $avatar : option('config.site_url') . '/static/images/avatar.png'; ?>" alt="<?php echo $now_store['name'];?>"/>
			</a>
		</div>
		<div class="userInfo promotion" style="display:none;">
			<?php if (isset($now_ucenter['promotion_field']) && !empty($now_ucenter['promotion_field'])) {?>
				<div class="name">
					<span style="display:<?php echo in_array('1',$now_ucenter['promotion_field']) ? '' : 'none';?>"><?php echo $seller['name'];?></span>
					<span style="display:<?php echo in_array('2',$now_ucenter['promotion_field']) ? '' : 'none';?>">【<?php echo $fx_degree_name['name'];?>】</span>
				</div>
				<div class="price" style="display:<?php echo in_array('3',$now_ucenter['promotion_field']) ? '' : 'none';?>">
					<span><i></i><?php echo !empty($storeUserData['point']) ? intval($storeUserData['point']) : '0' ;?></span>
					<span>收入:￥<?php echo $balance;?></span>
				</div>
				<div class="price" style="display:<?php echo in_array('4',$now_ucenter['promotion_field']) ? '' : 'none';?>">
					<span>营销额:￥<?php echo $sales;?></span>
				</div>
			<?php } else if (!isset($now_ucenter['promotion_field'])) {?>
				<div class="name">
					<span><?php echo $seller['name'];?></span>
					<span>【<?php echo $fx_degree_name['name'];?>】</span>
				</div>
				<div class="price">
					<span><i></i><?php echo !empty($storeUserData['point']) ? intval($storeUserData['point']) : '0' ;?></span>
					<span>收入:￥<?php echo $balance;?></span>
				</div>
				<div class="price">
				   <span>营销额:￥<?php echo $sales;?></span>
				</div>
			<?php }?>
		</div>
		<div class="userInfo consumption">
			<?php if(isset($now_ucenter['consumption_field']) && !empty($now_ucenter['consumption_field'])) {?>
			<div class="name">
				<span style="display:<?php echo in_array('1',$now_ucenter['consumption_field']) ? '' : 'none';?>"><?php echo !empty($_SESSION['wap_user']['nickname']) ? $_SESSION['wap_user']['nickname'] : ''; ?></span>
				<span style="display:none;display:<?php echo in_array('3',$now_ucenter['consumption_field']) ? '' : 'none';?>">【<?php echo $fx_degree_name['name'];?>】</span>
			</div>
			<div class="price" style="display:none">
				<span style="display:<?php echo in_array('2',$now_ucenter['consumption_field']) ? '' : 'none';?>"><i></i><?php echo !empty($storeUserData['point']) ? intval($storeUserData['point']) : '0' ;?></span>
				<span style="displays:<?php echo in_array('4',$now_ucenter['consumption_field']) ? '' : 'none';?>; display:none">消费：￥<?php echo $consume; ?></span>
				<?php if ($store_points_config['sign_set'] == 1) { ?>
					<span><a href="./checkin.php?act=checkin&store_id=<?php echo $now_store['store_id'] ?>" style="color:#fff;">每日签到</a></span>
				<?php } ?>
			</div>
			<?php }else if(!isset($now_ucenter['consumption_field'])) {?>
				<div class="name">
					<span><?php echo !empty($_SESSION['wap_user']['nickname']) ? $_SESSION['wap_user']['nickname'] : ''; ?></span>
					<span style="display:none">【<?php echo $fx_degree_name['name'];?>】</span>
				</div>
				<div class="price">
					<span style="display:none"><i></i><?php echo !empty($storeUserData['point']) ? intval($storeUserData['point']) : '0' ;?></span>
					<span style="display:none">消费：￥<?php echo $consume[0]['consume']?></span>
					<?php if ($store_points_config['sign_set'] == 1) { ?>
						<span><a href="./checkin.php?act=checkin&store_id=<?php echo $now_store['store_id'] ?>" style="color:#fff;">每日签到</a></span>
					<?php } ?>
				</div>
			<?php }?>
		</div>
	</div>
	<!-- 优礼库样式结构修改 end -->
</section>
<section class="userTab dTab">
	<div class="bd">
		<div class="row">
			<div class="orderNav">
				<ul class="box">
					<li class="b-flex">
						<a href="./order.php?id=<?php echo $now_store['store_id'];?>&action=unpay">
							<i><?php echo intval($storeUserData['order_unpay']);?></i>
							待付款
						</a>
					</li>
					<li class="b-flex">
						<a href="./order.php?id=<?php echo $now_store['store_id'];?>&action=unsend">
							<i><?php echo intval($storeUserData['order_unsend']);?></i>
							待发货
						</a>
					</li>
					<li class="b-flex">
						<a href="./order.php?id=<?php echo $now_store['store_id'];?>&action=send">
							<i><?php echo intval($storeUserData['order_send']);?></i>
							已发货
						</a>
					</li>
					<li class="b-flex">
						<a href="./order.php?id=<?php echo $now_store['store_id'];?>&action=complete">
							<i><?php echo intval($storeUserData['order_complete']);?></i>
							已完成
						</a>
					</li>
					<li class="b-flex">
						<a href="./rights.php?id=<?php echo $now_store['store_id'];?>">
							<i><?php echo $returnProduct > 0 ? $returnProduct : '0';?></i>
							退换货
						</a>
					</li>
				</ul>
			</div>
			<!--会员消息 start-->
			<div class="group consumption-group">
				<div class="cell">
					<a href="./cart.php?id=<?php echo $now_store['store_id'];?>">
						<i class="arrow"></i>
						<span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/1.png"/></i>我的购物车</span>
					</a>
				</div>
				<div class="cell">
					<a href="./order.php?id=<?php echo $now_store['store_id'];?>">
						<i class="arrow"></i>
						<span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/2.png"/></i>我的订单</span>
					</a>
				</div>
				<div class="cell">
					<a href="./unitay_address.php">
						<i class="arrow"></i>
						<span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/4.png"/></i>收货地址</span>
					</a>
				</div>
				<div class="cell">
					<a href="./drp_ucenter.php?a=profile">
						<i class="arrow"></i>
						<span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/5.png"/></i>个人资料</span>
					</a>
				</div>
			</div>
			<!--会员消息end-->
			<div class="cell dTab likeSome" style="display:none;margin-bottom: 46px;">
				<div class="hd">
					<ul class="box">
						<li class="b-flex on">
							<a data-flex="product" href="javascript:;">喜欢的商品</a>
						</li>
						<li class="b-flex">
							<a data-flex="article" href="javascript:;">喜欢的包厢</a>
						</li>
					</ul>
				</div>
				<div class="bd product">
					<div class="row">
						<?php if(!empty($collects)){?>
						<?php foreach($collects as $collect) {?>
						<div class="cell">
							<a href="./good.php?id=<?php echo $collect['product_id']?>&store_id=<?php echo $collect['store_id']?>">
								<i class="arrow"></i>
								<div class="proImg fl">
									<img src="<?php echo getAttachmentUrl($collect['image']); ?>"/>
								</div>
								<div class="detailInfo">
									<h3><?php echo $collect['name']?></h3>
									<p><?php echo date('Y-m-d', $collect['add_time'])?></p>
								</div>
							</a>
						</div>
						<?php }?>
						<?php }?>
					</div>
				</div>
				<div class="bd article" style="display:none;">
					<div class="row">
						<?php if(!empty($subjects)){?>
						<?php foreach($subjects as $subject) {?>
							<div class="cell">
								<a href="./subinfo.php?store_id=<?php echo $subject['store_id'] ?>&subject_id=<?php echo $subject['dataid'] ?>">
									<i class="arrow"></i>
									<div class="proImg fl">
										<img src="<?php echo getAttachmentUrl($subject['pic']); ?>"/>
									</div>
									<div class="detailInfo">
										<h3><?php echo $subject['name'] ?></h3>
										<p><?php echo date('Y-m-d', $subject['add_time'])?></p>
									</div>
								</a>
							</div>
						<?php }?>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="customer" >
	<?php
	if($homeCustomField){
		foreach($homeCustomField as $value){
			echo $value['html'];
		}
	}
	?>
   </div>
</section>
<?php if(!empty($storeNav)){ echo $storeNav;}?>
</body>
<?php echo $shareData;?>
</html>
<script>
	$(function(){
		$('.tab-name').click(function(){
			var data = $(this).data('tab');
			if(data == 'consumption'){
				$('.promotion').css('display','none');
				$('.orderNav').css('display','block');
				$('.consumption').css('display','block');
				$('.promotion-group').css('display','none');
				$('.consumption-group').css('display','block');
				$('.likeSome').css('display','block');
				$('.index_footer').css('display','none');
				$('.customer').css('display','block');
				//$(this).parent('li').addClass('on').siblings().removeClass('on');

			}else if(data == 'promotion'){
				$('.consumption').css('display','none');
				$('.orderNav').css('display','none');
				$('.promotion').css('display','block');
				$('.promotion-group').css('display','block');
				$('.consumption-group').css('display','none');
				$('.likeSome').css('display','none');
				$('.index_footer').css('display','block');
				$('.customer').css('display','none');
			   // $(this).parent('li').addClass('on').siblings().removeClass('on');
			}
		});
		$('.box li a').click(function(){
			var flex = $(this).data('flex');
			if(flex == 'product'){
				$('.product').css('display','block');
				$('.article').css('display','none');
			}else if(flex == 'article'){
				$('.article').css('display','block');
				$('.product').css('display','none');
			}
		});
	});
</script>
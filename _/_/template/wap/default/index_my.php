<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>个人中心</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		
		<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/reset.css">
	    <link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/common.css">
	    <link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/home.css">
		
		
		
		
		
		
		
		
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/my.css"/>
		
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/layernew/layer/layer.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
		<style type="text/css">
			.userMoreInfo{text-align:right}
			.my-store > a:before {
				content: normal;
				display: block;
			}
			.userMoreInfo{top:5px;}
		</style>

		 
	    <script type="text/javascript">
	        $(document).ready(function() {
				layer.config({
					extend: 'extend/layer.ext.js'
				});
				var allow_account_pwd_confirm = "<?php echo $allow_account_pwd_confirm;?>";
				var hash = '';
				if ("<?php echo $store; ?>" != '' && parseInt("<?php echo $store['drp_supplier_id']; ?>") == 0) {
					hash = '?store_id=<?php echo $store['store_id']; ?>#0';
				}
				$('#mycount').click(function(){
					if(allow_account_pwd_confirm == 1){
						layer.prompt({
							formType: 1,
							title: '请确认你的密码'
						}, function(value, index, elem){
							$.post("my.php?action=checkpassword", {'passwd': value}, function(result) {
								if (result == 0) {
									layer.msg("密码错误");
								} else {
									location.href='./my_point.php' + hash;
								}
							});
						});
					}else{
						location.href='./my_point.php' + hash;
					}
				});
	        });
	    </script>
	</head>
	<body style="padding-bottom:70px;">
	<div class="home_main">
		<div class="home_title">
			<div class="home_title_l">
				<img src="<?php echo $avatar;?>">
				<h3><?php echo $wap_user['nickname'];?></h3>
				<h4>积分 <?php echo $user_info['point_gift'];?>分</h4>
			</div>
			<div class="home_title_r">
				<a href="" class="home_title_xinfeng"><img src="<?php echo TPL_URL;?>pingtai/images/home_xinfeng.png" alt=""></a>
				<a class="home_title_shezhi"><span>设置</span></a>
			</div>
		</div>
		<div class="home_main_t">
			<div class="home_main_con cf">
				<h3>我的订单</h3>
				<a href="./my_order.php">查看全部订单&gt;</a>	
			</div>
			<div class="home_main_pic main cf">
			    <ul>
			        <a href="./my_order.php?action=unpay">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_01.png">
			            	<p class="index_menu_li_p">待付款</p>
			        	</li>
			    	</a>
			        <a href="./my_order.php?action=unsend">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_02.png">
			            	<p class="home_pic_li_p">待发货</p>
			        	</li>
			        </a>
			         <a href="./my_order.php?action=send">
			         	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_03.png">
			            	<p class="home_pic_li_p">待收货</p>
			        	</li>
			        </a>
			        <a href="#">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_04.png">
			            	<p class="home_pic_li_p">待评价</p>
				        </li>
				    </a>
				    <a href="./my_return.php">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_05.png">
			            	<p class="home_pic_li_p">退货/售后</p>
				        </li>
				    </a>
			    </ul>
			</div>
		</div>
		<div class="home_main_t">
			<div class="home_main_con cf">
				<h3>我的预约</h3>
				<a href="./dcorder.php?action=all&platform=1">查看全部预约&gt;</a>
			</div>
			<div class="home_main_pic main cf">
			    <ul>
			        <a href="./dcorder.php?action=dsh&platform=1">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_06.png">
			            	<p class="index_menu_li_p">待确认</p>
			        	</li>
			    	</a>
			        <a href="./dcorder.php?action=dxf&platform=1">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_07.png">
			            	<p class="home_pic_li_p">待消费</p>
			        	</li>
			        </a>
			         <a href="#">
			         	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_08.png">
			            	<p class="home_pic_li_p">待点评</p>
			        	</li>
			        </a>
			        <a href="./dcorder.php?action=suc&platform=1">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_09.png">
			            	<p class="home_pic_li_p">已消费</p>
				        </li>
				    </a>
				    <a href="./dcorder.php?action=cancel&platform=1">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_010.png">
			            	<p class="home_pic_li_p">已关闭</p>
				        </li>
				    </a>
			    </ul>
			</div>
		</div>
		<div class="home_main_t">
			<div class="home_main_con cf">
				<h3>我的报名</h3>
				<a href="./chorder.php?platform=1">查看全部报名&gt;</a>
			</div>
			<div class="home_main_pic main cf">
			    <ul>
			        <a href="./chorder.php?status=1&platform=1">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_011.png">
			            	<p class="index_menu_li_p">待审核</p>
			        	</li>
			    	</a>
			        <a href="./chorder.php?status=3&platform=1">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_012.png">
			            	<p class="home_pic_li_p">审核通过</p>
			        	</li>
			        </a>
			         <a href="#">
			         	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_013.png">
			            	<p class="home_pic_li_p">待反馈</p>
			        	</li>
			        </a>
			        <a href="#">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_014.png">
			            	<p class="home_pic_li_p">已完成</p>
				        </li>
				    </a>
				    <a href="./chorder.php?status=2&platform=1">
			        	<li class="home_pic_li">
			            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_010.png">
			            	<p class="home_pic_li_p">未通过</p>
				        </li>
				    </a>
			    </ul>
			</div>
		</div>
		<!-- 更多功能 -->
		<div class="home_more">
		    <ul>
		        <a href="./my_cart.php">
		        	<li class="home_more_li">
		            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_1.png">
		            	<p class="home_more_li_p">购物车</p>
		        	</li>
		    	</a>
		        <a href="./my_shoucang.php?action=goods">
		        	<li class="home_more_li">
		            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_2.png">
		            	<p class="home_more_li_p">收藏夹</p>
		        	</li>
		        </a>
		         <a href="#">
		         	<li class="home_more_li">
		            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_3.png">
		            	<p class="home_more_li_p">代金券</p>
		        	</li>
		        </a>
		        <a href="#">
		        	<li class="home_more_li">
		            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_4.png">
		            	<p class="home_more_li_p">找客服</p>
			        </li>
			    </a>
		        <a href="./my_recently.php">
			        <li class="home_more_li">
			            <img src="<?php echo TPL_URL;?>pingtai/images/home_icon_5.png">
			            <p class="home_more_li_p">最近浏览</p>
			        </li>
			    </a>
			    <a href="#">
		        	<li class="home_more_li">
		            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_6.png">
		            	<p class="home_more_li_p">我要开店</p>
		        	</li>
		        </a>
		        <a href="./drp_ucenter.php?a=profile" >
		        	<li class="home_more_li">
		            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_7.png">
		            	<p class="home_more_li_p">设置</p>
		        	</li>
		        </a>
		        <a href="#">
		        	<li class="home_more_li">
		            	<img src="<?php echo TPL_URL;?>pingtai/images/home_icon_8.png">
		            	<p class="home_more_li_p">意见反馈</p>
		        	</li>
		        </a>
		    </ul>
		</div>
		<div class="common_nav">
		    <div class="common_nav_main">
		        <ul>
		            <a href="./index.php"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon01.png">
		                <p>首页</p>
		            </li></a>
		            <a href="./category.php"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon02.png">
		                <p>茶品</p>
		            </li></a>
		            <a href="teahouse.html"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon03.png">
		                <p>茶馆</p>
		            </li></a>
		            <a href="./weidian.php"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon04.png">
		                <p>茶会</p>
		            </li></a>
		            <a href="./my.php"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon05_cur.png">
		                <p class="common_nav_cur">我的</p>
		            </li></a>
		        </ul>
		    </div>
		</div>
	
		<div class="common_footer"></div>
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		<div class="wx_wrap">
			
			<!--  
			<div class="my_head">
				<img src="<?php echo getAttachmentUrl('images/default_ucenter.jpg', false);?>" style="width:100%;max-height:220px;display:block;margin:auto;"/>
				<!-- S 账户信息 --
				<a class="my_user">
					<h5>尊敬的 <?php echo $wap_user['nickname'];?> ，<?php echo $time_tip;?></h5>
				</a>
				<!-- E 账户信息 --
			</div>
			-->
			
			<div class="my_head">
				<div class="userAvatr">
					<div class="avatarImg">
						<img src="<?php echo $avatar;?>"/>
					</div>
					<div class="userDesc"> <?php echo $wap_user['nickname'];?>
					<!--<i>&nbsp;&nbsp;&nbsp;</i>--></div>
				</div>
				<div class="userMoreInfo">
					<ul>
						<li><?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?>(可用)  <em><?php echo $user_info['point_balance'];?></em></li>
						<li>分享积分  <em><?php echo $user_info['point_gift'];?></em></li>
						<?php if($point_shop) {?>
							<li><a href="./jf_shop.php"> 积分商城     <em><i class="rightArrow">&nbsp;&nbsp;&nbsp;</i></em></a></li>
						<?php }?>
						<li><a href="./my.php?action=quit"> 退出     <em><i class="rightArrow">&nbsp;&nbsp;&nbsp;</i></em></a></li>
					</ul>
				</div>
			</div>		
			
			
			<!-- S 入口菜单 -->
			<div class="my_menu">
				<ul>
					<li class="tiao">
						<a href="./my_order.php" class="menu_1">全部订单</a>
					</li>
					<li class="tiao">
						<a href="./my_order.php?action=unpay" class="menu_2">待付款</a>
					</li>
					<li class="tiao">
						<a href="./my_order.php?action=unsend" class="menu_4">待发货</a>
					</li>
					<li class="tiao">
						<a href="./my_order.php?action=send" class="menu_3">已发货</a>
					</li>
					
				</ul>
			</div>
			<!-- E 入口菜单 -->

			<!-- S 入口列表 -->
			<ul class="my_list">
				<li class="tiao"><a href="#" id="mycount" >我的账户</a></li>
				<li class="tiao"><a href="./my_cart.php">我的购物车</a></li>
				<li class="tiao"><a href="./promotion_platform.php">平台推广</a></li>
				<li class="tiao"><a href="./my_return.php">我的退货</a></li>
				<li class="tiao"><a href="./my_rights.php">我的维权</a></li>
				<li class="tiao"><a href="./my_recently.php">我的浏览记录</a></li>
				<li class="tiao"><a href="./my_memcard.php">我的会员卡</a></li>
				<li class="tiao"><a href="./my_guanzhu.php?action=goods">我的关注</a></li>
				<li class="tiao"><a href="./my_shoucang.php?action=goods">我的收藏</a></li>
				<!--<li class="tiao"><a href="./obtain_tpl.php">获取证书</a></li>-->
				<li class="hr"></li>
				<li class="tiao"><a href="./user_address.php">收货地址管理</a></li>
				<!-- <li class="hr"></li> -->
				<!-- <?php if (!empty($stores)) { ?>
				<li class="tiao my-store"><a href="javascript:void(0);">我的店铺</a></li>
				<?php foreach ($stores as $store_tmp) { ?>
				<li class="tiao"><a href="./my_store.php?id=<?php echo $store_tmp['store_id']; ?>"><img src="<?php echo $store_tmp['logo']; ?>" style="margin-top: 5px;margin-right: 5px" width="35" height="35" /><?php echo $store_tmp['name']; ?></a></li>
				<?php } ?>
				<?php } ?> -->
			</ul>
			<!-- E 入口列表 -->
			<!--div class="my_links">
				<a href="tel:4006560011" class="link_tel">致电客服</a>
				<a href="#" class="link_online">在线客服</a>
			</div-->
		</div>
		<div class="wx_nav">
			<a href="./index.php" class="nav_index">首页</a>
			<a href="./category.php" class="nav_search">分类</a>
			<a href="./weidian.php" class="nav_shopcart">店铺</a>
			<a href="./my.php" class="nav_me on">个人中心</a></div>
		<?php echo $shareData;?>
		
	</body>
</html>
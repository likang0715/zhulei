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
        <link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css?time='<?php echo time();?>'"/>
    <?php } ?>
    <title>个人中心</title>
    <script src="<?php echo TPL_URL;?>ucenter/js/swiper.min.js"></script>
    <script src="<?php echo TPL_URL;?>ucenter/js/rem.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>ucenter/js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/base.js"></script>
    <!--活动模块-->
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/weidian_files/style.css">
    <script src="<?php echo TPL_URL;?>/weidian_files/iscroll.js"></script>
	<script type="text/javascript">
        var drp_center_show = parseInt("<?php echo $drp_center_show; ?>");
		$(function () {
			$(".scroller").each(function (i) {
				$(this).find("a").css("height", "auto");
				var li = $(this).find("li");
				var liW = li.width() + 18;
				var liLen = li.length;
				$(this).width(liW * liLen);

				var class_name = $(this).parent().attr("class");
				new IScroll("." + class_name, { scrollX: true, scrollY: false, mouseWheel: false, click: true });
			});
		});
	</script>
    <!--		活动模块-->
</head>
<style type="text/css">
    .motify {
        text-align: center;
        position: fixed;
        top: 35%;
        left: 50%;
        width: 220px;
        padding: 5px;
        margin: 0 0 0 -110px;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        font-size: 14px;
        line-height: 1.5em;
        border-radius: 6px;
        -webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
    }
    .userTab>.bd .consumption-group .cell:nth-child(4n) {
        margin-bottom: .5rem;
    }
     .ucenter-tab {
        float: right;
        background-size: cover;
        margin-top: 0.1rem;
        margin-right: 19px;
        color:#f60;
    }
    .motify-inner {
        font-size: 12px;
    }
</style>

<script type="text/javascript">
$(function(){
	if(location.hash == '#promotion') {
		$(".dTab .hd ul li").removeClass('on');
		$(".dTab .hd ul li").eq(1).addClass('on');
		$('.likesomes').css('display','none');
		$('.consumption').css('display','none');
		$('.orderNav').css('display','none');
		$('.promotion').css('display','block');
		$('.promotion-group').css('display','block');
		$('.consumption-group').css('display','none');
		$('.user-image').css('display','none');
		$('.store-image').css('display','block');

		$('.index_footer').css('display','block');
		$('.customer').css('display','none');
	}
});
</script>

<body>
<section class="userTop clearfix dTab" style="background-image:url('<?php echo  getAttachmentUrl($now_ucenter['bg_pic']);?>');background-size:cover">

    <!-- 样式结构修改 start -->
    <div class="userTopInfo">
        <div class="fl userAvatar">
            <a href="##" style="display:block;" class="user-image">
                <img class="mp-image " width="24" height="24" src="<?php echo !empty($avatar) ? $avatar : option('config.site_url') . '/static/images/default_shop_2.jpg'; ?>" alt="<?php echo $_SESSION['wap_user']['nickname'];?>"/>
            </a>
            <a href="##" style="display:none;" class="store-image">
                <img class="mp-image" width="24" height="24" src="<?php echo !empty($visitor['data']['logo']) ? $visitor['data']['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg'; ?>" alt="<?php echo $visitor['data']['name'];?>"/>
            </a>
        </div>
        <div class="userInfo promotion" style="display:none;">
            <?php if (isset($now_ucenter['promotion_field']) && !empty($now_ucenter['promotion_field'])) {?>
                <div class="name">
                    <span style="display:<?php echo in_array('1',$now_ucenter['promotion_field']) ? '' : 'none';?>"><?php echo $visitor['data']['name'];?></span>
                    <span style="display:<?php echo in_array('2',$now_ucenter['promotion_field']) ? '' : 'none';?>">【<?php echo $visitor['data']['drp_degree_name'];?>】</span>
                </div>
                <div class="price" style="display:<?php echo in_array('3',$now_ucenter['promotion_field']) ? '' : 'none';?>">
                    <span>店铺积分：<?php echo $visitor['data']['point'];?></span>
                    <span>收入：￥<?php echo $visitor['data']['balance'];?></span>
                    <div class="price" style="display:<?php echo in_array('4',$now_ucenter['promotion_field']) ? '' : 'none';?>">
                        <span>营销额：￥<?php echo $visitor['data']['sales'];?></span>
                    </div>
                </div>

            <?php } else if (!isset($now_ucenter['promotion_field'])) {?>
                <div class="name">
                    <span><?php echo $visitor['data']['name'];?></span>
                    <span>【<?php echo $visitor['data']['drp_degree_name'];?>】</span>
                </div>
                <div class="price">
                    <span>店铺积分：<?php echo $visitor['data']['point'];?></span>
                    <span>收入：￥<?php echo $visitor['data']['balance'];?></span>
                    <div class="price">
                        <span>营销额：￥<?php echo $visitor['data']['sales'];?></span>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="userInfo consumption">
            <?php if(isset($now_ucenter['consumption_field']) && !empty($now_ucenter['consumption_field'])) {?>
            <div class="name">
                <span style="display:<?php echo in_array('1',$now_ucenter['consumption_field']) ? '' : 'none';?>"><?php echo !empty($_SESSION['wap_user']['nickname']) ? $_SESSION['wap_user']['nickname'] : ''; ?></span>
                <span style="display:<?php echo in_array('3',$now_ucenter['consumption_field']) ? '' : 'none';?>">【<?php echo $storeUserData['degree_name'] ?>】</span>
            </div>
            <div class="price">
                <span style="display:<?php echo in_array('2',$now_ucenter['consumption_field']) ? '' : 'none';?>">
				会员积分：<?php echo $storeUserData['point'] ? $storeUserData['point'] : '0' ;?></span>
                <span style="display:<?php echo in_array('4',$now_ucenter['consumption_field']) ? '' : 'none';?>">消费：￥<?php echo $consume; ?></span>
                <?php if ($store_points_config['sign_set'] == 1) { ?>
                    <div class="price">
                    <span><a href="./checkin.php?act=checkin&store_id=<?php echo $now_store['store_id'] ?>" style="color:#2AAEE8;">点我签到</a></span>
                     </div>
                <?php } ?>
            </div>
            <?php }else if(!isset($now_ucenter['consumption_field'])) {?>
                <div class="name">
                    <span><?php echo !empty($_SESSION['wap_user']['nickname']) ? $_SESSION['wap_user']['nickname'] : ''; ?></span>
                    <span>【<?php echo $storeUserData['degree_name'];?>】</span>
                </div>
                <div class="price">
                    <span>会员积分：<?php echo !empty($storeUserData['point']) ? intval($storeUserData['point']) : '0' ;?></span>
                    <span>消费：￥<?php echo $consume; ?></span>
                    <?php if ($store_points_config['sign_set'] == 1) { ?>
                        <div class="price">
                        <span><a href="./checkin.php?act=checkin&store_id=<?php echo $now_store['store_id'] ?>" style="color:#2AAEE8;">点我签到</a></span>
                        </div>
                    <?php } ?>
                </div>
            <?php }?>
        </div>
    </div>

    <div class="clearfix userTabTop hd">
        <ul>
            <li class="on">
                <a class="tab-name" data-tab='consumption' href="#consumption"><?php echo !empty($now_ucenter['tab_name']) ? $now_ucenter['tab_name'][0] : '消费中心'?></a>
            </li>
            <?php if ($drp_center_show >= 0) { ?>
            <li>
                <?php if($drp_center_show == 0) {?>
                    <a class="no-isfx"><?php echo !empty($now_ucenter['tab_name']) ? $now_ucenter['tab_name'][1] : '推广中心'?></a>
                <?php } else if ($drp_center_show == 1) {?>
                    <a class="tab-name" data-tab='promotion' href="#promotion"><?php echo !empty($now_ucenter['tab_name']) ? $now_ucenter['tab_name'][1] : '推广中心'?></a>
                <?php } else {?>
                    <a class="no-status"><?php echo !empty($now_ucenter['tab_name']) ? $now_ucenter['tab_name'][1] : '推广中心'?></a>
                <?php }?>
            </li>
            <?php } ?>
        </ul>
    </div>
    <!-- 样式结构修改 end -->

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
                        <a href="./return.php?id=<?php echo $now_store['store_id'];?>">
                            <i><?php echo $returnProduct > 0 ? $returnProduct : '0';?></i>
                            退换货
                        </a>
                    </li>
                </ul>
            </div>

            <!--会员消息 start-->
            <div class="group consumption-group">
                <?php if(!isset($now_ucenter['member_content']) && empty($now_ucenter['member_content'])) {?>
                <div class="group">
                    <div class="cell">
                        <a href="./cart.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/1.png"/></i>我的购物车</span>
                        </a>
                    </div>
                    <div class="cell">
                         <a href="./degree.php?id=<?php echo $now_store['store_id'];?>">
                             <i class="arrow"></i>
                             <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/16.png"/></i>会员等级</span>
                             <span class="ucenter-tab"><?php echo !empty($storeUserData['degree_name']) ? $storeUserData['degree_name'] : '暂无等级';?></span>
                         </a>
                    </div>

                    <div class="cell">
                        <a href="./points_detailed.php?store_id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/19.png"/></i>积分明细</span>
                            <span class="ucenter-tab"><?php echo $storeUserData['point'] ? $storeUserData['point'] : '0' ;?></span>
                        </a>
                    </div>

                    <div class="cell">
                        <a href="./checkin.php?act=single&store_id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/17.png"/></i>个人推广</span>
                        </a>
                    </div>

                    <div class="cell">
                        <a href="./order.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/2.png"/></i>我的订单</span>
                            <span class="ucenter-tab"><?php echo !empty($allOrder) ? $allOrder : '0';?></span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./dcorder.php?id=<?php echo $now_store['store_id'];?>&action=all">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/2.png"/></i>我的点茶</span>
                            <span class="ucenter-tab"><?php echo !empty($allOrder) ? $allOrder : '0';?></span>
                        </a>
                    </div>
					<div class="cell">
                        <a href="./chorder.php?id=<?php echo $now_store['store_id'];?>&action=all">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/2.png"/></i>我的茶会</span>
                            <span class="ucenter-tab"><?php echo !empty($allOrder) ? $allOrder : '0';?></span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./my_coupon.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/3.png"/></i>我的礼券</span>
                        </a>
                    </div>

                    <div class="cell">
                        <a href="./my_activity.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/activity.png"/></i>我的活动</span>
                        </a>
                    </div>

                    <div class="cell">
                        <a href="./user_address.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/4.png"/></i>收货地址</span>
                        </a>
                    </div>
                     <div class="cell">
                            <a href="./game_center.php?a=index">
                                <i class="arrow"></i>
                                <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/game.png"/></i>我的游戏</span>
                            </a>
                        </div>
                    <div class="cell">
                        <a href="./drp_ucenter.php?a=profile">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/5.png"/></i>个人资料</span>
                        </a>
                    </div>
                </div>
                <?php } else { ?>
                <div class="group">

                    <?php if (isset($now_ucenter['member_content'][8])) { ?>
                    <div class="cell" style='display:<?php echo isset($now_ucenter['member_content'][8]) ? '' : 'none'?>'>
                        <a href="./cart.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/1.png"/></i><?php echo $now_ucenter['member_content'][8];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['member_content'][9])) { ?>
                    <div class="cell">
                        <a href="./degree.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/16.png"/></i><?php echo $now_ucenter['member_content'][9];?></span>
                            <span class="ucenter-tab"><?php echo !empty($storeUserData['degree_name']) ? $storeUserData['degree_name'] : '暂无等级';?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['member_content'][10])) { ?>
                    <div class="cell">
                        <a href="./points_detailed.php?store_id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/19.png"/></i><?php echo $now_ucenter['member_content'][10];?></span>
                            <span class="ucenter-tab"><?php echo $storeUserData['point'] ? $storeUserData['point'] : '0' ;?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['member_content'][11])) { ?>
                    <div class="cell">
                        <a href="./checkin.php?act=single&store_id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/17.png"/></i><?php echo $now_ucenter['member_content'][11];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['member_content'][1])) { ?>
                    <div class="cell">
                        <a href="./order.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/2.png"/></i><?php echo $now_ucenter['member_content'][1];?></span>
                            <span class="ucenter-tab"><?php echo !empty($allOrder) ? $allOrder : '0';?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['member_content'][2])) { ?>
                    <div class="cell">
                        <a href="./my_coupon.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/3.png"/></i><?php echo $now_ucenter['member_content'][2];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['member_content'][30])) { ?>
                    <div class="cell" style='display:<?php echo isset($now_ucenter['member_content'][30]) ? '' : 'none'?>'>
                        <a href="./my_activity.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/activity.png"/></i><?php echo $now_ucenter['member_content'][30];?></span>
                        </a>
                    </div>
                    <?php } ?>
                    
                    <?php if (isset($now_ucenter['member_content'][5])) { ?>
                    <div class="cell">
                        <a href="./user_address.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/4.png"/></i><?php echo $now_ucenter['member_content'][5];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['member_content'][29])) { ?>
                    <div class="cell">
                        <a href="./game_center.php?a=index">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/game.png"/></i><?php echo $now_ucenter['member_content'][29];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['member_content'][6])) { ?>
                    <div class="cell">
                        <a href="./drp_ucenter.php?a=profile">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/5.png"/></i><?php echo $now_ucenter['member_content'][6];?></span>
                        </a>
                    </div>
                    <?php } ?>

                </div>
                <?php } ?>
            </div>
            <!--会员消息end--->

            <!--推广内容start-->
            <div class="group promotion-group" style="display:none;margin-bottom: 46px;">
                <?php if(!isset($now_ucenter['promotion_content']) && empty($now_ucenter['promotion_content'])) {?>
                <div class="group">
                    <div class="cell">
                        <a href="./drp_products.php?a=index">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/6.png"/></i>推广仓库</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./drp_order.php?a=index">
                             <i class="arrow"></i>
                             <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/7.png"/></i>推广订单</span>
                            <span class="ucenter-tab"><?php echo $fx_order_count;?></span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./drp_commission.php?a=statistics">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/8.png"/></i>推广奖金</span>
                            <span class="ucenter-tab"><?php echo $visitor['data']['balance'];?></span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./user_team.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/9.png"/></i>我的团队</span>
                            <span class="ucenter-tab"><?php echo $visitor['data']['drp_team_name'];?></span>
                        </a>
                    </div>

                    <div class="cell">
                        <a href="./popularize.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/10.png"/></i>我的推广</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./drp_store_qrcode.php?store_id=<?php echo $_SESSION['wap_drp_store']['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/11.png"/></i>我的名片</span>
                        </a>
                    </div>
                    <div class="cell" style="display:<?php if($visitor['data']['drp_level']>1 && empty($visitor['data']['drp_team_name'])) { ?> 'none'<?php }?>">
                        <a href="./drp_team.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/12.png"/></i>团队管理</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./team_rank.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/13.png"/></i>团队排名</span>
                            <span class="ucenter-tab"><?php echo !empty($team_num) ? $team_num : 1;?></span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./description.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/14.png"/></i>推广说明</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./synopsis.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/15.png"/></i>企业简介</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./drp_seller_level.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/18.png"/></i>等级积分</span>
                            <span class="ucenter-tab"><?php echo $visitor['data']['point'];?></span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./change_store.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/qiehuan.png"/></i>切换店铺</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./drp_return.php?a=return&tab_num=1&ajax=1#return">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/thwq.png"/></i>退货维权</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./drp_fans.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/7.png"/></i>我的粉丝</span>
                        </a>
                    </div>
					<div class="cell">
                        <a href="./obtain_tpl.php?id=<?php echo $_GET['id']?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/7.png"/></i>获取证书</span>
                        </a>
                    </div>
                </div>
                </div>
                <?php } else { ?>
                <div class="group">
                    <?php if (isset($now_ucenter['promotion_content'][1])) { ?>
                    <div class="cell">
                        <a href="./drp_products.php?a=index">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/6.png"/></i><?php echo $now_ucenter['promotion_content'][1];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][2])) { ?>
                    <div class="cell">
                        <a href="./drp_order.php?a=index">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/7.png"/></i><?php echo $now_ucenter['promotion_content'][2];?></span>
                            <span class="ucenter-tab"><?php echo $fx_order_count;?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][3])) { ?>
                    <div class="cell">
                        <a href="./drp_commission.php?a=statistics">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/8.png"/></i><?php echo $now_ucenter['promotion_content'][3];?></span>
                            <span class="ucenter-tab"><?php echo $visitor['data']['balance'];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][4])) { ?>
                    <div class="cell">
                        <a href="./user_team.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/9.png"/></i><?php echo $now_ucenter['promotion_content'][4];?></span>
                            <span class="ucenter-tab"><?php echo $visitor['data']['drp_team_name'];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][5])) { ?>
                    <div class="cell">
                        <a href="./popularize.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/10.png"/></i><?php echo $now_ucenter['promotion_content'][5];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][6])) { ?>
                    <div class="cell">
                        <a href="./drp_store_qrcode.php?store_id=<?php echo $_SESSION['wap_drp_store']['store_id'];?>">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/11.png"/></i><?php echo $now_ucenter['promotion_content'][6];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][7])) { ?>
                    <div class="cell" style="display:<?php if($visitor['data']['drp_level']>1 && empty($visitor['data']['drp_team_name'])) { ?> none <?php }?>">
                        <a href="./drp_team.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/12.png"/></i><?php echo $now_ucenter['promotion_content'][7];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][8])) { ?>
                    <div class="cell">
                        <a href="./team_rank.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/13.png"/></i><?php echo $now_ucenter['promotion_content'][8];?></span>
                            <span class="ucenter-tab"><?php echo $visitor['data']['drp_team_rank'];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][9])) { ?>
                    <div class="cell">
                        <a href="./description.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/14.png"/></i><?php echo $now_ucenter['promotion_content'][9];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][10])) { ?>
                    <div class="cell">
                        <a href="./synopsis.php">
                            <i class="arrow"></i>
                            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/15.png"/></i><?php echo $now_ucenter['promotion_content'][10];?></span>
                        </a>
                    </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][11])) { ?>
                        <div class="cell">
                            <a href="./drp_seller_level.php">
                                <i class="arrow"></i>
                                <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/18.png"/></i><?php echo $now_ucenter['promotion_content'][11];?></span>
                                <span class="ucenter-tab"><?php echo $visitor['data']['point'];?></span>
                            </a>
                        </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][13])) { ?>
                        <div class="cell">
                            <a href="./change_store.php">
                                <i class="arrow"></i>
                                <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/qiehuan.png"/></i><?php echo $now_ucenter['promotion_content'][13];?></span>
                            </a>
                        </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][14])) { ?>
                        <div class="cell">
                            <a href="./drp_return.php?a=return&tab_num=1&ajax=1#return">
                                <i class="arrow"></i>
                                <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/thwq.png"/></i><?php echo $now_ucenter['promotion_content'][14];?></span>
                            </a>
                        </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][15])) { ?>
                        <div class="cell">
                            <a href="./drp_fans.php">
                                <i class="arrow"></i>
                                <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/7.png"/></i><?php echo $now_ucenter['promotion_content'][15];?></span>
                            </a>
                        </div>
                    <?php } ?>

                    <?php if (isset($now_ucenter['promotion_content'][16])) { ?>
                        <div class="cell">
                            <a href="./obtain_tpl.php?id=<?php echo $_GET['id']?>">
                                <i class="arrow"></i>
                                <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/7.png"/></i><?php echo $now_ucenter['promotion_content'][16];?></span>
                            </a>
                        </div>
                    <?php } ?>

                </div>
                <?php }?>
            </div>
            <!--推广内容end-->
            <div class="cell dTab likesomes" style="display:block;margin-bottom: 46px;">

                <div class="hd">
                    <ul class="box">
                        <li class="b-flex">
                            <a style="color:#F15A0C;" data-flex="product" href="javascript:;">喜欢的商品</a>
                        </li>
                        <li class="b-flex">
                            <a data-flex="article" href="javascript:;">点赞的文章</a>
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
                                            <img style="width:60px;height;60px;" src="<?php echo getAttachmentUrl($collect['image']); ?>"/>
                                        </div>
                                        <div class="detailInfo">
                                            <h3><?php echo mb_substr($collect['name'],'0','12','utf-8');?></h3>
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
                                            <img style="width:60px;height;60px;"  src="<?php echo getAttachmentUrl($subject['pic']); ?>"/>
                                        </div>
                                        <div class="detailInfo">
                                            <h3><?php echo mb_substr($subject['name'],'0','12','utf-8');?></h3>
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
    <style>
    .custom-nav a {height: auto;}
    </style>
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
                $(this).parent('li').addClass('on').siblings().removeClass('on');
                $('.promotion').css('display','none');
                $('.orderNav').css('display','block');
                $('.consumption').css('display','block');
                $('.promotion-group').css('display','none');
                $('.consumption-group').css('display','block');
                $('.store-image').css('display','none');
                $('.user-image').css('display','block');

                $('.index_footer').css('display','none');
                $('.customer').css('display','block');
                $('.likesomes').css('display','block');

            }else if(data == 'promotion'){
                $(this).parent('li').addClass('on').siblings().removeClass('on');
                $('.likesomes').css('display','none');
                $('.consumption').css('display','none');
                $('.orderNav').css('display','none');
                $('.promotion').css('display','block');
                $('.promotion-group').css('display','block');
                $('.consumption-group').css('display','none');
                $('.user-image').css('display','none');
                $('.store-image').css('display','block');

                $('.index_footer').css('display','block');
                $('.customer').css('display','none');
            }
        });

        $('.box li a').click(function(){
            var flex = $(this).data('flex');
            if(flex == 'product'){
                $('.product').css('display','block');
                $(this).css('color','#F15A0C');
                $(this).parent().siblings('li').children('a').removeAttr('style');
                $('.article').css('display','none');
            }else if(flex == 'article'){
                $('.article').css('display','block');
                $(this).css('color','#F15A0C');
                $(this).parent().siblings('li').children('a').removeAttr('style');
                $('.product').css('display','none');
            }
        });

        var url = '<?php echo $config['wap_site_url'];?>/drp_register.php?id=<?php echo $store_id?>';
        $('.no-isfx').click(function(){
            window.location.href =url;
        });
        $('.no-status').click(function(){
            if (drp_center_show > 1) {
                warning();
            }
        });
    });

    function warning() {
        $('.motify').remove();
        $('body').append('<div class="motify"><div class="motify-inner"><?php echo $warning_msg; ?></div></div>');
        setTimeout(function () {
            $('.motify').remove();
        }, 3000);
    }
</script>
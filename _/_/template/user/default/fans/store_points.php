<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>店铺积分 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="description" content="<?php echo $config['seo_description'];?>">
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <meta name="renderer" content="webkit">
        <meta name="referrer" content="always">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <!-- ▼ Base CSS -->
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>css/jquery.ui.css" />
        <!-- ▲ Base CSS -->
        <!-- ▼ Member CSS -->
		<link href="<?php echo TPL_URL;?>css/coupon.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Member CSS -->
        <!-- ▼ Constant JS -->
		<script type="text/javascript">
			var load_url="<?php dourl('load');?>";
			var location_type = "shop_points";
			var page_content = "points_content";
			var store_points_edit = "<?php dourl('points_config_update') ?>";
			var set_config_subscribe = "<?php dourl('is_subscribe') ?>";
			var set_config_share = "<?php dourl('is_share') ?>";
			var set_config_offset = "<?php dourl('is_offset') ?>";
			var set_config_sign = "<?php dourl('is_sign') ?>";
		</script>
        <!-- ▲ Constant JS -->
        <!-- ▼ Base JS -->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/echart/echarts.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
        <!-- ▲ Base JS -->
        <!-- ▼ Member JS -->
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/store_points.js"></script>
        <!-- ▲ Member JS -->
		<style type="text/css">
			.widget-app-board-info { position: relative; }
			.pull-left { float: left; }
			.pull-right { float: right; }
			.ui-nav, .ui-nav2 { border: none; }
			.ui-nav li.active a { font-size: 16px; line-height: 40px; }
			.ui-nav-table li.active a { border-color: #ccc; }
			.widget-app-board { border: 1px solid rgba(255,255,255, 0.6); background-color: rgba(255,255,255, 0.6); }
			.check-on { border: 1px solid #6af; }
			.c-blue { color: #07d }
			.c-grey { color: #ccc; }
			.c-red { color: #f33; }
			.ui-input { width: 80px; }
			.ui-sep { border-right: 1px dashed #ccc;float: left;height: 30px;margin-left: 20px }
			.ui-sep:after { content: " "; }
			.ui-tip { float: left; color: #999; padding: 6px 0 0 20px; }
			.points-section { display: none; }
			.points-section.section-on { display: block; }
			.app-inner { padding-bottom: 20px; }
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:first_sidebar');?>
			<?php include display('sidebar');?>
		<!-- ▼ Container-->
		<div id="container" class="clearfix container right-sidebar">
			<div id="container-left">
				<!-- ▼ Third Header -->
				<div id="third-header">
				    <ul class="pull-left js-title-list third-header-inner">
						<li class="" id="config_spread">
							<a href="#config_spread">推广积分</a>
						</li>
						<li class="" id="config_trade">
							<a href="#config_trade">交易积分</a>
						</li>
						<li class="" id="config_worth">
							<a href="#config_worth">价值管理</a>
						</li>
						<li class="" id="config_checkin">
							<a href="#config_checkin">每日签到</a>
						</li>
					</ul>
				</div>
				<!-- ▲ Third Header -->
				<!-- ▼ Container App -->
				<div class="container-app">
					<div class="app-inner clearfix">
						<div class="app-init-container">
							<div class="nav-wrapper--app"></div>
							<div class="app__content">
								<div class="form-actions">
									<input class="btn btn-primary js-config-save" type="button" value="保 存" data-loading-text="保 存...">
								</div>
								<div class="points-section">
								<form class="section-form" onsubmit="return false;">
									<input type="hidden" name="type" value="spread">
									<div class="ui-nav">
										<ul>
											<li class="js-app-nav auto active">
												<a href="#">用户/分销商 【积分】 来源渠道</a>
											</li>
										</ul>
									</div>

									<div class="widget-app-board ui-box">
										<div class="widget-app-board-info">
											<h3>多级推广<span style="color:#f00;font-size:14px;">(绑定认证服务号此功能才会生效)</span></h3>
											<div class="clearfix">
												<!-- <p>需要开启“关注成为分销商” <a href="<?php dourl('fx:setting') ?>" target="_blank">快速开启</a></p><br> -->
												<div class="pull-left c-blue">
													<b>关注本店公众号，可获得积分</b> <input type="text" name="drp1_subscribe_point" class="ui-input" value="<?php echo $data['drp1_subscribe_point'] ?>" placeholder="0"> <br>
												</div>
												<div class="ui-sep"></div>
												<div class="ui-tip">
													<b>*关注获得积分</b>
												</div>
											</div>
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b>上一级推荐关注，可获得积分</b> <input type="text" name="drp2_subscribe_point" class="ui-input" value="<?php echo $data['drp2_subscribe_point'] ?>" placeholder="0"> <br>
												</div>
												<div class="ui-sep"></div>
												<div class="ui-tip">
													<b>*积分必须为正整数</b>
												</div>
											</div>
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b>上二级推荐关注，可获得积分</b> <input type="text" name="drp3_subscribe_point" class="ui-input" value="<?php echo $data['drp3_subscribe_point'] ?>" placeholder="0"> <br>
												</div>
												<div class="ui-sep"></div>
												<div class="ui-tip">
													<b>*推广等级采用分销设置等级，可获得佣金级别统一为三层</b>
												</div>
											</div>
										</div>
										<!-- 多级推广开关 -->
										<div class="widget-app-board-control limit">
											<label class="js-switch ui-switch pull-right js-config-subscribe <?php if ($data['is_subscribe']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
										</div>
									</div>

									<div class="widget-app-board ui-box">
										<div class="widget-app-board-info">
											<h3>分享获得积分</h3>
											<div class="clearfix">
												<p>需要开启“分享成为分销商” <a href="<?php dourl('fx:setting') ?>" target="_blank">快速开启</a></p><br>
												<div class="pull-left c-blue">
													<b>分享点击数(扫数)</b> <input type="text" name="share_click_num" class="ui-input" value="<?php echo $data['share_click_num'] ?>" placeholder="0"> <b>得积分</b> <input type="text" name="share_click_point" class="ui-input" value="<?php echo $data['share_click_point'] ?>" placeholder="0"><br>
												</div>
											</div>
										</div>
										<!-- 分享得积分开关 -->
										<div class="widget-app-board-control limit">
											<label class="js-switch ui-switch pull-right js-config-share <?php if ($data['is_share']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
										</div>
									</div>

									<div class="ui-nav">
										<ul>
											<li class="js-app-nav auto active">
												<a href="#">分销商专属 【分销积分】 来源渠道</a>
											</li>
										</ul>
									</div>

									<div class="widget-app-board ui-box">
										<div class="widget-app-board-info">
											<h3>发展分销商</h3>
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b>&nbsp; &nbsp;成为本店分销商，可获得积分</b> <input type="text" name="drp1_spoint" class="ui-input" value="<?php echo $data['drp1_spoint'] ?>" placeholder="1000"> <br>
												</div>
												<div class="ui-sep"></div>
												<div class="ui-tip">
													<b>*积分输入必须为正整数</b>
												</div>
											</div>
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b>发展下一级分销商，可获得积分</b> <input type="text" name="drp2_spoint" class="ui-input" value="<?php echo $data['drp2_spoint'] ?>" placeholder="100"> <br>
												</div>
												<div class="ui-sep"></div>
												<div class="ui-tip">
													<b>*积分必须为正整数</b>
												</div>
											</div>
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b>发展下二级分销商，可获得积分</b> <input type="text" name="drp3_spoint" class="ui-input" value="<?php echo $data['drp3_spoint'] ?>" placeholder="50"> <br>
												</div>
												<div class="ui-sep"></div>
												<div class="ui-tip">
													<b>*推广等级采用分销设置等级，可获得佣金级别统一为三层</b>
												</div>
											</div>
										</div>
									</div>
								</form>
								</div>
								<!-- 推广积分 end -->

								<!-- 交易积分 start -->
								<div class="points-section">
								<form class="section-form" onsubmit="return false;">
									<input type="hidden" name="type" value="trade">
									<div class="ui-nav">
										<ul>
											<li class="js-app-nav auto active">
												<a href="#">用户/分销商 【积分】 来源渠道</a>
											</li>
										</ul>
									</div>

									<div class="widget-app-board ui-box <?php if ($data['order_consume'] == 0) echo 'check-on'; ?>">
										<div class="widget-app-board-info">
											<h3><label><input type="radio" name="order_consume" value="0" <?php if ($data['order_consume'] == 0) echo 'checked=checked'; ?>> 满送积分</label></h3>
											<div class="clearfix" style="margin-top: 20px;">
												<div class="pull-left c-blue">
													<b>单笔消费金额满</b> <input type="text" name="consume_money" class="ui-input" value="<?php echo $data['consume_money'] ?>" placeholder="0"> <b>元</b> <b>送积分</b> <input type="text" name="consume_point" class="ui-input" value="<?php echo $data['consume_point'] ?>" placeholder="0"><br>
												</div>
												<div class="ui-sep"></div>
												<div class="ui-tip">
													<b>*不满，不送。消费金额倍数，方可累计赠送</b>
												</div>
											</div>
										</div>
									</div>

									<div class="widget-app-board ui-box <?php if ($data['order_consume'] == 1) echo 'check-on'; ?>">
										<div class="widget-app-board-info">
											<h3><label><input type="radio" name="order_consume" value="1" <?php if ($data['order_consume'] == 1) echo 'checked=checked'; ?>> 消费送积分</label></h3>
											<div class="clearfix" style="margin-top: 20px;">
												<div class="pull-left c-blue">
													<b>实际消费金额，生成积分比例 消费金额：</b> <input type="text" name="proport_money" class="ui-input" value="<?php echo $data['proport_money'] ?>" placeholder="0"> <b>元 转化为1积分 (数额需为正整数)</b><br>
												</div>
												<div class="ui-sep"></div>
												<div class="ui-tip" style="padding-left:0">
													<b>*实际过程中，订单金额非整数时，积分取整数值部分 4.9积分 取4积分</b>
												</div>
											</div>
										</div>
									</div>

									<div class="ui-nav">
										<ul>
											<li class="js-app-nav auto active">
												<a href="#">分销商专属 【分销积分】 来源渠道</a>
											</li>
										</ul>
									</div>

									<div class="widget-app-board ui-box">

										<div class="widget-app-board-info">
											<h3>销售积分</h3>
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b>实际销售金额生成积分比例 【销售金额】 每</b> <input type="text" name="drp1_spoint_money" class="ui-input" value="<?php echo $data['drp1_spoint_money'] ?>" placeholder="0"> <b>元 兑换1积分 (比例需要正整数)</b>  <br>
												</div>
												<div class="ui-sep"></div>
												<div class="ui-tip" style="padding:0; margin-bottom: 20px;">
													<b>*实际过程中，订单金额非整数时，积分取整数值部分 4.9积分 取4积分</b>
												</div>
											</div>
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b>上一级分销商 【分润金额】 每</b> <input type="text" name="drp2_spoint_money" class="ui-input" value="<?php echo $data['drp2_spoint_money'] ?>" placeholder="0"> <b>元 兑换1积分</b>  <br>
												</div>
											</div>
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b>上二级分销商 【分润金额】 每</b> <input type="text" name="drp3_spoint_money" class="ui-input" value="<?php echo $data['drp3_spoint_money'] ?>" placeholder="0"> <b>元 兑换1积分</b>  <br>
												</div>
											</div>
										</div>
									</div>
								</form>
								</div>
								<!-- 交易积分 end -->

								<!-- 价值管理 start -->
								<div class="points-section">
								<form class="section-form" onsubmit="return false;">
									<input type="hidden" name="type" value="worth">
									<div class="ui-nav">
										<ul>
											<li class="js-app-nav auto active">
												<a href="#">会员积分价值</a>
											</li>
										</ul>
									</div>

									<div class="widget-app-board ui-box">
										<div class="widget-app-board-info">
											<div class="clearfix">
												<div class="pull-left">
													<b class="c-blue">积分价值 每</b> <input type="text" name="price" class="ui-input" value="<?php echo $data['price'] ?>" > <b class="c-blue">积分 可以折算抵现1元</b><br>
													<b class="c-grey">*积分折算现金，积分数量为正整数。</b>
													<br>
												</div>
											</div>
										</div>
										<!-- 积分兑换开关 -->
										<div class="widget-app-board-control limit">
											<label class="js-switch ui-switch pull-right js-config-offset <?php if ($data['is_offset']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
										</div>
									</div>

									<div class="widget-app-board ui-box <?php if ($data['is_percent'] == 1) echo 'check-on'; ?>">
										<div class="widget-app-board-info">
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b><label style="display: inline;"><input type="checkbox" name="is_percent" placeholder="0" value="1" <?php if ($data['is_percent'] == 1) echo 'checked=checked'; ?>>交易每单可抵用订单金额比例</label></b> <input type="text" name="offset_cash" class="ui-input" value="<?php echo $data['offset_cash'] ?>" placeholder="0.00"> <b> %</b>
												</div>
											</div>
										</div>
									</div>

									<div class="widget-app-board ui-box <?php if ($data['is_limit'] == 1) echo 'check-on'; ?>">
										<div class="widget-app-board-info">
											<div class="clearfix">
												<div class="pull-left c-blue">
													<b><label style="display: inline;"><input type="checkbox" name="is_limit" placeholder="0" value="1" <?php if ($data['is_limit'] == 1) echo 'checked=checked'; ?>>默认每单交易抵现上限</label></b> <input type="text" name="offset_limit" class="ui-input" value="<?php echo $data['offset_limit'] ?>" placeholder="5"> <b> 元</b>
												</div>
											</div>
										</div>
									</div>

									<div class="ui-nav">
										<ul>
											<li class="js-app-nav auto active">
												<a href="#">分销商积分价值</a>
											</li>
										</ul>
									</div>

									<div class="widget-app-board ui-box">
										<div class="widget-app-board-info">
											<div class="clearfix">
												<div class="pull-left">
													<b>提升自身的分销等级</b>
													<br><br>
													<b>分销等级和自身的分润相关</b> <b class="c-red">等级越高，分销的分润值越大</b>
												</div>
											</div>
										</div>
									</div>
								</form>
								</div>
								<!-- 价值管理 end -->

								<!-- 每日签到 start -->
								<div class="points-section">
								<form class="section-form" onsubmit="return false;">
									<input type="hidden" name="type" value="checkin">
									<div class="ui-nav">
										<ul>
											<li class="js-app-nav auto active">
												<a href="#">用户积分/分销商积分 签到获取</a>
											</li>
										</ul>
									</div>

									<div class="widget-app-board ui-box">
										<div class="widget-app-board-info">
											<div class="clearfix">
												<div class="pull-left" style="padding-top: 10px;">
													<b class="c-red">* 积分签到需要开启才能生效</b>
												</div>
											</div>
										</div>
										<!-- 签到开关 -->
										<div class="widget-app-board-control limit">
											<label class="js-switch ui-switch pull-right js-config-sign <?php if ($data['sign_set']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
										</div>
									</div>

									<div class="widget-app-board ui-box <?php if ($data['sign_type'] == 0) echo 'check-on'; ?>">
										<div class="widget-app-board-info">
											<h3><label><input type="radio" name="sign_type" value="0" <?php if ($data['sign_type'] == 0) echo 'checked=checked'; ?>> 每日固定积分</label></h3>
											<div class="clearfix" style="margin-top: 20px;">
												<div class="pull-left c-blue">
													<b>每日签到一次，签到积分</b> <input type="text" name="sign_fixed_point" class="ui-input" value="<?php echo $data['sign_fixed_point'] ?>" placeholder="0"><br>
												</div>
											</div>
										</div>
									</div>

									<div class="widget-app-board ui-box <?php if ($data['sign_type'] == 1) echo 'check-on'; ?>">
										<div class="widget-app-board-info" style="width:90%;">
											<h3><label><input type="radio" name="sign_type" value="1" <?php if ($data['sign_type'] == 1) echo 'checked=checked'; ?>> 累计签到模式</label></h3>
											<div class="clearfix" style="margin-top: 20px;">
												<div class="pull-left c-blue">
													<b>首次签到积分</b> <input type="text" name="sign_plus_start" class="ui-input" value="<?php echo $data['sign_plus_start'] ?>" placeholder="0"> 
													<b>连续签到每日额外增加积分</b> <input type="text" name="sign_plus_addition" class="ui-input" value="<?php echo $data['sign_plus_addition'] ?>" placeholder="0"> 
													<b>连续签到上限天数</b> <input type="text" name="sign_plus_day" class="ui-input" value="<?php echo $data['sign_plus_day'] ?>" placeholder="0"> <b>天</b>
												</div>
												<div class="ui-tip" style="padding-left:0">
													<b>* 比如：第一天签到5分，第二天签到5+5分，持续7天、第7天为5+6*5=35分；后续保持35分，不会再增加</b>
													<br>
													<b>* 一旦中断持续签到，则从第一天重新计算</b>
													<br>
													<b class="c-red">* 只有在【累计签到模式】下，才会累计签到天数，切换为【每日固定积分】后，用户点击签到，则会将之前的累计天数清零</b>
												</div>
											</div>
										</div>
									</div>
								</form>
								</div>
								<!-- 每日签到 end -->

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>
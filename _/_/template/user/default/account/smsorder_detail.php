<html>
<head>
    <meta charset="utf-8"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit"/>
    <title id="js-meta-title">短信记录详细 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
    <link rel="icon" href="./favicon.ico" />
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css" />
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/app_team.css" />
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL; ?>js/base.js"></script>
	<script type="text/javascript">var load_url="<?php dourl('load');?>", buysms_url="<?php dourl('buysms'); ?>", dobuysms_url="<?php dourl('account:dobuysms'); ?>", select_url="<?php dourl('store:select'); ?>";</script>
	<script type="text/javascript" src="<?php echo TPL_URL; ?>js/account_sms_record.js"></script>
<style>
.block-help>a {
  display: inline-block;
  width: 16px;
  height: 16px;
  line-height: 18px;
  border-radius: 8px;
  font-size: 12px;
  text-align: center;
  background: #bbb;
  color: #fff;
}
.block-help>a:after {
  content: "?";
}		
.hide{display:none}
	</style>
</head>
<body>
	<div id="hd" class="wrap rel">
		<div class="wrap_1000 clearfix">
			<h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
				<?php if($config['pc_shopercenter_logo'] != ''){?>
					<a href="<?php dourl('store:select');?>">
						<img src="<?php echo $config['pc_shopercenter_logo'];?>" height="35" alt="<?php echo $config['site_name'];?>" style="height:35px;width:auto;max-width:none;"/>
					</a>
				<?php }?>
			</h1>
			<h2 class="tc hd_title">购买短信</h2>
		</div>
	</div>
	<div class="container wrap_800">
			<div class="content" role="main">
				<div class="app">
					<div class="app-init-container">
						<div class="team">
							<div class="wrapper-app">
								<div id="header">
									<div class="addition">
										<div class="user-info">
											<span class="avatar" style="background-image: url(<?php if (!empty($avatar)) { ?><?php echo $avatar; ?><?php } else { ?>./static/images/avatar.png<?php } ?>)"></span>
											<div class="user-info-content">
												<div class="info-row"><?php echo !empty($user_session['nickname']) ? $user_session['nickname'] : ''; ?>
												</div>
												<?php if (!empty($user_session['phone'])) { ?>
												<div class="info-row info-row-info">账号: <?php echo $user_session['phone']; ?></div>
												<?php } ?>
	
												<a href="<?php dourl('account:personal'); ?>" class="personal-setting">设置</a>
											</div>

											
											<div class="search-team hide">
												<div class="form-search">
													<input type="text" class="span3 search-query" placeholder="搜索店铺/微信/微博"/>
													<button type="button" class="btn search-btn">搜索</button>
												</div>
											</div>
											<div class="team-opt-wrapper" style="bottom:45px;">
												您账户还剩 <font	style="color:#f00;font-weight:700"><?php echo $user['smscount'];?></font> 条短信，点击 
													<a href="<?php dourl('account:sms_record'); ?>" class="">这里</a> 进行购买
													<span class="block-help">
														<a href="javascript:void(0);" class="js-help-notes"></a>
															<div class="js-notes-cont hide">
																<p><strong>1.</strong>短信如不足,与店铺相关短信通知无法传达！</p>
															</div>
													</span>
		<style>
		.popover-inner {padding: 3px; width: 280px;overflow: hidden; background: #000000;background: rgba(0, 0, 0, 0.8);border-radius: 4px;-webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);}
		.popover.bottom .arrow {/* left: 50%; */ margin-left: 105px;border-left: 5px solid transparent;border-right: 5px solid transparent;border-bottom: 5px solid #000000;}
		.popover.bottom .arrow:after {top: 1px;border-bottom-color: #ffffff; border-top-width: 0;}
		.team-opt-wrapper .block-help>a:hover { background: #4b0;color:#fff }
		</style>													
		<script>	
		var t2 = '';		
		 $('.js-help-notes').hover(function(){
            var content = $(this).next('.js-notes-cont').html();
            $('.popover-help-notes').remove();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left - 250) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + content + '</div></div></div>';
            $('body').append(html);
            $('.popover-help-notes').show();
        }, function(){
            t2 = setTimeout('hide2()', 200);
        })		
        $('.popover-help-notes').live('hover', function(event){
            if (event.type == 'mouseenter') {
                clearTimeout(t2);
            } else {
                clearTimeout(t2);
                hide2();
            }
        })
		function hide() {
			$('.popover-intro').remove();
		}
		function hide2() {
			$('.popover-help-notes').remove();
		}
		function msg_hide() {
			$('.notifications').html('');
			clearTimeout(t0);
		}	
		</script>											
													
													
													
													
													
											</div>
											
											<div class="team-opt-wrapper">
												<a href="<?php dourl('store:select');?>" class="js-create-all">返回 选择公司/店铺</a>
											</div>
											
										</div>
									</div>
								</div>
								<div id="content">

								</div>
							</div>
							<?php $show_footer_link = false; include display('public:footer');?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<script>
$(function(){
	$("#shortcut-2014 .fr li").hover(function(){
		if($(this).find(".cw-icon")) {
			$(this).removeClass("dorpdown").addClass("hover");
		}
	},function(){
		if($(this).find(".cw-icon")) {
			$(this).removeClass("hover").addClass("dorpdown");;
		}
	})
	
})
</script>
<style>.steps .part2{position:static}</style>
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/public.css" />
<div class="header">
<div id="shortcut-2014">
				<div class="ws">
					<ul  class="fl">
						<li  id="ttbar-login" class=" dorpdowns">
							<div class="dt cw-icon"><i class="ci-left"></i></div>
							<?php if(empty($user_session)){?>
								
									Hi，欢迎来 <?php echo option('config.site_name');?>&nbsp;<a class="link-login style-red" target="_top" href="<?php echo url('account:login') ?>">请登录</a>&nbsp;&nbsp;
									<a class="link-regist style-red"  target="_top" href="<?php echo url('account:register') ?>" >免费注册</a>	
							<?php }else{?>	
									你好，<a class="link-login" href="<?php echo url('account:index') ?>" ><?php echo $user_session['nickname'];?></a>&nbsp;&nbsp;
									<a class="link-regist style-red" target="_top" href="<?php echo url('account:logout') ?>">退出</a>							
							<?php }?>
						</li>	
					</ul>
					<ul class="fr">
						<li  id="ttbar-gwc" class="fore2">
							<div class="dt cw-icon">
								<i class="ci-left"></i>
								<a href="<?php echo url('cart:one') ?>" target="_blank">购物车
								<span class="mc-count mc-pt3" id="header_cart_number">0</span> 件</a>
							</div>
						</li>
						<li class="spacer"></li>
						
						<li  class="fore3 dorpdown" data-load="1">
							<div class="dt cw-icon">
									<i class="ci-right"></i>
									<a href="<?php echo url('account:order') ?>" target="_blank">我的订单</a>
								</div>
						</li>
						<li class="spacer"></li>
						
						<li id="ttbar-servs2"  class="fore4 dorpdown">
							<div class="dt cw-icon">
								<i class="ci-right"><s>◇</s></i>
								<a href="<?php echo url('account:index') ?>" target="_blank">我的账户</a>
							</div>
							<div class="dd dorpdown-layer">
								<div class="dd-spacer"></div>
								<div class="item"><a target="_blank" href="<?php echo url('account:index') ?>">个人设置</a></div>
								<div class="item"><a target="_blank" href="<?php echo url('account:password') ?>">修改密码</a></div>
								<div class="item"><a target="_blank" href="<?php echo url('account:address') ?>">收货地址</a></div>
							</div>
						</li>
						<li class="spacer"></li>
						
						<li id="ttbar-servs"  class="fore5 dorpdown">
							<div class="dt cw-icon">
								<i class="ci-right"><s>◇</s></i>我的收藏
							</div>
							<div class="dd dorpdown-layer">
								<div class="dd-spacer"></div>
								<div class="item"><a target="_blank" href="<?php echo url('account:collect_goods') ?>">收藏的宝贝</a></div>
								<div class="item"><a target="_blank" href="<?php echo url('account:collect_store') ?>">收藏的店铺</a></div>
							</div>
						</li>
						<li class="spacer"></li>
						
						<li  id="ttbar-apps" class="fore6 dorpdown"  data-load="1">
								<div class="dt cw-icon">
									<i class="ci-left"></i>
									<i class="ci-right"><s>◇</s></i><!--扫一扫，定制我的微店！-->
									<a href="javascript:void(0)" target="_blank">&nbsp;&nbsp;微信版&nbsp;&nbsp;</a>
								</div>
								<div style="" class="dd dorpdown-layer">				
									<div class="dd-spacer"></div>				
									<div id="ttbar-apps-main" class="dd-inner" >
										<img src="<?php echo option('config.wechat_qrcode');?>" width="150px" height="150px">
										<p><b>扫一扫，定制我的微店！</b></p>
									</div>			
								</div>		
						</li>
						<li class="spacer"></li>

						
						<li  id="ttbar-serv" class="fore8 dorpdown" data-load="1">
							<div class="dt cw-icon">
								<i class="ci-right"><s>◇</s></i>卖家中心
							</div>
							<div class="dd dorpdown-layer">
								<div class="dd-spacer"></div>
								<div class="item"><a target="_blank" href="<?php echo url('user:store:select') ?>">我的店铺</a></div>
								<div class="item"><a target="_blank" href="<?php echo url('user:store:index') ?>">管理店铺</a></div>
							</div>
						</li>

					</ul>
					<span class="clr"></span>
				</div>
			</div>
</div>
<div class="danye_menu">
	<ul>
		<li class="danye_index"><a href="/"><img src="<?php echo option('config.pc_usercenter_logo');?>" /></a></li>
		<li class="danye_list"><a href="<?php echo url('account:index') ?>">会员首页</a></li>
		<li class="danye_list"><a href="<?php echo url('account:index') ?>">个人资料</a></li>
		<li class="fanhui"><a href="/">返回首页<span></span></a></li>
	</ul>
</div>
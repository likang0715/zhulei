<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){echo ' responsive-320';}elseif($_GET['ps']>=540){echo ' responsive-540';} if($_GET['ps']>540){echo ' responsive-800';} ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>关注店铺</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<?php if($is_mobile){ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
			<script>var is_mobile = true;</script>
		<?php }else{ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
			<script>var is_mobile = false;</script>
		<?php } ?>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script>var storeId = <?php echo $now_store['store_id']?>;</script>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
	<script src="<?php echo TPL_URL;?>js/base.js"></script>
	<script src="<?php echo TPL_URL;?>js/sku.js"></script>
	<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
	<script src="<?php echo TPL_URL;?>js/guanzhu.js"></script>
	<script>var page_url = '<?php echo $page_url;?>&ajax=1';</script>
<style>
.tabber {width: 100%;color: #333;font-size: 14px;background-color: #fff;}
.tabber.tabber-ios {border: 1px solid #f60;height: 28px;border-radius: 3px;margin: 0 20px;width: auto;overflow: hidden;}
.tabber.tabber-ios a {color: #f60;height: 28px;line-height: 28px;border: 0px none;background-color: transparent;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}
.tabber a.active {color: #22C415;border-top: 1px solid #e5e5e5;border-bottom: 1px solid #22C415;}
.tabber .c_middle {
  border-left: 1px solid #f60 !important;
  border-right: 1px solid #f60 !important;
 /*  width: 34%; */
}
.list_comments li {
  padding: 5px 0;
}
.tbox {
  width: 100%;
  height: 100%;
}
.tbox > * {
  height: 100%;
  display: table-cell;
  vertical-align: top;
}
.list_comments .tbox>* {
  vertical-align: middle;
  padding: 15px 0;
}
.list_comments .tbox > *:first-of-type {
  padding: 0 5px;
  text-align: center;
}
.list_comments .tbox>*:first-of-type {
  padding: 0 5px;
  text-align: center;
}

.list_comments .img_wrap {
  display: inline-block;
  width: 34px;
  height: 34px;
  border-radius: 100px;
  overflow: hidden;
}
.list_comments .tbox>*:first-of-type p {
  padding: 3px 5px 0 0;
  width: 70px;
  font-size: 10px;
  color: #4a4a4a;
}
.list_comments .tbox>*:first-of-type p:nth-of-type(2) {
  font-size: 9px;
  color: #7f8c8d;
}
.tbox .comment_content {
  text-align: left;
}
.list_comments .comment_content {
  color: #4a4a4a;
  font-size: 11px;
  line-height: 18px;
  word-break: break-all;
}
.list_comments .comment_rate, .list_comments .comment_time {
  display: inline-block;
  height: 18px;
  line-height: 18px;
  font-size: 9px;
  color: #7f8c8d;
  width: 152px;
  padding:0 20px;
}
.list_comments .comment_time {
  position: absolute;
  right: 0px;
  margin-top: 3px;
  text-align: right;
}

.s_empty {
  color: #999;
  display: none;
  height: 70px;
  line-height: 70px;
  text-align: center;
  background: none;
  background-color: none;
}
.list_comments .img_wrap img {
  width: 100%;
  height: 100%;
  border-radius: 100px;
}
</style>

		
	</head>
	<body <?php if(!empty($storeNav)){ ?>style="padding-bottom:45px;"<?php } ?>>
		<div class="container">
			<div class="header">
				<?php if(!$is_mobile && $_SESSION['user']){ ?>
				<div class="headerbar">
					<div class="headerbar-wrap clearfix">
						<div class="headerbar-preview">
							<span>预览：</span>
							<ul>
								<li>
								   <a href="<?php echo $now_url;?>&ps=320" class="js-no-follow<?php if(empty($_GET['ps']) || $_GET['ps'] == '320') echo ' active';?>">iPhone版</a>
								</li>
								<li>
								   <a href="<?php echo $now_url;?>&ps=540" class="js-no-follow<?php if($_GET['ps'] == '540') echo ' active';?>">三星Note3版</a>
								</li>
								<li>
								   <a href="<?php echo $now_url;?>&ps=800" class="js-no-follow<?php if($_GET['ps'] == '800') echo ' active';?>">PC版</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- ▼顶部通栏 -->
				<div class="js-mp-info share-mp-info">
					<a class="page-mp-info" href="<?php echo $now_store['url'];?>">
						<img class="mp-image" width="24" height="24" src="<?php echo $now_store['logo'];?>" alt="<?php echo $now_store['name'];?>"/>
						<i class="mp-nickname"><?php echo $now_store['name'];?></i>
					</a>
					<div class="links">
						<a class="mp-homepage" href="<?php echo $now_store['ucenter_url'];?>">会员中心</a>
					</div>
				</div>
				<!-- ▲顶部通栏 -->
			</div>
			
			
			
			<div class="content">
				<div class="content-body">
				
				
				
						
					<!-- ----------------------------------------------------------------------- -->	
						
<section class="section_comments section_section" data-type="default" style="display: block;padding-top:10px;">
	<div>
		<div class="tabber tabber_menu tabber-ios clearfix js-comment-tab">
			<a class="active" data-tab="1">收藏店铺</a>
			<a class="c_middle" data-tab="2">关注店铺</a>
		</div>
	</div>
	<div id="list_comments">
		<ul class="list_comments on" id="list_comments_1" data-page="1" data-type="default" next="true" style="display: block;">
	
				<div class="s_empty" style="display:hidden;">
					已无更多关注！
				</div>
		</ul>
		
		<ul class="list_comments on" id="list_comments_2" data-page="2" data-type="default" next="true" style="display: hidden;">
	
				<div class="s_empty" style="display:hidden;">
					已无更多收藏！
				</div>
		</ul>
								
		<div class="wx_loading1" style="display: none;">
			<i class="wx_loading_icon"></i>
		</div>
	<div class="wx_loading2" style="display: none;">
			<i class="wx_loading_icon"></i>
		</div>
		<div class="empty-list" style="margin-top:40px;display: none">
			<div><span class="font-size-16 c-black">神马，还没有被关注？</span></div>
			<div>
				<span class="font-size-12">怎么能忍？</span>
			</div>
		</div>
		<div class="s_empty" id="noMoreTips">
			已无更多关注！
		</div>
	</div>
</section>
						
						
						
						
						
						
					<!-- ----------------------------------------------------------------------- -->	
						<?php if($goodList['pagebar']){ ?>
							<div class="custom-paginations-container">
								<div class="custom-paginations clearfix"><?php echo $goodList['pagebar'];?></div>
							</div>
						<?php } ?>
				</div>
				
				
				
				
				
				
				
				
				<?php if(!$is_mobile){ ?>
					<div class="content-sidebar">
						<a href="<?php echo $now_store['url'];?>" class="link">
							<div class="sidebar-section shop-card">
								<div class="table-cell">
									<img src="<?php echo $now_store['logo'];?>" width="60" height="60" class="shop-img" alt="<?php echo $now_store['name'];?>"/>
								</div>
								<div class="table-cell">
									<p class="shop-name"><?php echo $now_store['name'];?></p>
								</div>
							</div>
						</a>
					</div>
				<?php } ?>
				<?php if(!empty($storeNav)){ echo $storeNav;}?>
			</div>
			<?php include display('footer');?>
			<?php echo $shareData;?>
		</div>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'search', '店铺关注', $now_store['store_id']); ?>
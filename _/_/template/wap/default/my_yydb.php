<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>我的一元夺宝 - <?php echo $now_store['name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/customer.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/coupon.css"/>
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/coupon11.js"></script>
		<style>
			/*.promote-card-list .promote-item{height:180px;}*/
			/*.promote-card-list  .curr_li{height:120px}*/
			.promote-card-list .curr_li{height: auto}
			.tabber.tabber-n4 button, .tabber.tabber-n4 a{width:33.3%}
			.tabber.tabber-ios{margin:0px;}
			.tabber button, .tabber a{width:25%}
			
			.m_buylist li {
				border-bottom: 1px solid #e5e5e5;
				padding: 15px 10px;
				overflow: hidden;
			}
			.m_buylist li.in_progress a, .in_progress li a {
				padding: 15px 10px;
			}
			.m_buylist li a {
				display: block;
			}
			.m_buylist cite {
				float: left;
				width: 74px;
				height: 74px;
				border: 1px solid #e5e5e5;
				border-radius: 3px;
				position: relative;
			}	
			.m_buylist cite img {
				width: 64px;
				height: 64px;
				padding: 5px;
			}
			fieldset, img {
				border: 0;
			}	

			.m_buylist cite i {
				display: block;
				width: 76px;
				height: 16px;
				line-height: 16px;
				color: #fff;
				position: absolute;
				left: -1px;
				bottom: -1px;
				text-align: center;
				filter: alpha(opacity=30);
				-moz-opacity: 0.3;
				-khtml-opacity: 0.3;
				opacity: 0.3;
				border-radius: 0 0 2px 2px;
				font-style: normal;
			}
			.m_buylist cite i {
				background: #000;
			}
			.m_buylist a cite i {
				background: #f60;
			}
			.m_buylist dl {
				margin-left: 86px;
				line-height: 18px;
			}	
			.m_buylist a dt {
				height: 18px;
				overflow: hidden;
				color: #666;
			}
			.m_buylist dt {
				display: block;
				margin-bottom: 3px;
				font-size: 14px;
				line-height: 18px;
			}
			.m_buylist dd {
				color: #999;
			}	
			.m_buylist dd em {
				margin: 0 3px;
			}
			.wrapper em {
				font-family: Arial,Helvetica,sans-serif;
			}
			.orange {
				color: #f60;
			}	
			.gRate {
				line-height: 16px;
			}	
			.Progress-bar {
				zoom: 1;
			}	
			.u-progress {
				height: 5px;
				background: #e7e7e7;
				position: relative;
				border-radius: 3px;
				overflow: hidden;
			}		
			.u-progress .pgbar, .u-progress .pging {
				display: block;
				width: 100%;
				height: 100%;
				border-radius: 3px;
			}	
			.u-progress .pging {
				background: #f60;
			}
			
.Progress-bar .Pro-bar-li li {
    float: left;
    color: #ccc;
    font-size: 10px;
    font-family: 宋体;
    border: none;
    margin: 0;
    padding: 0;
    box-shadow: none;
    border-radius: none;
}				
.gRate .Progress-bar li {
    font-size: 12px;
    color: #bbb;
}			
			
.Progress-bar .Pro-bar-li li.P-bar01 {
    width: 30%;
    text-align: left;
}
.Progress-bar .Pro-bar-li li em {
    display: block;
    font-size: 10px;
    font-family: arial;
    height: 14px;
    padding: 2px 0 0 0;
    font-style: normal;
}
.Progress-bar .Pro-bar-li li.P-bar01 em {
    color: #F60;
}
.gRate .Progress-bar li em {
    margin: 0;
    padding: 0;
}
.Progress-bar .Pro-bar-li li.P-bar02 {
    width: 40%;
    text-align: center;
}
.Progress-bar .Pro-bar-li li.P-bar03 {
    width: 30%;
    float: right;
    text-align: right;
}
.m_buylist dd a {
    display: inline-block;
}
.blue {
    color: #49b8ff;
}
.m_buylist dd em {
    margin: 0 3px;
}
.m_buylist em {
    font-family: Arial,Helvetica,sans-serif;
	font-style: normal;
}


.m_buylist_nav {
    background: #fafafa;
    padding: 10px;
    border-bottom: 1px solid #e5e5e5;
}

.m_buylist_nav p {
    border-radius: 5px;
    border: 2px solid #f60;
    height: 30px;
    line-height: 30px;
    overflow: hidden;
    width: 100%;
    display: box;
    display: -webkit-box;
    display: -moz-box;
}
.wrapper {
    min-width: 320px;
    width: 100%;
    margin: 0 auto;
    background: #fff;
}
.m_buylist_nav a {
    text-align: center;
    color: #f60;
    border-left: 2px solid #f60;
    margin-left: -2px;
    font-size: 14px;
    -webkit-box-flex: 1;
    -moz-box-flex: 1;
    box-flex: 1;
    display: block;
}
.m_buylist_nav a.hover {
    background: #f60;
    color: #fff;
}
.m_buylist_nav a em {
    font-size: 12px;
    margin-left: 2px;
}
.m_buylist_nav a.hover {
    background: #f60;
    color: #fff;
}
.container{background:#fff;}
.Progress-bar .Pro-bar-li li.P-bar03 em {
    color: #2AF;
}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="block block-border-none"><!--
					<div class="tabber tabber_menu  tabber-ios clearfix">
						<a <?php if($type=='all'){ ?>class="active"<?php } ?> href="#all">全部</a>
						<a <?php if($type=='used'){ ?>class="active"<?php } ?> href="#used">进行中</a>
						<a <?php if($type=='unused'){ ?>class="active"<?php } ?> href="#unused">已结束</a>
						<a <?php if($type=='unused'){ ?>class="active"<?php } ?> href="#unused">夺宝成功</a>
					</div>
					-->
				<div class="m_buylist_nav" id="navBox">
					<p>
						<a class="hover" <?php if($type=='all'){ ?>class="active"<?php } ?> href="#all">全部</a>
						<a <?php if($type=='used'){ ?>class="active"<?php } ?> href="#used">进行中</a>
						<a <?php if($type=='unused'){ ?>class="active"<?php } ?> href="#unused">已结束</a>
						<a <?php if($type=='unused'){ ?>class="active"<?php } ?> href="#unused">夺宝成功</a>
					</p>
				</div>	
				
				</div>
				<div class="block block-coupon-list block-list2 block-no-background">
					<div class="mod_itemgrid hide" id="itemList"></div>

					<div class="hproduct">
						<ul class="promote-card-list">	</ul>
					</div>

					<!--
					<div class="wx_loading2"><i class="wx_loading_icon"></i></div>
					-->
						
					<div id="divBuyList" class="m_buylist marginB">
							<ul>
								<li class="in_progress" style="padding-top:0px;">
								<!--追加-->
									<a href="my_yydb_detail.php?action=zj">
										<cite><img src="http://image.pigcms.com/pyxtbb1440638937/2015/10/28/1445995308_1i39sy0cgvjbnl72.jpg"><i>进行中</i></cite>
										<dl>
											<dt>活动名称</dt>
											<dd>已参与<em class="orange">6031</em>人次</dd>
											<dd>
												<div class="gRate">
												<div class="Progress-bar">
													<p class="u-progress"><span style="width:1.2062%;" class="pgbar"><span class="pging"></span></span></p>
													<ul class="Pro-bar-li"><li class="P-bar01"><em>6031</em>已参与</li><li class="P-bar02"><em>500000</em>总需人次</li><li class="P-bar03"><em>493969</em>剩余</li></ul>
												</div>
												</div>
											</dd>
										</dl>
									</a>
								</li>
							</ul>
							
							<ul>
								<li>
									<cite><a href="my_yydb_detail.php?action=detail"><img src="http://image.pigcms.com/pyxtbb1440638937/2015/09/16/1442369609_17db7ad4aa9fd95f.png"></a><i>已结束</i></cite>
									<dl><dt><a href="my_yydb_detail.php?action=detail" class="gray6">/home/www</a></dt><dd>获得者：<a href="" class="blue">祝超</a></dd><dd>揭晓时间：<em>2016-02-27 09:51:13</em></dd></dl>
								</li>
							</ul>
							<!--
								<div class="noRecords gray9" style="display:none"><s></s>暂无记录</div>
								<div id="divGoodsLoading" class="loading" style="display: none;"><b></b>正在加载</div>
							-->
					</div>
						
						<div class="empty-list" style="margin-top:40px;display: none">
							<div>
								<span class="font-size-16 c-black">神马，我还没有券？</span>
							</div>
							<div>
								<span class="font-size-12">怎么能忍？</span>
							</div>
							<div><a href="javascript:void(0)" class="tag tag-big tag-orange" style="padding:8px 30px;">马上去领取</a></div>
						</div>
					<div class="s_empty" id="noMoreTips">已无更多优惠券！</div>

				</div>
			</div>
			<?php include display('footer');?>
		</div>
	</body>
</html>
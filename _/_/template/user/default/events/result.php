<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>报名管理 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<meta name="renderer" content="webkit">
	<meta name="referrer" content="always">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ▼ Base CSS -->
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>js/ueditor/themes/default/css/ueditor.css" type="text/css"/>
	<!-- ▲ Base CSS -->
	<!-- ▼ Order CSS -->
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/freight.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/hint.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>js/ueditor/third-party/codemirror/codemirror.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/events.css" type="text/css"/>
	<!-- ▲ Order CSS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">var load_url="<?php  dourl('events:load');?>", store_name_check_url = "<?php dourl('store_name_check'); ?>",store_setting_url="<?php dourl('store'); ?>",events_add_url="<?php dourl('physical_add'); ?>",events_edit_url="<?php dourl('physical_edit'); ?>",events_del_url="<?php dourl('physical_del'); ?>",static_url="<?php echo TPL_URL;?>";</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/ueditor.all.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/lang/zh-cn/zh-cn.js" defer="defer"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/third-party/codemirror/codemirror.js" defer="defer"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Order JS -->
	<!-- <script type="text/javascript" src="<?php echo TPL_URL;?>js/events.js"></script>-->
	<script type="text/javascript" src="./js/meaz.js"></script>
	<!-- ▲ Order JS --> 
</head>
<body class="font14 usercenter">
	<?php include display('public:first_sidebar');?>
	<?php include display('sidebar');?>
	<!-- ▼ Container-->
	<div id="container" class="clearfix container right-sidebar">
		<div id="container-left">
			<!-- ▼ Third Header -->
			<div id="third-header">
				<ul class="third-header-inner">
					<li class="active">
						<a href="javascript:;">报名管理</a>
					</li>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content">
							<div class="events_list">
								<!-- 内容头部 -->
								<div class="events_results">
									<div class="events_results_t">
										<div class="events_results_t_left"><img src="upload/<?php echo $chahui['images'];?>"></div>
										<div class="events_results_t_right">
											<h4><?php echo $chahui['name'];?></h4>
											<p class="date"><?php echo $chahui['sttime'];?> ～ <?php echo $chahui['endtime'];?></p>
											<p class="address"><?php echo $chahui['province_txt'];?><?php echo $chahui['city_txt'];?><?php echo $chahui['county_txt'];?><?php echo $chahui['address'];?></p>
											<p class="type"><?php echo $chahui['category'];?></p>
											<p class="number">限额<?php echo $chahui['renshu'];?>人&nbsp;&nbsp;&nbsp;&nbsp;已报名：<?php echo $count;?>人</p>
										</div>
									</div>
									<div class="events_results_c">
										<div class="events_results_c_nav">
											<ul>
												<a href="<?php dourl('events:result');?>&id=<?php echo $_REQUEST['id'];?>"><li <?php if(empty($_REQUEST['status'])){?> class="cur"<?php } ?>>全部</li></a>
												<a href="<?php dourl('events:result');?>&id=<?php echo $_REQUEST['id'];?>&status=1"><li <?php if($_REQUEST['status']==1){?> class="cur"<?php } ?>>待审核</li></a>
												<a href="<?php dourl('events:result');?>&id=<?php echo $_REQUEST['id'];?>&status=3"><li <?php if($_REQUEST['status']==3){?> class="cur"<?php } ?>>审核通过</li></a>
												<a href="<?php dourl('events:result');?>&id=<?php echo $_REQUEST['id'];?>&status=2"><li <?php if($_REQUEST['status']==2){?> class="cur"<?php } ?>>审核未通过</li></a>
											</ul>
										</div>
									</div>
									<div class="events_results_b">
										<div class="events_results_b_nav">
											<ul>
												<li>报名人姓名</li>
												<li>手机号</li>
												<li>审核状态</li>
												<li>报名时间</li>
												<li>操作</li>
											</ul>
										</div>
										
										<?php if(!empty($result)){ ?>
										<?php foreach($result as $value){ ?>
										<div class="events_results_b_list">
											<ul>
												<li><?php echo $value['name'];?></li>
												<li><?php echo $value['mobile'];?></li>
												<li><?php if($value['status']==1){echo '待审核';}elseif($value['status']==2){echo '审核未通过';}elseif($value['status']==3){echo '审核通过';}?></li>
												<li><?php echo date('Y-m-d',$value['addtime']);?></li>
												<li><?php if($value['status']==1){?><a href="<?php echo dourl('events:bm_edit'); ?>&id=<?php echo $value['id'];?>&cid=<?php echo $_REQUEST['id'];?>&status=2" class="delete">拒绝报名</a> | <a href="<?php echo dourl('events:bm_edit'); ?>&cid=<?php echo $_REQUEST['id'];?>&id=<?php echo $value['id'];?>&status=3" class="delete">通过报名</a>
													<?php } ?>
													<?php if($value['status']==2){?><a href="<?php echo dourl('events:bm_edit'); ?>&id=<?php echo $value['id'];?>&cid=<?php echo $_REQUEST['id'];?>&status=3" class="delete">通过报名</a>
													<?php } ?>
												</li>
											</ul>
										</div>
										<?php } ?>
										<?php }else{ ?>
										<div class="js-list-empty-region">
											<div>
												<div class="no-result widget-list-empty">还没有相关数据。</div>
											</div>
										</div>
										<?php } ?>
										
									</div>
									<?php
									
									if ($pages) {
										?>
										<table align="center">
											<thead class="js-list-header-region tableFloatingHeaderOriginal">
												<tr>
													<td colspan="5">
														<div class="pagenavi js-present_list_page" id="pages">
															<span class="total"><?php echo $pages ?></span>
															
														</div>
													</td>
												</tr>
											</thead>
										</table>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include display('public:footer');?>
</body>
</html>
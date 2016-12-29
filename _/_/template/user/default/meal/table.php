<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>茶桌管理 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>E点茶<?php } ?></title>
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<meta name="renderer" content="webkit">
	<meta name="referrer" content="always">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ▼ Base CSS -->
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
	<!-- ▲ Base CSS -->
	<!-- ▼ Table CSS -->
	<link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/table.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Table CSS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">
	var catDom = '<div class="cat_edit"><div class="cat_edit_top"><div class="top_left left"><input type="checkbox" id="all_select""><span>全选</span><span class="js-del-all">删除</span></div><div class="top_right right"><span class="js-add-cat">新增分类</span></div></div><?php if(!empty($cat_list)){ ?><div class="cat_edit_list"><div class="cat_item cat_item_t" data-catid=""><div class="cat_item_con list_name_t"><span>分类名称</span></div><div class="cat_item_con list_sort_t"><span>显示排序</span></div><div class="cat_item_con list_btn_t"><span>操作</span></div></div><?php foreach($cat_list as $r){ ?><div class="cat_item" data-catid="<?php echo $r["cat_id"];?>"><div class="cat_item_con list_name"><input type="checkbox" class="cat_all" value="<?php echo $r["cat_id"];?>"><span class="state-show cat-name"><?php echo $r["cat_name"];?></span><input type="text" value="<?php echo $r["cat_name"];?>" name="cat_name" class="state-edit"></div><div class="cat_item_con list_sort"><span class="state-show cat-sort"><?php echo $r["cat_sort"];?></span><input type="text" value="<?php echo $r["cat_sort"];?>" name="cat_sort" class="state-edit"></div><div class="cat_item_con list_btn"><span class="js-cat-edit state-show">编辑</span><span class="js-cat-del state-show"> - 删除</span><span class="js-cat-save state-edit">保存</span><span class="js-cat-cancel state-edit"> - 取消</span></div></div><?php } ?></div><?}else{?><div class="no-results"></div><?php } ?></div>'
	var store_id = "<?php echo $_GET['physical_id'];?>"
	var load_url="<?php  dourl('meal:table',array('physical_id'=>$_GET['physical_id'],'cat_id'=>$_GET['cat_id']));?>";
	var cat_del_url="<?php  dourl('meal:cat_del',array('physical_id'=>$_GET['physical_id']));?>";
	var cat_add_url="<?php  dourl('meal:cat_add',array('physical_id'=>$_GET['physical_id']));?>";
	var cat_edit_url="<?php  dourl('meal:cat_edit',array('physical_id'=>$_GET['physical_id']));?>";
	</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/swiper.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Table JS -->
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/table-main.js"></script>
	<!-- ▲ Table JS -->	
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
					<?php if(!empty($store_physical)){ ?>
					<?php foreach($store_physical as $value){ ?>
					<li class="store_<?php echo $value['pigcms_id'];?><?php if($value['pigcms_id']==$_GET['physical_id']){ ?> active<?php } ?>" data-id="<?php echo $value['pigcms_id'];?>">
						<a href="<?php echo dourl('meal:table'); ?>&physical_id=<?php echo $value['pigcms_id'];?>"><?php echo $value['name'];?></a>
					</li>
					<?php } ?>
					<?php }else{ ?>
					<script type="text/javascript">
					$(document).ready(function() {
						teaAlert('complete','请先添加线下门店',function () {
							window.location.href = "<?php echo dourl('setting:store'); ?>#physical_store"
						})
					});
					</script>
					<?php } ?>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content">
							<!-- ▼ App card -->
							<div id="app-card" class="app-card">
								<div class="app-card-inner">
									<div class="app-card-img">
										<?php $array = explode(',', $now_store['images']); ?>
										<img src="<?php echo $now_store['images'];?>">
									</div>
									<div class="app-card-text">
										<div class="app-card-title">
											<h4><?php echo $now_store['name'];?></h4>
											<span>
												<a href="<?php echo dourl('setting:store'); ?>#physical_store_edit/<?php echo $now_store['pigcms_id'];?>">编辑</a>
											</span>
										</div>
										<div class="app-card-con">
											<div class="app-card-item">
												<span><?php echo $now_store['province'];?> <?php echo $now_store['city'];?> <?php echo $now_store['county'];?></span>
											</div>
											<div class="app-card-item">
												<span>营业时间：<?php echo $now_store['business_hours'];?></span>
											</div>
											<div class="app-card-item">
												<span>联系电话：<?php echo $now_store['phone1'];?> - <?php echo $now_store['phone2'];?></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- ▲ App card -->
							<!-- ▼ Fourth Header -->
							<div id="fourth-header" class="fourth-header unselect">
								<div class="fourth-header-menu">
									<ul class="fourth-header-inner fourth-header-wrapper">
										<li class="<?php if(empty($_GET['cat_id'])){ ?>active<?php } ?> fourth-header-silde"><a href="<?php echo dourl('meal:table'); ?>&physical_id=<?php echo $_GET['physical_id'];?>">全部</a></li>
										<?php if(!empty($cat_list)){ ?>
										<?php foreach($cat_list as $r){ ?>
										<li  class="<?php if($_GET['cat_id']==$r['cat_id']){ ?>active<?php }?> fourth-header-silde"><a href="<?php echo dourl('meal:table'); ?>&physical_id=<?php echo $r['physical_id'];?>&cat_id=<?php echo $r['cat_id'];?>"><?php echo $r['cat_name'];?></a></li>
										<?php } ?>
										<?php } ?>
										<!-- <li class="active">
											<a href="<?php echo dourl('meal:cat_list'); ?>&physical_id=<?php echo $_GET['physical_id'];?>">分类列表</a>
										</li>
										<li>
											<a href="<?php echo dourl('meal:table_add'); ?>&physical_id=<?php echo $_GET['physical_id'];?>">新增茶桌</a>
										</li>
										<li>
											<a href="<?php echo dourl('meal:order_add'); ?>&physical_id=<?php echo $_GET['physical_id'];?>">新增预约</a>
										</li> -->
									</ul>
								</div>
								<div class="fourth-cat-add" style="background:none">
									<span id="js-cat-add" class="add-btn">分类管理</span>
								</div>
							</div>
							<!-- ▲ Fourth Header -->
							<div class="table-main">
								
								<div class="table_order">
									<div class="main_order_t">
										<h3>近七天预约情况</h3>
										<div class="main_order_add">
											<a href="<?php echo dourl('meal:order_add'); ?>&physical_id=<?php echo $_GET['physical_id'];?>"><span id="js-order-add" class="add-btn">新增预约</span></a>
										</div>
									</div>
									<ul>
										<li class="table_order_day">
											<label>
												<span class="big_day"><?php echo date('d',strtotime("today"))?></span>
												<span class="small_day"><?php echo date('Y-m',strtotime("today"))?></span>
											</label>
											<ul>
												<?php foreach($order_list as $value){ ?>
												<?php 
												$dt=date('d',$value['dd_time']);
												$dd=date('d',strtotime("today"));
												if($dt==$dd){?>
												<?php $etime=date('H',$value['dd_time'])+$value['sc'];?>
												<li>
													<span class="order_data"><?php echo date('H',$value['dd_time']); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</span>
													<div class="order_info">
														<span class="info_thumb"><img src="<?php echo $value['avatar'];?>"></span>
														<span class="info_nickname"><?php echo $value['nickname'];?></span>
														<span class="info_name"><?php echo $value['name'];?></span>
														<span class="info_tel"><?php echo $value['phone'];?></span>
													</div>
												</li>
												<?php }?>
												<?php }?>
											</ul>
										</li>
										<li class="table_order_day">
											<label>
												<span class="big_day"><?php echo date('d',strtotime("+1 day"))?></span>
												<span class="small_day"><?php echo date('Y-m',strtotime("today"))?></span>
											</label>
											<ul>
												<?php foreach($order_list as $value){ ?>
												<?php 
												$dt=date('d',$value['dd_time']);
												$dd=date('d',strtotime("+1 day"));
												if($dt==$dd){?>
												<?php $etime=date('H',$value['dd_time'])+$value['sc'];?>
												<li>
													<span class="order_data"><?php echo date('H',$value['dd_time']); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</span>
													<div class="order_info">
														<span class="info_thumb"><img src="<?php echo $value['avatar'];?>"></span>
														<span class="info_nickname"><?php echo $value['nickname'];?></span>
														<span class="info_name"><?php echo $value['name'];?></span>
														<span class="info_tel"><?php echo $value['phone'];?></span>
													</div>
												</li>
												<?php }?>
												<?php }?>
											</ul>
										</li>
										<li class="table_order_day">
											<label>
												<span class="big_day"><?php echo date('d',strtotime("+2 day"))?></span>
												<span class="small_day"><?php echo date('Y-m',strtotime("today"))?></span>
											</label>
											<ul>
												<?php foreach($order_list as $value){ ?>
												<?php 
												$dt=date('d',$value['dd_time']);
												$dd=date('d',strtotime("+2 day"));
												if($dt==$dd){?>
												<?php $etime=date('H',$value['dd_time'])+$value['sc'];?>
												<li>
													<span class="order_data"><?php echo date('H',$value['dd_time']); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</span>
													<div class="order_info">
														<span class="info_thumb"><img src="<?php echo $value['avatar'];?>"></span>
														<span class="info_nickname"><?php echo $value['nickname'];?></span>
														<span class="info_name"><?php echo $value['name'];?></span>
														<span class="info_tel"><?php echo $value['phone'];?></span>
													</div>
												</li>
												<?php }?>
												<?php }?>
											</ul>
										</li>
										<li class="table_order_day">
											<label>
												<span class="big_day"><?php echo date('d',strtotime("+3 day"))?></span>
												<span class="small_day"><?php echo date('Y-m',strtotime("today"))?></span>
											</label>
											<ul>
												<?php foreach($order_list as $value){ ?>
												<?php 
												$dt=date('d',$value['dd_time']);
												$dd=date('d',strtotime("+3 day"));
												if($dt==$dd){?>
												<?php $etime=date('H',$value['dd_time'])+$value['sc'];?>
												<li>
													<span class="order_data"><?php echo date('H',$value['dd_time']); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</span>
													<div class="order_info">
														<span class="info_thumb"><img src="<?php echo $value['avatar'];?>"></span>
														<span class="info_nickname"><?php echo $value['nickname'];?></span>
														<span class="info_name"><?php echo $value['name'];?></span>
														<span class="info_tel"><?php echo $value['phone'];?></span>
													</div>
												</li>
												<?php }?>
												<?php }?>
											</ul>
										</li>
										<li class="table_order_day">
											<label>
												<span class="big_day"><?php echo date('d',strtotime("+4 day"))?></span>
												<span class="small_day"><?php echo date('Y-m',strtotime("today"))?></span>
											</label>
											<ul>
												<?php foreach($order_list as $value){ ?>
												<?php 
												$dt=date('d',$value['dd_time']);
												$dd=date('d',strtotime("+4 day"));
												if($dt==$dd){?>
												<?php $etime=date('H',$value['dd_time'])+$value['sc'];?>
												<li>
													<span class="order_data"><?php echo date('H',$value['dd_time']); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</span>
													<div class="order_info">
														<span class="info_thumb"><img src="<?php echo $value['avatar'];?>"></span>
														<span class="info_nickname"><?php echo $value['nickname'];?></span>
														<span class="info_name"><?php echo $value['name'];?></span>
														<span class="info_tel"><?php echo $value['phone'];?></span>
													</div>
												</li>
												<?php }?>
												<?php }?>
											</ul>
										</li>
										<li class="table_order_day">
											<label>
												<span class="big_day"><?php echo date('d',strtotime("+5 day"))?></span>
												<span class="small_day"><?php echo date('Y-m',strtotime("today"))?></span>
											</label>
											<ul>
												<?php foreach($order_list as $value){ ?>
												<?php 
												$dt=date('d',$value['dd_time']);
												$dd=date('d',strtotime("+5 day"));
												if($dt==$dd){?>
												<?php $etime=date('H',$value['dd_time'])+$value['sc'];?>
												<li>
													<span class="order_data"><?php echo date('H',$value['dd_time']); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</span>
													<div class="order_info">
														<span class="info_thumb"><img src="<?php echo $value['avatar'];?>"></span>
														<span class="info_nickname"><?php echo $value['nickname'];?></span>
														<span class="info_name"><?php echo $value['name'];?></span>
														<span class="info_tel"><?php echo $value['phone'];?></span>
													</div>
												</li>
												<?php }?>
												<?php }?>
											</ul>
										</li>
										<li class="table_order_day">
											<label>
												<span class="big_day"><?php echo date('d',strtotime("+6 day"))?></span>
												<span class="small_day"><?php echo date('Y-m',strtotime("today"))?></span>
											</label>
											<ul>
												<?php foreach($order_list as $value){ ?>
												<?php 
												$dt=date('d',$value['dd_time']);
												$dd=date('d',strtotime("+6 day"));
												if($dt==$dd){?>
												<?php $etime=date('H',$value['dd_time'])+$value['sc'];?>
												<li>
													<span class="order_data"><?php echo date('H',$value['dd_time']); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</span>
													<div class="order_info">
														<span class="info_thumb"><img src="<?php echo $value['avatar'];?>"></span>
														<span class="info_nickname"><?php echo $value['nickname'];?></span>
														<span class="info_name"><?php echo $value['name'];?></span>
														<span class="info_tel"><?php echo $value['phone'];?></span>
													</div>
												</li>
												<?php }?>
												<?php }?>
											</ul>
										</li>
									</ul>
								</div>
								<div class="table_list">
									<div class="table_list_t">
										<h3>茶桌列表</h3>
										<div class="table_list_add">
											<a href="<?php echo dourl('meal:table_add'); ?>&physical_id=<?php echo $_GET['physical_id'];?>"><span id="js-table-add" class="add-btn">新增茶桌</span></a>
										</div>
									</div>
									<ul>
									<?php if(!empty($list)){ ?>
										<?php foreach($list as $value){ ?>
										<li class="table_table_li<?php if($value['cz_id']==$cz){?> table_cur<?php } ?>">
											<span class="table_con1"><?php echo $value['name'];?></span>
											<span class="table_con2">容纳人数：<?php echo $value['zno'];?></span>
											<span class="table_con3">价格：<?php echo $value['price'];?>元/小时</span>
											<span class="table_con4"><?php if($value['status']==1){echo '可预约';}else{echo '不可预约';};?></span>
											<span class="table_con_cz">
												<div class="table_con_cz_order"><a href="<?php echo dourl('meal:table'); ?>&physical_id=<?php echo $value['physical_id'];?>&cz_id=<?php echo $value['cz_id'];?><?php if($_GET['cat_id']){echo '&cat_id='.$_GET['cat_id'];}?>#fourth-header"><img src="images/diancha.png"></a></div>
												<div class="table_con_cz_xiu">
													<a href="./wap/baoxiang.php?id=<?php echo $value['cz_id'];?>#fourth-header" class="edit">查看</a> -
													<a href="<?php echo dourl('meal:table_edit'); ?>&physical_id=<?php echo $value['physical_id'];?>&cz_id=<?php echo $value['cz_id'];?>" class="edit">编辑</a> -
													<a href="<?php echo dourl('meal:table_del'); ?>&physical_id=<?php echo $value['physical_id'];?>&cz_id=<?php echo $value['cz_id'];?>" class="delete">删除</a>
												</div>
											</span>	
										</li>
										<?php } ?>
										<?php }else{ ?>
										<tr class="odd"><span class="button-column" colspan="11" >暂时没有数据...</span></tr>
										<?php } ?>
									</ul>
								<?php
								if ($pages) {
									?>
									<!-- <div class="pagenavi js-present_list_page" id="pages">
										<span class="total"><?php echo $pages ?></span>
									</div> -->
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
	<style type="text/css">
	.swiper-slide{
		width: auto;
	}
	</style>
<script type="text/javascript">
	function autoMenu (index) {
		var swiper = new Swiper('.fourth-header-menu', {
			initialSlide:index,
			wrapperClass:"fourth-header-wrapper",
			slideClass :"fourth-header-silde",
	        slidesPerView: 'auto',
	        paginationClickable: true,
	        grabCursor: true,
	        slidesPerGroup:2,
	        spaceBetween: 0
	    });
	}
	$(document).ready(function() {
		var ulWidth = 0;
		var wrapperWidth = $('#fourth-header .fourth-header-menu').width();
		for (var i = 0; i < $('.fourth-header-inner li').size(); i++) {
			ulWidth = ulWidth + $('.fourth-header-inner li').eq(i).width()-1;
		};
		if (ulWidth>wrapperWidth) {
			var index = $('.fourth-header-inner li.active').index()
			autoMenu (index-1)
		};
	});
</script>
</body>
</html>
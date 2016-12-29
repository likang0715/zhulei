<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>茶会</title>
	<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="./js/base.js"></script>

	<script type="text/javascript" src="./js/meaz.js"></script>
	<link rel="stylesheet" href="../template/user/default/css/base.css">
	<link rel="stylesheet" href="./skin/css/global.css">
	<link rel="stylesheet" href="./skin/css/hint.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui-timepicker-addon.css">
	<link href="./css/store.css" type="text/css" rel="stylesheet"/>
	<link href="./css/setting_store.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript">var load_url="<?php  dourl('events:baoming',array('id'=>$_GET['id']));?>";</script>
<script type="text/javascript" src="./js/chahui.js"></script>

</head>
<body class="font14 usercenter">
	<?php include display('public:header');?>
	<div class="wrap_1000 clearfix container">
		<?php include display('events:sidebar');?>
		<!-- 茶会列表 -->
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
						<a href="<?php dourl('events:baoming');?>&id=<?php echo $_REQUEST['id'];?>"><li <?php if(empty($_REQUEST['status'])){?> class="cur"<?php } ?>>全部</li></a>
						<a href="<?php dourl('events:baoming');?>&id=<?php echo $_REQUEST['id'];?>&status=1"><li <?php if($_REQUEST['status']==1){?> class="cur"<?php } ?>>待审核</li></a>
						<a href="<?php dourl('events:baoming');?>&id=<?php echo $_REQUEST['id'];?>&status=3"><li <?php if($_REQUEST['status']==3){?> class="cur"<?php } ?>>审核通过</li></a>
						<a href="<?php dourl('events:baoming');?>&id=<?php echo $_REQUEST['id'];?>&status=2"><li <?php if($_REQUEST['status']==2){?> class="cur"<?php } ?>>审核未通过</li></a>
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
				
					<?php if(!empty($baoming)){ ?>
					<?php foreach($baoming as $value){ ?>
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
		<script type="text/javascript">
		$(document).ready(function() {
			$(".events_results_b_list ul").click(function() {
				$(this).next(".events_results_b_list_more").toggle()
			});
		});
		</script>
	</div>
	<?php include display('public:footer');?>
</body>
</html>
<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>预约管理</title>
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/base.js"></script>
	<script type="text/javascript" src="./js/meaz.js"></script>
	<script type="text/javascript">var load_url="<?php  dourl('meal:table',array('physical_id'=>$_GET['physical_id'],'cat_id'=>$_GET['cat_id']));?>";</script>
	<link rel="stylesheet" href="./skin/css/global.css">	
	<script type="text/javascript">
	$(document).ready(function(){
		$(".meal_con_main_order").touchSlider({
			flexible : true,
			speed : 200,
			paging : $(".meal_con_main_table_li"),
			counter : function (e){
				$(".table_con_cz_order").removeClass("on").eq(e.current-1).addClass("on");
			}
		});

	});
	</script>	
</head>
<body class="font14 usercenter">
	<?php include display('public:header');?>
	<div class="wrap_1000 clearfix container">
		<?php include display('sidebar');?>
		<div class="meal_con">
			<!-- 内容头部 -->
			<div class="meal_con_header">
				<span><?php echo $now_store['name'];?></span>
				<a href="<?php echo dourl('meal:cat_list'); ?>&physical_id=<?php echo $_GET['physical_id'];?>" style="float:right;  background: #FFFFFF;border: 1px solid #ccc;padding: 0 10px;font-weight: normal;">分类列表</a>
				<a href="<?php echo dourl('meal:table_add'); ?>&physical_id=<?php echo $_GET['physical_id'];?>" style="float:right;  background: #FFFFFF;border: 1px solid #ccc;padding: 0 10px;font-weight: normal;margin-right: 20px;">新增茶桌</a>
				<a href="<?php echo dourl('meal:order_add'); ?>&physical_id=<?php echo $_GET['physical_id'];?>" style="float:right;  background: #FFFFFF;border: 1px solid #ccc;padding: 0 10px;font-weight: normal;margin-right: 20px;">新增预约</a>
			</div>
			<div class="meal_con_nav">
				<div class="ui-nav">
					<ul>
						<li <?php if(empty($_GET['cat_id'])){ ?>class="active"<?php } ?>><a href="<?php echo dourl('meal:table'); ?>&physical_id=<?php echo $_GET['physical_id'];?>">全部</a></li>
									<?php if(!empty($cat_list)){ ?>
					<?php foreach($cat_list as $r){ ?>
						<li  <?php if($_GET['cat_id']==$r['cat_id']){ ?>class="active"<?php } ?>><a href="<?php echo dourl('meal:table'); ?>&physical_id=<?php echo $r['physical_id'];?>&cat_id=<?php echo $r['cat_id'];?>"><?php echo $r['cat_name'];?></a></li>
						<?php } ?>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="meal_con_main_list">
				<ul>
					<?php if(!empty($list)){ ?>
					<?php foreach($list as $value){ ?>
					<li class="meal_con_main_table_li<?php if($value['cz_id']==$cz){?> table_cur<?php } ?>">
						<span class="table_con1"><?php echo $value['name'];?></span>
						<span class="table_con2">容纳人数：<?php echo $value['zno'];?></span>
						<span class="table_con3">价格：<?php echo $value['price'];?>元/小时</span>
						<span class="table_con4"><?php if($value['status']==1){echo '可预约';}else{echo '不可预约';};?></span>
						<span class="table_con_cz">
							<div class="table_con_cz_order"><a href="<?php echo dourl('meal:table'); ?>&physical_id=<?php echo $value['physical_id'];?>&cz_id=<?php echo $value['cz_id'];?>"><img src="images/diancha.png"></a></div>
							<div class="table_con_cz_xiu">
								<a href="./wap/baoxiang.php?id=<?php echo $value['cz_id'];?>" class="edit">查看</a> -
								<a href="<?php echo dourl('meal:table_edit'); ?>&physical_id=<?php echo $value['physical_id'];?>&cz_id=<?php echo $value['cz_id'];?>" class="edit">编辑</a> -
								<a href="<?php echo dourl('meal:table_del'); ?>&physical_id=<?php echo $value['physical_id'];?>&cz_id=<?php echo $value['cz_id'];?>" class="delete">删除</a>
							</div>
						</span>	
					</li>

					<?php } ?>
					<?php }else{ ?>
					<tr class="odd"><span class="button-column" colspan="11" >暂时没有数据...</span></tr>
				</ul>
				<?php } ?>

				<?php

				if ($pages) {
					?>
					<div class="pagenavi js-present_list_page" id="pages">
						<span class="total"><?php echo $pages ?></span>

					</div>
					<?php
				}
				?>
			</div>



			<div class="meal_con_main_order">
				<div class="main_order_t">
					<h3>近七天预约情况</h3>
				</div>
				<ul>
					<li class="meal_con_main_order_day">
						<label>
							<span><?php echo date('d',strtotime("today"))?></span>
							<span><?php echo date('Y-m',strtotime("today"))?></span>
						</label>
						<ul>		
							<?php foreach($order_list as $value){ ?>
							<?php 
							$dt=date('d',strtotime($value['dd_time']));
							$dd=date('d',strtotime("today"));
							if($dt==$dd){?>
							<?php $etime=date('H',strtotime($value['dd_time']))+$value['sc'];?>
							<li><?php echo date('H',strtotime($value['dd_time'])); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</li>	<?php }?>
							<?php }?>
						</ul>
					</li>
					<li class="meal_con_main_order_day">
						<label>
							<span><?php echo date('d',strtotime("+1 day"))?></span>
							<span><?php echo date('Y-m',strtotime("today"))?></span>
						</label>
						<ul>
							<?php foreach($order_list as $value){ ?>
							<?php 
							$dt=date('d',strtotime($value['dd_time']));
							$dd=date('d',strtotime("+1 day"));
							if($dt==$dd){?>
							<?php $etime=date('H',strtotime($value['dd_time']))+$value['sc'];?>
							<li><?php echo date('H',strtotime($value['dd_time'])); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</li>	<?php }?>
							<?php }?>
						</ul>
					</li>
					<li class="meal_con_main_order_day">
						<label>
							<span><?php echo date('d',strtotime("+2 day"))?></span>
							<span><?php echo date('Y-m',strtotime("today"))?></span>
						</label>
						<ul>
							<?php foreach($order_list as $value){ ?>
							<?php 
							$dt=date('d',strtotime($value['dd_time']));
							$dd=date('d',strtotime("+2 day"));
							if($dt==$dd){?>
							<?php $etime=date('H',strtotime($value['dd_time']))+$value['sc'];?>
							<li><?php echo date('H',strtotime($value['dd_time'])); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</li>	<?php }?>
							<?php }?>
						</ul>
					</li>
					<li class="meal_con_main_order_day">
						<label>
							<span><?php echo date('d',strtotime("+3 day"))?></span>
							<span><?php echo date('Y-m',strtotime("today"))?></span>
						</label>
						<ul>
							<?php foreach($order_list as $value){ ?>
							<?php 
							$dt=date('d',strtotime($value['dd_time']));
							$dd=date('d',strtotime("+3 day"));
							if($dt==$dd){?>
							<?php $etime=date('H',strtotime($value['dd_time']))+$value['sc'];?>
							<li><?php echo date('H',strtotime($value['dd_time'])); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</li>	<?php }?>
							<?php }?>
						</ul>
					</li>
					<li class="meal_con_main_order_day">
						<label>
							<span><?php echo date('d',strtotime("+4 day"))?></span>
							<span><?php echo date('Y-m',strtotime("today"))?></span>
						</label>
						<ul>
							<?php foreach($order_list as $value){ ?>
							<?php 
							$dt=date('d',strtotime($value['dd_time']));
							$dd=date('d',strtotime("+4 day"));
							if($dt==$dd){?>
							<?php $etime=date('H',strtotime($value['dd_time']))+$value['sc'];?>
							<li><?php echo date('H',strtotime($value['dd_time'])); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</li>	<?php }?>
							<?php }?>
						</ul>
					</li>
					<li class="meal_con_main_order_day">
						<label>
							<span><?php echo date('d',strtotime("+5 day"))?></span>
							<span><?php echo date('Y-m',strtotime("today"))?></span>
						</label>
						<ul>
							<?php foreach($order_list as $value){ ?>
							<?php 
							$dt=date('d',strtotime($value['dd_time']));
							$dd=date('d',strtotime("+5 day"));
							if($dt==$dd){?>
							<?php $etime=date('H',strtotime($value['dd_time']))+$value['sc'];?>
							<li><?php echo date('H',strtotime($value['dd_time'])); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</li>	<?php }?>
							<?php }?>
						</ul>
					</li>
					<li class="meal_con_main_order_day">
						<label>
							<span><?php echo date('d',strtotime("+6 day"))?></span>
							<span><?php echo date('Y-m',strtotime("today"))?></span>
						</label>
						<ul>
							<?php foreach($order_list as $value){ ?>
							<?php 
							$dt=date('d',strtotime($value['dd_time']));
							$dd=date('d',strtotime("+6 day"));
							if($dt==$dd){?>
							<?php $etime=date('H',strtotime($value['dd_time']))+$value['sc'];?>
							<li><?php echo date('H',strtotime($value['dd_time'])); ?>:00-<?php if($etime<10){ echo '0';} ?><?php echo $etime; ?>:00</li>	<?php }?>
							<?php }?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<?php include display('public:footer');?>

</body>
</html>
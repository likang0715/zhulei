<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>预约管理</title>
	<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/base.js"></script>
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
				<span><?php echo $now_store['name'];?></span><a href="<?php echo dourl('meal:table_add'); ?>&store_id=<?php echo $_GET['store_id'];?>" style="float:right;  background: #FFFFFF;border: 1px solid #ccc;padding: 0 10px;font-weight: normal;">新增茶桌</a>
				
			</div>
			<div class="meal_con_main_list">
				<div class="meal_con_main_title">
					包厢
				</div>
					<ul>
						<?php if(!empty($list)){ ?>
						<?php foreach($list as $value){ ?>
						<?php if($value['wz_id']==2){ ?>
						<li class="meal_con_main_table_li<?php if($value['cz_id']==$cz){?> table_cur<?php } ?>">
							<span class="table_con1"><?php echo $value['name'];?></span>
							<span class="table_con2">容纳人数：<?php echo $value['zno'];?></span>
							<span class="table_con3">价格：<?php echo $value['price'];?>元/小时</span>
							<span class="table_con4"><?php if($value['status']==1){echo '空闲';}else{echo '使用中';};?></span>
							<span class="table_con_cz">
								<div class="table_con_cz_order"><a href="<?php echo dourl('meal:table'); ?>&store_id=<?php echo $value['store_id'];?>&cz_id=<?php echo $value['cz_id'];?>"><img src="images/diancha.png"></a></div>
								<div class="table_con_cz_xiu">
									<a href="<?php echo dourl('meal:table_edit'); ?>&store_id=<?php echo $value['store_id'];?>&cz_id=<?php echo $value['cz_id'];?>" class="edit">编辑</a> -
								    <a href="<?php echo dourl('meal:table_del'); ?>&store_id=<?php echo $value['store_id'];?>&cz_id=<?php echo $value['cz_id'];?>" class="delete">删除</a>
								</div>
							</span>	
						</li>
						<?php } ?>
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
<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>所有一元夺宝</title>
		<meta content="app-id=518966501" name="apple-itunes-app" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta content="black" name="apple-mobile-web-app-status-bar-style" />
		<meta content="telephone=no" name="format-detection" />
		<link href="http://demo.pigcms.cn//tpl/static/unitary/css/comm.css" rel="stylesheet" type="text/css" />
		<link href="http://demo.pigcms.cn//tpl/static/unitary/css/goods.css" rel="stylesheet" type="text/css" />
		<style>
			#dialog{
				width: 256px;
				height: 46px;
				position: fixed;
				left: 50%;
				top:50%;
				margin-left: -128px;
				margin-top: -23px;
				display: none;
			}
		</style>
	</head>
	<body>
		<script src="http://demo.pigcms.cn//tpl/static/unitary/js/jquery-2.1.3.min.js" language="javascript" type="text/javascript"></script>
		
		<div id="loadingPicBlock">
			<div class="wrapper">
				<div class="column">
					<a href="javascript:;" title="" class="entry-list"><?php echo empty($category_arr[$_GET['type']]['typetext'])?'全部分类':$category_arr[$_GET['type']]['typetext'];?><span></span><b class="fr"></b></a>
					<div class="sort_list sort_list1" style="display: none;">
						<ul>
							<?php foreach($category_arr as $vo){ ?>
							<li class="all" type="0"><a href="unitary.php?id=<?php echo $store_id;?>&type=<?php echo $vo['type'];?>" <?php if($_GET['type'] == $vo['type']){?>class="hover"<?php }?>><s></s><?php echo $vo['typetext'];?><i></i></a></li>
							<?php } ?>							
						</ul>
					</div>
					<a href="javascript:;" title="" class="ann-publicly"><?php echo empty($order_arr[$_GET['order']]['ordertext'])?'即将揭晓':$order_arr[$_GET['order']]['ordertext'];?><span></span><b class="fl"></b></a>
					<div class="sort_list sort_list2" style="display: none;">
						<ul>
							<?php foreach($order_arr as $key=>$vo){ ?>
							<li><a href="unitary.php?id=<?php echo $store_id;?>&type=<?php echo $_GET['type'];?>&order=<?php echo $key;?>" <?php if($_GET['order'] == null || $_GET['order'] == 'proportion'){?>class="hover"<?php }?>><?php echo $vo['ordertext'];?><i></i></a></li>
							<?php } ?>
							
							
						</ul>
					</div>
				</div>
				<div class="goodList marginB">
					
					<!-- 商品s -->
					<?php foreach($unitary_list as $vo){ ?>
					<ul class="unitary" unitaryid="<?php echo $vo['id'];?>">
						<li>
							<span class="gList_l fl">
								<img src="<?php echo $vo['logopic'];?>">
							</span>
							<div class="gList_r">
								<h3 class="gray6"><?php echo $vo['name'];?>(第<?php echo $vo['qishu'];?>期)</h3>
								<em class="gray9">价值：￥<?php echo $vo['price'];?>.00</em>
								<div class="gRate">
									<div class="Progress-bar">
										<p class="u-progress"><span style="width: <?php echo (($vo['pay_count']/$vo['price'])*100)?>%;" class="pgbar"><span class="pging"></span></span></p>
										<ul class="Pro-bar-li">
											<li class="P-bar01">
												<em><?php echo $vo['pay_count']?></em>已参与
											</li>
											<li class="P-bar02">
												<em><?php echo $vo['price'];?></em>总需人次
											</li>
											<li class="P-bar03">	
												<em><?php echo $vo['shengyu_count'];?></em>剩余
											</li>
										</ul>
									</div>
									<a class="cart" unitaryid="<?php echo $vo['id'];?>" qishu = <?php echo $vo['qishu'];?> price = <?php echo $vo['price'];?> store_id = <?php echo $vo['store_id'];?>>
										<s></s>
									</a>
								</div>
							</div>
						</li>
					</ul>
					<?php } ?>
					<!-- 商品e -->
					<div id="divGoodsLoading" class="loading" style="display:none;"><b></b>正在加载</div>
					<div class="load_more" id="btnLoadMore" style="display:none"><a href="javascript:;" title="加载更多">加载更多</a></div>
				</div>
				
				<div class="footer" style="display:block;">
					<ul>
						<li class="f_whole"><a href="unitary.php?id=<?php echo $store_id;?>" class="hover" title="所有夺宝"><i></i>所有夺宝</a></li>
						<li class="f_car"><a id="btnCart" href="unitary.php?id=<?php echo $store_id;?>&t=cart"  title="购物车"><i><?php if($cart_count != null && $cart_count != 0){?><b><?php echo $cart_count;?></b><?php }?></i>购物车</a></li>
						<li class="f_personal"><a href="{pigcms::U('Unitary/my',array('token'=>$token))}"  title="我的"><i></i>我的</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="dialog">
			<div class="Prompt">
				<s></s>
				<span>添加成功</span>
			</div>
		</div>
	<script>
	$(function(){
		$(".entry-list").click(function(){
			$(".sort_list2").hide();
			if($(".sort_list1").is(":hidden")){
				$(".sort_list1").show();
			}else{
				$(".sort_list1").hide();
			}
		});
		$(".ann-publicly").click(function(){
			$(".sort_list1").hide();
			if($(".sort_list2").is(":hidden")){
				$(".sort_list2").show();
			}else{
				$(".sort_list2").hide();
			}
		});
		
		//加入购物车
		$(".cart").click(function(event){
			event.stopPropagation(); //阻止事件冒泡到DOM树上
			var id = $(this).attr("unitaryid");
			var qishu = $(this).attr("qishu");
			var price = $(this).attr("price");
			var store_id = $(this).attr("store_id");
			$.ajax({
				type:"POST",
				url:"unitary.php?t=indexajax",
				dataType:"json",
				data:{
					type:'cart',
					unitaryid:id,
					qishu:qishu,
					price:price,
					store_id:store_id,
				},
				success:function(data){
					if(data.error)
					{
						$("#dialog span").html(data.error);
					}
					if(data.count)
					{
						$(".f_car a i").html("<b>"+data.count+"</b>");
					}					
					$("#dialog").fadeIn();
					setTimeout(function(){
						$("#dialog").fadeOut();
					},1000)
				}
			});
		});
	});
	</script>

	</body>
</html>
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
					<a href="javascript:;" title="" class="entry-list"><?php echo $typetext;?><span></span><b class="fr"></b></a>
					<div class="sort_list sort_list1" style="display: none;">
						<ul>
							<li class="all" type="0"><a href="<?php dourl('index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>0,'order'=>$order));?>" <?php if($_GET['type'] == null || $_GET['type'] == 0){?>class="hover"<?php }?>><s></s>全部分类<i></i></a></li>
							<li class="phone" type="1"><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>1,'order'=>$order))}" <?php if($_GET['type'] == 1){?>class="hover"<?php }?>><s></s>手机数码<i></i></a></li>
							<li class="computer" type="2"><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>2,'order'=>$order))}" <?php if($_GET['type'] == 2){?>class="hover"<?php }?>><s></s>电脑办公<i></i></a></li>
							<li class="device" type="3"><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>3,'order'=>$order))}" <?php if($_GET['type'] == 3){?>class="hover"<?php }?>><s></s>家用电器<i></i></a></li>
							<li class="makeup" type="4"><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>4,'order'=>$order))}" <?php if($_GET['type'] == 4){?>class="hover"<?php }?>><s></s>化妆个护<i></i></a></li>
							<li class="watches" type="5"><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>5,'order'=>$order))}" <?php if($_GET['type'] == 5){?>class="hover"<?php }?>><s></s>钟表首饰<i></i></a></li>
							<li class="other" type="9999"><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>9999,'order'=>$order))}" <?php if($_GET['type'] == 9999){?>class="hover"<?php }?>><s></s>其他商品<i></i></a><br /><br /></li>
						</ul>
					</div>
					<a href="javascript:;" title="" class="ann-publicly"><?php echo $ordertext;?><span></span><b class="fl"></b></a>
					<div class="sort_list sort_list2" style="display: none;">
						<ul>
							<li><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>$type,'order'=>'proportion'))}" <?php if($_GET['order'] == null || $_GET['order'] == 'proportion'){?>class="hover"<?php }?>>即将揭晓<i></i></a></li>
							<li><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>$type,'order'=>'renqi'))}" <?php if($_GET['order'] == 'renqi'){?>class="hover"<?php }?>>人气<i></i></a></li>
							<li><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>$type,'order'=>'priceup'))}" <?php if($_GET['order'] == 'priceup'){?>class="hover"<?php }?>>价格<em>(由高到低)</em><i></i></a></li>
							<li><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>$type,'order'=>'pricedown'))}" <?php if($_GET['order'] == 'pricedown'){?>class="hover"<?php }?>>价格<em>(由低到高)</em><i></i></a></li>
							<li><a href="{pigcms::U('Unitary/index',array('token'=>$token,'wecha_id'=>$wecha_id,'type'=>$type,'order'=>'addtime'))}" <?php if($_GET['order'] == 'addtime'){?>class="hover"<?php }?>>最新<i></i></a></li>
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
								<h3 class="gray6"><?php echo $vo['name'];?></h3>
								<em class="gray9">价值：￥<?php echo $vo['price'];?>.00</em>
								<div class="gRate">
									<div class="Progress-bar">
										<p class="u-progress"><span style="width: <?php echo (($unitary_count[$vo['id']]/$vo['price'])*100)?>%;" class="pgbar"><span class="pging"></span></span></p>
										<ul class="Pro-bar-li">
											<li class="P-bar01">
												<em><?php echo $unitary_count[$vo['id']]?></em>已参与
											</li>
											<li class="P-bar02">
												<em><?php echo $vo['price'];?></em>总需人次
											</li>
											<li class="P-bar03">	
												<em><?php echo $vo['price'] - $unitary_count[$vo['id']];?></em>剩余
											</li>
										</ul>
									</div>
									<a class="cart" unitaryid="<?php echo $vo['id'];?>">
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
						<li class="f_whole"><a href="unitary.php" class="hover" title="所有夺宝"><i></i>所有夺宝</a></li>
						<li class="f_car"><a id="btnCart" href="unitary.php?t=cart"  title="购物车"><i><?php if($cart_count != null && $cart_count != 0){?><b><?php echo $cart_count;?></b><?php }?></i>购物车</a></li>
						<li class="f_personal"><a href="{pigcms::U('Unitary/my',array('token'=>$token))}"  title="我的"><i></i>我的</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="dialog">
			<div class="Prompt">
				<s></s>
				添加成功
			</div>
		</div>
		<script type="text/javascript">
			$(function(){
				<!---more();---->
				$(".entry-list").click(function(){
					$(".sort_list2").hide();
					$(".sort_list1").toggle();
					if($('.sort_list1').css("display") == 'none' && $('.sort_list2').css("display") == 'none'){
						$(".goodList").show();
					}else{
						$(".goodList").hide();
					}
				});
				$(".ann-publicly").click(function(){
					$(".sort_list1").hide();
					$(".sort_list2").toggle();
					if($('.sort_list1').css("display") == 'none' && $('.sort_list2').css("display") == 'none'){
						$(".goodList").show();
					}else{
						$(".goodList").hide();
					}
				});
				unitary("");
				var i = 0;
				$("#btnLoadMore").click(function(){
					i++;
					var unitarynum = $(".unitary").length;
					$.ajax({
						type:"POST",
						url:"{pigcms::U('Unitary/indexajax',array('token'=>$token))}",
						dataType:"json",
						data:{
							type:'more',
							token:"{pigcms:$token}",
							num:unitarynum,
							utype:"{pigcms:$type}",
							order:"{pigcms:$order}",
							i:i
						},
						beforeSend:function(){
							$("#btnLoadMore").hide();
							$("#divGoodsLoading").show();
						},
						success:function(data){
							$("#divGoodsLoading").before(data.unitary);
							more();
							unitary(i);
						},
						complete:function(){
							$("#divGoodsLoading").hide();
						}
					});
				})
			}); 
			function more(){
				$.ajax({
					type:"POST",
					<!----url:"{pigcms::U('Unitary/indexajax',array('token'=>$token))}", 10:32 2015/10/20---->
					url:"unitary.php?t=indexajax",
					dataType:"json",
					data:{
						type:"unitary_count",
						token:"{pigcms:$token}",
						utype:"{pigcms:$type}",
						order:"{pigcms:$order}"
					},
					success:function(data){
						var unitarynum = $(".unitary").length;
						if(data.count > unitarynum){
							$("#btnLoadMore").show();
						}else{
							$("#btnLoadMore").hide();
						}
					}
				});
			}
			function unitary(i){
				$(".unitary"+i).click(function(){
					var id = $(this).attr("unitaryid");
					window.location.href="{pigcms::U('Unitary/goodswhere',array('token'=>$token))}&unitaryid="+id;
				});
				$(".cart"+i).click(function(event){
					event.stopPropagation();
					var id = $(this).attr("unitaryid");
					//alert(id+id);
					$.ajax({
						type:"POST",
						<!----url:"{pigcms::U('Unitary/indexajax',array('token'=>$token))}", 10:32 2015/10/20---->
						url:"unitary.php?t=indexajax",
						dataType:"json",
						data:{
							type:'cart',
							/* token:"{pigcms:$token}",
							wecha_id:"{pigcms:$wecha_id}", 10:45 2015/10/20*/
							unitaryid:id
						},
						success:function(data){
							$(".f_car a i").html("<b>"+data.count+"</b>");
							$("#dialog").fadeIn();
							setTimeout(function(){
								$("#dialog").fadeOut();
							},1000)
						}
					});
				});
			}
		</script>
<if condition="$unitary eq ''">
<script type="text/javascript">
window.shareData = {  
            "moduleName":"Unitary",
            "moduleID":"0",
            "imgUrl": "http://demo.pigcms.cn//tpl/static/unitary/images/wxnewspic.jpg", 
            "sendFriendLink": "{pigcms:$f_siteUrl}{pigcms::U('Unitary/index',array('token'=>$token))}",
            "tTitle": "一元夺宝",
            "tContent": ""
        };
</script>
<else />
<script type="text/javascript">
window.shareData = {  
            "moduleName":"Unitary",
            "moduleID":"0",
            "imgUrl": "{pigcms:$unitary['wxpic']}", 
            "sendFriendLink": "{pigcms:$f_siteUrl}{pigcms::U('Unitary/goodswhere',array('token'=>$token,'unitaryid'=>$_GET['unitaryid']))}",
            "tTitle": "{pigcms:$unitary['name']}",
            "tContent": "{pigcms:$unitary['wxinfo']}"
        };
</script>
</if>
{pigcms:$shareScript}
	</body>
</html>
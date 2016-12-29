<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>购物车</title>
		<meta content="app-id=518966501" name="apple-itunes-app" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta content="black" name="apple-mobile-web-app-status-bar-style" />
		<meta content="telephone=no" name="format-detection" />
		<link href="http://demo.pigcms.cn/tpl/static/unitary/css/comm.css" rel="stylesheet" type="text/css" />
		<link href="http://demo.pigcms.cn/tpl/static/unitary/css/cartList.css" rel="stylesheet" type="text/css" />
		<style>
			.cerror{
				width: 256px;
				height: 46px;
				position: absolute;
				left: 50%;
				margin-left:-128px;
				top: -5px;
				display: none;
			}
			.error{
				width: 256px;
				height: 46px;
				position: fixed;
				left: 50%;
				margin-left:-128px;
				top: 50%;
				margin-top:-23px;
				display: none;
			}
			.cart_del{
				width: 256px;
				height: 126px;
				position: fixed;
				left: 50%;
				margin-left:-128px;
				top: 50%;
				margin-top:-63px;
				display: none;
				z-index:102;
			}
		</style>
	</head>
	<body>
		<script src="http://demo.pigcms.cn/tpl/static/unitary/js/jquery-2.1.3.min.js" language="javascript" type="text/javascript"></script>
		
		<div id="loadingPicBlock">
			<div class="wrapper">
				<div class="g-Cart-list marginB">
					<ul id="cartBody">
						<?php foreach($cart_list as $vo){ ?>
						<li class="unitary_cart" unitaryid="<?php echo $vo['unitary_id'];?>" id="unitary_cart<?php echo $vo['id'];?>" style="position:relative;">
							<a class="fl u-Cart-img">
								<img src="<?php echo $vo['logopic']?>" border="0" alt="">
							</a>
							<div class="u-Cart-r">
								<a class="gray6"><?php echo $vo['name']?>(第<?php echo $vo['qishu']?>期)</a>
								<span class="gray9">剩余<em id="ycount<?php echo $vo['id'];?>"><?php echo $vo['shengyu_count'];?></em>人次 </span>
								<input cid="<?php echo $vo['id'];?>" qishu="<?php echo $vo['qishu'];?>" store_id="<?php echo $vo['store_id'];?>" price="<?php echo $vo['price'];?>" unitary_id="<?php echo $vo['unitary_id'];?>" name="" maxlength="7" min="1" max="<?php echo $vo['shengyu_count'];?>" type="number" id="cart_count<?php echo $vo['id'];?>" class="gray6 cart_count" value="<?php echo $vo['count'];?>"/>
								<a cid="<?php echo $vo['id'];?>" class="z-del"><s></s></a>
							</div>
							<div class="cerror" id="cerror<?php echo $vo['id'];?>">
								<div class="Prompt"></div>
							</div>
						</li>
						<?php } ?>
					</ul>
					<div id="divNone" class="empty" style="display: none;">
						<s></s>
						购物车为空
					</div>
				</div>
				
				<div id="mycartpay" class="g-Total-bt" style="bottom: 0px;">
					<dl>
						<dt class="gray6"><span>共<em class="orange" id="sum"><?php echo $sum;?></em>个商品</span>合计<em class="orange" id="total"><?php echo $total;?>.00</em>元</dt>
						<dd><a href="unitary.php?t=address" class="orangeBtn w_account">去结算</a></dd>
					</dl>
				</div>
				
				<div class="footer" style="display:none;">
					<ul>
						<li class="f_whole"><a href="unitary.php" title="所有商品"><i></i>所有商品</a></li>
						<li class="f_car"><a id="btnCart" href="unitary.php?id=<?php echo $store_id;?>&t=cart" class="hover" title="购物车"><i></i>购物车</a></li>
						<li class="f_personal"><a href="{pigcms::U('Unitary/my',array('token'=>$token))}"  title="我的"><i></i>我的</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="pageDialogBG" class="pageDialogBG"></div>
		<div id="cart_del" class="cart_del">
			<div class="clearfix m-round u-tipsEject">
				<div class="u-tips-txt">您确定要删除吗？</div>
				<div class="u-Btn">
					<div class="u-Btn-li">
						<a id="btnMsgCancel" class="z-CloseBtn">取消</a>
					</div>
					<div class="u-Btn-li">
						<a id="btnMsgOK" class="z-DefineBtn">确定</a>
					</div>
				</div>
			</div>
		</div>
		<div id="error" class="error">
			<div class="Prompt"></div>
		</div>
		<script>
		$(function(){
			var cnum = $(".unitary_cart").length;
			if(cnum == 0){
				$("#mycartpay").hide();
				$(".footer").show();
				$("#divNone").show();
			}
			$(".cart_count").bind("click keyup",function(){
				var cart_num = $(this).val();
				var re = /^[1-9]+[0-9]*]*$/;
				var id = $(this).attr('cid');
				var unitary_id = $(this).attr('unitary_id');
				var qishu = $(this).attr('qishu');
				var store_id = $(this).attr('store_id');
				var price = $(this).attr('price');
				if(!re.test(cart_num)){
					alert("必须为正整数");return false;
				}
				//去更新购物车,价格
				$.ajax({
					type:"POST",
					url:"unitary.php?t=indexajax",
					dataType:"json",
					data:{
						type:'cart_update',
						id:id,
						unitary_id:unitary_id,
						qishu:qishu,
						cart_num:cart_num,
						store_id:store_id,
						price:price,
					},
					success:function(data){
						if(data.error == 1 || data.error == 2 || data.error == 3 || data.error == 4){
							cerror(id,data.msg);
							setTimeout(function(){
								location.reload();
							},1000);
						}else{
							$("#total").html(data.ok+".00");
						}
					}
				});
			});
			
			
			$(".z-del").click(function(){
					event.stopPropagation();
					var id = $(this).attr("cid");
					$("#pageDialogBG").show();
					$("#cart_del").show();
					$("#btnMsgCancel").click(function(){
						$("#pageDialogBG").hide();
						$("#cart_del").hide();
					});
					$("#btnMsgOK").click(function(){
						$.ajax({
							type:"POST",
							url:"unitary.php?t=indexajax",
							dataType:"json",
							data:{
								type:'cart_del',
								cid:id
							},
							success:function(data){
								if(data.error == 1){
									location.reload();
								}else{
									$("#pageDialogBG").hide();
									$("#cart_del").hide();
									$("#total").html(data.total+".00");
									$("#sum").html(data.sum);
									$("#unitary_cart"+id).hide();
									if(data.total == 0 && data.sum == 0){
										$("#mycartpay").hide();
										$(".footer").show();
										$("#divNone").show();
									}
								}
							}
						});
					})
				});
				
				
			
			
		});
		
			
			function cerror(id,text){
				$("#cerror"+id+" .Prompt").html(text);
				$("#cerror"+id).fadeIn();
				setTimeout(function(){
					$("#cerror"+id).fadeOut();
				},1000)
			}
			function error(text){
				$("#error .Prompt").html(text);
				$("#error").fadeIn();
				setTimeout(function(){
					$("#error").fadeOut();
				},1000)
			}
		</script>
	</body>
</html>
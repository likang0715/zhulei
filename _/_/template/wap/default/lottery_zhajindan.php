<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/css/reset.css" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/css/main.css" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/css/dialog.css" media="all" />
		<script src="<?php echo TPL_URL;?>js/rem.js" type="text/javascript"></script>
		<title>幸运砸金蛋</title>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <!-- Mobile Devices Support @begin -->
		<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
		<meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
		<meta content="no-cache" http-equiv="pragma">
		<meta content="0" http-equiv="expires">
		<meta content="telephone=no, address=no" name="format-detection">
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <!-- Mobile Devices Support @end -->
		<style>
		div {font-family: "微软雅黑";}
		div p{word-break:break-all;}
		
		.layer {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.5);
        z-index: 900;
    }

    .layer_content {
         background: #fff;
		position: fixed;
		width: 15rem;
		left: 50%;
		top: 50%;
		text-align: center;
		z-index: 901;
		height: 19rem;
		margin-top: -8.5rem;
		margin-left: -7.5rem;

    }
    .layer_content .layer_title {
        font-size: .55rem;
        color: #fff;
        line-height: .9rem;
        padding: .3rem .5rem;
        background: #45a5cf;
        text-align: left;
        text-indent: 1.2rem;
    }
    .layer_content p {
        font-size: .55rem;
        color: #333333;
        line-height: 1.4rem;
    }
    .layer_content img {
        width: 8rem;
        margin: 1rem 0;
    }
    .layer_content p span {
        font-size: .45rem;
        color: #999;
        line-height: 0.9rem;
    }

    .layer_content button {
        background: #ff9c00;
        width: 5.5rem;
        height: 1.5rem;
        color: #fff;
        line-height: 1.5rem;
        border-radius: 1.5rem;
        margin: .6rem 0;
    }

    .layer_content i {
        background: url(/template/wap/default/ucenter/images/weidian_25.png) no-repeat;
        background-size: 1rem;
        height: 1.2rem;
        width: 1.24rem;
        display: inline-block;
        vertical-align: middle;
        position: absolute;
        right: -.5rem;
        top: -.5rem;
    }
	.profit, .nickname {
		color: #26CB40;
	}
		</style>
    </head>
<?php if ($lottery['need_subscribe'] && empty($is_subscribe)) {?>
<aside>
    <div class="layer"></div>
    <div class="layer_content">
        <div class="layer_title" style="text-shadow: initial;">亲，店家发现你还未关注店家的公众号</div>
        <div class="layer_text">
            <p>第一步：长按二维码并识别</p>
            <img src="<?php echo $_result['ticket'];?>" >
            <p>第二步：打开图文进入游戏</p>
            <p><em>贴心小提示：成为店铺会员购物一直有特权哦！</em></p>
        </div>
    </div>
</aside>
<?php }?>
<body onselectstart="return true;" ondragstart="return false;">
<script src="<?php echo TPL_URL;?>css/guajiang/js/jquery.js" type="text/javascript"></script> 
<script src="<?php echo TPL_URL;?>css/guajiang/js/alert.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/js/zepto.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/js/dialog_min.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/js/player_min.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/js/main.js"></script>
<script>
	var rid = 0;
	document.addEventListener("DOMContentLoaded", function(){
	playbox.init("playbox");
	var shape = document.getElementById("shape");
	var hitObj = {
		handleEvent: function(evt){
				if("SPAN" == evt.target.tagName){
				var audio = new Audio();
				audio.src = "<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/smashegg.mp3";
				audio.play();
				setTimeout(function(){
					evt.target.classList.toggle("on");
					$.ajax({
						url: "/wap/lottery.php?action=get_prize&aid=<?php echo $lottery['id']?>",
						type: "POST",
						dataType: "json",
						async:true,
						data:{id:<?php echo $lottery['id']?>},
						success: function(res){
							if(res.err_code==1){
								alert(res.err_msg);
								return;
							}
							if(res.success == true){
								evt.target.classList.toggle("luck");
							}
							setTimeout(function(){
								// 抽奖次数
								var usenums = $('#usenums').text();
								$('#usenums').text(parseInt(usenums)+1);
								if(res.success == true){
									// 中奖次数
									var winnums = $('#winnums').text();
					    			$('#winnums').text(parseInt(winnums)+1);
					    			
									var urls = ["<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/coin.png"];
									getCoin(urls);
									rid = res.rid;
									var data = reorganize(res);
									jg(data);
								}else{
									if(res.err_msg==undefined){
										alert('未砸中奖品');
									}else{
										alert(res.err_msg);
										return;
									}
									lqsb();
								}
							}, 2000);
						}
					});
					
				}, 100);
				$("#hit").addClass("on").css({left: evt.pageX+"px", top:evt.pageY +"px"});
			}
			shape.removeEventListener("click", hitObj, false);
		}
	}
	shape.addEventListener("click", hitObj, false);
}, false);


// 重新组织抽奖数据
function reorganize(res){
	var aid = res.aid;									// 活动id
	var isonline = res.isonline;						// 是否是线上兑奖
	var prizetype = parseInt(res.prizetype);			// 获奖等级
	var product_name = res.product_name;				// 奖品名称
	var rid = res.rid;									// 抽奖记录id

	var data = new Object();
	var fruitNum = prizetype-1;
	data.left = fruitNum;
	data.middle = fruitNum;
	data.right = fruitNum;
	data.prize_type = '';
	data.prize = prizetype;

	data.rid = rid;
	data.product_name = product_name;
	data.isonline = res.isonline;
	return data;
}
</script>

<div class="body pb_10">
		<div style="position:absolute;left:10px;top:10px;z-index:350;">
		<a href="javascript:;" id="playbox" class="btn_music" onclick="playbox.init(this).play();" ontouchstart="event.stopPropagation();"></a><audio id="audio" loop src="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/default.mp3" style="pointer-events:none;display:none;width:0!important;height:0!important;"></audio>
	</div>
	<section class="stage">
		<?php if($lottery['endtime'] < time()){?>
		<img src="<?php echo TPL_URL;?>css/lottery_goldenEgg/user/end.jpg" />
		<?php }else{?>
		<img src="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/images/stage.jpg" />
		<div id="shape" class="cube on">
	        <div class="plane one"><span><figure>&nbsp;</figure></span></div>
	        <div class="plane two"><span><figure>&nbsp;</figure></span></div>
	        <div class="plane three"><span><figure>&nbsp;</figure></span></div>
	    </div>
		<?php }?>
	      <div id="hit" class="hit"><img src="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/images/1.png" /></div>
	</section>
		<section>
		<div class="instro_wall">
		<?php 
			// 今天抽奖次数
			$today_draw_count = 0;
			// 今天中奖次数
			$today_prize_count = 0;
		?>
		<?php if($record){?>
			<article>
				<h6>您中过的奖</h6>
				<?php foreach($record as $k=>$v){
				if($v['dateline']>strtotime(date('Y-m-d 00:00:00'))){
					$today_draw_count++;
					if($v['prize_id']>0){
						$today_prize_count++;
					}
				}
				?>
				<?php if($v['prize_id']>0){?>
					<?php if($k != 0){echo "<hr>";}?>
				
				<div style="line-height:200%" <?php if($k != 0){?>style="border-top :1px dashed rgba(0, 0, 0, 0.3);"<?php }?> 
				<?php if($v['status'] == 0){?>
					<?php if($v['isonline']==0){?>
						onclick="dh_unline('<?php echo $v['id'];?>','<?php echo $prize_names[$v['prize_id']];?>')"
					<?php }else{?>
						onclick="dh('<?php echo $v['id'];?>','<?php echo $prize_names[$v['prize_id']];?>')"
					<?php }?>
				
				<?php }?>
				>
					<p>你中了：<span class="red" ><?php echo $prize_names[$v['prize_id']]?></span></p>
					<p>中奖时间：<span class="red"><?php echo date('Y-m-d H:i:s',$v['dateline']);?></span></p>
					<p>状态：<span class="red">
					<?php if($v['status'] == 0){?>
					未兑奖，点击兑奖
					<?php }else{?>
					已于<?php echo date('Y-m-d H:i:s',$v['prize_time'])?>兑奖
					<?php }?>
					</span></p>
				</div>
				<?php }?>
				<?php }?>
			</article>
		<?php }?>
			<article>
				<h6>参与次数</h6>
				<div style="line-height:200%">
					<?php if ($lottery['starttime'] > time()){echo '<p style="color:red">活动还没有开始 :(</p>';}?>
	
					 <?php if($lottery['win_limit'] == 1){?>
					 	<p>每人每日最多允许抽奖次数：<?php echo $lottery['win_limit_extend']?>-已抽取<span class="red" id="usenums"><?php echo $today_draw_count;?></span>次</p>
						<p>分享获取奖励次数：<?php echo $lottery_share_setting['num']-$lottery['win_limit_extend'];?>次</p>
					<?php }elseif($lottery['win_limit'] == 2){?>
						<p>每分享<?php echo $lottery['win_limit_extend']?>次，增加一次机会</p>
					 <?php }elseif($lottery['win_limit'] == 3){?>
						<p>每抽奖一次，消耗<?php echo $lottery['win_limit_extend']?>积分</p>
					 <?php }?>
					 <br />
					 <?php if($lottery['win_type']==0){?>
					 	<p>每人中奖总数：<?php echo $lottery['win_type_extend']?>次-已中奖<span class="red" id="winnums"><?php echo $win_num_record?></span>次</p>
					 <?php }elseif($lottery['win_type']==1){?>
					 	<p>每人每日中奖总数：<?php echo $lottery['win_type_extend']?>次-已中奖<span class="red" id="winnums"><?php echo $today_prize_count?></span>次</p>
					 <?php }?>
				</div>
			</article>
			<article>
				<h6>活动说明</h6>
				<div style="line-height:200%">
					<p><?php echo $lottery['active_desc']?></p>
		        	<p>活动时间:<?php echo date('Y-m-d H:i',$lottery['starttime'])?>至<?php echo date('Y-m-d H:i',$lottery['endtime'])?></p>
				</div>
			</article>
			<?php if($lottery['endtime']<time()){?>
			<article class="a3">
				<h6>结束说明</h6>
				<div style="line-height:200%">
				<p><?php echo $lottery['endtitle']?></p>
				</div>
			</article>
			<?php }?>
			<article class="a3">
				<h6>活动奖项</h6>
				<div style="line-height:200%">
				<?php if ($lottery['statdate']>time()){echo '<p style="color:red">活动还没有开始 :(</p>';}?>
			 	<?php if($lottery_prizes){?>
					<?php foreach($lottery_prizes as $_prize){?>
		            	<p><?php echo $prize_names[$_prize['prize_type']]?>: <?php echo $_prize['product_name']?><?php if($lottery['isshow_num']){?>--奖品数量: <?php echo $_prize['product_num']?><?php }?></p>
		            <?php }?>
	        	<?php }?>
				</div>
			</article>


					</div>
	</section>

</div>
<script>
//lq({sn:'{pigcms:$record.sn}',prize_type:'{pigcms:$record.prize}'});
//sqdh({sn:'{pigcms:$record.sn}',prize_type:'{pigcms:$record.prize}'});
	function sqdh(arg){
		rid = arg.rid;
		var d1 = new iDialog();
		d1.open({
			classList: "apply",
			title:"",
			close:"",
			content:'<div class="header"><h6 style="color:#fff;">已中'+arg.prize_type+'等奖,进行兑奖</h6></div>\
				<table>\
					<tr><td><input type="text" id="d1_1" placeholder="" maxlength="30" readonly="readonly" value="{pigcms:$lottery.renamesn}：'+arg.sn+'" /></td></tr>\
					<tr><td><p><?php echo $lottery['win_info']?></p></td></tr>\
					<tr><td><input type="password" id="d1_2" placeholder="请输入商家兑奖密码" maxlength="30" /></td></tr>\
				</table>',
			btns:[
				{id:"", name:"确定", onclick:"fn.call();", fn: function(self){
					var obj = {
						parssword: $.trim($("#d1_2").val()),
						id:{pigcms:$lottery.id},
						rid:rid,
					}
					$.post('?g=Wap&m=Lottery&a=exchange&token={pigcms:$token}', obj,
					function(data) {
						if (data.success == true) {
							alert('兑奖状态已经记录');
							setTimeout(function(){
								location.href = location.href + "&r="+Math.random();
							},2000);
							
							self.die();
						} else {
							alert(data.msg);
						}
					}
					,'json')
				}},
				{id:"", name:"关闭", onclick:"fn.call();", fn: function(self){
					self.die();
				},}
			]
		});
	}

	//领取
	function dh_unline(rid,prizetype){
		var d2 = new iDialog();
		d2.open({
			classList: "get",
			title:"",
			close:"",
			content:'<div class="header"><h6>'+prizetype+'</h6></div>\
				<table>\
					<tr><td><input type="password" id="pwd" placeholder="请经销商输入密码" maxlength="30" /></td></tr>\
				</table>',
			btns:[
				{id:"", name:"领取", onclick:"fn.call();", fn: function(self){
					var aid = <?php echo $lottery['id']?>;
					// 检查中奖商品是否需要发货，如果需要发货，检查用户是否有收货地址
				    $.get('/wap/lottery.php?action=check_address',{'aid':aid},function(response){
						if(response.err_code>0){
							alert(response.err_msg);
							setTimeout(function(){window.location = '/wap/lottery.php?action=myaddress&aid='+aid},2000);
						}else{
							// 开始兑奖
							// 开始兑奖
			    			var password = $.trim($('#pwd').val());
			    			if(password==''){
			        			alert('请商家输入兑奖密码');
			        			return;
			        		}
							$.post('/wap/lottery.php?action=cash_prize',{'rid':rid,'aid':aid,'password':password},function(response){
								alert(response.err_msg);
								if(response.err_code==0){
									setTimeout(function(){window.location.href = '/wap/lottery.php?action=detail&id=<?php echo $lottery['id']?>&rand='+Math.random();;},2000);	
								}
							},'json');
						}
				    },'json');
				}},
				{id:"", name:"关闭", onclick:"fn.call();", fn: function(self){
					self.die();
				},}
			]
		});
	}

	//领取
	function dh(rid,prizetype){
		// 开始兑奖
		$.post('/wap/lottery.php?action=cash_prize',{'rid':rid},function(response){
			if(response.err_code==0){
				alert(response.err_msg);
				setTimeout(function(){window.location.href = '/wap/lottery.php?action=detail&id=<?php echo $lottery['id']?>&rand='+Math.random();;},1500);
				return;
			}
			if(response.err_code==1){	// 线下兑奖，需要商家填写兑奖密码
				dh_unline(rid,prizetype);
				return;
			}
			// 错误提示
			if(response.err_code>1000){
				alert(response.err_msg);
			}
		},'json');
	}

	//结果
	function jg(arg){
		var d3 = new iDialog();
		var prize_arr = ['一等奖','二等奖','三等奖','四等奖','五等奖','六等奖'];
		arg.prize = parseInt(arg.prize);
		d3.open({
			classList: "result",
			title:"",
			close:"",
			content:'<div class="header"><h5 style="color:#2f8ae5;font-size:16px;">恭喜您中了'+prize_arr[arg.prize-1]+'</h6></div>\
				<table style="margin-top:60px;"><tr>\
					<td style="text-align:center"><label>'+arg.product_name+'</label></td>\
				</tr></table>',
			btns:[
				{id:"", name:"领取奖品", onclick:"fn.call();", fn: function(self){
					self.die();
					if(arg.isonline==1){
						dh(arg.rid,arg.prize);
					}else{
						dh_unline(arg.rid,prize_arr[arg.prize-1]);
					}
				}},
				{id:"", name:"关闭", onclick:"fn.call();", fn: function(self){
					location.href = location.href + "&r="+Math.random();
					self.die();
				},}
			]
		});
	}
	
	//领取结果-成功
	function lqcg(){
		var d5 = new iDialog();
		d5.open({
			classList: "success",
			title:"",
			close:"",
			content:'<div class="header"><h6>成功领取</h6></div>\
				<table><tr>\
					<td><img src="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/images/7.png" /></td>\
					<td style="width:170px;"><label>线下兑换请到指定地点，出示此{pigcms:$lottery.renamesn}给我们的工作人确认兑换！</label></td>\
				</tr></table>',
			btns:[
				{id:"", name:"知道了", onclick:"fn.call();", fn: function(self){
					location.href = location.href + "&r="+Math.random();
					self.die();
				}},
			]
		});
	}

	//失败
	function lqsb(){
		var d6 = new iDialog();
		d6.open({
			classList: "failed",
			title:"",
			close:"",
			content:'<div class="header"><?php echo $lottery['rejoin_tip']?></div>\
				<table><tr>\
					<td><img src="<?php echo TPL_URL;?>css/lottery_goldenEgg/wap/style/images/8.png" /></td>\
				</tr></table>',
			btns:[
				{id:"", name:"再砸一次", onclick:"fn.call();", fn: function(self){
					//window.location.reload();	// 微信浏览器无法使用
					window.location.href = '/wap/lottery.php?action=detail&id=<?php echo $lottery['id']?>&rand='+Math.random();
				}},
			]
		});
	}
	
	window.alert = function(str){
		var d7 = new iDialog();
		d7.open({
			classList: "alert",
			title:"",
			close:"",
			content:str,
			btns:[
				{id:"", name:"确定", onclick:"fn.call();", fn: function(self){
					self.die();
				}},
			]
		});
	}
</script>
<div mark="stat_code" style="width:0px; height:0px; display:none;"></div>
<?php echo $shareData;?>
	</body>
</html>
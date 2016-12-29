<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<title><?php echo $lottery['title']?></title>
<link href="<?php echo TPL_URL;?>css/lottery_jiugong/css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo TPL_URL;?>js/rem.js" type="text/javascript"></script>
<style>
.pop{ position: fixed;	top:0;	left:0;	width:100%;	height:100%;background:rgba(0, 0, 0, 0.7);	display:none;z-index:1000; padding-top:15%;}
.content .prize ul li .jiangpin{
position: relative;
}
.content .prize ul li .jiangpin span {
position:absolute;
width:100%; text-align:center;
bottom:9px;left:0; font-size:12px;
border-radius:0 0 10px 10px;
background-color: rgba(196, 43, 43, 0.57);
color:#fff;
padding:5px 0;
}
.promptbox{
left:13%;
margin:0;
}

body {font-family: "微软雅黑";}
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
<body>
<script src="<?php echo TPL_URL;?>css/lottery_jiugong/js/jquery.min.js" type="text/javascript"></script> 
<script src="<?php echo TPL_URL;?>css/lottery_jiugong/js/alert.js" type="text/javascript"></script> 

<div id="mcovear" class="pop" style="display:none;">
<div class="promptbox">
<div class="box">
<div class="line"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/line_yellow.png" width="100%" /></div>
<div class="user">
<p><?php echo $lottery['win_info']?></p>
<div class="input"><input type="text" id="parssword" placeholder="商家输入兑奖密码" /> </div>
<input type="hidden" id="rid" />
<div class="but_con"  >
<button onclick="save_lq_unline()" class="button_01 but">领奖</button><button class="button_02 but"  onclick="document.getElementById('mcovear').style.display='none';"  style="margin-left:18%">关闭</button>
<div class="clr"></div>
</div>
</div>
</div></div>


</div>

<div id="dh" class="pop" style="display:none;">
<div class="promptbox">
<div class="box"><h1>申请兑换</h1>
<div class="line"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/line_yellow.png" width="100%" /></div>
<div class="user">
<img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/cat_01.png"  width="60px" class="left"  />
<div style="margin-left:70px;"><div class="input_01 input"><input type="text" id="parssword" value="" /><span id="dhsn"></span></div>
<div class="clr"></div></div>

<div class="but_con"  >
<button   onclick="ckpass()"  class="button_01 but">确定</button><button class="button_02 but" onclick="document.getElementById('dh').style.display='none';" style="margin-left:18%">关闭</button>
<div class="clr"></div>
</div>
</div>
</div>
</div>

</div>
<div id="ydh"  class="pop"  style="display:none;">
 <div class="promptbox">
<div class="box"><h1 id="">奖品已兑换</h1>
<div class="line"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/line_yellow.png" width="100%" /></div>
<div class="user">
<img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/cat_02.png"  width="70" class="left"  />
<div class="text"><span id="">
已于{pigcms:$record.sendtime|date="Y-m-d H:i",###}兑奖</span>
<br>
<span><if condition="$Dazpan.renamesn eq ''">中奖码<else />{pigcms:$Dazpan.renamesn}</if>：{pigcms:$record.sn}</span>
<div class="clr"></div></div>

<div class="but_con"  >
<button class="button_01" onclick="document.getElementById('ydh').style.display='none';">知道啦</button>
<div class="clr"></div>
</div>
</div>
</div></div>
</div>

<div id="zjl"  class="pop" onclick="document.getElementById('zjl').style.display='';" style="display:none;">
<div class="promptbox">
<div class="box"><h1><?php if($lottery['win_tip']==''){echo '恭喜您！您的运气实在太好了！';}else{echo $lottery['win_tip'];}?></h1>
<div class="line"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/line_yellow.png" width="100%" /></div>
<div class="user">
<img  id="jpimg" src="<?php echo TPL_URL;?>css/lottery_jiugong/images/prize.png"  width="45%" class="left"  />
<div class="text" style="margin-left:50%; "><span  id="jptype">一等奖</span><br />
  <span id="jpname"></span><br />
  <img  src="<?php echo TPL_URL;?>css/lottery_jiugong/images/cat_03.png" width="120"/>
    <div class="clr"></div></div>
<div class="but_con"  >
 
  <button class="button_01 but" onclick="lq2()">领奖</button>
  <button class="button_02 but" style="margin-left:18%">关闭</button>
  <div class="clr"></div>
</div>
</div>
</div></div>
</div>

<div id="mzj"  class="pop" onclick="document.getElementById('mzj').style.display='';" style="display:none;">
 <div class="promptbox">
<div class="box"><h1 id="hyh">很遗憾没抽中</h1>
<div class="line"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/line_yellow.png" width="100%" /></div>
<div class="user">
<img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/cat_02.png"  width="70" class="left"  />
<div class="text">
	<span id="ncz">没抽中任何奖品,请继续!</span>
	<div class="clr"></div>
</div>

<div class="but_con"  >
<button class="button_01">知道啦</button>
<div class="clr"></div>
</div>
</div>
</div></div>
</div>
<?php if($lottery['endtime']<time()){?>
<img width="100%" src="<?php echo TPL_URL;?>css/lottery_jiugong/images/activity-lottery-end.jpg"/>
<div class="line"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/line.png" /></div>
<div class="content">
<div class="title"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/title_2.png" /></div>
<div class="text"><?php echo $lottery['active_desc']?></div>
</div>
<div class="line"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/line.png" /></div>
<?php }else{?>
<?php if ($lottery['starttime']<time()){?>
<div class="container" id="lottery">
<inpu type="hidden" id="isonline" value='0' />
<div class="NO">
<ul>
<li class="lottery-unit lottery-unit-0"><span class="active"></span><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/1.png" width="99%"/></li>
<li class="lottery-unit lottery-unit-1"><span></span><img src='<?php echo TPL_URL;?>css/lottery_jiugong/images/6.png'  width="99%"/></li>
<li class="lottery-unit lottery-unit-2"><span></span><img src='<?php echo TPL_URL;?>css/lottery_jiugong/images/4.png'   width="99%"/></li>
<li class="lottery-unit lottery-unit-7"><span></span><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/ths.png"  /></li>
<li><a onclick="jiugong()"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/start.jpg"  style="cursor:pointer;" /></a></li>
<li class="lottery-unit lottery-unit-3"><span></span><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/ths.png" /></li>
<li class="lottery-unit lottery-unit-6"><span></span><img src='<?php echo TPL_URL;?>css/lottery_jiugong/images/3.png'   width="99%"/></li>
<li class="lottery-unit lottery-unit-5"><span></span><img src='<?php echo TPL_URL;?>css/lottery_jiugong/images/5.png'   width="99%"/></li>
<li class="lottery-unit lottery-unit-4"><span></span><img src='<?php echo TPL_URL;?>css/lottery_jiugong/images/2.png'   width="99%"/></li>
<div class="clr"></div>
</ul></div>
<img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/bg.jpg" class="img"/>
</div>
 <?php  }?>
<?php }?>

<script type="text/javascript">
var lottery={
	index:0,	//当前转动到哪个位置
	count:0,	//总共有多少个位置
	timer:0,	//setTimeout的ID，用clearTimeout清除
	speed:1000,	//初始转动速度
	times:0,	//转动次数
	cycle:50,	//转动基本次数：即至少需要转动多少次再进入抽奖环节
	prize:-1,	//中奖位置
	init:function(id){
		if ($("#"+id).find(".lottery-unit").length>0) {
			slottery = $("#"+id);
			sunits = slottery.find(".lottery-unit");
			this.obj = slottery;
			this.count = sunits.length;
			slottery.find(".lottery-unit-"+this.index).find('span').addClass("active");
		};
	},
	roll:function(){
		var index = this.index;
		var count = this.count;
		var lottery = this.obj;
		$(lottery).find(".lottery-unit-"+index).find('span').removeClass("active");
		index += 1;
		if (index>count-1) {
			index = 0;
		};
		$(lottery).find(".lottery-unit-"+index).find('span').addClass("active");
		this.index=index;
		return false;
	},
	stop:function(index){
		this.prize=index;
		return false;
	}
};

function roll(){
	lottery.times += 1;
	lottery.roll();
	if (lottery.times > lottery.cycle+10 && lottery.prize==lottery.index) {
		clearTimeout(lottery.timer);
		lottery.prize=-1;
		lottery.times=0;
		click=false;
		if(lottery.index<7){
			//;
			setTimeout(function(){
				$("#zjl").show();
				// 中奖次数
				var winnums = $('#winnums').text();
    			$('#winnums').text(parseInt(winnums)+1);
			},1300);
		}else{
			//$("#mzj").show();
			 
			setTimeout('$("#mzj").show()',1300);
		}
		//alert(lottery.index);//最终停靠弹出中奖层!
	}else{
		if (lottery.times<lottery.cycle) {
			lottery.speed -= 10;
		}else if(lottery.times==lottery.cycle) {
			index = myindex;//Math.random()*(lottery.count)|0;
			// alert(index);
			lottery.prize = index;//随机停靠获取中奖数据
		 
		}else{
			if (lottery.times > lottery.cycle+10 && ((lottery.prize==0 && lottery.index==7) || lottery.prize==lottery.index+1)) {
				lottery.speed += 110;
			}else{
				lottery.speed += 20;
			}
		}
		if (lottery.speed<40) {
			lottery.speed=40;
		};
		lottery.timer = setTimeout(roll,lottery.speed);
	}
	return false;
}

var flag = 1;
var bo_times = 100;//{pigcms:$Dazpan.canrqnums};
var daynums = 100;//{pigcms:$Dazpan.daynums};
var use_times = 0;//<if condition="$Dazpan.usenums eq ''">0<else />{pigcms:$Dazpan.usenums}</if>; 
 


var click=false;//是否已进入转动抽奖
var myindex =7;
window.onload=function(){
	lottery.init('lottery');
	//$("#lottery a").click(function(){
		
	//});
};
function jiugong(){
	lottery.init('lottery');
	if (click) {
		return false;
	}else{
		//myindex =yaojiang();
		if(use_times >= bo_times) {
			alert('你的机会已用完!');
			return;
		}else{
			if(daynums != 0){
				if(daynums > use_times){
					use_times++;
					$("#count").html(use_times);
				}
			}else{
				use_times++;
				$("#count").html(use_times);
			}
		}
		//alert(use_times);
		$.ajax({
			url : "/wap/lottery.php?action=get_prize&aid=<?php echo $lottery['id']?>",
			type : "POST",
			dataType : "json",
			data : {
				aid:<?php echo $lottery['id']?>
			},
			beforeSend : function(){
				$('#zjl').hide();
				$('#mzj').hide();
			 
			},
			success : function(data){
				if(data.err_code == 1){
					$('#mzj').show();
					$('#ncz').text(data.err_msg);
					$('#hyh').html("");
					flag = 0;
					myindex = 7;
				}else{
					// 抽奖次数
					var usenums = $('#usenums').text();
					$('#usenums').text(parseInt(usenums)+1);
					
					$('#rid').val(data.rid);
					$('#isonline').val(data.isonline);
					if(data.prizetype == 1) {
						//$('#zjl').show();
						$('#jpimg').attr("src","<?php echo TPL_URL;?>css/lottery_jiugong/images/"+data.prizetype+".png");
						$('#jptype').html("一等奖");
						$('#jpname').text(data.product_name);
						flag =1;
						myindex = 0;
						$('#rid').val(data.rid);
		    			
					}else if(data.prizetype == 2) {
						//$('#zjl').show();
						$('#jpimg').attr("src","<?php echo TPL_URL;?>css/lottery_jiugong/images/"+data.prizetype+".png");
						$('#jptype').html("二等奖");
						$('#jpname').text(data.product_name);
						flag =1;
						myindex = 4;
						$('#rid').val(data.rid);
		    			
					}else if(data.prizetype == 3) {
						//$('#zjl').show();
						$('#jpimg').attr("src","<?php echo TPL_URL;?>css/lottery_jiugong/images/"+data.prizetype+".png");
						$('#jptype').html("三等奖");
						$('#jpname').text(data.product_name);
						flag =1;
						myindex = 6;
						$('#rid').val(data.rid);
					}else if(data.prizetype == 4) {
						//$('#zjl').show();
						$('#jpimg').attr("src","<?php echo TPL_URL;?>css/lottery_jiugong/images/"+data.prizetype+".png");
						$('#jptype').html("四等奖");
						$('#jpname').html(data.product_name);
						flag =1;
						myindex = 2;
						$('#rid').val(data.rid);
					}else if(data.prizetype == 5) {
						//$('#zjl').show();
						$('#jpimg').attr("src","<?php echo TPL_URL;?>css/lottery_jiugong/images/"+data.prizetype+".png");
						$('#jptype').html("五等奖");
						$('#jpname').text(data.product_name);
						flag =1;
						myindex = 5;
						$('#rid').val(data.rid);
					}else if(data.prizetype == 6) {
						//$('#zjl').show();
						$('#jpimg').attr("src","<?php echo TPL_URL;?>css/lottery_jiugong/images/"+data.prizetype+".png");
						$('#jptype').html("六等奖");
						$('#jpname').text(data.product_name);
						flag =1;
						myindex = 1;
						$('#rid').val(data.rid);
					}else {
						$('#ncz').text('很遗憾没抽中');
						flag = 1;
						myindex = 7;
					}
				}
			},
			complete :function() {
				if(flag==1){
					lottery.speed=100;
					roll();
					click=true;

					return false;
				}else{
					
					$('#mzj').show();
					myindex = 7;
				}
			}
		});

	}
}

function lq2(){
	var rid = $('#rid').val();
	var isonline = parseInt($('#isonline').val());
	if(isonline==1){
		lq(rid);
	}else{
		lq_unline(rid);
	}
}

function lq(rid){
	// 开始兑奖
	$.post('/wap/lottery.php?action=cash_prize',{'rid':rid},function(response){
		if(response.err_code==0){
			alert(response.err_msg);
			setTimeout(function(){window.location.href = '/wap/lottery.php?action=detail&id=<?php echo $lottery['id']?>&rand='+Math.random();},1500);
			return;
		}
		if(response.err_code==1){	// 线下兑奖，需要商家填写兑奖密码
			$('.result').slideUp(500);
			$('#result2').slideDown(500);
			$('.prizetype').text(prizetype);
			$('#rid').val(rid);
			return;
		}
		// 错误提示
		if(response.err_code>1000){
			alert(response.err_msg);
		}
	},'json');
}
// 线下兑奖
function lq_unline(rid){
	document.getElementById('mcovear').style.display='block';
	if(rid!=''){
		$('#rid').val(rid);
	}
}

// 开始线下兑奖
function save_lq_unline(){
    var aid = <?php echo $lottery['id']?>;	// 活动id
    var rid = $('#rid').val();
    // 检查中奖商品是否需要发货，如果需要发货，检查用户是否有收货地址
    $.get('/wap/lottery.php?action=check_address',{'aid':aid},function(response){
		if(response.err_code>0){
			alert(response.err_msg);
			setTimeout(function(){window.location = '/wap/lottery.php?action=myaddress&aid='+aid},2000);
		}else{
			// 开始兑奖
			var password = $('#parssword').val();
			$.post('/wap/lottery.php?action=cash_prize',{'rid':rid,'aid':aid,'password':password},function(response){
				alert(response.err_msg);
				if(response.err_code==0){
					setTimeout(function(){window.location.href = '/wap/lottery.php?action=detail&id=<?php echo $lottery['id']?>&rand='+Math.random();},2000);	
				}
			},'json');
		}
    },'json');
}
</script>

<div class="content">
<?php if($lottery['endtime']>time(0)){?>
<?php if ($lottery['starttime']<time()){?>
<div class="title"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/title_1.png" /></div>
<div class="text">

<?php 
	// 今天抽奖次数
	$today_draw_count = 0;
	// 今天中奖次数
	$today_prize_count = 0;
	?>
	
<?php if($record){
	// 今天抽奖次数
	$today_draw_count = 0;
	// 今天中奖次数
	$today_prize_count = 0;
	foreach($record as $_v){
		if($_v['dateline']>strtotime(date('Y-m-d 00:00:00'))){
			$today_draw_count++;
			if($_v['prize_id']>0){
				$today_prize_count++;
			}
		}
	}
}
?>
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
<?php  }?>

<div class="title"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/title_2.png" /></div>
<div class="text"><?php if ($lottery['starttime']>time()){echo '<p style="color:#000">活动还没有开始 :(</p>';}?><?php echo $lottery['active_desc']?></div>
<div class="title"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/title_3.png" /></div>
<div class="prize text">
<ul>

<?php foreach ($lottery_prizes as $prize){?>
<li>
	<div class="jiangpin">
	</div><?php echo $prize_names[$prize['prize_type']]?><p><?php echo $prize['product_name']?></p><?php if($lottery['isshow_num']){?><p>奖品数量:<?php echo $prize['product_num']?></p><?php }?></php>
</li>
<?php }?>

</ul>
</div>
<?php }?>
<?php if ($lottery['starttime']<time()){?>
<div class="mylist">
<div class="title"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/title_4.png" /></div>
<div class="text list">
<ul>
<hr style="border-color:#fff6a7">
<?php if ($record){ ?>
<?php foreach($record as $vo){?>
	<?php if($vo['prize_id']>0){?>
	<li><?php echo isset($prize_names[$vo['prize_id']])?$prize_names[$vo['prize_id']]:'未知'?><div class="clr"></div></li>
	<li>获奖时间<?php echo date("Y-m-d H:i",$vo['dateline']); ?><div class="clr"></div></li>
	<?php if ($vo['status'] == 0){?>
	<li onclick="<?php if($vo['isonline']==0){?>lq_unline(<?php echo $vo['id']?>)<?php }else{?>lq(<?php echo $vo['id']?>)<?php }?>">点此兑奖<div class="clr"></div></li>
	<?php }else{?>
	<li>已于<?php echo date("Y-m-d H:i",$vo['prize_time']);?>兑奖<div class="clr"></div></li>
	<?php }?>
	<hr style="border-color:#fff6a7">
	<?php }?>
<?php }?>
<?php }else{ ?>
<li>还没有中奖纪录<div class="clr"></div></li>
<?php } ?>

 </ul></div>
 </div>
 <!--
 <?php if($lottery['endtime']>time()){?>
 <div class="alllist">
<div class="title"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/title_5.png" /></div>
<div class="text list">
<ul>
<volist name="record_list" id="vo">
<li>
<span class="time"><?php echo date('Y-m-d H:i:s',$vo['time']);?></span>
<?php $phone = substr($vo['phone'],0,3)."****".substr($vo['phone'],7,11);?>
<span class="phone01"><?php echo $phone?></span><span class="award">{pigcms:$vo.prize}等奖</span> 
<div class="clr"></div>
</li>
</volist>
</ul>
</div>
</div>
-->
<?php }?>
<?php  }?>

</div>
<div class="line"><img src="<?php echo TPL_URL;?>css/lottery_jiugong/images/line.png" /></div>
<div class="copyright"><?php if($iscopyright == 1){echo $homeInfo['copyright'];}else{echo $siteCopyright;}?></div>
<?php echo $shareData;?>

<include file="Index:styleInclude"/><include file="$cateMenuFileName"/>
</body>
</html>
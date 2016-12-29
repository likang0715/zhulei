<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="description" content="">

<title><?php echo $lottery['title']?></title>
<link href="<?php echo TPL_URL;?>css/lottery/css/activity-style.css" rel="stylesheet" type="text/css">
<script src="<?php echo TPL_URL;?>js/rem.js" type="text/javascript"></script>
<script src="<?php echo TPL_URL;?>css/lottery/js/jquery.js" type="text/javascript"></script> 
<script src="<?php echo TPL_URL;?>css/lottery/js/alert.js" type="text/javascript"></script>
<style>
body {font-family: "微软雅黑";}
	.layer {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.5);
        z-index: 9;
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

<?php if($lottery['backgroundThumImage'] == ''){?>
<body class="activity-lottery-winning">
<?php }else{?>
	<?php if($lottery['fill_type'] == 0){?>
	<body style="background:url('<?php echo getAttachmentUrl($lottery['backgroundThumImage'])?>')">
	<?php }else{?>
	<body>
	<img src="<?php echo getAttachmentUrl($lottery['backgroundThumImage'])?>" style="position: fixed;top:0;left:0;width:100%;height:100%;z-index:-1">
	<?php }?>
<?php }?>

<?php if($memberNotice!=null){
	echo $memberNotice;
}?>
<!--main start-->
<div class="main" >

<style type="text/css">

.window {
	width:290px;
	position:absolute;
	display:none;
	bottom:30px;
	left:50%;
	 z-index:9999;
	margin:-50px auto 0 -145px;
	padding:2px;
	border-radius:0.6em;
	-webkit-border-radius:0.6em;
	-moz-border-radius:0.6em;
	background-color: #ffffff;
	-webkit-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	-moz-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	-o-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	font:14px/1.5 Microsoft YaHei,Helvitica,Verdana,Arial,san-serif;
}
.window .title {
	
	background-color: #A3A2A1;
	line-height: 26px;
    padding: 5px 5px 5px 10px;
	color:#ffffff;
	font-size:16px;
	border-radius:0.5em 0.5em 0 0;
	-webkit-border-radius:0.5em 0.5em 0 0;
	-moz-border-radius:0.5em 0.5em 0 0;
	background-image: -webkit-gradient(linear, left top, left bottom, from( #585858 ), to( #565656 )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient(#585858, #565656); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient(#585858, #565656); /* FF3.6 */
	background-image:     -ms-linear-gradient(#585858, #565656); /* IE10 */
	background-image:      -o-linear-gradient(#585858, #565656); /* Opera 11.10+ */
	background-image:         linear-gradient(#585858, #565656);
	
}
.window .content {
	/*min-height:100px;*/
	overflow:auto;
	padding:10px;
	background: linear-gradient(#FBFBFB, #EEEEEE) repeat scroll 0 0 #FFF9DF;
    color: #222222;
    text-shadow: 0 1px 0 #FFFFFF;
	border-radius: 0 0 0.6em 0.6em;
	-webkit-border-radius: 0 0 0.6em 0.6em;
	-moz-border-radius: 0 0 0.6em 0.6em;
}
.window #txt {
	min-height:30px;font-size:16px; line-height:22px;
}
.window .txtbtn {
	
	background: #f1f1f1;
	background-image: -webkit-gradient(linear, left top, left bottom, from( #DCDCDC ), to( #f1f1f1 )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #ffffff , #DCDCDC ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #ffffff , #DCDCDC ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #ffffff , #DCDCDC ); /* IE10 */
	background-image:      -o-linear-gradient( #ffffff , #DCDCDC ); /* Opera 11.10+ */
	background-image:         linear-gradient( #ffffff , #DCDCDC );
	border: 1px solid #CCCCCC;
	border-bottom: 1px solid #B4B4B4;
	color: #555555;
	font-weight: bold;
	text-shadow: 0 1px 0 #FFFFFF;
	border-radius: 0.6em 0.6em 0.6em 0.6em;
	display: block;
	width: 100%;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
	text-overflow: ellipsis;
	white-space: nowrap;
	cursor: pointer;
	text-align: windowcenter;
	font-weight: bold;
	font-size: 18px;
	padding:6px;
	margin:10px 0 0 0;
}
.window .txtbtn:visited {
	background-image: -webkit-gradient(linear, left top, left bottom, from( #ffffff ), to( #cccccc )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #ffffff , #cccccc ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #ffffff , #cccccc ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #ffffff , #cccccc ); /* IE10 */
	background-image:      -o-linear-gradient( #ffffff , #cccccc ); /* Opera 11.10+ */
	background-image:         linear-gradient( #ffffff , #cccccc );
}
.window .txtbtn:hover {
	background-image: -webkit-gradient(linear, left top, left bottom, from( #ffffff ), to( #cccccc )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #ffffff , #cccccc ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #ffffff , #cccccc ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #ffffff , #cccccc ); /* IE10 */
	background-image:      -o-linear-gradient( #ffffff , #cccccc ); /* Opera 11.10+ */
	background-image:         linear-gradient( #ffffff , #cccccc );
}
.window .txtbtn:active {
	background-image: -webkit-gradient(linear, left top, left bottom, from( #cccccc ), to( #ffffff )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #cccccc , #ffffff ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #cccccc , #ffffff ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #cccccc , #ffffff ); /* IE10 */
	background-image:      -o-linear-gradient( #cccccc , #ffffff ); /* Opera 11.10+ */
	background-image:         linear-gradient( #cccccc , #ffffff );
	border: 1px solid #C9C9C9;
	border-top: 1px solid #B4B4B4;
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3) inset;
}

.window .title .close {
	float:right;
	background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAACTSURBVEhL7dNtCoAgDAZgb60nsGN1tPLVCVNHmg76kQ8E1mwv+GG27cestQ4PvTZ69SFocBGpWa8+zHt/Up+IN+MhgLlUmnIE1CpBQB2COZibfpnXhHFaIZkYph0SOeeK/QJ8o7KOek84fkCWSBtfL+Ny2MPpCkPFMH6PWEhWhKncIyEk69VfiUuVhqJefds+YcwNbEwxGqGIFWYAAAAASUVORK5CYII=");
	width:26px;
	height:26px;
	display:block;	
}
.myhide{
	display:none;
}
</style>
<?php if($lottery['endtime']<time()){?>
    <div class="activity-lottery-end" >
    <div  class="main" >
    <div class="banner"><img src="<?php echo TPL_URL;?>css/lottery/images/activity-lottery-end2.jpg" /></div>
    <div class="content" style=" margin-top:10px">
        <div class="boxcontent boxyellow">
            <div class="box">
                <div class="title-red">活动结束说明：</div>
                <div class="Detail">
                <p><?php echo $lottery['endinfo']?></p>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
<?php }else{?>
    <div style="display: none;" class="window" id="windowcenter">
	<div id="title" class="title">消息提醒<span class="close" id="alertclose"></span></div>
	<div class="content">
	 <div id="txt">亲，继续努力哦！</div>
	 <input value="确定" id="windowclosebutton" name="确定" class="txtbtn" type="button">	
	</div>
    </div>
    <?php if ($lottery['starttime']<time()){?>
    <div id="outercont"  >
        <div id="outer-cont">
            <div id="outer" style="-webkit-transform: rotate(2075.9993514680145deg);"><img src="<?php echo TPL_URL;?>css/lottery/images/activity-lottery-5.png"></div>
        </div>
        <div id="inner-cont">
            <div id="inner" <?php if($memberNotice!=null){?>onclick="alert('您不能参加此活动');"<?php }else{?>><img src="<?php echo TPL_URL;?>css/lottery/images/activity-lottery-2.png"><?php }?></div>
        </div>
    </div>
    <?php  }?>
<?php }?>


<!--content start-->
<div class="content">
    <div class="boxcontent boxyellow myhide result"  id="result"  >
		<div class="box">
			<div class="title-orange"><span>兑奖</span></div>
			<div class="Detail">   
				<p>你中了：<span class="red prizetype" id="span_prizetype"></span></p>
				<p><input class="pxbtn" name="提 交"  id="save-btn" type="button" value="兑奖"></p>
			</div>
		</div>
	</div>
	<div class="boxcontent boxyellow myhide result"  id="result2"  >
		<div class="box">
			<div class="title-orange"><span>领取奖品</span></div>
			<div class="Detail">
				<inpu type="hidden" id="rid" />
				<p>你中了：<span class="red prizetype"></span></p>
				<p><?php echo $lottery['win_info']?></p>
				<p><input name="" class="px" id="parssword" value="" placeholder="商家输入兑奖密码" type="password"></p>
				<p><input class="pxbtn" name="提 交" id="save-btnn" value="商家提交" type="button"></p>
			</div>
		</div>
	</div>
	<?php 
		// 今天抽奖次数
		$today_draw_count = 0;
		// 今天中奖次数
		$today_prize_count = 0;
	?>
	<?php if($record){?>
	<div class="boxcontent boxyellow" >
		<div class="box">
			<div class="title-orange"><span>您中过的奖</span></div>
			<?php foreach($record as $k=>$v){
				if($v['dateline']>strtotime(date('Y-m-d 00:00:00'))){
					$today_draw_count++;
					if($v['prize_id']>0){
						$today_prize_count++;
					}
				}
				
			if($v['prize_id']>0){
			?>
			<div class="Detail" <?php if($k != 0){?>style="border-top :1px dashed rgba(0, 0, 0, 0.3);"<?php }?> 
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
			<?php } }?>
		</div>
	</div>
	<?php }?>

<div class="boxcontent boxyellow">
    <div class="box">
    <div class="title-green"><span>奖项设置：</span></div>
         <div class="Detail">
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
			<br>
		<?php if($lottery_prizes){?>
			<?php foreach($lottery_prizes as $_prize){?>
            	<p><?php echo $prize_names[$_prize['prize_type']]?>: <?php echo $_prize['product_name']?><?php if($lottery['isshow_num']){?>--奖品数量: <?php echo $_prize['product_num']?><?php }?></p>
            <?php }?>
        <?php }?>
        </div>
</div>
</div>
<div class="boxcontent boxyellow">
    <div class="box">
        <div class="title-green">活动说明：</div>
        <div class="Detail">
        <p><?php echo $lottery['active_desc']?></p>
        <p>活动时间:<?php echo date('Y-m-d H:i',$lottery['starttime'])?>至<?php echo date('Y-m-d H:i',$lottery['endtime'])?></p>
        <p><strong><!-- {pigcms:$Dazpan.txt} --></strong></p>  
        </div>
    </div>
</div>

</div>
<!--content end-->
</div>
<!--main end-->
<!--footer start-->
<style>
.footFix{width:100%;text-align:center;position:fixed;left:0;bottom:0;z-index:99;}
#footReturn a, #footReturn2 a {
display: block;
line-height: 41px;
color: #fff;
text-shadow: 1px 1px #282828;
font-size: 14px;
font-weight: bold;
}
#footReturn, #footReturn2 {
z-index: 89;
display: inline-block;
text-align: center;
text-decoration: none;
vertical-align: middle;
cursor: pointer;
width: 100%;
outline: 0 none;
overflow: visible;
Unknown property name.-moz-box-sizing: border-box;
box-sizing: border-box;
padding: 0;
height: 41px;
opacity: .95;
border-top: 1px solid #181818;
box-shadow: inset 0 1px 2px #b6b6b6;
background-color: #515151;
Invalid property value.background-image: -ms-linear-gradient(top,#838383,#202020);
background-image: -webkit-linear-gradient(top,#838383,#202020);
Invalid property value.background-image: -moz-linear-gradient(top,#838383,#202020);
Invalid property value.background-image: -o-linear-gradient(top,#838383,#202020);
background-image: -webkit-gradient(linear,0% 0,0% 100%,from(#838383),to(#202020));
Invalid property value.filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#838383',endColorstr='#202020');
Unknown property name.-ms-filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#838383',endColorstr='#202020');
}

</style>
<div style="height:60px;"></div>
<!--footer end-->
<input type="hidden" id="prize_record_id" />
<input type="hidden" id="isonline"/>
<script type="text/javascript">

    
$(function() {
    window.requestAnimFrame = (function() {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
        function(callback) {
            window.setTimeout(callback, 1000 / 60)
        }
    })();

    var totalDeg = 360 * 3 + 0;
    var steps = [];
    var lostDeg = [36, 96, 156, 216, 276,336];
    var prizeDeg = [6, 66, 126,186,246,306];
    var prize, sncode;
    var count = 0;
    var now = 0;
    var a = 0.01;
    var outter, inner, timer, running = false;

    function countSteps() {
        var t = Math.sqrt(2 * totalDeg / a);
        var v = a * t;
        for (var i = 0; i < t; i++) {
            steps.push((2 * v * i - a * i * i) / 2)
        }
        steps.push(totalDeg)
    }
     
    function step() {
    	outter.style.webkitTransform = 'rotate(' + steps[now++] + 'deg)';
        outter.style.MozTransform = 'rotate(' + steps[now++] + 'deg)';
        if (now < steps.length) {
			running = true;
            requestAnimFrame(step)
        } else {
            running = false;
            setTimeout(function() {
                if (prize != null) {
                    $(".sncode").text(sncode);
                    var type = "";
                    if (prize == 1) {
                        type = "一等奖";
                    } else if (prize == 2) {
                        type = "二等奖";
                    } else if (prize == 3) {
                    	type = "三等奖";
                    }
                    else if (prize == 4) {
                    	type = "四等奖";
                    }
                    else if (prize == 5) {
                    	type = "五等奖";
                    }
                    else if (prize == 6) {
                    	type = "六等奖";
                    }
                    $("#span_prizetype").text(type);
                    $(".result").slideUp(500);
                    
                    $("#result").slideDown(500);
                    // 显示中奖次数
                    var winnums = $('#winnums').text();
        			$('#winnums').text(parseInt(winnums)+1);
                    //$("#outercont").slideUp(500)
                } else {
                   outter.style.webkitTransform = 'rotate(2075.9993514680145deg)';
                   alert("<?php echo $lottery['rejoin_tip']?>");
                }
            },
            200);
        }
    } //setps()
    
    function start(deg) {
        deg = deg || lostDeg[parseInt(lostDeg.length * Math.random())];
        running = true;
        clearInterval(timer);
        totalDeg = 360 * 5 + deg;
        steps = [];
        now = 0;
        countSteps();
        requestAnimFrame(step)
    }
    window.start = start;
    outter = document.getElementById('outer');
    inner = document.getElementById('inner');
    i = 10;

    $("#inner").click(function() {
        if (running) return;
		
       $.ajax({
		 type:"POST",
         url     : "/wap/lottery.php?action=get_prize&aid=<?php echo $lottery['id']?>",
         dataType: "json",
         data:{
			aid:<?php echo $lottery['id']?>
		},
         beforeSend : function(){
           // running = true;
            timer = setInterval(function() {
                i += 5;
                outter.style.webkitTransform = 'rotate(' + i + 'deg)';
                outter.style.MozTransform = 'rotate(' + i + 'deg)'
            },1);
         },
         success: function(data) {
         	if (data.error == 1) {
         		outter.style.webkitTransform = 'rotate(2075.9993514680145deg)';
         		alert(data.msg);
         		//count = {pigcms:$Dazpan.canrqnums};
         		clearInterval(timer);
         		return
         	}
         	if(data.err_code==1){
         		outter.style.webkitTransform = 'rotate(2075.9993514680145deg)';
         		alert(data.err_msg);
         		clearInterval(timer);
         		return;
             }

			var usenums = $('#usenums').text();
			$('#usenums').text(parseInt(usenums)+1);
         	if (data.success) {
    			
         		prize = data.prizetype;
         		sncode = data.sn;
				$("#aid").val(data.aid);
				$('#prize_record_id').val(data.rid);
				if(data.isonline != undefined){
					$('#isonline').val(data.isonline);
				}
         		start(prizeDeg[data.prizetype - 1]);
         	} else {
         		prize = null;
         		start()
         	}
         
         	running = false;
         	count++;
         },
         error: function() {
         	alert('请求失败，您的网络环境可能不佳!');
         	return;
         	prize = null;
         	start();
         	running = false;
         	count++
         },
         timeout    : 10000       
        
       })//ajax
    }
    );
});

function dh_unline(rid,prizetype){
	$('.result').slideUp(500);
	$('#result2').slideDown(500);
	$('.prizetype').text(prizetype);
	$('#rid').val(rid);
}
function dh(rid,prizetype){
	// 开始兑奖
	$.post('/wap/lottery.php?action=cash_prize',{'rid':rid},function(response){
		if(response.err_code==0){
			alert(response.err_msg);
			setTimeout(function(){window.location.reload();},1500);
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

//中奖提交
$("#save-btn").bind("click",
function() {
	var btn = $(this);
    var aid = <?php echo $lottery['id']?>;	// 活动id
    var rid = $('#prize_record_id').val();
	var isonline = $('#isonline').val();
	if(isonline == 0){
		dh_unline(rid,$(".prizetype").text());
		return;
	}
    // 检查中奖商品是否需要发货，如果需要发货，检查用户是否有收货地址
    $.get('/wap/lottery.php?action=check_address',{'aid':aid},function(response){
		if(response.err_code>0){
			alert(response.err_msg);
			setTimeout(function(){window.location = '/wap/lottery.php?action=myaddress&aid='+aid},2000);
		}else{
			// 开始兑奖
			$.post('/wap/lottery.php?action=cash_prize',{'rid':rid,'aid':aid},function(response){
				alert(response.err_msg);
				if(response.err_code==0){
					setTimeout(function(){window.location.reload();},2000);	
				}
			},'json');
		}
    },'json');

});

$("#save-btnn").bind("click",
function () {
	var btn = $(this);
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
					setTimeout(function(){window.location.reload();},2000);	
				}
			},'json');
		}
    },'json');
});

</script>
<?php echo $shareData;?>
</body>
</html>
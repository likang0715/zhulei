var timer=0;
$(function(){
	$("#fly_page").hide();
	$("#TipContent").hide();
	$(".zhezhao").hide();
    	timeShow();//倒计时
    	record();//中奖记录延迟加载
	init();//手机摇一摇执行事件
});
//点击摇奖
function shakelottery(){
	var stat = $("#stat").val();
	var notice_content = $('params').attr('notice_content');
	var ShakeUrl = $('params').attr('AjaxReturnPrizeUrl');
	if(notice_content == 'no_follow'){
	  $(".closed").show();
		$("._flys").show();
		$("#membernotice").show();
	  $("#fly_page").show();
		return false;
	}
	if(notice_content == 'no_register'){
		$(".closed").show();
		$("._flys").show();
		$("#TipContent").show();
		$(".zhezhao").show();
		return false;
	}
	if(stat == 'fail'){
		return false;
	}
	var t = null;
	$(function() {
		clearTimeout(t);
		var t = setTimeout($.ajax({
			type : 'GET',
			url  : ShakeUrl,
			beforeSend:function(){
				$(".game-yao").addClass("shake");
				$(".game-start-btn").attr('disabled','disabled');
			},
			success:function(json){
				// console.log(json);
				var obj = eval('(' + json + ')');
				if(obj.status == 'success'){
					playsuccesssound();
					$(".tipText").html("摇到了<em>"+obj.prizename+"</em>");
					$(".priceImg").html('<img src="'+obj.prizeimg+'" height="112" width="112" alt="price">');
					winning();
					record();
				}else if(obj.status == 'errormsg'){
					playfailsound();
					alert(obj.msg,'blue','#00ff00','green','rgb(255, 255, 0)');
				}else if(obj.status == 'timelimit'){
				}else{
					playfailsound();
					$(".tipText").html("给力点， 换个姿势再摇一次");
					$(".priceImg").html('');
					fail();
				}
			},
			complete:function(){
				$(".game-start-btn").removeAttr("disabled");
				$('.game-yao').removeClass('shake');
			}
		}), 500);
	});

}
function timeShow(){
	var other_source = $('params').attr('other_source');
	if(other_source == ''){
		var show_time = $(".timeShow");
		starttime = new Date($('params').attr('starttime'));//开始时间
		endtiem = new Date($('params').attr('enddate'));//结束时间
		today = new Date();//当前时间
		if(starttime > today){
			time = starttime;
		}else{
			time = endtiem;
		}
		delta_T = time.getTime() - today.getTime();//时间间隔
		if(delta_T < 0){
			clearInterval(timeShow);
			//alert("活动已结束");
			alert('活动已结束','blue','#00ff00','green','rgb(255, 255, 0)');
			return false;
		}
		window.setTimeout(timeShow,1000);
		total_days = delta_T/(24*60*60*1000);//总天数
		total_show = Math.floor(total_days);//实际显示的天数
		total_hours = (total_days - total_show)*24;//剩余小时
		hours_show = Math.floor(total_hours);//实际显示的小时数
		total_minutes = (total_hours - hours_show)*60;//剩余的分钟数
		minutes_show = Math.floor(total_minutes);//实际显示的分钟数
		total_seconds = (total_minutes - minutes_show)*60;//剩余的分钟数
		seconds_show = Math.floor(total_seconds);//实际显示的秒数
		if(total_days<10){
			total_days="0"+total_days;
		}
		if(hours_show<10){
			hours_show="0"+hours_show;
		}
		if(minutes_show<10){
			minutes_show="0"+minutes_show;
		}
		if(seconds_show<10){
			seconds_show="0"+seconds_show;
		}
		show_time.find("li").eq(0).text(total_show);//显示在页面上
		show_time.find("li").eq(2).text(hours_show);
		show_time.find("li").eq(4).text(minutes_show);
		show_time.find("li").eq(6).text(seconds_show);
	}
}
function playfailsound(){
	var Failaudio = document.getElementById('failaudio');
	Failaudio.play();
}
function playsuccesssound(){
	var Successaudio = document.getElementById('successaudio');
	Successaudio.play();
}

 function init(){
　　if (window.DeviceMotionEvent) {
　　　　// 移动浏览器支持运动传感事件
　　　　window.addEventListener('devicemotion', deviceMotionHandler, false);
　　}
}


var SHAKE_THRESHOLD = 3000;
// 定义一个变量保存上次更新的时间
var last_update = 0;
// 紧接着定义x、y、z记录三个轴的数据以及上一次出发的时间
var x;
var y;
var z;
var last_x;
var last_y;
var last_z;
var count = 0;
function deviceMotionHandler(eventData) {
　　// 获取含重力的加速度
　　var acceleration = eventData.accelerationIncludingGravity;
　　// 获取当前时间
　　var curTime = new Date().getTime();
　　var diffTime = curTime -last_update;
　　// 固定时间段
　　if (diffTime > 100) {
　　　　last_update = curTime;
　　　　x = acceleration.x;
　　　　y = acceleration.y;
　　　　z = acceleration.z;
　　　　var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;
　　　　if (speed > SHAKE_THRESHOLD) {
			var ct = null;
			clearTimeout(ct);
			var t = null;
			clearTimeout(t);
			var ct = setTimeout(shakelottery, 500);
			$(".game-yao").addClass("shake");
            t=setTimeout("$('.game-yao').removeClass('shake');i=0",3000);
　　　　}
　　　　last_x = x;
　　　　last_y = y;
　　　　last_z = z;
　　}
}

function winning(){
	$(".fullBg").show();
    $(".get").show();
	$("#stat").val('fail');
}
function fail(){
    $(".fullBg").show();
    $(".sorry").show();
    $("#stat").val('fail');
}
function aClosed(){
    $(".fullBg").fadeOut(300);
    $(".owindow").fadeOut();
    $("#stat").val('ok');
}
function getprize(id){
	layer.open({
	  type: 2,
	  title: '填写收货地址',
	  shadeClose: true,
	  shade: false,
	  closeBtn: 1, //不显示关闭按钮
	  area: ['90%', '90%'],
	  content: '?a=lottery_getadress&id='+id,
	  end :function(){
	  	record();
	  }
	});
}
// 领取虚拟奖品
function getfictitiou(id){
	var url='?a=user_get_fictitiou&id='+id;
	$.get(url,function(sta){
		// console.log(sta);
		if(sta.err_code==0){
			alert(sta.err_msg);
			record();
		}else{
			alert(sta.err_msg);
		}
	})
}
function record(){
	var aid = $('params').attr('aid');
	var user_id = $('params').attr('user_id');
	var MyRecordUrl = $('params').attr('MyRecordUrl');
	var OtherRecordUrl = $('params').attr('OtherRecordUrl');
	$.ajax({	//我的中奖记录
		type : 'POST',
		data : "aid="+aid+"&user_id="+user_id,
		url  : MyRecordUrl,
		success:function(data){
			if(data != 'fail'){
				$(".myrecord").html(data);
			}else{
				$(".myrecord").html("<li style='text-align:center;'>暂无中奖记录</li>");
			}
		}
	});
	$.ajax({	//其他中奖记录
		type : 'POST',
		data : "aid="+aid+"&user_id="+user_id,
		url  : OtherRecordUrl,
		success:function(data){
			if(data != 'fail'){
				$(".otherrecord").html(data);
			}else{
				$(".otherrecord").html("<li style='text-align:center;'>暂无中奖记录</li>");
			}
		}
	});
}
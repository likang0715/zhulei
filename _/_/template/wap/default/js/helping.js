function tab(a,b,c){
    var len=$(a);
    len.bind("click",function(){
        var index = 0;
        $(this).addClass(c).siblings().removeClass(c);
        index = len.index(this);
        $(b).eq(index).show().siblings().hide();
        return false;
    }).eq(0).trigger("click");
}
//2.将盒子方法放入这个方，方便法统一调用
function centerWindow(a) {
    center(a);
    //自适应窗口
    $(window).bind('scroll resize',
        function() {
            center(a);
        });
}
function centerTop(a) {
    var wWidth = $(window).width();
    var boxWidth = $(a).width();
    var scrollLeft = $(window).scrollLeft();
    var left = scrollLeft + (wWidth - boxWidth) / 2;
    $(a).css({
        "left": left
    });
}
//1.居中方法，传入需要剧中的标签
function center(a) {
    var wWidth = $(window).width();
    var wHeight = $(window).height();
    var boxWidth = $(a).width();
    var boxHeight = $(a).height();
    var scrollTop = $(window).scrollTop();
    var scrollLeft = $(window).scrollLeft();
    var top = scrollTop + (wHeight - boxHeight) / 2;
    var left = scrollLeft + (wWidth - boxWidth) / 2;
    $(a).css({
        "top": top,
        "left": left
    });
}

$(function(){
    countTop();
    $(window).bind('scroll resize',
        function() {
            countTop();
        });
    function countTop(){
        var ftH=$("footer").height();
        var wHeight = $(window).height();
        var top = wHeight - ftH;
        $("footer").css({"top":top});

    }
});

function share(){
    $('.share_bg').show();
    $('.share_bg').click(function(){
        if($(this).css('display') == 'block'){
            $(this).css('display','none');
        }
    });
}

//倒计时
var timeShow = function(){
    var show_time = $(".timeShow");
    endtime = new Date(daotime);//结束时间
    today = new Date();//当前时间
    delta_T = endtime.getTime() - today.getTime();//时间间隔
    if(delta_T>1000){
        window.setTimeout(timeShow,1000);
    }else{
        /*if(is_over==1){
            $(".timeBox").children("h2").text("活动已经开始");
            $(".timeShow").hide();
            $("#oBtn a").text("活动已经开始");
        }else if(is_over==0){
            $(".timeBox").children("h2").text("活动已经结束");
            $(".timeShow").hide();
            $(".first_join").text("活动已经结束");
        }*/
        window.location.href="";return false;
    }
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

function alert(text){
    var t=null;
    clearTimeout(t);
    var tip= $(".tips");
    tip.find('h3').html(text);
    tip.slideDown();
    t=setTimeout(function(){ tip.slideUp()},3000);
}

function alertlong(text){
    var t=null;
    clearTimeout(t);
    var tip= $(".tips");
    tip.find('h3').html(text);
    tip.slideDown();
    t=setTimeout(function(){ tip.slideUp()},60000);
}

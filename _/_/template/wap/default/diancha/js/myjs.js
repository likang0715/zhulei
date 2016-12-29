// My javascript
// 2016-01-20
// Author: duchong
// Blog: http://lovejquery.com

// 阻止冒泡事件
function stopEvent() { 
	var e = arguments.callee.caller.arguments[0] || event; //若省略此句，下面的e改为event，IE运行可以，但是其他浏览器就不兼容
	if (e && e.stopPropagation) {
		e.stopPropagation();
	} else if (window.event) {
		window.event.cancelBubble = true;
	}
}

// 设置相对屏幕宽度变化的的样式
function newStyle(id,attr,val) {//设置新的样式，自适应浏览器窗口
	var w = document.body.clientWidth; //获取页面可见宽度
	var v = ~~ (w * val * 100) / 100;
	$(id).css(attr, v + "px");
}

// 执行一次animation动画
function oneAnim(x){
	$('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass();
    });
}
//无限轮播
$(document).ready(function() {
	var liw = 990;
	var ul = $('#banner_box');
	var next = $('#banner_next');
	var prev = $('#banner_prev');
	var lis = ul.find('li').size();
	if (parseInt(lis)>1) {
		autoNum();
		var lisize = ul.find('li').size();
		ul.css('width', lisize*(liw+10));
		oneShow(3); //参数为eq值+1
		aSilder();
	}else{
		oneShow(1);
		$('.detail_banner_control').hide();
	};
		// 某一张在中间部分显示
		function oneShow (index) {
			var one = ul.find('li').eq((parseInt(index)-1))
			var left = one.position().left;
			var wwidth = $(window).width();
			var mainside = (wwidth-liw)*0.5;
			one.addClass('banner_cur');
			ul.css({
				'left': mainside-left,
			});
		}

		function autoNum() {
			ul.find('li').eq(0).clone().appendTo('#banner_box');
			ul.find('li').eq(1).clone().appendTo('#banner_box');
			ul.find('li:nth-last-of-type(3)').clone().prependTo('#banner_box');
			ul.find('li:nth-last-of-type(4)').clone().prependTo('#banner_box');
		}

		
		function aSilder () {
			prev.click(function() {
				var cur = $('li.banner_cur');
				if (cur.size()>0) {
				var curid = parseInt(cur.index())+1;
				if (curid>3) {
					cur.removeClass('banner_cur');
					ul.animate({'left': '+='+(liw+10)},
						300, function() {
							oneShow (parseInt(curid)-1)
					});
					}else if(curid==3){
						cur.removeClass('banner_cur');
						ul.animate({'left': '+='+(liw+10)},
							300, function() {
								oneShow (lisize-2);
						});
					}
				}else{
					return false;
				};
			});
			next.click(function() {
				var cur = $('li.banner_cur');
				if (cur.size()>0) {
					var curid = parseInt(cur.index())+1;
					if (curid<lisize-2) {
					cur.removeClass('banner_cur');
					ul.animate({'left': '-='+(liw+10)},
						300, function() {
							oneShow (parseInt(curid)+1)
					});
					}else if(curid==lisize-2){
						cur.removeClass('banner_cur');
						ul.animate({'left': '-='+(liw+10)},
							300, function() {
								oneShow (3);
						});
					}
				
				}else{
					return false;
				};
			});

		}
})

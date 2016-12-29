var guanzhuPage = 1;
var shoucangPage = 1;
var guanzhuIsAjax = false;
var shoucangIsAjax = false;
var orderSort = 'default';
var orderShowRows = false;
var max_page;
var max_page1 = 1;
var max_page2 = 1;
var indes = 1;


$(function(){
	FastClick.attach(document.body);
	$(window).scroll(function(){
		
		if($("#list_comments .list_comments").eq(1).is(":visible")) {
			if(guanzhuPage > 1 && $(window).scrollTop()/($('body').height() -$(window).height())>=0.95){
				if(guanzhuIsAjax == false){
					if(typeof(max_page1) != 'undefined'){
						if(guanzhuPage <= max_page1) {
							
							if($('.wx_loading1').is(":hidden")) {
								getGuanzhu();
							}	
						}
					}
				}
			}
		}
		if($("#list_comments .list_comments").eq(0).is(":visible")) {
			
				if(shoucangIsAjax == false){
					if(typeof(max_page2) != 'undefined'){
						if(shoucangPage <= max_page2) {
							
							if($('.wx_loading2').is(":hidden")) {
								getShoucang();
							}	
						}
					}
				}

		}
		
		if($(document).scrollTop() > 50){
			$('.mod_filter').css('top',0);
		}else{
			$('.mod_filter').css('top',45);
		} 
	});	
	if($(window).width() < 400){
		orderShowRows = true;
	}

	getShoucang();
	
	$(".tabber_menu a").click(function(){
		var menu_index = $(".tabber_menu a").index($(this));
		
		if(!$(this).hasClass("active")) {
			$(".tabber_menu a").removeClass("active");
			$(this).addClass("active");
			
			if(menu_index == 0) {
				$("#list_comments .list_comments").hide();
				$("#list_comments .list_comments").eq(1).show();
				if ($("#list_comments_2").attr("next") == "false") {
					return;
				}
				
				if(typeof(max_page) == 'undefined') {
					if($('.wx_loading2').is(":hidden")) {
						getShoucang();
					}
				} else {
					if(shoucangPage <= max_page2) {
						if($('.wx_loading2').is(":hidden")) {
							getShoucang();
						}
					}
				}
			}
			if(menu_index == 1) {
				$("#list_comments .list_comments").hide();
				$("#list_comments .list_comments").eq(0).show();
				
				if ($("#list_comments_1").attr("next") == "false") {
					return;
				}
				
				if(typeof(max_page1) != 'undefined'){
					if(guanzhuPage <= max_page1) {
						if($('.wx_loading1').is(":hidden")) {
							getGuanzhu();
						}	
					}
				}
			}
		}
	})
	
	function getGuanzhu(){
		$('.wx_loading1').show();
		$('.wx_loading2').hide();
		product_id="10";
		var url=page_url+"&page="+guanzhuPage;
		
		$.get(url, function (result) {
			var plHtml = "";
			var comments_index = '';
			
			for(var i in result.err_msg.list){
				var pinlun = result.err_msg.list[i];
				//var users = result.err_msg.userlist[pinlun.user_id];
				
						
				var touxiang = pinlun.avatar;
				if(pinlun.nickname){
					var nickname = pinlun.nickname;
				} else {
					var nickname = "匿名";
				}
				
				var dateline = new Date((pinlun.add_time)*1000);
				var last_time = pinlun.last_time;
				plHtml += '<li>';
				plHtml += '	<div class="tbox">';
				plHtml += '		<div>';
				plHtml += '			<span class="img_wrap">';
				plHtml += '				<img src="' + touxiang + '">';
				plHtml += '			</span>';
				plHtml += '			<p>' + nickname + '</p>';
				plHtml += '			<p style="align:center;"></p>';
				plHtml += '		</div>';
				plHtml += '		<div>';
				plHtml += '			<p class="comment_content"> </p>';
				plHtml += '			<p>';
				plHtml += '				<label class="comment_time">关注时间：' + formatDate(dateline) + '</label>';
				plHtml += '			</p>';
				plHtml += '		</div>';
				plHtml += '	</div>';
				plHtml += '</li>';
			}

			guanzhuPage = parseInt(guanzhuPage) + 1;

			$(".wx_loading1").hide();
			$("#list_comments .list_comments").hide();
			$("#list_comments .list_comments").eq(0).show().append(plHtml);
			$("#list_comments .list_comments").eq(0).data("type", "value");
			$("#list_comments .list_comments").eq(0).data("page", guanzhuPage);
			max_page1 = result.err_msg.max_page;
				
			if (result.err_msg.noNextPage) {
				$("#list_comments .list_comments").eq(0).show().append('<div class="s_empty" style="display:block;">已无更多关注！</div>');
				$("#list_comments .list_comments").eq(0).attr("next", "false");
			}
			
		});
		
		
	}
	
	function getShoucang(){
		$('.wx_loading1').hide();
		$('.wx_loading2').show();
		product_id="10";
		var url=page_url+"&types=shoucang&page="+shoucangPage;
		
		$.get(url, function (result) {
			var plHtml = "";
			var comments_index = '';
			
			for(var i in result.err_msg.list){
				var pinlun = result.err_msg.list[i];
				//var users = result.err_msg.userlist[pinlun.user_id];
	
/*				if(pinlun.content){
					var miaoshu = pinlun.content;
				} else {
					var miaoshu = "暂无描述";
				}
				if(users.avatar){
					var touxiang = users.avatar;
				} else {
					var touxiang = "";
				}
				if(users.nickname){
					var nickname = users.nickname;
				} else {
					var nickname = "匿名";
				}*/
				
				
				var touxiang = pinlun.avatar;
				if(pinlun.nickname){
					var nickname = pinlun.nickname;
				} else {
					var nickname = "匿名";
				}
				
				var dateline = new Date((pinlun.add_time)*1000);
				var last_time = pinlun.last_time;
				plHtml += '<li>';
				plHtml += '	<div class="tbox">';
				plHtml += '		<div>';
				plHtml += '			<span class="img_wrap">';
				plHtml += '				<img src="' + touxiang + '">';
				plHtml += '			</span>';
				plHtml += '			<p>' + nickname + '</p>';
				plHtml += '			<p style="align:center;"></p>';
				plHtml += '		</div>';
				plHtml += '		<div>';
				plHtml += '			<p class="comment_content"> </p>';
				plHtml += '			<p>';
				plHtml += '				<label class="comment_time">收藏时间：' + formatDate(dateline) + '</label>';
				plHtml += '			</p>';
				plHtml += '		</div>';
				plHtml += '	</div>';
				plHtml += '</li>';
			}

			shoucangPage = parseInt(shoucangPage) + 1;

			$(".wx_loading2").hide();
			$("#list_comments .list_comments").hide();
			$("#list_comments .list_comments").eq(1).show().append(plHtml);
			$("#list_comments .list_comments").eq(1).data("type", "value");
			$("#list_comments .list_comments").eq(1).data("page", shoucangPage);
			max_page2 = result.err_msg.max_page;
				
			if (result.err_msg.noNextPage) {
				$("#list_comments .list_comments").eq(1).show().append('<div class="s_empty" style="display:block;">已无更多收藏！</div>');
				$("#list_comments .list_comments").eq(1).attr("next", "false");
			}
			
		});
		
		
	}
	
	function   formatDate(now)   {
		var   year=now.getFullYear();
		var   month=now.getMonth()+1;
		var   date=now.getDate();
		var   hour=now.getHours();
		var   minute=now.getMinutes();
		var   second=now.getSeconds();
		
		if(month<10) month = "0"+month;
		if(date<10) date = "0"+date;
		
		return   year+"."+month+"."+date;
	}
	
	
});
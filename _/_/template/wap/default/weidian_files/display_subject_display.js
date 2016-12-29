
$.fn.isOnScreen = function(){
	var win = $(window);
	var viewport = {
		top : win.scrollTop(),
		left : win.scrollLeft()
	};
	viewport.right = viewport.left + win.width();
	viewport.bottom = viewport.top + win.height();

	var bounds = this.offset();

	bounds.right = bounds.left + this.outerWidth();
	bounds.bottom = bounds.top + this.outerHeight();
		 
	return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
};
	
$(function(){
	
	
	//专题点击 禁止冒泡
	$(".product_show .active, .product_show .actives").live("click",function(event){
		var subject_id = $(this).data("subjectid");
		i_obj = $(this);
		if(!subject_id) {
			return false;
		}

		//专题点赞操作
		if($(this).hasClass("dianzan_selected")) {
			//取消点赞
			$.post(
				dianzan_url,
				{'subject_id':subject_id,'types':'qx'},
				function(obj) {
					if(obj.err_code == '0') {
						  i_obj.removeClass("dianzan_selected");
						//添加成功
						dz_index = $(".product_show .active").index($(this))
						var last_dz_count = i_obj.find(".dz_count").text();

						last_dz_count = parseInt(last_dz_count*1)*1-1;
						if(last_dz_count>0) {}else {last_dz_count = 0;}
						i_obj.find(".dz_count").text(last_dz_count);
					} else {
						//已经收藏过了
						return false;
					}
				},
				'json'
			)
		} else {
			//点赞
			$.post(
				dianzan_url,
				{'subject_id':subject_id},
				function(obj) {
					if(obj.err_code == '0') {
						$(this).addClass("dianzan_selected");
						 i_obj.addClass("dianzan_selected");
						//添加成功
						dz_index =$(".product_show .active").index($(this))
						var last_dz_count = i_obj.find(".dz_count").text();
						last_dz_count = parseInt(last_dz_count*1)+1;
						i_obj.find(".dz_count").text(last_dz_count);
					
					} else {
						//已经收藏过了
						
						return false;
					}
				},
				'json'
			)
		}
		return false;
	})
	
	//进入产品详情页
	$(".product_show li").live("click",function(event){
		var e = window.event || event;

		if(e.stopPropagatioin) {
			e.stopPropagation();
		} else {
			//兼容IE的方式来取消事件冒泡
			window.event.cancelBubble = true;
		}
		
	})	
	

	
	//无限加载专题
	var scroll_index = false;
	$(window).scroll(function(){
		
		if(scroll_index) return;
		try{
			if($(".subject_display_datas").size()) {
				if ($(".subject_display_datas").isOnScreen()) {	
					scroll_index = true;
					var info = $(".subject_display_datas").data("infos");
					console.log(info)
					if(info) {
						//每次滚动加载1个
						j=0;
						for(var i in info) {

							if($(".subject_display_div .show_list li").hasClass(info[i].dates)) {
								//拥有当日部分数据
								obj_dates_data = $(".subject_display_div .show_list li "+info[i].dates);
								if ($(".subject_display_div .show_list  ."+info[i].dates + " .product_show li").hasClass("subject_"+info[i].id)) {
									//拥有当日当条专题数据	
									delete info[i];
									
									$(".subject_display_datas").data("info",info);
									var info2 = $(".subject_display_datas").data("info");
									scroll_index = false;
									continue;
								} else {
									var html1  = '<li class="subject_'+info[i].id+'" style1="background-color:#ccc;background:url('+info[i].pic+') center no-repeat;">'; 
										html1 += '	<a style="display:block;width:100%;height:100%;text-align:center" href="'+info[i].url+'">';
										html1 += '		<img src="'+info[i].pic+'">';
										if(info[i].dianzan_tip) {
											html1 += '				<i  data-subjectid="'+info[i].id+'"  class="active dianzan_selected"><em></em><span class="dz_count">'+info[i].dz_count+'</span></i>';
										} else {
											html1 += '				<i   data-subjectid="'+info[i].id+'"  class="active"><em></em><span class="dz_count">'+info[i].dz_count+'</span></i>';
										}
										html1 += '		<p style="width:100%;text-align:left;line-height:18px;height:18px;font-size:14px;">'+info[i].name+'</p>';
										html1 += '	</a>';
										html1 += '</li>';
										
									$(".subject_display_div .show_list  ."+info[i].dates + " .product_show").append(html1);

									delete info[i];
									$(".subject_display_datas").data("info",info);
									scroll_index = false;
									j++;
								}
							} else {
								var html1  = '<li class="'+info[i].dates+'">';
									//var next_tims = '<i><em></em>下次更新'+info[i].dates_update_click+'</i>';
									next_tims = "";
									html1 += '	<div class="show_title clearfix"> <span>'+info[i].dates_chinese+'&nbsp;'+info[i].dates_xingqi+'</span>'+next_tims+' </div>';
									html1 += '	<ul class="product_show">';
									html1 += '		<li class="subject_'+info[i].id+'" style1="background:url('+info[i].pic+') center no-repeat;">';
									html1 += '			<a style="display:block;width:100%;height:100%;text-align:center" href="'+info[i].url+'">';
									html1 += '				<img src="'+info[i].pic+'">';
									if(info[i].dianzan_tip) {
										html1 += '				<i  data-subjectid="'+info[i].id+'" class="active dianzan_selected"><em></em><span class="dz_count">'+info[i].dz_count+'</span></i>';
									} else {
										html1 += '				<i  data-subjectid="'+info[i].id+'" class="active"><em></em><span class="dz_count">'+info[i].dz_count+'</span></i>';
									}
									html1 += '				<p style="width:100%;text-align:left;line-height:18px;height:18px;font-size:14px;">'+info[i].name+'</span></p>';
									html1 += '			</a>';
									html1 += '		</li>';
									html1 += '	</ul>';	
									html1 += '</li>';
								
									delete info[i];
									$(".subject_display_datas").data("info",info);
									$(".subject_display_div .show_list").append(html1);
								
									scroll_index = false;
								
								j++;
							}
							break;
						}
					}
				}
			}
		} catch(e) {
			
		}


	});

	
})
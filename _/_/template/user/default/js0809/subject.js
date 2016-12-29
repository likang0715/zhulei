/**
 * Created by pigcms-s on 2015/09/11.
 */
var p=1;
var sub_add_tip = "";
$(function() {
	location_page(location_type,location.hash, 1);

	function reloads() {
		window.location.reload();
	}
	
  //专题管理 关联产品上传
	function load_widget_lin_box() {
		
		
		$('.module-goods-list .sort .js-delete-goods').live("click",function(){
			obj_sort = $(this).closest(".js-ico-lists");
			if(obj_sort.find(".sort").size() == 1) {
				$(this).closest('.js-ico-lists').remove();
			}
			$(this).closest('.sort').remove();
			//var good_data = domHtml.data('goods');
			//delete good_data[$(this).data('id')];

		});
		
		widget_link_box($('.js-add-sub-product'),'good_only_pic&only=1',function(result){

			var domHtml = $(".app__content").find(".form-forms");
			var good_data = '';
			if(good_data){
				//$.merge(good_data,result);
			}else{
				good_data = result;
			}

			var html = '';var htmls="";
			for(var i in good_data){
				var html = '';
				var item = good_data[i];
				titles = item.title;
				len = 6;
					
				if(titles.length>len) {
					titles = titles.substr(0,len)+'..';
				}	
					
					
				html += "<div><ul class='ico app-image-list js-ico-lists' style='display:inline-block'>";

				html += '	<li style="background:none;width:90px;line-height:41px;border:0px;">' +titles+ '</li>';
				for(var j in item.piclist) {
					html += '<li class="sort" data-id="'+i+'"><img data-id="'+i+'" src="'+item.piclist[j]+'" ><a class="close-modal js-delete-goods small hide" data-id="'+i+'" title="删除">×</a></li>';
				}
				html += " </ul></div>";
				htmls += html;
			}
			
			$('.module-goods-list').prepend(htmls);
			// rightHtmls = $(".controls_good").html();
			 //rightHtml = $(rightHtmls);			
				//$(".controls_good .module-goods-list").sortable().bind('sortupdate', function(j) {
		
			$(".controls_good .sort-goods-list").sortable({cancel: ".ui-state-disabled"}).live('sortupdate', function(j) {
				$(".save_ok").html('<font style="font-size:11px;font-weight:700;color:#f00">商品位置更新成功,保存后生效。</font>').delay(1000).fadeIn(0,function(){
					$(".save_ok").html('温馨提示：上下挪动商品名称，可以改变商品排序!');	
				})
			})			
			
		});
		
	}
	
	$('a').live('click',function(){
		if($(this).closest(".widget-image").size()) {
			
		} else {
			if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#')  {
				
				location_page(location_type,$(this).attr('href'),$(this));
			}
		}
	});
	function location_page(location_type,mark, page){
		var mark_arr = mark.split('/');
		
			switch(location_type){
			
				case 'subject':
					switch(mark_arr[0]){
						case '#create':
							$(".subject_search").hide();
							load_page('.app__content', load_url,{page:'subject_create',type:'subject'}, '',load_widget_lin_box);
							break;
						case "#edit":
							if(mark_arr[1]){$(".subject_search").hide();
								load_page('.app__content', load_url,{page:'subject_edit',type:'subject',id:mark_arr[1]},'',load_widget_lin_box);
							}else{
								layer.alert('非法访问！');
								location.hash = '#list';
								location_page('');
							}
							break;
						
						case '#all':
							load_page('.app__content', load_url,{page:'subject_content', "type": 'subject', "p" : page}, '');
							break;
							
							
						default:
							load_page('.app__content', load_url,{page:'subject_content', "type": 'subject', "p" : page}, '');
						}
					break;
					
				case 'subtype':
					switch(mark_arr[0]){
						case '#create':
							//load_page('.app__content', load_url,{page:'subtype_create',type:'subtype'}, '');
							break;
						case "#edit":
							if(mark_arr[1]){
								subtype_edit(mark_arr[1]);

								//load_page('.app__content', load_url,{page:'subtype_edit',type:'subtype',id:mark_arr[1]},'',function(){
	
								//});
							}else{
								layer.alert('非法访问！');
								location.hash = '#list';
								location_page('');
							}
							break;
	
							
						default:
							load_page('.app__content', load_url,{page:'subtype_content', "type": 'subtype', "p" : page}, '');
					}
					break;
					
				case 'subject_pinlun':
					switch(mark_arr[0]){
						case '#create':
							//load_page('.app__content', load_url,{page:'subtype_create',type:'subtype'}, '');
							break;
						case "#edit":
							if(mark_arr[1]){
								subtype_edit(mark_arr[1]);

								//load_page('.app__content', load_url,{page:'subtype_edit',type:'subtype',id:mark_arr[1]},'',function(){
	
								//});
							}else{
								layer.alert('非法访问！');
								location.hash = '#list';
								location_page('');
							}
							break;
	
							
						default:
							load_page('.app__content', load_url,{page:'subject_pinlun_content', "type": 'subject_pinlun', "p" : page}, '');
					}
					break;
				
			}		
				
	}

	
	//添加新分类
	$("#subtype_create").live("click",function(){
		
		 sub_add_tip = $.layer({
			type: 2,
			shade: [0],
			fix: false,
			title: '添加新分类',
			maxmin: true,
			iframe:{src : subtype_create_url},
			area: ['750px' , '550px'],

		}); 
		
	})
	
	//修改指定分类
	$(".subtype_edit").live("click",function() {
		subtype_id = $(this).attr("data");
		$.layer({
			type: 2,
			shade: [0],
			fix: false,
			title: '修改新分类',
			maxmin: true,
			iframe:{src : subtype_edit_url+"&id="+subtype_id},
			area: ['750px' , '550px'],
		}); 	
	})
	

	
	//专题分类管理 图片上传
	$('.js-add-subtype-picture').live('click',function(){
		upload_pic_box(1,true,function(pic_list){
			if(pic_list.length > 0){
				for(var i in pic_list) {
					var list_size = $('.js-ico-list .sort').size();
					if(list_size > 0){
						layer_tips(1,'每个专题分类最多支持 选1张');
						return false;
					}else if(list_size > 0){
						$('.js-ico-list .sort:last').after('<li class="sort"><div class="spans"><span class="checkico no-selected-style"><i class="icon-ok icon-white"></i><img class="avatar" src="'+pic_list[i]+'"></span><a class="js-delete-picture close-modal small hide">×</a></div></li>');
					}else{
						$('.js-ico-list').prepend('<li class="sort"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
					}
				}
			}
		},1);
	});
	
	
	//专题管理 图片上传
	$('.js-add-sub-picture').live('click',function(){
		upload_pic_box(1,true,function(pic_list){
			if(pic_list.length > 0){
				for(var i in pic_list) {
					var list_size = $('.js-ico-list .sort').size();
					if(list_size > 0){
						layer_tips(1,'每个专题最多支持 选1张');
						return false;
					}else if(list_size > 0){
						//$('.js-ico-list .sort:last').after('<li class="sort"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
						
						$('.js-ico-list .sort:last').after('<li class="sort"><div class="spans"><span class="checkico no-selected-style"><i class="icon-ok icon-white"></i><img class="avatar" src="'+pic_list[i]+'"></span><a class="js-delete-picture close-modal small hide">×</a></div></li>');
					}else{
						$('.js-ico-list').prepend('<li class="sort"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
					}
				}
			}
		},1);
	});	
	


		var click_status = true
		$(".subtype_px_button").live("click",function(){
			var idvalue = "";
			var pxidvalue = "";
			if(click_status) {
				click_status=false;

				$('.subtype_ids').each(function() {
					idvalue += $(this).attr("data_subtype_id") + ','
				});
				$('input[name="px"]').each(function() {
					pxidvalue += $(this).val() + ','
				});
				var valuearray = 'id_str=' + idvalue + '&sort_str=' + pxidvalue;
			
				$.layer({
					shade: [0],
					area: ['auto','auto'],
					dialog: {
						msg: '确认批量排序么？',
						btns: 2,
						type: 4,
						btn: ['确定','取消'],
						yes: function(){	
							click_status = true;
							$.ajax({
								type: "POST",
								async: false,
								dataType:"json",
								//url: "/admin.php?c=Product&a=set_type_sort",
								url: subtype_px_url,
								data: valuearray,
								success: function(data) {			
									layer.alert(data.msg);
									if(data.status == '0') {
										load_page('.app__content', load_url,{page:'subtype_content', "type": 'subtype', "page" : page_content}, '');
									}
								}
							})
						}, no: function(){
							click_status = true;
						}
					}
				});

				
			}

			
		})


		
	//专题搜索
	$(".subject_search_botton").live("click",function(){
		var keyword = $('.js-coupon-keyword').val();
		var type = window.location.hash.substring(1);

		
		var keyword = $(".subject_search input[name='titles']").val();
		var start_time = $(".subject_search input[name='start_time']").val();
		var end_time = $(".subject_search input[name='end_time']").val();
		var subtype1 = $(".subject_search select[name='subtype1']").val();
		var subtype2 = $(".subject_search select[name='subtype2']").val();
		if(subtype2) {
			subtype = subtype2;
		} else {
			subtype = subtype1;
		}
		$('.app__content').load(load_url, {"is_search":1, "page" : page_content, "title" : keyword, "start_time" : start_time,  "end_time":end_time, "subtype" : subtype}, function(){
			
		});		
		
		
		
	})
	

	//搜索框动画
	$('.ui-search-box :input').live('focus', function(){
		$(this).animate({width: '180px'}, 100);
	})
	$('.ui-search-box :input').live('blur', function(){
		$(this).animate({width: '70px'}, 100);
	})

	//分页
	$('.pagenavi > a').live('click', function(e){
		if($(this).closest(".widget-image").size()) {
		} else {
			var p = $(this).attr('data-page-num');
			location_page(location_type,window.location.hash, p);
		}
	});


	
	//失焦事件
	$(".app__content input").live("blur",function(){
		var input_name = $(this).attr("name");
		check_form_blur(input_name);
	})	
	
	//表单失焦
	function check_form_blur(input_name) {}
	
	

	//表单提交验证
	function check_form() {}
	




	
	
	//返回列表页
	$(".js-btn-quit").live("click", function () {
		switch(location_type) {
			case 'subject':
					location.href = "user.php?c=goods&a=subject";
				break;
				
			case 'subtype':
					location.href = "user.php?c=goods&a=subtype";
				break;
		}	
	})
	
	
	
	function returnurl() {		
		location.href= page_list_url;
	}
	

	
	$("input[name='range_type']").live("change",function(){
		var range_type = $(this).val();
		if(range_type == 'part') {$(".js-add-goods,.js_add_goods_from_edit").show();$(".js-goods-list,.js_add_goods_from_edit1").show();} else {$(".js-add-goods,.js_add_goods_from_edit").hide();$(".js-goods-list,.js_add_goods_from_edit1").hide();}
	})

	//限制文本框输入的字数
	$("textarea[name='description']").live("keydown",function(){
		var textObj = $("textarea[name='description']");

		var curLength= textObj.val().length;
		strLenCalc(textObj,'syzs',200);
	})

	function strLenCalc(obj, checklen, maxlen) {
		$(".controls_syzs").show();
		var v = obj.val(), charlen = 0, maxlen = !maxlen ? 200 : maxlen, curlen = maxlen, len = v.length;
		for(var i = 0; i < v.length; i++) {
			if(v.charCodeAt(i) < 0 || v.charCodeAt(i) > 255) {
				curlen -= 1;
			}
		}

		if(curlen >= len) {
			$("#"+checklen).html(" "+Math.floor((curlen-len)/2)+" ").css('color', '');
		} else {
			var contents = obj.val().substr(0,200);
			obj.val(contents);
			$("#"+checklen).html(" "+Math.ceil((len-curlen)/2)+" ").css('color', '#FF0000');

		}
	}





	// 删除
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var id = $(this).attr('data');
		$('.js-delete').addClass('active');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(delete_url, {'id': id}, function(data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == 0) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					load_page('.app__content',load_url,{page: page_content},'');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
			})
		});
	});

	// 删除专题分类
	$('.js-subject-delete').live("click", function(e){
		var delete_obj = $(this);
		var id = $(this).attr('data');
		$('.js-subject-delete').addClass('active');
		
		var confrm_tips = '确认删除？';

		button_box($(this), e, 'left', 'confirm', confrm_tips, function(){
			$.get(subject_delete_url, {'id': id}, function(data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == 0) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					load_page('.app__content', load_url,{page:'subject_content', "type": 'subject', "page" : page_content}, '');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
			})
		});
	});

	// 删除专题分类
	$('.js-subtype-delete').live("click", function(e){
		var delete_obj = $(this);
		var id = $(this).attr('data');
		$('.js-subtype-delete').addClass('active');
		
		var confrm_tips = '确认删除？';
		if($(this).closest("tr").attr('datatype') == 'fa') {
			var confrm_tips = "确认删除，<br><span style='#f00' class='red'>当前及其子分类！</span>";
		}
		
		button_box($(this), e, 'left', 'confirm', confrm_tips, function(){
			$.get(subtype_delete_url, {'id': id}, function(data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == 0) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					load_page('.app__content', load_url,{page:'subtype_content', "type": 'subtype', "page" : page_content}, '');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
			})
		});
	});

	//使专题类别失效
	$(".js_subtype_disabled").live("click", function (e) {
		var disabled_obj = $(this);
		var js_disabled_index = $(".js_subtype_disabled").index($(this));
		var subtype_id = disabled_obj.closest("tr").attr("data");
		
		var confrm_tips = '确定让这组专题分类失效?';
		if(disabled_obj.closest("tr").attr("datatype") == 'fa') {
			var confrm_tips='确定让这组专题分类失效?<br><span class="red">失效的将包括当前及其子分类哦！</span>';
		}
		button_box($(this), e, 'left', 'confirm', confrm_tips, function(){
			$.get(subtype_disabled_url, {"id" : subtype_id}, function (data) {
				close_button_box();
				if (data.err_code == "0") {
					disabled_obj.closest(".subtype_ids").find(".tr_status").html("<b><font color='#f00'>已关闭</font></b>");
					$(".ui-table-list").find(".tr_status_"+subtype_id).html("<b><font color='#f00'>已关闭</font></b>");
					
					
					$(".js_subtype_disabled").eq(js_disabled_index).removeClass("js_subtype_disabled").addClass("js_subtype_able").html("使开启")
					
						$(".subtype_ids").each(function(i) {
							if($(this).attr("data_top") == subtype_id) {
								$(this).find(".js_subtype_disabled").removeClass("js_subtype_disabled").addClass("js_subtype_able").html("使开启");
							}
						})
					
					layer_tips(0, data.err_msg);
				} else {
					layer_tips(1, data.err_msg);
				}
			})
		});
	});
	
	//使专题类别启用
	$(".js_subtype_able").live("click",function (e) {
		var able_obj = $(this);
		var js_able_index = $(".js_subtype_able").index($(this));
		var subtype_id = able_obj.closest("tr").attr("data");
		
		var confrm_tips = "确认让这组专题分类开启？";
		
		button_box($(this), e, 'left', 'confirm', confrm_tips, function(){
			$.get(subtype_able_url, {"id" : subtype_id}, function (data) {
				close_button_box();
				if (data.err_code == "0") {
					able_obj.closest(".subtype_ids").find(".tr_status").html("<b>已开启</b>");
					$(".js_subtype_able").eq(js_able_index).removeClass("js_subtype_able").addClass("js_subtype_disabled").html("使失效")
					layer_tips(0, data.err_msg);
				} else {
					layer_tips(1, data.err_msg);
				}
			})
		});		
		
	})

	//添加图文专题内容
	var is_close_tip2 = true;
	$(".js-btn-add-save-subject").live("click", function() {
		if(!is_close_tip2) return false;
		is_close_tip2 = false;
		
		var subject_title = $("input[name='subject_title']").val();
		var top_typeid = $(".select_toptype").val();
		var son_typeid = $(".select_sontype").val();
		var subject_description = $(".description").val();
		var subject_pic = "";
		var list_size = $('.js-subject-ico img').size();
		var is_show = $('input[name="is_show"]:checked').val();

		var product_id_arr = [];
		var product_image_arr = [];
		$(".module-goods-list .sort img").each(function(i,item) {
			var product_id = $(item).attr("data-id");

			product_image_arr.push($(item).attr("src"));
			product_id_arr.push($(item).attr("data-id"));
		})
		
		if(!subject_title) {
			layer.alert("攻略标题不能为空！");
			is_close_tip2 = true;
			return;
		}
		
		if(list_size > 0) {
			var subject_pic = $('.js-subject-ico img').attr('src');	
		} else {
			layer.alert("专题图片不能为空！")
			is_close_tip2 = true;
			return;
		}
		
		if(!top_typeid) {
			layer.alert("请选择攻略分类");
			is_close_tip2 = true;
			return;
		}
		
		if(!subject_description) {
			layer.alert("攻略内容不能为空!");
			is_close_tip2 = true;
			return;
		}

		$.post(
			load_url,
			{'page':'subject_create','is_ajax':1,'product_image_arr':product_image_arr,'product_id_arr':product_id_arr,'top_typeid':top_typeid,"son_typeid":son_typeid,'title':subject_title,'pic':subject_pic,'description':subject_description,'is_show':is_show},	
			function(obj) {
				is_close_tip2 = true;
				
				if(obj.err_code == '0') {
					layer.msg("添加成功!");
					var t = setTimeout(returnurl('subject_list'), 2000);
				} else {
					layer.msg(obj.err_msg);
				}
			})
	})
	
	
	
	//修改图文专题内容
	var is_close_tip3 = true;
	$(".js-btn-edit-save-subject").live("click", function() {
		//if(!is_close_tip3) return false;
		//is_close_tip3 = false;
		
		var subject_title = $("input[name='subject_title']").val();
		var top_typeid = $(".select_toptype").val() ? $(".select_toptype").val() : '0';
		var son_typeid = $(".select_sontype").val();
		var subject_description = $(".description").val();
		var subject_pic = "";
		var list_size = $('.js-subject-ico img').size();
		var is_show = $('input[name="is_show"]:checked').val();

		var product_id_arr = [];
		var product_image_arr = [];
		$(".module-goods-list .sort img").each(function(i,item) {
			var product_id = $(item).attr("data-id");

			product_image_arr.push($(item).attr("src"));
			product_id_arr.push($(item).attr("data-id"));
		})
	
		//return true;
		if(!subject_title) {
			layer.alert("攻略标题不能为空！");
			is_close_tip3 = true;
			return;
		}
		
		if(list_size > 0) {
			var subject_pic = $('.js-subject-ico img').attr('src');	
		} else {
			layer.alert("专题图片不能为空！")
			is_close_tip3 = true;
			return;
		}
		
		if($(".old_select_toptype").is(':visible')) {
			
		} else {
			if($(".select_toptype").is(":visible")) {
				if(!top_typeid) {
					layer.alert("请选择攻略分类");
					is_close_tip3 = true;
					return;
				}
			} else {
				layer.alert("专题分类错误！");
				is_close_tip3 = true;
				return;
			}
		}

		if(!subject_description) {
			layer.alert("攻略内容不能为空!");
			is_close_tip3 = true;
			return;
		}
		if(!subject_id) {
			layer.alert("修改参数错误");
			is_close_tip3 = true;
			return;
		}
		
		$.post(
			load_url,
			{'id':subject_id,'page':'subject_edit','is_ajax':1,'product_image_arr':product_image_arr,'product_id_arr':product_id_arr,'top_typeid':top_typeid,"son_typeid":son_typeid,'title':subject_title,'pic':subject_pic,'description':subject_description,'is_show':is_show},	
			function(obj) {
				is_close_tip3 = true;
				
				if(obj.err_code == '0') {
					layer.alert('修改成功', 9, !1);
					var t = setTimeout(returnurl('subject_list'), 2000);
				} else {
					layer.msg(obj.err_msg);
				}
			})
	})
	
	

	/*
	$(".controls_good .module-goods-list").sortable().bind('sortupdate', function(j) {
		$(".save_ok").html('<font style="font-size:11px;font-weight:700;color:#f00">商品位置更新成功,保存后生效。</font>').fadeIn(200).delay(1000).fadeOut(200);
	})	
	
	*/
	
	function returnurl(typs) {
		
		switch(typs) {
		
			case 'subject_list' : 
				location.href = page_list_url;
				break;
		} 
		
	}
	
	
	//添加/ 修改  专题内容
	$(".select_toptype").live("change",function(){
		top_val = $(this).val();
		if(top_val) {
			$.post(
				get_sonsubtype_url,
				{"topid":top_val},
				function(obj) {
					if(obj.err_code == '0') {
						for(var i in obj.err_msg) {
							var sontype = "<option class='son' value='"+obj.err_msg[i].id+"'>"+obj.err_msg[i].typename+"</option>";
							$(".select_sontype").append(sontype);
							$(".select_sontype").show();
						}
					} else if(obj.err_code == '5000') {
						$(".select_sontype son").hide().detach();
						$(".select_sontype").hide();
					} else {
						$(".select_sontype").hide();
						
						layer.alert(obj.err_msg);
					}
				},
				'json'
			)
		} else {
			$(".select_sontype").hide();
		}
	})

	//专题主页 搜索框专题分类
	$(".select_toptype_subject_content").live("change",function(){
		top_val = $(this).val();
		$("select[name='subtype2']").empty();
		if(top_val) {
			$.post(
				get_sonsubtype_url,
				{"topid":top_val},
				function(obj) {
					if(obj.err_code == '0') {
						var sontype = "<option class='son' value=''>未选择</option>";
						$(".select_sontype_subject_content").append(sontype);
						for(var i in obj.err_msg) {
							var sontype = "<option class='son' value='"+obj.err_msg[i].id+"'>"+obj.err_msg[i].typename+"</option>";
							$(".select_sontype_subject_content").append(sontype);
							$(".select_sontype_subject_content").show();
						}
					} else if(obj.err_code == '5000') {
						$(".select_sontype_subject_content son").hide().detach();
						$(".select_sontype_subject_content").hide();
					} else {
						$(".select_sontype_subject_content").hide();
						
						layer.alert(obj.err_msg);
					}
				},
				'json'
			)
		} else {

			$("select[name='subtype2']").empty().hide();
		}
	})
	
	
	$(".show_new_select_toptype").live("click",function() {
		$(".old_select_toptype").hide();
		$(".select_toptype").show();
		
	})
	
	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-coupon-keyword').is(':focus')) {
			var keyword = $('.js-coupon-keyword').val();
			var type = window.location.hash.substring(1);
			$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type}, function(){
			});
		}
	})


	//
	function msg_hide() {
		$('.notifications').html('');
		clearTimeout(t);
	}

	$(".js-link").live('click',function(e){

	   // button_box($(this),e,'left','copy',wap_coupon_url+'?id='+$(this).closest('tr').attr('service_id'),function(){
		button_box($(this),e,'left','copy',wap_coupon_url+'?id='+$(this).closest('tr').attr('data-store-id')+"&couponid="+$(this).closest('tr').attr('service_id'),function(){
			layer_tips(0,'复制成功');
		});
	})





})


//
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}




//删除图片
$('.js-delete-picture').live('click', function(){
	$(this).closest('li').remove();
})

//标签列表 显示详细
$(".show_more").live("click",function(){
	var show_more_data = $(this).attr("data");
	layer.alert("使用须知 ：" +show_more_data,'1','使用须知');
})

/*
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var id = $(this).attr('data');
		$('.js-delete').addClass('active');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(delete_url, {'id': id}, function(data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == 0) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					load_page('.app__content',load_url,{page: page_content},'');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
			})
		});
	});
*/


//专题评论全选
$(".js-check-all-subject_pinlun").live("click",function(){
	if ($(this).is(':checked')) {
		$('.js-check-toggle').attr('checked', true);
	} else {
		$('.js-check-toggle').attr('checked', false);
	}
})

//专题评论单个隐藏
$(".js-subject_pinlun-disabled").live("click",function(e){
	var disabled_obj = $(this);
	var js_disabled_index = $(".js-disabled").index($(this));
	var plid = disabled_obj.closest("tr").data("plid");
	
	button_box($(this), e, 'left', 'confirm', '确定隐藏这组专题评论?<br><span class="red">隐藏后将导致该专题评论无法在微信端专题评论中不显示！</span>', function(){
		$.get(subject_pinlun_disabled_url, {"id" : plid}, function (data) {
			close_button_box();
			if(data.err_code == '8888') {
				disabled_obj.closest("tr").find(".zt").html("<font color='#f00'>已隐藏</font>");
				disabled_obj.html("使显示");
				layer_tips(0, data.err_msg);
				
			} else if(data.err_code == '9999') {
				disabled_obj.closest("tr").find(".zt").html("<font color='#f00'>已显示</font>");
				disabled_obj.html("使隐藏");
				layer_tips(0, data.err_msg);
			} else {
				layer_tips(1, data.err_msg);
			}
		})
	});	
})

//专题评论单个删除
$(".js-subject_pinlun-delete").live("click",function(e){
	var disabled_obj = $(this);
	var plid = disabled_obj.closest("tr").data("plid");

	button_box($(this), e, 'left', 'confirm', '确定删除这组的专题评论?<br><span class="red">删除后将导致该专题评论无法在微信及商家中心端专题评论中无法显示！</span>', function(){
		$.post(all_subject_pinlun_delete_url, {'id_str': plid}, function (data) {
			close_button_box();
			if (data.err_code == "0") {
				load_page('.app__content', load_url,{page:'subject_pinlun_content', "type": 'subject_pinlun', "p" : p}, '');
				layer_tips(0, data.err_msg);
			} else {
				layer_tips(1, data.err_msg);
			}
		})
	});	
})

//批量删除
$(".js-subject-batch_pinlun-delete").live("click",function(e){
	var disabled_obj = $(this);
	var js_disabled_index = $(".js-disabled").index($(this));
	var jf_id = disabled_obj.closest("td").attr("data");

	if ($('.js-check-toggle:checked').length == 0) {
		layer.alert("请选择需要删除的专题评价！");
		return false;
	}	
    var comment_id = [];
    $('.js-check-toggle:checked').each(function(i){
        comment_id[i] = $(this).val();
    })
    
	button_box($(this), e, 'right', 'confirm', '确定批量删除勾选的专题评论?<br><span class="red">删除后将导致以选择的专题评论无法在微信及商家中心端专题评论中无法显示！</span>', function(){
		$.post(all_subject_pinlun_delete_url, {'id_str': comment_id}, function (data) {
			close_button_box();
			if (data.err_code == "0") {
				load_page('.app__content', load_url,{page:'subject_pinlun_content', "type": 'subject_pinlun', "p" : p}, '');
	
				layer_tips(0, data.err_msg);
				
			} else {
				layer_tips(1, data.err_msg);
			}
		})
	});	
})

//批量隐藏
$(".js-subject-batch_pinlun-disabled").live("click",function(e){
	var disabled_obj = $(this);
	var js_disabled_index = $(".js-disabled").index($(this));

	if ($('.js-check-toggle:checked').length == 0) {
		layer.alert("请选择需要隐藏的专题评价！");
		return false;
	}	
    var comment_id = [];
    $('.js-check-toggle:checked').each(function(i){
        comment_id[i] = $(this).val();
    })
	button_box($(this), e, 'right', 'confirm', '确定批量隐藏勾选的专题评论?<br><span class="red">隐藏后将导致已选择的专题评论无法在微信端专题评论中不显示！</span>', function(){
		$.get(all_subject_pinlun_disabled_url, {'id_str': comment_id}, function (data) {
			close_button_box();
			if (data.err_code == "0") {
				disabled_obj.closest("tr").find(".zt").html("<font color='#f00'>已隐藏</font>");
				$(".js-disabled").eq(js_disabled_index).removeClass("js-disabled").addClass("js-able").html("使显示")
				layer_tips(0, data.err_msg);
			} else {
				layer_tips(1, data.err_msg);
			}
		})
	});	
})

$(function(){
	
	//开始时间
	$('#js-start-time').live('focus', function() {
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-end-time').val() != '') {
					$(this).datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
				}
			},
			onSelect: function() {
				if ($('#js-start-time').val() != '') {
					$('#js-end-time').datepicker('option', 'minDate', new Date($('#js-start-time').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($(this).datepicker('getDate'), $('#js-end-time').datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-end-time').datepicker('getDate'));
				}
			},
			_afterClose: function(date1, date2) {
				var starttime = 0;
				if (date1 != '' && date1 != undefined) {
					starttime = new Date(date1).getTime();
				}
				var endtime = 0;
				if (date2 != '' && date2 != undefined) {
					endtime = new Date(date2).getTime();
				}
				if (endtime > 0 && endtime < starttime) {
					alert('无效的时间段');
					return false;
				}
				return true;
			}
		};
		$('#js-start-time').datetimepicker(options);
	})


	//结束时间
	$('#js-end-time').live('focus', function(){
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-start-time').val() != '') {
					$(this).datepicker('option', 'minDate', new Date($('#js-start-time').val()));
				}
			},
			onSelect: function() {
				if ($('#js-end-time').val() != '') {
					$('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($('#js-start-time').datepicker('getDate'), $(this).datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-start-time').datepicker('getDate'));
				}
			},
			_afterClose: function(date1, date2) {
				var starttime = 0;
				if (date1 != '' && date1 != undefined) {
					starttime = new Date(date1).getTime();
				}
				var endtime = 0;
				if (date2 != '' && date2 != undefined) {
					endtime = new Date(date2).getTime();
				}
				if (starttime > 0 && endtime < starttime) {
					alert('无效的时间段');
					return false;
				}
				return true;
			}
		};
		$('#js-end-time').datetimepicker(options);
	})

	//最近7天或30天
	$('.date-quick-pick').live('click', function(){
		$(this).siblings('.date-quick-pick').removeClass('current');
		$(this).addClass('current');
		var tmp_days = $(this).attr('data-days');
		$('.js-start-time').val(changeDate(tmp_days).begin);
		$('.js-end-time').val(changeDate(tmp_days).end);
	})	
	function changeDate(days){
		var today=new Date(); // 获取今天时间
		var begin;
		var endTime;
		if(days == 3){
			today.setTime(today.getTime()-3*24*3600*1000);
			begin = today.format('yyyy-MM-dd');
			today = new Date();
			today.setTime(today.getTime()-1*24*3600*1000);
			end = today.format('yyyy-MM-dd');
		}else if(days == 7){
			today.setTime(today.getTime()-7*24*3600*1000);
			begin = today.format('yyyy-MM-dd');
			today = new Date();
			today.setTime(today.getTime()-1*24*3600*1000);
			end = today.format('yyyy-MM-dd');
		}else if(days == 30){
			today.setTime(today.getTime()-30*24*3600*1000);
			begin = today.format('yyyy-MM-dd');
			today = new Date();
			today.setTime(today.getTime()-1*24*3600*1000);
			end = today.format('yyyy-MM-dd');
		}
		return {'begin': begin + ' 00:00:00', 'end': end + ' 23:59:59'};
	}

	//格式化时间
	Date.prototype.format = function(format){
		var o = {
			"M+" : this.getMonth()+1, //month
			"d+" : this.getDate(),	//day
			"h+" : this.getHours(),	//hour
			"m+" : this.getMinutes(), //minute
			"s+" : this.getSeconds(), //second
			"q+" : Math.floor((this.getMonth()+3)/3),  //quarter
			"S" : this.getMilliseconds() //millisecond
		}
		if(/(y+)/.test(format)) {
			format=format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
		}
		for(var k in o) {
			if(new RegExp("("+ k +")").test(format)) {
				format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
			}
		}
		return format;
	}	
})
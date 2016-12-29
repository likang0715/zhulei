var upload_image_index = '';
$(function () {
	var is_has_no_pingjias = $(".detail_no").size();
	if(is_has_no_pingjias == 0) {
		$(".js_save").addClass("no_js_save").removeClass("js_save").html("返回");	
	}
	
	$(".no_js_save").live("click",function(){	
		//location.href='order.php?id='+order_store_id;
		location.href="javascript:history.go(-1)"
	})
	
	$("textarea[name='content']").bind("keyup blur", function () {
		var word_count = $(this).val().length;
		if (word_count > 300) {
			$(this).val($(this).val().substr(0, 300));
			word_count = 300;
		}
		
		$(".js-word-number").html(word_count + "/" + 300);
	});
	
	$(".upload_image").change(function () {
		 upload_image_index = $(".upload_image").index($(this));
		
		if ($(".shop_pingjia_list").eq(upload_image_index).find("li").size() == 6) {
			motify.log("最多只能上传5张图片");
			$(this).val('');
			return false;
		}
		
		var file = $(this).val();
		if (file.length == 0) {
			return;
		}
		
		if(!/.(gif|jpg|jpeg|png)$/.test(file)) {
			motify.log("图片类型必须是gif,jpeg,jpg,png中的一种");
			return;
		} else {
			
			$(".upload_image_form").eq(upload_image_index).submit();
		} 
	});
	
	// 删除上传图片
	$(".shop_pingjia_list span").live("click", function () {
		$(this).closest("li").remove();
		uploadImageNumber();
	});

	$(".upload_image_form").ajaxForm({
		beforeSubmit: showRequestUpload,
		success: showResponseUpload,
		dataType: 'json'
	});
	
	var tip_check = false;
	
	// 单个提交评论
	$(".js_save").click(function () {
		
		var indexs = $(".js_save").index($(this));
		if(tip_check) {
			return false;
		}
		tip_check = true;
			
		//var id =  $(".b-list .block-order").eq(iss).attr("data_pro_id");
		var id = $(this).attr("js_submit_proid");
		var pid = $(this).data("pid");
		var type = 'PRODUCT';
		var tag_id_str = "";
		var content = $(".contents"+id).val();
		var score = $("input[name='manyi"+id+"']:checked").val();
		
		if (content.length == 0) {
			$(".contents"+id).focus();
			motify.log("请填写评论内容");
			tip_check = false;
			return;
		}
		
		var images_id_str = "";
		var li_size = $(".shop_pingjia_list"+id+" li").size();
		
		$(".shop_pingjia_list"+id+" li").each(function (i) {
			if (i != li_size - 1) {
				if (images_id_str.length == 0) {
					images_id_str = $(this).data("attachment_id");
				} else {
					images_id_str += "," + $(this).data("attachment_id");
				}
			}
		});

		$.post("comment_add.php", {"id" : id, "pid" : pid, "type" : type, "score" : score, "content" : content, "images_id_str" : images_id_str, "tag_id_str" : tag_id_str}, function (data) {
			tip_check = false;
			try {
				if (data.status == true) {
					$(".js_save").eq(indexs).hide();
					motify.log("评论成功");
					
					$(".b-list li[data_pro_id="+id+"]").find(".upload_image").hide();
					$(".b-list li[data_pro_id="+id+"]").find("textarea").attr("readonly",true);
					$(".b-list li[data_pro_id="+id+"]").find(".ui-checkbox").attr("disabled",true);
					
					$(".b-list li[data_pro_id="+id+"]").find(".updat_pic").hide();
					$(".b-list li[data_pro_id="+id+"]").find(".shop_add").hide();
					$(".b-list li[data_pro_id="+id+"]").find(".prices").html("已评");
					
					if (type == "PRODUCT") {
						if($(".js_save:visible").size() == 0) {
							location.href = "order.php?id=" + order_id + "&action=complete";
						}
					} else {
						//location.href = "home.php?id=" + id;
					}
				} else {
					motify.log(data.msg);
				}
			} catch(e) {
				motify.log("评论失败");
			}
		}, "json");
	});	
})

function showRequestUpload() {
	return true;
}

function showResponseUpload(data) {
	
	try {
		if (data.err_code == "0") {
			var html_upload = '<li data-attachment_id="' + data.err_msg.id + '"><img src="' + data.err_msg.file + '" /><span></span></li>';
			var form_li_html = $(".shop_pingjia_list ul").eq(upload_image_index).last("li").html();
			///$(".shop_pingjia_list ul li").eq(-1).before(html_upload);
			$(".shop_pingjia_list ul").eq(upload_image_index).find("li").eq(-1).before(html_upload);
			$(".upload_image").eq(upload_image).val("");
			uploadImageNumber();
		} else if (data.err_code == "1000") {
			
		} else if (data.err_code == "1001") {
			motify.log(data);
		} else if (data.err_code == "1002") {
			motify.log("上传失败");
		}else if (data.err_code == "1003") {
			motify.log("上传失败");
		}else if (data.err_code == "1004") {
			motify.log("上传失败");
		}
		
	} catch (e) {
		motify.log("上传失败");
		return;
	}
}

function uploadImageNumber() {
	var number = $(".shop_pingjia_list ul").eq(upload_image_index).find("li").size() - 1;
	$(".updat_pic p").eq(upload_image_index).html(number + "/10");
}
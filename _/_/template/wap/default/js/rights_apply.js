$(function(){
	$("#upload_message").click(function () {
		var image_size = $(".image_list li").size();
		if (image_size >= 5) {
			return;
		}
		$("#upload_image").trigger("click");
	});
	
	$(".image_list span").click(function () {
		$(this).closest("li").remove();
		checkImages();
	});
	
	$("#upload_image").change(function () {
		$("#upload_image_form").submit();
	});
	
	$("#upload_image_form").ajaxForm({
		beforeSubmit: showRequestUpload,
		success: showResponseUpload,
		dataType: 'json'
	});
	
	$(".js-save-btn").click(function () {
		$(this).attr("disabled", "disabled");
		var pro_num = $("select[name='pro_num']").val();
		var type = $("select[name='type']").val();
		var phone = $("input[name='phone']").val();
		var content = $("input[name='content']").val();
		
		if (type.length == 0) {
			motify.log("请选择维权类型");
			$(this).removeAttr("disabled");
			return;
		}
		
		if (phone.length == 0) {
			motify.log("请填写手机号");
			$(this).removeAttr("disabled");
			return;
		}
		
		var re = /^\d{6,12}$/;
		if (!re.test(phone)) {
			motify.log("请正确填写手机号");
			$(this).removeAttr("disabled");
			return;
		}
		
		if (content.length == 0) {
			motify.log("请填写维权说明");
			$(this).removeAttr("disabled");
			return;
		}
		
		var data = {};
		data.number = pro_num;
		data.type = type;
		data.phone = phone;
		data.content = content;
		data.images = [];
		data.is_ajax = true;
		
		$(".image_list img").each(function () {
			data.images.push($(this).attr("src"));
		});
		
		$.post("", data, function (result) {
			if (result.err_code == "0") {
				location.href = "rights_detail.php?id=" + result.err_dom;
			} else {
				motify.log(result.err_msg);
				$(".js-save-btn").removeAttr("disabled");
				return;
			}
		})
	});
});

function checkImages() {
	var image_size = $(".image_list li").size();
	if (image_size >= 5) {
		$("#upload_message").hide();
	} else {
		$("#upload_message").show();
	}
}

function showRequestUpload() {
	return true;
}

function showResponseUpload(data) {
	try {
		if (data.err_code == "0") {
			var html_upload = '<li data-attachment_id="' + data.err_msg.id + '"><img src="' + data.err_msg.file + '" /><span></span></li>';
			$(".shop_pingjia_list ul").append(html_upload);
			$("#upload_image").val("");
			checkImages();
		} else if (data.err_code == "1000") {
			
		} else if (data.err_code == "1002") {
			motify.log("上传失败");
		}
		
	} catch (e) {
		motify.log("上传失败");
		return;
	}
}
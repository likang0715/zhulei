$(function () {
	$("select[name='pro_num']").change(function () {
		var num = parsetFloat($(this).val());
		var price = parseFloat($(".js-price").html());
		
		$(".js-total_price").html(num * price);
	});
	
	$("#upload_jiahao").click(function () {
		if ($(".js-image-list").find("li").size() >= 5) {
			tusi("最多只能上传5张图片");
			return;
		}
		$("#upload_image").trigger("click");
	});
	
	$("#upload_image").change(function () {
		$("#upload_image_form").submit();
	});
	
	$("#upload_image_form").ajaxForm({
		beforeSubmit: showRequestUpload,
		success: showResponseUpload,
		dataType: 'json'
	});
	
	$(".js-image-list span").live("click", function () {
		$(this).closest("li").remove();
		uploadImageNumber();
	});
	
	$(".js-submit").click(function () {
		if ($(this).data("type") != "default") {
			tusi("提交中，请稍等");
			return;
		}
		
		$(this).data("type", "submit");
		var content = $("#content").val();
		var type = $(".js-type").val();
		var phone = $("#phone").val();
		var pro_num = $("select[name='pro_num']").val();
		
		if (phone.length == 0) {
			$(this).data("type", "default");
			$("#phone").focus();
			tusi("请填写手机号");
			return;
		}
		
		var re = /^\d{6,12}$/;
		if (!re.test(phone)) {
			$(this).data("type", "default");
			$("#phone").focus();
			tusi("请正确填写手机号");
			return;
		}
		
		if (content.length == 0) {
			$(this).data("type", "default");
			$("#content").focus();
			tusi("请填写维权原因");
			return;
		}
		
		var image_arr = [];
		$(".js-image-list").find("li").each(function () {
			image_arr.push($(this).find("img").attr("src"));
		});
		
		$.post("", {type : type, phone : phone, content : content, image_list : image_arr, number : pro_num, is_ajax : true}, function (data) {
			showResponse(data);
		}, "json")
	});
});

function showRequestUpload() {
	return true;
}

function showResponseUpload(data) {
	try {
		if (data.status == true) {
			var html_upload = '<li data-attachment_id="' + data.data.id + '"><img src="' + data.data.file + '" /><span></span></li>';
			var form_li_html = $(".js-image-list").append(html_upload);
			
			//$("#upload_message").html("添加图片");
			uploadImageNumber();
			$("#upload_image").val("");
		} else {
			showResponse(data);
		}
		
	} catch (e) {
		tusi("上传失败");
		return;
	}
}

function uploadImageNumber() {
	var number = $(".js-image-list").find("li").size();
	$(".updat_pic p").html(number + "/5");
}
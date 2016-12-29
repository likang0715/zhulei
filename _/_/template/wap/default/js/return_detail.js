$(function(){
	$("a[rel=show_img]").fancybox({
		'titlePosition' : 'over',
		'cyclic'		: true,
		'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
			return '';
		}
	});
	
	$(".js-submit-btn").click(function () {
		if ($(this).attr("disabled")) {
			return;
		}
		
		$(this).attr("disabled", "disabled");
		$(this).html("提交中");
		var id = $(this).data("id");
		var express_code = $("select[name='express_code']").val();
		var express_no = $("input[name='express_no']").val();
		
		if (express_code.length == 0) {
			motify.log("请选择快递公司");
			$(this).html("提交");
			$(this).removeAttr("disabled");
			return;
		}
		
		if (express_no.length == 0) {
			motify.log("请填写快递单号");
			$(this).html("提交");
			$(this).removeAttr("disabled");
			return;
		}
		
		$.post("", {express_code : express_code, express_no : express_no, id : id, action : "express"}, function (result) {
			if (result.err_code == 0) {
				motify.log(result.err_msg);
				location.reload();
			} else {
				motify.log(result.err_msg);
				$(".js-submit-btn").html("提交");
				$(".js-submit-btn").removeAttr("disabled");
				return;
			}
		}, "json");
	});
	
	$(".js-express-btn").click(function () {
		var express_detail_obj = $(".express_detail");
		if (express_detail_obj.data("is_has") == "1" && express_detail_obj.find("table").size() > 0 && express_detail_obj.css("display") == "block") {
			express_detail_obj.hide();
			$(".js-express-btn").html("查看物流信息");
			return;
		} else if (express_detail_obj.data("is_has") == "1" && express_detail_obj.find("table").size() > 0 && express_detail_obj.css("display") == "none") {
			express_detail_obj.show();
			$(".js-express-btn").html("关闭物流信息");
			return;
		}
		
		
		
		var type = $(this).data("type");
		var express_no = $(this).data("express_no");
		
		if (type.length == 0 || express_no.length == 0) {
			return;
		}
		
		var express_detail_obj = $(".express_detail");
		express_detail_obj.html("<p>努力查询中</p>");
		express_detail_obj.show();
		
		var url = "express.php?type=" + type + "&express_no=" + express_no;
		$.getJSON(url, function (data) {
			try {
				if (data.status == true) {
					html = '<table><tr><td width="30%">处理时间</td><td>处理信息</td></tr>';
					for(var i in data.data.data) {
						html += "<tr>";
						html += "<td>" + data.data.data[i].time + "</td>";
						html += "<td>" + data.data.data[i].context + "</td>";
						html += "</tr>";
					}
					html += "</table>";
					express_detail_obj.html(html);
					express_detail_obj.data("is_has", 1);
					$(".js-express-btn").html("关闭物流信息");
				} else {
					html = "<p>查寻失败</p>";
					express_detail_obj.html(html);
				}
			}catch(e) {
				html = "<p>查寻失败</p>";
				express_detail_obj.html(html);
			}
		});
	});
});
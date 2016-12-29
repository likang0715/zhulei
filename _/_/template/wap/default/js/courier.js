var packagePage = 1;
var packageIsAjax = false;
$(function(){
	
	FastClick.attach(document.body);
	$(window).scroll(function(){

		if (packagePage > 1 && $(window).scrollTop()/($('.content').height() - $(window).height())>=0.95) {
			if(packageIsAjax == false){
				getPackages();
			}
		}

	});


	function getPackages() {

		var status_action = $(".dist_bottom").find(".active").attr("data-action");
		packageIsAjax = true;
		
		$('.wx_loading2').show();
		$.ajax({
			type:"POST",
			url:'courier_ajax.php?action=package_list',
			data:{status_action:status_action, page:packagePage},
			dataType:'json',
			success:function(result){
				$('.wx_loading2').hide();
				if(result.err_code){
					alert(result.err_msg);
				}else{	
					if (result.err_msg.list.length > 0) {
						var htm = '';
						for (i in result.err_msg.list) {
							htm += "<li>";
							htm +=      "<div class=\"order_txt\">";
							htm +=          "<div class=\"order_title clearfix\">";
							htm +=              "<div class=\"order_num\"><span>订单号：</span><span>"+result.err_msg.list[i].order.order_no+"</span></div>";
							htm +=              "<a href=\"/wap/courier_detail.php?package_id="+result.err_msg.list[i].package_id+"\"><div class=\"order_details\">详情</div></a>";

							if (result.err_msg.list[i].status == 1) {
								// htm += "<div class=\"status_btn js-send\" data-id="+result.err_msg.list[i].package_id+">配送</div>";
								htm += "<div class=\"order_state red\">未配送</div>";
							} else if (result.err_msg.list[i].status == 2) {
								// htm += "<div class=\"status_btn js-arrive\" data-id="+result.err_msg.list[i].package_id+">送达</div>";								
								htm += "<div class=\"order_state yellow\">配送中</div>";								
							} else if (result.err_msg.list[i].status == 3) {
								htm += "<div class=\"order_state blue\">已送达</div>";								
							}

							htm +=          "</div>";
							htm +=          "<div class=\"order_arc clearfix\">";
							htm +=              "<div class=\"order_bd\">地址：<span>";

							htm += 				result.err_msg.list[i].order.address.province+' ';
							htm += 				result.err_msg.list[i].order.address.city+' ';
							htm += 				result.err_msg.list[i].order.address.area+' ';
							htm += 				result.err_msg.list[i].order.address.address;

							htm +=              "</span></div>";
							htm +=              "<a href=/wap/courier_map.php?pigcms_id="+result.err_msg.list[i].package_id+"><i style=\"margin-top: 8px;\"><img src=\""+img_tpl+"/courier_style/images/ps1_03.png\" /></i></a>";
							htm +=          "</div>";
							htm +=          "<div class=\"order_arc clearfix\">";
							htm +=              "<div class=\"order_bd\">电话：<span>"+result.err_msg.list[i].order.address_tel+"</span> </div>";
							htm +=              "<a href=\"tel:"+result.err_msg.list[i].order.address_tel+"\"><i><img src=\""+img_tpl+"/courier_style/images/ps1_07.png\" /></i></a>";
							htm +=          "</div>";
							htm +=      "</div>";
							htm += "</li>";
						}
						var htm = $(htm);
						bindStatus(htm);
						$('.order_list ul').append(htm);		
						if(typeof(result.err_msg.noNextPage) == 'undefined'){
							packageIsAjax = false;
						}else{
							$('#noMoreTips').removeClass('hide');
						}
					} else {
						if(packagePage == 1){
							$('#sNull01').removeClass('hide');
						}else{
							$('#noMoreTips').removeClass('hide');
						}
					}
					packagePage ++;
				}
			},
			error:function(){
				$('.wx_loading2').hide();
			}
		});
	}

	getPackages();

	function bindStatus (obj) {

		obj.find(".js-send").off("click").on("click", function(){
			if (!confirm("开始配送包裹？")) {
				return false;
			}
			var self = $(this);
			var package_id = self.attr("data-id");
			self.unbind("click");
			$.post('./courier_status.php',{package_id:package_id, action:'send'}, function(result){
				if (result.status) {
					window.location.reload();
				} else {
					alert(result.msg);
				}
			},'json');

		});

		obj.find(".js-arrive").off("click").on("click", function(){
			if (!confirm("已经送达了吗？")) {
				return false;
			}
			var self = $(this);
			var package_id = self.attr("data-id");
			self.unbind("click");
			$.post('./courier_status.php',{package_id:package_id, action:'arrive'}, function(result){
				if (result.status) {
					window.location.reload();
				} else {
					alert(result.msg);
				}
			},'json');

		});

	}

});
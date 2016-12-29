function fenlei() {
	$(".fenlei_list").css('display', 'block');
	$('.fenlei_list_ct').height($(window).height()-60);
}
function close_fenlei(){
	$(".fenlei_list").css('display', 'none');
}
function select_size() {
	$(".product_select_size").show();
	$(".content").hide();
}
function return_details() {
	$(".product_select_size").hide();
	$(".content").show();
}
function product_list1(){
	$(".zhuanliebiao_icon1").css('display', 'none');
	$(".zhuanliebiao_icon2").css('display', 'block');
	$("ul.product_list_con_1").attr("className", "product_list_con_2");
}
function product_list2(){
	$(".zhuanliebiao_icon1").css('display', 'block');
	$(".zhuanliebiao_icon2").css('display', 'none');
	$("ul.product_list_con_2").attr("className", "product_list_con_1");
}

$(document).ready(function(){
	
	$('.fenlei_list_ct li').click(function(){
		if($(this).hasClass('a_selected')==false){
			$(this).siblings().removeClass('a_selected');
			$(this).addClass('a_selected');
		}
	});
	$(":radio.tab_c_c_li_r_radio1").click(function(){
		$(".baoxiangmc1_select").removeAttr("disabled");
	})
	$(":radio.tab_c_c_li_r_radio2").click(function(){
		$(".baoxiangmc1_select").attr('disabled','ture');
	})

	$(":radio.tab_c_c_li_r_radio.xs").click(function(){
		$(".input_shichang").removeAttr("disabled");
	})
	$(":radio.tab_c_c_li_r_radio.xser").click(function(){
		$(".input_shichang").attr('disabled','ture');
	})
	$(":radio.tab_c_c_li_r_radio.xsyi").click(function(){
		$(".input_shichang").attr('disabled','ture');
	})
	$('.prod_l_f_shoucang').click(function(){
		$('.prod_l_f_shoucang').hide();
		$('.prod_l_f_shoucang_on').show();
	});
	$('.prod_l_f_shoucang_on').click(function(){
		$('.prod_l_f_shoucang_on').hide();
		$('.prod_l_f_shoucang').show();
	});
	$('.tab_c_c_li_r_radio.dating').click(function(){
		$('.baoxiangmc').hide();
		$('.shiyongsc').hide();
	});
	$('.tab_c_c_li_r_radio.baoxiang').click(function(){
		$('.baoxiangmc').show();
		$('.shiyongsc').show();
	});
})

function resetTabs(obj) {
	$(obj).parent().parent().parent().find(".tab_con").hide();
	$(obj).siblings("li").removeClass("current");
}
function loadTab() {
	$(".tab_con").hide();
	$(".tabs").each(function () {
		$(this).find("li:first").addClass("current");
		$($(this).find("li:first").attr("name")).show();
	});
	$(".tab_con").each(function () {
		$(this).find("div.tab_con").fadeIn();
	});
	$(".tabs li").on("click", function () {
		if ($(this).attr("class") == "current") {
			return;
		} else {
			resetTabs(this);
			$(this).addClass("current");
			$($(this).attr("name")).fadeIn();
		}
	});
}

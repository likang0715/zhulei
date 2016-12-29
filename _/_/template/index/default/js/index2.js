// JavaScript Document


 
$(function() {
	 $(".shiyong1").click(function() {
	     aaa('youhui2','youhui3','youhui1');
       $(this).addClass("shiyong_on").siblings().removeClass("shiyong_on")
    });
    $(".shiyong2").click(function() {
   aaa('youhui1','youhui3','youhui2');
             $(this).addClass("shiyong_on").siblings().removeClass("shiyong_on")
    });
	    
	    $(".shiyong3").click(function() {
	     aaa('youhui1','youhui2','youhui3');
   
             $(this).addClass("shiyong_on").siblings().removeClass("shiyong_on")
    });	 
 
	
	function aaa(sClass1,sClass2,sClass3){
		$('.'+sClass1).hide();
		$('.'+sClass2).hide();
		$('.'+sClass3).show();
	}
});


$(function() {
    $(".youhuiquan_z").click(function() {
        $(this).addClass("xuanzhe_on").siblings().removeClass("xuanzhe_on")
    });

    $(".address_title i").click(function(){
     $(".address_layer,.layer").fadeOut("400");

    })
});

$(function() {
  $('label').click(function(){
    var radioId = $(this).attr('name');
    $('.order_add_list_ul label').removeAttr('class') && $(this).attr('class', 'checked');
    $('.order_add_list_ul input[type="radio"]').removeAttr('checked') && $('#' + radioId).attr('checked', 'checked');
  });
});


$(function() {
	/*
	 $(".youhuiquan_chakan").click(function() {
		 $(".danye_youhi").hide();
		 $(".youhui_list").show();
     });
	 	 $(".youhuiquan_info").click(function() {
		 $(".danye_youhi").hide();
		 $(".youhui_list").show();
     });
     */
	});
	
	$(function() {
	 $(".danye_shop_hot").click(function() {
	 	  var shop_new_index = $(".danye_shop_hot").index($(this));
		 $(".danye_product2").eq(shop_new_index).hide();
		 $(".danye_product1").eq(shop_new_index).show();
     });
	 	 $(".danye_shop_new").click(function() {
	 	  var shop_new_index = $(".danye_shop_new").index($(this));
	 	 
		 $(".danye_product1").eq(shop_new_index).hide();
		 $(".danye_product2").eq(shop_new_index).show();
     });
	});
	
	
$(function() {
    $(".danye_shop_list_title div").click(function() {
        $(this).addClass("rexiao").siblings().removeClass("rexiao")
    });
	
	var sc = document.getElementById("sc");
    if (screen.width < 1500) //获取屏幕的的宽度
    {
        sc.setAttribute("href", "/template/index/default/css/ie8.css"); //设置css引入样式表的路径
        //alert("你的电脑屏幕宽度大于1024，我的宽度是 1200px, 背景色现在是红色。")
		$("#sn-bd").css("width", "1000px");
		$(".sn-container").css("width", "1000px");
		$(".js-preson-footer").css("margin-left", "0px");
    }
});

$(document).ready(function() {
    if ($('.shopping_dingwei').size() > 0) {
        var h = $(".content").offset().left;
        var navH = $(".shopping_dingwei").offset().top - 0;
        $(window).scroll(function() {
            var scroH = $(this).scrollTop();
            if (scroH >= navH) {
                $(" .shopping_dingwei").css({
                    "position": "fixed",
                    "top": "0px",
                    "left": "0"
				 

                });
            } else if (scroH < navH) {
                $(".shopping_dingwei").css({
                    "position": "absolute",
                    "top": "0%",
                    "left": "0"
                });
            }
        })
    }
})
/*
window.onload = function() {
	return;
    var sc = document.getElementById("sc");
    if (screen.width < 1500) //获取屏幕的的宽度
    {
        sc.setAttribute("href", "/template/index/default/css/ie8.css"); //设置css引入样式表的路径
        //alert("你的电脑屏幕宽度大于1024，我的宽度是 1200px, 背景色现在是红色。")
		$("#sn-bd").css("width", "1000px");
		$(".sn-container").css("width", "1000px");
    }
};*/
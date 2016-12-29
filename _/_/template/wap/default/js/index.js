$(function() {
	

	
	
  var width = $(window).width();
  var height = $(window).height();

  //设置分类滚动条
  var cate_he = $(".category_top").height();
  var shop_he = $(".shop_list_hr").height();
  $(".shop_menu").css("height", height - cate_he - shop_he);
  var img_he = $(".product_show img").height();
  var menu_le = $("menu .menu_list ul>li").length;

  
  var menu_li_w = $(" .menu_list ul> li").outerWidth();  
  //menu_li_w = 50;
 // $("menu .menu_list ul").css("width", menu_le * menu_li_w + 30);
  //头部列表
  var menu_list = $(".menu_list ul li").text();
  var menu_ul = [];
  for (var i = 0; i < menu_le; i++) {
	hrefs = $(".menu_list ul li").eq(i).find("a").attr("href");
    menu_ul += "<li><span class='li_class'><a href='"+hrefs+"'>" + $(".menu_list ul li").eq(i).text() + "</a></span></li>";
  }
  $(".menu ul").html(menu_ul);
  $("menu span").click(function() {
	  if($(".menu").is(":hidden")) {
		  $(".span_iss_old").hide();  
	  } else {
		  $(".span_iss_old").show();  
	  }
	  
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
      } else {
        $(this).addClass("active");
      }
      $(".menu").slideToggle(500);
    })
    //收藏.关注
 
  $(".product_show li ia,.product_info span:nth-child(2)").click(function() {
 
	  if ($(this).hasClass("active")) {
		  $(this).removeClass("active");
	  } else {
		  $(this).addClass("active");
	  }
	  return false;
	})
    //下拉
  var order_ul_le = $(".order_select ul li").length;
  var order_ul_li_he = $(".order_select ul li").height()
  var order_ul_he = order_ul_le * order_ul_li_he;

  $(".order_select").toggle(function() {
    $(this).animate({
      height: order_ul_he
    });
	$(".order_select i").addClass("active");
  }, function() {
    if ($(".order_select").height() <= order_ul_li_he) {
      $(this).animate({
        height: order_ul_he
      });$(".order_select i").addClass("active");
    } else {
      $(".order_select").animate({
        height: order_ul_li_he
      });$(".order_select i").removeClass("active");
    }
  })
  $(".order_select ul li").click(function() {
    $(this).addClass("active").first().siblings().removeClass("active");
    $(".order_select ul").prepend($(this));
    $(".order_select").animate({
      height: order_ul_li_he
    });
	$(".order_select i").removeClass("active");
    return false;
  })
  
  //订单列表,购物车
  $(".order_status .reduce").click(function(){
	  var num= parseFloat($(this).next().val());
	  if(num<=0){
		 $(this).parents(".order_list_li li").remove()
		  }
		  else{
	  $(this).next().find("input").val(num-1);
		  }
	  })
    $(".plus").click(function(){
	  var num=parseFloat( $(this).prev().find("input").val());
	  $(this).prev().find("input").val(num+1);
	  
	  })
  //招人代付

   
  //订单列表,购物车,礼物,人数,时间
  $(".ordedr_confirm .reduce").click(function(){
	  var num= parseFloat($(this).next().val());
	  if(num<=1){
 alert("数量不能再减");
		  }
		  else{
	  $(this).next().find("input").val(num-1);
		  }
	  
	  })
 

  //产品信息页
  $(window).scroll(function() {
    if ($(window).scrollTop() > img_he / 4) {
      $(".product_show img").addClass("reduce").removeClass("enlarge");
    } else if ($(window).scrollTop() < img_he / 4) {
      $(".product_show img").addClass("enlarge").removeClass("reduce");
    }
    if ($(window).scrollTop() >= $(document).height() - $(window).height() - 100) {
      $("ul.product_footer").fadeOut(300);
    } else {
      $("ul.product_footer").fadeIn(300);
    }
  });

  //设置
  $('label').click(function() {
    var radioId = $(this).attr('name');
    $('.order_add_list_ul label').removeAttr('class') && $(this).attr('class', 'checked');
    $('.order_add_list_ul input[type="radio"]').removeAttr('checked') && $('#' + radioId).attr('checked', 'checked');
  });

$(".layer").click(function(){
		$(".layer").fadeToggle(200);
	$(".layer_content").fadeToggle(500);
	
	
	})

})
 function pop_layer(){
	$(".layer").fadeToggle(200);
	$(".layer_content").fadeToggle(500);
	
	}
$(function() {
  tab(".activity_title li", ".acticity_list> li", "active");
    myFun.tab(".dTab");
})

function tab(a, b, c) { //a 是点击的目标,,b 是所要切换的目标,c 是点击目标的当前样式
  var len = $(a);
  len.bind("click",
    function() {
      var index = 0;
      $(this).addClass(c).siblings().removeClass(c);
      index = len.index(this); //获取当前的索引
      $(b).eq(index).show().siblings().hide();
      return false;
    }).eq(0).trigger("click"); //浏览器模拟第一个点击
}



var myFun = {
 

    //tab切换一个参数
    tab: function(obj) {
        var tabObj = $(obj);
        tabObj.each(function() {
            var len = tabObj.find('.hd ul li');
            var row = tabObj.find('.bd .row');
            len.bind("click", function() {
                var index = 0;
                $(this).addClass('on').siblings().removeClass('on');
                index = len.index(this);
                row.eq(index).show().siblings().hide();
                return false;
            }).eq(0).trigger("click");
        });
    },



};

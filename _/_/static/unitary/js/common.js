/**
 *
 * @param dom
 * @param url
 * @param param
 * @param cache
 * @param obj
 */
var load_page_cache = [];
function load_page(dom,url,param,cache,obj){

    if(cache!='' && load_page_cache[cache]){
        $(dom).html(load_page_cache[cache]);
        if(obj) obj();
    }else{
        $(dom).html('<div class="w-loading"><b class="w-loading-ico"></b><span class="w-loading-txt">正在努力加载……</span></div>');
        $(dom).load(url+'&t='+Math.random(),param,function(response,status,xhr){
            if(cache!='') load_page_cache[cache]=response;
            if(obj) obj();
        });
    }
}
$(function(){

    // 个人中心下拉
    $(".m-toolbar-myDuobao").hover(function(){
        $(this).addClass("m-toolbar-myDuobao-hover");
    }, function(){
        $(this).removeClass("m-toolbar-myDuobao-hover");
    });

    // 分类下拉效果
    function initDrop (obj) {

        var self = obj;
        var menu = self.find();
        var innerHeight = self.find(".m-catlog-list").height() + 70;

        if (self.hasClass('m-catlog-fold')) {
            self.css({"overflow":"hidden"}).animate({"height":40}, 300);
            self.hover(function(){
                self.stop().animate({
                    "height":innerHeight,
                }, 200);
            }, function(){
                self.stop().animate({
                    "height":40,
                }, 200);
            });
        }

    }

    initDrop($(".m-catlog"));

    $.fn.setAddCart = function(options){

        var self = $(this);
        var defaluts = {
            hasCount:false,
            numClass:".js-input",
            buyClass:".js-quickBuy",
            buyAllClass:".js-buyAll",
            addClass:".js-addToCart",
            minusClass:".js-minus",
            plusClass:".js-plus",
            restClass:".js-restNum",
            redirect:"/",           // 购物车跳转链接
            addCartUrl:"",
        };

        var option = $.extend({}, defaluts, options); //使用jQuery.extend 覆盖插件默认参数
        // console.log(option);return;
        var cart = {

            // 修改准备购买的数量
            changeCount : function (allObj, changeNum) {

                var resetNum = parseInt(allObj.item.data("left_count"));

                // 数量范围控制
                if (changeNum < 1) {
                    changeNum = 1;
                } else if (changeNum > resetNum) {
                    changeNum = resetNum;
                }

                allObj.num.val(changeNum);

                return allObj;
            },

            // 添加到购物车
            addCart : function (allObj, callback) {
                $.post(option.addCartUrl, { id:allObj.item.data('id'), count:allObj.num.val() }, function(data){
                    callback(data);
                },'json');
            },

            // 购买剩余所有
            addAllCart : function (allObj, callback) {
                $.post(option.addCartUrl, { id:allObj.item.data('id'), count:allObj.item.data("left_count") }, function(data){
                    callback(data);
                },'json');
            }

        };

        self.each(function(){

            var item = $(this);
            var allObj = {
                add:item.find(defaluts.addClass),
                buy:item.find(defaluts.buyClass),
                buyAll:item.find(defaluts.buyAllClass),
                num:item.find(defaluts.numClass),
                minus:item.find(defaluts.minusClass),
                plus:item.find(defaluts.plusClass),
                rest:item.find(defaluts.restClass),
                item:item,
            };

            var num;

            // 减
            allObj.minus.click(function(){
                num = parseInt(allObj.num.val()) - 1;
                cart.changeCount(allObj, num);
            });

            // 加
            allObj.plus.click(function(){
                num = parseInt(allObj.num.val()) + 1;
                cart.changeCount(allObj, num);
            });

            // 改
            allObj.num.blur(function(){
                cart.changeCount(allObj, allObj.num.val());
            });

            // 加入购物车
            allObj.add.click(function(){
                cart.addCart(allObj, function(data){
                    if (data.err_code == 0) {
                        refreshMiniCart.init($(".js-miniCart"), miniUrls);
                    } else {
                        dialog.init(function(){},'',data.err_msg);
                    }
                });
            });

            // 立即购买
            allObj.buy.click(function(){
                cart.addCart(allObj, function(data){
                    if (data.err_code == 0) {
                        window.location.href = option.redirect;
                    } else {
                        dialog.init(function(){
                            // window.location.href = option.redirect;
                        },'',data.err_msg);
                    }
                });
            });

            // 购买剩余全部
            allObj.buyAll.click(function(){
                cart.addAllCart(allObj, function(data){
                    if (data.err_code == 0) {
                        window.location.href = option.redirect;
                    } else {
                        dialog.init(function(){
                            // window.location.href = option.redirect;
                        },'',data.err_msg);
                    }
                });
            });

        });


    }

});

/**
 *
 * 悬浮购物车刷新
 *
 * 调用方法: refreshMiniCart.init(shopmini, ajaxurl, hrefurl)
 *
 *
 */
var refreshMiniCart = (function() {

    var btnNum;
    var miniBox;

    var minicart;

    var urls = {
        'ajaxurl':'',
        'catrdelurl':'',
        'hrefurl':'',
    };

    function init (shopmini, miniUrls) {
        if(!shopmini) return;

        minicart = shopmini;
        urls.ajaxurl = miniUrls;

        urls = $.extend({}, urls, miniUrls || {});

        btnNum = shopmini.find(".w-miniCart-btn .w-miniCart-count");
        miniBox = shopmini.find(".js-miniCart-layer");

        refresh();
    }

    function refresh () {

        $.post(urls.ajaxurl, {}, function(data){

            if (data.err_code == 0) {
                miniCartChange(data.err_msg);
            }

        },'json');
    }

    function miniCartChange (listdata) {

        var implodeHtm;

        if (listdata.list.length > 0) {
            implodeHtm = getlisthtm(listdata);
        } else {
            implodeHtm = getnullhtm();
        }

        implodeHtm = bind($(implodeHtm));

        miniBox.html($(implodeHtm));

    }

    function getnullhtm () {
        btnNum.html('<i class="ico ico-arrow-white-solid ico-arrow-white-solid-l"></i>' + '0');
        return $('<ul pro="list" class="w-miniCart-list"><li class="w-miniCart-empty">您的清单中还没有任何商品</li></ul>');
    }

    function getlisthtm (listdata) {

        btnNum.html('<i class="ico ico-arrow-white-solid ico-arrow-white-solid-l"></i>' + listdata.total);

        var list = listdata.list;
        var list_htm = '';
        list_htm = '<div pro="title"><p class="w-miniCart-layer-title"><strong>最近加入的商品</strong></p></div>';
        list_htm += '<ul pro="list" class="w-miniCart-list">';

        for (i in list) {   
            list_htm += '<li class="w-miniCart-item">' + 
                '<div class="w-miniCart-item-pic"><img src="' + list[i].unitary.logopic + '" alt="' + list[i].unitary.name + '" style="width:74px;height:74px;"></div>' +
                '<div class="w-miniCart-item-text">' +
                    '<p><strong>' + list[i].unitary.name + '</strong></p>' +
                    '<p><em>' + list[i].unitary.item_price + '元 × ' + list[i].count + '</em><a class="w-miniCart-item-del js-mini-del" data-cart_id="' + list[i].id + '" href="javascript:void(0);">删除</a>' +
                '</p></div>' +
            '</li>';
        }

        list_htm += '</ul>';
        list_htm += '<div pro="footer" class="w-miniCart-layer-footer">'+
            '<p><strong>共有<b>' + listdata.total + '</b>件商品，金额总计：<em><span>' + listdata.total_price + '</span>元</em></strong></p>'+
            '<p><button class="w-button w-button-main js-go">查看清单并结算</button></p>' +
        '</div>';

        return list_htm;

    }

    function bind ($listhtm) {
        var toCartBtn = $listhtm.find(".js-go");
        var delCartBtn = $listhtm.find(".js-mini-del");

        toCartBtn.click(function(){
            window.location.href = urls.hrefurl;
        });

        delCartBtn.click(function(){
            var self = $(this);
            var mLi = self.closest("li");
            var cart_id = self.data('cart_id');

            $.post(urls.catrdelurl, { type:"cart_del", cart_id:cart_id }, function(data){
                if (data.err_code == 0) {
                    refreshMiniCart.init(minicart, urls.ajaxurl, urls.catrdelurl,urls.hrefurl);
                }
        
            },'json');

        });

        return $listhtm;
    }

    return {
        init : init
    }

})();

/**
 *
 * 购物车的飞入效果
 *
 * 调用方法: clickfiy.init($el, shopcarmenu)
 *
 * @param $el 购物车按钮
 * @param shopcarmenu  飞到哪个元素上
 *
 */
var clickfiy = (function() {

    function init($el, shopcarmenu, type) {
        if(!$el) return;
        if(type) {
            bind($el, shopcarmenu, true)
        }else{
            bind($el, shopcarmenu, false);
        }
    }

    function bind($el, shopcarmenu, bool) {

        $el.on("click",function() {

            if(bool) {

                var shopcarimg = $(".nowshowImg"),
                    shopcarimgsrc = shopcarimg.attr("src"),
                    shopcarimgmTop = shopcarimg.offset().top,
                    shopcarimgsRight = shopcarimg.offset().left,
                    shopcarimgshopcarmenuTop = shopcarmenu.offset().top,
                    shopcarimgshopcarmenuLeft = shopcarmenu.offset().left;
                imgcount(shopcarimgsrc, shopcarimgsRight, shopcarimgmTop, shopcarimgshopcarmenuTop, shopcarimgshopcarmenuLeft)

            }else{
                var img = $(this).parents(".w-goods-ing").find("img"),
                    src = img.attr("src"),
                    mTop = img.offset().top,
                    sRight = img.offset().left,
                    shopcarmenuTop = shopcarmenu.offset().top,
                    shopcarmenuLeft = shopcarmenu.offset().left;
                imgcount(src, sRight, mTop, shopcarmenuTop, shopcarmenuLeft)
            }

        });
    }



    function imgcount(src, sRight, mTop, shopcarmenuTop, shopcarmenuLeft) {
        var newimg = $("<img />");
        newimg.attr({
            src: src,
            width : 200,
            height : 200
        });
        newimg.css({
            position: "absolute",
            left : sRight,
            top : mTop,
            "z-index" : 9999
        });

        newimg.appendTo("body");

        newimg.animate({
            top : shopcarmenuTop,
            left : shopcarmenuLeft,
            width : 0,
            height : 0
        }, 1000, function() {
            newimg.remove();
        });
    }

    return {
        init : init
    }
})();


/**
 *
 * 滚动后导航条跟随及下拉列表收缩相关操作
 *
 * 调用方法: scrollnav.init($el, $tragele)
 *
 * @param $el 需要浮动的元素
 * @param $tragele  飞到哪个元素上
 *
 */
var scrollnav = (function () {

    function init($el, $tragele){
        $(document).on("scroll",function() {
            var mTop = $tragele.offset().top,
                sTop = $(window).scrollTop(),
                result = mTop - sTop,
                $catlog = $(".m-catlog-normal");

            if(result < 0){
                $(".m-catlog-list").slideUp(300, function(){
                    $(".m-catlog-wrap").hide();
                });

                $el.addClass("g-header-fixed-m-nav");
                $(".w-miniCart").addClass("m-shopcar-main-nav");

                $catlog.on("mouseenter", function() {
                    $(".m-catlog-wrap").show();
                    $(".m-catlog-list").slideDown(300);
                });

                $catlog.on("mouseleave", function() {
                    $(".m-catlog-list").slideUp(300, function () {
                        $(".m-catlog-wrap").hide();
                    });
                });
            } else if(result >= 0) {
                $(".m-catlog-wrap").show();
                $el.removeClass("g-header-fixed-m-nav")
                $(".w-miniCart").removeClass("m-shopcar-main-nav");
                $(".m-catlog-list").slideDown(300);

                $catlog.off("mouseenter");
                $catlog.off("mouseleave");
            }
        });
    }

    return {
        init : init
    }
})();



/**
 *
 * 点击切换图片效果
 *
 * 调用方法: imghover.init()
 *
 *
 */
var imghover = (function() {
    function init(){
        $(".w-gallery-thumbnail-item").on("mouseenter", function () {
            $(".w-gallery-picture").find("img").attr("src", $(this).find("img").attr("src"));
            $(this).addClass("w-gallery-thumbnail-item-selected").siblings("li").removeClass("w-gallery-thumbnail-item-selected");
            $(".w-gallery .ico-arrow").css({
                left : 31 + ($(this).index() * 12) + ($(this).index() * 70) + ($(this).index() * 3)
            });
        });
    }

    return {
        init : init
    }
})();



/**
 *
 * 图片自动向上滚动
 *
 * 调用方法: imgup.init()
 *
 *
 */

var imgup = (function() {

    function init($el) {
        var $imgli = $el.find("li"),
            imglen = $imgli.length;

        bind($el, $imgli, imglen);
    }

    function bind($el, $imgli, imglen){
        var timer = settime($el);
        $el.on("mouseenter", function() {
            clearInterval(timer);
        })

        $el.on("mouseleave", function() {
            timer = settime($el);
        })
    }

    function settime($el) {
        var timer = setInterval(function() {
            $el.animate({
                "margin-top" : "-96px"
            },function() {
                var html = $el.find("li").first();
                $el.append(html);
                $el.css("margin-top", 0);
            });
        }, 1000);

        return timer;
    }



    return {
        init : init
    }
})();


/**
 *
 * 确认框，有确认取消按钮
 *
 * 调用方法: dialog.init(success[, err][, msg])
 *
 * @param success 点击确认后的回调
 * @param err  点击取消后的回调 -- 可不传
 *
 */
var dialog = (function() {
    function init(suss, err, msg) {

        bind(suss, err, msg);
    }

    function bind(suss, err, msg) {
        var nowwidth = $(window).width(),
            nowheight = $(window).height();
        var msg = msg ? msg : '确定要删除商品吗？';

        var html = '<div class="w-mask" id="pro-view-32"></div><div class="w-msgbox" tabindex="0" id="pro-view-25" style="top: '+ (nowheight - 193)/ 2 +'px; left: '+ (nowwidth - 502)/ 2 +'px;"><a pro="close" href="javascript:void(0);" class="w-msgbox-close">×</a>' +
            '<div class="w-msgbox-hd" pro="header">提示</div><div class="w-msgbox-bd" pro="entry"><p style="text-align: center;">'+msg+'</p></div><div pro="footer" class="w-msgbox-ft">' +
            '<button class="w-button w-button-main" type="button" id="pro-view-26"><span>确定</span></button><button class="w-button w-button-aside" type="button" id="pro-view-27"><span>取消</span></button></div></div>'
        $("body").append(html);

        $(".w-button-main").on("click",function() {
            $(".w-mask").remove();
            $(".w-msgbox").remove();
            suss();
        });

        $(".w-msgbox-close").on("click",function() {
            $(".w-mask").remove();
            $(".w-msgbox").remove();
        });

        $(".w-button-aside").on("click", function() {
            $(".w-mask").remove();
            $(".w-msgbox").remove();
            if(err) err();

        });
    }

    return {
        init : init
    }
})();



/**
 *
 * 购物列表悬浮
 *
 * 调用方法: menushow.init($el, $menuel)
 *
 * @param $el 事件目标
 * @param $menuel 哪个元素被隐藏
 *
 */
var menushow = (function() {
    function init($el, $menuel) {
        $el.on("mouseenter", function() {
            $menuel.show();
        });

        $el.on("mouseleave", function() {
            $menuel.hide();
        });
    }

    return {
        init : init
    }

})();



var runtime = (function() {

    function init($el){

        bind($el);
    }

    function bind($el) {

        downtime($el);
        var timer = setInterval(function() {
            downtime($el);
        }, 1000)
    }

    function downtime($el) {
        var jstimer = $(".jstimer");
        for(var i = 0, j = $el.length; i < j; i++) {
            jstimer.eq(i).attr("data-countdown", parseInt(jstimer.eq(i).attr("data-countdown")) - 1)
            if(jstimer.eq(i).attr("data-countdown") == 0) {
                window.location.href = window.location.href;
            }
            var time = formatSeconds(jstimer.eq(i).attr("data-countdown"));
            var html = "";
            for(var k = 0; k < time.split("").length; k++) {
                if(time.split("")[k] == ":") {
                    html += ":"
                }else{
                    html += '<b>'+ time.split("")[k] +'</b>'
                }
            }
            jstimer.eq(i).html(html);
        }
    }

    function formatSeconds(value) {    // 倒计时
        var theTime = parseInt(value);
        var theTime1 = 0;
        var theTime2 = 0;
        if(theTime > 60) {
            theTime1 = parseInt(theTime/60);
            theTime = parseInt(theTime%60);
            if(theTime1 > 60) {
                theTime2 = parseInt(theTime1/60);
                theTime1 = parseInt(theTime1%60);
            }
        }


        var result = "";

        if(theTime2 > 0) {
            if(theTime2 >= 10) {
                result += theTime2 + ":";
            }else{
                result += "0" + theTime2 + ":";
            }
        }else{
            result +=  "00:";
        }

        if(theTime1 > 0) {
            if(theTime >= 10) {
                result += theTime1 + ":";
            }else{
                result += "0" + theTime1 + ":";
            }
        }else{
            result += "00:";

        }

        if(theTime > 0) {
            if(theTime >= 10) {
                result += theTime;
            }else{
                result += "0"+theTime;
            }
        }else{
            result += "00";
        }
        return result;
    }


    return {
        init : init,
        formatSeconds : formatSeconds
    }
})();


/**
 *
 * 资源懒加载
 *
 * 调用方法: $(el).lazyLoad( {callback : callbackFN} );
 *
 * @param el 事件目标
 * @param callback 回调函数，可不传
 *
 * 注意！！！
 *     在需要懒加载的元素上加入data-src，data-src里为需要加载的图片，src里放需要尚未被用户看到时展现图片
 *
 */
(function($){
    $.fn.lazyLoad = function(options){
        var defaultConf = {
            container: $(window),
            prop: 'data-src',
            callback: null
        };

        var conf = $.extend({}, defaultConf, options || {});
        conf.cache = [];

        this.each(function(ele){
            var data = {
                obj: $(this),
                src: $(this).attr(conf.prop)
            };
            conf.cache.push(data);
        });

        var callback = function(ele){
            if($.isFunction(conf.callback)){
                conf.callback.call(ele);
            }
        };

        var loading = function(){
            var container = conf.container,
                containerHeight = container.height(),
                containerTop = 0;

            if(container[0] === window){
                containerTop = $(window).scrollTop();
            }else{
                containerTop = container.offset().top;
            }

            $.each(conf.cache, function(index, data){
                var o = data.obj,
                    src = data.src,
                    post = 0,
                    postb =0;
                if(o){
                    post = o.offset().top - containerTop;
                    postb = post + o.height();

                    if((post >= 0 && post < containerHeight) || (postb > 0 && postb <= containerHeight)){
                        callback(o.attr('src', src));
                        data.obj = null;
                    }
                }
            });
        };
        loading();
        conf.container.on('scroll', loading);
        return this;
    };
})(jQuery);

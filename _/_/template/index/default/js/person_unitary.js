// JavaScript Document

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

        var html = $(html);

        $("body").append(html);

        html.find(".w-button-main").click(function() {
            $(".w-mask").remove();
            $(".w-msgbox").remove();
            suss();
        });

        html.find(".w-msgbox-close").click(function() {
            $(".w-mask").remove();
            $(".w-msgbox").remove();
        });

        html.find(".w-button-aside").click( function() {
            $(".w-mask").remove();
            $(".w-msgbox").remove();
            if(err) err();

        });
    }

    return {
        init : init
    }
})();

var page_content = '';
var status = '';

$(function(){

    var select_tab = $(".js-tab-list .tab-act");

    if (select_tab.data('status') == 'order') {
        page_content = 'unitary_order';
        status = '';
    } else if (select_tab.data('status') == 'reveal' || select_tab.data('status') == 'ing' || select_tab.data('status') == 'end' || select_tab.data('status') == 'all') {
        page_content = 'unitary_list';
        status = select_tab.data('status');
    }

    load_page('.unitary_con', load_url, {'page': page_content, 'status': status}, '', function(){});

    // tab 头部列表
    $(".js-tab-list .item-tab a").bind("click", function(){

        var self = $(this).closest(".item-tab");
        self.parent().find(".tab-act").removeClass("tab-act").end().end().addClass("tab-act");

        var select_tab = self;

        if (select_tab.data('status') == 'order') {
            page_content = 'unitary_order';
            status = '';
        } else if (select_tab.data('status') == 'reveal' || select_tab.data('status') == 'ing' || select_tab.data('status') == 'end' || select_tab.data('status') == 'all') {
            page_content = 'unitary_list';
            status = select_tab.data('status');
        }

        load_page('.unitary_con', load_url, {'page': page_content, 'status': status}, '', function(){});

    });

    // 查看夺宝号码
    $(".js-viewCode").live("click", function(){
        var self = $(this);
        var count = self.data('count');
        var lucknum_str = '<p style="text-align:left">您本期共参与了</p>'+count+'人次 <br><hr>'+self.data("lucknum");
        dialog.init(function(){}, '', lucknum_str);

    });

})
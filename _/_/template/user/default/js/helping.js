/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark, page){
    var mark_arr = mark.split('/');

    switch(mark_arr[0]){
        case '#create':
            load_page('.app__content', load_url, {page : 'helping_add' }, '');
            break;
        case "#edit":
            if(mark_arr[1]){
                load_page('.app__content', load_url,{page:'helping_edit', id : mark_arr[1]},'',function(){
                });
            }else{
                layer.alert('非法访问！');
                location.hash = '#list';
                location_page('');
            }
            break;
        case "#all" :
            load_page('.app__content', load_url, {page : 'helping_list', "p" : page}, '');
            break;
        case "#future" :
            action = "future";
            load_page('.app__content', load_url, {page : 'helping_list', "type" : action, "p" : page}, '');
            break;
        case "#on" :
            action = "on";
            load_page('.app__content', load_url, {page : 'helping_list', "type" : action, "p" : page}, '');
            break;
        case "#end" :
            action = "end";
            load_page('.app__content', load_url, {page : 'helping_list', "type" : action, "p" : page}, '');
            break;
        case "#log" :
            if(mark_arr[1]){
                load_page('.app__content', load_url,{page:'helping_log', id : mark_arr[1]},'',function(){
                });
            }else{
                layer.alert('非法访问！');
                location.hash = '#list';
                location_page('');
            }
            break;
        default :
            load_page('.app__content', load_url, {page : 'helping_list' }, '');
    }
}
$(function(){


    location_page(location.hash, 1)

    //筛选
    $(".js-list-filter-region a").live('click', function () {
        var action = $(this).attr("href");
        location_page(action, 1);
    });

    //回车提交搜索
    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.js-helping-keyword').is(':focus')) {
            var keyword = $('.js-helping-keyword').val();
            var type = window.location.hash.substring(1);

            load_page('.app__content',load_url,{ page:'helping_list' , 'keyword':keyword , 'type' : type },'');
        }
    });

    // 分页
    $(".js-list_page a").live("click", function () {
        var page = $(this).data("page-num");
        var keyword = $(".js-list-search").data("keyword");

        load_page('.app__content', load_url, {page : 'helping_list', keyword : keyword, p : page}, '', function() {

        });
    });

    //添加聚力活动
    $(".btn-helping-add").live("click",function(){
        var type = window.location.hash.substring(1);

        load_page('.app__content',load_url,{ page:'helping_add' , 'type' : type },'');
    })

    //修改聚力活动
    $(".js-helping-edit").live("click",function(){
        location_page($(this).attr("href"));
    })

    // 取消
    $(".js-btn-quit").live("click", function () {
        load_page('.app__content', load_url, {page : 'helping_list' }, '');
    })

    //微信预览图添加
    $('.js-add-wxpic').live('click',function(){
        var $_this = $(this);
        upload_pic_box(1,true,function(pic_list){

            if (pic_list.length == 0) {
                layer_tips(1, "请先上传图片");
                return false;
            }

            for(var i in pic_list){
                $_this.parents("ul:first").prepend('<li class="sort"><a href="javascript:void(0)"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
                $("input[id='wxpic']").val(pic_list[i]);
                $_this.parent().hide();
            }
        }, 1);
    });

    //宣传图片添加
    $('.js-add-newspic').live('click',function(){
        var $_this = $(this);
        upload_pic_box(1,true,function(pic_list){

            if (pic_list.length == 0) {
                layer_tips(1, "请先上传图片");
                return false;
            }

            for(var i in pic_list){
                $_this.next('input').val(pic_list[i]);
                $_this.parents("ul:first").prepend('<li class="sort"><a href="javascript:void(0)"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
                $_this.parent().hide();
            }
        }, 1);
    });

    // 删除活动背景图片
    $(".js-delete-picture").live("click", function () {
        var self = $(this);
        // 显示 +图片 +产品 按钮
        self.parent('li').siblings('li').show();
        self.closest("li").remove();
        btn.parent().show();
    });

    function prize_check(){
        var result = new Array();
        result[0] = 0;
        $('.prize_select').each(function(i, n){
            key = i + 1;
            type = $('#prize_type_'+key).val();
            content = $('#prize_title_'+key).val();
            /*if(type==''){
                result[0] = 1;
                result[1] = "1等奖奖品内容设置不正确";
                return result;
            };*/
            if(content=='' || content==0){
                result[0] = 1;
                result[1] = key + '等奖奖品内容设置不正确';
                return result;
            };
            return result;
        });
        return result;
    }

    function news_check(){
        var result = 0;
        $('input[name="news_imgurl"]').each(function(i, n){
            if($(n).val()==''){
                result = 1;
            }
        });
        $('input[name="news_title"]').each(function(i, n){
            if($(n).val()==''){
                result = 2;
            }
        });
        return result;
    }

    //点击执行保存
    $(".js-btn-add").live("click", function () {
        var title = $("#title").val();
        var start_time = $("#js-start-time").val();
        var end_time = $("#js-end-time").val();
        var wxtitle = $("#wxtitle").val();
        var wxinfo = $("#wxinfo").val();
        var wxpic = $("#wxpic").val();
        var guize = $("#guize").val();
        var rank_num = parseInt($("#rank_num").val());
        var prizecode = $("#prizecode").val();
        var hash = $("#hash").val();

        var prize_type = $("input[name='prize_type']").serialize();
        var prize_imgurl = $("input[name='prize_imgurl']").serialize();
        var prize_title = $("input[name='prize_title']").serialize();

        var news_imgurl = $("input[name='news_imgurl']").serialize();
        var news_title = $("input[name='news_title']").serialize();

        var is_attention = $("input[name='is_attention']:checked").val();
        var is_help = $("input[name='is_help']:checked").val();
        var is_open = $("input[name='is_open']:checked").val();


        if (title.length == 0) {
            layer_tips(1, '活动名称没有填写，请填写');
            return false;
        };
        if (start_time.length == 0) {
            layer_tips(1, '活动开始时间没有填写，请填写');
            return false;
        };
        if (end_time.length == 0) {
            layer_tips(1, '活动结束时间没有填写，请填写');
            return false;
        };
        if (wxtitle.length == 0) {
            layer_tips(1, '微信分享标题没有填写，请填写');
            $("#wxtitle").focus();
            return false;
        };
        if (wxinfo.length == 0) {
            layer_tips(1, '微信分享描述没有填写，请填写');
            $("#wxinfo").focus();
            return false;
        };
        if (wxpic.length == 0) {
            layer_tips(1, '微信分享图片没有上传，请上传');
            $("#wxpic").focus();
            return false;
        };
        if (guize.length == 0) {
            layer_tips(1, '活动规则没有填写，请填写');
            $("#guize").focus();
            return false;
        };
        if (isNaN(rank_num) || rank_num==0) {
            layer_tips(1, '排行榜设置不正确，请填写');
            $("#rank_num").focus();
            return false;
        };
        //添加奖品验证
        var result = prize_check();
        if(result[0]==1){
            layer_tips(1, result[1]);
            return false;
        };
        //宣传标题验证
        var news_result = news_check();
        if(news_result==1){
            layer_tips(1, '宣传图片没有填写');
            return false;
        }else if(news_result==2){
            layer_tips(1, '宣传标题没有填写');
            return false;
        };

        $.post(do_helping_add,{
                "title" : title,
                "start_time" : start_time,
                "end_time" : end_time,
                "wxtitle" : wxtitle,
                "wxinfo" : wxinfo,
                "wxpic" : wxpic,
                "guize" : guize,
                "prize_type" : prize_type,
                "prize_imgurl" : prize_imgurl,
                "prize_title" : prize_title,
                "news_imgurl" : news_imgurl,
                "news_title" : news_title,
                "rank_num" : rank_num,
                "prizecode" : prizecode,
                "is_attention" : is_attention,
                "is_help" : is_help,
                "is_open" : is_open,
                "hash" : hash
            }, function (data) {
                if (data.err_code == '0') {
                    layer_tips(0, data.err_msg);
                    var t = setTimeout(presentList(), 2000);
                    return;
                } else {
                    layer_tips(1, data.err_msg);
                    return;
                }
        });
    });

    //点击执行编辑保存
    $(".js-btn-edit").live("click", function () {
        var id = $("#id").val();
        var title = $("#title").val();
        var start_time = $("#js-start-time").val();
        var end_time = $("#js-end-time").val();
        var wxtitle = $("#wxtitle").val();
        var wxinfo = $("#wxinfo").val();
        var wxpic = $("#wxpic").val();
        var guize = $("#guize").val();
        var rank_num = parseInt($("#rank_num").val());
        var prizecode = $("#prizecode").val();
        var hash = $("#hash").val();

        var prize_id = $("input[name='prize_id']").serialize();
        var prize_type = $("input[name='prize_type']").serialize();
        var prize_imgurl = $("input[name='prize_imgurl']").serialize();
        var prize_title = $("input[name='prize_title']").serialize();

        var news_id = $("input[name='news_id']").serialize();
        var news_imgurl = $("input[name='news_imgurl']").serialize();
        var news_title = $("input[name='news_title']").serialize();

        var is_attention = $("input[name='is_attention']:checked").val();
        var is_help = $("input[name='is_help']:checked").val();
        var is_open = $("input[name='is_open']:checked").val();


        if (title.length == 0) {
            layer_tips(1, '活动名称没有填写，请填写');
            return false;
        };
        if (start_time.length == 0) {
            layer_tips(1, '活动开始时间没有填写，请填写');
            return false;
        };
        if (end_time.length == 0) {
            layer_tips(1, '活动结束时间没有填写，请填写');
            return false;
        };
        if (wxtitle.length == 0) {
            layer_tips(1, '微信分享标题没有填写，请填写');
            $("#wxtitle").focus();
            return false;
        };
        if (wxinfo.length == 0) {
            layer_tips(1, '微信分享描述没有填写，请填写');
            $("#wxinfo").focus();
            return false;
        };
        if (wxpic.length == 0) {
            layer_tips(1, '微信分享图片没有上传，请上传');
            $("#wxpic").focus();
            return false;
        };
        if (guize.length == 0) {
            layer_tips(1, '活动规则没有填写，请填写');
            $("#guize").focus();
            return false;
        };
        if (isNaN(rank_num) || rank_num==0) {
            layer_tips(1, '排行榜设置不正确，请填写');
            $("#rank_num").focus();
            return false;
        };
        //添加奖品验证
        var result = prize_check();
        if(result[0]==1){
            layer_tips(1, result[1]);
            return false;
        };
        //宣传标题验证
        var news_result = news_check();
        if(news_result==1){
            layer_tips(1, '宣传图片没有填写');
            return false;
        }else if(news_result==2){
            layer_tips(1, '宣传标题没有填写');
            return false;
        };

        $.post(do_helping_edit,{
            "id" : id,
            "title" : title,
            "start_time" : start_time,
            "end_time" : end_time,
            "wxtitle" : wxtitle,
            "wxinfo" : wxinfo,
            "wxpic" : wxpic,
            "guize" : guize,
            "prize_id" : prize_id,
            "prize_type" : prize_type,
            "prize_imgurl" : prize_imgurl,
            "prize_title" : prize_title,
            "news_id" : news_id,
            "news_imgurl" : news_imgurl,
            "news_title" : news_title,
            "rank_num" : rank_num,
            "prizecode" : prizecode,
            "is_attention" : is_attention,
            "is_help" : is_help,
            "is_open" : is_open,
            "hash" : hash
        }, function (data) {
            if (data.err_code == '0') {
                layer_tips(0, data.err_msg);
                var t = setTimeout(presentList(), 2000);
                return;
            } else {
                layer_tips(1, data.err_msg);
                return;
            }
        });
    });

    function presentList() {
        location.href = "user.php?c=helping&a=helping_index";
    }

    //预览浮层
    $(".js_show_ewm").live("click",function(e) {
        event.stopPropagation();
        var dom = $(this);
        var dom_offset = dom.offset();

        var id = dom.data("id");
        var store_id = dom.data("store_id");
        var qrcode_url = lottery_qrcode_url + "&id=" + id + "&store_id=" + store_id;
        var htmls = "";
        htmls += '<div class="popover bottom" style="">';
        htmls += '	<div class="arrow"></div>';
        htmls += '	<div style="width:120px;" class="popover-inner">';
        htmls += '		<div class="popover-content">';
        htmls += '			<div class="form-inline">';
        htmls += '				<div class="input-append"><img width="100" height="100" src="' + qrcode_url + '"></div>';
        htmls += '			</div>';
        htmls += '		</div>';
        htmls += '	</div>';
        htmls += '</div>';
        $('body').append(htmls);

        var popover_height = $('.popover').height();
        var popover_width = $('.popover').width();

        $('.popover').css({top: dom_offset.top + dom.height()-3, left: dom_offset.left - (popover_width/2) + (dom.width()/2)});

        $('.popover').click(function(e) {
            e.stopPropagation();
        });

        $('body').bind('click',function() {
            $(".popover").remove();
        });
    });

    //开始时间
    $('#js-start-time').live('focus', function() {
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-end-time').val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-start-time').val() != '') {
                    $('#js-end-time').datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($(this).datepicker('getDate'), $('#js-end-time').datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-end-time').datepicker('getDate'));
                }
            },
            _afterClose: function(date1, date2) {
                var starttime = 0;
                if (date1 != '' && date1 != undefined) {
                    starttime = new Date(date1).getTime();
                }
                var endtime = 0;
                if (date2 != '' && date2 != undefined) {
                    endtime = new Date(date2).getTime();
                }
                if (endtime > 0 && endtime < starttime) {
                    alert('无效的时间段');
                    return false;
                }
                return true;
            }
        };
        $('#js-start-time').datetimepicker(options);
    })

    //结束时间
    $('#js-end-time').live('focus', function(){
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-start-time').val() != '') {
                    $(this).datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-end-time').val() != '') {
                    $('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($('#js-start-time').datepicker('getDate'), $(this).datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-start-time').datepicker('getDate'));
                }
            },
            _afterClose: function(date1, date2) {
                var starttime = 0;
                if (date1 != '' && date1 != undefined) {
                    starttime = new Date(date1).getTime();
                }
                var endtime = 0;
                if (date2 != '' && date2 != undefined) {
                    endtime = new Date(date2).getTime();
                }
                if (starttime > 0 && endtime < starttime) {
                    alert('无效的时间段');
                    return false;
                }
                return true;
            }
        };
        $('#js-end-time').datetimepicker(options);
    });

    var newsnum = 1;
    //添加宣传图片
    $('.js-add-news').live('click',function(){
        if(newsnum>5){
            layer_tips(1, '最多能添加6个宣传图片！');
        }else{
            newsnum++;
            var news_html = '<div class="control-group news_imgurl"><label class="control-label"><em class="required"> *</em>宣传图片'+newsnum+'：</label><div class="controls" style="margin-left:30px;" id="div_win_limits"><ul class="ico app-image-list js-logo"><li><a href="javascript:;" class="add-goods js-add-newspic" classname="backgroundThumImage">上传</a><input type="hidden" name="news_imgurl" value="" id="backgroundThumImage"></li></ul></div><span style="color: red;">&nbsp;推荐尺寸：900*500&nbsp;请让每个宣传图片的尺寸相同！否则会导致页面错位！</span></div><div class="control-group news_title"><label class="control-label"><em class="required"> *</em>宣传标题'+newsnum+'：</label><div class="controls" style="margin-left:30px;" id="div_win_limits"><input type="text" id="news_title_1" name="news_title"></div></div>';
            $('.news_title').last().after(news_html);
        }

    });

    //删除宣传图片
    $('.js-delete-news').live('click',function(){
        if(newsnum > 1){
            newsnum--;
            $('.news_title').last().detach();
            $('.news_imgurl').last().detach();
        }else{
            alert('必须有一个宣传图片');
        }
    });

    //查看领奖纪录
    $('.js-log').live('click',function(){
        location_page($(this).attr("href"));
    });

    var prizenum = 1;
    //添加奖品
    $('.js-add-prize').live('click',function(){
        if(prizenum>5){
            layer_tips(1, '最多能添加6个商品！');
        }else{
            prizenum++;
            var prize_html = '<div class="control-group prize_select">'+
                '<span style="float:left;font-size:16px;color:#4cae4c">&nbsp;&nbsp;'+prizenum+'等奖</span>'+
                '<label class="control-label" style="margin-left:-50px;">'+
                '奖品类型：'+
                '</label>'+
                '<div class="controls">'+
                    '<select id="prize_1" class="prize_type" name="type" data-id="'+prizenum+'">'+
                        '<option value="0">选择奖品</option>'+
                        '<option value="1">商品</option>'+
                        '<option value="2">优惠券</option>'+
                        '<option value="3">店铺积分</option>'+
                        '<option value="4">其他</option>'+
                    '</select>'+
                    '<input type="hidden" name="prize_type" id="prize_type_'+prizenum+'" value=""/>'+
                    '<input type="hidden" name="prize_title" id="prize_title_'+prizenum+'" value=""/>'+
                    '<input type="hidden" name="prize_imgurl" id="prize_imgurl_'+prizenum+'" value=""/>'+
                '</div>'+
            '</div>'+

            '<div class="control-group prize_content">'+
                '<div class="control-group" style="display: none;" id="div_product_select_'+prizenum+'">'+
                            '<label class="control-label">'+
                                '<em class="required"> *</em>选择商品：'+
                            '</label>'+
                            '<div class="controls">'+
                                '<ul class="ico app-image-list js-product_'+prizenum+'" data-product_id="0">'+
                                    '<li><a href="javascript:void(0)"data-key="'+prizenum+'" class="add-goods js-add-picture">选商品</a></li>'+
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                        '<div class="control-group" style="display:none;" id="div_coupon_select_'+prizenum+'">'+
                            '<label class="control-label">&nbsp;</label>'+
                            '<div class="controls">'+
                                '<select class="js-reward-coupon" data-key="'+prizenum+'" id="coupon_'+prizenum+'" style="width: 180px;">'+
                                    '<option value="0">请选择优惠券</option>'+ coupon_list_select +
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<label class="control-label">'+
                            '<em class="required"> *</em>奖品：'+
                        '</label>'+
                        '<div class="controls">'+
                            '<input type="text" id="product_name_'+prizenum+'" data-key="'+prizenum+'" class="js-reward-imgurl">'+
                                '<input type="text" style="display:none;width:100px;" id="product_recharge_'+prizenum+'" data-key="'+prizenum+'" class="js-reward-title">'+
                                '</div>'+
                            '</div>';
            $('.prize_content').last().after(prize_html);
        };
    });

    //删除奖品
    $('.js-delete-prize').live('click',function(){
        if(prizenum > 1){
            prizenum--;
            $('.prize_select').last().detach();
            $('.prize_content').last().detach();
        }else{
            layer_tips(1, '必须有一个奖品！');
        }
    });

    // 奖品切换
    $('.prize_type').live('change',function(){
        $_this = $(this);
        var option = $_this.val();
        var key = $_this.attr('data-id');
        $('#prize_type_'+key).val(option);
        //清理信息
        $('#prize_title_'+key).val('');
        $('#prize_imgurl_'+key).val('');
        $('#product_recharge_'+key).val('');
        $('#coupon_'+key).val('');
        $('.js-product_'+key+' .sort').remove();
        $('.js-product_'+key+' li').show();
        if(option==1){
            // 商品
            $('#div_product_select_'+key).show();
            $('#div_coupon_select_'+key).hide();
            $('#product_recharge_'+key).hide();
            $('#product_name_'+key).val();

            $('#product_name_'+key).val('商品');
            $('#product_name_'+key).attr('readonly',true);
        }else if(option==2){
            // 优惠券
            $('#div_product_select_'+key).hide();
            $('#div_coupon_select_'+key).show();
            $('#product_recharge_'+key).hide();

            $('#product_name_'+key).val('优惠券');
            $('#product_name_'+key).attr('readonly',true);
        }else if(option==3){
            $('#div_product_select_'+key).hide();
            $('#div_coupon_select_'+key).hide();
            $('#product_recharge_'+key).show();

            $('#product_name_'+key).val('店铺积分');
            $('#product_name_'+key).attr('readonly',true);
        }else if(option==4){
            $('#div_product_select_'+key).hide();
            $('#div_coupon_select_'+key).hide();
            $('#product_recharge_'+key).show();

            $('#product_name_'+key).val('其他奖品');
            $('#product_name_'+key).attr('readonly',true);
        }else{
            $('#div_product_select_'+key).hide();
            $('#div_coupon_select_'+key).hide();
            $('#product_recharge_'+key).hide();

            $('#product_name_'+key).val('选择奖品');
            $('#product_name_'+key).attr('readonly',true);
        }
    });

    //奖品响应事件
    prize_initialize = function(dom,type){;
        var option = dom.val();
        var key = dom.attr('data-id');
        $('#prize_type_'+key).val(option);
        if(option==1){
            // 商品
            $('#div_product_select_'+key).show();
            $('#div_coupon_select_'+key).hide();
            $('#product_recharge_'+key).hide();

            $('#product_name_'+key).val('店铺商品');
            $('#product_name_'+key).attr('readonly',true);
        }else if(option==2){
            // 优惠券
            $('#div_product_select_'+key).hide();
            $('#div_coupon_select_'+key).show();
            $('#product_recharge_'+key).hide();

            $('#div_coupon_select_'+key).val();
            $('#coupon_'+key).val($('#prize_title_'+key).val());
            $('#product_name_'+key).val($('#coupon_'+key).find("option:selected").text());
            $('#product_name_'+key).attr('readonly',true);
        }else if(option==3){
            $('#div_product_select_'+key).hide();
            $('#div_coupon_select_'+key).hide();
            $('#product_recharge_'+key).show();

            $('#product_name_'+key).val('店铺积分');
            $('#product_name_'+key).attr('readonly',true);
        }else{
            $('#div_product_select_'+key).hide();
            $('#div_coupon_select_'+key).hide();
            $('#product_recharge_'+key).show();

            $('#product_name_'+key).val('其他奖品');
            $('#product_name_'+key).attr('readonly',true);
        };
    };

    //选取商品插件
    function widget_link_box_help(dom,type,after_obj){
        //点击事件
        dom.live('click',function(){
            $_this = $(this);
            key = $_this.attr('data-key');
            //移除
            $('.modal-backdrop,.modal').remove();
            //增加
            $('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');
            //赋值
            var randNum = getRandNumber();
            var load_url = 'user.php?c=widget&a='+type+'&type=more&number='+randNum;
            widget_link_save_box[randNum] = after_obj;
            modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="'+load_url+'" style="width:100%;height:200px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');
            //增加
            $('body').append(modalDom);
            //动画
            modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
            //点击关闭
            $('.modal-backdrop').click(function(){
                login_box_close();
            });
        });
    }

    // 选取商品
    widget_link_box_help($(".js-add-picture"), "store_goods_by_sku", function (result) {
        var good_data = pic_list;
        $('.js-goods-list .sort').remove();
        for (var i in result) {
            item = result[i];
            var pic_list = "";
            var list_size = $('.js-product .sort').size();
            if(list_size > 0){
                layer_tips(1, '聚力只能添加一件商品！');
                return false;
            }

            $(".js-product_"+key).prepend('<li class="sort" data-pid="' + item.product_id + '" data-skuid="' + item.sku_id + '"><a href="' + item.url + '" target="_blank"><img data-pid="' + item.product_id + '" alt="' + item.title + '" title="' + item.title + '" src="' + item.image + '"></a><a class="js-delete-picture_multy close-modal small hide">×</a></li>');
            $(".js-product").data("product_id", item.product_id);

            $("#prize_title_"+key).val(item.product_id+'_'+item.sku_id);
            $("#prize_imgurl_"+key).val(item.image);
            $('#product_name_'+key).val(item.title);
            $_this.parent().hide();
        }
    });

    // 删除商品图片
    $('.js-delete-picture_multy').live('click',function(){
        var self = $(this);
        key = self.parent('li').siblings('li').children('a').attr('data-key');
        self.parent('li').siblings('li').show();
        self.closest("li").remove();
        //清理选中信息
        $('#prize_title_'+key).val('');
        $('#prize_imgurl_'+key).val('');
        $('#product_name_'+key).val('商品');
        $('#product_name_'+key).attr('readonly',true);
    });

    //点击选择优惠券
    $('.js-reward-coupon').live('change',function(){
        var key = $(this).attr('data-key');
        $("#prize_title_"+key).val($('#coupon_'+key).val());
        $("#prize_imgurl_"+key).val($("#coupon_"+key+" option:selected").attr("val"));
    });

    //积分和其他商品
    $('.js-reward-title').live('keyup',function(){
        var key = $(this).attr('data-key');
        $("#prize_title_"+key).val($('#product_recharge_'+key).val());
        $("#prize_imgurl_"+key).val($("#product_name_"+key).attr("val"));
    });
    $('.js-reward-imgurl').live('keyup',function(){
        var key = $(this).attr('data-key');
        $("#prize_title_"+key).val($('#product_recharge_'+key).val());
        $("#prize_imgurl_"+key).val($("#product_name_"+key).attr("val"));
    });
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}

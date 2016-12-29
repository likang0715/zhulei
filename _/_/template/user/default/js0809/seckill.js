/**
 * Created by pigcms on 2016/01/23.
 */
$(function() {
    location_page(location.hash);
    $('.ui-nav-table a').live('click',function(){
        $(".ui-nav-table li").removeClass("active");
        $(this).closest("li").addClass("active");

        if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
            location_page($(this).attr('href'));
        }
    });

    $(window).bind('hashchange', function() {
        location_page(location.hash);
    })

    function location_page(mark) {
        var mark_arr = mark.split('/');
        switch(mark_arr[0]){
            case '#create' :
                load_page('.app__content', load_url, {page : 'create'}, '', function() {

                });
                break;
            case '#edit' :
                var pigcms_id = mark_arr[1];
                load_page('.app__content', load_url, {page : 'edit', pigcms_id : pigcms_id}, '', function() {

                });
                break;
            case '#info' :
                var tuan_id = mark_arr[1];
                load_page('.app__content', load_url, {page : 'info', tuan_id : tuan_id}, '', function() {
                    var level = -1;
                    $(".js-item_level").each(function (i) {
                        var tmp_level = $(this).data("level");
                        if (tmp_level == "1") {
                            level = i;
                        }
                    });

                    if (level != -1) {
                        $(".js-item_level").each(function (i) {
                            if (level > i) {
                                $(this).html("-");
                            }
                        });
                    } else {
                        $(".js-tuan_cancel").show();
                    }

                    load_page('.tuan_order_list', load_url, {page : 'order', tuan_id : tuan_id}, '', function () {

                    });
                });
                break;
            default :
                var type = mark.substr(1);
                load_page('.app__content', load_url, {page : 'seckill_list', type : type}, '', function() {

                });
                break;
        }
    }

    /* 搜素 */
    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.ui-search-box .txt').is(':focus')) {
            var keyword = $(".js-tuan-keyword").val();
            var type = $(".js-list-search").data("type");

            load_page('.app__content', load_url, {page : 'seckill_list', type : type, keyword : keyword}, '', function() {

            });
        }
    });

    /* 分页 */
    $('.pagenavi > a').live('click', function(){
        var p = $(this).attr('data-page-num');
        var keyword = $(".js-list-search").data("keyword");
        var type = $(".js-list-search").data("type");
        load_page('.app__content', load_url, {page:'seckill_list', 'p': p, 'keyword': keyword, 'type': type}, '', function(){
            if(keyword != ''){
                $(".js-list-search").val(keyword);
            }
        });
    });

    // 复制链接
    $(".js-copy-link").live("click", function (e) {
        var seckill_id = $(this).data("id");
        button_box($(this),e,'left','copy', seckill_wap_url + seckill_id, function(){
            layer_tips(0,'复制成功');
        });
    });

    /* 删除*/
    $('.js-delete').live("click", function(e){
        var seckill_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
            $.get(seckill_delete_url, {'seckill_id': seckill_id}, function(result) {
                close_button_box();
                layer_tips(0, result.err_msg);

                location.reload();
            })
        });
    });

    $(".js_show_ewm").live("click",function(e) {
        event.stopPropagation();
        var dom = $(this);
        var dom_offset = dom.offset();

        var id = $(this).data("id");
        var qrcode_url = seckill_qrcode_url +"seckill&id="+ id;
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

        $('.popover').css({top: dom_offset.top+dom.height()-3, left: dom_offset.left - (popover_width/2) + (dom.width()/2)});

        $('.popover').click(function(e) {
            e.stopPropagation();
        });

        $('body').bind('click',function() {
            $(".popover").remove();
        });
    })

    /* 使失效 */
    $(".js-disabled").live("click", function (e) {
        var seckill_id = $(this).data("id");
        button_box($(this), e, 'left', 'confirm', '此操作将会停止此秒杀活动,确认将此活动改为失效吗？', function(){
            $.get(seckill_disabled_url, {seckill_id : seckill_id}, function (result) {
                if (result.err_code == 0) {
                    layer_tips(0, "操作完成");
                    location.reload();
                } else {
                    layer_tips(1, result.err_message);
                }
            });
        });
    });


    $(".js-create").live("click", function () {
        if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
            location_page($(this).attr('href'));
        }
    });

    $(".js-edit").live("click", function () {
        if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
            location_page($(this).attr('href'));
        }
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
    })

    /* 选择商品 */
    widget_link_box1($(".js-select-product"), 'store_goods_by_sku', function(result){
        var  good_data = pic_list;
        $('.js-goods-list .sort').remove();
        for (var i in result) {
            item = result[i];
            var pic_list = "";
            var list_size = $('.js-product .sort').size();
            if(list_size > 0){
                layer_tips(1, '秒杀活动商品一次仅能选择一个！');
                return false;
            }

            $(".js-product").prepend('<li class="sort" data-pid="' + item.product_id+'"><a href="' + item.url + '" target="_blank"><img data-pid="' + item.id + '" alt="' + item.title + '" title="' + item.title + '" src="' + item.image + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
            $("input[name='product_id']").val(item.product_id);
            $("input[name='sku_id']").val(item.sku_id);
            $("#js-select-product").css('display','none');
            $("#good_name").removeClass('good-info');
            $("#original").removeClass('good-info');
            $(".good_name").text(item.title);
            $(".original").text(item.price);
        }
    });

    /* 删除选择的商品 */
    $(".js-delete-picture").live("click", function () {
        $(this).closest("li").remove();
        $("#js-select-product").css('display','block');
        $("#good_name").addClass('good-info');
        $("#original").addClass('good-info');
        $("input[name='product_id']").val(0);
    });

    $('#seckill_price').live('blur',function(){
        var original = parseFloat($('.original').text());
        var seckill_price = parseFloat($(this).val());
        if(isNaN(seckill_price) || seckill_price <= 0){
            layer_tips(1, '请正确填写秒杀价！');
            $(this).focus();
            return false;
        } else if(seckill_price > original){
            layer_tips(1, '秒杀价不能大于商品原价！');
            $(this).focus();
            return false;
        }
    });
    // 保存
    $(".js-create-save").live("click", function () {
        var name = $("#name").val();
        var product_id = $("#product_id").val();
        var sku_id = $("#sku_id").val();
        var start_time = $("#js-start-time").val();
        var end_time = $("#js-end-time").val();
        var reduce_point = $(".reduce_pointe").val();
        var description = $("#description").val();
        var seckill_price = $("#seckill_price").val();
        var preset_time = $("#preset_time").val();
        var is_subscribe = $("input[name='is_attention']:checked").val();

        if (name.length == 0) {
            layer_tips(1, "请填写秒杀活动名称");
            $("#name").focus();
            return;
        }

        if (product_id == '') {
            layer_tips(1, "请选择秒杀商品");
            $("#js-select-product").css('border', '1px dotted red');
            return;
        }

        if (start_time.length == 0) {
            layer_tips(1, "请选择秒杀开始时间");
            $(".js-start-time").focus();
            return;
        }

        if (end_time.length == 0) {
            layer_tips(1, "请选择秒杀结束时间");
            $(".js-start-time").focus();
            return;
        }

        var data = {name : name, product_id : product_id, 'sku_id':sku_id, start_time : start_time, end_time : end_time, description : description, reduce_point : reduce_point, seckill_price : seckill_price, is_subscribe : is_subscribe, preset_time:preset_time};
        var post_url = seckill_add_url;

        if ($("#seckill_id").size() > 0) {
            post_url = seckill_edit_url;
            data.pigcms_id = $("#seckill_id").val();
        }
        $.post(post_url, data, function (result) {
            if (result.err_code == 0) {
                layer_tips(0, "操作完成");
                setTimeout(function(){
                    location.href = result.err_msg;
                },2000);
            } else {
                layer_tips(1, result.err_msg);
            }
        });
    });

    // 取消
    $(".js-btn-quit").live("click", function () {
        location.href = index_url;
    });
});


function changeDate(days){
    var today=new Date(); // 获取今天时间
    var begin;
    var endTime;
    if(days == 3){
        today.setTime(today.getTime()-3*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime()-1*24*3600*1000);
        end = today.format('yyyy-MM-dd');
    }else if(days == 7){
        today.setTime(today.getTime()-7*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime()-1*24*3600*1000);
        end = today.format('yyyy-MM-dd');
    }else if(days == 30){
        today.setTime(today.getTime()-30*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime()-1*24*3600*1000);
        end = today.format('yyyy-MM-dd');
    }
    return {'begin': begin + ' 00:00:00', 'end': end + ' 23:59:59'};
}

//格式化时间
Date.prototype.format = function(format){
    var o = {
        "M+" : this.getMonth()+1, //month
        "d+" : this.getDate(),	//day
        "h+" : this.getHours(),	//hour
        "m+" : this.getMinutes(), //minute
        "s+" : this.getSeconds(), //second
        "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
        "S" : this.getMilliseconds() //millisecond
    }
    if(/(y+)/.test(format)) {
        format=format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    }
    for(var k in o) {
        if(new RegExp("("+ k +")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
        }
    }
    return format;
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}





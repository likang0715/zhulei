/**
 * Created by pigcms_21 on 2015/2/5.
 */
var name = '';
var owner = '';
var order_method = 'DESC';
var order_field = 'add_time';
var t = '';
var start_time = '';
var end_time = '';
var p = 1;
var is = 1; //tab切换
$(function(){
    $('.app__content').load(load_url,{page:'distribution_rank_content','is':is}, '', function(){

    });

    //tab切换
    $('.ui-nav > ul > li').live('click', function() {
        var is = $(this).children('a').data('is');
       // $(this).addClass('active').siblings('li').removeClass('active');
        load_page('.app__content', load_url, {page:'distribution_rank_content','is':is}, '', function(){
       });
    })


    //搜索
    $('.js-search-btn').live('click', function(e) {
        var is = $('.fx-team').val();
        start_time = $('.js-list-search > .js-start-time').val().trim();
        end_time = $('.js-list-search > .js-end-time').val().trim();
        if(is == 1){
            store_name = $("input[class='store_name']").val();
            team_name = $("input[class='team_name']").val();
            load_page('.app__content', load_url, {page: 'distribution_rank_content','store_name': store_name,'is': is,'team_name': team_name,'start_time': start_time,'end_time': end_time }, '', function () {
                if (store_name != '') {
                    $('.js-list-search > .store_name').val(store_name);
                }
                if (team_name != '') {
                    $('.js-list-search > .team_name').val(team_name);
                }
                if (start_time != '') {
                    $('.js-list-search > .js-start-time').val(start_time);
                }
                if (end_time != '') {
                    $('.js-list-search > .js-end-time').val(end_time);
                }
            });
        }else if(is == 2) {
            name = $('.js-list-search > .name').val().trim();
            owner = $('.js-list-search > .owner').val().trim();
            load_page('.app__content', load_url, {page: 'distribution_rank_content','name': name,'is': is,'owner': owner,'start_time': start_time,'end_time': end_time }, '', function () {
                if (name != '') {
                    $('.js-list-search > .name').val(name);
                }
                if (owner != '') {
                    $('.js-list-search > .owner').val(owner);
                }
                if (start_time != '') {
                    $('.js-list-search > .js-start-time').val(start_time);
                }
                if (end_time != '') {
                    $('.js-list-search > .js-end-time').val(end_time);
                }
            });
        }
    });

    //排序
    $('.sort span').live('click', function(e) {
        order_method = $(this).data('method').toUpperCase();
        order_field = $(this).data('field');
        var is = $('.fx-team').val();

        load_page('.app__content', load_url, {page: 'distribution_rank_content', 'is': is, 'name': name, 'owner': owner, 'start_time': start_time, 'end_time': end_time, 'order_field': order_field, 'order_method': order_method, 'p': p}, '', function() {
            if (name != '') {
                $('.js-list-search > .name').val(name);
            }
            if (owner != '') {
                $('.js-list-search > .owner').val(owner);
            }
            if (start_time != '') {
                $('.js-list-search > .js-start-time').val(start_time);
            }
            if (end_time != '') {
                $('.js-list-search > .js-end-time').val(end_time)
            }
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
    })

    //最近7天或30天
    $('.date-quick-pick').live('click', function(){
        $(this).siblings('.date-quick-pick').removeClass('current');
        $(this).addClass('current');
        var tmp_days = $(this).attr('data-days');
        $('.js-start-time').val(changeDate(tmp_days).begin);
        $('.js-end-time').val(changeDate(tmp_days).end);
    })

    $('.js-filter').live('click', function(){
        start_time = $.trim($("input[name='start_time']").val());
        end_time = $.trim($("input[name='end_time']").val());

        load_page('.app__content', load_url, {page:'distribution_rank_content', 'p': p, 'end_time': end_time, 'start_time': start_time}, '', function(){
            if (start_time != '') {
                $("input[name='start_time']").val(start_time)
            }
            if (end_time != '') {
                $("input[name='end_time']").val(end_time)
            }

        });
    })


    $('.js-drp-disabled').live('click', function(e) {
        var seller_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认禁用？', function(){
            $.post(drp_status_url, {'seller_id': seller_id, 'status': 5}, function(data) {
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content', load_url, {page:'distribution_rank_content', 'p': p}, '');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        });
    })
    //分销商启用
    $('.js-drp-enabled').live('click', function(e) {
        var seller_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认启用？', function(){
            $.post(drp_status_url, {'seller_id': seller_id, 'status': 1}, function(data) {
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content', load_url, {page:'distribution_rank_content', 'p': p}, '');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        });
    })

    //分页
    $('.pagenavi > a').live('click', function(){
        var p = $(this).attr('data-page-num');
        start_time = $.trim($("input[name='start_time']").val());
        end_time = $.trim($("input[name='end_time']").val());
        var is = $('.fx-team').val();
        load_page('.app__content', load_url, {page:'distribution_rank_content', 'is':is, 'p': p, 'start_time': start_time, 'end_time': end_time}, '', function(){

            if (start_time != '') {
                $("input[name='start_time']").val(start_time)
            }
            if (end_time != '') {
                $("input[name='end_time']").val(end_time)
            }

        });
    })

    $('.js-pay-btn').live('click', function(){
        var order_id = $(this).data('id');
        $.post(pay_url, {'order_id': order_id, 'type': 'pay'}, function(data){
            if (data.err_code == 0) {
                window.location.href= data.err_msg;
            }
        })
    })

    $('.js-batch-pay').live('click', function(){
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择订单。</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        var order_id = [];
        var supplier_id = [];
        var flag = false;
        $('.js-check-toggle:checked').each(function(i){
            order_id[i] = $(this).val();
            if ($.inArray($(this).data('supplier-id'), supplier_id) >= 0 || i == 0) {
                supplier_id[i] = $(this).data('supplier-id');
            } else { //不同供货商
                flag = true;
            }
        })
        if (flag) {
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>不同供货商订单不能合并支付。</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        order_id = order_id.toString();
        $.post(pay_url, {'order_id': order_id, 'type': 'pay'}, function(data){
            if (data.err_code == 0) {
                window.location.href= data.err_msg;
            }
        })
    })
})

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
        today.setTime(today.getTime()-6*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime());
        end = today.format('yyyy-MM-dd');
    }else if(days == 30){
        today.setTime(today.getTime()-29*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime());
        end = today.format('yyyy-MM-dd');
    }
    return {'begin': begin + ' 00:00:00', 'end': end + ' 23:59:59'};
}

//格式化时间
Date.prototype.format = function(format){
    var o = {
        "M+" : this.getMonth()+1, //month
        "d+" : this.getDate(),    //day
        "h+" : this.getHours(),   //hour
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









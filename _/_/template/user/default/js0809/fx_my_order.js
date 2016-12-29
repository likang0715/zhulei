/**
 * Created by pigcms_21 on 2015/10/9.
 */
var t = '';
var status = 1;
var order_no = '';
var start_time = '';
var stop_time = '';
var supplier_id = '';
var p = 1;

$(function(){
    if (location.hash != '') {
        var mark = location.hash.split('#');
        if (mark != undefined && mark[1] != undefined) {
            status = mark[1];
        }
    }
    load_page('.app__content', load_url, {page:'my_order_content', 'order_id': order_id, 'status': status}, '', function() {
        if (status != '') {
            $("select[name='state']").find("option[value='" + status + "']").attr('selected', true);
        }
        $('.status-' + status).addClass('active').siblings('li').removeClass('active');
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
        status          = $.trim($("select[name='state']").val());
        order_no        = $.trim($("input[name='order_no']").val());
        start_time      = $.trim($("input[name='start_time']").val());
        stop_time       = $.trim($("input[name='stop_time']").val());
        supplier_id     = $.trim($("select[name='supplier_id']").val());
        window.location.hash = status;
        load_page('.app__content', load_url, {page:'my_order_content', 'order_id': order_id, 'p': p, 'order_no': order_no, 'start_time': start_time, 'stop_time': stop_time, 'supplier_id': supplier_id, 'status': status}, '', function(){

            $('.status-' + status).addClass('active').siblings('li').removeClass('active');

            if (order_no != '') {
                $("input[name='order_no']").val(order_no);
            }
            if (start_time != '') {
                $("input[name='start_time']").val(start_time)
            }
            if (stop_time != '') {
                $("input[name='stop_time']").val(stop_time)
            }
            if (supplier_id != '') {
                $("select[name='supplier_id']").find("option[value='" + supplier_id + "']").attr('selected', true);
            }
            if (status != '') {
                $("select[name='state']").find("option[value='" + status + "']").attr('selected', true);
            }
        });
    })

    $('.ui-nav ul > li > a').live('click', function(){
        p = 1;
        status = $(this).closest('li').data('status');
        order_no = '';
        start_time = '';
        stop_time = '';
        supplier_id = '';
        load_page('.app__content', load_url, {page:'my_order_content', 'order_id': order_id, 'p': p, 'order_no': order_no, 'start_time': start_time, 'stop_time': stop_time, 'supplier_id': supplier_id, 'status': status}, '', function(){
            $('.status-' + status).addClass('active').siblings('li').removeClass('active');
            if (order_no != '') {
                $("input[name='order_no']").val(order_no);
            }
            if (start_time != '') {
                $("input[name='start_time']").val(start_time)
            }
            if (stop_time != '') {
                $("input[name='stop_time']").val(stop_time)
            }
            if (supplier_id != '') {
                $("select[name='supplier_id']").find("option[value='" + supplier_id + "']").attr('selected', true);
            }
            if (status != '') {
                $("select[name='state']").find("option[value='" + status + "']").attr('selected', true);
            }
        });
    });

    //分页
    $('.pagenavi > a').live('click', function(){
        var p = $(this).attr('data-page-num');
        order_no        = $.trim($("input[name='order_no']").val());
        start_time      = $.trim($("input[name='start_time']").val());
        stop_time       = $.trim($("input[name='stop_time']").val());
        supplier_id     = $.trim($("select[name='supplier_id']").val());
        load_page('.app__content', load_url, {page:'my_order_content', 'order_id': order_id, 'p': p, 'order_no': order_no, 'start_time': start_time, 'stop_time': stop_time, 'supplier_id': supplier_id, 'status': status}, '', function(){
            if (order_no != '') {
                $("input[name='order_no']").val(order_no);
            }
            if (start_time != '') {
                $("input[name='start_time']").val(start_time)
            }
            if (stop_time != '') {
                $("input[name='stop_time']").val(stop_time)
            }
            if (supplier_id != '') {
                $("select[name='supplier_id']").find("option[value='" + supplier_id + "']").attr('selected', true);
            }
            if (status != '') {
                $("select[name='state']").find("option[value='" + status + "']").attr('selected', true);
            }
        });
    })


    $('.ui-table-order > tbody').live('mouseover', function(e) {
        $(this).addClass('bgcolor');
    })

    $('.ui-table-order > tbody').live('mouseout', function(e) {
        $(this).removeClass('bgcolor');
    })
})

function changeDate(days){
    var today=new Date(); // 获取今天时间
    var begin;
    var endTime;
    if(days == 3){
        today.setTime(today.getTime()-2*24*3600*1000);
        begin = today.format('yyyy-MM-dd');
        today = new Date();
        today.setTime(today.getTime());
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

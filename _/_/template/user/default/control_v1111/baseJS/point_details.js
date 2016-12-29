/**
 * Created by pigcms_21 on 2015/2/4.
 */
var p = 1;
var order_no = ''; //订单号
var start_time = ''; //起始时间
var stop_time  = ''; //结束时间
var type = ''; //类型
var channel = ''; //渠道
var t = '';
var param = '';

$(function() {
    if (location.hash != '') {
        param = location.hash.replace('#', '').toLowerCase();
        if (param == 'point' || param == 'fee') {
            type = 2;
        } else if (param == 'order') {
            type = 0;
            channel = 1;
        } else if (param == 'cash_point') {
            type = 0;
        }
    }
    var params = {
        'page': 'point_details_content',
        'type': type
    }
    if (channel) {
        params.channel = channel;
    }
    load_page('.app__content', load_url, params, '', function () {
        $("select[name='type']").val(type);
        if (channel) {
            $("select[name='channel']").val(channel);
        }
    });

    //开始时间
    $('#js-stime').live('focus', function() {
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-etime').val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date($('#js-etime').val()));
                }
            },
            onSelect: function() {
                if ($('#js-stime').val() != '') {
                    $('#js-etime').datepicker('option', 'minDate', new Date($('#js-stime').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($(this).datepicker('getDate'), $('#js-etime').datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-etime').datepicker('getDate'));
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
        $('#js-stime').datetimepicker(options);
    })

    //结束时间
    $('#js-etime').live('focus', function(){
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-stime').val() != '') {
                    $(this).datepicker('option', 'minDate', new Date($('#js-stime').val()));
                }
            },
            onSelect: function() {
                if ($('#js-etime').val() != '') {
                    $('#js-stime').datepicker('option', 'maxDate', new Date($('#js-etime').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($('#js-stime').datepicker('getDate'), $(this).datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-stime').datepicker('getDate'));
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
        $('#js-etime').datetimepicker(options);
    })

    //最近7天或30天
    $('.date-quick-pick').live('click', function(){
        $(this).addClass('current');
        $(this).siblings('.date-quick-pick').removeClass('current');

        var tmp_days = $(this).attr('data-days');
        $('.js-stime').val(changeDate(tmp_days).begin);
        $('.js-etime').val(changeDate(tmp_days).end);
    });

    //分页
    $('.pagenavi > a').live('click', function(e){
        p = $(this).data('page-num');
        start_time = $("input[name='stime']").val().trim();
        stop_time = $("input[name='etime']").val().trim();
        order_no = $("input[name='order_no']").val().trim();
        type = $("select[name='type']").val();
        channel = $("select[name='channel']").val();
        load_page('.app__content', load_url, {'page': 'point_details_content', 'p': p, 'order_no': order_no, 'start_time': start_time, 'stop_time': stop_time, 'type': type, 'channel': channel}, '', function(e){
            if (order_no != '') {
                $("input[name='order_no']").val(order_no);
            }
            if (start_time != '') {
                $("input[name='stime']").val(start_time)
            }
            if (stop_time != '') {
                $("input[name='etime']").val(stop_time)
            }
            $("select[name='channel']").val(channel);
            $("select[name='type']").val(type);
        });
    });

    //查询
    $('.js-filter').live('click', function(e){
        start_time = $("input[name='stime']").val().trim();
        stop_time = $("input[name='etime']").val().trim();
        order_no = $("input[name='order_no']").val().trim();
        type = $("select[name='type']").val();
        channel = $("select[name='channel']").val();
        load_page('.app__content', load_url, {'page': 'point_details_content', 'p': p, 'order_no': order_no, 'start_time': start_time, 'stop_time': stop_time, 'type': type, 'channel': channel}, '', function(e){
            if (order_no != '') {
                $("input[name='order_no']").val(order_no);
            }
            if (start_time != '') {
                $("input[name='stime']").val(start_time)
            }
            if (stop_time != '') {
                $("input[name='etime']").val(stop_time)
            }
            $("select[name='channel']").val(channel);
            $("select[name='type']").val(type);
        });
    });

});

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

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
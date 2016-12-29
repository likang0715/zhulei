/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var status = '';
var start_time = ''; //下单时间
var stop_time = ''; //下单时间
var page = 1; //页码
var order_no = ''; //订单号
var third_id = ''; //支付流水号
$(function() {

    if (getQueryString('start_time')) {
        start_time = getQueryString('start_time').replace('+', ' ');
    }

    if (getQueryString('stop_time')) {
        stop_time = getQueryString('stop_time').replace('+', ' ');
    }

    if (getQueryString('status')) {
        status = getQueryString('status');
    }
	
    load_page('.app__content', load_url, {page: page_content, 'third_id': third_id, 'order_no': order_no, 'status': status, 'start_time': start_time, 'stop_time': stop_time}, '', function(){
        if (start_time) {
            $('#js-start-time').val(start_time);
        }
        if (stop_time) {
            $('#js-end-time').val(stop_time);
        }
        //状态
        if (status) {
            $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
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


    //筛选
    $('.js-filter').live('click', function(){
        order_no = $("input[name='order_no']").val().trim();
        third_id = $("input[name='third_id']").val().trim();
        start_time = $("input[name='start_time']").val().trim();
        stop_time = $("input[name='end_time']").val().trim();
        status = $("select[name='status']").val();
        load_page('.app__content', load_url, {page: page_content, 'third_id': third_id, 'order_no': order_no, 'status': status, 'start_time': start_time, 'stop_time': stop_time}, '', function(){
            if (third_id) {
                $("input[name='third_id']").val(third_id)
            }
            if (order_no) {
                $("input[name='order_no']").val(order_no)
            }
            if (start_time) {
                $('#js-start-time').val(start_time);
            }
            if (stop_time) {
                $('#js-end-time').val(stop_time);
            }
            //状态
            if (status) {
                $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
            }
        });
    })

    //分页
    $('.pagenavi > a').live('click', function(){
        page = $(this).attr('data-page-num');
        order_no = $("input[name='order_no']").val().trim();
        third_id = $("input[name='third_id']").val().trim();
        start_time = $("input[name='start_time']").val().trim();
        stop_time = $("input[name='end_time']").val().trim();
        status = $("select[name='status']").val();
        load_page('.app__content', load_url, {page: page_content, 'p': page, 'third_id': third_id, 'order_no': order_no, 'status': status, 'start_time': start_time, 'stop_time': stop_time}, '', function(){
            if (third_id) {
                $("input[name='third_id']").val(third_id)
            }
            if (order_no) {
                $("input[name='order_no']").val(order_no)
            }
            if (start_time) {
                $('#js-start-time').val(start_time);
            }
            if (stop_time) {
                $('#js-end-time').val(stop_time);
            }
            //状态
            if (status) {
                $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
            }
        });
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

})

function changeDate(days){
    var today=new Date(); // 获取今天时间
    var begin;
    var end;
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

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}

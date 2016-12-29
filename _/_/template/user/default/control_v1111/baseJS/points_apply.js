var t = '';
$(function(){
    load_page('.app__content',load_url,{page:'points_apply_content'},'');

    //tab 切换
    $('.js-title-list>li ').live('click', function() {
        var points = $(this).data('points');

        load_page('.app__content', load_url, {page:'points_apply_content', 'points': points}, '', function(){
        });
    });

    $('.js-search-btn').live('click', function(){
        type = $.trim($('.select_type:visible').val());            /* 来源 */
        user_name = $.trim($("input[name='user_name']").val());    /* 用户 */
        points = $.trim($('.data-points').val());                  /*  */
        start_time = $.trim($("input[name='start_time']").val());
        end_time = $.trim($("input[name='end_time']").val());

        load_page('.app__content', load_url, {page:'points_apply_content', 'type': type, 'user_name': user_name, 'start_time':start_time, 'end_time': end_time,'points':points}, '', function(){
            if(type != '') {
               $('.select_type').val(type);
            }
            if(user_name != ''){
                $('input[name="user_name"]').val(user_name);
            }
            if(start_time != ''){
                $('input[name="start_time"]').val(start_time);
            }
            if(end_time != ''){
                $('input[name="end_time"]').val(end_time);
            }
        });
    })

    //分页
    $('.pagenavi > a').live('click', function(e){
        p = $(this).attr('data-page-num');
        type = $.trim($('.select_type').val());                    /* 来源 */
        user_name = $.trim($("input[name='user_name']").val());    /* 用户 */
        points = $.trim($('.data-points').val());                  /*  */
        start_time = $.trim($("input[name='start_time']").val());
        end_time = $.trim($("input[name='end_time']").val());
        var points = $.trim($('.data-points').val());
        //$('.app__content').load(load_url, {page: 'points_apply_content', 'p': p, 'keyword': keyword, 'points': points}, function(){
        load_page('.app__content', load_url, {page:'points_apply_content',  'p': p, 'type': type, 'user_name': user_name, 'start_time':start_time, 'end_time': end_time,'points':points}, '', function(){
            if(type != ''){
                $('.points-create').find("option[value='" + type + "']").attr("selected",true);
            }
            if(user_name != ''){
                $('input[name="user_name"]').val(user_name);
            }
            if(start_time != ''){
                $('input[name="start_time"]').val(start_time);
            }
            if(end_time != ''){
                $('input[name="end_time"]').val(end_time);
            }
        });
    })

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
});


function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}

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
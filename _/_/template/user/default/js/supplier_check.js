/**
 * Created by pigcms_21 on 2015/2/5.
 */
var name   = '';
var status = '';
var page   = 1; //页码
var type   = 1;
$(function() {

    if (getQueryString('name')) {
        name = getQueryString('name').replace('+', ' ');
    }

    if (getQueryString('status')) {
        status = getQueryString('status');
    }

    $('.ui-nav > ul > li:lt(2)').live('click', function () {
        type = $(this).data('checked');
        var obj = this;
        load_page('.app__content', load_url, {page: page_content, 'name': name, 'status': status, 'type': type}, '', function(){
            if (name) {
                $("input[name='name']").val(name);
            }
            //状态
            if (status) {
                $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
            }
            $(obj).addClass('active').siblings('li').removeClass('active');
        });
    })

    $('.ui-nav > ul > li:eq(2)').live('click', function () {
        type = $(this).data('checked');
        var page_content = 'dividends_mx_content';
        var obj = this;
        load_page('.app__content', load_url, {page: page_content, 'name': name, 'status': status, 'type': type}, '', function(){
            
            $(obj).addClass('active').siblings('li').removeClass('active');
        });
    })

    if (location.hash == '#cash-pay') {
        type = 2;
        $('.ui-nav > ul > li').eq(1).trigger('click');
    }else if(location.hash == '#dividends_mx'){
        type = 3;
        $('.ui-nav > ul > li').eq(2).trigger('click');
    }else {
        type = 1;
        $('.ui-nav > ul > li').eq(0).trigger('click');
    }

    $('.js-dividends-mx').live('click', function(){
        var page_content = 'dividends_mx_content';
        window.location.hash = '#dividends_mx';
        load_page('.app__content',load_url,{page:page_content},'',function(){
            $('.ui-nav > ul > li').eq(2).addClass('active').siblings('li').removeClass('active');
        });
    })

    //筛选
    $('.js-filter').live('click', function(){
        name  = $("input[name='name']").val().trim();
        status = $("select[name='status']").val();

        load_page('.app__content', load_url, {page: page_content, 'name': name, 'status': status, 'type': type}, '', function(){
            if (name) {
                $("input[name='name']").val(name)
            }
            //状态
            if (status) {
                $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
            }
        });
    })


    //分红记录筛选
    $('.js-filter-dividends').live('click', function(){
        
        if ($("input[name='store']").length > 0) {
            store = $("input[name='store']").val();
        }

        start_time = $("input[name='stime']").val();
        stop_time = $("input[name='etime']").val();

        var page_content = 'dividends_mx_content';
        window.location.hash = '#dividends_mx';

        load_page('.app__content', load_url, {page: page_content, 'start_time': start_time, 'stop_time': stop_time, 'store': store}, '', function(){
            if (store) {
                $("input[name='store']").val(store);
            }

            if (start_time != '') {
                $("input[name='stime']").val(start_time);
            }
            if (stop_time != '') {
                $("input[name='etime']").val(stop_time);
            }


           
        });
    })




    //分页
    $('.pagenavi > a').live('click', function(){
        page  = $(this).attr('data-page-num');
        name  = $("input[name='name']").val().trim();
        status = $("select[name='status']").val();
        load_page('.app__content', load_url, {page: page_content, 'p': page, 'name': name, 'status': status, 'type': type}, '', function(){
            if (name) {
                $("input[name='name']").val(name)
            }
            //状态
            if (status) {
                $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
            }
        });
    })


      //分红记录分页
    $('.js-dividends-page > a').live('click', function(){
        page  = $(this).attr('data-page-num');

        if ($("input[name='store']").length > 0) {
            store = $("input[name='store']").val();
        }

        start_time = $("input[name='stime']").val();
        stop_time = $("input[name='etime']").val();

        var page_content = 'dividends_mx_content';
        window.location.hash = '#dividends_mx';

        load_page('.app__content', load_url, {page: page_content, 'p': page, 'start_time': start_time, 'stop_time': stop_time, 'store': store}, '', function(){
           
            if (store) {
                $("input[name='store']").val(store);
            }

            if (start_time != '') {
                $("input[name='stime']").val(start_time);
            }
            if (stop_time != '') {
                $("input[name='etime']").val(stop_time);
            }


        });
    })



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
    })


})

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}


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

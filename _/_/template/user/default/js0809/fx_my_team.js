var t = '';
var p = 1;
var name = '';
var owner = '';
var start_time = '';
var end_time = '';
var order_method = 'DESC';
var order_field = 'add_time';

$(function () {
    load_page('.app__content', load_url, {page: 'my_team_content', 'order_field': order_field, 'order_method': order_method, 'p': p}, '');

    $('.js-upload-picture').live('click', function () {
        upload_pic_box(1, true, function (pic_list) {
            if (pic_list.length > 0) {
                for (var i in pic_list) {
                    $('.logo-img').attr('src', pic_list[i]);
                }
            }
        }, 1);
    });

    //检测团队名称是否已存在（同一供货商下）
    $('.name').live('blur', function() {
        var name = $(this).val().trim();
        var old_name = $(this).data('value').trim();
        var team_id = $('.team_id').val();
        var obj = this;
        if (name != '' && name != old_name) {
            $.post(check_team_name_url, {'type': 'check_name', 'name': name, 'team_id': team_id}, function(data) {
                if (data.err_code != 0) {
                    $(obj).addClass('error').next('.required').html('* ' + data.err_msg);
                }
            })
        }
    });

    $('.name').live('focus', function() {
        $(this).removeClass('error').next('.required').html('*');
    });

    //团队所有者添加/修改团队
    $('.team-owner > .js-save-btn').live('click', function(e) {
        var name = $('.name').val().trim();
        var logo = $('.logo-img').attr('src').trim();
        var member_labels = [];
        $('.member-label').each(function(i) {
            member_labels[$(this).data('level')] = $(this).val().trim();
        });
        var desc = $('.desc').val().trim();
        var team_id = $('.team_id').val(); //团队id

        if (name == '') {
            $('.name').addClass('error').next('.required').html('* 团队名称不能为空');
        }

        if ($('.error').length == 0) {
            $.post(save_team_url, {'type': 'save', 'name': name, 'logo': logo, 'member_labels': member_labels, 'desc': desc, 'team_id': team_id}, function(data) {
                $('.notifications').html('');
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        }
    });

    //团队成员添加/修改标签
    $('.team-member > .js-save-btn').live('click', function(e) {
        var team_id = $('.team_id').val(); //团队id
        var member_labels = [];
        $('.member-label').each(function(i) {
            member_labels[$(this).data('level')] = $(this).val().trim();
        });

        $.post(save_team_url, {'type': 'save', 'member_labels': member_labels, 'team_id': team_id}, function(data) {
            $('.notifications').html('');
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    });

    //搜索
    $('.js-search-btn').live('click', function(e) {
        name = $('.js-list-search > .name').val().trim();
        owner = $('.js-list-search > .owner').val().trim();
        start_time = $('.js-list-search > .js-start-time').val().trim();
        end_time = $('.js-list-search > .js-end-time').val().trim();

        load_page('.app__content', load_url, {page: 'my_team_content', 'name': name, 'owner': owner, 'start_time': start_time, 'end_time': end_time}, '', function() {
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
    });

    //排序
    $('.sort span').live('click', function(e) {
        order_method = $(this).data('method').toUpperCase();
        order_field = $(this).data('field');

        load_page('.app__content', load_url, {page: 'my_team_content', 'name': name, 'owner': owner, 'start_time': start_time, 'end_time': end_time, 'order_field': order_field, 'order_method': order_method, 'p': p}, '', function() {
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

    //分页
    $('.js-page-list > a').live('click', function(e){
        p = $(this).attr('data-page-num');

        load_page('.app__content', load_url, {page: 'my_team_content', 'name': name, 'owner': owner, 'start_time': start_time, 'end_time': end_time, 'order_field': order_field, 'order_method': order_method, 'p': p}, '', function() {
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
    });

    $('.help').live('hover', function(e) {
        if (event.type == 'mouseover') {
            $(this).next('.js-intro-popover').show();
        } else if (event.type == 'mouseout') {
            $(this).next('.js-intro-popover').hide();
        }
    });
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}


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


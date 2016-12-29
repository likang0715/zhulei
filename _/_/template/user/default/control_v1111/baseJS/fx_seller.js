/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var keyword = '';
var approve = '*';
var p = 1;
$(function(){
    load_page('.app__content', load_url, {page:'seller_content'}, '');


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


    $('.js-search-btn').live('click', function(){
        keyword = $.trim($('.js-fx-seller').val());           /* 分销商 */
        team_name = $.trim($('.filter-box-team').val());      /* 团队名称 */
        approve = $.trim($('.js-search-drp-approve').val());  /* 审核状态 */
        degree = $.trim($('.js-search-drp-degree').val());    /* 分销推广等级 */
        level = $.trim($('.js-search-drp-level').val());      /* 分销商级别 */
        start_time = $.trim($("input[name='start_time']").val());
        end_time = $.trim($("input[name='end_time']").val());
        load_page('.app__content', load_url, {page:'seller_content','team_name':team_name, 'keyword': keyword, 'approve': approve, 'degree':degree, 'level': level, 'start_time': start_time, 'end_time':end_time}, '', function(){
            if(keyword != ''){
                $('.js-fx-seller').val(keyword);
            }
            if(team_name != ''){
                $('.filter-box-team').val(team_name);
            }
            if(approve != ''){
                $('.js-search-drp-approve').find("option[value='" + approve + "']").attr("selected",true);
            }
            if(degree != ''){
                $('.js-search-drp-degree').find("option[value='" + degree + "']").attr("selected",true);
            }
            if(level != ''){
                $('.js-search-drp-level').find("option[value='" + level + "']").attr("selected",true);
            }
            if(start_time != ''){
                $("input[name='start_time']").val(start_time);
            }
            if(end_time != ''){
                $("input[name='end_time']").val(end_time);
            }
        });
    })
    //搜索
    $(".js-search").live('keyup', function(e){
        if (event.keyCode == 13) { //回车
            $('.js-search-btn').trigger('click');
        }
    })

    //选项卡切换
    $('.ui-nav > ul > li').live('click', function() {
        $(this).addClass('active');
        $(this).siblings('li').removeClass('active');
        var level = $(this).children('a').data('level');
        var keyword = $.trim($('.js-search').val());
        var approve = $.trim($('.js-search-drp-approve').val());
        load_page('.app__content', load_url, {page:'seller_content', 'keyword': keyword, 'approve': approve, 'level':level}, '', function(){
            $('.js-search').val(keyword);
            $('.js-search-drp-approve').find("option[value='" + approve + "']").attr("selected",true);
            $('.js-search').focus();
        });
    })

    //查看下属
    $('#js-drp-approve').live('click', function(e) {
        var hash = window.location.hash;
        //alert(hash);
        var seller_id = $(this).data('id');
        load_page('.app__content', load_url, {page:'seller_content', 'seller_id': seller_id}, '', function(){
            $('.js-search-drp-approve').find("option[value='" + approve + "']").attr("selected",true);
            $('.js-search').focus();
        });
    })

    //审核
    $('.js-drp-approve').live('click', function(e) {
        var seller_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认审核？', function(){
            $.post(drp_approve_url, {'seller_id': seller_id}, function(data) {
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content', load_url, {page:'seller_content', 'p': p, 'keyword': keyword, 'approve': approve}, '');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        });
    })
    //分销商禁用
    $('.js-drp-disabled').live('click', function(e) {
        var seller_id = $(this).data('id');
        var level = $('.page-is').data('is');
        button_box($(this), e, 'left', 'confirm', '确认禁用？', function(){
            $.post(drp_status_url, {'seller_id': seller_id, 'status': 5}, function(data) {
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content', load_url, {page:'seller_content', 'p': p, 'keyword': keyword, 'level': level}, '');
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
        var level = $('.page-is').data('is');
        button_box($(this), e, 'left', 'confirm', '确认启用？', function(){
            $.post(drp_status_url, {'seller_id': seller_id, 'status': 1}, function(data) {
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content', load_url, {page:'seller_content', 'p': p, 'keyword': keyword, 'level': level}, '');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        });
    })
	
	
	$('.js-not-reconcile').live('click',function(){
		var store_id=$(this).data('id');
		load_page('.app__content', load_url, {page:'check_income', 'store_id': store_id}, '', function(){
            //alert(111);
        });
	});
	
	
    //分页
    $('.pagenavi > a').live('click', function(e){
        p = $(this).attr('data-page-num');
        keyword = $.trim($('.js-search').val());

        var keyword = $.trim($('.js-fx-seller').val());           /* 分销商 */
        var team_name = $.trim($('.filter-box-team').val());      /* 团队名称 */
        var approve = $.trim($('.js-search-drp-approve').val());  /* 审核状态 */
        var degree = $.trim($('.js-search-drp-degree').val());    /* 分销推广等级 */
        var level = $.trim($('.js-search-drp-level').val());      /* 分销商级别 */
        var start_time = $.trim($("input[name='start_time']").val());
        var end_time = $.trim($("input[name='end_time']").val());

        $('.app__content').load(load_url, {page: 'seller_content', 'p': p, 'keyword': keyword, 'level': level, 'team_name':team_name,'approve':approve,'degree':degree}, function(){
            if(keyword != ''){
                $('.js-fx-seller').val(keyword);
            }
            if(team_name != ''){
                $('.filter-box-team').val(team_name);
            }
            if(approve != ''){
                $('.js-search-drp-approve').find("option[value='" + approve + "']").attr("selected",true);
            }
            if(degree != ''){
                $('.js-search-drp-degree').find("option[value='" + degree + "']").attr("selected",true);
            }
            if(level != ''){
                $('.js-search-drp-level').find("option[value='" + level + "']").attr("selected",true);
            }
            if(start_time != ''){
                $("input[name='start_time']").val(start_time);
            }
            if(end_time != ''){
                $("input[name='end_time']").val(end_time);
            }
        });
    });


	//导出分销商订单
    $(".js-dump-btn").live("click",function(){
    	
    	var loadi =layer.load('正在查询', 10000000000000);

        var keyword = $.trim($('.js-fx-seller').val());           /* 分销商 */
        var team_name = $.trim($('.filter-box-team').val());      /* 团队名称 */
        var approve = $.trim($('.js-search-drp-approve').val());  /* 审核状态 */
        var degree = $.trim($('.js-search-drp-degree').val());    /* 分销推广等级 */
        var level = $.trim($('.js-search-drp-level').val());      /* 分销商级别 */
        var start_time = $.trim($("input[name='start_time']").val());
        var end_time = $.trim($("input[name='end_time']").val());
        var is_checkout = 1;

    	$.post(drp_checkout_url,{'is_checkout':is_checkout,'team_name':team_name, 'keyword': keyword, 'approve': approve, 'degree':degree, 'level': level, 'start_time': start_time, 'end_time':end_time},function(obj) {
    				layer.close(loadi);
    				if(obj.msg>0) {
    					layer.confirm('该指定条件下有 用户  '+obj.msg+' 人，确认导出？',function(index){
    					 	layer.close(index);

                            window.open(drp_checkout_url+"&type=do_checkout&keyword="+keyword+"&team_name="+team_name+"&approve="+approve+"&degree="+degree+"&level="+level+"&is_checkout=1");
    					});
    				} else {
    					layer.alert('该搜索条件下没有用户数据，无需导出！', 8); 
    				}
    			},
    			'json'
    	)	
    })
        
    



	//////////////////////////////
})

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

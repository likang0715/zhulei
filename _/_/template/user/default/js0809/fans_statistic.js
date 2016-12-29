/**
 * Created by pigcms-89 on 2016/01/13.
 */
var t;
var start_time;
var stop_time;
$(function() {

	// $(".js-title-list li").on("click", function(){
	// 	var self  = $(this);
	// 	var v = $(this).index();
	// 	self.siblings(".active").removeClass("active").end().addClass("active");

	// });

    $(".js-title-list li a").on('click', function(){
        var marks2 = $(this).attr('href').split('#');
        console.log(marks2);
        if(marks2[1]) {
            if($(this).attr('href')) location_page("#"+marks2[1],$(this));
        }
    })

	// init
	function location_page(mark,dom) {

		var mark_arr = mark.split('/');

		switch(mark_arr[0]){
			case '#statistic_fans':
				$(mark_arr[0]).siblings(".active").removeClass("active").end().addClass('active');
				load_page('.app__content', load_url, {page:'statistic_fans'}, '');
				break;
			default:
				mark_arr[0] = '#statistic_basic';
				$(mark_arr[0]).siblings(".active").removeClass("active").end().addClass('active');
				load_page('.app__content', load_url, {page:'statistic_basic'}, '');
				break;
		}

	}

	location_page(location.hash);



    //开始时间
    $('#js-start-time').live('focus', function() {
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            showTimepicker: false,
            showButtonPanel: false,
            beforeShow: function() {
                if ($('#js-end-time').val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-start-time').val() != '') {
                    $('#js-end-time').datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            }
        };
        $('#js-start-time').datetimepicker(options);
    })


    //结束时间
    $('#js-end-time').live('focus', function(){
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            showTimepicker: false,
            showButtonPanel: false,
            beforeShow: function() {
                if ($('#js-start-time').val() != '') {
                    $(this).datepicker('option', 'minDate', new Date($('#js-start-time').val()));
                }
            },
            onSelect: function() {
                if ($('#js-end-time').val() != '') {
                    $('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
                }
            }
        };
        $('#js-end-time').datetimepicker(options);
    })


    //最近7天或30天
    $('.js-filter-quickday > li').live('click', function(){
        var tmp_days = $(this).attr('data-days');
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $('.js-start-time').val(changeDate(tmp_days).begin);
        $('.js-end-time').val(changeDate(tmp_days).end);
    })

    //筛选
    $('.js-filter-btn').live('click', function(){
        start_time = $('#js-start-time').val();
        stop_time = $('#js-end-time').val();
        index = $('.js-filter-quickday > .active').index('.js-filter-quickday > li');
        
        load_page('.app__content', load_url, {page:"statistic_fans", 'start_time': start_time, 'stop_time': stop_time }, '', function(){
            $('.js-start-time').val(start_time);
            $('.js-end-time').val(stop_time);
            $('.js-filter-quickday > li').removeClass('active');
            $('.js-filter-quickday > li').eq(index).addClass('active');

        });
    })

})

function changeDate(days){
    var today=new Date(); // 获取今天时间
    var begin;
    var endTime;
    today.setTime(today.getTime()-days*24*3600*1000);
    begin = today.format('yyyy-MM-dd');
    today = new Date();
    today.setTime(today.getTime()-1*24*3600*1000);
    end = today.format('yyyy-MM-dd');

    return {'begin': begin, 'end': end};
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
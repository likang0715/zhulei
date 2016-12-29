$(function(){
    $('.dropdown-toggle').click(function(){
        if($(this).hasClass('active')){
            close_dropdown();
            return false;
        }
        close_dropdown();

        $('.listBox .shade').removeClass('hide');

        $(this).addClass('active');
        var nav = $(this).attr('data-nav');
        $('.dropdown-wrapper').addClass(nav+' active');
        $('.'+nav+'-wrapper').addClass('active');
        if ($('.listBox').height() < $('#dropdown_scroller').height()) {
        	$('.listBox').height($('#dropdown_scroller').height());
        }
        $('#dropdown_scroller,.dropdown-module').height($('#dropdown_scroller').height());
    });
    $('.listBox .shade').click(function(){
        close_dropdown();
    });
    $('#mypageid').click(function(){
		if (parseInt($(this).data('pageid')) > 0) {
			getAjaxList(table_name, $(this).data('pageid'));
		}
    });
    
});

function list_location(obj)
{
	close_dropdown();
	if(obj.attr('data-category-id')){
		obj.addClass('red').siblings().removeClass('red');
		obj.addClass('active').siblings('li').removeClass('active');
		$('.dropdown-toggle.category .nav-head-name').html(obj.find('span').data('name'));
		table_name = obj.attr('data-category-id');
	}else if(obj.attr('data-sort-id')){
		obj.addClass('red').siblings().removeClass('red');
		obj.addClass('active').siblings('li').removeClass('active');
		$('.dropdown-toggle.sort .nav-head-name').html(obj.find('span').data('name'));
		order = obj.attr('data-sort-id');
	}
	$('.listBox dl').empty().hide();
	$('.listBox .no-deals').addClass('hide');
	
	$("#pullUp").removeClass('noMore loading').show();
	$('.listBox dl .noMore').remove();
	getAjaxList(table_name, 1);
}

function getRTime(time, id)
{
    var d = Math.floor(time/60/60/24);
    var h = Math.floor(time/60/60%24);
    var m = Math.floor(time/60%60);
    var s = Math.floor(time%60);
	if (d > 0) {
		$("#day_" + id).html(d);
	} else {
		$("#day_" + id).next('em').remove();
		$("#day_" + id).remove();
	}
	$("#hour_" + id).html(h);
	$("#minute_" + id).html(m);
	$("#second_" + id).html(s);
	setTimeout(getRTime, 1000, time - 1, id);
}

function getAjaxList(table_name, page)
{
	layer.load();
	$.post('./bargain.php', {'action':'list','table_name':table_name, 'page':page, 'order':order}, function(response){
		var html = ''
		$.each(response.data, function(i, row){
			html += '<li><div class="goodsImg fl"><img src="' + row.pic + '" /></div>';
			html += '<div class="desc"><div class="time">';
			if (row.endtime > 0) {
				getRTime(row.endtime, row.id);
				html += '<span id="day_' + row.id + '">0</span><em>天</em><span id="hour_' + row.id + '">0</span><em>:</em><span id="minute_' + row.id + '">0</span><em>:</em><span id="second_' + row.id + '">0</span>';
			}
			html += '</div><h3>' + row.title + '</h3>';
			
			if (row.table_name == 'crowdfunding' || row.table_name == 'unitary') {
				html += '<p class="zcPrice"><span>价值：' + row.price + '元</span></p>';
				html += '<div class="progressBar"><span><i style="width:' + row.percent + '"></i></span>';
				html += '<small><em><i>' + row.price_count + '</i>已参与</em><em><i>' + row.price + '</i>总需金额</em><em><i>' + row.balance + '</i>剩余</em></small></div>';
			} else {
				html += '<p>';
				if (row.type > 0) {
					html += '<span><i>最高奖：</i>' + row.price + '</span>';
				} else {
					if (row.price > 0) {
						html += '<span>' + row.price + '<i>元</i></span>';//<span>原价 20元</span>
					}
					if (row.original_price > 0) {
						html += '<span>原价 ' + row.original_price + '元</span>';//<span>原价 20元</span>
					}
				}
				html += '</p>';
				if (row.table_name == 'bargain' || 'cutprice' == row.table_name) {
					html += '<small><em><i>' + row.joincount + '</i>已参与</em></small>';
				}
			}
			html += '</div><a class="abtn" href="' + row.joinurl + '">参与</a> <i class="tipOn ' + row.table_name + '">' + row.actname + '</i></li>';
		});

		if (page > 1) {
			$('.pro_shop').before(html);
		} else {
			$('.pro_shop').siblings('li').remove();
			$('.pro_shop').before(html);
		}
		$('#mypageid').data('pageid', response.page);
		if (response.page > 0) {
			$('.pro_shop').show();
			$('#mypageid').html('查看更多');
		}else{
			$('#mypageid').html('没有更多了');
		}
		layer.closeAll('loading');
	}, 'json');
}

function close_dropdown()
{
	$('.listBox').css('height','auto')
    $('#dropdown_scroller,#dropdown_sub_scroller').css('width','');
    $('.dropdown-toggle').removeClass('active');
    $('.dropdown-wrapper').prop('class','dropdown-wrapper');
    $('#dropdown_scroller,.dropdown-module').css('height','');
    $('.listBox .shade').addClass('hide');
    $('#dropdown_sub_scroller').css('left','100%');
    $('#dropdown_scroller>div>ul>li').removeClass('active');
}

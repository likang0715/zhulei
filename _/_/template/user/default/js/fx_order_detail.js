/**
 * Created by pigcms_21 on 2015/3/11.
 */
$(function() {
    load_page('.app__content', load_url, {page: page_content, 'order_id': order_id}, '', function(){});

    $('.modal-header > .close').live('click', function(){
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
            $('.modal-backdrop,.modal').remove();
            if ($('.select2-display-none').length > 0) {
                $('.select2-display-none').remove();
            }
            $('.js-express-goods').removeClass('express-active');
        });
    })

    $(".js-express-close").live("click", function () {
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
            $('.modal-backdrop,.modal').remove();
        });
    })

    //切换包裹选项卡
    $('.js-express-tab > li').live('click', function(){
        var index  = $(this).index('.js-express-tab > li');
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $('.section-detail > .js-express-tab-content').eq(index).siblings('div').addClass('hide')
        $('.section-detail > .js-express-tab-content').eq(index).removeClass('hide');
    });

    // 查看物流
    $('.js-express-detail').live('click', function(){
        express_company = $(this).data("express_company");
        express_type = $(this).data("type");
        express_no = $(this).data("express_no");

        var express_title = "物流查询-" + express_company + ' 物流单号：' + express_no;
        if ($(".js-express-detail").size() > 1) {
            var select_html = '<select class="js-express_select">';
            $(".js-express-detail").each(function () {
                var t_company = $(this).data("express_company");
                var t_type = $(this).data("type");
                var t_express_no = $(this).data("express_no");

                var t_str = t_company + "," + t_type + "," + t_express_no;

                if (t_express_no == express_no) {
                    select_html += '	<option value="' + t_str + '" selected="selected">' + t_express_no + '</option>';
                } else {
                    select_html += '	<option value="' + t_str + '">' + t_express_no + '</option>';
                }
            });
            select_html += "</select>";

            express_title = "物流查询-" + select_html;
        }

        var html = '<div class="modal-backdrop in"></div><div class="modal hide widget-express in" aria-hidden="false" style="display: block; margin-top: -1000px;">';
        html += '		<div class="modal-header ">';
        html += '			<a class="close" data-dismiss="modal">×</a>';
        html += '			<h3 class="title">' + express_title + '</h3>';
        html += '		</div>';
        html += '		<div class="modal-body">';
        html += '			<div class="control-group">';
        html += '				<label class="control-label"></label>';
        html += '				<div class="controls">';
        html += '					<div class="control-action js-express-message">努力查询中...</div>';
        html += '				</div>';
        html += '			</div>';
        html += '		</div>'
        html += '		<div class="modal-footer">';
        html += '			<a href="javascript:;" class="ui-btn ui-btn-primary js-express-close">关闭</a>';
        html += '			<div class="final js-footer text-left pull-left js-physical-info"><div>';
        html += '			</div></div>';
        html += '		</div>';
        html += '	</div>';

        $('body').append(html);
        $('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");

        getExpress();
    });
});

var express_company, express_type, express_no;
function getExpress() {
    var default_html = '<div class="control-group">';
    default_html += '	<label class="control-label"></label>';
    default_html += '	<div class="controls">';
    default_html += '		<div class="control-action js-express-message">努力查询中...</div>';
    default_html += '	</div>';
    default_html += '</div>';
    $(".modal-body").html(default_html);
    $.getJSON("wap/express.php", {type: express_type, express_no: express_no}, function (data) {
        if (data.status == false) {
            $(".js-express-message").html("查询失败，<a href='javascript:getExpress()'>重试</a>");
        } else {
            var html = "<table><tr><td>时间</td><td>地点和跟踪进度</td></tr>";
            for (var i in data.data.data) {
                html += '	<tr>';
                html += '		<td style="padding-right:10px; height:18px; line-height:18px;">' + data.data.data[i].time + '</td>';
                html += '		<td>' + data.data.data[i].context + '</td>';
                html += '</tr>';
            }
            html += "</table>"

            $(".modal-body").html(html);
        }
    });
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}

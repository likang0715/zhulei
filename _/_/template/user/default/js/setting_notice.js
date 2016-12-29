/**
 * Created by ediancha on 2016/8/9.
 */
 "use strict";
 function location_page(mark, dom) {
    var mark_arr = mark.split('/');
    $('.widget-image .close').click();
    try{
        var mark_param = mark_arr[1].split('&');
    }catch(err){
        var mark_param = [mark_arr[1]]
    }
    switch (mark_arr[0]) {
        case '#notice_switch':
        $('.js-app-nav.notice_switch').addClass('active').siblings('.js-app-nav').removeClass('active');
        $(".notice-nav .notice_switch").addClass("active").siblings().removeClass("active");
        load_page('.app__content', load_url, {
            page: 'notice_switch'
        }, '', function() {
            $('input.label_input').each(function() {
                var id= $(this).attr('id');
                var c= $(this).attr('data-class');
                $(this).after('<label class="notice_status_item '+c+'" for="'+id+'"><i class="notice_icon"></i><span></span></label>');
                if ($(this).is(':checked')) {
                    $(this).next('label').addClass('notice_open')
                    $(this).next('label').find('span').text('已开启')
                } else{
                    $(this).next('label').addClass('notice_close')
                    $(this).next('label').find('span').text('已关闭')
                };
            });
        });
        break;
        case '#notice_recipient':
        $('.js-app-nav.notice_recipient').addClass('active').siblings('.js-app-nav').removeClass('active');
        $(".notice-nav .notice_recipient").addClass("active").siblings().removeClass("active");
        load_page('.app__content', load_url, {
            page: 'notice_recipient'
        }, '', function() {
            $.getScript('../static/js/jquery.json-2.4.js');
        });
        break;
        case '#notice_sms':
        $('.js-app-nav.notice_sms').addClass('active').siblings('.js-app-nav').removeClass('active');
        $(".notice-nav .notice_sms").addClass("active").siblings().removeClass("active");
        load_page('.app__content', load_url, {
            page: 'notice_sms'
        }, '', function() {
            var toadystart = String(changeDate(0,true).begin).substring(0,10);
            var toadyend = String(changeDate(0,true).end).substring(0,10);
            $('.js-today-send a').attr('href', '#notice_sms/2&type=send&stime='+toadystart+'&etime='+toadyend+'&page=1');
            if (String(mark_arr[1]).length>0) {
                if (mark_arr[1]==='1') {
                    replaceParamVal({'type':'recharge'})
                } else if (mark_arr[1]==='2') {
                    replaceParamVal({'type':'send'})
                }
                if (mark_param.length>0) {
                    if (getUrlParam('layer')==='open') {
                        replaceParamVal.remove('layer')
                        $('.js-recharge-layer').click();
                    };
                    getSmsDate (getUrlParam('type'),getUrlParam('stime'),getUrlParam('etime'),getUrlParam('page'))
                }
                $(".sms_con").find(".sms_main>div").eq(mark_param[0]).show().siblings().hide();
                $(".sms-menu ul li").eq(mark_param[0]).addClass("active").siblings().removeClass("active");
            };
        });
        break;
        default:
        $(".notice-nav .notice_switch").addClass("active").siblings().removeClass("active");
        $('.js-app-nav.notice_switch').addClass('active').siblings('.js-app-nav').removeClass('active');
        load_page('.app__content', load_url, {
            page: 'notice_switch'
        }, '', function() {
            $('input.label_input').each(function() {
                var id= $(this).attr('id');
                var c= $(this).attr('data-class');
                $(this).after('<label class="notice_status_item '+c+'" for="'+id+'"><i class="notice_icon"></i><span></span></label>');
                if ($(this).is(':checked')) {
                    $(this).next('label').addClass('notice_open')
                    $(this).next('label').find('span').text('已开启')
                } else{
                    $(this).next('label').addClass('notice_close')
                    $(this).next('label').find('span').text('已关闭')
                };
            });
            
        });

    }
}
//获取充值订单二维码
//order_id  订单Id
//load      操作 1: 已有弹窗 只更改html  2: 创建弹窗
function getPayCode(order_id,load){
    if (!order_id) {
        teaAlert('订单id错误')
        return false;
    };
    var load = load?Number(load):1;
    $.post(sms_details_url, {'sms_order_id': order_id}, function(details) {
        if(details.err_code != 0){
            teaAlert(details.err_msg);
            return false;
        }
        var order_no = details.err_msg.smspay_no;
        var order_num = details.err_msg.sms_num;
        var order_money = details.err_msg.money;
        if (load==1) {
            $('.modal-body').html('<div class="loading-more" style="height: 374px;"><span style="margin-top: 120px"></span></div>');
        } else if(load==2){
            teaLayer(1,'<div class="loading-more" style="height: 374px;"><span style="margin-top: 120px"></span></div>','短信充值','','',false)
        };
        $.post(sms_code_url,{'qrcode_id': String(700000000+Number(order_id))},function(result){
            if(result.err_code != 0){
                teaAlert(result.err_msg);
            }else{
                if(result.err_msg.error_code != 0){
                    teaAlert(result.err_msg);
                }else{
                    var img =new Image();
                    img.src = result.err_msg.ticket;
                    img.onload = function(){
                        img.onload =null;
                        $('.modal-body').html(store_recharge_pay);
                        $('#orderNo').text(order_no);
                        $('#orderNum').text(load==1?order_num:order_num+'条');
                        $('#orderMoney').text(order_money);
                        $('#sms-pay-code').html('<img src="'+result.err_msg.ticket+'" style="width:120px;height:120px;">')
                    }  
                }
            }
        });
        setInterval("checkPay("+order_id+")", 3000);
    });
    
}
//轮询查询支付状态
var checkPayNow = false;
function checkPay(id){
    if(checkPayNow == false){
        checkPayNow = true;
        $.getJSON(sms_check_url,{'sms_order_id':String(id)},function(result){
            checkPayNow = false;
            if(result.err_msg == 'ok'){
                teaAlert('支付成功')
                setTimeout(function () {
                    window.location.reload();
                }, 3000)
            }
        });
    }
}
function saveNoticeform () {
    var fields_seria = $(".js-notice-form input[type='checkbox']").serializeArray();
    teaAlert("保存中",'loading');
    $.post(
        load_url, 
        {"page":'store_notice_setting',"fields_seria":fields_seria}, 
        function(data){
            if(data.status == '0') {
                $('input.label_input').each(function() {
                    if ($(this).is(':checked')) {
                        $(this).next('label').addClass('notice_open').removeClass('notice_close');
                        $(this).next('label').find('span').text('已开启')
                    } else{
                        $(this).next('label').addClass('notice_close').removeClass('notice_open');
                        $(this).next('label').find('span').text('已关闭')
                    };
                });
                teaAlert("保存成功！");
            } else {
                teaAlert("保存失败,请重试！")
                var t = setTimeout(function () {
                    window.location.reload();
                }, 500)
            }
        },
        'json'
        )
}
function getSmsDate (type,stime,etime,page) {
    if (!type || type.length<1) {
        return false;
    };
    var page = page?page:'1';
    var parents = $('.sms_'+type);
    var contains = parents.find('table.ui-table tbody');
    var pages = parents.find('.js-page-list');
    var startDom = parents.find('.js-start-time');
    var endDom = parents.find('.js-end-time');
    var start = stime?String(stime).substring(0,10):''; //10位
    var end = etime?String(etime).substring(0,10):'';
    replaceParamVal({'type':type,'page':page,'stime':start,'etime':end});
    if (start) {
        startDom.val(new Date(Number(String(start)+'000')).format('yyyy-MM-dd hh:mm:ss'))
    };
    if (end) {
        endDom.val(new Date(Number(String(end)+'000')).format('yyyy-MM-dd hh:mm:ss'))
    };
    if (startDom.val()&&startDom.val()) {
        if ((new Date().getTime() - new Date(Number(start+'000')).getTime())>91*24*3600*1000) {
            teaAlert('只可查询近3个月的记录')
            return;
        };
    };
    if (type=='recharge') {
        contains.html('<tr class="loading"><td colspan="4"><div class="loading-more"><i class="loading-icon-big"></i></div></td></tr>');
        $.post(sms_recharge_url, {'page':page,'size':'20','starttime': start,'endtime': end}, function(data) {
            contains.html('');
            pages.html('');
            if (data.err_code == 0) {
                if (data.err_dom.count!='0') {
                    var totalPage = Math.ceil(Number(data.err_dom.count)/20);
                    var pageNum = data.err_dom.count >20?20:data.err_dom.count;
                    pages.html(data.err_dom.pages);
                    for (var i = 0; i < pageNum; i++) {
                        var statusPay = ((new Date().getTime() - new Date(data.err_msg[i].dateline).getTime())<86400000) && (data.err_msg[i].status!=1)?' 未支付（<a class="unpay js-order-pay" href="javascript:;" data-pay-no="'+data.err_msg[i].smspay_no+'" style="color:#07d;">去支付</a>）':' 未支付（已过期）';
                        var rechargeDom = '<tr data-id='+data.err_msg[i].sms_order_id+'><td class="time">'+data.err_msg[i].dateline+'</td><td class="money">'+data.err_msg[i].money+'</td><td class="num">'+data.err_msg[i].sms_num+'</td><td class="status">'+(data.err_msg[i].status==1 ? "<b style='font-weight: normal;'>已支付</b>" : statusPay)+'</td></tr>';
                        contains.append(rechargeDom);
                    };
                }
            } else{
                contains.html('<tr><td colspan="4" class="no-result">没有找到相关记录</td></tr>');
            };
        });
    } else if(type=='send') {
        contains.html('<tr class="loading"><td colspan="4"><div class="loading-more"><i class="loading-icon-big"></i></div></td></tr>');
        $.post(sms_send_url, {'page':page,'size':'20','starttime': start,'endtime': end}, function(data) {
            contains.html('');
            pages.html('');
            if (data.err_code== 0) {
                if (data.err_dom.count!='0') {
                    pages.html(data.err_dom.pages);
                    var totalPage = Math.ceil(Number(data.err_dom.count)/20);
                    var pageNum = data.err_dom.count >20?20:data.err_dom.count;
                    for (var i = 0; i < pageNum; i++) {
                        var rechargeDom = '<tr data-id='+data.err_msg[i].id+'><td>'+data.err_msg[i].time+'</td><td><div class="two-line" title="'+data.err_msg[i].text+'">'+data.err_msg[i].text+'</div></td><td>'+(data.err_msg[i].status==0 ? "发送成功" : " 发送失败")+'</td><td>'+data.err_msg[i].mobile+'</td></tr>';
                        contains.append(rechargeDom);
                    };
                }
            } else{
                contains.html('<tr><td colspan="4" class="no-result">没有找到相关记录</td></tr>');
            };
        });
    };
}
$(function(){
    location_page(location.hash);
    $('input.label_input').live('change', function() {
        saveNoticeform ()
    });
    // $('.notice-nav a').live('click', function() {
    //     try {
    //         var mark_arr = $(this).attr("href").split("#");
    //         if (mark_arr[1]) {
    //             location_page("#" + mark_arr[1]);
    //         }
    //     } catch (e) {
    //         location_page(location.hash);
    //     }
    // });
    // 接收人设置
    $('.js-input-tip').live('change input', function(event) {
        if ($(this).val()==="") {
            $(this).next('span.input_tip').hide()
        } else{
            $(this).next('span.input_tip').show()
        };
    });
    // 接收人保存
    $('.js-recipient-submit').live('click', function(event) {
        var nowDom = $(this);
        layer.closeAll();
        var formObj = {};
        var form = nowDom.parents('.form-horizontal').serializeArray();
        $.each(form, function(i, field) {
            formObj[field.name] = field.value;
        });
        for (var i in formObj) {
            var value = $.trim(formObj[i]);
            switch (i) {
                case 'name_shop':
                case 'name_enents':
                if (value === '') {
                    layer_tips(1, '接收人姓名不能为空');
                    return false;
                }
                break;
                case 'mobile_shop':
                case 'mobile_enents':
                if (value === '') {
                    layer_tips(1, '接收人手机号不能为空');
                    return false;
                }
                if (/^1[0-9]{10}$/.test(value) || (/^[0]?[0-9]{2,3}[\-]{1}[0-9]{6,8}$/.test(value)) || (/^[0-9]{1,4}[\-]{1}[0-9]{2,4}[\-]{1}[0-9]{2,4}$/.test(value))) {
                } else {
                    layer_tips(1, '手机号码格式不正确');
                    return false;
                }
                break;
            }
        }
        var store_tel = [];
        for (var i = 0; i < $('.js-store-tel').size(); i++) {
            var value = $('.js-store-tel').eq(i).val();
            var id = $('.js-store-tel').eq(i).attr('data-id');
            console.log(Number(id))
            if ($.trim(value)=="" || isNaN(Number(id))) {
                layer_tips(1, '门店读取错误');
                window.location.reload();
                return false;
            };
            if ($.trim(value)=="") {
                layer_tips(1, '接收人手机号不能为空');
                return false;
            };
            if (/^1[0-9]{10}$/.test(value) || (/^[0]?[0-9]{2,3}[\-]{1}[0-9]{6,8}$/.test(value)) || (/^[0-9]{1,4}[\-]{1}[0-9]{2,4}[\-]{1}[0-9]{2,4}$/.test(value))) {
            } else {
                layer_tips(1, '手机号码格式不正确');
                return false;
            }
            store_tel[i] = {};
            store_tel[i]['store_id'] = id;
            store_tel[i]['tel'] = value;
        };
        formObj['store'] = store_tel;
        formObj = $.toJSON(formObj);
        nowDom.prop('disabled', true).html(nowDom.attr('data-text-loading'));
        $.post('user.php?c=setting&a=sms_mobile', formObj, function(data) {
            if(data.err_code){
                nowDom.prop('disabled', false).html('保存');
                layer_tips(1, data.err_msg);
            }else{
                layer_tips(1, '保存成功！');
                // window.location.reload();
            }
        });
    });
    // 选择充值金额
    $('.choose-money input').live('change', function() {
        var money = $('.choose-money input:checked').next('label').find('.sms_money').text();
        var num = $('.choose-money input:checked').next('label').find('.sms_num').text();
        $('#smsMoney').text(money)
        $('#smsNum').text(num.replace('(推荐)',''))
    });

    // 充值按钮
    $('.js-sms-pay').live('click', function() {
        var type = $('.choose-money input:checked[name="choose_money"]').val();
        var parents = $(this).parents('.pay-info');
        var order_num = parents.find('#smsNum').text();
        var order_money = parents.find('#smsMoney').text();
        var t = parseInt(Math.random()*1000000);
        if (type!='1' && type!='2' && type!='3' ) {
            teaAlert('充值类型不正确')
        }else{
            $.post(sms_buy_url, {'type': type,'t':t}, function(data) {
                if(!data.err_code) {
                    getPayCode(data.err_msg.order_id,1)
                } else{
                    layer_tips(4,'失败!&#12288;'+data.err_msg);
                }
            });
        }
    });

    // 弹出支付界面
    $('.js-order-pay').live('click', function() {
        var parents = $(this).parents('tr');
        var order_id = parents.attr('data-id');
        getPayCode(order_id,2)
    });

    // 充值记录搜索
    $('.js-filter-recharge').live('click', function() {
        var start = $('.js-start-time1').val().length>0?returnformat($('.js-start-time1').val()):'';
        var end = $('.js-end-time1').val().length>0?returnformat($('.js-end-time1').val()):'';
        getSmsDate('recharge',start,end,"1")
    });
    // 发送记录搜索
    $('.js-filter-send').live('click', function() {
        var start = $('.js-start-time2').val().length>0?returnformat($('.js-start-time2').val()):'';
        var end = $('.js-end-time2').val().length>0?returnformat($('.js-end-time2').val()):'';
        getSmsDate('send',start,end,"1")
    });
    // 分页
    $('.js-page-list a.fetch_page,.js-page-list a.js-page_btn').live('click', function() {
        var newpage = $(this).attr('data-page-num');
        var parents = $(this).parents('.sms_page_item');
        var start = parents.find('.js-start-time').val().length>0?returnformat($('.js-start-time').val()):'';
        var end = parents.find('.js-end-time').val().length>0?returnformat($('.js-end-time').val()):'';
        getSmsDate(parents.attr('data-type'),start,end,newpage)
        // replaceParamVal({'page':$(this).attr('data-page-num')},true)
    });
    //开始时间
    $('.js-start-time1,.js-start-time2').live('focus', function() {
        var myInput = $(this);
        var endInput = myInput.siblings('.js-end-time');
        var options = {
            numberOfMonths: 1,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            minDate:'-3m',
            maxDate:new Date(),
            showTime: true,
            showHour: true,
            showMinute: true,
            showSecond: true,
            beforeShow: function() {
                if (endInput.val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date(endInput.val()));
                }
            },
            onSelect: function() {
                if (myInput.val() != '') {
                    endInput.datepicker('option', 'minDate', new Date(myInput.val()));
                }
                // $.datepicker._hideDatepicker();
            },
            onClose: function() {
                var flag = options._afterClose($(this).datepicker('getDate'), endInput.datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', endInput.datepicker('getDate'));
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
        myInput.datetimepicker(options);
    })

    //结束时间
    $('.js-end-time1,.js-end-time2').live('focus', function(){
        var myInput = $(this);
        var startInput = myInput.siblings('.js-start-time');
        var options = {
            numberOfMonths: 1,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            minDate:'-3m',
            maxDate:new Date(),
            showTime: true,
            showHour: true,
            showMinute: true,
            showSecond: true,
            beforeShow: function() {
                if (startInput.val() != '') {
                    $(this).datepicker('option', 'minDate', new Date(startInput.val()));
                }
            },
            onSelect: function() {
                if (myInput.val() != '') {
                    startInput.datepicker('option', 'maxDate', new Date(myInput.val()));
                }
                // $.datepicker._hideDatepicker();
            },
            onClose: function() {
                var flag = options._afterClose(startInput.datepicker('getDate'), $(this).datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', startInput.datepicker('getDate'));
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
        myInput.datetimepicker(options);
    })
    //最近N天
    $('.date-quick-pick').live('click', function(){
        $(this).siblings('.date-quick-pick').removeClass('current');
        $(this).addClass('current');
        var tmp_days = $(this).attr('data-days');
        $(this).siblings('.js-start-time').val(changeDate(tmp_days).begin);
        $(this).siblings('.js-end-time').val(changeDate(tmp_days).end);
    })

})

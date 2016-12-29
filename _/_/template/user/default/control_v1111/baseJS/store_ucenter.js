/**
 * Created by pigcms_21 on 2015/2/6.
 * Changed by pigcms_89 on 2016/5/19.
 */
$(function(){
    var defaultFieldObj;
    var name;
   // var consumption_field;
    //var member_content;
    load_page('.app__content',load_url,{page:'ucenter_content'},'',function(){

        defaultFieldObj = $('.js-config-region .app-field');
        defaultFieldObj.data({'page_title':ucenter_page_title,'bg_pic':ucenter_bg_pic,'tab_name':tab_name,'consumption_field':consumption_field, 'promotion_field': promotion_field, 'member_content': member_content, 'promotion_content': promotion_content}).live('click',function(){
            $('.app-entry .app-field').removeClass('editing');
            $(this).addClass('editing');
            $('.js-sidebar-region').html(defaultHtmlObj());
            $('.app-sidebar').css('margin-top','5px');
        });

        $('.page-title').html(ucenter_page_title);
        $('.custom-level-img').attr('src',ucenter_bg_pic);
        var cli = $('.custom-level-img');
        var clts = $('<div class="custom-level-title-section">');
        /*if(ucenter_show_level && ucenter_show_point){
         //clts.html('<h5 class="custom-level-title">尊贵的｛会员等级名｝<br/>你拥有本店积分：888</h5>');
         clts.html('<h5 class="custom-level-title">尊贵的｛会员等级名｝');
         cli.after(clts);
         }else if(ucenter_show_level){
         //clts.html('<h5 class="custom-level-title">尊贵的｛会员等级名｝</h5>');
         //cli.after(clts);
         }else if(ucenter_show_point){
         clts.html('<h5 class="custom-level-title">你拥有本店积分：888</h5>');
         cli.after(clts);
         }

        clts.html('<h5 class="custom-level-title">尊贵的会员');
        cli.after(clts);*/
        //如果添加内容
       /* $('.js-add-region .app-add-field ul li').live('click',function(){
            var tab_name = [];
            var consumption_field = [];
            var promotion_field = [];
            var member_content = {};
            var promotion_content = {};

            $('.tab-name span').each(function(){
                var name = $(this).text();
                tab_name.push(name);
            });


            $('.consumption input').each(function(i){
                var consumption_val = $("input[name='consumption']:checked").eq(i).val();
                if(consumption_val != undefined){
                    consumption_field.push(consumption_val);
                }
            });

            $('.promotion input').each(function(i){
                var promotion_val = $("input[name='promotion']:checked").eq(i).val();
                if(promotion_val != undefined){
                    promotion_field.push(promotion_val);
                }
            });

            $('.member_content input').each(function(i){
                var member_content_val = $("input[name='member_content']:checked").eq(i).val();
                if(member_content_val != undefined){
                    var text = $("input[name='member_content']:checked").eq(i).next('span').text();
                    member_content[member_content_val] = text;
                }
            });

            $('.promotion_content input').each(function(i){
                var promotion_content_val = $("input[name='promotion_content']:checked").eq(i).val();
                if(promotion_content_val != undefined){
                    var text = $("input[name='promotion_content']:checked").eq(i).next('span').text();
                    promotion_content[promotion_content_val] = text;
                }
            });
        });*/
        name = $.parseJSON(defaultFieldObj.data('tab_name'));
        consumption_field = $.parseJSON(defaultFieldObj.data('consumption_field'));
        promotion_field = $.parseJSON(defaultFieldObj.data('promotion_field'));
        member_content = $.parseJSON(defaultFieldObj.data('member_content'));
        promotion_content = $.parseJSON(defaultFieldObj.data('promotion_content'));

        $('.js-sidebar-region').html(defaultHtmlObj());

        customField.init();
        customField.setHtml(ucenter_customField);
    });

    var defaultHtmlObj = function(){

        /* 新版 */
        var htm =  '<form class="form-horizontal">' +
            '<div class="ucenter-section">' +
                '<div class="ucenter-li">' +
                    '<div class="ucli-top">' +
                        '<p>页面名称 <em>*</em></p>' +
                    '</div>' +
                    '<div class="ucli-con">' +
                        '<input class="input-xxlarge page-title-text" type="text" name="title" value="'+(defaultFieldObj.data('page_title'))+'">' +
                    '</div>' +
                '</div>' +
                '<div class="ucenter-li">' +
                    '<div class="ucli-top">' +
                        '<p>背景图</p>' +
                    '</div>' +
                    '<div class="ucli-con">' +
                        '<div class="ucenter-topBg"><img src="'+(defaultFieldObj.data('bg_pic'))+'" class="custom-level-img"></div>' +
                        '<a class="js-choose-bg control-action" href="javascript: void(0);">修改背景图</a>' +
                        '<p class="help-block">建议尺寸：640 x 320 像素</p>' +
                    '</div>' +
                '</div>' +
                '<div class="ucenter-li">' +
                    '<div class="ucli-top">' +
                        '<p>Tab名称</p>' +
                    '</div>' +
                    '<div class="ucli-con ucli-tab tab-name">' +
                        '<label>' +
                            '<div class="ul-m" data-original="消费中心"><span class="edit-1">' + (!$.isEmptyObject(name) ? name[0] : '消费中心') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="1" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-m" data-original="推广中心"><span class="edit-2">' + (!$.isEmptyObject(name) ? name[1] : '推广中心') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="2" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                    '</div>' +
                '</div>' +
                '<div class="ucenter-li consumption">' +
                    '<div class="ucli-top">' +
                        '<p>消费中心</p>' +
                        '<label class="ult-all"><input class="checkall" type="checkbox" value="">全选</label>' +
                    '</div>' +
                    '<div class="ucli-con ucli-chose">' +
                        '<label>' +
                            '<div class="ul-l"><input name="consumption" type="checkbox" ' + ($.inArray('1',consumption_field) != -1 ? 'checked' : '') + ' value="1"></div>' +
                            '<div class="ul-m"><span>昵称</span></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="consumption" type="checkbox" ' + ($.inArray('2',consumption_field) != -1 ? 'checked' : '') + ' value="2"></div>' +
                            '<div class="ul-m"><span>积分</span></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="consumption" type="checkbox" ' + ($.inArray('3',consumption_field) != -1 ? 'checked' : '') + ' value="3"></div>' +
                            '<div class="ul-m"><span>会员等级</span></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="consumption" type="checkbox" ' + ($.inArray('4',consumption_field) != -1 ? 'checked' : '') + ' value="4"></div>' +
                            '<div class="ul-m"><span>消费金额</span></div>' +
                        '</label>' +
                    '</div>' +
                '</div>' +
                '<div class="ucenter-li promotion">' +
                    '<div class="ucli-top">' +
                        '<p>推广中心</p>' +
                        '<label class="ult-all"><input class="checkall" type="checkbox" value="">全选 </label>' +
                    '</div>' +
                    '<div class="ucli-con ucli-chose">' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion" type="checkbox" '+ ($.inArray('1',promotion_field) != -1 ? 'checked' : '') +' value="1"></div>' +
                            '<div class="ul-m"><span>昵称</span></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion" type="checkbox" '+ ($.inArray('2',promotion_field) != -1 ? 'checked' : '') +' value="2"></div>' +
                            '<div class="ul-m"><span>推广等级</span></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion" type="checkbox" '+ ($.inArray('3',promotion_field) != -1 ? 'checked' : '') +' value="3"></div>' +
                            '<div class="ul-m"><span>奖金收入</span></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion" type="checkbox" '+ ($.inArray('4',promotion_field) != -1 ? 'checked' : '') +' value="4"></div>' +
                            '<div class="ul-m"><span>营销额</span></div>' +
                        '</label>' +
                    '</div>' +
                '</div>' +
                '<div class="ucenter-li member_content">' +
                    '<div class="ucli-top">' +
                        '<p>会员内容</p>' +
                        '<label class="ult-all"><input class="checkall" type="checkbox" value="">全选 </label>' +
                    '</div>' +
                    '<div class="ucli-con ucli-txt">' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[1] ? 'checked' : '') : '') + ' value="1"></div>' +
                            '<div class="ul-m" data-original="我的订单"><span class="edit-3" title="">' + (!$.isEmptyObject(member_content) ? (member_content[1] ? member_content[1] : '我的订单') : '我的订单') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="3" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[2] ? 'checked' : '') : '') + ' value="2"></div>' +
                            '<div class="ul-m" data-original="我的礼券"><span class="edit-4" title="">'+ (!$.isEmptyObject(member_content) ? (member_content[2] ? member_content[2] : '我的礼券') : '我的礼券') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="4" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[5] ? 'checked' : '') : '') + ' value="5"></div>' +
                            '<div class="ul-m" data-original="收货地址"><span class="edit-7" title="">' + (!$.isEmptyObject(member_content) ? (member_content[5] ? member_content[5] : '收货地址') : '收货地址') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="7" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[29] ? 'checked' : '') : '') + ' value="29"></div>' +
                            '<div class="ul-m" data-original="我的游戏"><span class="edit-29" title="">' + (!$.isEmptyObject(member_content) ? (member_content[29] ? member_content[29] : '我的游戏') : '我的游戏') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="29" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[30] ? 'checked' : '') : '') + ' value="30"></div>' +
                            '<div class="ul-m" data-original="我的活动"><span class="edit-30" title="">' + (!$.isEmptyObject(member_content) ? (member_content[30] ? member_content[30] : '我的活动') : '我的活动') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="30" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[6] ? 'checked' : '') : '') + ' value="6"></div>' +
                            '<div class="ul-m" data-original="个人资料"><span class="edit-8" title="">' + (!$.isEmptyObject(member_content) ? (member_content[6] ? member_content[6] : '个人资料') : '个人资料') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="8" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[8] ? 'checked' : '') : '') + ' value="8"></div>' +
                            '<div class="ul-m" data-original="我的购物车"><span class="edit-20" title="">' + (!$.isEmptyObject(member_content) ? (member_content[8] ? member_content[8] : '我的购物车') : '我的购物车') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="20" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[9] ? 'checked' : '') : '') + ' value="9"></div>' +
                            '<div class="ul-m" data-original="会员等级"><span class="edit-21" title="">' + (!$.isEmptyObject(member_content) ? (member_content[9] ? member_content[9] : '会员等级') : '会员等级') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="21" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[10] ? 'checked' : '') : '') + ' value="10"></div>' +
                            '<div class="ul-m" data-original="积分明细"><span class="edit-22" title="">' + (!$.isEmptyObject(member_content) ? (member_content[10] ? member_content[10] : '积分明细') : '积分明细') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="22" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="member_content" type="checkbox" ' + (!$.isEmptyObject(member_content) ? (member_content[11] ? 'checked' : '') : '') + ' value="11"></div>' +
                            '<div class="ul-m" data-original="个人推广"><span class="edit-23" title="">' + (!$.isEmptyObject(member_content) ? (member_content[11] ? member_content[11] : '个人推广') : '个人推广') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="23" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                    '</div>' +
                '</div>' +
                '<div class="ucenter-li promotion_content">' +
                    '<div class="ucli-top">' +
                        '<p>推广内容</p>' +
                        '<label class="ult-all"><input class="checkall" type="checkbox" value="">全选 </label>' +
                    '</div>' +
                    '<div class="ucli-con ucli-txt">' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[1] ? 'checked' : '') : '') + ' value="1"></div>' +
                            '<div class="ul-m" data-original="推广仓库"><span class="edit-10">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[1] ? promotion_content[1] : '推广仓库') : '推广仓库') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="10" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[2] ? 'checked' : '') : '') + ' value="2"></div>' +
                            '<div class="ul-m" data-original="推广订单"><span class="edit-11">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[2] ? promotion_content[2] : '推广订单') : '推广订单') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="11" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[3] ? 'checked' : '') : '') + ' value="3"></div>' +
                            '<div class="ul-m" data-original="推广奖金"><span class="edit-12">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[3] ? promotion_content[3] : '推广奖金') : '推广奖金') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="12" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[4] ? 'checked' : '') : '') + ' value="4"></div>' +
                            '<div class="ul-m" data-original="我的团队"><span class="edit-13">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[4] ? promotion_content[4] : '我的团队') : '我的团队') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="13" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" '+ (!$.isEmptyObject(promotion_content) ? (promotion_content[5] ? 'checked' : '') : '') + ' value="5"></div>' +
                            '<div class="ul-m" data-original="我的推广"><span class="edit-14">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[5] ? promotion_content[5] : '我的推广') : '我的推广') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="14" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[6] ? 'checked' : '') : '') + ' value="6"></div>' +
                            '<div class="ul-m" data-original="我的名片"><span class="edit-15">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[6] ? promotion_content[6] : '我的名片') : '我的名片') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="15" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[7] ? 'checked' : '') : '') + ' value="7"></div>' +
                            '<div class="ul-m" data-original="团队管理"><span class="edit-16">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[7] ? promotion_content[7] : '团队管理') : '团队管理') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="16" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[8] ? 'checked' : '') : '') + ' value="8"></div>' +
                            '<div class="ul-m" data-original="团队排名"><span class="edit-17">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[8] ? promotion_content[8] : '团队排名') : '团队排名') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="17" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[9] ? 'checked' : '') : '') + ' value="9"></div>' +
                            '<div class="ul-m" data-original="推广说明"><span class="edit-18">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[9] ? promotion_content[9] : '推广说明') : '推广说明') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="18" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[10] ? 'checked' : '') : '') + ' value="10"></div>' +
                            '<div class="ul-m" data-original="企业简介"><span class="edit-19">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[10] ? promotion_content[10] : '企业简介') : '企业简介') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="19" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[11] ? 'checked' : '') : '') + ' value="11"></div>' +
                            '<div class="ul-m" data-original="等级积分"><span class="edit-24">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[11] ? promotion_content[11] : '等级积分') : '等级积分') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="24" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[13] ? 'checked' : '') : '') + ' value="13"></div>' +
                            '<div class="ul-m" data-original="切换店铺"><span class="edit-26">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[13] ? promotion_content[13] : '切换店铺') : '切换店铺') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="26" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[14] ? 'checked' : '') : '') + ' value="14"></div>' +
                            '<div class="ul-m" data-original="退货维权"><span class="edit-27">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[14] ? promotion_content[14] : '退货维权') : '退货维权') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="27" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[15] ? 'checked' : '') : '') + ' value="15"></div>' +
                            '<div class="ul-m" data-original="我的粉丝"><span class="edit-28">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[15] ? promotion_content[15] : '我的粉丝') : '我的粉丝') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="28" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                        '<label>' +
                            '<div class="ul-l"><input name="promotion_content" type="checkbox" ' + (!$.isEmptyObject(promotion_content) ? (promotion_content[16] ? 'checked' : '') : '') + ' value="16"></div>' +
                            '<div class="ul-m" data-original="获取证书"><span class="edit-31">' + (!$.isEmptyObject(promotion_content) ? (promotion_content[16] ? promotion_content[16] : '获取证书') : '获取证书') + '</span></div>' +
                            '<div class="ul-r"><a data-edit="31" class="edit-ucenter" href="javascript: void(0);"></a></div>' +
                        '</label>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</form>';

        return bindDefault($(htm));

    };

    // 绑定默认值效果
    var bindDefault = function (centerObj) {

        var overTxt = centerObj.find(".tab-name .ul-m span,.member_content .ul-m span,.promotion_content .ul-m span");

        // 初始值设置 title 可显示超出边界内容
        overTxt.each(function(){
            var self = $(this);
            var defaultTxt = self.closest('.ul-m').data('original');
            self.attr('title', self.text());

            var hoverHtm = $('<div class="ul-original" title="恢复默认名称"><p>'+defaultTxt+'</p><a href="javascript:void(0)" class="ori-set"></a></div>');
            self.closest('label').find('.ul-r .edit-ucenter').after(hoverHtm);

        });

        return centerObj;

    }

    // 设置数据
    var resetData = {

        tab_name : function (defaultFieldObj) {
            var tab_name = [];
            $('.tab-name span').each(function(){
                var name = $(this).text();
                tab_name.push(name);
            });
            defaultFieldObj.data('tab_name', tab_name);
        },

        // 消费中心
        consumption_field : function (defaultFieldObj) {

            var consumption_field = [];
            $('.consumption input').each(function(i){
                var consumption_val = $("input[name='consumption']:checked").eq(i).val();
                if(consumption_val != undefined){
                    consumption_field.push(consumption_val);
                }
            });
            defaultFieldObj.data('consumption_field',consumption_field);

        },

        // 推广中心
        promotion_field : function (defaultFieldObj) {

            var promotion_field = [];
            $('.promotion input').each(function(i){
                var promotion_val = $("input[name='promotion']:checked").eq(i).val();
                if(promotion_val != undefined){
                    promotion_field.push(promotion_val);
                }
            });
            defaultFieldObj.data('promotion_field',promotion_field);

        },

        // 会员内容
        member_content : function (defaultFieldObj) {

            var member_content = {};
            $('.member_content input').each(function(i){
                var member_content_val = $("input[name='member_content']:checked").eq(i).val();
                if(member_content_val != undefined){
                    var text = $("input[name='member_content']:checked").eq(i).closest('label').find('span').text();
                    member_content[member_content_val] = text;
                }
            });

            defaultFieldObj.data('member_content', member_content);
        },

        // 推广内容
        promotion_content : function (defaultFieldObj) {

            var promotion_content = {};
            $('.promotion_content input').each(function(i){
                var promotion_content_val = $("input[name='promotion_content']:checked").eq(i).val();
                if(promotion_content_val != undefined){
                    var text = $("input[name='promotion_content']:checked").eq(i).closest('label').find('span').text();
                    promotion_content[promotion_content_val] = text;
                }
            });

            defaultFieldObj.data('promotion_content', promotion_content);
        }

    };

    // 编辑名称 [会员/推广]
    $('.member_content .edit-ucenter, .promotion_content .edit-ucenter').live('click', function(){

        var self = $(this);
        if (self.hasClass('readonly')) {
            return;
        }

        self.addClass('readonly');

        var edit = self.data('edit');
        var val = $(".edit-" + edit).text();
        var input = $('<input class="edit' + edit + '" type="text" value="'+ val +'" >');
        
        $(".edit-" + edit).replaceWith(input);
        $('input[class="edit' + edit + '"]').focus();

        input.blur(function(){

            var input_val = $(this).val();
            if (input_val.length == 0) {
                var span = $('<span class="edit-' + edit + '">'+ val +'</span>');
                span.attr("title", val);
            } else {
                var span = $('<span class="edit-' + edit + '">'+ input_val +'</span>');
                span.attr("title", input_val);
            }
            input.replaceWith(span);

            self.removeClass('readonly');

            resetData.member_content(defaultFieldObj);
            resetData.promotion_content(defaultFieldObj);
        });

    });

    // tab 标题
    $('.tab-name .edit-ucenter').live('click', function(){
        var self = $(this);
        if (self.hasClass('readonly')) {
            return;
        }
        self.addClass('readonly');

        var edit = self.data('edit');
        var val = $(".edit-" + edit).text();
        var input = $('<input class="edit' + edit + '" type="text" value="'+ val +'" >');

        $(".edit-" + edit).replaceWith(input);
        input.focus();

        input.blur(function(){

            var input_val = $(this).val();
            if (input_val.length == 0) {
                var span = $('<span class="edit-' + edit + '">'+ val +'</span>');
                span.attr("title", val);
            } else {
                var span = $('<span class="edit-' + edit + '">'+ input_val +'</span>');
                span.attr("title", input_val);
            }
            input.replaceWith(span);
            self.removeClass('readonly');

            resetData.tab_name(defaultFieldObj);

        });

    });

    // 恢复默认名称
    $(".ul-original a.ori-set").live("click", function(){
        var self = $(this);
        var ulM = self.closest('label').find('.ul-m');
        var edit = self.closest('.ul-r').find('.edit-ucenter').data('edit');
        var span = '<span class="edit-' + edit + '">'+ ulM.data('original') +'</span>';

        ulM.html(span);
    });

    // 页面标题失焦点
    $('.page-title-text').live('blur', function(e){
        var t_l = $(this).val().length;
        if (t_l == 0 || t_l > 50) {
            layer_tips(1, '标题长度不能少于一个字或者大于50个字！');
        } else {
            $('.page-title').html($(this).val());
            defaultFieldObj.data('page_title', $(this).val());
        }
    });

    // 背景图
    $('.js-choose-bg').live('click',function(){
        var self = $(this);
        upload_pic_box(1,true,function(pic_list){
            for(var i in pic_list){
                self.siblings('.ucenter-topBg').find('img').attr('src', pic_list[i]);
                $('.custom-level-img').attr('src', pic_list[i]);
                defaultFieldObj.data('bg_pic', pic_list[i]);
            }
        },1);
    });

    // 消费中心 ???
    $('.consumption').live('blur',function(){
        resetData.consumption_field(defaultFieldObj);
    });

    // 消费中心全选
    $('.consumption .checkall').live('click', function(){
        if ($(this).is(':checked')) {
            $("input[name='consumption']").attr('checked', true);
        } else {
            $("input[name='consumption']").attr('checked', false);
        }
        resetData.consumption_field(defaultFieldObj);
    });

    // 推广中心 ???
    $('.promotion').live('blur',function(){
        resetData.promotion_field(defaultFieldObj);
    });

    // 推广中心全选
    $('.promotion .checkall').live('click', function(){
        if ($(this).is(':checked')) {
            $("input[name='promotion']").attr('checked', true);
        } else {
            $("input[name='promotion']").attr('checked', false);
        }
        resetData.promotion_field(defaultFieldObj);
    });

    // 会员内容 ???
    $('.member_content').live('blur', function(){
        resetData.member_content(defaultFieldObj);
    });

    // 会员中心全选
    $('.member_content .checkall').live('click', function(){
        if ($(this).is(':checked')) {
            $("input[name='member_content']").attr('checked', true);
        } else {
            $("input[name='member_content']").attr('checked', false);
        }
        resetData.member_content(defaultFieldObj);
    });

    // 推广内容 ???
    $('.promotion_content').live('blur',function(){
        resetData.promotion_content(defaultFieldObj);
    });

    $('.promotion_content .checkall').live('click', function(){
        if ($(this).is(':checked')) {
            $("input[name='promotion_content']").attr('checked', true);
        } else {
            $("input[name='promotion_content']").attr('checked', false);
        }
        resetData.promotion_content(defaultFieldObj);
    });

	//选择专题 ???
	$('.area-editor-list-title').live('click',function(){
		if($(this).hasClass('area-editor-list-select')){
			$(this).removeClass('area-editor-list-select');
		}else{
			$(this).addClass('area-editor-list-select');
		}
	});

    // 提交
    $('.form-actions .btn-save,.form-actions .btn-preview').live('click',function(){
        var isPerview = $(this).hasClass('btn-preview') ? true : false;
        var post_data = {};

        post_data.page_title = defaultFieldObj.data('page_title');
        post_data.bg_pic = defaultFieldObj.data('bg_pic');

        post_data.tab_name = typeof(defaultFieldObj.data('tab_name')) == 'string' ? $.parseJSON(defaultFieldObj.data('tab_name')) : defaultFieldObj.data('tab_name');
        post_data.consumption_field = typeof(defaultFieldObj.data('consumption_field')) == 'string' ? $.parseJSON(defaultFieldObj.data('consumption_field')) : defaultFieldObj.data('consumption_field');
        post_data.promotion_field = typeof(defaultFieldObj.data('promotion_field')) == 'string' ? $.parseJSON(defaultFieldObj.data('promotion_field')) : defaultFieldObj.data('promotion_field');
        post_data.member_content = typeof(defaultFieldObj.data('member_content')) == 'string' ? $.parseJSON(defaultFieldObj.data('member_content')) : defaultFieldObj.data('member_content');
        post_data.promotion_content = typeof(defaultFieldObj.data('promotion_content')) == 'string' ? $.parseJSON(defaultFieldObj.data('promotion_content')) : defaultFieldObj.data('promotion_content');

        post_data.custom = customField.checkEvent();
        post_data.isPerview = isPerview;
        // console.log(post_data.promotion_content);return;
        $.post(post_url,post_data,function(result){
            if (result.err_code == 0) {
                if (isPerview) {
                    layer_tips(0,'修改成功，正在跳转');
                    setTimeout(function(){
                        window.location.href = wap_site_url+'/ucenter.php?id='+store_id;
                    },1000);
                } else {
                    layer_tips(0,result.err_msg);
                }
            } else {
                layer_tips(1,result.err_msg);
            }
        });
    });



});
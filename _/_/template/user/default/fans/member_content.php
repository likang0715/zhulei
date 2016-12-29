<!-- ▼ Main container -->
<style>
    .member_search ul {
        width: 100%
    }

    .member_search ul li {
        float: left;
        padding: 5px;
        5px;
    }

    .member_search ul .small_input {
        width: 90px;
    }

    .member_search ul .middle_input {
        width: 130px;
    }

    .member_search ul .date-quick-pick{
        color: #07d;
        font-size: 12px;
        display: inline-block;
        vertical-align: middle;
        margin-bottom: 8px;
        margin-left: 6px;
    }

    .member_search ul select {
        width: 110px;
    }

    .ui-table-list .fans-box .fans-avatar {
        float: left;
        width: 60px;
        height: 60px;
        background: #eee;
        overflow: hidden;
    }

    .ui-table-list .fans-box .fans-avatar img {
        width: 60px;
        height: auto;
    }

    .ui-table-list .fans-box .fans-msg {
        float: left;
    }

    .ui-table-list .fans-box .fans-msg p {
        padding: 0 5px;
        text-align: left;
    }

    .block-help > a {
        display: inline-block;
        width: 16px;
        height: 16px;
        line-height: 18px;
        border-radius: 8px;
        font-size: 12px;
        text-align: center;
        background: #bbb;
        color: #fff;
    }

    .block-help > a:after {
        content: "?";
    }

    .user_info_table {
        background: #f8f8f8
    }

    .user_info_table .tleft {
        text-align: left
    }

    .user_info_table .tright {
        text-align: right
    }

    .user_info_table .w20 {
        width: 20%
    }

    .user_info_table .w30 {
        width: 30%
    }

    input, select {
        font-size: 12px;
    }
</style>
<div class="widget-app-board ui-box member_search" style="border: none;">
    <ul>
        <li>
            <div class="control-group">
                <label class="control-label">
                    <select class="select_type">
                        <option value="uid">会员id</option>
                        <option value="nickname">会员昵称</option>
                        <option value="phone">会员手机号</option>
                    </select>
                    <input class="small_input input_type" type="text" name="input_type" />
                </label>
            </div>
        </li>
        <li>
            <div class="control-group">
                <label class="control-label">会员等级：
                    <select name="select_degree" class="select_degree">
                        <option value="0">未选择</option>
                        <?php if (is_array($all_degree)) { ?>
                            <?php foreach ($all_degree as $k => $v) { ?>
                                <option value="<?php echo $v[id]; ?>"><?php echo $v['name']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </label>
            </div>
        </li>
        <li>
            <div class="control-group">
                <label class="control-label">获本店积分：
                    <input type="text" name="start_point" value="<?php echo is_numeric($_POST['start_point'])?$_POST['start_point']:'';?>" class="small_input">
                    <span>至</span>
                    <input type="text" name="end_point" value="<?php echo is_numeric($_POST['end_point'])?$_POST['end_point']:'';?>" class="small_input">
                </label>
            </div>
        </li>
        <li>
            <div class="control-group">
                <label class="control-label">
                    <select name="time_type">
                        <option value="add_time">注册时间</option>
                        <option value="last_time">最后登录时间</option>
                    </select>
                    <input type="text" name="start_time" readonly="readonly" style="background-color: white"
                           class="middle_input js-start-time " id="js-start-time">
                    <span>至</span>
                    <input type="text" name="end_time" readonly="readonly" style="background-color: white"
                           class="middle_input js-end-time" id="js-end-time">
                    <span class="date-quick-pick" data-days="7">最近7天</span>
                    <span class="date-quick-pick" data-days="30">最近30天</span>
                </label>
            </div>
        </li>


        <li style="text-align:right">
            <div class="controls">
                <div class="ui-btn-group">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="ui-btn ui-btn-primary js-filter js_search" data-loading-text="正在筛选...">筛选</a>
                </div>
            </div>
        </li>
    </ul>

</div>


<div class="widget-list">
    <div style="position:relative;margin-bottom: 0px;" class="js-list-filter-region clearfix ui-box">
        <div class="js-list-filter-region clearfix">
            <div>
                <div class="ui-nav2 ico_all_f" style="margin-bottom: 0px;margin-top: 0px;border: none;">
                    <ul style="display:inline-block;">
                        <li><a href="javascript:;"><input class="check_all" type="checkbox"> 全选</a></li>
                        <li class="print_style"></a>
                        </li>
                    </ul>

                    <ul style="display:inline-block;float:right">
                        <li>
                            <span style="display:inline-block;margin-top: 10px;margin-right: 10px;">
                                <select id="select_checkout_type" style="padding:5px;margin-bottom: 0px;margin-top: -1px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                                    <option value="now">导出当前筛选出的会员</option>
                                    <option value="check">导出已勾选的会员</option>
                                    <option value="all">导出全部会员</option>
                                </select>
                                <a style="background:#006cc9;color:#fff;height: 30px;" href="javascript:;" class="checkout_orders status-1 ui-btn ui-btn-blue js-filter" data="1"> <span class="ico_all2 "></span> 导出会员</a>
                            </span>
                        </li>
                    </ul>

                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    .li_txt {
        display: inline-block;
    }

    .li_img {
        display: inline-block;
        height: 20px;
        margin-left: 3px;
        width: 14px;
    }

    .li_img_show {
        background: rgba(0, 0, 0, 0) url("<?php echo TPL_URL;?>images/ico/list_04.png") no-repeat scroll 0 8px;
    }

    .li_img_hide {
        background: rgba(0, 0, 0, 0) url("<?php echo TPL_URL;?>images/ico/list_03.png") no-repeat scroll 0 8px;
    }

    .degree {
        display: inline-block;
        margin-left: 20px;
    }

    .popover-content p {
        font-size: 12px!important;
    }

    .degree-label {
        color: gray;
        display: inline-block;
    }
</style>
<div class="ui-box" style="margin-top: 0px;">
    <?php
    if ($count > 0) {
        if ($array) {
            ?>
            <table class="ui-table ui-table-list" style="padding:0px;">
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                    <tr class="widget-list-header">
                        <th class="cell-15 text-left">会员信息</th>
                        <th class="cell-10 text-right"><?php echo $platform_credit_name; ?></th>
                        <th class="cell-10 text-right">可用<?php echo $platform_credit_name; ?></th>
                        <th class="cell-10 text-right">积分
                            <span class="block-help">
                                <a href="javascript:void(0);" class="js-help-notes"></a>
                                <div class="js-notes-cont hide">
                                    <p>积分：用户在您店铺拥有的积分数</p>
                                </div>
                            </span>
                        </th>
                        <th class="cell-10 text-center">最后登录/是否关注
                            <span class="block-help">
                                <a href="javascript:void(0);" class="js-help-notes"></a>
                                <div class="js-notes-cont hide">
                                    <p><strong>1.</strong>店铺绑定 <font color="#f00">认证服务号</font>才能显示关注状态</p>

                                    <p><strong>2.</strong>扫商家绑定的二维码成为店铺关注会员</p>
                                </div>
                            </span>
                        </th>
                        <th width="280" align="center">操作</th>
                    </tr>
                </thead>
                <tbody class="js-list-body-region">
                    <?php foreach ($array as $k => $v) { ?>
                    <tr class="widget-list-item" data-uid="<?php echo $v['uid']; ?>" data-store_id="<?php echo $v['store_id']; ?>">
                        <td align="left">
                            <input type="checkbox" class="array_checkbox" value="<?php echo $v['uid']; ?>" />
                            会员昵称：<?php if ($v['nickname']) {
                                echo $v['nickname'];
                            } else {
                                echo "匿名用户";
                            } ?>
                            <br/>
                            <span class="degree"><label class="degree-label">会员等级：</label><a href="javascript:void(0)"><?php echo !empty($v['degree_name']) ? $v['degree_name'] : '无'; ?></a></span>
                        </td>
                        <td class="cell-10 text-right"><?php echo $v['point_unbalance']; ?></td>
                        <td class="cell-10 text-right"><?php echo $v['point_balance']; ?></td>
                        <td class="td_jf zt cell-10 text-right"><a href="<?php echo dourl('points_apply', array('uid' => $v['uid'])); ?>" hrefs="javascript:void(0)"><?php echo $v['point']; ?></a></td>
                        <td class="zt cell-10 text-center">
                            <?php echo date("Y-m-d H:i", $v['last_time']); ?>
                            <br/>
                            <?php if ($bind['service_type_info'] == 2 && $bind['verify_type_info'] != '-1') { ?>
                            【
                            <?php if ($guanzhu_user_info[$v['uid']]['openid']) { ?>
                                <b style="color:#f00">已关注</b>
                            <?php } else { ?>
                                <b>未关注</b>
                            <?php } ?>
                            】
                            <?php } ?>   
                        </td>
                        <td align="right" data="<?php echo $points['id']; ?>">
                            <a href="javascript:void(0)"
                               hrefs="<?php echo dourl('list') ?>&from=fans_rule&id=<?php echo $points['id'] ?>"
                               class="js-show-user">
                                <div class="li_txt">查看会员</div>
                                <div class="li_img li_img_show"></div>
                            </a>
                            <span>-</span>
                            <a href="javascript:void(0)" class="js_edit_jifen">修改店铺积分</a>
                            <!-- <span>-</span>
                            <a href="javascript:void(0);" data="<?php echo $points['id'] ?>" class="js_show_txm">会员卡</a> -->
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="js-list-footer-region ui-box">
                <div>
                    <div class="pagenavi js-page-list"><?php echo $pages; ?></div>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="js-list-empty-region">
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<script type="text/javascript">
    var t = '';
    $(function () {
        $('.js-help-notes').hover(function () {
            $('.popover-help-notes').remove();
            //var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 140) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p><strong>1：</strong>启用后方可赠送积分！</p><p><strong>2：</strong>同等条件下,按照最高标准赠送积分！</p></div></div></div>';
            var htmls = $(this).closest(".block-help").find(".js-notes-cont").html();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 140) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + htmls + '</div></div></div>';
            $('body').append(html);
            $('.popover-help-notes').show();
        }, function () {
            t = setTimeout('hide()', 200);
        })

        $('.popover-help-notes').live('mouseleave', function () {
            clearTimeout(t);
            hide();
        })

        $('.popover-help-notes').live('mouseover', function () {
            clearTimeout(t);
        })

    })

    function hide() {
        $('.popover-help-notes').remove();
    }
</script>
<div class="js-list-footer-region ui-box"></div>
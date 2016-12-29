<!-- ▼ Main container -->
<style type="text/css">
    label {
        display: inline-block;
    }
    .ui-nav-table {
        position: relative;
        border-bottom: 1px solid #ccc;
        margin-bottom: 0px;
    }
    .date-quick-pick {
        display: inline-block;
        color: #07d;
        cursor: pointer;
        padding: 2px 4px;
        border: 1px solid transparent;
        margin-left: 12px;
        border-radius: 4px;
        margin-top: 4px;
    }
    .current {
        background: #fff!important;
        border-color: #07d!important;
    }
    .date-quick-pick:hover{
        border-color:#ccc;
        text-decoration:none;
    }
    .member_search ul {
        width:100%;
    }
    .member_search ul li{
        float:left;
        padding:5px; 5px;
    }
    .member_search ul .small_input{
        width:90px;
    }
    .member_search .control-label {
        float: left;
        line-height: 30px;
        width: 107px;
        text-align: right;
    }
    .member_search .controls {
        float: left;
        margin-left: 6px;
    }
    .member_search ul .middle_input{width:93px;}
    .member_search ul select{width:110px;}
    .ui-table-list .fans-box .fans-avatar {float: left;width: 60px;height: 60px;background: #eee;overflow: hidden;}
    .ui-table-list .fans-box .fans-avatar img {width: 60px;height: auto;}
    .ui-table-list .fans-box .fans-msg {float: left;}
    .ui-table-list .fans-box .fans-msg p {padding: 0 5px;text-align: left;}
    .block-help>a {
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
    .block-help>a:after {
        content: "?";
    }
    .user_info_table {background:#D7D7D7}
    .user_info_table .tleft {text-align:left}
    .user_info_table .tright {text-align:right}
    .user_info_table .w20 {width:20%}
    .user_info_table .w30 {width:30%}
</style>
<div class="widget-app-board ui-box member_search" style="border: none;">
    <ul style="">
        <li class="points-create" style="display:<?php echo  $store_points==1 ? 'block' : 'none';?>">
            <div class="control-group">
                <label class="control-label">来源：
                </label>
                <div class="controls">
                    <select class="select_type">
                        <option value="0">请选择来源</option>
                        <option value="1">关注公众号送</option>
                        <option value="2">订单满送</option>
                        <option value="3">消费送</option>
                        <option value="4">分享送</option>
                        <option value="5">签到送</option>
                        <option value="6">买特殊商品所送</option>
                        <option value="7">手动变更</option>
                        <option value="8">推广增加</option>
                        <option value="10">退货退还积分</option>
                    </select>
                </div>
            </div>
        </li>
        <li class="points-apply" style="display:<?php echo  $store_points==2 ? 'block' : 'none';?>">
            <div class="control-group">
                <label class="control-label">
                    消费：
                </label>
                <div class="controls">
                    <select class="select_type">
                        <option value="0">请选择</option>
                        <option value="7">手动变更</option>
                        <option value="9">订单抵扣现金</option>
                        <option value="11">升级会员等级</option>
                    </select>
                </div>
            </div>
        </li>
        <li>
            <div class="control-group">
                <label class="control-label">
                   昵称：
                </label>
                <div class="controls">
                    <input type="text" name="user_name" value="" class="middle_input" id="" />
                </div>
            </div>
        </li>
        <li>
            <div class="control-group">
                <label class="control-label">
                    时间：
                </label>
                <div class="controls">
                    <input type="text" name="start_time" value="" class="middle_input js-start-time" id="js-start-time" />
                    <span>至</span>
                    <input type="text" name="end_time" value="" class="middle_input js-end-time" id="js-end-time" />
                </div>
                <span class="date-quick-pick" data-days="7">最近7天</span>
                <span class="date-quick-pick" data-days="30">最近30天</span>
            </div>
        </li>
        <li style="text-align:right">
            <div class="controls">
                <div class="ui-btn-group">
                    <a href="javascript:;" class="ui-btn ui-btn-primary js-filter js_search js-search-btn" data-loading-text="正在筛选...">筛选</a>
                </div>
            </div>
        </li>
    </ul>
</div>
</li>
</ul>
</div>
<?php
 $types = array(
     1 =>'关注公众号送',
     2 =>'订单满送',
     3 =>'消费送',
     4 =>'分享送',
     5 =>'签到送',
     6 =>'买特殊商品所送',
     7 =>'手动变更',
     8 =>'推广增加',
     9 =>'订单抵扣现金',
     10=>'退货退还积分',
     11=>'升级会员等级'
 );
?>
<div class="ui-box">
    <?php
        if($pointlist) {
     ?>
            <table class="ui-table ui-table-list" style="padding:0px;">
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-30 text-left">
                        昵称
                    </th>
                    <th class="cell-10 text-left">
                        积分
                    </th>
                    <th class="cell-10 text-left">
                        积分来源
                    </th>

                    <th class="cell-10 text-left">
                        对应订单号
                    </th>

                    <th class="cell-10 text-left">时间</th>

                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach($pointlist as $k=>$v){ ?>
                    <tr class="widget-list-item" data-uid="<?php echo $v['uid'];?>" data-store_id="<?php echo $v['store_id'];?>">
                        <td align="left"><?php if($v['nickname']) {echo $v['nickname'];}else{echo "匿名用户";}?></td>
                        <td  class="td_jf zt cell-10 text-left">
                            <?php echo $v['points'];?>
                        </td>
                        <th class="cell-10 text-left">
                            <?php foreach($types as $key=>$type){?>
                                <?php if($v['type'] == $key){?>
                                    <?php echo $type;?>
                                <?php }?>
                            <?php }?>
                        </td>
                        <td  class="zt cell-10 text-left">
                            <?php echo $v['order_no']?>
                        </td>
                        <td  class="zt cell-10 text-left">
                            <?php echo date("Y-m-d H:i",$v['timestamp']);?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>


            <div class="js-list-footer-region ui-box">
                <div>
                    <input type="hidden" class="data-points" value="<?php echo $store_points;?>">
                    <div class="pagenavi js-page-list"><?php echo $page;?></div>
                </div>
            </div>
        <?php
        }else{
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

<div class="js-list-footer-region ui-box"></div>
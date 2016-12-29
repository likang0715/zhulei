<style>
.list-filter-form .date-quick-pick {
    display: inline-block;
    color: #07d;
    cursor: pointer;
    padding: 2px 4px;
    border: 1px solid transparent;
    margin-left: 12px;
    border-radius: 4px;
}
.list-filter-form .date-quick-pick+.date-quick-pick {
    margin-left: 0;
}
.list-filter-form .date-quick-pick.current {
    background: #fff;
    border-color: #07d!important;
}
.list-filter-form .date-quick-pick:hover{border-color:#ddd;}


.js-dividends-page {
font-size: 12px;
line-height: 16px;
text-align: right;
margin-top: 20px;
}
.js-dividends-page .total {
padding: 6px 0;
font-weight: normal !important;
}
.js-dividends-page .total, .js-dividends-page .prev, .js-dividends-page .next, .js-dividends-page .num, .js-dividends-page .goto-input, .js-dividends-page .goto-btn {
display: inline-block;
color: #292929;
}
.js-dividends-page .prev, .js-dividends-page .next, .js-dividends-page .num, .js-dividends-page .goto {
padding: 5px 8px;
margin: 0 0 0 2px;
min-width: 28px;
border: 1px solid #ddd;
text-align: center;
border-radius: 2px;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
}
.js-dividends-page .active {
/*background: #D5CFCF;*/
background:#00A5FF;
color:white;
border-color: #ddd;
}
.js-dividends-page .prev:hover, .js-dividends-page .next:hover, .js-dividends-page .num:hover {
border-color: #ccc;
}


</style>
<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="js-list-filter-region clearfix">
                <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="control-group">
                    <label class="control-label">供货商名称：</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="store" />
                    </div>
                </div>
                

                <div class="control-group">
                    <label class="control-label">发放时间：</label>
                    <div class="controls">
                        <input type="text" name="stime" class="js-stime" id="js-stime" />
                        <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                        <input type="text" name="etime" class="js-etime" id="js-etime" />
                        <span class="date-quick-pick" data-days="7">最近7天</span>
                        <span class="date-quick-pick" data-days="30">最近30天</span>
                         &nbsp;&nbsp;&nbsp;&nbsp;
                         <a href="javascript:;" class="ui-btn ui-btn-primary js-filter-dividends" data-loading-text="正在查询...">查询</a>
                    </div>
                </div>
               
                </form>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <?php if (!empty($list)) { ?>

        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-25">供货商名称</th>
                    <th class="cell-25">经销奖金分红 </th>
                    <th class="cell-25 text-center">发送时间</th>
                    <th class="cell-25 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="js-list-body-region">
                <?php foreach ($list as $value) { ?>
                <tr class="widget-list-item">
                    
                    <td>
                        <span><?php echo $value['store']; ?></span>
                    </td>
                   
                     <td>
                        <span><?php echo $value['amount']; ?></span>
                    </td>
                    
                   
                    <td class="text-center"><?php echo date('Y-m-d H:i:s',$value['add_time']); ?></td> 

                    <td class="text-center">
                        <a class="rules_mx" href="" supplier_id="<?php echo $value['supplier_id']?>" >规则明细</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?php dourl('trade:income', array('to' => 'supplier', 'supplier_id' => $value['supplier_id'])); ?>#dividends_withdrawal">奖金提现</a>
                    </td>
                   
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
        <div class="js-list-empty-region">
            <?php if (empty($list)) { ?>
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div class="widget-list-footer">
            <div class="js-dividends-page"><?php echo $page; ?></div>
        </div>
    </div>
</div>

<script>
 $('.rules_mx').live('click',function(){
        var supplier_id = $(this).attr('supplier_id');
        $.layer({
            type: 2,
            title: false,
            shadeClose: false,
            shade: [0.4, '#000',false],
            area: ['250px','60px'],
            border: [0],
            iframe: {src:'./user.php?c=order&a=dividends_mx_rules&supplier_id='+supplier_id}
        });
        return false;
    });
</script>
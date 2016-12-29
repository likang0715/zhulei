<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="js-list-filter-region clearfix">
                <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="control-group">
                    <label class="control-label">发放对象名称：</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="store" />
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label">类别：</label>
                    <div class="controls">
                        <select name="type" class="js-type-select">
                            <option value="0" selected="true">请选择</option>
                            <option value="1">经销商</option>
                            <option value="2">分销团队</option>
                            <option value="3">独立分销商</option>
                        </select>
                       
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">起止时间：</label>
                    <div class="controls">
                        <input type="text" name="stime" class="js-stime" id="js-stime" />
                        <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                        <input type="text" name="etime" class="js-etime" id="js-etime" />
                        <span class="date-quick-pick" data-days="7">最近7天</span>
                        <span class="date-quick-pick" data-days="30">最近30天</span>

                         <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在查询...">查询</a>
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
                    <th class="cell-25">奖金对象</th>
                    <th class="cell-25">类别</th>
                    <th class="cell-25">奖金分红 </th>
                    <th class="cell-25 text-center">发送时间</th>
                </tr>
            </thead>
            <tbody class="js-list-body-region">
                <?php foreach ($list as $value) { ?>
                <tr class="widget-list-item">
                    
                    <td>
                        <span><?php echo $value['store']; ?></span>
                    </td>
                     <td>
                        <span><?php echo $dividends_type_arr[$value['dividends_type']]; ?></span>
                    </td>
                     <td>
                        <span><?php echo $value['amount']; ?></span>
                    </td>
                    
                   
                    <td class="text-center"><?php echo date('Y-m-d H:i:s',$value['add_time']); ?></td> 
                   
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
            <div class="pagenavi"><?php echo $page; ?></div>
        </div>
    </div>
</div>
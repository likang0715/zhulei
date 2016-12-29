<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="js-list-filter-region clearfix">
                <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                    <div class="control-group">
                        <label class="control-label">
                            起止时间：
                        </label>
                        <div class="controls">
                            <input type="text" name="stime" class="js-stime" id="js-stime" />
                            <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                            <input type="text" name="etime" class="js-etime" id="js-etime" />
                            <span class="date-quick-pick" data-days="7">最近7天</span>
                            <span class="date-quick-pick" data-days="30">最近30天</span>
                           
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">类型：</label>
                        <div class="controls">
                            <select name="type" class="js-type-select">
                                <option value="0">全部</option>
                                <?php
                                foreach ($dividends_type_arr as $key => $value) {
                                ?>
                                <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                <?php
                                }
                                ?>
                            </select>
                             <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在查询...">查询</a>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <?php if (!empty($my_dividends)) { ?>
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-12 text-right">金额(元)</th>
                    <th class="cell-12 text-right">类型</th>
                    <th class="cell-15 text-right">时间</th>  
                </tr>
            </thead>
            <tbody class="js-list-body-region">
                <?php foreach ($my_dividends as $my_dividend) { ?>
                <tr class="widget-list-item"> 
                    <td width="50" class="text-right ui-money-outlay"><?php echo $my_dividend['amount']; ?></td>
                    <td width="50" class="text-right"><?php echo $dividends_type_arr[$my_dividend['dividends_type']]; ?></td>
                    <td width="90" class="text-right"><?php echo date('Y-m-d H:i:s', $my_dividend['add_time'])?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
        <div class="js-list-empty-region">
            <?php if (empty($my_dividends)) { ?>
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
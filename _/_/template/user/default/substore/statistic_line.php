<script type="text/javascript">
    require.config({
        paths: {
            echarts: './static/js/echart'
        }
    });

    require(
        [
            'echarts',
            'echarts/chart/line',
        ],
        function (ec) {
            var myChart = ec.init(document.getElementById('chart-body'));
            myChart.setOption({
                tooltip : {
                    trigger: 'axis',
                    backgroundColor : 'white',
                    borderColor : 'black',
                    borderWidth : 2,
                    borderRadius : 5,
                    textStyle : {color : 'black'},
                    axisPointer : {
                        type: 'line',
                        lineStyle: {
                            color: '#8FD1FA',
                            width: 1,
                            type: 'dotted'
                        }
                    }
                },
                legend: {
                    data:['销售数量']
                },
                grid: {
                    x: 80,
                    y: 60,
                    x2: 80,
                    y2: 60,
                    width : '700px',
                    backgroundColor: 'rgba(0,0,0,0)',
                    borderWidth: 0,
                    borderColor: '#ccc'
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        axisLine : {show : false},
                        axisTick : {show : false},
                        splitLine : {show : false},
                        data : <?php echo $days; ?>
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLine : {show : false},
                        splitArea : {show : false},
                        splitLine : {
                            show : true,
                            lineStyle : {
                                color: ['#ccc'],
                                width: 1,
                                type: 'dotted'
                            }
                        }
                    }
                ],
                series : [
                    {
                        name:'销售数量',
                        type:'line',
                        smooth:true,
                        data:<?php echo $days_7_products; ?>
                    }
                ]
            });
        }
    );
</script>
<style type="text/css">
    .widget .widget-body__inner {
        min-height: 350px;
    }
</style>
<div class="js-app-inner app-inner-wrap hide" style="display: block;">

    <div id="js-filter" class="filter-wrap"><table>
            <tbody>
            <tr>
                <th>筛选日期：</th>
                <td>
                    <div class="filter-time" style="padding-bottom: 10px;">
                        <input type="text" class="js-start-time input-medium" id="js-start-time" placeholder="开始日期" />
                        至
                        <input type="text" class="js-end-time input-medium" id="js-end-time" placeholder="结束日期" />
                        <span class="quickday">
                            <em>快速查看：</em>
                            <ul class="js-filter-quickday items-ul">
                                <li data-days="7" class="active">
                                    <span>最近7天</span>
                                </li>
                                <li data-days="30">
                                    <span>最近30天</span>
                                </li>
                            </ul>
                        </span>
                    </div>
                </td>
            </tr>
            <?php if (!empty($physicals)) { ?>
            <tr>
                <th>查看门店：</th>
                <td>
                    <div class="control-group">
                        <label class="control-label select">
                            <select name="physical_id">
                                <option value="0">全部</option>
                                <?php foreach ($physicals as $physical) { ?>
                                <option value="<?php echo $physical['pigcms_id'] ?>"><?php echo $physical['name'] ?></option>
                                <?php } ?>
                            </select>
                        </label>
                    </div>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <th>销售产品：</th>
                <td>
                    <div class="control-group">
                        <label class="control-label select">
                            <select name="product_id" style="width: 100px">
                                <option value="0">全部产品</option>
                                <?php foreach ($products as $product) { ?>
                                <option value="<?php echo $product['product_id'] ?>"><?php echo $product['name'] ?></option>
                                <?php } ?>
                            </select>
                        </label>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="btn-actions">
            <button type="button" class="js-filter-btn btn btn-primary" data-loading-text="请稍候...">筛选</button>
        </div>
    </div>

    <div id="js-order-chart" class="widget widget-order-chart">
        <div class="widget-inner">
            <div class="widget-head">
                <h3 class="widget-title">销售数量</h3>
                <div class="help">
                    <a href="javascript:void(0);" class="js-help-notes"></a>
                    <div class="js-notes-cont hide">
                        <p><strong>销售数量：</strong>由本店配送的产品数量。</p>
                    </div>
                </div>
            </div>
            <div class="widget-body">
                <div class="js-body widget-body__inner" id="chart-body" style="cursor: default;">
                    <div class="widget-chart-no-data">暂无数据</div>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    var t= '';
    $(function(){
        $('.js-help-notes').hover(function(){
            $('.popover-help-notes').remove();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 20) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p><strong>销售数量：</strong>由本门店配送的产品数量。</p></div></div></div>';
            $('body').append(html);
            $('.popover-help-notes').show();
        }, function(){
            t = setTimeout('hide()', 200);
        })

        $('.popover-help-notes').live('mouseleave', function(){
            clearTimeout(t);
            hide();
        })

        $('.popover-help-notes').live('mouseover', function(){
            clearTimeout(t);
        })

    })

    function hide() {
        $('.popover-help-notes').remove();
    }
</script>
<style type="text/css">
    .widget .widget-body__inner {
        min-height: 500px;
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
                                <li data-days="180">
                                    <span>半年</span>
                                </li>
                                <li data-days="365">
                                    <span>一年</span>
                                </li>
                            </ul>
                        </span>
                    </div>
                </td>
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
                <h3 class="widget-title">销售百分比</h3>
                <div class="help">
                    <a href="javascript:void(0);" class="js-help-notes"></a>
                    <div class="js-notes-cont hide">
                        <p><strong>销售百分比：</strong>由本店配送的产品销售百分比。</p>
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
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 20) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p><strong>销售百分比：</strong>由本门店配送的产品销售百分比。</p></div></div></div>';
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
<script type="text/javascript">

    var barOption = {
        tooltip : {
            trigger: 'item',
            formatter: function(params){
                return '<p style="max-width:200px;white-space:normal;word-wrap:break-word;">'+params.seriesName+' <br/>'+params.name+' : '+params.value+' ('+params.percent+'%)'+'</p>';
            }
        },
        legend: {
            orient : 'vertical',
            x : 'right',
            data:<?php echo $products; ?>,
            formatter: function(c){
                for (i in c) {
                    if (c.length > 12) {
                        return c.substring(0,12)+'…';
                    } else {
                        return c;
                    }
                }
            }
        },
        calculable : true,
        series : [
            {
                name:'销售数量：数量',
                type:'pie',
                radius : '70%',
                center: ['50%', '40%'],
                itemStyle: {
                    normal:{
                        label:{
                            formatter:function(params){
                                if (params.name.length > 12) {
                                    return params.name.substring(0,12)+'…';
                                } else {
                                    return params.name;
                                }
                            }
                        }
                    }
                },
                data:<?php echo $days_7_value_name; ?>
            }
        ]
    };


    var histogramOption = {
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['销售量']
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : <?php echo $products; ?>
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'销售量',
                type:'bar',
                data:<?php echo $tmp_histogram; ?>
            }
        ]
    };

    // console.log(histogramOption);

    require.config({
        paths: {
            echarts: './static/js/echart'
        }
    });

    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/pie'
        ],
        function (ec) {
            var myChart = ec.init(document.getElementById('chart-body'));
            myChart.setOption(barOption);
            // myChart.setOption(histogramOption);
        }
    );

</script>
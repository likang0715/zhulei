<script type="text/javascript">
var chartWidth = $('.js-body-chart.chart-body').width()-170;
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
            title: {
                text: '近7日订座到店情况'
            },
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
                data:['成功预订订单','实际到店订单']
            },
            grid: {
                x: 80,
                y: 60,
                x2: 80,
                y2: 60,
                width : chartWidth,
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
                data : <?php echo $data_seven; ?>
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
                name:'成功预订订单',
                type:'line',
                smooth:true,
                data:<?php echo $data_seven_order; ?>
            },
            {
                name:'实际到店订单',
                type:'line',
                smooth:true,
                data:<?php echo $data_seven_shop;?>
            }
            ]
        });
    }
);
</script>
<div class="js-app-inner app-inner-wrap hide" style="display: block;">
    <div id="js-pagedata" class="widget widget-pagedata">
        <div class="widget-inner">
            <div class="widget-head">
                <h3 class="widget-title">实时订单概况</h3>
                <ul class="widget-nav">
                    <li>
                        <a href="javascript:;" class="updata-time" target="_blank">(更新时间：<?php echo date('Y-m-d H:i:s',$time); ?>)</a>
                    </li>
                </ul>
                <div class="help">
                    <a href="javascript:void(0);" class="js-help-notes"></a>
                </div>
            </div>
            <div class="widget-body with-border">
                <div class="js-body widget-body__inner clearfix">
                    <ul class="js-body-desc chart-desc">
                        <li class="coming">
                            <p class="num">
                                <a href="<?php dourl('order'); ?>#list/<?php echo $physical_id; ?>&status=2&stime=<?php echo $time; ?>&etime=<?php echo $today_endtime; ?>"><?php echo $today; ?></a>
                            </p>
                            <p class="title">即将到店</p>
                        </li>
                        <li class="order">
                            <p class="num">
                                <a href="<?php dourl('order'); ?>#list/<?php echo $physical_id; ?>&status=1&stime=<?php echo $time; ?>"><?php echo $wait; ?></a>
                            </p>
                            <p class="title">待确认预订</p>
                        </li>
                        <li class="actual">
                            <p class="num">
                                <a href="<?php dourl('order'); ?>#list/<?php echo $physical_id; ?>&status=3&stime=<?php echo $time; ?>&etime=<?php echo $wait_endtime; ?>"><?php echo $waitmoney; ?></a>
                            </p>
                            <p class="title">待确认到店</p>
                        </li>
                        <li class="data_7">
                            <p class="num">
                                <a href="<?php dourl('order'); ?>#list/<?php echo $physical_id; ?>&status=3&stime=<?php echo $time; ?>&etime=<?php echo $waitmoney_endtime; ?>"><?php echo $sevendays; ?></a>
                            </p>
                            <p class="title">近7日到店</p>
                        </li>
                    </ul>
                    <div class="js-body-chart chart-body" id="chart-body" style="height: 310px;">
                        <div class="widget-chart-no-data">暂无数据</div>
                    </div>
                </div>
            </div>
    </div>
</div>
</div>
<script type="text/javascript">

$(function(){

    var barOption1 = {
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        calculable : true,
        legend: {
            orient : 'vertical',
            x : 'left',
            data: <?php echo $data['sex_unit'] ?>
        },
        series : [
            {
                name:'访问来源',
                type:'pie',
                radius : [60, 80],

                // for funnel
                x: '60%',
                width: '35%',
                funnelAlign: 'left',
                max: 1048,
                center: ['60%', '50%'],
                itemStyle : {
                    normal : {
                        label : {
                            show : false
                        },
                        labelLine : {
                            show : false
                        }
                    },
                    emphasis : {
                        label : {
                            show : true,
                            position : 'center',
                            textStyle : {
                                fontSize : '18',
                                fontWeight : 'bold'
                            }
                        }
                    }
                },
                data:<?php echo $data['sex_chart_str'] ?>
            }
        ]
    };

    var barOption2 = {
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        calculable : true,
        legend: {
            orient : 'vertical',
            x : 'left',
            data: <?php echo $data['drp_unit'] ?>
        },
        series : [
            {
                name:'访问来源',
                type:'pie',
                radius : [60, 80],

                // for funnel
                x: '60%',
                width: '35%',
                funnelAlign: 'left',
                max: 1048,
                center: ['60%', '50%'],
                itemStyle : {
                    normal : {
                        label : {
                            show : false
                        },
                        labelLine : {
                            show : false
                        }
                    },
                    emphasis : {
                        label : {
                            show : true,
                            position : 'center',
                            textStyle : {
                                fontSize : '18',
                                fontWeight : 'bold'
                            }
                        }
                    }
                },
                data: <?php echo $data['drp_chart_str'] ?>
            }
        ]
    };

    var barOption3 = {
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        calculable : true,
        legend: {
            orient : 'vertical',
            x : 'left',
            data: <?php echo $data['degree_unit'] ?>
        },
        series : [
            {
                name:'访问来源',
                type:'pie',
                radius : [60, 80],

                // for funnel
                x: '60%',
                width: '35%',
                funnelAlign: 'left',
                max: 1048,
                center: ['60%', '50%'],
                itemStyle : {
                    normal : {
                        label : {
                            show : false
                        },
                        labelLine : {
                            show : false
                        }
                    },
                    emphasis : {
                        label : {
                            show : true,
                            position : 'center',
                            textStyle : {
                                fontSize : '18',
                                fontWeight : 'bold'
                            }
                        }
                    }
                },
                data:<?php echo $data['degree_str'] ?>
            }
        ]
    };

    var mapOption = {
        title : {
            text: '',
            subtext: '',
            x:'center'
        },
        tooltip : {
            trigger: 'item'
        },
        dataRange: {
            min: <?php echo $data['map_min'] ?>,
            max: <?php echo $data['map_max'] ?>,
            x: 'left',
            y: 'bottom',
            text:['多','少'],           // 文本，默认为数值文本
            calculable : true
        },
        series : [
            {
                name: '粉丝数',
                type: 'map',
                mapType: 'china',
                roam: false,
                itemStyle:{
                    normal:{label:{show:true}},
                    emphasis:{label:{show:true}}
                },
                data:<?php echo $data['map_str'] ?>
            }
        ]
    };

    require.config({
        paths: {
            echarts: './static/js/echart'
        }
    });

    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/pie',
            'echarts/chart/map'
        ],
        function (ec) {

            var myChart1 = ec.init(document.getElementById('chart-pie-sex'));
            myChart1.setOption(barOption1);

            var myChart2 = ec.init(document.getElementById('chart-pie-fx'));
            myChart2.setOption(barOption2);

            var myChart3 = ec.init(document.getElementById('chart-pie-level'));
            myChart3.setOption(barOption3);

            var myChartMap = ec.init(document.getElementById('chart-map'));
            myChartMap.setOption(mapOption);

        }
    );
})
</script>
<div class="js-app-inner app-inner-wrap">

    <div id="js-overview" class="dash-bar clearfix">
        <div class="js-cont dash-todo__body">
            <div class="info-group">
                <div class="info-group__inner">
					<span class="h4">
						<a href="javascript:void(0)"><?php echo $data['num_members'] ?></a>
					</span>
                    <span class="info-description">会员总数</span>
                </div>
            </div>
            <div class="info-group">
                <div class="info-group__inner">
					<span class="h4">
						<a href="javascript:void(0)"><?php echo $data['num_fans'] ?></a>
					</span>
                    <span class="info-description">已关注本店</span>
                </div>
            </div>
            <div class="info-group">
                <div class="info-group__inner">
					<span class="h4">
						<a href="javascript:void(0)"><?php echo $data['num_yesterday'] ?></a>
					</span>
                    <span class="info-description">昨日新增用户</span>
                </div>
            </div>
            <div class="info-group">
                <div class="info-group__inner">
					<span class="h4">
						<a href="javascript:void(0)"><?php echo $data['num_coupon'] ?></a>
					</span>
                    <span class="info-description">领过优惠</span>
                </div>
            </div>
        </div>
    </div>

    <div class="widget">
        <div class="widget-inner">
            <div class="widget-head">
                <h3 class="widget-title">会员属性</h3>
            </div>
            <div class="widget-body">
                <div class="chart-pie-box" id="chart-pie-fx"></div>
                <div class="chart-pie-box" id="chart-pie-level"></div>
                <div class="chart-pie-box" id="chart-pie-sex"></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="widget">
        <div class="widget-inner">
            <div class="widget-head">
                <h3 class="widget-title">会员分布</h3>
            </div>
            <div class="widget-body">
                <div class="chart-map-box" id="chart-map"></div>
                <div class="chart-rank">
                    <div class="ui-tTable">
                        <div class="ui-trTop clearfix">
                            <div class="ui-th">排名</div>
                            <div class="ui-th">地区</div>
                            <div class="ui-th">粉丝数</div>
                        </div>
                        <?php foreach ($data['area_list'] as $i => $area) { ?>
                            <?php if ($i >= 10) { continue; } ?>
                            <div class="ui-tr clearfix">
                                <div class="ui-td"><?php echo $i + 1; ?></div>
                                <div class="ui-td"><?php echo $area['province']; ?></div>
                                <div class="ui-td"><?php echo $area['num']; ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

</div>
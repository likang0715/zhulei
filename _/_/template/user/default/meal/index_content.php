<div class="js-app-inner app-inner-wrap hide" style="display: block;">
    <div id="js-pagedata" class="widget widget-pagedata">
        <div class="widget-inner">
            <div class="widget-head">
                <h3 class="widget-title">实时订单概况1</h3>
                <ul class="widget-nav">
                    <li>
                        <a href="javascript:;" class="updata-time" target="_blank">(更新时间：2016-0117-27 15:09:12)</a>
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
                                <a href="<?php dourl('order', array('start_time' => $yesterday_start_time, 'stop_time' => $yesterday_stop_time)); ?>"><?php echo $yesterday_orders; ?></a>
                            </p>
                            <p class="title">即将到店</p>
                        </li>
                        <li class="order">
                            <p class="num">
                                <a href="<?php dourl('order', array('status' => 2, 'start_time' => $yesterday_start_time, 'stop_time' => $yesterday_stop_time)); ?>"><?php echo $yesterday_paid_orders; ?></a>
                            </p>
                            <p class="title">待确认预订</p>
                        </li>
                        <li class="actual">
                            <p class="num">
                                <a href="<?php dourl('order', array('status' => 3, 'start_time' => $yesterday_start_time, 'stop_time' => $yesterday_stop_time)); ?>"><?php echo $yesterday_send_orders; ?></a>
                            </p>
                            <p class="title">待确认到店</p>
                        </li>
                        <li class="data_7">
                            <p class="num">
                                <a href="<?php dourl('order', array('status' => 3, 'start_time' => $yesterday_start_time, 'stop_time' => $yesterday_stop_time)); ?>"><?php echo $yesterday_send_orders; ?></a>
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
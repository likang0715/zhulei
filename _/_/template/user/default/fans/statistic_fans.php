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
			var myChart = ec.init(document.getElementById('chart-line'));
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
					data:['新增粉丝','跑路粉丝', '净增粉丝']
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
						data : <?php echo $days ?>
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
						name:'新增粉丝',
						type:'line',
						smooth:true,
						data:<?php echo $days_add ?>
					},
					{
						name:'跑路粉丝',
						type:'line',
						smooth:true,
						data:<?php echo $days_leave ?>
					},
					{
						name:'净增粉丝',
						type:'line',
						smooth:true,
						data:<?php echo $days_pure_add ?>
					},
				]
			});
		}
	);
</script>
<link rel="stylesheet" type="text/css" href="">
<div class="js-app-inner app-inner-wrap">

	<div id="js-filter" class="filter-wrap">
		<table>
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
                            <button type="button" class="js-filter-btn btn btn-primary" data-loading-text="请稍候...">筛选</button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="js-overview" class="dash-bar clearfix">
		<div class="js-cont dash-todo__body">
			<div class="info-group">
				<div class="info-group__inner">
					<span class="h4">
						<a href="javascript:void(0)"><?php echo $data['num_fans'] ?></a>
					</span>
					<span class="info-description">会员总数</span>
				</div>
			</div>
			<div class="info-group">
				<div class="info-group__inner">
					<span class="h4">
						<a href="javascript:void(0)"><?php echo $data['num_add'] ?></a>
					</span>
					<span class="info-description">新增关注</span>
				</div>
			</div>
			<div class="info-group">
				<div class="info-group__inner">
					<span class="h4">
						<a href="javascript:void(0)"><?php echo $data['num_leave'] ?></a>
					</span>
					<span class="info-description">取消关注</span>
				</div>
			</div>
			<div class="info-group">
				<div class="info-group__inner">
					<span class="h4">
						<a href="javascript:void(0)"><?php echo $data['num_pure_add'] ?></a>
					</span>
					<span class="info-description">净增关注</span>
				</div>
			</div>
		</div>
	</div>

	<div class="widget">
		<div class="widget-inner">
			<div class="widget-head">
				<h3 class="widget-title">微信会员关注统计 <span>(默认近7天)</span></h3>
			</div>
			<div class="widget-body">
				<div class="chart-line-box" id="chart-line"></div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>

	<div class="widget">

		<div class="ui-block app-block-pagerank ui-block-no-data">

			<div class="ui-block-head">
				<h3 class="block-title">详细数据</h3>
			</div>

			<div class="ui-block-body">
				<div class="js-body">
				<table class="ui-table">
					<thead>
						<tr>
							<th class="cell-37">日期</th>
							<th class="cell-12">新增粉丝</th>
							<th class="cell-12">跑路粉丝</th>
							<th class="cell-12">净增粉丝</th>
						</tr>
					</thead>
					<tbody class="js-list-tbody">
						<?php foreach ($statistic_list as $static) { ?>
						<tr>
							<td><?php echo $static['date'] ?></td>
							<td><?php echo $static['add'] ?></td>
							<td><?php echo $static['leave'] ?></td>
							<td><?php echo $static['pure_add'] ?></td>
						</tr>
						<?php } ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>
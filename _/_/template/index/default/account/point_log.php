<?php include display( 'public:person_header');?>

<script type="text/javascript" src="/static/js/plugin/jquery-ui.js"></script>
<script type="text/javascript" src="/static/js/plugin/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" href="/static/css/jquery.ui.css">

<style type="text/css">
	#search_order,.controls .ui-btn-primary,.controls .date-quick-pick,.controls span{font-size:12px; }
	#search_order{margin-left: 10px; float: left; }
	#search_order input{border: 1px solid #cccccc; width: 160px; padding: 5px; }
	#search_select select{margin-left: 50px; margin-top:2px; float: left; border: 1px solid #cccccc;padding: 5px; }
	.controls input {width: 135px; padding: 5px; border: 1px solid #cccccc; }
	.hasDatepicker[readonly] {background-color: #fff; cursor: pointer; }
	.controls input.input-large {width: 160px; }
	.controls select {width: 139px; }
	.controls .ui-btn {height:20px; line-height:20px; }
	.controls .ui-btn-primary {/* margin-left: 28px; margin-right: 10px;*/ /*font-size: 12px;*/ }
	.controls .date-quick-pick {display: inline-block; color: #07d; cursor: pointer; /*padding: 2px 4px;*/ /*border: 1px solid transparent;*/ margin-left: 12px; /*border-radius: 4px;*/ }
	.controls .date-quick-pick+.date-quick-pick {margin-left: 0; }
	.controls .date-quick-pick.current {background: #fff; border-color: #07d!important; }
	.controls .date-quick-pick:hover{border-color:#ddd;}

	/* 样式修改 */
	#con_one_1 form .danye_content_title {padding: 10px 0;font-size: 14px;}
	.danye_content .head_3 {width: 234px;}
	.order_list ul.order_list_list {margin-top:0;}
	.order_list {border-bottom:1px solid #ccc;margin-top:0;}
	.order_list:nth-child(odd) {background-color: #f1f1f1;}
	.order_list ul.order_list_list::after {min-height: 0; }
</style>
<script>
	//开始时间
    $('#js-stime').live('focus', function() {
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-etime').val() != '') {
                    $(this).datepicker('option', 'maxDate', new Date($('#js-etime').val()));
                }
            },
            onSelect: function() {
                if ($('#js-stime').val() != '') {
                    $('#js-etime').datepicker('option', 'minDate', new Date($('#js-stime').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($(this).datepicker('getDate'), $('#js-etime').datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-etime').datepicker('getDate'));
                }
            },
            _afterClose: function(date1, date2) {
                var starttime = 0;
                if (date1 != '' && date1 != undefined) {
                    starttime = new Date(date1).getTime();
                }
                var endtime = 0;
                if (date2 != '' && date2 != undefined) {
                    endtime = new Date(date2).getTime();
                }
                if (endtime > 0 && endtime < starttime) {
                    alert('无效的时间段');
                    return false;
                }
                return true;
            }
        };
        $('#js-stime').datetimepicker(options);
    })


    //结束时间
    $('#js-etime').live('focus', function(){
        var options = {
            numberOfMonths: 2,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            showSecond: true,
            beforeShow: function() {
                if ($('#js-stime').val() != '') {
                    $(this).datepicker('option', 'minDate', new Date($('#js-stime').val()));
                }
            },
            onSelect: function() {
                if ($('#js-etime').val() != '') {
                    $('#js-stime').datepicker('option', 'maxDate', new Date($('#js-etime').val()));
                }
            },
            onClose: function() {
                var flag = options._afterClose($('#js-stime').datepicker('getDate'), $(this).datepicker('getDate'));
                if (!flag) {
                    $(this).datepicker('setDate', $('#js-stime').datepicker('getDate'));
                }
            },
            _afterClose: function(date1, date2) {
                var starttime = 0;
                if (date1 != '' && date1 != undefined) {
                    starttime = new Date(date1).getTime();
                }
                var endtime = 0;
                if (date2 != '' && date2 != undefined) {
                    endtime = new Date(date2).getTime();
                }
                if (starttime > 0 && endtime < starttime) {
                    alert('无效的时间段');
                    return false;
                }
                return true;
            }
        };
        $('#js-etime').datetimepicker(options);
    })

    //最近7天或30天
    $('.date-quick-pick').live('click', function(){
        $(this).addClass('current');
        $(this).siblings('.date-quick-pick').removeClass('current');

        var tmp_days = $(this).attr('data-days');
        $('.js-stime').val(changeDate(tmp_days).begin);
        $('.js-etime').val(changeDate(tmp_days).end);
    })
    function changeDate(days){
	    var today=new Date(); // 获取今天时间
	    var begin;
	    var endTime;
	    if(days == 3){
	        today.setTime(today.getTime()-2*24*3600*1000);
	        begin = today.format('yyyy-MM-dd');
	        today = new Date();
	        today.setTime(today.getTime());
	        end = today.format('yyyy-MM-dd');
	    }else if(days == 7){
	        today.setTime(today.getTime()-6*24*3600*1000);
	        begin = today.format('yyyy-MM-dd');
	        today = new Date();
	        today.setTime(today.getTime());
	        end = today.format('yyyy-MM-dd');
	    }else if(days == 30){
	        today.setTime(today.getTime()-29*24*3600*1000);
	        begin = today.format('yyyy-MM-dd');
	        today = new Date();
	        today.setTime(today.getTime());
	        end = today.format('yyyy-MM-dd');
	    }
	    return {'begin': begin + ' 00:00:00', 'end': end + ' 23:59:59'};
	}

	//格式化时间
	Date.prototype.format = function(format){
	    var o = {
	        "M+" : this.getMonth()+1, //month
	        "d+" : this.getDate(),    //day
	        "h+" : this.getHours(),   //hour
	        "m+" : this.getMinutes(), //minute
	        "s+" : this.getSeconds(), //second
	        "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
	        "S" : this.getMilliseconds() //millisecond
	    }
	    if(/(y+)/.test(format)) {
	        format=format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
	    }
	    for(var k in o) {
	        if(new RegExp("("+ k +")").test(format)) {
	            format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
	        }
	    }
	    return format;
	}
</script>
<div class="menudiv">
	<div id="con_one_1" style="display: block;">
		<div class="danye_content_title">
			<div class="danye_suoyou"><a href="<?php echo url('account:point_log'); ?>"><span>积分明细</span></a></div>
			
		</div>
		<form action="<?php echo url('account:point_log') ?>" method="get">
		<div class="danye_content_title"> 
			<span id="search_order" >订单号 : <input type="text" name="order_no" value="<?php echo $_GET['order_no'];?>" /></span>
			<span id="search_select">
				<select name="type" id="type">
					<option value="*" <?php if(!isset($_GET['type'])){ echo 'selected';} ?>>请选择</option>
					<?php foreach ($point_type_arr as $key => $value) {	
						if($key == $_GET['type'] && $_GET['type'] != '*' && isset($_GET['type'])){
							$selected = 'selected';
						}else{
							$selected = '';
						}
					?>
					<option value="<?php echo $key;?>" <?php echo $selected?> ><?php echo $value;?></option>
					<?php
					}?>
				</select>
			</span>
			<div class="control-group" style="display: inline;float: right;">
	            
	            <div class="controls" style="display: inline;">
	                <input type="text" name="stime" class="js-stime" id="js-stime" value="<?php echo $_GET['stime'];?>" />
	                <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span>
	                <input type="text" name="etime" class="js-etime" id="js-etime" value="<?php echo $_GET['etime'];?>" />
	                <span class="date-quick-pick" data-days="7">最近7天</span>
	                &nbsp;
	                <span class="date-quick-pick" data-days="30">最近30天</span>
	                 &nbsp;&nbsp;&nbsp;&nbsp;
	                 <input type="hidden" name="c" value="account">
	                 <input type="hidden" name="a" value="point_log">
	                 <input type="submit" name="dosearch" value="查询" style="width: 50px;cursor:pointer;">
	            </div>
	        </div>
		</div>
		</form>

		<?php 
		if ($log_list) {
		?>
			<ul class="order_list_head clearfix">
				<li class="head_1">订单号</li>
				<li class="head_2">商家</li>
				<li class="head_3">内容</li>
				<li class="head_4">操作额度</li>
				<li class="head_5">时间</li>	
			</ul>
			<?php
			foreach ($log_list as $log) {
			?>
				<div class="order_list">
					<ul class="order_list_list" style="border: 0px;">
						<li class="head_1">
							<?php echo $log['order_no'];?>
						</li>
						<li class="head_2">
							<?php echo ($log['name']?$log['name']:'无');?>
						</li>
						<li class="head_3">
							<?php echo $log['bak'];?>
						</li>
						<li class="head_4">
							<?php echo $log['point'];?>
						</li>
						<li class="head_5">
							<?php echo date('Y-m-d H:i:s',$log['add_time']);?>
						</li>	
						<div style="clear:both;"></div>
					</ul>
				</div>
			<?php
			}
			if ($pages) {
			?>
				<style>
				.page_input {border: 1px solid #00bb88; width: 20px; height: 38px; float: left; margin-right: 5px; padding: 0 5px;}
				</style>
				<div class="page_list" id="pages" style="padding-top:20px;">
					<dl>
						<?php echo $pages ?>
					</dl>
				</div>
		<?php 
			}
		} else {
		?>
				<div style="line-height:30px; padding-top:30px; font-size:16px;">暂无记录</div>
			<?php 
			}
		
		?>
	</div>
</div>	
<?php include display( 'public:person_footer');?>
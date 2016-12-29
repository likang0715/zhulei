<params
	AjaxReturnPrizeUrl = "<?php echo '?a=ajaxReturnPrize&id='.$actioninfo['id'];  ?>"
	enddate = "<?php echo date('m/d/Y H:i:s', $actioninfo['endtime']); ?>"
	starttime = "<?php echo date('m/d/Y H:i:s', $actioninfo['starttime']); ?>"
	other_source = "<?php  echo $actioninfo['other_source']  ?>"
	notice_content = '<?php echo $notice_content;  ?>'
	staticPath = '{pigcms:$staticPath}'
	aid		   = '<?php echo $actioninfo['id']; ?>';
	user_id		   = '<?php echo $user_id; ?>'
	MyRecordUrl 	= "<?php echo '?a=lotteryMyRecord';  ?>"
	OtherRecordUrl 	= "<?php echo '?a=lotteryRecord&record_nums='.$actioninfo['record_nums'];  ?>"
/>
<div class="weiba-footer"><div class="weiba-copyright"></div></div>

<?php echo !empty($shareData) ? $shareData : ''; ?>
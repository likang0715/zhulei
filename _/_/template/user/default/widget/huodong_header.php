<?php
if ($_SERVER['SERVER_NAME'] != 'dd2.pigcms.com' && $_SERVER['SERVER_NAME'] != 'www.weidian.com' && $_SERVER['SERVER_NAME'] != 'd.pigcms.com') {
?>
<style>
    .hidFunc{display:none !important;}
</style>
<?php
}
?>

<script>
$(function(){
	$("select[name='select_type']").change(function(){
		var this_val = $(this).val();
		
		if("0" != this_val ) {
			var href = $("select ").find("option[value='"+this_val+"']").data("href");
			window.location.href= href;
		}
	})
})
</script>
<div class="modal-header">
	<a class="close js-news-modal-dismiss">×</a>
	<!-- 顶部tab -->
	<ul class="module-nav modal-tab">
		<!--  
		<li class="active"><a href="<?php dourl('activity_module',array('number'=>$_GET['number']));?>" class="js-modal-tab">预售活动</a></li>
		<li><a href="<?php dourl('activity_module_tuan',array('number'=>$_GET['number']));?>" class="js-modal-tab">团购活动</a></li>
		<li>|<a href="/user.php?c=appmarket&a=present" target="_blank" class="new_window">新建活动</a></li>
		-->
		
		<li><a href="<?php dourl('activity_module',array('huodong_type'=>'tuan','number'=>$_GET['number']));?>" class="js-modal-tab">团购活动</a></li>
		<li>|&nbsp;&nbsp;<a href="<?php dourl('activity_module',array('huodong_type'=>'presale','number'=>$_GET['number']));?>" class="js-modal-tab">预售活动</a></li>
		<?php if ($show_activity) { ?>
		<li>|&nbsp;&nbsp;<a href="<?php dourl('activity_module',array('huodong_type'=>'unitary','number'=>$_GET['number']));?>" class="js-modal-tab">一元夺宝</a></li>
		<li>|&nbsp;&nbsp;<a href="<?php dourl('activity_module',array('huodong_type'=>'zc','number'=>$_GET['number']));?>" class="js-modal-tab">众筹</a></li>
		<li>|&nbsp;&nbsp;
			<select name="select_type" style="width:auto;margin-bottom:0px;">
				<option value="0">其它活动</option>
				<option <?php if($huodong_type == 'seckill') { echo "selected='selected'"; }?>   value="seckill" data-href="<?php dourl('activity_module',array('huodong_type'=>'seckill','number'=>$_GET['number']));?>">秒杀</option>
				<option <?php if($huodong_type == 'bargain') { echo "selected='selected'"; }?>   value="bargain" data-href="<?php dourl('activity_module',array('huodong_type'=>'bargain','number'=>$_GET['number']));?>">砍价</option>
				<option <?php if($huodong_type == 'cutprice') { echo "selected='selected'"; }?>   value="cutprice" data-href="<?php dourl('activity_module',array('huodong_type'=>'cutprice','number'=>$_GET['number']));?>">降价拍</option>
			</select>
		</li>
		<?php } ?>
	</ul>
</div>
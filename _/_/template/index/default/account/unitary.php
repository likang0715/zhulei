<?php include display( 'public:person_header');?>
<script src="<?php echo TPL_URL;?>js/person_unitary.js"></script>
<script type="text/javascript">
	var load_url = "<?php dourl('account:unitary_load') ?>";
</script>
<div class="menudiv">
	<div id="con_one_1">
		<div class="danye_content_title js-tab-list">
			<div class="item-tab tab-act" data-status="all"><a href="javascript:"><span>参与记录</span></a></div>
			<div class="item-tab" data-status="reveal"><a href="javascript:"><span>即将揭晓</span></a></div>
			<div class="item-tab" data-status="ing"><a href="javascript:"><span>正在进行</span></a></div>
			<div class="item-tab" data-status="end"><a href="javascript:"><span>已揭晓</span></a></div>
			<div class="item-tab" data-status="order"><a href="javascript:"><span>夺宝订单</span></a></div>
		</div>
		<!-- 夺宝活动内容加载 -->
		<div class="unitary_con"></div>
	</div>
</div>
<?php include display( 'public:person_footer');?>
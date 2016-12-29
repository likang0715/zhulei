<style type="text/css">
.m-province { margin: 0 2px 2px 0; border:2px solid #00868b; background:#fff; color:#00868b; padding:4px 8px; float:left; }
.m-city { margin: 0 2px 2px 0; border:2px solid #00bfff; background:#fff; color:#00bfff; padding:4px 8px; float:left; }
.m-area { margin: 0 2px 2px 0; border:2px solid #7ec0ee; background:#fff; color:#7ec0ee; padding:4px 8px; float:left; }

.m-province.selected, .m-city.selected, .m-area.selected { background-color: #bf0000; border-color: #bf0000; color: #fff; }

.m-label { cursor:pointer; }

.confirm-box { width: 100%; float: left; }
.confirm-box .confirm-tit { width: 100%; float: left; }
.confirm-box .confirm-con { width: 100%; float: left; height: 0; overflow: hidden; }

.confirm-title { width: 100%; float: left; padding: 10px 0; background-color: #eef3f7; }
.confirm-title .cf-l { font-size: 14px; }
.confirm-title .cf-m { font-size: 14px; }
.confirm-title .t-reload { color: #FFF; border: solid 1px #3399dd; background: #2880C3; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#2880C3', endColorstr='#126DAD'); background: linear-gradient(top, #2880C3, #126DAD); background: -moz-linear-gradient(top, #2880C3, #126DAD); background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#2880C3), to(#126DAD)); text-shadow: -1px -1px 1px #1c6a9e; color: #FFF; border-color: #1c6a9e; float: right; padding: 4px 8px; }

.confirm-select { width: 100%; float: left; padding: 10px 0; }
.confirm-select .cs-label { width: 60px; padding: 4px 5px 4px 0; float: left; }

.confirm-province { width: 100%; padding: 10px 0; float: left; border-bottom: 1px solid #ccc; }
.confirm-city { width: 100%; padding: 10px 0; float: left; border-bottom: 1px solid #ccc; }
.confirm-area { width: 100%; padding: 10px 0; float: left; border-bottom: 1px solid #ccc; }

.confirm-label { margin: 0 2px 2px 0; background:#fff; width: 26px; text-align: center; padding:4px 8px; float:left; }
.confirm-province .confirm-label { border:2px solid #00868b; color:#00868b; }
.confirm-city .confirm-label { border:2px solid #00bfff; color:#00bfff; }
.confirm-area .confirm-label { border:2px solid #7ec0ee; color:#7ec0ee; }

</style>
<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Admin/agent_area')}" frame="true" refresh="true">
		<input type="hidden" name="uid" value="{pigcms{$now_admin.id}"/>

		<div class="confirm-title">
			<span class="cf-l">关联到 - </span>
			<span class="cf-m"></span>
			<input type=hidden name="admin_id" value="0">
			<a href="javascript:void(0)" onClick="window.location.reload();" class="t-reload">重置</a>
		</div>

		<div class="confirm-select">
			<span class="cs-label">选择区域:</span>
			<div class="js-regions-wrap" data-province="<?php if (!empty($about_area_admin)) { echo $about_area_admin['province']; } ?>" data-city="<?php if (!empty($about_area_admin)) { echo $about_area_admin['city']; } ?>" data-county="">
				<span><select name="province" id="s1" data-province="<?php if (!empty($about_area_admin)) { echo $about_area_admin['province']; } ?>"><option value="">选择省份</option></select></span>
				<span><select name="city" id="s2" data-city="<?php if (!empty($about_area_admin)) { echo $about_area_admin['city']; } ?>"><option value="">选择城市</option></select></span>
				<!-- <span><select name="county" id="s3"><option value="">选择地区</option></select></span> -->
			</div>
		</div>

		<div class="confirm-province">
			<div class="confirm-label">省份</div>
			<?php foreach ($area_all as $val) { ?>

				<?php if (isset($admin_array['province'][$val['province_code']])) { ?>
				<div class="m-area-item m-province <?php if ($admin_array['province'][$val['province_code']]['id'] == $about_area_admin['id']) { echo 'selected'; } ?>" data-code="<?php echo $val['province_code'] ?>" data-account="<?php echo $admin_array['province'][$val['province_code']]['account'] ?>" data-id="<?php echo $admin_array['province'][$val['province_code']]['id'] ?>">
					<label class="m-label" data-address="<?php echo $val['province'] ?>">
						<span style=""><?php echo $val['province'] ?></span> [<?php echo $admin_array['province'][$val['province_code']]['account'] ?>]
					</label>
				</div>
				<?php } ?>

			<?php } ?>
		</div>

		<div class="confirm-city">
			<div class="confirm-label">城市</div>
			<?php foreach ($area_all as $val) { ?>
				<?php foreach ($val['city'] as $vo2) { ?>
					<?php if (isset($admin_array['city'][$vo2['city_code']])) { ?>
					<div class="m-area-item m-city <?php if ($admin_array['city'][$vo2['city_code']]['id'] == $about_area_admin['id']) {echo 'selected'; } ?> province_box_<?php echo $val['province_code'] ?>" data-code="<?php echo $vo2['city_code'] ?>" data-id="<?php echo $admin_array['city'][$vo2['city_code']]['id'] ?>" data-account="<?php echo $admin_array['city'][$vo2['city_code']]['account'] ?>" style="/*display:none*/">
						<label class="m-label" data-address="<?php echo $val['province'].'-'.$vo2['city'] ?>">
							<span><?php echo $vo2['city'] ?></span> [<?php echo $admin_array['city'][$vo2['city_code']]['account'] ?>] 
						</label>
					</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>

		</div>
		
		<div class="confirm-area">
			<div class="confirm-label">区县</div>
			<?php foreach ($area_all as $val) { ?>
			<?php foreach ($val['city'] as $vo2) { ?>
				<?php foreach ($vo2['area'] as $vo3) { ?>
					<?php if (isset($admin_array['area'][$vo3['area_code']])) { ?>
					<div class="m-area-item m-area <?php if ($admin_array['area'][$vo3['area_code']]['id'] == $about_area_admin['id']) {echo 'selected'; } ?> province_box_<?php echo $val['province_code'] ?> city_box_<?php echo $vo2['city_code'] ?>" data-code="<?php echo $vo3['area_code'] ?>" data-id="<?php echo $admin_array['area'][$vo3['area_code']]['id'] ?>" data-account="<?php echo $admin_array['area'][$vo3['area_code']]['account'] ?>" style="/*display:none*/">
						<label class="m-label" data-address="<?php echo $val['province'].'-'.$vo2['city'].'-'.$vo3['area'] ?>">
							<span><?php echo $vo3['area'] ?></span> [<?php echo $admin_array['area'][$vo3['area_code']]['account'] ?>]
						</label>
					</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<?php } ?>
		</div>
		
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>
<script type="text/javascript" src="{pigcms{$static_public}js/area/area.min.js"></script>
<script type="text/javascript">
$(function(){

	var initArea = function () {

		if ($('.js-regions-wrap').data('province') == '') {
			getProvinces('s1','');
		} else {
			getProvinces('s1', $('.js-regions-wrap').data('province'));
			($("#s2").length > 0) ? getCitys('s2','s1', $('.js-regions-wrap').data('city')) : true;
			// ($("#s3").length > 0) ? getAreas('s3','s2', $('.js-regions-wrap').data('county')) : true;
		}

	}

	$('#s1').live('change', function(){
		if ($(this).val() != '') {
			selectItem('province', $(this).val());
			getCitys('s2','s1','');
		} else {
			selectItem('province', 0);
			$('#s2').html('<option value="">选择城市</option>');
		}

		// $('#s3').html('<option value="">选择地区</option>');
	});

	$('#s2').live('change', function(){
		if ($(this).val() != '') {
			selectItem('city', $(this).val());
			// getAreas('s3','s2','');
		} else {
			selectItem('province', $('#s1').val());
			// $('#s3').html('<option value="">选择地区</option>');
		}

	});

	// $('#s3').live('change', function(){
	// 	if ($(this).val() != '') {
	// 		selectItem('area', $(this).val());
	// 	} else {
	// 		selectItem('area', 0);
	// 	}
	// });


	var choseAdmin = function (btn) {
		$(".confirm-title .cf-m").text(btn.find('label').data('address')+'【'+btn.data('account')+'】');
		$("input[name=admin_id]").val(btn.data('id'));
	}

	var selectItem = function (areaLevel, code) {

		if (areaLevel == 'province') {

			if (code == 0) {
				$(".m-province").show();
				$(".confirm-city-item,.confirm-area-item").hide();
				return;
			}

			$('.m-area-item:visible').hide();
			$('[data-code='+code+']').show();
			$('.province_box_'+code).show();

		} else if (areaLevel == 'city') {

			if (code == 0) {
				return;
			} 

			// 城市隐藏
			$(".confirm-city").find(".m-area-item:visible").hide();
			$('[data-code='+code+']').show();

			// 显示对应区县
			$(".confirm-area").find(".m-area-item:visible").hide();
			$('.city_box_'+code).show();

		} else {
			return;
		}

	}

	var all_province = $(".m-province");
	var all_city = $(".confirm-city-item");
	var all_area = $(".confirm-area-item");

	$(".m-area-item").bind('click', function(){

		var self = $(this);
		var code = self.data('code');

		if (self.hasClass("selected")) {
			self.removeClass("selected");
			return;
		}

		$("#myform").find(".selected").removeClass("selected");
		self.addClass("selected");
		choseAdmin(self);
	});

	// init
	if ($(".selected").length > 0) {
		choseAdmin($(".selected"));
	}

	if ($(".js-regions-wrap").data('province') != '') {
		selectItem('province', $(".js-regions-wrap").data('province'));
	}

	if ($(".js-regions-wrap").data('city') != '') {
		selectItem('city', $(".js-regions-wrap").data('city'));
	}

	initArea();

	$("#dosubmit").bind("click", function(){
		$('.myform').submit();
	});

})
</script>
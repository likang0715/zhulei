<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<script type="text/javascript">
	$(function(){

		$(".ui-sidebar nav > ul").click(function(){
			$(this).addClass("ul_list").siblings().removeClass("ul_list");
		});

		$(".ui-sidebar nav > ul").each(function(){
			var oHeadUl = $(this);
			var oConUl = $("li > ul", oHeadUl);
			var oConLi = $("li", oConUl);

			if ($("li.active", oConUl).length > 0) {
				oHeadUl.trigger("click");
			}

		});

	})
</script>
<aside class="ui-sidebar sidebar">
	<nav class="clearfix">
		<ul class="">
			<li>
                <h4>基础营销</h4>
            </li>
            <li>
            	<ul class="clearfix">
            		<?php if(in_array(PackageConfig::getRbacId(11,'appmarket','present'), $rbac_result) || $package_id == 0){?>
            		<li  <?php if(in_array($select_sidebar,array('present','statistics'))) echo 'class="active"';?>>
						<a href="<?php dourl('appmarket:present');?>" >赠品</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'reward','reward_index'), $rbac_result) || $package_id == 0){?>
					<li <?php if(in_array($select_sidebar,array('reward_index','statistics'))) echo 'class="active"';?>>
						<a href="<?php dourl('reward:reward_index');?>">满减/送</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'preferential','coupon'), $rbac_result) || $package_id == 0){?>
					<li <?php if(in_array($select_sidebar,array('coupon','statistics'))) echo 'class="active"';?>>
						<a href="<?php dourl('preferential:coupon');?>">优惠券</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'peerpay','peerpay_index'), $rbac_result) || $package_id == 0){?>
					<?php if(!in_array($my_version,array('1','5'))){?>
					<li <?php if(in_array($select_sidebar,array('peerpay_index'))) echo 'class="active"';?>>
						<a href="<?php dourl('peerpay:peerpay_index');?>">找人代付</a>
					</li>
					<?php } ?>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'appmarket','presale'), $rbac_result) || $package_id == 0){?>
					<li <?php if(in_array($select_sidebar,array('presale','statistics'))) echo 'class="active"';?>>
						<a href="<?php dourl('appmarket:presale');?>">预售</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'tuan','tuan_index'), $rbac_result) || $package_id == 0){?>
					<li <?php if(in_array($select_sidebar, array('tuan_index'))) echo 'class="active"';?>>
						<a href="<?php dourl('tuan:tuan_index');?>">拼团活动</a>
					</li>
					<?php } ?>

            	</ul>
            </li>
		</ul>
	</nav>
</aside>
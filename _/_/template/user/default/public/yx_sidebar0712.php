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
<!-- 		<ul class="" >
	<li>
                <h4>应用营销概况</h4>
            </li>
            <li>
            	<ul class="clearfix">
			<li <?php if(in_array($select_sidebar,array('dashboard','statistics'))) echo 'class="active"';?>>
				<a href="<?php dourl('appmarket:dashboard');?>">应用营销概况</a>
			</li>
            	</ul>
            </li>
        </ul> -->
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
<?php if($show_activity!=0) {?>
		<?php if(!in_array($my_version,array('1','5')) && in_array($show_activity,array('1','2'))) {?>
		<ul class="">
			<li>
                <h4>特色营销</h4>
            </li>
            <li>
            	<ul class="clearfix">

					<?php if(in_array(PackageConfig::getRbacId(11,'wxapp','api&act=bargain'), $rbac_result) || $package_id == 0){?>

					<li <?php if($_GET['act'] == 'bargain') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'bargain'));?>">砍价</a>
					</li>

					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'wxapp','api&act=seckill'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'seckill') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'seckill'));?>">秒杀</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'wxapp','api&act=crowdfunding'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'crowdfunding') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'crowdfunding'));?>">众筹</a>
					</li>
					<?php } ?>

					
					<?php if(in_array(PackageConfig::getRbacId(11,'wxapp','api&act=unitary'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'unitary') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'unitary'));?>" >一元夺宝</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'wxapp','api&act=cutprice'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'cutprice') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'cutprice'));?>" >降价拍</a>
					</li>
					<?php } ?>
					
					<?php if(in_array(PackageConfig::getRbacId(11,'wxapp','api&act=red_packet'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'red_packet') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'red_packet'));?>" >微信红包</a>
					</li>
					<?php } ?>

            	</ul>
        	</li>
		</ul>
		<?php } ?>
		<?php if(!in_array($my_version,array('1','2','5','6'))  && in_array($show_activity,array('1','2'))) { ?>
		<ul class="">
			<li>
                <h4>活动营销</h4>
            </li>
            <li>
            	<ul class="clearfix">

				<?php if(in_array(PackageConfig::getRbacId(12,'wxapp','api&act=lottery'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'lottery') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'lottery'));?>" >大转盘</a>
					</li>
				<?php } ?>

				<?php if(in_array(PackageConfig::getRbacId(12,'wxapp','api&act=guajiang'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'guajiang') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'guajiang'));?>" >刮刮卡</a>
					</li>
				<?php } ?>

				<?php if(in_array(PackageConfig::getRbacId(12,'wxapp','api&act=jiugong'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'jiugong') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'jiugong'));?>" >九宫格</a>
					</li>
				<?php } ?>

				<?php if(in_array(PackageConfig::getRbacId(12,'wxapp','api&act=jiugong'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'luckyFruit') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'luckyFruit'));?>" >幸运水果机</a>
					</li>
				<?php } ?>

				<?php if(in_array(PackageConfig::getRbacId(12,'wxapp','api&act=goldenEgg'), $rbac_result) || $package_id == 0){?>
					<li <?php if($_GET['act'] == 'goldenEgg') echo 'class="active"';?>>
						<a href="<?php dourl('wxapp:api',array('act'=>'goldenEgg'));?>" >砸金蛋</a>
					</li>
				<?php } ?>
            	</ul>
            </li>
       </ul>
		<?php } ?>

		<?php if(!in_array($my_version,array('1','2','5','6'))   && in_array($show_activity,array('1','3'))) { ?>
        <ul>
            <li>
                <h4>新营销活动</h4>
            </li>
            <li>
                <ul class="clearfix">
					<?php if(in_array(PackageConfig::getRbacId(11,'bargain','index'), $rbac_result) || $package_id == 0){?>
                    <li class="<?php if(in_array($select_sidebar, array('bargain'))) echo "active";?>">
                        <a href="<?php dourl('bargain:index');?>">砍价</a>
                    </li>
                    <?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'unitary','unitary_index'), $rbac_result) || $package_id == 0){?>
					<li class="<?php if(in_array($select_sidebar, array('unitary_index'))) echo "active";?>">
						<a href="<?php dourl('unitary:unitary_index');?>">一元夺宝</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'seckill','seckill_index'), $rbac_result) || $package_id == 0){?>
					<li class="<?php if(in_array($select_sidebar, array('seckill_index'))) echo "active";?>">
						<a href="<?php dourl('seckill:seckill_index');?>">秒杀</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'cutprice','cutprice_index'), $rbac_result) || $package_id == 0){?>
					<li class="<?php if(in_array($select_sidebar, array('cutprice_index'))) echo "active";?>">
						<a href="<?php dourl('cutprice:cutprice_index');?>">降价拍</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'wzc','wzc_index'), $rbac_result) || $package_id == 0){?>
					<li class="<?php if(in_array($select_sidebar, array('wzc_index'))) echo "active";?>">
						<a href="<?php dourl('wzc:wzc_index');?>">微众筹</a>
					</li>
					<?php } ?>
					<?php if(in_array(PackageConfig::getRbacId(12,'shakelottery','shakelottery_index'), $rbac_result) || $package_id == 0){?>
					<li class="<?php if(in_array($select_sidebar, array('shakelottery_index'))) echo "active";?>">
						<a href="<?php dourl('shakelottery:shakelottery_index');?>">摇一摇抽奖</a>
					</li>
					<?php } ?>
					<?php if(in_array(PackageConfig::getRbacId(11,'lottery','lottery_index'), $rbac_result) || $package_id == 0){?>
					<li class="<?php if(in_array($select_sidebar, array('lottery_index'))) echo "active";?>">
						<a href="<?php dourl('lottery:lottery_index');?>">抽奖活动合集</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'lottery_words','words_index'), $rbac_result) || $package_id == 0){?>
					<li class="<?php if(in_array($select_sidebar, array('words_index'))) echo "active";?>">
						<a href="<?php dourl('lottery_words:words_index');?>">集字游戏</a>
					</li>
					<?php } ?>

                </ul>
            </li>
        </ul>
        <?php } ?>

        <ul class="testFunc">
            <li>
                <h4>内测活动</h4>
            </li>
            <li>
                <ul class="clearfix">
                    <?php //if(in_array(PackageConfig::getRbacId(11,'helping','helping_index'), $rbac_result) || $package_id == 0){?>
                        <li class="<?php if(in_array($select_sidebar, array('helping'))) echo "active";?>">
                            <a href="<?php dourl('helping:helping_index');?>">微助力</a>
                        </li>
                    <?php //} ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'yousetdiscount','yousetdiscount_index'), $rbac_result) || $package_id == 0){?>
					<li class="<?php if(in_array($select_sidebar, array('yousetdiscount_index'))) echo "active";?>">
						<a href="<?php dourl('yousetdiscount:yousetdiscount_index');?>">优惠接力</a>
					</li>
					<?php } ?>

					<?php if(in_array(PackageConfig::getRbacId(11,'lottery','lottery_index'), $rbac_result) || $package_id == 0){?>
					<li class="<?php if(in_array($select_sidebar, array('lottery_index'))) echo "active";?>">
						<a href="<?php dourl('lottery:lottery_index');?>">摇钱树</a>
					</li>
					<?php } ?>
					
                </ul>
            </li>
        </ul>
<?php } ?>
	</nav>
</aside>
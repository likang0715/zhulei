<?php if(empty($noFooterLinks) && empty($noFooterCopy)){ ?>
	<div class="js-footer">          
		<div class="footer">
			<div class="copyright">
			
				<?php if(empty($noFooterLinks)){ ?>
					<div class="ft-links">
						<a href="<?php echo $now_store['url'];?>">店铺主页</a>
						<a href="<?php echo $now_store['ucenter_url'];?>">会员中心</a>
						<!-- <a href="diancha.php?id=<?php echo $now_store['store_id'];?>">点茶预约</a> -->
						<!-- <a href="chahui.php?id=<?php echo $now_store['store_id'];?>">茶会主页</a> -->
					    <?php if($now_store['physical_count']){ ?><a href="<?php echo $now_store['physical_url'];?>">线下门店</a><?php } ?>
					</div>
				<?php } ?>
				<?php if(0 && empty($noFooterCopy)){ ?>
					<div class="ft-copyright">
						<a href="<?php echo $config['wap_site_url'];?>" target="_blank">由&nbsp;<span class="company"><?php echo $config['site_name'];?></span>&nbsp;提供技术支持</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	if(!empty($_GET['platform']) || !empty($_SESSION['platform'])){
		$_SESSION['platform'] = 1;
?>
		<div class="common_nav" id="quckArea">
		    <div class="common_nav_main" id="quckMenu">
		          <ul>
		            <a href="./index.php"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon01.png">
		                <p>首页</p>
		            </li></a>
		            <a href="./category.php"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon02.png">
		                <p>茶品</p>
		            </li></a>
		            <a href="./weidian.php"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon03.png">
		                <p>茶馆</p>
		            </li></a>
		            <a href="./chahui.php"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon04.png">
		                <p>茶会</p>
		            </li></a>
		            <a href="./my.php"> <li>
		                <img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon05_cur.png">
		                <p class="common_nav_cur">我的</p>
		            </li></a>
		        </ul>
		    </div>
		</div>
		<?php } ?>
<!-- 新底部样式 -->
<style>
.clear{
    clear: both;
}
.footer_l{
    float: left;
    margin-left:7px;
    width:122px;
    display:block;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}
.g-footer {
    position: relative;
    background-color: #f5f5f5;
    z-index: 1;
}
.g-main {
    float: left;
}
.m-instruction {
    padding: 30px 0 10px;
}

.m-instruction .g-main {
    margin-left: 15px;
}

.m-instruction .g-side {
    width: 43%;
}

.m-instruction .g-side-l {
    float: left;
    width: 175px
}

.m-instruction .g-side-r {
    float: left;
    width: 120px;
}

.m-instruction{
	text-align:left;
}

.m-instruction-list-item {
    float: right;
    margin-right:25px;
    
}
.m-instruction-list-item:first-child{
    margin-right:5px;
}

.m-instruction-list-item h5 {
    margin-bottom: 6px;
    padding: 4px 0;
    height: 22px;
    font-size: 16px;
    line-height: 22px;
    font-weight: bold;
    font-family: "Microsoft Yahei";
}

.m-instruction-list-item .list {
    padding-left: 18px;
}

.m-instruction-list-item li {
    list-style: disc inside;
    line-height: 22px;

}

.m-instruction-list-item a {
    color: #808080;

}

.m-instruction-state {
    margin: 0 auto;
    width: 170px;
    font-family: "Microsoft Yahei";
}

.m-instruction-state li {
    padding: 3px 0;
    height: 34px;
    line-height: 34px;
    font-size: 14px;
}

.m-instruction-yxCode {
    float: left;
    padding: 0;
    width: 115px;
    text-align: center;
    padding-left:15px;
    margin-left:5px;
}

.m-instruction-yxCode img {
    margin: 0 auto;
}

.m-instruction-service {
    float: right;
    margin-top: 30px;
    padding: 10px;
    font-size: 14px;
}

.m-instruction-service-call {
    padding: 4px 0;
    height: 18px;
    line-height: 18px;
    font-size: 16px;
    font-weight: bold;
    font-family: "MicroSoft Yahei";
    background-position: -235px -26px;
}

.m-instruction-service-phoneNum {
    font-style: italic;
    color: #db3652;
    font-size: 16px;
    font-weight: bold;
}

.m-instruction-110 {
    position: absolute;
    right: 30px;
    bottom: 5px;
    font-size: 14px;
    font-family: 'Microsoft Yahei'
}

.m-instruction-110 a {
    color: #808080;
    text-decoration: none;
}

.m-instruction-110 img {
    display: inline;
    vertical-align: middle;
}

.m-instruction-list-item h5{
    text-indent: 18px;
}
.g-csda{
    width:310px !important;
    border-left:solid 1px #e1e1e1;
    padding-left:15px;
}
.m-instruction-img-small{
    width:34px;
    height:34px;
}
</style>

<div class="g-footer">
    <div class="m-instruction">
        <div class="g-wrap f-clear">
            <div class="g-main g-sdaf">
                <ul class="m-instruction-list">
                    
                    <?php if($public_footer_config['menu_1']){?>
                    <li class="m-instruction-list-item">
                        
                        <h5><?php echo $public_footer_config['menu_1']?></h5>
                        <?php if($new_flink_list['menu_1']){?>
                        <ul class="list">
                        	<?php
                        	 foreach ($new_flink_list['menu_1'] as $key => $flink) {
                        	?>
                        	<li><a href="<?php echo $flink['url'] ?>" target="_blank"><?php echo $flink['name'] ?></a>
                        	</li>
                        	<?php }?>
                        </ul>
                        <?php }?>
                    </li>
                    <?php }?>

                    <?php if($public_footer_config['menu_2']){?>
                    <li class="m-instruction-list-item">
                        
                        <h5><?php echo $public_footer_config['menu_2']?></h5>
                        <?php if($new_flink_list['menu_2']){?>
                        <ul class="list">
                        	<?php
                        	 foreach ($new_flink_list['menu_2'] as $key => $flink) {
                        	?>
                        	<li>
                        	<a href="<?php echo $flink['url'] ?>" target="_blank"><?php echo $flink['name'] ?></a>
                        	</li>
                        	<?php }?>
                        </ul>
                        <?php }?>
                    </li>
                    <?php }?>

                    <?php if($public_footer_config['menu_3']){?>
                    <li class="m-instruction-list-item">
                        
                        <h5><?php echo $public_footer_config['menu_3']?></h5>
                        <?php if($new_flink_list['menu_3']){?>
                        <ul class="list">
                        	<?php
                        	 foreach ($new_flink_list['menu_3'] as $key => $flink) {
                        	?>
                        	<li>
                        	<a href="<?php echo $flink['url'] ?>" target="_blank"><?php echo $flink['name'] ?></a>
                        	</li>
                        	<?php }?>
                        </ul>
                        <?php }?>
                    </li>
                    <?php }?>

                    <?php if($public_footer_config['menu_4']){?>
                    <li class="m-instruction-list-item">
                        
                        <h5><?php echo $public_footer_config['menu_4']?></h5>
                        <?php if($new_flink_list['menu_4']){?>
                        <ul class="list">
                        	<?php
                        	 foreach ($new_flink_list['menu_4'] as $key => $flink) {
                        	?>
                        	<li>
                        	<a href="<?php echo $flink['url'] ?>" target="_blank"><?php echo $flink['name'] ?></a></li>
                        	<?php }?>
                        </ul>
                        <?php }?>
                    </li>
                    <?php }?>

                    
                   

                </ul>

            </div>
            <div class="g-main g-csda">
                <div class="g-side-l">
                    <ul class="m-instruction-state f-clear">
                      <?php if($public_footer_config['nav_1']){?> 
                        <li>
	                        <?php if($public_footer_config['nav_1_pic']){?>
	                        <img class="m-instruction-img-small fl" src="<?php echo getAttachmentUrl($public_footer_config['nav_1_pic'])?>" alt="">
	                        <?php }?>
	                        <span class="footer_l"><?php echo $public_footer_config['nav_1']?></span>
	                        <span class="clear"></span>
                        </li>
                       <?php }?>

                       <?php if($public_footer_config['nav_2']){?> 
                        <li>
	                         <?php if($public_footer_config['nav_2_pic']){?>
	                        <img class="m-instruction-img-small fl" src="<?php echo getAttachmentUrl($public_footer_config['nav_2_pic'])?>" alt="">
	                        <?php }?>
	                        <span class="footer_l"><?php echo $public_footer_config['nav_2']?></span>
	                        <span class="clear"></span>
                        </li>
                       <?php }?>

                       <?php if($public_footer_config['nav_3']){?> 
                        <li>
	                        <?php if($public_footer_config['nav_3_pic']){?>
	                        <img class="m-instruction-img-small fl" src="<?php echo getAttachmentUrl($public_footer_config['nav_3_pic'])?>" alt="">
	                        <?php }?>
	                        <span class="footer_l"><?php echo $public_footer_config['nav_3']?></span>
	                        <span class="clear"></span>
                        </li>
                       <?php }?>

                    </ul>
                </div>
                <?php if($public_footer_config['wx']){
                   if($public_footer_config['wx_link']){
                        $_url = strstr($public_footer_config['wx_link'],'http://');
                        $wx_link = $_url?$_url:'http://'.$public_footer_config['wx_link'];
                   }else{
                        $wx_link = '';
                   }  
                ?>
                <div class="g-side-r">
                    <div class="m-instruction-yxCode">
                        <a href="<?php echo $wx_link;?>" target="_blank"><img width="100%" src="<?php echo getAttachmentUrl($public_footer_config['wx'])?>"></a>
                        <p style="line-height:12px;"><?php echo $public_footer_config['wx_title']?></p>
                    </div>
                </div>
                 <?php }?>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</div>
<script>
    $(function() {
        var leftwidth = $(".g-sdaf").outerWidth(true);
        var rightwidth = $(".g-csda").outerWidth(true);
        var winwidth = $(document).width();
        $(".g-sdaf").css("margin-left", (winwidth - (leftwidth + rightwidth)) / 2);
//        console.log(winwidth - leftwidth + rightwidth)
    });
</script>

<div class="footer1 " style="margin-top:0px; height:auto;padding:15px 0;" >
	<div class="footer_txt">
		<div class="footer_txt">
			<?php echo $config['site_footer'] ?><?php echo $config['site_icp'] ?>
		</div>
	</div>
</div>


<!--二维码弹出层-->
<style>
.right-red-radius {background-color: #cc0000; border-radius: 10px;}
.mui-mbar-tab-sup-bd {font-size:12px;}
</style>
<div class="content_rihgt" id="leftsead" style="position: fixed; top: 352px;">
	<ul>
		<li class="content_rihgt_shpping">
			<div id="cartbottom">
				<div class="right-red-radius" style="margin-top: 0px; color:#fff; position: absolute;z-index:2; width: 20px; height: 22px; font-size: 12px;line-height:22px;">
					<div class="mui-mbar-tab-sup-bd"><?php  if(($cart_number + 0)>99) {echo "99";}else{echo $cart_number + 0;} ?></div>
				</div>
			</div>
		</li>
		<li class="content_rihgt_erweima">
			<a href="javascript:void(0)">
				<div class="content_rihgt_erweima_img"><img src="<?php echo option('config.wechat_qrcode');?>"></div>
			</a>
		</li>
		<li class="content_rihgt_gotop"><a href="javascript:scroll(0,0)"></a></li>
	</ul>
</div>
<script>
<!-- 代码 结束 -->
function addCart_pf(event) {
	$("#leftsead").show();
	var offset = $('#cartbottom').offset(), flyer = $('<div class="right-red-radius" style="margin-top: 0px; color:#fff; position: absolute;z-index:9999; width: 20px; height: 22px; font-size: 12px;line-height:22px;"><div class="mui-mbar-tab-sup-bd"></div></div>');
	offset.top="352";
	
	flyer.fly({
		start: {left : event.pageX, top: event.clientY - 30},
		end: {left : offset.left, top : offset.top, width : 20, height : 20},
		onEnd: function() {
			var cart_number = parseInt($("#header_cart_number").text());
			if(cart_number > 99) {
				cart_number = 99;
			}
			$(".mui-mbar-tab-sup-bd").html(cart_number);
		}
	});
}
$(function () {
	$(".content_rihgt_shpping").css("cursor", "pointer");
	$(".content_rihgt_shpping").click(function () {
		location.href = "<?php echo url('cart:one') ?>";
	});
})
</script>
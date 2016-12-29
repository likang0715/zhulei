<!-- 夺宝 - 个人中心 - 参与记录 -->
<div class="content">
    <?php if (empty($cartList)) { ?>
    <div class="f-clear">现在空空如也哦，不来一发吗？</div>
    <?php } else { ?>
    <div class="m-detail-recordList-start"><i class="ico ico-clock"></i></div>
    <div>
        <div class="m-detail-recordList-timeSeperate"><?php if (count($cartList) > 0) { echo date('Y-m-d', $cartList[0]['addtime']); } ?><i class="ico ico-recordDot ico-recordDot-solid"></i></div>
        <ul class="m-detail-recordList js-buy-list">
        <?php foreach ($cartList as $val) { ?>
            <li class="f-clear">
                <span class="time"><?php echo date('H:i:s', $val['addtime']) ?></span>
                <i class="ico ico-recordDot ico-recordDot-hollow"></i>
                <div class="m-detail-recordList-userInfo">
                    <div class="inner">
                        <p>
                            <span class="avatar">
                                <img width="20" height="20" src="http://nos.netease.com/mail-userthumb/0b9c09e3dc7cc5666a30fddba4a67354_40.jpeg">
                            </span>
                            <a href="/user/index.do?cid=63598136" target="_blank"><?php echo $val['user']['nickname'] ?></a> (<?php echo $val['user']['province'] ?> IP：<?php echo $val['user']['last_ip'] ?>) 参与了<b class="times txt-red"><?php echo $val['count'] ?>人次</b> <a class="w-button w-button-simple btn-checkCodes" style="display:none" data-cart_id="<?php echo $val['id'] ?>" href="javascript:void(0)">所有夺宝号码
                            <i class="ico ico-arrow-gray ico-arrow-gray-down"></i></a>
                        </p>
                        <a style="display:none" class="btn-close" href="javascript:void(0)">x</a>
                    </div>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
    <?php } ?>
</div>
<div class="pager">
    <div class="w-pager js-buyList-page"><?php echo $pages ?></div>
</div>
<script type="text/javascript">
$(function(){

    // 购买记录效果
    $(".js-buy-list li").each(function(){

        var self = $(this);
        var hoverArea = self.find(".m-detail-recordList-userInfo");
        var clickBtn = self.find(".btn-checkCodes");
        var showArea = self.find(".m-detail-recordList-userInfo");
        var closeBtn = showArea.find(".btn-close");
        var htm = '<p class="codes"></p>';

        // hover效果
        hoverArea.hover(function(){
            if (showArea.hasClass("m-detail-recordList-userInfo-detail")) {
                return;
            }
            clickBtn.show();
        }, function(){
            clickBtn.hide();
        });

        // 显示
        clickBtn.click(function(){

            showArea.addClass("m-detail-recordList-userInfo-detail");
            closeBtn.show();

            if (showArea.find(".codes").length == 0) {
                $.post(cart_lucknum_url, { cart_id:clickBtn.data('cart_id') }, function(data){

                    if (data.err_code == 0) {
                        var lucknumNum = data.err_msg.lucknum_list;

                        var htm = '<p class="codes">';
                        for (i in lucknumNum) {
                            htm += '<b>'+lucknumNum[i]+'</b>';
                        }
                        htm += '</p>';
                        $(".inner", showArea).append(htm);
                    } else {
                        alert('出现错误，刷新后再试')
                    }

                },'json');
            }

            showArea.find(".codes").show();

            return;
        });

        // 关闭
        closeBtn.click(function(){
            showArea.removeClass("m-detail-recordList-userInfo-detail");
            closeBtn.hide();
            showArea.find(".codes").hide();
        });


    });
})
</script>
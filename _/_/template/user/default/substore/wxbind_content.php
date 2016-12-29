<style type="text/css">
    .bind_qrcode-box { padding-top: 20px; padding-bottom: 20px; margin-bottom: 20px; background-color: #fff; }
</style>
<div class="widget-list">
    <div class="ui-box">
        <div class="ui-box">
            <?php if ($store_info['openid']) { ?>

                <div class="bind_qrcode-box">
                    <p style="text-align:center;">
                        绑定的微信openid为: <?php echo $store_info['openid'] ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:confirm('确定取消吗？');" data-store_id="<?php echo $store_info['store_id'];?>" class="del_bind">取消绑定</a>
                    </p>
                </div>
                <div class="js-list-empty-region">
                    <div>
                        <div class="no-result widget-list-empty" style="color: #0c0;">
                            您已经绑定微信
                        </div>
                    </div>
                </div>

            <?php } else { ?>

                <?php if ($qrcode_return['error_code']) { ?>
                <div class="bind_qrcode-box">
                    <p style="text-align:center;color: #f00"><?php echo $qrcode_return['msg'] ?></p>
                </div>
                <?php } else { ?>
                <div class="bind_qrcode-box">
                    <p style="margin-bottom:0px;text-align:center;font-size: 14px;">请使用微信扫描二维码绑定</p>
                    <p style="text-align:center;"><img src="<?php echo $qrcode_return['ticket'];?>" style="width:260px;height:260px;background:url('<?php echo STATIC_URL;?>images/lightbox-ico-loading.gif') no-repeat center"/></p>
                </div>
                <div class="js-list-empty-region">
                    <div>
                        <div class="no-result widget-list-empty" style="color: #f00;">微信通知消息需要您绑定微信才能收到。</div>
                    </div>
                </div>
                <?php } ?>

            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box"></div>
</div>
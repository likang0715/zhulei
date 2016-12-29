<style type="text/css">
    .dash-bar .info-group {
        float: left;
        width: 25.33%;
        padding-top: 18px;
    }
    .widget .chart-body {
        height: 345px;
    }
    .form-horizontal input {
        width: 206px!important;
    }
    .form-actions input {
        width: auto!important;
        height: auto;
    }
    input[type="radio"] {
        margin: 0;
        vertical-align: middle;
    }
    input[type="button"] {
        width: auto!important;
    }
</style>
<?php $version = option('config.weidian_version');?>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>粉丝终身制</h3>
        <div>
            <p>店铺开启粉丝终身制，访问的用户成为该店铺的粉丝后，再访问其它人的店铺，还是会跳到之前绑定的店铺。</p>
            <p><a href="javascript:void(0);" class="fans-list">粉丝列表>></a></p>
        </div>
    </div>
    <div class="widget-app-board-control fans_lifelong">
        <label class="js-switch ui-switch pull-right <?php if ($setting_fans_forever) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>粉丝分享自动成为分销商</h3>
        <div>
            <p>粉丝分享自动成为分销商</p>
        </div>
    </div>
    <div class="widget-app-board-control is_fanshare_drp">
        <label class="js-switch ui-switch pull-right <?php if ($is_fanshare_drp) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>分销审核</h3>
        <div>
            <p>店铺粉丝申请成为分销商是否需要通过审核，如果需要请开启审核，默认为未启用。</p>
        </div>
    </div>
    <div class="widget-app-board-control approve">
        <label class="js-switch ui-switch pull-right <?php if ($open_drp_approve) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>

<?php if($_SESSION['user']['uid']==162){?>
<div class="widget-app-board ui-box" style="border: none;">
    <div class="widget-app-board-info">
        <h3>渠道二维码生成</h3>
        <div>
            <p>开启后分销二维码变成渠道二维码</p>
            <div style="float: left;margin-top: 10px">
                <b style="color: #07d">封面图片</b> <a href="javascript:void(0);" class="upload-img1">上传图片</a> | <a href="javascript:void(0);" class="default-img1" data-img="<?php echo getAttachmentUrl('images/drp_ad_01.png', false); ?>">默认图片</a><br/><br/>
                <b style="color: #07d">消息模板</b>
                <textarea class="canal_qrcode-tpl" cols="100" rows="3"><?php if (!empty($reg_drp_subscribe_tpl)) { ?><?php echo $reg_drp_subscribe_tpl; ?><?php } else { ?>由分销商{$store_name}推荐，{$name}成为会员。<?php } ?></textarea><br/>
            </div>
            <div style="border-right: 1px dashed lightgray;float: left;height: 97px;margin-left: 20px;margin-top: 20px">&nbsp;</div>
            <div style="float: left;padding-top: 0px">
                <input type="button" class="ui-btn ui-btn-primary save-btn1" value="保 存" style="margin-left: 30px;margin-top: 65px" />
                预览：<img class="preview1" src="<?php if (!empty($reg_drp_subscribe_img)) { ?><?php echo $reg_drp_subscribe_img; ?><?php } else { ?><?php echo getAttachmentUrl('images/drp_ad_01.png', false); ?><?php } ?>" width="220" />
            </div>
        </div>
        <div style="clear: both;color:orange;">温馨提示：若需要自定义消息模板，请保留{$xxx}，封面图片建议尺寸 900x600。</div>
    </div>
    <div class="widget-app-board-control setting_canal_qrcode">
        <label class="js-switch ui-switch pull-right <?php if ($setting_canal_qrcode) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?>"></label>
    </div>
</div>
<?php } ?>
<script>
    /*$(function(){
        $("input[name='qcode']").on('click',function(){
            var qcode = $(this).val();

            if(qcode == 1){
                $('.widget-app-qcode').show();
            }else{
                $('.widget-app-qcode').hide();
            }
        });
    })*/
</script>

<style>
    .account-info .account-info-meta label {
        display: inline;
        color: #999;
        cursor: text;
    }
    .account-info img {
        float: left;
        width: 80px;
        height: 80px;
    }

    .account-info {
        padding: 20px 20px 20px 20px;
        background: rgba(255,255,255,0.3);
        zoom: 1;
    }
    .account-info .account-info-meta {
        margin-left: 100px;
    }

     .account-info .info-item {
        margin-top: 7px;
    }
    .btn {
        background: none;
        /* border: none; */
        display: inline-block;
        padding: 4px 11px;
        /* margin-bottom: 0; */
        font-size: 12px;
        line-height: 20px;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        background: #009adb;
    }
    .popover-inner {
        padding: 1px;
        background: #000000;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

</style>
<div class="ui-box settlement-info">
    <div class="account-info">
        <img src="<?php echo $store_info['logo']; ?>" class="logo" />

        <div class="account-info-meta">
            <div class="info-item">
                <label>店铺名称：</label>
                <span><?php echo $store_info['name']; ?></span>
            </div>
            <div class="info-item">
                <label>联系人：</label>
                <span><?php if (!empty($store_info['linkman'])) { ?><?php echo $store_info['linkman']; ?><?php } else { ?>未填写<?php } ?></span>
            </div>
            <div class="info-item">
                <label>手机号：</label>
                <span><?php if (!empty($store_info['tel'])) { ?><?php echo $store_info['tel']; ?><?php } else { ?>未填写<?php } ?></span>
            </div>
            <input class="supplierid" type="hidden" data-supplierid="<?php echo $supplier_id;?>">
            <input class="distributorid" type="hidden" data-distributorid="<?php echo $store_info['store_id'];?>">
        </div>

        <div class="account-info-meta" style="float:right;margin-top:-75px;margin-right:240px">
            <div class="info-item">
                <label>入驻时间：</label>
                <span><?php echo date('Y-m-d H:i:s', $store_info['date_added']); ?></span>
            </div>
            <!--<div class="info-item">
                <label>收款账户：</label>
                <span><?php if (!empty($store_info['bank_card_user'])) { ?><?php echo $store_info['bank_card_user']; ?><?php } else { ?>未填写<?php } ?></span>
            </div>
            <div class="info-item">
                <label>银行卡号：</label>
                <span><?php if (!empty($store_info['bank_card'])) { ?><?php echo $store_info['bank_card']; ?><?php } else { ?>未填写<?php } ?></span>
            </div>-->
        </div>
    </div>
</div>
<div>
    <h2 style="background: #F2F2F2;height:23px;padding:5px;margin-bottom:2px;">
        资料详情
    </h2>
    <table width="100%" height="180" style="background: #F2F2F2;">
        <tbody>
        <?php foreach($certification_info as $k=>$v){?>
            <tr>
                <th width="60" class="center" style="border:1px #ff000 solid"><?php echo $k;?></th>
                <td><div class="show"><?php if(strpos($v,'images')!==false){?><img src="<?php echo getAttachmentUrl($v); ?> " width="120" height="120" /><?php }else{ ?><?php echo $v;}?></div></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <!--<div style="margin-top:5px;background: #F2F2F2;">
        <div style="float: left">
            <b style="color: #07d">充值额度:</b> <input type="text" style="width: 80px" name="drp_limit_buy" class="drp-limit-buy" value="<?php echo $band; ?>" /> <b style="color: #07d">元</b><br/>
        </div>
    </div>-->
    <div class="control-group">
        <div class="controls" style="float:right;">
            <?php if(!empty($is_authen)) {?>
                <a class="btn" style="cursor: no-drop;color: #bbb;">审核通过</a>
            <?php } else {?>
                <a class="btn" id="shenhe" href="javascript:void(0)">审核通过</a>
            <?php } ?>
        </div>
    </div>
</div>

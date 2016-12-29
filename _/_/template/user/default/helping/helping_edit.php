<style>
    .error-message {color:#b94a48;}
    .hide {display:none;}
    .error{color:#b94a48;}
    .ui-timepicker-div .ui-widget-header {margin-bottom:8px; }
    .ui-timepicker-div dl {text-align:left; }
    .ui-timepicker-div dl dt {height:25px;margin-bottom:-25px; }
    .ui-timepicker-div dl dd {margin:0 10px10px65px; }
    .ui-timepicker-div td {font-size:90%; }
    .ui-tpicker-grid-label {background:none;border:none;margin:0;padding:0; }
    .controls .ico li .checkico {width: 50px;height: 54px;display: block;}
    .controls .ico li .avatar {width: auto; height: auto;max-height: 50px;max-width: 50px;display: inline-block;}
    .no-selected-style i {display: none;}
    .icon-ok {background-position: -288px 0;}
    .module-goods-list li img, .app-image-list li img {height: 100%;width: 100%;}
    .tequan {width: 100%;min-height: 60px;line-height: 60px;}
    .controls .input-prepend .add-on { margin-top: 5px;}
    .controls .input-prepend input {border-radius:0px 5px 5px 0px}
    .control-group table.reward-table{width:85%;}
    .tequan li{float:left;width:30%;text-align:left;margin-left:3%;}
    .form-horizontal .control-label{width:150px;}
    .form-horizontal .controls{margin-left:0px;}
    .controls  .renshu .add-on{margin-left:-3px;border-radius:0 4px 4px 0;}
    .js-condition {height:35px;}
    .controls .chose-label { height: 28px; line-height: 28px; float: left; margin-right: 20px; }
    .game_type label{width:50px;float:left;margin-left:20px;}
</style>

<nav class="ui-nav clearfix">
    <ul class="pull-left">
        <li id="js-list-nav-all" class="active">
            <a href="javascript:">编辑助力</a>
        </li>
    </ul>
</nav>

<div class="app-design-wrap">
<div class="page-presale clearfix">
<div class="app-presale app-reward">
<form class="form-horizontal" id="myform">
<div class="presale-info">
    <input type="hidden" id="id" name="id" value="<?php echo $helping['id'];?>">
    <div class="js-basic-info-region">
        <div class="control-group">
            <label class="control-label">
                <em class="required"> *</em>活动名称：
            </label>
            <div class="controls">
                <input type="text" id="title" name="title" value="<?php echo $helping['title'];?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                <em class="required"> *</em>活动时间：
            </label>
            <div class="controls">
                <input type="text" name="start_time" value="<?php echo $helping['start_time'];?>" class="js-start-time Wdate" id="js-start-time" readonly="" style="cursor:default; background-color:white">
                <span>至 </span>
                <input type="text" name="end_time" value="<?php echo $helping['end_time'];?>" class="js-end-time Wdate" id="js-end-time" readonly="" style="cursor:default; background-color:white">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                <em class="required"> *</em>微信分享标题：
            </label>
            <div class="controls">
                <input type="text" id="wxtitle" name="wxtitle" value="<?php echo $helping['wxtitle'];?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                <em class="required"> *</em>微信分享描述：
            </label>
            <div class="controls">
                <textarea id="wxinfo" name="wxinfo"><?php echo $helping['wxinfo'];?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                <em class="required"> *</em>微信分享图片：
            </label>
            <div class="controls">
                <ul class="ico app-image-list js-logo">
                    <li class="sort">
                        <a href="javascript:void(0)">
                            <img class="add-goods" src="<?php echo $helping['wxpic'];?>"></a>
                        <a class="js-delete-picture close-modal small hide">×</a>
                    </li>
                    <li style="display: none;">
                        <a href="javascript:;" class="add-goods js-add-wxpic" classname="backgroundThumImage">上传</a>
                        <input type="hidden" name="reply_pic" value="<?php echo $helping['wxpic'];?>" id="wxpic">
                    </li>
                </ul>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                <em class="required"> *</em>活动规则：
            </label>
            <div class="controls">
                <textarea id="guize" name="guize"><?php echo $helping['guize'];?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                <em class="required"> *</em>排行榜：
            </label>
            <div class="controls">
                <input type="text" id="rank_num" name="rank_num" value="<?php echo $helping['rank_num'];?>">
            </div>
        </div>
    </div>

    <div class="control-group">
        <div class="alert alert-success alert-dismissible" role="alert">
            <span style="font-weight:bold;font-size:16px;">奖项设置&nbsp;&nbsp;</span>
        </div>
    </div>

    <?php foreach($helping_prizes as $hpk=>$hpv){ ?>
    <input type="hidden" name="prize_id" value="<?php echo $hpv['id'];?>">
    <div class="control-group prize_select">
        <span style="float:left;font-size:16px;color:#4cae4c">&nbsp;&nbsp;<?php echo $hpk+1;?>等奖</span>
        <label class="control-label" style="margin-left:-50px;">
            奖品类型：
        </label>
        <div class="controls">
            <select id="type_<?php echo $hpk+1;?>" data-id="<?php echo $hpk+1;?>" class="prize_type" name="type">
                <option value="0" <?php if($hpv['type']==0){echo 'selected';};?>>选择奖品</option>
                <option value="1" <?php if($hpv['type']==1){echo 'selected';};?>>商品</option>
                <option value="2" <?php if($hpv['type']==2){echo 'selected';};?>>优惠券</option>
                <option value="3" <?php if($hpv['type']==3){echo 'selected';};?>>店铺积分</option>
                <option value="4" <?php if($hpv['type']==4){echo 'selected';};?>>其他</option>
            </select>
            <input type="hidden" name="prize_type" id="prize_type_<?php echo $hpk+1;?>" value="<?php echo $hpv['type'];?>"/>
            <input type="hidden" name="prize_title" id="prize_title_<?php echo $hpk+1;?>" value="<?php echo $hpv['title'];?>"/>
            <input type="hidden" name="prize_imgurl" id="prize_imgurl_<?php echo $hpk+1;?>" value="<?php echo $hpv['imgurl'];?>"/>
        </div>
    </div>

    <div class="control-group prize_content">
        <div class="control-group" style="display:none;" id="div_product_select_<?php echo $hpk+1;?>">
            <label class="control-label">
                <em class="required"> *</em>选择商品：
            </label>
            <div class="controls">
                <ul class="ico app-image-list js-product_<?php echo $hpk+1;?>" data-product_id="0">
                    <?php if(isset($hpv['imgurl']) && $hpv['type']==1) { ?>
                    <li class="sort" data-pid="89" data-skuid=""><a href="javascript:void(0);" target="_blank">
                            <img src="<?php echo $hpv['imgurl'];?>"></a>
                        <a class="js-delete-picture_multy close-modal small hide">×</a>
                    </li>
                    <li style="display: none;"><a href="javascript:void(0);" data-key="<?php echo $hpk+1;?>" class="add-goods js-add-picture">选商品</a></li>
                    <?php }else{ ?>
                    <li><a href="javascript:void(0);" data-key="<?php echo $hpk+1;?>" class="add-goods js-add-picture">选商品</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="control-group" style="display:none;" id="div_coupon_select_<?php echo $hpk+1;?>">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <select class="js-reward-coupon" data-key="<?php echo $hpk+1;?>" id="coupon_<?php echo $hpk+1;?>" style="width: 180px;">
                    <option value="0">请选择优惠券</option>
                    <?php echo $coupon_list_select;?>
                </select>
            </div>
        </div>
        <label class="control-label">
            <em class="required"> *</em>奖品：
        </label>
        <div class="controls">
            <input type="text" id="product_name_<?php echo $hpk+1;?>" data-key="<?php echo $hpk+1;?>" class="js-reward-imgurl">
            <input type="text" style="display:none;width:100px;" id="product_recharge_<?php echo $hpk+1;?>" data-key="<?php echo $hpk+1;?>" class="js-reward-title" value="<?php echo isset($hpv['proname'])?$hpv['proname']:$hpv['title'];?>">
        </div>
    </div>
    <script type="text/javascript">
        prize_initialize($('#type_'+<?php echo $hpk+1;?>),<?php echo $hpv['type'];?>);
    </script>
    <?php } ?>

    <div class="control-group">
        <div class="alert alert-success alert-dismissible" role="alert">
            <span style="font-weight:bold;font-size:16px;">宣传内容设置</span>
        </div>
    </div>

    <?php foreach($helping_news as $hnk=>$hnv){ ?>
    <input type="hidden" name="news_id" value="<?php echo $hnv['id'];?>">
    <div class="control-group news_imgurl">
        <label class="control-label">
            <em class="required"> *</em>宣传图片<?php echo $hnk+1;?>：
        </label>
        <div class="controls" style="margin-left:30px;" id="div_win_limits">
            <ul class="ico app-image-list js-logo">
                <?php if(isset($hnv['title'])) { ?>
                <li class="sort"><a href="javascript:void(0)"><img src="<?php echo $hnv['imgurl'];?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
                <li style="display: none;">
                    <a href="javascript:;" class="add-goods js-add-newspic" classname="backgroundThumImage">上传</a>
                    <input type="hidden" name="news_imgurl" value="<?php echo $hnv['imgurl'];?>" id="backgroundThumImage">
                </li>
                <?php }else{ ?>
                <li>
                    <a href="javascript:;" class="add-goods js-add-newspic" classname="backgroundThumImage">上传</a>
                    <input type="hidden" name="news_imgurl" value="" id="backgroundThumImage">
                </li>
                <?php } ?>
            </ul>
        </div>
        <span style="color: red;">&nbsp;推荐尺寸：900*500&nbsp;请让每个宣传图片的尺寸相同！否则会导致页面错位！</span>
    </div>

    <div class="control-group news_title">
        <label class="control-label">
            <em class="required"> *</em>宣传标题<?php echo $hnk+1;?>：
        </label>
        <div class="controls" style="margin-left:30px;" id="div_win_limits">
            <input type="text" id="news_title_<?php echo $hnk+1;?>" name="news_title" value="<?php echo $hnv['title'];?>">
        </div>
    </div>
    <?php } ?>

    <div class="control-group">
        <label class="control-label">
            未关注是否可以参与：
        </label>
        <div class="controls game_type" id="is_attention">
            <label><input type="radio" name="is_attention" value="1" <?php if($helping['is_attention']==1){echo 'checked';};?>>是</label>
            <label><input type="radio" name="is_attention" value="0" <?php if($helping['is_attention']==0){echo 'checked';};?>>否</label>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            未关注是否可以助力：
        </label>
        <div class="controls game_type" id="is_help">
            <label><input type="radio" name="is_help" value="1" <?php if($helping['is_help']==1){echo 'checked';};?>>是</label>
            <label><input type="radio" name="is_help" value="0" <?php if($helping['is_help']==0){echo 'checked';};?>>否</label>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            是否开启：
        </label>
        <div class="controls game_type" id="is_open">
            <label><input type="radio" name="is_open" value="1" <?php if($helping['is_open']==1){echo 'checked';};?>>是</label>
            <label><input type="radio" name="is_open" value="0" <?php if($helping['is_open']==0){echo 'checked';};?>>否</label>
        </div>
    </div>

</div>
</form>
<div class="app-design">
    <div class="app-actions">
        <div class="form-actions text-center">
            <input type="hidden" id="hash" name="hash" value="<?php echo $hash;?>"/>
            <?php if($is_save){ ?>
            <input class="btn js-btn-quit" type="button" value="取 消">
            <input class="btn btn-primary js-btn-edit" type="button" value="保 存" data-loading-text="保 存...">
            <?php } ?>
        </div>
    </div>
</div>
</div>
</div>
</div>

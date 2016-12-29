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
            <a href="javascript:">新增助力</a>
        </li>
    </ul>
</nav>

<div class="app-design-wrap">
<div class="page-presale clearfix">
<div class="app-presale app-reward">
<form class="form-horizontal" id="myformaaaaaaa">
<div class="presale-info">
<div class="js-basic-info-region">
    <div class="control-group">
        <label class="control-label">
            <em class="required"> *</em>活动名称：
        </label>
        <div class="controls">
            <input type="text" id="title" name="title">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required"> *</em>活动时间：
        </label>
        <div class="controls">
            <input type="text" name="start_time" value="" class="js-start-time Wdate" id="js-start-time" readonly="" style="cursor:default; background-color:white">
            <span>至 </span>
            <input type="text" name="end_time" value="" class="js-end-time Wdate" id="js-end-time" readonly="" style="cursor:default; background-color:white">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required"> *</em>微信分享标题：
        </label>
        <div class="controls">
            <input type="text" id="wxtitle" name="wxtitle">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required"> *</em>微信分享描述：
        </label>
        <div class="controls">
            <textarea id="wxinfo" name="wxinfo"></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required"> *</em>微信分享图片：
        </label>
        <div class="controls">
            <ul class="ico app-image-list js-logo">
                <li>
                    <a href="javascript:;" class="add-goods js-add-wxpic" classname="backgroundThumImage">上传</a>
                    <input type="hidden" name="reply_pic" value="" id="wxpic">
                </li>
            </ul>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required"> *</em>活动规则：
        </label>
        <div class="controls">
            <textarea id="guize" name="guize"></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required"> *</em>排行榜：
        </label>
        <div class="controls">
            <input type="text" id="rank_num" name="rank_num">
        </div>
    </div>
</div>

<div class="control-group">
    <div class="alert alert-success alert-dismissible" role="alert">
        <span style="font-weight:bold;font-size:16px;">奖项设置&nbsp;&nbsp;</span>
    </div>
</div>

<div class="control-group">
    <div class="controls" style="margin-left:30px;float: left;" id="div_win_limits">
        <input class="btn js-add-prize" type="button" value="+ 添加一个奖品">
    </div>
    <div class="controls" style="margin-left:30px;float: left;" id="div_win_limits">
        <input class="btn js-delete-prize" type="button" value="- 删除一个奖品">
    </div>
</div>

<div class="control-group prize_select">
    <span style="float:left;font-size:16px;color:#4cae4c">&nbsp;&nbsp;1等奖</span>
    <label class="control-label" style="margin-left:-50px;">
        奖品类型：
    </label>
    <div class="controls">
        <select id="type" data-id="1" class="prize_type" name="type">
            <option value="0">选择奖品</option>
            <option value="1">商品</option>
            <option value="2">优惠券</option>
            <option value="3">店铺积分</option>
            <option value="4">其他</option>
        </select>
        <input type="hidden" name="prize_type" id="prize_type_1" value=""/>
        <input type="hidden" name="prize_title" id="prize_title_1" value=""/>
        <input type="hidden" name="prize_imgurl" id="prize_imgurl_1" value=""/>
    </div>
</div>

<div class="control-group prize_content">
    <div class="control-group" style="display: none;" id="div_product_select_1">
        <label class="control-label">
            <em class="required"> *</em>选择商品：
        </label>
        <div class="controls">
            <ul class="ico app-image-list js-product_1" data-product_id="0">
                <li><a href="javascript:void(0);" data-key="1" class="add-goods js-add-picture">选商品</a></li>
            </ul>
        </div>
    </div>
    <div class="control-group" style="display:none;" id="div_coupon_select_1">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <select class="js-reward-coupon" data-key="1" id="coupon_1" style="width: 180px;">
                <option value="0">请选择优惠券</option>
                <?php echo $coupon_list_select;?>
            </select>
        </div>
    </div>
    <label class="control-label">
        <em class="required"> *</em>奖品：
    </label>
    <div class="controls">
        <input type="text" id="product_name_1" data-key="1" class="js-reward-imgurl">
        <input type="text" style="display:none;width:100px;" id="product_recharge_1" data-key="1" class="js-reward-title">
    </div>
</div>

<div class="control-group">
    <div class="alert alert-success alert-dismissible" role="alert">
        <span style="font-weight:bold;font-size:16px;">宣传内容设置</span>
    </div>
</div>

<div class="control-group">
    <div class="controls" style="margin-left:30px;float: left;" id="div_win_limits">
        <input class="btn js-add-news" type="button" value="+ 添加一个宣传图片">
    </div>
    <div class="controls" style="margin-left:30px;float: left;" id="div_win_limits">
        <input class="btn js-delete-news" type="button" value="- 删除一个宣传图片">
    </div>
</div>

<div class="control-group news_imgurl">
    <label class="control-label">
        <em class="required"> *</em>宣传图片1：
    </label>
    <div class="controls" style="margin-left:30px;" id="div_win_limits">
        <ul class="ico app-image-list js-logo">
            <li>
                <a href="javascript:;" class="add-goods js-add-newspic" classname="backgroundThumImage">上传</a>
                <input type="hidden" name="news_imgurl" value="" id="backgroundThumImage">
            </li>
        </ul>
    </div>
    <span style="color: red;">&nbsp;推荐尺寸：900*500&nbsp;请让每个宣传图片的尺寸相同！否则会导致页面错位！</span>
</div>

<div class="control-group news_title">
    <label class="control-label">
        <em class="required"> *</em>宣传标题1：
    </label>
    <div class="controls" style="margin-left:30px;" id="div_win_limits">
        <input type="text" id="news_title_1" name="news_title">
    </div>
</div>

<div class="control-group">
    <label class="control-label">
        未关注是否可以参与：
    </label>
    <div class="controls game_type" id="is_attention">
        <label><input type="radio" name="is_attention" value="1">是</label>
        <label><input type="radio" name="is_attention" checked="" value="0">否</label>
    </div>
</div>

<div class="control-group">
    <label class="control-label">
        未关注是否可以助力：
    </label>
    <div class="controls game_type" id="is_help">
        <label><input type="radio" name="is_help" value="1">是</label>
        <label><input type="radio" name="is_help" checked="" value="0">否</label>
    </div>
</div>

<div class="control-group">
    <label class="control-label">
        是否开启：
    </label>
    <div class="controls game_type" id="is_open">
        <label><input type="radio" name="is_open" checked="" value="1">是</label>
        <label><input type="radio" name="is_open" value="0">否</label>
    </div>
</div>

</div>
</form>
<div class="app-design">
    <div class="app-actions">
        <div class="form-actions text-center">
            <input type="hidden" id="hash" name="hash" value="<?php echo $hash;?>"/>
            <input class="btn js-btn-quit" type="button" value="取 消">
            <input class="btn btn-primary js-btn-add" type="button" value="保 存" data-loading-text="保 存...">
        </div>
    </div>
</div>
</div>
</div>
</div>

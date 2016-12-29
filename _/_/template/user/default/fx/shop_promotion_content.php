<style>
    .form-horizontal{
        background-color: #fff;
        padding-bottom:138px;
    }
    .controls input{
        width:240px;
    }
    .controls textarea{
        height:auto;
        width:240px;
    }
    .ui-btn-preview {
        color: #fff;
        background: #07d;
        border-color: #006cc9;
        float:left;
        margin-right:30px;
    }
    .desc {
        padding:10px 0 0 10px;
        color:gray;
        border: 1px dashed #E4E4E4;
    }
    .filter-box{
        border-bottom:1px solid #ddd;
        margin-bottom:20px;
    }
    .filter-box_1{
        border:0px solid #666;
        width:50%;
        float:right;
        margin-top:-349px;
        width:246px;
        margin-right:156px;
    }
    .class_form{
        width:50%;
        height:auto;
    }
     *{padding:0;margin:0;}
    .shou_all{
        width:270px;
        margin:auto;
    }
    .shou_top{
        height:70px;
        background:#C0C7CC;
        font-size:18px;
        font-weight:bold;
        padding-top:20px;
        padding-left:15px;
        padding-right:15px;
        line-height:25px;
        color:#333;
    }
    .red{
        color:#CD2026;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
        width:160px;
    }
    .fl{
        float:left;
    }
    .fr{
        float:right;
    }
    .shou_con{
        height:300px;
    <?php echo !empty($promote['image']) ? "background-size:cover;background-image:url(".$promote['image'].")" : "background: #E32139";?>;
       /*background:#E32139;*/
        text-align:center;
        overflow:hidden;
        color:#fff;
        font-size:14px;
        line-height:30px;
    }

    .con_h1{
        color:#FC3;
        font-weight:bold;
        font-size:16px;
        margin-top:0px;
    }
    .con_h2{
        font-size:13px;
    }
    .shou_foot{
        background:#B91A30;
        height:40px;
        line-height:40px;
        color:#FC3;
        font-size:16px;
        font-weight:bold;
        text-align:center;
    }
    .textarea_con_counter{
        margin-left: 292px;
    }
</style>
<div class="form-horizontal">
<div class="filter-box">
    <div class="js-list-search">
        <span style="font-size:15px;">推广店铺页面自定义</span>
    </div>
</div>
<form class="class_form">
    <fieldset>
        <div class="control-group">
            <label class="control-label">标题：</label>
            <div class="controls">
                <input class="contact-name"  maxlength="12" type="text" name="contact_name" placeholder="请填写标题名称" value="<?php echo !empty($promote['title']) ? $promote['title'] : ''; ?>" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">简介：</label>
            <div class="controls">
                <textarea name="intro" class="input-intro" rows='5' cols='35' onfocus="fed_inputMaxLength(this,21,'catchask_con_counter_num')"><?php echo !empty($promote['content']) ? $promote['content'] : ''; ?></textarea>
            </div>
            <div class="textarea_con_counter">还能输入<strong id="catchask_con_counter_num"><span style="color:red;"><?php echo 21- mb_strlen($promote['content'],'utf-8');?></span></strong>字</div>
        </div>

        <div class="control-group">
            <label class="control-label">背景图：</label>
            <div class="controls">
                <input type="hidden" name="picture">
                <div class="picture-list ui-sortable">
                    <ul class="js-picture-list app-image-list clearfix">
                        <?php if(!empty($promote['image'])) {?>
                            <li class="sort">
                                <a href="<?php echo $promote['image'];?>" target="_blank">
                                    <img src="<?php echo $promote['image'];?>"></a>
                                <a class="js-delete-picture close-modal small hide">×</a>
                            </li>
                        <?php }?>
                        <li>
                            <a href="javascript:;" class="add-goods js-add-picture">+加图</a>
                        </li>
                    </ul>
                </div>
                <p class="help-desc" style="opacity: 1;color:#999">建议尺寸：710 x 600 像素。</p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">尾语：</label>
            <div class="controls">
                <input class="description" type="text" maxlength="12" placeholder="填写您的尾语" name="" value="<?php echo !empty($promote['description']) ? $promote['description'] : ''; ?>"  />
            </div>
        </div>
    </fieldset>

    <div class="form-actions">
        <button class="ui-btn ui-btn-preview js-btn-submit" type="button">预览</button>
    </div>
    <div class="form-actions">
        <button class="ui-btn ui-btn-primary js-btn-submit" type="button" data-loading-text="正在保存...">保存</button>
    </div>
</form>
<div class="filter-box_1">
    <div class="shou_all">
        <div class="shou_top">
            <img src="<?php echo !empty($store_session['logo']) ? $store_session['logo'] : TPL_URL."images/shop2.png!145x145.jpg"; ?>" class="fl" style="border-radius:50%;width:60px;height:60px;margin-right:15px;">
            <div class="fl">
                <span class="red">我是<?php echo mb_strlen($store_info['name'])>18 ? mb_substr($store_info['name'], 0, '18') : $store_info['name']; ?></span><br/>
                <span class="title">我向您推荐此店铺</span>
            </div>
        </div>
        <div class="shou_con">
            <div class="con_h1"><?php echo !empty($promote['title']) ? $promote['title'] : '本店物美价廉,专供闺蜜基友'?></div>
            <div class="con_h2"><?php echo !empty($promote['content']) ? $promote['content'] : '店铺宝贝丰富,速进店入手;发现心动宝贝要快快入手,不然店家缺货了就要等待哦'?></div>

            <img src="<?php echo option('config.site_url')."/source/qrcode.php?type=home&id=".$store_session['store_id'];?>" style="width:120px;height:120px;margin:5px auto;"><br />
            [长按此图,识别图中的二维码]
        </div>
        <div class="shou_foot">
          <span>——<span class="shou_end"><?php echo !empty($promote['description']) ? $promote['description'] : '成为我的分销商,赚分佣哦'?></span>——</span>
        </div>
    </div>

    <script type='text/javascript'>

        function fed_inputMaxLength(target,maxlength,counterId){
            if($(target).attr('fed_max_length')==null){
                $(target).attr('fed_max_length',maxlength);
                var counter = $('#'+counterId);
                if ($.browser.msie) { //IE浏览器
                    $(target).unbind("propertychange").bind("propertychange", function(e) {
                        e.preventDefault();
                        textareaMaxProc1(target, maxlength);
                        counter.html(maxlength-$(target).val().length);
                    });
                    target.attachEvent("onpropertychange", function(e) {
                        //e.preventDefault();
                        textareaMaxProc1(target, maxlength);
                        counter.html(maxlength-$(target).val().length);
                    });

                }else { //ff浏览器
                    target.addEventListener("input",function(e) {
                        e.preventDefault();
                        textareaMaxProc1(target, maxlength);
                        counter.html(maxlength-$(target).val().length);
                    },false);
                }
                $('target').unbind("keypress").bind("keypress", function(event) {
                    var code;
                    if(typeof event.charCode =="number" ){ //charCode只在keypress事件后才包含值，此时keyCode可能有值也可能没有，Ie没有charCode属性。
                        code = event.charCode;
                    }else{
                        code = event.keyCode;
                    }
                    if(code > 9 && !event.ctrlKey && $(target).val().length>=maxlength){
                        event.preventDefault();
                    }else if(event.ctrlKey && $(target).val().length>=maxlength && code==18){
                        event.preventDefault();
                    }
                });
            }
        }


        function textareaMaxProc1(textArea, total){
            var max;
            max=total;

            if($(textArea).val().length > max){
                $(textArea).val($(textArea).val().substring(0,max));
            }
        }

    </script>
</div>
</div>
<div class="desc">
    <p>1.<b></b>所有字段不设置则默认为初始信息</p>
    <p>2.<b></b>图片建议尺寸为710*600</p>
    <p>3.<b></b>该页面为店铺推广页面,阅读者是为你推广的用户</p>
</div>
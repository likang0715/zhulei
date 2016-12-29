<form class="form-horizontal" style="">
    <div class="control-group">
        <label class="control-label">
            横幅标题：
        </label>
        <div class="controls">
            <input type="text" id="name" name="name" value="" maxlength="20">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            横幅图片：
        </label>
        <div class="controls">
            <div class="control-action js-picture-list-wrap">
                <ul class="app-image-list clearfix">
                    <div class="js-img-list" style="display: inline-block"></div>
                    <li class="js-picture-btn-wrap" style="display:inline-block;float:none;vertical-align: top;">
                        <a href="javascript:;" class="add js-add-banner-picture">+加图</a>
                    </li>
                </ul><span style="vertical-align: middle;color: red;">(建议尺寸 1210 *200)</span>
            </div>
        </div>
    </div>
    <input type="hidden" id="pic" name="pic" value=""/>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            链接地址：
        </label>
        <div class="controls">
            <input type="text" id="url" name="url" value="">
        </div><span style="vertical-align: middle;color: red;margin-left: 130px;">(输入的网站不要带http://)</span>
    </div>
    <div class="form-actions" style="margin-top:50px">
        <button type="button" class="ui-btn ui-btn-primary js-banner-save">添加</button>
    </div>
</form>

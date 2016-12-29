<form class="form-horizontal" style="">
    <input type="hidden" id="id" name="id" value="<?php echo isset($banner_detail['id'])?$banner_detail['id']:'';?>">
    <div class="control-group">
        <label class="control-label">
            横幅标题：
        </label>
        <div class="controls">
            <input type="text" id="name" name="name" value="<?php echo isset($banner_detail['name'])?$banner_detail['name']:'';?>">
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
                    <div class="js-img-list" style="display: inline-block">
                        <li class="upload-preview-img">
                            <a target="_blank" href="<?php echo isset($banner_detail['pic'])?$banner_detail['pic']:'';?>"><img src="<?php echo isset($banner_detail['pic'])?$banner_detail['pic']:'';?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
                    </div>
                    <li class="js-picture-btn-wrap" style="display:inline-block;float:none;vertical-align: top;">
                        <a href="javascript:;" class="add js-add-banner-picture">+加图</a>
                    </li>
                </ul><span style="vertical-align: middle;color: red;">(建议尺寸 1210 *200)</span>
            </div>
        </div>
    </div>
    <input type="hidden" id="pic" name="pic" value="<?php echo isset($banner_detail['pic'])?$banner_detail['pic']:'';?>"/>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            链接地址：
        </label>
        <div class="controls">
            <input type="text" id="url" name="url" value="<?php echo isset($banner_detail['url'])?$banner_detail['url']:'';?>">
        </div><span style="vertical-align: middle;color: red;margin-left: 130px;">(输入的网站不要带http://)</span>
    </div>
    <div class="form-actions" style="margin-top:50px">
        <button type="button" class="ui-btn ui-btn-primary js-banner-edit-save">编辑</button>
    </div>
</form>

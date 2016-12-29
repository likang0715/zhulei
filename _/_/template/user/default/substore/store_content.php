<form class="form-horizontal" onsubmit="return false;">
    <fieldset>

        <div class="control-group">
            <label class="control-label">门店名称：</label>
            <div class="controls">
                <div class="hide js-team-name-input">
                    <input type="text" name="team_name" value="<?php echo $store_physical['name']; ?>" data="<?php echo $store_physical['name']; ?>" />
                    <p class="help-block error-message">请填写</p>
                </div>
                <div class="js-team-name-text">
                    <span class="sink"><?php echo $store_physical['name']; ?></span>
                    <a href="javascript:;" class="sink sink-minor js-team-name-edit">修改</a>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">联系电话：</label>
            <div class="controls">
                <span class="sink"><?php echo !empty($store_physical['phone1']) ? $store_physical['phone1'].'-'.$store_physical['phone2'] : $store_physical['phone2']; ?></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">所属区域：</label>
            <div class="controls">
                <span class="sink"><?php echo $store_physical['province_txt'].' - '.$store_physical['city_txt'].' - '.$store_physical['area_txt']; ?></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">联系地址：</label>
            <div class="controls">
                <span class="sink"><?php echo $store_physical['address']; ?></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">门店图片：</label>
            <div class="controls">
                <div class="control-action js-picture-list-wrap">
                    <ul class="app-image-list clearfix">
                        <div class="js-img-list" style="display:inline-block">
                        <?php foreach ($store_physical['images_arr'] as $img) { ?>
                            <li class="upload-preview-img">
                                <a href="<?php echo $img; ?>" target="_blank"><img src="<?php echo $img; ?>"></a>
                            </li>
                        <?php } ?>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">运营时间：</label>
            <div class="controls">
                <span class="sink"><?php echo $store_physical['business_hours']; ?></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">商家推荐：</label>
            <div class="controls">
                <span class="sink"><?php echo $store_physical['description']; ?></span>
            </div>
        </div>

    </fieldset>
    <div class="form-actions">
        <button class="ui-btn ui-btn-primary js-physical-edit-submit" type="button" data-loading-text="正在保存...">保存</button>
    </div>
</form>
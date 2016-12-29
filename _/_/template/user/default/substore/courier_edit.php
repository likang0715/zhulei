<div class="app-preview">
    <div class="" style="background: #fff;border:1px solid #ccc;padding:10px 0;">
        <form class="form-horizontal" action="#" method="post" onsubmit="return false;">
            <fieldset>

                <div class="control-group">
                    <label class="control-label">头像预览：</label>
                    <div class="controls">
                        <img src="<?php if($info['avatar']){echo $info['avatar'];}else{ echo option('config.site_url').'/upload/images/default_shop.png';}?>" class="avatar_show" width="90px" height="90px">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">配送员头像：</label>
                    <div class="controls">
                        <input type="text" placeholder="请上传客服头像" name="avatar" class="input-xxlarge" value="<?php echo $info['avatar'];?>"/>
                        <a class="js-choose-bg control-action" href="javascript: void(0);">修改头像</a>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">姓名：</label>
                    <div class="controls">
                        <input type="text" placeholder="请填写配送员姓名" name="name" class="input-xxlarge name" value="<?php echo $info['name'];?>" maxlength="30"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">性别：</label>
                    <div class="controls">
                        <label class="radio inline">
                            <input type="radio" placeholder="请填写手机号码" name="sex" class="sex" value="1" <?php if($info['sex'] == 1) echo 'checked' ?>/> 男</label>
                        <label class="radio inline">
                            <input type="radio" placeholder="请填写手机号码" name="sex" class="sex" value="0" <?php if($info['sex'] == 0) echo 'checked' ?>/> 女</label>
                    </div>
                </div>
        
                <div class="control-group">
                    <label class="control-label">手机号码：</label>
                    <div class="controls">
                        <input type="text" placeholder="请填写手机号码" name="tel" class="input-xxlarge tel" maxlength="11" value="<?php echo $info['tel'];?>"/>
                    </div>
                </div>

                <?php if ($user_session['type'] == 0) { ?>
                <div class="control-group">
                    <label class="control-label">所属门店：</label>
                    <div class="controls">
                        <select class="" name="physical_id">
                            <option value="0">请选择门店</option>
                            <?php foreach ($physicals as $key => $physical) { ?>
                            <option value="<?php echo $key ?>" <?php if($key == $info['physical_id']) echo 'selected=selected'; ?>><?php echo $physical ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } ?>

                <div class="controls">
                    <input type="hidden" name="courier_id" class="courier_id" value="<?php echo $info['courier_id'];?>">
                    <button class="btn btn-large btn-primary submit-btn" type="button">添加配送员</button>
                </div>
            </fieldset>
        </form>

    <div class="js-list-footer-region ui-box">
        <div>
            <div class="pagenavi js-page-list"><?php echo $group_list['page'];?></div>
        </div>
    </div>
</div>
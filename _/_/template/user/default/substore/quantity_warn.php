<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<form class="form-horizontal" onsubmit="return false;">
    <fieldset>
    	<div class="control-group">
            <label class="control-label">库存警告下限<br>(门店)：</label>
            <div class="controls">
                <input class="contact-name" <?php if ($user_session['type'] != 0) echo 'disabled=disabled'; ?> type="text" name="warn_sp_quantity" placeholder="报警库存数量" value="<?php echo $store_info['warn_sp_quantity']; ?>" />
                <font color="#f00"> &nbsp; 库存报警数量下限，设为0则不报警</font>
            </div>
        </div>
    </fieldset>
    <div class="form-actions">
        <?php if ($user_session['type'] == 0) { ?>
        <button class="ui-btn ui-btn-primary js-warn-submit" type="button" data-loading-text="正在保存...">保存</button>
        <?php } ?>
    </div>
</form>
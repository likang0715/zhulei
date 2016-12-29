<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/app_team.css" />
<style type="text/css">
/* 表单样式修改 */
.ui-table tr:nth-child(2n) { background-color: #fafafa; }
.ui-form .control-group { background-color: transparent; }
.control-group label.error { float: right; color: #f66; margin-top: 5px; }
.control-group .controls { position: relative; }
.form-horizontal .controls { margin-left: 150px; }
.ui-form .control-label { font-size: 14px; width: 140px; border-right: 1px solid #ccc; padding: 15px 10px 15px 0; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ui-form .controls { /*border-left: none;*/ }
.popover { margin: 0 0 0 -110px; }
.config_upload_image_btn .button { margin-left: 0px; margin-right: 5px; background: #6c6; color: #fff; padding: 5px;} 
.config_upload_image_btn .button:hover { background: #6b6; } 

.helps {position: absolute; top: 10px; right: 14px; }
.help a {display: inline-block; width: 16px; height: 16px; line-height: 18px; border-radius: 8px; font-size: 12px; text-align: center; background: #D5CD2F; color: #fff; }
.help a:after {content: "?"; }
.info { margin: 0; padding: 0; }
/* 新分类样式 */
.set-cate-block { background-color: #fff; border: 1px solid #ccc; margin-top: 10px; display: none; }
.set-cate-block .scb-li { width: 100%; border-bottom: 1px solid #ccc; padding: 0 0 5px 0; }
.set-cate-block .scb-li .scb-tit { padding: 5px 0 5px 10px; height: 20px; background-color: #ddd; border-bottom: 1px dotted #ccc; font-size: 14px; }
.scb-tit a.scb-cancel { background-color: #07d; color: #fff; padding: 5px 8px; margin-right: 5px; border-radius: 3px; font-size: 12px; line-height: 12px; float: right; }
.set-cate-block .scb-li .scb-con {  }
.set-cate-block .scb-li .scb-label { width: 115px; height: 20px; padding: 5px; font-size: 14px; border: 1px solid #ccc; margin: 5px 0 0 5px; border-radius: 3px; float: left; }
.set-cate-block .scb-li .scb-label:hover { border-color: #07d; }
.scb-li .scb-label.selected { border-color: #07d; color: #fff; background-color: #07d; }
.scb-li .scb-label .scb-l { width: 20px; height: inherit; float: left; }
.scb-li .scb-label .scb-l input { margin: 0; }
.scb-li .scb-label .scb-r { width: 90px; height: inherit; float: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
</style>
<script type="text/javascript">
    var json_categories = '<?php echo $json_categories; ?>';
</script>

<form class="form-horizontal ui-form">
    <fieldset>
        <div class="control-group">
            <label class="control-label">所属公司</label>
            <div class="controls">
                <span class="sink"><?php echo $company['name']; ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">店铺名称</label>
            <div class="controls">
                <?php if (empty($store['edit_name_count'])) { ?>
                <div class="hide js-team-name-input">
                    <input type="text" name="team_name" value="<?php echo $store_session['name']; ?>" data="<?php echo $store['name']; ?>" maxlength="30" />
                    <p class="help-block error-message">店铺名称只能修改一次，请您谨慎操作</p>
                </div>
                <?php } ?>
                <div class="js-team-name-text">
                    <span class="sink"><?php echo $store['name']; ?></span>
                    <?php if($store['drp_level'] > 0 && $store['update_drp_store_info']) {?>
                        <?php if (empty($store['edit_name_count'])) { ?>
                            <a href="javascript:;" class="sink sink-minor js-team-name-edit">修改</a>
                        <?php } ?>
                    <?php } elseif ($store['drp_level'] == 0){?>
                        <?php if (empty($store['edit_name_count'])) { ?>
                            <a href="javascript:;" class="sink sink-minor js-team-name-edit">修改</a>
                        <?php } ?>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">主营类目</label>
            <div class="controls">
                <?php echo $sale_category;?>
                <?php if ($store['drp_level'] == 0) { ?>
                <a href="javascript:;" class="sink sink-minor js-category-edit">修改</a>
                <?php } ?>
                <!-- 新所属分类选择 -->
                <div class="set-cate-block" data-fid="<?php echo $store['sale_category_fid'] ?>" data-cid="<?php echo $store['sale_category_id'] ?>">
                    <input type='hidden' name="sale_category_fid" value="<?php echo $store['sale_category_fid'] ?>" >
                    <input type='hidden' name="sale_category_id" value="<?php echo $store['sale_category_id'] ?>" >
                    <div class="scb-li">
                        <div class="scb-tit">一级类 <a href="javascript:void(0);" class="scb-cancel">重 置</a></div>
                        <div class="scb-con">
                            <?php foreach ($categories as $category) { ?>
                            <?php $f_name = !empty($category['children']) ? $category['name'].' ('.count($category['children']).')' : $category['name']; ?>
                            <label class="scb-label js-flabel" title="<?php echo $f_name; ?>" data-cat_id="<?php echo $category['cat_id']; ?>">
                                <div class="scb-l"></div>
                                <div class="scb-r"><?php echo $f_name ?></div>
                            </label>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="scb-li">
                        <div class="scb-tit">二级类</div>
                        <div class="scb-con">
                        <?php foreach ($categories as $category) { ?>
                            <?php foreach ($category['children'] as $chd) { ?>
                            <label class="scb-label js-clabel fid_<?php echo $category['cat_id'] ?>" data-cat_id="<?php echo $chd['cat_id'] ?>">
                                <div class="scb-l"></div>
                                <div class="scb-r"><?php echo $chd['name']; ?></div>
                            </label>
                            <?php } ?>
                        <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">创建日期</label>
            <div class="controls">
                <span class="sink"><?php echo date('Y-m-d H:i:s', $store['date_added']); ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">店铺Logo</label>
            <div class="controls">
                <div class="avatar" style="float: none;"><img class="avatar-img" <?php if (!empty($store['logo'])) { ?>src="<?php echo $store['logo']; ?>"<?php } else { ?>src="<?php echo TPL_URL;?>/images/logo.png"<?php } ?> /></div>
                <?php if($store['drp_level'] > 0 && $store['update_drp_store_info']) { ?>
                    <a href="javascript:;" class="upload-img js-add-picture">修改</a>
                <?php } elseif ($store['drp_level'] == 0) { ?>
                    <a href="javascript:;" class="upload-img js-add-picture">修改</a>
                <?php } ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">店铺简介</label>
            <div class="controls">
                <textarea name="intro" class="input-intro" <?php if($store['drp_level'] > 0) {?> disabled<?php }?> cols="30" rows="3" maxlength="100"><?php echo $store['intro']; ?></textarea>
            </div>
        </div>
		<div class="control-group">
            <label class="control-label">人均价位</label>
            <div class="controls">
             <input class="input-price" type="text" name="price" placeholder="请填写人均价位" value="<?php echo $store['price']; ?>" />元/人
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">经营人姓名</label>
            <div class="controls">
                <input class="contact-name" <?php if($store['drp_level'] > 0) {?> disabled<?php }?> type="text" name="contact_name" placeholder="请填写完整的真实姓名" value="<?php echo $store['linkman']; ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">法人姓名</label>
            <div class="controls">
                <input class="legal-person" <?php if($store['drp_level'] > 0) {?> disabled<?php }?> type="text" name="legal_person" placeholder="请填写完整的真实姓名" value="<?php echo $store['legal_person']; ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">经营人 QQ</label>
            <div class="controls">
                <input class="qq" type="text" <?php if($store['drp_level'] > 0) {?> disabled<?php }?> placeholder="填写能联系到您的QQ号码" name="qq" value="<?php echo $store['qq']; ?>" maxlength="15" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">经营人手机/电话</label>
            <div class="controls">
                <input class="mobiles js-mobile" type="text" name="mobile" placeholder="填写准确的手机/电话号码，便于及时联系" value="<?php echo $store['tel']; ?>" maxlength="14" />
				<font color="#f00"></font>
			</div>
		</div>

		<?php if ($store['drp_level'] == 0) { ?>
				<select name="is_show_drp_tel" style="display:none">
					<option value="1" selected="selected"></option>
				</select>
		<?php }?>
		
        <?php if (!empty($_SESSION['sync_store'])) { ?>
		<div class="control-group">
                <label class="control-label">启用客服</label>
                <div class="controls">
                    <input type="radio" value="0" name="open_service" class="open_service" <?php if($store['open_service'] == 0 || $store['open_service'] == ''){echo 'checked=true';} ?> />
					关闭
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" value="1" name="open_service" class="open_service" <?php if($store['open_service'] == 1){echo 'checked=true';} ?> />
					开启
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <font color="#f00">(* 开启商品详情页“联系客服”功能)</font>
                </div>
            </div>
        <?php } ?>

    </fieldset>
    
    <div class="form-actions">
        <button class="ui-btn ui-btn-primary js-btn-submit" type="button" data-loading-text="正在保存...">保存</button>
    </div>

</form>

<script type="text/javascript">
var t = '';

$(function(){
    $('.js-help-notes').hover(function(){
        $('.popover-help-notes').remove();
        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 20) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p><strong>下单笔数：</strong>所有用户的下单总数。</p><p><strong>付款订单：</strong>已付款的订单总数；</p><p><strong>发货订单：</strong>已发货的订单总数。</p></div></div></div>';
        $('body').append(html);
        $('.popover-help-notes').show();
    }, function(){
        t = setTimeout('hide()', 200);
    })

    $('.popover-help-notes').live('mouseleave', function(){
        clearTimeout(t);
        hide();
    })

    $('.popover-help-notes').live('mouseover', function(){
        clearTimeout(t);
    })

    // 店铺所属分类选择
    $(".set-cate-block").storeCateSelect();

})

function hide() {
    $('.popover-help-notes').remove();
}
</script>

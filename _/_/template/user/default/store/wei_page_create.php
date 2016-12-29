<div class="app-design clearfix">
    <div class="app-preview">
        <div class="app-header"></div>
        <div class="app-entry">
            <div class="app-config js-config-region">
                <div class="app-field clearfix editing">
					<h1><span>微页面标题</span></h1>
					<style>.app-preview .app-field{background-color:#f9f9f9 !important;}</style>
				</div>
            </div>
			<div class="app-fields js-fields-region"><div class="app-fields ui-sortable"></div></div>
		</div>
    </div>
    <div class="app-sidebars">
		<div class="app-sidebar" style="margin-top:71px;">
			<div class="arrow"></div>
			<div class="app-sidebar-inner js-sidebar-region"></div>
		</div>
    </div>
    <div class="app-actions" style="display:block;bottom:0px;">
        <div class="form-actions text-center">
            <input class="btn btn-primary btn-save" type="submit" value="保存" data-loading-text="保存..."/>
            <!--input class="btn btn-preview" type="submit" value="预览效果" data-loading-text="预览效果..."/-->
        </div>
    </div>
</div>
<?php if ($customField){?>

<div style="display:none;" id="edit_data" page-name="<?php echo $now_page['page_name'];?>" page-id="<?php echo $now_page['page_id'];?>" page-desc="<?php echo $now_page['page_desc'];?>" show_head="<?php echo $now_page['show_head'];?>" show_footer="<?php echo $now_page['show_footer'];?>" bgcolor="<?php echo $now_page['bgcolor'];?>" cat-ids="<?php echo $cat_ids;?>"></div>
<div style="display:none;" id="edit_custom" custom-field='<?php echo $customField;?>'></div>
<?php }?>
<div style="display:none;" id="edit_custom_subject_menu" subject-menu-field='<?php echo $subtype;?>'></div>
<style>
.subtype_right_left {width: 200px; height: 400px; border:1px solid #000; float: left;}
.subtype_right_left ul {padding: 5px; margin: 0px; list-style: none;}
.subtype_right_left ul li{height: 20px; line-height: 20px; width: 190px; margin-top:2px; cursor: pointer;}

.subtype_right_middle {width: 80px; height: 400px; float: left;}

.subtype_right_right {width: 200px; height: 400px; border:1px solid #000; float: left;}
.subtype_right_right ul {padding: 5px; margin: 0px; list-style: none;}
.subtype_right_right ul li{height: 20px; line-height: 20px; width: 180px; margin-top:2px; cursor: pointer;}

.subtype_right_right ul li span {width: 15px; height:15px; line-height: 15px; float: right; border-radius: 50%; background-color: #d7d7d7; color: #FFF; margin-top:5px;}

.subtype_selected {background: #ccc;}


</style>


<script type="text/javascript">
$(function(){
	/*
function $(id){
return document.getElementById(id);
}*/

	
})

</script>

<div class="app-design clearfix">
    <div class="app-preview">
        <div class="app-header"></div>
        <div class="app-entry">
            <div class="app-config js-config-region">
                <div class="app-field clearfix editing">
					<h1><span></span></h1>
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
        </div>
    </div>
</div>
<div style="display:none;" id="edit_data" page-name="<?php echo $now_page['page_name'];?>" page-id="<?php echo $now_page['page_id'];?>" page-desc="<?php echo $now_page['page_desc'];?>" show_head="<?php echo $now_page['show_head'];?>" show_footer="<?php echo $now_page['show_footer'];?>" bgcolor="<?php echo $now_page['bgcolor'];?>" thumb="<?php echo $now_page['thumb'];?>" cat-ids="<?php echo $cat_ids;?>"></div>
<div style="display:none;" id="edit_custom" custom-field='<?php echo $customField;?>'></div>
<div style="display:none;" id="edit_custom_subject_menu" subject-menu-field='<?php echo $subtype;?>'></div>

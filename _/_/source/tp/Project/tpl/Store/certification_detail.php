<include file="Public:header"/>
    <style type="text/css">
        .frame_form th{
            border-left: 1px solid #e5e3e3!important;
            font-weight: bold;
            color:#ccc;
        }
        .frame_form td {
            vertical-align: middle;
        }
        .center {
            text-align: center!important;
        }
        .right-border {
            border-right: 1px solid #e5e3e3!important;
        }
    </style>
	<form action="<?php echo U('Store/approve'); ?>" method="post" id="myform" enctype="multipart/form-data" frame="true" refresh="true">
	
   <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
	
	<?php foreach($diy_attestation_list as $k=>$v){?>
        <tr>
            <th width="60" class="center"><?php echo $k?></th>
            <td>
            	<div class="show"><?php if(strpos($v,'images')!==false) {?><a href="<?php echo  getAttachmentUrl($v)?>" rel="show_img" target="_blank"><img src="<?php echo  getAttachmentUrl($v)?>" width="120" height="120px"/></a><?php }else{ ?><?php echo $v; ?><?php } ?></div>
            </td>
        </tr>
 <?php } ?>

		<tr>
            <td colspan="5" class="right-border" style="text-align:center">
                <span class="cb-enable approve-enable"><label class="cb-enable <?php if(($store_info['approve'] == 1)||($store_info['approve'] != 3)) { echo 'selected';}?>" data-id="<?php echo $_GET['id']; ?>"><span>认证通过</span><input type="radio" name="approve" value="1" /></label></span>
                <span class="cb-disable approve-disable"><label class="cb-disable <?php if($store_info['approve'] == 3){ echo 'selected'; }?>" data-id="<?php echo $_GET['id']; ?>"><span>认证不通过</span><input type="radio" name="approve" value="3" /></label></span>
            </td>
        </tr>
		<input type="hidden" name="store_id" value="<?php echo $_GET['id'] ?>"/>

    </table>
	
	 <div class="btn hide">
        <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
        <input type="reset" value="取消" class="button" />
    </div>
	</form>
	<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/iframeTools.js"></script>
	<script type="text/javascript">
	function addLink(domid,iskeyword){
	art.dialog.data('domid', domid);
	art.dialog.open('?g=Admin&c=Link&a=insert&iskeyword='+iskeyword,{lock:true,title:'插入链接或关键词',width:600,height:400,yesText:'关闭',background: '#000',opacity: 0.45});
}
	</script>
   
<include file="Public:footer"/>
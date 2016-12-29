<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
 <meta charset="utf-8"/> 
 <title>新增茶桌 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
 <meta name="description" content="<?php echo $config['seo_description'];?>">
 <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
 <meta name="renderer" content="webkit">
 <meta name="referrer" content="always">
 <meta name="format-detection" content="telephone=no">
 <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
 <!-- ▼ Base CSS -->
 <link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
 <link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
 <!-- ▲ Base CSS -->
 <!-- ▼ Table CSS -->
 <link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
 <link href="<?php echo TPL_URL;?>css/table.css" type="text/css" rel="stylesheet"/>
 <link href="<?php echo STATIC_URL;?>js/ueditor/themes/default/css/ueditor.css" type="text/css" rel="stylesheet">
 <link href="<?php echo STATIC_URL;?>js/ueditor/third-party/codemirror/codemirror.css" rel="stylesheet" type="text/css" >
 <!-- ▲ Table CSS -->
 <!-- ▼ Constant JS -->
 <script type="text/javascript">
 var store_id = "<?php echo $_GET['physical_id'];?>"
 var load_url="<?php  dourl('meal:table',array('physical_id'=>$_GET['physical_id'],'cat_id'=>$_GET['cat_id']));?>";
 var store_physical_edit_url ='<?php echo dourl('meal:table_add'); ?>&physical_id=<?php echo $_GET['physical_id'];?>'
 </script>
 <!-- ▲ Constant JS -->
 <!-- ▼ Base JS -->
 <script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
 <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
 <script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
 <script type="text/javascript" src="<?php echo TPL_URL;?>js/swiper.jquery.min.js"></script>
 <script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/ueditor.config.js"></script>
 <script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/ueditor.all.js"></script>
 <script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/lang/zh-cn/zh-cn.js" defer="defer"></script>
 <script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/third-party/codemirror/codemirror.js" defer="defer"></script>
 <script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
 <!-- ▲ Base JS -->
 <!-- ▼ Table JS -->
 <script type="text/javascript" src="<?php echo TPL_URL;?>js/table-edit.js"></script>
 <!-- ▲ Table JS -->
</head>
<body class="font14 usercenter">
 <?php include display('public:first_sidebar');?>
 <?php include display('sidebar');?>
 <!-- ▼ Container-->
 <div id="container" class="clearfix container right-sidebar">
  <div id="container-left">
    <!-- ▼ Third Header -->
      <div id="third-header">
        <ul class="third-header-inner">
          <li class="active">
            <a href="javascript:;">新增茶桌</a>
          </li>
        </ul>
      </div>
      <!-- ▲ Third Header -->
    <!-- ▼ Container App -->
    <div class="container-app">
      <div class="app-inner clearfix">
        <div class="app-init-container">
          <div class="app__content">
            <div class="meal_con">
              <div class="meal_con_main_con">
                <?php if($_GET['ok_tips']){?>
                <div class="form-group" style="margin-left:0px;" id="back">
                  <span style="color:blue;"><?php echo $_GET['ok_tips'];?></span>
                </div>
                <?php }?>
                <form method="post" id="table_form" enctype="multipart/form-data" action="<?php echo dourl('meal:table_edit'); ?>&physical_id=<?php echo $_GET['physical_id'];?>&cz_id=<?php echo $czn['cz_id'];?>" id="store_form">
                  <input  type="hidden" name="physical_id" value="<?php echo $_GET['physical_id'];?>" />
                  <table class="infoTable" align="center" style="margin-left: 20px;margin-top:20px;">
                    <tr>
                      <td class="table_edit_td">所属茶馆:</td>
                      <td>
                        <?php echo $now_store['name'];?></td>
                      </tr>
                      <tr>
                        <td class="table_edit_td"><em class="required">*</em>包厢名称:</td>
                        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="name" maxlength="20" type="text" id="store_name" value="" /></td>
                      </tr>
                      <tr>
                        <td class="table_edit_td"><em class="required">*</em>所属分类:</td>
                        <td class="paddingT15 wordSpacing5"><select name="wz_id">
                          <option value="">请选择</option>
                          <?php if(!empty($cat_list)){ ?>
                          <?php foreach($cat_list as $r){ ?>
                          <option value="<?php echo $r['cat_id'];?>" ><?php echo $r['cat_name'];?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="table_edit_td"><em class="required">*</em>缩略图:</td>
                        <td class="paddingT15 wordSpacing5">
                          <div class="img-list ui-sortable">
                            <ul class="js-img-list app-image-list clearfix table_edit_img">
                             <div class="preview-img-box"></div>
                             <li>
                              <a href="javascript:;" class="js-add-img">+加图</a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table_edit_td"><em class="required">*</em>包厢图片:</td>
                      <td class="paddingT15 wordSpacing5">
                        <div class="picture-list ui-sortable">
                          <ul class="js-picture-list app-image-list clearfix table_edit_img">
                            <li>
                              <a href="javascript:;" class="js-add-picture">+加图</a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table_edit_td"><em class="required">*</em>包厢介绍:</td>
                      <td class="paddingT15 wordSpacing5"><textarea name="description" cols="25" rows="5"></textarea></td>
                    </tr>
                    <tr>
                      <td class="table_edit_td"><em class="required">*</em>包厢价格:</td>
                      <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="price" type="text" id="price" value="" palcehol/> 元/小时</td>
                    </tr>
                    <tr>
                      <td class="table_edit_td"><em class="required"> </em>优惠政策:</td>
                      <td class="paddingT15 wordSpacing5"><textarea name="sale" cols="25" rows="2"></textarea></td>
                    </tr>
                    <tr>
                      <td class="table_edit_td"><em class="required">*</em>容纳人数:</td>
                      <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="zno" type="text" id="zno" value=""/></td>
                    </tr>
                    <tr>
                      <td class="table_edit_td"> <label for="state"><em class="required">*</em>开放预约:</label></td>
                      <td class="paddingT15 wordSpacing5"><label style="float: left;margin-right: 20px;"><input type="radio" value="1" name="status" checked="true">&nbsp;可预约</label><label  style="float: left;margin-right: 20px;"><input type="radio" value="2" name="status">&nbsp;不可预约</label></td>
                    </tr>
                    <tr>
                      <td class="paddingT15 wordSpacing5" colspan="2">
                       <script id="editor_add" name="content" type="text/plain"></script>
                     </td>
                   </tr>
                   <tr>
                    <td class="paddingT15"><input class="ui-btn1 ui-btn-primary" type="button" id="table_submit" name="Submit" value="提交" style="margin-bottom: 20px;"/>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include display('public:footer');?>
</body>
</html>
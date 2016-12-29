<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
			<?php if($withdrawal_count > 0): ?><script type="text/javascript">
					$(function(){
						$('#nav_4 > dd > #leftmenu_Order_withdraw', parent.document).html('提现记录 <label style="color:red">(' + <?php echo ($withdrawal_count); ?> + ')</label>')
					})
				</script><?php endif; ?>
			<?php if($unprocessed > 0): ?><script type="text/javascript">
					$(function(){
						if ($('#leftmenu_Credit_returnRecord', parent.document).length > 0) {
							var menu_html = $('#leftmenu_Credit_returnRecord', parent.document).html();
							menu_html = menu_html.split('(')[0];
							menu_html += ' <label style="color:red">(<?php echo ($unprocessed); ?>)</label>';
							$('#leftmenu_Credit_returnRecord', parent.document).html(menu_html);
						}
					})
				</script><?php endif; ?>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 
<script type="text/javascript" src="<?php echo ($root_path); ?>/template/user/default/js/base.js"></script>
<style type="text/css">
    a {
        color: #444444;
        text-decoration: none;
    }
    a, a:hover {
        text-decoration: none;
    }
    .platform-tag {
        display: inline-block;
        vertical-align: middle;
        padding: 3px 7px 3px 7px;
        background-color: #f60;
        color: #fff;
        font-size: 12px;
        line-height: 14px;
        border-radius: 2px;
    }
</style>
<script type="text/javascript">
    //删除
    $('.js-cancel-to-fx').live('click', function(e){
        var pigcms_id = $(this).data('id');
        if (!confirm("记录将不可恢复，确定删除？")) {
            return false;
        }
        $.post("<?php echo U('Promotion/detach_promote')?>", {'pigcms_id': pigcms_id}, function(data){
            if (data.err_code == 0) {
                window.top.msg(1, data.message);
                setTimeout('history.go(0)',1000);//延时1秒
            } else {
                window.top.msg(1, data.message);
                setTimeout('history.go(0)',1000);//延时1秒
            }
        },'json');
    });

    //开启海报
    $('.js-enable-up').live('click', function(e){
        var pigcms_id = $(this).data('id');
        var type = 1;
        if (!confirm("确认开启")) {
            return false;
        }
        $.post('<?php echo U("Promotion/enable")?>', {'pigcms_id': pigcms_id,'type': type}, function(data){
            if (data.err_code == 0) {
                window.top.msg(1, data.message);
                setTimeout('history.go(0)',1000);//延时1秒
            } else {
                window.top.msg(1, data.message);
                setTimeout('history.go(0)',1000);//延时1秒
            }
        },'json');
    });

    //关闭海报
    $('.js-enable-down').live('click', function(e){
        var pigcms_id = $(this).data('id');
        var type = 0;
        if (!confirm("确认关闭")) {
            return false;
        }
        $.post('<?php echo U("Promotion/enable")?>', {'pigcms_id': pigcms_id, 'type': type}, function(data){
            if (data.error == 0) {
                window.top.msg(1, data.message);
                setTimeout('history.go(0)',1000);//延时1秒
            } else {
                window.top.msg(1, data.message);
                setTimeout('history.go(0)',1000);//延时1秒
            }
        },'json');
    });


    $('.js-enable-up').live('mouseover', function(e){
        var text = $(this).text();
        if(text == '未启用')
        {
            $(this).text('启　用');
        }
    });

    $('.js-enable-up').live('mouseout',function(){
        var text = $(this).text();
        if(text == '启　用'){
            $(this).text('未启用');
        }
    });

    $('.js-enable-down').live('mouseover', function(e){
        var text = $(this).text();
        if(text == '已启用')
        {
            $(this).text('关　闭');
        }
    });

    $('.js-enable-down').live('mouseout',function(){
        var text = $(this).text();
        if(text == '关　闭'){
            $(this).text('已启用');
        }
    });

    $('.js-search-btn').live('click', function(){
        keyword = $.trim($('.filter-box-search').val());           /* 海报名称 */
        load_page('.app__content', load_url, {page:'promotional_list','keyword': keyword}, '', function(){
            if(keyword != ''){
                $('.filter-box-search').val(keyword);
            }
        });
    });
</script>
<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="<?php echo U('Promotion/index');?>" class="on">海报列表</a>
            <a href="<?php echo U('Promotion/add');?>" class="on">添加推广海报</a>
        </ul>
    </div>
    <table class="search_table" width="100%">
        <tr>
            <td>
                <form action="<?php echo U('Promotion/index');?>" method="post">
                    <input type="hidden" name="c" value="Promotion"/>
                    <input type="hidden" name="a" value="index"/>
                    <input type="text" name="keyword" placeholder="海报名称" class="input-text" value="<?php echo $name;?>"/>
                    <input type="submit" value="查询" class="button"/>
                </form>
            </td>
        </tr>
    </table>
    <form name="myform" id="myform" action="" method="post">
        <div class="table-list">
            <style>
                .table-list td{line-height:22px;padding-top:5px;padding-bottom:5px;}
            </style>
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>编号</th>
                    <th class="textcenter">海报名称</th>
                    <th>修改时间</th>
                    <th>海报类型</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($promote_list)) {?>
                    <?php foreach($promote_list as $list) {?>
                        <tr>
                        <td class="goods-meta"> <?php echo $list['pigcms_id']; ?></td>
                        <td class="textcenter"> <?php echo $list['name']; ?></td>
                        <td>
                            <?php echo date("Y-m-d H:i:s",$list['update_time']);?>
                        </td>
                        <td>
                            <?php if($list['poster_type'] == 1) {?>
                        横式模板
                    <?php } elseif ($list['poster_type'] == 2) {?>
                        竖式模板
                    <?php } elseif ($list['poster_type'] == 3) {?>
                        正方形模板
                    <?php } ?>
                        </td>
                        <td>
                            <?php echo $list['status'] == 1 ? '有效' : '<span style="color:red;">已删除</span>';?>
                        </td>

                        <td>
                            <?php if($list['type']){?>
                        <a href="javascript:;" data-id="<?php echo $list['pigcms_id']; ?>" class="js-enable-down">已启用</a>&nbsp;|&nbsp;
                    <?php } elseif (empty($list['type'])) {?>
                        <a href="javascript:;" data-id="<?php echo $list['pigcms_id']; ?>" class="js-enable-up">未启用</a>&nbsp;|&nbsp;
                    <?php }?>
                            <a href="<?php echo U('Promotion/edit' ,array('pigcms_id'=>$list['pigcms_id']));?>">编辑</a>&nbsp;|&nbsp;
                            <a href="javascript:;" data-id="<?php echo $list['pigcms_id']; ?>" class="js-cancel-to-fx">删除</a>
                        </td>
                <?php }?>
                    <tr><td class="textcenter pagebar" <?php if(in_array($my_version,array(4,8))) {?>colspan="11"  <?php }else{?>colspan="10"<?php }?>><?php echo ($page); ?></td></tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </form>
</div>
	</body>
</html>
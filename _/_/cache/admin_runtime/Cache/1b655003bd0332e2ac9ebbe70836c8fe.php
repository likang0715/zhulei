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
>     <style type="text/css">        a {            color:blue;        }        a, a:hover {            text-decoration: none;        }        .platform-tag {            display: inline-block;            vertical-align: middle;            padding: 3px 7px 3px 7px;            background-color: #f60;            color: #fff;            font-size: 12px;            line-height: 14px;            border-radius: 2px;        }    </style>    <script type="text/javascript">        $(function() {            $('.status-enable > .cb-enable').click(function(){                if (!$(this).hasClass('selected')) {                    var product_id = $(this).data('id');                    $.post("<?php echo U('Product/status'); ?>",{'status': 1, 'id': product_id}, function(data){})                }            })            $('.status-disable > .cb-disable').click(function(){                if (!$(this).hasClass('selected')) {                    var product_id = $(this).data('id');                    if (!$(this).hasClass('selected')) {                        $.post("<?php echo U('Product/status'); ?>", {'status': 0, 'id': product_id}, function (data) {})                    }                }            })			//是否热门			$('.status-enable-hot > .cb-enable').click(function(){				if (!$(this).hasClass('selected')) {					var product_id = $(this).data('id');					$.post("<?php echo U('Product/ishot'); ?>",{'is_hot': 1, 'id': product_id}, function(data){})				}			})			$('.status-disable-hot > .cb-disable').click(function(){				if (!$(this).hasClass('selected')) {					var product_id = $(this).data('id');					if (!$(this).hasClass('selected')) {						$.post("<?php echo U('Product/ishot'); ?>", {'is_hot': 0, 'id': product_id}, function (data) {})					}				}			})	        })    </script>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="<?php echo U('Product/fxlist');?>" class="on" id="url_for_checkout" >分销源商品列表</a>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td>						<form action="<?php echo U('Product/fxlist');?>" method="get">							<input type="hidden" name="c" value="Product"/>							<input type="hidden" name="a" value="fxlist"/>							筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>"/>							<select name="type">								<option value="product_id" <?php if($_GET['type'] == 'product_id'): ?>selected="selected"<?php endif; ?>>商品编号</option>								<option value="name" <?php if($_GET['type'] == 'name'): ?>selected="selected"<?php endif; ?>>商品名称</option>								<option value="store" <?php if($_GET['type'] == 'store'): ?>selected="selected"<?php endif; ?>>店铺名称</option>							</select>                            &nbsp;&nbsp;分类：                            <select name="category">                                <option value="0">商品分类</option>                                <?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?><option value="<?php echo ($category["cat_id"]); ?>"><?php if ($category['cat_level'] > 1){ echo str_repeat('&nbsp;&nbsp;', $category['cat_level']); } ?> |-- <?php echo ($category["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>                            </select>							&nbsp;&nbsp;							是否热门：                            <select name="is_hot">                                <option value="">全部</option>                                <option value="0" <?php if($_GET['is_hot'] == '0'): ?>selected="selected"<?php endif; ?>>否</option>								<option value="1" <?php if($_GET['is_hot'] == '1'): ?>selected="selected"<?php endif; ?>>是</option>                            </select>							&nbsp;&nbsp;							是否（启用/上线）：                            <select name="status">                                <option value="">全部</option>                                <option value="0" <?php if($_GET['status'] == '0'): ?>selected="selected"<?php endif; ?>>仓库中</option>								<option value="1" <?php if($_GET['status'] == '1'): ?>selected="selected"<?php endif; ?>>上架</option>                            </select>														<!-- &nbsp;&nbsp;分组：                            <select name="group">                                <option value="0">商品分组</option>                                <?php if(is_array($groups)): $i = 0; $__LIST__ = $groups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><option value="<?php echo ($group['group_id']); ?>" <?php if($_GET['group']== $group['group_id']): ?>selected<?php endif; ?>><?php echo ($group['group_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>                            </select>                            &nbsp;&nbsp;会员折扣：                            <select name="allow_discount">                                <option value="*">选择</option>                                <option value="1" <?php if($_GET['allow_discount']== 1): ?>selected<?php endif; ?>>有</option>                                <option value="0" <?php if (isset($_GET['allow_discount']) && is_numeric($_GET['allow_discount']) && $_GET['allow_discount'] == 0) { ?>selected<?php } ?>>无</option>                            </select>                            &nbsp;&nbsp;发票：                            <select name="invoice">                                <option value="*">选择</option>                                <option value="1" <?php if($_GET['invoice']== 1): ?>selected<?php endif; ?>>有</option>                                <option value="0" <?php if (isset($_GET['invoice']) && is_numeric($_GET['invoice']) && $_GET['invoice'] == 0) { ?>selected<?php } ?>>无</option>                            </select>-->							<input type="submit" value="查询" class="button"/>							<input type="button" value="导出" class="button search_checkout" />						</form>					</td>				</tr>			</table>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<style>					.table-list td{line-height:22px;padding-top:5px;padding-bottom:5px;}					</style>					<table width="100%" cellspacing="0">						<thead>							<tr>								<th>编号</th>                                <th class="textcenter">图片</th>								<th>名称</th>								<th>分类</th>                                <!--th>分组</th-->                                <th>店铺</th>								<th>价格(元)</th>                                <!--th>原价(元)</th-->								<th>数量(件)</th>								<th>销量(件)</th>								<!--th>买家限购</th-->								<!--th class="textcenter">是/否参与折扣</th-->								<!--th class="textcenter">是/否有发票</th-->								<th class="textcenter">添加时间</th>								<th class="textcenter" width="120">是否热门</th>								<th class="textcenter" width="100">操作</th>							</tr>						</thead>						<tbody>							<?php if(!empty($products)): if(is_array($products)): $i = 0; $__LIST__ = $products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$product): $mod = ($i % 2 );++$i;?><tr>										<td><?php echo ($product["product_id"]); ?></td>                                        <td class="textcenter"><img src="<?php echo ($product["image"]); ?>" width="60" /></td>										<td><?php echo ($product["name"]); ?>                                            <?php if($product['source_product_id'] > 0): ?><br/>                                            <span class="platform-tag">分销</span><?php endif; ?>                                        </td>										<td><?php echo ($product["category"]); ?></td>                                        <!--td><?php echo ($product["group"]); ?></td-->                                        <td><?php echo ($product["store"]); ?></td>										<td><?php echo ($product["price"]); ?></td>										<!--td><?php echo ($product["original_price"]); ?></td-->										<td><?php echo ($product["quantity"]); ?></td>										<td><?php echo ($product["sales"]); ?></td>										<!--td><?php echo ($product["buyer_quota"]); ?></td-->										<!--td class="textcenter"><?php if($product['allow_discount'] == 1): ?>是<?php else: ?>否<?php endif; ?></td-->										<!--td class="textcenter"><?php if($product['invoic'] == 1): ?>有<?php else: ?>无<?php endif; ?></td-->										<td class="textcenter"><?php echo (date('Y-m-d H:i:s', $product["date_added"])); ?></td>                                        <td class="textcenter">                                            <span class="cb-enable status-enable-hot"><label class="cb-enable <?php if($product['is_hot'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $product['product_id']; ?>"><span>热门</span><input type="radio" name="is_hot" value="1" <?php if($product['product_id'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>                                            <span class="cb-disable status-disable-hot"><label class="cb-disable <?php if($product['is_hot'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $product['product_id']; ?>"><span>非热门</span><input type="radio" name="is_hot" value="0" <?php if($product['product_id'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>                                        </td>                                        <td>                                            <span class="cb-enable status-enable"><label class="cb-enable <?php if($product['status'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $product['product_id']; ?>"><span>启用</span><input type="radio" name="status" value="1" <?php if($product['product_id'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>                                            <span class="cb-disable status-disable"><label class="cb-disable <?php if($product['status'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $product['product_id']; ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php if($product['product_id'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>                                        </td>									</tr><?php endforeach; endif; else: echo "" ;endif; ?>								<tr><td class="textcenter pagebar" colspan="11"><?php echo ($page); ?></td></tr>							<?php else: ?>								<tr><td class="textcenter red" colspan="11">列表为空！</td></tr><?php endif; ?>						</tbody>					</table>				</div>			</form>		</div><script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>

<script type="text/javascript">
    $(function() {
        
        if($('.url_for_checkout').hasClass('on')){
            var checkout_url = $('.url_for_checkout').filter('.on').attr('href');
        }else{
             var checkout_url = $('#url_for_checkout').attr('href');
        }


       $(".search_checkout").click(function(){
  
            var loadi =layer.load('正在导出', 10000000000000);

            var searchcontent = encodeURIComponent(window.location.search.substr(1));

            $.post(
                    checkout_url,
                    {"searchcontent":searchcontent},
                    function(obj) {
                        layer.close(loadi);
                        if(obj.msg>0) {
                            layer.confirm('该条件下有记录  '+obj.msg+' 条，确认导出？',function(index){
                               layer.close(index);
                               location.href=checkout_url+"&searchcontent="+searchcontent+"&download=1";
                            });
                        } else {
                            layer.alert('该搜索条件下没有数据，无需导出！', 8); 
                        }
                        
                    },
                    'json'
            )

        })

    })
</script>	</body>
</html>
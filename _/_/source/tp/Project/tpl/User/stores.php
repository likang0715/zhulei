<include file="Public:header"/>
    <script type="text/javascript">
        $(function(){
            $('span > .cb-enable').click(function(){
                if (!$(this).hasClass('selected')) {
                    var store_id = $(this).data('id');
                    $.post("<?php echo U('Store/status'); ?>",{'status': 1, 'store_id': store_id}, function(data){})
                }
            })
            $('span > .cb-disable').click(function(){
                var store_id = $(this).data('id');
                if (!$(this).hasClass('selected')) {
                    $.post("<?php echo U('Store/status'); ?>",{'status': 0,  'store_id': store_id}, function(data){})
                }
            })
            $(".js-store_status").change(function () {
				var store_id = $(this).closest("th").data("id");
				var status = $(this).val();
				$.post("<?php echo U('Store/status'); ?>",{'status': status,  'store_id': store_id}, function(data){})
			});
        })
    </script>
    <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
        <tr>
            <th><b>Logo</b></th>
            <th><b>店铺名称</b></th>
            <th><b>主营类目</b></th>
            <th style="text-align: right"><b>收入</b></th>
            <th style="text-align: right"><b>可提现余额</b></th>
            <th style="text-align: right"><b>待结算余额</b></th>
            <th style="text-align: center"><b>操作</b></th>
        </tr>
        <volist name="stores" id="store">
        <tr>
            <th><img src="{pigcms{$store.logo}" width="60" height="60" /></th>
            <th>{pigcms{$store.name}</th>
            <th>{pigcms{$store.sale_category}</th>
            <th style="text-align: right">{pigcms{$store.income}</th>
            <th style="text-align: right">{pigcms{$store.balance}</th>
            <th style="text-align: right">{pigcms{$store.unbalance}</th>
            <th style="text-align: center;width:90px" data-id="<?php echo $store['store_id']; ?>">
            	<select class="js-store_status">
            		<option value="1" <if condition="$store['status'] eq 1">selected="selected"</if>>正常</option>
            		<option value="2" <if condition="$store['status'] eq 2">selected="selected"</if>>待审核</option>
            		<option value="3" <if condition="$store['status'] eq 3">selected="selected"</if>>审核未通过</option>
            		<option value="4" <if condition="$store['status'] eq 4">selected="selected"</if>>店铺关闭</option>
            		<?php 
            		if ($store['drp_supplier_id']) {
            		?>
            			<option value="5" <if condition="$store['status'] eq 5">selected="selected"</if>>供货商关闭</option>
            		<?php 
            		}
            		?>
            	</select>
            </th>
        <tr/>
        </volist>
    </table>
<include file="Public:footer"/>
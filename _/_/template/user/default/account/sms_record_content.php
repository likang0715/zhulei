<style type="text/css">
	.get-web-img-input {height: 30px!important;}
	.pull-left {float: left;}
</style>
<div>
<!------------------------------------------------>

<div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
                <tr> 
					<th class="cell-10" style="min-width: 30px; max-width: 30px;">&nbsp;</th>
					<th class="cell-10" style="min-width: 200px; max-width: 200px;">下单时间/付款时间</th>

					<th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
						<a href="javascript:;" class="orderby" data-orderby="quantity">订单号</a>
					</th>
					<th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
						<a href="javascript:;" class="orderby" data-orderby="sales">短信单价</a>
					</th>
					<th class="cell-12" style="min-width: 102px; max-width: 102px;">
						<a href="javascript:;" class="orderby" data-orderby="date_added">购买数量</a>
					</th>
					<th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
						<a href="javascript:;" class="orderby" data-orderby="sort">支付金额<span class="orderby-arrow desc"></span></a>
					</th>
					<th class="cell-15 text-right" style="min-width: 127px; max-width: 127px;">结果/操作</th>
				</tr>
            </thead>
            <tbody class="js-list-body-region">
				<?php 
				if(count($sms_list) > 0) {
				foreach($sms_list as $sms){ ?>
                <tr>
                    <td class="checkbox">
                        <input type="checkbox" class="js-check-toggle" value="116">
                    </td>

                    <td class="goods-meta">
                        <p class="goods-title">
                            下单时间：<?php echo date("Y-m-d H:i:s",$sms['dateline']);?>                                                   </a>
                        </p>
						<?php if($sms['pay_dateline']) {?>
                        <p>
                            付款时间：<?php echo date("Y-m-d H:i:s",$sms['pay_dateline']);?>       
                        </p>
						<?php }?>
                    </td>

                    <td class="text-right"><?php echo $sms['smspay_no'];?></td>
                    <td class="text-right">￥<?php echo $sms['sms_price']*0.01;?></td>
                    <td class=""><?php echo $sms['sms_num'];?>条</td>
                    <td class="text-right">
                        <a class="js-change-num" href="javascript:void(0);">&yen;<?php	echo $sms['money']?></a>
                        <input class="input-mini js-input-num" type="number" min="0" maxlength="8" style="display:none;" data-id="116" value="0">
                    </td>
                    <td class="text-right">
                        <p>
							<!--
                            <a href="javascript:void(0);" class="js-delete" data="116">删除</a><span>-</span>
                            <a href="javascript:void(0);" class="js-promotion-btn" data-fx="false" data="116">推广商品</a>
							-->
							
							<?php	if($sms['status'] == '0') {?>
									未支付
									<?php if(time() - $sms['dateline']<86400){?>
									（<a class="unpay" href="#edit/<?php echo $sms['smspay_no'];?>"  style="color:#c00;font-weight:700">去支付</a>）
									<?php }else{?>
									（已过期）
									<?php }?>
							<?php } elseif($sms['status'] == '1') {?>
									<b style='color:#07d'>已支付</b>
							<?php }?>
							
							
                        </p>
                      
                    </td>
                </tr>
                <?php }
				} else {
				?>
				
                <tr>
                    <td colspan="7" align="center">
                       暂无购买短信记录！
                    </td>
				</tr>
                   
				<?php }
				?>

                        
             </tbody>
        </table>
		
		<div class="js-list-footer-region ui-box">
			<div>
			<!--
				<div class="pull-left">
					<a href="javascript:;" class="ui-btn js-batch-delete">删除</a>
				</div>
			-->	
				<div class="pagenavi js-page-list"><?php echo $pages;?></div></div>
			</div>
            </div>
		
</div>






















<!-------------------------------------------------->
	<form class="form-horizontal">
		<fieldset>

			<div class="control-group">
				<label class="control-label">短信价格：</label>

				<div class="controls">
					<input type="text" data-price="<?php echo $sms_price;?>" readonly="readonly" value="<?php echo $sms_price;?>分/条" name="sms_price" maxlength="15" />
				</div>
			</div>
			<div class="control-group">&#12288;</div>
			<div class="control-group">
				<label class="control-label">购买条数：</label>

				<div class="controls">
					<input type="text" value="1000" class="sms_amount" name="sms_amount" maxlength="6" /> 条 （1000条起订）
				</div>
			</div>
			<div class="control-group">&#12288;</div>
			<div class="control-group">
				<label class="control-label">价格合计：</label>

				<div class="controls controls_account">
					<?php echo $sms_price*10;?>元
				</div>
			</div>
			<div class="control-group">&#12288;</div>
			<div class="control-group control-action">
				<div class="controls">
					<button class="btn btn-large btn-primary js-btn-submit" type="button" data-loading-text="正在提交...">确认购买</button>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?php dourl('store:select'); ?>">取消</a>
				</div>
			</div>

		</fieldset>
	</form>
</div>
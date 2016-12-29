<?php include display( 'public:person_header');?>
<style type="text/css">
.col-table a,.ftag div,.date{ font-size:12px;}
</style>
<div id="con_one_3">
                    <div class="danye_content_title">
                        <div class="danye_suoyou"><a href="###"><span>商品关注</span></a></div>
                    </div>
                    <div class="col-table">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <th width="80"></th>
                                    <th width="300">商品</th>
                                    <th width="175" class="tb02">价格</th>
                                    <th width="120">库存</th>
                                    <th width="120">操作</th>
                                </tr>
                            </tbody>
                            <tbody id="follow_table">
							
							<?php
						foreach ($product_list as $product) {
					?>
                                <tr id="tr_1159804448">
                                    <td><a target="_blank" href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>"> <img width="100" height="100" src="<?php echo $product['image'] ?>" alt="<?php echo $product['name']; ?>"> </a></td>
                                    <td class="tb01"><div class="p-name"> <a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank"><?php echo $product['name']; ?></a> </div>
                                        
                                        <div class="ftag">
                                            <div id="t1159804448" piden="" clstag="homepage|keycount|guanzhu|bjbiaoqian"> 成交<?php echo $product['sales'] < 10 ? '10笔以内' : $product['sale'] . '笔' ?> </div>
                                            <div class="prompt-01" pid="1159804448" style="display:none"></div>
                                        </div>
                                        <div class="date"> 关注时间：<?php echo date('Y-m-d',$product['add_time']); ?> </div>
                                        <div class="btns"> <a id="a_simi_1159804448" class="btn btn-12 psame" style="display:none" href="javascript:void(0);" clstag="click|count|follow|btnsimi"> <s></s><b></b>找相似</a> <a id="a_match_1159804448" class="btn btn-12 pcoll" style="display:none" href="javascript:void(0);" clstag="click|count|follow|btnmatch"> <s></s><b></b>找搭配</a> 
                                        </div></td>
                                    <td class="tb02"><div class="p-price" id="price_1159804448"> ￥<?php echo $product['price'] ?> </div></td>
                                    <td><div class="p-state">
                                            <div id="f_1159804448" class="ac"> <?php echo $product['quantity'] ?> </div>
                                        </div>
                                        <input type="hidden" id="state_1159804448" value="0">
                                        <input type="hidden" id="isLoc_1159804448" value=""></td>
                                    <td><ul class="operating">
                                            <li><a id="buyCart_1159804448" class="btn-add" href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>">我要购买</a></li>
                                            <li><a onclick="attention_cancel(<?php echo $product['product_id'];?>, 1,<?php echo $product['store_id'];?>)" href="javascript:void(0);">取消关注</a></li>
                                        </ul></td>
                                </tr>
                                <?php
						}
								?>
                                
                            </tbody>
                        </table>
                    </div>
					
					<?php if ($pages) { ?>
					
					<div class="page_list" id="pages">
                        <dl>
                            <?php echo $pages ?>
							</dl>
                    </div>
					<?php 
				}
				?>
			</div>
                </div>
				<?php include display( 'public:person_footer');?>
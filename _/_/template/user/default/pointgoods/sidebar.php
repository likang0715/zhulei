			<?php 
                $select_sidebar=isset($select_sidebar) ? $select_sidebar : ACTION_NAME;
                $uid = $user_session['uid'];
                
                if ($user_session['type'] == 1) {

                    function checkIsShow($action_id, $uid){

                        $physicalRbac = M("Rbac_action")->getControlArr($uid, MODULE_NAME);
                        if (in_array($action_id, $physicalRbac)) return true;

                        return false;
                    }

                } else {
                    function checkIsShow(){
                        return true;
                    }
                }

            ?>
            <aside class="ui-sidebar sidebar">
                <nav>
                    <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
                        <?php if (checkIsShow('create', $uid)) { ?>
                        <ul>
                            <li>
                                <a class="ui-btn ui-btn-success" href="<?php dourl('create');?>">发布积分礼物</a>
                            </li>
                        </ul>
                        <?php } ?>
                        <h4>礼物管理</h4>
                        <ul>
                            <?php if (checkIsShow('index', $uid)) { ?>
                            <li <?php if($select_sidebar == 'index') echo 'class="active"';?>>
                                <a href="<?php dourl('index');?>">兑换中的礼物</a>
                            </li>
                            <?php } ?>

                            <?php if (checkIsShow('stockout', $uid)) { ?>
                            <li <?php if($select_sidebar == 'stockout') echo 'class="active"';?>>
                                <a href="<?php dourl('stockout'); ?>">兑完/下架 的商品</a>
                            </li>
                            <?php } ?>

                            <?php if (checkIsShow('soldout', $uid)) { ?>
                            <li <?php if($select_sidebar == 'soldout') echo 'class="active"';?>>
                                <a href="<?php dourl('soldout'); ?>">仓库中的积分商品</a>
                            </li>
                            <?php } ?>

                            <?php if (checkIsShow('category', $uid)) { ?>
                            <li <?php if($select_sidebar == 'category') echo 'class="active"';?>>
                                <a href="<?php dourl('category'); ?>">积分商品分组</a>
                            </li>
                            <?php } ?>
                        </ul>
                        <h4>评论管理</h4>
                        <ul>
                            <?php if (checkIsShow('product_comment', $uid)) { ?>
                            <li <?php if($select_sidebar == 'product_comment') echo 'class="active"';?>>
                                <a href="<?php dourl('product_comment');?>">积分商品评价</a>
                            </li>
                            <?php } ?>

                            <?php if(($wd_version == 8 || $wd_version == 4) || (empty($_SESSION['sync_store']) && empty($version))){?>

                                <?php if (checkIsShow('store_comment', $uid)) { ?>
                                <li <?php if($select_sidebar == 'store_comment') echo 'class="active"';?>>
                                    <a href="<?php dourl('store_comment'); ?>">积分商城评价</a>
                                </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>

                        
                        <?php if($user_session['type']==1): ?>
                        <!-- <h4>门店管理</h4>
                        <ul>
                            <li <?php if($select_sidebar == 'physical_stock') echo 'class="active"';?>>
                                <a href="<?php dourl('physical_stock');?>">库存</a>
                            </li>
                        </ul> -->
                        <?php endif; ?>
                    <?php } ?>
                </nav>
            </aside>
			<?php
                $version      = option('config.weidian_version');
                $select_sidebar=isset($select_sidebar) ? $select_sidebar : ACTION_NAME;
                $uid = $user_session['uid'];

                if ($user_session['type'] == 1) {

                    function checkIsShow($action_id, $uid, $controller_id = MODULE_NAME){

                        if ($action_id == 'create') return false;

                        $physicalRbac = M("Rbac_action")->getControlArr($uid, $controller_id);
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
                    <ul>
                        <?php if (checkIsShow('dashboard', $uid, 'order')) { ?>
                        <li <?php if(in_array($select_sidebar,array('dashboard','statistics'))) echo 'class="active"';?>>
                            <a href="<?php dourl('pointorder:dashboard');?>">订单概况</a>
                        </li>
                        <?php } ?>
                        <?php if (checkIsShow('all', $uid, 'order')) { ?>
                        <li <?php if($select_sidebar == 'all') echo 'class="active"';?>>
                            <a href="<?php dourl('pointorder:all');?>">所有订单</a>
                        </li>
                        <?php } ?>
                        <?php if (!empty($_SESSION['drp_diy_store'])) { ?>

                            <?php if (checkIsShow('selffetch', $uid, 'order')) { ?>
                            <li <?php if($select_sidebar == 'selffetch') echo 'class="active"';?>>
                                <a href="<?php dourl('pointorder:selffetch'); ?>"><?php echo $store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '到店自提' ?>订单</a>
                            </li>
                            <?php } ?>
                            
                            <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
                            <?php if (checkIsShow('codpay', $uid, 'order')) { ?>
                            <li <?php if($select_sidebar == 'codpay') echo 'class="active"';?>>
                                <a href="<?php dourl('pointorder:codpay'); ?>">货到付款订单</a>
                            </li>
                            <?php } ?>
                            <?php } ?>
                        <?php } ?>


                        <?php if (checkIsShow('star', $uid, 'order')) { ?>
                        <li <?php if($select_sidebar == 'star') echo 'class="active"';?>>
                            <a href="<?php dourl('pointorder:star'); ?>">加星订单</a>
                        </li>
                        <?php } ?>

                    </ul>
                    <ul style="display:none">
                        <?php if (checkIsShow('delivery', $uid, 'trade')) { ?>
                            <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
                                <li <?php if($select_sidebar == 'delivery') echo 'class="active"';?>>
                                    <a href="<?php dourl('trade:delivery');?>">物流工具</a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>



                </nav>
            </aside>
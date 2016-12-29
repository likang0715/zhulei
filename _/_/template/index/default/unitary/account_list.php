<div class="m-user-duobao">
    <div class="m-user-comm-wraper">
        <div module="user/duobao/DuobaoMine" class="m-user-comm-cont m-user-duobaoMine">
            <div class="m-user-comm-title">
                <div class="m-user-comm-navLandscape js-list-nav">
                    <a class="i-item <?php if ($status == 'all') { echo 'i-item-active'; } ?>" data-status="all" href="javascript:void(0)">参与成功 <span></span></a>
                    <span class="i-sptln">|</span>
                    <a class="i-item <?php if ($status == 'reveal') { echo 'i-item-active'; } ?>" data-status="reveal" href="javascript:void(0)">即将揭晓 <span class="txt-impt"><?php echo $num_arr['reveal'] ?></span></a>
                    <span class="i-sptln">|</span>
                    <a class="i-item <?php if ($status == 'ing') { echo 'i-item-active'; } ?>" data-status="ing" href="javascript:void(0)">正在进行 <span class="txt-impt"><?php echo $num_arr['ing'] ?></span></a>
                    <span class="i-sptln">|</span>
                    <a class="i-item <?php if ($status == 'end') { echo 'i-item-active'; } ?>" data-status="end" href="javascript:void(0)">已揭晓 <span class="txt-impt"><?php echo $num_arr['end'] ?></span></a>
                </div>
            </div>
            <div pro="container">
                <div class="listCont" data-name="join" style="display: block;">    
                    <div>

                        <table class="w-table m-user-comm-table" pro="listHead">
                            <thead>
                                <tr>
                                    <th class="col-info">商品信息</th>
                                    <th class="col-period">期号</th>
                                    <th class="col-joinNum">参与人次</th>
                                    <th class="col-status">夺宝状态</th>
                                    <th class="col-opt">操作</th>
                                </tr>
                            </thead>
                        </table>
                        <div pro="duobaoList" class="duobaoList">
                            <?php if (empty($cart_list)) { ?>
                                <div class="m-user-comm-empty">
                                    <b class="ico ico-face-sad"></b>
                                    <div class="i-desc">您还没有相关记录哦~</div>
                                    <div class="i-opt"><a href="<?php dourl('unitary:index') ?>" class="w-button w-button-main w-button-xl">马上去逛逛</a></div>
                                </div>
                            <?php } ?>
                            <?php foreach ($cart_list as $val) { ?>
                            <table class="m-user-comm-table">
                                <tbody>
                                <tr class="<?php if ($user_session['uid'] == $val['luck_uid']) { echo 'getWin'; } ?>">
                                    <td class="col-info">
                                        <div class="w-goods w-goods-l w-goods-hasLeftPic">
                                            <div class="w-goods-pic">
                                                <a target="_blank" href="<?php dourl('unitary:detail', array('id'=>$val['id'])); ?>">
                                                    <img src="<?php echo $val['logopic'] ?>" alt="<?php echo $val['name'] ?>" width="74" height="74">
                                                </a>
                                                <?php if ($user_session['uid'] == $val['luck_uid']) { ?>
                                                <b class="ico ico-winner"></b>
                                                <?php } ?>
                                            </div>
                                            <p class="w-goods-title f-txtabb">
                                                <a title="<?php echo $val['name'] ?>" target="_blank" href="<?php dourl('unitary:detail', array('id'=>$val['id'])); ?>"><?php echo $val['name'] ?></a>
                                            </p>
                                            <p class="w-goods-price">总需：<?php echo $val['total_num'] ?>人次</p>

                                            <?php if ($val['state'] == 1) { ?>
                                            <!-- 进行中 -->
                                            <div class="w-progressBar">
                                                <p class="w-progressBar-wrap">
                                                    <span class="w-progressBar-bar" style="width:<?php echo number_format($val['proportion'], 2) ?>%"></span>
                                                </p>
                                                <ul class="w-progressBar-txt f-clear">
                                                    <li class="w-progressBar-txt-l">已完成<?php echo number_format($val['proportion'], 2) ?>%，剩余<span class="txt-residue"><?php echo $val['left_count'] ?></span></li>
                                                </ul>
                                            </div>
                                            
                                            <?php } else if ($val['state'] == 2 && $val['is_countdown'] == 1) { ?>
                                            <!-- 待揭晓 -->
                                            <div class="w-progressBar">
                                                <p class="w-progressBar-wrap">
                                                    <span class="w-progressBar-bar" style="width:100%"></span>
                                                </p>
                                                <ul class="w-progressBar-txt f-clear">
                                                    <li class="w-progressBar-txt-l">已完成100%，剩余<span class="txt-residue">0</span></li>
                                                </ul>
                                            </div>
                                            <?php } else if ($val['state'] == 2 && $val['is_countdown'] == 0) { ?>

                                            <!-- 已揭晓 -->
                                            <div class="winner">
                                                <div class="name">获得者：<a href="javascrit:void(0)" title="<?php echo $val['luck_name'] ?>"><?php echo $val['luck_name'] ?></a>（本期参与<strong class="txt-dark"><?php echo $val['user_count'] ?></strong>人次）</div>
                                                <div class="code">幸运代码：<strong class="txt-impt"><?php echo 100000 + $val['lucknum'] ?></strong></div>
                                                <div class="time">揭晓时间：<?php echo date('Y-m-d H:i:s', $val['endtime']) ?>.000</div>
                                            </div>

                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="col-period"><?php echo $val['id'] ?></td>
                                    <td class="col-joinNum"><?php echo $val['my_count'] ?>人次</td>
                                    <td class="col-status">
                                        <?php 
                                            if ($val['state'] == 1) {
                                                echo '<span class="txt-suc">正在进行</span>';
                                            } else if ($val['state'] == 2 && $val['is_countdown'] == 1) {
                                                echo '<span class="txt-wait">等待揭晓</span>';
                                            } else if ($val['state'] == 2 && $val['is_countdown'] == 0) {
                                                echo '<span>已揭晓</span>';
                                            }
                                        ?>
                                    </td>
                                    <td class="col-opt">
                                        <p><a href="javascript:void(0)" class="js-viewCode" data-count="<?php echo $val['my_count'] ?>" data-lucknum="<?php echo $val['my_lucknum_str'] ?>">查看夺宝号码</a></p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?php } ?>
                        </div>
                        <div class="w-pager">
                            <div class="pager js-my-list"><?php echo $pages; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
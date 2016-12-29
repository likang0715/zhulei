<!-- 夺宝参与记录 -->
<?php $unitary_detail = option('config.site_url').'/unitary/index.php?c=index&a=detail&id='; ?>
<script type="text/javascript">
    
// 分页
function changePage(page_type, status, p) {

    if (p.length == 0) {
        return;
    }

    var re = /^[0-9]*[1-9][0-9]*$/;
    if (!re.test(p)) {
        alert("请填写正确的页数");
        return;
    }

    load_page('.unitary_con', load_url, {'page':page_type, 'status':status, 'p':p }, '', function(){});
}

$(function () {

    var select_tab = $(".js-tab-list .tab-act");

    if (select_tab.data('status') == 'order') {
        var page_content = 'unitary_order';
        var status = '';
    } else if (select_tab.data('status') == 'reveal' || select_tab.data('status') == 'ing' || select_tab.data('status') == 'end' || select_tab.data('status') == 'all') {
        var page_content = 'unitary_list';
        var status = select_tab.data('status');
    }

    $("#pages a").click(function(){
        var p = $(this).attr("data-page-num");
        // console.log(status);
        changePage(page_content , status, p);
    });


});

</script>
<div class="unitary_con">
	
	<ul class="order_list_head clearfix">
		<li class="head_1">宝贝信息</li>
		<li class="head_2">数量 x 单价</li>
		<li class="head_3">合计</li>
		<li class="head_4">交易状态</li>
		<li class="head_5">操作</li>
	</ul>

	<div class="duobaoList">
        <?php if (empty($cart_list)) { ?>
        <div style="line-height:30px; padding-top:30px; font-size:16px;">暂无相关记录</div>
        <?php } ?>
        <?php foreach ($cart_list as $val) { ?>
        <table class="m-user-comm-table">
            <tbody>
            <tr class="<?php if ($user_session['uid'] == $val['luck_uid']) { echo 'getWin'; } ?>">
                <td class="col-info">
                    <div class="w-goods w-goods-l w-goods-hasLeftPic">
                        <div class="w-goods-pic">
                            <a target="_blank" href="<?php echo $unitary_detail.$val['id'] ?>">
                                <img src="<?php echo $val['logopic'] ?>" alt="<?php echo $val['name'] ?>" width="74" height="74">
                            </a>
                            <?php if ($user_session['uid'] == $val['luck_uid']) { ?>
                            <b class="ico ico-winner"></b>
                            <?php } ?>
                        </div>
                        <p class="w-goods-title f-txtabb">
                            <a title="<?php echo $val['name'] ?>" target="_blank" href="<?php echo $unitary_detail.$val['id'] ?>"><?php echo $val['name'] ?></a>
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
                            <div class="name">获得者：<?php echo $val['luck_name'] ?>（本期参与<strong class="txt-dark"><?php echo $val['user_count'] ?></strong>人次）</div>
                            <div class="code">幸运代码：<strong class="txt-impt"><?php echo 100000 + $val['lucknum'] ?></strong></div>
                            <div class="time">揭晓时间：<?php echo date('Y-m-d H:i:s', $val['endtime']) ?>.000</div>
                        </div>

                        <?php } ?>
                    </div>
                </td>
                <td class="col-period"><?php echo $val['my_count'].' x '.$val['item_price'].'元' ?></td>
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
    
	<div class="page_list" id="pages" style="margin-top: 20px;">
		<dl> <?php echo $pages ?> </dl>
	</div>

</div>
<!-- ▼ Main container -->
<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
        <div>
            <a href="#create" class="ui-btn ui-btn-primary btn-bargain-add">添加砍价</a>
            <div class="js-list-search ui-search-box">
                <input class="txt js-bargain-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
            </div>
        </div>
    </div>
</div>

<div class="msgWrap">
    <?php if($bargain_list) { ?>
    <table class="ListProduct" border="0" cellspacing="0" cellpadding="0" width="100%">
        <thead>
        <tr>
            <th width="120px">商品名称</th>
            <th width="100px">商品信息</th>
            <th width="100px">库存</th>
            <th width="80px">人数</th>
            <th width="60px">开始关闭</th>
            <th>操作</th>
            <th width="120px" class="norightborder">添加时间</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($bargain_list as $bargain) { ?>
        <tr pigcms_id="<?php echo $bargain['pigcms_id'];?>">
            <td><img src="<?php echo $bargain['logoimg1'];?>" style="max-height:100px;max-width: 100px;"><br/>
                <?php echo htmlspecialchars($bargain['name']) ?></td>
            <td>初始价：<?php echo $bargain['original'];?>元<br>最低价：<?php echo $bargain['minimum'];?>元<br></td>
            <td><?php echo $bargain['inventory'];?></td>
            <td>参与：<?php echo $bargain['count_canyu'];?><br>购买：<?php echo $bargain['count_pay'];?></td>
            <td><a class="js-trigger-image" href="javascript:void(0);"><input type="hidden" class="state" value="<?php echo $bargain['state'];?>"/>
                    <?php if($bargain['state']==1) { ?>
                    <img id="state<?php echo $bargain['pigcms_id'];?>" src="<?php echo STATIC_URL;?>images/start.png" width="60px">
                    <?php }else{ ?>
                    <img id="state<?php echo $bargain['pigcms_id'];?>" src="<?php echo STATIC_URL;?>images/stop.png" width="60px">
                    <?php } ?>
                </a>
            </td>
            <td class="norightborder" style="border-right:1px solid #eee">
                <a href="#edit/<?php echo $bargain['pigcms_id']?>" class="btn-bargain-edit">修改</a>
                <a href="javascript:drop_confirm('您确定要删除【<?php echo htmlspecialchars($bargain['name']) ?>】吗?', '/user.php?c=bargain&amp;a=edit_one&amp;token=ijpows1454304142&amp;type=delete_flag&amp;pigcms_id=<?php echo $bargain['pigcms_id'];?>&amp;value=1&amp;referurl=1')">删除</a>
                <a class="activity_promotion" target="_blank" href="javascript:void(0);">手机查看</a>
                <span class="js-promotion-cont hide">
                    <p class="team-code"><img src="<?php echo  option('config.site_url')."/source/qrcode.php?type=bargain&id=".$bargain['pigcms_id']."&store_id=".$_SESSION['store']['store_id'];?>" alt="砍价活动二维码" style="width: 100px;height: 100px;"/></p>
                    <p><a href="<?php echo  option('config.site_url')."/source/qrcode.php?type=bargain&id=".$bargain['pigcms_id']."&store_id=".$_SESSION['store']['store_id'];?>" download="" target="_blank">下载二维码</a></p>
                </span>
                <a target="_blank" href="<?php dourl('order:activity&activity_type=50&activity_id='.$bargain['pigcms_id']);?>">查看订单</a>
            </td>
            <td style="border-right:0"><?php echo date("Y-m-d H:i:s",$bargain['addtime']);?></td>
        </tr>
        <?php } ?>
        <?php if ($pages) { ?>
        <thead class="js-list-header-region tableFloatingHeaderOriginal">
        <tr>
            <td colspan="5">
                <div class="pagenavi js-bargain_list_page">
                    <span class="total"><?php echo $pages ?></span>
                </div>
            </td>
        </tr>
        </thead>
        <?php } ?>
        </tbody>
    </table>
    <?php }else{ ?>
    <div class="js-list-empty-region">
        <div>
            <div class="no-result widget-list-empty">还没有相关数据。</div>
        </div>
    </div>
    <?php } ?>
</div>
<div class="js-list-footer-region ui-box"></div>
<script type="text/javascript">
    function drop_confirm(msg, url)
    {
        if (confirm(msg)) {
            window.location.href = url;
        }
    };
    $('.activity_promotion').live("click",function(){
        var content = $(this).next('.js-promotion-cont').html();
        $('.popover-help-notes').remove();
        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 25) + 'px; left: ' + ($(this).offset().left - 28) +'px;"><div class="arrow"></div><div class="popover-inner" style="width: 120px;"><div class="popover-content">' + content + '</div></div></div>';
        $('body').append(html);
        $('.popover').focus();
        $('.popover-help-notes').show();
    });
    $('.activity_promotion').live('blur',function(){
        $('.popover-help-notes').remove();
    });
</script>

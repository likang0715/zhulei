<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
$(function(){
$("div").click(function(){
    var img=$(this).attr("img");
    if(img != undefined && img!=null){
        layer.open({
          type: 1,
          shade: false,
          title: false, //不显示标题
          area: ['60%', '60%'], //宽高
          content:  '<img src="'+img+'" style="width:100%;"/>'
        });
    }
})
})
</script>
<style type="text/css">
body{word-break: break-all;}
</style>
        <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
            <tr>
                <th width="120">ID</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $repayInfo['repay_id'];  ?></div></td>
                        <th width="120">回报类别</th>
                        <td width="35%">
                        <?php echo $repayInfo['redoundType']==1 ? '实物回报' : '虚拟物品回报';       ?>
                        </td>
            <tr/>
            <tr>
                <th style="width: 120px;">是否为抽奖档</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $repayInfo['raffleType']==1 ? '是' : '否'; ?></div></td>
                <th style="width: 120px;">回报档位</th>
                <td width="35%">
                <?php
                switch ($repayInfo['platform']) {
                    case '0':
                        echo '普通';
                        break;
                    case '1':
                        echo '手机优惠';
                        break;
                    case '2':
                        echo '手机专享';
                        break;
                }
                ?>
                </td>
            </tr>
            <?php if($repayInfo['raffleType']==1){ ?>
            <tr>
                <th width="120">抽奖规则</th>
                <td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;">
                <?php echo $repayInfo['raffleRule']==0 ? '每满'.$repayInfo['raffleBase'].'位支持者抽取1位幸运用户，不满足时也抽取1位。幸运用户将会获得'.$repayInfo['raffleReword'] : '将从所有支持者中抽取'.$repayInfo['luckyCount'].'位幸运用户。幸运用户将会获得'.$repayInfo['luckyReword']; ?>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <th width="120">回报内容</th>
                <td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;"><?php echo $repayInfo['redoundContent']; ?></td>
            </tr>
            <tr>
                <?php
                switch ($repayInfo['platform']) {
                    case '0':
                ?>
                    <th width="120">支持金额</th>
                    <td width="35%" colspan="3" ><div style="height:24px;line-height:24px;"><?php echo $repayInfo['amount'].'元'; ?></div></td>
                <?php
                        break;
                    case '1':
                ?>
                    <th width="120">支持金额</th>
                    <td width="35%" ><div style="height:24px;line-height:24px;"><?php echo $repayInfo['amount'].'元'; ?></div></td>
                    <th width="120">手机端金额</th>
                    <td width="35%"><?php echo $repayInfo['mamount'].'元'; ?></td>
                <?php
                        break;
                    case '2':
                ?>
                    <th width="120">手机端金额</th>
                    <td width="35%"><?php echo $repayInfo['mamount'].'元'; ?></td>
                <?php
                        break;
                }
                ?>
            </tr>
            <tr>
                <th width="120">说明图片</th>
                <td width="35%"  colspan="3" ><div img="<?php echo getAttachmentUrl($repayInfo['images']); ?>" style="height:24px;line-height:24px;color: green;"><?php echo getAttachmentUrl($repayInfo['images']);  ?></div></td>
            </tr>
            <tr>
                <th width="120">是否设置抢购</th>
                <td width="35%">
                <div  style="height:44px;line-height:24px;">
                <?php echo $repayInfo['scrambleStatus']==0 ? '否' : '是'; ?>
                </div>
                </td>
                <th width="120">限定名额</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $repayInfo['limits']==0 ? '不限' : $repayInfo['limits']; ?></div></td>

            </tr>
            <tr>
                <th width="120">运费</th>
                <td width="35%">
                <?php echo $repayInfo['freight']==0 ? '包邮' : $repayInfo['freight'].'元'; ?>
                </td>
                <th width="120">发票</th>
                <td width="35%"><?php echo $repayInfo['invoiceStatus']==0 ? '不可开发票' : '可开发票'; ?></td>
            </tr>
            <tr>
                <th width="120">是否填写备注信息</th>
                <td width="35%"><?php echo $repayInfo['remarkStatus']==1 ? '是' : '否'; ?></td>
                <th width="120">备注信息</th>
                <td width="35%">
                <div style="height:24px;line-height:24px;">
                <?php  echo $repayInfo['remark'];  ?>
                </div>
                </td>
            </tr>
            <tr>
                <th width="120">回报时间</th>
                <td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;"><?php echo '项目结束后'.$repayInfo['redoundDays'].'天，将会向支持者发送回报'; ?></td>
            </tr>
        </table>
<include file="Public:footer"/>
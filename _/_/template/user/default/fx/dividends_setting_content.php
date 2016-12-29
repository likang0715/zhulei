<?php
$dividends_send_rules_content = '';
/*
if($dividends_send_rules['type'] == 1){
    $dividends_send_rules_content .= '提现规则： 奖金提现无限制';
}else if($dividends_send_rules['type'] == 2){
    $dividends_send_rules_content .= '提现规则：  定时发放 每月'.$dividends_send_rules['rules'].'号 统一发放奖金 ';
}else if($dividends_send_rules['type'] == 3){
    $_rules = unserialize($dividends_send_rules['rules']);
    $_count = count($_rules);
    $dividends_send_rules_content .= '提现规则： 奖金提现分'.$_count.'份<br />';
    foreach ($_rules as $key => $value) {
        $dividends_send_rules_content .= '每月'.$value['rules3_day'].'号发放'.$value['rules3_percent'].'%,';
    }
    $dividends_send_rules_content = rtrim($dividends_send_rules_content,',');
}else{
    $dividends_send_rules_content .= '尚未添加相关提现规则';
}
*/

if($dividends_send_rules['type'] == 1){
    $dividends_send_rules_content .= '发放规则： 手动 (达到规则手动发放)';
}else if($dividends_send_rules['type'] == 2){
    $dividends_send_rules_content .= '发放规则： 自动 (达到规则自动发放)';
}else{
    $dividends_send_rules_content .= '尚未添加相关发放规则';
}

?> 
<nav class="ui-nav-table clearfix">
    <ul class="pull-left js-list-filter-region">
        <li id="js-list-nav-all"  class="active">
            <a href="#list">分红规则</a>
        </li>
        <li id="js-list-nav-all" >
            <a href="#sendrules">奖金发放规则</a>
        </li>
    </ul>
</nav>


<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
        <div>
            <a href="#create/<?php echo $dividends_rules_count;?>" class="ui-btn ui-btn-primary">新增分红规则</a>
        </div>
    </div>
</div>

<div class="widget-app-board ui-box member_degree" style="border: none;">
    <div class="widget-app-board-info">
        <div>
            <p>
                <?php echo $dividends_send_rules_content;?>
            </p>
        </div>
    </div>
   
</div>


<div class="ui-box">
<table class="ui-table ui-table-list" style="padding: 0px;">
<?php if (!empty($dividends_rules)) { ?>
<thead class="js-list-header-region tableFloatingHeaderOriginal">
<tr class="widget-list-header">
    <th class="cell-10 " >对象</th>
    <!-- <th class="cell-10 " >奖金池</th>
    <th class="cell-10 " >比例</th> -->
    <th class="cell-10 " >上限</th>
    <th class="cell-10 " >达标周期</th>
    <th class="cell-10 " >创建时间</th>
    <th class="cell-10 text-right" >操作</th>
</tr>
</thead>
<tbody class="js-list-body-region">
<?php
    $dx_arr = array(1=>'经销商',2=>'分销团队',3=>'分销商');
    foreach($dividends_rules as $rules) { ?>
<tr class="widget-list-item">
    <td >
        <div><?php echo $dx_arr[$rules['dividends_type']] ?></div>
    </td>
   <!--  <td >
        <div>交易额</div>
    </td>
    <td >
        <div><?php echo ($rules['percentage'] == 0)?100:$rules['percentage']; ?>%</div>
    </td> -->
    <td >
        <div><?php echo $rules['upper_limit'] ?></div>
    </td>
    <td >
        <div>
         <?php
            if($rules['rule_type'] == 3){
                echo $rules['rule3_month'].'月'; 
            }else{
                $str = $rules['month'].'月';
                if($rules['is_bind'] == 1){
                    $str .= '/'.$rules['rule3_month'].'月';
                }
                echo $str;
            }
            
         ?>
         
        </div>
    </td>
    <td >
        <div><?php echo Date('Y-m-d',$rules['add_time']); ?></div>
    </td>
    <td class="text-right">
        <div>
            <a href="#edit/<?php echo $rules['pigcms_id']?>" class="js-edit">编辑</a>
            <span>-</span>
            <a href="javascript:void(0);" class="js-delete" data="<?php echo $rules['pigcms_id']?>">删除</a>
        </div>
    </td>
</tr>
<?php } ?>
</tbody>
<?php } ?>
</table>
<div class="js-list-empty-region">
    <?php if (empty($dividends_rules)) { ?>
    <div>
        <div class="no-result widget-list-empty">还没有相关数据。</div>
    </div>
    <?php } ?>
</div>
</div>
<div class="js-list-footer-region ui-box">
    <?php if (!empty($dividends_rules)) { ?>
    <div class="widget-list-footer">
        <div class="pull-left">
        </div>
        <input type="hidden" data-is="<?php echo $is;?>" class="page-is">
        <div class="pagenavi ui-box"><?php echo $page; ?></div>
    </div>
    <?php } ?>
</div>
</div>


<include file="Public:header"/>
<form   method="post" action="{pigcms{:U('Trade/procurement_edit_save')}" frame="true"  >
	<input type="hidden" name="ph_id" value="{pigcms{$now_order.ph_id}"/>
	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
            <tr>
                <th width="15%">项目id</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.project_id}</div></td>
                <th width="15%">联系人</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.realName}</div></td>
            <tr/>
            <tr>
                <th width="15%">联系电话</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.phone}</div></td>
                <th width="15%">联系邮箱</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.email}</div></td>
            <tr/>
            <tr>
                <th width="15%">微信号</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.sponsorWeixin}</div></td>
                <th width="15%">个人OR企业</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.type}</div></td>
            <tr/>
            <tr>
                <th width="15%">项目名称</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.projectName}</div></td>
                <th width="15%">一句话介绍</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.projectSubtitle}</div></td>
            <tr/>
            <tr>
                <th width="15%">所在省</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.projectProvince}</div></td>
                <th width="15%">城市</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.projectCity}</div></td>
            <tr/>
            <tr>
                <th width="15%">标签</th>
                <td width="35%"><div style="height:24px;line-height:24px;">
                        <?php 
                        $projectShowLabel = explode(',', $projectShow['label']);
                        foreach($projectShowLabel as $k=>$v){
                            foreach($projectConfig['business_prefer'] as $kk=>$vv){
                                if($v == $kk){
                                    echo $vv;
                                    echo "&nbsp;";
                                }
                            }
                            
                        }
                        ?>
                    </div></td>
                <th width="15%">成立时间</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.companyCreatetime}</div></td>
            <tr/>
            <tr>
                <th width="15%">创始人人数</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $projectConfig['foundingNum'][$projectShow['foundingNum']];?></div></td>
                <th width="15%">员工数量</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $projectConfig['projectTeamcount'][$projectShow['projectTeamcount']];?></div></td>
            <tr/>
            <tr>
                <th width="15%">项目阶段</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $projectConfig['projectStage'][$projectShow['projectStage']];?></div></td>
                <th width="15%">本轮融资轮数</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $projectConfig['financingRoundsNumber'][$projectShow['financingRoundsNumber']];?></div></td>
            <tr/>
            <tr>
                <th width="15%">年收入情况</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $projectConfig['companyRevenue'][$projectShow['companyRevenue']];?> </div></td>
                <th width="15%">运营数据</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $projectConfig['operatingData'][$projectShow['operatingData']];?></div></td>
            <tr/>
            <tr>
                <th width="15%">列表页图片</th>
                <td width="35%"><img style="width:80px;" src="{pigcms{$projectShow.listImg}"/></td>
            <tr/>
            <tr>
                <th width="15%">过往融资次数</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $projectConfig['pastFinancing'][$projectShow['pastFinancing']];?></div></td>
                <th width="15%">过往融资金额</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><?php echo $projectConfig['pastAmount'][$projectShow['pastAmount']];?></div></td>
            <tr/>
            <tr>
                <th width="15%">投资估值</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.valuation}万元</div></td>
                <th width="15%">此次融资金额</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.amount}万元</div></td>
            <tr/>
            <tr>
                <th width="15%">此次出让股份</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.sellShares}%</div></td>
                <th width="15%">融资计划书URL</th>
                <td width="35%"><div style="height:24px;line-height:24px;"><a href="{pigcms{$projectShow.prospectusUrl}" class="button">查看</a></div></td>
            <tr/>
            <tr>
                <th width="15%">状态</th>
                <td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$projectShow.status}</div></td>
            <tr/>
            
            <tr>
                <th width="15%">项目详情</th>
            <tr/>
	</table>
                <div>
                    {pigcms{$projectShow.projectDetails}
<!--                    <th width="15%">项目详情</th>
                <td width="35%"><div style="height:150px;line-height:60px;">{pigcms{$projectShow.projectDetails}</div></td>-->
                </div>

</form>
<include file="Public:footer"/>
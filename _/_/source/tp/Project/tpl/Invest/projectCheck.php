<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript" src="{pigcms{$static_path}js/invest.js"></script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Invest/projectCheck')}" class="on">项目列表</a>
				</ul>
			</div>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col width="180" align="center"/>
						</colgroup>
						<thead>
							<tr>
								<th>ID</th>
								<th>联系人</th>
								<th>联系电话</th>
                                				<th>项目名称</th>
								<th>成立时间</th>
                                                                <th>图片</th>
                                                                <th>项目详情</th>
                                                                <th>团队成员</th>
                                                                <th>推荐</th>
								<th class="textcenter">状态</th>
                                                                <th class="textcenter">审核</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($projectList)">
								<volist name="projectList" id="vo">
									<tr>
										<td>{pigcms{$vo.project_id}</td>
										<td>{pigcms{$vo.realName}</td>
										<td>{pigcms{$vo.phone}</td>
                                        					<td>{pigcms{$vo.projectName}</td>
										<td>{pigcms{$vo.companyCreatetime}</td>
                                                                                <td><img style="width: 80px;" src="<?php echo getAttachmentUrl($vo['listImg']);  ?>"/></td>
                                                                                <td>
                                                                                    <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Invest/projectShowData',array('project_id'=>$vo['project_id'],'frame_show'=>true))}','项目详情',800,800,true,false,false,false,'add',true);">查看</a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Invest/projectShowTeam',array('project_id'=>$vo['project_id'],'frame_show'=>true))}','项目详情',800,800,true,false,false,false,'add',true);">查看</a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Invest/projectRecommend',array('project_id'=>$vo['project_id']))}','是否推荐',450,400,true,false,false,confirmbtn,'add',true);">是否推荐</a>
<!--                                                                                    <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Invest/projectShowTeam',array('project_id'=>$vo['project_id'],'frame_show'=>true))}','项目详情',600,200,true,false,false,false,'add',true);">推荐</a>-->
                                                                                </td>
										<td class="textcenter">
										<?php
										switch ($vo['status']) {
											case '0':
												echo '<font color="red">未审核</font>';
												break;
                                                                                        case '1':
												echo '<font color="red">审核成功</font>';
												break;
                                                                                        case '2':
												echo '<font color="red">审核失败</font>';
												break;
                                                                                        case '3':
												echo '<font color="red">融资中</font>';
												break;
											case '4':
												echo '<font color="red">融资成功</font>';
												break;
											case '5':
												echo '<font color="red">融资失败</font>';
												break;
											default:
												echo '<font color="red">未知</font>';
												break;
										} ?>
										</td>
										<td class="textcenter">

                                                                        <if condition="$vo['status'] lt 1">
<!--                                                                           <a class="button" href="{pigcms{:U('Invest/investDel',array('uid'=>$vo['uid']))}" onclick="approved({pigcms{$vo.project_id})">通过</a>
                                                                           <a class="button" onclick="failure({pigcms{$vo.project_id})">拒绝</a>-->
                                                                            <a href="{pigcms{:U('Invest/projectCheckOperate',array('project_id'=>$vo['project_id'],'status'=>'1'))}">通过</a>|
                                                                            <a href="{pigcms{:U('Invest/projectCheckOperate',array('project_id'=>$vo['project_id'],'status'=>2))}">拒绝</a>

                                                                           <else/>
                                                                           已审核
                                                                        </if>

										</td>

                                                                                <td>
                                                                                    <a href="{pigcms{:U('Invest/projectDelete',array('id'=>$vo['project_id']))}">删除</a>
                                                                                </td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="12">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="12">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>


<script>
function approved(p_id){
    var check_url = "<?php echo U('Invest/projectCheckOperate'); ?>";
    $.post(check_url,{'project_id':p_id,'status':1},function(data){
        var res =$.parseJSON(data);
        if(res.error==0){
            alert(res.msg)
        }else{
            alert(res.msg)
        }
    })
}
function failure(p_id){
    var check_url = "<?php echo U('Invest/projectCheckOperate'); ?>";
    $.post(check_url,{'project_id':p_id,'status':2},function(data){
        var res =$.parseJSON(data);
        if(res.error==0){
            alert(res.msg)
        }else{
            alert(res.msg)
        }
    })
}
</script>

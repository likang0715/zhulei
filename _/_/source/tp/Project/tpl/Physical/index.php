<include file="Public:header"/>
<style>
.cursor{cursor:pointer;}
.display_edit,.display_save{background:url('./source/tp/Project/tpl/Static/images/glyphicons-halflings.png') no-repeat;}
.display_edit{background-position: -20px -23px;display:inline-block;height:20px;width:20px;}
.display_save{background-position: -283px 0px;display:inline-block;height:20px;width:20px;}
</style>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Physicals/index')}" class="on">茶馆列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('Physical/index')}" method="get">
							<input type="hidden" name="c" value="Physical"/>
							<input type="hidden" name="a" value="index"/>
							<select name="type">
					            <option value="name" <if condition="$_GET['type'] eq 'name'">selected="selected"</if>>茶馆名称</option>
								<option value="tel" <if condition="$_GET['type'] eq 'tel'">selected="selected"</if>>茶馆电话</option>
								<option value="address" <if condition="$_GET['type'] eq 'address'">selected="selected"</if>>茶馆地址</option>
							
							</select>
							筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}" />
							
                  							<input type="submit" value="查询" class="button"/>
											<input type="button" value="导出" class="button search_checkout">
						</form>
					</td>
				</tr>
			</table>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup><col> <col> <col> <col><col><col><col><col><col width="240" align="center"> </colgroup>
						<thead>
							<tr>
								<th>编号</th>
                                <th>茶馆名称</th>
								<th>茶馆电话</th>
								<th>茶馆地址</th>
								<th>店铺名称</th>
								<th>商户账号</th>
								<th>商户联系人</th>
								<th>联系人电话</th>
								<th>更新时间</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($physicals)">
								<volist name="physicals" id="store">
									<tr>
										<td>{pigcms{$store.store_id}</td>
                                        <td>{pigcms{$store.name}</td>
										
										
										<td>{pigcms{$store.phone1}-{pigcms{$store.phone2}</td>
										<td>{pigcms{$store.address}</td>
										<td>{pigcms{$store.store_name}</td>
										<td>{pigcms{$store.nickname}</td>
										<td>{pigcms{$store.linkman}</td>
										<td>{pigcms{$store.tel}</td>
                                        <td>{pigcms{$store.last_time|date='Y-m-d H:i:s', ###}</td>
                                   	   
									
										
                                       
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" <?php if(in_array($my_version,array(4,8))) {?>colspan="9"  <?php }else{?>colspan="9"<?php }?>  >{pigcms{$page}</td></tr>
							<else/>
								<tr><td class="textcenter red" <?php if(in_array($my_version,array(4,8))) {?>colspan="7"  <?php }else{?>colspan="9"<?php }?> >列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
		<script type="text/javascript" src="{pigcms{$static_public}js/layer/layer.min.js"></script>
		<script type="text/javascript">
    $(function() {

       $(".search_checkout").click(function(){
  
            var loadi =layer.load('正在导出', 10000000000000);

            var searchcontent = encodeURIComponent(window.location.search.substr(1));
            $.post(
                    "{pigcms{:U('Physical/index')}",
                    {"searchcontent":searchcontent},
                    function(obj) {
                        layer.close(loadi);
                        if(obj.msg>0) {
                            layer.confirm('该条件下有记录  '+obj.msg+' 条，确认导出？',function(index){
                               layer.close(index);
                               location.href="{pigcms{:U('Physical/index')}&searchcontent="+searchcontent+"&download=1";
                            });
                        } else {
                            layer.alert('该搜索条件下没有数据，无需导出！', 8); 
                        }
                        
                    },
                    'json'
            )

        })

    })
</script>
<include file="Public:footer"/>
<include file="Public:header"/>
<style type="text/css">
    .table-list tfoot tr {
        height: 40px;
    }
     .date-quick-pick {
        display: inline-block;
        color: #07d;
        cursor: pointer;
        padding: 2px 4px;
        border: 1px solid transparent;
        margin-left: 12px;
        border-radius: 4px;
        line-height: normal;
    }
    .date-quick-pick.current {
        background: #fff;
        border-color: #07d!important;
    }
    .date-quick-pick:hover{border-color:#ccc;text-decoration:none}
    .search_table span{
        margin: auto 4px;
    }
</style>

<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
             <volist name="credit_config" id="vo"  key="k" >
              
               <a href="{pigcms{:U('Credit/record',array('record_type'=>$k))}" <if condition="$record_type eq $k">class="on url_for_checkout"</if>>
                    {pigcms{$vo}
               </a>|
             </volist>
        </ul>
    </div>

    <table class="search_table" width="100%">
        <tbody>
            <tr>
                 <td>         
                    <span>平台充值现金总额 {pigcms{$common_data[1]['value']}</span>
                    <span>平台积分收入（销毁） {pigcms{$common_data[0]['value']}</span><br />
                    <span>可用有效积分数 （用户  {pigcms{$user_point_balance} 店铺  {pigcms{$store_point_balance}）</span>
                    <span>用户积分池积分总额  {pigcms{$user_point_pool_sum}</span>                      
                </td>
            </tr>
        </tbody>
    </table>

     <table class="search_table" width="100%">
        <tr>
            <td>
                <form action="{pigcms{:U('Credit/record')}" method="get">
                    <input type="hidden" name="c" value="Credit"/>
                    <input type="hidden" name="a" value="record"/>
                    <input type="hidden" name="record_type" value="{pigcms{$Think.get.record_type}"/>
                    <input type="text" name="keyword" class="input-text" value="{pigcms{$Think.get.keyword}" />
                    &nbsp;&nbsp;
                    <select name="ktype">
                       
                           <option value="order" <if condition="$_GET['ktype'] eq 'order'">selected="selected"</if>>订单号</option>
                           <if condition="$record_type neq 1">
                                <option value="store" <if condition="$_GET['ktype'] eq 'store'">selected="selected"</if>>店铺名称</option>
                           </if>
                           <if condition="$record_type eq 1">
                                <option value="user"  <if condition="$_GET['ktype'] eq 'user'">selected="selected"</if>>用户名称</option>

                                 <option value="uid"  <if condition="$_GET['ktype'] eq 'uid'">selected="selected"</if>>用户ID</option>

                                  <option value="phone"  <if condition="$_GET['ktype'] eq 'phone'">selected="selected"</if>>手机号</option>
                           </if>
                          

                    </select>
                    &nbsp;&nbsp;
                    渠道：
                    <select name="channel">
                       
                           <option value="0" <if condition="$_GET['channel'] eq 0">selected="selected"</if>>请选择</option>
                         
                           <option value="1"  <if condition="$_GET['channel'] eq 1">selected="selected"</if>>线上</option>
                           
                           <option value="2"  <if condition="$_GET['channel'] eq 2">selected="selected"</if>>线下</option>
                          
                    </select>
                    &nbsp;&nbsp;
                    内容：
                    <select name="type">
                       
                           <option value="0" <if condition="$_GET['type'] eq 0">selected="selected"</if>>请选择</option>
                         
                           <option value="1"  <if condition="$_GET['type'] eq 1">selected="selected"</if>>用户积分抵现</option>
                           
                           <option value="2"  <if condition="$_GET['type'] eq 2">selected="selected"</if>>
                                {pigcms{$record_type == 1?'用户获得积分':'积分转现'}
                           </option>
                        
                    </select>
                    &nbsp;&nbsp;时间：
                    <input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="{pigcms{$Think.get.start_time}" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="{pigcms{$Think.get.end_time}" />
                    <span class="date-quick-pick" data-days="7">最近7天</span>
                    <span class="date-quick-pick" data-days="30">最近30天</span>
                    <input type="submit" value="查询" class="button"/>
                    <input type="button" value="导出" class="button search_checkout" />
                </form>
            </td>
        </tr>
    </table> 
    
    <div class="table-list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>订单号</th>
                <if condition="$record_type neq 1"><th>店铺</th></if>
                <if condition="$record_type eq 1"><th>用户</th></if>
                <th>积分</th>
                <th>渠道</th>
                <th>内容</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            <if condition="is_array($list)">
                <volist name="list" id="lists">
                    <tr>
                        <td><span class="c-gray">{pigcms{$lists.order_no}</span></td>
                        <if condition="$record_type neq 1"><td>{pigcms{$lists.store}</td></if>
                        <if condition="$record_type eq 1"><td>{pigcms{$lists.nickname}</td></if>
                        <td><if condition="$lists['point'][0] neq '-'">+</if>{pigcms{$lists['point']}</td>
                        <td>{pigcms{$lists['channel'] == 1?'线下':'线上'}</td>
                        <td>{pigcms{$lists.bak}</td>
                        <td>{pigcms{$lists.add_time|date='Y-m-d H:i:s', ###}</td>
                    </tr>
                </volist>
            </if>
            </tbody>
            <tfoot>
            <if condition="is_array($list)">
                <tr>
                    <td class="textcenter pagebar" colspan="14">{pigcms{$page}</td>
                </tr>
                <else/>
                <tr><td class="textcenter red" colspan="14">列表为空！</td></tr>
            </if>
            </tfoot>
        </table>
    </div>

</div>
<include file="Public:checkout"/>
<include file="Public:footer"/>
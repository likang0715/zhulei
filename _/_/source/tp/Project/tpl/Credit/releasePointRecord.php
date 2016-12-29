<include file="Public:header"/>
<style type="text/css">
    .c-gray {
        color: #999;
    }
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
    .red{
        color:'red';
        font-weight:bold;
    }
</style>

<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Credit/index')}" >积分概述</a>
        </ul>
    </div>
     <table class="search_table" width="100%">
        <tr>
            <td>
                <form action="{pigcms{:U('Credit/releasePointRecord')}" method="get">
                    <input type="hidden" name="c" value="Credit"/>
                    <input type="hidden" name="a" value="releasePointRecord"/>
                   
                    时间：
                    <input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="{pigcms{$Think.get.start_time}" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="{pigcms{$Think.get.end_time}" />
                    <span class="date-quick-pick" data-days="7">最近7天</span>
                    <span class="date-quick-pick" data-days="30">最近30天</span>
                    <input type="submit" value="查询" class="button"/>
                   
                </form>
            </td>
        </tr>
    </table> 
    <div class="table-list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>发放前的备付金总额</th>
                <th>发放总分数</th>
                <th>实时备付金总额</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            <if condition="is_array($list)">
                <volist name="list" id="lists">
                    <tr>
                        <td>{pigcms{$lists.cash_provision_balance_before}</td>
                        <td>{pigcms{$lists.point_total}</td>
                        <td>{pigcms{$lists.cash_provision_balance}</td>
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
<include file="Public:footer"/>



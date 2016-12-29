<include file="Public:header"/>
<style type="text/css">
    .c-gray {
        color: #999;
    }
    .table-list tfoot tr {
        height: 40px;
    }
    .green {
        color: green;
    }
    .ui-money, .ui-money-income, .ui-money-outlay {
        font-weight: bold;
        color: #333;
    }
    .ui-money-income {
        color: #55BD47;
    }
    .ui-money-outlay {
        color: #f00;
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
</style>

<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Order/myPromotionRecord')}" class="on">我的奖金</a>
        </ul>
    </div>
    <table class="search_table" width="100%">
        <tr>
            <td>
                <form action="{pigcms{:U('Order/myPromotionRecord')}" method="get">
                    <input type="hidden" name="c" value="Order"/>
                    <input type="hidden" name="a" value="myPromotionRecord"/>
                    类型：
                    <select name="record_type">
                        <option value="all">全部</option>
                        <option value="plus" <if condition="$Think.get.record_type eq 'plus'">selected="true"</if>>奖励</option>
                        <option value="minus" <if condition="$Think.get.record_type eq 'minus'">selected="true"</if>>发送</option>
                    </select>
                    &nbsp;&nbsp;
                    订单来源：
                    <select name="from_type">
                        <option value="0" <if condition="$Think.get.from_type eq 0">selected="true"</if>>线上</option>
                        <option value="1" <if condition="$Think.get.from_type eq 1">selected="true"</if>>线下</option>
                    </select>
                    &nbsp;&nbsp;时间：
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
                <th>订单号</th>
                <th>所属推广者</th>
                <th>来自店铺</th>
                <th>奖励(元)</th>
                <th>发送(元)</th>
                <th>当时奖励比率(%)</th>
                <!-- <th>交易单号</th> -->
                <th>发送信息</th>
                <th>备注</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            <if condition="!empty($promotions)">
                <volist name="promotions" id="promotion">
                    <tr>
                        <td><span class="c-gray">{pigcms{$promotion.order_no}</span></td>
                        <td>{pigcms{$promotion.account}</td>
                        <td>{pigcms{$promotion.name}</td>
                        <td><span class="ui-money-income"><if condition="$promotion['type'] eq 0">+ {pigcms{$promotion.amount}</if></span></td>
                        <td><span class="ui-money-outlay"><if condition="$promotion['type'] eq 1">- {pigcms{$promotion.amount}</if></span></td>
                        <td>{pigcms{$promotion.reward_rate}</td>
                        <!-- <td>{pigcms{$promotion.trade_no}</td> -->
                        <td>
                            <if condition="$promotion['type'] eq 1">
                                由【{pigcms{$promotion.send_atype}】<br>
                                <span style="color:red">{pigcms{$promotion.send_aname}</span> 通过
                                <span style="color:green">{pigcms{$promotion.pay_type}</span> 发送
                            </if>
                        </td>
                        <td>{pigcms{$promotion.bak}</td>
                        <td>{pigcms{$promotion.add_time|date='Y-m-d H:i:s', ###}</td>
                    </tr>
                </volist>
            </if>
            </tbody>
            <tfoot>
            <if condition="!empty($promotions)">
                <tr>
                    <td class="textcenter pagebar" colspan="10">{pigcms{$page}</td>
                </tr>
                <else/>
                <tr><td class="textcenter red" colspan="10">列表为空！</td></tr>
            </if>
            </tfoot>
        </table>
    </div>

</div>
<include file="Public:footer"/>
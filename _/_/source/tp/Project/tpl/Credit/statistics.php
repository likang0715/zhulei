<include file="Public:header"/>

    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Credit/index')}">积分概述</a>
            |
            <a href="{pigcms{:U('Credit/sendLog')}" >积分发放流水</a>
            |
            <a href="{pigcms{:U('Credit/statistics')}" class="on" >积分统计数据汇总</a>
        </ul>
    </div>

	<table cellpadding="0" cellspacing="0"  width="100%" class="frame_form" >
        <tr>
            <th width="300">1.累计从消费积分释放的【可用积分】总数（=B*W）：</th>
            <td>{pigcms{$release_point|default="0"}</td>
        </tr>
        <tr>
            <th width="300">2.累计已释放消费积分耗损总数(=B-1)：</th>
            <td>{pigcms{$release_point_lose|default="0"}</td>
        </tr>
        <tr>
            <th width="300">3.累计商家积分转【可用积分】总数：</th>
            <td>{pigcms{$store_to_point_balance_total|default="0"}</td>
        </tr>
        <tr>
            <th width="300">4.累计【可用积分】总数（=1+3)：</th>
            <td><?php echo  ($release_point + $store_to_point_balance_total);?></td>
        </tr>

        <tr>
            <th width="300">5.累计消耗可用积分（=6+7）：</th>
            
            <td><?php echo  ($offline_user_point_balance_total + $order_user_point_balance_total);?></td>
        </tr>

        <tr>
            <th width="300">6.累计商家用于【补单】的可用积分总数：</th>
            <td><?php echo  ($offline_user_point_balance_total);?></td>
        </tr>

        <tr>
            <th width="300">7.累计（兑换商品）转为【商家积分】的可用积分总数：</th>
            <td>{pigcms{$order_user_point_balance_total|default="0"}</td>
        </tr>

        <tr>
            <th width="300">8.累计可用积分总余额（=4-5)（=4-6-7）：</th>
            <td>{pigcms{$user_point_balance_total|default="0"}</td>
        </tr>

        <tr>
            <th width="300">9.累计可用积分兑换商品转为商家积分火耗A（积分状态转换服务费)=7*10%：</th>
            <td>{pigcms{$store_margin_used|default="0"}</td>
        </tr>

        <tr>
            <th width="300">10.累计商家积分总数=累计可用积分已兑换为【商家积分】的总数（=7-9）：</th>
            <td>{pigcms{$store_point_total|default="0"}</td>
        </tr>

        <tr>
            <th width="300">11.累计商家积分总余额（=10-12）：</th>
            <td>{pigcms{$store_point_balance_total|default="0"}</td>
        </tr>

        <tr>
            <th width="300">12.累计消耗的商家积分（=13+14+15）：</th>
            <td><?php echo ($offline_store_point_balance_total_new + $store_to_user_balance_points + $store_point2money)?></td>
        </tr>

        <tr>
            <th width="300">13.累计用于补单的商家积分：</th>
            <td>{pigcms{$offline_store_point_balance_total_new|default="0"}</td>
        </tr>

        <tr>
            <th width="300">14.累计转可用积分的商家积分：</th>
            <td>{pigcms{$store_to_user_balance_points|default="0"}</td>
        </tr>

         <tr>
            <th width="300">15.累计转可兑现现金的商家积分：</th>
            <td>{pigcms{$store_point2money|default="0"}</td>
        </tr>

         <tr>
            <th width="300">16.累计转兑现现金火耗B(兑现服务费)=15*6%：</th>
            <td>{pigcms{$store_withdrawal_lose|default="0"}</td>
        </tr>

         <tr>
            <th width="300">17.累计已转可兑现现金总额（=15-16）：</th>
            <td>{pigcms{$store_point2money_total|default="0"} </td>
        </tr>

         <tr>
            <th width="300">18.累计商家可兑现现金账总余额(=17-19)：</th>
            <td>{pigcms{$store_point2money_balance|default="0"}</td>
        </tr>

         <tr>
            <th width="300">19.累计已兑现现金总额：</th>
            <td>{pigcms{$store_withdrawal|default="0"}</td>
        </tr>




        <!-- <tr>
        <th width="300">1.累计已释放消费积分耗损总数：</th>
        <td>{pigcms{$release_point_lose|default="0"}</td>
        </tr>
        <tr>
        <th width="300">2.累计已释放可用积分总数（从消费积分释放）：</th>
        <td>{pigcms{$release_point|default="0"}</td>
        </tr>
        <tr>
        <th width="300">3.累计可用积分总数（从消费积分释放）：</th>
        <td>{pigcms{$release_point|default="0"}</td>
        </tr>
        <tr>
        <th width="300">4.累计商家积分转可用积分总数：</th>
        <td>{pigcms{$store_to_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">5.累计可用积分【补单】总数：</th>
        <td>{pigcms{$offline_user_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">6.累计可用积分兑换转商家积分：</th>
        <td>{pigcms{$order_user_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">7.可用积分总余额：</th>
        <td>{pigcms{$user_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">8.消耗可用积分总数：</th>
        <td>{pigcms{$deplete_user_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">9.累计可用积分【补单】总数：</th>
        <td>{pigcms{$offline_user_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">10.累计可用积分兑换转商家积分：</th>
        <td>{pigcms{$order_user_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">11.可用积分消耗：</th>
        <td>{pigcms{$deplete_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">12.商家积分总余额：</th>
        <td>{pigcms{$store_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">13.累计消耗商家积分：</th>
        <td>{pigcms{$store_lose_point|default="0"}</td>
        </tr>
        <tr>
        <th width="300">14.累计商家积分【补单】总数：</th>
        <td>{pigcms{$offline_store_point_balance_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">15.累计商家积分分转可用积分：</th>
        <td>{pigcms{$store_to_user_balance_points|default="0"}</td>
        </tr>
        <tr>
        <th width="300">16.累计商家可兑现积分总数：</th>
        <td>{pigcms{$store_point2money|default="0"}</td>
        </tr>
        <tr>
        <th width="300">17.兑现消耗：</th>
        <td>{pigcms{$store_withdrawal_lose|default="0"}</td>
        </tr>
        <tr>
        <th width="300">18.商家可兑现现金余额总数：</th>
        <td>{pigcms{$store_point2money_balance|default="0"}</td>
        </tr>
        <tr>
        <th width="300">19.累计已兑现现金总额：</th>
        <td>{pigcms{$store_withdrawal|default="0"}</td>
        </tr> -->
        <tr>
        <th width="300">A.累计赠送消费积分总数：</th>
        <td>{pigcms{$user_point_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">B.累计已释放消费积分总数：</th>
        <td>{pigcms{$release_send_point|default="0"}</td>
        </tr>
        <tr>
        <th width="300">C.待释放消费积分余额：</th>
        <td>{pigcms{$wait_release_point|default="0"}</td>
        </tr>
        <tr>
        <th width="300">D.前一日发送积分总数：</th>
        <td>{pigcms{$yes_release_send_point|default="0"}</td>
        </tr>
        <tr>
        <th width="300">E.今日应释放消费积分总数：</th>
        <!-- <td>$evaluate_today_release_send_point</td> -->
        <td>{pigcms{$today_send_point_max|default="0"}</td>
        </tr>
        <tr>
        <th width="300">EA.今日已释放消费积分总数：</th>
        <td>{pigcms{$today_release_send_point|default="0"}</td>
        </tr>
        <tr>
        <th width="300">F.累计赠送积分总数(不包含积分做单赠送的消费积分部分 *10%)：</th>
        <td>{pigcms{$cash_provision_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">G.累计积分服务费收入：</th>
        <td>{pigcms{$platform_service_charge|default="0"}</td>
        </tr>
        <tr>
        <th width="300">H.累计商家充值现金总额：</th>
        <td>{pigcms{$margin_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">I.前一日申请充值返还的金额：</th>
        <td>{pigcms{$yes_margin_back|abs|default="0"}</td>
        </tr>
        <tr>
        <th width="300">J.累计充值返还已提现总额：</th>
        <td>{pigcms{$margin_back|default="0"}</td>
        </tr>
        <tr>
        <th width="300">K.商家充值现金总余额：</th>
        <td>{pigcms{$margin_balance_now|default="0"}</td>
        </tr>
        <tr>
        <th width="300">L.累计保证金扣除(线上发放消费积分的服务费)：</th>
        <td>{pigcms{$store_online_cash_provision|default="0"}</td>
        </tr>
        <tr>
        <th width="300">M.累计店铺线下做单扣除的服务费(线下做单的服务费但不包含积分做单服务费)：</th>
        <td>{pigcms{$store_offline_cash_provision|default="0"}</td>
        </tr>
        <tr>
        <th width="300">N.累计服务费：</th>
        <td>{pigcms{$platform_service_charge|default="0"}</td>
        </tr>
        <tr>
        <th width="300">O.累计存管金：</th>
        <td>{pigcms{$cash_provision_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">P.存管金余额：</th>
        <td>{pigcms{$cash_provision_balance_now|default="0"} (包含待处理的){pigcms{$store_withdrawal_handle|default="0"}</td>
        </tr>
        <tr>
        <th width="300">Q.累计已兑现金额：</th>
        <td>{pigcms{$store_withdrawal|default="0"}</td>
        </tr>
        <tr>
        <th width="300">R.前日申请兑现金额：</th>
        <td>{pigcms{$yes_apply_store_withdrawal|default="0"}</td>
        </tr>
        <tr>
        <th width="300">S.累计平台运营费：</th>
        <td>{pigcms{$platform_operating_cost|default="0"}</td>
        </tr>
        <tr>
        <th width="300">T.累计区域总奖金：</th>
        <td>{pigcms{$_reward_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">U.累计区域经理总奖金：</th>
        <td>{pigcms{$area_reward_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">V.累计客户经理总奖金：</th>
        <td>{pigcms{$agent_reward_total|default="0"}</td>
        </tr>
        <tr>
        <th width="300">W.权数：</th>
        <td>{pigcms{$real_point_weight|default="0"}</td>
        </tr>

        <tr><th width="150">今日需发放积分点数最大值：</th><td>{pigcms{$today_send_point_max|default="0"}</td></tr>


         <tr><th width="150">昨日备付金总额(单日)：</th><td>￥{pigcms{$cash_provision_balance_yestoday|default="0"} </td></tr>

	</table>

<include file="Public:footer"/>

<style>
.frame_form td{

	font-weight: 100;
	line-height: 24px;

}

</style>

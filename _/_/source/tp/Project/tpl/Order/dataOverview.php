<include file="Public:header"/>
<style type="text/css">
.list h1{ color:red; font-size:12px;}
.ul_list li{ display:block; background:#F00; width:19%; float:left; height:100px; margin-right:1%}
.ul_list li p{ text-align:center; font-weight:bold; font-size:16px;}
.ul_list li:nth-child(1){ background:#FF9966;}
.ul_list li:nth-child(2){ background:#6699CC;}
.ul_list li:nth-child(3){ background:#CC3300;}
.ul_list li:nth-child(4){ background:#669966;}
.ul_list li:nth-child(5){ background:#FF6666;}
.ul_list2{ clear:both; padding-top:10px;}
.ul_list2 li{ background:url(<?php echo $static_path; ?>images/u71.png) no-repeat center left;}
.ul_list2 li p{ margin-left:20px; color:#333333}
</style>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Order/dataOverview')}" class="on">数据概览</a>
				</ul>
			</div>
            <div class="list" id="Profile">
			<h1>所有数据，没有涉及到第三方支付手续费数据（需以实际收款数据为准）</h1>
            <ul class="ul_list">
            	<li>
                	<p>平台总资产（元）</p>
                    <p>220，512.00</p>
                </li>
                <li>
                	<p>已提现总额（元）</p>
                    <p>220，512.00</p>
                </li>
                <li>
                	<p>待提现总额（元）</p>
                    <p>220，512.00</p>
                </li>
               	<li>
                	<p>未结算总额（元）</p>
                    <p>220，512.00</p>
                </li>
                <li>
                	<p>累计收入（元）</p>
                    <p>220，512.00</p>
                </li>
            </ul>
		</div>
        	<div>
            	<ul class="ul_list2">
                	<li><p>上述汇总提现数据 是指  店铺从平台上提现操作</p></li>
                    <li><p>平台总资产  =  待提现总额 + 未结算总额   + 累计收入=  累计进账金额  -   已提现总额</p></li>
                    <li><p>平台总资产  =  待提现总额 + 未结算总额   + 累计收入  - 平台本身提现总额</p></li>
                </ul>
            </div>
		</div>
<include file="Public:footer"/>
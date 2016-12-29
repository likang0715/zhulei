<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">

<link href="<?php echo TPL_URL; ?>css/index.css" rel="stylesheet">
<style>
body {min-width:320px; color:#666666;font-size:1.4rem;background:#f0eff5;font-family:  Microsoft YaHei,Arial, Helvetica,"\534E\6587\9ED1\4F53", sans-serif;overflow-x:hidden}
.fr{float: right}
/*原来basic*/
.wrap{min-width:320px}
.box{display:-moz-box;display:-webkit-box;display:box}
.b-flex{-moz-box-flex:1;-webkit-box-flex:1;box-flex:1}
.b-flex2{-moz-box-flex:2;-webkit-box-flex:2;box-flex:2}
.b-flex3{-moz-box-flex:3;-webkit-box-flex:3;box-flex:3}
.box-vm{display:-moz-box;-moz-box-pack:center;-moz-box-align:center;display:-webkit-box;-webkit-box-pack:center;-webkit-box-align:center;display:box;box-pack:center;box-align:center}
.box-vb{display:-moz-box;display:-webkit-box;display:box;-moz-box-pack:center;-webkit-box-pack:center;box-pack:center;-moz-box-align:end;-webkit-box-align:end;box-align:end}

.red-font{ color: #e60012;}
.orange-font{color:#ff4800;}
.big-font{font-size:1em!important;}
</style>

<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/swiper.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/usercenter.css" type="text/css">
<title>我的奖金 - <?php echo $store['name']; ?></title>
<script src="<?php echo TPL_URL; ?>js/swiper.min.js"></script>
    <script src="<?php echo TPL_URL; ?>js/rem.js"></script>
    <script src="<?php echo TPL_URL; ?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL; ?>js/index.js"></script>
</head>
<body>
    <div class="prizeMoney">
        <div class="topInfo">
            <div class="row">
                <ul class="box">
                    <li class="b-flex">
                        <p class="category">团队奖金分红</p>
                        <p class="money"><i>￥</i><?php echo $team_dividends_total;?></p>
                    </li>
                    <li class="b-flex">
                        <p class="category">独立分销奖金</p>
                        <p class="money"><i>￥</i><?php echo $my_dividends_total;?></p>
                    </li>
                </ul>
            </div>
            <div class="row total">
                <a style="margin-top:8px;" class="fr cash" href="./drp_commission.php?a=withdrawal&type=dividends">提现</a>
                <p>总发放奖金：<span>￥<?php echo $all_dividends_total;?></span><br /> ( 可提现:<span>￥<?php echo $my_dividends;?></span> )</p>
            </div>
        </div>
        <div class="dTab detailInfo">
            <div class="hd">
                <ul class="box">
                    <li class="b-flex">奖金纪录</li>
                    <li class="b-flex">提现纪录</li>
                    <li class="b-flex">规则说明</li>
                </ul>
            </div>
            <div class="bd">
               
               

                 <div class="row">
                    <table class="sendlog" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <th scope="col" width="25%">金额</th>
                            <th scope="col" width="25%">类型</th>
                            <th scope="col">时间</th>
                        </tr>
                     
                    <?php
                        foreach ($dividends_send_log as $key => $value) {
                    ?>

                        <tr>
                            <td>￥<?php echo $value['amount'];?></td>
                            <td>
                                <?php
                                if($value['dividends_type'] == 2){
                                    echo '<em class="green">团队分红</em>';
                                }else if($value['dividends_type'] == 3){
                                    echo '<em class="red">独立奖金</em>';
                                }
                                ?>    
                            </td>
                            <td><?php echo date('Y-m-d H:i:s',$value['add_time']);?></td>
                        </tr>

                     <?php       
                        }
                    ?>
                 
                    </table>
                </div>


                 <div class="row">
                    <table class="tixian" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <th scope="col" width="25%">金额</th>
                            <th scope="col" width="25%">类型</th>
                            <th scope="col">时间</th>
                        </tr>
                        
                        <?php
                        foreach ($my_dividends_withdrawal as $key => $value) {
                        ?>
                            <tr>
                                <td>￥<?php echo $value['amount']; ?></td>
                                <?php
                                    if($value['status'] == 1 || $value['status'] == 2){
                                        echo '<td><em class="red">处理中</em></td>';
                                    }else if($value['status'] == 3){
                                        echo '<td><em class="green">成功</em></td>';
                                    }else if($value['status'] == 4){
                                        echo '<td><em class="black">失败</em></td>';
                                    }
                                ?>
                                <td><?php echo date('Y-m-d H:i:s',$value['add_time']);?></td>
                            </tr>
                        <?php
                        }
                        ?>
                       
                    </table>
                </div>

                <div class="row rule">
                    <h2>奖金分红规则：</h2>

                    <?php
                    $i = 1;
                    foreach ($rules_des as $key => $value) {
                        echo '<div class="cell">';
                        echo '<h3>'.$i.'.'.$rules_type[$key].'：</h3>';
                        
                        echo '<p>'.$value[0].'</p>';
                        echo '<p>'.$value[1].'</p>';
                        
                        echo '</div>';
                        $i++;
                    }
                    ?>
                 
                    <!-- <h2>奖金发放规则：</h2>
                    <div class="cell">
                        <?php echo $rules_send_times_str; ?>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
<script>

//<tr><td style="cursor:pointer;" align="center" colspan="3">加载更多</td></tr>
$(function(){
   //是否显示更多页面
   var my_dividends_withdrawal_count = "<?php echo $my_dividends_withdrawal_count; ?>";
   var dividends_send_log_count = "<?php echo $dividends_send_log_count; ?>";
   var allow_num = "<?php echo $allow_num; ?>";
   var dividends_withdrawal_more = "<?php echo $dividends_withdrawal_more; ?>";
   var dividends_send_log_more = "<?php echo $dividends_send_log_more; ?>";
   var start_num = allow_num;
   var start_log_num = allow_num;

   if(dividends_send_log_more == 1){
      $('.sendlog tbody').append('<tr><td style="cursor:pointer;" align="center" colspan="3">加载更多</td></tr>');
      $('.sendlog tbody').find('tr:last').click(function(){
            //获取数据
             $.post(
                "./dividends_record.php?a=get_sendlog",
                {'allow_num':allow_num,'start_log_num':start_log_num}, 
                function(data){
                        start_log_num = parseInt(start_log_num) + parseInt(allow_num);
                        
                        data = data.err_msg;

                        var html_output = '';

                        for( k in data){
                            html_output += '<tr><td>￥'+data[k].amount+'</td>';
                            
                            if(data[k].dividends_type == 2){
                                html_output += '<td><em class="green">团队分红</em></td>';
                            }else if(data[k].dividends_type == 3){
                                html_output += '<td><em class="red">独立奖金</em></td>';
                            }
                            html_output += '<td>'+timetostr(data[k].add_time,24,2)+'</td></tr>';
                        }


                        $('.sendlog tbody').find('tr:last').before(html_output);

                        if(start_log_num >= dividends_send_log_count){
                             $('.sendlog tbody').find('tr:last').html('<td align="center" colspan="3">没有了</td>');
                            return;
                        }

            },'json');

      });
   }


   if(dividends_withdrawal_more == 1){
      $('.tixian tbody').append('<tr><td style="cursor:pointer;" align="center" colspan="3">加载更多</td></tr>');
      $('.tixian tbody').find('tr:last').click(function(){
            //获取数据
             $.post(
                "./dividends_record.php?a=get_withdrawal",
                {'allow_num':allow_num,'start_num':start_num}, 
                function(data){
                        start_num = parseInt(start_num) + parseInt(allow_num);
                        
                        data = data.err_msg;

                        var html_output = '';

                        for( k in data){
                            html_output += '<tr><td>￥'+data[k].amount+'</td>';
                            if(data[k].status == 1 || data[k].status == 2){
                                html_output += '<td><em class="red">处理中</em></td>';
                            }else if(data[k].status == 3){
                                html_output += '<td><em class="green">成功</em></td>';
                            }else if(data[k].status == 4){
                                html_output += '<td><em class="black">失败</em></td>';
                            }
                            html_output += '<td>'+timetostr(data[k].add_time,24,2)+'</td></tr>';
                        }


                        $('.tixian tbody').find('tr:last').before(html_output);

                        if(start_num >= my_dividends_withdrawal_count){
                             $('.tixian tbody').find('tr:last').html('<td align="center" colspan="3">没有了</td>');
                            return;
                        }

            },'json');

      });
   }
})

function fillZero(v){  
    if(v<10){v='0'+v;}  
    return v;  
} 


function timetostr(unixtime,type,show_type){  
      var d=new Date(parseInt(unixtime) * 1000);  
      var Week=['星期天','星期一','星期二','星期三','星期四','星期五','星期六'];  
      Y=d.getFullYear();  
      M=fillZero(d.getMonth()+1);  
      D=fillZero(d.getDate());  
      W=Week[d.getDay()]; //取得星期几  
      H=fillZero(d.getHours());  
      I=fillZero(d.getMinutes());  
      S=fillZero(d.getSeconds());  
      //12小时制显示模式  
      if(type && type==12){  
        //若要显示更多时间类型诸如中午凌晨可在下面添加判断  
        if(H<=12){  
          H='上午 '+H;  
        }else if(H>12 && H<24){  
          H-=12;  
          H='下午 '+fillZero(H);  
        }else if(H==24){  
          H='凌晨 00';  
        }  
      }  
      if(show_type && show_type=='1') return Y+'年'+M+'月'+D+'日'+' '+W+' '+H+':'+I+':'+S;  
      return Y+'-'+M+'-'+D+' '+H+':'+I+':'+S;  
      
}  

</script>
</body>
</html>

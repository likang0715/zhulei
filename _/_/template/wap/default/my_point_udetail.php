<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>流水查询</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/my_point_style.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/common_datepick.css"> 
    <script src="<?php echo TPL_URL;?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL;?>js/date.js"></script>
    <script src="<?php echo TPL_URL;?>js/iscroll.js"></script>
    <script type="text/javascript"> var type = '<?php echo isset($type) ? $type : ''; ?>'</script>
</head>
<body>
    <ul class="search-list">
        <li>
            <div class="fl search-list-tit">开始时间</div>
            <div class="fr ">
                <span class="fl search-time" id="beginTime">请选择</span>
                <span class="icon-angle-right icon-2x fr"></span>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </li>
        <li>
            <div class="fl search-list-tit">结束时间</div>
            <div class="fr ">
                <span class="fl search-time" id="endTime">请选择</span>
                <span class="icon-angle-right icon-2x fr"></span>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </li>
        <li>
            <div class="fl search-list-tit">渠道</div>
            <div class="fr ">
                <select class="fl select-time search-time" id='channel' name='channel' >
                    <option value='0'>所有</option>
                    <option value='1'>线上</option>              
                    <option value='2'>线下</option>              
                </select>
                <span class="icon-angle-right icon-2x fr"></span>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </li>
    </ul>
<div class="btn" id="cx" >查询</div>
<ul class="search-order">
    <?php
    if($user_point_log_list){
        foreach($user_point_log_list as $key=>$value){
        ?>
         <li>
            <div class="fl search-order-left">
                <p>订单：<?php echo $value['order_no'];?></p>
                <p class="grey">时间：<?php echo date('Y-m-d H:i:s',$value['add_time']);?></p>
            </div>
            <div class="search-order-con fl">
                <span class="search-order-con-con-blue-circle search-order-con-con-circle fl"></span>
                <span class="search-order-con-con-txt fl">
                <?php 
                    if($value['channel'] == 0){
                        echo '线上';
                    }else{
                        echo '线下';
                    }
                ?>
                </span>
                <div class="clear"></div>
            </div>
            <div class="fl search-order-right">
                <p><?php echo $point_type_arr[$value['type']]; ?></p>
                
                <p class="orange"><?php echo ($value['point'] > 0)?'+'.$value['point']:$value['point'];?><?php echo ($value['type'] == 7)?'可用积分':$point_alias; ?></p>
            </div>
            <div class="clear"></div>
        </li>
        <?php
        }
    }else{
    ?>
        <li align='center'>暂无信息</li>
    <?php
    }

    ?>
</ul>
<div id="datePlugin"></div>
<input type="hidden" name="record_count" value="<?php echo intval($record_count); ?>">
</body>
<script>

    $(function(){
        $('#beginTime').date();
        $('#endTime').date();

       //是否显示更多页面
       var record_count = "<?php echo intval($record_count); ?>";
       var allow_num = "<?php echo intval($allow_num); ?>";
       var has_more = "<?php echo $has_more; ?>";
       var page_url = "<?php echo $page_url;?>";
       var start_log_num = allow_num;
       var point_alias = "<?php echo $point_alias;?>";

       if(has_more == 1){
         $('.search-order').append('<li align=center>查看更多</li>');
         search_list(allow_num,start_log_num,point_alias,page_url);
       }
      

       $('#cx').click(function(){
          var channel = $("select[name='channel'] option:selected").val();
          var beginTime = $('#beginTime').html();
          var endTime = $('#endTime').html();
          beginTime = (beginTime == '请选择')?'':beginTime;
          endTime = (endTime == '请选择')?'':endTime;
          allow_num = "<?php echo intval($allow_num); ?>";
          start_log_num = 0;
          var param = {'allow_num':allow_num,'start_log_num':start_log_num,'start_time':beginTime,'stop_time':endTime,'channel':channel}
          if (type != '') {
              param.type = type;
          }
          //获取数据
           $.post(page_url, param, function(data){
                  start_log_num = parseInt(start_log_num) + parseInt(allow_num);

                  data = data.err_msg;

                  has_more = data.has_more;

                  record_count = data.record_count;

                  log_count = data.log_count;

                  data = data.user_point_log_list;

                  $("input[name='record_count']").val(record_count);

                  if(record_count > 0){
                    var html_output = create_html_output(data,point_alias);
                     if(has_more == 1){
                       html_output += '<li align=center>查看更多</li>';
                       $('.search-order').html(html_output);
                       search_list(allow_num,start_log_num,point_alias,page_url);
                     }else{
                      $('.search-order').html(html_output);
                     }
                  }else{
                    $('.search-order').html('<li align="center">该条件暂无数据</li>');
                  }
              },'json');

       });
        
    });


    function search_list(allow_num,start_log_num,point_alias,page_url){
      $('.search-order').find('li:last').click(function(){
        var channel = $("select[name='channel'] option:selected").val();
        var beginTime = $('#beginTime').html();
        var endTime = $('#endTime').html();
        beginTime = (beginTime == '请选择')?'':beginTime;
        endTime = (endTime == '请选择')?'':endTime;
        var is_get = $("input[name='record_count']").val();
        if(is_get == 0){
          return false;
        }
        var param = {'allow_num':allow_num,'start_log_num':start_log_num,'start_time':beginTime,'stop_time':endTime,'channel':channel}
        if (type != '') {
            param.type = type;
        }
        //获取数据
         $.post(page_url, param, function(data){
                start_log_num = parseInt(start_log_num) + parseInt(allow_num);

                data = data.err_msg;

                record_count = data.record_count;

                data = data.user_point_log_list;

                $("input[name='record_count']").val(record_count);

                if(record_count > 0){
                  var html_output = create_html_output(data,point_alias);
                  $('.search-order').find('li:last').before(html_output);
                }else{
                  $('.search-order').find('li:last').html('没有了');
                }
            },'json');

       });   
    }

    function fillZero(v){  
        if(v<10){v='0'+v;}  
        return v;  
    }


    function create_html_output(data,point_alias){
         var html_output = '';
         for( k in data){
            html_output += '<li><div class="fl search-order-left">';
            html_output += '<p>订单：'+data[k].order_no+'</p><p class="grey">时间：'+timetostr(data[k].add_time,24,2)+'</p></div><div class="search-order-con fl"><span class="search-order-con-con-blue-circle search-order-con-con-circle fl"></span><span class="search-order-con-con-txt fl">';
            if(data[k].channel == 0){
                html_output += '线上';
            }else{
                html_output += '线下';
            }
            html_output += '</span><div class="clear"></div></div><div class="fl search-order-right">';
         
            html_output += '<p>';
           
            switch (parseInt(data[k].type))
            {
            case 0:
              html_output += '消费获赠积分';
              break;
            case 1:
               html_output += '消费抵现积分';
              break;
            case 2:
               html_output += '退货返还积分';
              break;
            case 3:
               html_output += '取消订单返还积分';
              break;
            case 4:
               html_output += '店铺积分转用户积分';
              break;
            case 5:
               html_output += '积分赠他人';
              break;
            case 6:
               html_output += '他人赠积分';
              break;
            case 7:
               html_output += '平台发放积分';
              break;
            }

            html_output += '</p>';
            
            if(parseInt(data[k].type) == 7){
              point_alias = '可用积分';
            }
            
            html_output += '<p class="orange">';

            if(data[k].point > 0){
                html_output += '+'+data[k].point+point_alias;
            }else{
                html_output += data[k].point+point_alias;
            }

            html_output += '</p></div><div class="clear"></div></li>';                  
         }

         return html_output;
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
</html>
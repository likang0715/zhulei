<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link href="<?php echo TPL_URL;?>css/gamecenter/base.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/gamecenter/usercenter.css" type="text/css">
<title>个人中心</title>
</head>
<body>
    <section class="prizeHd">
        <ul class="box">
            <li class="b-flex showMore on">
                <a href="javascript:;">游戏合集<i></i></a>
            </li>
            <li class="b-flex shake_lottery" >
                <a href="javascript:;">摇一摇抽奖</a>
            </li>
            <li class="b-flex toggleStatus">
                <a href="javascript:;">状态<i></i></a>
            </li>
        </ul>
        <div class="tagList statusTags">
            <ol id="lottery_status">
                <li class="on" type_id=0>全部</li>
                <li type_id=1>未兑奖</li>
                <li type_id=2>已兑奖</li>
            </ol>
        </div>
        <div class="tagList moreTags">
            <ol id="lottery_list">
                <li class="on" type_id=1>大转盘</li>
                <li type_id=2>九宫格</li>
                <li type_id=3>刮刮卡</li>
                <li type_id=4>水果机</li>
                <li type_id=5>砸金蛋</li>
            </ol>
        </div>
    </section>
    <section class="prizeBd">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        </table>
        <input type="hidden" name="store_id" id="store_id" value="<?php echo $store_id; ?>">
        <input type="hidden" name="page" id="page" value="1" />
        <input type="hidden" name="type" id="type" value="1" />
    </section>

    <div class="cashPrizeWindow">
    	<div class="cashPrize">
        	<div class="windowWrap">
            	<h3>请商家输入兑奖密码</h3>
	            <div class="prizeRow">
	                <input type="password" id="pwd" placeholder="请输入兑奖密码" /><button onclick="doprize()">确定兑奖</button>
	                <input type="hidden" id="record_id" />
	                <input type="hidden" id="aid" />
	            </div>
	            <div class="xCloseBtn">
	                <a href="javascript:;">关闭窗口</a>
	            </div>
        	</div>
    	</div>
	</div>

    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
	<!-- <script src="<?php echo TPL_URL; ?>js/shakelottery/layer.alert.js"></script> -->
    <script src="<?php echo TPL_URL; ?>activity_style/js/layer.js?ii=<?php echo rand(1,99999999); ?>"></script>
	<script>
	$(".xCloseBtn a").click(function(){
		$('#pwd').val('');
		$('#record_id').val(0);
		$('#aid').val(0);
        $('.cashPrizeWindow').slideUp();
         return false;
     });
	</script>
    <script>
        $(function(){
    		var type = $("#type").val();
            var type_id = 1;
    		var status = $('#lottery_status li[class="on"]').attr('type_id');
    		var url_lottery='?a=lottery_list&type='+type_id+'&status='+status;//抽奖合集
            var url_shake_lottery = '?a=shake_list&status='+status;//摇一摇抽奖
    		load_page_list(url_lottery,1);

            //滚动分页
    		$(window).on("scroll",function(){
                type_id = $('#lottery_list li[class="on"]').attr('type_id');
                type = $("#type").val();
                status = $('#lottery_status li[class="on"]').attr('type_id');
                url_lottery='?a=lottery_list&type='+type_id+'&status='+status;//抽奖合集
                url_shake_lottery = '?a=shake_list&status='+status;//摇一摇抽奖
    			if($(".prizeBd table").height() <= $(window).scrollTop()+$(window).height()){
    				page=$("#page").val();
    				page++;
    				$("#page").val(page);
                    if(type=='shakelottery'){
                        load_page_list(url_shake_lottery,page);
                    }else{
                        load_page_list(url_lottery,page);
                    }
    			}
    		});
        	$(".prizeHd>ul>li").on("click",function(){
                var index=$(this).index();
                // layer.alert(index);
                if(index!=2){
                    $(this).addClass('on').siblings().removeClass('on');
                }
        		if($(this).hasClass('showMore')){
        			$(".moreTags").slideToggle();
        			$(this).toggleClass("up");
        			return false;
        		}else if($(this).hasClass('toggleStatus')){
        			$(".statusTags").slideToggle();
        			$(this).toggleClass("up");
        			return false;
        		}else{
        			$(".prizeHd>ul>li").removeClass("up");
        			$(".tagList").hide();
        		}
                if($(this).hasClass("shake_lottery")){
                    $("#type").val("shakelottery");
                }
        		if($("#type").val()=='shakelottery'){
                    $(".prizeBd table").html('');
                    status = $('#lottery_status li[class="on"]').attr('type_id');
                    url_shake_lottery = '?a=shake_list&status='+status;
        			load_page_list(url_shake_lottery,1);
        		}
        		$("#page").val(1);
        	});
    	        // 摇一摇抽奖 兑奖实现
            $(".prizeBd table").on("click",".shakelottery",function(){
            	var rid=$(this).attr("rid");
            	var prize_type = $(this).attr("type");
            	var url_getprize_shiwu = "/wap/shakelottery.php?a=lottery_getadress&id="+rid;
            	var url_getprize_xuni='/wap/shakelottery.php?a=user_get_fictitiou&id='+rid;
            	var index = $(".prizeBd table a").index(this);
            	if(prize_type=='1'){
    			layer.open({
    			  type: 2,
    			  title: '填写收货地址',
    			  shadeClose: true,
    			  shade: false,
    			  closeBtn: 1, //不显示关闭按钮
    			  area: ['90%', '90%'],
    			  content: url_getprize_shiwu,
    			  end :function(){
    				var lis=$(".prizeBd table a").eq(index);
    				lis.removeClass("go");
    				lis.removeClass("shakelottery");
    				lis.addClass("ok");
    				lis.text("已兑奖");
    			  }
    			});
            	}else if(prize_type=='2'||prize_type=='3'){
    			$.get(url_getprize_xuni,function(sta){
    				if(sta.err_code==0){
    					var lis=$(".prizeBd table a").eq(index);
    					lis.removeClass("go");
    					lis.removeClass("shakelottery");
    					lis.addClass("ok");
    					lis.text("已兑奖");
    					layer.alert(sta.err_msg);
    				}else{
    					layer.alert(sta.err_msg);
    				}
    			},'json')
            	}else{
            		layer.alert('参数错误');
            	}
            })
        });
        // 加载分页
        function load_page_list(url,page){
        	var link=url+'&page='+page;
        	var islottery_list = url.indexOf("lottery_list")==-1?false:true;
        	if(islottery_list){
            	$.get(link,function(response){
                	if(response.err_code){
                    	if(response.ismore != undefined && response.ismore==false){
                        	return;
                        }
                    	layer.alert(response.err_msg);
                    	return;
                    }
                	var html = recode_record_list(response.record_list);
                	$('.prizeBd table').append(html);
                },'json');
            }else{
            	$.get(link,function(sta){
            		$('.prizeBd table').append(sta.err_msg);
            	},'json');
            }
        }

        // 抽奖活动合集
        $('#lottery_list li').on('click',function(){
            $(this).addClass('on').siblings('li').removeClass('on');
            var type_id = $(this).attr('type_id');
            var status = $('#lottery_status li[class="on"]').attr('type_id');
            $(".moreTags").slideToggle();
            $('.prizeBd table').html('');
            var url_lottery = '?a=lottery_list&type='+type_id+'&status='+status;
            load_page_list(url_lottery,1);
            $("#page").val(1);
            $("#type").val(type_id);
        });

     	// 状态更改
        $('#lottery_status li').on('click',function(){
            $(this).addClass('on').siblings('li').removeClass('on');
            var type_id = $('#lottery_list li[class="on"]').attr('type_id');
            var status = $(this).attr('type_id');
            $(".statusTags").slideToggle();
            $('.prizeBd table').html('');
            var url_lottery = '?a=lottery_list&type='+type_id+'&status='+status;
            var url_shake_lottery = '?a=shake_list&status='+status;
            if($("#type").val()=='shakelottery'){
                 load_page_list(url_shake_lottery,1);
            }else{
                load_page_list(url_lottery,1);
            }
            $("#page").val(1);
        });

        // 显示记录
        function recode_record_list(record_list){
            var html = '';
            $.each(record_list,function(i,v){
	            html += '	<tr>';
	            html += '    <td class="prizeInfo"><h2><span>'+v.type_name+'</span>奖品：'+v.product_name+'</h2><p>中奖日期：'+v.dateline+'</p></td>';
	            html += '    <td class="prizeState">';
	            if(v.prize_time>0){
	            	html += '        <p> <a href="javascript:;" class="ok">已兑奖</a></p>';
		        }else{
			        var method = v.isonline==1?'go_online('+v.id+','+v.active_id+',\''+v.product_name+'\')':'go_unline('+v.id+','+v.active_id+',\''+v.product_name+'\')';
		        	html += '        <p><a href="javascript:'+method+';" class="go">兑奖</a></p>';
			    }
	            html += '    </td>';
	            html += '   </tr>';
            });
            return html;
        }

        // 线上对奖
        function go_online(rid,aid,product_name){
        	var aid = aid;	// 活动id
            var rid = rid;
            // 检查中奖商品是否需要发货，如果需要发货，检查用户是否有收货地址
            $.get('/wap/lottery.php?action=check_address',{'aid':aid},function(response){
        		if(response.err_code>0){
        			layer.alert(response.err_msg);
        			setTimeout(function(){window.location = '/wap/lottery.php?action=myaddress&aid='+aid},2000);
        		}else{
        			// 开始兑奖
        			$.post('/wap/lottery.php?action=cash_prize',{'rid':rid,'aid':aid},function(response){
        				layer.alert(response.err_msg);
        				if(response.err_code==0){
        					setTimeout(function(){window.location.reload();},2000);
        				}
        			},'json');
        		}
            },'json');
        }

        // 线下对奖
        function go_unline(rid,aid,product_name){
            $('#record_id').val(rid);
            $('#aid').val(aid);
        	$(".cashPrizeWindow").show();
        }

        // 兑奖
        function doprize(){
        	var aid = $('#aid').val();	// 活动id
            var rid = $('#record_id').val();
            // 检查中奖商品是否需要发货，如果需要发货，检查用户是否有收货地址
            $.get('/wap/lottery.php?action=check_address',{'aid':aid},function(response){
        		if(response.err_code>0){
        			layer.alert(response.err_msg);
        			setTimeout(function(){window.location = '/wap/lottery.php?action=myaddress&aid='+aid},2000);
        		}else{
        			// 开始兑奖
        			var password = $.trim($('#pwd').val());
        			if(password==''){
            			layer.alert('请输入兑奖密码');
            			return;
            		}
        			$.post('/wap/lottery.php?action=cash_prize',{'rid':rid,'aid':aid,'password':password},function(response){
        				layer.alert(response.err_msg);
        				if(response.err_code==0){
        					setTimeout(function(){window.location.reload();},2000);
        				}
        			},'json');
        		}
            },'json');
        }
    </script>
</body>
</html>
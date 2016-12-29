<!DOCTYPE html>
<html class="ui-mobile">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=1">
    <title>幸运水果机</title>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/luckyFruit/wap/jquery.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/luckyFruit/wap/tigerslot.css">
	<script src="<?php echo TPL_URL;?>js/rem.js" type="text/javascript"></script>
    <style type="text/css">
.window {
	width:290px;
	position:fixed;
	display:none;
	bottom:120px;
	left:50%;
	 z-index:9999;
	margin:-50px auto 0 -145px;
	padding:2px;
	border-radius:0.6em;
	-webkit-border-radius:0.6em;
	-moz-border-radius:0.6em;
	background-color: #ffffff;
	-webkit-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	-moz-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	-o-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	font:14px/1.5 Microsoft YaHei,Helvitica,Verdana,Arial,san-serif;
}
.window .title {
	
	background-color: #A3A2A1;
	line-height: 26px;
    padding: 5px 5px 5px 10px;
	color:#ffffff;
	font-size:16px;
	border-radius:0.5em 0.5em 0 0;
	-webkit-border-radius:0.5em 0.5em 0 0;
	-moz-border-radius:0.5em 0.5em 0 0;
	background-image: -webkit-gradient(linear, left top, left bottom, from( #585858 ), to( #565656 )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient(#585858, #565656); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient(#585858, #565656); /* FF3.6 */
	background-image:     -ms-linear-gradient(#585858, #565656); /* IE10 */
	background-image:      -o-linear-gradient(#585858, #565656); /* Opera 11.10+ */
	background-image:         linear-gradient(#585858, #565656);
	
}
.window .content {
	/*min-height:100px;*/
	overflow:auto;
	padding:10px;
	background: linear-gradient(#FBFBFB, #EEEEEE) repeat scroll 0 0 #FFF9DF;
    color: #222222;
    text-shadow: 0 1px 0 #FFFFFF;
	border-radius: 0 0 0.6em 0.6em;
	-webkit-border-radius: 0 0 0.6em 0.6em;
	-moz-border-radius: 0 0 0.6em 0.6em;
}
.window #txt {
	min-height:30px;font-size:16px; line-height:22px;
}
.window .txtbtn {
	
	background: #f1f1f1;
	background-image: -webkit-gradient(linear, left top, left bottom, from( #DCDCDC ), to( #f1f1f1 )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #ffffff , #DCDCDC ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #ffffff , #DCDCDC ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #ffffff , #DCDCDC ); /* IE10 */
	background-image:      -o-linear-gradient( #ffffff , #DCDCDC ); /* Opera 11.10+ */
	background-image:         linear-gradient( #ffffff , #DCDCDC );
	border: 1px solid #CCCCCC;
	border-bottom: 1px solid #B4B4B4;
	color: #555555;
	font-weight: bold;
	text-shadow: 0 1px 0 #FFFFFF;
	border-radius: 0.6em 0.6em 0.6em 0.6em;
	display: block;
	width: 100%;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
	text-overflow: ellipsis;
	white-space: nowrap;
	cursor: pointer;
	text-align: windowcenter;
	font-weight: bold;
	font-size: 18px;
	padding:6px;
	margin:10px 0 0 0;
}
.window .txtbtn:visited {
	background-image: -webkit-gradient(linear, left top, left bottom, from( #ffffff ), to( #cccccc )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #ffffff , #cccccc ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #ffffff , #cccccc ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #ffffff , #cccccc ); /* IE10 */
	background-image:      -o-linear-gradient( #ffffff , #cccccc ); /* Opera 11.10+ */
	background-image:         linear-gradient( #ffffff , #cccccc );
}
.window .txtbtn:hover {
	background-image: -webkit-gradient(linear, left top, left bottom, from( #ffffff ), to( #cccccc )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #ffffff , #cccccc ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #ffffff , #cccccc ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #ffffff , #cccccc ); /* IE10 */
	background-image:      -o-linear-gradient( #ffffff , #cccccc ); /* Opera 11.10+ */
	background-image:         linear-gradient( #ffffff , #cccccc );
}
.window .txtbtn:active {
	background-image: -webkit-gradient(linear, left top, left bottom, from( #cccccc ), to( #ffffff )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #cccccc , #ffffff ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #cccccc , #ffffff ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #cccccc , #ffffff ); /* IE10 */
	background-image:      -o-linear-gradient( #cccccc , #ffffff ); /* Opera 11.10+ */
	background-image:         linear-gradient( #cccccc , #ffffff );
	border: 1px solid #C9C9C9;
	border-top: 1px solid #B4B4B4;
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3) inset;
}

.window .title .close {
	float:right;
	
	width:26px;
	height:26px;
	display:block;	
}
.ui-body-c{
background:rgba(0,0,0,0);
}
.peplo_content div a{
    text-shadow: 0px 0px 0px;
}

div {font-family: "微软雅黑";}
.layer {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.5);
        z-index: 900;
    }

    .layer_content {
         background: #fff;
		position: fixed;
		width: 15rem;
		left: 50%;
		top: 50%;
		text-align: center;
		z-index: 901;
		height: 19rem;
		margin-top: -8.5rem;
		margin-left: -7.5rem;

    }
    .layer_content .layer_title {
        font-size: .6rem;
        color: #fff;
        line-height: .9rem;
        padding: .3rem .5rem;
        background: #45a5cf;
        text-align: left;
        text-indent: 1.2rem;
    }
    .layer_content p {
        font-size: .55rem;
        color: #333333;
        line-height: 1.4rem;
    }
    .layer_content img {
        width: 8rem;
        margin: 1rem 0;
    }
    .layer_content p span {
        font-size: .45rem;
        color: #999;
        line-height: 0.9rem;
    }

    .layer_content button {
        background: #ff9c00;
        width: 5.5rem;
        height: 1.5rem;
        color: #fff;
        line-height: 1.5rem;
        border-radius: 1.5rem;
        margin: .6rem 0;
    }

    .layer_content i {
        background: url(/template/wap/default/ucenter/images/weidian_25.png) no-repeat;
        background-size: 1rem;
        height: 1.2rem;
        width: 1.24rem;
        display: inline-block;
        vertical-align: middle;
        position: absolute;
        right: -.5rem;
        top: -.5rem;
    }
	.profit, .nickname {
		color: #26CB40;
	}
	
</style>
</head>
<?php if ($lottery['need_subscribe'] && empty($is_subscribe)) {?>
<aside>
    <div class="layer"></div>
    <div class="layer_content">
        <div class="layer_title" style="text-shadow: initial;">亲，店家发现你还未关注店家的公众号</div>
        <div class="layer_text">
            <p>第一步：长按二维码并识别</p>
            <img src="<?php echo $_result['ticket'];?>" >
            <p>第二步：打开图文进入游戏</p>
            <p><em>贴心小提示：成为店铺会员购物一直有特权哦！</em></p>
        </div>
    </div>
</aside>
<?php }?>


<?php if($lottery['backgroundThumImage'] == ''){?>
<body style="background:url('<?php echo TPL_URL;?>css/luckyFruit/wap/bg.png')">
<?php }else{?>
	<?php if($lottery['fill_type'] == 0){?>
	<body style="background:url('<?php echo getAttachmentUrl($lottery['backgroundThumImage'])?>')">
	<?php }else{?>
	<body>
	<img src="<?php echo $lottery['bg']?>" style="position: fixed;top:0;left:0;width:100%;height:100%;z-index:-99">
	<?php }?>
<?php }?>
<script src="<?php echo TPL_URL;?>css/luckyFruit/wap/jquery-1.js"></script>
<script src="<?php echo TPL_URL;?>css/luckyFruit/wap/jquery.js"></script>
<script src="<?php echo TPL_URL;?>css/luckyFruit/wap/alert.js"></script>
<pigcmsif where="$memberNotice neq ''">
<else/>
<!-- <script src="tpl/static/luckyFruit/wap/tigerslot.js"></script> -->
<script>
(function () {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame']
                                   || window[vendors[x] + 'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function (callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function () { callback(currTime + timeToCall); },
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function (id) {
            clearTimeout(id);
        };
}());

(function () {
    window.GameTimer = function (fn, timeout) {
        this.__fn = fn;
        this.__timeout = timeout;
        this.__running = false;
        this.__lastTime = Date.now();
        this.__stopcallback = null;
    };

    window.GameTimer.prototype.__runer = function () {
        if (Date.now() - this.__lastTime >= this.__timeout) {
            this.__lastTime = Date.now();
            this.__fn.call(this);
        }
        if (this.__running) {
            window.requestAnimationFrame(this.__runer.bind(this));
        }
        else {
            if (typeof this.__stopcallback === 'function') {
                window.setTimeout(this.__stopcallback,100);
            }
        }
    };

    window.GameTimer.prototype.start = function () {
        this.__running = true;
        this.__runer();
    };
    window.GameTimer.prototype.stop = function (callback) {
        this.__running = false;
        this.__stopcallback = callback;
    };

})();


// 重新组织抽奖数据
function reorganize(res){
	var aid = res.aid;									// 活动id
	var isonline = res.isonline;						// 是否是线上兑奖
	var prizetype = parseInt(res.prizetype);			// 获奖等级
	var product_name = res.product_name;				// 奖品名称
	var rid = res.rid;									// 抽奖记录id

	var data = new Object();
	var fruitNum = prizetype-1;
	data.left = fruitNum;
	data.middle = fruitNum;
	data.right = fruitNum;
	data.prize_type = 
	data.prize = prizetype;
	return data;
}
var prize_names = ['一等奖','二等奖','三等奖','四等奖','五等奖','六等奖'];
$(function () {
    var url_rndprize = '/wap/lottery.php?action=get_prize&aid=<?php echo $lottery['id']?>';
    var url_getprize = '兑奖地址';
    var itemPositions = [
        0, //苹果
        100,//芒果
        200,//布林
        300,//香蕉
        400,//草莓
        500,//梨
        600,//桔子
        700,//青苹果
        800//樱桃
    ];

    //游戏开始
    var gameStart = function () {
        lightFlicker.stop();
        lightRandom.stop();
        lightCycle.start();
		
        var prize_arr = ['一等奖','二等奖','三等奖','四等奖','五等奖','六等奖'];
		
        var marketing_id = $('.tigerslot').attr('activity_id');
        var token = $('.tigerslot').attr('data-token');
        var wechat_id = $('.tigerslot').attr('wechat_id');
        var rid = $('.tigerslot').attr('rid');
        $.post(url_rndprize, {
        	aid:<?php echo $lottery['id']?>
        }, function (result) {
        	if(result.err_code > 0){
            	$('#modaltrigger_notice').removeClass('stop');
        		alert(result.err_msg);
        		return;
        	}
        	// 抽奖次数
			var usenums = $('#usenums').text();
			$('#usenums').text(parseInt(usenums)+1);
        	if(result.success){
            	// 中奖了
				$('.tigerslot').attr('rid',result.rid);
				$('#rid').val(result.rid);
				$('#isonline').val(result.isonline);
				$('#_prizes').val(result.prizetype);
				$('.prizetype').text(prize_arr[result.prizetype]);
				var data = reorganize(result);
        		boxCycle.start(data);
        	}
        	if(result.success==false){
            	var data = new Object();
        		data.prize = 2;
	            data.type = 0;
	            data.left = parseInt(10*Math.random());
	            data.middle = parseInt(10*Math.random());
	            if(data.left == data.middle){
	                data.middle = parseInt(10*Math.random());
	            }
	            data.right = parseInt(10*Math.random());
	            if(data.middle == data.right){
	                data.right = parseInt(10*Math.random());
	            }
	            boxCycle.start(data);
            	return;
        	}
        },'json');

    };

    //游戏结束
    var gameOver = function (resultData) {
        lightFlicker.start();
        lightRandom.stop();
        lightCycle.stop();

        //
        if(resultData.type == 0){
        	alert('未中奖');
        	$('.machine .gamebutton').removeClass('disabled');
        }else{
			// 中奖次数
			var winnums = $('#winnums').text();
			$('#winnums').text(parseInt(winnums)+1);
        	$('.machine .gamebutton').addClass('disabled');
			$('.machine .gamebutton').removeClass('disabled');
            $("#prize").text(prize_names[parseInt(resultData.prize-1)]);
            $("#request-reward").slideDown(500);
        }
		var rest_chance = parseInt($('#rest_chance').text()) - 1;
		rest_chance = rest_chance<0 ? 0 : rest_chance;
		$('#rest_chance').text(rest_chance);		
    };

    //准备兑奖
    var getprize = function (listid, prizeid, code) {
        var tel=prompt('获奖纪录id:' + listid + ' ,奖品ID:' + prizeid + ' ,兑奖编码：' + code +'\n请输入手机号码兑奖：');
        if ($.trim(tel)) {
            /*
            $.post(url_getprize, {
                listid: listid, prizeid: prizeid, code: code
            }, function (result) {
                //操作成功,
                //setPrizeList(listid);
            });
            */
          
        }
        else {
            return false;
        }
    };
    
    //
    var setPrizeList = function (listid) {
        console.log($prizelist);
        var p = $prizelist.find('li[prizelist_id="' + listid + '"]');
        p.addClass('hasGetPrize');
    };

    var $machine = $('.machine');
    var $slotBox = $('.tigerslot .box');
    var light_html = '';
    for (var i = 0; i < 21; i++) {
        light_html += '<div class="light l'+ i +'"></div>';
    }
    var $lights = $(light_html).appendTo($machine);
    var $result = $('#result').on('click', '.close-btn', function(){
    	$result.slideUp();
    	
        var submitData = {
                marketing_id: $('.tigerslot').attr('activity_id'),
                sn: $.trim($(".sncode").text()),
                wxid: $('.tigerslot').attr('data-token')
            };
        $.post('###', 
        		submitData,
        		function(data) {
					if (data.error == 1) {
						alert(data.msg);
						return;
					}        	
		            if (data.success == 1) {
		    			//window.location.reload();
		            	$('#result #prize').empty();
		            	$('#result .sncode').empty();
		            	$('.machine .gamebutton').removeClass('disabled');
		                return;
		            } else {
		
		            }
        		});   	
    });
    var $request_reward = $('#result').on('click', '.close-btn', function(){
    	$request_reward.slideUp();
    })
    
    var $gameButton = $('.machine .gamebutton').tap(function () {
        var $this = $(this);
        if (!$this.hasClass('disabled')) {
            $this.addClass('disabled');
            $this.toggleClass(function (index, classname) {
                if (classname.indexOf('stop') > -1) {
                    boxCycle.stop(function (resultData) {
                        gameOver(resultData);
                        //$this.removeClass('disabled');
                    });
                } else {
                    gameStart();
                    window.setTimeout(function () {
                        $this.removeClass('disabled');
                    },1500);
                }
                return 'stop';
            });
        }
    });

    var $prizelist = $('.part.prizelist').on('tap', '.getprize', function () {
        var $this = $(this), $parent = $this.parent();
        var code = $parent.find('.code').html();
        $("#result").slideToggle(500);

        return false;
    });
    
    //线下兑奖
    $('.part').on('tap', '#submit-btn', function () {
    	var aid = <?php echo $lottery['id']?>;	// 活动id
        var rid = $('#rid').val();
    	// 检查中奖商品是否需要发货，如果需要发货，检查用户是否有收货地址
        $.get('/wap/lottery.php?action=check_address',{'aid':aid},function(response){
    		if(response.err_code>0){
    			alert(response.err_msg);
    			setTimeout(function(){window.location = '/wap/lottery.php?action=myaddress&aid='+aid},2000);
    		}else{
    			// 开始兑奖
    			var password = $.trim($('#pwd').val());
    			if(password==''){
        			alert('请商家输入兑奖密码');
        			return;
        		}
    			$.post('/wap/lottery.php?action=cash_prize',{'rid':rid,'aid':aid,'password':password},function(response){
    				alert(response.err_msg);
    				if(response.err_code==0){
    					setTimeout(function(){window.location.href = '/wap/lottery.php?action=detail&id=<?php echo $lottery['id']?>&rand='+Math.random();},2000);	
    				}
    			},'json');
    		}
        },'json');
    });
    
    //提交验证码    
    $('.part').on('tap', '#ver-btn', function () {
        var pwd = $("#password").val();
        if (pwd == '') {
            alert("请输入密码");
            return;
        }
        	
        var submitData = {
        	aid : <?php echo $lottery['id']?>,	// 活动id
            password: pwd,
            rid: $('.tigerslot').attr('rid')
        };
        $.post('/wap/lottery.php?action=cash_prize',submitData,function(response){
			alert(response.err_msg);
			if(response.err_code==0){
				setTimeout(function(){window.location.href = '/wap/lottery.php?action=detail&id=<?php echo $lottery['id']?>&rand='+Math.random();},2000);	
			}
		},'json');
    });
    
    var lightCycle = new function () {
        var currIndex = 0, maxIndex = $lights.length - 1;
        $('.l0').addClass('on');
        var tmr = new GameTimer(function () {
            $lights.each(function(){
                var $this = $(this);
                if($this.hasClass('on')){
                    currIndex++;
                    if (currIndex > maxIndex) {
                        currIndex = 0;
                    }
                    $this.removeClass('on');
                    $('.l' + currIndex).addClass('on');
                    return false;
                }
            });
        }, 100);
        this.start = function () {
            tmr.start();
        };
        this.stop = function () {
            tmr.stop();
        };
    };
    var lightRandom = new function () {
        var tmr = new GameTimer(function () {
            $lights.each(function () {
                var r = Math.random() * 1000;
                if (r < 400) {
                    $(this).addClass('on');
                } else {
                    $(this).removeClass('on');
                }
            });
        }, 100);
        this.start = function () {
            tmr.start();
        };
        this.stop = function () {
            tmr.stop();
        };
    };

    var lightFlicker = new function () {
        $lights.each(function (index) {
            if ((index >> 1) == index / 2) {
                $(this).addClass('on');
            } else {
                $(this).removeClass('on');
            }
        });
        var tmr = new GameTimer(function () {
            $lights.toggleClass('on');
        }, 100);
        this.start = function () {
            tmr.start();
        };
        this.stop = function () {
            tmr.stop();
        };
    };


    var boxCycle = new function () {

        var speed_left = 0, speed_middle = 0, speed_right = 0, maxSpeed = 25;
        var running = false, toStop = false, toStopCount = 0;
        var boxPos_left = 0, boxPos_middle = 0, boxPos_right = 0;
        var toLeftIndex = 0, toMiddleIndex = 0, toRightIndex = 0;
        var resultData;
        
        var $box = $('.tigerslot .box'), $box_left = $('.tigerslot .strip.left .box'), $box_middle = $('.tigerslot .strip.middle .box'), $box_right = $('.tigerslot .strip.right .box');

        var fn_stop_callback = null;

        var tmr = new GameTimer(function () {
            if (toStop) {
                toStopCount--;
                speed_left = 0;
                boxPos_left = -itemPositions[toLeftIndex];
                if (toStopCount < 25) {
                    speed_middle = 0;
                    boxPos_middle = -itemPositions[toMiddleIndex];
                }
                if (toStopCount < 0) {
                    speed_right = 0;
                    boxPos_right = -itemPositions[toRightIndex];
                }


            } else {
                speed_left += 1;
                speed_middle += 1;
                speed_right += 1;
                if (speed_left > maxSpeed) {
                    speed_left = maxSpeed;
                }
                if (speed_middle > maxSpeed) {
                    speed_middle = maxSpeed;
                }
                if (speed_right > maxSpeed) {
                    speed_right = maxSpeed;
                }
            }

            boxPos_left += speed_left;
            boxPos_middle += speed_middle;
            boxPos_right += speed_right;

            $box_left.css('background-position', '0 ' + boxPos_left + 'px')
            $box_middle.css('background-position', '0 ' + boxPos_middle + 'px')
            $box_right.css('background-position', '0 ' + boxPos_right + 'px')

            if (speed_left == 0 && speed_middle == 0 && speed_right == 0) {
                tmr.stop(fn_stop_callback.bind(this, resultData));
            }
            
        }, 33);

        this.start = function (data) {
            toLeftIndex = data.left; toMiddleIndex = data.middle; toRightIndex = data.right;
            running = true; toStop = false;
            resultData = data;
            tmr.start();
        };

        this.stop = function (fn) {
            fn_stop_callback = fn;
            toStop = true;
            toStopCount = 50;
        };


        this.reset = function () {
            $box_left.css('background-position', '0 ' + itemPositions[0] + 'px');
            $box_middle.css('background-position', '0 ' + itemPositions[0] + 'px');
            $box_right.css('background-position', '0 ' + itemPositions[0] + 'px');
        };
        this.reset();
    };

    //顶部滚动中奖信息
	AutoScrollHeader = (function(obj){
		$(obj).find("ul:first").animate({
			marginTop:"-15px"
		},500,function(){
			$(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
		});
	});
	if($('.scroll-reward-info li').length >1){
	   setInterval('AutoScroll(".scroll-reward-info")',4000);
	}
	
	//手机号码格式判断
	function istel(value) {
	    var regxEny = /^[0-9]*$/;
	    return regxEny.test(value);
	}
	

    lightFlicker.start();
    window.setTimeout(function () {
        lightFlicker.stop();
    }, 2000)

});

$('#ver-btn').on('click',function(){
	var rid = $('#rid').val();
	var isonline = $('#isonline').val();
	var _prizes = $('#_prizes').val();
	if(isonline==0){
		// 线下
		dh_unline(rid,prize_names[_prizes]);
	}else{
		dh(rid,prize_names[_prizes]);
	}
});

function lq(prizetype,sncode,rid){
	$('.result').hide();
	$('#result').show();
	$('#prize').text(prizetype+'等奖');
	$('.sncode').text(sncode);
	$('.tigerslot').attr('rid',rid);
}

// 线下兑奖
function dh_unline(rid,prizetype){
	$('.result').hide();
	$('#result').show();
	$('#prize').text(prizetype);
	$('.tigerslot').attr('rid',rid);
	$('#rid').val(rid);
}

// 线上兑奖
function dh(rid,prizetype){
	// 开始线上兑奖
	// 检查中奖商品是否需要发货，如果需要发货，检查用户是否有收货地址
	var aid = <?php echo $lottery['id']?>;
    $.get('/wap/lottery.php?action=check_address',{'aid':aid},function(response){
		if(response.err_code>0){
			alert(response.err_msg);
			setTimeout(function(){window.location = '/wap/lottery.php?action=myaddress&aid='+aid},2000);
		}else{
			// 开始兑奖
			$.post('/wap/lottery.php?action=cash_prize',{'rid':rid,'aid':aid},function(response){
				alert(response.err_msg);
				if(response.err_code==0){
					setTimeout(function(){window.location.href = '/wap/lottery.php?action=detail&id=<?php echo $lottery['id']?>&rand='+Math.random();},2000);	
				}
			},'json');
		}
    },'json');
}
function centerTop(a) {
    var wWidth = $(window).width();
    var boxWidth = $(a).width();
    var scrollLeft = $(window).scrollLeft();
    var left = scrollLeft + (wWidth - boxWidth) / 2;
    $(a).css({
        "left": left
    });
}
$(function(){
	centerTop('.ui-content');
});
</script>
</pigcmsif>

<?PHP if($lottery['backgroundThumImage'] != ''){?>
<img src="<?php echo getAttachmentUrl($lottery['backgroundThumImage'])?>" style="position: fixed;top:0;left:0;width:100%;height:100%;z-index:0">
<?PHP }?>

<div class="window" id="windowcenter">
	<div id="title" class="title">消息提醒<span class="close" id="alertclose"></span></div>
	<div class="content">
	 <div id="txt"></div>
	 <input value="确定" id="windowclosebutton" name="确定" class="txtbtn" type="button">	
	</div>
</div>

        <div role="main" style="padding-top:10px;position:absolute;z-index:99;width:100%;" class="tigerslot ui-content" style="position: absolute;z-index:99" data-role="content" activity_id="{pigcms:$lottery.id}" wechat_id="{pigcms:$lottery.wecha_id}" data-token="{pigcms:$lottery.token}" rid="{pigcms:$lottery.rid}">
          <div style="height:20px;"></div>
            <div class="machine">
                <div class="strip left">
                    <div style="background-position: 0px 0px;" class="box"></div>
                    <div class="cover"></div>
                </div>
                <div class="strip middle">
                    <div style="background-position: 0px 0px;" class="box"></div>
                    <div class="cover"></div>
                </div>
                <div class="strip right">
                    <div style="background-position: 0px 0px;" class="box"></div>
                    <div class="cover"></div>
                </div>
				<a class="gamebutton" href="#memberNoticeBox" id="modaltrigger_notice"></a>
            <div class="light l0"></div><div class="light l1 on"></div><div class="light l2"></div><div class="light l3 on"></div><div class="light l4"></div><div class="light l5 on"></div><div class="light l6"></div><div class="light l7 on"></div><div class="light l8"></div><div class="light l9 on"></div><div class="light l10"></div><div class="light l11 on"></div><div class="light l12"></div><div class="light l13 on"></div><div class="light l14"></div><div class="light l15 on"></div><div class="light l16"></div><div class="light l17 on"></div><div class="light l18"></div><div class="light l19 on"></div><div class="light l20"></div></div>
            
            
            <div id="result" class="part result" style="display:none">
            	<a title="取消" data-wrapperels="span" data-iconshadow="true" data-shadow="true" data-corners="true" class="close-btn ui-btn ui-btn-up-c ui-shadow ui-btn-corner-all ui-btn-inline ui-btn-icon-notext" style="position:absolute;top:0;right:0;" data-role="button" data-icon="delete" data-iconpos="notext" data-theme="c" data-inline="true"><span class="ui-btn-inner"><span class="ui-btn-text">取消</span><span class="ui-icon ui-icon-delete ui-icon-shadow">&nbsp;</span></span></a>
                <div class="title">填写中奖信息</div>
                <div class="content">
					<p>您中了：<span id="prize"></span></p>
					<p class="red" id="red"><?php echo $lottery['win_tip']?></p>
					<p><input type="password" class="ui-input-text ui-body-c" id="pwd"  placeholder="请经销商输入兑奖密码"/>
					</p>
					<p>
					<input data-disabled="false" class="ui-btn-hidden" id="submit-btn" value="提交" type="button">
					</p>                  
                </div>
            </div>
            <input type="hidden" id="rid" />
            <input type="hidden" id="isonline" />
            <input type="hidden" id="_prizes" />
			<div id="request-reward" class="part result" style="display:none">
				<a title="取消" data-wrapperels="span" data-iconshadow="true" data-shadow="true" data-corners="true" class="close-btn ui-btn ui-btn-up-c ui-shadow ui-btn-corner-all ui-btn-inline ui-btn-icon-notext" style="position:absolute;top:0;right:0;" data-role="button" data-icon="delete" data-iconpos="notext" data-theme="c" data-inline="true"><span class="ui-btn-inner"><span class="ui-btn-text">取消</span><span class="ui-icon ui-icon-delete ui-icon-shadow">&nbsp;</span></span></a>
				<div class="title">领取奖品</div>
				<div class="content">
					<p><?php echo $lottery['win_info']?></p>
					<p>你中了：<span class="red prizetype"></span></p>
					<p><input data-disabled="false" class="ui-btn-hidden" id="ver-btn" value="提交" type="button">
					</p>
				</div>
			</div>
			<?php 
				// 今天抽奖次数
				$today_draw_count = 0;
				// 今天中奖次数
				$today_prize_count = 0;
			?>
			<?php if($record){?>
				<div class="part">
					<div class="title">您中过的奖</div>
					<?php foreach($record as $k=>$v){
						if($v['dateline']>strtotime(date('Y-m-d 00:00:00'))){
							$today_draw_count++;
							if($v['prize_id']>0){
								$today_prize_count++;
							}
						}
					if($v['prize_id']>0){
					?>
					<div class="content" <?php if($k != 0){?>style="border-top :1px dashed rgba(0, 0, 0, 0.3);"<?php }?> 
					<?php if($v['status'] == 0){?>
						<?php if($v['isonline']==0){?>
							onclick="dh_unline('<?php echo $v['id'];?>','<?php echo $prize_names[$v['prize_id']];?>')"
						<?php }else{?>
							onclick="dh('<?php echo $v['id'];?>','<?php echo $prize_names[$v['prize_id']];?>')"
						<?php }?>
					
					<?php }?>
					>
						<p>你中了：<span class="red" ><?php echo $prize_names[$v['prize_id']]?></span></p>
						<p>中奖时间：<span class="red"><?php echo date('Y-m-d H:i:s',$v['dateline']);?></span></p>
						<p>状态：<span class="red">
						<?php if($v['status'] == 0){?>
						未兑奖，点击兑奖
						<?php }else{?>
						已于<?php echo date('Y-m-d H:i:s',$v['prize_time'])?>兑奖
						<?php }?>
						</span></p>
					</div>
					<?php } }?>
				</div>
		<?php }?>
			<?php if($lottery['endtime']<time()){?>
			<div class="part">
                <div class="title">结束说明:</div>
                <div class="content">
				<p><?php echo $lottery['endtitle']?></p>
                </div>
            </div>
			<?php }?>
            <div class="part">
                <div class="title">奖项设置:</div>
                <div class="content">              
	            <?php if ($lottery['starttime'] > time()){echo '<p style="color:red">活动还没有开始 :(</p>';}?>
	
				 <?php if($lottery['win_limit'] == 1){?>
				 	<p>每人每日最多允许抽奖次数：<?php echo $lottery['win_limit_extend']?>-已抽取<span class="red" id="usenums"><?php echo $today_draw_count;?></span>次</p>
					<p>分享获取奖励次数：<?php echo $lottery_share_setting['num']-$lottery['win_limit_extend'];?>次</p>
				<?php }elseif($lottery['win_limit'] == 2){?>
					<p>每分享<?php echo $lottery['win_limit_extend']?>次，增加一次机会</p>
				 <?php }elseif($lottery['win_limit'] == 3){?>
					<p>每抽奖一次，消耗<?php echo $lottery['win_limit_extend']?>积分</p>
				 <?php }?>
				 <br />
				 <?php if($lottery['win_type']==0){?>
				 	<p>每人中奖总数：<?php echo $lottery['win_type_extend']?>次-已中奖<span class="red" id="winnums"><?php echo $win_num_record?></span>次</p>
				 <?php }elseif($lottery['win_type']==1){?>
				 	<p>每人每日中奖总数：<?php echo $lottery['win_type_extend']?>次-已中奖<span class="red" id="winnums"><?php echo $today_prize_count?></span>次</p>
				 <?php }?>
					<br>
				<?php if($lottery_prizes){?>
					<?php foreach($lottery_prizes as $_prize){?>
		            	<p><?php echo $prize_names[$_prize['prize_type']]?>: <?php echo $_prize['product_name']?><?php if($lottery['isshow_num']){?>--奖品数量: <?php echo $_prize['product_num']?><?php }?></p>
		            <?php }?>
		        <?php }?>
                </div>
            </div>

            <div class="part">
                <div class="title">活动说明:</div>
                <div class="content">
				<p><?php echo $lottery['active_desc']?></p>
		        <p>活动时间:<?php echo date('Y-m-d H:i',$lottery['starttime'])?>至<?php echo date('Y-m-d H:i',$lottery['endtime'])?></p>
		        </div>
            </div>
        </div>

<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon ui-icon-loading"></span></div>

<?php echo $shareData;?>
</body></html>
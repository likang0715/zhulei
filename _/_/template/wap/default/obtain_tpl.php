<!DOCTYPE html>
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>获取证书<?php echo $point_alias; ?></title>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<meta name="format-detection" content="telephone=no">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		<meta name="applicable-device" content="mobile">
                <script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
                <link href="<?php echo STATIC_URL;?>zt/zt.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/my.css">
                <script src="<?php echo STATIC_URL;?>js/layer_mobile/layer.m.js"></script>
                <style> 
                    .black_overlay{  display: block;  position: absolute;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.8;  opacity:.80;  filter: alpha(opacity=80);  }  
                    .white_content {  display: block; position: absolute;  top: 38%;  left: 10%;  width: 250px;  height: 100px;  padding: 16px;  border: 1px solid orange;  background-color: white;  z-index:1002;  overflow: auto; text-align: center;}  
                    .account-fr { width: 55px; height: 32px; border: solid 1px #ff7216; border-radius: 3px; }
                    .account { width: 55px; height: 22px; border: solid 1px #ff7216; border-radius: 3px; }
                </style>
	</head>
	<body>
            
            <div id="content">
                <div>
                    <div>
                        <div style="float:left;"><a href=""><button class="account">返回</button></a></div>
                        <div style="text-align:  center; font-size: 15px; color: #000000;">模板证书</div>
                        <div onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'" style="float:right;  margin-top: -22px;"><button class="account">获取</button></div>
                    </div>
                    <div style=" text-align: center; border:1px dotted red"></div>
                </div>
                
                <div id="light" class="white_content">
                    <div style=" margin-top: 15px;">
                        姓名：<input type="text" name="user_name" id="user_name" value="" style=" height: 25px; border: solid 1px #ff7216;"/>
                        <br/>
                        <div style=" margin-top: 15px;">
                                <button class="account-fr" onclick="yes()">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" class="account-fr"onclick="no()">取消</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id='store_id' value="<?php echo $_GET['id'];?>"/>
                <div id="fade" class="black_overlay"></div>
                
<!--                <div id="ssss" style=" display: show;text-align: center; margin:0 auto; border: solid 1px #ff7216;  margin-top: 50%; width: 300px; height: 100px;">
                    <div style=" margin-top: 15px;">
                        姓名：<input type="text" name="user_name" id="user_name" value="" style=" height: 25px; border: solid 1px #ff7216;"/>
                        <br/>
                        <div style=" margin-top: 15px;">
                            <button class="account-fr" onclick="yes()">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="account-fr"onclick="no()">取消</button>
                        </div>
                        
                    </div>
                </div>-->
                                
  
                <script>
                   function yes(){
                       var user_name = $('#user_name').val();

                       var store_id = $('#store_id').val();
                       
                       if(user_name){
                           
                           $.post("obtain_ajax.php", {'user_name':user_name,'store_id':store_id}, function(data){
                            // alert(data);
                               if(data == 1){
                                        layer.open({
                                            content: '未查询供货商模板请联系供货商或管理员',
                                            style: 'background-color:#09C1FF; color:#fff; border:none;',
                                            time: 2
                                        });
                               }else if(data == 2){
                                    layer.open({
                                            content: '生成图片失败请重试',
                                            style: 'background-color:#09C1FF; color:#fff; border:none;',
                                            time: 2
                                        });
                               }else{
                                   document.getElementById('fade').style.display='none';
                                    var img_show = "<img src='"+data+"'/>";
                                    document.getElementById('light').style.display='none';
    //                                document.getElementById("otp").style.display="";
                                    $('#img_show').html(img_show);
                               }
                           });
                           
                       }else{
                            layer.open({
                                content: '个人签名不可以为空',
                                style: 'background-color:#09C1FF; color:#fff; border:none;',
                                time: 2
                            });
                       }
                       
                   }
                   function no(){
                       location.href= "my.php";
                   }
                </script>
                <div id="img_show">
                    <?php if(!empty ($img_info)){ ?>
                        <div id="img_show" style="text-align: center;" >
                            <img src=".<?php echo $img_info['img_url'];?>"/>
                        </div>
                    <?php }else{
                        echo "<div style='text-align: center; margin-top: 200px; font-size: 40px;'>暂时没有模板</div>";
                    } ?>

<!--                    <div id="optain_tpl_img" style="float: left; width: 375px; height: 667px;">
                        <div id="styleurl" style=" background-size:100%; height:667px;width: 375px; background-image: url(<?php echo $tpl_info['tpl_img_url'];?>);">
                            <div class="sname" style=" height: 20px; width: 150px; position: relative; top: <?php echo $tpl_info['store_name_seat']['1']?>; left: <?php echo $tpl_info['store_name_seat']['0']?>;"> 
                                <p id="store_name" class="<?php echo $tpl_info['font']?>"><?php echo $tpl_info['store_name']?></p>
                            </div>
                           <div class="uname" style="height: 20px; width: 150px; position: relative; top: <?php echo $tpl_info['proposer_seat']['1']?>; left: <?php echo $tpl_info['proposer_seat']['0']?>;"> 
                               <p id="autograph" class="<?php echo $tpl_info['font']?>">申请人签名</p>
                            </div>
                           <div class="otime" style="height: 20px; width: 150px; position: relative; top: <?php echo $tpl_info['validity_time_seat']['1']?>; left: <?php echo $tpl_info['validity_time_seat']['0']?>;"> 
                               <p id="validity_time" ><?php echo $tpl_info['validity_time'];?></p>
                            </div>
                        </div>
                    </div>-->
                </div>
                
            </div>
            

	</body>
</html>
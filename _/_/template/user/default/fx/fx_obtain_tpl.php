<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>我的批发商品 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
    <link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/goods.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>

    <script type="text/javascript" src="<?php echo TPL_URL;?>js/tpl.js"></script>
    <link href="<?php echo STATIC_URL;?>zt/zt.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/extension/css/hbconfig.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/tpl.css">

    <script>
        var img_url = "<?php dourl('fx_obtain_img'); ?>";
</script>
    
</head>
<body class="font14 usercenter">
<?php include display('public:header');?>
<div class="wrap_1000 clearfix container">
    <?php include display('sidebar');?>
    <div class="app">
        <div class="app-inner clearfix">
            <div class="app-init-container"></div>
                <div class="content">
                    <div class="filter-box">
                        <div class="js-list-search">
                            <nav class="ui-nav clearfix" >
                                <ul class="-left">
                                    <li class="active">
                                        <a href="#">证书获取</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div> 
                        <p style=" margin-left: 50px; font-size: 16px;">请输入姓名:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="obtain_val" type="text" name="" value=""/></p>
                        <div style=" margin-left: 25%; "><button style=" height: 30px; width: 80px;" onclick="make_tpl()">获取证书</button> </div>
                    </div>
                    <div style="border-bottom:1px dashed #000000; margin-top: 10px;"></div>
                    
                    <script>
                        function make_tpl(){
                            var obtain_val =  $('#obtain_val').val();
                            if(obtain_val == ''){
                                layer_tips(1, '签名不可以为空');
                            }else{
                                $.post(img_url, {'uname':obtain_val}, function(data){
                                    if(data == 1){
                                           layer_tips(1, '未查询供货商模板请联系供货商或管理员');
                                       }else if(data == 2){
                                           layer_tips(1, '生成图片失败请重试');
                                       }else{
                                            var img_show = "<img src='"+data+"'/>"
                                            $('#img_show').html(img_show);
                                       }
                           
                           
                                    
                                });
                                $('#autograph').html(obtain_val);
                            }
                        }
                    </script>
                    <div id="img_show" style="text-align: center;" >
                        <?php if(!empty ($info)){ ?>
                            <img src="<?php echo $info['img_url'];?>"/>
                        <?php }else{ ?>
                            <div style='text-align: center; margin-top: 200px; font-size: 40px;'>暂时没有模板</div>
                        <?php } ?>
                    </div>
                </div>
        </div>
    </div>
</div>
                    
<?php include display('public:footer');?>
<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
</body>
</html>
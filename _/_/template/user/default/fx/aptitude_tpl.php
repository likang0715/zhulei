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
    <script>
        var delete_url="<?php dourl('aptitude_tpl_delete');?>";
        var edit_url="<?php dourl('aptitude_tpl_edit');?>";
        var url = "<?php dourl('aptitude_tpl_add'); ?>";
        var edit_url_data = "<?php dourl('aptitude_tpl_edit_data'); ?>";
        var up_status_url = "<?php dourl('up_status'); ?>";
        var object_url = "<?php dourl('object_info'); ?>";
        var degree_url = "<?php dourl('fx_degree_data'); ?>";
        var ajax_uploadImg = "<?php dourl('ajax_uploadImg'); ?>";
        
    </script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/tpl.js"></script>
    <link href="<?php echo STATIC_URL;?>zt/zt.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/extension/css/hbconfig.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/tpl.css">
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
                                        <a href="#">分销资质证书模板</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div style=" height: 40px;">
                        <p><span style=" font-size: 16px;">&nbsp;荣誉证书管理</span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php dourl('aptitude_tpl'); ?>">新增</a></p>
                    </div>
                    <table class="ui-table ui-table-list" style="padding: 0px;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">序号</th>
                                <th style="text-align:center;">模板标题</th>
                                <th style="text-align:center;">适用对象</th>
                                <th style="text-align:center;">状态</th>
                                <th style="text-align:center;">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($aptitudeTplList as $k=>$v){ ?>
                                <tr class="">
                                    <td style="text-align:center;"><?php echo $v['tpl_id'];?></td>
                                    <td style="text-align:center;"><?php echo $v['tpl_name'];?></td>
                                    <td style="text-align:center;"><?php if($v['object'] == 1){ echo '<span style="color:#D9B300;">经销商</span>';}else{echo '<span style="color:#F75000;">分销商</span>';}  echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$v['degree_name'];?></td>
                                    <td style="text-align:center;"><?php if($v['status'] == 2){ ?> 
                                        
                                        <a href="#" onclick="up_status(<?php echo $v['tpl_id'];?>,<?php echo $v['status'];?>,<?php echo $v['object'];?>,<?php echo $v['degree_id'];?>)" style='color:red;'>禁止</a>
                                        
                                        <?php }  else { ?>
                                        
                                        <a href="#" onclick="up_status(<?php echo $v['tpl_id'];?>,<?php echo $v['status'];?>,<?php echo $v['object'];?>,<?php echo $v['degree_id'];?>)"  style='color:#00DD00;'>启用</a>
                                        
                                            <?php } ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <a target="_blank" href="<?php dourl('preview'); ?>&id=<?php echo $v['tpl_id'];?>">预览</a>
                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <a href="#" onclick="editTpl(<?php echo $v['tpl_id'];?>)">编辑</a>
                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <a href="#" onclick="deleteTpl(<?php echo $v['tpl_id'];?>,<?php echo $v['status'];?>)">删除</a></td>
                                </tr>
                            <?php }?>
                            
                        <script>
                            function up_status(tpl_id,status,object,degree_id){
                                $.post(up_status_url,{'tpl_id':tpl_id,'status':status,'object':object,'degree_id':degree_id},function(data){
                                    if(data.err_code == 1001){
                                        layer_tips(1, data.err_msg);
                                        var t=setTimeout(
                                        'location.href= "<?php dourl('aptitude_tpl');?>"'
                                        ,1000)
                                    }else{
                                        layer_tips(1, data.err_msg);
                                    }
                                })
                            }
                            
                            function deleteTpl(tpl_id,status){
                                if(status == 2){
                                    $.post(delete_url, {'tpl_id':tpl_id}, function(data){
                                        if(data.err_code == 1001){
                                            layer_tips(1, data.err_msg);
                                            var t=setTimeout(
                                            'location.href= "<?php dourl('aptitude_tpl');?>"'
                                            ,1000)
                                        }
                                    },'json')
                                }else{
                                    layer_tips(1,'删除前请先修改状态');
                                }
                                
                            }
                            function editTpl(tpl_id){
                                
                                $.post(edit_url, {'tpl_id':tpl_id}, function(data){

                                    $('#tpl_name').val(data.tpl_name);
                                    $('#object').val(data.object);
                                    $('#validity_time').val(data.validity_time);
                                    $('#font').val(data.font);
                                    $('#status').val(data.status);
                                    if(data.object == 2){
                                        $('#degree').val(data.degree_id);
                                        document.getElementById("degree").style.display="";
                                    }else{
                                        document.getElementById("degree").style.display="none";
                                    }
                                    
                                    if(data.status == 1){
                                        $("#status_show").addClass("cok");
                                        $("#status_hidden").removeClass("cok");
                                    }else{
                                        
                                            $("#status_hidden").addClass("cok");
                                            $("#status_show").removeClass("cok");
                                    }
                                    
                                    $('#div1').css('left',data.store_name_seat['0']);
                                    $('#div1').css('top',data.store_name_seat['1']);
                                    $('#div2').css('left',data.proposer_seat['0']);
                                    $('#div2').css('top',data.proposer_seat['1']);
                                    $('#div3').css('left',data.validity_time_seat['0']);
                                    $('#div3').css('top',data.validity_time_seat['1']);
                                    var styleurl = data.tpl_img_url;
                                    document.getElementById("styleurl").style.backgroundImage="url("+styleurl+")";
                                    $('#tpl_id').val(data.tpl_id);
                                    
                                    
                                    
                                    $('#b_img').val(data.tpl_img_url);
                                                                
                                },'json')
                                $('#etpl_id').val(tpl_id);
                            }
                            function showTpl(tpl_id){
                                
                            }
                        </script>
                        </tbody>
                    </table>      
                        <div class="gameConfig">
                            <div id="itemCtrlBox">
                                <div class="gBd clearfix">
                                    <div class="leftPhonewrap">
                                       <div class="styletpl" id="styleurl" style="background-image: url(<?php echo TPL_URL;?>images/sq.png);">
                                            <input type="hidden" id="b_img" value="<?php echo TPL_URL;?>images/sq.png"/>
                                            <div id="div1" class="sname" style=" top: 295px; left: 130px;" onmousedown="mouseDown(this,event)" onmousemove="mouseMove(event)" onmouseup="mouseUp(event)"> 
                                                <p style=" font-size: 20px; ">店铺名称</p>
                                            </div> 
                                           <div id="div2" class="uname" style="top: 480px; left: 230px;" onmousedown="mouseDown2(this,event)" onmousemove="mouseMove2(event)" onmouseup="mouseUp2(event)"> 
                                               <p style="font-size: 15px;">个人签名</p>
                                            </div> 
                                           <div id="div3" class="otime" style="top: 510px; left: 230px;" onmousedown="mouseDown3(this,event)" onmousemove="mouseMove3(event)" onmouseup="mouseUp3(event)"> 
                                               <p style="font-size: 15px;">有效期日期</p>
                                            </div> 
                                       </div>
                                    </div>

                                    <!--右侧设置表单-->
                                    <div class="rightForm">
                                        <!--表单切换主体-->
                                        <div class="bd">
                                            <div class="row">
                                                <div class="formRow"  style=" height: 60px;">
                                                    <span class="rowTitle ">
                                                        <a href="javascript:;" class="file">上传模板
                                                            <input id="upload_file" value=""  type="file">
                                                        </a>
                                                    </span>
                                                    <div class="putWrap">
                                                        <p class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  建议尺寸 375*667<br/>&nbsp;&nbsp;&nbsp;支持小于2MB格式为JPG、JPEG、PNG的图片</p>
                                                        
                                                        <input type="hidden" id="addImg" name="projectFirstImg" value="">
                                                    </div>
                                                    <br/>
                                                </div>
          
                                                    
                    
                                                <div class="formRow" id="actNamePut">
                                                    <span class="rowTitle"><i>*</i>模版标题：</span>
                                                    <div class="putWrap">
                                                        <input style="width:240px;"  placeholder="" type="text" id="tpl_name" name="tpl_name" value=""/>
                                                    </div>
                                                </div>
                                                <div class="formRow" id="actNamePut">
                                                    <span class="rowTitle"><i>*</i>适用对象：</span>
                                                        <select name="object" id="object" onchange="on_object(this.value)" style="width:100px;">
                                                            <option value="1">经销商</option>
                                                            <option value="2">分销商</option>
                                                        </select>
                                                    
                                                        <select name="object"  style="display: none; width: 160px;" id="degree" style="">
                                                        </select>
                                                </div>
                                                <script>
                                                    function on_object(val){
                                                        
                                                        if(val == 2){
                                                            $.post(degree_url, {}, function(data){
                                                                if(data == 1){
                                                                    var html = '<option value="0">默认等级</option>';
                                                                    $('#degree').html(html);
                                                                    document.getElementById("degree").style.display="";
                                                                    
                                                                }else{
                                                                    $('#degree').html(data);
                                                                    document.getElementById("degree").style.display="";
                                                                }
                                                                
                                                            })
                                                            
//                                                            $.post(object_url, data, callback, type)
                                                        }
                                                        if(val == 1){
                                                            document.getElementById("degree").style.display="none";
                                                        }
                                                    }
                                                </script>
                                                <div class="formRow" id="actNamePut">
                                                    <span class="rowTitle"><i>*</i>有效期：</span>
                                                    <input style="width:120px;"  placeholder="" type="text" id="validity_time" name="validity_time" value=""/>&nbsp;&nbsp;<span style=" font-size: 18px;">月</span>
                                                </div>
                                                
                                                  
                                                <div class="formRow" id="actNamePut">
                                                    <span class="rowTitle"><i>*</i>字体：</span>
                                                    <div class="putWrap">
                                                        <select name="font" id="font" style="width:150px;">
                                                            <option value="pzhgbzt">庞中华钢笔字体</option>
                                                            <option value="ybxs">硬笔行书</option>
                                                            <option value="ygyjfcs">叶根友疾风草书</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="rowTitle"><i>*</i>状态：</span>
                                                    <div style="margin-top: 5px;" class="cssRadio time_switcher">
                                                            <label class="yok" id="status_show" for="start_time_show">启用</label>
                                                            <label class="yok cok" id="status_hidden" >禁止</label>
                                                            <input type="hidden" name="status" id="status" value="2"/>
                                                        </div>
                                                </div>
                                                <br/>
                                                <div class="formRow">
                                                    <span class="rowTitle "></span>
                                                    <div class="putWrap">
<!--                                                        <input type="hidden" value="<?php echo $promote['pigcms_id'];?>" class="promote-id">-->
                                                        <input type="hidden"  id="tpl_id" value=""/>
                                                        <div class="ui-btn ui-btn-primary btnGreen" onclick="submit()"  >保存</div>
                                                    
                                                        <script>
                                                            $('#status_show').click(function(){
                                                                $("#status_show").addClass("cok");
                                                                 $("#status_hidden").removeClass("cok");
                                                                $('#status').val(1);
                                                            })
                                                            $('#status_hidden').click(function(){
                                                                $("#status_hidden").addClass("cok");
                                                                 $("#status_show").removeClass("cok");
                                                                $('#status').val(2);
                                                            })
                                                            
                                                            function submit(){
                                                                var tpl_name = $('#tpl_name').val();
                                                                var object = $('#object').val();
                                                                
                                                                if(object ==2){
                                                                    var degree_id = $('#degree').val();
                                                                }
                                                              
                                                                var validity_time = $('#validity_time').val();
                                                                var font = $('#font').val();
                                                                var status = $('#status').val();
                                                                var store_name_seat = $('#div1').css('left')+','+$('#div1').css('top');
                                                                var proposer_seat = $('#div2').css('left')+','+$('#div2').css('top');
                                                                var validity_time_seat = $('#div3').css('left')+','+$('#div3').css('top');
                                                                var tpl_img_url = $('#b_img').val();
                                                                if(tpl_name ==''){
                                                                    layer_tips(1, '模版标题不能为空');
                                                                    $("input[name='tpl_name']").focus();
                                                                    return false;
                                                                }
                                                                if(validity_time ==''){
                                                                    layer_tips(1, '有效期不能为空');
                                                                    $("input[name='validity_time']").focus();
                                                                    return false;
                                                                }
                                                                
                                                                var tpl_id = $('#tpl_id').val();
                                                                if(tpl_id){
                                                                    $.post(edit_url_data,{
                                                                        'tpl_id' : tpl_id,
                                                                        'tpl_name' : tpl_name,
                                                                        'object': object,
                                                                        'validity_time': validity_time,
                                                                        'font': font,
                                                                        'status': status,
                                                                        'tpl_img_url': tpl_img_url,
                                                                        'store_name_seat': store_name_seat,
                                                                        'proposer_seat': proposer_seat,
                                                                        'validity_time_seat': validity_time_seat,
                                                                        'degree_id' : degree_id
                                                                    },function(data){
                                                                        if(data.err_code == 1001){
                                                                            layer_tips(1, data.err_msg);
                                                                            var t=setTimeout(
                                                                            'location.href= "<?php dourl('aptitude_tpl');?>"'
                                                                            ,1000)
                                                                        }else if(data.err_code == 1002){
                                                                            layer_tips(1, data.err_msg);
                                                                        }else if(data.err_code == 1003){
                                                                            layer_tips(1, data.err_msg);
                                                                        }

                                                                    })
                                                                }else{
                                                                    $.post(url,{
                                                                        'tpl_name' : tpl_name,
                                                                        'object': object,
                                                                        'validity_time': validity_time,
                                                                        'font': font,
                                                                        'status': status,
                                                                        'tpl_img_url': tpl_img_url,
                                                                        'store_name_seat': store_name_seat,
                                                                        'proposer_seat': proposer_seat,
                                                                        'validity_time_seat': validity_time_seat,
                                                                        'degree_id' : degree_id
                                                                    },function(data){
                                                                        if(data.err_code == 1001){
                                                                            layer_tips(1, data.err_msg);
                                                                            var t=setTimeout(
                                                                            'location.href= "<?php dourl('aptitude_tpl');?>"'
                                                                            ,1000)
                                                                        }else if(data.err_code == 1002){
                                                                            layer_tips(1, data.err_msg);
                                                                        }else if(data.err_code == 1003){
                                                                            layer_tips(1, data.err_msg);
                                                                        }

                                                                    })
                                                                }
                                                                
                                                            }
                                                        </script>
                                                        
                                                    </div>
                                                        <div>
                                                            <span  class="rowTitle" style=" height: 70px;"><i>*</i>备注：</span>
                                                            <div style=" margin-top: 15px; font-size: 15px;" >
                                                                <span>左侧模板中下列三个字段可拖动位置<br/>1. 申请资质店铺名称<br/>2. 申请人签名<br/>3. 有效期</span>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--表单切换主体-->
                                    </div>
                                    <!--右侧设置表单-->
                                </div>
                                <!--游戏设置主体-->
                            </div>
                        </div>
                </div>
        </div>
    </div>
</div>
                    
<?php include display('public:footer');?>
<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>分销店铺 - 团队管理</title>
    <link href="<?php echo TPL_URL;?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/style.css" rel="stylesheet">
</head>

<body>
<header class="header_title">
	<?php if($_COOKIE['wap_store_id']) {?>
		<a  href="./ucenter.php?id=<?php echo $_COOKIE['wap_store_id'];?>#promotion" onclicks="javascript:history.go(-1);"><i></i></a>
	<?php } else {?>
		<a  href="javascript:void(0)" onclicks="javascript:history.go(-1);"><i></i></a>
	<?php }?>	
    <p>团队管理</p>
</header>
<style>
    .userAvatar {
        width: 2.5rem;
        height: 2.5rem;
        overflow: hidden;
        border-radius: 100%;
    }
    .textInfo {
        font-size: .6rem;
        width: 69%;
        float: right;
        line-height: 18px;
        margin-top: 26px;
        margin-bottom: 19px;
        margin-right: -13px;
    }
    .addFile {
        opacity: 0;
        top: 16px;
        position: absolute;
        margin-left: 8px;
    }
    input {
        font-size: medium;
    }
    textarea {
        font-size: medium;
    }
    input,img{vertical-align:top;}

    .motify {
        text-align: center;
        position: fixed;
        top: 35%;
        left: 50%;
        width: 220px;
        padding: 5px;
        margin: 0 0 0 -110px;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        font-size: 14px;
        line-height: 1.5em;
        border-radius: 6px;
        -webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
    }
    .userTab>.bd .consumption-group .cell:nth-child(4n) {
        margin-bottom: .5rem;
    }
    .ucenter-tab {
        float: right;
        background-size: cover;
        margin-top: 0.1rem;
        margin-right: 19px;
        color:#f60;
    }
    .motify-inner {
        font-size: 12px;
    }
</style>
<article>
    <section>
        <form enctype="multipart/form-data" id="upload_image_form" method="post" action="./comment_attachment.php">
            <div class="team_manage clearfix">
                <div class="setInfo">
                    <div class="fl userAvatar">
                        <img style="width:2.5rem; height:2.5rem;" src="<?php echo !empty($drp_team) ? $drp_team['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg';?>"/>
                        <input class="addFile" name="file" type="<?php echo $store_info['drp_level']>1 ? '' : 'file'?>" id="upload_image" style="height:50px;width:50px"/>
                    </div>
                    <div class="team_manage_txt"><?php echo $store_info['drp_level']>1 ? '团队创建者才能修改' : '点击左边的图片修改logo'?></div>
                </div>
            </div>
        </form>
        <iframe name="iframe_upload_image" style="width:0px; height:0px; display:none;"></iframe>
        <div class="team_manage_list">
            <dl>
                <?php if($store_info['drp_level']>1) {?>
                <dd><span>团队名称</span>
                    <?php echo !empty($drp_team) ? $drp_team['name'] : $fx_one_info['name'];?>
                    <input style="display:none;" type="text" name="team_name" value="<?php echo !empty($drp_team) ? $drp_team['name'] : $fx_one_info['name'];?>" placeholder="请输入团队名称">
                </dd>
                <?php } else {?>
                    <dd><span>团队名称</span>
                        <input type="text" name="team_name" value="<?php echo !empty($drp_team) ? $drp_team['name'] : $fx_one_info['name'];?>" placeholder="请输入团队名称">
                    </dd>
                <?php }?>
                <dt>团队成员别称</dt>
                <dd><span>直属成员</span>
                    <input type="text" class="member-label" name="member_label[]" data-level="1" value='<?php echo !empty($team_lable[0]['name']) ? $team_lable[0]['name'] : '直属成员'?>' placeholder="请输入直属成员名称">
                </dd>
                <dd><span>二级成员</span>
                    <input type="text" class="member-label" name="member_label[]" data-level="2" value='<?php echo !empty($team_lable[1]['name']) ? $team_lable[1]['name'] : '下级成员'?>' placeholder="请输入二级成员名称">
                </dd>
                <dt>店铺设置</dt>
                <dd><span>微店名称</span>
                    <input type="text" name="store_name" value="<?php echo $store_info['name']?>" placeholder="请输入微店">
                </dd>
                <dd><span>店铺描述</span>
                    <textarea type="text" name="intro" placeholder=""><?php echo $store_info['intro']?></textarea>
                </dd>
            </dl>
            <div class="team_but">
                <input type="hidden" name="team_id" class="team_id" value="<?php echo !empty($drp_team['pigcms_id']) ? $drp_team['pigcms_id'] : ''; ?>" />
                <button id="button" type="txt">保存修改</button>
            </div>
        </div>
    </section>
</article>
</body>
<script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
<script src="<?php echo STATIC_URL;?>js/jquery.form.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>

</html>
<script type="text/javascript">
    $(function(){

        $('.userAvatar > img').click(function(e){
            $('#upload_image').trigger('click');
        });

        $("#upload_image").change(function () {
            $("#upload_image_form").submit();
        });

        $("#upload_image_form").ajaxForm({
            beforeSubmit: showRequestUpload,
            success: showResponseUpload,
            dataType: 'json'
        });


        $('#button').click(function(){
            var drpTeamId = '<?php echo $drp_team['pigcms_id']?>';
            var drpLevel = <?php echo $store_info['drp_level']?>;
            if((drpTeamId == '' && drpLevel == 1) || drpTeamId){
                var post_url = './drp_team.php?action=edit';
                var team_name = $('input[name="team_name"]').val();
                var store_name = $('input[name="store_name"]').val();
                var intro = $('textarea[name="intro"]').val();
                var logo = $('.userAvatar img').attr('src');
                var team_id = $('.team_id').val();
                var member_labels = [];

                $('.member-label').each(function(i) {
                    member_labels[$(this).data('level')] = $(this).val().trim();
                });

                $.post(post_url,{'team_name':team_name, 'team_id': team_id, 'logo': logo, 'member_labels':member_labels, 'store_name':store_name, 'intro':intro},function(data){
                    if(data.err_code == 0){
                        warning(data.err_msg);
                    }else{
                        warning(data.err_msg);
                    }
                });
            } else {
                warning('只有一级分销商才能创建团队');
            }
        });
    });


    function warning(msg) {
        $('.motify').remove();
        $('body').append('<div class="motify"><div class="motify-inner">'+ msg +'</div></div>');
        setTimeout(function () {
            $('.motify').remove();
        }, 3000);
    }

    function showRequestUpload() {
        return true;
    }

    function showResponseUpload(data) {
        var post_url = './drp_team.php?action=upload';
        if (data.err_code == "0") {
            $('.userAvatar img').attr('src',data.err_msg.file);
            $.post(post_url,{'logo':data.err_msg.file},function(data){
                if(data.err_code == 0){
                    warning(data.err_msg);
                }else{
                    warning("更新失败");
                }
            });

        } else if (data.err_code == "1000") {
            //
        } else if (data.err_code == "1002") {
            motify.log("上传失败");
        }
    }


    var motify = {
        timer:null,
        log:function(msg,time){
            $('.motify').hide();
            if(motify.timer) clearTimeout(motify.timer);
            if($('.motify').size() > 0){
                $('.motify').show().find('.motify-inner').html(msg);
            }else{
                $('body').append('<div class="motify" style="display:block;"><div class="motify-inner">'+msg+'</div></div>');
            }
            if(!time && time != 0) time=3000;
            if(time > 0){
                motify.timer = setTimeout(function(){
                    $('.motify').hide();
                },3000);
            }
        }
    };

</script>
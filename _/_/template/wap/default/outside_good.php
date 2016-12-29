<html class="no-js admin <?php if($_GET['ps']<=320){echo ' responsive-320';}elseif($_GET['ps']>=540){echo ' responsive-540';} if($_GET['ps']>540){echo ' responsive-800';} ?>" lang="zh-CN">
    <head>
        <meta charset="utf-8"/>
        <meta name="HandheldFriendly" content="true"/>
        <meta name="MobileOptimized" content="320"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta http-equiv="cleartype" content="on"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    </head>
    <body style="margin:0;padding:0">
        <iframe id="product" name="product" scrolling="0" src="<?php echo $product['buy_url']; ?>" style="margin:0;padding:0" width="100%" height="100%" frameborder="0" onload="iFrameHeight()"></iframe>
    </body>
</html>
<script type="text/javascript" language="javascript">
    function iFrameHeight() {
        var ifm= document.getElementById("product");
        var subWeb = document.frames ? document.frames["product"].document : ifm.contentDocument;
        if(ifm != null && subWeb != null) {
            ifm.height = subWeb.body.scrollHeight;
        }
    }
</script>
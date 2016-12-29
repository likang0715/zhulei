<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<title><?php echo $info['name'] ?></title>
<script type="text/javascript">
	var GID = "shuqian";
	var SCORE_LIMIT = 4000;
	var APP_LIST_URL = "<?php echo './yousetdiscount.php?action=index&store_id='.$info['store_id'].'&id='.$info['id']; ?>";
</script>

<script type="text/javascript" src="<?php echo TPL_URL;?>/yousetdiscount/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>/yousetdiscount/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>/yousetdiscount/js/createjs-2013.12.12.min.js"></script>
<style type="text/css">
html,body,canvas { margin: 0px; padding: 0px; border:none; text-align: center; background-color: black; }
canvas { background-color: white; }
</style>
</head>
<body>
<canvas id="stage">您的浏览器不支持html5, 请换用支持html5的浏览器。</canvas>

<script type="text/javascript">
function dp_share(){
	document.getElementById("share").style.display="";
}
</script>

<div id=share style="display: none">
	<img width=100% src="<?php echo TPL_URL ?>yousetdiscount/images/share-guide.png" style="position: fixed; z-index: 9999; top: 0; left: 0;background: rgba(0,0,0,0.7);" ontouchstart="document.getElementById('share').style.display='none';" />
</div>


<script type="text/javascript">
$(function(){
	$.ajax({
		type:"POST",
		url:"./yousetdiscount.php?action=iscount",
		dataType:"json",
		data:{
			id:'<?php echo $info["id"] ?>',
			share_key:'<?php echo $share_key ?>',
			uid:'<?php echo $wap_user["uid"] ?>'
		},
		success:function(data){
			if(data.error == 1){
				alert('次数已用完');
				window.location.href='./yousetdiscount.php?action=index&store_id='+$info['store_id']+'&id='+$info['id']+'&share_key='+$share_key;
			}
		}
	});
});
var myData = { gameid: "sq" };
function dp_submitScore(score){
	myData.score = score;
	myData.scoreName = "数了"+score+"分";
	if(score>0){
		var this_discount = roundFun(score,2);
		$.ajax({
			type:"POST",
			url:"<?php echo './yousetdiscount.php?action=todiscount' ?>",
			dataType:"json",
			data:{
				id:'<?php echo $info["id"] ?>',
				share_key:'<?php echo $share_key ?>',
				uid:'<?php echo $wap_user["uid"] ?>',
				this_discount:this_discount
			},
			success:function(data){
				if(data.error == 0){
					
				}
			}
		});
		dp_share();
		document.getElementById("share").style.display="none";

	}
}

</script>
<?php
$helps_sum = $helps_sum ? $helps_sum : 0;
if ($info['discount_type']==1) {
	$youhuizhi = $helps_sum.'分';
} else {
	$youhuizhi = (10 - $helps_sum) < $info['discount_min'] ? $info['discount_min'] : (10 - $helps_sum);
	$youhuizhi = $youhuizhi.'折';
}
?>
<?php include display('yousetdiscount_js_qipa_app'); ?>
<?php include display('yousetdiscount_js_qipa_stage'); ?>
<?php include display('yousetdiscount_js_main'); ?>
<?php
    if ($memberNotice == '' && $is_over == 0) {
        $shareData = _createShareData($YouSetDiscount, 'game', $user, $youhuizhi);
    } else {
        $shareData = _createShareData($YouSetDiscount, 'simple', $user, $youhuizhi);
    }
    echo $shareData;
?>
</body>
</html>
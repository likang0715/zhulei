<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $info['name'] ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/yousetdiscount/css/base.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/yousetdiscount/css/style.css">
    <script type="text/javascript" src="<?php echo TPL_URL;?>/yousetdiscount/js/jquery-2.1.1.min.js"></script>
	</head>
<body style="background:#000">

<a href="<?php echo './yousetdiscount.php?action=index&store_id='.$info['store_id'].'&id='.$info['id'].'&share_key='.$share_key ?>">
    <img src='<?php echo TPL_URL;?>/yousetdiscount/images/share-guide.png' style="width: 100%;height: 100%;">
</a>
<?php
    $helps_sum = $_GET['discount'] ? $_GET['discount'] : 0;
    if ($info['discount_type'] == 1) {
    	$youhuizhi = $helps_sum.'分';
    } else {
    	$youhuizhi = '下降'.$helps_sum.'折';
    }

    if ($memberNotice == '' && $is_over == 0) {
        $shareData = _createShareData($YouSetDiscount, 'fx', $user, $youhuizhi);
    } else {
        $shareData = _createShareData($YouSetDiscount, 'simple', $user, $youhuizhi);
    }

    echo $shareData;
?>
</body>
</html>
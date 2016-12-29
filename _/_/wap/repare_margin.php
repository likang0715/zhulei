<?php
require_once dirname(__FILE__) . '/global.php';

$store_id = (int)$_GET['store_id'];
$where['pigcms_id'] = array('>',0);
$where['store_id'] = $store_id;
$margin_list = D('Platform_margin_log')->where($where)->order('pigcms_id asc')->select();
if(!$margin_list){
	exit('没有找到记录');
}


foreach($margin_list as $key => $item){
	if(!isset($margin_list[$key+1])){
		break;
	}
	$current = D('Platform_margin_log')->where(array('pigcms_id'=>$item['pigcms_id']))->find();
	$next = D('Platform_margin_log')->where(array('pigcms_id'=>$margin_list[$key+1]['pigcms_id']))->find();

	if($current['status'] == 2){		// 已处理情况：增加金额
		D('Platform_margin_log')->where(array('pigcms_id'=>$next['pigcms_id']))->data('margin_balance='.bcadd($current['margin_balance'], $current['amount'],2))->save();
		$str = '更新'.$next['pigcms_id'].'的margin_balance为：'.bcadd($current['margin_balance'], $current['amount'],2);
		$str .= '              前一个margin_balance为:'.$current['margin_balance'].'      amount为'.$current['amount'].'和为：'.bcadd($current['margin_balance'], $current['amount'],2).'<br>';
		echo $str;
	}else{								// 未处理情况：同步金额，不计算、不增加
		D('Platform_margin_log')->where(array('pigcms_id'=>$next['pigcms_id']))->data('margin_balance='.$current['margin_balance'])->save();
		echo '更新'.$next['pigcms_id'].'的margin_balance为：'.$current['margin_balance'].'<br>';
	}

	if($current['status'] == 2 && $current['type'] == 0){
		D('Platform_margin_log')->where(array('pigcms_id'=>$next['pigcms_id']))->data('margin_total='.bcadd($current['margin_total'], $current['amount']),2)->save();
	}else{
		D('Platform_margin_log')->where(array('pigcms_id'=>$next['pigcms_id']))->data('margin_total='.$current['margin_total'])->save();
	}
}

echo '处理完成'.date('Y-m-d H:i:s');

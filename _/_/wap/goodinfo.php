<?php
/** 
 *  商品信息
 */
require_once dirname(__FILE__).'/global.php';

$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();

//关注折扣判断
$follow = M('Store')->is_subscribe_store($wap_user['uid'],$_POST['store_id']);

if(IS_POST){

	$action = isset($_POST['action']) ? $_POST['action'] : 'getSku';
	switch($action){
		case 'getSku':
			$store_id = isset($_POST['store_id']) ? intval($_POST['store_id']) : json_return(1000,'缺少必要参数');
			$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : json_return(1000,'缺少必要参数');

//			店铺信息
			$now_store = D('Store')->field('drp_level')->where(array('store_id' => $store_id))->find();
//			商品信息
			$nowProduct = D('Product')->where(array('product_id'=>$product_id))->field('`product_id`,`name`,`buy_way`,`quantity`,`image`,`price`,`after_subscribe_discount`,`after_subscribe_price`,`sold_time`,`buyer_quota`,`buy_url`,`has_property`,`unified_price_setting`,`is_fx`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->find();

			if(empty($nowProduct)){
				json_return(1001,'商品不存在');
			}else if($nowProduct['buy_way'] == '0'){  //检测是否外部购买
				json_return(1002,$nowProduct['buy_url']);
			}else if($nowProduct['quantity'] == '0'){ //检测商品数量
				json_return(1003,'商品已经售完');
			}else if($nowProduct['sold_time'] > $_SERVER['REQUEST_TIME']){ //检测开售时间
				json_return(1004,'商品还未开始销售');
			}else if($nowProduct['sold_time'] > $_SERVER['REQUEST_TIME']){ //买家限购		---- 未写代码
				json_return(1005,'商品还未开始销售');
			}
			$nowProduct['image'] = getAttachmentUrl($nowProduct['image']);

			$returnArr['productInfo'] = $nowProduct;
			if($nowProduct['has_property']){
				//有商品属性
				$skuList = D('Product_sku')->field('`sku_id`,`properties`,`quantity`,`price`,`after_subscribe_price`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('product_id'=>$product_id,'quantity'=>array('!=','0')))->order('`sku_id` ASC')->select();
				
				//如果有库存信息并且有库存，则查库存关系表
				if(!empty($skuList)){
					$skuPriceArr = $skuPropertyArr = array();
					foreach($skuList as $i => $value){
						if (!empty($nowProduct['unified_price_setting']) && !empty($nowProduct['is_fx'])) { //分销商的价格
							$value['price'] = ($value['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price'] > 0) ? $value['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price'] : $value['price'];
							$skuList[$i] = $value;
						}
						if($nowProduct['after_subscribe_discount'] >= 1 && $nowProduct['after_subscribe_discount'] < 10 && !empty($follow)){
							$value['price'] = number_format(($value['price'] * $nowProduct['after_subscribe_discount'] / 10), 2, '.', '');
							$skuList[$i] = $value;
							$skuPriceArr[] = $value['price'];
							$skuPropertyArr[$value['properties']] = true;
						}else{
							$skuPriceArr[] = $value['price'];
							$skuPropertyArr[$value['properties']] = true;
						}
					}
					
					
					if(!empty($skuPriceArr)){
						$minPrice = min($skuPriceArr);
						$maxPrice = max($skuPriceArr);
					}else{
						json_return(1003,'商品已经售完');
					}
					$tmpPropertyList = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property'=>'ptp','Product_property'=>'pp'))->where("`ptp`.`product_id`='$product_id' AND `pp`.`pid`=`ptp`.`pid`")->order('`ptp`.`order_by` ASC')->select();
//					echo "<pre>";
//					print_r($tmpPropertyList);
//					exit;
					if(!empty($tmpPropertyList)){
						$tmpPropertyValueList = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`')->table(array('Product_to_property_value'=>'ptpv','Product_property_value'=>'ppv'))->where("`ptpv`.`product_id`='$product_id' AND `ppv`.`vid`=`ptpv`.`vid`")->order('`ptpv`.`pigcms_id` ASC')->select();
						if(!empty($tmpPropertyValueList)){
							foreach($tmpPropertyValueList as $value){
								$propertyValueList[$value['pid']][] = array(
									'vid'=>$value['vid'],
									'value'=>$value['value'],
								);
							}
							foreach($tmpPropertyList as $value){
								$newPropertyList[] = array(
									'pid'=>$value['pid'],
									'name'=>$value['name'],
									'values'=>$propertyValueList[$value['pid']],
								);
							}
							if(count($newPropertyList) == 1){
								foreach($newPropertyList[0]['values'] as $key=>$value){
									$tmpKey = $newPropertyList[0]['pid'].':'.$value['vid'];
									if(empty($skuPropertyArr[$tmpKey])){
										unset($newPropertyList[0]['values'][$key]);
									}
								}
							}
							
							$returnArr['skuList'] = $skuList;
							$returnArr['propertyList'] = $newPropertyList;
						}else{
							json_return(1008,'未找到商品的库存信息，无法购买');
						}
					}else{
						json_return(1007,'未找到商品的库存信息，无法购买');
					}
				}else{
					json_return(1006,'商品已经售完');
				}
			}
			if (!empty($nowProduct['unified_price_setting']) && !empty($nowProduct['is_fx'])) {
				$nowProduct['price'] = !empty($nowProduct['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price']) ? $nowProduct['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price'] : $nowProduct['price'];
			}

//			用户是否关注
			if($nowProduct['after_subscribe_discount'] >= 1 && !empty($follow)){
				$returnArr['productInfo']['minPrice'] = !empty($minPrice) ? $minPrice : number_format(($nowProduct['price'] * $nowProduct['after_subscribe_discount'] / 10), 2 , '.', '');
			}else{
				$returnArr['productInfo']['minPrice'] = !empty($minPrice) ? $minPrice : $nowProduct['price'];
			}

//			$returnArr['productInfo']['minPrice'] = !empty($minPrice) ? $minPrice : $nowProduct['price'];
			$returnArr['productInfo']['maxPrice'] = !empty($maxPrice) ? $maxPrice : 0;
			
			//自定义字段
			$returnArr['customFieldList'] = D('Product_custom_field')->field('`field_name`,`field_type`,`multi_rows`,`required`')->where(array('product_id'=>$product_id))->select();
//			返回productInfo、skuList、propertyList、customFieldList
			json_return(0,$returnArr);
			break;
	}
}else{
	
}
?>
<?php

/**
 * 关联商品数据模型
 * User: pigcms_21
 * Date: 2016/5/16
 * Time: 11:15
 */
class product_relation_model extends base_model {
	// 获取某个商品的关联商品
	public function getRelationProduct($product_id, $store_id = 0) {
		if (empty($product_id)) {
			return array();
		}
		
		$product_list = D('Product_relation as pr')->join('Product as p ON p.product_id = pr.relation_id')->where("pr.product_id = '" . $product_id . "' AND p.status = 1 AND p.quantity > 0")->field('p.*')->order('pr.sort asc')->select();
		
		foreach ($product_list as &$product) {
			if (empty($store_id)) {
				$store_id = $product['store_id'];
			}
			unset($product['info']);
			$product['image'] = getAttachmentUrl($product['image']);
			$product['wap_url'] = option('config.wap_site_url') . '/good.php?id=' . $product['product_id'] . '&store_id=' . $store_id;
			$product['pc_url'] = url_rewrite('goods:index', array('id' => $product['product_id']));
		}
		
		return $product_list;
	}
}

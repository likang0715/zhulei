<?php
/**
 * 
 * User: pigcms_16
 * Date: 2015/9/21
 * Time: 20:28
 */

class store_physical_quantity_model extends base_model{

	public function add ($data) {
		return $this->db->data($data)->add();
	}

	public function edit ($where, $data) {
		return $this->db->where($where)->data($data)->save();
	}

	public function get_list($where = ''){

		if (empty($where)) return array();
		$list = $this->db->where($where)->select();

		$data = array();
		foreach ($list as $key => $val) {
			$data[$val['physical_id']] = $val;
		}

		return $data;
	}

	/**
	 * [getQuantityByPid 根据product_id/sku_id获取门店=>库存]
	 * @param    string $where [sql条件]
	 * @return   [arr] [门店及库存数量]
	 * @Auther   pigcms_89
	 * @DateTime 2015-12-16T13:26:09+0800
	 */
	public function getQuantityByPid($where = ''){

		if (empty($where)) return array();
		$list = $this->db->where($where)->select();

		$data = array();
		foreach ($list as $key => $val) {
			$data[$val['physical_id']] = $val['quantity'];
		}

		return $data;
	}

	/**
	 * [getPhysicalByPid 根据product_id/sku_id获取门店数组]
	 * @param    string $where [sql条件]
	 * @return   [arr] [门店id数组]
	 * @Auther   pigcms_89
	 * @DateTime 2015-12-16T13:28:24+0800
	 */
	public function getPhysicalByPid($where = ''){
		if (empty($where)) return array();
		$list = $this->db->where($where)->select();

		$data = array();
		foreach ($list as $key => $val) {
			$data[] = $val['physical_id'];
		}

		return $data;
	}

	public function getProducts($where){
		$products = $this->db->where($where)->select();
		return $products;
	}

	/**
	 * [getPhysicalIds 判断某产品门店库存 足够的门店id数组]
	 * @param    [arr] $params['product_id'] 产品id
	 * @param    [arr] $params['sku_id'] sku_id
	 * @param    int $quantity 该产品的数量
	 * @return   [arr] 门店id数组
	 * @Auther   pigcms_89
	 * @DateTime 2015-12-16T13:33:18+0800
	 */
	public function getPhysicalIds($params, $quantity = 0){
		$where = '';
		foreach ($params as $field => $param) {
			$where .= " AND spq." . $field . " = " . "'" . $param . "'";
		}
		if ($quantity > 0) {
			$where .= " AND spq.quantity >= ".$quantity;
		}
		$ids = array();
		$list = $this->db->query("SELECT sp.name,spq.* FROM " . option('system.DB_PREFIX') . "store_physical_quantity spq, " . option('system.DB_PREFIX') . "store_physical sp WHERE spq.physical_id = sp.pigcms_id " . $where);
		foreach ($list as $val) {
			$ids[] = $val['physical_id'];
		}

        return $ids;
	}

	/**
	 * [checkInit 检测是否有门店库存记录，没有则加0库存记录]
	 * @param    [int] $store_id 店铺id
	 * @return   bool 无需添加则返回 false
	 * @Auther   pigcms_89
	 * @DateTime 2015-12-16T13:38:43+0800
	 */
	public function checkInit($store_id) {

		if (empty($store_id)) return true;

		$where['store_id'] = $store_id;
        $where['quantity'] = array('>', 0);
        $where['soldout'] = 0;
        $where['wholesale_product_id'] = 0;
        $products = M("Product")->getSelling($where, '', '', 0, 999);

        foreach ($products as $key => $value) {
            if (empty($value['has_property'])) {
				$where_spq[] = array(
						'store_id'=>$store_id,
						'product_id'=>$value['product_id'],
						'sku_id'=>0,
					);
                $products[$key]['sku'] = array();
                continue;
            } else {
                $sku_val = M("Product_sku")->getSkus($value['product_id']);
                foreach ($sku_val as $k => $v) {
	            	$where_spq[] = array(
							'store_id'=>$store_id,
							'product_id'=>$value['product_id'],
							'sku_id'=>$v['sku_id'],
						);
                }
            }

        }

		$physicals = M('Store_physical')->getList($store_id);
		if (empty($physicals)) {
			return false;
		}

        foreach ($physicals as $physical) {
        	foreach ($where_spq as $w_spq) {
        		$where_tmp = array_merge($w_spq, array("physical_id"=>$physical['pigcms_id']));
        		$result = D("Store_physical_quantity")->where($where_tmp)->find();
        		if (empty($result)) {
        			// $lack_data[] = $where_tmp;
        			D("Store_physical_quantity")->data($where_tmp)->add();
        		}

        	}
        }


	}

	/**
	 * [getStockProduct 获取门店库存商品列表]
	 * @param    [str/arr] $where sql条件
	 * @param    [str] $order_by_field [排序字段]
	 * @param    [str] $order_by_method [desc/asc]
	 * @param    [int] $store_id [店铺id]
	 * @return   [arr] [array('data'=>$products, 'page'=>$page)]
	 * @Auther   pigcms_89
	 * @DateTime 2015-12-16T13:40:44+0800
	 */
	public function getStockProduct($where, $order_by_field, $order_by_method, $store_id) {

		$product_total = M('Product')->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 15);

		$store_physical = D('Store_physical')->where(array('store_id'=>$store_id))->select();
		$products = M('Product')->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);

		$product_groups = M('Product_group')->get_all_list($store_id);

		foreach ($products as $key => $val) {

            if (!empty($store_physical)) {  
                $physical = $store_physical;
                foreach ($physical as $k => $v) {
                    $where_quantity = array(
                        'product_id'=>$val['product_id'], 
                        'sku_id'=>0,
                        'physical_id'=>$v['pigcms_id'],
                    );
                    $quantity = D('Store_physical_quantity')->where($where_quantity)->find();
                    $physical[$k]['quantity'] =  !empty($quantity) ? $quantity['quantity'] : 0;
                }
                $products[$key]['physical'] = $physical;
            }

            if (empty($val['has_property'])) {
                $products[$key]['sku'] = array();
                continue;
            }

            $val_sku = M('Product_sku')->getSkus($val['product_id']);

            foreach ($val_sku as $k => $v) {
                $sku_id = $v['sku_id'];

                $tmpPropertiesArr = explode(';', $v['properties']);
                $properties = $propertiesValue = $productProperties = array();
                foreach($tmpPropertiesArr as $v){
                    $tmpPro = explode(':',$v);
                    $properties[] = $tmpPro[0];
                    $propertiesValue[] = $tmpPro[1];
                }
                if(count($properties) == 1){
                    $findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid'=>$properties[0]))->select();
                    $findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`,`image`')->where(array('vid'=>$propertiesValue[0]))->select();
                }else{
                    $findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid'=>array('in',$properties)))->select();
                    $findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`,`image`')->where(array('vid'=>array('in',$propertiesValue)))->select();
                }
                foreach($findPropertiesArr as $v){
                    $propertiesArr[$v['pid']] = $v['name'];
                }
                foreach($findPropertiesValueArr as $v){
                    $propertiesValueArr[$v['vid']] = $v['value'];
                }
                foreach($properties as $kk=>$v){
                    $productProperties[] = array('pid'=>$v,'name'=>$propertiesArr[$v],'vid'=>$propertiesValue[$kk],'value'=>$propertiesValueArr[$propertiesValue[$kk]], 'image'=>getAttachmentUrl($findPropertiesValueArr[$kk]['image']));
                }

                $val_sku[$k]['_property'] = $productProperties;

                if (!empty($store_physical)) {  //加门店相关库存 TODO
                    $physical = $store_physical;
                    foreach ($physical as $_key => $_val) {
                        $where_quantity = array(
                            'product_id'=>$val['product_id'], 
                            'sku_id'=>$sku_id,
                            'physical_id'=>$_val['pigcms_id'],
                        );

                        $quantity = D('Store_physical_quantity')->where($where_quantity)->find();
                        $physical[$_key]['quantity'] = !empty($quantity) ? $quantity['quantity'] : 0;
                    }
                    $val_sku[$k]['physical'] = $physical;
                }

            }

            $products[$key]['sku'] = $val_sku;
        }

        return array('data'=>$products, 'page'=>$page);

	}

}
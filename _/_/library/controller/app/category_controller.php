<?php
class category_controller extends base_controller{
	public function index() {
		
	}
	
	// 所有产品分类
	public function get_category() {
		$cat_list = M('Product_category')->getAllCategory();
		
		foreach($cat_list as $key => $value){
			unset($cat_list[$key]['cat_fid']);
			unset($cat_list[$key]['cat_pc_pic']);
			unset($cat_list[$key]['cat_status']);
			unset($cat_list[$key]['cat_path']);
			unset($cat_list[$key]['cat_level']);
			unset($cat_list[$key]['filter_attr']);
			unset($cat_list[$key]['tag_str']);
			unset($cat_list[$key]['cat_parent_status']);
			
			if(empty($value['cat_list'])){
				unset($cat_list[$key]);
			} else {
				foreach ($value['cat_list'] as $key_son => $tmp) {
					unset($cat_list[$key]['cat_list'][$key_son]['cat_fid']);
					unset($cat_list[$key]['cat_list'][$key_son]['cat_pc_pic']);
					unset($cat_list[$key]['cat_list'][$key_son]['cat_status']);
					unset($cat_list[$key]['cat_list'][$key_son]['cat_path']);
					unset($cat_list[$key]['cat_list'][$key_son]['cat_level']);
					unset($cat_list[$key]['cat_list'][$key_son]['filter_attr']);
					unset($cat_list[$key]['cat_list'][$key_son]['tag_str']);
					unset($cat_list[$key]['cat_list'][$key_son]['cat_parent_status']);
				}
			}
		}
		
		$json_data = array();
		foreach ($cat_list as $tmp) {
			$json_data[] = $tmp;
		}
		
		json_return(0, $json_data);
	}
	
	// 分类的属性筛选
	public function property() {
		$cid = $_REQUEST['cid'];
		if (empty($cid)) {
			json_return(1000, '缺少参数');
		}
		
		// 顶级分类和子分类
		$product_category_model = M('Product_category');
		$category_detail = $product_category_model->getCategory($cid);
		
		$property_list = array();
		if (!empty($category_detail)) {
			$property_list = M('System_product_property')->getPropertyAndValue($category_detail['filter_attr']);
		}
		
		$json_data = array();
		if (is_array($property_list['property_list'])) {
			foreach ($property_list['property_list'] as $property) {
				unset($property['sort']);
				unset($property['status']);
				unset($property['property_type_id']);
				$property['property_value_list'] = $property_list['property_value_list'][$property['pid']];
				$json_data[] = $property;
			}
		}
		
		json_return(0, $json_data);
	}
}
?>
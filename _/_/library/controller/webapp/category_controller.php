<?php
class category_controller extends base_controller {
	// 所有分类列表
	public function index() {
		$product_category_list = M('Product_category')->getAllCategory('', true);
		
		$return = array();
		$return['product_category_list'] = $product_category_list;
		
		json_return(0, $return);
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
}
?>
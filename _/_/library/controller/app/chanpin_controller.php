<?php
class chanpin_controller extends base_controller{
public $arrays=array();
	public $config;
	public $_G;
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}
	public function index() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$store_id = $_REQUEST['store_id'];
		$keyword = $_REQUEST['keyword'];
	
		if($_REQUEST['orderby']){
		$orderby=$_REQUEST['orderby'].' DESC ';
		}else{
		$orderby='is_recommend DESC, product_id DESC';
		}
		
		
	    $product_model = D('Product');
		$where = array();
		
		//店铺资料
		if($store_id){
		$store = M('Store')->getStore($store_id, true);
		
		
		$supplier_id = $store_id;
		if (!empty($store['top_supplier_id']) && empty($store['drp_diy_store'])) {
			$supplier_id = $store['top_supplier_id'];
		}
		$where['store_id'] = $supplier_id;
		}
		
		$where['is_recommend'] = 1;
		$where['status'] = 1;
		$where['uid'] = 5;
		$where['category_id'] = array('<>', 193);
		$where['quantity'] = array('>', 0);
		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}
		
		// 如果是分销店铺，只能搜索供货商已分销的产品
		if ($store['top_supplier_id']) {
			$where['is_fx'] = 1;
		}
		$count = $product_model->where($where)->count('product_id');
		
		
		// 定义返回数据
		$json_return = array();
		$json_return['count'] = $count;
		$json_return['next_page'] = true;
		if ($offset >= $count) {
			$json_return['product_list'] = array();
			$json_return['next_page'] = false;
		} else {
			if ($count > 0) {
			
			
				$product_list = $product_model->where($where)->field('product_id, store_id, name, quantity, price, original_price, weight, image2 as image, intro, is_recommend, sales, recommend_title, drp_level_2_price, drp_level_3_price')->order($orderby)->limit(10)->select();

				foreach ($product_list as &$product) {
					$product['image'] = getAttachmentUrl($product['image']);
					
					$drp_level = 0;
					if ($supplier_id != $store_id) {
						if ($store['drp_level'] >= 3) {
							$drp_level = 3;
						} else {
							$drp_level = $store['drp_level'];
						}
					}
					
					if ($product['is_fx'] && $supplier_id != $store_id && $drp_level > 0) {
						$product['price'] = !empty($product['drp_level_' . $drp_level . '_price']) ? $product['drp_level_' . $drp_level . '_price'] : $product['price'];
					}
					
					if ($product['original_price'] && $product['original_price'] < $product['price']) {
						$product['original_price'] = $product['price'];
					}
					
					$product['intro'] = mb_substr($product['intro'], 0, 50, 'utf-8');
					//$product['url'] = url('goods:index', array('product_id' => $product['product_id'], 'store_id' => $store_id));
					unset($product['drp_level_1_price']);
					unset($product['drp_level_2_price']);
					unset($product['drp_level_3_price']);
				}
				
				$json_return['product_list'] = $product_list;
				if (count($product_list) < $limit) {
					$json_return['next_page'] = false;
				}
			}
		}
		$productlist=array();
		
		
		foreach ($product_list as $key=>$r) {

		   $productlist[$key]['product_id']=$r['product_id'];
		   $productlist[$key]['name']=$r['name'];
	      $productlist[$key]['image']=$r['image'];
	      $productlist[$key]['price']=$r['price'];
          $productlist[$key]['original_price']=$r['original_price'];
		 $productlist[$key]['is_recommend']=$r['is_recommend']; 
		   $productlist[$key]['recommend_title']=$r['recommend_title'];
		
		  
	     }
		 $count=count($productlist);
		
		 
		 for($i=0;$i<$count;$i++){
		 
		 $p[$i]['r']	=  1;
		 $p[$i]['data1']	=  $productlist[$i] ? $productlist[$i] : array();
	
		 }
		

		$hots = D('Search_hot')->field('name')->where(array('cat_type'=>3))->order('`sort` DESC,`id` ASC')->select();	 
    		
		 $hot['name']='关键词';
		 $hot['data']=$hots ? $hots : array();
		 $hot['key']='keyword';
		
		 
		 $p[$i]['r']	=  2;
		 $p[$i]['data2']	=  $hot ? $hot : array();
	   
	
		 $i++;
		
		 
		 
		 $slide 	= M('Adver')->get_adver_by_key('app_tea',5);
      	 foreach($slide as $key=>$r){
		 $ad[$key]['name']	=  $r['name'];
		 $ad[$key]['pic']	=  $r['pic'];
		 $ad[$key]['url']	=  $r['url'];
		 $ad[$key]['content']	=  $r['description']?$r['description']:'';
		 }
		 
		 $count=count($slide);

		 $p[$i]['r']	=  3;
		 $p[$i]['data3']	=  $slide ? $slide : array();
	   
		
		 $i++;

		 $goodslist=$this->goodslist();
		 
		  $count=count($goodslist);
		 $v=$i+$count;
		  $x=0;
		 for($i;$i<$v;$i++){
		 
		 $p[$i]['r']	=  4;
		 $p[$i]['data4']	=  $goodslist[$x] ? $goodslist[$x] : array();
	    $x++;
		 }
		 
		
		 

	$results['data'] = $p;

	exit(json_encode($results));
	}
	
	// 单店铺里的搜索
	public function goods_list() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$store_id = $_REQUEST['store_id'];
		$keyword = $_REQUEST['keyword'];
		$page = max(1, $_REQUEST['page']);
		$limit = 10;
		if($_REQUEST['orderby']){
		$orderby=$_REQUEST['orderby'].' DESC ';
		}else{
		$orderby='is_recommend DESC, product_id DESC';
		}
		
		
	    $product_model = D('Product');
		$where = array();
		
		//店铺资料
		if($store_id){
		$store = M('Store')->getStore($store_id, true);
		
		
		$supplier_id = $store_id;
		if (!empty($store['top_supplier_id']) && empty($store['drp_diy_store'])) {
			$supplier_id = $store['top_supplier_id'];
		}
		$where['store_id'] = $supplier_id;
		}
		$where['uid'] = 5;
		$where['is_recommend'] = 0;
		$where['status'] = 1;
		$where['category_id'] = array('<>', 193);
		$where['quantity'] = array('>', 0);
		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}
		
		// 如果是分销店铺，只能搜索供货商已分销的产品
		if ($store['top_supplier_id']) {
			$where['is_fx'] = 1;
		}
		$count = $product_model->where($where)->count('product_id');
		
		$pages = '';
		$total_pages = ceil($count / $limit);
		
		$page = min($page, $total_pages);
		
		$offset = ($page - 1) * $limit;
		// 定义返回数据
		$json_return = array();
		$json_return['count'] = $count;
		$json_return['next_page'] = true;
		if ($offset >= $count) {
			$json_return['product_list'] = array();
			$json_return['next_page'] = false;
		} else {
			if ($count > 0) {
			
			
				$product_list = $product_model->where($where)->field('product_id, store_id, name, quantity, price, original_price, weight, image2 as image, intro, is_recommend, sales, recommend_title, drp_level_2_price, drp_level_3_price')->order($orderby)->limit($offset . ',' . $limit)->select();

				foreach ($product_list as &$product) {
					$product['image'] = getAttachmentUrl($product['image']);
					
					$drp_level = 0;
					if ($supplier_id != $store_id) {
						if ($store['drp_level'] >= 3) {
							$drp_level = 3;
						} else {
							$drp_level = $store['drp_level'];
						}
					}
					
					if ($product['is_fx'] && $supplier_id != $store_id && $drp_level > 0) {
						$product['price'] = !empty($product['drp_level_' . $drp_level . '_price']) ? $product['drp_level_' . $drp_level . '_price'] : $product['price'];
					}
					
					if ($product['original_price'] && $product['original_price'] < $product['price']) {
						$product['original_price'] = $product['price'];
					}
					
					$product['intro'] = mb_substr($product['intro'], 0, 50, 'utf-8');
					//$product['url'] = url('goods:index', array('product_id' => $product['product_id'], 'store_id' => $store_id));
					unset($product['drp_level_1_price']);
					unset($product['drp_level_2_price']);
					unset($product['drp_level_3_price']);
				}
				
				$json_return['product_list'] = $product_list;
				if (count($product_list) < $limit) {
					$json_return['next_page'] = false;
				}
			}
		}
		$productlist=array();
		foreach ($product_list as $key=>$r) {
		   $productlist[$key]['product_id']=$r['product_id'];
		   $productlist[$key]['name']=$r['name'];
	      $productlist[$key]['image']=$r['image'];
	      $productlist[$key]['price']=$r['price'];
          $productlist[$key]['original_price']=$r['original_price'];
		 $productlist[$key]['is_recommend']=$r['is_recommend']; 
		   $productlist[$key]['recommend_title']=$r['recommend_title'];
		  
	     }
		 
		 
		 $count=count($productlist);
		
		
		 for($i=0;$i<$count;$i++){
		 
		 $p[$i]['r']	=  4;
		 $p[$i]['data4']	=  $productlist[$i];
	  
		 } 
		 
		 
	
	$results['data']=$p;
    $page_info['page_count'] =  (string)$total_pages;
	$page_info['page_index'] =  (string)$page;
	$results['page_info'] =  $page_info;
	exit(json_encode($results));
	}
	
	
	
	
	
	// 综合商城搜索
	public function search_product() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$key_id = $_REQUEST['catid'];
		$keyword = $_REQUEST['keyword'];
		$page = max($_REQUEST['page'], 1);
		$prop1 = $_REQUEST['prop1'];
		$prop2 = $_REQUEST['prop2'];
		if($prop1){
		$prop = $prop1;
		}
		if($prop2){
		$prop = $prop2;
		}
		if($prop1 && $prop2){
		$prop = $prop1.'_'.$prop2;
		}
		if($_REQUEST['price']){
		$price=explode('-',$_REQUEST['price']);
		$minprice=$price['0'];
		$maxprice=$price['1'];
		}
		// 筛选属性ID集合
		$prop_arr = array();
		if (!empty($prop)) {
			$prop_arr = explode('_', $prop);
		}
		
		// 查询属性条件
		$is_prop = false;
		$product_id_str = '';
		if (!empty($prop_arr)) {
			$product_id_str = M('System_product_to_property_value')->getProductIDByVid($prop_arr);
			$is_prop = true;
		}
		
		if($key_id){
			$now_category = D('Product_category')->field('`cat_id`,`cat_fid`')->where(array('cat_id' => $key_id))->find();
		}
		$condition['uid'] = 5;
		$condition['status'] = '1';
		$condition['supplier_id'] = '0'; //只出现供货商商品
		$condition['wholesale_product_id'] = '0';
		$condition['public_display'] = '1'; //只出现开启展示的商品
		$condition['quantity'] = array('!=','0');
		if($now_category){
			if($now_category['cat_fid']){
				$condition['category_id'] = $now_category['cat_id'];
			}else{
				$condition['category_fid'] = $now_category['cat_id'];
			}
		}else{
		
		$condition['category_id'] = array('<>', 193);
		}
		
		
		if($keyword){
			$condition['name'] = array('like','%'.$keyword.'%');
		}
		if($minprice){
			$condition['price'] = array('>=',$minprice);
		}
		if($maxprice){
			$condition['price'] = array('<=',$maxprice);
		}
		if($minprice && $maxprice){
		$condition['price'] = array(array('<=',$maxprice),array('>=',$minprice));
		
		}
		
		
		
		
		
		if ($is_prop && $product_id_str) {
			$product_id_arr = explode(',', $product_id_str);
			$condition['product_id'] = array('in', $product_id_arr);
		} 
		
	
		
		$count = D('Product')->where($condition)->count('product_id');
		
		$total_pages = ceil($count / 10);
		switch($_REQUEST['sort']) {
			case 'price_asc':
				$sort_by = '`price` ASC';
				break;
			case 'price_desc':
				$sort_by = '`price` DESC';
				break;
			case 'sale':
				$sort_by = '`sales` DESC';
				break;
			case 'pv':
				$sort_by = '`pv` DESC';
				break;
			default:
				$sort_by = '`product_id` DESC';
		}
		$product_list = D('Product')->field('`product_id`, `is_recommend`, `recommend_title`, `name`,`image` as image,`price`,`original_price`,`sales`')->where($condition)->order($sort_by)->limit((($page-1)*10).',10')->select();
		
		$productlist=array();
		foreach ($product_list as $key=>$r) {
		   $productlist[$key]['product_id']=$r['product_id'];
		   $productlist[$key]['name']=$r['name'];
	       $productlist[$key]['image']=getAttachmentUrl($r['image']);
	       $productlist[$key]['price']=$r['price'];
           $productlist[$key]['original_price']=$r['original_price'];
		   $productlist[$key]['is_recommend']=$r['is_recommend']; 
		   $productlist[$key]['recommend_title']=$r['recommend_title'];
		  
	     }
	
		
     	$count=count($productlist);
		$p=array();
		
		 for($i=0;$i<$count;$i++){
		 
		 $p[$i]['r']	=  4;
		 $p[$i]['data4']	=  $productlist[$i];
	  
		 } 
		 
		 
	
	$results['data']=$p;
	$page_info['page_count'] =  (string)$total_pages;;
	$page_info['page_index'] =  (string)$page;
	$results['page_info'] =  $page_info;
	exit(json_encode($results));	
		
	}
	
	
	
	
	
	
	
	
	private function goodslist() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		

		$orderby='product_id DESC';
		
		
	    $product_model = D('Product');
		$where = array();
		
		$where['uid'] = 5;
		$where['is_recommend'] = 0;
		$where['status'] = 1;
		$where['category_id'] = array('<>', 193);
		$where['quantity'] = array('>', 0);
		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}
		
		// 如果是分销店铺，只能搜索供货商已分销的产品
		if ($store['top_supplier_id']) {
			$where['is_fx'] = 1;
		}

		// 定义返回数据
		$json_return = array();
		$json_return['count'] = $count;
		$json_return['next_page'] = true;
	
	
			
			
				$product_list = $product_model->where($where)->field('product_id, store_id, name, quantity, price, original_price, weight, image2 as image, intro, is_recommend, sales, recommend_title, drp_level_2_price, drp_level_3_price')->order($orderby)->limit(10)->select();

				foreach ($product_list as &$product) {
					$product['image'] = getAttachmentUrl($product['image']);
					
					$drp_level = 0;
					if ($supplier_id != $store_id) {
						if ($store['drp_level'] >= 3) {
							$drp_level = 3;
						} else {
							$drp_level = $store['drp_level'];
						}
					}
					
					if ($product['is_fx'] && $supplier_id != $store_id && $drp_level > 0) {
						$product['price'] = !empty($product['drp_level_' . $drp_level . '_price']) ? $product['drp_level_' . $drp_level . '_price'] : $product['price'];
					}
					
					if ($product['original_price'] && $product['original_price'] < $product['price']) {
						$product['original_price'] = $product['price'];
					}
					
					$product['intro'] = mb_substr($product['intro'], 0, 50, 'utf-8');
					//$product['url'] = url('goods:index', array('product_id' => $product['product_id'], 'store_id' => $store_id));
					unset($product['drp_level_1_price']);
					unset($product['drp_level_2_price']);
					unset($product['drp_level_3_price']);
				}
				
				$json_return['product_list'] = $product_list;
				if (count($product_list) < $limit) {
					$json_return['next_page'] = false;
				}
		

		$productlist=array();
		foreach ($product_list as $key=>$r) {
		   $productlist[$key]['product_id']=$r['product_id'];
		   $productlist[$key]['name']=$r['name'];
	      $productlist[$key]['image']=$r['image'];
	      $productlist[$key]['price']=$r['price'];
          $productlist[$key]['original_price']=$r['original_price'];
		 $productlist[$key]['is_recommend']=$r['is_recommend']; 
		   $productlist[$key]['recommend_title']=$r['recommend_title'];
		  
	     }

	return $productlist;

	}
	
	


	
public function show() {
$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$product_id = $_REQUEST['id'];
		if (empty($product_id)) {
		     $results['result']='1';
			$results['msg']='product_id不正确';
			exit(json_encode($results));
		}
	    $nowProduct = D('Product')->where(array('product_id' => $product_id))->find();
		if (empty($nowProduct)) {
		     $results['result']='1';
			$results['msg']='product_id不正确';
			exit(json_encode($results));
		}
		$sql=" `s`.`store_id`,`s`.`name`,`sc`.`phone1`, `sc`.`phone2` ";
		$store_id = $nowProduct['store_id'];
		$where = "`sc`.`store_id`=`s`.`store_id` AND `s`.`store_id`='$store_id' ";
		$store = D('')->table(array('Store_contact'=>'sc', 'Store'=>'s'))->field($sql)->where($where)->find();
		$images = D('Product_image')->field('image')->where(array('product_id' => $product_id))->select();
		foreach($images as $key=>$r){
		$images[$key]['image']=getAttachmentUrl($r['image']);
		}
		$Product['product_id']=$nowProduct['product_id'];
		$Product['name']=$nowProduct['name'];
		$Product['images']=$images;
		$Product['price']=$nowProduct['price'];
		$Product['quantity']=$nowProduct['quantity'];
	    $Product['postage']=$nowProduct['postage'];    
		$Product['store_name']=$store['name'];
		$Product['phone1']=$store['phone1'];
		$Product['phone2']=$store['phone2'];
		$Product['store_id']=$store_id;
		$Product['content']=$this->config['wap_site_url'] . '/good_app.php?id=' . $nowProduct['product_id'];;
		$Product['comment']=$this->comment($product_id,'PRODUCT');
	
	
	
	
	
	
	$product=$nowProduct;
	
	$newPropertyList = array();
		if ($product['has_property']) {
		
			//库存信息
			$sku_list = D('Product_sku')->where(array('product_id' => $product_id))->order('`sku_id` ASC')->select();
			//如果有库存信息并且有库存，则查库存关系表
			if (!empty($sku_list)) {
				$sku_price_arr = $sku_property_arr = array();
				foreach ($sku_list as $value) {
					if (!empty($product['unified_price_setting']) && !empty($product['is_fx'])) { //分销商的价格
						$value['price'] = ($value['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] > 0) ? $value['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] : $value['price'];
					}
					
					if ($is_subscribe_store && $product['after_subscribe_discount'] > 0 && $product['after_subscribe_discount'] < 10) {
						$value['price'] = $value['price'] * $product['after_subscribe_discount'] / 10;
					}
					
					$sku_price_arr[] = $value['price'];
					$sku_property_arr[$value['properties']] = true;
				}
				if (!empty($sku_price_arr)) {
					$min_price = min($sku_price_arr);
					$max_price = max($sku_price_arr);
				} else {
					$product['quantity'] = 0;
				}
				$tmpPropertyList = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property' => 'ptp', 'Product_property' => 'pp'))->where("`ptp`.`product_id`='$product_id' AND `pp`.`pid`=`ptp`.`pid`")->order('`ptp`.`pigcms_id` ASC')->select();
				if (!empty($tmpPropertyList)) {
					$tmpPropertyValueList = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`,`ppv`.`image`')->table(array('Product_to_property_value' => 'ptpv', 'Product_property_value' => 'ppv'))->where("`ptpv`.`product_id`='$product_id' AND `ppv`.`vid`=`ptpv`.`vid`")->order('`ptpv`.`pigcms_id` ASC')->select();
					if (!empty($tmpPropertyValueList)) {
						foreach ($tmpPropertyValueList as $value) {
							$propertyValueList[$value['pid']][] = array(
									'vid' => $value['vid'],
									'value' => $value['value'],
									'image' => getAttachmentUrl($value['image']),
										);
						}
						foreach ($tmpPropertyList as $value) {
							$newPropertyList[] = array(
									'pid' => $value['pid'],
									'name' => $value['name'],
									'values' => $propertyValueList[$value['pid']],
							);
						}
						if (count($newPropertyList) == 1) {
							foreach ($newPropertyList[0]['values'] as $key => $value) {
								$tmpKey = $newPropertyList[0]['pid'] . ':' . $value['vid'];
								if (empty($sku_property_arr[$tmpKey])) {
									unset($newPropertyList[0]['values'][$key]);
								}
							}
						}
					}
				}
			}
	
		}
	
	
	
	    $Product['property']=$newPropertyList;
	   
	   $sku_list = D('Product_sku')->field('sku_id,price,quantity,properties')->where(array('product_id' => $product_id))->select();
	   
       $Product['sku_list']=$sku_list;
	    $share['logo']=getAttachmentUrl($nowProduct['image']);
		$share['name']=$nowProduct['name'];
		$share['url']=$this->config['wap_site_url'] . '/good.php?id=' . $nowProduct['product_id'];
		$share['info']=$nowProduct['recommend_title'] ? $nowProduct['recommend_title'] : $nowProduct['name'];
		
		
		$Product['share']=$share;
	
	
		  $results['data']=$Product;
			exit(json_encode($results)); 
	}
	
	
	
	
	
	
	public function search() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
        $sql=" `s`.`value` as name,`s`.`vid` as value ";
		$where = "`sc`.`pid`=`s`.`pid` AND `sc`.`name`='品牌' AND `sc`.`status`='1' ";
    $list =D('')->table(array('System_product_property'=>'sc', 'System_property_value'=>'s'))->field($sql)->where($where)->select();



   $category = D('Product_category')->field('`cat_id` as value,`cat_name` as name')->where(array('cat_status' => 1,'cat_fid' =>0 ))->order('cat_sort DESC,cat_id DESC')->select();
	
      $price[0]['name']='0-100元';
	  $price[0]['value']='0-100';
	  $price[1]['name']='100-300元';
	  $price[1]['value']='100-300';
	  $price[2]['name']='300-500元';
	  $price[2]['value']='300-500';
	  $price[3]['name']='500-1000元';
	  $price[3]['value']='500-1000';
	  $price[4]['name']='1000-2000元';
	  $price[4]['value']='1000-2000';
      $price[5]['name']='2000元以上';
	  $price[5]['value']='2000-1000000';

        $sql=" `s`.`value` as name,`s`.`vid` as value ";
		$where = "`sc`.`pid`=`s`.`pid` AND `sc`.`name`='用途' AND `sc`.`status`='1' ";
    $uses =D('')->table(array('System_product_property'=>'sc', 'System_property_value'=>'s'))->field($sql)->where($where)->select();
		
		$re['0']['name']='种类';
		$re['0']['data']=$category;
		$re['0']['key']='catid';
		$re['1']['name']='价格';
		$re['1']['data']=$price;
		$re['1']['key']='price';
		$re['2']['name']='品牌';
		$re['2']['data']=$list;
		$re['2']['key']='prop1';
		$re['3']['name']='用途';
		$re['3']['data']=$uses;
		$re['3']['key']='prop2';
		
	       $results['data']=$re;

	exit(json_encode($results));
    }
	

	
	private function comment($id,$type) {
	

		$page = 1;
		
				
		$where = array();
		$where['type'] = $type;
		$where['relation_id'] = $id;
		$where['status'] = 1;
		$where['delete_flg'] = 0;
		switch($tab) {
			case 'HAO' :
				$where['score'] = array('>=', 4);
				break;
			case 'ZHONG' :
				$where['score'] = 3;
				break;
			case 'CHA' :
				$where['score'] = array('<=', 2);
				break;
			case 'IMAGE' :
				$where['has_image'] = 1;
			default :
				break;
		}
			
		
		$comment_model = M('Comment');
		$count = $comment_model->getCount($where);
			
		$comment_list = array();
		$pages = '';
		$limit = 5;
		$total_page = ceil($count / $limit);
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$comment_list = $comment_model->getList($where, 'id desc', $limit, $offset, true);
		}
			
		$user_list = array();
		if ($comment_list['user_list']) {
			foreach ($comment_list['user_list'] as $key => $user) {
				$tmp = array();
				$tmp['nickname'] = anonymous($user['nickname']);
				$tmp['avatar'] = $user['avatar'];
				
				$user_list[$key] = $tmp;
			}
		}
		
		$list = array();
		if ($comment_list['comment_list']) {
			foreach ($comment_list['comment_list'] as $tmp) {
				$comment = array();
				$comment['content'] = htmlspecialchars($tmp['content']);
				$comment['score'] = $tmp['score'];
				$comment['date'] = date('Y-m-d', $tmp['dateline']);
				$comment['nickname'] = isset($user_list[$tmp['uid']]) ? $user_list[$tmp['uid']]['nickname'] : '匿名';
				$comment['avatar'] = isset($user_list[$tmp['uid']]) ? $user_list[$tmp['uid']]['avatar'] : getAttachmentUrl('images/touxiang.png', false);
				foreach ($tmp['attachment_list'] as &$r) {
				unset($r['id']);
				unset($r['cid']);
				unset($r['type']);
				unset($r['size']);
				unset($r['uid']);
				unset($r['width']);
				unset($r['height']);
				}
				$comment['price'] = $tmp['price'] ? $tmp['price'] : '';
				$comment['attachment_list'] = $tmp['attachment_list'];
				
				$list[] = $comment;
			}
		}
	
		
		return $list;
		
	}
	
	
}
?>
<?php
/**
 * 订单控制器
 */
class storegoods_controller extends base_controller{

	 /**
     * 出售中的商品列表
     */
    public function sell_goods_list() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');

        $order_by_field = isset($_POST['orderbyfield']) ? $_POST['orderbyfield'] : '';
        $order_by_method = isset($_POST['orderbymethod']) ? $_POST['orderbymethod'] : '';
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $group_id = isset($_POST['group_id']) ? trim($_POST['group_id']) : '';
		$page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
		
        $where = array();
        $where['store_id'] = $this->store_id;
        $where['quantity'] = array('>', 0);
        $where['soldout'] = 0;
        if ($keyword) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }
        if ($group_id) {
            $products = $product_to_group->getProducts($group_id);
            $product_ids = array();
            if (!empty($products)) {
                foreach ($products as $item) {
                    $product_ids[] = $item['product_id'];
                }
            }
            $where['product_id'] = array('in', $product_ids);
        }



        $count = $product->getSellingTotal($where);
        $pages=ceil($count / $limit);
		$offset=($page - 1) * $limit;
		$lists = $product->getSelling($where, $order_by_field, $order_by_method, $offset, $limit);
		$products=array();
		foreach($lists as $key=>$r){
		$products[$key]['product_id']=$r['product_id'];
	    $products[$key]['name']=$r['name'];
		$products[$key]['price']=$r['price'];
		$products[$key]['quantity']=$r['quantity'];
		$products[$key]['image']=$r['image'];
		$products[$key]['sales']=$r['sales'];
		$products[$key]['pv']=$r['pv'];
		}
	
		$results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$products;
		exit(json_encode($results));
		
    }

    /**
     * 已售罄的商品列表
     */
    public function over_goods_list() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');

        $order_by_field = isset($_POST['orderbyfield']) ? $_POST['orderbyfield'] : '';
        $order_by_method = isset($_POST['orderbymethod']) ? $_POST['orderbymethod'] : '';
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $group_id = isset($_POST['group_id']) ? trim($_POST['group_id']) : '';
        $page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
        
        $where = array();
        $where['store_id'] = $this->store_id;
        if ($keyword) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }
        if ($group_id) {
            $products = $product_to_group->getProducts($group_id);
            $product_ids = array();
            if (!empty($products)) {
                foreach ($products as $item) {
                    $product_ids[] = $item['product_id'];
                }
            }
            $where['product_id'] = array('in', $product_ids);
        }

        

        $count = $product->getStockoutTotal($where);
		$pages=ceil($count / $limit);
		$offset=($page - 1) * $limit;
        $lists = $product->getStockout($where, $order_by_field, $order_by_method, $offset, $limit);
		$products=array();
       foreach($lists as $key=>$r){
		$products[$key]['product_id']=$r['product_id'];
	    $products[$key]['name']=$r['name'];
		$products[$key]['price']=$r['price'];
		$products[$key]['quantity']=$r['quantity'];
		$products[$key]['image']=$r['image'];
		$products[$key]['sales']=$r['sales'];
		$products[$key]['pv']=$r['pv'];
		}
        
        $results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$products;
		exit(json_encode($results));
    }

    /**
     * 仓库中的商品
     */
    public function soldout_goods_list() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');

        $order_by_field = isset($_POST['orderbyfield']) ? $_POST['orderbyfield'] : '';
        $order_by_method = isset($_POST['orderbymethod']) ? $_POST['orderbymethod'] : '';
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $group_id = isset($_POST['group_id']) ? trim($_POST['group_id']) : '';
        $page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
        
        $where = array();
        $where['store_id'] = $this->store_id;
        if ($keyword) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }
        if ($group_id) {
            $products = $product_to_group->getProducts($group_id);
            $product_ids = array();
            if (!empty($products)) {
                foreach ($products as $item) {
                    $product_ids[] = $item['product_id'];
                }
            }
            $where['product_id'] = array('in', $product_ids);
        }

       
        $count = $product->getSoldoutTotal($where);
        
        
        $pages=ceil($count / $limit);
		$offset=($page - 1) * $limit;
        $lists = $product->getsoldout($where, $order_by_field, $order_by_method, $offset, $limit);
		$products=array();
       foreach($lists as $key=>$r){
		$products[$key]['product_id']=$r['product_id'];
	    $products[$key]['name']=$r['name'];
		$products[$key]['price']=$r['price'];
		$products[$key]['quantity']=$r['quantity'];
		$products[$key]['image']=$r['image'];
		$products[$key]['sales']=$r['sales'];
		$products[$key]['pv']=$r['pv'];
		}
        
        $results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$products;
		exit(json_encode($results));
    }

	
	

	
	// 商品下架
	public function soldout() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
            $product = M('Product');
            $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';

            if (!empty($product_id)) {//批量下架商品
                if(is_array($product_id))
                {
                    foreach ($product_id as $id) {
                        $product_info = D('Product')->field('product_id,is_fx,fx_type,source_product_id,wholesale_product_id')->where(array('product_id' => $id))->find();
                        if ($product->soldout($this->store_id, array($id))) {
                            if ($product_info['wholesale_product_id'] == 0) {
                                $this->_soldoutFxProduct($product_info['product_id']);
                            }
                        }
                    }
                }
                else //下架单个商品
                {
                    $product_info = $product->getOne($product_id);
                  $product->soldout($this->store_id, array($product_id));
                }

            
           
			
			$results['msg']='商品下架成功';
			exit(json_encode($results));
            } else {
                $results['result']='1';
				$results['msg']='商品下架失败';
				exit(json_encode($results));
            }
         
        
	}
	


	
	// 商品上架
	public function putaway() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		  $product = M('Product');
            $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : array();
	
           $where = array();
            $where ['store_id'] = $this->store_id;
            $where ['product_id'] =  $product_id;
		$result =  D('Product')->where($where)->data(array(
                'status' => 1
            ))->save();
			
            if ($result) {
            
				$results['msg']='商品上架成功';
				exit(json_encode($results));
            } else {
          
				 $results['result']='1';
				$results['msg']='商品上架失败';
				exit(json_encode($results));
            }
         
	}
	
	// 商品分组
	public function group() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	 $product_group = M('Product_group');
		 $product_groups = $product_group->get_all_list($this->store_id);
        
		
			$results['data']= $product_groups;
			exit(json_encode($results));
       
         
	}

}

<?php

class widget_controller extends base_controller {

    public function page() {
        if (0 && !empty($_SESSION['system'])) {
            $page_result = M('Wei_page')->getAllList(8);
            $this->assign('is_system', true);
        } else {
            $page_result = M('Wei_page')->get_list($this->store_session['store_id'], 8);
        }

        $this->assign('wei_pages', $page_result['page_list']);
        $this->assign('page', $page_result['page']);
        if (IS_POST) {
            $this->display('ajax_page');
        } else {
            $this->display();
        }
    }

    public function widget() {
        if (0 && !empty($_SESSION['system'])) {
            $wei_page_categories = M('Wei_page_category')->getAllList(8);
            $this->assign('is_system', true);
        } else {
            $wei_page_categories = M('Wei_page_category')->get_list($this->store_session['store_id'], 8);
        }
        $this->assign('wei_page_categories', $wei_page_categories['cat_list']);
        $this->assign('page', $wei_page_categories['page']);
        if (IS_POST) {
            $this->display('ajax_pagecat');
        } else {
            $this->display();
        }
    }

    public function good() {
        $product = M('Product');
        $where = array();
        $where['status'] = 1;
        $where['quantity'] = array('>', 0);
        /*if (!empty($_SESSION['system'])) {
            $this->assign('is_system', true);
        } else {*/
		$where['store_id'] = $this->store_session['store_id'];
        /*}*/
        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
        $product_total = $product->getSellingTotal($where);

        import('source.class.user_page');
        $page = new Page($product_total, 8);
        $products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);

        $this->assign('products', $products);
        $this->assign('page', $page->show());
        if ($_GET['type'] == 'more') {
            if (IS_POST) {
                $this->display('ajax_more_goods');
            } else {
                $this->display('more_goods');
            }
        } else {
            if (IS_POST) {
                $this->display('ajax_good');
            } else {
                $this->display();
            }
        }
    }

     /******yfz@20160621 茶会列表*******/
     public function chahui() {
        $chahui = D('Chahui');
        $where = array();
      //  $where['status'] = 1;
      //  $where['quantity'] = array('>', 0);
        /*if (!empty($_SESSION['system'])) {
            $this->assign('is_system', true);
        } else {*/
		$where['store_id'] = $this->store_session['store_id'];
        /*}*/
        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
		if (!empty($_REQUEST['zt'])) {
            $where['zt'] = $_REQUEST['zt'];
        }
        $chahui_total = $chahui->where($where)->count('pigcms_id');
        $p = max(1,(int)$_REQUEST['p']);
        import('source.class.user_page');
        $page = new Page($chahui_total, 8,$p);
     $chahui = $chahui->where($where)->order('`last_time` DESC')->limit($page->firstRow . ', ' . $page->listRows)->select();      foreach ($chahui as $key=>$tmp) {
           $chahui[$key]['images'] = getAttachmentUrl($tmp['images']);
        
        }

        $category = D('Chahui_category')->select();
	    $this->assign('category', $category);   
        $this->assign('chahui', $chahui);
		$this->assign('number', $_REQUEST['number']);
        $this->assign('page', $page->show());
        if ($_GET['type'] == 'more') {
            if (IS_POST) {
                $this->display('ajax_more_chahui');
            } else {
                $this->display('more_chahui');
            }
        } else {
            if (IS_POST) {
                $this->display('ajax_chahui');
            } else {
                $this->display();
            }
        }
    }

/******yfz@20160623 包厢列表*******/
     public function baoxiang() {
        $chahui = D('Meal_cz');
        $where = array();
      //  $where['status'] = 1;
      //  $where['quantity'] = array('>', 0);
        /*if (!empty($_SESSION['system'])) {
            $this->assign('is_system', true);
        } else {*/
		$where['seller_id'] = $this->store_session['store_id'];
        /*}*/
        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
		if (!empty($_REQUEST['seller_id'])) {
            $where['seller_id'] = $_REQUEST['seller_id'];
        }
        $chahui_total = $chahui->where($where)->count('cz_id');
        $p = max(1,(int)$_REQUEST['p']);
        import('source.class.user_page');
        $page = new Page($chahui_total, 8,$p);
     $baoxiang = $chahui->where($where)->order('`add_time` DESC')->limit($page->firstRow . ', ' . $page->listRows)->select();      foreach ($baoxiang as $key=>$tmp) {
           $baoxiang[$key]['image'] = getAttachmentUrl($tmp['image']);
        
        }

        $physical =  D('Store_physical')->where(array('store_id'=> $this->store_session['store_id']))->select();
	    $this->assign('physical', $physical);  
		 
        $this->assign('baoxiang', $baoxiang);
		$this->assign('number', $_REQUEST['number']);
        $this->assign('page', $page->show());
        if ($_GET['type'] == 'more') {
            if (IS_POST) {
                $this->display('ajax_more_baoxiang');
            } else {
                $this->display('more_baoxiang');
            }
        } else {
            if (IS_POST) {
                $this->display('ajax_baoxiang');
            } else {
                $this->display();
            }
        }
    }

    /**
	 * 店铺动态
    */
    function article_module(){
    	$keywords = trim($_POST['keyword']);
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		if($keywords){
			$where['title'] = array('like','%'.$keywords.'%');
		}
		$p = max(1,(int)$_REQUEST['p']);
		$res_count = D('Article')->field('count(*) as count')->where($where)->find();
		$count = $res_count['count'];
		$article_lists = array();
		if ($count > 0) {
			import('source.class.user_page');
			$page = new Page($count, 8,$p);
			$article_lists = D('Article')->where($where)->limit($page->firstRow . ', ' . $page->listRows)->order('status asc,id desc')->select();
			$this->assign('page', $page->show());
		}

		$this->assign('article_lists',$article_lists);
		$this->display('articles');
    }

    /**
     * 选择商铺的一件商品
     */
	public function select_one_good() {
        $product = M('Product');
        $product_image = M('Product_Image');

        $where = array();
        $where['status'] = 1;
        $where['quantity'] = array('>', 0);
        $where['store_id'] = $this->store_session['store_id'];
        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }

        $product_total = $product->getSellingTotal($where);

        import('source.class.user_page');
        $page = new Page($product_total, 8);
        $products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);

        foreach($products as $k=>$product){
            $imglogoarr = $product_image->getImages($product['product_id']);
            $products[$k]['logoimg1'] = '';$products[$k]['logoimg2'] = '';$products[$k]['logoimg3'] = '';
            for($i=1;$i<=count($imglogoarr);$i++){
                $products[$k]['logoimg'.$i] = $imglogoarr[$i-1]['image'];
            }
        }

        $this->assign('products', $products);
        $this->assign('page', $page->show());

        $this->display('select_one_good');
	}




	/**
	 * 活动调取：1:预售	 2：团购	 3：一元夺宝	 4：砍价	 5：秒杀 6:众筹 7:降价拍
	 */
	public function activity_module() {

		$huodong_type = $_GET['huodong_type'] ? $_GET['huodong_type'] : 'tuan';
		
		$this->assign('huodong_type',$huodong_type);
		switch($huodong_type) {
			//团购
			case 'tuan':
				$keyword = $_REQUEST['keyword'];
				$tuan = M('Tuan');
				
				$tuan_where = array();
				$tuan_where['status'] = 1;
				$tuan_where['delete_flg'] = 0;
				$tuan_where['store_id'] = $this->store_session['store_id'];
				$tuan_where['end_time'] = array('>',time());
				$tuan_where['start_time'] = array('<',time());
				if (!empty($keyword)) {
					$tuan_where['name'] = array('like', '%' . $keyword . '%');
				}
				
				$tuan_total = $tuan->getCount($tuan_where);
				
				$tuan_list = array();
				if ($tuan_total > 0) {
					import('source.class.user_page');
					$tuan_page = new Page($tuan_total, 8);
					
					$tuan_list = $tuan->getList($tuan_where, '', $tuan_page->listRows, $tuan_page->firstRow);
					$this->assign('tuan_page', $tuan_page->show());
				}
				$this->assign('tuans', $tuan_list);
				if ($_REQUEST['type'] == 'ajax') {
					$this->display('activity_tuan_more');
				} else {
					$this->display('activity_tuan');
				}
				break;
			//预售
			case 'presale':
				$keyword = $_REQUEST['keyword'];
				$presale = M('Presale');
				$presale_where = array();
				$presale_where['is_open'] = 1;
				$presale_where['endtime'] = array('>',time());
				$presale_where['starttime'] = array('<',time());
				$presale_where['store_id'] = $this->store_session['store_id'];
				if ($keyword) {
					$presale_where['name'] = array('like', '%' . $keyword . '%');
				}
				$presale_total = $presale->getCount($presale_where);
				
				$presale_list = array();
				if ($presale_total > 0) {
					import('source.class.user_page');
					
					$presale_page = new Page($presale_total, 8);
					$presale_list = $presale->getList($presale_where, $presale_page->listRows, $presale_page->firstRow);
	
					$this->assign('presale_page', $presale_page->show());
				}
				$this->assign('presales', $presale_list);
				
				if ($_REQUEST['type'] == 'ajax') {
					$this->display('activity_presale_ajax');
				} else {
					$this->display('activity_presale');
				}
				break;
			//砍价
			case 'bargain':
				$bargain = M('Bargain');
				$where[] = " b.delete_flag = 0 ";
				$where[] = " b.store_id = ".$this->store_session['store_id'];
				if(!empty($_REQUEST['keyword'])){
					$where[] = " b.name like '%" . $_REQUEST['keyword'] . "%'";
				}
				import('source.class.user_page');
				$where = implode(" AND ", $where);
				
				$counts = D('')-> table("Bargain b")->where($where)->field("count(pigcms_id) counts")->find();
				$bargain_total = $counts['counts'] ? $counts['counts'] : 0;
				
				$bargain_list = array();
				if ($counts > 0) {
					$bargain_page  = new Page($bargain_total, 8);
					
					$bargain_list = D('')-> table("Bargain b")->join("Product p On b.product_id=p.product_id","LEFT")
										 -> where($where)
										 -> field("b.*,p.name as product_name")
										 -> limit($bargain_page->firstRow.",".$bargain_page->listRows)
										 -> select();
					
					$this->assign('bargain_page', $bargain_page->show());
				}
				
				$this->assign('bargain_list', $bargain_list);
				
				if ($_REQUEST['type'] == 'ajax') {
					$this->display('activity_bargain_ajax');
				} else {
					$this->display('activity_bargain');
				}
				break;
			//一元夺宝
			case 'unitary':
				$keyword = $_REQUEST['keyword'];
				$unitary = M('Unitary');
				$unitary_where = array();
				$unitary_where['state'] = 1;
				$unitary_where['store_id'] = $this->store_session['store_id'];
				if ($keyword) {
					$unitary_where['name'] = array('like', '%' . $keyword . '%');
				}
				$unitary_total = $unitary->getCount($unitary_where);
				
				$unitary_list = array();
				if ($unitary_total > 0) {
					import('source.class.user_page');
					
					$unitary_page = new Page($unitary_total, 8);
					$unitary_list = $unitary->getList($unitary_where,'id desc',$unitary_page->listRows,$unitary_page->firstRow);
					$this->assign('unitary_page', $unitary_page->show());
				}
				$this->assign('unitarys', $unitary_list);
				
				if ($_REQUEST['type'] == 'ajax') {
					$this->display('activity_unitary_ajax');
				} else {
					$this->display('activity_unitary');
				}
				break;
			//秒杀
			case 'seckill':
				$keyword = $_REQUEST['keyword'];
				$seckill = M('Seckill');
				$seckill_where = array();
				$seckill_where['status'] = 1;
				$seckill_where['store_id'] = $this->store_session['store_id'];
				if ($keyword) {
					$seckill_where['name'] = array('like', '%' . $keyword . '%');
				}
				
				$seckill_total = $seckill->getCount($seckill_where);
				$seckill_list = array();
				if ($seckill_total > 0) {
					import('source.class.user_page');
					
					$seckill_page = new Page($seckill_total, 8);
					$seckill_list = $seckill->getList($seckill_where, 'pigcms_id desc', $seckill_page->listRows, $seckill_page->firstRow);
					$this->assign('seckill_page', $seckill_page->show());
				}
				$this->assign('seckills', $seckill_list);
				
				if ($_REQUEST['type'] == 'ajax') {
					$this->display('activity_seckill_ajax');
				} else {
					$this->display('activity_seckill');
				}
				
				break;
			
			// 众筹
			case 'zc' :
				$keyword = $_REQUEST['keyword'];
				$where = array();
				$where['store_id'] = $this->store_session['store_id'];
				$where['status'] = array('in', array(2, 4));
				if ($keyword) {
					$where['productName'] = array('like', '%' . $keyword . '%');
				}
				$count = D('Zc_product')->where($where)->count('product_id');
				
				$zc_product_list = array();
				if ($count > 0) {
					import('source.class.user_page');
					$page = new Page($count, 8);
					
					$zc_product_list = D('Zc_product')->where($where)->limit($page->firstRow . ', ' . $page->listRows)->order('product_id DESC')->select();
					$this->assign('page', $page->show());
				}
				
				$this->assign('zc_product_list', $zc_product_list);
				
				if ($_REQUEST['type'] == 'more') {
					$this->display('activity_zc_more');
				} else {
					$this->display('activity_zc');
				}
				break;
			// 降价拍
			case 'cutprice' :
				$keyword = $_REQUEST['keyword'];
				$where = array();
				$where['store_id'] = $this->store_session['store_id'];
				$where['state'] = 0;	// 正常的降价拍活动
				$where['endtime'] = array('>',time());
				$where['inventory'] = array('>',0);// 有库存的活动
				if ($keyword) {
					$where['active_name'] = array('like', '%' . $keyword . '%');
				}
				$count = D('Cutprice')->where($where)->select();
				$count = count($count);
				$active_cutprice_list = array();
				if ($count > 0) {
					import('source.class.user_page');
					$page = new Page($count, 8);
					$active_cutprice_list = D('Cutprice')->where($where)->limit($page->firstRow . ', ' . $page->listRows)->order('pigcms_id DESC')->select();
					$this->assign('page', $page->show());
				}
				if($active_cutprice_list){
					// 活动商品
					foreach($active_cutprice_list as $key => $item){
						$product = D('Product')->field('product_id,name')->where(array('product_id'=>$item['product_id']))->find();
						$active_cutprice_list[$key]['product'] = $product;
					}
				}
				
				$this->assign('active_cutprice_list', $active_cutprice_list);
				if ($_REQUEST['type'] == 'more') {
					$this->display('activity_cutprice_more');
				} else {
					$this->display('activity_cutprice');
				}
				break;
			}
	}

	
	/**
	 * //当前自营的商品
	 */
    public function do_selfgood() {
        $product = M('Product');
        $where = array();
        if (0 && !empty($_SESSION['system'])) {
            $this->assign('is_system', true);
        } else {
            $where['store_id'] = $this->store_session['store_id'];
        }

        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
        $where['supplier_id'] = '0';
        $where['quantity'] = array('>', 0);
        $where['soldout'] = 0;
        $product_total = $product->getSellingTotal($where);

        import('source.class.user_page');
        $page = new Page($product_total, 8);
        $products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);

        $this->assign('products', $products);
        $this->assign('page', $page->show());
        if ($_GET['type'] == 'more') {
            if (IS_POST) {
                $this->display('ajax_more_goods');
            } else {
                $this->display('more_self_goods');
            }
        } else {
            if (IS_POST) {
                $this->display('ajax_good');
            } else {
                $this->display();
            }
        }
    }
    

	//读取自营仓库中商品
	public function do_self_soldout_good() {
		$product = M('Product');
		$where = array();
		if (0 && !empty($_SESSION['system'])) {
			$this->assign('is_system', true);
		} else {
			$where['store_id'] = $this->store_session['store_id'];
		}

		if (!empty($_REQUEST['keyword'])) {
			$where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
		}
		$where['supplier_id'] = '0';
		$where['quantity'] = array('>', 0);
		$where['soldout'] = 0;
		$product_total = $product->getSoldoutTotal($where);

 		import('source.class.user_page');
		$page = new Page($product_total, 8);
		$products = $product->getSoldout($where, '', '', $page->firstRow, $page->listRows);

		$this->assign('products', $products);
		$this->assign('page', $page->show());
		if ($_GET['type'] == 'more') {
			if (IS_POST) {
				$this->display('ajax_more_soldout_goods1');
			} else {
				$this->display('more_soldout_good');
			}
		} else {
			if (IS_POST) {
				$this->display('ajax_good1');
			} else {
				$this->display(2);
		}
	}
}


	//自营商品 包含批发商品 显示 产品图片
	public function good_only_pic() {
		$product = M('Product');
		$product_image = M('Product_image');
		
		$where = array();
		if (!empty($_SESSION['system'])) {
			$this->assign('is_system', true);
		} else {
			$where['store_id'] = $this->store_session['store_id'];
		}
		$where['store_id'] = $this->store_session['store_id'];
		if (!empty($_REQUEST['keyword'])) {
			$where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
		}
		$where['_string'] = '(supplier_id = 0 or wholesale_product_id !=0)';
		$where['quantity'] = array('>', 0);
		$where['soldout'] = 0;
		$product_total = $product->getSellingTotal($where);
			
		import('source.class.user_page');
		$page = new Page($product_total, 7);
		$products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);
		
		foreach($products as $k=>&$v) {
			//商品图片
			$tmp_images = $product_image->getImages($v['product_id']);
			$images = array();
			foreach ($tmp_images as $k=>$tmp_image) {
				if($k>4) break;
				$images[] = array(
						'image' => getAttachmentUrl($tmp_image['image']),
				);
			}
			if(count($images)) $v['image_list'] = $images;
		}
		

		
		$this->assign('page', $page->show());
		$this->assign('products', $products);

		if (IS_POST) {
			$this->display('more_goods_onlypic_ajax');
		} else {
			$this->display('more_goods_onlypic');
		}
    }

    public function goodcat() {
        if (0 && !empty($_SESSION['system'])) {
            $product_groups = M('Product_group')->getAllList(8);
            $this->assign('is_system', true);
        } else {
            $product_groups = M('Product_group')->get_list($this->store_session['store_id'], 8);
        }

        $this->assign('product_groups', $product_groups['group_list']);
        $this->assign('page', $product_groups['page']);
        if (IS_POST) {
            $this->display('ajax_goodcat');
        }else{
            $this->display();
        }
    }

    /**
     *
     * 各分组下商品列表
     */
    public function productList(){

        $group_id = $_POST['group_id'];
        if(empty($group_id)){
            return false;
        }

        $product_groups = M('Product_group')->getProductList($group_id,$this->store_session['store_id']);

        $product_list = array();
        foreach($product_groups['product_list'] as $product){
            $product_list[] = array(
                'name' => $product['name'],
                'id' => $product['product_id'],
                'image' => getAttachmentUrl($product['image']),
                'price' => $product['price'],
                'title' => $product['name']
            );
        }
        json_return(0,$product_list);
    }

    public function component() {
        if (0 && !empty($_SESSION['system'])) {
            $custom_pages = M('Custom_page')->getAllList(8);
            $this->assign('is_system', true);
        } else {
            $custom_pages = M('Custom_page')->getPages($this->store_session['store_id'], 8);
        }
        $this->assign('pages', $custom_pages['pages']);
        $this->assign('page', $custom_pages['page']);
        if (IS_POST) {
            $this->display('ajax_component');
        } else {
            $this->display();
        }
    }

    //优惠券弹窗列表
    public function coupon() {
        $coupon = M('Coupon');
        $keyword = $_POST['keyword'];
        $time = time();
        
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['status'] = 1;
        $where['type'] = 1;
        $where['start_time'] = array('<=', $time);
        $where['end_time'] = array('>=', $time);
        
        if (!empty($keyword)) {
        	$where['name'] = array('like', '%' . $keyword . '%');
        }

        $coupon_total = $coupon->getCount($where);
        import('source.class.user_page');
        $page = new Page($coupon_total, 8);
        $coupons = $coupon->getList($where, '', $page->listRows, $page->firstRow);
        //coupon
        $this->assign('coupons', $coupons);
        $this->assign('page', $page->show());
		
        if (IS_POST) {
			$this->display('ajax_more_coupon');
		} else {
			$this->display('more_coupon');
        }
    }

	
	//logo弹窗及列表
	    //当前自营的商品
    public function logo() {
        $product = M('Product');
        $where = array();
        if (0 && !empty($_SESSION['system'])) {
            $this->assign('is_system', true);
        } else {
            $where['store_id'] = $this->store_session['store_id'];
        }

        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
        $where['supplier_id'] = '0';
        $where['quantity'] = array('>', 0);
        $where['soldout'] = 0;
        $product_total = $product->getSellingTotal($where);

        import('source.class.user_page');
        $page = new Page($product_total, 8);
        $products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);

        $this->assign('products', $products);
        $this->assign('page', $page->show());
        if ($_GET['type'] == 'more') {
            if (IS_POST) {
                $this->display('ajax_more_goods');
            } else {
                $this->display('more_goods');
            }
        } else {
            if (IS_POST) {
                $this->display('ajax_good');
            } else {
                $this->display();
            }
        }
    }

	public function goods_by_sku() {
		$uid = $_REQUEST['uid'];
		$keyword = $_POST['keyword'];
		$p = $_POST['p'];
		$is_ajax = $_POST['is_ajax'];
		$status = $_REQUEST['status'];
		$group_id = $_REQUEST['group_id'];
		
		if (!in_array($status, array(1, 2, 3))) {
			$_REQUEST['status'] = 1;
			$status = 1;
		}
		
		$product_module = M('Product');
		$where = "store_id = '" . $this->store_session['store_id'] . "' AND supplier_id = 0 AND quantity > 0 AND wholesale_product_id = 0";
		if (!empty($keyword)) {
			$where .= " AND name like '%" . trim($_REQUEST['keyword']) . "%'";
		}
		
		if ($status == 1) {
			$where .= " AND `status` = 1";
		} else if ($status == 2) {
			$where .= " AND `status` = 0";
		}
		
		if ($group_id) {
			$products = M('Product_to_group')->getProducts($group_id);
			$product_ids = array(0);
			if (!empty($products)) {
				foreach ($products as $item) {
					$product_ids[] = $item['product_id'];
				}
			}
			
			$where .= " AND product_id in (" . join(',', $product_ids) . ")";
		}
		
		$product_total = $product_module->getSellingTotal($where);
		
		import('source.class.user_page');
		$page = new Page($product_total, 8);
		$product_list = array();
		if ($product_total > 0) {
			$product_list = $product_module->getSelling($where, '', '', $page->firstRow, $page->listRows);
		}
		
		$product_sku_module = D('Product_sku');
		$pid_arr = array();
		$vid_arr = array();
		$pid_list = array();
		$vid_list = array();
		foreach ($product_list as &$product) {
			if ($product['has_property']) {
				$product_sku_list = $product_sku_module->where(array('product_id' => $product['product_id'], 'quantity' => array('>', 0)))->select();
				
				foreach ($product_sku_list as &$product_sku) {
					$sku_arr = explode(';', $product_sku['properties']);
					foreach ($sku_arr as $sku) {
						$sku_tmp = explode(':', $sku);
						if (empty($sku_tmp) || $sku_tmp[0] == 'undefined' || $sku_tmp[1] == 'undefined') {
							//continue;
						}
						$pid_arr[$sku_tmp[0]] = $sku_tmp[0];
						$vid_arr[$sku_tmp[1]] = $sku_tmp[1];
					}
					
					// 查找上次购买的价格,不用考虑商家更改了商品属性
					$order_product = D('Order_product as op')->join('Order as o ON o.order_id = op.order_id', 'LEFT')->where("op.sku_id = '" . $product_sku['sku_id'] . "' AND o.status = 4 AND o.uid = '" . $uid . "' AND op.return_status != 2 AND op.product_id = '" . $product['product_id'] . "'")->field('op.pro_price')->order('op.pigcms_id DESC')->find();
					$product_sku['origin_price'] = $product_sku['price'];
					if ($order_product) {
						$product_sku['price'] = $order_product['pro_price'];
					}
				}
				
				$product['sku_list'] = $product_sku_list;
			} else {
				// 查找上次购买的价格
				$order_product = D('Order_product as op')->join('Order as o ON o.order_id = op.order_id', 'LEFT')->where("o.status = 4 AND o.uid = '" . $uid . "' AND op.return_status != 2 AND op.product_id = '" . $product['product_id'] . "'")->field('op.pro_price')->order('op.pigcms_id DESC')->find();
				$product['origin_price'] = $product['price'];
				if ($order_product) {
					$product['price'] = $order_product['pro_price'];
				}
			}
		}
		
		if (!empty($pid_arr)) {
			$pid_arr = D('Product_property')->where("pid in ('" . join("','", $pid_arr) . "')")->select();
			$vid_arr = D('Product_property_value')->where("vid in ('" . join("','", $vid_arr) . "')")->select();
			
			foreach ($pid_arr as $tmp) {
				$pid_list[$tmp['pid']] = $tmp;
			}
			
			foreach ($vid_arr as $tmp) {
				$vid_list[$tmp['vid']] = $tmp;
			}
		}
		
		// 产品分组
		$product_group_list = D('Product_group')->where(array('store_id' => $this->store_session['store_id']))->select();
		
		$this->assign('product_list', $product_list);
		$this->assign('pid_list', $pid_list);
		$this->assign('vid_list', $vid_list);
		$this->assign('page', $page->show());
		$this->assign('product_group_list', $product_group_list);
		
		if (IS_POST) {
			$this->display('ajax_goods_by_sku');
		} else {
			$this->display();
		}
	}
	
	// 获取当前店铺产品
	public function store_goods_by_sku() {

		$keyword = $_POST['keyword'];
		$p = $_POST['p'];
		$is_ajax = $_POST['is_ajax'];
		
		
		$product_module = M('Product');
		$where['store_id'] = $this->store_session['store_id'];
		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
		}
		
		$where['supplier_id'] = '0';
		$where['quantity'] = array('>', 0);
		$where['soldout'] = 0;
		$where['wholesale_product_id'] = 0;
		$where['status'] = 1;
		$product_total = $product_module->getSellingTotal($where);
		
		import('source.class.user_page');
		$page = new Page($product_total, 8);
		$product_list = $product_module->getSelling($where, '', '', $page->firstRow, $page->listRows);
		
		$product_sku_module = D('Product_sku');
		$pid_arr = array();
		$vid_arr = array();
		$pid_list = array();
		$vid_list = array();
		foreach ($product_list as &$product) {
			if ($product['has_property']) {
				$product_sku_list = $product_sku_module->where(array('product_id' => $product['product_id'], 'quantity' => array('>', 0)))->select();
				
				foreach ($product_sku_list as &$product_sku) {
					$sku_arr = explode(';', $product_sku['properties']);
					foreach ($sku_arr as $sku) {
						$sku_tmp = explode(':', $sku);
						if (empty($sku_tmp) || $sku_tmp[0] == 'undefined' || $sku_tmp[1] == 'undefined') {
							//continue;
						}
						$pid_arr[$sku_tmp[0]] = $sku_tmp[0];
						$vid_arr[$sku_tmp[1]] = $sku_tmp[1];
					}
					
				}
				$product['sku_list'] = $product_sku_list;
			}
		}
		
		if (!empty($pid_arr)) {
			$pid_arr = D('Product_property')->where("pid in ('" . join("','", $pid_arr) . "')")->select();
			$vid_arr = D('Product_property_value')->where("vid in ('" . join("','", $vid_arr) . "')")->select();
			
			foreach ($pid_arr as $tmp) {
				$pid_list[$tmp['pid']] = $tmp;
			}
			
			foreach ($vid_arr as $tmp) {
				$vid_list[$tmp['vid']] = $tmp;
			}
		}
		
		$this->assign('product_list', $product_list);
		$this->assign('pid_list', $pid_list);
		$this->assign('vid_list', $vid_list);
		$this->assign('page', $page->show());
		
		if (IS_POST) {
			$this->display('ajax_goods_by_sku');
		} else {
			$this->display();
		}
	}

	public function goods_by_scan() {
		$uid = $_REQUEST['uid'];
		$code = $_POST['code'];
		
		$product_list = array();
		$pid_arr = array();
		$vid_arr = array();
		if (!empty($code)) {
			$where = array();
			$where['supplier_id'] = '0';
			$where['quantity'] = array('>', 0);
			$where['soldout'] = 0;
			$where['wholesale_product_id'] = 0;
			$where['code'] = $code;
			$where['status'] = 1;
			$product_list_tmp = D('Product')->where($where)->field('product_id, name, image, price, quantity, has_property')->select();
			
			$product_sku_module = D('Product_sku');
			foreach ($product_list_tmp as $product) {
				$product['image'] = getAttachmentUrl($product['image']);
				$product['link'] = option('config.site_wap_url') . '/good.php?id=' . $product['product_id'];
				if ($product['has_property']) {
					$product_sku_list_tmp = $product_sku_module->where(array('product_id' => $product['product_id'], 'quantity' => array('>', 0), 'code' => array('!=', $code)))->select();
					$product_sku_list = array();
					foreach ($product_sku_list_tmp as $product_sku) {
						$sku_arr = explode(';', $product_sku['properties']);
						foreach ($sku_arr as $sku) {
							$sku_tmp = explode(':', $sku);
							if (empty($sku_tmp) || $sku_tmp[0] == 'undefined' || $sku_tmp[1] == 'undefined') {
								//continue;
							}
							$pid_arr[$sku_tmp[0]] = $sku_tmp[0];
							$vid_arr[$sku_tmp[1]] = $sku_tmp[1];
						}
							
						// 查找上次购买的价格,不用考虑商家更改了商品属性
						$order_product = D('Order_product as op')->join('Order as o ON o.order_id = op.order_id', 'LEFT')->where("op.sku_id = '" . $product_sku['sku_id'] . "' AND o.status = 4 AND o.uid = '" . $uid . "' AND op.return_status != 2 AND op.product_id = '" . $product['product_id'] . "'")->field('op.pro_price')->order('op.pigcms_id DESC')->find();
						$product_sku['origin_price'] = $product_sku['price'];
						if ($order_product) {
							$product_sku['price'] = $order_product['pro_price'];
						}
						$product_sku_list[$product_sku['sku_id']] = $product_sku;
					}
					
					if (!empty($product_sku_list)) {
						$product['sku_list'] = $product_sku_list;
						$product_list[$product['product_id']] = $product;
					}
				} else {
					// 查找上次购买的价格
					$order_product = D('Order_product as op')->join('Order as o ON o.order_id = op.order_id', 'LEFT')->where("o.status = 4 AND o.uid = '" . $uid . "' AND op.return_status != 2 AND op.product_id = '" . $product['product_id'] . "'")->field('op.pro_price')->order('op.pigcms_id DESC')->find();
					$product['origin_price'] = $product['price'];
					if ($order_product) {
						$product['price'] = $order_product['pro_price'];
					}
					
					$product_list[$product['product_id']] = $product;
				}
			}
			
			$product_list_tmp = D('Product_sku AS ps')->join('Product AS p ON p.product_id = ps.product_id', 'LEFT')->field('*, ps.price as ps_price, ps.quantity as ps_quantity, ps.properties as ps_properties')->where("p.supplier_id = 0 AND p.quantity > 0 AND p.soldout = 0 AND p.wholesale_product_id = 0 AND ps.code = '" . $code . "'")->select();
			foreach ($product_list_tmp as $product) {
				if (isset($product_list[$product['product_id']])) {
					// 库存规格
					$product_sku = array();
					$product_sku['sku_id'] = $product['sku_id'];
					$product_sku['quantity'] = $product['ps_quantity'];
					$product_sku['price'] = $product['ps_price'];
					$product_sku['properties'] = $product['ps_properties'];
					
					$sku_arr = explode(';', $product['ps_properties']);
					foreach ($sku_arr as $sku) {
						$sku_tmp = explode(':', $sku);
						if (empty($sku_tmp) || $sku_tmp[0] == 'undefined' || $sku_tmp[1] == 'undefined') {
							//continue;
						}
						$pid_arr[$sku_tmp[0]] = $sku_tmp[0];
						$vid_arr[$sku_tmp[1]] = $sku_tmp[1];
					}
						
					// 查找上次购买的价格,不用考虑商家更改了商品属性
					$order_product = D('Order_product as op')->join('Order as o ON o.order_id = op.order_id', 'LEFT')->where("op.sku_id = '" . $product['sku_id'] . "' AND o.status = 4 AND o.uid = '" . $uid . "' AND op.return_status != 2 AND op.product_id = '" . $product['product_id'] . "'")->field('op.pro_price')->order('op.pigcms_id DESC')->find();
					$product_sku['origin_price'] = $product_sku['price'];
					if ($order_product) {
						$product_sku['price'] = $order_product['pro_price'];
					}
					
					$product_list[$product['product_id']]['sku_list'][$product['sku_id']] = $product_sku;
				} else {
					$product_detail = array();
					$product_detail['product_id'] = $product['product_id'];
					$product_detail['name'] = $product['name'];
					$product_detail['image'] = getAttachmentUrl($product['image']);
					$product_detail['price'] = $product['price'];
					$product_detail['quantity'] = $product['quantity'];
					$product_detail['link'] = option('config.wap_site_url') . '/goods.php?id=' . $product['product_id'];
					
					// 库存规格
					$product_sku = array();
					$product_sku['sku_id'] = $product['sku_id'];
					$product_sku['quantity'] = $product['ps_quantity'];
					$product_sku['price'] = $product['ps_price'];
					$product_sku['properties'] = $product['ps_properties'];
					
					$sku_arr = explode(';', $product['ps_properties']);
					foreach ($sku_arr as $sku) {
						$sku_tmp = explode(':', $sku);
						if (empty($sku_tmp) || $sku_tmp[0] == 'undefined' || $sku_tmp[1] == 'undefined') {
							//continue;
						}
						$pid_arr[$sku_tmp[0]] = $sku_tmp[0];
						$vid_arr[$sku_tmp[1]] = $sku_tmp[1];
					}
						
					// 查找上次购买的价格,不用考虑商家更改了商品属性
					$order_product = D('Order_product as op')->join('Order as o ON o.order_id = op.order_id', 'LEFT')->where("op.sku_id = '" . $product['sku_id'] . "' AND o.status = 4 AND o.uid = '" . $uid . "' AND op.return_status != 2 AND op.product_id = '" . $product['product_id'] . "'")->field('op.pro_price')->order('op.pigcms_id DESC')->find();
					$product_sku['origin_price'] = $product_sku['price'];
					if ($order_product) {
						$product_sku['price'] = $order_product['pro_price'];
					}
					
					$product_detail['sku_list'][$product['sku_id']] = $product_sku;
					
					$product_list[$product['product_id']] = $product_detail;
				}
			}
			
			if (!empty($pid_arr)) {
				$pid_arr = D('Product_property')->where("pid in ('" . join("','", $pid_arr) . "')")->select();
				$vid_arr = D('Product_property_value')->where("vid in ('" . join("','", $vid_arr) . "')")->select();
					
				foreach ($pid_arr as $tmp) {
					$pid_list[$tmp['pid']] = $tmp;
				}
					
				foreach ($vid_arr as $tmp) {
					$vid_list[$tmp['vid']] = $tmp;
				}
			}
			
			$json_data = array();
			$json_data['product_list'] = $product_list;
			$json_data['pid_list'] = $pid_list;
			$json_data['vid_list'] = $vid_list;
			
			echo json_encode($json_data);
			exit;
		}
		$this->display();
	}

    public function pagecat(){
        if(!empty($_SESSION['system'])){
            $wei_page_categories = M('Wei_page_category')->getAllList(8);
            $this->assign('is_system',true);
        }else{
            $wei_page_categories = M('Wei_page_category')->get_list($this->store_session['store_id'],8);
        }
        $this->assign('wei_page_categories', $wei_page_categories['cat_list']);
        $this->assign('page', $wei_page_categories['page']);
        if(IS_POST){
            $this->display('ajax_pagecat');
        }else{
            $this->display();
        }
    }

    /**
     * 选择一个分类
     */
    public function select_store_banner(){
        $Ucenter = D('Ucenter');

        $ucenters = $Ucenter->field("store_banner_field")->find();

        $this->assign('first_banners', unserialize($ucenters['store_banner_field']));

        $this->display('select_store_banner');
    }

    /**
     * 添加一个分类
     */
    public function add_banner(){
        $Ucenter = D('Ucenter');
        $name = $_POST['name'];
        if(!isset($name)){
            $data['error'] = 1;
            $data['msg'] = '请填写类别名字';
            echo json_encode($data);die();
        }

        $ucenters = $Ucenter->field("store_banner_field")->find();
        unset($original);
        $original = unserialize($ucenters['store_banner_field']);
        ksort($original);
        end($original);
        $key = key($original);
        $original[$key+1] = $name;

        $where['store_id'] = $this->store_session['store_id'];
        $udata['store_banner_field'] = serialize($original);

        $result = $Ucenter->where($where)->data($udata)->save();
        if($result){
            $data['error'] = 0;
            $data['msg'] = '添加分类成功';
        }else{
            $data['error'] = 1;
            $data['msg'] = '添加分类失败';
        }
        echo json_encode($data);die();
    }

    /**
     * 编辑一个分类
     */
    public function edit_banner(){
        $Ucenter = D('Ucenter');
        $key = $_POST['key'];
        if(!isset($key)){
            $data['error'] = 1;
            $data['msg'] = '无法查询类别id';
            echo json_encode($data);die();
        }
        $ori_value = $_POST['ori_value'];
        $now_value = $_POST['now_value'];
        if(!isset($ori_value) || !isset($now_value) || $ori_value==$now_value){
            $data['error'] = 1;
            $data['msg'] = '无法查询类别id';
            echo json_encode($data);die();
        }

        $ucenters = $Ucenter->field("store_banner_field,class_content")->find();
        unset($original);
        $original = unserialize($ucenters['store_banner_field']);
        $original[$key] = $now_value;

        $where['store_id'] = $this->store_session['store_id'];
        $udata['store_banner_field'] = serialize($original);

        $result = $Ucenter->where($where)->data($udata)->save();
        if($result){

            $vdata['class_content'] = str_replace($ori_value,$now_value,$ucenters['class_content']);
            $result = $Ucenter->where($where)->data($vdata)->save();

            $data['error'] = 0;
            $data['msg'] = '修改分类成功';
        }else{
            $data['error'] = 1;
            $data['msg'] = '修改分类失败';
        }
        echo json_encode($data);die();
    }

	//店铺终身制粉丝
	public function fans_forever()
	{
		if (IS_GET && $_GET['type'] == 'status') {
			$status = $_GET['status'];
			$id = $_GET['id'];
			D('Store_fans_forever')->where(array('pigcms_id' => $id))->data(array('status' => $status))->save();
			json_return(0, '操作成功');
		}

		import('source.class.user_page');
		$sql = "SELECT COUNT(sff.pigcms_id) AS fans_count FROM " . option('system.DB_PREFIX') . "store_fans_forever sff, " . option('system.DB_PREFIX') . "user u WHERE sff.uid = u.uid AND sff.store_id = '" . $this->store_session['store_id'] . "'";
		if (!empty($_POST['keyword'])) {
			$sql .= " AND u.nickname like '%" . trim($_POST['keyword']) . "%'";
		}
		$fans_count = D('')->query($sql);
		$fans_count = !empty($fans_count[0]['fans_count']) ? $fans_count[0]['fans_count'] : 0;

		$page = new Page($fans_count, 10);
		$sql = "SELECT u.nickname,u.uid,sff.* FROM " . option('system.DB_PREFIX') . "store_fans_forever sff, " . option('system.DB_PREFIX') . "user u WHERE sff.uid = u.uid AND sff.store_id = '" . $this->store_session['store_id'] . "'";
		if (!empty($_POST['keyword'])) {
			$sql .= " AND u.nickname like '%" . trim($_POST['keyword']) . "%'";
		}
		$sql .= " ORDER BY sff.pigcms_id DESC LIMIT " . $page->firstRow . ',' . $page->listRows;
		$fans_list = D('')->query($sql);

		$this->assign('fans_list', $fans_list);
		$this->assign('page', $page->show());

		if ($_GET['type'] == 'more') {
			if (IS_POST) {
				$this->display('ajax_more_fans_forever');
			} else {
				$this->display('fans_forever');
			}
		}
	}
}

?>
<?php

/**
 * 订单
 * User: pigcms_21
 * Date: 2015/2/5
 * Time: 10:42
 */
class pointorder_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        if (empty($this->store_session))
            redirect(url('index:index'));

        $this->checkRbac('order');
        $this->assign("is_local_logistic", $this->is_local_logistic());
    }

    // 检查门店管理员登录下权限
    private function checkRbac () {

        $controller = MODULE_NAME;
        $action = ACTION_NAME;
        $rbacActionModel = M('Rbac_action');
        $uid = $this->user_session['uid'];
        if ($this->user_session['type'] == 1) {     //门店管理员登录

            // 禁止使用方法配置到该数组
            // $rbacBanMethod = array();
            // if (!empty($rbacBanMethod) && in_array($action, $rbacBanMethod)			     //     $this->rbacError();
            // }

            $rbacArray = option('physical.rbac');
            $checkRbacMethod = (isset($rbacArray[$controller]) && !empty($rbacArray[$controller])) ? array_flip($rbacArray[$controller]) : array();
            $method = $rbacActionModel->getMethod($uid, $controller, $action);
            if (in_array($action, $checkRbacMethod) && !$method) {

            	// 检测默认值，空则跳转
            	$rbac_link = option('physical.link');
                if ($action == 'dashboard') {
                	$where_tmp = "uid = '$uid' AND controller_id = '$controller' AND action_id IN ('".join("','", $rbac_link[$controller])."')";
                	$rbac_row = D("Rbac_action")->where($where_tmp)->order("id ASC")->find();
                    !empty($rbac_row) ? redirect(url($controller.':'.$rbac_row['action_id'])) : $this->rbacError();
                }
                $this->rbacError();
            }

        }
    }

    // 门店管理rbac权限报错
    private function rbacError () {
        header("Content-type: text/html;charset=utf-8");
        if (IS_AJAX) {
            if (IS_GET) {
                json_return(0, '您没有操作权限');
            } elseif (IS_POST) {
                json_return(0, '您没有操作权限');
            }
        } else if (IS_POST) {
            pigcms_tips('您没有操作权限！', 'none');
        } else {
            pigcms_tips('您没有操作权限！', 'none');
        }
        exit;
    }

    // 本地物流是否可用
    private function is_local_logistic() {
        $store_id = $this->store_session['store_id'];
        $store_info = D('Store')->where(array('store_id'=>$store_id))->find();
        return !empty($store_info['open_local_logistics']) ? $store_info['open_local_logistics'] : 0;
    }

    public function index() {
        $this->display();
    }

    public function load() {
        $action          = strtolower(trim($_POST['page']));
        $status          = isset($_POST['status']) ? trim($_POST['status']) : ''; //订单状态
        $shipping_method = isset($_POST['shipping_method']) ? strtolower(trim($_POST['shipping_method'])) : ''; //运送方式 快递发货 上门自提
        $payment_method  = isset($_POST['payment_method']) ? strtolower(trim($_POST['payment_method'])) : ''; //支付方式
        $type            = isset($_POST['type']) ? $_POST['type'] : '*'; //订单类型 普通订单 代付订单
        $orderbyfield    = isset($_POST['orderbyfield']) ? trim($_POST['orderbyfield']) : '';
        $orderbymethod   = isset($_POST['orderbymethod']) ? trim($_POST['orderbymethod']) : '';
        $page            = isset($_POST['p']) ? intval(trim($_POST['p'])) : 1;
        $third_id        = isset($_POST['third_id']) ? trim($_POST['third_id']) : '';
        $order_no        = isset($_POST['order_no']) ? trim($_POST['order_no']) : '';
        $trade_no        = isset($_POST['trade_no']) ? trim($_POST['trade_no']) : '';
        $user            = isset($_POST['user']) ? trim($_POST['user']) : ''; //收货人
        $tel             = isset($_POST['tel']) ? trim($_POST['tel']) : ''; //收货人手机
        $time_type       = isset($_POST['time_type']) ? trim($_POST['time_type']) : '';
        $start_time      = isset($_POST['start_time']) ? trim($_POST['start_time']) : '';
        $stop_time       = isset($_POST['stop_time']) ? trim($_POST['stop_time']) : '';
        $weixin_user     = isset($_POST['weixin_user']) ? trim($_POST['weixin_user']) : '';
        $activity_type = isset($_POST['activity_type']) ? trim($_POST['activity_type']) : '';

        $data = array(
            'status'          => $status,
            'orderbyfield'    => $orderbyfield,
            'orderbymethod'   => $orderbymethod,
            'page'            => $page,
            'third_id'        => $third_id,
            'order_no'        => $order_no,
            'trade_no'        => $trade_no,
            'user'            => $user,
            'tel'             => $tel,
            'time_type'       => $time_type,
            'start_time'      => $start_time,
            'stop_time'       => $stop_time,
            'weixin_user'     => $weixin_user,
            'type'            => $type,
            'payment_method'  => $payment_method,
            'shipping_method' => $shipping_method,
            'activity_type' => $activity_type
        );
        if (empty($action))
            pigcms_tips('非法访问！', 'none');
		
        switch ($action) {
            case 'dashboard_content': //订单概况
                $this->_dashboard();
                break;
            case 'statistics_content':
                $this->_statistics_content(array('start_time' => $start_time, 'stop_time' => $stop_time));
                break;
            case 'selffetch_content': //到店自提
                $this->_selffetch_content($data);
                break;
            case 'detail_content':
                $this->_detail_content();
                break;
            case 'all_content':
                $this->_all_content($data);
                break;
            case 'activity_content':
                $this->_activity_content($data);
                break;
            case 'codpay_content':
                $this->_codpay_content($data);
                break;
            case 'buy_agent_content':
                $this->_buy_agent_content($data);
                break;
            case 'star_content':
                $this->_star_content($data);
                break;
            case 'physical_order_content':
                $this->_physical_order_content($data);
                break;
            case 'pay_agent_content':
                $this->_pay_agent_content($data);
                break;
            case 'check_content': //对账概况
                $this->_check_content($data);
                break;
            case 'seller_check_content':
                $this->_seller_check_content();
                break;
            case 'supplier_check_content':
                $this->_supplier_check_content();
                break;
            case 'dealer_check_content':
                $this->_dealer_check_content();
                break;
            case 'profit_check_content':
                $this->_profit_check_content();
                break;
            case 'order_return_list' :
                $this->_order_return_list();
                break;
            case 'order_return_detail':
                $this->_order_return_detail();
                break;
            case 'order_rights_list' :
                $this->_order_rights_list();
                break;
            case 'order_rights_detail':
                $this->_order_rights_detail();
                break;
            case 'order_add':
                $this->_order_add();
                break;
            case 'fx_bill_check_content':
                $this->_fx_bill_check_content();
                break;
            case 'ws_bill_check_content':
                $this->_ws_bill_check_content();
                break;
			case 'orderprint_index':
				$this->_orderprint_index();
				break;
			case 'orderprint_create':
				$this->_orderprint_create();
				break;
			case 'orderprint_edit':
				$this->_orderprint_edit();
				break;				
            default:
                break;
        }

        $this->display($_POST['page']);
    }

    //订单概况
    public function dashboard() {
        $this->display();
    }

    //订单详细
    public function detail() {
        $this->display();
    }

    //门店
    public function physical() {
        $this->display();
    }

    //订单打印 自定义模板
    public function print_order2() {


        $this->display();
    }
	
    //订单打印
	public function order_printing() {
		/*查看当前店铺的 订单打印*/
		//D('Store_printing_order_template')->where(array('store_id'=>$store_id))->select();
		if(!IS_AJAX) return false;
		$store_id = $this->store_session['store_id'];
		$Store_printing_order_template =  M('Store_printing_order_template');
		///
		switch($_POST['types']) {
			case 'save':
				$data = array();
				$texts = $_POST['text'];
				$data['typeid'] = $_POST['typeid'];
				$data['store_id'] = $store_id;
				if(empty($texts) || !$data['typeid']) {
					json_return(1000, '缺少必要参数！');
				}
				$data['text'] = $texts;
				if($Store_printing_order_template->update_printing_order($data,$store_id,$data['typeid'])) {
					json_return(0, '订单保存成功');
				} else {
					json_return(2000, '订单模板里不允许含html,body,script 等标签 ');
				}

				break;

			case 'get':

				$store_prining = $Store_printing_order_template->getBystoreid($store_id);
				foreach($store_prining as $k=>$v) {
					$store_prining_info[$v['typeid']] = $v;
				}

				$sys_printing_tpl = D('Order_printing_template')->where(array('status'=>1))->field("folder,filename,id,typename,timestamp")->select();
				foreach($sys_printing_tpl as $k=>$v) {
					$smalltext = "";
					$store_text="";
					if($store_prining_info[$v['id']]) {
						$store_text = $store_prining_info[$v['id']]['text'];
					}
					$file_folder = $v['folder'];
					$file = PIGCMS_PATH."static/moban/".$v['folder']."/".$v['filename'];

					if(!$store_text) {
						if(!file_exists($file) || !$v['filename']) {
							$smalltext = "";
						} else {
							ob_start();
							@include_once($file);
							$smalltext = ob_get_clean();
						}
					} else {
						$smalltext = $store_text;
					}
					$huifu[] = "<input type='checkbox' name='huifu' value='".$v[id]."'> 恢复原系统".$v[typename];
					$text = "<textarea class='text_printing' data_id=".$v['id']." style='width:800px;height:350px;margin:10px auto;'>".$smalltext."</textarea>";
					$text .= "<div style='text-align:center;width:100%'>";
					$text .= "	<center><button type='button'  class='input_button print_save' data_type='".$v['id']   ."'>保 存</button>&#12288<button type='button' style='position:static;right:0px;top:0px;background:#FF6600' class='input_button print_return xubox_tabclose' data_type='".$v['id']."'>返回</button></center>";
					$text .= "</div>";
					$info[] = array_object(array('title'=>$v['typename'], 'content'=>$text));
				}
				
				//加载系统标签查询
				$file_folder = $v['folder'] ? $v['folder'] : "order_print";
				$arr = include_once(PIGCMS_PATH."static/moban/".$file_folder."/biaoqian.php");
				$contents_sys = "<ul>";
				$j=0;
				foreach($arr as $k=>$v) {
					$contents_sys .="<li style='float:left;width:33%;line-height:35px;hegiht:35px;border:1px solid #ccc;border-left:0px;'><b>".$k.':</b> &nbsp;'. $v ."</td>";
					$contents_sys .="</li>";
					$j++;
				}
				$contents_sys .= "</ul>";
				$huifu_str =  implode("&#12288;",$huifu);
				$contents_sys .= "<div style='clear:both;bottom:50px;position:absolute;width:100%;text-align:center'>".$huifu_str."</div>";
				$contents_sys .= "<div style='position:absolute;bottom:0px;text-align:center;width:100%'>";
				$contents_sys .= "	<center><button type='button'  class='input_button huifu' data_type=''>确认恢复</button>&#12288<button type='button' style='position:static;right:0px;top:0px;background:#FF6600' class='input_button print_return xubox_tabclose' data_type=''>返回</button></center>";
				$contents_sys .= "</div>";
				
				$arr_sys = array(
					'title' =>	'系统标签查看',
					'content' => $contents_sys
				);
				$info[] = array_object($arr_sys);

				$return_arr = array(
					'err_code' =>0,
					'err_msg' => $sys_printing_tpl,
					'text'=> $info
				);
				echo json_encode($return_arr);exit;
		}
	}


    //列表页打印预览数据
    public function do_printing(){
        $order_model = M('Order');
        $order_product_model = M('Order_product');
        $print_type = $_GET['print_type'];
        $store_id = $this->store_session['store_id'];
        if(!in_array($print_type,array(1,2,3))) 	exit('参数错误！');
        if(!$_GET['order_id_str']) 	return false;
        $Store_printing_order_template =  M('Store_printing_order_template');
        $sys_printing = D('Order_printing_template')->where(array('status'=>1,'id'=>$print_type))->field("folder,filename,id,typename,timestamp")->find();
        $store_prining = $Store_printing_order_template->getOneByTypeid($store_id,$print_type);
        //获取店铺信息
        $store_name = $this->store_session['name'];
       
        //模板 $store_prining['text'];
        $limits = 7;//每个订单显示几个商品
        
        $order_id_arr = explode(",",$_GET['order_id_str']);
        $order_arr = $order_model->getOrders(array('store_id'=>$this->store_session['store_id'],'order_id'=>array('in',$order_id_arr)));

        // 满减/送、优惠券、折扣
        import('source.class.Order');
	
        foreach($order_arr as $k=>$order) {
            $order['products_list'] = array();
            $products = array();
            // 重新计算邮费
            $order['postage'] = 0;
            // 取得运费值
            if ($order['fx_postage']) {
                $fx_postage_arr = unserialize($order['fx_postage']);
                if (isset($fx_postage_arr[$this->store_session['store_id']])) {
                    $order['postage'] = $fx_postage_arr[$this->store_session['store_id']];
                }
            }

            $products2 = $order_product_model->getProductOwn(array('op.order_id' => $order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
            //$products = $order_product->getProducts($order_id);

            $product_list = array();
            if ($order['user_order_id']) {
                // 有分销时，重新计算产品价格
                foreach ($products as $product) {
                    $original_product_id = $product['original_product_id'];
                    if (empty($product['original_product_id'])) {
                        $original_product_id = $product['product_id'];
                    }

                    $product_tmp = D('Order_product')->where("order_id = '" . $order['user_order_id'] . "' AND original_product_id = '" . $original_product_id . "' AND sku_data = '" . $product['sku_data'] . "'")->field('pro_price')->order("pigcms_id ASC")->find();
                    $product['pro_price'] = $product_tmp['pro_price'];

                    $product_list[] = $product;
                }

                $products2 = $product_list;
            }

            ///
            $total_money = 0;
            $xh=1;
            foreach($products2 as $product) {
            	$product['xh'] = $xh;
            	$xh++;
                $product['xj'] = number_format($product['pro_num'] * $product['pro_price'], 2, '.', '');
                $product['total_money'] += $product['xj'];
                if ($product['is_present']) {
                    $product['zp_or_fx'] = '<span style="color:#f60;">赠品</span>';
                }
                if ($product['is_fx']) {
                    $product['zp_or_fx'] = '<span class="platform-tag">分销</span>';
                }
                $start_package = false; //订单已经有商品开始打包
                $discount_money = 0;
                if (!$start_package && $products['is_packaged']) {
                    $start_package = true;
                }

                if ($products['is_packaged'] || $start_package) {
                    if ($product['in_package_status'] == 0) {
                        $product['zhuangtai'] = '待发货';
                    } else if ($product['in_package_status'] == 1) {
                        $product['zhuangtai'] = '已发货';
                    }  else if ($product['in_package_status'] == 2) {
                        $product['zhuangtai'] = '已到店';
                    } else if ($product['in_package_status'] == 3) {
                        $product['zhuangtai'] = '已签收';
                    }
                } else {
                    if ($order['shipping_method'] == 'selffetch' && $order['status'] != 4 && $order['status'] != 7) {
                        $product['zhuangtai'] = '未' . ($store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提');
                    } else if ($order['shipping_method'] == 'selffetch' && ($order['status'] == 4 || $order['status'] == 7)) {
                        $product['zhuangtai'] = '已' . ($store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提');
                    } else {
                        $product['zhuangtai'] = '未打包';
                    }
                }

                //款式
                $product['skus_name'] ="";
                if ($skus) {
                    $product['skus_name'] .= "<p><span class='goods-sku'>";
                    foreach ($skus as $sku) {
                        $product['skus_name'] .= $sku['name'] .":". $sku['value']."&nbsp";
                    }
                    $product['skus_name'] .= "<p><span class='goods-sku'></p>";
                }

                $product['comment'] ="";
                if (!empty($comments)) {
                    foreach ($comments as $comment) {
                        $product['comments'] .= $comment['name'] .":". $comment['value'];
                    }
                }

                //留言
                $total_money += $product['xj'] ;
                $products[] = $product;
            }

            $order['order_xj'] = $total_money;
            $order['store_name'] = $store_name;
            $address = !empty($order['address']) ? unserialize($order['address']) : array();
            $order['address'] = $address;
            $order['xd_time'] = date('Y-m-d', $order['add_time']);
            $order_data = Order::orderDiscount($order, $products);

            $order['products_list'] = $products?$products:array();
            /////
            $order['max_one_order_page'] = ceil(count($products)/$limits) ? ceil(count($products)/$limits) : '1';	//一个订单最多可能的分页
            for($iq = 0 ; $iq<$order['max_one_order_page']; $iq++) {
				$order['products_list'.$iq] = array_slice($products, $iq*$limits, $limits);	
            }
            ////
            $order['store'] = $store?$store:array();
            $order['order_data'] = $order_data?$order_data:array();
            //

            if ($order_data['order_ward_list']) {
                foreach ($order_data['order_ward_list'] as $order_ward_list) {
                    foreach ($order_ward_list as $order_ward) {
                        $discount_money += $order_ward['content']['cash'];
                        //满减
                        $order['manjian'] = "满减：".getRewardStr($order_ward['content'])."<br/>";
                    }
                }
            }
            if ($order_data['order_coupon_list']) {
                foreach ($order_data['order_coupon_list'] as $order_coupon) {
                    $discount_money += $order_coupon['money'];
                    //优惠券
                    $order['youhuiquan'] = "优惠券：".$order_coupon['name']."&#12288;优惠金额".number_format($order_coupon['money'], 2)."<br/>";
                }
            }
            if ($order_data['discount_money']) {
                $discount_money += $order_data['discount_money'];
                //折后优惠
                $order['zhehouyouhui'] = "打折优惠：<i>&yen". number_format($order_data['discount_money'], 2) ."元</i><br/>";

            }

          
            $discount_money -= $order['float_amount'];
            //卖家改价
            if ($order['float_amount'] > 0) {
                $order['maijiagaijia'] = "卖家改价：+￥".$order['float_amount']."<br/>";
            } elseif($order['float_amount'] == 0) {
            	$order['maijiagaijia'] ="";
            } else {
                $order['maijiagaijia']  = "卖家改价：".number_format(abs($order['float_amount']), 2, '.', '')."<br/>";
            }
			//运费
			$order['postages'] = $order['postage'] ? "运费：&yen".$order['postage']."<br/>" : "";
			
			//应收款
            $order['yingshoukuan'] = number_format($order['order_xj']+$order['postage']-$discount_money,2);

            $order_all[] = $order;
        }

        //商铺二维码
        $store_id = $order['store_id'];
        $store = D('Store')->where(array('store_id' => $store_id))->find();
        if ($store) {
            $store['qcode'] = option('config.site_url') . "/source/qrcode.php?type=home&id=" . $store['store_id'];
        }

        if(!$store_prining['text']) {
        	
	        $file = PIGCMS_PATH."static/moban/".$sys_printing['folder']."/".$sys_printing['filename'];
	        if(file_exists($file)) {
	        	ob_start();
	        	@include_once($file);
	        	$sys_prining = ob_get_clean();	
	        }
        }
        //////////////////
        $order_all = array_reverse($order_all);
        //////////////////
        $tpls = $store_prining['text'] ? $store_prining['text'] : $sys_prining;
        $tmp = 'tmp' . uniqid(time(), true) . rand(100000000, 99999999999);
        if(!$tpls) {
        	$tpls="请先检查是否已经设置了打印模板！";
        	$tip_tpls="error";
        }
        // php转换
        $tpls = preg_replace('/\<\?php(\S| )*\?>/', '',$tpls);
        $tpls = preg_replace('/\<volist name="(.{1,})" id="(.{1,})"\>/', '<?php foreach ($$1 as $tmp_$1 => $$2) { ?>',$tpls);

        $tpls = preg_replace('/\<\/volist>/', '<?php } ?>',$tpls);
        $tpls = preg_replace('/\<if condition="(.{1,})\">/', '<?php if ($1) { ?>',$tpls);
        $tpls = preg_replace('/\<\/if>/', '<?php } ?>',$tpls);
        $tpls = preg_replace('/\<else>/', '<?php } else { ?>',$tpls);
        $tpls = preg_replace("/<forpage>/" , "<?php for(\$is=0; \$is<\$vo_all['max_one_order_page']; \$is++) {?>" , $tpls);
        $tpls = preg_replace("/<\/forpage>/", "<?php }?>", $tpls);
        //一个订单仅仅显示一次
        $tpls = preg_replace("/<showone>/" , "<?php if(\$is==\$vo_all['max_one_order_page']-1) {?>" , $tpls);
        $tpls = preg_replace("/<\/showone>/", "<?php }?>", $tpls);        
        //显示 商品/LIMIT n-1次
        $tpls = preg_replace("/<unshowone>/" , "<?php if(\$tmp_order_all != count(\$order_all)-1){ if((\$is==\$vo_all['max_one_order_page']-1) || (\$is!=\$vo_all['max_one_order_page']-1) || \$vo_all['max_one_order_page']==1 || \$vo_all['max_one_order_page']==0) {?>" , $tpls);
        $tpls = preg_replace("/<\/unshowone>/", "<?php }}?>", $tpls);
        
        $tpls = preg_replace("/<unshowone1>/" , "<?php if(\$tmp_order_all!=0) {?>" , $tpls);
        $tpls = preg_replace("/<\/unshowone1>/", "<?php }?>", $tpls);
        
        //地址
        $tpls = preg_replace('/\[%vo_all.addressdetail%\]/',"<?php echo \$vo_all['address']['province'] .'&nbsp;'.\$vo_all['address']['city'].'&nbsp;'.\$vo_all['address']['area'].'&nbsp;'.\$vo_all['address']['address'];?>",$tpls);	//会员名称
        $tpls = preg_replace('/\[%xh%\]/',"<?php echo \$vo['xh'];?>",$tpls);	//商品序号
        $tpls = preg_replace('/\[%vo.name%\]/',"<?php echo \$vo['name'];?>",$tpls);	//商品名称
        $tpls = preg_replace('/\[%vo.bak%\]/',"<?php echo \$vo['bak'];?>",$tpls);	//商品款式
        $tpls = preg_replace('/\[%vo.skus_name%\]/',"<?php echo \$vo['skus_name'];?>",$tpls);	//商品备注
        $tpls = preg_replace('/\[%vo.pro_price%\]/',"<?php echo \$vo['pro_price'];?>",$tpls);	//商品单价
        $tpls = preg_replace('/\[%vo.pro_num%\]/',"<?php echo \$vo['pro_num'];?>",$tpls);	//商品数量
        $tpls = preg_replace('/\[%vo.xj%\]/',"<?php echo \$vo['xj'];?>",$tpls);	//单个商品小计
        $tpls = preg_replace('/\[%vo.zp_or_fx%\]/',"<?php echo \$vo['zp_or_fx'];?>",$tpls);	//商品 赠品描述
        $tpls = preg_replace('/\[%vo.comment%\]/',"<?php echo \$vo['comment'];?>",$tpls);	//单个商品小计
        $tpls = preg_replace('/\[%store.qcode%\]/',"<?php echo \$store['qcode'];?>",$tpls);	//店铺二维码

        $tpls = preg_replace('/\[%vo_all.order_no%\]/',"<?php echo \$vo_all[order_no];?>",$tpls);	//订单号
        $tpls = preg_replace('/\[%vo_all.xd_time%\]/',"<?php echo \$vo_all[xd_time];?>",$tpls);	//下单时间
        $tpls = preg_replace('/\[%vo_all.address_user%\]/',"<?php echo \$vo_all[address_user];?>",$tpls);	//联系人
        $tpls = preg_replace('/\[%vo_all.order_xj%\]/',"<?php echo \$vo_all['order_xj'];?>",$tpls);	//单个订单小计
        $tpls = preg_replace('/\[%vo_all.postage%\]/',"<?php echo \$vo_all['postages'];?>",$tpls);	//订单运费
        $tpls = preg_replace('/\[%vo_all.zhehouyouhui%\]/',"<?php echo \$vo_all['zhehouyouhui'];?>",$tpls);	//订单打折优惠
        $tpls = preg_replace('/\[%vo_all.manjian%\]/',"<?php echo \$vo_all['manjian'];?>",$tpls);	//订单满减
        $tpls = preg_replace('/\[%vo_all.maijiagaijia%\]/',"<?php echo \$vo_all['maijiagaijia'];?>",$tpls);	//卖家改价
        $tpls = preg_replace('/\[%vo_all.youhuiquan%\]/',"<?php echo \$vo_all['youhuiquan'];?>",$tpls);	//订单优惠券
        
        $tpls = preg_replace('/\[%vo_all.address_tel%\]/',"<?php echo \$vo_all[address_tel];?>",$tpls);	//商家联系电话

        $tpls = preg_replace('/\[%vo_all.yingshoukuan%\]/',"<?php echo \$vo_all['yingshoukuan'];?>",$tpls);	//订单总金额

		if($tip_tpls == 'error') {
			$tpls .="<style>.heads_tr td{font-size:11pt;font-weight:700;line-height:26px;}</style><style type=\"text/css\" media=\"print\">.heads_tr td{font-size:11pt;font-weight:700;line-height:26px;} .noprint{display:none}.table-footer{display:table-footer-group}.PageNext{page-break-before: always;}</style><style>.NOPRINT {font-family: \"宋体\";font-size: 9pt;}td{font-size:9pt;font-family: Arial, Helvetica, sans-serif;}.table_style {border-collapse: collapse;}.hr_style {color: #000000;}.td01 {font-size: 14pt;}.font01 {font-size: medium;}.font02 {font-size: 11pt;}.font03 {font-size: 11pt;text-align: center;}.font04 {line-height: 150%;}.print_button{height:40px;background:#369 none repeat scroll 0 0;border:2px solid #efefef;border-radius:5px;width:100px;color:#fff;font-size:13px;font-weight:700;}#divTest{position: fixed;z-index: 1000;background-color: #D5ECF1;width: 100%;height:45px;left: 0%;bottom:0px;padding-top:10px;text-align:center;}</style><div id=\"divTest\" class=noprint> <input type=button style=\"background:#FF6600\" name=button_show value=\"返回上一页\" class=\"noprint print_button\" onclick=\"javascript:location.href='./user.php?c=order&a=all'\"> <input class=\"print_button\" type=\"button\" id=\"datasubmit\" VALUE=\"尚无打印模板\" name=\"button\" ></div>";
		} else{
			$tpls .="<style>.heads_tr td{font-size:11pt;font-weight:700;line-height:26px;}</style><style type=\"text/css\" media=\"print\">.heads_tr td{font-size:11pt;font-weight:700;line-height:26px;} .noprint{display:none}.table-footer{display:table-footer-group}.PageNext{page-break-before: always;}</style><style>.lists li{float:left;line-height:25px;margin:12px;font-weight:700;} tr{height:22px;line-height:22px;} .NOPRINT {font-family: \"宋体\";font-size: 9pt;}td{font-size:9pt;font-family: Arial, Helvetica, sans-serif;}.table_style {border-collapse: collapse;}.hr_style {color: #000000;}.td01 {font-size: 14pt;}.font01 {font-size: medium;}.font02 {font-size: 11pt;}.font03 {font-size: 11pt;text-align: center;}.font04 {line-height: 150%;}.print_button{height:40px;background:#369 none repeat scroll 0 0;border:2px solid #efefef;border-radius:5px;width:100px;color:#fff;font-size:13px;font-weight:700;}#divTest{position: fixed;z-index: 1000;background-color: #D5ECF1;width: 100%;height:45px;left: 0%;bottom:0px;padding-top:10px;text-align:center;}</style><div id=\"divTest\" class=noprint><OBJECT classid=\"CLSID:8856F961-340A-11D0-A96B-00C04FD705A2\" height=\"0\" id=\"wb\" name=\"wb\" width=\"0\" VIEWASTEXT></OBJECT> <input class=\"print_button\" type=\"button\" id=\"datasubmit\" VALUE=\"确认打印\" name=\"submit\" onclick=\"javascrīpt:window.print()\"></div><script type=\"text/javascript\">var rootel=document.documentElement; //XHTMlvar bto=document.getElementById('divTest');</script>";
		}

		file_put_contents("./cache/read_print.php", $tpls);
		ob_start();
		include './cache/read_print.php';
		$out = ob_get_clean();
		echo $out; 
		exit;
        $this->display();
    }

    //订单打印
    public function print_order()
    {
        $order = M('Order');
        $order_product = M('Order_product');

        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $order = $order->getOrder($this->store_session['store_id'], $order_id);

        // 重新计算邮费
        $order['postage'] = 0;
        // 取得运费值
        if ($order['fx_postage']) {
            $fx_postage_arr = unserialize($order['fx_postage']);
            if (isset($fx_postage_arr[$this->store_session['store_id']])) {
                $order['postage'] = $fx_postage_arr[$this->store_session['store_id']];
            }
        }

        $products = $order_product->getProductOwn(array('op.order_id' => $order_id, 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
        //$products = $order_product->getProducts($order_id);

        $product_list = array();
        if ($order['user_order_id']) {
            // 有分销时，重新计算产品价格
            foreach ($products as $product) {
                $original_product_id = $product['original_product_id'];
                if (empty($product['original_product_id'])) {
                    $original_product_id = $product['product_id'];
                }

                $product_tmp = D('Order_product')->where("order_id = '" . $order['user_order_id'] . "' AND original_product_id = '" . $original_product_id . "' AND sku_data = '" . $product['sku_data'] . "'")->field('pro_price')->order("pigcms_id ASC")->find();
                $product['pro_price'] = $product_tmp['pro_price'];

                $product_list[] = $product;
            }

            $products = $product_list;
        }

        // 满减/送、优惠券、折扣
        import('source.class.Order');
        $order_data = Order::orderDiscount($order, $products);
		//dump($order_data);
        //商铺二维码
        $store_id = $order['store_id'];
        $store = D('Store')->where(array('store_id' => $store_id))->find();
        if ($store) {
            $store['qcode'] = $store['qcode'] ? getAttachmentUrl($store['qcode']) : option('config.site_url') . "/source/qrcode.php?type=home&id=" . $store['store_id'];
        }

        $this->assign('order', $order);
        $this->assign('store', $store);
        $this->assign('products', $products);
        $this->assign('payment_method', $payment_method);
        $this->assign('order_data', $order_data);
        $this->display();
    }
	
	//恢复系统打印订单样式
	public function order_print_getback() {
		if($_POST['huifu_ids']) {
			$huifu_ids = preg_replace("/(^,|,$)/","",$_POST['huifu_ids']);
			$huifu_arr = explode(",",$huifu_ids);
			$where = array(
				'typeid' => array('in',$huifu_arr),
				'store_id' => $this->store_session['store_id']	
			);
			D('Store_printing_order_template')->where($where)->delete();
			json_return(0, '修改成功！');
		} 
		json_return(1001, '修改失败！');
		
	}

	
	//订单打印机
	public function orderprint() {
		
		$this->display();
	}

	//订单打印机 列表页
	public function _orderprint_index() {

		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$type = $_REQUEST['type'];
		$keyword = $_REQUEST['keyword'];
		$limit = 20;
		$uid = $_SESSION['store']['uid'];
		$store_id = $_SESSION['store']['store_id'];
		$oprint_machine = M('Store_orderprint_machine');
		
		$where = array();
		$where['store_id'] = $store_id;		
		if (!empty($keyword)) {
			$where['username'] = array('like', '%' . $keyword . '%');
		}
		$count = $oprint_machine->getCount($where);
		
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "";
			$oprint_machine_list = $oprint_machine->getList($where,$order_by,$limit,$offset);
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		$this->assign('pages', $pages);
		$this->assign('keyword', $keyword);

		$this->assign('machine_list', $oprint_machine_list);
	}

	
	//订单打印机 添加
	private function _orderprint_create() {
		$store_id = $this->store_session['store_id'];
		if($_POST['is_submit'] == 'submit'){
			$data['mobile'] = trim($_POST['mobile']);
			$data['username'] = $_POST['username'];
			$data['terminal_number'] = $_POST['terminal_number'];
			$data['keys'] = $_POST['keys'];
			$data['counts'] = $_POST['counts'];
			$data['type'] = $_POST['type'];
			$data['store_id'] = $store_id;
			$data['is_open'] = 1;
			$data['timestamp'] = time();
			
			if($data['mobile']) {
				if(!preg_match('/^((1[34578]\d{9}))$/',$data['mobile'])) {
					json_return(1000,"手机号填写错误！".$data['mobile']);
				}
			}
			if(!$data['counts'] || !preg_match("/^[1-9]{1}[\d]{0,3}$/",$data['counts'])) {
				json_return(2000,"打印份数在1-9999之间！");
			}
			if(!in_array($data['type'],array(1,2))) {
				json_return(3000,"选择打印类型错误！");
			}
			
			$return = M('Store_orderprint_machine')->create($data);
			json_return($return[err_code],$return['err_msg']);
		}
		
		
		
	}
	
	//订单打印机 修改
	private function _orderprint_edit() {
		$oprint_machine = M('Store_orderprint_machine');
		$store_id = $this->store_session['store_id'];
		$id = $_REQUEST['id'];

		if($_POST['is_submit'] == 'submit') {
			$store_id = $this->store_session['store_id'];
			if($_POST['mobile']) $data['mobile'] = $_POST['mobile'];
			if($_POST['username'])  $data['username'] = $_POST['username'];
			if($_POST['terminal_number']) $data['terminal_number'] = $_POST['terminal_number'];
			if($_POST['keys']) $data['keys'] = $_POST['keys'];
			if($_POST['counts']) $data['counts'] = $_POST['counts'];
			if($_POST['type']) $data['type'] = $_POST['type'];
			$data['timestamp'] = time();
			//$id = $_POST['ids'];
			$where = array('store_id' => $store_id, 'id' => $id);	
			
			if(!$id) json_return(5000,"缺少参数！");
			if($data['mobile']) {
				if(!preg_match('/^((1[34578]\d{9}))$/',$data['mobile'])) {
					json_return(1000,"手机号填写错误！");
				}
			}
			if(!$data['counts'] || !preg_match("/^[1-9]{1}[\d]{0,3}$/",$data['counts'])) {
				json_return(2000,"打印份数在1-9999之间！");
			}
			if(!in_array($data['type'],array(1,2))) {
				json_return(3000,"选择打印类型错误！");
			}
			
			$exists_machine = D('Store_orderprint_machine')->where(array('terminal_number' => $data['terminal_number'] ,'id'=>array("!=",$id), 'store_id' => $store_id))->find();
			if($exists_machine) {
				json_return(4000,"您的店铺已存在相同的终端号，请核对！");
			}			
			
			 $oprint_machine->save($data,$where);
				
			json_return(0,"修改成功！");
		}
		if($id) {
			$oprint_machine_info = $oprint_machine->get($id,$store_id);
		} else {
			json_return(6000,"参数错误！");
		}
		
		$this->assign("array",$oprint_machine_info);
	}	

	//关闭/开启 指定订单打印机
	public function orderprint_disabled() {
		$id = (int)$_GET['id'];
		$is_open = (int)$_GET['is_open'];
		if(!in_array($is_open,array('0','1'))) json_return(1000,"缺少参数！");
		
		$store_id = $this->store_session['store_id'];
		$oprint_machine =  M('Store_orderprint_machine');
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}	

		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$oprint = $oprint_machine->get($id, $store_id);
		if(empty($oprint['id'])) {
			json_return(1002, '未找到相应的订单打印机');
		}		

		$data = array();
		$data['is_open'] = $is_open;
		$oprint_machine->save($data, array('id' => $id));
		json_return(0, '操作完成');
		
	}
	
	//删除指定 订单打印机
	public function orderprint_delete() {
		$id = $_GET['id'] + 0;
		$store_id = $this->store_session['store_id'];
		$oprint_machine =  M('Store_orderprint_machine');
		
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $store_id;
		$where['id'] = $id;
		$oprint = $oprint_machine->get($id, $store_id);
		if(empty($oprint['id'])) {
			json_return(1002, '未找到相应的订单打印机');
		}
		
		$oprint_machine->delete($id,$store_id);
		json_return(0, '操作完成');
		
	}
	

	//订单打印机 有无终端号说明
	public function orderprint_tips() {
		$types = $_GET['types'];
		if(!in_array($types,array('hadzdh','nohadzdh'))) $types = 'hadzdh';
		$this->assign('types', $types);
		$this->display();
	}
	
    //订单详细页面
    private function _detail_content() {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $package = M('Order_package');

        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $order = $order->getOrder($this->store_session['store_id'], $order_id);
        $products = $order_product->getProducts($order_id);
        if (empty($order['uid'])) {
            $order['is_fans'] = false;
            $is_fans = false;
            $order['buyer'] = '';
        } else {
            //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
            $order['is_fans'] = true;
            $is_fans = true;
            $user_info = $user->checkUser(array('uid' => $order['uid']));

        }

        $is_supplier = false;
        if (!empty($order['suppliers'])) { //订单供货商
            $suppliers = explode(',', $order['suppliers']);
            if (in_array($this->store_session['store_id'], $suppliers)) {
                $is_supplier = true;
            }
        } else if (empty($order['suppliers'])) {
        	$is_supplier = true;
        }
        $order['is_supplier'] = $is_supplier;

        $comment_count = 0;
        $product_count = 0;
        $tmp_products = array();
        $is_print = false;
        foreach ($products as $product) {
            if (!empty($product['comment'])) {
                $comment_count++;
            }
            $product_count++;
			if ($product['original_product_id']) {
				$tmp_products[] = $product['original_product_id'];
			} else {
				$tmp_products[] = $product['product_id'];
			}
			
			if ($product['store_id'] == $this->store_session['store_id']) {
				$is_print = true;
			}
        }

        $status = M('Order')->status();
        $payment_method = M('Order')->getPaymentMethod();

        if (empty($order['address'])) {
            $status[0] = '未填收货地址';
        } else {
            $status[1] = '已填收货地址';
        }
        if (!empty($order['user_order_id'])) {
            $user_order_id = $order['user_order_id'];
            $mainOrder = D('Order')->field('uid')->where(array('order_id'=>$user_order_id,'fx_order_id'=>0,'user_order_id'=>0))->find();
            // 购买者详细信息
            $userInfo = D('User')->where(array('uid'=>$mainOrder['uid']))->find();
            $order['buyer'] = $user_info['nickname'];
            $order['phone'] = $user_info['phone'];
        } else {
            $user_order_id = $order['order_id'];
        }
        $where = array();
        $where['user_order_id'] = $user_order_id;
        $tmp_packages = $package->getPackages($where);
        $packages = array();
        foreach ($tmp_packages as $package) {
            $package_products = explode(',', $package['products']);
            if (array_intersect($package_products, $tmp_products)) {
                // 由门店配送
                if (!empty($package['physical_id'])) {
                    $physical_info = M('Store_physical')->getOne($package['physical_id']);
                    $package['physical_name'] = $physical_info["name"];
                }

                // 配送员信息
                if (!empty($package['courier_id'])) {
                    $courier_info = D("Store_physical_courier")->where(array('courier_id'=>$package['courier_id']))->find();
                    $package['courier_name'] = $courier_info["name"];
                }

                if ($package['status'] == 1) {
                    $package['status_txt'] = '未配送';
                } else if ($package['status'] == 2) {
                    $package['status_txt'] = '配送中';
                } else if ($package['status'] == 3) {
                    $package['status_txt'] = '已送达';
                }

                $packages[] = $package;
            }
        }
        import('source.class.Order');
        $order_data = Order::orderDiscount($order, $products);
        /*
        // 查看满减送
        $order_data['order_ward_list'] = M('Order_reward')->getByOrderId($order['order_id']);
        // 使用优惠券
        $order_data['order_coupon_list'] = M('Order_coupon')->getList($order['order_id']);
        // 查看使用的折扣
        $order_discount_list = M('Order_discount')->getByOrderId($order['order_id']);
        foreach ($order_discount_list as $order_discount) {
            $order_data['order_discount_list'][$order_discount['store_id']] = $order_discount['discount'];
        }*/

        // 代付订单
        if ($order['payment_method'] == 'peerpay') {
            $order_peerpay_list = D('Order_peerpay')->where(array('order_id' => $order['order_id'], 'status' => 1))->select();
            $this->assign('order_peerpay_list', $order_peerpay_list);
        }
        // 订单来源
        if(empty($order['user_order_id']))
        {
            $seller['name'] = '本店';
        }
        else
        {
            $order_info = D('Order')->field('store_id')->where(array('order_id' => $order['user_order_id']))->find();
            $seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
        }

		// 送他人订单
		$orderFriendCount = 0;
		$orderFriendAddress = array();
		if ($order['shipping_method'] == 'send_other') {
			$where_sql = "(`order_id` = " . $order['order_id'] . " OR `order_id` = " . $order['user_order_id'] . ")";
			$orderFriendCount = D('Order_friend_address')->where($where_sql." AND `default` = 0")->count('id');
			$orderFriendAddress = D('Order_friend_address')->where($where_sql)->select();
			foreach ($orderFriendAddress as $key => $val) {
				$addressArr = unserialize($val['address']);
				$orderFriendAddress[$key]['address'] = $addressArr;
			}
		}

		$this->assign('order_friend_count', $orderFriendCount);
		$this->assign('order_friend_address', $orderFriendAddress);
        $this->assign('seller', $seller['name']);
        $this->assign('is_fans', $is_fans);
        $this->assign('order', $order);
        $this->assign('products', $products);
        $this->assign('rows', $comment_count + $product_count);
        $this->assign('comment_count', $comment_count);
        $this->assign('status', $status);
        $this->assign('payment_method', $payment_method);
        $this->assign('packages', $packages);
        $this->assign('order_data', $order_data);
        $this->assign('is_print', $is_print);
    }

    public function detail_json()
    {
    	$order = M('Order');
    	$order_product = M('Order_product');
    	$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
    	$order = $order->getOrder($this->store_session['store_id'], $order_id);
    	$order['address'] = !empty($order['address']) ? unserialize($order['address']) : '';
    	$tmp_products = $order_product->getProducts($order_id);
    	$products = array();
    	foreach ($tmp_products as $product) {
    		$products[] = array(
    				'product_id' => $product['product_id'],
    				'name' => $product['name'],
    				'price' => $product['pro_price'],
    				'quantity' => $product['pro_num'],
    				'skus' => !empty($product['sku_data']) ? unserialize($product['sku_data']) : '',
    				'url' => $this->config['wap_site_url'] . '/good.php?id=' . $product['product_id'],
    		);
    	}
    	$order['products'] = $products;
    
    	// 查看满减送
    	$order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);
    	// 使用优惠券
    	$order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);
    	$money = 0;
    	foreach ($order_ward_list as $order_ward) {
    		$money += $order_ward['content']['cash'];
    	}
    
    	if (!empty($order_coupon)) {
    		$money += $order_coupon['money'];
    	}
    
    	$order['reward_money'] = round($money, 2);
    
    
    	// 满减/送、优惠券、折扣
    	$order['manjian']=0;
    	$order['coupon'] ="0";
    	$order['zhehouyouhui']="0";
    
    	import('source.class.Order');
    	$order_data = Order::orderDiscount($order, $tmp_products);
    	//echo json_encode($order_data);exit;
    	if ($order_data['order_ward_list']) {
    		foreach ($order_data['order_ward_list'] as $order_ward_list) {
    			foreach ($order_ward_list as $order_ward) {
    				$discount_money += $order_ward['content']['cash'];
    				//满减
    				$order['manjian'] = number_format($order_ward['content']['cash'], 2);
    			}
    		}
    	}
    
    	if ($order_data['order_coupon_list']) {
    		foreach ($order_data['order_coupon_list'] as $order_coupon) {
    			$discount_money += $order_coupon['money'];
    			//优惠券
    			$order['coupon'] = number_format($order_coupon['money'], 2);
    		}
    	}
    	$order['manjian'] = $order['coupon']+$order['manjian'];
    	if($order_data['discount_money']) {
    		$discount_money += $order_data['discount_money'];
    		//折后优惠
    		$order['zhehouyouhui'] = number_format($order_data['discount_money'], 2);
    
    	}
    	$discount_money -= $order['float_amount'];
    	echo json_encode($order);
    	exit;
    }
    
    //订单浮动金额
    public function float_amount()
    {
        $order = M('Order');		
        $store_id = $this->store_session['store_id'];
        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $float_amoumt = isset($_POST['float_amount']) ? floatval(trim($_POST['float_amount'])) : 0;
        $postage = isset($_POST['postage']) ? floatval(trim($_POST['postage'])) : 0;
        $sub_total = isset($_POST['sub_total']) ? floatval(trim($_POST['sub_total'])) : 0;

        // 满减/送、优惠券、折扣
        $order_list = $order->getOrder($this->store_session['store_id'], $order_id);
        import('source.class.Order');
        $order_data = Order::orderDiscount($order_list, "",1);
        
        $fx_postage_arr = unserialize($order_list['fx_postage']);
        if (isset($fx_postage_arr[$this->store_session['store_id']])) {
        	$fx_postage_arr[$this->store_session['store_id']] = $postage;
        	$fx_postage =  serialize($fx_postage_arr);
        }

        $total = $sub_total + $postage + $float_amoumt - $money - $order_data;
        $result = $order->setFields($store_id, $order_id, array('postage' => $postage, 'float_amount' => $float_amoumt, 'total' => $total,'fx_postage'=>$fx_postage));
        if ($result || $result === 0) {
            json_return(0, array('total' => $total, 'postage' => $postage));
        } else {
            json_return(1001, '修改失败！');
        }
    }

   
    //所有订单
    public function all()
    {
        $this->display();
    }

    private function _all_content($data)
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');

        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['third_id']) {
            $where['third_id'] = $data['third_id'];
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if ($data['trade_no']) {
            $where['trade_no'] = $data['trade_no'];
        }
        if (!empty($data['user'])) {
            $where['address_user'] = $data['user'];
        }
        if (!empty($data['tel'])) {
            $where['address_tel'] = $data['tel'];
        }
        if (!empty($data['payment_method'])) {
            $where['payment_method'] = $data['payment_method'];
        }
        if (!empty($data['shipping_method'])) {
            $where['shipping_method'] = $data['shipping_method'];
        }
        
        $data['is_show_activity_data'] = '0';	//不显示 活动订单
        if(!$data['is_show_activity_data']) {
        	// $where['activity_data'] = array('is_null', "is_null");
        }

        $field = '';
        if (!empty($data['time_type'])) {
            $field = $data['time_type'];
        }
        if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
            $where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
        } else if (!empty($data['start_time']) && !empty($field)) {
            $where[$field] = array('>=', strtotime($data['start_time']));
        } else if (!empty($data['stop_time']) && !empty($field)) {
            $where[$field] = array('<=', strtotime($data['stop_time']));
        }

        // 活动订单
        if (!empty($data['activity_type'])) {
            $where['activity_type'] = $data['activity_type'];
        }

        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
		}

        $tmp_types = array();
        if (!$this->checkFx(true)) {
            $tmp_types[] = 5;
            $where['type'] = array('not in', $tmp_types);
        }
        if (!$this->checkDrp(true)) {
            $tmp_types[] = 3;
            $where['type'] = array('not in', $tmp_types);
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
        }

		$order_total = $order->getOrderTotal($where);

        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
        $orders = array();
        foreach ($tmp_orders as $tmp_order) {

            $user_order = $tmp_order;
            if (!empty($tmp_order['user_order_id'])) {
                $user_order = D('Order')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                //订单实付金额
                $tmp_order['pay_amount'] = $user_order['total'];
            }

            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7) {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }


            $is_supplier = false;
            $is_packaged = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
                    $is_supplier = true;
                }
            }
            if (empty($tmp_order['suppliers'])) {
                $is_supplier = true;
            }

            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx'])) {
                    $has_my_product = true;
                }

                //自营商品
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) {
                    $is_supplier = true;
                }

                //商品来源
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
                    $product['is_ws'] = 1;
                } else { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;

                //向后兼容利润计算
                $no_profit = false;
                if ($product['profit'] == 0) {
                    $fx_order = D('Fx_order')->field('fx_order_id')->where(array('order_id' => $tmp_order['order_id']))->find();
                    $fx_order_product = D('Fx_order_product')->field('cost_price')->where(array('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
                    $product['cost_price'] = $fx_order_product['cost_price'];
                    $product['profit'] = $product['pro_price'] - $product['cost_price'];
                    if ($product['profit'] <= 0) {
                        $product['profit'] = 0;
                        $no_profit = true;
                    }
                }

                $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit)) {
                    $product['profit'] = $product['pro_price'];
                    $product['cost_price'] = 0;
                }

                $product['profit'] = number_format($product['profit'], 2, '.', '');
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');

                //零售价
                if (!empty($tmp_order['user_order_id'])) {
                    if ($tmp_order['type'] == 3) {
                        $tmp_order_product = D('Order_product')->field('pro_price')->where(array('order_id' => $tmp_order['user_order_id'], 'product_id' => $product['product_id']))->find();
                        $product['sale_price'] = $tmp_order_product['pro_price'];
                    } else if ($tmp_order['type'] == 5) {
                        $tmp_order_product = D('Order_product')->field('pro_price')->where(array('order_id' => $tmp_order['user_order_id'], 'original_product_id' => $product['product_id']))->find();
                        $product['sale_price'] = $tmp_order_product['pro_price'];
                    }
                }

                //退货商品
                $return_products = D('Return_product')->field('product_id,pro_num')->where(array('order_id' => $tmp_order['order_id'], 'order_product_id' => $product['pigcms_id']))->select();
                if (!empty($return_products)) {
                    foreach ($return_products as $return_product) {
                        $product['return_quantity'] += $return_product['pro_num'];
                    }
                }
            }

            if (!empty($user_order['suppliers']) && in_array($this->store_session['store_id'], explode(',', $user_order['suppliers']))) {
                //退货的分销利润
                $return_profit = 0;
                //和当前订单相关的退货
                $return_products = D('Return_product')->field('product_id,pro_num')->where(array('order_id' => $tmp_order['order_id']))->select();
                if (!empty($return_products)) {
                    foreach ($return_products as $return_product) {
                        $order_return_product = D('Order_product')->field('profit')->where(array('product_id' => $return_product['product_id'], 'user_order_id' => $tmp_order['user_order_id']))->find();
                        $return_profit += $order_return_product['profit'] * $return_product['pro_num'];
                    }
                }
                $tmp_order['return_profit'] = number_format($return_profit, 2, '.', '');
            }

            if (!empty($tmp_order['user_order_id'])) {
                $order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                $seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
                $tmp_order['seller'] = $seller['name'];
            } else {
                $tmp_order['seller'] = '本店';
            }

            $un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
            if (count($un_package_selfsale_products) == 0) {
                $is_packaged = true;
            }

            $profit = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id'], 'type' => array('!=', 3), 'income' => array('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0) {
                //$cost = $profit;
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['is_supplier'] = $is_supplier;
            $tmp_order['is_packaged'] = $is_packaged;
            $tmp_order['profit'] = number_format($profit, 2, '.', '');
            //$tmp_order['cost'] = number_format($cost, 2, '.', '');
            $tmp_order['cost'] = $tmp_order['total'] - $tmp_order['postage'] - $tmp_order['profit'];
            $tmp_order['cost'] = number_format($tmp_order['cost'], 2, '.', '');

            $return = D('Return')->where(array('order_id' => $tmp_order['order_id']))->sum('product_money + postage_money');
            $tmp_order['return'] = ($return > 0) ? number_format($return, 2, '.', '') : 0;

            if (empty($tmp_order['is_fx']) && empty($tmp_order['user_order_id'])) { //店铺直销订单
                $tmp_order['marketed_channel'] = '该订单通过本店直销完成交易，请进入“收入/提现”页面看收入或提现';
            } else {
                $tmp_order['marketed_channel'] = '该订单通过分销商分销完成交易，请进入“收入/提现”页面看收入或提现';
            }

            if ($tmp_order['type'] != 5) {
                //查看是否有未支付的供货商订单
                $not_paid_orders = M('Order')->getNotPaidSupplierOrders($tmp_order['order_id']);
                //未支付供货商订单总额
                $not_paid_total = 0;
                if (!empty($not_paid_orders)) {
                    foreach ($not_paid_orders as $not_paid_order) {
                        $not_paid_total += $not_paid_order['total'];
                    }
                }
                $tmp_order['not_paid_total'] = number_format($not_paid_total, 2, '.', '');
                $tmp_order['not_paid_orders'] = $not_paid_orders;

                //查看保证金支付的供货商订单
                $bond_pay_orders = M('Order')->getBondPaySupplierOrders($tmp_order['order_id']);
                //保证金支付供货商订单总额
                $bond_pay_total = 0;
                if (!empty($bond_pay_orders)) {
                    foreach ($bond_pay_orders as $bond_pay_order) {
                        $bond_pay_total += $bond_pay_order['total'];
                    }
                }
                $tmp_order['bond_pay_total'] = number_format($bond_pay_total, 2, '.', '');
                $tmp_order['bond_pay_orders'] = $bond_pay_orders;
            }

            $orders[] = $tmp_order;
        }

        //订单状态
        $order_status = $order->status();

        //订单状态别名
        $ws_alias_status = $order->ws_alias_status();

        //支付方式
        $payment_method = $order->getPaymentMethod();
        $this->assign('order_status', $order_status);
        $this->assign('ws_alias_status', $ws_alias_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    // 活动订单
    public function activity()
    {
        $this->display();
    }

    // 拷贝来自 $this->_all_content()  2015-12-22
    private function _activity_content($data)
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];

        $where['activity_id'] = array('>', 0);

        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
        }
        if (!empty($data['user'])) {
            $where['address_user'] = $data['user'];
        }
        if (!empty($data['tel'])) {
            $where['address_tel'] = $data['tel'];
        }
        if (!empty($data['payment_method'])) {
            $where['payment_method'] = $data['payment_method'];
        }
        if (!empty($data['shipping_method'])) {
            $where['shipping_method'] = $data['shipping_method'];
        }
        
        $data['is_show_activity_data'] = '0';   //不显示 活动订单
        if(!$data['is_show_activity_data']) {
            // $where['activity_data'] = array('is_null', "is_null");
        }

        $field = '';
        if (!empty($data['time_type'])) {
            $field = $data['time_type'];
        }
        if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
            $where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
        } else if (!empty($data['start_time']) && !empty($field)) {
            $where[$field] = array('>=', strtotime($data['start_time']));
        } else if (!empty($data['stop_time']) && !empty($field)) {
            $where[$field] = array('<=', strtotime($data['stop_time']));
        }

        if (!empty($data['activity_type'])) {
            $where['activity_type'] = $data['activity_type'];
        }

        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
        }

        $order_total = $order->getOrderTotal($where);

        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
        $orders = array();
        foreach ($tmp_orders as $tmp_order) {

            $user_order = $tmp_order;
            if (!empty($tmp_order['user_order_id'])) {
                $user_order = D('Order')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                //订单实付金额
                $tmp_order['pay_amount'] = $user_order['total'];
            }

            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7) {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }

            $is_supplier = false;
            $is_packaged = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
                    $is_supplier = true;
                }
            }
            if (empty($tmp_order['suppliers'])) {
                $is_supplier = true;
            }

            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx'])) {
                    $has_my_product = true;
                }

                //自营商品
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) {
                    $is_supplier = true;
                }

                //商品来源
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
                    $product['is_ws'] = 1;
                } else { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;

                //向后兼容利润计算
                $no_profit = false;
                if ($product['profit'] == 0) {
                    $fx_order = D('Fx_order')->field('fx_order_id')->where(array('order_id' => $tmp_order['order_id']))->find();
                    $fx_order_product = D('Fx_order_product')->field('cost_price')->where(array('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
                    $product['cost_price'] = $fx_order_product['cost_price'];
                    $product['profit'] = $product['pro_price'] - $product['cost_price'];
                    if ($product['profit'] <= 0) {
                        $product['profit'] = 0;
                        $no_profit = true;
                    }
                }

                $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit)) {
                    $product['profit'] = $product['pro_price'];
                    $product['cost_price'] = 0;
                }

                $product['profit'] = number_format($product['profit'], 2, '.', '');
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');

                //零售价
                if (!empty($tmp_order['user_order_id'])) {
                    if ($tmp_order['type'] == 3) {
                        $tmp_order_product = D('Order_product')->field('pro_price')->where(array('order_id' => $tmp_order['user_order_id'], 'product_id' => $product['product_id']))->find();
                        $product['sale_price'] = $tmp_order_product['pro_price'];
                    } else if ($tmp_order['type'] == 5) {
                        $tmp_order_product = D('Order_product')->field('pro_price')->where(array('order_id' => $tmp_order['user_order_id'], 'original_product_id' => $product['product_id']))->find();
                        $product['sale_price'] = $tmp_order_product['pro_price'];
                    }
                }

                //退货商品
                $return_products = D('Return_product')->field('product_id,pro_num')->where(array('order_id' => $tmp_order['order_id'], 'order_product_id' => $product['pigcms_id']))->select();
                if (!empty($return_products)) {
                    foreach ($return_products as $return_product) {
                        $product['return_quantity'] += $return_product['pro_num'];
                    }
                }
            }

            if (!empty($user_order['suppliers']) && in_array($this->store_session['store_id'], explode(',', $user_order['suppliers']))) {
                //退货的分销利润
                $return_profit = 0;
                //和当前订单相关的退货
                $return_products = D('Return_product')->field('product_id,sku_id,pro_num')->where(array('order_id' => $tmp_order['order_id']))->select();
                if (!empty($return_products)) {
                    foreach ($return_products as $return_product) {
                        $order_return_product_profit = D('Order_product')->where(array('product_id' => $return_product['product_id'], 'sku_id' => $return_product['sku_id'], 'user_order_id' => $tmp_order['user_order_id']))->sum('profit');
                        $return_profit += ($order_return_product_profit * $return_product['pro_num']);
                    }
                }
                $tmp_order['return_profit'] = number_format($return_profit, 2, '.', '');
            }

            if (!empty($tmp_order['user_order_id'])) {
                $order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                $seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
                $tmp_order['seller'] = $seller['name'];
            } else {
                $tmp_order['seller'] = '本店';
            }

            $un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
            if (count($un_package_selfsale_products) == 0) {
                $is_packaged = true;
            }

            $profit = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id'], 'type' => array('!=', 3), 'income' => array('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0) {
                //$cost = $profit;
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['is_supplier'] = $is_supplier;
            $tmp_order['is_packaged'] = $is_packaged;
            $tmp_order['profit'] = number_format($profit, 2, '.', '');
            //$tmp_order['cost'] = number_format($cost, 2, '.', '');
            $tmp_order['cost'] = $tmp_order['total'] - $tmp_order['postage'] - $tmp_order['profit'];
            $tmp_order['cost'] = number_format($tmp_order['cost'], 2, '.', '');

            $return = D('Return')->where(array('order_id' => $tmp_order['order_id']))->sum('product_money + postage_money');
            $tmp_order['return'] = ($return > 0) ? number_format($return, 2, '.', '') : 0;

            if (empty($tmp_order['is_fx']) && empty($tmp_order['user_order_id'])) { //店铺直销订单
                $tmp_order['marketed_channel'] = '该订单通过本店直销完成交易，请进入“收入/提现”页面看收入或提现';
            } else {
                $tmp_order['marketed_channel'] = '该订单通过分销商分销完成交易，请进入“收入/提现”页面看收入或提现';
            }

            $orders[] = $tmp_order;
        }

        //订单状态
        $order_status = $order->status();

        //订单状态别名
        $ws_alias_status = $order->ws_alias_status();

        //支付方式
        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('ws_alias_status', $ws_alias_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    //到店自提
    public function selffetch()
    {
        $this->display();
    }

    //货到付款订单 cash on delivery
    public function codpay()
    {
        $this->display();
    }

    //代付的订单
    public function pay_agent()
    {
        $this->display();
    }

    //订单概况
    public function check()
    {
        $this->display();
    }

    //加星订单
    public function star()
    {
        $this->display();
    }

    //订单概况
    private function _dashboard()
    {
        $order = M('Order');
        $financial_record = M('Financial_record');

        $days = array();
        for ($i = 6; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime('-' . $i . 'day'));
            $days[] = $day;
        }
        //7天下单笔数
        $where = array();
        //开始时间
        $start_time = strtotime($days[0] . ' 00:00:00');
        //结束时间
        $stop_time = strtotime($days[count($days) - 1] . '23:59:59');
        $where['store_id'] = $this->store_session['store_id'];
        $where['status'] = array('>', 0);
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
        $week_orders = $order->getOrderCount($where);

        $this->assign('start_time', date('Y-m-d H:i:s', $start_time));
        $this->assign('stop_time', date('Y-m-d H:i:s', $stop_time));

        //待付款订单数
        $not_paid_orders = $order->getOrderCount(array('store_id' => $this->store_session['store_id'], 'status' => 1));
        //待发货订单数
        $not_send_orders = $order->getOrderCount(array('store_id' => $this->store_session['store_id'], 'status' => 2));
        //已发货订单数
        $send_orders = $order->getOrderCount(array('store_id' => $this->store_session['store_id'], 'status' => 3));

        //7天收入
        $where = array();
        //开始时间
        $start_time = strtotime($days[0] . ' 00:00:00');
        //结束时间
        $stop_time = strtotime($days[count($days) - 1] . '23:59:59');
        $where['store_id'] = $this->store_session['store_id'];
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
        $days_7_income = $financial_record->getTotal($where);
        $days_7_income = ($days_7_income > 0) ? $days_7_income : 0;
        $days_7_income = number_format($days_7_income, 2, '.', '');

        //昨日下单笔数
        $where = array();
        $day = date("Y-m-d", strtotime('-1 day'));
        //开始时间
        $start_time = strtotime($day . ' 00:00:00');
        //结束时间
        $stop_time = strtotime($day . ' 23:59:59');
        $where['store_id'] = $this->store_session['store_id'];
        $where['status'] = array('>', 0);
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
        $yesterday_orders = $order->getOrderCount($where);
        $this->assign('yesterday_start_time', date('Y-m-d H:i:s', $start_time));
        $this->assign('yesterday_stop_time', date('Y-m-d H:i:s', $stop_time));

        //昨日付款订单
        $where['status'] = array('in', array(2, 3, 4));
        $where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
        $yesterday_paid_orders = $order->getOrderCount($where);

        //昨日发货订单
        $where['status'] = array('in', array(3, 4));
        $where['_string'] = "sent_time >= '" . $start_time . "' AND sent_time <= '" . $stop_time . "'";
        $yesterday_send_orders = $order->getOrderCount($where);

        //七天下单、付款、发货订单笔数
        $days_7_orders = array();
        $days_7_paid_orders = array();
        $days_7_send_orders = array();
        $tmp_days = array();
        foreach ($days as $day) {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $stop_time = strtotime($day . ' 23:59:59');
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('>', 0);
            $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
            $days_7_orders[] = $order->getOrderCount($where);

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(2, 3, 4));
            $where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
            $days_7_paid_orders[] = $order->getOrderCount($where);

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(3, 4));
            $where['_string'] = "sent_time >= '" . $start_time . "' AND sent_time <= '" . $stop_time . "'";
            $days_7_send_orders[] = $order->getOrderCount($where);

            $tmp_days[] = "'" . $day . "'";
        }
        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_orders = '[' . implode(',', $days_7_orders) . ']';
        $days_7_paid_orders = '[' . implode(',', $days_7_paid_orders) . ']';
        $days_7_send_orders = '[' . implode(',', $days_7_send_orders) . ']';

        //本店销售额
        $store = D('Store')->field('sales')->where(array('store_id' => $this->store_session['store_id']))->find();
        $store_sales = !empty($store['sales']) ? $store['sales'] : 0;

        //分销商销售额
        $seller_sales = D('Store')->where(array('root_supplier_id' => $this->store_session['store_id']))->sum('sales');

        //经销商销售额
        $dealer_sales = D('Supp_dis_relation')->where(array('supplier_id' => $this->store_session['store_id']))->sum('sales');

        //总销售额
        $sales = $store_sales + $seller_sales + $dealer_sales;


        $this->assign('week_orders', $week_orders);
        $this->assign('not_paid_orders', $not_paid_orders);
        $this->assign('not_send_orders', $not_send_orders);
        $this->assign('send_orders', $send_orders);
        $this->assign('yesterday_orders', $yesterday_orders);
        $this->assign('yesterday_paid_orders', $yesterday_paid_orders);
        $this->assign('yesterday_send_orders', $yesterday_send_orders);
        $this->assign('days', $days);
        $this->assign('days_7_orders', $days_7_orders);
        $this->assign('days_7_paid_orders', $days_7_paid_orders);
        $this->assign('days_7_send_orders', $days_7_send_orders);
        $this->assign('days_7_income', $days_7_income);
        $this->assign('sales', number_format($sales, 2, '.', ''));
    }

    //到店自提
    private function _selffetch_content($data)
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['shipping_method'] = 'selffetch';
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
        }
        if (!empty($data['user'])) {
            $where['address_user'] = $data['user'];
        }
        if (!empty($data['tel'])) {
            $where['address_tel'] = $data['tel'];
        }
        if (!empty($data['payment_method'])) {
            $where['payment_method'] = $data['payment_method'];
        }
        if (!empty($data['shipping_method'])) {
            $where['shipping_method'] = $data['shipping_method'];
        }
        $field = '';
        if (!empty($data['time_type'])) {
            $field = $data['time_type'];
        }
        if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
            $where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
        } else if (!empty($data['start_time']) && !empty($field)) {
            $where[$field] = array('>=', strtotime($data['start_time']));
        } else if (!empty($data['stop_time']) && !empty($field)) {
            $where[$field] = array('<=', strtotime($data['stop_time']));
        }
        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
        }
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
            } else {
                $tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
            }
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
                    $is_supplier = true;
                }
            }
            if (empty($tmp_order['suppliers'])) {
                $is_supplier = true;
            }
            $tmp_order['is_supplier'] = $is_supplier;
            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx'])) {
                    $has_my_product = true;
                }

                //商品来源
                if (empty($product['supplier_id'])) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
                } else { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;
                $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                if ($product['profit'] == 0 && empty($product['original_product_id'])) {
                    $product['profit'] = $product['pro_price'];
                }
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');
            }

            $profit = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id'], 'income' => array('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0) {
                $cost = $profit;
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['profit'] = number_format($profit, 2, '.', '');
            $tmp_order['cost'] = number_format($cost, 2, '.', '');
            $orders[] = $tmp_order;
        }

        $order_status = $order->status();

        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    private function _codpay_content($data)
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['payment_method'] = 'codpay';
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
        }
        if (!empty($data['user'])) {
            $where['address_user'] = $data['user'];
        }
        if (!empty($data['tel'])) {
            $where['address_tel'] = $data['tel'];
        }
        if (!empty($data['payment_method'])) {
            $where['payment_method'] = $data['payment_method'];
        }
        if (!empty($data['shipping_method'])) {
            $where['shipping_method'] = $data['shipping_method'];
        }
        $field = '';
        if (!empty($data['time_type'])) {
            $field = $data['time_type'];
        }
        if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
            $where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
        } else if (!empty($data['start_time']) && !empty($field)) {
            $where[$field] = array('>=', strtotime($data['start_time']));
        } else if (!empty($data['stop_time']) && !empty($field)) {
            $where[$field] = array('<=', strtotime($data['stop_time']));
        }
        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
        }
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
                    $is_supplier = true;
                }
            }
            $tmp_order['is_supplier'] = $is_supplier;
            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx'])) {
                    $has_my_product = true;
                }

                //商品来源
                if (empty($product['supplier_id'])) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
                } else { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;
            }
            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $orders[] = $tmp_order;
        }

        $order_status = $order->status();

        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    private function _pay_agent_content($data)
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['type'] = 1;
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
        }
        if (!empty($data['user'])) {
            $where['address_user'] = $data['user'];
        }
        if (!empty($data['tel'])) {
            $where['address_tel'] = $data['tel'];
        }
        if (!empty($data['payment_method'])) {
            $where['payment_method'] = $data['payment_method'];
        }
        if (!empty($data['shipping_method'])) {
            $where['shipping_method'] = $data['shipping_method'];
        }
        $field = '';
        if (!empty($data['time_type'])) {
            $field = $data['time_type'];
        }
        if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
            $where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
        } else if (!empty($data['start_time']) && !empty($field)) {
            $where[$field] = array('>=', strtotime($data['start_time']));
        } else if (!empty($data['stop_time']) && !empty($field)) {
            $where[$field] = array('<=', strtotime($data['stop_time']));
        }
        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
        }
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
                    $is_supplier = true;
                }
            }
            $tmp_order['is_supplier'] = $is_supplier;
            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx'])) {
                    $has_my_product = true;
                }
            }
            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $orders[] = $tmp_order;
        }

        $order_status = $order->status();

        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    private function _star_content($data)
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['star'] = array('>', 0);
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
        }
        if (!empty($data['user'])) {
            $where['address_user'] = $data['user'];
        }
        if (!empty($data['tel'])) {
            $where['address_tel'] = $data['tel'];
        }
        if (!empty($data['payment_method'])) {
            $where['payment_method'] = $data['payment_method'];
        }
        if (!empty($data['shipping_method'])) {
            $where['shipping_method'] = $data['shipping_method'];
        }
        $field = '';
        if (!empty($data['time_type'])) {
            $field = $data['time_type'];
        }
        if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
            $where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
        } else if (!empty($data['start_time']) && !empty($field)) {
            $where[$field] = array('>=', strtotime($data['start_time']));
        } else if (!empty($data['stop_time']) && !empty($field)) {
            $where[$field] = array('<=', strtotime($data['stop_time']));
        }

        // 活动订单
        if (!empty($data['activity_type'])) {
            $where['activity_type'] = $data['activity_type'];
        }
        
        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`star` DESC';
        }
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array();
        foreach ($tmp_orders as $tmp_order) {

            $user_order = $tmp_order;
            if (!empty($tmp_order['user_order_id'])) {
                $user_order = D('Order')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                //订单实付金额
                $tmp_order['pay_amount'] = $user_order['total'];
            }

            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7) {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }

            $is_packaged = false;
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
                    $is_supplier = true;
                }
            }
            $tmp_order['is_supplier'] = $is_supplier;
            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx'])) {
                    $has_my_product = true;
                }

                //自营商品
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) {
                    $is_supplier = true;
                }

                //商品来源
                if (empty($product['supplier_id'])) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
                    $product['is_ws'] = 1;
                } else { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;

                //向后兼容利润计算
                $no_profit = false;
                if ($product['profit'] == 0) {
                    $fx_order = D('Fx_order')->field('fx_order_id')->where(array('order_id' => $tmp_order['order_id']))->find();
                    $fx_order_product = D('Fx_order_product')->field('cost_price')->where(array('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
                    $product['cost_price'] = $fx_order_product['cost_price'];
                    $product['profit'] = $product['pro_price'] - $product['cost_price'];
                    if ($product['profit'] <= 0) {
                        $product['profit'] = 0;
                        $no_profit = true;
                    }
                }

                $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit)) {
                    $product['profit'] = $product['pro_price'];
                    $product['cost_price'] = 0;
                }

                $product['profit'] = number_format($product['profit'], 2, '.', '');
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');

                //零售价
                if (!empty($tmp_order['user_order_id'])) {
                    if ($tmp_order['type'] == 3) {
                        $tmp_order_product = D('Order_product')->field('pro_price')->where(array('order_id' => $tmp_order['user_order_id'], 'product_id' => $product['product_id']))->find();
                        $product['sale_price'] = $tmp_order_product['pro_price'];
                    } else if ($tmp_order['type'] == 5) {
                        $tmp_order_product = D('Order_product')->field('pro_price')->where(array('order_id' => $tmp_order['user_order_id'], 'original_product_id' => $product['product_id']))->find();
                        $product['sale_price'] = $tmp_order_product['pro_price'];
                    }
                }

                //退货商品
                $return_products = D('Return_product')->field('product_id,pro_num')->where(array('order_id' => $tmp_order['order_id'], 'order_product_id' => $product['pigcms_id']))->select();
                if (!empty($return_products)) {
                    foreach ($return_products as $return_product) {
                        $product['return_quantity'] += $return_product['pro_num'];
                    }
                }
            }

            if (!empty($user_order['suppliers']) && in_array($this->store_session['store_id'], explode(',', $user_order['suppliers']))) {
                //退货的分销利润
                $return_profit = 0;
                //和当前订单相关的退货
                $return_products = D('Return_product')->field('product_id,pro_num')->where(array('order_id' => $tmp_order['order_id']))->select();
                if (!empty($return_products)) {
                    foreach ($return_products as $return_product) {
                        $order_return_product = D('Order_product')->field('profit')->where(array('product_id' => $return_product['product_id'], 'user_order_id' => $tmp_order['user_order_id']))->find();
                        $return_profit += $order_return_product['profit'] * $return_product['pro_num'];
                    }
                }
                $tmp_order['return_profit'] = number_format($return_profit, 2, '.', '');
            }

            $profit = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id'], 'income' => array('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0) {
                //$cost = $profit;
            }

            $un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
            if (count($un_package_selfsale_products) == 0) {
                $is_packaged = true;
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['is_supplier'] = $is_supplier;
            $tmp_order['is_packaged'] = $is_packaged;
            $tmp_order['profit'] = number_format($profit, 2, '.', '');
            //$tmp_order['cost'] = number_format($cost, 2, '.', '');
            $tmp_order['cost'] = $tmp_order['total'] - $tmp_order['postage'] - $tmp_order['profit'];
            $tmp_order['cost'] = number_format($tmp_order['cost'], 2, '.', '');

            $return = D('Return')->where(array('order_id' => $tmp_order['order_id']))->sum('product_money + postage_money');
            $tmp_order['return'] = ($return > 0) ? number_format($return, 2, '.', '') : 0;

            if (empty($tmp_order['is_fx']) && empty($tmp_order['user_order_id'])) { //店铺直销订单
                $tmp_order['marketed_channel'] = '该订单通过本店直销完成交易，请进入“收入/提现”页面看收入或提现';
            } else {
                $tmp_order['marketed_channel'] = '该订单通过分销商分销完成交易，请进入“收入/提现”页面看收入或提现';
            }

            $orders[] = $tmp_order;
        }

        //订单状态
        $order_status = $order->status();

        //订单状态别名
        $ws_alias_status = $order->ws_alias_status();

        //支付方式
        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('ws_alias_status', $ws_alias_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    // 门店下 订单列表
    private function _physical_order_content($data)
    {

        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
        }
        if (!empty($data['user'])) {
            $where['address_user'] = $data['user'];
        }
        if (!empty($data['tel'])) {
            $where['address_tel'] = $data['tel'];
        }
        if (!empty($data['payment_method'])) {
            $where['payment_method'] = $data['payment_method'];
        }
        if (!empty($data['shipping_method'])) {
            $where['shipping_method'] = $data['shipping_method'];
        }
        $field = '';
        if (!empty($data['time_type'])) {
            $field = $data['time_type'];
        }
        if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
            $where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
        } else if (!empty($data['start_time']) && !empty($field)) {
            $where[$field] = array('>=', strtotime($data['start_time']));
        } else if (!empty($data['stop_time']) && !empty($field)) {
            $where[$field] = array('<=', strtotime($data['stop_time']));
        }

        //过滤为本门店
        $order_ids = M('Order_product')->getOrderByPhysical($this->user_session['item_store_id']);
        $where['order_id'] = array('in', $order_ids);

        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
        }
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
        $orders = array();

        foreach ($tmp_orders as $tmp_order) {

            $send_couriered = false;
            if ($this->user_session['type'] == 1) {         // 属于本门店的order_product
                $products = $order_product->getProductsPhysical($tmp_order['order_id'], $this->user_session['item_store_id']);

                // 门店中是否分配完
                // 该订单 该门店 是否完全打包了 order_product
                $physical_ops = $order_product->getUnAssignProducts($tmp_order['order_id'], $this->user_session['item_store_id']);
                if (empty($physical_ops)) {
                    $send_couriered = true;
                }

            } else {
                $products = $order_product->getProducts($tmp_order['order_id']);
            }

            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7) {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }

            $is_supplier = false;
            $is_packaged = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
                    $is_supplier = true;
                }
            }
            if (empty($tmp_order['suppliers'])) {
                $is_supplier = true;
            }

            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx'])) {
                    $has_my_product = true;
                }

                //自营商品
                if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) {
                    $is_supplier = true;
                }
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            if (!empty($tmp_order['user_order_id'])) {
                $order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                $seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
                $tmp_order['seller'] = $seller['name'];
            }

            $un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
            if (count($un_package_selfsale_products) == 0) {
                $is_packaged = true;
            }
            $tmp_order['is_supplier'] = $is_supplier;
            $tmp_order['is_packaged'] = $is_packaged;
            $tmp_order['send_couriered'] = $send_couriered;
            $orders[] = $tmp_order;
        }
        // dump($orders);exit;

        //订单状态
        $order_status = $order->status();

        //支付方式
        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    //订单备注
    public function save_bak()
    {
        $order = M('Order');

        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
        $bak = isset($_POST['bak']) ? trim($_POST['bak']) : '';

        if ($order->setBak($order_id, $bak)) {
            json_return(0, '保存成功');
        } else {
            json_return(1001, '保存失败');
        }
    }

    //订单加星
    public function add_star()
    {
        $order = M('Order');

        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $star = isset($_POST['star']) ? intval(trim($_POST['star'])) : 0;

        if ($order->addStar($order_id, $star)) {
            json_return(0, '加星成功');
        } else {
            json_return(1001, '加星失败');
        }
    }

    //取消订单
    public function cancel_status()
    {
        $order = M('Order');

        $store_id = $this->store_session['store_id'];
        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $time = time();

        $order_detail = $order->get(array('store_id' => $store_id, 'order_id' => $order_id));

        if ($order->cancelOrder($order_detail, 1)) {
            json_return(0, date('Y-m-d H:i:s', $time));
        } else {
            json_return(1001, date('Y-m-d H:i:s', $time));
        }
    }

    //订单统计
    public function statistics()
    {
        $this->display();
    }

    public function _statistics_content($data)
    {
        $order = M('Order');

        $days = array();
        if (empty($data['start_time']) && empty($data['stop_time'])) {
            for ($i = 6; $i >= 0; $i--) {
                $day = date("Y-m-d", strtotime('-' . $i . 'day'));
                $days[] = $day;
            }
        } else if (!empty($data['start_time']) && !empty($data['stop_time'])) {
            $start_unix_time = strtotime($data['start_time']);
            $stop_unix_time = strtotime($data['stop_time']);
            $tmp_days = round(($stop_unix_time - $start_unix_time) / 3600 / 24);
            $days = array($data['start_time']);
            if ($data['stop_time'] > $data['start_time']) {
                for ($i = 1; $i < $tmp_days; $i++) {
                    $days[] = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
                }
                $days[] = $data['stop_time'];
            }
        } else if (!empty($data['start_time'])) { //开始时间到后6天的数据
            $stop_time = date("Y-m-d", strtotime($data['start_time'] . ' +7 day'));
            $days = array($data['start_time']);
            for ($i = 1; $i <= 6; $i++) {
                $day = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
                $days[] = $day;
            }
        } else if (!empty($data['stop_time'])) { //结束时间前6天的数据
            $start_time = date("Y-m-d", strtotime($data['stop_time'] . ' -6 day'));
            $days = array($start_time);
            for ($i = 1; $i <= 6; $i++) {
                $day = date("Y-m-d", strtotime($start_time . ' +' . $i . 'day'));
                $days[] = $day;
            }
        }

        //七天下单、付款、发货订单笔数和付款金额
        $days_7_orders = array();
        $days_7_paid_orders = array();
        $days_7_send_orders = array();
        $days_7_paid_total = array();
        $tmp_days = array();
        foreach ($days as $day) {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $stop_time = strtotime($day . ' 23:59:59');

            //下单笔数
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('>', 0);
            $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
            $days_7_orders[] = $order->getOrderCount($where);

            //付款订单
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(2, 3, 4, 7));
            $where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
            $days_7_paid_orders[] = $order->getOrderCount($where);

            //发货订单
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(3, 4, 7));
            $where['_string'] = "sent_time >= '" . $start_time . "' AND sent_time <= '" . $stop_time . "'";
            $days_7_send_orders[] = $order->getOrderCount($where);

            //付款金额
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(2, 3, 4, 7));
            $where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
            $amount = $order->getOrderAmount($where);
            $days_7_paid_total[] = number_format($amount, 2, '.', '');

            $tmp_days[] = "'" . $day . "'";
        }
        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_orders = '[' . implode(',', $days_7_orders) . ']';
        $days_7_paid_orders = '[' . implode(',', $days_7_paid_orders) . ']';
        $days_7_send_orders = '[' . implode(',', $days_7_send_orders) . ']';
        $days_7_paid_total = '[' . implode(',', $days_7_paid_total) . ']';

        $this->assign('days', $days);
        $this->assign('days_7_orders', $days_7_orders);
        $this->assign('days_7_paid_orders', $days_7_paid_orders);
        $this->assign('days_7_send_orders', $days_7_send_orders);
        $this->assign('days_7_paid_total', $days_7_paid_total);
    }

	//商品打包
	public function package_product() {
		// 获取发货的收货地址，送他人订单会有此值
		$order_friend_address_id = $_REQUEST['order_friend_address_id'];
		
		$order = M('Order');
		$order_product = M('Order_product');
		$express = M('Express');
		$store_physical_quantity = M('Store_physical_quantity');
		$store_physical = M('Store_physical');
		$store_id = $this->store_session['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '页面错误，请刷新浏览器后，重试');
			exit;
		}

		//快递公司
		$express = $express->getExpress();

		$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		
		if (empty($order_id)) {
			json_return(1000, '缺少参数');
		}
		
		$data = array();
		$order = $order->getOrder($this->store_session['store_id'], $order_id);
		
		if (empty($order)) {
			json_return(1000, '未找到相应的订单');
		}
		
		$order_friend_address_list = array();
		$send_other = false;
		// 送他人进行相关处理,送单人、送多人处理，送公益与普通订单一样处理
		if ($order['shipping_method'] == 'send_other' && $order['send_other_type'] != 2) {
			$send_other = true;
			$order_friend_address_list = D('Order_friend_address')->where("order_id = '" . $order['order_id'] . "' OR order_id = '" . $order['user_order_id'] . "'")->select();
			
			// 已过有效期，礼品没有领完，直接给默认收货地址
			if (time() - $order['paid_time'] > $order['send_other_hour'] * 3600 && count($order_friend_address_list) < $order['send_other_number']) {
				$count = D('Order_friend_address')->where("(order_id = '" . $order['order_id'] . "' OR order_id = '" . $order['user_order_id'] . "') AND `default` = 1")->count('id');
				if (empty($count)) {
					$data = array();
					$data['dateline'] = time();
					$data['order_id'] = $order['order_id'];
					$data['uid'] = $order['uid'];
					$data['store_id'] = $this->store_session['store_id'];	// 如果是分销商的订单，无须记录店铺ID
					$data['name'] = $order['address_user'];
					$data['phone'] = $order['address_tel'];
					$data['pro_num'] = ($order['send_other_number'] - count($order_friend_address_list)) * $order['send_other_per_number'];
					$data['address'] = $order['address'];
					$data['package_id'] = 0;
					$data['default'] = 1;
					
					$id = D('Order_friend_address')->data($data)->add();
					$data['id'] = $id;
					$order_friend_address_list[] = $data;
				}
			}
		}
		
		// 删除已发过货的收货地址
		$friend_address = array();
		foreach ($order_friend_address_list as $key => &$order_friend_address) {
			$order_friend_address['address'] = unserialize($order_friend_address['address']);
			$order_friend_address['package_dateline'] = date('Y-m-d H:i', $order_friend_address['package_dateline']);
			if ($order_friend_address['id'] == $order_friend_address_id) {
				if ($order_friend_address['package_id'] == 1) {
					json_return(1000, '此收货地址已发货');
				}
				$friend_address = $order_friend_address;
			}
			
			if ($order_friend_address['package_id'] > 0) {
				continue;
			}
			
			if (empty($friend_address)) {
				$friend_address = $order_friend_address;
			}
		}
		
		$tmp_products = $order_product->getUnPackageProducts(array('op.order_id' => $order_id, 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));

		$products = array();
		foreach ($tmp_products as $tmp_product) {
			$tmp_number = $tmp_product['pro_num'];
			if ($order['shipping_method'] == 'send_other' && $order['send_other_type'] != 2) {
				$tmp_number = $friend_address['pro_num'];
			}
			
			$sku_data = unserialize($tmp_product['sku_data']);
			$products[] = array(
							'order_product_id' => $tmp_product['order_product_id'],
							'product_id' => $tmp_product['product_id'],
							'name' => $tmp_product['name'],
							'pro_num' => $tmp_number,
							'skus' => $sku_data,
							'sku_data' => $tmp_product['sku_data']
			);
		}
		
		if ($order['shipping_method'] == 'send_other' && $order['send_other_type'] != 2) {
			$address = $friend_address['address'];
			$address['name'] = $friend_address['name'];
			$address['tel'] = $friend_address['phone'];
		} else {
			$address = unserialize($order['address']);
			$address['name'] = !empty($order['address_user']) ? $order['address_user'] : '';
			$address['tel'] = !empty($order['address_tel']) ? $order['address_tel'] : '';
		}
		
		$data = array();
		$data['address'] = $address;
		$data['products'] = $products;
		$data['express'] = $express;
		$data['send_other'] = $send_other;
		$data['order_friend_address_list'] = $order_friend_address_list;
		$data['friend_address'] = $friend_address;
		
		echo json_encode($data);
		exit;
	}

    //创建包裹
    public function create_package()
    {
        $order = M('Order');
        $fx_order = M('Fx_order');
        $order_product = M('Order_product');
        $order_package = M('Order_package');
        $sku_data = isset($_POST['sku_data']) ? $_POST['sku_data'] : array();
        $sku_data = join("','", $sku_data);

        $data = array();
        $data['store_id'] = $this->store_session['store_id'];
        $data['order_id'] = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $data['products'] = isset($_POST['products']) ? trim($_POST['products']) : 0;
        $data['express_company'] = isset($_POST['express_company']) ? trim($_POST['express_company']) : '';
        $data['express_no'] = isset($_POST['express_no']) ? trim($_POST['express_no']) : '';
        $data['express_code'] = isset($_POST['express_id']) ? trim($_POST['express_id']) : '';
        $data['status'] = 1; //已发货
        $data['add_time'] = time();
        $data['order_products'] = isset($_POST['order_products']) ? trim($_POST['order_products']) : '';

        //门店打包到配送员
        $data['physical_id'] = $this->user_session['item_store_id'];
        $data['courier_id'] = isset($_POST['courier']) ? intval($_POST['courier']) : 0;
        // if (!empty($data['physical_id']) && empty($data['courier_id'])) {
        //     json_return(1002, '门店打包请选择配送员');
        // }
        if ($data['courier_id']) {
            $whereCourier = array('order_id' => $data['order_id']);
            $order->editStatus($whereCourier, array('has_physical_send' => 1));
        }

        if (!empty($data['products'])) {
            $data['products'] = explode(',', $data['products']);
            $data['products'] = array_unique($data['products']);
            $data['products'] = implode(',', $data['products']);
        }

        if (empty($data['order_id']) || empty($data['store_id'])) {
            json_return(1002, '参数有误，包裹创建失败！');
        }

        $order_info = $order->getOrder($data['store_id'], $data['order_id']);

        if (empty($order_info)) {
            json_return(1002, '参数有误，包裹创建失败！');
        }
        
        if ($order_info['shipping_method'] == 'send_other' && $order_info['send_other_type'] != '2') {
        	json_return(1002, '参数有误，包裹创建失败！');
        }
        $data['user_order_id'] = !empty($order_info['user_order_id']) ? $order_info['user_order_id'] : $order_info['order_id'];
        //分销商和供货商的订单
        $where = array();
        $where['_string'] = "order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "'";
        $orders = D('Order')->field('order_id,suppliers,user_order_id,uid')->where($where)->select();

        if ($order_package->add($data)) { //添加包裹

            //货到付款同步库存
            if (strtolower($order_info['payment_method']) == 'codpay' && !empty($data['products'])) {
                $tmp_product_list = explode(',', $data['products']);
                foreach ($tmp_product_list as $key => $tmp_product_id) {
                    $sku_data_arr = explode("','", $sku_data);

                    $properties = '';
                    if (!empty($sku_data_arr[$key])) {
                        $properties = $this->_getProperty2Str($sku_data_arr[$key]);
                    }
                    if (!empty($sku_data_arr[$key])) {
                        $tmp_order_product = D('Order_product')->field('pigcms_id,pro_num')->where(array('order_id' => $data['order_id'], 'product_id' => $tmp_product_id, 'sku_data' => $sku_data_arr[$key]))->find();
                    } else {
                        $tmp_order_product = D('Order_product')->field('pigcms_id,pro_num')->where(array('order_id' => $data['order_id'], 'product_id' => $tmp_product_id))->find();
                    }
                    //退货数量
                    $return_quantity = M('Return_product')->returnNumber($data['order_id'], $tmp_order_product['pigcms_id'], true);
                    //实际购买数量
                    $quantity = $tmp_order_product['pro_num'] - $return_quantity;

                    if ($quantity <= 0) {
                        continue;
                    }

                    //更新库存
                    D('Product')->where(array('product_id' => $tmp_product_id))->setDec('quantity', $quantity);
                    if (!empty($properties)) { //更新商品属性库存
                        D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setDec('quantity', $quantity);
                    }
                    //更新销量
                    D('Product')->where(array('product_id' => $tmp_product_id))->setInc('sales', $quantity); //更新销量
                    if (!empty($properties)) { //更新商品属性销量
                        D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setInc('sales', $quantity);
                    }
                    //同步批发商品库存、销量
                    $wholesale_products = D('Product')->field('product_id')->where(array('wholesale_product_id' => $tmp_product_id))->select();
                    if (!empty($wholesale_products)) {
                        foreach ($wholesale_products as $wholesale_product) {
                            //更新库存
                            D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setDec('quantity', $quantity);
                            if (!empty($properties)) { //更新商品属性库存
                                D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setDec('quantity', $quantity);
                            }
                            //更新销量
                            D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setInc('sales', $quantity); //更新销量
                            if (!empty($properties)) { //更新商品属性销量
                                D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setInc('sales', $quantity);
                            }
                        }
                    }
                }
            }

            $where = array();
            if (!empty($sku_data)) {
                $where['_string'] = "order_id = '" . $data['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . ")) AND sku_data in ('" . $sku_data . "')";
            } else {
                $where['_string'] = "order_id = '" . $data['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . "))";
            }
            $result = $order_product->setPackageInfo($where, array('is_packaged' => 1, 'in_package_status' => 1));
            if ($result) {
                //订单中含有此商品的均设置为已打包
                $where = array();
                if (!empty($sku_data)) {
                    $where['_string'] = "(order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "') AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . ")) AND sku_data in ('" . $sku_data . "')";
                } else {
                    $where['_string'] = "(order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "') AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . "))";
                }
                D('Order_product')->where($where)->data(array('is_packaged' => 1, 'in_package_status' => 1))->save();
            }

            $order_product->getUnPackageProducts(array('op.order_id' => $data['order_id'], 'p.store_id' => $this->store_session['store_id']));

            //获取当前订单未打包的商品
            $un_package_products = $order_product->getUnPackageProducts(array('op.order_id' => $data['order_id'], 'p.store_id' => $this->store_session['store_id']));
            $un_package_products = count($un_package_products);
            if ($un_package_products == 0) { //已全部打包发货
                $time = time();
                $where = array();
                $where['order_id'] = $data['order_id'];
                $where['status'] = 2;
                //当订单中的所有商品均打包，设置订单状态为已发货
                $order->editStatus($where, array('status' => 3, 'sent_time' => $time));
                //设置订单商品状态为已打包
                foreach ($orders as $tmp_order_info) {
                    //含有当前店铺发布的商品(自营或供货商商品)的订单
                    if (!empty($tmp_order_info['suppliers']) && in_array($this->store_session['store_id'], explode(',', $tmp_order_info['suppliers']))) {
                        $where = array();
                        if (!empty($sku_data)) {
                            $where['_string'] = "order_id = '" . $tmp_order_info['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . ")) AND sku_data in ('" . $sku_data . "')";
                        } else {
                            $where['_string'] = "order_id = '" . $tmp_order_info['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . "))";
                        }

                        $order_product->setPackageInfo($where, array('is_packaged' => 1, 'in_package_status' => 1));
                    }

                    if ($tmp_order_info['user_order_id'] == 0) {
                        $main_user_info = D('User')->where(array('uid' => $tmp_order_info['uid']))->field('openid,phone')->find();
                    }
                }
                $un_package_products = $order_product->getUnPackageProducts(array('op.user_order_id' => $data['user_order_id']));
                $un_package_products = count($un_package_products);
                //所有相关订单均打包
                if ($un_package_products == 0) {
                    $where = array();
                    $where['_string'] = "(order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "') AND status = 2";
                    $order->editStatus($where, array('status' => 3, 'sent_time' => $time));

                    $fx_order->setStatus(array('user_order_id' => $data['user_order_id']), array('status' => 3, 'supplier_sent_time' => time()));

                    if ($order->getOrderCount(array('order_id' => $data['user_order_id'], 'status' => array('in', array(3, 4))))) {
                        $user_order_info = $order->get(array('order_id' => $data['user_order_id']));
                        M('Store_user_data')->upUserData($user_order_info['store_id'], $user_order_info['uid'], 'send'); //修改已发货订单数
                    }
                }
                if (!empty($order_info['fx_order_id'])) {
                    $fx_order->setPackaged($order_info['fx_order_id']); //设置分销订单状态为已打包
                }
            } else {
                //更新本店订单状态（店铺自营商品全部发货）
                /*$un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $data['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0, 'product_id' => array('not in' , $data['products'])));
                if (count($un_package_selfsale_products) == 0) {
                    $time = time();
                    $where = array();
                    $where['order_id'] = $data['order_id'];
                    $where['status']   = 2;
                    //当订单中的所有商品均打包，设置订单状态为已发货
                    $order->editStatus($where, array('status' => 3, 'sent_time' => $time));
                }*/
            }

			//////////////////////////////////////////////////////////////////////////////////////////////////
			//产生提醒-已发货
			import('source.class.Notice');
			$express_company = $data['express_company'] ? $data['express_company'] : "";
			$express_no = $data['express_no'] ? $data['express_no']:"";
			Notice::OrderShipped($order_info, $this->store_session['store_id'], $express_company, $express_no); 
			//////////////////////////////////////////////////////////////////////////////////////////////////

			
            //发送买家消息通知end
            json_return(0, '包裹创建成功');
        } else {
            json_return(1001, '包裹创建失败');
        }
    }
	
	// 送他人创建包裹,送单人和送多人创建包裹
	public function create_package_friend() {
		$order = M('Order');
		$fx_order = M('Fx_order');
		$order_product = M('Order_product');
		$order_package = M('Order_package');
		$address_id = $_POST['address_id'];
		$sku_data = isset($_POST['sku_data']) ? $_POST['sku_data'] : array();
		$address_id = $_POST['address_id'];
		$sku_data = join("','", $sku_data);
		
		$data = array();
		$data['store_id'] = $this->store_session['store_id'];
		$data['order_id'] = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		$data['products'] = isset($_POST['products']) ? trim($_POST['products']) : 0;
		$data['express_company'] = isset($_POST['express_company']) ? trim($_POST['express_company']) : '';
		$data['express_no'] = isset($_POST['express_no']) ? trim($_POST['express_no']) : '';
		$data['express_code'] = isset($_POST['express_id']) ? trim($_POST['express_id']) : '';
		$data['status'] = 1; //已发货
		$data['add_time'] = time();
		$data['order_products'] = isset($_POST['order_products']) ? trim($_POST['order_products']) : '';
		
		if (!empty($data['products'])) {
			$data['products'] = explode(',', $data['products']);
			$data['products'] = array_unique($data['products']);
			$data['products'] = implode(',', $data['products']);
		}
		
		if (empty($data['order_id']) || empty($data['store_id']) || empty($address_id) || empty($data['products'])) {
			json_return(1002, '参数有误，包裹创建失败！');
		}
		
		// 有快递公司，没有运单号
		if (!empty($data['express_code']) && empty($data['express_no'])) {
			json_return(1000, '请填写快递单号');
		}
		
		$order = $order->getOrder($data['store_id'], $data['order_id']);
		
		if (empty($order)) {
			json_return(1002, '参数有误，包裹创建失败！');
		}
		
		if ($order['shipping_method'] != 'send_other') {
			json_return(1002, '参数有误，包裹创建失败！');
		}
		
		$order_friend_address = D('Order_friend_address')->where(array('id' => $address_id))->find();
		if ($order_friend_address['package_id']) {
			json_return(1000, '此收货地址已发货');
		}
		
		// 订单与收货地址信息不统一
		if ($order_friend_address['order_id'] != $order['order_id'] && $order_friend_address['order_id'] != $order['user_order_id']) {
			json_return(1000, '收货地址与订单信息不统一');
		}
		
		$data['user_order_id'] = $order['user_order_id'] ? $order['user_order_id'] : $order['order_id'];
		$package_id = D('Order_package')->data($data)->add();
		if ($package_id) {
			$data = array();
			$data['package_id'] = $package_id;
			$data['package_dateline'] = time();
			D('Order_friend_address')->where(array('id' => $address_id))->data($data)->save();
			
			// 检查是否全部商品都发完货，都发完货，需要把订单改为已发货
			$send_pro_num = D('Order_friend_address')->where("(order_id = '" . $order['order_id'] . "' OR order_id = '" . $order['user_order_id'] . "') AND package_id > 0")->sum('pro_num');
			$order_product = D('Order_product')->where(array('order_id' => $order['order_id']))->field('pro_num')->find();
			
			// 已全部发货，更改订单状态为已发货，相关产品改为已打包
			$is_all = false;
			if ($send_pro_num >= $order_product['pro_num']) {
				$is_all = true;
				D('Order_product')->where("order_id = '" . $order['order_id'] . "' OR order_id = '" . $order['user_order_id'] . "'")->data(array('is_packaged' => 1, 'in_package_status' => 1))->save();
				D('Order')->where("order_id = '" . $order['order_id'] . "' OR user_order_id = '" . $order['user_order_id'] . "'")->data(array('sent_time' => time(), 'status' => 3))->save();
			}
			
			//产生提醒-已发货
			import('source.class.Notice');
			$express_company = $data['express_company'] ? $data['express_company'] : "";
			$express_no = $data['express_no'] ? $data['express_no']:"";
			Notice::OrderShipped($order, $this->store_session['store_id'], $express_company, $express_no);
			
			if ($is_all) {
				json_return(0, 1);
			} else {
				// 查看是否还有未发货的地址
				$count = D('Order_friend_address')->where("(order_id = '" . $order['order_id'] . "' OR order_id = '" . $order['user_order_id'] . "') AND package_id = 0")->count('id');
				if ($count) {
					json_return(0, 2);
				} else {
					json_return(0, 1);
				}
			}
		} else {
			json_return(1000, '创建包裹失败');
		}
	}
	
    //分配订单商品(包裹)到门店
    public function package_product_physical()
    {

        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $store_id = $this->store_session['store_id'];

        $order = M('Order');
        $order_product = M('Order_product');
        $store_physical = M('Store_physical');
        $store_physical_quantity = M('Store_physical_quantity');

        $physicals = $store_physical->getList($store_id);
        if (empty($physicals)) {
            json_return(1, '请先添加门店');
        }

        $data = array();
        $order = $order->getOrder($store_id, $order_id);

        // 自提订单 货到付款订单 不分配
        if ($order['payment_method'] == 'codpay' || $order['shipping_method'] == 'selffetch') {
            json_return(1, '货到付款或自提订单不支持门店配送');
        }

        // 过滤已经分配到门店的包裹
        $tmp_products = $order_product->getUnPackageSkuProducts($order_id);

        //门店
        $data['physical'] = D('Store_physical')->where(array('store_id' => $this->store_session['store_id']))->select();

        $products = array();
        foreach ($tmp_products as $tmp_product) {

            if (!empty($data['physical'])) {

                $physical = $data['physical'];

                foreach ($physical as $k => $v) {

                    $where = array(
                        'product_id' => $tmp_product['product_id'],
                        'sku_id' => $tmp_product['sku_id'],
                        'physical_id' => $v['pigcms_id'],
                    );
                    $quantity = D('Store_physical_quantity')->where($where)->find();
                    $physical[$k]['quantity'] = !empty($quantity) ? $quantity['quantity'] : 0;

                }

            }

            $sku_data = unserialize($tmp_product['sku_data']);
            $products[] = array(
                'order_product_id' => $tmp_product['order_product_id'],
                'product_id' => $tmp_product['product_id'],
                'name' => $tmp_product['name'],
                'pro_num' => $tmp_product['pro_num'],
                'skus' => $sku_data,
                'physical' => $physical,
                'sku_data' => $tmp_product['sku_data']
            );
        }

        $address = unserialize($order['address']);
        $address['name'] = !empty($order['address_user']) ? $order['address_user'] : '';
        $address['tel'] = !empty($order['address_tel']) ? $order['address_tel'] : '';

        $data['physicals_desc'] = array();
        $data['baidu_map'] = array();

        $address['address'] = str_replace(' ', '', $address['address']);

        //收货地址换取坐标
        import('Http');
        $http_class = new Http();
        $url = "http://api.map.baidu.com/place/v2/search?q=" . $address['address'] . "&region=" . $address['city'] . "&output=json&ak=4c1bb2055e24296bbaef36574877b4e2";
        $map_json = $http_class->curlGet($url);
        $address_map = json_decode($map_json, true);

        if ($map_json && !empty($address_map['results'])) {
            reset($address_map['results']) & $first = current($address_map['results']);
            $data['baidu_map'] = $first;
            $store_list = $store_physical->nearshops($first['location']['lng'], $first['location']['lat'], $store_id);
            $data['physicals_desc'] = $store_list;
        }

        $data['address'] = $address;
        $data['products'] = $products;
        $data['express'] = $express;
        echo json_encode($data);
        exit;
    }

    //保存分配货单到门店
    public function product_physical_save()
    {

        $store_id = $this->store_session['store_id'];
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
        $physical_id = isset($_POST['physical_id']) ? $_POST['physical_id'] : 0;

        $order_products = isset($_POST['order_products']) ? $_POST['order_products'] : array();

        if (empty($order_id) || empty($order_products)) {
            json_return(1001, '缺少参数，修改失败');
        }

        foreach ($order_products as $order_product) {
            $where = array('pigcms_id' => $order_product, 'order_id' => $order_id);
            M('Order_product')->setPackageInfo($where, array('sp_id' => $physical_id));

            // 消减库存
            $op_info = M('Order_product')->getProduct($order_product);
            D('Store_physical_quantity')->where(array('product_id' => $op_info['product_id'], 'sku_id' => $op_info['sku_id'], 'physical_id' => $physical_id))->setDec('quantity', $op_info['pro_num']);
        }

        $op_all = M('Order_product')->orderProduct($order_id, false);

        $ops = M('Order_product')->getUnPackageSkuProducts($order_id);
        if (count($ops) == 0) {     //全部分配完毕
            // M('Order')->where(array("order_id"=>$order_id))->save(array("is_assigned"=>1));
            M('Order')->editStatus(array("order_id" => $order_id), array("is_assigned" => 2));
        } else if (count($ops) > 0 && count($ops) < count($op_all)) {
            M('Order')->editStatus(array("order_id" => $order_id), array("is_assigned" => 1));
        }

        json_return(0, '分配订单商品到门店成功');
    }

    //ajax弹层 门店获取发货单
    public function package_product_phy()
    {

        //获取 order_product sp_id = physical_id项
        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        if ($order_id == 0)
            json_return(1001, '缺少参数!');
        if ($this->user_session['item_store_id'] == 0)
            json_return(1001, '参数异常，请用门店管理员登录');

        $physical_id = $this->user_session['item_store_id'];

        $order = M('Order');
        $order_product = M('Order_product');
        $express = M('Express');


        //快递公司
        $express = $express->getExpress();

        $data = array();

        //获取配送员
        // $data['courier'] = M('User')->getList(array('type'=>2, 'item_store_id'=>$physical_id));
        $data['courier'] = D('Store_physical_courier')->where(array('physical_id' => $physical_id, 'status' => 1))->select();
        if (empty($data['courier'])) {
            json_return(1001, '请先为本店绑定并添加配送员');
        }


        $order = $order->getOrder($this->store_session['store_id'], $order_id);
        $tmp_products = $order_product->getUnAssignProducts($order_id, $this->user_session['item_store_id']);
        $products = array();
        foreach ($tmp_products as $tmp_product) {
            $sku_data = unserialize($tmp_product['sku_data']);
            $products[] = array(
                'order_product_id' => $tmp_product['order_product_id'],
                'product_id' => $tmp_product['product_id'],
                'name' => $tmp_product['name'],
                'pro_num' => $tmp_product['pro_num'],
                'skus' => $sku_data,
                'sku_data' => $tmp_product['sku_data']
            );
        }
        $address = unserialize($order['address']);
        $address['name'] = !empty($order['address_user']) ? $order['address_user'] : '';
        $address['tel'] = !empty($order['address_tel']) ? $order['address_tel'] : '';
        $data['address'] = $address;
        $data['products'] = $products;
        $data['express'] = $express;
        echo json_encode($data);
        exit;
    }

    //交易完成
    public function complate_status()
    {
        /**
         * $order_uncomplated  判断整个订单交易是否完成
         */
        if (IS_POST) {
            $order = M('Order');
            $order_product = M('Order_product');
            $fx_order = M('Fx_order');
            $financial_record = M('Financial_record');
            $return = M('Return');
            $return_product = M('Return_product');
            $store = M('Store');

            $store_id = !empty($this->store_session['store_id']) ? $this->store_session['store_id'] : 0;
            $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
            $offline  = false; //是否是货到付款订单

            if (empty($store_id)) {
                json_return(1001, '参数异常，店铺不存在');
            }

            //订单详细
            $order_info = $order->getOrder($store_id, $order_id);

            if (empty($order_info)) {
                json_return(1001, '参数异常，订单不存在');
            } else if ($order_info['status'] != 7 && $order_info['status'] != 6) {
            	$config_order_return_date = option('config.order_return_date');
				$config_order_complete_date = option('config.order_complete_date');
				if ((($order_info['status'] == 7 && ($order_info['delivery_time'] + $config_order_return_date * 24 * 3600 < time() || $order_info['sent_time'] + $config_order_complete_date * 24 * 3600 < time())) || ($order_info['status'] == 3 && $order_info['sent_time'] + $config_order_complete_date * 24 * 3600 < time())) && $order_info['returning_count'] == 0) {
					
				} else {
					json_return(1001, '订单状态不正确，交易无法完成');
				}
            }

            //退货中的订单
            $returning = $return->getOrderReturning($order_id);
            if (!empty($returning)) {
                json_return(1001, '订单退货中，交易无法完成');
            }

            //获取本订单相关退货金额（供货商是当前店铺）
            $sql = "SELECT SUM(r.product_money) AS return_sub_total, SUM(r.postage_money) AS return_postage FROM " . option('system.DB_PREFIX') . "return r, " . option('system.DB_PREFIX') . "return_product rp WHERE r.id = rp.return_id AND rp.supplier_id = r.store_id AND r.order_id = '" . $order_id . "' AND r.store_id = '" . $store_id . "'";
            $return_detail = D('')->query($sql);
            //退货商品金额
            $order_returns_sub_total = !empty($return_detail[0]['return_sub_total']) ? $return_detail[0]['return_sub_total'] : 0;
            //退货运费
            $order_returns_postage   = !empty($return_detail[0]['return_postage']) ? $return_detail[0]['return_postage'] : 0;
            //退货总额
            $order_returns_total = $order_returns_sub_total + $order_returns_postage;

            $user_order_id = !empty($order_info['user_order_id']) ? $order_info['user_order_id'] : $order_id;
            //用户主订单
            $user_order_info = $order->get(array('order_id' => $user_order_id));
            $uid = $user_order_info['uid']; //购买者id
            //产生订单的店铺
            $user_order_store = D('Store')->field('store_id,drp_team_id')->where(array('store_id' => $user_order_info['store_id']))->find();

            //订单商品
            $order_products = $order_product->getProducts($order_id);
            //自营商品
            $my_products = array();
            if (!empty($order_products)) {
                foreach ($order_products as $product) {
                    if ($product['store_id'] == $store_id && empty($product['supplier_id'])) {
                        $my_products[] = $product['product_id'];
                    }
                }
            }

            if (empty($my_products)) {
                json_return(1001, '操作失败，没有店铺自营商品');
            }

            //订单运费
            $postage = $order_info['postage'];
            if (!empty($order_info['fx_postage'])) {
                $postage = unserialize($order_info['fx_postage']);
                $postage = !empty($postage[$store_id]) ? $postage[$store_id] : 0;
            }

            //供货商订单
            $dealer_id         = 0;
            $order_uncomplated = 0; //交易是否未完成(如果>0表示有其它供货商或经销商未点交易完成)
            $is_supplier       = false;
            $is_dealer         = false;
            $dealer_order      = array();
            //if (empty($order_info['suppliers']) || $order_info['suppliers'] == $store_id) {
            if ($order_info['type'] == 5) { //供货商身份
                //经销商订单
                $sql = "SELECT o.* FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.supplier_id = '" . $store_id . "' AND ss.type = 0 AND (o.order_id = '" . $order_info['user_order_id'] . "' OR o.user_order_id  = '" . $order_info['user_order_id'] . "')";
                $dealer_order = D('')->query($sql);
                $dealer_order = !empty($dealer_order[0]) ? $dealer_order[0] : array();

                if (!empty($dealer_order)) {

                    //经销商订单商品
                    $order_products = $order_product->getProducts($dealer_order['order_id']);
                    //经销商自营商品
                    $dealer_products = array();
                    if (!empty($order_products)) {
                        foreach ($order_products as $product) {
                            if ($product['store_id'] == $dealer_order['store_id'] && empty($product['supplier_id'])) {
                                $dealer_products[] = $product['product_id'];
                            }
                        }
                    }

                    //经销商的其它供货商
                    $suppliers = $dealer_order['suppliers'];
                    $suppliers = explode(',', $suppliers);
                    $key = array_search($store_id, $suppliers);
                    if (!empty($suppliers[$key])) {
                        unset($suppliers[$key]);
                    }

                    //其它供货商订单
                    $where = array();
                    $where['user_order_id'] = !empty($dealer_order['user_order_id']) ? $dealer_order['user_order_id'] : $dealer_order['order_id'];
                    $where['store_id'] = array('in', $suppliers);
                    $where['status'] = array('!=', 4); //交易未完成
                    $order_uncomplated = D('Order')->where($where)->count('order_id'); //交易未完成(其它供货商)

                    //经销商
                    $dealer_id = $dealer_order['store_id'];
                    //供货商身份
                    $is_supplier = true;

                    if ($dealer_order['status'] != 4 && !empty($dealer_products)) { //交易未完成(有自营商品)
                        $order_uncomplated = 1;
                    }
                }
            } else if ($order_info['type'] == 3) { //经销商身份
                $is_dealer = true;
                //经销商
                $dealer_id = $store_id;
                //供货商
                $suppliers = $order_info['suppliers'];
                $suppliers = explode(',', $suppliers);
                $suppliers = array_diff($suppliers, array($store_id));

                //经销商的供货商订单
                $where = array();
                $where['user_order_id'] = !empty($order_info['user_order_id']) ? $order_info['user_order_id'] : $order_info['order_id'];
                $where['store_id'] = array('in', $suppliers);
                $where['status'] = array('!=', 4); //交易未完成
                $order_uncomplated = D('Order')->where($where)->count('order_id'); //交易未完成
            } else { //供货商身份
                $is_supplier = true;
            }

            //是否是货到付款订单
            if (!empty($user_order_info['payment_method']) && strtolower($user_order_info['payment_method']) == 'offline') {
                $offline = true;
            }

            //订单下的退货列表
            $tmp_returns = $return->getReturns($order_id);
            $returns = array();
            foreach ($tmp_returns as $tmp_return) {
                $returns[] = !empty($tmp_return['user_return_id']) ? $tmp_return['user_return_id'] : $tmp_return['id'];
            }

            $now = time();
            $where = array();
            $where['order_id'] = $order_id;
            $where['store_id'] = $store_id;
            $data = array();
            $data['status'] = 4;
            $data['complate_time'] = $now;

            //修改订单状态
            if ($order->editStatus($where, $data)) {
            //if (true) {
                //修改分销订单状态
                if (!empty($order_info['fx_order_id'])) {
                    $fx_order->setStatus(array('fx_order_id' => $order_info['fx_order_id']), array('status' => 4, 'complate_time' => $now));
                }

                //是否有分销订单
                $has_fx_order = true;
                $where = array();
                $where['_string'] = "(order_id = '" . $user_order_id . "' OR user_order_id = '" . $user_order_id . "')";
                //当前订单以及相关分销订单
                $orders = $order->getAllOrders($where, 'order_id ASC');

                //无分销
                if (empty($order_info['user_order_id']) && empty($order_info['is_fx'])) {
                    $has_fx_order = false;
                }

                //主订单商品
                $products = M('Order_product')->getProducts($user_order_id);

                import('source.class.Order');

                //订单活动（满减、优惠券、折扣）
                $activities = Order::orderDiscount($user_order_info, $products);

                //各店铺订单减免总额
                $order_coupon = array();
                //满减
                $order_ward_list = array();
                if (!empty($activities['order_ward_list'])) {
                    $order_ward_list = $activities['order_ward_list'];
                    foreach ($order_ward_list as $tmp_supplier_id => $rewards) {
                        foreach ($rewards as $reward) {
                            if ($reward['content']['cash'] > 0) {
                                $order_coupon[$tmp_supplier_id] += $reward['content']['cash'];
                            }
                        }
                    }
                }
                //优惠
                $order_coupon_list = array();
                if (!empty($activities['order_coupon_list'])) {
                    $order_coupon_list = $activities['order_coupon_list'];
                    foreach ($order_coupon_list as $tmp_supplier_id => $coupon) {
                        if ($coupon['money'] > 0) {
                            $order_coupon[$tmp_supplier_id] += $coupon['money'];
                        }
                    }
                }
                //折扣
                $order_discount_list = array();
                if (!empty($activities['discount_money_list'])) {
                    $order_discount_list = $activities['discount_money_list'];
                    foreach ($order_discount_list as $tmp_supplier_id => $discount_money) {
                        if ($discount_money > 0) {
                            $order_coupon[$tmp_supplier_id] += $discount_money;
                        }
                    }
                }

                //分销商商品利润
                $seller_product_profit = 0;
                //批发商品利润
                $dealer_product_profit = 0;
                //每次退货所含分销商利润
                $returns_seller_profit = array();
                //退货商品
                $return_products = $return_product->getReturnProducts($returns);
                if (!empty($return_products)) {
                    //分销商利润
                    $stores_profit = array();
                    foreach ($return_products as $tmp_return_product) {
                        $order_product_info = $order_product->getProduct($tmp_return_product['order_product_id']);
                        //分销商/经销商(减商品利润)
                        if ($order_product_info['store_id'] != $store_id) {
                            //单件商品利润
                            if (!empty($order_product_info['profit'])) {
                                $profit = $order_product_info['profit'] * $tmp_return_product['pro_num']; //利润x数量
                            }
                            if ($profit > 0) {
                                $stores_profit[$order_product_info['store_id']] += $profit;
                                $seller_product_profit += $profit;
                                //批发商品利润
                                if ($order_product_info['store_id'] == $dealer_id) {
                                    $dealer_product_profit += $profit;
                                }
                                $returns_seller_profit[$tmp_return_product['user_return_id']] += $profit;
                            }
                        }
                    }
                }

                if (!$has_fx_order) { //无分销和批发

                    $income = $financial_record->getOrderProfit($order_id, array(1,3));
                    $new_income = $income;
                    //退货金额
                    $return_amount = $order_returns_total;

                    if (!empty($order_info['useStorePay'])) {
                        $useStorePay = 1;
                    } else {
                        $useStorePay = 0;
                    }

                    //更新供货商店铺收入
                    $this->_update_store_income($order_info, $income, $new_income, $return_amount, $offline, $now, true, $useStorePay);

                    //退货减销售额
                    if ($return_amount > 0) {
                        $sales = $user_order_info['sales'] - $return_amount;
                        $sales = ($sales > 0) ? $sales : 0;
                        D('Store')->where(array('store_id' => $user_order_info['store_id']))->data(array('sales' => $sales))->save();
                    }

                    $sub_total = 0;
                    //当前店铺订单商品
                    $supplier_products = M('Order_product')->getProducts($order_id);
                    foreach ($supplier_products as $supplier_product) {
                        if (in_array($supplier_product['product_id'], $my_products)) { //当前店铺商品
                            $sub_total += $supplier_product['pro_price'] * $supplier_product['pro_num'];
                        }
                    }

                    //订单退货总额
                    if ($order_returns_total > 0) {
                        D('Financial_record')->where(array('store_id' => $store_id, 'order_id' => $order_id, 'type' => 3))->data(array('income' => (0 - $order_returns_total)))->save();
                    }

                    //更新
                    M('Store_user_data')->upUserData($order_info['store_id'], $order_info['uid'], 'complete', 1);
                    Points::orderPoint($order_info);
                } else {
                    foreach ($orders as $tmp_order) {

                        //订单供货商
                        if (!empty($tmp_order['suppliers'])) {
                            $suppliers = explode(',', $tmp_order['suppliers']);
                        } else {
                            $suppliers = array();
                        }
                        if (!in_array($store_id, $suppliers) || $tmp_order['store_id'] == $store_id) {
                            continue;
                        }

                        $tmp_store = D('Store')->field('drp_supplier_id')->where(array('store_id' => $tmp_order['store_id']))->find();
                        if (empty($tmp_store['drp_supplier_id']) && !empty($user_order_info['useStorePay'])) {
                            $useStorePay = 1;
                        } else {
                            $useStorePay = 0;
                        }

                        //只有一个供货商，并且是当前店铺
                        $single_supplier = false;
                        if ($tmp_order['suppliers'] == $store_id) {
                            $single_supplier = true;
                        }

                        //从当前供货商获取的利润
                        $seller_profit = 0;
                        $seller_products = M('Order_product')->getProducts($tmp_order['order_id']);
                        foreach ($seller_products as $seller_product) {
                            if (in_array($seller_product['original_product_id'], $my_products)) {
                                $seller_profit += $seller_product['profit'];
                            }
                        }

                        //退款金额
                        $return_amount = 0;
                        //订单收入
                        if ($single_supplier) {
                            $income = $financial_record->getOrderProfit($tmp_order['order_id'], array(1,3));;
                        } else {
                            $income = $seller_profit;
                        }
                        //退款后收入
                        $new_income = 0;
                        //订单收入 - 退货金额
                        if (!empty($stores_profit[$tmp_order['store_id']]) && $stores_profit[$tmp_order['store_id']] > 0) {
                            $return_amount = $stores_profit[$tmp_order['store_id']];
                            $new_income = $income - $return_amount;
                        } else {
                            $new_income = ($new_income > 0) ? $new_income : $income;
                        }

                        //更新经销商可提现金额(非经销商收款)
                        if ($tmp_order['type'] != 5 && empty($tmp_order['useStorePay'])) {
                            if ($tmp_order['store_id'] == $dealer_id) {
                                $income        = $order_info['sale_total'];
                                $new_income    = $order_info['sale_total'];
                                $return_amount = !empty($stores_profit[$tmp_order['store_id']]) ? $stores_profit[$tmp_order['store_id']] : 0;
                            }
                        }

                        //更新供货商店铺收入
                        $this->_update_store_income($tmp_order, $income, $new_income, $return_amount, $offline, $now, $single_supplier, $useStorePay);

                        if ($tmp_order['order_id'] == $user_order_info['order_id']) {
                            //退货减销售额
                            if ($order_returns_total > 0) {
                                $sales = $user_order_info['sales'] - $order_returns_total;
                                $sales = ($sales > 0) ? $sales : 0;
                                D('Store')->where(array('store_id' => $user_order_info['store_id']))->data(array('sales' => $sales))->save();
                            }
                        }
                    }

                    $total = 0;
                    $sub_total = 0;
                    //当前店铺订单商品
                    $supplier_products = M('Order_product')->getProducts($order_id);
                    foreach ($supplier_products as $supplier_product) {
                        if (in_array($supplier_product['product_id'], $my_products)) { //当前店铺商品
                            $sub_total += $supplier_product['pro_price'] * $supplier_product['pro_num'];
                        }
                    }
                    $total = $sub_total + $postage;

                    //订单收入
                    if ($is_dealer) { //经销商
                        $income = $total;
                        //订单金额减免
                        if (!empty($order_coupon[$store_id])) {
                            $income -= $order_coupon[$store_id];
                        }
                    } else {
                        $income = $financial_record->getOrderProfit($order_id, array(1,3));
                    }

                    //收回分销商商品利润
                    if ($seller_product_profit > 0 && empty($user_order_info['useStorePay'])) {
                        $new_income = $income + $seller_product_profit;

                        //更新收支记录
                        $financial_record->setOrderIncomeInc($order_id, $seller_product_profit);
                    } else {
                        $new_income = $income;
                    }

                    //平台代收款(供货商订单)
                    if (empty($order_info['useStorePay']) && $order_info['type'] == 5) {
                        $income        = $order_info['total'];
                        $new_income    = $order_info['total'];
                    } else if (empty($order_info['useStorePay']) && $order_info['type'] == 3) { //平台代收款(经销商订单)
                        $income        = $order_info['sale_total'];
                        $new_income    = $order_info['sale_total'];
                    }
                    //退货金额 = 退货总额 - 分销商利润
                    $return_amount = 0;
                    if ($order_returns_total > 0) {
                        $return_amount = $order_returns_total - $seller_product_profit;
                        $return_amount = ($return_amount > 0) ? $return_amount : 0;
                    }

                    if (!empty($order_info['useStorePay']) || !empty($order_info['use_deposit_pay'])) {
                        $useStorePay = 1;
                    }

                    //批发订单
                    if ($order_info['type'] == 5) {
                        if (!empty($dealer_product_profit) && !empty($dealer_id)) {
                            D('Supp_dis_relation')->where(array('distributor_id' => $dealer_id, 'supplier_id' => $store_id))->setDec('profit', $dealer_product_profit);
                        }
                    }

                    //更新供货商店铺收入
                    $this->_update_store_income($order_info, $income, $new_income, $return_amount, $offline, $now, true, $useStorePay);

                    if (empty($order_uncomplated)) { //交易完成

                        $where = array();
                        $where['status'] = array('!=', 4);
                        $where['_string'] = "(order_id = '" . $user_order_id . "' OR user_order_id  = '" . $user_order_id . "')";
                        $data = array();
                        $data['status'] = 4;
                        $data['complate_time'] = $now;
                        $order->editStatus($where, $data);

                        $where = array();
                        $where['user_order_id'] = $user_order_id;
                        $where['status'] = array('!=', 4);
                        $data = array();
                        $data['status'] = 4;
                        $data['complate_time'] = $now;
                        $fx_order->setStatus($where, $data);

                        //更新订单状态为已完成
                        $where = array();
                        $where['user_order_id'] = $user_order_id;
                        $where['status'] = 1;
                        $data = array();
                        $data['status'] = 3; //交易完成
                        M('Financial_record')->editStatus($where, $data);

                        //更新
                        M('Store_user_data')->upUserData($user_order_info['store_id'], $user_order_info['uid'], 'complete', 1);
                        Points::orderPoint($order_info);
                    }

                    //批发订单
                    if ($order_info['type'] == 5) {

                        $dealer_relation = D('Supp_dis_relation')->where(array('distributor_id' => $dealer_id, 'supplier_id' => $store_id))->find();

                        //订单是否是保证金付款
                        $bond_record = D('Bond_record')->where(array('supplier_id' => $store_id, 'order_id' => $order_id))->find();
                        if (!empty($bond_record)) {
                            //更新保证金扣款金额（减退货金额）
                            $balance_deduct_bond = ($bond_record['deduct_bond'] - $return_amount > 0) ? $bond_record['deduct_bond'] - $return_amount : 0;
                            $balance_residue_bond = $bond_record['residue_bond'] + $return_amount;
                            if (D('Bond_record')->where(array('bond_id' => $bond_record['bond_id']))->data(array('deduct_bond' => $balance_deduct_bond, 'status' => 1, 'residue_bond' => $balance_residue_bond))->save()) {
                                //更新经销商在当前供货商的保证余额（返还退货金额）
                                D('Supp_dis_relation')->where(array('supplier_id' => $store_id, 'distributor_id' => $bond_record['wholesale_id']))->setInc('bond', $return_amount);
                                //更新付款金额
                                if ($dealer_relation['paid'] >= $return_amount) {
                                    D('Supp_dis_relation')->where(array('distributor_id' => $dealer_id, 'supplier_id' => $store_id))->setDec('paid', $return_amount);
                                } else {
                                    D('Supp_dis_relation')->where(array('distributor_id' => $dealer_id, 'supplier_id' => $store_id))->setDec('paid', $dealer_relation['paid']);
                                }
                            }
                        }

                        //更新销售额
                        if ($return_amount > 0) {
                            if ($dealer_relation['sales'] >= $return_amount) {
                                D('Supp_dis_relation')->where(array('distributor_id' => $dealer_id, 'supplier_id' => $store_id))->setDec('sales', $return_amount);
                            } else {
                                D('Supp_dis_relation')->where(array('distributor_id' => $dealer_id, 'supplier_id' => $store_id))->setDec('sales', $dealer_relation['sales']);
                            }
                        }
                    }

                    //订单退货总额
                    if (!empty($tmp_returns)) {
                        foreach ($tmp_returns as $tmp_return) {
                            if (array_key_exists($tmp_return['user_return_id'], $returns_seller_profit)) {
                                $return_amount = !empty($returns_seller_profit[$tmp_return['user_return_id']]) ? $returns_seller_profit[$tmp_return['user_return_id']] : 0;
                                $return_amount = ($tmp_return['product_money'] + $tmp_return['postage_money']) - $return_amount;
                                $return_amount += $seller_product_profit;
                                if ($return_amount > 0) {
                                    D('Financial_record')->where(array('return_id' => $tmp_return['id'], 'store_id' => $store_id, 'order_id' => $order_id, 'type' => 3))->data(array('income' => (0 - $return_amount)))->save();
                                    //修改退货支出状态
                                    $where = array();
                                    $where['user_order_id'] = $user_order_id;
                                    $where['type']          = 3;
                                    $where['_string']       = "supplier_id = '" . $store_id . "' OR (store_id = '" . $store_id . "' AND supplier_id = 0)";
                                    D('Financial_record')->where($where)->data(array('status' => 3))->save();
                                }
                            }
                        }
                    }

                    //因退货更新团队总销售额
                    if (M('Drp_team')->checkDrpTeam($user_order_store['store_id'], true)) {
                        if (!empty($user_order_store['drp_team_id']) && $return_amount > 0) {
                            M('Drp_team')->setSalesDec($user_order_store['drp_team_id'], $return_amount);
                        }
                    }
                }
                
                /*====通知 start====*/
                //产生提醒-已生成订单
                import('source.class.Notice');
                Notice::orderComplete($order_info);
                /*====通知 end====*/

                json_return(0, '订单交易完成');
            } else {
                json_return(1001, '订单状态修改失败');
            }
        }
    }


    /**
     * 更新店铺收入
     * @param $store_id
     * @param $order_id
     * @param $income
     * @param $new_income
     */
    private function _update_store_income($order, $income, $new_income, $return_amount, $offline, $now, $status, $useStorePay = 0)
    {
        $store_id = $order['store_id'];
        $order_id = $order['order_id'];

        //货到付款不处理供货商收入
        if (!empty($offline) && $store_id == $this->store_session['store_id']) {
            return true;
        }

        //更新店铺收入
        if ($return_amount > 0) {
            D('Store')->where(array('store_id' => $store_id))->setDec('income', $return_amount);
        }

        if (empty($useStorePay)) {
            //更新店铺不可用余额
            if ($income > 0) {
                D('Store')->where(array('store_id' => $store_id))->setDec('unbalance', $income);
            }
            //更新店铺可提现余额
            if ($new_income > 0) {
                D('Store')->where(array('store_id' => $store_id))->setInc('balance', $new_income);
            }
        }

        if ($status) {

            //更新订单状态为已完成
            $where = array();
            $where['order_id'] = $order_id;
            $where['store_id'] = $store_id;
            $where['status'] = 1;

            $data = array();
            $data['status'] = 3; //交易完成
            M('Financial_record')->editStatus($where, $data);
        }

        return true;
    }

   


    //订单概况
    private function _check_content($data)
    {
        $order = M('Order');
        $supp_dis_relation = M('Supp_dis_relation');
        $return = M('Return');
        $financial_record = M('Financial_record');

        $store_id = $this->store_session['store_id'];

        $store = D('Store')->field('unbalance,balance')->where(array('store_id' => $store_id))->find();
        //在平台可提现金额
        //分销商分润
        $sql = "SELECT SUM(s.balance) AS balance,SUM(s.unbalance) AS unbalance FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND FIND_IN_SET(" . $store_id . ", ss.supply_chain) AND ss.type = 1";
        $sellers = D('')->query($sql);
        $seller_balance = !empty($sellers[0]['balance']) ? $sellers[0]['balance'] : 0;
        //待支出分润
        $seller_balance = number_format($seller_balance, 2, '.', '');

        //在平台不可提现金额
        //分销商分润
        $seller_unbalance = !empty($sellers[0]['unbalance']) ? $sellers[0]['unbalance'] : 0;
        //待支出分润
        $seller_unbalance = number_format($seller_unbalance, 2, '.', '');

        $where = array();
        $where['store_id'] = $this->store_session['store_id'];

        import('source.class.user_page');
        $where['store_id']    = $store_id;
        $where['useStorePay'] = 0;
        if (trim($_POST['third_id'])) {
            $where['third_id'] =  trim($_POST['third_id']);
        }
        if (trim($_POST['order_no'])) {
            $where['order_no'] =  trim($_POST['order_no']);
        }
        if (!empty($_POST['status']) && $_POST['status'] == 1) { //待结算
            $where['status'] = array('in', array(1,2,3,6,7));
        } else if (!empty($_POST['status']) && $_POST['status'] == 2) { //已结算
            $where['status'] = 4;
        } else if (!empty($_POST['status']) && $_POST['status'] == 3) { //已对账
            $where['is_check'] = 2;
        }
        if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
            $start_time = strtotime($_POST['start_time']);
            $stop_time  = strtotime($_POST['stop_time']);
            $where['_string'] = "add_time >= " . $start_time . " AND add_time <= " . $stop_time;
        } else if (!empty($_POST['start_time'])) {
            $start_time = strtotime($_POST['start_time']);
            $where['add_time'] = array('>=', $start_time);
        } else if (!empty($_POST['stop_time'])) {
            $stop_time = strtotime($_POST['stop_time']);
            $where['add_time'] = array('<=', $stop_time);
        }
        $order_count = $order->getOrderCount($where);
        $page = new Page($order_count, 15);

        $orders = $order->getOrders($where, 'order_id DESC', $page->firstRow, $page->listRows);
        foreach ($orders as &$tmp_order) {
            $user_order_id = !empty($tmp_order['user_order_id']) ? $tmp_order['user_order_id'] : $tmp_order['order_id'];

            //分润
            if ($tmp_order['type'] == 5) {
                $tmp_order['seller_profit'] = '0.00';
                $tmp_order['income'] = $tmp_order['total'];
                $tmp_order['profit'] = $tmp_order['total'];
            } else {

                if (!empty($tmp_order['user_order_id'])) {
                    $user_order = D('Order')->field('total')->where(array('order_id' => $user_order_id))->find();
                    $tmp_order['income'] = $user_order['total'];
                } else {
                    $tmp_order['income'] = $tmp_order['total'];
                }

                //分销商利润
                $seller_profit = D('Financial_record')->where(array('supplier_id' => $tmp_order['store_id'], 'user_order_id' => $user_order_id))->sum('income');
                $tmp_order['profit'] = $financial_record->getOrderProfit($tmp_order['order_id']);
                $tmp_order['seller_profit'] = number_format($seller_profit, 2, '.', '');
            }

            //退货
            $return_amount = $return->getOrderReturnAmount($tmp_order['order_id']);
            $tmp_order['return_amount'] = number_format($return_amount, 2, '.', '');

            //状态
            if ($tmp_order['status'] == 4) {
                $tmp_order['status'] = '已结算';
            } else if ($tmp_order['status'] == 1) {
                $tmp_order['status'] = '未支付';
            } else {
                $tmp_order['status'] = '未结算';
            }
            if ($tmp_order['is_check'] == 2) {
                $tmp_order['status'] = '已对账';
            }
        }

        $this->assign('balance', number_format($store['balance'], 2, '.', ''));
        $this->assign('unbalance', number_format($store['unbalance'], 2, '.', ''));
        $this->assign('seller_unbalance', $seller_unbalance);
        $this->assign('seller_balance', $seller_balance);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    public function seller_check()
    {
        $this->display();
    }

    private function _seller_check_content()
    {
        import('source.class.user_page');

        $store_withdrawal = M('Store_withdrawal');

        $store_id = $this->store_session['store_id'];


        $sql = "SELECT SUM(o.) AS total FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "financial_record fr WHERE fr.order_id = o.order_id AND (fr.supplier_id = '" . $store_id . "' OR fr.store_id = '" . $store_id . "') AND o.is_fx = 1 AND fr.status IN (1,3) AND fr.income > 0";
        $seller_sales = D('')->query($sql);
        if (!empty($seller_sales[0]['total'])) {
            $seller_sales = $seller_sales[0]['total'];
        } else {
            $seller_sales = 0;
        }

        $sql = "SELECT SUM(s.sales) AS sales, SUM(s.balance) AS balance FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND FIND_IN_SET(" . $store_id . ", ss.supply_chain) AND ss.type = 1";
        $sellers = D('')->query($sql);
        //销售总额
        if (!empty($sellers[0]['sales'])) {
            $seller_sales = $sellers[0]['sales'];
        } else {
            $seller_sales = 0;
        }
        //分销商可提现利润
        if (!empty($seller_profit[0]['balance'])) {
            $seller_profit_balance = $seller_profit[0]['balance'];
        } else {
            $seller_profit_balance = 0;
        }
        //已提现，待处理
        $seller_withdrawal_pending = $store_withdrawal->getWithdrawalAmount(array('supplier_id' => $store_id, 'status' => array(1,2), 'type' => 0));

        $seller_profit_balance += $seller_withdrawal_pending;

        //已支出(已提现)
        $seller_withdrawal_processed = $store_withdrawal->getWithdrawalAmount(array('supplier_id' => $store_id, 'status' => 3, 'type' => 0));

        //分销商待结算利润
        $sql = "SELECT SUM(s.unbalance) AS total FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND s.unbalance > 0 AND FIND_IN_SET(" . $store_id . ", ss.supply_chain) AND ss.type = 1";
        $seller_profit = D('')->query($sql);
        if (!empty($seller_profit[0]['total'])) {
            $seller_profit_unbalance = $seller_profit[0]['total'];
        } else {
            $seller_profit_unbalance = 0;
        }

        //未处理提现
        $where = array();
        $where['supplier_id'] = $store_id;
        $where['type']        = 0;
        $seller_withdrawals = D('Store_withdrawal')->where($where)->count('pigcms_id');

        //分销商数量
        $sql = "SELECT COUNT(s.store_id) AS seller_count FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND ss.type = 1 AND FIND_IN_SET(" . $store_id . ", ss.supply_chain)";
        $sellers_count = D('Store_supplier')->query($sql);
        if (!empty($_POST['name'])) {
            $sql .= " AND s.name LIKE '%" . trim($_POST['name']) . "%'";
        }
        if (!empty($_POST['level']) && $_POST['level'] >= 9) {
            $sql .= " AND ss.level >= '" . intval(trim($_POST['level'])) . "'";
        } if (!empty($_POST['level'])) {
            $sql .= " AND ss.level = '" . intval(trim($_POST['level'])) . "'";
        }
        $seller_count = D('Store_supplier')->query($sql);
        $seller_count = !empty($seller_count[0]['seller_count']) ? $seller_count[0]['seller_count'] : 0;

        $page = new Page($seller_count, 15);

        $sql = "SELECT s.store_id AS seller_id,s.name,ss.level,s.balance,s.unbalance FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND ss.type = 1 AND FIND_IN_SET(" . $store_id . ", ss.supply_chain)";
        if (!empty($_POST['name'])) {
            $sql .= " AND s.name LIKE '%" . trim($_POST['name']) . "%'";
        }
        if (!empty($_POST['level']) && $_POST['level'] >= 9) {
            $sql .= " AND ss.level >= '" . intval(trim($_POST['level'])) . "'";
        } if (!empty($_POST['level'])) {
            $sql .= " AND ss.level = '" . intval(trim($_POST['level'])) . "'";
        }
        $sql .= " ORDER BY s.store_id ASC LIMIT " . $page->firstRow . ',' . $page->listRows;
        $sellers = D('Store_supplier')->query($sql);

        if (!empty($sellers)) {
            foreach ($sellers as &$seller) {
                $where['store_id']    = $seller['seller_id'];
                $where['supplier_id'] = $store_id;
                $where['type']        = 0;
                $where['status']      = array('in', array(1,2));
                $seller['withdrawal_pending'] = D('Store_withdrawal')->where($where)->count('pigcms_id');
                $withdrawal_pending_amount = D('Store_withdrawal')->where($where)->sum('amount');
                $seller['withdrawal_pending_amount'] = number_format($withdrawal_pending_amount, 2, '.', '');

                //分销商销售额
                $sql = "SELECT SUM(o.total) AS sales_total,(SELECT SUM(product_money + postage_money) FROM " . option('system.DB_PREFIX') . "return WHERE order_id = o.order_id) AS return_total FROM " . option('system.DB_PREFIX') . "order o WHERE o.store_id = '" . $seller['seller_id'] . "' AND o.is_fx = 1 AND o.user_order_id = 0";
                $order_total = D('')->query($sql);
                $sales_total  = !empty($order_total[0]['sales_total']) ? $order_total[0]['sales_total'] : 0;
                $return_total = !empty($order_total[0]['return_total']) ? $order_total[0]['return_total'] : 0;
                if ($sales_total - $return_total > 0) {
                    $seller['sales_total'] = $sales_total - $return_total;
                } else {
                    $seller['sales_total'] = 0;
                }
                $seller['sales_total'] = number_format($seller['sales_total'], 2, '.', '');
            }
        }

        $this->assign('seller_sales', number_format($seller_sales, 2, '.', ''));
        $this->assign('seller_profit_balance', number_format($seller_profit_balance, 2, '.', ''));
        $this->assign('seller_profit_unbalance', number_format($seller_profit_unbalance, 2, '.', ''));
        $this->assign('seller_withdrawal_processed', number_format($seller_withdrawal_processed, 2, '.', ''));
        $this->assign('seller_count', !empty($sellers_count[0]['seller_count']) ? $sellers_count[0]['seller_count'] : 0);
        $this->assign('seller_withdrawals', $seller_withdrawals);
        $this->assign('sellers', $sellers);
        $this->assign('page', $page->show());
    }

    //供货对账
    public function supplier_check()
    {
        $this->checkFx(false, true);

        $store_id = $this->store_session['store_id'];
        //供货商数量和保证金余额
        $sql = "SELECT SUM(sdr.bond) AS bond_balance,COUNT(sdr.supplier_id) AS suppliers, SUM(sdr.profit) AS profit, SUM(sdr.return_owe) AS return_owe,SUM(sdr.not_paid) AS unpay_total FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE sdr.supplier_id = s.store_id AND sdr.distributor_id = '" . $store_id . "'";
        $suppliers = D('')->query($sql);
        //供货商数量
        $suppliers_count  = !empty($suppliers[0]['suppliers']) ? $suppliers[0]['suppliers'] : 0;
        //获得收益
        $income_balance   = !empty($suppliers[0]['profit']) ? $suppliers[0]['profit'] : 0;
        //待支付
        $unpay_total      = !empty($suppliers[0]['unpay_total']) ? $suppliers[0]['unpay_total'] : 0;
        //退货欠
        $return_owe       = !empty($suppliers[0]['return_owe']) ? $suppliers[0]['return_owe'] : 0;

        $this->assign('supplier_count', $suppliers_count);
        $this->assign('income_balance', number_format($income_balance, 2, '.', ''));
        $this->assign('return_owe', number_format($return_owe, 2, '.', ''));
        $this->assign('unpay_total', number_format($unpay_total, 2, '.', ''));
        $this->display();
    }

    private function _supplier_check_content()
    {
        /**
         * margin_amount 0,1 0 普通批发 1 开启保证模式
         * not_paid 经销商未付款给供货商金额
         * paid 经销商已付款给供货商金额
         * bond 经销商的保证金余额
         * margin_minimum 保证金最低额度充值提现
         */
        import('source.class.user_page');

        //1 为保证金供货商 2 为现付供货商
        $type = 1;
        $store_id = $this->store_session['store_id'];

        if (!empty($_POST['type'])) {
            $type = $_POST['type'];
        }

        //待支付总额
        $unpay_total = 0;
        if ($type == 2) {
            $unpay_total = D('Supp_dis_relation')->where(array('distributor_id' => $store_id))->sum('not_paid');
            $unpay_total = !empty($unpay_total) ? $unpay_total : 0;
        }

        if ($type == 1) {
            //保证金余额
            $sql = "SELECT SUM(bond) AS bond_balance FROM " . option('system.DB_PREFIX') . "supp_dis_relation WHERE distributor_id = '" . $store_id . "'";
            $suppliers = D('')->query($sql);

            //保证金余额
            $bond_balance = !empty($suppliers[0]['bond_balance']) ? $suppliers[0]['bond_balance'] : 0;

            //充值提醒
            $sql = "SELECT COUNT(sdr.distributor_id) AS recharge_notice FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE sdr.supplier_id = s.store_id AND sdr.distributor_id = '" . $store_id . "' AND s.margin_amount = 1 AND sdr.bond < s.margin_minimum";
            $recharge_notice = D('')->query($sql);
            if (!empty($recharge_notice[0]['recharge_notice'])) {
                $recharge_notice = $recharge_notice[0]['recharge_notice'];
            } else {
                $recharge_notice = 0;
            }
        }

        if ($type == 1) {
            $sql = "SELECT COUNT(s.store_id) AS supplier_count FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE s.store_id = sdr.supplier_id AND sdr.distributor_id = '" . $store_id . "'";
            $sql2 = "SELECT sdr.distributor_id AS seller_id,s.name,sdr.supplier_id AS supplier_id,sdr.bond,s.margin_amount,s.margin_minimum,sdr.return_owe,sdr.not_paid,sdr.profit FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE s.store_id = sdr.supplier_id AND sdr.distributor_id = '" . $store_id . "'";
        } else {
            $sql = "SELECT COUNT(s.store_id) AS supplier_count FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE s.store_id = sdr.supplier_id AND sdr.distributor_id = '" . $store_id . "'";
            $sql2 = "SELECT sdr.distributor_id AS seller_id,s.name,sdr.supplier_id AS supplier_id,sdr.bond,s.margin_amount,s.margin_minimum,sdr.not_paid,sdr.return_owe,sdr.not_paid,sdr.profit FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE s.store_id = sdr.supplier_id AND sdr.distributor_id = '" . $store_id . "'";
        }
        if ($type == 1) {
            $sql .= " AND s.margin_amount = 1";
            $sql2 .= " AND s.margin_amount = 1";
        } else {
            $sql .= " AND s.margin_amount = 0";
            $sql2 .= " AND s.margin_amount = 0";
        }
        if (!empty($_POST['name'])) {
            $sql .= " AND s.name LIKE '%" . trim($_POST['name']) . "%'";
            $sql2 .= " AND s.name LIKE '%" . trim($_POST['name']) . "%'";
        }
        if (!empty($_POST['status'])) {
            if ($_POST['status'] == 1) {
                if ($type == 1) {
                    $sql .= " AND sdr.bond >= s.margin_minimum";
                    $sql2 .= " AND sdr.bond >= s.margin_minimum";
                } else {
                    $sql .= " AND sdr.not_paid > 0";
                    $sql2 .= " AND sdr.not_paid > 0";
                }
            } else if ($_POST['status'] == 2) {
                if ($type == 1) {
                    $sql .= " AND sdr.bond < s.margin_minimum";
                    $sql2 .= " AND sdr.bond < s.margin_minimum";
                } else {
                    $sql .= " AND sdr.not_paid = 0";
                    $sql2 .= " AND sdr.not_paid = 0";
                }
            }
        }

        $supplier_count = D('')->query($sql);
        $supplier_count = !empty($supplier_count[0]['supplier_count']) ? $supplier_count[0]['supplier_count'] : 0;
        $page = new Page($supplier_count, 15);
        $sql2 .= ' ORDER BY s.store_id DESC LIMIT ' . $page->firstRow . ',' . $page->listRows;

        //供货商列表
        $suppliers = D('')->query($sql2);
        if (!empty($suppliers) && $type == 2) {
            foreach ($suppliers as &$tmp_supplier) {
                $tmp_supplier['unbalance'] = number_format($tmp_supplier['not_paid'], 2, '.', '');
            }
        }

        $this->assign('type', $type);
        if ($type == 1) {
            $this->assign('recharge_notice', $recharge_notice);
            $this->assign('bond_balance', $bond_balance);
        }
        if ($type == 2) {
            $this->assign('unpay_total', number_format($unpay_total, 2, '.', ''));
        }
        $this->assign('suppliers', $suppliers);
        $this->assign('page', $page->show());
    }

    //经销商对账
    public function dealer_check()
    {
        $this->checkFx(false, true);

        $store_id = $this->store_session['store_id'];

        //经销商数量和保证金余额
        $sql = "SELECT SUM(sdr.bond) AS bond_balance,COUNT(sdr.distributor_id) AS dealers,SUM(sdr.not_paid) AS not_paid,SUM(sdr.paid) AS paid,SUM(sdr.return_owe) AS return_owe,SUM(sdr.sales) AS sales FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE sdr.distributor_id = s.store_id AND sdr.supplier_id = '" . $store_id . "'";
        $dealers = D('')->query($sql);

        //已收款
        $paid_total = !empty($dealers[0]['paid']) ? $dealers[0]['paid'] : 0;
        //经销商数量
        $dealers_count  = !empty($dealers[0]['dealers']) ? $dealers[0]['dealers'] : 0;
        //待收款
        $not_paid_total      = !empty($dealers[0]['not_paid']) ? $dealers[0]['not_paid'] : 0;
        //退货欠
        $return_owe = !empty($dealers[0]['return_owe']) ? $dealers[0]['return_owe'] : 0;
        //销售额
        $sales = !empty($dealers[0]['sales']) ? $dealers[0]['sales'] : 0;

        $this->assign('paid_total', number_format($paid_total, 2, '.', ''));
        $this->assign('dealers_count', $dealers_count);
        $this->assign('not_paid_total', number_format($not_paid_total, 2, '.', ''));
        $this->assign('return_owe', number_format($return_owe, 2, '.', ''));
        $this->assign('sales', number_format($sales, 2, '.', ''));
        $this->display();
    }

    //经销商对账
    private function _dealer_check_content()
    {
        import('source.class.user_page');

        //1 为保证金供货商 2 为现付供货商
        $type = 1;
        $store_id = $this->store_session['store_id'];
        $store = D('Store')->field('margin_minimum')->where(array('store_id' => $store_id))->find();

        if (!empty($_POST['type'])) {
            $type = $_POST['type'];
        }

        $unpay_total = 0;
        if ($type == 1) {
            //保证金余额
            $sql = "SELECT SUM(bond) AS bond_balance FROM " . option('system.DB_PREFIX') . "supp_dis_relation WHERE supplier_id = '" . $store_id . "'";
            $suppliers = D('')->query($sql);
            $bond_balance = !empty($suppliers[0]['bond_balance']) ? $suppliers[0]['bond_balance'] : 0;

            //充值提醒
            $sql = "SELECT *,COUNT(sdr.distributor_id) AS recharge_notice FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE sdr.distributor_id = s.store_id AND sdr.supplier_id = '" . $store_id . "' AND s.margin_amount = 1 AND sdr.bond < s.margin_minimum";
            $recharge_notice = D('')->query($sql);
            if (!empty($recharge_notice[0]['recharge_notice'])) {
                $recharge_notice = $recharge_notice[0]['recharge_notice'];
            } else {
                $recharge_notice = 0;
            }

            $sql = "SELECT COUNT(s.store_id) AS supplier_count FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE s.store_id = sdr.distributor_id AND sdr.supplier_id = '" . $store_id . "'";
            $sql2 = "SELECT sdr.distributor_id AS dealer_id,s.name,sdr.supplier_id AS supplier_id,sdr.bond,sdr.profit,sdr.return_owe,sdr.not_paid,sdr.sales FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE s.store_id = sdr.distributor_id AND sdr.supplier_id = '" . $store_id . "'";

            if ($_POST['status'] == 1) {
                $sql .= " AND sdr.bond >= '" . $store['margin_minimum'] . "'";
                $sql2 .= " AND sdr.bond >= '" . $store['margin_minimum'] . "'";
            } else if ($_POST['status'] == 2) {
                $sql .= " AND sdr.bond < '" . $store['margin_minimum'] . "'";
                $sql2 .= " AND sdr.bond < '" . $store['margin_minimum'] . "'";
            } else {
                $sql .= " AND sdr.bond > 0";
                $sql2 .= " AND sdr.bond > 0";
            }
        } else {
            $sql = "SELECT COUNT(s.store_id) AS supplier_count FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE s.store_id = sdr.distributor_id AND sdr.supplier_id = '" . $store_id . "'";
            $sql2 = "SELECT sdr.distributor_id AS dealer_id,s.name,sdr.supplier_id AS supplier_id,sdr.bond,sdr.profit,sdr.return_owe,sdr.not_paid,sdr.sales FROM " . option('system.DB_PREFIX') . "supp_dis_relation sdr, " . option('system.DB_PREFIX') . "store s WHERE s.store_id = sdr.distributor_id AND sdr.supplier_id = '" . $store_id . "' AND sdr.bond <= 0";

            if ($_POST['status'] == 1) {
                $sql .= " AND sdr.not_paid = 0";
                $sql2 .= " AND sdr.not_paid = 0";
            } else if ($_POST['status'] == 2) {
                $sql .= " AND sdr.not_paid > 0";
                $sql2 .= " AND sdr.not_paid > 0";
            }

            //待支付总额
            $unpay_total = D('Supp_dis_relation')->where(array('supplier_id' => $store_id))->sum('not_paid');
            $unpay_total = !empty($unpay_total) ? $unpay_total : 0;

        }

        if (!empty($_POST['name'])) {
            $sql .= " AND s.name LIKE '%" . trim($_POST['name']) . "%'";
            $sql2 .= " AND s.name LIKE '%" . trim($_POST['name']) . "%'";
        }

        $dealer_count = D('')->query($sql);
        $dealer_count = !empty($dealer_count[0]['supplier_count']) ? $dealer_count[0]['supplier_count'] : 0;
        $page = new Page($dealer_count, 15);
        $sql2 .= ' ORDER BY s.store_id DESC LIMIT ' . $page->firstRow . ',' . $page->listRows;

        //经销商列表
        $dealers = D('')->query($sql2);

        $this->assign('type', $type);
        $this->assign('bond_balance', $bond_balance);
        $this->assign('recharge_notice', $recharge_notice);
        $this->assign('unpay_total', $unpay_total);
        $this->assign('dealers', $dealers);
        $this->assign('page', $page->show());
    }

    //分销商分润对账
    public function profit_check()
    {

        $this->display();
    }

    private function _profit_check_content()
    {
        import('source.class.user_page');
        $order = M('Order');
        $financial_record = M('Financial_record');

        $store_id = $this->store_session['store_id'];

        $store = D('Store')->where(array('store_id' => $store_id))->find();
        $store['balance'] = number_format($store['balance'], 2, '.', '');
        $store['unbalance'] = number_format($store['unbalance'], 2, '.', '');

        //供货商
        $supplier_supply = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $store_id))->find();
        $supplier_name = '';
        if (!empty($supplier_supply['supply_chain'])) {
            $chain = explode(',', $supplier_supply['supply_chain']);
            $supplier_id = $chain[1];
            $supplier = D('Store')->field('name')->where(array('store_id' => $supplier_id))->find();
            $supplier_name = $supplier['name'];
        }

        //订单列表
        $where = array();
        $where['store_id']      = $store_id;
        if ($_POST['status'] == 1) {
            $where['status'] = array('in', array(2,3,6,7));
        } else if ($_POST['status'] == 2) {
            $where['status'] = 4;
        } else {
            $where['status'] = array('in', array(2,3,4,6,7));
        }
        if (!empty($_POST['start_time']) && !empty($_POST['end_time'])) {
            $start_time = strtotime(trim($_POST['start_time']));
            $end_time   = strtotime(trim($_POST['end_time']));
            $where['_string'] = " add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
        } else if (!empty($_POST['start_time'])) {
            $start_time = strtotime(trim($_POST['start_time']));
            $where['add_time'] = array('>=', $start_time);
        } else if (!empty($_POST['end_time'])) {
            $end_time   = strtotime(trim($_POST['end_time']));
            $where['add_time'] = array('<=', $end_time);
        }
        if (!empty($_POST['order_no'])) {
            if (!empty($where['_string'])) {
                $where['_string'] .= " AND (order_no = '" . trim($_POST['order_no']) . "' OR third_id = '" . trim($_POST['order_no']) . "')";
            } else {
                $where['_string'] = "(order_no = '" . trim($_POST['order_no']) . "' OR third_id = '" . trim($_POST['order_no']) . "')";
            }
        }
        $order_count = $order->getOrderCount($where);

        $page = new Page($order_count, 15);
        $orders = $order->getOrders($where, 'order_id DESC', $page->firstRow, $page->listRows);
        if (!empty($orders)) {
            foreach ($orders as &$tmp_order) {

                //分销利润
                $profit = $financial_record->getOrderProfit($tmp_order['order_id']);
                $tmp_order['profit'] = number_format($profit, 2, '.', '');

                //退货
                if (empty($tmp_order['user_order_id'])) {
                    $return = D('Return')->where(array('order_id' => $tmp_order['order_id'], 'store_id' => $store_id))->sum('product_money + postage_money');
                    $tmp_order['return'] = number_format($return, 2, '.', '');
                } else {
                    $where = array();
                    $where['store_id'] = $store_id;
                    $where['order_id'] = $tmp_order['order_id'];
                    $where['type']     = 3;
                    $return = $financial_record->getTotal($where);
                    $return = abs($return);
                    $tmp_order['return'] = number_format($return, 2, '.', '');
                }
            }
        }


        $this->assign('supplier_name', $supplier_name);
        $this->assign('store', $store);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    /**
     * 更改到店自提状态
     */
    public function selffetch_status()
    {
        $order_id = $_GET['order_id'];
        if (empty($order_id)) {
            json_return(1001, '更改失败，缺少参数');
        }

        $order = M('Order')->getOrder($this->store_session['store_id'], $order_id);
        if (empty($order)) {
            json_return(1001, '未找到要更改的订单');
        }

        if ($order['shipping_method'] != 'selffetch') {
            $buyer_selffetch_name = $this->store_session['buyer_selffetch_name'] ? $this->store_session['buyer_selffetch_name'] : '到店自提';
            json_return(1001, '此订单不是' . $buyer_selffetch_name . '订单，不能更改');
        }

        if ($order['status'] != 2) {
            json_return(1001, '更改失败，订单状态不正确');
        }

        $data = array();
        $data['sent_time'] = time();
        $data['delivery_time'] = time();
        $data['status'] = 7;
        $result = D('Order')->where(array('order_id' => $order_id))->data($data)->save();
        if ($result) {
            json_return(0, '操作成功');
        } else {
            json_return(1001, '操作失败');
        }
    }
	
	/**
	 * 确认收款
	 */
	public function receive_time() {
		$order_id = $_POST['order_id'];
		
		if (empty($order_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$order = M('Order')->getOrder($this->store_session['store_id'], $order_id);
		if (empty($order)) {
			json_return(1000, '没有找到相应的订单');
		}
		
		if ($order['payment_method'] != 'codpay') {
			json_return(1000, '此订单不是货到付款订单，不能确认收款');
		}
		
		if ($order['receive_time'] > 0) {
			json_return(1000, '此订单不是货到付款订单，不能确认收款');
		}
		
		$data = array();
		$data['receive_time'] = time();
		
		if (D('Order')->where(array('order_id' => $order_id))->data($data)->save()) {
			json_return(0, '确认收款成功');
		} else {
			json_return(1000, '确认收款失败');
		}
	}
	
    /**
     * 退货管理
     */
    public function order_return()
    {
        $this->display();
    }

    /**
     * 退货列表
     */
    private function _order_return_list()
    {
        $store_id = $_SESSION['store']['store_id'];
        $return_model = M('Return');
        $count = $return_model->getCount("store_id = '" . $store_id . "'");
        $page = max(1, $_GET['page']);

        $return_list = array();
        $pages = '';
        if ($count > 0) {
            $limit = 15;
            $page = min($page, ceil($count / $limit));
            $offset = ($page - 1) * $limit;

            $return_list = $return_model->getList("r.store_id = '" . $store_id . "'", $limit, $offset);
            import('source.class.user_page');
            $pages = new Page($count, 15, $page);
        }

        $this->assign('return_list', $return_list);
        $this->assign('pages', $pages);
    }

    /**
     * 退货详情
     */
    private function _order_return_detail() {
        $id = $_POST['id'];
        $order_no = $_POST['order_no'];
        $pigcms_id = $_POST['pigcms_id'];
        $store_id = $_SESSION['store']['store_id'];

        if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
            echo '缺少参数！';
            exit;
        }

        $return = array();
        if (!empty($id)) {
            $return = M('Return')->getById($id);
        } else {
            $order_no = trim($order_no, option('config.orderid_prefix'));
            $where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
            $return_list = M('Return')->getList($where);

            if ($return_list) {
                $return = $return_list[0];
            }
        }

        //$return = M('Return')->getById($id);
        if (empty($return)) {
            echo '未找到相应的退货申请';
            exit;
        }

        if (empty($id) && !empty($order_no) && !empty($pigcms_id)) {
            echo json_encode(array('status' => true, 'msg' => $return['id']));
            exit;
        }

        if ($return['store_id'] != $_SESSION['store']['store_id']) {
            echo '您无权查看此退货申请';
            exit;
        }
        // 查找订单
        $order = D('Order')->where("(order_id = '" . $return['order_id'] . "' or user_order_id = '" . $return['order_id'] . "') and store_id = '" . $store_id . "'")->find();

        if (empty($order)) {
            echo '未查到相应的订单';
            exit;
        }
        $order = M('Order')->find(option('config.orderid_prefix') . $order['order_no']);

        // 相关折扣、满减、优惠
        import('source.class.Order');
        $order_data = Order::orderDiscount($order);
        $discount_money = 0;

        // 计算出每级此产品的分销利润
        if ($return['is_fx'] == 0) {
            $return_list = M('Return')->getProfit($return);
            $this->assign('return_list', $return_list);

            // 查看此退货商品折扣金额
            $product = D('Order_product')->where("pigcms_id = '" . $return['order_product_id'] . "'")->find();
            $tmp_order_data = Order::orderDiscount($order, array(0 => $product));
            $discount_money = $tmp_order_data['discount_money'];
        }

        $this->assign('order', $order);
        $this->assign('return', $return);
        $this->assign('order_data', $order_data);
        $this->assign('discount_money', $discount_money);
    }

    /**
     * 退单
     */
    public function return_save() {
        $id = $_POST['id'];
        $store_id = $_SESSION['store']['store_id'];
        $status = $_POST['status'];
        $store_content = $_POST['store_content'];
        $product_money = $_POST['product_money'] + 0;
        $postage_money = $_POST['postage_money'] + 0;
        $address_user = $_POST['address_user'];
        $address_tel = $_POST['address_tel'];
        $provinceId_m = $_POST['provinceId_m'];
        $cityId_m = $_POST['cityId_m'];
        $areaId_m = $_POST['areaId_m'];
        $address = $_POST['address'];

        if (!in_array($status, array(2, 3))) {
            json_return(1001, '参数错误');
        }

        $return = M('Return')->getById($id);
        if (empty($return)) {
            json_return(1001, '未找到相应的退货申请');
        }
        if ($return['store_id'] != $_SESSION['store']['store_id'] || $return['is_fx'] != '0') {
            json_return(1001, '您无权操作此退货申请');
        }
        // 查找订单
        $order = D('Order')->where("(order_id = '" . $return['order_id'] . "' or user_order_id = '" . $return['order_id'] . "') and store_id = '" . $store_id . "'")->find();

        //是否有经销商订单
        $user_order_id = !empty($order['user_order_id']) ? $order['user_order_id'] : $order['order_id'];
        $sql = "SELECT o.order_id,o.store_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 0 AND (o.user_order_id = '" . $user_order_id . "' OR o.order_id = '" . $user_order_id . "') AND ss.supplier_id = '" . $store_id . "'";
        $dealer_order = D('')->query($sql);

        if (empty($order)) {
            json_return(1001, '未查到相应的订单');
        }

        if ($status == '2') {
            if (empty($store_content)) {
                json_return(1001, '不同意退货理由不能为空，请填写');
            }
        } else {
            if (empty($product_money) || $product_money <= 0) {
                json_return(1001, '请正确填写退货金额');
            }

            if ($order['status'] != 2 && $order['status'] != 6) {
                if (empty($address_user)) {
                    json_return(1001, '请填写收货人姓名');
                }

                if (empty($address_tel)) {
                    json_return(1001, '请填写收货人电话');
                }

                if (!preg_match("/\d{5,12}$/", $address_tel)) {
                    json_return(1001, '手机号格式不正确，请正确填写');
                }

                if (empty($provinceId_m) || empty($cityId_m) || empty($areaId_m)) {
                    json_return(1001, '请选择省份、城市、地区信息');
                }

                if (empty($address)) {
                    json_return(1001, '请填写所在街道');
                }

                if (mb_strlen($address, 'utf-8') < 1 || mb_strlen($address, 'utf-8') > 120) {
                    json_return(1001, '所在街道字数范围为1-120，请正确填写');
                }
            }
        }

        if ($status == '2') {
            $data = array();
            $data['status'] = 2;
            $data['cancel_dateline'] = time();
            $data['store_content'] = $store_content;

            if ($return['user_return_id']) {
                $result = D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' or id = '" . $return['user_return_id'] . "'")->data($data)->save();
            } else {
                $result = D('Return')->where("id = '" . $return['id'] . "'")->data($data)->save();
            }

            if ($result) {
                // 审核不通过更改订单产品表退货状态
                import('source.class.ReturnOrder');
                ReturnOrder::checkReturnStatus($return);
                json_return(0, '操作成功');
            } else {
                json_return(1001, '操作失败，请重试');
            }
        } else {
            $tmp_address = array();
            $tmp_address['address'] = $address;
            $tmp_address['province_id'] = $provinceId_m;
            $tmp_address['city_id'] = $cityId_m;
            $tmp_address['area_id'] = $areaId_m;

            import('area');
            $areaClass = new area();
            $tmp_address['province_txt'] = $areaClass->get_name($provinceId_m);
            $tmp_address['city_txt'] = $areaClass->get_name($cityId_m);
            $tmp_address['county_txt'] = $areaClass->get_name($areaId_m);


            $data = array();
            $data['status'] = 3;
            if ($order['status'] != 2 && $order['status'] != 6) {
                $data['address'] = serialize($tmp_address);
                $data['address_user'] = $address_user;
                $data['address_tel'] = $address_tel;
            }
            $data['product_money'] = $product_money;
            $data['postage_money'] = $postage_money;

            // 同意退款，订单为货到付款，订单状态在待发货时，直接将退货状态改为退货完成
            if ($order['status'] == 2 || $order['status'] == 6) {
                $data['status'] = 5;
            }

            if ($return['user_return_id']) {
                $result = D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' or id = '" . $return['user_return_id'] . "'")->data($data)->save();
            } else {
                $result = D('Return')->where("id = '" . $return['id'] . "'")->data($data)->save();
            }

            if ($result) {

                //退货记账(经销商)
                if (!empty($dealer_order)) {
                    //退货的商品
                    $tmp_return_product = D('Return_product')->field('product_id,sku_data,pro_num')->where(array('return_id' => $id))->find();
                    $return_product_sku_data = !empty($tmp_return_product['sku_data']) ? $tmp_return_product['sku_data'] : '';
                    $return_product_id = $tmp_return_product['product_id'];
                    $return_amount = D('Order_product')->where(array('original_product_id' => $return_product_id, 'sku_data' => $return_product_sku_data, 'user_order_id' => $user_order_id))->sum('profit');
                    $return_amount *= $tmp_return_product['pro_num'];
                    //经销商批发利润(减)
                    $return_dealer_profit = D('Order_product')->where(array('original_product_id' => $return_product_id, 'sku_data' => $return_product_sku_data, 'order_id' => $dealer_order[0]['order_id']))->sum('profit');
                    $return_dealer_profit *= $tmp_return_product['pro_num'];
                    if (!empty($return_dealer_profit)) {
                        D('Supp_dis_relation')->where(array('distributor_id' => $dealer_order[0]['store_id'], 'supplier_id' => $store_id))->setDec('profit', $return_dealer_profit);
                    }
                    if (!empty($return_amount)) {
                        D('Supp_dis_relation')->where(array('distributor_id' => $dealer_order[0]['store_id'], 'supplier_id' => $store_id))->setInc('return_owe', $return_amount);
                    }
                }

                // 如果是货到付款退货，全部退完，直接将订单改为取消状态
                if ($order['status'] == 2) {
                    import('source.class.ReturnOrder');
                    ReturnOrder::checkOrderStatus($order);
                }

                // 如果订单状态为2，不是货到付款，要更改库存和外销量
                if ($order['status'] == 2 && $order['payment_method'] != 'codpay') {

                    $return_list = M('Return')->getProfit($return);
                    foreach ($return_list as $tmp) {
                        $order = D('Order')->where("order_id = '" . $tmp['order_id'] . "'")->find();
                        $store = D('Store')->field('income')->where(array('store_id' => $order['store_id']))->find();

                        //收支记录
                        $financial_record = D('Financial_record')->field('supplier_id')->where(array('order_id' => $tmp['order_id'], 'store_id' => $tmp['store_id'], 'income' => array('>', 0)))->find();

                        $financial_record_data = array();
                        $financial_record_data['store_id'] = $tmp['store_id'];
                        $financial_record_data['order_id'] = $order['order_id'];
                        $financial_record_data['order_no'] = $order['order_no'];
                        $financial_record_data['income'] = -1 * $tmp['profit'];

                        if ($tmp['drp_level'] == '0') {
                            // 查看此退货商品折扣金额
                            $product = D('Return_product')->where("return_id = '" . ($tmp['user_return_id'] > 0 ? $tmp['user_return_id'] : $tmp['return_id']) . "'")->find();
                            $discount_money = $product['pro_num'] * $product['pro_price'] - $product_money;
                            $financial_record_data['income'] = -1 * $tmp['profit'] - $tmp['postage_money'] + $discount_money;
                        }

                        $financial_record_data['type'] = 3;
                        $financial_record_data['trade_no'] = date('YmdHis') . rand(100000, 999999);
                        $financial_record_data['add_time'] = time();
                        $financial_record_data['status'] = 2;
                        $financial_record_data['user_order_id'] = !empty($order['user_order_id']) ? $order['user_order_id'] : $order['order_id'];
                        $financial_record_data['bak'] = '退货';
                        $financial_record_data['balance'] = $store['income'];
                        $financial_record_data['return_id'] = $tmp['id'];
                        $financial_record_data['supplier_id'] = !empty($financial_record['supplier_id']) ? $financial_record['supplier_id'] : 0;

                        D('Financial_record')->data($financial_record_data)->add();
                    }


                    $quantity = $return['pro_num'];

                    $properties = getPropertyToStr($return['sku_data']);
                    $tmp_product_id = $return['product_id'];

                    //更新库存
                    D('Product')->where(array('product_id' => $tmp_product_id))->setInc('quantity', $quantity);
                    if (!empty($properties)) { //更新商品属性库存
                        D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setInc('quantity', $quantity);
                    }
                    //更新销量
                    D('Product')->where(array('product_id' => $tmp_product_id))->setDec('sales', $quantity); //更新销量
                    if (!empty($properties)) { //更新商品属性销量
                        D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setDec('sales', $quantity);
                    }
                    //同步批发商品库存、销量
                    $wholesale_products = D('Product')->field('product_id')->where(array('wholesale_product_id' => $tmp_product_id))->select();
                    if (!empty($wholesale_products)) {
                        foreach ($wholesale_products as $wholesale_product) {
                            //更新库存
                            D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setInc('quantity', $quantity);
                            if (!empty($properties)) { //更新商品属性库存
                                D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setInc('quantity', $quantity);
                            }
                            //更新销量
                            D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setDec('sales', $quantity); //更新销量
                            if (!empty($properties)) { //更新商品属性销量
                                D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setDec('sales', $quantity);
                            }
                        }
                    }
                }

                json_return(0, '操作成功');
            } else {
                json_return(1001, '操作失败，请重试');
            }
        }
    }

    /**
     * 退货完成
     */
    public function return_over() {
        $id = $_POST['id'];
        $store_id = $_SESSION['store']['store_id'];

        $return = M('Return')->getById($id);
        if (empty($return)) {
            json_return(1001, '未找到相应的退货申请');
        }
        if ($return['store_id'] != $_SESSION['store']['store_id'] || $return['is_fx'] != '0') {
            json_return(1001, '您无权操作此退货申请');
        }

        if ($return['status'] != 4) {
            json_return(1001, '操作状态不正确');
        }

        // 查找订单
        $order = D('Order')->where("(order_id = '" . $return['order_id'] . "' or user_order_id = '" . $return['order_id'] . "') and store_id = '" . $store_id . "'")->find();

        //是否有经销商订单
        $user_order_id = !empty($order['user_order_id']) ? $order['user_order_id'] : $order['order_id'];
        $sql = "SELECT o.order_id,o.store_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 0 AND (o.user_order_id = '" . $user_order_id . "' OR o.order_id = '" . $user_order_id . "') AND ss.supplier_id = '" . $store_id . "'";
        $dealer_order = D('')->query($sql);

        //退货记账(经销商)
        if (!empty($dealer_order)) {
            //退货的商品
            $tmp_return_product = D('Return_product')->field('product_id,sku_data,pro_num')->where(array('return_id' => $id))->find();
            $return_product_sku_data = !empty($tmp_return_product['sku_data']) ? $tmp_return_product['sku_data'] : '';
            $return_product_id = $tmp_return_product['product_id'];
            $return_amount = D('Order_product')->where(array('original_product_id' => $return_product_id, 'sku_data' => $return_product_sku_data, 'user_order_id' => $user_order_id))->sum('profit');
            $return_amount *= $tmp_return_product['pro_num'];
            //经销商批发利润(减)
            $return_dealer_profit = D('Order_product')->where(array('original_product_id' => $return_product_id, 'sku_data' => $return_product_sku_data, 'order_id' => $dealer_order[0]['order_id']))->sum('profit');
            $return_dealer_profit *= $tmp_return_product['pro_num'];
            if (!empty($return_dealer_profit)) {
                D('Supp_dis_relation')->where(array('distributor_id' => $dealer_order[0]['store_id'], 'supplier_id' => $store_id))->setDec('profit', $return_dealer_profit);
            }
            if (!empty($return_amount)) {
                D('Supp_dis_relation')->where(array('distributor_id' => $dealer_order[0]['store_id'], 'supplier_id' => $store_id))->setInc('return_owe', $return_amount);
            }
        }

        if (empty($order)) {
            json_return(1001, '未查到相应的订单');
        }

        // 计算出每级此产品的分销利润
        //$return_list = D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' or id = '" . $return['user_return_id'] . "'")->select();
        $return_list = M('Return')->getProfit($return);

        foreach ($return_list as $tmp) {
            $order = D('Order')->where("order_id = '" . $tmp['order_id'] . "'")->find();
            $store = D('Store')->field('income')->where(array('store_id' => $order['store_id']))->find();

            // 货到付款平台不进行扣款
            if ($order['payment_method'] == 'codpay') {
                continue;
            }

            //收支记录
            $financial_record = D('Financial_record')->field('supplier_id')->where(array('order_id' => $tmp['order_id'], 'store_id' => $tmp['store_id'], 'income' => array('>', 0)))->find();

            /* $data = "income = income - " . $tmp['profit'] . ", unbalance = unbalance - " . $tmp['profit'];

              if ($tmp['is_fx']) {
              $data .= ", drp_profit = drp_profit - " . $tmp['profit'];
              }

              D('Store')->where(array('store_id' => $tmp['store_id']))->data($data)->save(); */

            $financial_record_data = array();
            $financial_record_data['store_id'] = $tmp['store_id'];
            $financial_record_data['order_id'] = $order['order_id'];
            $financial_record_data['order_no'] = $order['order_no'];
            $financial_record_data['income'] = -1 * $tmp['profit'];

            if ($tmp['drp_level'] == '0') {
                // 查看此退货商品折扣金额
                $product = D('Return_product')->where("return_id = '" . ($tmp['user_return_id'] > 0 ? $tmp['user_return_id'] : $tmp['return_id']) . "'")->find();
                $discount_money = $product['pro_num'] * $product['pro_price'] - $return['product_money'];
                $financial_record_data['income'] = -1 * $tmp['profit'] - $tmp['postage_money'] + $discount_money;
            }

            $financial_record_data['type'] = 3;
            $financial_record_data['trade_no'] = date('YmdHis') . rand(100000, 999999);
            $financial_record_data['add_time'] = time();
            $financial_record_data['status'] = 2;
            $financial_record_data['user_order_id'] = !empty($order['user_order_id']) ? $order['user_order_id'] : $order['order_id'];
            $financial_record_data['bak'] = '退货';
            $financial_record_data['balance'] = $store['income'];
            $financial_record_data['return_id'] = $tmp['id'];
            $financial_record_data['supplier_id'] = !empty($financial_record['supplier_id']) ? $financial_record['supplier_id'] : 0;

            D('Financial_record')->data($financial_record_data)->add();
        }
        if ($return['user_return_id']) {
            D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' OR id = '" . $return['user_return_id'] . "'")->data(array('status' => 5))->save();
        } else {
            D('Return')->where("id = '" . $return['id'] . "'")->data(array('status' => 5))->save();
        }


        // 更改库存和销量
        $quantity = $return['pro_num'];

        $properties = getPropertyToStr($return['sku_data']);
        $tmp_product_id = $return['product_id'];

        //更新库存
        D('Product')->where(array('product_id' => $tmp_product_id))->setInc('quantity', $quantity);
        if (!empty($properties)) { //更新商品属性库存
            D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setInc('quantity', $quantity);
        }
        //更新销量
        D('Product')->where(array('product_id' => $tmp_product_id))->setDec('sales', $quantity); //更新销量
        if (!empty($properties)) { //更新商品属性销量
            D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setDec('sales', $quantity);
        }
        //同步批发商品库存、销量
        $wholesale_products = D('Product')->field('product_id')->where(array('wholesale_product_id' => $tmp_product_id))->select();
        if (!empty($wholesale_products)) {
            foreach ($wholesale_products as $wholesale_product) {
                //更新库存
                D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setInc('quantity', $quantity);
                if (!empty($properties)) { //更新商品属性库存
                    D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setInc('quantity', $quantity);
                }
                //更新销量
                D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setDec('sales', $quantity); //更新销量
                if (!empty($properties)) { //更新商品属性销量
                    D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setDec('sales', $quantity);
                }
            }
        }

        // 如果订单产品全部退完，更改订单状态
        import('source.class.ReturnOrder');
        ReturnOrder::checkOrderStatus($order);

        json_return(0, '操作完成');
    }

    /**
     * 维权列表
     */
    public function order_rights() {
        $this->display();
    }

    /**
     * 维权列表
     */
    private function _order_rights_list() {
        $store_id = $_SESSION['store']['store_id'];
        $rights_model = M('Rights');
        $count = $rights_model->getCount("store_id = '" . $store_id . "'");
        $page = max(1, $_GET['page']);

        $rights_list = array();
        $pages = '';
        if ($count > 0) {
            $limit = 15;
            $page = min($page, ceil($count / $limit));
            $offset = ($page - 1) * $limit;

            $rights_list = $rights_model->getList("r.store_id = '" . $store_id . "'", $limit, $offset);
            import('source.class.user_page');
            $pages = new Page($count, 15, $page);
        }
        $this->assign('rights_list', $rights_list);
        $this->assign('pages', $pages);
    }

    private function _order_rights_detail() {
        $id = $_POST['id'];
        $order_no = $_POST['order_no'];
        $pigcms_id = $_POST['pigcms_id'];
        $store_id = $_SESSION['store']['store_id'];

        if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
            echo '缺少参数！';
            exit;
        }

        $rights = array();
        if (!empty($id)) {
            $rights = M('Rights')->getById($id);
        } else {
            $order_no = trim($order_no, option('config.orderid_prefix'));
            $where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
            $rights_list = M('Rights')->getList($where);

            if ($rights_list) {
                $rights = $rights_list[0];
            }
        }
        //$return = M('Return')->getById($id);
        if (empty($rights)) {
            echo '未找到相应的退货申请';
            exit;
        }

        if (empty($id) && !empty($order_no) && !empty($pigcms_id)) {
            echo json_encode(array('status' => true, 'msg' => $rights['id']));
            exit;
        }

        if ($rights['store_id'] != $_SESSION['store']['store_id']) {
            echo '您无权查看此退货申请';
            exit;
        }
        // 查找订单
        $order = D('Order')->where("(order_id = '" . $rights['order_id'] . "' or user_order_id = '" . $rights['order_id'] . "') and store_id = '" . $store_id . "'")->find();

        if (empty($order)) {
            echo '未查到相应的订单';
            exit;
        }
        $order = M('Order')->find(option('config.orderid_prefix') . $order['order_no']);
        /*// 查看满减送
        $order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);
        // 使用优惠券
        $order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);*/

        // 计算出每级此产品的分销利润
        if ($rights['is_fx'] == 0) {
            $rights_list = M('Rights')->getProfit($rights);
            $this->assign('rights_list', $rights_list);
        }

        // 相关折扣、满减、优惠
        import('source.class.Order');
        $order_data = Order::orderDiscount($order);

        $this->assign('order', $order);
        $this->assign('rights', $rights);
        //$this->assign('order_ward_list', $order_ward_list);
        //$this->assign('order_coupon', $order_coupon);
        $this->assign('order_data', $order_data);
    }
    
    //simon
    public function order_checkout_csv() {
    	$order = M('Order');
    	$order_product = M('Order_product');
    	$user = M('User');
    
    	$where = array();
    	$where['store_id'] = $this->store_session['store_id'];
    	$orderby = '`order_id` DESC';
    	$check_type = $_REQUEST['check_type'];
    
    	switch($check_type) {
    		//当前页面订单
    		case 'now':
    			if ($_REQUEST['order_no']) {
    				$where['order_no'] = $_REQUEST['order_no'];
    			}
    				
    				
    			if ($_REQUEST['status']>0) {
    				$where['status'] = $_REQUEST['status'];
    
    			} else {
    				$where['status'] = array(">",0);
    			}
    				
    			if (is_numeric($_REQUEST['type'])) {
    				$where['type'] = $_REQUEST['type'];
    			}
    			if (!empty($_REQUEST['user'])) {
    				$where['address_user'] = $_REQUEST['user'];
    			}
    			if (!empty($_REQUEST['tel'])) {
    				$where['address_tel'] = $_REQUEST['tel'];
    			}
    			if (!empty($_REQUEST['payment_method'])) {
    				$where['payment_method'] = $_REQUEST['payment_method'];
    			}
    			if (!empty($_REQUEST['shipping_method'])) {
    				$where['shipping_method'] = $_REQUEST['shipping_method'];
    			}
    			$field = '';
    			if (!empty($_REQUEST['time_type'])) {
    				$field = $_REQUEST['time_type'];
    			}
    			if (!empty($_REQUEST['start_time']) && !empty($_REQUEST['stop_time']) && !empty($field)) {
    				$where['_string'] = "`" . $field . "` >= " . strtotime($_REQUEST['start_time']) . " AND `" . $field . "` <= " . strtotime($_REQUEST['stop_time']);
    			} else if (!empty($_REQUEST['start_time']) && !empty($field)) {
    				$where[$field] = array('>=', strtotime($_REQUEST['start_time']));
    			} else if (!empty($_REQUEST['stop_time']) && !empty($field)) {
    				$where[$field] = array('<=', strtotime($_REQUEST['stop_time']));
    			}
    				
    			//排序
    			if (!empty($_REQUEST['orderbyfield']) && !empty($_REQUEST['orderbymethod'])) {
    				$orderby = "`{$_REQUEST['orderbyfield']}` " . $_REQUEST['orderbymethod'];
    			}
    
				break;
			//导出指定id组合的 订单
			case 'check':
					if(is_array($_REQUEST['order_check_id'])) {
						$where['order_id'] = array('in',$_REQUEST['order_check_id']);
					} else {
						if($_REQUEST['order_check_id']) {
							$where['_string'] = " order_id in (".$_REQUEST['order_check_id'].")";
						}
					}
					
				break;
    			//全部订单
    		case 'all':
    			$where['status'] = array(">",0);
    			break;
    			//全部待付款
    		case '1':
    			$where['status'] = 1;
    			break;
    			//全部待发货
    		case '2':
    			$where['status'] = 2;
    			break;
    			//全部已完成
    		case '3':
    			$where['status'] = 4;
    			break;
    			//全部已发货
    		case '4':
    			$where['status'] = 3;
    			break;
    			//全部已关闭
    		case '5':
    			$where['status'] = 5;
    			break;
    			//全部退款中
    		case '6':
    			$where['status'] = 6;
    			break;
    	}
    
	    	$data['is_show_activity_data'] = '0';	//不显示 活动订单
	    	if(!$data['is_show_activity_data']) {
	    		//$where['activity_data'] = '';
	    		$where['activity_data'] = array('is_null',"is_null");
	    	}
    
    	$order_total = $order->getOrderTotal($where);
    
    	if(IS_POST) {
    		json_return(json_encode($where),$order_total);
    	}

    	//import('source.class.user_page');
    	//$page = new Page($order_total, 15);
    	$tmp_orders = $order->getOrders($where, $orderby);
    	$orders = array();
    	foreach ($tmp_orders as $tmp_order) {
    		$products = $order_product->getProducts($tmp_order['order_id']);
    		$tmp_order['products'] = $products;
    		if (empty($tmp_order['uid'])) {
    			$tmp_order['is_fans'] = false;
    			$tmp_order['buyer'] = '';
    		} else {
    			//$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
    			$tmp_order['is_fans'] = true;
    			$user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
    			$tmp_order['buyer'] = $user_info['nickname'];
    		}
    
    		// 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
    		if ($tmp_order['status'] == 7) {
    			$count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
    			$tmp_order['returning_count'] = $count;
    		}
    
    
    		$is_supplier = false;
    		if (!empty($tmp_order['suppliers'])) { //订单供货商
    			$suppliers = explode(',', $tmp_order['suppliers']);
    			if (in_array($this->store_session['store_id'], $suppliers)) {
    				$is_supplier = true;
    			}
    		}
    		$tmp_order['is_supplier'] = $is_supplier;
    		$has_my_product = false;
    		foreach ($products as &$product) {
    			$product['image'] = getAttachmentUrl($product['image']);
    			if (empty($product['is_fx'])) {
    				$has_my_product = true;
    			}
    		}
    
    		$tmp_order['products'] = $products;
    		$tmp_order['has_my_product'] = $has_my_product;
    		if (!empty($tmp_order['user_order_id'])) {
    			$order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
    			$seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
    			$tmp_order['seller'] = $seller['name'];
    		}
    		$orders[] = $tmp_order;
    	}
    
    	//订单状态
    	$order_status = $order->status();
    
    	//支付方式
    	$payment_method = $order->getPaymentMethod();
    	//file_put_contents('./a.txt', json_encode($orders));
    
    	$order_status = array(
    			0 => '临时订单',
    			1 => '等待买家付款',
    			2 => '等待卖家发货',
    			3 => '卖家已发货',
    			4 => '交易完成',
    			5 => '订单关闭',
    			6 => '退款中',
    			7 => '确认收货'
    	);
    
    	//
    	include 'source/class/execl.class.php';
    	$execl = new execl();
    	$filename = date($level_cn."订单信息_YmdHis",time()).'.xls';
    	header ( 'Content-Type: application/vnd.ms-excel' );
    	header ( "Content-Disposition: attachment;filename=$filename" );
    	header ( 'Cache-Type: charset=gb2312');
    	echo "<style>table td{border:1px solid #ccc;}</style>";
    	echo "<table>";
    	 
    	echo '	<tr>';
    	echo ' 		<td align="center"><b> 订单号 </b></td>';
    	echo ' 		<td align="center"><b> 外部订单号 </b></td>';
		echo ' 		<td align="center" colspan="5" ><table><tr><td colspan="5" align="center" ><b>商品信息</b></td></tr><tr><td width="300" align="center"><b>商品名称</b></td><td align="center"><b>数量</b></td><td align="center"><b>单价</b></td><td align="center"><b>购买的商品规格</b></td><td align="center"><b>买家购买商品的留言</b></td></tr></table></td>';
    	echo ' 		<td align="center"><b> 买家 </b></td>';
    	echo ' 		<td align="center"><b> 订单状态 </b></td>';
    	echo ' 		<td align="center"><b> 收货人 </b></td>';
    	echo ' 		<td align="center"><b> 收货联系电话 </b></td>';
    	echo ' 		<td align="center"><b> 支付方式 </b></td>';
    	echo ' 		<td align="center"><b> 订单类型  </b></td>';
    	echo ' 		<td align="center"><b> 订单时间  </b></td>';
    	echo ' 		<td align="center"><b> 付款时间 </b></td>';
    	echo ' 		<td align="center"><b> 发货时间  </b></td>';
    	echo ' 		<td align="center"><b> 收货时间  </b></td>';
    	echo ' 		<td align="center"><b> 取消时间  </b></td>';
    	echo ' 		<td align="center"><b> 订单完成时间  </b></td>';
    	echo ' 		<td align="center"><b> 退款时间  </b></td>';
    	echo ' 		<td align="center"><b> 买家留言  </b></td>';
    	echo ' 		<td align="center"><b> 商家备注  </b></td>';
    	echo ' 		<td align="center"><b> 实际付款金额  </b></td>';
    	echo ' 		<td align="center"><b> 订单取消方式  </b></td>';
    	echo ' 		<td align="center"><b> 商品供货商 </b></td>';
    	echo ' 		<td align="center"><b> 是否对账  </b></td>';
    	echo ' 		<td align="center"><b> 商品金额  </b></td>';
    	echo ' 		<td align="center"><b> 订单金额  </b></td>';
    	echo ' 		<td align="center"><b> 订单地址/选择门店  </b></td>';
    	echo '	</tr>';
    
       	foreach ($orders as $k => $v) {
    		$tmp_info = '';

    		$product_info['status'] = $order_status_info;
    
    		echo '	<tr>';
    		echo ' 		<td  style="vnd.ms-excel.numberformat:@" align="center" width="300">' . $v['order_no'] . '</td>';
    		echo ' 		<td  style="vnd.ms-excel.numberformat:@" align="center" width="190">' . $v['trade_no'] . '</td>';
    		echo '<td colspan="5"><table style="height:100%">';
    		$guige = "";
			$comments_buyer= "";
    		foreach($v['products'] as $val) {
    			$skus =  !empty($val['sku_data']) ? unserialize($val['sku_data']) : '';
    			$comments = !empty($val['comment']) ? unserialize($val['comment']) : '';
				if ($skus) {
					foreach ($skus as $sku) { 
						$guige.= $sku['name'] .':'. $sku['value'] ." ";
					}
    			}
				if ($comments) {
					foreach ($comments as $comment) { 
						$comments_buyer.= $comment['name'] .':'. $comment['value'] ." ";
					}
				}
    			$liuyan="";
    			echo '<tr><td align="center">'.$val['name'].'</td><td align="center">' .$val['pro_num']. '</td><td align="center">￥'.$val['pro_price'].'</td><td align="center">'.$guige.'</td><td align="center">'.$comments_buyer.'</td></tr>';	
    		}
    		echo '</table></td>';

    		echo ' 		<td align="center">' . $v['buyer'] . '</td>';
    		echo ' 		<td align="center">' . $order_status[$v['status']] . '</td>';
    		echo ' 		<td align="center">' . $v['address_user'] . '</td>';
    		echo ' 		<td align="center">' . $v['address_tel'] . '</td>';
    		echo ' 		<td align="center">' . $payment_method[$v['payment_method']] . '</td>';
    		echo ' 		<td align="center">' . ($v['type'] == 0 ? '普通' : ($v['type'] == 1 ? '代付' : ($v['type'] == 2 ? '送礼' : '分销'))) . '</td>';
    		echo ' 		<td align="center">' . ($v['add_time'] ? date('Y-m-d H:i:s', $v['add_time']) : '' ). '</td>';
    		echo ' 		<td align="center">' . ($v['paid_time'] ? date('Y-m-d H:i:s', $v['paid_time']) : '' ). '</td>';
    		echo ' 		<td align="center">' . ($v['sent_time'] ? date('Y-m-d H:i:s', $v['sent_time']) : '' ). '</td>';
    		echo ' 		<td align="center">' . ($v['delivery_time'] ? date('Y-m-d H:i:s', $v['delivery_time']) : '' ). '</td>';
    		echo ' 		<td align="center">' . ($v['cancel_time'] ? date('Y-m-d H:i:s', $v['cancel_time']) : '' ). '</td>';
    		echo ' 		<td align="center">' . ($v['complate_time'] ? date('Y-m-d H:i:s', $v['complate_time']) : '' ). '</td>';
    		echo ' 		<td align="center">' . ($v['refund_time'] ? date('Y-m-d H:i:s', $v['refund_time']) : '' ). '</td>';
    		echo ' 		<td align="center">' . $v['comment'] . '</td>';
    		echo ' 		<td align="center">' . $v['bak'] . '</td>';
    		echo ' 		<td align="center">' . $v['pay_money'] . '</td>';
    		echo ' 		<td align="center">' . ($v['cancel_method'] == 0 ? '正常（过期自动取消）' : ($v['cancel_method'] == 1 ? '卖家手动取消' : '买家手动取消')) . '</td>';
    		$store_info = M('Store')->getStore($v['suppliers']);
    		echo ' 		<td align="center">' . $store_info['name'] . '</td>';
    		echo ' 		<td align="center">' . ($v['is_check'] == 1 ? '未对账' : '已对帐') . '</td>';
    		echo ' 		<td align="center">' . $v['sub_total']. '</td>';
    		echo ' 		<td align="center">' . $v['total'] . '</td>';
    		
    		$address = !empty($v['address']) ? unserialize($v['address']) : array();
			if ($v['shipping_method'] == 'selffetch') {
				$address_str = $address['name']." ".$address['province']." ".$address['city']." ".$address['area']." ".$address['address']." ".$v['address_tel'];
				
				$infos = "<b>门店：</b>" . $address_str ;
				if($v['address_user']) {
					$infos .= "  <b>预约人：</b>".$v['address_user'];
				}
				if($v['address_tel']) {
					$infos .= "<b>联系方式：</b>".$v['address_tel'];
				}
				if($address['time']) {
					$infos .= "<b>预约时间：</b>".$address['date'] . $address['time'];
				}
				echo ' 		<td align="left">'.$infos.'</td>';
			} else {
				
				$address_str='';
				if(!in_array($address['province_code'],array(110000,310000,500000,120000))){
					$address_str.=$address['province'];
				}
				$address_str.=$address['city'].$address['area'].$address['address'];
				echo ' 		<td align="center">' . $address_str . '</td>';
			}
    		
    		
    		
    		
    		echo '	</tr>';
    	}
    	echo '</table>';
    }
	


    private function _getProperty2Str($sku_data)
    {
        $tmp_properties = '';
        if (!empty($sku_data)) {
            $sku_data = unserialize($sku_data);
            $skus = array();
            if (is_array($sku_data)) {
                foreach ($sku_data as $sku) {
                    $skus[] = $sku['pid'] . ':' . $sku['vid'];
                }
            }
            $tmp_properties = implode(';', $skus);
        }
        return $tmp_properties;
    }

    public function testAssign()
    {
        $order_id = !empty($_GET['order_id']) ? $_GET['order_id'] : 0;
        M('Store_physical')->assignOrderToPhysical($order_id);
    }

    //分销对账
    public function fx_bill_check()
    {
        if (IS_AJAX) {
            $checked  = 2;
            $store_id = intval(trim($_POST['store_id']));
            $order_id = intval(trim($_POST['order_id']));
            if (empty($order_id)) {
                json_return(1001, '对账处理失败');
            }
            if (!empty($store_id)) {
                $sql = "UPDATE " . option('system.DB_PREFIX') . "order SET is_check = '" . $checked . "' WHERE store_id = '" . $store_id . "' AND (order_id = '" . $order_id . "' OR user_order_id = '" . $order_id . "')";
            } else {
                $sql = "UPDATE " . option('system.DB_PREFIX') . "order SET is_check = '" . $checked . "' WHERE status = 4 AND is_check = 1 AND store_id IN (SELECT seller_id FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET(" . $this->store_session['store_id'] . ", supply_chain)) AND (order_id = '" . $order_id . "' OR user_order_id = '" . $order_id . "')";
            }
            if (D('Order')->query($sql)) {
                json_return(0, '对账处理成功');
            } else {
                json_return(1001, '对账处理失败');
            }
        }
        $store_id = !empty($_REQUEST['store_id']) ? intval(trim($_REQUEST['store_id'])) : 0;
        $supplier_id = $this->store_session['store_id'];

        //未对账分销商
        if (empty($this->store_session['drp_supplier_id'])) {
            $sql = "SELECT o.store_id AS sellers FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $supplier_id . ", ss.supply_chain) GROUP BY o.store_id";
            $sellers = D('Order')->query($sql);
            $seller_count = 0;
            if (!empty($sellers)) {
                foreach ($sellers as $seller) {
                    $seller_count += 1;
                }
            }

            //未对账金额
            $sql = "SELECT SUM(income) AS income FROM " . option('system.DB_PREFIX') . "financial_record WHERE order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $supplier_id . ", ss.supply_chain)) AND status IN (1,2,3)";
            $incomes = D('Financial_record')->query($sql);
            $uncheck_amount = 0;
            if (!empty($incomes[0]['income'])) {
                $uncheck_amount = $incomes[0]['income'];
            }
            $uncheck_amount = number_format($uncheck_amount, 2, '.', '');

            //已对账金额
            $sql = "SELECT SUM(income) AS income FROM " . option('system.DB_PREFIX') . "financial_record WHERE order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 2 AND FIND_IN_SET(" . $supplier_id . ", ss.supply_chain)) AND status IN (1,2,3)";
            $incomes = D('Financial_record')->query($sql);
            $check_amount = 0;
            if (!empty($incomes[0]['income'])) {
                $check_amount = $incomes[0]['income'];
            }
            $check_amount = number_format($check_amount, 2, '.', '');

            //未对账订单
            $sql = "SELECT COUNT(o.order_id) AS orders FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $supplier_id . ", ss.supply_chain)";
            $orders = D('Order')->query($sql);
            $order_count = 0;
            if (!empty($orders[0]['orders'])) {
                $order_count = $orders[0]['orders'];
            }

            //销售额
            $sql = "SELECT SUM(o.total) AS sales FROM " . option('system.DB_PREFIX') . "order o INNER JOIN " . option('system.DB_PREFIX') . "store_supplier ss ON o.store_id = ss.seller_id WHERE ss.type = 1 AND o.status IN (2,3,4,7) AND FIND_IN_SET(1, ss.supply_chain) AND o.is_fx = 1";
            $sales = D('Order')->query($sql);
            $seller_sales = 0;
            if (!empty($sales[0]['sales'])) {
                $seller_sales = $sales[0]['sales'];
            }
            $seller_sales = number_format($seller_sales, 2, '.', '');
        } else {
            //未对账金额
            $where = array();
            $where['_string'] = "status IN (1,2,3) AND order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order WHERE status = 4 AND is_check = 1 AND store_id = '" . $this->store_session['store_id'] . "')";
            $uncheck_amount = D('Financial_record')->where($where)->sum('income');
            $uncheck_amount = number_format($uncheck_amount, 2, '.', '');

            //已对账金额
            $where = array();
            $where['_string'] = "status IN (1,2,3) AND order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order WHERE status = 4 AND is_check = 2 AND store_id = '" . $this->store_session['store_id'] . "')";
            $check_amount = D('Financial_record')->where($where)->sum('income');
            $check_amount = number_format($check_amount, 2, '.', '');

            //未对账订单
            $where = array();
            $where['status']   = 4;
            $where['is_check'] = 1;
            $where['store_id'] = $this->store_session['store_id'];
            $order_count = D('Order')->where($where)->count('store_id');

            //销售额（不含退货）
            $sql = "SELECT SUM(o.total) AS sales FROM " . option('system.DB_PREFIX') . "order o WHERE o.store_id = '" . $this->store_session['store_id'] . "' AND o.is_fx = 1 AND o.status IN (2,3,4,7)";
            $seller_sales = D('')->query($sql);
            $seller_sales =  !empty($seller_sales[0]['sales']) ? $seller_sales[0]['sales'] : 0;
            $seller_sales = number_format($seller_sales, 2, '.', '');
        }

        $this->assign('store_id', $store_id);
        $this->assign('seller_count', $seller_count);
        $this->assign('uncheck_amount', $uncheck_amount);
        $this->assign('check_amount', $check_amount);
        $this->assign('order_count', $order_count);
        $this->assign('seller_sales', $seller_sales);
        $this->display();
    }

    //分销对账
    private function _fx_bill_check_content()
    {
        $order         = M('Order');
        $order_product = M('Order_product');

        $store_id  = $this->store_session['store_id'];
        $seller_id = !empty($_REQUEST['store_id']) ? intval(trim($_REQUEST['store_id'])) : 0;
        $checked   = intval(trim($_POST['checked']));

        if (!empty($checked)) {
            if (!empty($seller_id)) { //指定分销商
                $sql = "SELECT COUNT(o.order_id) AS order_count FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = '" . $seller_id . "' AND o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.type = 3 AND is_check = '" . $checked .  "' AND FIND_IN_SET(" . $store_id . ", ss.supply_chain)";
                $order_count = D('Order')->query($sql);
                if (!empty($order_count)) {
                    $order_count = $order_count[0]['order_count'];
                } else {
                    $order_count = 0;
                }

                import('source.class.user_page');
                $page = new Page($order_count, 15);
                $sql = "SELECT o.* FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = '" . $seller_id . "' AND o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.type = 3 AND is_check = '" . $checked .  "' AND FIND_IN_SET(" . $store_id . ", ss.supply_chain) ORDER BY o.order_id DESC LIMIT " . $page->firstRow . "," . $page->listRows;
                $orders = D('Order')->query($sql);
            } else {
                if (empty($this->store_session['drp_supplier_id'])) {
                    $sql = "SELECT COUNT(o1.order_id) AS order_count FROM " . option('system.DB_PREFIX') . "order o1 WHERE o1.store_id = '" . $store_id . "' AND o1.status = 4 AND o1.is_fx = 0 AND o1.type = 3 AND (o1.user_order_id in (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.order_id = o1.user_order_id AND o2.is_check = '" . $checked . "' AND o2.status = 4 AND o1.store_id != o2.store_id) OR o1.user_order_id in (SELECT user_order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.user_order_id = o1.user_order_id AND o2.is_check = '" . $checked . "' AND o2.status = 4 AND o1.store_id != o2.store_id AND o2.order_id < o1.order_id)) ORDER BY order_id DESC";
                } else {
                    $sql = "SELECT COUNT(o1.order_id) AS order_count FROM " . option('system.DB_PREFIX') . "order o1 WHERE o1.store_id = '" . $store_id . "' AND o1.status = 4 AND o1.type = 3 AND o1.is_check = '" . $checked .  "' ORDER BY order_id DESC";
                }

                $order_count = D('Order')->query($sql);
                if (!empty($order_count)) {
                    $order_count = $order_count[0]['order_count'];
                } else {
                    $order_count = 0;
                }
                import('source.class.user_page');
                $page = new Page($order_count, 15);

                if (empty($this->store_session['drp_supplier_id'])) {
                    $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "order o1 WHERE o1.store_id = '" . $store_id . "' AND o1.status = 4 AND o1.is_fx = 0 AND o1.type = 3 AND (o1.user_order_id in (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.order_id = o1.user_order_id AND o2.is_check = '" . $checked . "' AND o2.status = 4 AND o1.store_id != o2.store_id) OR o1.user_order_id in (SELECT user_order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.user_order_id = o1.user_order_id AND o2.is_check = '" . $checked . "' AND o2.status = 4 AND o1.store_id != o2.store_id AND o2.order_id < o1.order_id)) ORDER BY order_id DESC LIMIT " . $page->firstRow . ',' . $page->listRows;
                } else {
                    $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "order o1 WHERE store_id = '" . $store_id . "' AND status = 4 AND type = 3 AND is_check = '" . $checked . "' ORDER BY order_id DESC LIMIT " . $page->firstRow . ',' . $page->listRows;
                }
                $orders = D('Order')->query($sql);
            }

            foreach ($orders as &$order) {
                $tmp_order = array();
                if (empty($order['user_order_id'])) {
                    $user_order_id = $order['order_id'];
                    $tmp_order['store_id'] = $order['store_id'];
                } else {
                    $user_order_id = $order['user_order_id'];
                    $tmp_order = D('Order')->field('store_id,order_id,total,payment_method')->where(array('order_id' => $user_order_id))->find();
                    $order['total'] = $tmp_order['total'];
                }

                $order['original_order_id'] = $user_order_id;
                $order_id = $order['order_id'];
                if (!empty($seller_id)) { //分销商

                    if (empty($order['user_order_id'])) {
                        $order['original_order_id'] = $order_id;
                    } else {
                        $tmp_order = D('Order')->field('store_id,order_id,payment_method')->where(array('store_id' => $seller_id, 'user_order_id' => $user_order_id))->find();
                        $order['original_order_id'] = $tmp_order['order_id'];
                    }

                    $where = array();
                    $where['store_id']      = $this->store_session['store_id'];
                    $where['user_order_id'] = $user_order_id;
                    $tmp_order = D('Order')->field('store_id,order_id,payment_method')->where($where)->find();
                    $order['order_id'] = $order_id = $tmp_order['order_id'];
                    $tmp_order['store_id'] = $order['store_id'];
                }

                //主订单商品
                $products = $order_product->getProducts($user_order_id);
                foreach ($products as $key => $product) {
                    if ($product['store_id'] != $store_id && empty($this->store_session['drp_supplier_id'])) { //非当前店铺商品
                        unset($products[$key]);
                        continue;
                    }
                    //退货商品
                    $return_products = D('Return_product')->field('pro_num')->where(array('order_id' => $user_order_id, 'order_product_id' => $product['pigcms_id']))->select();
                    if (!empty($return_products)) {
                        foreach ($return_products as $return_product) {
                            $products[$key]['return_quantity'] += $return_product['pro_num'];
                        }
                    }
                }
                $order['products'] = $products;

                //分销商
                if ($tmp_order['store_id'] == $store_id) {
                    $order['seller'] = '本店';
                } else {
                    $seller = D('Store')->field('name')->where(array('store_id' => $tmp_order['store_id']))->find();
                    $order['seller'] = $seller['name'];
                }


                //支付方式
                if (!empty($tmp_order['payment_method'])) {
                    $order['payment_method'] = $tmp_order['payment_method'];
                }

                if (!empty($seller_id)) {
                    $sql = "SELECT o.order_id,o.store_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND o.store_id = '" . $seller_id . "' AND FIND_IN_SET(" . $store_id . ", ss.supply_chain) AND (o.order_id = '" . $user_order_id . "' OR o.user_order_id = '" . $user_order_id . "') AND o.is_check = '" . $checked . "'";
                } else {
                    $sql = "SELECT o.order_id,o.store_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND o.order_id < '" . $order_id . "' AND FIND_IN_SET(" . $store_id . ", ss.supply_chain) AND (o.order_id = '" . $user_order_id . "' OR o.user_order_id = '" . $user_order_id . "') AND o.is_check = '" . $checked . "'";
                }

                $fx_orders = D('')->query($sql);

                //待对账金额
                $order['check_amount'] = 0;
                $order['sellers'] = array();
                if (empty($this->store_session['drp_supplier_id'])) {
                    $order['sellers'] = array();
                    foreach ($fx_orders as $fx_order) {
                        //分销商分销利润
                        $income = M('Financial_record')->getOrderProfit($fx_order['order_id']);
                        $order['check_amount'] += $income;
                        $seller = D('Store')->field('store_id,name,drp_level')->where(array('store_id' => $fx_order['store_id']))->find();
                        $order['sellers'][] = array(
                            'store_id'     => $seller['store_id'],
                            'name'         => $seller['name'],
                            'check_amount' => $income,
                            'drp_level'    => $seller['drp_level']
                        );
                    }
                    array_multisort($order['sellers'], SORT_ASC, SORT_NUMERIC);
                } else {
                    $order['check_amount'] = M('Financial_record')->getOrderProfit($order['order_id']);
                }
                $order['check_amount'] = number_format($order['check_amount'], 2, '.', '');
            }

            //支付方式
            $payment_method = M('Order')->getPaymentMethod();

            $this->assign('orders', $orders);
            $this->assign('payment_method', $payment_method);

        } else { //未对账分销商
            $sql = "SELECT COUNT(s.store_id) AS seller_count FROM " . option('system.DB_PREFIX') . "store s WHERE s.store_id IN (SELECT o.store_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND o.is_check = 1 AND o.status = 4 AND FIND_IN_SET(" . $store_id . ", ss.supply_chain)) AND s.status = 1";
            $seller_count = D('Order')->query($sql);
            $seller_count = !empty($seller_count[0]['seller_count']) ? $seller_count[0]['seller_count'] : 0;

            import('source.class.user_page');
            $page = new Page($seller_count, 15);

            $sql = "SELECT s.store_id,s.name,s.logo,s.drp_level,s.service_tel,s.service_qq,s.service_weixin FROM " . option('system.DB_PREFIX') . "store s WHERE s.store_id IN (SELECT o.store_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND o.is_check = 1 AND o.status = 4 AND FIND_IN_SET(" . $store_id . ", ss.supply_chain)) AND s.status = 1 ORDER BY s.store_id ASC LIMIT " . $page->firstRow . ',' . $page->listRows;
            $sellers = D('Store')->query($sql);

            foreach ($sellers as &$seller) {
                $sales = $order->getSales(array('store_id' => $seller['store_id'], 'is_fx' => 1, 'status' => array('in', array(2,3,4,7))));

                $seller['logo']  = !empty($seller['logo']) ? getAttachmentUrl($seller['logo']) : getAttachmentUrl('images/default_shop.png', false);
                $seller['sales'] = !empty($sales) ? number_format($sales, 2, '.', '') : '0.00';

                //未对账佣金
                $where = array();
                $where['store_id'] = $seller['store_id'];
                $where['status']   = 4;
                $where['is_check'] = 1;
                $where['_string']  = "FIND_IN_SET(" . $store_id . ", suppliers)";
                $fx_orders = D('Order')->field('order_id,store_id')->where($where)->select();
                $seller['uncheck_profit'] = 0;
                foreach ($fx_orders as $fx_order) {
                    $income = M('Financial_record')->getOrderProfit($fx_order['order_id']);
                    $seller['uncheck_profit'] += $income;
                }
                $seller['uncheck_profit'] = number_format($seller['uncheck_profit'], 2, '.', '');

                //已对账佣金
                $where = array();
                $where['store_id'] = $seller['store_id'];
                $where['status']   = 4;
                $where['is_check'] = 2;
                $where['_string']  = "FIND_IN_SET(" . $store_id . ", suppliers)";
                $fx_orders = D('Order')->field('order_id,store_id')->where($where)->select();
                $seller['checked_profit'] = 0;
                foreach ($fx_orders as $fx_order) {
                    $income = M('Financial_record')->getOrderProfit($fx_order['order_id']);
                    $seller['checked_profit'] += $income;
                }
                $seller['checked_profit'] = number_format($seller['checked_profit'], 2, '.', '');

                //未对账订单
                $where = array();
                $where['store_id'] = $seller['store_id'];
                $where['status']   = 4;
                $where['is_check'] = 1;
                $where['_string']  = "FIND_IN_SET(" . $store_id . ", suppliers)";
                $uncheck_order = D('Order')->where($where)->count('order_id');
                $seller['uncheck_order'] = $uncheck_order;
            }

            $this->assign('sellers', $sellers);
        }
        $this->assign('is_check', $checked);
        $this->assign('page', $page->show());
    }

    //批发对账
    public function ws_bill_check()
    {
        $wholesale_id = !empty($_REQUEST['store_id']) ? intval(trim($_REQUEST['store_id'])) : 0;
        if (IS_AJAX) {

            if (!$this->checkFx(true)) {
                json_return(1001, '对账处理失败');
            }

            $checked  = 2;
            $order_id = intval(trim($_POST['order_id']));
            if (empty($order_id)) {
                json_return(1001, '对账处理失败');
            }

            $sql = "UPDATE " . option('system.DB_PREFIX') . "order SET is_check ={$checked} WHERE order_id = {$order_id}";
            if (D('Order')->execute($sql)) {
                json_return(0, '对账处理成功');
            } else {
                json_return(1001, '对账处理失败');
            }
        }

        $this->checkFx(false, true);

        $supplier_id = $this->store_session['store_id'];

        //未对账的经销商
        $sql = "SELECT COUNT(DISTINCT f.`store_id`) as store_id FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$supplier_id} AND TYPE = 5 AND o.is_check = 1 AND o.status = 4";
        $unwholesale = D('Store')->query($sql);
        $wholesale_count = $unwholesale[0]['store_id'];

        //未对账金额
        $sql = "SELECT SUM(income) AS income from ". option('system.DB_PREFIX') ."financial_record WHERE order_id IN (SELECT order_id FROM ". option('system.DB_PREFIX') ."order where store_id='".$supplier_id."' AND TYPE = 5 AND is_check = 1 AND STATUS = 4) AND status IN (1,3) AND type = 6";
        $unwholesale = D('Store')->query($sql);
        $income = $unwholesale[0]['income'];
        $uncheck_amount = number_format($income, 2, '.', '');

        //已对账金额
        $sql = "SELECT SUM(income) AS income from ". option('system.DB_PREFIX') ."financial_record WHERE order_id IN (SELECT order_id FROM ". option('system.DB_PREFIX') ."order where store_id='".$supplier_id."' AND TYPE = 5 AND is_check = 2 AND STATUS = 4) AND status IN (1,3) AND type = 6";
        $unwholesale = D('Store')->query($sql);
        $income = $unwholesale[0]['income'];
        $check_amount = number_format($income, 2, '.', '');

        //未对账订单
        $sql = "SELECT COUNT(O.order_id) as store_id FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$supplier_id} AND TYPE = 5 AND o.is_check = 1 AND o.status = 4";
        $order = D('Store')->query($sql);
        $order_count = $order[0]['store_id'];

        //销售额
        //$sql = "SELECT SUM(o.total) as income FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$supplier_id} AND TYPE = 5  AND o.status = 4";
        $sql = "SELECT SUM(income) AS income from ". option('system.DB_PREFIX') ."financial_record WHERE order_id IN (SELECT order_id FROM ". option('system.DB_PREFIX') ."order where store_id='".$supplier_id."' AND TYPE = 5 AND STATUS = 4) AND status IN (1,3) AND type = 6";
        $unwholesale = D('Store')->query($sql);
        $income = $unwholesale[0]['income'];
        $seller_sales = number_format($income, 2, '.', '');

        $this->assign('check_amount', $check_amount);
        $this->assign('wholesale_id', $wholesale_id);
        $this->assign('order_count', $order_count);
        $this->assign('seller_sales', $seller_sales);
        $this->assign('wholesale_count', $wholesale_count);
        $this->assign('uncheck_amount', $uncheck_amount);
        $this->display();
    }

    //批发对账
    private function _ws_bill_check_content()
    {
        $order         = M('Order');
        $fx_order_product = M('Fx_order_product');

        $store_id  = $this->store_session['store_id'];
        $wholesale_id = !empty($_REQUEST['store_id']) ? intval(trim($_REQUEST['store_id'])) : 0;
        $checked   = intval(trim($_POST['checked']));

        if(!empty($checked) && $checked != 3)
        {
            if(empty($wholesale_id)){
                $sql_count = "SELECT COUNT(O.order_id) as store_id FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND TYPE = 5 AND o.is_check = {$checked} AND o.status = 4";
            }else{
                $sql_count = "SELECT COUNT(O.order_id) as store_id FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND f.`store_id`={$wholesale_id} AND TYPE = 5 AND o.is_check = {$checked} AND o.status = 4";
            }

            $order = D('Store')->query($sql_count);
            $order_count = $order[0]['store_id'];
            import('source.class.user_page');
            $page = new Page($order_count, 15);
            if(empty($wholesale_id)){
                $sql = "SELECT f.total, f.total,f.cost_total,f.fx_order_id,f.store_id,f.add_time, o.payment_method,o.order_no,o.trade_no,o.order_id FROM " .option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND TYPE = 5 AND o.is_check = {$checked} AND o.status = 4 ORDER BY o.order_id DESC LIMIT " . $page->firstRow . "," . $page->listRows;
            }else{
                $sql = "SELECT f.total, f.total,f.cost_total,f.fx_order_id,f.store_id,f.add_time, o.payment_method,o.order_no,o.trade_no,o.order_id FROM " .option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND f.`store_id`={$wholesale_id} AND TYPE = 5 AND o.is_check = {$checked} AND o.status = 4 ORDER BY o.order_id DESC LIMIT " . $page->firstRow . "," . $page->listRows;
            }
            //echo $sql;
            $orders = D('Order')->query($sql);

            foreach($orders as &$order)
            {
                $products = $fx_order_product->getProducts($order['fx_order_id']);
                //订单来源
                $seller = D('Store')->field('name')->where(array('store_id'=>$order['store_id']))->find();
                $order['seller'] = $seller['name'];
                $order['products'] = $products;
            }

            //支付方式
            $payment_method = M('Order')->getPaymentMethod();

            $this->assign('payment_method', $payment_method);
            $this->assign('is_check', $checked);
            $this->assign('orders', $orders);
            $this->assign('page', $page->show());
        }else if($checked == 3){

            $sql_count = "SELECT COUNT(O.order_id) as store_id FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND f.`store_id`={$store_id} AND TYPE = 5 AND o.is_check = 2 AND o.status = 4";

            $order = D('Store')->query($sql_count);
            $order_count = $order[0]['store_id'];
            import('source.class.user_page');
            $page = new Page($order_count, 15);

            $sql = "SELECT f.total, f.total,f.cost_total,f.fx_order_id,f.store_id,f.add_time, o.payment_method,o.order_no,o.trade_no,o.order_id,o.user_order_id FROM " .option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND f.`store_id`={$store_id} AND TYPE = 5 AND o.is_check = 2 AND o.status = 4 ORDER BY o.order_id DESC LIMIT " . $page->firstRow . "," . $page->listRows;

            $orders = D('Order')->query($sql);

            foreach($orders as &$order)
            {
                $products = $fx_order_product->getProducts($order['fx_order_id']);

                //订单来源
                $seller = D('Store')->field('name')->where(array('store_id'=>$order['store_id']))->find();
                $order['seller'] = $seller['name'];
                $order['products'] = $products;
            }

            //支付方式
            $payment_method = M('Order')->getPaymentMethod();

            $this->assign('payment_method', $payment_method);
            $this->assign('is_check', $checked);
            $this->assign('orders', $orders);
            $this->assign('page', $page->show());
        }else{
            //未对账的经销商
            $sql_count = "SELECT COUNT(DISTINCT f.`store_id`) as store_id FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND TYPE = 5 AND o.is_check = 1 AND o.status = 4";
            $unwholesale = D('Store')->query($sql_count);
            $wholesale_count = $unwholesale[0]['store_id'];
            import('source.class.user_page');
            $page = new Page($wholesale_count, 15);
            $sql = "SELECT DISTINCT s.* FROM pigcms_order o, pigcms_fx_order f,pigcms_store s WHERE s.`store_id`= f.`store_id` AND o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND TYPE = 5 AND o.is_check = 1 AND o.status = 4 ORDER BY o.order_id DESC LIMIT " . $page->firstRow . "," . $page->listRows;
            $sellers = D('Order')->query($sql);

            foreach($sellers as &$seller)
            {
                //未对账佣金
                $sql = "SELECT SUM(f.cost_sub_total) as income FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND f.`store_id`={$seller['store_id']} AND TYPE = 5 AND o.is_check = 1 AND o.status = 4";
                //$sql = "SELECT SUM(income) AS income from ". option('system.DB_PREFIX') ."financial_record WHERE order_id IN (SELECT order_id FROM ". option('system.DB_PREFIX') ."order where store_id='".$seller['store_id']."' AND TYPE = 5 AND is_check = 1 AND STATUS = 4) AND status IN (1,3) AND type = 6";
                $unwholesale = D('Store')->query($sql);
                $income = $unwholesale[0]['income'];
                $seller['uncheck_profit'] = $uncheck_amount = number_format($income, 2, '.', '');

                //已对账佣金
                $sql = "SELECT SUM(f.cost_sub_total) as income FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND f.`store_id`={$seller['store_id']} AND TYPE = 5 AND o.is_check = 2 AND o.status = 4";
                //$sql = "SELECT SUM(income) AS income from ". option('system.DB_PREFIX') ."financial_record WHERE order_id IN (SELECT order_id FROM ". option('system.DB_PREFIX') ."order where store_id='".$seller['store_id']."' AND TYPE = 5 AND is_check = 2 AND STATUS = 4) AND status IN (1,3) AND type = 6";
                $wholesale_income = D('Store')->query($sql);
                $check_income = $wholesale_income[0]['income'];
                $seller['checked_profit'] = $check_amount = number_format($check_income, 2, '.', '');

                //未对账订单
                $sql = "SELECT COUNT(O.order_id) as store_id FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND f.`store_id`={$seller['store_id']} AND TYPE = 5 AND o.is_check = 1 AND o.status = 4";
                $order = D('Store')->query($sql);
                $seller['uncheck_order'] = $order[0]['store_id'];

                //销售额
                $sql = "SELECT SUM(o.total) as income FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$store_id} AND f.`store_id`={$seller['store_id']} AND TYPE = 5  AND o.status = 4";
                //$sql = "SELECT SUM(income) AS income from ". option('system.DB_PREFIX') ."financial_record WHERE order_id IN (SELECT order_id FROM ". option('system.DB_PREFIX') ."order where store_id='".$seller['store_id']."' AND TYPE = 5 AND STATUS = 4) AND status IN (1,3) AND type = 6";
                $unwholesale = D('Store')->query($sql);
                $income = $unwholesale[0]['income'];
                $seller['sales'] = number_format($income, 2, '.', '');

            }
            $this->assign('sellers', $sellers);
        }
	}

	public function add() {
		if (IS_POST) {
			$store_id = $this->store_session['store_id'];
			$product_data_list = $_POST['product_list'];
			$uid = $_POST['uid'];
			$logistics_type = $_POST['logistics_type'];
			$address_id = $_POST['address_id'];
			$pay_type = $_POST['pay_type'];
			$coupon_id = $_POST['coupon_id'];

			// 上门自提变量
			$selffetch_id = $_POST['selffetch_id'];
			$selffetch_name = $_POST['selffetch_name'];
			$selffetch_tel = $_POST['selffetch_tel'];
			$selffetch_date = $_POST['selffetch_date'];

			// 送朋友变量
			$friend_province_id = $_POST['friend_province_id'];
			$friend_city_id = $_POST['friend_city_id'];
			$friend_area_id = $_POST['friend_area_id'];
			$friend_jiedao = $_POST['friend_jiedao'];
			$friend_name = $_POST['friend_name'];
			$friend_tel = $_POST['friend_tel'];
			$friend_date = $_POST['friend_date'];
			
			// 扣分抵扣
			$point = $_POST['point'];
			$point_money = $_POST['point_money'];

			$session_key = $_POST['session_key'];

			if (empty($uid)) {
				json_return(1000, '请选择会员');
			}

			$user = D('User')->where(array('uid' => $uid))->find();
			if (empty($user)) {
				json_return(1001, '未找到会员信息');
			}

			// 订单表数据
			$order_data = array();
			if ($logistics_type == 'logistics') {
				if (empty($address_id)) {
					json_return(1002, '请选择收货地址');
				}

				$user_address = M('User_address')->getAdressById(0, $uid, $address_id);
				if (empty($user_address)) {
					json_return(1003, '未找到相应的收货地址');
				}

				$order_data['shipping_method'] = 'express';
				$order_data['address_user'] = $user_address['name'];
				$order_data['address_tel'] = $user_address['tel'];
				$order_data['address'] = serialize(array(
					'address' => $user_address['address'],
					'province' => $user_address['province_txt'],
					'province_code' => $user_address['province'],
					'city' => $user_address['city_txt'],
					'city_code' => $user_address['city'],
					'area' => $user_address['area_txt'],
					'area_code' => $user_address['area'],
				));

			} else if ($logistics_type == 'selffetch') {
				if (empty($selffetch_id)) {
					json_return(1004, '请选择门店');
				}

				if (empty($selffetch_name)) {
					json_return(1005, '请填写收件人姓名');
				}

				if (empty($selffetch_tel)) {
					json_return(1006, '请填写联系电话');
				}

				if (!preg_match("/\d{5,12}$/", $selffetch_tel)) {
					json_return(1006, '手机号格式不正确，请正确填写');
				}

				if (empty($selffetch_date)) {
					json_return(1007, '请选择预约时间');
				}

				list($selffetch_date1, $selffetch_time) = explode(' ', $selffetch_date, 2);

				// 判断门店信息是否正确
				$selffetch = array();
				if (strpos($selffetch_id, 'store')) {
					$selffetch = M('Store_contact')->get($store_id);
					if (!empty($selffetch)) {
						$store = M('Store')->getStore($store_id);
						$selffetch['tel'] = ($selffetch['phone1'] ? $selffetch['phone1'] . '-' : '') . $selffetch['phone2'];
						$selffetch['business_hours'] = '';
						$selffetch['name'] = $store['name'];
						$selffetch['physical_id'] = 0;
						$selffetch['store_id'] = $store_id;
					}
				} else {
					$selffetch = M('Store_physical')->getOne($selffetch_id);
					if (!empty($selffetch) && $selffetch['store_id'] != $store_id) {
						$selffetch = '';
					} else if (!empty($selffetch)) {
						$selffetch['tel'] = ($selffetch['phone1'] ? $selffetch['phone1'] . '-' : '') . $selffetch['phone2'];
						$selffetch['physical_id'] = $selffetch_id;
						$selffetch['store_id'] = $store_id;
					}
				}

				if (empty($selffetch)) {
					json_return(1009, '该门店不存在');
				}

				$order_data['postage'] = '0';
				$order_data['shipping_method'] = 'selffetch';
				$order_data['address_user'] = $selffetch_name;
				$order_data['address_tel'] = $selffetch_tel;
				$order_data['address'] = serialize(array(
					'name' => $selffetch['name'],
					'address' => $selffetch['address'],
					'province' => $selffetch['province_txt'],
					'province_code' => $selffetch['province'],
					'city' => $selffetch['city_txt'],
					'city_code' => $selffetch['city'],
					'area' => $selffetch['county_txt'],
					'area_code' => $selffetch['county'],
					'tel' => $selffetch['tel'],
					'long' => $selffetch['long'],
					'lat' => $selffetch['lat'],
					'business_hours' => $selffetch['business_hours'],
					'date' => $selffetch_date1,
					'time' => $selffetch_time,
					'store_id' => $selffetch['store_id'],
					'physical_id' => $selffetch['physical_id'],
				));
			} else if ($logistics_type == 'friend') {
				if (empty($friend_province_id)) {
					json_return(1008, '请选择省份');
				}

				if (empty($friend_city_id)) {
					json_return(1008, '请选择城市');
				}

				if (empty($friend_area_id)) {
					json_return(1008, '请选择地区');
				}

				if (empty($friend_jiedao)) {
					json_return(1008, '请填写朋友所在街道');
				}

				if (mb_strlen($friend_jiedao, 'utf-8') > 120) {
					json_return(1008, '所在街道最多只能填写120个字');
				}

				if (empty($friend_name)) {
					json_return(1008, '请填写朋友姓名');
				}

				if (empty($friend_tel)) {
					json_return(1008, '请填写朋友手机号');
				}

				if (!preg_match("/\d{5,12}$/", $friend_tel)) {
					json_return(1006, '朋友手机号格式不正确，请正确填写');
				}

				list($friend_date2, $friend_time) = explode(' ', $friend_date, 2);

				import('source.class.area');
				$area_class = new area();
				$province_txt = $area_class->get_name($friend_province_id);
				$city_txt = $area_class->get_name($friend_city_id);
				$county_txt = $area_class->get_name($friend_area_id);

				if (empty($province_txt) || empty($city_txt)) {
					json_return(1009, '该地址不存在');
				}

				$order_data['address_user'] = $friend_name;
				$order_data['address_tel'] = $friend_tel;
				$order_data['address'] = serialize(array(
					'address' => $friend_jiedao,
					'province' => $province_txt,
					'province_code' => $friend_province_id,
					'city' => $city_txt,
					'city_code' => $friend_city_id,
					'area' => $county_txt,
					'area_code' => $friend_area_id,
					'date' => $friend_date2,
					'time' => $friend_time,
				));
			} else {
				json_return(1000, '请选择配送方式');
			}

			// 商品信息
			$store_id = $this->store_session['store_id'];
			$product_list = array();
			$total_money = 0;
			$pro_count = 0;
			$pro_num = 0;
			$discount_money = 0;
			$product_id_arr = array();
			foreach ($product_data_list as $tmp) {
				list($product_id, $sku_id, $number, $price) = explode('_', $tmp);
				$product_id_arr[$product_id] = $product_id;

				if (empty($product_id) && empty($number)) {
					json_return(1000, '产品信息错误，请正确操作');
				}

				$product = D('Product')->where(array('product_id' => $product_id, 'store_id' => $store_id))->find();
				if (empty($product)) {
					json_return(1000, '产品不存在，请正确操作');
				}

				// 有属性，但是库存ID不存在，直接跳过
				if ($product['has_property'] && empty($sku_id)) {
					json_return(1000, '产品信息有误，请正确操作');
				}

				if (!empty($sku_id)) {
					$product_sku = D('Product_sku')->where(array('sku_id' => $sku_id, 'product_id' => $product_id))->find();
					if (empty($product_sku)) {
						json_return(1000, '产品信息有误，请正确操作');
					}

					$product['pro_price'] = $price;
					if (!empty($product_sku['weight'])) {
						$product['pro_weight'] = $product_sku['weight'];
					}

					// 库存判断
					if ($product_sku['quantity'] < $number) {
						json_return(1000, '产品：' . $product['name'] . '的库存不足');
					}

					$tmpPropertiesArr = explode(';', $product_sku['properties']);
					$properties = $propertiesValue = $productProperties = array();
					foreach ($tmpPropertiesArr as $value) {
						$tmpPro = explode(':', $value);
						$properties[] = $tmpPro[0];
						$propertiesValue[] = $tmpPro[1];
					}
					if (count($properties) == 1) {
						$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => $properties[0]))->select();
						$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid' => $propertiesValue[0]))->select();
					} else {
						$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => array('in', $properties)))->select();
						$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid' => array('in', $propertiesValue)))->select();
					}
					foreach ($findPropertiesArr as $value) {
						$propertiesArr[$value['pid']] = $value['name'];
					}
					foreach ($findPropertiesValueArr as $value) {
						$propertiesValueArr[$value['vid']] = $value['value'];
					}
					foreach ($properties as $key => $value) {
						$productProperties[] = array('pid' => $value, 'name' => $propertiesArr[$value], 'vid' => $propertiesValue[$key], 'value' => $propertiesValueArr[$propertiesValue[$key]]);
					}
					$propertiesStr = serialize($productProperties);

					$product['properties'] = $product_sku['properties'];
					$product['sku_data'] = $propertiesStr;
					$product['sku_id'] = $sku_id;
				} else {
					// 库存判断
					if ($product['quantity'] < $number) {
						json_return(1000, '产品：' . $product['name'] . '的库存不足');
					}
					
					$product['pro_price'] = $price;
					$product['pro_weight'] = $product['weight'];
					$product['sku_data'] = '';
					$product['sku_id'] = 0;
				}
				$product['pro_num'] = $number;
				$product['wholesale_supplier_id'] = $store_id;

				// 折扣金额
				$discount = 10;
				$discount = $_SESSION['reward'][$session_key]['discount_list'][$product['store_id']];

				if ($discount != 10 && $discount > 0) {
					$discount_money += $product['pro_num'] * $product['pro_price'] * (10 - $discount) / 10;
				}

				if ($product['buyer_quota']) {
					// 限购
					$buy_quantity = M('Order_product')->getBuyNumber($uid, $product['product_id'], 'uid');

					if ($buy_quantity + $number > $product['buyer_quota']) {
						json_return(1010, '您购买的产品：' . $product['name'] . '超出了限购');
					}
				}

				unset($product['intro']);
				unset($product['info']);

				$product_list[] = $product;

				$total_money += $product['pro_price'] * $number;
				$pro_count++;
				$pro_num += $number;
			}

			// 获取之前的处理数据
			if (!isset($_SESSION['reward'][$session_key]) || ($logistics_type != 'selffetch' && (!isset($_SESSION['postage'][$session_key]) || !isset($_SESSION['postage_error'][$session_key])))) {
				json_return(2000, '数据错误，请刷新页面重试');
			}

			if ($logistics_type != 'selffetch' && $_SESSION['postage_error'][$session_key]) {
				json_return(2000, '不能配送到此收货地址');
			}

			$time = time();
			$order_data['store_id'] = $store_id;
			$order_data['order_no'] = $order_data['trade_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
			$order_data['uid'] = $uid;
			$order_data['postage'] = 0;
			if ($logistics_type != 'selffetch') {
				$order_data['postage'] = $_SESSION['postage'][$session_key]['postage'] + 0;
			}
			$order_data['sub_total'] = $total_money;
			$order_data['total'] = $total_money + $order_data['postage'];
			$order_data['pro_count'] = $pro_count;
			$order_data['pro_num'] = $pro_num;
			$order_data['payment_method'] = $pay_type;
			$order_data['status'] = 1;
			if ($pay_type == 'offline') {
				$order_data['payment_method'] = 'codpay';
				$order_data['status'] = 2;
			}
			
			$order_data['shipping_method'] = 'express';
			if ($logistics_type == 'selffetch') {
				$order_data['shipping_method'] = 'selffetch';
			} else if ($logistics_type == 'friend') {
				$order_data['shipping_method'] = 'friend';
			}
			
			$order_data['add_time'] = $time;
			$order_data['paid_time'] = 0;
			$order_data['sent_time'] = 0;
			$order_data['delivery_time'] = 0;
			$order_data['complate_time'] = 0;
			// 现金支付
			if ($pay_type == 'cash') {
				$order_data['paid_time'] = $time;
				$order_data['sent_time'] = $time;
				$order_data['delivery_time'] = $time;
				
				$order_data['payment_method'] = 'cash';
				$order_data['status'] = 7;
				
				// 店铺收款
				$order_data['useStorePay'] = 1;
				$order_data['storePay'] = $this->store_session['store_id'];
			}
			
			$order_data['bak'] = '后台添加订单';
			$order_data['pay_money'] = $order_data['total'];
			$order_data['is_check'] = 1;

			$order_id = D('Order')->data($order_data)->add();
			if ($order_id) {
				// 插入订单产品表
				foreach ($product_list as $product) {
					$order_product_data = array();
					$order_product_data['order_id'] = $order_id;
					$order_product_data['product_id'] = $product['product_id'];
					$order_product_data['sku_id'] = $product['sku_id'];
					$order_product_data['sku_data'] = $product['sku_data'];
					$order_product_data['pro_num'] = $product['pro_num'];
					$order_product_data['pro_price'] = $product['pro_price'];
					$order_product_data['pro_weight'] = $product['pro_weight'];
					//$order_product_data['is_packaged'] = 1;
					//$order_product_data['in_package_status'] = 3;
					$order_product_data['is_fx'] = 0;
					$order_product_data['supplier_id'] = 0;
					$order_product_data['original_product_id'] = 0;
					$order_product_data['user_order_id'] = $order_id;
					
					$product_discount = M('Product_discount')->getPointDiscount($product, $uid);
					if (!empty($product_discount['point'])) {
						$order_product_data['point'] = $product_discount['point'];
					}
					if (!empty($product_discount['discount'])) {
						$order_product_data['discount'] = $product_discount['discount'];
					}

					D('Order_product')->data($order_product_data)->add();
					
					if ($pay_type == 'cash') {
						// 更改库存和销量
						$tmp_product_id = $product['product_id'];
						$properties = $product['properties'];
						$quantity = $product['pro_num'];
	
						D('Product')->where(array('product_id' => $tmp_product_id))->setDec('quantity', $quantity);
						if (!empty($properties)) { //更新商品属性库存
							D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setDec('quantity', $quantity);
						}
						//更新销量
						D('Product')->where(array('product_id' => $tmp_product_id))->setInc('sales', $quantity); //更新销量
						if (!empty($properties)) { //更新商品属性销量
							D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setInc('sales', $quantity);
						}
						//同步批发商品库存、销量
						$wholesale_products = D('Product')->field('product_id')->where(array('wholesale_product_id' => $tmp_product_id))->select();
						if (!empty($wholesale_products)) {
							foreach ($wholesale_products as $wholesale_product) {
								//更新库存
								D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setDec('quantity', $quantity);
								if (!empty($properties)) { //更新商品属性库存
									D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setDec('quantity', $quantity);
								}
								//更新销量
								D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setInc('sales', $quantity); //更新销量
								if (!empty($properties)) { //更新商品属性销量
									D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setInc('sales', $quantity);
								}
							}
						}
					}
				}

				$session_reward_list = array();
				if (isset($_SESSION['reward'][$session_key]['reward_list']) && is_array($_SESSION['reward'][$session_key]['reward_list'])) {
					$session_reward_list = $_SESSION['reward'][$session_key]['reward_list'];
				}

				// 优惠金额统计
				$money = 0;
				foreach ($session_reward_list as $tmp_store_id => $reward_list) {
					if (!is_array($reward_list)) {
						continue;
					}
					foreach ($reward_list as $key => $reward) {
						if ($key === 'product_price_list') {
							continue;
						}

						// 积分
						if ($reward['score'] > 0) {
							M('Store_user_data')->changePoint($tmp_store_id, $uid, $reward['score']);
							//增加积分日志
							$data_point_record = array(
								'uid' => $uid,
								'store_id' => $tmp_store_id,
								'points' => $reward['score'],
								'order_id' =>  $order_id,
								'is_call_to_fans' => 0,
								'type' => '5',						//满减送
								'is_available'=> 1,					//不可用
								'timestamp' => time(),
							);
							M('User_points_record')->add($data_point_record);
						}

						// 送赠品
						if (is_array($reward['present']) && count($reward['present']) > 0) {
							foreach ($reward['present'] as $present) {
								$data_order_product = array();
								$data_order_product['order_id'] = $order_id;
								$data_order_product['product_id'] = $present['product_id'];

								// 是否有属性，有则随机挑选一个属性
								if ($present['has_property']) {
									$sku_arr = M('Product_sku')->getRandSku($present['product_id']);
									$data_order_product['sku_id'] = $sku_arr['sku_id'];
									$data_order_product['sku_data'] = $sku_arr['propertiey'];
								}

								$data_order_product['pro_num'] = 1;
								$data_order_product['pro_price'] = 0;
								$data_order_product['is_present'] = 1;

								$pro_num++;
								if (!in_array($present['product_id'], $product_id_arr)) {
									$pro_count++;
								}

								D('Order_product')->data($data_order_product)->add();
								unset($data_order_product);
							}
						}

						// 送优惠券
						if ($reward['coupon']) {
							$data_user_coupon = array();
							$data_user_coupon['uid'] = $uid;
							$data_user_coupon['store_id'] = $reward['coupon']['store_id'];
							$data_user_coupon['coupon_id'] = $reward['coupon']['id'];
							$data_user_coupon['card_no'] = String::keyGen();
							$data_user_coupon['cname'] = $reward['coupon']['name'];
							$data_user_coupon['face_money'] = $reward['coupon']['face_money'];
							$data_user_coupon['limit_money'] = $reward['coupon']['limit_money'];
							$data_user_coupon['start_time'] = $reward['coupon']['start_time'];
							$data_user_coupon['end_time'] = $reward['coupon']['end_time'];
							$data_user_coupon['is_expire_notice'] = $reward['coupon']['is_expire_notice'];
							$data_user_coupon['is_share'] = $reward['coupon']['is_share'];
							$data_user_coupon['is_all_product'] = $reward['coupon']['is_all_product'];
							$data_user_coupon['is_original_price'] = $reward['coupon']['is_original_price'];
							$data_user_coupon['description'] = $reward['coupon']['description'];
							$data_user_coupon['timestamp'] = time();
							$data_user_coupon['type'] = 2;
							$data_user_coupon['give_order_id'] = $order_id;

							D('User_coupon')->data($data_user_coupon)->add();
						}

						$reward['store_id'] = $tmp_store_id;
						$data = array();
						$data['order_id'] = $order_id;
						$data['uid'] = $uid;
						$data['rid'] = $reward['rid'];
						$data['name'] = $reward['name'];
						$data['content'] = serialize($reward);
						$money += $reward['cash'];
						D('Order_reward')->data($data)->add();
					}
				}

				// 优惠券处理
				if ($coupon_id) {
					$session_user_coupon_list = array();
					if (isset($_SESSION['reward'][$session_key]['user_coupon_list']) && is_array($_SESSION['reward'][$session_key]['user_coupon_list'])) {
						$session_user_coupon_list = $_SESSION['reward'][$session_key]['user_coupon_list'];
					}
					foreach ($session_user_coupon_list as $tmp_store_id => $user_coupon_list) {
						if (!is_array($user_coupon_list)) {
							continue;
						}
						foreach ($user_coupon_list as $user_coupon) {
							if ($user_coupon['id'] == $coupon_id) {
								$data = array();
								$data['order_id'] = $order_id;
								$data['uid'] = $uid;
								$data['store_id'] = $tmp_store_id;
								$data['coupon_id'] = $user_coupon['coupon_id'];
								$data['name'] = $user_coupon['cname'];
								$data['user_coupon_id'] = $user_coupon['id'];
								$data['money'] = $user_coupon['face_money'];

								$money += $user_coupon['face_money'];
								D('Order_coupon')->data($data)->add();

								// 将用户优惠券改为已使用
								$data = array();
								$data['is_use'] = 1;
								$data['use_time'] = time();
								$data['use_order_id'] = $order_id;
								D('User_coupon')->where(array('id' => $user_coupon['id']))->data($data)->save();
								break;
							}
						}
					}
				}

				// 折扣、包邮
				if (isset($_SESSION['reward'][$session_key]['discount_list']) && is_array($_SESSION['reward'][$session_key]['discount_list'])) {
					$postage_free_list = $_SESSION['reward'][$session_key]['postage_free_list'];
					$postage_list = $_SESSION['postage'][$session_key]['supplier_postage_nofree_arr'];

					foreach ($_SESSION['reward'][$session_key]['discount_list'] as $tmp_store_id => $discount) {
						if (($discount != 0 && $discount != 10) || !empty($postage_free_list[$tmp_store_id])) {
							$order_discount_data = array();
							$order_discount_data['order_id'] = $order_id;
							$order_discount_data['uid'] = $uid;
							$order_discount_data['store_id'] = $tmp_store_id;
							$order_discount_data['discount'] = $discount;
							$order_discount_data['is_postage_free'] = $postage_free_list[$tmp_store_id];
							$order_discount_data['postage_money'] = 0;

							if (isset($postage_list[$tmp_store_id])) {
								$order_discount_data['postage_money'] = $postage_list[$tmp_store_id];
							}

							D('Order_discount')->data($order_discount_data)->add();
						}
					}
				}
				
				$points_money_data = array('money' => 0, 'point' => 0);
				if ($point && $point_money) {
					// 积分抵扣现金
					$points_money_data = Points::getPointMoney($uid, $store_id, $order_data['sub_total'] + $order_data['postage'] + $order_data['float_amount'] - $money - $discount_money);
					if ($points_money_data['money'] || $points_money_data['point']) {
						$point_money = $points_money_data['money'];
						
						$data = array();
						$data['dateline'] = $_SERVER['REQUEST_TIME'];
						$data['order_id'] = $order_id;
						$data['store_id'] = $store_id;
						$data['uid'] = $uid;
						$data['money'] = $points_money_data['money'];
						$data['point'] = $points_money_data['point'];
						
						if (D('Order_point')->data($data)->add()) {
							$data = array();
							$data['uid'] = $uid;
							$data['store_id'] = $store_id;
							$data['order_id'] = $order_id;
							$data['points'] = -1 * $points_money_data['point'];
							$data['type'] = 9;
							$data['is_available'] = 1;
							$data['timestamp'] = $_SERVER['REQUEST_TIME'];
							
							if (D('User_points')->data($data)->add()) {
								D('Store_user_data')->where(array('uid' => $uid, 'store_id' => $store_id))->setDec('point', $points_money_data['point']);
							}
						}
					}
				}
				
				// 更改订单金额
				$total = max(0, $order_data['sub_total'] + $order_data['postage'] + $order_data['float_amount'] - $money - $discount_money - $points_money_data['money']);

				$data = array();
				$data['total'] = $total;
				$data['pro_count'] = $pro_count;
				$data['pro_num'] = $pro_num;

				D('Order')->where(array('order_id' => $order_id))->data($data)->save();
				
				if ($pay_type == 'cash') {
					if ($total > 0) {
						D('Store')->where(array('store_id' => $this->store_session['store_id']))->data("`income` = `income` + '" . $total . "', `sales` = `sales` + '" . $total . "', `store_pay_income` = `store_pay_income` + '" . $total . "'")->save();
					}
					
					$store = D('Store')->where(array('store_id' => $this->store_session['store_id']))->find();
					// 支付流水
					unset($data);
					$data = array();
					$data['store_id'] = $this->store_session['store_id'];
					$data['order_id'] = $order_id;
					$data['order_no'] = $order_data['order_no'];
					$data['income'] = $total;
					$data['type'] = 1;
					$data['balance'] = $store['balance'];
					$data['payment_method'] = 'cash';
					$data['trade_no'] = $order_data['trade_no'];
					$data['add_time'] = $time;
					$data['status'] = 1;
					$data['user_order_id'] = $order_id;
					$data['storeOwnPay'] = 1;
					$data['bak'] = '线下现金收款';
					D('Financial_record')->data($data)->add();
				}

				// 删除session数据
				unset($_SESSION['reward']);
				unset($_SESSION['postage_error']);
				unset($_SESSION['postage']);
				$jump_url = '';
				if ($pay_type == 'cash') {
					$jump_url = url('order:all');
				} else {
					if ($this->user_session['type'] == 0) {
						$jump_url = 'user.php?c=cashier&a=index&order_no=' . $order_data['order_no'];
					} else {
						$jump_url = 'merchants.php?m=User&c=cashier&a=payment&type=1&order_no=' . $order_data['order_no'];
					}
				}
				json_return(0, '订单创建成功', $jump_url);

			} else {
				json_return(1000, '订单创建失败');
			}
			exit;
		}

		$this->assign('session_key', uniqid('uniqid', false));
		$this->display();
	}

	private function _order_add() {
		$store = M('Store')->getStore($this->store_session['store_id']);
		$selffetch_list = array();
		// 门店信息
		if ($store['buyer_selffetch']) {
			$store_contact = M('Store_contact')->get($store['store_id']);
			$store_physical = M('Store_physical')->getList($store['store_id']);
			if ($store_contact) {
				$data = array();
				$data['pigcms_id'] = '99999999_store';
				$data['name'] = $store['name'] . '';
				$data['tel'] = ($store_contact['phone1'] ? $store_contact['phone1'] . '-' : '') . $store_contact['phone2'];
				$data['province_txt'] = $store_contact['province_txt'] . '';
				$data['city_txt'] = $store_contact['city_txt'] . '';
				$data['county_txt'] = $store_contact['area_txt'] . '';
				$data['address'] = $store_contact['address'] . '';
				$data['business_hours'] = '';
				$data['logo'] = $store['logo'];
				$data['description'] = '';
				$data['store_id'] = $store['store_id'];
				$data['long'] = $store_contact['long'];
				$data['lat'] = $store_contact['lat'];

				$selffetch_list[] = $data;
			}

			if ($store_physical) {
				foreach ($store_physical as $physical) {
					$data = array();
					$data['pigcms_id'] = $physical['pigcms_id'];
					$data['name'] = $physical['name'] . '';
					$data['tel'] = ($physical['phone1'] ? $physical['phone1'] . '-' : '') . $physical['phone2'];
					$data['province_txt'] = $physical['province_txt'] . '';
					$data['city_txt'] = $physical['city_txt'] . '';
					$data['county_txt'] = $physical['county_txt'] . '';
					$data['address'] = $physical['address'] . '';
					$data['business_hours'] = $physical['business_hours'] . '';
					$data['logo'] = $physical['images_arr'][0];
					$data['description'] = $physical['description'];
					$data['long'] = $physical['long'];
					$data['lat'] = $physical['lat'];

					$selffetch_list[] = $data;
				}
			}
		}

		// 支付方式
		$payMethodList = M('Config')->get_pay_method();
		$pay_list = array();

		if ($payMethodList['weixin']) {
			$payMethodList['weixin']['name'] = '微信安全支付';
			$pay_list[0] = $payMethodList['weixin'];
		}

		if ($payMethodList['tenpay']) {
			$pay_list[2] = $payMethodList['tenpay'];
		}

		if ($payMethodList['yeepay']) {
			$pay_list[3] = $payMethodList['yeepay'];
		} else if ($payMethodList['allinpay']) {
			$pay_list[3] = $payMethodList['allinpay'];
		}

		if ($pay_list[3]) {
			$pay_list[3]['name'] = '银行卡支付';
		}

		if ($store['pay_agent']) {
			$pay_list[] = array('name' => '找人代付', 'type' => 'peerpay');
		}

		if ($store['offline_payment']) {
			$pay_list[] = array('name' => '货到付款', 'type' => 'offline');
		}

		$this->assign('pay_list', $pay_list);
		$this->assign('selffetch_list', $selffetch_list);
		$this->assign('store', $store);
	}

	// 后台手动添加订单满减等信息
	public function order_reward($product = array(), $uid = 0) {
		$product_data_list = $_REQUEST['product_list'] ? $_REQUEST['product_list'] : $product;
		$uid = $_REQUEST['uid'] ? $_REQUEST['uid'] : $uid;
		$store_id = $this->store_session['store_id'];

		$product_list = $this->_order_data($product_data_list, $uid);

		if ($product_list == 1000) {
			json_return(1000, '');
		}

		// 删除之前已经存在数据里的运费
		$session_key = $_POST['session_key'];
		if (isset($_SESSION['reward'][$session_key])) {
			unset($_SESSION['reward'][$session_key]);
		}

		// 抽出可以享受的优惠信息与优惠券
		import('source.class.Order');
		$order_data = new Order($product_list, array('uid' => $uid));
		// 不同供货商的优惠、满减、折扣、包邮等信息
		$order_data = $order_data->all();

		// 将信息存放在session中，方便在生成订单时，直接调用此数据
		$_SESSION['reward'][$session_key] = $order_data;

		$reward_list = array();
		$coupon_list = array();
		if ($order_data['reward_list'][$store_id]) {
			$reward_money = 0;
			foreach ($order_data['reward_list'][$store_id] as $key => $reward) {
				if ($key === 'product_price_list') {
					continue;
				}
				if (isset($reward['content'])) {
					$reward = $reward['content'];
				}
				$reward_money += $reward['cash'];
				$reward_list[] = getRewardStr($reward);
			}
		}

		if ($order_data['user_coupon_list']) {
			$user_coupon_money = 0;
			foreach ($order_data['user_coupon_list'] as $store_id => $user_coupon_list) {
				foreach ($user_coupon_list as $key => $user_coupon_tmp) {
					$checked = '';
					if ($key == '0') {
						$user_coupon_money += $user_coupon_tmp['face_money'];
					}

					$tmp = array();
					$tmp['id'] = $user_coupon_tmp['id'];
					$tmp['money'] = $user_coupon_tmp['face_money'];
					$tmp['cname'] = $user_coupon_tmp['cname'];

					$coupon_list[] = $tmp;
				}
			}
		}

		$discount = isset($order_data['discount_list'][$store_id]) ? $order_data['discount_list'][$store_id] : 10;
		$postage_free = isset($order_data['postage_free_list'][$store_id]) && $order_data['postage_free_list'][$store_id] ? true : false;
		
		// 查看是否有特权折扣
		$product_discount_arr = array();
		foreach ($product_list as $product) {
			$product_discount = M('Product_discount')->getPointDiscount($product, $uid);
			if (!empty($product_discount['discount'])) {
				$product_discount_arr[$product['product_id']] = $product_discount['discount'];
			}
		}

		$return = array();
		$return['reward_list'] = $reward_list;
		$return['reward_money'] = $reward_money;
		$return['coupon_list'] = $coupon_list;
		$return['discount'] = $discount;
		$return['postage_free'] = $postage_free;
		$return['product_discount'] = $product_discount_arr;

		json_return(0, $return);
	}

	// 后台手动添加订单邮费信息
	public function order_postage() {
		$address_id = $_POST['address_id'];
		$province_id = $_POST['province_id'];
		$uid = $_POST['uid'];

		$product_data_list = $_REQUEST['product_list'] ? $_REQUEST['product_list'] : $product;

		$product_list = $this->_order_data($product_data_list, $uid);

		// 删除之前已经存在数据里的运费
		$session_key = $_POST['session_key'];
		unset($_SESSION['postage_error'][$session_key]);
		unset($_SESSION['postage'][$session_key]);

		$user_address = array();
		if (!empty($address_id)) {
			$user_address = D('User_address')->field('`province`')->where(array('address_id' => $address_id, 'uid' => $uid))->find();
			if(empty($user_address)) {
				$_SESSION['postage_error'][$session_key] = true;
				json_return(1007,'该地址不存在');
			}
		} else if (!empty($province_id)) {
			import('area');
			$areaClass = new area();
			$province_txt = $areaClass->get_name($province_id);
			if (empty($province_txt)) {
				$_SESSION['postage_error'][$session_key] = true;
				json_return(1007,'该地址不存在');
			}
			$user_address['province'] = $province_id;
		} else {
			$_SESSION['postage_error'][$session_key] = true;
			json_return(1007,'该地址不存在');
		}

		//计算运费
		$postage_arr = array();
		$hasTplPostage = false;
		$order_products = array();
		$postage_details = array();

		// 有无运费模板
		$has_tpl_postage_arr = array();
		$hast_tpl_postage_arr = array();

		$postage_template_model = M('Postage_template');
		foreach ($product_list as $key => $product) {
			if (!empty($product['wholesale_supplier_id']) && !empty($product['wholesale_product_id'])) {
				$product['supplier_id'] = $product['wholesale_supplier_id'];
			} else {
				$product['supplier_id'] = $product['store_id'];
			}

			if ($product['postage_template_id']) {
				$postage_template = $postage_template_model->get_tpl($product['postage_template_id'], $product['supplier_id']);

				// 没有相应运费模板，直接跳出
				if (empty($postage_template)) {
					continue;
					$_SESSION['postage_error'][$session_key] = true;
					json_return(1009, '');
				}

				$has_tpl = false;
				foreach ($postage_template['area_list'] as $area) {
					$has_tpl = false;
					if (in_array($user_address['province'], explode('&', $area[0]))) {
						if (isset($has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']])) {
							$has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']]['weight'] += $product['pro_num'] * $product['pro_weight'];
						} else {
							$has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']]['weight'] = $product['pro_num'] * $product['pro_weight'];
							$has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']]['area'] = $area;
						}

						$has_tpl = true;
						break;
					}
				}

				// 没有相应运费模板，直接跳出
				if (!$has_tpl) {
					$_SESSION['postage_error'][$session_key] = true;
					json_return(1009, '');
				}
			} else {
				$hast_tpl_postage_arr[$product['supplier_id']] += $product['postage'];
			}
		}

		import('source.class.Order');
		$order_data = new Order($product_list, array('uid' => $uid));
		$order_data->discount();
		$postage_free_list = $order_data->postage_free_list;

		$supplier_postage_arr = array();
		$supplier_postage_nofree_arr = array();
		$postageCount = 0;
		foreach ($has_tpl_postage_arr as $key => $postage_detail) {
			list($supplier_id, $tpl_id) = explode('_', $key);

			$supplier_postage_nofree_arr[$supplier_id] += $postage_detail['area'][2];
			if ($postage_detail['weight'] > $postage_detail['area']['1'] && $postage_detail['area'][3] > 0 && $postage_detail['area'][4] > 0) {
				$supplier_postage_nofree_arr[$supplier_id] += ceil(($postage_detail['weight'] - $postage_detail['area']['1']) / $postage_detail['area'][3]) * $postage_detail['area']['4'];
			}

			if ($postage_free_list[$supplier_id]) {
				continue;
			}

			$supplier_postage_arr[$supplier_id] += $postage_detail['area'][2];
			$postageCount += $postage_detail['area'][2];
			if ($postage_detail['weight'] > $postage_detail['area']['1'] && $postage_detail['area'][3] > 0 && $postage_detail['area'][4] > 0) {
				$supplier_postage_arr[$supplier_id] += ceil(($postage_detail['weight'] - $postage_detail['area']['1']) / $postage_detail['area'][3]) * $postage_detail['area']['4'];
				$postageCount += ceil(($postage_detail['weight'] - $postage_detail['area']['1']) / $postage_detail['area'][3]) * $postage_detail['area']['4'];
			}
		}

		foreach ($hast_tpl_postage_arr as $key => $postage) {
			$supplier_postage_nofree_arr[$key] += $postage;
			if ($postage_free_list[$key]) {
				continue;
			}
			$supplier_postage_arr[$key] += $postage;
			$postageCount += $postage;
		}

		// 将信息存放在session中，方便在生成订单时，直接调用此数据
		$data = array();
		$data['postage'] = sprintf("%.2f", $postageCount);
		$data['supplier_postage_nofree_arr'] = $supplier_postage_nofree_arr;
		$_SESSION['postage'][$session_key] = $data;
		$_SESSION['postage_error'][$session_key] = false;

		json_return(0, $postageCount, serialize($supplier_postage_nofree_arr));
	}

	// 后台订单添加对产品进行处理
	private function _order_data($product_data_list, $uid) {
		if (empty($product_data_list) && empty($uid) && !is_array($product_data_list)) {
			return 1000;
		}

		$user = D('User')->where(array('uid' => $uid))->find();
		if (empty($user)) {
			return 1000;
		}

		$store_id = $this->store_session['store_id'];
		$product_list = array();
		foreach ($product_data_list as $tmp) {
			list($product_id, $sku_id, $number, $price) = explode('_', $tmp);

			if (empty($product_id) && empty($number)) {
				continue;
			}

			$product = D('Product')->where(array('product_id' => $product_id, 'store_id' => $store_id))->find();
			if (empty($product)) {
				continue;
			}

			// 有属性，但是库存ID不存在，直接跳过
			if ($product['has_property'] && empty($sku_id)) {
				continue;
			}

			if (!empty($sku_id)) {
				$product_sku = D('Product_sku')->where(array('sku_id' => $sku_id, 'product_id' => $product_id))->find();
				if (empty($product_sku)) {
					continue;
				}

				$product['pro_price'] = $price;//$product_sku['price'];
				if (!empty($product_sku['weight'])) {
					$product['pro_weight'] = $product_sku['weight'];
				}
			} else {
				$product['pro_price'] = $price;// $product['price'];
				$product['pro_weight'] = $product['weight'];
			}
			$product['pro_num'] = $number;
			$product['wholesale_supplier_id'] = $store_id;

			unset($product['intro']);
			unset($product['info']);

			$product_list[] = $product;
		}

		if (empty($product_list)) {
			return 1000;
		}

		return $product_list;
	}

	// 后台手动修改包裹 快递公司/快递单号 ajax弹层
	public function ajax_package_info() {
		$store_id = $this->store_session['store_id'];
		$package_id = isset($_POST['package_id']) ? intval($_POST['package_id']) : 0;

		$orderPackage = D('Order_package')->where(array('package_id'=>$package_id, 'store_id'=>$store_id))->find();
		if (empty($orderPackage)) {
			json_return(1001, '缺少参数，或者无权限修改此包裹！');
		}

		$order = D('Order')->where(array('order_id'=>$orderPackage['order_id'], 'store_id'=>$store_id))->find();
		switch ($order['status']) {
			case 4:
				json_return(1003, '订单已经完成');
				break;
			case 5:
				json_return(1004, '订单已经取消');
				break;
		}

		if ($orderPackage['physical_id'] > 0) {
			json_return(1001, '这是门店配送包裹，无法修改！');
		}

		//快递公司
		$data['express'] = M('Express')->getExpress();
		$data['order_package'] = $orderPackage;
		echo json_encode($data);
		exit;
	}

	// 后台手动修改包裹 快递公司/快递单号
	public function ajax_package_edit() {

		$store_id = $this->store_session['store_id'];
		$package_id = isset($_POST['package_id']) ? intval($_POST['package_id']) : 0;
		$express_no = isset($_POST['express_no']) ? trim($_POST['express_no']) : '';
		$express_code = isset($_POST['express_code']) ? trim($_POST['express_code']) : '';
		$express_company = isset($_POST['express_name']) ? trim($_POST['express_name']) : '';

		if (empty($package_id) || empty($express_no) || empty($express_code)) {
			json_return(1001, '参数不能为空');
		}


		$orderPackage = D('Order_package')->where(array('package_id'=>$package_id, 'store_id'=>$store_id))->find();
		if (empty($orderPackage)) {
			json_return(1002, '缺少参数，无权限修改此包裹！');
		}

		$order = D('Order')->where(array('order_id'=>$orderPackage['order_id'], 'store_id'=>$store_id))->find();
		switch ($order['status']) {
			case 4:
				json_return(1003, '订单已经完成');
				break;
			case 5:
				json_return(1004, '订单已经取消');
				break;
		}

		$result = D('Order_package')->
					where(array('store_id'=>$store_id, 'package_id'=>$package_id))->
					data(array('express_no'=>$express_no, 'express_code'=>$express_code, 'express_company'=>$express_company))->save();

		if ($result) {
			json_return(0, '修改成功！');
		} else {
			json_return(1005, '修改失败，请稍后再试');
		}
	}

	
	public function return_save_debug() {
		$id = 3;
		$store_id = $_SESSION['store']['store_id'];
	
		$return = M('Return')->getById($id);
		if (empty($return)) {
			json_return(1001, '未找到相应的退货申请');
		}
		// 查找订单
		$order = D('Order')->where("(order_id = '" . $return['order_id'] . "' or user_order_id = '" . $return['order_id'] . "') and store_id = '" . $store_id . "'")->find();
	
		if (empty($order)) {
			json_return(1001, '未查到相应的订单');
		}
	
		$return_list = M('Return')->getProfit($return);
		foreach ($return_list as $tmp) {
			$order = D('Order')->where("order_id = '" . $tmp['order_id'] . "'")->find();
		
			$financial_record_data = array();
			$financial_record_data['store_id'] = $tmp['store_id'];
			$financial_record_data['order_id'] = $order['order_id'];
			$financial_record_data['order_no'] = $order['order_no'];
			$financial_record_data['income'] = -1 * $tmp['profit'];
		
			if ($tmp['drp_level'] == '0') {
				// 查看此退货商品折扣金额
				$product = D('Return_product')->where("return_id = '" . ($tmp['user_return_id'] > 0 ? $tmp['user_return_id'] : $tmp['return_id']) . "'")->find();
				$discount_money = $product['pro_num'] * $product['pro_price'] - $product_money;
				$financial_record_data['income'] = -1 * $tmp['profit'] - $tmp['postage_money'] + $discount_money;
			}
		
			$financial_record_data['type'] = 3;
			$financial_record_data['trade_no'] = date('YmdHis') . rand(100000, 999999);
			$financial_record_data['add_time'] = time();
			$financial_record_data['status'] = 2;
			$financial_record_data['user_order_id'] = $order['user_order_id'];
			$financial_record_data['bak'] = '退货';
			$financial_record_data['return_id'] = $tmp['id'];
			print_r($financial_record_data);
			//D('Financial_record')->data($financial_record_data)->add();
		}
	}
}

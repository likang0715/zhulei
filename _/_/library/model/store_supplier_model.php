<?php
/**
 * 店铺模型
 * User: pigcms_21
 * Date: 2015/2/2
 * Time: 22:00
 */
    class store_supplier_model extends base_model
    {
        public function add($data)
        {
            return $this->db->data($data)->add();
        }

        public function suppliers($where, $offset = 0, $limit = 0)
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store" .  ' WHERE 1=1';
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }
            if ($limit) {
                $sql .= ' LIMIT ' . $offset . ',' . $limit;
            }

            $suppliers = $this->db->query($sql);
            foreach ($suppliers as &$tmp) {
                $tmp['logo'] = getAttachmentUrl($tmp['logo']);
            }
            return $suppliers;
        }

        public function supplier_count($where)
        {
            $sql = "SELECT count(store_id) as storeId FROM " . option('system.DB_PREFIX') . "store" .  ' WHERE 1=1';

            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }

            $suppliers = $this->db->query($sql);

            return !empty($suppliers[0]['storeId']) ? $suppliers[0]['storeId'] : 0;
        }

        /*public function sellers($where, $offset = 0, $limit = 0, $supplier_id = 0)
        {
            //$sql = "SELECT *,s.status,s.drp_profit as profit,s.name FROM " . option('system.DB_PREFIX') . "store as s left join " . option('system.DB_PREFIX') . "store_supplier as ss on s.store_id = ss.seller_id  WHERE  and drp_level > 0 and FIND_IN_SET($supplier_id,supply_chain) ";
            $sql = "select * from pigcms_store s left join pigcms_drp_degree dd on s.drp_degree_id = dd.pigcms_id where s.root_supplier_id = {$supplier_id} AND s.drp_level > 0 ";

            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        }
                    }else if($key == '_string'){
                        $sql .= "AND " . $value;
                    }else if($key != '_string'){
                        $sql .= " AND " . $key . "=" . "'".$value."'";
                    }
                }
            }

            $sql .= ' ORDER BY s.date_added DESC';
            if ($limit) {
                $sql .= ' LIMIT ' . $offset . ',' . $limit;
            }

            $sellers = $this->db->query($sql);
            foreach ($sellers as &$tmp) {
                $tmp['logo'] = getAttachmentUrl($tmp['logo']);
            }
            return $sellers;
        }*/

        public function sellers($where, $offset = 0, $limit = 0)
        {
            //$sql = "SELECT *,s.status,s.drp_profit as profit FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id and drp_level > 0';
            $sql = "select s.*,team.name as team_name, s.store_id as fx_store_id, s.logo as store_logo, s.name as store_name,s.sales as store_sales, s.status as store_status from " . option('system.DB_PREFIX') . "store as s left join " . option('system.DB_PREFIX') . "store_supplier as ss on s.store_id = ss.seller_id left join " . option('system.DB_PREFIX') . "drp_degree dd on s.drp_degree_id = dd.pigcms_id left join " . option('system.DB_PREFIX') . "drp_team as team on s.drp_team_id=team.pigcms_id where s.drp_level > 0 ";
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        } else if( array_key_exists('find_in_set',$value)) {
								$sql .=  " AND find_in_set (".$value['find_in_set'].",".$key.")";
							}
                    }else if($key == '_string'){
                        $sql .= "AND " . $value;
                    }else if($key != '_string'){
                        $sql .= " AND " . $key . "=" . "'".$value."'";
                    }
                }
            }

            $sql .= ' ORDER BY s.status ASC,s.drp_approve ASC,s.store_id DESC';
            if ($limit) {
                $sql .= ' LIMIT ' . $offset . ',' . $limit;
            }
            $sellers = $this->db->query($sql);
            foreach ($sellers as &$tmp) {
                $tmp['logo'] = getAttachmentUrl($tmp['logo']);
            }
            return $sellers;
        }

        public function seller_count($where)
        {
            $sql = "SELECT count(s.drp_profit) AS sellers FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id  and drp_level > 0';
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        } else if( array_key_exists('find_in_set',$value)) {
								$sql .=  " AND find_in_set (".$value['find_in_set'].",".$key.")";
						}
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }

            $sellers = $this->db->query($sql);
            return !empty($sellers[0]['sellers']) ? $sellers[0]['sellers'] : 0;
        }

        /*public function seller_count($where,$supplier_id = 0)
        {
            $sql = "SELECT count(s.drp_profit) AS sellers FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss,".option('system.DB_PREFIX')."platform_drp_degree as pp WHERE s.store_id = ss.seller_id and s.drp_degree_id = pp.pigcms_id and drp_level > 0 and FIND_IN_SET($supplier_id,supply_chain) ";
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        }
                    }else if($key == '_string'){
                        $sql .= "AND " . $value;
                    }else if($key != '_string'){
                        $sql .= " AND " . $key . "=" . "'".$value."'";
                    }
                }
            }

            $sellers = $this->db->query($sql);
            return !empty($sellers[0]['sellers']) ? $sellers[0]['sellers'] : 0;
        }*/

        //获取符合条件的单个分销商
        public function getSeller($where)
        {
            $seller = $this->db->where($where)->find();

            return $seller;
        }
        //获取符合条件的多个分销商
        public function getSellers($where, $offset = 0, $limit = 0)
        {
            if (!empty($limit)) {
                $sellers = $this->db->where($where)->limit($offset . ',' . $limit)->select();
            } else {
                $sellers = $this->db->where($where)->select();
            }
            return $sellers;
        }

        public function getSellerCount($where)
        {
            $sellers = $this->db->where($where)->count('pigcms_id');
            return $sellers;
        }

        //获取符合条件的下级分销商
        public function getNextSellers($supplierId, $level)
        {
        	$where = "";
        	if($level != 'all') {
        		//全部 下级
        		$where = " AND level=".$level;
        	}
 
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplierId,supply_chain) ".$where;

            $sellers = $this->db->query($sql);

            return $sellers;
        }

        //获取下级分销商数量
        public function getSubSellers($supplier_id)
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplier_id, supply_chain)";
            $sellers = $this->db->query($sql);
            return !empty($sellers) ? $sellers : array();
        }

        //获取符合条件的上级分销商
        public function getPrevSellers($supplierId,$currentlevel, $level)
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplierId,supply_chain) AND level<$level";

            if($currentlevel==1)
            {
                $sql .= " AND " . level . "!=" . $currentlevel;
            }
            $sellers = $this->db->query($sql);

            return $sellers;
        }

        //获取符合条件的下级分销商数量
        public function getNextAllSellers($supplierId, $level)
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplierId,supply_chain) AND level>=$level";

            $sellers = $this->db->query($sql);

            return $sellers;
        }

        //获取当前用户下所有分销商id
        public function getAllSellerId($supplierId)
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplierId,supply_chain)";

            $sellers = $this->db->query($sql);

            return $sellers;
        }

        //获取当前用户下级所有分销商id
        public function getNextAllSellerId($supplierId,$level)
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplierId,supply_chain) and level >= $level";

            $sellers = $this->db->query($sql);

            return $sellers;
        }

        //获取符合条件的下两级分销商
        public function getNextTwoSellers($supplierId, $level, $level1)
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplierId,supply_chain) AND (level=$level or level =$level1 )";

            $sellers = $this->db->query($sql);

            return $sellers;
        }

        //获取下两级分销商数量
        public function getNextTwoCount($supplierId, $level, $level1)
        {
            $sql = "SELECT count(*) as num FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplierId,supply_chain) AND (level=$level or level =$level1 )";

            list($sellers) = $this->db->query($sql);

            return !empty($sellers['num']) ? $sellers['num'] : '0';
        }

        //今日新增分销商数量
        public function getNewSellers($where, $dayBegin, $dayEnd)
        {
            $sql = "SELECT COUNT(store_id) as storeId FROM " . option('system.DB_PREFIX') . "store WHERE  "."date_added > $dayBegin and date_added < $dayEnd";
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }
            list($sellers) = $this->db->query($sql);
            return !empty($sellers['storeId']) ? $sellers['storeId'] : 0;
        }

        //截至今日分销商数量
        public function getAllSellers($where,$dayEnd)
        {
            $sql = "SELECT COUNT(store_id) as storeId FROM " . option('system.DB_PREFIX') . "store WHERE "." date_added < $dayEnd" ;
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }

            list($sellers) = $this->db->query($sql);

            return !empty($sellers['storeId']) ? $sellers['storeId'] : 0;

        }

        //截至今日上级分销商数量
        public function getPrevAllSellers($where,$level)
        {
            $sql = "SELECT COUNT(pigcms_id) as storeId FROM " . option('system.DB_PREFIX') . "store_supplier WHERE "." level<=$level";
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }

            list($sellers) = $this->db->query($sql);

            return !empty($sellers['storeId']) ? $sellers['storeId'] : 0;

        }

        //截至今日下级分销商数量
        public function getNextSeller($where,$level)
        {
            $sql = "SELECT COUNT(pigcms_id) as storeId FROM " . option('system.DB_PREFIX') . "store_supplier WHERE "."level>=$level";
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }

            list($sellers) = $this->db->query($sql);

            return !empty($sellers['storeId']) ? $sellers['storeId'] : 0;

        }


        public function getSupplierList($sellerId)
        {
            $sql = "select distinct supplier_id from " .option('system.DB_PREFIX'). "store_supplier where seller_id = $sellerId";
            $supplierIdList = $this->db->query($sql);

            return $supplierIdList;
        }

        /* 获取当前供货商下的所有经销商id */
        public function getAgencyList($supplierId)
        {
            $sql = "SELECT distinct seller_id FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id and drp_level = 0 and supplier_id =' .$supplierId;
           // $sql = "select  from " .option('system.DB_PREFIX'). "store_supplier where supplier_id = $supplierId";
            $supplierIdList = $this->db->query($sql);
//echo $sql;
            return $supplierIdList;
        }

        /* 获取当前供货商、经销商下的所有分销商id */
        public function getSellerList($sellerId)
        {
            $sql = "SELECT seller_id FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($sellerId,supply_chain)";
            $sellerIdList = $this->db->query($sql);

            return $sellerIdList;
        }
        
        
        //粉丝分享创建店铺分销店铺
        public function create_fans_supplier_store($uid,$store_id){
        	if ($uid&&($_SESSION['wap_user']['uid']!=$uid)) {
        	
        		$store_supplier = M('Store_supplier');
        		$getAllSellerList = $store_supplier->getAllSellerId($store_id);
        	
        		$new_seller_arr = array();
        		foreach ($getAllSellerList as $v) {
        			$new_seller_arr[] = $v['seller_id'];
        		}
        	
        		$seller_store = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' =>$uid, 'status' => 1))->find();
        		$_condition['store_id'] = array('in', $new_seller_arr);
        		$store_list = D('Store')->where($_condition)->select();
        	
        	
        		$user_list = array();
        		foreach ($store_list as $v) {
        			$user_list[] = $v['uid'];
        		}
        	
        		if (!in_array($uid, $user_list)) {
        			$uid = $uid;
        			$common_data = M('Common_data');
        			$sale_category = M('Sale_category');
        	
        			$user = D('User')->field('uid,nickname,avatar')->where(array('uid' =>$uid))->find();
        			$store = D('Store')->field('store_id,name,open_drp_approve,sale_category_id,sale_category_fid,open_nav,drp_level,open_drp_subscribe_auto,drp_subscribe_tpl,open_drp_subscribe,reg_drp_subscribe_tpl,reg_drp_subscribe_img,drp_subscribe_img')->where(array('store_id' => $store_id))->find();
        			$supplier_id = $store_id;
        			$name = !empty($user['nickname']) ? $user['nickname'] : $store['name'] . '分店';
        			$linkname = $user['nickname'];
        			$avatar = $user['avatar'];
        			$drp_level = ($store['drp_level'] + 1); //分销级别
        	
        			$data = array();
        			$data['uid'] = $uid;
        			$data['name'] = $name;
        			$data['sale_category_id'] = $store['sale_category_id'];
        			$data['sale_category_fid'] = $store['sale_category_fid'];
        			$data['linkman'] = $linkname;
        			$data['tel'] = '';
        			$data['status'] = 1;
        			$data['qq'] = '';
        			$data['drp_supplier_id'] = $supplier_id;
        			$data['date_added'] = time();
        			$data['drp_level'] = $drp_level;
        			$data['logo'] = $avatar;
        			$data['open_nav'] = $store['open_nav'];
        			$data['bind_weixin'] = 0;
        			$data['open_drp_diy_store'] = 0;
        			$data['drp_diy_store'] = 0;
        			if (!empty($store['open_drp_approve'])) {
        				$data['drp_approve'] = 0; //需要审核
        			}
        	
        			$store['drp_subscribe_img'] = !empty($store['drp_subscribe_img']) ? $store['drp_subscribe_img'] : getAttachmentUrl('images/drp_ad_01.png');
        	
        			$result = M('Store')->create($data);
        			if (!empty($result['err_code'])) { //店铺添加成功
        				$common_data->setStoreQty();
        	
        				$store_id2 = $result['err_msg']['store_id']; //分销商id
        				//用户店铺数加1
        				M('User')->setStoreInc($uid);
        				//设置为卖家
        				M('User')->setSeller($uid, 1);
        	
        				//主营类目店铺数加1
        				$sale_category->setStoreInc($store['sale_category_id']);
        				$sale_category->setStoreInc($store['sale_category_fid']);
        	
        				$current_seller = $store_supplier->getSeller(array('seller_id' => $store_id2));
        				if ($current_seller['supplier_id'] != $supplier_id) {
        					$seller = $store_supplier->getSeller(array('seller_id' => $supplier_id)); //获取上级分销商信息
        					if (empty($seller['type'])) { //全网分销的分销商
        						$seller['supply_chain'] = 0;
        						$seller['level'] = 0;
        					}
        					$seller['supply_chain'] = !empty($seller['supply_chain']) ? $seller['supply_chain'] : 0;
        					$seller['level'] = !empty($seller['level']) ? $seller['level'] : 0;
        					$supply_chain = !empty($supplier_id) ? $seller['supply_chain'] . ',' . $supplier_id : 0;
        					$level = $seller['level'] + 1;
        					$store_supplier->add(array('supplier_id' => $supplier_id, 'seller_id' => $store_id2, 'supply_chain' => $supply_chain, 'level' => $level, 'type' => 1)); //添加分销关联关系
        				}
        	
        				$common_data->setDrpSellerQty();
        	
        				$return = array();
        				$store['drp_subscribe_tpl'] = !empty($store['drp_subscribe_tpl']) ? $store['drp_subscribe_tpl'] : '尊敬的 {$nickname}, 您已成为 {$store} 第 {$num} 位分销商，点击管理店铺。';
        	
        				if (stripos($store['drp_subscribe_tpl'], '{$num}') !== false) {
        					$sellers = $store_supplier->getSubSellers($supplier_id);
        					$seller_num = count($sellers);
        					$content = str_replace(array('{$nickname}', '{$store}', '{$num}'), array($user['nickname'], $store['name'], $seller_num), $store['drp_subscribe_tpl']);
        				} else if (preg_match('/\{\$num=(\d+)\}/i', $store['drp_subscribe_tpl'])) {
        					$sellers = $store_supplier->getSubSellers($supplier_id);
        					global $global_seller_num;
        					$global_seller_num = count($sellers);
        					$content = str_replace(array('{$nickname}', '{$store}'), array($user['nickname'], $store['name']), $store['drp_subscribe_tpl']);
        					$content = preg_replace_callback('/\{\$num=(\d+)\}/i', function($num) {
        						global $global_seller_num;
        						$num[1] = !empty($num[1]) ? $num[1] : 0;
        						return $num[1] + $global_seller_num;
        					}, $content);
        				}
        				//$return[] = array($content, '', $store['drp_subscribe_img'], option('config.wap_site_url') . '/home.php?id=' . $store_id);
        				//dump($return);
        				//return array($return, 'news');
        			}
        		}
        	}
        }

        /*****2016 1 13*****/

        /*function getNSellers($where, $page->firstRow, $page->listRows){

            $sql = "SELECT *,s.status,s.drp_profit as profit FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id and drp_level > 0';
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }

            $sql .= ' ORDER BY s.date_added DESC';
            if ($limit) {
                $sql .= ' LIMIT ' . $offset . ',' . $limit;
            }
            $sellers = $this->db->query($sql);
            foreach ($sellers as &$tmp) {
                $tmp['logo'] = getAttachmentUrl($tmp['logo']);
            }
            return $sellers;

        }*/
        

        //获取一级分销商
        public function getFirstSeller($seller_id)
        {
            $supply_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $seller_id, 'type' => 1))->find();
            if (!empty($supply_chain['supply_chain'])) {
                $chain = explode(',', $supply_chain['supply_chain']);
                $first_seller_id = !empty($chain[2]) ? $chain[2] : $seller_id;
            } else {
                $first_seller_id = $seller_id;
            }

            return $first_seller_id;
        }

        //获取供货商id(顶级供货商)
        public function getSupplierId($seller_id) {

            $supplier = D('Store_supplier')->where(array('seller_id' => $seller_id, 'type' => 1))->find();
            if (!empty($supplier)) {
                if (!empty($supplier['root_supplier_id'])) {
                    $supplier_id = $supplier['root_supplier_id'];
                } else if (!empty($supplier['supply_chain'])) {
                    $supply_chain = explode(',', $supplier['supply_chain']);
                    $supplier_id = $supply_chain[1];
                } else {
                    $supplier_id = $seller_id;
                }
            } else {
                $supplier_id = $seller_id;
            }
            return $supplier_id;
        }

        //获取下级分销商数量
        public function getSellersList($supplier_id)
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store_supplier as su,".option('system.DB_PREFIX')."store as s WHERE s.store_id = su.supplier_id and FIND_IN_SET($supplier_id, supply_chain) order by s.sales desc";
            $sellers = $this->db->query($sql);
            return !empty($sellers) ? $sellers : array();
        }
    }
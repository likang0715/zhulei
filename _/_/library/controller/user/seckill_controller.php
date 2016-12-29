<?php
/**
 * 秒杀功能
 */
class seckill_controller extends base_controller {
    // 加载
    public function load() {
        $action = strtolower(trim($_POST['page']));
        if (empty($action)) pigcms_tips('非法访问！', 'none');

        switch ($action) {
            case 'seckill_list' :
                $this->_seckill_list();
                break;
            case 'edit' :
                $this->_edit();
                break;
            case 'info' :
                $this->_info();
                break;
            case 'order' :
                $this->_order();
            default:
                break;
        }

        $this->display($_POST['page']);
    }

    public function seckill_index() {
        $this->display();
    }

    public function add() {
        $name = $_POST['name'];
        $product_id = $_POST['product_id'];
        $sku_id = !empty($_POST['sku_id']) ? $_POST['sku_id'] : 0;
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $seckill_price = $_POST['seckill_price'];
        $description = $_POST['description'];
        $reduce_point = $_POST['reduce_point'];
        $is_subscribe = $_POST['is_subscribe'];
        $preset_time = $_POST['preset_time'];

        if (empty($name)) {
            json_return(1000, '活动名称不能为空');
        }

        if (empty($product_id)) {
            json_return(1000, '请选择秒杀的产品');
        }

        if (empty($start_time)) {
            json_return(1000, '秒杀开始时间不能为空');
        }

        if (empty($end_time)) {
            json_return(1000, '秒杀结束时间不能为空');
        }


        $product = D('Product')->where(array('product_id' => $product_id, 'store_id' => $this->store_session['store_id'], 'status' => array('!=', 2)))->find();
        if (empty($product)) {
            json_return(1000, '未找要秒杀的产品');
        }

        $data = array();
        $data['name'] = $name;
        $data['store_id'] = $this->store_session['store_id'];
        $data['product_id'] = $product_id;
        $data['sku_id'] = $sku_id;
        $data['seckill_price'] = !empty($seckill_price) ? $seckill_price : $product['price'];
        $data['start_time'] = strtotime($start_time);
        $data['end_time'] = strtotime($end_time);
        $data['description'] = $description;
        $data['reduce_point'] = $reduce_point;
        $data['is_subscribe'] = $is_subscribe;
        $data['add_time'] = time();
        $data['update_time'] = time();
        $data['is_subscribe'] = $is_subscribe;
        $data['preset_time'] = $preset_time;


        $seckill = D('Seckill')->data($data)->add();

        if (!$seckill) {
            json_return(1000, '添加失败，请重试');
        }else{
            json_return(0, url('seckill:seckill_index'));
        }
    }

    private function _seckill_list() {
        $type = $_REQUEST['type'];
        $keyword = $_REQUEST['keyword'];

        $type_arr = array('future', 'on', 'end', 'all');
        if (!in_array($type, $type_arr)) {
            $type = 'all';
        }

        $where = array();
        $where['store_id'] = $_SESSION['store']['store_id'];
        $where['delete_flag'] = 0;
        $order_by_field = 'pigcms_id desc';

        if (!empty($keyword)) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }

        $time = time();
        if ($type == 'future') {
            $where['start_time'] = array('>', $time);
        } else if ($type == 'on') {
            $where['start_time'] = array('<', $time);
            $where['end_time'] = array('>', $time);
        } else if ($type == 'end') {
            $where = "`store_id` = '" . $_SESSION['store']['store_id'] . "' AND (`end_time` < '" . $time . "' OR `status` = '2')";
        }

        $seckill_model = M('Seckill');
        $count = $seckill_model->getCount($where);

        import('source.class.user_page');
        $page = new Page($count, 10);

        $seckills = $seckill_model->getList($where, $order_by_field, $page->listRows, $page->firstRow);

        $seckill_list = array();
        foreach($seckills as $seckill){

            /* 查询商品 */
            $productInfo = D('Product')->field('name,image,product_id')->where(array('product_id'=>$seckill['product_id']))->find();

            $seckill_list[] = array(
                'product_name' => $productInfo['name'],
                'product_url' => $productInfo['url'],
                'product_image' => getAttachmentUrl($productInfo['image'],false),
                'product_id' => $productInfo['product_id'],
                'seckill_name' => $seckill['name'],
                'start_time' => $seckill['start_time'],
                'end_time' => $seckill['end_time'],
                'sales_volume' => $seckill['sales_volume'],
                'is_subscribe' => $seckill['is_subscribe'],
                'status' => $seckill['status'],
                'pigcms_id' => $seckill['pigcms_id'],
            );
        }

        $this->assign('keyword', $keyword);
        $this->assign('type', $type);
        $this->assign('page', $page->show());
        $this->assign('seckill_list', $seckill_list);
    }

    public function edit() {

        $seckill_id = intval($_POST['pigcms_id']);
        $name = $_POST['name'];
        $product_id = $_POST['product_id'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $seckill_price = $_POST['seckill_price'];
        $description = $_POST['description'];
        $reduce_point = $_POST['reduce_point'];
        $is_subscribe = $_POST['is_subscribe'];
        $preset_time = $_POST['preset_time'];

        if (empty($name)) {
            json_return(1000, '秒杀名称不能为空');
        }

        if (empty($product_id)) {
            json_return(1000, '请选择参与秒杀的产品');
        }

        if (empty($start_time)) {
            json_return(1000, '秒杀开始时间不能为空');
        }

        if (empty($end_time)) {
            json_return(1000, '秒杀结束时间不能为空');
        }

        if (empty($seckill_id)) {
            json_return(1000, '缺少最基本的参数ID');
        }

        $seckill = D('Seckill')->where(array('pigcms_id' => $seckill_id, 'store_id' => $this->store_session['store_id'], 'delete_flag' => 0))->find();

        if (empty($seckill)) {
            json_return(1000, '未找到要修改的秒杀');
        }

        if ($seckill['start_time'] < time()) {
            json_return(1000, '此秒杀活动已开始，不能修改');
        }

        $product = D('Product')->where(array('product_id' => $product_id, 'store_id' => $this->store_session['store_id'], 'status' => array('!=', 2)))->find();
        if (empty($product)) {
            json_return(1000, '未找要参加秒杀的产品');
        }

        $data = array();
        $data['name'] = $name;
        $data['store_id'] = $this->store_session['store_id'];
        $data['product_id'] = $product_id;
        $data['start_time'] = strtotime($start_time);
        $data['end_time'] = strtotime($end_time);
        $data['description'] = $description;
        $data['seckill_price'] = $seckill_price;
        $data['reduce_point'] = $reduce_point;
        $data['is_subscribe'] = $is_subscribe;
        $data['preset_time'] = $preset_time;

        D('Seckill')->where(array('pigcms_id' => $seckill_id))->data($data)->save();

        json_return(0, url('seckill:seckill_index'));
    }

    // 使失效
    public function disabled() {
        $seckill_id = intval($_GET['seckill_id']);

        if (empty($seckill_id)) {
            json_return(1001, '缺少最基本的参数ID');
        }

        $seckill = D('Seckill')->where(array('pigcms_id' => $seckill_id, 'store_id' => $this->store_session['store_id']))->find();
        if (empty($seckill)) {
            json_return(1001, '未找到相应的秒杀活动');
        }

        if ($seckill['status'] == 2) {
            json_return(1000, '此活动已失效，无须再次操作');
        }

        if ($seckill['end_time'] < time()) {
            json_return(1000, '此活动已经结束，不能进行失效操作');
        }

        $data = array();
        $data['status'] = 2;
        $result = D('Seckill')->where(array('pigcms_id' => $seckill_id))->data(array('status' => 2, 'update_time' => time()))->save();

        if ($result) {
           /* set_time_limit(0);
            // 已产生的订单进入退货流程
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['type'] = 7; //秒杀订单
            $where['status'] = array('in', array(2, 3, 7));
            $order_list = D('Order')->where($where)->field('order_id, order_no, uid, store_id, pro_num, address_tel')->select();

            import('source.class.ReturnOrder');
            ReturnOrder::batchReturn($order_list);*/
            json_return(0, '操作完成');
        } else {
            json_return(1000, '操作失败');
        }
    }

    // 删除
    public function delete() {
        $seckill_id = intval($_GET['seckill_id']);

        if (empty($seckill_id)) {
            json_return(1001, '缺少最基本的参数ID');
        }

        $seckill = D('Seckill')->where(array('pigcms_id' => $seckill_id, 'store_id' => $this->store_session['store_id'], 'delete_flag' => 0))->find();
        if (empty($seckill)) {
            json_return(1001, '未找到相应的团购活动');
        }

        if ($seckill['start_time'] < time()) {
            json_return(1000, '活动已开始，不能进行删除操作');
        }

        D('Seckill')->where(array('pigcms_id' => $seckill_id))->data(array('delete_flag' => 1))->save();
        json_return(0, '删除完成');
    }

    // 团购结束
    public function over() {
        $seckill_id = intval($_POST['tuan_id']);
        $type = $_POST['type'];
        $tuan_config = array();

        if ($type != 'cancel') {
            if (empty($tuan_id) || empty($tuan_config_id)) {
                json_return(1000, '缺少最基本的参数');
            }
        } else if (empty($tuan_id)) {
            json_return(1000, '缺少最基本的参数');
        }

        // 查找相应团购
        $seckill = D('Tuan')->where(array('pigcms_id' => $seckill_id, 'store_id' => $this->store_session['store_id']))->find();
        if (empty($seckill)) {
            json_return(1000, '未找到相应的团购活动');
        }


        // 查找达标团购项
        if ($type != 'cancel') {
            $tuan_config_list = D('Tuan_config')->where(array('tuan_id' => $tuan_id))->order('discount DESC')->select();
            if (empty($tuan_config_list)) {
                json_return(1000, '未找到相应的团购项');
            }

            $is_has = false;
            foreach ($tuan_config_list as $tmp) {
                if ($tmp['id'] == $tuan_config_id) {
                    $tuan_config = $tmp;
                    $is_has = true;
                    break;
                }
            }

            if (!$is_has) {
                json_return(1000, '未找到相应的团购项');
            }

            // 查出人缘开团购买数量
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['type'] = 6;
            $where['data_id'] = $tuan_id;
            $where['data_type'] = 0;
            $where['status'] = array('in', array(2, 3, 4, 7));
            $count_ry = D('Order')->where($where)->sum('pro_num');

            $where['data_type'] = 1;
            $count_list_tmp = D('Order')->where($where)->field('data_item_id, sum(pro_num) AS count')->group('data_item_id')->select();
            $count_list = array();
            $count += $count_ry;
            foreach ($count_list_tmp as $tmp) {
                $count += $tmp['count'];
                $count_list[$tmp['data_item_id']] = $tmp['count'];
            }

            // 判断哪一级达标，只能操作最高级别的达标设置
            $level = -1;
            $level_arr = array();
            $tuan_config_id_arr = array();
            $start_count = $count_ry;
            foreach ($tuan_config_list as $key => $tmp) {
                $start_count += $count_list[$tmp['id']];
                $count =  + $tmp['start_number'] + $start_count;
                if ($count > $tmp['number']) {
                    $level_arr[$key] = true;
                } else {
                    $level_arr[$key] = false;
                }
                $tuan_config_id_arr[$key] = $tmp['id'];

                if ($tmp['id'] == $tuan_config_id) {
                    $level = $key;
                }
            }

            foreach ($level_arr as $key => $val) {
                if ($val == true && $key > $level) {
                    json_return(1000, '有更高级别团购项达标');
                }
            }

            // 处理哪些级别退货，哪些级别需要退款
            $return_money_arr = array();
            $return_arr = array();
            foreach ($tuan_config_id_arr as $key => $tmp) {
                if ($level > $key) {
                    $return_money_arr[] = $tmp;
                }

                if ($level < $key) {
                    $return_arr[] = $tmp;
                }
            }

            $result = D('Tuan')->where(array('id' => $tuan_id))->data(array('tuan_config_id' => $tuan_config_id, 'operation_dateline' => $_SERVER['REQUEST_TIME']))->save();
            if (!$result) {
                json_return(1000, '操作失败');
            }

            // 取消限时
            set_time_limit(0);
            // 未支付直接进入取消
            Tuan::cancelOrder($tuan['store_id'], $tuan_id);

            // 退款处理
            if (!empty($return_money_arr)) {
                Tuan::returnMoney($tuan, $tuan_config, $return_money_arr, $level);
            }

            // 未达标高级别最优团，自动进入退货
            if (!empty($return_arr)) {
                $where = array();
                $where['store_id'] = $this->store_session['store_id'];
                $where['type'] = 6;
                $where['data_id'] = $tuan_id;
                $where['data_type'] = 1;
                $where['data_item_id'] = array('in', $return_arr);
                $where['status'] = 2;
                $order_list = D('Order')->where($where)->field('order_id, order_no, uid, store_id, pro_num, address_tel')->select();

                import('source.class.ReturnOrder');
                ReturnOrder::batchReturn($order_list);
            }
        } else {
            $result = D('Tuan')->where(array('id' => $tuan_id))->data(array('tuan_config_id' => '-1', 'operation_dateline' => $_SERVER['REQUEST_TIME']))->save();
            if (!$result) {
                json_return(1000, '操作失败');
            }

            // 未发货状态进行自动退货
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['type'] = 6;
            $where['data_id'] = $tuan_id;
            $where['status'] = 2;
            $order_list = D('Order')->where($where)->field('order_id, order_no, uid, store_id, pro_num, address_tel')->select();

            import('source.class.ReturnOrder');
            ReturnOrder::batchReturn($order_list);
        }

        json_return(0, '操作成功');
    }



    private function _edit() {
        $seckill_id = $_POST['pigcms_id'];

        if (empty($seckill_id)) {
            echo '缺少最基本的参数ID';
            exit;
        }

        $seckill = D('Seckill')->where(array('pigcms_id' => $seckill_id, 'store_id' => $this->store_session['store_id'], 'delete_flag' => 0))->find();

        if (empty($seckill)) {
            echo '未找到要修改的秒杀';
            exit;
        }

        if ($seckill['start_time'] < time()) {
            echo '此团购已开始，不能编辑';
            exit;
        }

        $product = D('Product')->where(array('product_id' => $seckill['product_id'], 'store_id' => $this->store_session['store_id'], 'status' => array('!=', 2)))->field('`product_id`, `name`, `image`')->find();
        if (!empty($product)) {
            $product['image'] = getAttachmentUrl($product['image']);
            $product['url'] = option('config.wap_site_url') . '/good.php?id=' . $product['product_id'];
        }

        $this->assign('seckill', $seckill);
        $this->assign('product', $product);
    }

    private function _info() {
        $seckill_id = intval($_POST['tuan_id']);

        if (empty($seckill_id)) {
            pigcms_tips('缺少最基本的参数ID');
        }

        $seckill = D('Seckill')->where(array('pigcms_id' => $seckill_id, 'store_id' => $this->store_session['store_id'], 'delete_flag' => 0))->find();
        if (empty($seckill)) {
            pigcms_tips('未找相应的团购');
        }
        $product = M('Product')->get(array('product_id' => $seckill['product_id'], 'store_id' => $seckill['store_id']), 'product_id, name, image, price, sales');

        // 查出人缘开团购买数量
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['type'] = 6;
        $where['data_id'] = $tuan_id;
        $where['data_type'] = 0;
        $where['status'] = array('in', array(2, 3, 4, 7));
        $count_ry = D('Order')->where($where)->sum('pro_num');

        $where['data_type'] = 1;
        $count_list_tmp = D('Order')->where($where)->field('data_item_id, sum(pro_num) AS count')->group('data_item_id')->select();
        $count_list = array();
        $count += $count_ry;
        foreach ($count_list_tmp as $tmp) {
            $count += $tmp['count'];
            $count_list[$tmp['data_item_id']] = $tmp['count'];
        }

        $this->assign('seckill', $seckill);
        $this->assign('product', $product);
        $this->assign('count', $count);
        $this->assign('count_ry', $count_ry);
        $this->assign('count_list', $count_list);
    }

    private function _order() {
        $tuan_id = $_REQUEST['tuan_id'];
        $page = max(1, $_REQUEST['p']);
        $limit = 15;

        if (empty($tuan_id)) {
            pigcms_tips('缺少最基本的参数ID');
        }

        $tuan = D('Tuan')->where(array('id' => $tuan_id, 'store_id' => $this->store_session['store_id'], 'delete_flag' => 0))->find();
        if (empty($tuan)) {
            pigcms_tips('未找相应的团购');
        }

        $count = M('Order')->getActivityOrderCount(6, $tuan_id, 'ALL');
        $order_list = array();
        if ($count > 0) {
            $page = min($page, ceil($count / $limit));

            $offset = ($page - 1) * $limit;
            $order_list = M('Order')->getActivityOrderList(6, $tuan_id, $limit, $offset, false, 'ALL');
            $order_list = $order_list['order_list'];

            foreach ($order_list as &$order) {
                $return_product = D('Return_product')->where(array('order_id' => $order['order_id']))->find();
                $order['return_quantity'] = $return_product['pro_num'];
                $order['return_product_id'] = $return_product['order_product_id'];
            }

            import('source.class.user_page');
            $page = new Page($count, $limit, $page);
            $this->assign('pages', $page->show());
        }

        $this->assign('tuan', $tuan);
        $this->assign('status_arr', M('Order')->status(-1));
        $this->assign('tuan_id', $tuan_id);
        $this->assign('order_list', $order_list);
    }
}
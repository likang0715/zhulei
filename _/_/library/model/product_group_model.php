<?php
class product_group_model extends base_model{
	/*分页得到商品分组的列表*/
	public function get_list($store_id, $page_size = 15){
        $where = array();
    //    $where['product_count'] = array('>',0);
        $where['store_id'] = $store_id;
        if (!empty($_REQUEST['keyword'])) {
            $where['group_name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
		$list_count = $this->db->where($where)->count('group_id');
		import('source.class.user_page');
		$p = new Page($list_count,$page_size);
		$group_list = $this->db->field('`group_id`,`group_name`,`product_count`,`add_time`')->where($where)->order('`group_id` DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$return['group_list'] = $group_list;
		$return['page'] = $p->show();
		return $return;
	}
	/*分页得到所有商品分组的列表*/
	public function getAllList($page_size = 15){
        $where = array();
        if (!empty($_REQUEST['keyword'])) {
            $where['group_name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
		$list_count = $this->db->where($where)->count('group_id');
		import('source.class.user_page');
		$p = new Page($list_count,$page_size);
		$group_list = $this->db->field('`group_id`,`group_name`,`product_count`,`add_time`')->where($where)->order('`group_id` DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$return['group_list'] = $group_list;
		$return['page'] = $p->show();
		return $return;
	}
	public function get_all_list($store_id){
		$group_list = $this->db->field('`group_id`,`group_name`')->where(array('store_id'=>$store_id))->order('`group_id` DESC')->select();
		return $group_list;
	}
	/*得到一个商品分组*/
	public function get_group($store_id,$group_id){
		$condition_group['store_id'] = $store_id;
		$condition_group['group_id'] = $group_id;
		$now_group = $this->db->where($condition_group)->find();
		return $now_group;
	}

    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    /**
     * @param $group_id
     * @param $store_id
     * @return mixed
     * 返回商品分组下的20个商品
     */
    public function getProductList($group_id,$store_id){
        $where = array();
        $where['store_id'] = $store_id;
        $product_list = D('')->table('Product_group as g')
            ->join('Product_to_group as to_group on g.group_id = to_group.group_id', 'right')
            ->join('Product as p on to_group.product_id = p.product_id', 'right')
            ->where('g.store_id='.$store_id." and g.group_id =".$group_id)
            //->where('g.store_id='.$store_id)
            ->limit('20')
            ->select();
        $return['product_list'] = $product_list;
        return $return;
    }
}
?>
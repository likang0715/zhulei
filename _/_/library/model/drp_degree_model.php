<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2016/1/10
 * Time: 13:08
 */
class drp_degree_model extends base_model
{
    public function getDrpDegrees($where, $order_by = 'value asc')
    {
        $degrees = $this->db->where($where)->order($order_by)->select();
        if (!empty($degrees)) {
            foreach ($degrees as &$degree) {
                if (!empty($degree['degree_alias'])) {
                    $degree['name'] = $degree['degree_alias'];
                } else {
                    $platform_drp_degree = M('Platform_drp_degree')->getDrpDegree($degree['is_platform_degree_name']);
                    $degree['name'] = $platform_drp_degree['name'];
                }
                if (!empty($degree['degree_icon_custom'])) {
                    $degree['icon'] = getAttachmentUrl($degree['degree_icon_custom']);
                } else {
                    $platform_drp_degree = M('Platform_drp_degree')->getDrpDegree($degree['is_platform_degree_name']);
                    $degree['icon'] = getAttachmentUrl($platform_drp_degree['icon']);
                }
            }
        }
        return $degrees;
    }

    //检测分销商等级能否使用
    public function checkDrpDegree($store_id)
    {
        $platform_drp_degree = option('config.open_drp_degree');
        if (empty($platform_drp_degree)) {
            return false;
        }
        $store = D('Store')->field('open_drp_degree')->where(array('store_id' => $store_id))->find();
        if (empty($store['open_drp_degree'])) {
            return false;
        }
        return true;
    }

	public function getDrpDegree($where, $order_by = 'value asc')
	{
		$drp_degree = $this->db->where($where)->order($order_by)->find();
		if (!empty($drp_degree['degree_alias'])) {
			$drp_degree['name'] = $drp_degree['degree_alias'];
		} else {
			$platform_drp_degree = M('Platform_drp_degree')->getDrpDegree($drp_degree['is_platform_degree_name']);
			$drp_degree['name'] = $platform_drp_degree['name'];
		}
		if (!empty($drp_degree['degree_icon_custom'])) {
			$drp_degree['icon'] = $drp_degree['degree_icon_custom'];
		} else {
			$platform_drp_degree = M('Platform_drp_degree')->getDrpDegree($drp_degree['is_platform_degree_name']);
			$drp_degree['icon'] = $platform_drp_degree['icon'];
		}
		return $drp_degree;
	}

	/**
	 * 获取满足条件的记录数
	 */
	public function getCount($where) {
		$tag_count = $this->db->field('count(pigcms_id) as count')->where($where)->find();
		return $tag_count['count'];
	}


	//
	public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}

		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}

		$degree_list = $this->db->select();

		foreach($degree_list as $k=>$v) {
			if($v['degree_icon_custom']) {
				if(preg_match('/^images\//',$v['degree_icon_custom'])) {
					$degree_list[$k]['degree_icon_custom'] = getAttachmentUrl($v['degree_icon_custom']);
				} else {
					$degree_list[$k]['degree_icon_custom'] = option('config.site_url').'/'.$v['degree_icon_custom'];
				}
			}
			
		}

		return $degree_list;
	}

	/**
	 * 获取一条数据
	 */
	public function get($where) {
		return $this->db->where($where)->find();
	}
	
	public function edit($where, $data) {
		return $this->db->where($where)->data($data)->save();
	}
		
	/**
	 * 更改标签,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}
	
	/**
	 * 删除
	 */
	public function delete($where) {
		$this->db->where($where)->delete();
	}
	
	
}
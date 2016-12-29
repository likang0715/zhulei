<?php
/**
 * 公司模型
 * User: pigcms_21
 * Date: 2015/2/3
 * Time: 10:01
 */
    class company_model extends base_model{
        //查看用户是否已经添加公司
        public function getCompanyByUid($uid){
            $company = $this->db->where(array('uid' => $uid))->find();
			if($company){
				import('source.class.area');
				$area_class = new area();
                $company['province_code'] = $company['province'];
                $company['city_code'] = $company['city'];
                $company['area_code'] = $company['area'];
                $company['province'] = $area_class->get_name($company['province']);
				$company['city'] = $area_class->get_name($company['city']);
				$company['area'] = $area_class->get_name($company['area']);
				return $company;
			}
			return false;
        }

        //创建公司
        public function create($data)
        {
            if($this->db->data($data)->add()){
                return array('err_code' => 1,'err_msg' => $data);
            } else {
                return array('err_code' => 0,'err_msg' => '公司创建失败');
            }
        }

        //修改公司
        public function edit($where, $data)
        {
            return $this->db->where($where)->data($data)->save();
        }

        //删除公司
        public function delete($uid)
        {
            return $this->db->where(array('uid' => $uid))->delete();
        }

        public function get($uid)
        {
            $company = $this->db->where(array('uid' => $uid))->find();
            return $company;
        }
    }
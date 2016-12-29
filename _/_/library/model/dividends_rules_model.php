<?php
/**
 * 分红发放规则数据模型
 * User: HZ
 * Date: 2016/3/3
 * Time: 10:51
 */

class dividends_rules_model extends base_model
{

   //获取分红规则
   public function getRulesDescription($where,$type=0)
    {
       
        if($type == 0){
            $result = $this->db->where($where)->select();
        }else{
            $result = $where;
        }
        
        $des = array();
       
        foreach ($result as $key => $value) {
            $temp_db_des = '';
            $temp_jj_des = '';
            if($value['rule_type'] == 1){
                $temp_db_des .= $value['month'].'个月 进货交易额累计'.$value['money'].'元 ';

            }else if($value['rule_type'] == 2){
                $temp_db_des .= '单月交易额达到'.$value['money'].'元且保持'.$value['month'].'月 ';
            }

            if($value['is_bind'] == 1 || $value['rule_type'] == 3){
                if($value['dividends_type'] == 2){
                    $temp_db_des .= $value['rule3_month'].'个月 新增分销商'.$value['rule3_seller_1'].'个 ';
                }else{
                        $temp_db_des .= $value['rule3_month'].'个月 发展下一级分销商'.$value['rule3_seller_1'].'个  发展下二级分销商'.$value['rule3_seller_2'].'个 ';
                }
            }

            if($value['percentage_or_fix'] == 1){
                $temp_jj_des .= '周期内累计交易额的'.$value['percentage'].'%'; 
            }else{
                $temp_jj_des .= '固定值:'.$value['fixed_amount'];
            }

            if($value['is_limit']){
                $temp_jj_des .= ' 分红上限:'.$value['upper_limit'];
            }


            if($value['dividends_type'] == 2){
                if($value['rule_type'] == 3){
                    $temp_jj_des .= ' 团队所有者获取总奖金100%';
                }else{
                    $temp_jj_des .= ' 团队所有者获取总奖金'.$value['team_owner_percentage'].'%  剩余由团队成员交易额比例分成(0则全部依据比例分成 100%则只给团长)';
                }
            }

          
           $des[$value['dividends_type']][0] = $temp_db_des;
           $des[$value['dividends_type']][1] = $temp_jj_des;
        
        }

        return $des;
        
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/5/19
 * Time: 13:24
 */
class slider_model extends base_model{


    /*通过分类的KEY得到导航列表*/
    public function get_slider_by_key($cat_key, $limit = 6){
        if(empty($cat_key)) return false;

       $adver_list = $this->db -> table("Slider as s")
                               -> join("Slider_category sc On s.cat_id = sc.cat_id")
                               -> where("sc.cat_key='".$cat_key."' and s.status='1'")
                               -> limit($limit)
                               -> order("s.sort asc,s.id asc")
                               -> select();

        $adverlist = array();
        foreach($adver_list as $key=>$value){
            $adver_list[$key]['pic'] = getAttachmentUrl($value['pic']);
        }

        return $adver_list;

    }



}
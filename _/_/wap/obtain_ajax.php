<?php

require_once dirname(__FILE__).'/global.php';
//        $tpl_info = D('Aptitude_tpl')->where(array('status'=>1,'object'=>2))->find();
        $store_info = D('Store')->where(array('store_id'=>$_POST['store_id']))->find();

        $store_id = $store_info['root_supplier_id'];
        $drp_degree_id = $store_info['drp_degree_id'];
        $tpl_info = D('Aptitude_tpl')->where(array('status'=>1,'object'=>2,'store_id'=>$store_id,'degree_id'=>$drp_degree_id))->find();
        // var_dump($tpl_info);die;
        if(empty ($tpl_info)){
            echo 1;//为1就是没有模板数据
            die;
        }
        if(!empty ($tpl_info)){
            $tpl_info['store_name_seat'] = explode(',',$tpl_info['store_name_seat']);
                $tpl_info['store_name_seat'][0] = substr($tpl_info['store_name_seat'][0],0,-2);
                $tpl_info['store_name_seat'][1] = substr($tpl_info['store_name_seat'][1],0,-2);
            $tpl_info['proposer_seat'] = explode(',',$tpl_info['proposer_seat']);
                $tpl_info['proposer_seat'][0] = substr($tpl_info['proposer_seat'][0],0,-2);
                $tpl_info['proposer_seat'][1] = substr($tpl_info['proposer_seat'][1],0,-2);
            $tpl_info['validity_time_seat'] = explode(',',$tpl_info['validity_time_seat']);
                $tpl_info['validity_time_seat'][0] = substr($tpl_info['validity_time_seat'][0],0,-2);
                $tpl_info['validity_time_seat'][1] = substr($tpl_info['validity_time_seat'][1],0,-2);
            $time = time()+$tpl_info['validity_time']*31*86400;
            $stime = date("Y.m.d ",time());
            $otime = date("Y.m.d ",$time);
            $tpl_info['validity_time'] =  $stime."\n".$otime;
//            $this->assign('tpl_info',$tpl_info);
        }
        
        $img_name = 'tpl_'.time();
        
        $sname_left = $tpl_info['store_name_seat'][0];
        $sname_top = $tpl_info['store_name_seat'][1];
        $sname = $store_info['name'];
        
        $uname_left = $tpl_info['proposer_seat'][0];
        $uname_top = $tpl_info['proposer_seat'][1];
        $uname = $_POST['user_name'];
       
        $time_left = $tpl_info['validity_time_seat'][0];
        $time_top = $tpl_info['validity_time_seat'][1];
        $time = $tpl_info['validity_time'];
         
        $font_zt = 'mzd';

        $dst_path = $tpl_info['tpl_img_url'];
//       die;
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        //打上文字
        $font = '../static/zt/'.$font_zt.'.ttf';//字体
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        imagefttext($dst, 20, 0, $sname_left, $sname_top, $black, $font,$sname); //店铺名称
        imagefttext($dst, 20, 0, $uname_left, $uname_top, $black, $font,$uname);//个人签名
        imagefttext($dst, 10, 0, $time_left, $time_top, $black, $font,$time);//时间
   
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagepng($dst,"../upload/tpl/".$img_name.".gif");
                $img_url = "../upload/tpl/".$img_name.".gif";
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagepng($dst,"../upload/tpl/".$img_name.".jpeg");
                $img_url = "../upload/tpl/".$img_name.".jpeg";
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($dst,"../upload/tpl/".$img_name.".png");
                $img_url =  "../upload/tpl/".$img_name.".png";
                break;
            default:
                break;
        }
        
        if(empty ($img_url)){
            echo 2;//生成图片失败
        }else{
            $data['drp_supplier_id'] = $store_id;
            $data['object'] = 2;
            $data['store_id'] = $_SESSION['store']['store_id'];
            $data['img_url'] = $img_url;
            $info = D('Aptitude_obtain')->where(array('store_id'=>$data['store_id'],'drp_supplier_id'=>$data['drp_supplier_id'],'object'=>2))->find();
            if($info){
                $lid = D('Aptitude_obtain')->where(array('store_id'=>$data['store_id'],'drp_supplier_id'=>$data['drp_supplier_id'],'object'=>2))->data($data)->save();
            }else{
                $id = D('Aptitude_obtain')->data($data)->add(); 
            }
            echo $img_url;	
        }
            
            
            
        
?>
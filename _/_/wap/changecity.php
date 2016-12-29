<?php
/**
 *  城市选择
 */
require_once dirname(__FILE__).'/global.php';
//$product_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : pigcms_tips('您输入的网址有误','none');

$action = $_REQUEST['action'];

//cookie 地理坐标
$WebUserInfo = show_distance();
if($WebUserInfo['city_name']) {
	$user_location_city_name = msubstr($WebUserInfo['city_name'],0,3,'utf-8');
}
		
switch($action) {
		
	//设置城市保存
	case 'set_city':

        $area_code = $_REQUEST['area_code'];
        $area_name = $_REQUEST['area_name'];
        $city_code = $_REQUEST['city_code'];
        $city_name = $_REQUEST['city_name'];

        if($city_code == 'to_china') {
            setcookie("Web_user", json_encode(array('location'=>'all_city')), null);
            echo json_return(0,"设置城市成功");
        }
        
        //如果传过来只有一个区
        if(isset($city_code) && substr($city_code,-2,2)!='00'){
            $area_code = $_REQUEST['city_code'];
            $area_name = $_REQUEST['city_name'];
            $city_code = substr($area_code,0,4)."00";
            $area = D('Lbs_area')->where(array('code'=>$city_code))->field('name')->find();
            $city_name = $area['name'];
        }

        if(isset($city_code) && isset($area_code)){
            setcookie("Web_user", "", time() + 3600 * 2 *(-1));

            $cookie_arr = array(
                'city_code' => $city_code,
                'city_name' => $city_name,
                'area_code' => $area_code,
                'area_name' => $area_name,
            );
            setcookie("Web_user", json_encode($cookie_arr), null);
            echo json_return(0,"设置城市成功");
        }elseif($city_code) {
            setcookie("Web_user", "", time() + 3600 * 2 *(-1));

            $cookie_arr = array(
                'city_code' => $city_code,
                'city_name' => $city_name,
            );
            setcookie("Web_user", json_encode($cookie_arr), null);
            echo json_return(0,"设置城市成功");
        }
		break;
	
	//百度地图定位保存
	case 'set_location':
		
		$lng = $_REQUEST['lng'];
		$lat = $_REQUEST['lat'];
		//写入cookie
		$cookie_arr = array(
			'long' => $lng,
			'lat' => $lat,
			'timestamp' => time()
		);
		setcookie("Web_user", json_encode($cookie_arr), null);
		echo json_return(0,"定位成功");
		
		break;
		
	//百度地图显示
	case 'map':
			
			
			include display('mapPosition');
			exit;			
		break;

	//关键词搜索城市名
	case 'select_city':
		$keyword = $_REQUEST['keyword'];
		
		$info = D('Lbs_area')->where("is_open=1 and (chinese_spell like '".$keyword."%' or  name like  '".$keyword."%')")->limit(10)->select();
		if(count($info)) {
			echo json_return(0,$info);
			
		} else {
			echo json_return("1000", "没有数据");
		}
		
		
	break;

    //获取定位城市
    case 'location_city':
        $lng = $_REQUEST['lng'];
        $lat = $_REQUEST['lat'];
        if(isset($lng) && isset($lat)){
            $xml_array=simplexml_load_file("http://api.map.baidu.com/geocoder?location={$lat},{$lng}&output=xml&key=18bcdd84fae25699606ffad27f8da77b"); //将XML中的数据,读取到数组对象中
            $lbs_distance_limit = option("config.lbs_distance_limit");
            foreach($xml_array as $tmp){
                $WebUserInfo['address'] = $tmp->formatted_address;
                $WebUserInfo['city'] =$tmp->addressComponent->city;
            }

            if (!empty($WebUserInfo['address'])) {
                $user_location_city_name_all = trim($WebUserInfo['city']);
                $user_location_city_name = msubstr($WebUserInfo['city'],0,8,'utf-8');
                $city_info = D("Lbs_area")->where(array('name'=>$user_location_city_name_all))->field('code')->find();
                $city_code = $city_info['code'];
                $location_info = array('status' => 1,'type'=>'location','city'=> msubstr($WebUserInfo['city'],0,8,'utf-8') , 'city_code'=>$city_code);
            } else {
                $location_info = array('status' => 0);
            }
        }else{
            $location_info = array('status' => 0);
        }
        if(!headers_sent()) header('Content-type:application/json');
        exit(json_encode($location_info, true));

        echo ob_get_clean();

        break;
	
	default:
        //设置php执行时间
        ini_set('max_execution_time', 30);
		$data_areas = D('Lbs_area')->where(array('is_open'=>1))->select();
        $open_area = array();
        foreach($data_areas as $k=>$v){
            array_push($open_area,$v['code']);
        }
		if(!$data_areas) {
			return ;
		}

        $city_array = F('area_array');
		if($city_array) {
			$hot_city = F('hot_city');
			$zimu_area = F('zimu_area');
			$city_array = F('area_array');
			$all_city = F('all_city');

		} else {

			import('source.class.area');
			$class_area = new area();
			
			$hot_city = array();
			$data_area = array();
			$zimu_area = array();
			$all_city = array();
					
			$default_area = $class_area->get_AllProvCityArea();

			foreach($data_areas as $k=>$v) {
                $area = $default_area[substr($v['code'],0,2)]['city'][substr($v['code'],2,2)]['area'];
                foreach($area as $ak=>$av){
                    if(in_array($av['area_code'],$open_area)){
                        $v['area'][$ak] = array(
                            'area'=>$av['area'],
                            'area_code'=>$av['area_code']
                        );
                    }
                };
                if($v['first_spell']!=''){
				    $data_area[$v['first_spell']][] = $v;
                }
				$data_code_area[$v['code']] = $v;
				if($v['is_hot']) {
					$hot_city[$v['code']] = $v['name'];
				}
			}
			
			if(count($data_area)) {
				ksort($data_area);
				$zimu_area = array_keys($data_area);
			}

			$city_array = $data_area;

            F('area_array',$city_array);
            F('hot_city', $hot_city);
            F('zimu_area', $zimu_area);
            F('all_city', $all_city);
		}
	}

	include display('changecity');
	
	
	echo ob_get_clean();		
<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2016/02/01
 * Time: 10:09
 * description:  地址区域切换
 */
class changecity_controller extends base_controller{
	
	public function __construct() {
		parent::__construct();
		
	}
	
	public function index () {

		

		$this->display();
	}
	
	
	public function ajax_get_area() {
		import('source.class.area');
		$class_area = new area();

		$prov_code = $_POST['prov_code'];
		//$prov_code = 340000;
		$prov_prov_code = substr($prov_code,0,2);
		$default_area = $class_area->get_AllProvCity();
		$data_areas = D('Lbs_area')->where(array('is_open'=>1,'code'=>array('like',$prov_prov_code."%")))->select();
		echo json_return(0,$data_areas);
	}
	

	//百度地图定位保存
	public function set_location() {
		$lng = $_REQUEST['lng'];
		$lat = $_REQUEST['lat'];
		//写入cookie
		$cookie_arr = array(
				'long' => $lng,
				'lat' => $lat,
				'timestamp' => time()
		);
		setcookie("Web_user", json_encode($cookie_arr), time() + 3600 * 24 * 365);
		echo json_return(0,"定位成功");
	}
	
	//关键词搜索城市名
	public function select_city() {
		$keyword = $_REQUEST['keyword'];
		
		$info = D('Lbs_area')->where("is_open=1 and(chinese_spell like '".$keyword."%' or  name like  '".$keyword."%')")->limit(10)->select();
		$la = D('Lbs_area')->last_sql;
		if(count($info)) {
			echo json_return(0,$info);
			
		} else {
			echo json_return("1000", "没有数据".$la);
		}	
	}
	
	//设置城市保存
	public function set_city() {
        $area_code = $_REQUEST['area_code'];
        $area_name = $_REQUEST['area_name'];
		$city_code = $_REQUEST['city_code'];
		$city_name = $_REQUEST['city_name'];
        $province_code = $_REQUEST['province_code'];
        $province_name = $_REQUEST['province_name'];
        //如果传过来只有一个区
        if(isset($city_code) && substr($city_code,-2,2)!='00'){
            $area_code = $_REQUEST['city_code'];
            $area_name = $_REQUEST['city_name'];
            $city_code = substr($area_code,0,4)."00";
            $area = D('Lbs_area')->where(array('code'=>$city_code))->field('name')->find();
            $city_name = $area['name'];
        }
		
		if($city_code == 'to_china') {
			setcookie("Web_user", "", time() + 3600 * 24 * 365*(-1));
			echo json_return(0,"设置城市成功");
		} 

        if(isset($city_code) && isset($area_code)){
            setcookie("Web_user", "", time() + 3600 * 24 * 365*(-1));

            $cookie_arr = array(
                'province_code' => $province_code,
                'province_name' => $province_name,
                'city_code' => $city_code,
                'city_name' => $city_name,
                'area_code' => $area_code,
                'area_name' => $area_name,
            );
            setcookie("Web_user", json_encode($cookie_arr), time() + 3600 * 24 * 365);
            echo json_return(0,"设置城市成功");
        }elseif($city_code) {
			setcookie("Web_user", "", time() + 3600 * 24 * 365*(-1));
			
			$cookie_arr = array(
                'province_code' => $province_code,
                'province_name' => $province_name,
				'city_code' => $city_code,
				'city_name' => $city_name,	
			);
			setcookie("Web_user", json_encode($cookie_arr), time() + 3600 * 24 * 365);
			echo json_return(0,"设置城市成功");
		}
	
	}
}
<?php
class index_controller extends base_controller{
	public function index(){
		if(is_mobile()){
			redirect($this->config['wap_site_url']);
		}else{
			redirect(url('user:store:select'));
		}
	}
}
?>
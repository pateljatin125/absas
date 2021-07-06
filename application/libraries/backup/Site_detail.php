<?php
Class Site_detail{
	public function __Construct(){
		$this->CI = get_instance();
		$this->CI->load->model('beats_model');
		//check ip_address cookie(for visitors)
		if(!isset($_COOKIE['ip_address'])) {
			//setcookie('ip_address', $_SERVER['HTTP_X_REAL_IP'], time() + (86400 * 30), "/"); // 86400 = 1 day
			setcookie('ip_address', $_SERVER['SERVER_PORT'], time() + (86400 * 30), "/"); // 86400 = 1 day
			$visitor['visitor']=1;
			$this->CI->beats_model->insert_data('website_visitors',$visitor);
		}
		
	}
	
}

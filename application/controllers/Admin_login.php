<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_login extends CI_Controller {
	public function __Construct(){
		parent::__Construct();

		 if($this->session->userdata('username')){
			redirect(base_url('Dashboard'));
		}
           
		
	}
	public function index()	{


		$this->load->view('Admin/index');
	}


	public function AdminForgot(){
	$this->load->view('Admin/ForgotPassword');
}


	public function u_signin()
	{
	   
	//	$verify = $this->beats_model->select_data('*' , 'admin' , array('email' =>trim($_POST['username']),'password' => trim($_POST['password'])));
	$verify = $this->beats_model->login_data('*' , 'admin' , array('email' =>trim($_POST['username']),'password' => trim($_POST['password'])));
		if(count($verify)>0)
		{
		$role = $verify['0']['role'];
		$status = $verify['0']['is_active'];
		if($status == 0)
		{
			echo "Ohhh ! Your account is currently Inactive";
			die;
		}
		$admin_email=$verify['0']['email'];
		$this->session->set_userdata('username',$admin_email);
		$this->session->set_userdata('user_id',$verify['0']['id']);
		$this->session->set_userdata('role', $role);

		$browser_details = get_browser(null,true);
		$browser = $browser_details['browser'];
		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $verify['0']['id'],
			'user_name' => $verify['0']['email'],
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'login',
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);
		echo 1;
		
		}
		else {
				echo "Ohhh ! Wrong Credential."; // wrong details
		}

	}
	public function forgotpassword()
	{
		$verify = $this->beats_model->select_data('*' , 'admin' , array('email' =>$_POST['username']));
		if(count($verify)>0)
		{
		    $otp=uniqid();
                    $data['otp'] = $otp;
                    
                    $user_detail = array(
									
									'otp' => $otp,
									
									);
				 $reg_id = $this->beats_model->update_data('admin',$user_detail,array('id' =>1));
		
      $sendemail=$_POST['username'];
		   
		 $mail="$sendemail,harvansh@hpsoftech.com";
		 $data['sender_mail'] = 'info@champhunt.com';
        $this->load->library('email');
        $config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8',
                  'priority' => '1'
                   );
                   
        $this->email->initialize($config);
        $this->email->from($data['sender_mail'], 'Champhunt');
        $this->email->to($mail);
        $this->email->subject('Forgot Password');
        $message=$this->load->view('Admin/forgotmail',$data,TRUE);
        $this->email->message($message);
        $this->email->send();
        echo 1;
		
		}
		else {
				echo "Ohhh ! Wrong Email Address."; // wrong details
		}

	}
	
	
function Adminupdate(){
    $user_detail = array(
									
									'password' => $_POST['newpassword'],
									'otp' => 'expire',
									
									);
				 $reg_id = $this->beats_model->update_data('admin',$user_detail,array('id' =>1));
    
	redirect(base_url('AdminLogin'));
}

	public function AdminUpdateLink($otp){
	     $data['otp'] = $otp;
	$this->load->view('Admin/updatepassword',$data);
}


	
}

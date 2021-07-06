<?php
defined('BASEPATH') or exit('No direct script access allowed');
// define('API_ACCESS_KEY', 'AAAA4ZU5p6M:APA91bHmTFQvfxwZZKEC4XzKRKT7RWTngm-uVv-JzOCozyI0ae0tmHVB77D13DHgX48v65omrnZ-tAbJn-Rp6bUhRMDcBu6hwSaX8s4Z9vEaQSYSwJHUEiwj_m7m1MlhDRNeO5QsMqQa');
   define('API_ACCESS_KEY', 'AAAA3JWXjJo:APA91bG0NUlZyUjyTs8IN48IL1WP6-b5wrFHojihqXVTBJF4RJla3l17QHQLncvFSHVAcIbEKMCVvvPuDxmbXNPbYHuEkgsanF91PfNNIxdJiLREeNe3b1e3g_6InDk911v7sDdNAsMc');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Test extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}
	
	
	
	public function Enoticenotification()
	{
	    $title = "On development Mode"; 
	    $message  = "Message";
	    $last ="Surat";
        $Sex ="Female";
        $Description = "eNotice for Missing Persons";
       $messageNotification = "Dholka Taliuka Ahmedabad disstict \n Last seen location: Ahmedabad  hqXVTBJF4RJla3l17\r\n No direct script access allowed";

		$dataset = array(
			'password' => 0,
		);

		$numdriver = $this->beats_model->select_data('*', 'user_signup');
	
		$user_detail1 = array(
			'titile' => $title,
			'message' => $message,
			'user_id' => 0,
			'notificationdate' => date("Y-m-d H:i:s")
		);
		$reg_id = $this->beats_model->insert_data('UserNotification_all', $user_detail1);
		$reg_id = $this->beats_model->insert_data('OfficerNotification_all', $user_detail1);
		$ttlfcm = count($numdriver);
		$registration_id = array();
// 		for ($i = 0; $i < $ttlfcm; $i++) {
// 			array_push($registration_id, $numdriver[$i]['fcm_tokenid']);
// 		}
//	$registration_id[0] = "foHjeIokS-2z4aHOegyST2:APA91bH2FLsAUtmuqaOo6n_4ETD-Gec2ZSaO1eT_usX9-D63GvXWWykaUsJSPHYv0jenpcThSjGtpUmXqBcgmVVNRgzRtP3MvXeg0n6boQeLh56GzP2ZVoK5kLkRsNzUf2NOCPT41xqV";
 	$registration_id[0] = "cHVmLCzDT36HcVn_YMtfbd:APA91bEtkLghcaNypjvPAJkFjWfp0M0KbrmFiCRqDnUdfCgTeSJFxKI-cYjPgkH0y_ekFcanNCc3eyBGQTGWQ3WRcaOLZgMfcWxEZDwds-iN0C86NGgSC9tcHyvLdRuA8lDnxt88v1Cf";
	
	
		
		//echo '<pre>'; print_r($registration_id); exit;
	//	cJpgw6iVS1ee4-x2H1g0UH:APA91bEDW0VK1dxiVuAGtf4q2LrHI_Zg5dHq0rLNr5uF4uMOMu3uIpqCZ2MtTbn0ikeX3nvqYC5wimgoCuiWrxNtYQQnKcTKjpbrNUd0Dyap8qczNGZ0-dKW13debB0PUuaSUTjS2fr-
		// define('API_ACCESS_KEY', 'AAAA4ZU5p6M:APA91bHmTFQvfxwZZKEC4XzKRKT7RWTngm-uVv-JzOCozyI0ae0tmHVB77D13DHgX48v65omrnZ-tAbJn-Rp6bUhRMDcBu6hwSaX8s4Z9vEaQSYSwJHUEiwj_m7m1MlhDRNeO5QsMqQa');
		$fcmMsg = array(
			'body' => $messageNotification,
			'title' => $title,
			'sound' => "default",
			'color' => "#203E78",
			'image' => "https://absas.com.ng/Admin/assets/admin/img/asas_logo.png"
		);
		$fcmFields = array(
			'registration_ids' => $registration_id,
			'priority' => 'high',
			'data'    => $fcmMsg,
			'notification' => $fcmMsg,
		);
		$headers = array(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
		$result = curl_exec($ch);
			echo '<pre>'; print_r($result); exit;
	//	curl_close($result);
			
	
	}


	public function chps(){
		echo 'test';
		echo phpinfo();
		//chmod("oldMypolice.php",0777);
		// chmod("/var/cpanel/php/sessions/ea-php71",0777);
	}
	
}

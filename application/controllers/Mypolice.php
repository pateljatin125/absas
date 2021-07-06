<?php
defined('BASEPATH') or exit('No direct script access allowed');
// define('API_ACCESS_KEY', 'AAAA4ZU5p6M:APA91bHmTFQvfxwZZKEC4XzKRKT7RWTngm-uVv-JzOCozyI0ae0tmHVB77D13DHgX48v65omrnZ-tAbJn-Rp6bUhRMDcBu6hwSaX8s4Z9vEaQSYSwJHUEiwj_m7m1MlhDRNeO5QsMqQa');
define('API_ACCESS_KEY', 'AAAA3JWXjJo:APA91bG0NUlZyUjyTs8IN48IL1WP6-b5wrFHojihqXVTBJF4RJla3l17QHQLncvFSHVAcIbEKMCVvvPuDxmbXNPbYHuEkgsanF91PfNNIxdJiLREeNe3b1e3g_6InDk911v7sDdNAsMc');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Mypolice extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();
		$this->load->library('session');
		require_once(APPPATH . 'libraries/phpqrcode/qrlib.php');
	}
	/*sen
	sending push notificaiton 
	@Param $title title of the notificaiton
	@Param $message message ,description or body limited characters
	@Param $registration_id array of fcm token id's to send messaging on those devices
	@Param $type type 1 for offficer app and 0 for citizen  app notification
	*/
	public function Nearbycab($lat1, $lon1, $type, $id)
	{
		if ($type == 0) {
			$cabs = $this->beats_model->select_data('*', 'Officer', array('Officer_status' => 1));
		} else {
			$a = "Officer_id !=" . $id . " AND Officer_status = 1";
			//  $numdriver= $this->beats_model->select_data('*' , 'Officer',$a);
			$cabs = $this->beats_model->select_data('*', 'Officer', $a);
		}
		// 	echo $this->db->last_query();
		// 	die;
		//print_r($cabs);
		$alldriverid = array();
		$allofficerid = array();
		foreach ($cabs as $itm) {
			//echo $itm['fcm_tokenid'];
			//  $lat1=$_POST['user_lat'];
			//  $lon1=$_POST['user_lan'];
			$lat2 = (float) $itm['lat'];
			$lon2 = (float) $itm['lag'];

			$unit = "K";

			$theta = $lon1 - $lon2;
			if (is_numeric($lon1) && is_numeric($lon1)) {
				if (is_numeric($theta)) {
					$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
					$dist = acos($dist);
					$dist = rad2deg($dist);
					// $miles = $dist * 60 * 1.1515;
					$miles = $dist * 25 * 1.1515;
					$unit = strtoupper($unit);
					if ($unit == "K") {
						$ttlkm = ($miles * 1.609344);
						if ($itm['officer_category'] == 1) {
							array_push($alldriverid, $itm['fcm_tokenid']);
							array_push($allofficerid, $itm['Officer_id']);
						} else {
							if ($ttlkm <= 25) {
								array_push($alldriverid, $itm['fcm_tokenid']);
								array_push($allofficerid, $itm['Officer_id']);
							}
						}
					}
				}
			}
		}
		return array('fcm' => $alldriverid, 'offid' => $allofficerid);
	}

	public function Nearbyunit($lat1, $lon1, $type)
	{
		$cabs = $this->beats_model->select_data('*', 'PoliceUnit', array('UnitType' => $type));
		// echo $this->db->last_query();
		if (!empty($cabs)) {
			$alldriverid = array();
			$alldriverid1 = array();

			foreach ($cabs as $itm) {
				$lat2 = $itm['Latitude'];
				$lon2 = $itm['Longitude'];

				$unit = "K";

				$theta = $lon1 - $lon2;
				$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
				$dist = acos($dist);
				$dist = rad2deg($dist);
				$miles = $dist * 60 * 1.1515;
				// $miles = $dist * 25 * 1.1515;
				$unit = strtoupper($unit);

				if ($unit == "K") {
					$ttlkm = ($miles * 1.609344);

					array_push($alldriverid, $ttlkm);
					array_push($alldriverid1, $itm['PoliceUnit_id']);
				}
			}

			$b = array_keys($alldriverid, min($alldriverid));

			// $check_user = $this->beats_model->select_data('*', 'PoliceUnit', array('PoliceUnit_id' => $alldriverid1[$b[0]]));
			$check_user = $this->beats_model->select_data('*', 'PoliceUnit', 'PoliceUnit_id IN (' . implode(',', $alldriverid1) . ')');

			if (!empty($check_user)) {
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $check_user));
			} else {
				echo json_encode(array('status' => true, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => true, 'message' => 'No data found.'));
		}
	}

	//old 18_5_2020
	public function oldsmsphoneval()
	{

		//SMS PHONE VALIDATION

		$keyword = $_REQUEST['keyword'];
		$sim = $_REQUEST['sim'];
		$sender = $_REQUEST['sender'];
		$message = $_REQUEST['message'];
		$ref = $_REQUEST['ref'];
		$msgdate = $_REQUEST['msgdate'];
		date_default_timezone_set("Africa/Lagos");
		$entrydate = date('Y-m-d H:i:s');

		//$recField = "keyword, sim, sender, message, ref, msgdate, entrydate";
		//$recData = "'$keyword', '$sim', '$sender', '$message', '$ref', '$msgdate', '$entrydate'";

		$tableData = array('keyword' => $keyword, 'sim' => $sim, 'sender' => $sender, 'message' => $message, 'ref' => $ref, 'msgdate' => $msgdate, 'entryDate' => $entrydate);
		$this->beats_model->insert_data("shortcode_sms", $tableData);

		echo json_encode(array('status' => true, 'message' => 'Successful'));

		//echo "YOU ARE WELCOME2g";
	}
	//new at 18_5_2020 
	public function smsphoneval()
	{

		//SMS PHONE VALIDATION

		$keyword = $_REQUEST['keyword'];
		$sim = $_REQUEST['sim'];
		$sender = $_REQUEST['sender'];
		$message = $_REQUEST['message'];
		$ref = $_REQUEST['ref'];
		$msgdate = $_REQUEST['msgdate'];
		date_default_timezone_set("Africa/Lagos");
		$entrydate = date('Y-m-d H:i:s');

		//$recField = "keyword, sim, sender, message, ref, msgdate, entrydate";
		//$recData = "'$keyword', '$sim', '$sender', '$message', '$ref', '$msgdate', '$entrydate'";

		$tableData = array('keyword' => $keyword, 'sim' => $sim, 'sender' => $sender, 'message' => $message, 'ref' => $ref, 'msgdate' => date("Y-m-d h:i A", strtotime($msgdate)), 'entryDate' => $entrydate);
		$idnew = $this->beats_model->insert_data("shortcode_sms", $tableData);
		$data = array();

		// User
		if (strpos(strtolower($message), 'user') !== false) {
			$sd_number = str_replace('absas user', '', strtolower($message));
			// Old
			// $check_citizen = $this->beats_model->select_data('*', 'user_signup', "user_phone = '" . $sender . "' and verify_code like '%" . trim($sd_number) . "%'");
			// New 28_5_2020
			$check_citizen = $this->beats_model->select_data('*', 'user_signup', "user_phone = '" . $sender . "'");
			if (!empty($check_citizen)) {
				// old
				// $this->sendPushNotisms("Shortcode Verification", "Verify citizen shortcode (" . $check_citizen[0]['verify_code'] . ") successfull", array('citizen', $check_citizen[0]['user_id'], $check_citizen[0]['fcm_tokenid']), array($check_officer[0]['fcm_tokenid']), "10");

				$Mbl = $check_citizen[0]['user_phone'];
				array_push($data, array('user_phone' => $Mbl));
				if ($check_citizen[0]['verify_code'] == trim($sd_number)) {

					$message = 'Your phone number: ' . $Mbl . ' has been verified. You can now login to ABSAS. Thanks';   /* message to be sent */
					// new 27_5_2020
					$this->sendPushNotisms("AB-SAS", $message, array('citizen', $check_citizen[0]['user_id'], $check_citizen[0]['fcm_tokenid']), array($check_citizen[0]['fcm_tokenid']), "10");
					$this->sendsmsnew($Mbl, $message);
					$user_detail = array(
						'verify_code' => 'verified',
						'user_status' => '1',
					);
					$this->beats_model->update_data('user_signup', $user_detail, array('user_id' => $check_citizen[0]['user_id']));
					echo json_encode(array('status' => true, 'message' => 'Successful', 'detail' => $data));
				} else {
					if ($check_citizen[0]['verify_code'] == 'verified') {
						$message = 'Your phone number: ' . $Mbl . ' already verified. Please login to ABSAS again your phone number. Thanks';   /* message to be sent */
						$this->sendPushNotisms("AB-SAS", $message, array('citizen', $check_citizen[0]['user_id'], $check_citizen[0]['fcm_tokenid']), array($check_citizen[0]['fcm_tokenid']), "10");
						$this->sendsmsnew($Mbl, $message);
						echo json_encode(array('status' => false, 'message' => 'alredy successful', 'detail' => $data));
					} else {
						$message = 'Your phone number: ' . $Mbl . ' could not be verified due to an invalid verification code. Please login to ABSAS again to re-verify your phone number. Thanks';   /* message to be sent */
						$this->sendPushNotisms("AB-SAS", $message, array('citizen', $check_citizen[0]['user_id'], $check_citizen[0]['fcm_tokenid']), array($check_citizen[0]['fcm_tokenid']), "10");
						$this->sendsmsnew($Mbl, $message);
						echo json_encode(array('status' => false, 'message' => 'Umsuccessful', 'detail' => $data));
					}
				}
			}
			die();
		}
		// Officer
		if (strpos(strtolower($message), 'officer') !== false) {

			$sd_number = str_replace('absas officer', '', strtolower($message));
			//old
			// $check_officer = $this->beats_model->select_data('*', 'Officer', "phone = '" . $sender . "' and verify_code like '%" . trim($sd_number) . "%'");
			//new 28_5_2020
			$check_officer = $this->beats_model->select_data('*', 'Officer', "phone = '" . $sender . "'");
			if (!empty($check_officer)) {
				//old
				// $this->sendPushNotisms("AB-SAS", "Verify officer shortcode (" . $check_officer[0]['verify_code'] . ") successfull", array('officer', $check_officer[0]['Officer_id']), array($check_officer[0]['fcm_tokenid']), "10");

				$Mbl = $check_officer[0]['phone'];
				array_push($data, array('officer_phone' => $Mbl));
				if ($check_officer[0]['verify_code'] == trim($sd_number)) {


					$message = 'Your phone number: ' . $Mbl . ' has been verified. You can now login to ABSAS. Thanks';   /* message to be sent */
					// new 27_5_2020
					$this->sendPushNotisms("AB-SAS", $message, array('officer', $check_officer[0]['Officer_id']), array($check_officer[0]['fcm_tokenid']), "10");
					$this->sendsmsnew($Mbl, $message);
					$user_detail = array(
						'verify_code' => 'verified',
						'Officer_status' => '0',
					);
					$this->beats_model->update_data('Officer', $user_detail, array('Officer_id' => $check_officer[0]['Officer_id']));
					echo json_encode(array('status' => true, 'message' => 'Successful', 'detail' => $data));
				} else {
					if ($check_officer[0]['verify_code'] == 'verified') {
						$message = 'Your phone number: ' . $Mbl . ' already verified. Please login to ABSAS again your phone number. Thanks';   /* message to be sent */
						$this->sendPushNotisms("AB-SAS", $message, array('officer', $check_officer[0]['Officer_id']), array($check_officer[0]['fcm_tokenid']), "10");
						$this->sendsmsnew($Mbl, $message);
						echo json_encode(array('status' => false, 'message' => 'already successful', 'detail' => $data));
					} else {
						$message = 'Your phone number: ' . $Mbl . ' could not be verified due to an invalid verification code. Please login to ABSAS again to re-verify your phone number. Thanks';   /* message to be sent */
						$this->sendPushNotisms("AB-SAS", $message, array('officer', $check_officer[0]['Officer_id']), array($check_officer[0]['fcm_tokenid']), "10");
						$this->sendsmsnew($Mbl, $message);
						echo json_encode(array('status' => false, 'message' => 'Umsuccessful', 'detail' => $data));
					}
				}
			}
			die();
		}
		if ((strpos(strtolower($message), 'user') === false) && (strpos(strtolower($message), 'officer') === false)) {
			$message = 'Your phone number: ' . $sender . ' could not be verified due to an invalid verification code. Please login to ABSAS again to re-verify your phone number. Thanks';   /* message to be sent */
			$this->sendsmsnew($sender, $message);
			echo json_encode(array('status' => false, 'message' => 'Umsuccessful', 'detail' => array('number' => $sender)));
		}





		// echo json_encode(array('status' => true, 'message' => 'Successful', 'detail' => $data));

		//echo "YOU ARE WELCOME2g";
	}

	public function sendsmsnew($number, $message)
	{

		$user_detail = array(
			'number' => $number,
			'msg' => $message,
		);
		$this->beats_model->insert_data('sms_msg', $user_detail);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://absas.com.ng/simhost/smsapi20",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => array('num' => $number, 'msg' => $message),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		// echo $response;
	}

	public function displaytoastmsg()
	{

		//RANDOM TOAST MESSAGE
		$usertype = $_REQUEST['usertype'];

		$queryResult = $this->beats_model->select_toast_msg('tbl_toastmsg', 'usertype', $usertype, 'usertype');

		foreach ($queryResult->result() as $rowData) {
			$toastmessage = $rowData->message;
		}

		echo json_encode(array('status' => 'Successful', 'usertype' => $usertype, 'message' => $toastmessage));



		//echo "YOU ARE WELCOME2g";
	}



	public function forgotpasswordphone()
	{
		if (isset($_POST['user_phone'])) {

			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_phone' => $_POST['user_phone']));

			if (!empty($check_user)) {

				$Mbl = $_POST['user_phone'];
				$otp = rand(1000, 9999);
				$data['otp'] = $otp;
				$user_id = $check_user['0']['user_id'];
				$user_detail = array(
					'otp' => $otp,
				);

				$reg_id = $this->beats_model->update_data('user_signup', $user_detail, array('user_id' => $check_user['0']['user_id']));

				$msgy = base_url('Userupdate/') . $otp . '/' . $user_id;

				// $owneremail = "ict@ribs.com.ng";
				// $subacct = "ABSAS";
				// $subacctpwd = "absas2020!";
				// $sendto = $Mbl;  /* destination number */
				// $sender = "ABSAS";   /* sender id */
				$message = 'your verification code is ' . $otp;   /* message to be sent */
				// $url = "http://www.smslive247.com/http/index.aspx?"  . "cmd=sendquickmsg"  . "&owneremail=" . UrlEncode($owneremail)  . "&subacct=" . UrlEncode($subacct)  . "&subacctpwd=" . UrlEncode($subacctpwd)  . "&message=" . UrlEncode($message) . "&sender=" . UrlEncode($sender) . "&sendto=" . UrlEncode($sendto);
				// if ($f = @fopen($url, "r")) {
				// 	$answer = fgets($f, 255);
				// 	if (substr($answer, 0, 1) == "+") {
				// 		"SMS to $Mbl was successful.";
				// 	} else {
				// 		"an error has occurred: [$answer].";
				// 	}
				// } else {
				// 	"Error: URL could not be opened.";
				// }

				$this->sendsmsnew($Mbl, $message);




				echo json_encode(array('status' => true, 'message' => 'Successfull .', 'Details' => "$otp"));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function forgotpassword()
	{
		if (isset($_POST['user_phone']) && isset($_POST['user_kinPhone'])) {

			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_phone' => $_POST['user_phone']));

			if (!empty($check_user)) {
				$str = $check_user['0']['user_kinPhone'];
				$count = explode(",", $str);
				if (in_array($_POST['user_kinPhone'], $count)) {

					// 			if(preg_match('/^[0-9]{10}+$/', $_POST['user_email'])){
					// 	    	    $Mbl=$_POST['user_email'];
					//   $otp=uniqid();
					//                     $data['otp'] = $otp;
					//                     $user_id= $check_user['0']['user_id'];

					//                     $user_detail = array(

					// 									'otp' => $otp,

					// 									);

					// 				$reg_id = $this->beats_model->update_data('user_signup',$user_detail,array('user_id' =>$check_user['0']['user_id']));
					// // $msgy= base_url('/signupref/').$reg_id;
					// $msgy = base_url('Userupdate/').$otp.'/'.$user_id;

					// $curl = curl_init();

					// curl_setopt_array($curl, array(
					//   CURLOPT_URL => "https://api.msg91.com/api/sendhttp.php?campaign=&response=&afterminutes=&flash=&mobiles=$Mbl&authkey=282834Ad3OfxZ95d1467e8&route=4&sender=CHUMPH&message=$msgy&country=91",
					//   CURLOPT_RETURNTRANSFER => true,
					//   CURLOPT_ENCODING => "",
					//   CURLOPT_MAXREDIRS => 10,
					//   CURLOPT_TIMEOUT => 30,
					//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					//   CURLOPT_CUSTOMREQUEST => "GET",
					//   CURLOPT_SSL_VERIFYHOST => 0,
					//   CURLOPT_SSL_VERIFYPEER => 0,
					// ));

					// $response = curl_exec($curl);
					// $err = curl_error($curl);

					// curl_close($curl);
					// 	    	    }else{
					// 	    	       	$otp=uniqid();
					//                     $data['otp'] = $otp;
					//                     $data['user_id'] = $check_user['0']['user_id'];

					//                     $user_detail = array(

					// 									'otp' => $otp,

					// 									);

					// 				$reg_id = $this->beats_model->update_data('user_signup',$user_detail,array('user_id' =>$check_user['0']['user_id']));

					// 			$em=$check_user['0']['user_email'];
					// 		 $mail="$em";




					//  		$data['sender_mail'] = 'info@champhunt.com';

					//         $this->load->library('email');
					//         $config = array (
					//                   'mailtype' => 'html',
					//                   'charset'  => 'utf-8',
					//                   'priority' => '1'
					//                   );
					//         $this->email->initialize($config);
					//         $this->email->from($data['sender_mail'], 'Champhunt');
					//         $this->email->to($mail);
					//         $this->email->subject('Forgot password');
					//         $message=$this->load->view('frontend/forgotmail',$data,TRUE);
					//         //$this->load->view('forgot',$link,TRUE);
					//         $this->email->message($message);
					//         $this->email->send();
					// 	    	    }
					echo json_encode(array('status' => true, 'message' => 'Successfull .', 'Details' => $check_user['0']['user_id']));
				} else {
					echo json_encode(array('status' => false, 'message' => 'Kin Phone not exits '));
				}
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function updatepasswordotp()
	{
		if (isset($_POST['user_phone']) && isset($_POST['otp'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_phone' => $_POST['user_phone'], 'otp' => $_POST['otp']));
			if (!empty($check_user)) {
				echo json_encode(array('status' => true, 'message' => 'Successfull .', 'Details' => $check_user['0']['user_id']));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function sendPushNotisms($title, $message, $data, $registration_id, $type)
	{

		$user_detail = array(
			'titile' => $title,
			'message' => $message,
			'user_id' => $data[1],
			'notificationdate' => date("Y-m-d H:i:s")
		);
		if ($data[0] == 'citizen') {
			$this->beats_model->insert_data('UserNotification_all', $user_detail);
		}
		if ($data[0] == 'officer') {
			$this->beats_model->insert_data('OfficerNotification_all', $user_detail);
		}

		$fcmMsg = array(
			'body' => $message,
			'title' => $title,
			'type' => $type,
			'flag' => ($data[0] == 'citizen') ? '0' : '1'
		);
		$fcmFields = array(
			'registration_ids' => $registration_id,
			'priority' => 'high',
			'data'    => $fcmMsg,
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
		if (curl_exec($ch) === false) {
			echo 'Curl error: ' . curl_error($ch);
		}
		print_r($result);
		curl_close($ch);
	}
	public function sendPushNoti($title, $message, $registration_id, $type)
	{
		$fcmMsg = array(
			'body' => $message,
			'title' => $title,
			'type' => $type
		);
		$fcmFields = array(
			'registration_ids' => $registration_id,
			'priority' => 'high',
			'data'    => $fcmMsg,
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
		if (curl_exec($ch) === false) {
			echo 'Curl error: ' . curl_error($ch);
		}
		// print_r($result);
		curl_close($ch);
	}
	public function sendPushNotiSOS($title, $message, $registration_id, $type, $sos_id)
	{


		foreach ($registration_id['offid'] as $cab) {
			$user_detail = array(
				'titile' => $title,
				'message' => $message,
				'user_id' => $cab,
				'notificationdate' => date("Y-m-d H:i:s")
			);
			$this->beats_model->insert_data('OfficerNotification_all', $user_detail);
		}

		$fcmMsg = array(
			'body' => $message,
			'title' => $title,
			'type' => $type,
			'sos_id' => $sos_id
		);
		$fcmFields = array(
			'registration_ids' => $registration_id['fcm'],
			'priority' => 'high',
			'data'    => $fcmMsg,
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
		if (curl_exec($ch) === false) {
			echo 'Curl error: ' . curl_error($ch);
		}
		// print_r($result);
		curl_close($ch);
		// die();
	}

	public function sendPushNotiNew($title, $message, $data, $type)
	{

		// $cabs = $this->beats_model->select_data('*', 'Officer', array('Officer_status' => 1));
		// $dt = array('multiple', array(array('user_officer_meta', 'user_officer_meta.user_id=Officer.Officer_id','full')));
		// $cabs = $this->beats_model->select_data('user_officer_meta.*,Officer.*', 'Officer', "user_officer_meta.user_type = 2 ", '', array('Officer.Officer_id', 'DESC'), '', $dt);
		$cabs = $this->beats_model->select_data('Officer.*', 'Officer', "", '', array('Officer.Officer_id', 'DESC'), '', '');


		$registration_id = array();
		foreach ($cabs as $cab) {

			$user_detail = array(
				'titile' => $title,
				'message' => $message,
				'user_id' => $cab['Officer_id'],
				'notificationdate' => date("Y-m-d H:i:s"),
			);
			if ($cab['officer_category'] == 1) {
				$reg_id = $this->beats_model->insert_data('OfficerNotification_all', $user_detail);
				array_push($registration_id, $cab['fcm_tokenid']);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $cab['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				if ($data[0] == $check_user_meta[0]['lga_state']) {
					$reg_id = $this->beats_model->insert_data('OfficerNotification_all', $user_detail);
					array_push($registration_id, $cab['fcm_tokenid']);
				}
			}
		}



		$fcmMsg = array(
			'body' => $message,
			'title' => $title,
			'report_id' => $data[1],
			'report_type_id' => $data[2],
			'type' => $type
		);
		// print_r($registration_id);
		$fcmFields = array(
			'registration_ids' => $registration_id,
			'priority' => 'high',
			'data'    => $fcmMsg,
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
		if (curl_exec($ch) === false) {
			echo 'Curl error: ' . curl_error($ch);
		}
		// print_r($result);
		curl_close($ch);
		// die();
	}

	public function qrcode()
	{
		$qrtext = 'haravv';
		$SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'] . '/Admin/images/';
		$text = $qrtext;
		$text1 = substr($text, 0, 9);

		$folder = $SERVERFILEPATH;
		$file_name1 = $text1 . "-Qrcode" . rand(2, 200) . ".png";
		$file_name = $folder . $file_name1;
		QRcode::png($text, $file_name);

		//echo"<center><img src="'http://localhost/qrcd/phpddr/'.$file_name1."></center";
		echo $file_name1;
	}

	public function EmergencyNumbers()
	{
		if (isset($_POST['State'])) {
			$check_user =  $this->beats_model->select_data('*', 'EMERGENCY_NUMBERS', array('STATE' => $_POST['State']));
			if (count($check_user) > 0) {
				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}




	public function RegisterBusiness()
	{
		if (isset($_POST['name'])  && isset($_POST['business_category']) && isset($_POST['user_id']) && isset($_POST['place']) && isset($_POST['address']) && isset($_POST['description']) && isset($_POST['phone_number'])) {
			$business_category =  $this->beats_model->select_data('*', 'business_category', "business_name Like '%" . $_POST['business_category'] . "%' ");
			$images = array();
			if (!isset($_POST['directory_id'])) {

				if (!empty($_FILES['userfile']['name']['0'])) {
					$files = $_FILES;
					$count = count($_FILES['userfile']['name']);
					for ($i = 0; $i < $count; $i++) {
						$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
						$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
						$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
						$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
						$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
						$config['upload_path'] = 'uploads/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
						$config['max_size'] = '';
						$config['remove_spaces'] = true;
						$config['overwrite'] = false;
						$config['max_width'] = '';
						$config['max_height'] = '';
						$config['encrypt_name'] = true;
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload()) {
							$uploadData = $this->upload->data();
							$picture = $uploadData['file_name'];
							$fileName = time() . $files['userfile']['name'][$i];
							$images[] = base_url() . 'uploads/' . $picture;
						}
					}
				}

				$user_detail = array(
					'name' => $_POST['name'],
					'business_id' => $business_category[0]['business_id'],
					'user_id' => $_POST['user_id'],
					'place' => $_POST['place'],
					'address' => $_POST['address'],
					'description' => $_POST['description'],
					'phone_number' => $_POST['phone_number'],
					'images' =>  json_encode($images),
					'business_type' =>  $_POST['business_type'],
				);
				$reg_id = $this->beats_model->insert_data('user_directories', $user_detail);
				echo json_encode(array('status' => true, 'message' => 'User Business Registration Successful.'));
				die();
			} else {
				$directoryData = $this->beats_model->select_data('*', 'user_directories', array('directory_id' => $_POST['directory_id']));
				if (!empty($_FILES['userfile']['name']['0'])) {
					$files = $_FILES;
					$count = count($_FILES['userfile']['name']);
					for ($i = 0; $i < $count; $i++) {
						$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
						$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
						$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
						$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
						$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
						$config['upload_path'] = 'uploads/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
						$config['max_size'] = '';
						$config['remove_spaces'] = true;
						$config['overwrite'] = false;
						$config['max_width'] = '';
						$config['max_height'] = '';
						$config['encrypt_name'] = true;
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload()) {
							$uploadData = $this->upload->data();
							$picture = $uploadData['file_name'];
							$fileName = time() . $files['userfile']['name'][$i];
							$images[] = base_url() . 'uploads/' . $picture;
						}
					}
				}

				if (!empty(json_decode($directoryData[0]['images']))) {
					$oldmedia = json_decode($directoryData[0]['images']);
					$newimg = array_merge($oldmedia, $images);
				} else {
					$newimg = $images;
				}

				$user_detail = array(
					'name' => $_POST['name'],
					'business_id' => $business_category[0]['business_id'],
					'user_id' => $_POST['user_id'],
					'place' => $_POST['place'],
					'address' => $_POST['address'],
					'description' => $_POST['description'],
					'phone_number' => $_POST['phone_number'],
					'images' =>  json_encode($newimg),
					'business_type' =>  $_POST['business_type'],
					'is_active' => $_POST['is_active'],
					'updated_at' => date("Y-m-d H:i:s")
				);

				$res = $this->beats_model->update_data('user_directories', $user_detail, array('directory_id' => trim($_POST['directory_id'])));
				echo json_encode(array('status' => true, 'message' => 'User Business Updated Successful.'));
				die();
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function ViewBusiness()
	{
		if (isset($_POST['directory_id'])) {

			$dt = array('multiple', array(array('business_category', 'business_category.business_id=user_directories.business_id', 'left')));
			$directory = $this->beats_model->select_data('business_category.*,user_directories.*', 'user_directories', "directory_id = '" . $_POST['directory_id'] . "'", '', array('directory_id', 'DESC'), '', $dt);
			if (!empty($directory)) {
				$user_name = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $directory[0]['user_id']), '', array('user_id', 'DESC'), '', '');

				if (!empty($directory[0]['images'])) {
					$newimg = json_decode($directory[0]['images']);
					$imgarray = array();
					if (!empty($newimg))
						foreach ($newimg as $itm) {
							$user_img = array(

								'image' => $itm
							);
							array_push($imgarray, $user_img);
						}
				} else {
					$imgarray = array();
				}

				$data = array(
					'directory_id' => $directory[0]['directory_id'],
					'business_category' => $directory[0]['business_name'],
					'business_id' => $directory[0]['business_id'],
					'name' => $directory[0]['name'],
					'user_id' => $directory[0]['user_id'],
					'user_name' => $user_name[0]['user_name'],
					'user_phone' => $user_name[0]['user_phone'],
					'place' => $directory[0]['place'],
					'address' => $directory[0]['address'],
					'description' => $directory[0]['description'],
					'phone_number' => $directory[0]['phone_number'],
					'media' => $imgarray,
					'business_type' => ($directory[0]['business_type'] == 1 ? 'Regular' : 'Premium'),
					'is_promoted' => $directory[0]['is_promoted'],
					'created_at' => $this->getDayNew($directory[0]['created_at']),
					'updated_at' => $this->getDayNew($directory[0]['updated_at']),
				);
				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $data));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}

	public function ListBusiness()
	{
		if (isset($_POST['user_type'])) {

			$dt = array('multiple', array(array('business_category', 'business_category.business_id=user_directories.business_id', 'left')));
			if ($_POST['user_type'] == 2) {
				$qr = '';
				if (!empty($_POST['place'])) {

					$qr .= " place = '" . $_POST['place'] . "' and";
				}
				if (!empty($_POST['business_category'])) {
					$business_category =  $this->beats_model->select_data('*', 'business_category', "business_name Like '%" . $_POST['business_category'] . "%' ");
					if (!empty($business_category)) {
						$qr .= " user_directories.business_id = '" . $business_category[0]['business_id'] . "' and";
					}
				}

				// $qr = (strpos($qr, 'and', -3) !== false) ? substr($qr, 0, -3) : $qr;
				// $qr = (substr_count($qr, 'and', -3) == 1) ? substr($qr, 0, -3) : $qr;
				$qr = substr($qr, 0, -3);
				$directory_list = $this->beats_model->select_data('business_category.*,user_directories.*', 'user_directories', $qr, '', array('user_directories.is_promoted' => 'DESC', 'user_directories.business_type' => 'DESC', 'user_directories.directory_id' => 'DESC'), '', $dt);
			} else {
				$qr = "user_id = '" . $_POST['user_id'] . "' and";
				if (!empty($_POST['place'])) {

					$qr .= " place = '" . $_POST['place'] . "' and";
				}
				if (!empty($_POST['business_category'])) {
					$business_category =  $this->beats_model->select_data('*', 'business_category', "business_name Like '%" . $_POST['business_category'] . "%' ");

					if (!empty($business_category)) {
						$qr .= " user_directories.business_id = '" . $business_category[0]['business_id'] . "' and";
					}
				}

				// $qr = (strpos($qr, 'and', -3) !== false) ? substr($qr, 0, -3) : $qr;
				// $qr = (substr_count($qr, 'and', -3) == 1) ? substr($qr, 0, -3) : $qr;
				$qr = substr($qr, 0, -3);
				$directory_list = $this->beats_model->select_data('business_category.*,user_directories.*', 'user_directories', $qr, '', array('user_directories.is_promoted' => 'DESC', 'user_directories.business_type' => 'DESC', 'user_directories.directory_id' => 'DESC'), '', $dt);
			}

			// echo $this->db->last_query();
			$data_new = array();

			if (!empty($directory_list)) {
				foreach ($directory_list as $directory) {
					$user_name = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $directory['user_id']), '', array('user_id', 'DESC'), '', '');

					if (!empty($user_name)) {

						if (!empty($directory['images'])) {
							$newimg = json_decode($directory['images']);
							$imgarray = array();
							if (!empty($newimg))
								foreach ($newimg as $itm) {
									$user_img = array(

										'image' => $itm
									);
									array_push($imgarray, $user_img);
								}
						} else {
							$imgarray = array();
						}

						$data = array(
							'directory_id' => $directory['directory_id'],
							'business_id' => $directory['business_id'],
							'business_category' => $directory['business_name'],
							'name' => $directory['name'],
							'user_id' => $directory['user_id'],
							'user_name' => $user_name[0]['user_name'],
							'user_phone' => $user_name[0]['user_phone'],
							'place' => $directory['place'],
							'address' => $directory['address'],
							'description' => $directory['description'],
							'phone_number' => $directory['phone_number'],
							'media' => $imgarray,
							'business_type' => ($directory['business_type'] == 1 ? 'Regular' : 'Premium'),
							'is_promoted' => $directory['is_promoted'],
							'created_at' => $this->getDayNew($directory['created_at']),
							'updated_at' => $this->getDayNew($directory['updated_at'])
						);
						array_push($data_new, $data);
					}
				}
				if (empty($data_new)) {
					echo json_encode(array('status' => false, 'message' => 'No data found.'));
					die();
				}
				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $data_new));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}

	public function GetBusinessCategory()
	{
		$business_category =  $this->beats_model->select_data('*', 'business_category');
		if (0 == 0) {
			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $business_category));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}



	public function getDayNew($date_str = '')
	{
		if (empty($date_str)) {
			return '';
		}
		$dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$dow_numeric = date("w", strtotime($date_str));;
		return $dowMap[$dow_numeric] . ' ' . date("d/m/Y h:i A", strtotime($date_str));
	}
	


	public function RegisterUser()
	{
		if (isset($_POST['user_name'])  && isset($_POST['user_phone']) && isset($_POST['user_kinPhone']) && isset($_POST['password']) && isset($_POST['lga_state']) && isset($_POST['device_token'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_phone' => $_POST['user_phone']));
			if (empty($check_user)) {
			      $uniqueCode = '';
			      if(isset($_POST['unique_code'])){
			          $uniqueCode = $_POST['unique_code'];
			      }
				$verifycode = rand(1000000, 9999999);
				$user_detail = array(
					'user_name' => $_POST['user_name'],
					'unique_code' => $uniqueCode,
					'user_phone' => $_POST['user_phone'],
					'user_kinPhone' => $_POST['user_kinPhone'],
					'fcm_tokenid' => $_POST['device_token'],
					'password' => $_POST['password'],
					'verify_code' => $verifycode,
					'created_date' => date('d/m/Y h:i:s A'),
				);
				$reg_id = $this->beats_model->insert_data('user_signup', $user_detail);
				$meta_detail = array(
					'user_type' => '1',
					'user_id' => $reg_id,
					'lga_state' => $_POST['lga_state'],
					'blood_group' => $_POST['blood_group'],
					'geno_type' => $_POST['geno_type'],
					'agency' => '',
					'allergies' => $_POST['allergies']
				);
				$meta_id = $this->beats_model->insert_data('user_officer_meta', $meta_detail);




				// $verifycode = rand(1000000, 9999999);
				// $user_detail = array(
				// 	'verify_code' => $verifycode,
				// );
				// $reg_id1 = $this->beats_model->update_data('user_signup', $user_detail, array('user_id' => $reg_id));


				// user_officer_meta
				$check_user1 =  $this->beats_model->select_data('*', 'user_signup', array('user_id' => $reg_id));
				$check_meta_user1 =  $this->beats_model->select_data('*', 'user_officer_meta', array('meta_id' => $meta_id));
				unset($check_meta_user1[0]['user_id']);
				unset($check_meta_user1[0]['created_date']);
				unset($check_meta_user1[0]['update_date']);
				$new_user = array_merge($check_user1[0], $check_meta_user1[0]);

				echo json_encode(array('status' => true, 'message' => 'User Registration Successful.', 'Details' => $new_user));
			} else {
				echo json_encode(array('status' => false, 'message' => ' Phone number that already exists.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	
	
		
	
	public function setKeyword(){
		if (isset($_POST['search_keyword'])  && isset($_POST['user_id'])) {
		    
		    	$condition = array('user_id' => $_POST['user_id']);
		    	$check_user =  $this->beats_model->select_data('*', 'user_signup', $condition);
    			if (!empty($check_user)) {
    			    	$data = array('search_keyword' => $_POST['search_keyword'],'is_keyword' => '1',);
    				$log_qr = array('user_id' => $check_user[0]['user_id'], 'user_type' => 1, 'is_login' => 1);
                  	$res = $this->beats_model->update_data('user_signup', $data, array('user_id' => trim($_POST['user_id'])));
    				echo json_encode(array('status' => true, 'message' => 'User keyword save Successful.'));
    			} else {
    				echo json_encode(array('status' => false, 'message' => 'Ohhh ! Wrong Credential.'));
    			}
		}else{
		    	echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	
	
	public function verifyDevice()
    {
    	  if (isset($_POST['device_token'])) {
    	    	 $deviceToken = $_POST['device_token'];
    	         $data = $this->beats_model->select_data('*', 'device_verify', array('deviceToken' => $deviceToken,'isVerify' => '1'));
    	         
    	         if(count($data) > 0){
    	             if($data[0]['isVerify'] == '1'){
    	                 echo json_encode(array('status' => true, 'message' => 'Device Already verified.'));
    	             }else{
    	                  echo json_encode(array('status' => true, 'message' => 'Device not verified.'));
    	             }
    	         }else{
    	             echo json_encode(array('status' => false, 'message' => 'Device not verified.'));
    	         }
    	  } else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
    }
    
    public function sendOtp()
	{
	    
    	    	if (isset($_POST['mobile']) && isset($_POST['device_token'])) {
    	    	    
    	    	   $date = new DateTime("now", new DateTimeZone('Africa/Lagos'));
                   $currentDateTime = $date->format('Y-m-d H:i:s');
                   $from_time = strtotime($currentDateTime);
    	    	   $deviceToken = $_POST['device_token'];
    	    	   $mobile = $_POST['mobile'];
    	    	    $otp = mt_rand(1000,9999);
    	    	    
    	    	    
    	    	   $isVerifyDevice =  $this->beats_model->select_data('*', 'device_verify', array('deviceToken' => $deviceToken,'mobile' => $mobile,'isVerify' => "1"));
    	    	    if(isset($isVerifyDevice[0]['id'])){
    	    	        	echo json_encode(array('status' => true, 'message' => 'Your device has already verified')); exit;
    	    	    }
    	    	    
    	    	     $checkDevice =  $this->beats_model->select_data('*', 'device_verify', array('deviceToken' => $deviceToken,'mobile' => $mobile));
                        if(isset($checkDevice[0]['id'])){
                           $to_time = strtotime($checkDevice[0]['created_at']);
                      
                              if(abs($to_time - $from_time) > 1 && abs($to_time - $from_time) <= 60){
                                   	echo json_encode(array('status' => false, 'message' => 'Please try after 1 minutes.')); exit;
                               }
                        }
                        $todatDate = date('Y-m-d');
	    	         	$date_s = "date(created_at) BETWEEN date('" . $todatDate . " 00:00:01') AND date('" . $todatDate . "23:59:59')";
	    	         
	    	         		$date_s = 	"deviceToken " . "='" . $deviceToken . "' AND mobile " . "='" . $mobile."' AND date(created_at) BETWEEN date('" . $todatDate . "') AND date('" . $todatDate . "')";
				        	$data = $this->beats_model->select_data('*', 'device_verify', $date_s, '');
                        if(count($data) >= 3){
                            echo json_encode(array('status' => false, 'message' => 'Please try after 24 hours.')); exit;
                        }
	    	    try {
	    	        $email = "j.okodugha@gmail.com";
                       $password = "Abuja2021!";
                      $message = "Device verify OTP  :  ".$otp;
                        $sender_name = "ABSAS";
                        $recipients = $_POST['mobile'];
                        
                        
                        
                        $forcednd = "1";
                        $data = array("email" => $email, "password" => $password,"message"=>$message,"sender_name"=>$sender_name,"recipients"=>$recipients,"forcednd"=>$forcednd);
                        $data_string = json_encode($data);
                     
                        $ch = curl_init('https://app.multitexter.com/v2/app/sms');
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($data_string))
                        );
                        $result = curl_exec($ch);
                        $otpsend = json_decode($result);
                        
                        
                          $dataset = array('mobile' =>$mobile ,'deviceToken' => $deviceToken ,'isVerify' => "0",'otp' => $otp,"created_at"=>$currentDateTime,"updated_at"=>$currentDateTime);
                                                $this->beats_model->insert_data('device_verify',$dataset);
                                                echo json_encode(array('status' => true, 'message' => $otpsend->msg));    
                        
             
                    //     $checkDevice =  $this->beats_model->select_data('*', 'device_verify', array('deviceToken' => $deviceToken,'mobile' => $mobile));
                    //     if(isset($checkDevice[0]['id'])){
                    //          $otp_detail = array('otp' => $otp,'created_at'=>$currentDateTime,'updated_at' => $currentDateTime);
            	       // 	$updateAgency = $this->beats_model->update_data('device_verify', $otp_detail, array('id' => $checkDevice[0]['id']));
            	       // 	 echo json_encode(array('status' => true, 'message' => $otpsend->msg));
                    //     } else{
                    //                 if(isset($otpsend->status)){
                    //                             $dataset = array('mobile' =>$mobile ,'deviceToken' => $deviceToken ,'isVerify' => "0",'otp' => $otp,"created_at"=>$currentDateTime,"updated_at"=>$currentDateTime);
                    //                             $this->beats_model->insert_data('device_verify',$dataset);
                    //                             echo json_encode(array('status' => true, 'message' => $otpsend->msg));    
                    //                 }
                    //     }         
                                }catch(Exception $e) {
                                  echo json_encode(array('status' => false, 'message' => 'Error'));
                                }
            	    	}else{
            	    	    echo '<pre>'; print_r($_POST); exit;
            	    	    	echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
            	    	}
    }
    
    	public function verifyotp()
       {
	    	if (isset($_POST['mobile']) && isset($_POST['device_token']) && isset($_POST['otp'])) {
	    	    
	    	    $deviceToken = $_POST['device_token'];
	    	    $mobile = $_POST['mobile'];
	    	    $otp = $_POST['otp'];
	    	    
	    	    
	    	    $checkDevice =  $this->beats_model->select_data('*', 'device_verify', array('deviceToken' => $deviceToken,'mobile' => $mobile,'otp' => $otp));
	    	    if(isset($checkDevice[0]['id'])){
	    	        
	    	         $to_time = strtotime($checkDevice[0]['created_at']);
                              $date = new DateTime("now", new DateTimeZone('Africa/Lagos'));
                               $currentDateTime = $date->format('Y-m-d H:i:s');
                                $from_time = strtotime($currentDateTime);
                                
                                 if(abs($to_time - $from_time) > 60){
                                   	echo json_encode(array('status' => false, 'message' => 'OTP has been expired.')); exit;
                               }
	    	           $isVerify = array('isVerify' => '1');
	    	        	$updateAgency = $this->beats_model->update_data('device_verify', $isVerify, array('id' => $checkDevice[0]['id']));
	    	            echo json_encode(array('status' => true, 'message' => 'Your device has been verified.'));
	    	    }else{
	    	         echo json_encode(array('status' => false, 'message' => 'Invalid Otp.'));
	    	    }
          }else{
              echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
         }
      }

		public function getAgency()
    	{
    	    	$agency =  $this->beats_model->select_data('*', 'agency');
    	    	$count = count($agency);
    	    	 $agenylist = array();
    	    		for ($i = 0; $i < $count; $i++) {
    			     	$agenylist[$i] = $agency[$i]['name'];
    	    		}
    	    echo json_encode(array('status' => true, 'message' => 'List of Agency.', 'Details' => $agenylist));
    	    
    	}

	public function Login()
	{
		if (isset($_POST['user_phone']) && isset($_POST['password']) && isset($_POST['device_token'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_phone' => $_POST['user_phone'], 'password' => $_POST['password']));

			if (!empty($check_user)) {
				$this->beats_model->update_data('user_signup', array('fcm_tokenid' => $_POST['device_token'], 'update_date' => date("Y-m-d H:i:s")), array('user_id' => $check_user[0]['user_id']));
				if ($check_user[0]['verify_code'] != 'verified' || $check_user[0]['verify_code'] == '') {
					$verifycode = rand(1000000, 9999999);
					$user_detail = array(
						'verify_code' => $verifycode,
					);
					$this->beats_model->update_data('user_signup', $user_detail, array('user_id' => $check_user[0]['user_id']));
					// echo json_encode(array('status' => true, 'message' => 'This user has not been verified.', 'Details' => array('verification_code' => $verifycode)));
					// die();
					$check_user[0]['verify_code'] = $verifycode;
				}

				$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $check_user[0]['user_id'], 'user_type' => 1));
				$meta_detail = array();

				if (!empty($check_meta_user)) {
					$meta_detail = array(
						'user_type' => '1',
						'lga_state' => $check_meta_user[0]['lga_state'],
						'blood_group' => $check_meta_user[0]['blood_group'],
						'geno_type' => $check_meta_user[0]['geno_type'],
						'agency' => '',
						'allergies' => $check_meta_user[0]['allergies']
					);
				} else {
					$meta_detail = array(
						'user_type' => '1',
						'lga_state' => '',
						'blood_group' => '',
						'geno_type' => '',
						'agency' => '',
						'allergies' => ''
					);
				}

				$new_check_user = array_merge($check_user[0], $meta_detail);

				$user_log =  $this->beats_model->select_data('*', 'user_auth_logs', array('user_id' => $check_user[0]['user_id'], 'user_type' => 1, 'is_login' => 1));

				if (!empty($user_log)) {
					// if ($user_log[0]['imei'] != $_POST['imei']) {
					echo json_encode(array('status' => false, 'message' => 'User Already Login Other Device. Please Logout Other Device.', 'log_id' => $user_log[0]['log_id']));
					die();
					// }
				} else {
					$auth_logs = array(
						'user_type' => '1',
						'user_id' => $check_user[0]['user_id'],
						'device_type' => $_POST['device_type'],
						'is_login' => '1',
						'imei' => $_POST['imei'],
						'device_version' => $_POST['device_version'],
						'device_uuid' => $_POST['device_uuid'],
						'device_manufacturer' => $_POST['device_manufacturer'],
						'device_platform' => $_POST['device_platform'],
						'device_modelNo' => $_POST['device_modelNo'],
						'device_token' => $_POST['device_token'],
						'created_at' => date("Y-m-d H:i:s"),
						'expires_at' => date("Y-m-d H:i:s", strtotime('+12 months'))
					);
					$meta_id = $this->beats_model->insert_data('user_auth_logs', $auth_logs);
					$user_token = $this->beats_model->update_data('user_signup', array('fcm_tokenid' => $_POST['device_token'], 'update_date' => date("Y-m-d H:i:s")), array('user_id' => $check_user[0]['user_id']));

					echo json_encode(array('status' => true, 'message' => 'User Login Successful.', 'Details' => $new_check_user));
					die();
					// echo json_encode(array('status' => true, 'message' => 'User Login Successful. 123'.$_POST['device_modelNo'], 'Details' => $new_check_user));
				}
			} else {
				echo json_encode(array('status' => false, 'message' => 'Ohhh ! Wrong Credential.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function Logout()
	{
		if ((isset($_POST['user_phone']) && isset($_POST['password'])) || isset($_POST['user_id']) || isset($_POST['log_id'])) {
			$flag = 1;

			if (isset($_POST['log_id'])) {
				$user_log_ns =  $this->beats_model->select_data('*', 'user_auth_logs', array('log_id' => $_POST['log_id'], 'is_login' => '1'));
				if (!empty($user_log_ns)) {
					$updt_meta_id = $this->beats_model->update_data('user_auth_logs', array('is_login' => 0, 'updated_at' => date("Y-m-d H:i:s")), array('log_id' => $_POST['log_id']));
					$this->sendPushNoti("New device login detected!", "AB-SAS", array($user_log_ns[0]['device_token']), "2");
					echo json_encode(array('status' => true, 'message' => 'User Logout Successful.'));
					die();
				} else {
					echo json_encode(array('status' => true, 'message' => 'User Already Logout Successful.'));
					die();
				}
			}

			if (isset($_POST['user_id'])) {
				$condition = array('user_id' => $_POST['user_id']);
				$flag = 1;
			} else {
				$condition = array('user_phone' => $_POST['user_phone'], 'password' => $_POST['password']);
				$flag = 2;
			}

			$check_user =  $this->beats_model->select_data('*', 'user_signup', $condition);

			if (!empty($check_user)) {
				$log_qr = array('user_id' => $check_user[0]['user_id'], 'user_type' => 1, 'is_login' => 1);

				$user_log =  $this->beats_model->select_data('*', 'user_auth_logs', $log_qr);

				if (!empty($user_log)) {
					$updt_meta_id = $this->beats_model->update_data('user_auth_logs', array('is_login' => 0, 'updated_at' => date("Y-m-d H:i:s")), array('log_id' => $user_log[0]['log_id']));
					if ($flag == 2) {
						$this->sendPushNoti("New device login detected!", "AB-SAS", array($user_log[0]['device_token']), "2");
					}
				} else {
					echo json_encode(array('status' => true, 'message' => 'User Already Logout Successful.'));
					die();
				}
				echo json_encode(array('status' => true, 'message' => 'User Logout Successful.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'Ohhh ! Wrong Credential.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function PoliceVerify()
	{
		if (isset($_POST['Police_service_Number'])) {
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('Police_service_Number' => $_POST['Police_service_Number']));
			if (!empty($check_user)) {
				echo json_encode(array('status' => true, 'message' => 'User Registration Successful.', 'Details' => $check_user));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data Found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function UserDetails()
	{
		if (isset($_POST['user_id'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_id' => $_POST['user_id']));

			if (!empty($check_user)) {
				$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $_POST['user_id'], 'user_type' => 1));
				$meta_user = array();

				if (!empty($check_meta_user)) {
					$meta_detail = array(
						'user_type' => '1',
						'lga_state' => $check_meta_user[0]['lga_state'],
						'blood_group' => $check_meta_user[0]['blood_group'],
						'geno_type' => $check_meta_user[0]['geno_type'],
						'agency' => '',
						'allergies' => $check_meta_user[0]['allergies']
					);
				} else {
					$meta_detail = array(
						'user_type' => '1',
						'lga_state' => '',
						'blood_group' => '',
						'geno_type' => '',
						'agency' => '',
						'allergies' => ''
					);
				}
				$new_check_user = array_merge($check_user[0], $meta_detail);
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $new_check_user));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data Found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function UpdateAccount()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_name']) && isset($_POST['user_kinPhone']) && isset($_POST['user_kinPhone']) && isset($_POST['allergies'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_id' => $_POST['user_id']));

			if (!empty($check_user)) {
				$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $check_user[0]['user_id'], 'user_type' => 1));

				if (!empty($check_meta_user)) {

					$meta_detail = array(
						'user_type' => '1',
						'user_id' => $check_user[0]['user_id'],
						'lga_state' => $_POST['lga_state'],
						'blood_group' => (isset($_POST['blood_group']) && !empty($_POST['blood_group']) ? $_POST['blood_group'] : $check_meta_user[0]['blood_group']),
						'geno_type' => (isset($_POST['geno_type']) && !empty($_POST['geno_type']) ? $_POST['geno_type'] : $check_meta_user[0]['geno_type']),
						'agency' => '',
						'allergies' => $_POST['allergies'],
						'update_date' => date("Y-m-d H:i:s")
					);
					$updt_meta_id = $this->beats_model->update_data('user_officer_meta', $meta_detail, array('meta_id' => $check_meta_user[0]['meta_id']));
				} else {
					$meta_detail = array(
						'user_type' => '1',
						'user_id' => $check_user[0]['user_id'],
						'lga_state' => $_POST['lga_state'],
						'blood_group' => (isset($_POST['blood_group']) && !empty($_POST['blood_group']) ? $_POST['blood_group'] : ''),
						'geno_type' => (isset($_POST['geno_type']) && !empty($_POST['geno_type']) ? $_POST['geno_type'] : ''),
						'agency' => '',
						'allergies' => $_POST['allergies'],
						'update_date' => date("Y-m-d H:i:s")
					);

					$meta_id = $this->beats_model->insert_data('user_officer_meta', $meta_detail);
				}

				$updt_id = $this->beats_model->update_data('user_signup', array('user_name' => $_POST['user_name'], 'user_kinPhone' => $_POST['user_kinPhone'], 'update_date' => date("Y-m-d H:i:s")), array('user_id' => $_POST['user_id']));
				echo json_encode(array('status' => true, 'message' => 'User Update Successful.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data Found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function UpdatePassword()
	{
		if (isset($_POST['user_id']) && isset($_POST['password'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_id' => $_POST['user_id']));
			if (!empty($check_user)) {

				$updt_id = $this->beats_model->update_data('user_signup', array('password' => $_POST['password']), array('user_id' => $_POST['user_id']));
				echo json_encode(array('status' => true, 'message' => 'Successful.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data Found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Anonymoususer()
	{
		if (isset($_POST['AnonymousID'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('AnonymousID' => $_POST['AnonymousID']));
			if (empty($check_user)) {
				$user_detail = array(
					'AnonymousID' => $_POST['AnonymousID'],
				);
				$reg_id = $this->beats_model->insert_data('user_signup', $user_detail);
				$check_user1 =  $this->beats_model->select_data('*', 'user_signup', array('user_id' => $reg_id));
				echo json_encode(array('status' => true, 'message' => 'User Registration Successful.', 'Details' => $check_user1));
			} else {
				echo json_encode(array('status' => true, 'message' => 'User Registration Successful.', 'Details' => $check_user));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function FcmUpdate()
	{
		if (isset($_POST['user_id']) && isset($_POST['fcm_id'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_id' => $_POST['user_id']));
			if (count($check_user) > 0) {
				$user_detail = array(
					'fcm_tokenid' => $_POST['fcm_id'],
				);
				$reg_id = $this->beats_model->update_data('user_signup', $user_detail, array('user_id' => $_POST['user_id']));
				echo json_encode(array('status' => true, 'message' => ' Successfull Update.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function SOScreate()
	{
		if (isset($_POST['SOS_category'])  && isset($_POST['current_location']) && isset($_POST['user_id']) && isset($_POST['Name']) && isset($_POST['Phone_Number']) && isset($_POST['lat']) && isset($_POST['lang']) && isset($_POST['usertype'])) {
			$check_cat =  $this->beats_model->select_data('*', 'sos_category', array('sos_category_id' => $_POST['SOS_category']));
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}

				$user_detail = array(
					'sos_uniquely' => substr(md5(time()), 0, 15),
					'SOS_category' => $_POST['SOS_category'],
					'current_location' => $_POST['current_location'],
					'Name' => $_POST['Name'],
					'Phone_Number' => $_POST['Phone_Number'],
					'lat' => $_POST['lat'],
					'lang' => $_POST['lang'],
					'images' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'SOS_Source' => $_POST['usertype'],
					'usertype' => $_POST['usertype'],
					'created_at' => date("Y/m/d h:i:s A"),
					'created_dateat' => date("Y/m/d"),
					'update_at' => date("Y-m-d H:i:s")
				);
				$reg_id = $this->beats_model->insert_data('SOSManagement', $user_detail);

				$user_data = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $_POST['user_id']));

				/* sending sos */
				if ($_POST['usertype'] == 0) {
					$fcmof = $this->Nearbycab($_POST['lat'], $_POST['lang'], $_POST['usertype'], 0);
				} else {
					$fcmof = $this->Nearbycab($_POST['lat'], $_POST['lang'], $_POST['usertype'], $_POST['user_id']);
				}
				$this->sendPushNotiSOS("SOS Reported", "SOS recieved for " . $check_cat['0']['sos_category_name'], $fcmof, "1", $reg_id);
				/*End sos */

				if (!empty($user_data)) {

					$Mbl = $user_data[0]['user_kinPhone'];
					// $owneremail = "ict@ribs.com.ng";
					// $subacct = "ABSAS";
					// $subacctpwd = "absas2020!";
					// $sendto = $Mbl;
					// $sender = "ABSAS";
					$message = 'SOS Reported in ' . $user_data[0]['user_name'] . '. SOS category:' . $check_cat['0']['sos_category_name'];
					$this->sendsmsnew($Mbl, $message);
					// $url = "http://www.smslive247.com/http/index.aspx?"  . "cmd=sendquickmsg"  . "&owneremail=" . UrlEncode($owneremail)  . "&subacct=" . UrlEncode($subacct)  . "&subacctpwd=" . UrlEncode($subacctpwd)  . "&message=" . UrlEncode($message) . "&sender=" . UrlEncode($sender) . "&sendto=" . UrlEncode($sendto);
					// if ($f = @fopen($url, "r")) {
					// 	$answer = fgets($f, 255);
					// 	if (substr($answer, 0, 1) == "+") {
					// 		"SMS to $Mbl was successful.";
					// 	} else {
					// 		"an error has occurred: [$answer].";
					// 	}
					// } else {
					// 	"Error: URL could not be opened.";
					// }
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'SOS_id' => $reg_id));
			} else {
				$user_detail = array(
					'sos_uniquely' => substr(md5(time()), 0, 15),
					'SOS_category' => $_POST['SOS_category'],
					'current_location' => $_POST['current_location'],
					'Name' => $_POST['Name'],
					'Phone_Number' => $_POST['Phone_Number'],
					'lat' => $_POST['lat'],
					'lang' => $_POST['lang'],
					'user_id' => $_POST['user_id'],
					'SOS_Source' => $_POST['usertype'],
					'usertype' => $_POST['usertype'],
					'created_at' => date("Y/m/d h:i:s A"),
					'created_dateat' => date("Y/m/d"),
					'update_at' => date("Y-m-d H:i:s")
				);
				$reg_id = $this->beats_model->insert_data('SOSManagement', $user_detail);
				/* sending sos */
				if ($_POST['usertype'] == 0) {
					$fcmof = $this->Nearbycab($_POST['lat'], $_POST['lang'], $_POST['usertype'], 0);
				} else {
					$fcmof = $this->Nearbycab($_POST['lat'], $_POST['lang'], $_POST['usertype'], $_POST['user_id']);
				}
				$this->sendPushNotiSOS("SOS Reported", "SOS received for " . $check_cat['0']['sos_category_name'], $fcmof, "1", $reg_id);
				/*End sos */

				$user_data = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $_POST['user_id']));
				if (!empty($user_data)) {

					$Mbl = $user_data[0]['user_kinPhone'];
					// $owneremail = "ict@ribs.com.ng";
					// $subacct = "ABSAS";
					// $subacctpwd = "absas2020!";
					// $sendto = $Mbl;
					// $sender = "ABSAS";
					$message = 'SOS Reported in ' . $user_data[0]['user_name'] . '. SOS category:' . $check_cat['0']['sos_category_name'];
					$this->sendsmsnew($Mbl, $message);
					// $url = "http://www.smslive247.com/http/index.aspx?"  . "cmd=sendquickmsg"  . "&owneremail=" . UrlEncode($owneremail)  . "&subacct=" . UrlEncode($subacct)  . "&subacctpwd=" . UrlEncode($subacctpwd)  . "&message=" . UrlEncode($message) . "&sender=" . UrlEncode($sender) . "&sendto=" . UrlEncode($sendto);
					// if ($f = @fopen($url, "r")) {
					// 	$answer = fgets($f, 255);

					// 	if (substr($answer, 0, 1) == "+") {
					// 		"SMS to $Mbl was successful.";
					// 	} else {
					// 		"an error has occurred: [$answer].";
					// 	}
					// } else {
					// 	"Error: URL could not be opened.";
					// }
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'SOS_id' => $reg_id));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}


	public function UpdateSOScreate()
	{
		if (isset($_POST['SOS_id'])  && isset($_POST['current_location']) && isset($_POST['lat']) && isset($_POST['lang'])) {
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];

					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = '*';
					$config['max_size'] = '40960000';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					} else {
						echo json_encode(array('status' => false, 'message' => 'file not Upload.'));
						// $error = array('error' => $this->upload->display_errors());
						// print_r($error);
						die;
					}
				}

				$check_img =  $this->beats_model->select_data('images', 'SOSManagement', array('SOS_id' => $_POST['SOS_id']));
				if (!empty($check_img['0']['images'])) {
					$sosim = json_decode($check_img['0']['images']);
					$fresult = array_merge($sosim, $images);
				} else {
					$sosim = array();
					$fresult = array_merge($sosim, $images);
				}

				if (!empty($_POST['current_location'])) {
					$user_detail = array(
						'current_location' => $_POST['current_location'],
						'lat' => $_POST['lat'],
						'lang' => $_POST['lang'],
						'images' => json_encode($fresult),
						'update_at' => date("Y-m-d H:i:s")
					);
				} else {
					$user_detail = array(
						'images' => json_encode($fresult),
						'update_at' => date("Y-m-d H:i:s")
					);
				}
				$reg_id = $this->beats_model->update_data('SOSManagement', $user_detail, array('SOS_id' => $_POST['SOS_id']));
				$check_user =  $this->beats_model->select_data('*', 'SOSManagement', array('SOS_id' => $_POST['SOS_id']));
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $check_user));
			} else {
				
				
				$user_detail = array(
					'current_location' => $_POST['current_location'],
					'lat' => $_POST['lat'],
					'lang' => $_POST['lang'],
					'update_at' => date("Y-m-d H:i:s")
				);
				$check_user =  $this->beats_model->select_data('*', 'SOSManagement', array('SOS_id' => $_POST['SOS_id']));
				if (!empty($_POST['current_location'])) {
					$reg_id = $this->beats_model->update_data('SOSManagement', $user_detail, array('SOS_id' => $_POST['SOS_id']));
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $check_user));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function ReportCategory()
	{
		$check_user =  $this->beats_model->select_data('FiledReport_name', 'FiledReports_category');
		if (count($check_user) > 0) {
			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}

	public function SOSCategory()
	{
		$check_user =  $this->beats_model->select_data('sos_category_id,sos_category_name', 'sos_category', "sos_category_id NOT IN (3,6)");
		if (count($check_user) > 0) {
			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}

	public function Propertytype()
	{
		$check_user =  $this->beats_model->select_data('Propertytype_id,type_name', 'Propertytype');
		if (count($check_user) > 0) {
			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}

	public function iWitness()
	{
		if (isset($_POST['Location']) && isset($_POST['Description']) && isset($_POST['Date']) && isset($_POST['Time']) && isset($_POST['user_id'])) {
			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}

				$user_detail = array(
					'Location' => $_POST['Location'],
					'Description' => $_POST['Description'],
					'iWitness_tym' => $_POST['Time'],
					'iWitness_date' => $_POST['Date'],
					'user_id' => $_POST['user_id'],
					'Media' => json_encode($images),
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Location' => $_POST['Location'],
					'Description' => $_POST['Description'],
					'iWitness_tym' => $_POST['Time'],
					'iWitness_date' => $_POST['Date'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			}
			$reg_id = $this->beats_model->insert_data('iWitness', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for iWitness', array($_POST['Location'], $reg_id, "7"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function OfficerAbuse()
	{
		if (isset($_POST['Location']) && isset($_POST['Description']) && isset($_POST['Date']) && isset($_POST['Time'])) {
			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}
				if (isset($_POST['Officer_name'])) {
					$user_detail = array(
						'Location' => $_POST['Location'],
						'Description' => $_POST['Description'],
						'OfficerAbuse_tym' => $_POST['Time'],
						'OfficerAbuse_date' => $_POST['Date'],
						'Media' => json_encode($images),
						'Officer_name' => $_POST['Officer_name'],
						'user_id' => $_POST['user_id'],
						'user_type' => $usertype,
						'GeoLocation' => $_POST['GeoLocation'],
						'GeoLocation_lat' => $_POST['GeoLocation_lat'],
						'GeoLocation_lag' => $_POST['GeoLocation_lag'],
						'created_at' => date("Y-m-d H:i:s"),
						'update_at' => date("Y-m-d H:i:s")
					);
				} else {
					$user_detail = array(
						'Location' => $_POST['Location'],
						'Description' => $_POST['Description'],
						'OfficerAbuse_tym' => $_POST['Time'],
						'OfficerAbuse_date' => $_POST['Date'],
						'Media' => json_encode($images),
						'user_id' => $_POST['user_id'],
						'user_type' => $usertype,
						'GeoLocation' => $_POST['GeoLocation'],
						'GeoLocation_lat' => $_POST['GeoLocation_lat'],
						'GeoLocation_lag' => $_POST['GeoLocation_lag'],
						'created_at' => date("Y-m-d H:i:s"),
						'update_at' => date("Y-m-d H:i:s")
					);
				}
			} else {
				if (isset($_POST['Officer_name'])) {
					$user_detail = array(
						'Location' => $_POST['Location'],
						'Description' => $_POST['Description'],
						'OfficerAbuse_tym' => $_POST['Time'],
						'OfficerAbuse_date' => $_POST['Date'],
						'Officer_name' => $_POST['Officer_name'],
						'user_id' => $_POST['user_id'],
						'user_type' => $usertype,
						'GeoLocation' => $_POST['GeoLocation'],
						'GeoLocation_lat' => $_POST['GeoLocation_lat'],
						'GeoLocation_lag' => $_POST['GeoLocation_lag'],
						'created_at' => date("Y-m-d H:i:s"),
						'update_at' => date("Y-m-d H:i:s")
					);
				} else {
					$user_detail = array(
						'Location' => $_POST['Location'],
						'Description' => $_POST['Description'],
						'OfficerAbuse_tym' => $_POST['Time'],
						'OfficerAbuse_date' => $_POST['Date'],
						'user_id' => $_POST['user_id'],
						'user_type' => $usertype,
						'GeoLocation' => $_POST['GeoLocation'],
						'GeoLocation_lat' => $_POST['GeoLocation_lat'],
						'GeoLocation_lag' => $_POST['GeoLocation_lag'],
						'created_at' => date("Y-m-d H:i:s"),
						'update_at' => date("Y-m-d H:i:s")
					);
				}
			}
			$reg_id = $this->beats_model->insert_data('Officer_Abuse', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Officer Abuse', array($_POST['Location'], $reg_id, "22"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function CommendOffice()
	{
		if (isset($_POST['Location']) && isset($_POST['Description']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}

				if (isset($_POST['Officer_name'])) {
					$user_detail = array(
						'Location' => $_POST['Location'],
						'Description' => $_POST['Description'],
						'CommendOffice_tym' => $_POST['Time'],
						'CommendOffice_date' => $_POST['Date'],
						'Media' => json_encode($images),
						'Officer_name' => $_POST['Officer_name'],
						'user_id' => $_POST['user_id'],
						'user_type' => $usertype,
						'GeoLocation' => $_POST['GeoLocation'],
						'GeoLocation_lat' => $_POST['GeoLocation_lat'],
						'GeoLocation_lag' => $_POST['GeoLocation_lag'],
						'created_at' => date("Y-m-d H:i:s"),
						'update_at' => date("Y-m-d H:i:s")

					);
				} else {
					$user_detail = array(
						'Location' => $_POST['Location'],
						'Description' => $_POST['Description'],
						'CommendOffice_tym' => $_POST['Time'],
						'CommendOffice_date' => $_POST['Date'],
						'Media' => json_encode($images),
						'user_id' => $_POST['user_id'],
						'user_type' => $usertype,
						'GeoLocation' => $_POST['GeoLocation'],
						'GeoLocation_lat' => $_POST['GeoLocation_lat'],
						'GeoLocation_lag' => $_POST['GeoLocation_lag'],
						'created_at' => date("Y-m-d H:i:s"),
						'update_at' => date("Y-m-d H:i:s")


					);
				}
			} else {

				if (isset($_POST['Officer_name'])) {
					$user_detail = array(
						'Location' => $_POST['Location'],
						'Description' => $_POST['Description'],
						'CommendOffice_tym' => $_POST['Time'],
						'CommendOffice_date' => $_POST['Date'],
						'Officer_name' => $_POST['Officer_name'],
						'user_id' => $_POST['user_id'],
						'user_type' => $usertype,
						'GeoLocation' => $_POST['GeoLocation'],
						'GeoLocation_lat' => $_POST['GeoLocation_lat'],
						'GeoLocation_lag' => $_POST['GeoLocation_lag'],
						'created_at' => date("Y-m-d H:i:s"),
						'update_at' => date("Y-m-d H:i:s")


					);
				} else {
					$user_detail = array(
						'Location' => $_POST['Location'],
						'Description' => $_POST['Description'],
						'CommendOffice_tym' => $_POST['Time'],
						'CommendOffice_date' => $_POST['Date'],
						'user_id' => $_POST['user_id'],
						'user_type' => $usertype,
						'GeoLocation' => $_POST['GeoLocation'],
						'GeoLocation_lat' => $_POST['GeoLocation_lat'],
						'GeoLocation_lag' => $_POST['GeoLocation_lag'],
						'created_at' => date("Y-m-d H:i:s"),
						'update_at' => date("Y-m-d H:i:s")
					);
				}
			}

			$reg_id = $this->beats_model->insert_data('Commend_Officer', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Commend Officer', array($_POST['Location'], $reg_id, "23"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}


	public function StolenVehicle()
	{
		if (
			isset($_POST['Vehicle_make']) && isset($_POST['Vehicle_model']) && isset($_POST['Vehicle_lastlocation'])
			&& isset($_POST['Plate_Number']) && isset($_POST['Engine_Number']) && isset($_POST['Vehicle_Color']) && isset($_POST['Date']) && isset($_POST['Time'])
		) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}

				$user_detail = array(
					'Vehicle_make' => $_POST['Vehicle_make'],
					'Vehicle_model' => $_POST['Vehicle_model'],
					//'Vehicle_year' => $_POST['Vehicle_year'],
					'Vehicle_lastlocation' => $_POST['Vehicle_lastlocation'],
					'Plate_Number' => $_POST['Plate_Number'],
					'Engine_Number' => $_POST['Engine_Number'],
					'Vehicle_Color' => $_POST['Vehicle_Color'],
					'StolenVehicle_report_date' => $_POST['Date'],
					'StolenVehicle_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {

				$user_detail = array(
					'Vehicle_make' => $_POST['Vehicle_make'],
					'Vehicle_model' => $_POST['Vehicle_model'],
					//'Vehicle_year' => $_POST['Vehicle_year'],
					'Vehicle_lastlocation' => $_POST['Vehicle_lastlocation'],
					'Plate_Number' => $_POST['Plate_Number'],
					'Engine_Number' => $_POST['Engine_Number'],
					'Vehicle_Color' => $_POST['Vehicle_Color'],
					'StolenVehicle_report_date' => $_POST['Date'],
					'StolenVehicle_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('StolenVehicle_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Stolen Vehicle', array($_POST['Vehicle_lastlocation'], $reg_id, "17"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function MissingPersons()
	{
		if (
			isset($_POST['Full_Name']) && isset($_POST['Age']) && isset($_POST['Sex']) && isset($_POST['Description'])
			&& isset($_POST['Last_Seen_Location']) && isset($_POST['Spoken_Language']) && isset($_POST['Date']) && isset($_POST['Time'])
		) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}

				$user_detail = array(
					'Full_Name' => $_POST['Full_Name'],
					'Age' => $_POST['Age'],
					'Sex' => $_POST['Sex'],
					'Description' => $_POST['Description'],
					'Last_Seen_Location' => $_POST['Last_Seen_Location'],
					'Spoken_Language' => $_POST['Spoken_Language'],
					'Missing_Persons_report_Date' => $_POST['Date'],
					'Missing_Persons_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {

				$user_detail = array(
					'Full_Name' => $_POST['Full_Name'],
					'Age' => $_POST['Age'],
					'Sex' => $_POST['Sex'],
					'Description' => $_POST['Description'],
					'Last_Seen_Location' => $_POST['Last_Seen_Location'],
					'Spoken_Language' => $_POST['Spoken_Language'],
					'Missing_Persons_report_Date' => $_POST['Date'],
					'Missing_Persons_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Missing_Persons_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Missing Persons', array($_POST['Last_Seen_Location'], $reg_id, "18"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Kidnap()
	{
		if (
			isset($_POST['Full_Name']) && isset($_POST['Age']) && isset($_POST['Sex']) && isset($_POST['Description'])
			&& isset($_POST['Last_Seen_Location']) && isset($_POST['Spoken_Language']) && isset($_POST['Date']) && isset($_POST['Time'])
		) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}

				$user_detail = array(
					'Full_Name' => $_POST['Full_Name'],
					'Age' => $_POST['Age'],
					'Sex' => $_POST['Sex'],
					'Description' => $_POST['Description'],
					'Last_Seen_Location' => $_POST['Last_Seen_Location'],
					'Spoken_Language' => $_POST['Spoken_Language'],
					'Kidnap_report_Date' => $_POST['Date'],
					'Kidnap_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {

				$user_detail = array(
					'Full_Name' => $_POST['Full_Name'],
					'Age' => $_POST['Age'],
					'Sex' => $_POST['Sex'],
					'Description' => $_POST['Description'],
					'Last_Seen_Location' => $_POST['Last_Seen_Location'],
					'Spoken_Language' => $_POST['Spoken_Language'],
					'Kidnap_report_Date' => $_POST['Date'],
					'Kidnap_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Kidnap_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Kidnap', array($_POST['Last_Seen_Location'], $reg_id, "19"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Rape()
	{
		if (
			isset($_POST['Victim_Name']) && isset($_POST['Age']) && isset($_POST['Sex']) && isset($_POST['Description'])
			&& isset($_POST['Location']) && isset($_POST['Date']) && isset($_POST['Time'])
		) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp|pdf';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}
				$user_detail = array(
					'Victim_Name' => $_POST['Victim_Name'],
					'Age' => $_POST['Age'],
					'Sex' => $_POST['Sex'],
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Rape_report_Date' => $_POST['Date'],
					'Rape_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'media' => json_encode($images),
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			}
			else
			{
				$user_detail = array(
					'Victim_Name' => $_POST['Victim_Name'],
					'Age' => $_POST['Age'],
					'Sex' => $_POST['Sex'],
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Rape_report_Date' => $_POST['Date'],
					'Rape_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			}


			$reg_id = $this->beats_model->insert_data('Rape_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Rape', array($_POST['Location'], $reg_id, "20"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}


	public function Lodgecomplaint()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Lodgecomplaint_report_Date' => $_POST['Date'],
					'Lodgecomplaint_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'Location' => $_POST['Location'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Lodgecomplaint_report_Date' => $_POST['Date'],
					'Lodgecomplaint_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'Location' => $_POST['Location'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Lodgecomplaint_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Lodge a complaint', array($_POST['Location'], $reg_id, "21"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function GunViolence()
	{
		if (isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}

				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'GunViolence_Date' => $_POST['Date'],
					'GunViolence_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'GunViolence_Date' => $_POST['Date'],
					'GunViolence_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Gun_Violence_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Gun Violence', array($_POST['Location'], $reg_id, "8"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Robbery()
	{
		if (isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Items']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Items' => $_POST['Items'],
					'Robbery_report_Date' => $_POST['Date'],
					'Robbery_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")


				);
			} else {


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Items' => $_POST['Items'],
					'Robbery_report_Date' => $_POST['Date'],
					'Robbery_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Robbery_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Robbery', array($_POST['Location'], $reg_id, "22"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Burglary()
	{
		if (isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Items']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Items' => $_POST['Items'],
					'Burglary_report_Date' => $_POST['Date'],
					'Burglary_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")


				);
			} else {


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Items' => $_POST['Items'],
					'Burglary_report_Date' => $_POST['Date'],
					'Burglary_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Burglary_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Burglary', array($_POST['Location'], $reg_id, "23"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}


	public function CybercrimeFraud()
	{
		if (isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'CybercrimeFraud_report_Date' => $_POST['Date'],
					'CybercrimeFraud_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")


				);
			} else {


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'CybercrimeFraud_report_Date' => $_POST['Date'],
					'CybercrimeFraud_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('CybercrimeFraud_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Cybercrime', array($_POST['Location'], $reg_id, "24"), "5");;
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function SubmitTip()
	{
		if (isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")


				);
			} else {


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Submit_Tip_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Submit a Tip', array($_POST['Location'], $reg_id, "10"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function DrugAbuse()
	{
		if (isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")


				);
			} else {


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Drug_Abuse_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Drug Abuse', array($_POST['Location'], $reg_id, "11"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}


	public function DomesticViolence()
	{
		if (isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")


				);
			} else {


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Domestic_Violence_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Domestic Violence', array($_POST['Location'], $reg_id, "12"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function TerroristAttack()
	{
		if (isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")


				);
			} else {


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Terrorist_Attack_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Terrorist Attack', array($_POST['Location'], $reg_id, "24"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Others()
	{
		if (isset($_POST['Description']) && isset($_POST['Location']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")


				);
			} else {


				$user_detail = array(
					'Description' => $_POST['Description'],
					'Location' => $_POST['Location'],
					'Date' => $_POST['Date'],
					'tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}

			$reg_id = $this->beats_model->insert_data('Others_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Other Reports', array($_POST['Location'], $reg_id, "25"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}



	public function SOSDetails()
	{


		if (isset($_POST['user_id']) && isset($_POST['sos_category'])) {

			$cat = $this->beats_model->select_data('*', 'sos_category', "sos_category_name like '%" . $_POST['sos_category'] . "%'");
			$a = "SOSManagement.usertype = '0' and SOSManagement.user_id = '" . $_POST['user_id'] . "' and SOSManagement.SOS_category = '" . $cat[0]['sos_category_id'] . "'";
			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOSManagement.SOS_id', 'DESC'), '', $dt);


			// $dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// $check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', array('SOSManagement.SOS_id' => $_POST['SOS_id']), '', '', '', $dt);
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty($resmt['images'])) {
						$newimg = json_decode($resmt['images']);
						$imgarray = array();
						if (!empty($newimg))
							foreach ($newimg as $itm) {
								$user_img = array(
									'image' => $itm
								);
								array_push($imgarray, $user_img);
							}
					} else {
						$imgarray = array();
					}

					$checkfeed = $this->beats_model->select_data('*', 'SOSFeedback', array('SOS_id' => $resmt['SOS_id']));
					if (!empty($checkfeed)) {
						$feedarray = array();
						$feedmarray = array();
						foreach ($checkfeed as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}

							if (!empty($feed['feedbackMedia'])) {
								$feedmmarray = array();
								foreach (json_decode($feed['feedbackMedia']) as $itm3) {
									$user_img3 = array(
										'image' => $itm3
									);
									array_push($feedmmarray, $user_img3);
								}
							} else {
								$feedmmarray = array();
							}

							$feed_detail = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' =>	$feedmmarray,
							);
							array_push($feedarray, $feed_detail);
						}
					} else {
						$feedarray = array();
					}

					$user_detail = array(
						'SOS_id' =>	$resmt['SOS_id'],
						'sos_category_id' =>	$resmt['sos_category_id'],
						'sos_category_name' =>	$resmt['sos_category_name'],
						'current_location' =>	$resmt['current_location'],
						'user_name' => $resmt['Name'],
						'lat' => $resmt['lat'],
						'usertype' => $resmt['usertype'],
						'lang' => $resmt['lang'],
						'update_at' => $this->getDayNew($resmt['update_at']),
						'created_at' => $this->getDayNew($resmt['created_at']),
						'SOS_staus' => $resmt['SOS_staus'],
						'feedback' => $feedarray,
						'media' => $imgarray
					);
					array_push($newarr, $user_detail);
				}
			}


			if (count($check_user) > 0) {
				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Vandalism()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/Vandalism/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/Vandalism/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					// 'Vandalism_report_Date' => date("d-m-Y",strtotime($_POST['Date'])),
					// 'Vandalism_report_tym' => date("H:i A",strtotime($_POST['Time'])),
					'Vandalism_report_Date' => $_POST['Date'],
					'Vandalism_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Vandalism_report_Date' => $_POST['Date'],
					'Vandalism_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Vandalism_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Vandalism', array($_POST['Name'], $reg_id, "24"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsVandalism_report()
	{
		$page = (isset($_POST['page']) ? $_POST['page'] : '');
		$limit = (isset($_POST['limit']) ? $_POST['limit'] : '');
		$pagination = ''; //$this->paginat($limit, $page);
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Vandalism_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Vandalism_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Vandalism_report', array('Vandalism_report.user_id' => $_POST['user_id'], 'Vandalism_report.user_type' => '1'), '', array('Vandalism_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vandalism_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Vandalism_report.*,('user') as type", 'Vandalism_report', array('Vandalism_report.user_id' => $_POST['user_id'], 'Vandalism_report.user_type' => '0'), '', array('Vandalism_report_id', 'DESC'), '', $dt);
			}
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Vandalism_reportFeedback', array('Vandalism_report_id' => $resmt['Vandalism_report_id']));

					if (!empty($check_feedbac)) {
						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);
							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Vandalism_report_id' => $resmt['Vandalism_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Vandalism_report_tym'],
						'date' => $resmt['Vandalism_report_Date'],
						'date_time' => $this->getDayNew($resmt['Vandalism_report_Date'] . ' ' . substr($resmt['Vandalism_report_tym'], 0, -3) . " " . substr($resmt['Vandalism_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Vandalism_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
					);
					array_push($newarr, $user_detail);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Fire()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/Fire/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/Fire/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Fire_report_Date' => $_POST['Date'],
					'Fire_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Fire_report_Date' => $_POST['Date'],
					'Fire_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Fire_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Fire', array($_POST['Name'], $reg_id, "25"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsFire_report()
	{
		$page = (isset($_POST['page']) ? $_POST['page'] : '');
		$limit = (isset($_POST['limit']) ? $_POST['limit'] : '');
		$pagination = ''; //$this->paginat($limit, $page);
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Fire_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Fire_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Fire_report', array('Fire_report.user_id' => $_POST['user_id'], 'Fire_report.user_type' => '1'), '', array('Fire_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Fire_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Fire_report.*,('user') as type", 'Fire_report', array('Fire_report.user_id' => $_POST['user_id'], 'Fire_report.user_type' => '0'), '', array('Fire_report_id', 'DESC'), '', $dt);
			}
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Fire_reportFeedback', array('Fire_report_id' => $resmt['Fire_report_id']));

					if (!empty($check_feedbac)) {
						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);
							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Fire_report_id' => $resmt['Fire_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Fire_report_tym'],
						'date' => $resmt['Fire_report_Date'],
						'date_time' => $this->getDayNew($resmt['Fire_report_Date'] . ' ' . substr($resmt['Fire_report_tym'], 0, -3) . " " . substr($resmt['Fire_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Fire_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
					);
					array_push($newarr, $user_detail);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Accident()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/Accident/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/Accident/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Accident_report_Date' => $_POST['Date'],
					'Accident_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Accident_report_Date' => $_POST['Date'],
					'Accident_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Accident_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Accident', array($_POST['Name'], $reg_id, "26"), "5");

			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsAccident_report()
	{
		$page = (isset($_POST['page']) ? $_POST['page'] : '');
		$limit = (isset($_POST['limit']) ? $_POST['limit'] : '');
		$pagination = ''; //$this->paginat($limit, $page);
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Accident_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Accident_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Accident_report', array('Accident_report.user_id' => $_POST['user_id'], 'Accident_report.user_type' => '1'), '', array('Accident_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Accident_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Accident_report.*,('user') as type", 'Accident_report', array('Accident_report.user_id' => $_POST['user_id'], 'Accident_report.user_type' => '0'), '', array('Accident_report_id', 'DESC'), '', $dt);
			}
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Accident_reportFeedback', array('Accident_report_id' => $resmt['Accident_report_id']));

					if (!empty($check_feedbac)) {
						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);
							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Accident_report_id' => $resmt['Accident_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Accident_report_tym'],
						'date' => $resmt['Accident_report_Date'],
						'date_time' => $this->getDayNew($resmt['Accident_report_Date'] . ' ' . substr($resmt['Accident_report_tym'], 0, -3) . " " . substr($resmt['Accident_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Accident_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
					);
					array_push($newarr, $user_detail);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Medical()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/Medical/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/Medical/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Medical_report_Date' => $_POST['Date'],
					'Medical_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Medical_report_Date' => $_POST['Date'],
					'Medical_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Medical_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Medical', array($_POST['Name'], $reg_id, "27"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsMedical_report()
	{
		$page = (isset($_POST['page']) ? $_POST['page'] : '');
		$limit = (isset($_POST['limit']) ? $_POST['limit'] : '');
		$pagination = ''; //$this->paginat($limit, $page);
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Medical_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Medical_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Medical_report', array('Medical_report.user_id' => $_POST['user_id'], 'Medical_report.user_type' => '1'), '', array('Medical_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Medical_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Medical_report.*,('user') as type", 'Medical_report', array('Medical_report.user_id' => $_POST['user_id'], 'Medical_report.user_type' => '0'), '', array('Medical_report_id', 'DESC'), '', $dt);
			}
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Medical_reportFeedback', array('Medical_report_id' => $resmt['Medical_report_id']));

					if (!empty($check_feedbac)) {
						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);
							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Medical_report_id' => $resmt['Medical_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Medical_report_tym'],
						'date' => $resmt['Medical_report_Date'],
						'date_time' => $this->getDayNew($resmt['Medical_report_Date'] . ' ' . substr($resmt['Medical_report_tym'], 0, -3) . " " . substr($resmt['Medical_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Medical_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
					);
					array_push($newarr, $user_detail);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Riot()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/Riot/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/Riot/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Riot_report_Date' => $_POST['Date'],
					'Riot_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Riot_report_Date' => $_POST['Date'],
					'Riot_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Riot_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Roit', array($_POST['Name'], $reg_id, "28"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsRiot_report()
	{
		$page = (isset($_POST['page']) ? $_POST['page'] : '');
		$limit = (isset($_POST['limit']) ? $_POST['limit'] : '');
		$pagination = ''; //$this->paginat($limit, $page);
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Riot_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Riot_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Riot_report', array('Riot_report.user_id' => $_POST['user_id'], 'Riot_report.user_type' => '1'), '', array('Riot_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Riot_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Riot_report.*,('user') as type", 'Riot_report', array('Riot_report.user_id' => $_POST['user_id'], 'Riot_report.user_type' => '0'), '', array('Riot_report_id', 'DESC'), '', $dt);
			}
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Riot_reportFeedback', array('Riot_report_id' => $resmt['Riot_report_id']));

					if (!empty($check_feedbac)) {
						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);
							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Riot_report_id' => $resmt['Riot_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Riot_report_tym'],
						'date' => $resmt['Riot_report_Date'],
						'date_time' => $this->getDayNew($resmt['Riot_report_Date'] . ' ' . substr($resmt['Riot_report_tym'], 0, -3) . " " . substr($resmt['Riot_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Riot_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
					);
					array_push($newarr, $user_detail);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Environmental_Hazard()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/Environmental_Hazard/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/Environmental_Hazard/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Environmental_Hazard_report_Date' => $_POST['Date'],
					'Environmental_Hazard_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Environmental_Hazard_report_Date' => $_POST['Date'],
					'Environmental_Hazard_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Environmental_Hazard_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Environmental Hazard', array($_POST['Name'], $reg_id, "29"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsEnvironmental_Hazard_report()
	{
		$page = (isset($_POST['page']) ? $_POST['page'] : '');
		$limit = (isset($_POST['limit']) ? $_POST['limit'] : '');
		$pagination = ''; //$this->paginat($limit, $page);
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Environmental_Hazard_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Environmental_Hazard_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_id' => $_POST['user_id'], 'Environmental_Hazard_report.user_type' => '1'), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Environmental_Hazard_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Environmental_Hazard_report.*,('user') as type", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_id' => $_POST['user_id'], 'Environmental_Hazard_report.user_type' => '0'), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
			}
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Environmental_Hazard_reportFeedback', array('Environmental_Hazard_report_id' => $resmt['Environmental_Hazard_report_id']));

					if (!empty($check_feedbac)) {
						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);
							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Environmental_Hazard_report_id' => $resmt['Environmental_Hazard_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Environmental_Hazard_report_tym'],
						'date' => $resmt['Environmental_Hazard_report_Date'],
						'date_time' => $this->getDayNew($resmt['Environmental_Hazard_report_Date'] . ' ' . substr($resmt['Environmental_Hazard_report_tym'], 0, -3) . " " . substr($resmt['Environmental_Hazard_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Environmental_Hazard_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
					);
					array_push($newarr, $user_detail);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Child_Abuse()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/Child_Abuse/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/Child_Abuse/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Child_Abuse_report_Date' => $_POST['Date'],
					'Child_Abuse_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Child_Abuse_report_Date' => $_POST['Date'],
					'Child_Abuse_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Child_Abuse_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Child Abuse', array($_POST['Name'], $reg_id, "30"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsChild_Abuse_report()
	{
		$page = (isset($_POST['page']) ? $_POST['page'] : '');
		$limit = (isset($_POST['limit']) ? $_POST['limit'] : '');
		$pagination = ''; //$this->paginat($limit, $page);
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Child_Abuse_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Child_Abuse_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Child_Abuse_report', array('Child_Abuse_report.user_id' => $_POST['user_id'], 'Child_Abuse_report.user_type' => '1'), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Child_Abuse_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Child_Abuse_report.*,('user') as type", 'Child_Abuse_report', array('Child_Abuse_report.user_id' => $_POST['user_id'], 'Child_Abuse_report.user_type' => '0'), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
			}
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Child_Abuse_reportFeedback', array('Child_Abuse_report_id' => $resmt['Child_Abuse_report_id']));

					if (!empty($check_feedbac)) {
						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);
							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Child_Abuse_report_id' => $resmt['Child_Abuse_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Child_Abuse_report_tym'],
						'date' => $resmt['Child_Abuse_report_Date'],
						'date_time' => $this->getDayNew($resmt['Child_Abuse_report_Date'] . ' ' . substr($resmt['Child_Abuse_report_tym'], 0, -3) . " " . substr($resmt['Child_Abuse_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Child_Abuse_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
					);
					array_push($newarr, $user_detail);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function CreateVehicleProfile()
	{
		if (
			isset($_POST['Vehicle_make']) && isset($_POST['Vehicle_model']) && isset($_POST['user_id'])
			&& isset($_POST['Plate_Number']) && isset($_POST['Engine_Number']) && isset($_POST['Vehicle_Color']) && isset($_FILES['Proof_of_Ownership']['name'])
		) {

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}

				if (isset($_FILES['Proof_of_Ownership']['name'])) {
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';

					$config['encrypt_name'] = TRUE;
					$new_name = time() . $_FILES['Proof_of_Ownership']['name'];
					$config['file_name'] = $new_name;
					//Load upload library and initialize configuration
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('Proof_of_Ownership')) {
						$uploadData1 = $this->upload->data();
						$picture1 = $uploadData1['file_name'];
						$compeurl = base_url() . 'uploads/' . $picture1;
					} else {
						$compeurl = '';
					}
				}




				$user_detail = array(
					'Vehicle_uniquely' => substr(md5(time()), 0, 15),
					'Vehicle_make' => $_POST['Vehicle_make'],
					'Vehicle_model' => $_POST['Vehicle_model'],
					'Plate_Number' => $_POST['Plate_Number'],
					'Engine_Number' => $_POST['Engine_Number'],
					'Vehicle_Color' => $_POST['Vehicle_Color'],
					'Vehicle_img' => json_encode($images),
					'Proof_of_Ownership' => $compeurl,
					'user_id' => $_POST['user_id'],
					//'qrcodeimg' => base_url('images/').$file_name1,


				);
			} else {



				if (isset($_FILES['Proof_of_Ownership']['name'])) {
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';

					$config['encrypt_name'] = TRUE;
					$new_name = time() . $_FILES['Proof_of_Ownership']['name'];
					$config['file_name'] = $new_name;
					//Load upload library and initialize configuration
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('Proof_of_Ownership')) {
						$uploadData1 = $this->upload->data();
						$picture1 = $uploadData1['file_name'];
						$compeurl = base_url() . 'uploads/' . $picture1;
					} else {
						$compeurl = '';
					}
				}

				// 			    $qrtext='Vehicle_make=>'.$_POST['Vehicle_make'].
				//                  'Vehicle_model=>'.$_POST['Vehicle_model'].
				//                  'Plate_Number=>'.$_POST['Plate_Number'].
				//                  'Engine_Number=>'.$_POST['Engine_Number'].
				//                  'Vehicle_Color=>'.$_POST['Vehicle_Color'].
				//                  'Proof_of_Ownership=>'.$compeurl."<br>"

				//                  ;
				// 		    $SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'].'/Admin/images/';
				// 			$text = $qrtext;
				// 			$text1= substr($text, 0,9);

				// 			$folder = $SERVERFILEPATH;
				// 			$file_name1 = $text1."-Qrcode" . rand(2,200) . ".png";
				// 			$file_name = $folder.$file_name1;
				// 			QRcode::png($text,$file_name);
				$user_detail = array(
					'Vehicle_uniquely' => substr(md5(time()), 0, 15),
					'Vehicle_make' => $_POST['Vehicle_make'],
					'Vehicle_model' => $_POST['Vehicle_model'],
					'Plate_Number' => $_POST['Plate_Number'],
					'Engine_Number' => $_POST['Engine_Number'],
					'Vehicle_Color' => $_POST['Vehicle_Color'],
					'Proof_of_Ownership' => $compeurl,
					'user_id' => $_POST['user_id'],
					//'qrcodeimg' => base_url('images/').$file_name1,

				);
			}

			$reg_id = $this->beats_model->insert_data('Vehicle_Profile', $user_detail);

			$check_useruniq = $this->beats_model->select_data('*', 'Vehicle_Profile', array('Vehicle_id' => $reg_id));

			$qrtext = $check_useruniq['0']['Vehicle_uniquely'];
			$SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'] . '/Admin/images/';
			$text = $qrtext;
			$text1 = substr($text, 0, 9);

			$folder = $SERVERFILEPATH;
			$file_name1 = $text1 . "-Qrcode" . rand(2, 200) . ".png";
			$file_name = $folder . $file_name1;
			QRcode::png($text, $file_name);


			$res = $this->beats_model->update_data('Vehicle_Profile', array('qrcodeimg' => base_url('images/') . $file_name1), array('Vehicle_id' => $reg_id));

			echo json_encode(array('status' => true, 'message' => 'Successful vehicle id ' . $check_useruniq['0']['Vehicle_uniquely'], 'qrcodeimg' => base_url('images/') . $file_name1));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Human_Trafficking()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/Human_Trafficking/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/Human_Trafficking/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Human_Trafficking_report_Date' => $_POST['Date'],
					'Human_Trafficking_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Human_Trafficking_report_Date' => $_POST['Date'],
					'Human_Trafficking_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Human_Trafficking_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Human Trafficking', array($_POST['Name'], $reg_id, "31"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsHuman_Trafficking_report()
	{
		$page = (isset($_POST['page']) ? $_POST['page'] : '');
		$limit = (isset($_POST['limit']) ? $_POST['limit'] : '');
		$pagination = ''; //$this->paginat($limit, $page);
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Human_Trafficking_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Human_Trafficking_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Human_Trafficking_report', array('Human_Trafficking_report.user_id' => $_POST['user_id'], 'Human_Trafficking_report.user_type' => '1'), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Human_Trafficking_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Human_Trafficking_report.*,('user') as type", 'Human_Trafficking_report', array('Human_Trafficking_report.user_id' => $_POST['user_id'], 'Human_Trafficking_report.user_type' => '0'), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
			}
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Human_Trafficking_reportFeedback', array('Human_Trafficking_report_id' => $resmt['Human_Trafficking_report_id']));

					if (!empty($check_feedbac)) {
						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);
							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Human_Trafficking_report_id' => $resmt['Human_Trafficking_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Human_Trafficking_report_tym'],
						'date' => $resmt['Human_Trafficking_report_Date'],
						'date_time' => $this->getDayNew($resmt['Human_Trafficking_report_Date'] . ' ' . substr($resmt['Human_Trafficking_report_tym'], 0, -3) . " " . substr($resmt['Human_Trafficking_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Human_Trafficking_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
					);
					array_push($newarr, $user_detail);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Blow_Whistle()
	{
		if (isset($_POST['Name']) && isset($_POST['Complaint']) && isset($_POST['Date']) && isset($_POST['Time'])) {

			if (isset($_POST['user_type'])) {
				$usertype = $_POST['user_type'];
			} else {
				$usertype = 0;
			}
			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$images = array();
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/Blow_Whistle/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/Blow_Whistle/' . $picture;
					}
				}
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Blow_Whistle_report_Date' => $_POST['Date'],
					'Blow_Whistle_report_tym' => $_POST['Time'],
					'media' => json_encode($images),
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")
				);
			} else {
				$user_detail = array(
					'Name' => $_POST['Name'],
					'Complaint' => $_POST['Complaint'],
					'Blow_Whistle_report_Date' => $_POST['Date'],
					'Blow_Whistle_report_tym' => $_POST['Time'],
					'user_id' => $_POST['user_id'],
					'user_type' => $usertype,
					'GeoLocation' => $_POST['GeoLocation'],
					'GeoLocation_lat' => $_POST['GeoLocation_lat'],
					'GeoLocation_lag' => $_POST['GeoLocation_lag'],
					'created_at' => date("Y-m-d H:i:s"),
					'update_at' => date("Y-m-d H:i:s")

				);
			}
			$reg_id = $this->beats_model->insert_data('Blow_Whistle_report', $user_detail);
			$this->sendPushNotiNew('Filed Report Reported', 'Filed Report for Blow a Whistle', array($_POST['Name'], $reg_id, "32"), "5");
			echo json_encode(array('status' => true, 'message' => 'Successful.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function FiledReportsBlow_Whistle_report()
	{
		$page = (isset($_POST['page']) ? $_POST['page'] : '');
		$limit = (isset($_POST['limit']) ? $_POST['limit'] : '');
		$pagination = ''; //$this->paginat($limit, $page);
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Blow_Whistle_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Blow_Whistle_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Blow_Whistle_report', array('Blow_Whistle_report.user_id' => $_POST['user_id'], 'Blow_Whistle_report.user_type' => '1'), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Blow_Whistle_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Blow_Whistle_report.*,('user') as type", 'Blow_Whistle_report', array('Blow_Whistle_report.user_id' => $_POST['user_id'], 'Blow_Whistle_report.user_type' => '0'), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
			}

			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Blow_Whistle_reportFeedback', array('Blow_Whistle_report_id' => $resmt['Blow_Whistle_report_id']));

					if (!empty($check_feedbac)) {
						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);
							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Blow_Whistle_report_id' => $resmt['Blow_Whistle_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Blow_Whistle_report_tym'],
						'date' => $resmt['Blow_Whistle_report_Date'],
						'date_time' => $this->getDayNew($resmt['Blow_Whistle_report_Date'] . ' ' . substr($resmt['Blow_Whistle_report_tym'], 0, -3) . " " . substr($resmt['Blow_Whistle_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Blow_Whistle_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
					);
					array_push($newarr, $user_detail);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function CreatePropertyProfile()
	{
		if (
			isset($_POST['Property_type']) && isset($_POST['Serial_Number']) && isset($_POST['user_id'])
			&& isset($_POST['Brand']) && isset($_POST['Color'])  && isset($_FILES['Proof_of_Ownership']['name'])
		) {
			$images = array();

			if (!empty($_FILES['userfile']['name']['0'])) {
				$files = $_FILES;
				$count = count($_FILES['userfile']['name']);
				for ($i = 0; $i < $count; $i++) {
					$_FILES['userfile']['name'] = time() . $files['userfile']['name'][$i];
					$_FILES['userfile']['type'] = $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error'] = $files['userfile']['error'][$i];
					$_FILES['userfile']['size'] = $files['userfile']['size'][$i];
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
					$config['max_size'] = '';
					$config['remove_spaces'] = true;
					$config['overwrite'] = false;
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload()) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$fileName = time() . $files['userfile']['name'][$i];
						$images[] = base_url() . 'uploads/' . $picture;
					}
				}


				if (isset($_FILES['Proof_of_Ownership']['name'])) {
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';

					$config['encrypt_name'] = TRUE;
					$new_name = time() . $_FILES['Proof_of_Ownership']['name'];
					$config['file_name'] = $new_name;
					//Load upload library and initialize configuration
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('Proof_of_Ownership')) {
						$uploadData1 = $this->upload->data();
						$picture1 = $uploadData1['file_name'];
						$compeurl = base_url() . 'uploads/' . $picture1;
					} else {
						$compeurl = '';
					}
				}


				$user_detail = array(
					'property_uniquely' => substr(md5(time()), 0, 15),
					'Property_type' => $_POST['Property_type'],
					'Serial_Number' => $_POST['Serial_Number'],
					'Brand' => $_POST['Brand'],
					'Color' => $_POST['Color'],
					'Property_img' => json_encode($images),
					'Proof_of_Ownership' => $compeurl,
					'user_id' => $_POST['user_id'],
					//'qrcodeimg' => base_url('images/').$file_name1,


				);
			} else {

				if (isset($_FILES['Proof_of_Ownership']['name'])) {
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';

					$config['encrypt_name'] = TRUE;
					$new_name = time() . $_FILES['Proof_of_Ownership']['name'];
					$config['file_name'] = $new_name;
					//Load upload library and initialize configuration
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('Proof_of_Ownership')) {
						$uploadData1 = $this->upload->data();
						$picture1 = $uploadData1['file_name'];
						$compeurl = base_url() . 'uploads/' . $picture1;
					} else {
						$compeurl = '';
					}
				}

				// 			         $qrtext='Property_type=>'.$_POST['Property_type'].
				//                  'Serial_Number=>'.$_POST['Serial_Number'].
				//                  'Brand=>'.$_POST['Brand'].
				//                  'Color=>'.$_POST['Color'].
				//                  //'Property_img=>'.json_encode($images).
				//                  'Proof_of_Ownership=>'.$compeurl."<br>"

				//                  ;
				// 		    $SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'].'/Admin/images/';
				// 			$text = $qrtext;
				// 			$text1= substr($text, 0,9);

				// 			$folder = $SERVERFILEPATH;
				// 			$file_name1 = $text1."-Qrcode" . rand(2,200) . ".png";
				// 			$file_name = $folder.$file_name1;
				// 			QRcode::png($text,$file_name);
				$user_detail = array(
					'property_uniquely' => substr(md5(time()), 0, 15),
					'Property_type' => $_POST['Property_type'],
					'Serial_Number' => $_POST['Serial_Number'],
					'Brand' => $_POST['Brand'],
					'Color' => $_POST['Color'],
					'Proof_of_Ownership' => $compeurl,
					'user_id' => $_POST['user_id'],
					//'qrcodeimg' => base_url('images/').$file_name1,

				);
			}

			$reg_id = $this->beats_model->insert_data('Property_Profile', $user_detail);

			$check_useruniq = $this->beats_model->select_data('*', 'Property_Profile', array('Property_id' => $reg_id));

			$qrtext = $check_useruniq['0']['property_uniquely'];

			//$qrtext=$reg_id;
			$SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'] . '/Admin/images/';
			$text = $qrtext;
			$text1 = substr($text, 0, 9);

			$folder = $SERVERFILEPATH;
			$file_name1 = $text1 . "-Qrcode" . rand(2, 200) . ".png";
			$file_name = $folder . $file_name1;
			QRcode::png($text, $file_name);


			$res = $this->beats_model->update_data('Property_Profile', array('qrcodeimg' => base_url('images/') . $file_name1), array('Property_id' => $reg_id));
			echo json_encode(array('status' => true, 'message' => 'Successful Property id ' . $check_useruniq['0']['property_uniquely'], 'qrcodeimg' => base_url('images/') . $file_name1));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}


	public function PropertyList()
	{
		if (isset($_POST['user_id'])) {
			//$dt=array('multiple',array(array('user_signup','user_signup.user_id=Pitch.user_id')));
			$check_user = $this->beats_model->select_data('*', 'Property_Profile', array('user_id' => $_POST['user_id']), '', array('Property_id', 'DESC'));


			//$check_user =  $this->beats_model->select_data('*','Pitch');

			if (!empty($check_user)) {

				$newarr = array();
				foreach ($check_user as $resmt) {

					if (!empty($resmt['Property_img'])) {
						$newimg = json_decode($resmt['Property_img']);
						$imgarray = array();
						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}

					$properytyd = $this->beats_model->select_data('*', 'Propertytype', array('Propertytype_id' => $resmt['Property_type']));
					$user_detail = array(
						'property_uniquely' => $resmt['property_uniquely'],
						'Property_id' => $resmt['Property_id'],
						'Property_name' => $properytyd['0']['type_name'],
						'user_id' => $resmt['user_id'],
						'Property_type' => $resmt['Property_type'],
						'Serial_Number' => $resmt['Serial_Number'],
						'qrcodeimg' => $resmt['qrcodeimg'],
						'Brand' => $resmt['Brand'],
						'Color' => $resmt['Color'],
						'Proof_of_Ownership' => $resmt['Proof_of_Ownership'],
						'images' => $imgarray,


					);
					array_push($newarr, $user_detail);
				}






				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {


				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function PropertyListSearch()
	{
		if (isset($_POST['Property_id'])) {
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Property_Profile.user_id')));
			$check_user = $this->beats_model->select_data('Property_Profile.*,user_signup.*', 'Property_Profile', array('Property_Profile.property_uniquely' => $_POST['Property_id']), '', '', '', $dt);


			//$check_user =  $this->beats_model->select_data('*','Pitch');

			if (!empty($check_user)) {

				$newarr = array();
				foreach ($check_user as $resmt) {

					if (!empty($resmt['Property_img'])) {
						$newimg = json_decode($resmt['Property_img']);
						if (!empty($newimg)) {
							$imgarray = array();
							foreach ($newimg as $itm) {
								$user_img = array(
									'image' => $itm,
								);
								array_push($imgarray, $user_img);
							}
							$nefimeimg = implode(',', $newimg);
						} else {
							$nefimeimg = "";
						}
					} else {
						$imgarray = array();
					}

					$properytyd = $this->beats_model->select_data('*', 'Propertytype', array('Propertytype_id' => $resmt['Property_type']));
					$user_detail = array(
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
						'Property_id' => $resmt['Property_id'],
						'property_uniquely' => $resmt['property_uniquely'],
						'Property_name' => $properytyd['0']['type_name'],
						'user_id' => $resmt['user_id'],
						'Property_type' => $resmt['Property_type'],
						'Serial_Number' => $resmt['Serial_Number'],
						'qrcodeimg' => $resmt['qrcodeimg'],
						'Brand' => $resmt['Brand'],
						'Color' => $resmt['Color'],
						'Proof_of_Ownership' => $resmt['Proof_of_Ownership'],
						'images' => $imgarray,


					);
					array_push($newarr, $user_detail);
				}






				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {


				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function VehicleListsearch()
	{
		if (isset($_POST['Vehicle_id'])) {
			//$dt=array('multiple',array(array('user_signup','user_signup.user_id=Pitch.user_id')));
			// $check_user = $this->beats_model->select_data('*' , 'Vehicle_Profile',array('Vehicle_id'=>$_POST['Vehicle_id']));
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vehicle_Profile.user_id')));
			$check_user = $this->beats_model->select_data('Vehicle_Profile.*,user_signup.*', 'Vehicle_Profile', array('Vehicle_Profile.Vehicle_uniquely' => $_POST['Vehicle_id']), '', '', '', $dt);


			//$check_user =  $this->beats_model->select_data('*','Pitch');

			if (!empty($check_user)) {

				$newarr = array();
				foreach ($check_user as $resmt) {

					//    if(!empty($resmt['Vehicle_img'])){
					//   $newimg=json_decode($resmt['Vehicle_img']);
					//             $nefimeimg=implode(',',$newimg);
					//   }else{
					//       $nefimeimg="";
					//   }
					if (!empty($resmt['Vehicle_img'])) {
						$newimg = json_decode($resmt['Vehicle_img']);
						if (!empty($newimg)) {
							$imgarray = array();
							foreach ($newimg as $itm) {
								$user_img = array(
									'image' => $itm,
								);
								array_push($imgarray, $user_img);
							}
							$nefimeimg = implode(',', $newimg);
						} else {
							$nefimeimg = "";
						}
					} else {
						$imgarray = array();
					}

					$user_detail = array(
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
						'Vehicle_uniquely' => $resmt['Vehicle_uniquely'],
						'Vehicle_id' => $resmt['Vehicle_id'],
						'user_id' => $resmt['user_id'],
						'Vehicle_make' => $resmt['Vehicle_make'],
						'Vehicle_model' => $resmt['Vehicle_model'],
						'Plate_Number' => $resmt['Plate_Number'],
						'qrcodeimg' => $resmt['qrcodeimg'],
						'Engine_Number' => $resmt['Engine_Number'],	'Vehicle_Color' => $resmt['Vehicle_Color'],
						'Proof_of_Ownership' => $resmt['Proof_of_Ownership'],
						'images' => $imgarray,


					);
					array_push($newarr, $user_detail);
				}






				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {


				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function VehicleList()
	{
		if (isset($_POST['user_id'])) {
			//$dt=array('multiple',array(array('user_signup','user_signup.user_id=Pitch.user_id')));
			$check_user = $this->beats_model->select_data('*', 'Vehicle_Profile', array('user_id' => $_POST['user_id']), '', array('Vehicle_id', 'DESC'));


			//$check_user =  $this->beats_model->select_data('*','Pitch');

			if (!empty($check_user)) {

				$newarr = array();
				foreach ($check_user as $resmt) {

					//    if(!empty($resmt['Vehicle_img'])){
					//   $newimg=json_decode($resmt['Vehicle_img']);
					//             $nefimeimg=implode(',',$newimg);
					//   }else{
					//       $nefimeimg="";
					//   }
					if (!empty($resmt['Vehicle_img'])) {
						$newimg = json_decode($resmt['Vehicle_img']);
						$imgarray = array();
						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}

					$user_detail = array(
						'Vehicle_uniquely' => $resmt['Vehicle_uniquely'],
						'Vehicle_id' => $resmt['Vehicle_id'],
						'user_id' => $resmt['user_id'],
						'Vehicle_make' => $resmt['Vehicle_make'],
						'Vehicle_model' => $resmt['Vehicle_model'],
						'Plate_Number' => $resmt['Plate_Number'],
						'qrcodeimg' => $resmt['qrcodeimg'],
						'Engine_Number' => $resmt['Engine_Number'],	'Vehicle_Color' => $resmt['Vehicle_Color'],
						'Proof_of_Ownership' => $resmt['Proof_of_Ownership'],
						'images' => $imgarray,


					);
					array_push($newarr, $user_detail);
				}






				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {


				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Nearby()
	{
		if (isset($_POST['UnitType']) && isset($_POST['Latitude']) && isset($_POST['Longitude'])) {
			//$check_user = $this->beats_model->select_data('*' , 'PoliceUnit',array('UnitType'=>$_POST['UnitType']),'',array('PoliceUnit_id','DESC'));
			echo $this->Nearbyunit($_POST['Latitude'], $_POST['Longitude'], $_POST['UnitType']);

			// 			if(!empty($check_user)){
			//       	echo json_encode(array('status' => true , 'message' => 'Successful.', 'Details' => $check_user));
			// 			}else{


			// 					echo json_encode(array('status' => true , 'message' => 'No data found.'));
			// 			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function FiledReportsiWitnessNew()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=iWitness.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,iWitness.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'iWitness', array('iWitness.user_id' => $_POST['user_id'], 'iWitness.user_type' => '1'), '', array('iWitness_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,iWitness.*,('user') as type", 'iWitness', array('iWitness.user_id' => $_POST['user_id'], 'iWitness.user_type' => '0'), '', array('iWitness_id', 'DESC'), '', $dt);
			}

			// $check_user = $this->beats_model->select_data('*' , 'iWitness','','',array('iWitness_id','DESC'));
			if (!empty($check_user)) {
				$newarr = array();
				$mostRecent1 = 0;
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['Media']))) {
						$newimg = json_decode($resmt['Media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}

					$check_feedbac = $this->beats_model->select_data('*', 'iWitnessFeedback', array('iWitness_id' => $resmt['iWitness_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							// user_officer_meta
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}

					$user_detail = array(
						'iWitness_id' => $resmt['iWitness_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['iWitness_tym'],
						'date' => $resmt['iWitness_date'],
						'date_time' => $this->getDayNew($resmt['iWitness_date'] . ' ' . substr($resmt['iWitness_tym'], 0, -3) . " " . substr($resmt['iWitness_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
						'Status ' => $resmt['iWitness_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),


					);
					array_push($newarr, $user_detail);

					// $curDate = strtotime($user_detail['date_time']);
					// echo '========'.date('l d/m/Y h:i A',$curDate);

					//               if ($curDate > $mostRecent1) {
					//                 $mostRecent1 = $curDate;
					//                 echo '-----'.date('l d/m/Y h:i A',$mostRecent1);
					//   }
				}
				//   $mostRecent = date('l d/m/Y h:i A',$mostRecent1);
				// usort($newarr, 'date_compare');

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'mostRecent' => $newarr[0]['date_time'], 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	function date_compare($a, $b)
	{
		$t1 = strtotime($a['date_time']);
		$t2 = strtotime($b['date_time']);
		// return $t1 - $t2;
		return $t1 < $t2 ? -1 : 1;
	}

	public function FiledReportsiWitness()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=iWitness.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,iWitness.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'iWitness', array('iWitness.user_id' => $_POST['user_id'], 'iWitness.user_type' => '1'), '', array('iWitness_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,iWitness.*,('user') as type", 'iWitness', array('iWitness.user_id' => $_POST['user_id'], 'iWitness.user_type' => '0'), '', array('iWitness_id', 'DESC'), '', $dt);
			}

			// $check_user = $this->beats_model->select_data('*' , 'iWitness','','',array('iWitness_id','DESC'));
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['Media']))) {
						$newimg = json_decode($resmt['Media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						// $nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}

					$check_feedbac = $this->beats_model->select_data('*', 'iWitnessFeedback', array('iWitness_id' => $resmt['iWitness_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							// user_officer_meta
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}

					$user_detail = array(
						'iWitness_id' => $resmt['iWitness_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['iWitness_tym'],
						'date' => $resmt['iWitness_date'],
						'date_time' => $this->getDayNew($resmt['iWitness_date'] . ' ' . substr($resmt['iWitness_tym'], 0, -3) . " " . substr($resmt['iWitness_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
						'Status ' => $resmt['iWitness_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),



					);
					array_push($newarr, $user_detail);
				}
				// usort($newarr, 'date_compare');
				// echo json_encode(array('status' => true, 'message' => 'Successful.','mostRecent'=>$newarr[0]['date_time'], 'Details' => $newarr));
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsOfficer_Abuse()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Officer_Abuse.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Officer_Abuse.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Officer_Abuse', array('Officer_Abuse.user_id' => $_POST['user_id'], 'Officer_Abuse.user_type' => '1'), '', array('OfficerAbuse_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Officer_Abuse.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Officer_Abuse.*,('user') as type", 'Officer_Abuse', array('Officer_Abuse.user_id' => $_POST['user_id'], 'Officer_Abuse.user_type' => '0'), '', array('OfficerAbuse_id', 'DESC'), '', $dt);
			}


			// $check_user = $this->beats_model->select_data('*' , 'Officer_Abuse','','',array('OfficerAbuse_id','DESC'));
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['Media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}

					$check_feedbac = $this->beats_model->select_data('*', 'Officer_AbuseFeedback', array('OfficerAbuse_id' => $resmt['OfficerAbuse_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}

					$user_detail = array(
						'OfficerAbuse_id' => $resmt['OfficerAbuse_id'],
						'Description' => $resmt['Description'],
						'Officer_name' => $resmt['Officer_name'],
						'Location' => $resmt['Location'],
						'time' => $resmt['OfficerAbuse_tym'],
						'date' => $resmt['OfficerAbuse_date'],
						'date_time' => $this->getDayNew($resmt['OfficerAbuse_date'] . ' ' . substr($resmt['OfficerAbuse_tym'], 0, -3) . " " . substr($resmt['OfficerAbuse_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['OfficerAbuse_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],


					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsCommend_Officer()
	{

		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Commend_Officer.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Commend_Officer.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Commend_Officer', array('Commend_Officer.user_id' => $_POST['user_id'], 'Commend_Officer.user_type' => '1'), '', array('CommendOffice_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Commend_Officer.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Commend_Officer.*,('user') as type", 'Commend_Officer', array('Commend_Officer.user_id' => $_POST['user_id'], 'Commend_Officer.user_type' => '0'), '', array('CommendOffice_id', 'DESC'), '', $dt);
			}

			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['Media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Commend_OfficerFeedback', array('CommendOffice_id' => $resmt['CommendOffice_id']));

					if (!empty($check_feedbac)) {


						$feedback = array();

						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'CommendOffice_id' => $resmt['CommendOffice_id'],
						'Description' => $resmt['Description'],
						'Officer_name' => $resmt['Officer_name'],
						'Location' => $resmt['Location'],
						'time' => $resmt['CommendOffice_tym'],
						'date' => $resmt['CommendOffice_date'],
						'date_time' => $this->getDayNew($resmt['CommendOffice_date'] . ' ' . substr($resmt['CommendOffice_tym'], 0, -3) . " " . substr($resmt['CommendOffice_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['CommendOffice_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],


					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsStolenVehicle_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=StolenVehicle_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,StolenVehicle_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'StolenVehicle_report', array('StolenVehicle_report.user_id' => $_POST['user_id'], 'StolenVehicle_report.user_type' => '1'), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=StolenVehicle_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,StolenVehicle_report.*,('user') as type", 'StolenVehicle_report', array('StolenVehicle_report.user_id' => $_POST['user_id'], 'StolenVehicle_report.user_type' => '0'), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
			}

			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();
						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'StolenVehicle_reportFeedback', array('StolenVehicle_report_id' => $resmt['StolenVehicle_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'StolenVehicle_report_id' => $resmt['StolenVehicle_report_id'],
						'Vehicle_make' => $resmt['Vehicle_make'],
						'Vehicle_model' => $resmt['Vehicle_model'],
						'Vehicle_year' => $resmt['Vehicle_year'],
						'Vehicle_lastlocation' => $resmt['Vehicle_lastlocation'],
						'Plate_Number' => $resmt['Plate_Number'],
						'Engine_Number' => $resmt['Engine_Number'],
						'Vehicle_Color' => $resmt['Vehicle_Color'],
						'time' => $resmt['StolenVehicle_report_tym'],
						'date' => $resmt['StolenVehicle_report_date'],
						'date_time' => $this->getDayNew($resmt['StolenVehicle_report_date'] . ' ' . substr($resmt['StolenVehicle_report_tym'], 0, -3) . " " . substr($resmt['StolenVehicle_report_tym'], -2, 5)),
						'media' => $imgarray,
						'StolenVehicle_report_status' => $resmt['StolenVehicle_report_status'],
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['StolenVehicle_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],


					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsMissing_Persons_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				// $dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Missing_Persons_report.user_id')));
				// $check_user = $this->beats_model->select_data("Officer.*,Missing_Persons_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Missing_Persons_report', array('Missing_Persons_report.user_id' => $_POST['user_id'], 'Missing_Persons_report.user_type' => '1'), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Missing_Persons_report.user_id')));
				$check_user = $this->beats_model->select_data('Officer.*,Missing_Persons_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Missing_Persons_report', array('Missing_Persons_report.user_id' => $_POST['user_id'], 'Missing_Persons_report.user_type' => '1'), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Missing_Persons_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Missing_Persons_report.*,('user') as type", 'Missing_Persons_report', array('Missing_Persons_report.user_id' => $_POST['user_id'], 'Missing_Persons_report.user_type' => '0'), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
			}
			
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Missing_Persons_reportFeedback', array('Missing_Persons_report_id' => $resmt['Missing_Persons_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Missing_Persons_report_id' => $resmt['Missing_Persons_report_id'],
						'Full_Name' => $resmt['Full_Name'],
						'Age' => $resmt['Age'],
						'Sex' => $resmt['Sex'],
						'Description' => $resmt['Description'],
						'Last_Seen_Location' => $resmt['Last_Seen_Location'],
						'Spoken_Language' => $resmt['Spoken_Language'],
						'time' => $resmt['Missing_Persons_report_tym'],
						'date' => $resmt['Missing_Persons_report_Date'],
						'date_time' => $this->getDayNew($resmt['Missing_Persons_report_Date'] . ' ' . substr($resmt['Missing_Persons_report_tym'], 0, -3) . " " . substr($resmt['Missing_Persons_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Missing_Persons_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],


					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsLodgecomplaint_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Lodgecomplaint_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Lodgecomplaint_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_id' => $_POST['user_id'], 'Lodgecomplaint_report.user_type' => '1'), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Lodgecomplaint_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Lodgecomplaint_report.*,('user') as type", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_id' => $_POST['user_id'], 'Lodgecomplaint_report.user_type' => '0'), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
			}

			// $check_user = $this->beats_model->select_data('*' , 'Lodgecomplaint_report','','',array('Lodgecomplaint_report_id','DESC'));
			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Lodgecomplaint_reportFeedback', array('Lodgecomplaint_report_id' => $resmt['Lodgecomplaint_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Lodgecomplaint_report_id' => $resmt['Lodgecomplaint_report_id'],
						'Name' => $resmt['Name'],
						'Description' => $resmt['Complaint'],
						'time' => $resmt['Lodgecomplaint_report_tym'],
						'date' => $resmt['Lodgecomplaint_report_Date'],
						'date_time' => $this->getDayNew($resmt['Lodgecomplaint_report_Date'] . ' ' . substr($resmt['Lodgecomplaint_report_tym'], 0, -3) . " " . substr($resmt['Lodgecomplaint_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Lodgecomplaint_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],
						'Location' => $resmt['Location'],


					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsGun_Violence_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Gun_Violence_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Gun_Violence_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Gun_Violence_report', array('Gun_Violence_report.user_id' => $_POST['user_id'], 'Gun_Violence_report.user_type' => '1'), '', array('GunViolence_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Gun_Violence_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Gun_Violence_report.*,('user') as type", 'Gun_Violence_report', array('Gun_Violence_report.user_id' => $_POST['user_id'], 'Gun_Violence_report.user_type' => '0'), '', array('GunViolence_id', 'DESC'), '', $dt);
			}



			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Gun_Violence_reportFeedback', array('GunViolence_id' => $resmt['GunViolence_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'GunViolence_id' => $resmt['GunViolence_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['GunViolence_tym'],
						'date' => $resmt['GunViolence_Date'],
						'date_time' => $this->getDayNew($resmt['GunViolence_Date'] . ' ' . substr($resmt['GunViolence_tym'], 0, -3) . " " . substr($resmt['GunViolence_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['GunViolence_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],


					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsDrug_Abuse_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Drug_Abuse_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Drug_Abuse_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Drug_Abuse_report', array('Drug_Abuse_report.user_id' => $_POST['user_id'], 'Drug_Abuse_report.user_type' => '1'), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Drug_Abuse_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Drug_Abuse_report.*,('user') as type", 'Drug_Abuse_report', array('Drug_Abuse_report.user_id' => $_POST['user_id'], 'Drug_Abuse_report.user_type' => '0'), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
			}


			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Drug_Abuse_reportFeedback', array('DrugAbuse_report_id' => $resmt['DrugAbuse_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'DrugAbuse_report_id' => $resmt['DrugAbuse_report_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['tym'],
						'date' => $resmt['Date'],
						'date_time' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['DrugAbuse_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],



					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsDomestic_Violence_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Domestic_Violence_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Domestic_Violence_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Domestic_Violence_report', array('Domestic_Violence_report.user_id' => $_POST['user_id'], 'Domestic_Violence_report.user_type' => '1'), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Domestic_Violence_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Domestic_Violence_report.*,('user') as type", 'Domestic_Violence_report', array('Domestic_Violence_report.user_id' => $_POST['user_id'], 'Domestic_Violence_report.user_type' => '0'), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
			}


			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Domestic_Violence_reportFeedback', array('DomesticViolence_report_id' => $resmt['DomesticViolence_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'GunViolence_id' => $resmt['DomesticViolence_report_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['tym'],
						'date' => $resmt['Date'],
						'date_time' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['DomesticViolence_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],



					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsTerrorist_Attack_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Terrorist_Attack_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Terrorist_Attack_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Terrorist_Attack_report', array('Terrorist_Attack_report.user_id' => $_POST['user_id'], 'Terrorist_Attack_report.user_type' => '1'), '', array('TerroristAttack_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Terrorist_Attack_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Terrorist_Attack_report.*,('user') as type", 'Terrorist_Attack_report', array('Terrorist_Attack_report.user_id' => $_POST['user_id'], 'Terrorist_Attack_report.user_type' => '0'), '', array('TerroristAttack_report_id', 'DESC'), '', $dt);
			}


			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Terrorist_Attack_reportFeedback', array('TerroristAttack_report_id' => $resmt['TerroristAttack_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'TerroristAttack_report_id' => $resmt['TerroristAttack_report_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['tym'],
						'date' => $resmt['Date'],
						'date_time' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['TerroristAttack_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],



					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsRape_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Rape_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Rape_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Rape_report', array('Rape_report.user_id' => $_POST['user_id'], 'Rape_report.user_type' => '1'), '', array('Rape_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Rape_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Rape_report.*,('user') as type", 'Rape_report', array('Rape_report.user_id' => $_POST['user_id'], 'Rape_report.user_type' => '0'), '', array('Rape_report_id', 'DESC'), '', $dt);
			}



			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if(!empty(json_decode($resmt['media']))){
					  $newimg=json_decode($resmt['media']);
					 $imgarray=array();

					  foreach($newimg as $itm){
					       $user_img = array(
						'image' =>$itm,
						);
						array_push($imgarray,$user_img);
					  }
					            $nefimeimg=implode(',',$newimg);
					  }else{
					        $imgarray=array();
					  }

					$check_feedbac = $this->beats_model->select_data('*', 'Rape_reportFeedback', array('Rape_report_id' => $resmt['Rape_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Rape_report_id' => $resmt['Rape_report_id'],
						'Victim_Name' => $resmt['Victim_Name'],
						'Age' => $resmt['Age'],
						'Sex' => $resmt['Sex'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['Rape_report_tym'],
						'date' => $resmt['Rape_report_Date'],
						'date_time' => $this->getDayNew($resmt['Rape_report_Date'] . ' ' . substr($resmt['Rape_report_tym'], 0, -3) . " " . substr($resmt['Rape_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Rape_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],



					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsKidnap_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				// $dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Kidnap_report.user_id')));
				// $check_user = $this->beats_model->select_data("Officer.*,Kidnap_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Kidnap_report', array('Kidnap_report.user_id' => $_POST['user_id'], 'Kidnap_report.user_type' => '1'), '', array('Kidnap_report_id', 'DESC'), '', $dt);
			
				$date_s = "Kidnap_report.user_type = '1' and Kidnap_report.user_id = '".$_POST['user_id']."'";
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Kidnap_report.user_id')));
				$check_user = $this->beats_model->select_data('Officer.*,Kidnap_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'), '', $dt);
				
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Kidnap_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Kidnap_report.*,('user') as type", 'Kidnap_report', array('Kidnap_report.user_id' => $_POST['user_id'], 'Kidnap_report.user_type' => '0'), '', array('Kidnap_report_id', 'DESC'), '', $dt);
			}
			



			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Kidnap_reportFeedback', array('Kidnap_report_id' => $resmt['Kidnap_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Kidnap_report_id' => $resmt['Kidnap_report_id'],
						'Full_Name' => $resmt['Full_Name'],
						'Age' => $resmt['Age'],
						'Sex' => $resmt['Sex'],
						'Description' => $resmt['Description'],
						'Last_Seen_Location' => $resmt['Last_Seen_Location'],
						'Spoken_Language' => $resmt['Spoken_Language'],
						'time' => $resmt['Kidnap_report_tym'],
						'date' => $resmt['Kidnap_report_Date'],
						'date_time' => $this->getDayNew($resmt['Kidnap_report_Date'] . ' ' . substr($resmt['Kidnap_report_tym'], 0, -3) . " " . substr($resmt['Kidnap_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Kidnap_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],



					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsRobbery_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Robbery_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Robbery_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Robbery_report', array('Robbery_report.user_id' => $_POST['user_id'], 'Robbery_report.user_type' => '1'), '', array('Robbery_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Robbery_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Robbery_report.*,('user') as type", 'Robbery_report', array('Robbery_report.user_id' => $_POST['user_id'], 'Robbery_report.user_type' => '0'), '', array('Robbery_report_id', 'DESC'), '', $dt);
			}


			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Robbery_reportFeedback', array('Robbery_report_id' => $resmt['Robbery_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Robbery_report_id' => $resmt['Robbery_report_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'Items' => $resmt['Items'],
						'time' => $resmt['Robbery_report_tym'],
						'date' => $resmt['Robbery_report_Date'],
						'date_time' => $this->getDayNew($resmt['Robbery_report_Date'] . ' ' . substr($resmt['Robbery_report_tym'], 0, -3) . " " . substr($resmt['Robbery_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Robbery_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],



					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsBurglary_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Burglary_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Burglary_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Burglary_report', array('Burglary_report.user_id' => $_POST['user_id'], 'Burglary_report.user_type' => '1'), '', array('Burglary_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Burglary_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Burglary_report.*,('user') as type", 'Burglary_report', array('Burglary_report.user_id' => $_POST['user_id'], 'Burglary_report.user_type' => '0'), '', array('Burglary_report_id', 'DESC'), '', $dt);
			}


			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Burglary_reportFeedback', array('Burglary_report_id' => $resmt['Burglary_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Burglary_report_id' => $resmt['Burglary_report_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'Items' => $resmt['Items'],
						'time' => $resmt['Burglary_report_tym'],
						'date' => $resmt['Burglary_report_Date'],
						'date_time' => $this->getDayNew($resmt['Burglary_report_Date'] . ' ' . substr($resmt['Burglary_report_tym'], 0, -3) . " " . substr($resmt['Burglary_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Burglary_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],


					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsCybercrimeFraud_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {
			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=CybercrimeFraud_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,CybercrimeFraud_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'CybercrimeFraud_report', array('CybercrimeFraud_report.user_id' => $_POST['user_id'], 'CybercrimeFraud_report.user_type' => '1'), '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=CybercrimeFraud_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,CybercrimeFraud_report.*,('user') as type", 'CybercrimeFraud_report', array('CybercrimeFraud_report.user_id' => $_POST['user_id'], 'CybercrimeFraud_report.user_type' => '0'), '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);
			}



			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'CybercrimeFraud_reportFeedback', array('CybercrimeFraud_report_id' => $resmt['CybercrimeFraud_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'CybercrimeFraud_report_id' => $resmt['CybercrimeFraud_report_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['CybercrimeFraud_report_tym'],
						'date' => $resmt['CybercrimeFraud_report_Date'],
						'date_time' => $this->getDayNew($resmt['CybercrimeFraud_report_Date'] . ' ' . substr($resmt['CybercrimeFraud_report_tym'], 0, -3) . " " . substr($resmt['CybercrimeFraud_report_tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['CybercrimeFraud_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],



					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsSubmit_Tip_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Submit_Tip_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Submit_Tip_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Submit_Tip_report', array('Submit_Tip_report.user_id' => $_POST['user_id'], 'Submit_Tip_report.user_type' => '1'), '', array('Submit_Tip_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Submit_Tip_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Submit_Tip_report.*,('user') as type", 'Submit_Tip_report', array('Submit_Tip_report.user_id' => $_POST['user_id'], 'Submit_Tip_report.user_type' => '0'), '', array('Submit_Tip_id', 'DESC'), '', $dt);
			}



			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Submit_Tip_reportFeedback', array('Submit_Tip_id' => $resmt['Submit_Tip_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Submit_Tip_id' => $resmt['Submit_Tip_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['tym'],
						'date' => $resmt['Date'],
						'date_time' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Submit_Tip_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],



					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsOthers_report()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_type'])) {

			if ($_POST['user_type'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Others_report.user_id')));
				$check_user = $this->beats_model->select_data("Officer.*,Others_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Others_report', array('Others_report.user_id' => $_POST['user_id'], 'Others_report.user_type' => '1'), '', array('Others_report_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Others_report.user_id')));
				$check_user = $this->beats_model->select_data("user_signup.*,Others_report.*,('user') as type", 'Others_report', array('Others_report.user_id' => $_POST['user_id'], 'Others_report.user_type' => '0'), '', array('Others_report_id', 'DESC'), '', $dt);
			}



			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					if (!empty(json_decode($resmt['media']))) {
						$newimg = json_decode($resmt['media']);
						$imgarray = array();

						foreach ($newimg as $itm) {
							$user_img = array(
								'image' => $itm,
							);
							array_push($imgarray, $user_img);
						}
						$nefimeimg = implode(',', $newimg);
					} else {
						$imgarray = array();
					}
					$check_feedbac = $this->beats_model->select_data('*', 'Others_reportFeedback', array('Others_report_id' => $resmt['Others_report_id']));

					if (!empty($check_feedbac)) {



						$feedback = array();
						foreach ($check_feedbac as $feed) {
							$feedname = '';
							$rank = '';
							$agency = '';
							if ($feed['user_type'] != 0) {
								$check_name = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $feed['user_type']));
								$feedname = $check_name[0]['Full_Name'];
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
								$rank = $check_name[0]['Rank'];
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							} else {
								$feedname = 'Admin';
								$rank = '';
								$agency = '';
							}
							$newimg1 = json_decode($feed['feedbackMedia']);

							if (!empty($newimg1)) {
								$imgarray1 = array();
								foreach ($newimg1 as $itm1) {
									$user_img1 = array(
										'image' => $itm1,
									);
									array_push($imgarray1, $user_img1);
								}
							} else {
								$imgarray1 = array();
							}
							$userfeedd = array(
								'feedback' => $feed['feedback'],
								'name' => $feedname,
								'rank' => $rank,
								'agency' => $agency,
								'date_time' => $this->getDayNew($feed['feedback_date']),
								'date' => $feed['feedback_date'],
								'image' => $imgarray1,
							);
							array_push($feedback, $userfeedd);
						}
					} else {
						$imgarray1 = array();
						$feedback = array();
					}
					$user_detail = array(
						'Others_report_id' => $resmt['Others_report_id'],
						'Description' => $resmt['Description'],
						'Location' => $resmt['Location'],
						'time' => $resmt['tym'],
						'date' => $resmt['Date'],
						'date_time' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
						'Media' => $imgarray,
						'feedback' => $feedback,
						//'feedbackMedia' => $imgarray1,
						'Status ' => $resmt['Others_report_status'],
						'created_at' => $this->getDayNew($resmt['created_at']),
						'user_name' => $resmt['user_name'],
						'user_phone' => $resmt['user_phone'],



					);
					array_push($newarr, $user_detail);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}


	public function Notification()
	{
		if (isset($_POST['user_id'])) {

			// $check_user =  $this->beats_model->select_data('*,(DATE_FORMAT(notificationdate,"%W %d/%m/%Y %l:%i %p")) as date_time', 'UserNotification_all', array('user_id' => $_POST['user_id'], 'user_id' => 0), '', array('usernotification_id', 'desc'));
			$check_user =  $this->beats_model->select_data('*,(DATE_FORMAT(notificationdate,"%W %d/%m/%Y %l:%i %p")) as date_time', 'UserNotification_all', array('user_id' => $_POST['user_id']), '', array('usernotification_id', 'desc'));

			if (count($check_user) > 0) {

				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function TransferVehicle()
	{
		if (isset($_POST['Vehicle_id']) && isset($_POST['new_Name']) && isset($_POST['new_phone']) && isset($_POST['Reason_Transfer'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_phone' => $_POST['new_phone']));
			if (!empty($check_user)) {
				$user_detail = array(
					'Vehicle_id' => $_POST['Vehicle_id'],
					'new_Name' => $_POST['new_Name'],
					'new_phone' => $_POST['new_phone'],
					'Reason_Transfer' => $_POST['Reason_Transfer'],

				);
				$reg_id = $this->beats_model->insert_data('Transfer_Vehicle', $user_detail);

				$this->beats_model->update_data('Vehicle_Profile', array('transfer_id' => $reg_id, 'user_id' => $check_user['0']['user_id']), array('Vehicle_id' => $_POST['Vehicle_id']));
				echo json_encode(array('status' => true, 'message' => ' Successfull.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No user exits'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function TransferProperty()
	{
		if (isset($_POST['Property_id']) && isset($_POST['new_Name']) && isset($_POST['new_phone']) && isset($_POST['Reason_Transfer'])) {
			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_phone' => $_POST['new_phone']));
			if (!empty($check_user)) {
				$user_detail = array(
					'Property_id' => $_POST['Property_id'],
					'new_Name' => $_POST['new_Name'],
					'new_phone' => $_POST['new_phone'],
					'Reason_Transfer' => $_POST['Reason_Transfer'],

				);
				$reg_id = $this->beats_model->insert_data('Transfer_Property', $user_detail);
				$this->beats_model->update_data('Property_Profile', array('transfer_id' => $reg_id, 'user_id' => $check_user['0']['user_id']), array('Property_id' => $_POST['Property_id']));
				echo json_encode(array('status' => true, 'message' => ' Successfull.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No user exits'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public  function getAllenotice($user_id, $enotice_type)
	{
		$qr = "user_id = '" . $user_id . "' and enotice_type = '" . $enotice_type . "'";
		$check_enotis = $this->beats_model->select_data('*,(DATE_FORMAT(created_at,"%W %d/%m/%Y %l:%i %p")) as date_time_notice', 'Userenotice_all', $qr, '', array('enotice_all_id', 'desc'));
		$check = array();
		if (!empty($check_enotis)) {
			foreach ($check_enotis as $check_enoti) {
				array_push($check, $check_enoti['enotice_id']);
			}
		}
		return $check;
	}

	public function eNoticeWantedPersons()
	{
		if (isset($_POST['user_id'])) {
			$notice_data = $this->getAllenotice($_POST['user_id'], '1');
			// $qr = (empty($notice_data) ? '' : implode(',', $notice_data));

			if (!empty($notice_data)) {
				$qr = "WantedPerson_id IN (" . implode(',', $notice_data) . ")";
				$check_user =  $this->beats_model->select_data('*,(DATE_FORMAT(created_at,"%W %d/%m/%Y %l:%i %p")) as date_time', 'Wanted_Persons', $qr, '', array('WantedPerson_id', 'desc'));

				if (count($check_user) > 0) {
					echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
				} else {
					echo json_encode(array('status' => false, 'message' => 'No data found.'));
				}
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function eNoticeMissingPersons()
	{
		if (isset($_POST['user_id'])) {
			$notice_data = $this->getAllenotice($_POST['user_id'], '2');
			// $qr = (empty($notice_data) ? '' : implode(',', $notice_data));		
			if (!empty($notice_data)) {
				$qr = "MissingPersons_id IN (" . implode(',', $notice_data) . ")";
				$check_user =  $this->beats_model->select_data('*,(DATE_FORMAT(CONCAT(MissingPersons_Date, " ", MissingPersons_tym),"%W %d/%m/%Y %l:%i %p")) as date_time', 'Missing_Persons', $qr, '', array('MissingPersons_id', 'desc'));
				if (count($check_user) > 0) {
					echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
				} else {
					echo json_encode(array('status' => false, 'message' => 'No data found.'));
				}
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function eNoticeStolenVehicle()
	{
		error_reporting(0);
		if (isset($_POST['user_id'])) {
			$notice_data = $this->getAllenotice($_POST['user_id'], '4');
			// $qr = (empty($notice_data) ? '' : implode(',', $notice_data));

			if (!empty($notice_data)) {
				$qr = "StolenVehicle_id IN (" . implode(',', $notice_data) . ")";

				$check_user =  $this->beats_model->select_data('*', 'Stolen_Vehicle', $qr, '', array('StolenVehicle_id', 'desc'));
				if (count($check_user) > 0) {
					$newarr = array();
					foreach ($check_user as $resmt) {
						if (!empty($resmt['StolenVehicle_img'])) {
							$newimg = json_decode($resmt['StolenVehicle_img']);
							$imgarray = array();
							foreach ($newimg as $itm) {
								$user_img = array(
									'image' => $itm,
								);
								array_push($imgarray, $user_img);
							}
							$nefimeimg = implode(',', $newimg);
						} else {
							$nefimeimg = "";
						}
						$user_detail = array(
							'StolenVehicle_id' => $resmt['StolenVehicle_id'],
							'Vehicle_make' => $resmt['Vehicle_make'],
							'Vehicle_model' => $resmt['Vehicle_model'],
							'Vehicle_year' => $resmt['Vehicle_year'],
							'Vehicle_lastlocation' => $resmt['Vehicle_lastlocation'],
							'Plate_Number' => $resmt['Plate_Number'],
							'Engine_Number' => $resmt['Engine_Number'],
							'Vehicle_Color' => $resmt['Vehicle_Color'],
							'time' => $resmt['StolenVehicle_report_tym'],
							'date' => $resmt['StolenVehicle_report_date'],
							'date_time' => $this->getDayNew($resmt['StolenVehicle_report_date'] . ' ' . $resmt['StolenVehicle_report_tym']),
							'StolenVehicle_img' => $imgarray,
							'StolenVehicle_status' => $resmt['StolenVehicle_status'],
						);
						array_push($newarr, $user_detail);
					}
					echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $newarr));
				} else {
					echo json_encode(array('status' => false, 'message' => 'No data found.'));
				}
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function eNoticePublicEvents()
	{
		if (isset($_POST['user_id'])) {
			$notice_data = $this->getAllenotice($_POST['user_id'], '3');
			// $qr = (empty($notice_data) ? '' : implode(',', $notice_data));

			if (!empty($notice_data)) {
				$qr = "PublicEvent_id IN (" . implode(',', $notice_data) . ")";
				$check_user =  $this->beats_model->select_data('*,(DATE_FORMAT(CONCAT(Event_date, " ", Event_tym),"%W %d/%m/%Y %l:%i %p")) as date_time', 'Public_Events', $qr, '', array('PublicEvent_id', 'desc'));
				if (count($check_user) > 0) {
					echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
				} else {
					echo json_encode(array('status' => false, 'message' => 'No data found.'));
				}
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function eNoticeSecurityTips()
	{

		if (isset($_POST['user_id'])) {
			$notice_data = $this->getAllenotice($_POST['user_id'], '5');
			// $qr = (empty($notice_data) ? '' : implode(',', $notice_data));

			if (!empty($notice_data)) {
				$qr = "SecurityTips_id IN (" . implode(',', $notice_data) . ")";
				$check_user =  $this->beats_model->select_data('*,(DATE_FORMAT(CONCAT(SecurityTips_date, " ", SecurityTips_tym),"%W %d/%m/%Y %l:%i %p")) as date_time', 'Security_Tips', $qr, '', array('SecurityTips_id', 'desc'));

				if (count($check_user) > 0) {
					echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
				} else {
					echo json_encode(array('status' => false, 'message' => 'No data found.'));
				}
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function eNoticeTrafficReport()
	{
		if (isset($_POST['user_id'])) {
			$notice_data = $this->getAllenotice($_POST['user_id'], '6');
			// $qr = (empty($notice_data) ? '' : implode(',', $notice_data));

			if (!empty($notice_data)) {
				$qr = "TrafficReport_id IN (" . implode(',', $notice_data) . ")";
				$check_user =  $this->beats_model->select_data('*', 'Traffic_Reports', $qr, '', array('TrafficReport_id', 'desc'));
				if (count($check_user) > 0) {
					$newarr = array();
					foreach ($check_user as $resmt) {
						if (!empty($resmt['images'])) {
							$newimg = json_decode($resmt['images']);
							$imgarray = array();
							foreach ($newimg as $itm) {
								$user_img = array(
									'image' => $itm,
								);
								array_push($imgarray, $user_img);
							}
							$nefimeimg = implode(',', $newimg);
						} else {
							$nefimeimg = "";
						}
						$user_detail = array(
							'TrafficReport_id' => $resmt['TrafficReport_id'],
							'area' => $resmt['area'],
							'traffic_level' => $resmt['traffic_level'],
							'recommendation' => $resmt['recommendation'],
							'time' => $resmt['time'],
							'date' => $resmt['date'],
							'date_time' => $this->getDayNew($resmt['date'] . ' ' . $resmt['time']),
							'created_at' => $resmt['created_at'],
							'updated_at' => $resmt['updated_at'],
							'TrafficReport_status' => $resmt['TrafficReport_status'],
							'images' => $imgarray,
						);
						array_push($newarr, $user_detail);
					}

					echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $newarr));
				} else {
					echo json_encode(array('status' => false, 'message' => 'No data found.'));
				}
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function getCountSOS()
	{
		if (isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['user_type']) && !empty($_POST['user_id'])) {
			$userid = $_POST['user_id'];
			$user_type = $_POST['user_type'];
			$a = '';
			$newarr = array();

			if ($user_type == 1) {

				$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $userid));


				$check_cate = $this->beats_model->select_data('*', 'sos_category', "sos_category_id NOT IN (3,6)");
				foreach ($check_cate as $cat) {
					$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
					$a = "SOSManagement.SOS_category= " . $cat['sos_category_id'];
					$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
					$i = 0;
					foreach ($check_user as $resmt) {
						$fs = $this->Nearbysos($check_type['0']['Officer_id'], $resmt['lat'], $resmt['lang'], $check_type['0']['officer_category']);
						if ($fs == 1) {
							$i++;
						}
					}

					$user_detail = array(
						'category_name' => $cat['sos_category_name'],
						'ttl_sos' =>	$i,
						'mostRecent' => ($i != 0) ? $check_user[0]['created_at'] : ""
					);
					array_push($newarr, $user_detail);
				}


				/* if ($check_type['0']['officer_category'] == 1) {
					$check_cate = $this->beats_model->select_data('*', 'sos_category', "sos_category_id NOT IN (3,6)");
					foreach ($check_cate as $cat) {
						$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
						$a = "SOSManagement.SOS_category= " . $cat['sos_category_id'];
						$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
						$user_detail = array(
							'category_name' => $cat['sos_category_name'],
							'ttl_sos' =>	count($check_user),
							'mostRecent' => (count($check_user) != 0) ? $check_user[0]['created_at'] : ""
						);
						array_push($newarr, $user_detail);
					}
				} else {
					$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
					$stated = $check_user_meta['0']['lga_state'];
					$check_cate = $this->beats_model->select_data('*', 'sos_category');
					foreach ($check_cate as $cat) {
						$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
						$a = "SOSManagement.SOS_category= " . $cat['sos_category_id'] . " AND current_location Like '%" . $stated . '%' . "'";
						$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
						$user_detail = array(
							'category_name' => $cat['sos_category_name'],
							'ttl_sos' =>	count($check_user),
							'mostRecent' => (count($check_user) != 0) ? $check_user[0]['created_at'] : ""
						);
						array_push($newarr, $user_detail);
					}
				} */
			} else {
				$check_cate = $this->beats_model->select_data('*', 'sos_category', "sos_category_id NOT IN (3,6)");
				foreach ($check_cate as $cat) {
					$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
					$a = "SOSManagement.usertype = '0' and SOSManagement.user_id = '" . $userid . "' and SOSManagement.SOS_category= " . $cat['sos_category_id'];
					$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
					$user_detail = array(
						'category_name' => $cat['sos_category_name'],
						'ttl_sos' =>	count($check_user),
						'mostRecent' => (count($check_user) != 0) ? $check_user[0]['created_at'] : ""
					);
					array_push($newarr, $user_detail);
				}
			}

			if (count($newarr) > 0) {
				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}


	public function getCountFieldReport()
	{

		$newarr = array();
		if (isset($_POST['user_id'])) {
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));
			$date_s = "user_type = '0' and user_id = '" . $_POST['user_id'] . "'";
			$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));

			$data['result3'] = $this->beats_model->select_data('*,(Vehicle_lastlocation) as GeoLocationnew', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'));
			$data['result4'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'));
			$data['result5'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'));
			$data['result6'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'));
			$data['result7'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'));
			$data['result8'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'));

			$data['result10'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'));
			$data['result11'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'));
			$data['result12'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'));
			$data['result13'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'));

			$data['result15'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'));

			$data['result17'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'));
			$data['result18'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'));
			$data['result19'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'));
			$data['result20'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'));
			$data['result21'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'));
			$data['result22'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'));
			$data['result23'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'));
			$data['result24'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'));
			$data['result25'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'));




			$user_detail = array(
				'type' => 'iWitness',
				'ttl_sos' => count($data['result']),
				'mostRecent' => (count($data['result']) != 0) ? $this->getDayNew($data['result'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result']) != 0) ? date('l d/m/Y', strtotime($data['result'][0]['iWitness_date'])) . ' ' . substr_replace($data['result'][0]['iWitness_tym'], ' ', (strlen($data['result'][0]['iWitness_tym']) == 8) ? 5 : 4, -2) : "",

			);
			array_push($newarr, $user_detail);

			$user_detail3 = array(
				'type' => 'Stolen vehicle',
				'ttl_sos' => count($data['result3']),
				'mostRecent' => (count($data['result3']) != 0) ? $this->getDayNew($data['result3'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result3']) != 0) ? date('l d/m/Y', strtotime($data['result3'][0]['StolenVehicle_report_date'])) . ' ' . substr_replace($data['result3'][0]['StolenVehicle_report_tym'], ' ', (strlen($data['result3'][0]['StolenVehicle_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail3);

			$user_detail4 = array(
				'type' => 'Missing Persons',
				'ttl_sos' => count($data['result4']),
				'mostRecent' => (count($data['result4']) != 0) ? $this->getDayNew($data['result4'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result4']) != 0) ? date('l d/m/Y', strtotime($data['result4'][0]['Missing_Persons_report_Date'])) . ' ' . substr_replace($data['result4'][0]['Missing_Persons_report_tym'], ' ', (strlen($data['result4'][0]['Missing_Persons_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail4);

			$user_detail5 = array(
				'type' => 'Lodge a complaint',
				'ttl_sos' => count($data['result5']),
				'mostRecent' => (count($data['result5']) != 0) ? $this->getDayNew($data['result5'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result5']) != 0) ? date('l d/m/Y', strtotime($data['result5'][0]['Lodgecomplaint_report_Date'])) . ' ' . substr_replace($data['result5'][0]['Lodgecomplaint_report_tym'], ' ', (strlen($data['result5'][0]['Lodgecomplaint_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail5);

			$user_detail6 = array(
				'type' => 'Gun Violence',
				'ttl_sos' => count($data['result6']),
				'mostRecent' => (count($data['result6']) != 0) ? $this->getDayNew($data['result6'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result6']) != 0) ? date('l d/m/Y', strtotime($data['result6'][0]['GunViolence_Date'])) . ' ' . substr_replace($data['result6'][0]['GunViolence_tym'], ' ', (strlen($data['result6'][0]['GunViolence_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail6);

			$user_detail7 = array(
				'type' => 'Drug Abuse',
				'ttl_sos' => count($data['result7']),
				'mostRecent' => (count($data['result7']) != 0) ? $this->getDayNew($data['result7'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result7']) != 0) ? date('l d/m/Y', strtotime($data['result7'][0]['Date'])) . ' ' . substr_replace($data['result7'][0]['tym'], ' ', (strlen($data['result7'][0]['tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail7);

			$user_detail8 = array(
				'type' => 'Domestic Violence',
				'ttl_sos' => count($data['result8']),
				'mostRecent' => (count($data['result8']) != 0) ? $this->getDayNew($data['result8'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result8']) != 0) ? date('l d/m/Y', strtotime($data['result8'][0]['Date'])) . ' ' . substr_replace($data['result8'][0]['tym'], ' ', (strlen($data['result8'][0]['tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail8);

			$user_detail10 = array(
				'type' => 'Rape',
				'ttl_sos' => count($data['result10']),
				'mostRecent' => (count($data['result10']) != 0) ? $this->getDayNew($data['result10'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result10']) != 0) ? date('l d/m/Y', strtotime($data['result10'][0]['Rape_report_Date'])) . ' ' . substr_replace($data['result10'][0]['Rape_report_tym'], ' ', (strlen($data['result10'][0]['Rape_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail10);

			$user_detail11 = array(
				'type' => 'Kidnap',
				'ttl_sos' => count($data['result11']),
				'mostRecent' => (count($data['result11']) != 0) ? $this->getDayNew($data['result11'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result11']) != 0) ? date('l d/m/Y', strtotime($data['result11'][0]['Kidnap_report_Date'])) . ' ' . substr_replace($data['result11'][0]['Kidnap_report_tym'], ' ', (strlen($data['result11'][0]['Kidnap_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail11);

			$user_detail12 = array(
				'type' => 'Robbery',
				'ttl_sos' => count($data['result12']),
				'mostRecent' => (count($data['result12']) != 0) ? $this->getDayNew($data['result12'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result12']) != 0) ? date('l d/m/Y', strtotime($data['result12'][0]['Robbery_report_Date'])) . ' ' . substr_replace($data['result12'][0]['Robbery_report_tym'], ' ', (strlen($data['result12'][0]['Robbery_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail12);

			$user_detail13 = array(
				'type' => 'Burglary',
				'ttl_sos' => count($data['result13']),
				'mostRecent' => (count($data['result13']) != 0) ? $this->getDayNew($data['result13'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result13']) != 0) ? date('l d/m/Y', strtotime($data['result13'][0]['Burglary_report_Date'])) . ' ' . substr_replace($data['result13'][0]['Burglary_report_tym'], ' ', (strlen($data['result13'][0]['Burglary_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail13);

			$user_detail15 = array(
				'type' => 'Submit a Tip',
				'ttl_sos' => count($data['result15']),
				'mostRecent' => (count($data['result15']) != 0) ? $this->getDayNew($data['result15'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result15']) != 0) ? date('l d/m/Y', strtotime($data['result15'][0]['Date'])) . ' ' . substr_replace($data['result15'][0]['tym'], ' ', (strlen($data['result15'][0]['tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail15);

			$user_detail17 = array(
				'type' => 'Vandalism',
				'ttl_sos' => count($data['result17']),
				'mostRecent' => (count($data['result17']) != 0) ? $this->getDayNew($data['result17'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result17']) != 0) ? date('l d/m/Y', strtotime($data['result17'][0]['Vandalism_report_Date'])) . ' ' . substr_replace($data['result17'][0]['Vandalism_report_tym'], ' ', (strlen($data['result17'][0]['Vandalism_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail17);

			$user_detail18 = array(
				'type' => 'Fire',
				'ttl_sos' => count($data['result18']),
				'mostRecent' => (count($data['result18']) != 0) ? $this->getDayNew($data['result18'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result18']) != 0) ? date('l d/m/Y', strtotime($data['result18'][0]['Fire_report_Date'])) . ' ' . substr_replace($data['result18'][0]['Fire_report_tym'], ' ', (strlen($data['result18'][0]['Fire_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail18);

			$user_detail19 = array(
				'type' => 'Accident',
				'ttl_sos' => count($data['result19']),
				'mostRecent' => (count($data['result19']) != 0) ? $this->getDayNew($data['result19'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result19']) != 0) ? date('l d/m/Y', strtotime($data['result19'][0]['Accident_report_Date'])) . ' ' . substr_replace($data['result19'][0]['Accident_report_tym'], ' ', (strlen($data['result19'][0]['Accident_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail19);

			$user_detail20 = array(
				'type' => 'Medical',
				'ttl_sos' => count($data['result20']),
				'mostRecent' => (count($data['result20']) != 0) ? $this->getDayNew($data['result20'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result20']) != 0) ? date('l d/m/Y', strtotime($data['result20'][0]['Medical_report_Date'])) . ' ' . substr_replace($data['result20'][0]['Medical_report_tym'], ' ', (strlen($data['result20'][0]['Medical_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail20);

			$user_detail21 = array(
				'type' => 'Riot',
				'ttl_sos' => count($data['result21']),
				'mostRecent' => (count($data['result21']) != 0) ? $this->getDayNew($data['result21'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result21']) != 0) ? date('l d/m/Y', strtotime($data['result21'][0]['Riot_report_Date'])) . ' ' . substr_replace($data['result21'][0]['Riot_report_tym'], ' ', (strlen($data['result21'][0]['Riot_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail21);

			$user_detail22 = array(
				'type' => 'Environmental Hazard',
				'ttl_sos' => count($data['result22']),
				'mostRecent' => (count($data['result22']) != 0) ? $this->getDayNew($data['result22'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result22']) != 0) ? date('l d/m/Y', strtotime($data['result22'][0]['Environmental_Hazard_report_Date'])) . ' ' . substr_replace($data['result22'][0]['Environmental_Hazard_report_tym'], ' ', (strlen($data['result22'][0]['Environmental_Hazard_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail22);

			$user_detail23 = array(
				'type' => 'Child Abuse',
				'ttl_sos' => count($data['result23']),
				'mostRecent' => (count($data['result23']) != 0) ? $this->getDayNew($data['result23'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result23']) != 0) ? date('l d/m/Y', strtotime($data['result23'][0]['Child_Abuse_report_Date'])) . ' ' . substr_replace($data['result23'][0]['Child_Abuse_report_tym'], ' ', (strlen($data['result23'][0]['Child_Abuse_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail23);

			$user_detail24 = array(
				'type' => 'Human Trafficking',
				'ttl_sos' => count($data['result24']),
				'mostRecent' => (count($data['result24']) != 0) ? $this->getDayNew($data['result24'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result24']) != 0) ? date('l d/m/Y', strtotime($data['result24'][0]['Human_Trafficking_report_Date'])) . ' ' . substr_replace($data['result24'][0]['Human_Trafficking_report_tym'], ' ', (strlen($data['result24'][0]['Human_Trafficking_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail24);

			$user_detail25 = array(
				'type' => 'Blow Whistle',
				'ttl_sos' => count($data['result25']),
				'mostRecent' => (count($data['result25']) != 0) ? $this->getDayNew($data['result25'][0]['created_at']) : "",
				'mostRecent1' => (count($data['result25']) != 0) ? date('l d/m/Y', strtotime($data['result25'][0]['Blow_Whistle_report_Date'])) . ' ' . substr_replace($data['result25'][0]['Blow_Whistle_report_tym'], ' ', (strlen($data['result25'][0]['Blow_Whistle_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail25);

			// $user_detail1 = array(
			// 	'type' => 'Officer Conduct',
			// 	'ttl_sos' => count($data['result1']),
			// );
			// array_push($newarr, $user_detail1);
			// $user_detail2 = array(
			// 	'type' => 'Commend Officer',
			// 	'ttl_sos' => count($data['result2']),
			// );
			// array_push($newarr, $user_detail2);

			// $user_detail9 = array(
			// 	'type' => 'Terrorist Attack',
			// 	'ttl_sos' => count($data['result9']),
			// );
			// array_push($newarr, $user_detail9);			

			// $user_detail14 = array(
			// 	'type' => 'Cybercrime',
			// 	'ttl_sos' => count($data['result14']),
			// );
			// array_push($newarr, $user_detail14);

			// $user_detail16 = array(
			// 	'type' => 'Other Reports',
			// 	'ttl_sos' => count($data['result16']),
			// );
			// array_push($newarr, $user_detail16);

			if (count($newarr) > 0) {

				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	// public function testsms()
	// {
	// 	$Mbl = '08161171389';
	// 	$otp = rand(1000, 9999);
	// 	$data['otp'] = $otp;


	// 	$user_detail = array(
	// 		'otp' => $otp,
	// 	);

	// 	$owneremail = "ict@ribs.com.ng";
	// 	$subacct = "ABSAS";
	// 	$subacctpwd = "absas2020!";
	// 	$sendto = $Mbl;  /* destination number */
	// 	$sender = "ABSAS";   /* sender id */
	// 	$message = 'your test verification code is ' . $otp;   /* message to be sent */
	// 	/* create the required URL */
	// 	$url = "http://www.smslive247.com/http/index.aspx?"  . "cmd=sendquickmsg"  . "&owneremail=" . UrlEncode($owneremail)  . "&subacct=" . UrlEncode($subacct)  . "&subacctpwd=" . UrlEncode($subacctpwd)  . "&message=" . UrlEncode($message) . "&sender=" . UrlEncode($sender) . "&sendto=" . UrlEncode($sendto);
	// 	if ($f = @fopen($url, "r")) {
	// 		$answer = fgets($f, 255);
	// 		if (substr($answer, 0, 1) == "+") {
	// 			echo "SMS to $Mbl was successful.";
	// 		} else {
	// 			echo "an error has occurred: [$answer].";
	// 		}
	// 	} else {
	// 		"Error: URL could not be opened.";
	// 	}
	// }

	public function verifyshortcode()
	{
		if (isset($_POST['phone_number']) && isset($_POST['message']) && isset($_POST['code'])) {

			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_phone' => $_POST['user_phone'], 'verify_code' => $_POST['code']));
			if (!empty($check_user)) {

				$this->sendPushNoti("Shortcode Verification", "Verify citizen shortcode successfull", array($check_user[0]['fcm_tokenid']), "10");

				$Mbl = $check_user[0]['user_phone'];
				// $owneremail = "ict@ribs.com.ng";
				// $subacct = "ABSAS";
				// $subacctpwd = "absas2020!";
				// $sendto = $Mbl;
				// $sender = "ABSAS";
				$message = 'your verification code successfully verify : ' . $check_user[0]['verify_code'];   /* message to be sent */
				$this->sendsmsnew($Mbl, $message);
				// $url = "http://www.smslive247.com/http/index.aspx?"  . "cmd=sendquickmsg"  . "&owneremail=" . UrlEncode($owneremail)  . "&subacct=" . UrlEncode($subacct)  . "&subacctpwd=" . UrlEncode($subacctpwd)  . "&message=" . UrlEncode($message) . "&sender=" . UrlEncode($sender) . "&sendto=" . UrlEncode($sendto);

				// if ($f = @fopen($url, "r")) {
				// 	$answer = fgets($f, 255);
				// 	if (substr($answer, 0, 1) == "+") {
				// 		"SMS to $Mbl was successful.";
				// 	} else {
				// 		"an error has occurred: [$answer].";
				// 	}
				// } else {
				// 	"Error: URL could not be opened.";
				// }
				$user_detail = array(
					'verify_code' => 'verified',
				);

				$this->beats_model->update_data('user_signup', $user_detail, array('user_id' => $check_user[0]['user_id']));

				echo json_encode(array('status' => true, 'message' => 'Verify citizen shortcode successfull.', 'Details' => array()));
			} else {
				echo json_encode(array('status' => false, 'message' => "Doesn't verify citizen shortcode."));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function generateverifyshortcode()
	{
		if (isset($_POST['phone_number']) && !empty($_POST['phone_number'])) {

			$check_user =  $this->beats_model->select_data('*', 'user_signup', array('user_phone' => $_POST['phone_number']));
			if (!empty($check_user)) {


				$verifycode = rand(1000000, 9999999);
				$user_detail = array(
					'verify_code' => $verifycode,
				);

				$reg_id1 = $this->beats_model->update_data('user_signup', $user_detail, array('user_id' => $check_user[0]['user_id']));
				$this->sendPushNoti("Shortcode Generated", "New citizen shortcode generated successfull : $verifycode", array($check_user[0]['fcm_tokenid']), "11");

				$Mbl = $_POST['phone_number'];
				// $owneremail = "ict@ribs.com.ng";
				// $subacct = "ABSAS";
				// $subacctpwd = "absas2020!";
				// $sendto = $Mbl;
				// $sender = "ABSAS";
				$message = 'your verification new code successfully generated : ' . $verifycode;
				$this->sendsmsnew($Mbl, $message);
				// $url = "http://www.smslive247.com/http/index.aspx?"  . "cmd=sendquickmsg"  . "&owneremail=" . UrlEncode($owneremail)  . "&subacct=" . UrlEncode($subacct)  . "&subacctpwd=" . UrlEncode($subacctpwd)  . "&message=" . UrlEncode($message) . "&sender=" . UrlEncode($sender) . "&sendto=" . UrlEncode($sendto);

				// if ($f = @fopen($url, "r")) {
				// 	$answer = fgets($f, 255);
				// 	if (substr($answer, 0, 1) == "+") {
				// 		"SMS to $Mbl was successful.";
				// 	} else {
				// 		"an error has occurred: [$answer].";
				// 	}
				// } else {
				// 	"Error: URL could not be opened.";
				// }

				echo json_encode(array('status' => true, 'message' => 'New verification citizen shortcode successfull generated.', 'Details' => $user_detail));
			} else {
				echo json_encode(array('status' => false, 'message' => "Doesn't generat citizen shortcode."));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function getUserGuidePDF()
	{
		$data = array();
		$filepath = base_url() . '/uploads/userguidepdf/';
		$citizenpdf = $filepath . 'citizen.pdf';
		$officerpdf = $filepath . 'officer.pdf';
		$citizenpdf = 'https://absas.com.ng/guide/citizen/Userguide.pdf';
		$officerpdf = 'https://absas.com.ng/guide/officer/officerguide.pdf';

		$data['citizen_path'] = $citizenpdf;
		$data['officer_path'] = $officerpdf;
		// userguidepdfAdmin/uploads
		echo json_encode(array('status' => true, 'message' => "successfull", 'Details' => $data));
	}


	public function paginat($limit = '', $page = '')
	{
		$page = (!empty($page) ? $page : 1);
		$limit = ((!empty($limit) && $limit > 0) ? $limit : 10);
		$start = ($page - 1) * $limit;
		// $pagination = ''; //array($limit, $start);
		return array($limit, $start);
	}
	public function Nearbysos($officer_id, $lat, $lon, $type)
	{
		$cabs = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id, 'Officer_status' => 1));

		$flg = 0;
		if (($type == 1) || ($cabs[0]['officer_category'] == 1)) {
			$flg = 1;
		}

		foreach ($cabs as $itm) {
			$lat2 = (float) $itm['lat'];
			$lon2 = (float) $itm['lag'];

			$unit = "K";

			$theta = $lon - $lon2;
			if (is_numeric($lon) && is_numeric($lon)) {
				if (is_numeric($theta)) {
					$dist = sin(deg2rad($lat)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
					$dist = acos($dist);
					$dist = rad2deg($dist);
					// $miles = $dist * 60 * 1.1515;
					$miles = $dist * 25 * 1.1515;
					$unit = strtoupper($unit);
					if ($unit == "K") {
						$ttlkm = ($miles * 1.609344);
						if ($ttlkm <= 25) {
							$flg = 1;
						}
					}
				}
			}
		}
		return $flg;
	}




	//  -----------------------  code by Invito -----------------------------

	public function Unittypes()
	{
		$unittypes = $this->beats_model->select_data('PoliceUnitType_name as name', 'PoliceUnitType', 'PoliceUnitType_id NOT IN (1,2,3,4,5,6,7,8) ', '', array('PoliceUnitType_id', 'ASC'));
		$units = array();
		foreach($unittypes as $data)
		{
			array_push($units,$data['name']);
		}
		echo json_encode(array('status' => true, 'unit-types' => $units));
	}

	public function Smsnumber()
	{
		$number = $this->beats_model->select_data('smsNumber','tbl_appsettings');
		echo json_encode(array('status' => true, 'smsnumber' => $number[0]['smsNumber']));
	}


	//  -----------------------  code by Invito -----------------------------

}

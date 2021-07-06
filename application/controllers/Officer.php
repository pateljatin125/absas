<?php
defined('BASEPATH') or exit('No direct script access allowed');
// define('API_ACCESS_KEY', 'AAAA4ZU5p6M:APA91bHmTFQvfxwZZKEC4XzKRKT7RWTngm-uVv-JzOCozyI0ae0tmHVB77D13DHgX48v65omrnZ-tAbJn-Rp6bUhRMDcBu6hwSaX8s4Z9vEaQSYSwJHUEiwj_m7m1MlhDRNeO5QsMqQa');
define('API_ACCESS_KEY', 'AAAA3JWXjJo:APA91bG0NUlZyUjyTs8IN48IL1WP6-b5wrFHojihqXVTBJF4RJla3l17QHQLncvFSHVAcIbEKMCVvvPuDxmbXNPbYHuEkgsanF91PfNNIxdJiLREeNe3b1e3g_6InDk911v7sDdNAsMc');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

class Officer extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();
		$this->load->library('session');
	}

	public function UpdateLocation()
	{
		if (isset($_POST['user_id']) && isset($_POST['lat']) && isset($_POST['lag']) && isset($_POST['currentaddress'])) {
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['user_id']));
			if (!empty($check_user)) {

				$updt_id = $this->beats_model->update_data('Officer', array('lat' => $_POST['lat'], 'lag' => $_POST['lag'], 'currentaddress' => $_POST['currentaddress']), array('Officer_id' => $_POST['user_id']));
				echo json_encode(array('status' => true, 'message' => 'Successful.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data Found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function UpdateAccount()
	{
		if (isset($_POST['user_id']) && isset($_POST['user_kinPhone']) && isset($_POST['allergies']) && isset($_POST['Designation']) && isset($_POST['Rank']) && isset($_POST['Place_Assignment'])) {
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['user_id']));
			if (!empty($check_user)) {

				if ($_POST['Designation'] == 'Area Commander') {
					$POLICEINTERFACE = 2;
				} else if ($_POST['Designation'] == 'State Commissioner') {
					$POLICEINTERFACE = 3;
				} else if (
					$_POST['Designation'] == 'AIG Zone 1' || $_POST['Designation'] == 'AIG Zone 2' || $_POST['Designation'] == 'AIG Zone 3' || $_POST['Designation'] == 'AIG Zone 4'
					|| $_POST['Designation'] == 'AIG Zone 5' || $_POST['Designation'] == 'AIG Zone 6' || $_POST['Designation'] == 'AIG Zone 7' || $_POST['Designation'] == 'AIG Zone 8' ||
					$_POST['Designation'] == 'AIG Zone 9' || $_POST['Designation'] == 'AIG Zone 10' || $_POST['Designation'] == 'AIG Zone 11' || $_POST['Designation'] == 'AIG Zone 12'
				) {
					$POLICEINTERFACE = 4;
				} else if ($_POST['Designation'] == 'DIG') {
					$POLICEINTERFACE = 5;
				} else if ($_POST['Designation'] == 'IG') {
					$POLICEINTERFACE = 6;
				} else if ($_POST['Designation'] == 'DPO') {
					$POLICEINTERFACE = 1;
				} else {
					$POLICEINTERFACE = 1;
				}


				$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $check_user[0]['Officer_id'], 'user_type' => 2));
				if (!empty($check_meta_user)) {
					$meta_detail = array(
						'user_type' => '2',
						'user_id' => $check_user[0]['Officer_id'],
						'lga_state' => (isset($_POST['lga_state']) && !empty($_POST['lga_state']) ? $_POST['lga_state'] : $check_meta_user[0]['lga_state']),
						'blood_group' => (isset($_POST['blood_group']) && !empty($_POST['blood_group']) ? $_POST['blood_group'] : $check_meta_user[0]['blood_group']),
						'geno_type' => (isset($_POST['geno_type']) && !empty($_POST['geno_type']) ? $_POST['geno_type'] : $check_meta_user[0]['geno_type']),
						'agency' => (isset($_POST['agency']) && !empty($_POST['agency']) ? $_POST['agency'] : $check_meta_user[0]['agency']),
						'allergies' => $_POST['allergies'],
						'update_date' => date("Y-m-d H:i:s")
					);
					$updt_meta_id = $this->beats_model->update_data('user_officer_meta', $meta_detail, array('meta_id' => $check_meta_user[0]['meta_id']));
				} else {

					$meta_detail = array(
						'user_type' => '2',
						'user_id' => $check_user[0]['Officer_id'],
						'lga_state' => (isset($_POST['lga_state']) && !empty($_POST['lga_state']) ? $_POST['lga_state'] : ''),
						'blood_group' => (isset($_POST['blood_group']) && !empty($_POST['blood_group']) ? $_POST['blood_group'] : ''),
						'geno_type' => (isset($_POST['geno_type']) && !empty($_POST['geno_type']) ? $_POST['geno_type'] : ''),
						'agency' => (isset($_POST['agency']) && !empty($_POST['agency']) ? $_POST['agency'] : ''),
						'allergies' => $_POST['allergies'],
						'update_date' => date("Y-m-d H:i:s")
					);
					$meta_id = $this->beats_model->insert_data('user_officer_meta', $meta_detail);
				}

				$updt_id = $this->beats_model->update_data('Officer', array(
					'Kin_Phone' => $_POST['user_kinPhone'],
					'Rank' => $_POST['Rank'],
					'Designation' => $_POST['Designation'],
					'Place_Assignment' => $_POST['Place_Assignment'],
					'POLICE_INTERFACE_id' => $POLICEINTERFACE,
					'update_date' => date("Y-m-d H:i:s")
				), array('Officer_id' => $_POST['user_id']));
				echo json_encode(array('status' => true, 'message' => 'Successful.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data Found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function FeedbackSOS()
	{
		if (isset($_POST['SOS_id']) && isset($_POST['feedback']) && isset($_POST['Officer_id'])) {


			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$sosReport = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', array('SOSManagement.SOS_id' => $_POST['SOS_id']), '', array('SOS_id', 'DESC'), '', $dt);

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
					'feedback' => $_POST['feedback'],
					'feedbackMedia' => json_encode($images),
					'SOS_id' => $_POST['SOS_id'],
					'user_type' => $_POST['Officer_id'],
					'feedback_date' => date('Y-m-d H:i:s'),
				);
			} else {
				$user_detail = array(
					'feedback' => $_POST['feedback'],
					'SOS_id' => $_POST['SOS_id'],
					'user_type' => $_POST['Officer_id'],
					'feedback_date' => date('Y-m-d H:i:s'),
				);
			}

			$reg_id = $this->beats_model->insert_data('SOSFeedback', $user_detail);
			if ($sosReport['0']['usertype'] == 1) {
				$numdriver = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $sosReport['0']['user_id']));
			} else {
				$numdriver = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $sosReport['0']['user_id']));
			}

			$ttlfcm = count($numdriver);
			$registration_id = array();

			for ($i = 0; $i < $ttlfcm; $i++) {
				array_push($registration_id, $numdriver[$i]['fcm_tokenid']);
			}

			$ctid = $sosReport[0]['sos_category_id'];
			$ct = $sosReport[0]['sos_category_id'];
			if ($ct == '4' || $ct == '5') {
				$ctid = $ct - 1;
			}
			if ($ct == '7' || $ct == '8' || $ct == '9' || $ct == '10' || $ct == '11' || $ct == '12') {
				$ctid = $ct - 2;
			}

			if ($sosReport['0']['usertype'] == 1) {
				$nsdata = array("sos_id" => $_POST['SOS_id'], "sos_category" => $sosReport[0]['sos_category_name'], "sos_category_id" => $ctid, 'userType' => 'officer');
			} else {
				$nsdata = array("sos_id" => $_POST['SOS_id'], "sos_category" => $sosReport[0]['sos_category_name'], "sos_category_id" => $ctid, 'userType' => 'citizen');
			}

			$this->sendPushNotiSOS("SOS Feedback", "Feedback for sos", $registration_id, $sosReport['0']['user_id'], "4", $nsdata);

			echo json_encode(array('status' => true, 'message' => 'Successfull.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function FeedbackFiledReport()
	{
		if (isset($_POST['cat_id']) && isset($_POST['feedback']) && isset($_POST['Officer_id']) && isset($_POST['report_id'])) {
			$rpid = "";
			switch (trim($_POST['cat_id'])) {
				case "1":
					$lang = "iWitness";
					$id = "iWitness_id";
					$rpid = "1";
					break;
				case "2":
					$lang = "Officer_Abuse";
					$id = "OfficerAbuse_id";
					$rpid = "22";
					break;
				case "3":
					$lang = "Commend_Officer";
					$id = "CommendOffice_id";
					$rpid = "23";
					break;
				case "4":
					$lang = "StolenVehicle_report";
					$id = "StolenVehicle_report_id";
					$rpid = "2";
					break;
				case "5":
					$lang = "Missing_Persons_report";
					$id = "Missing_Persons_report_id";
					$rpid = "3";
					break;
				case "6":
					$lang = "Lodgecomplaint_report";
					$id = "Lodgecomplaint_report_id";
					$rpid = "4";
					break;
				case "7":
					$lang = "Gun_Violence_report";
					$id = "GunViolence_id";
					$rpid = "5";
					break;
				case "8":
					$lang = "Drug_Abuse_report";
					$id = "DrugAbuse_report_id";
					$rpid = "6";
					break;
				case "9":
					$lang = "Domestic_Violence_report";
					$id = "DomesticViolence_report_id";
					$rpid = "7";
					break;
				case "10":
					$lang = "Terrorist_Attack_report";
					$id = "TerroristAttack_report_id";
					$rpid = "24";
					break;
				case "11":
					$lang = "Rape_report";
					$id = "Rape_report_id";
					$rpid = "8";
					break;
				case "12":
					$lang = "Kidnap_report";
					$id = "Kidnap_report_id";
					$rpid = "9";
					break;
				case "13":
					$lang = "Robbery_report";
					$id = "Robbery_report_id";
					$rpid = "10";
					break;
				case "14":
					$lang = "Burglary_report";
					$id = "Burglary_report_id";
					$rpid = "11";
					break;
				case "15":
					$lang = "CybercrimeFraud_report";
					$id = "CybercrimeFraud_report_id";
					$rpid = "25";
					break;
				case "16":
					$lang = "Submit_Tip_report";
					$id = "Submit_Tip_id";
					$rpid = "12";
					break;
				case "17":
					$lang = "Others_report";
					$id = "Others_report_id";
					$rpid = "26";
					break;
				case "18":
					$lang = "Vandalism_report";
					$id = "Vandalism_report_id";
					$rpid = "13";
					break;
				case "19":
					$lang = "Fire_report";
					$id = "Fire_report_id";
					$rpid = "14";
					break;
				case "20":
					$lang = "Accident_report";
					$id = "Accident_report_id";
					$rpid = "15";
					break;
				case "21":
					$lang = "Medical_report";
					$id = "Medical_report_id";
					$rpid = "16";
					break;
				case "22":
					$lang = "Riot_report";
					$id = "Riot_report_id";
					$rpid = "17";
					break;
				case "23":
					$lang = "Environmental_Hazard_report";
					$id = "Environmental_Hazard_report_id";
					$rpid = "18";
					break;
				case "24":
					$lang = "Child_Abuse_report";
					$id = "Child_Abuse_report_id";
					$rpid = "19";
					break;
				case "25":
					$lang = "Human_Trafficking_report";
					$id = "Human_Trafficking_report_id";
					$rpid = "20";
					break;
				case "26":
					$lang = "Blow_Whistle_report";
					$id = "Blow_Whistle_report_id";
					$rpid = "21";
					break;
				default:
					$lang = "iWitness";
					$id = "iWitness_id";
					$rpid = "1";
			}



			$sosReport = $this->beats_model->select_data('*', $lang, array($id => $_POST['report_id']));

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
				if (!empty($sosReport['feedbackMedia'])) {
					$oldmedia = json_decode($sosReport['feedbackMedia']);
					$newimg = array_merge($oldmedia, $images);
				} else {
					$newimg = $images;
				}
				//$res=$this->beats_model->update_data('SOSManagement',array('feedback'=>$feedback,'feedbackMedia'=>json_encode($newimg)),array('SOS_id'=>trim($_POST['SOS_id'])));

				$user_detail = array(
					'feedback' => $_POST['feedback'],
					'feedbackMedia' => json_encode($images),
					"$id" => $_POST['report_id'],
					'user_type' => $_POST['Officer_id'],
					'feedback_date' => date('Y-m-d H:i:s'),
				);
			} else {
				$user_detail = array(
					'feedback' => $_POST['feedback'],
					"$id" => $_POST['report_id'],
					'user_type' => $_POST['Officer_id'],
					'feedback_date' => date('Y-m-d H:i:s'),
				);
			}


			//$res=$this->beats_model->update_data($lang.'Feedback',$user_detail));
			$reg_id = $this->beats_model->insert_data($lang . 'Feedback', $user_detail);
			//  echo $this->db->last_query();
			// die;

			if ($sosReport['0']['user_type'] == 1) {
				$numdriver = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $sosReport['0']['user_id']));
			} else {
				$numdriver = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $sosReport['0']['user_id']));
			}

			$ttlfcm = count($numdriver);
			$registration_id = array();

			for ($i = 0; $i < $ttlfcm; $i++) {
				array_push($registration_id, $numdriver[$i]['fcm_tokenid']);
			}
			if ($sosReport['0']['user_type'] == 1) {

				$this->sendPushNotiFiled("Filed Report Feedback", "Feedback for " . $lang, $registration_id, $sosReport['0']['user_id'], array($rpid, 'officer'), "6");
			} else {

				$this->sendPushNotiFiled("Filed Report Feedback", "Feedback for " . $lang, $registration_id, $sosReport['0']['user_id'], array($rpid, 'citizen'), "6");
			}

			echo json_encode(array('status' => true, 'message' => 'Successfull.'));
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function sendPushNotiFiled($title, $message, $registration_id, $userid, $data, $type)
	{

		$user_detail = array(
			'titile' => $title,
			'message' => $message,
			'user_id' => $userid,
			'notificationdate' => date("Y-m-d H:i:s")
		);
		// print_r($data);
		if ($data[1] == 'officer') {
			$reg_id = $this->beats_model->insert_data('OfficerNotification_all', $user_detail);
		} else {
			$reg_id = $this->beats_model->insert_data('UserNotification_all', $user_detail);
		}

		$fcmMsg = array(
			'body' => $message,
			'title' => $title,
			'type' => $type,
			'report_id' => $data[0],
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
		// if (curl_errno($ch)) {
		// 	$error_msg = curl_error($ch);
		// print_r($error_msg);
		// }
		// print_r($result);
		curl_close($ch);
		// die;
	}
	public function sendPushNoti($title, $message, $registration_id, $userid)
	{

		$user_detail = array(
			'titile' => $title,
			'message' => $message,
			'user_id' => $userid,
			'notificationdate' => date("Y-m-d H:i:s")
		);
		$reg_id = $this->beats_model->insert_data('UserNotification_all', $user_detail);

		$fcmMsg = array(
			'body' => $message,
			'title' => $title,
			'type' => 0
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
		// if (curl_errno($ch)) {
		// 	$error_msg = curl_error($ch);
		// print_r($error_msg);
		// }
		// print_r($result);
		curl_close($ch);
		// die;
	}
	public function sendPushNoti1($title, $message, $registration_id, $type)
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
	public function sendPushNotiSOS($title, $message, $registration_id, $userid, $type, $data)
	{

		$user_detail = array(
			'titile' => $title,
			'message' => $message,
			'user_id' => $userid,
			'notificationdate' => date("Y-m-d H:i:s")
		);
		if ($data['userType'] == 'citizen') {
			$reg_id = $this->beats_model->insert_data('UserNotification_all', $user_detail);
		} else {
			$reg_id = $this->beats_model->insert_data('OfficerNotification_all', $user_detail);
		}

		$fcmMsg = array(
			'body' => $message,
			'title' => $title,
			'type' => $type,
			'sos_id' => $data['sos_id'],
			'sos_category' => $data['sos_category'],
			'sos_category_id' => $data['sos_category_id']
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
		// if (curl_errno($ch)) {
		// 	$error_msg = curl_error($ch);
		// print_r($error_msg);
		// }
		// print_r($result);
		curl_close($ch);
		// die;
	}

	public function sendPushNotiNew($title, $message, $registration_id, $type)
	{

		// $user_detail = array(
		// 	'titile' => $title,
		// 	'message' => $message,
		// 	'user_id' => $userid,
		// );
		// $reg_id = $this->beats_model->insert_data('UserNotification_all', $user_detail);

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

		curl_close($ch);
	}
	public function Notification()
	{
		if (isset($_POST['user_id'])) {

			// $check_user =  $this->beats_model->select_data('*,(DATE_FORMAT(notificationdate,"%W %d/%m/%Y %l:%i %p")) as date_time', 'OfficerNotification_all', array('user_id' => $_POST['user_id'], 'user_id' => 0), '', array('usernotification_id', 'desc'));
			$check_user =  $this->beats_model->select_data('*,(DATE_FORMAT(notificationdate,"%W %d/%m/%Y %l:%i %p")) as date_time', 'OfficerNotification_all', array('user_id' => $_POST['user_id']), '', array('usernotification_id', 'desc'));

			if (count($check_user) > 0) {

				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function forgotpasswordphone()
	{
		if (isset($_POST['user_phone'])) {
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('phone' => $_POST['user_phone']));

			if (!empty($check_user)) {

				$Mbl = $_POST['user_phone'];
				$otp = rand(1000, 9999);
				$data['otp'] = $otp;
				$user_id = $check_user['0']['Officer_id'];

				$user_detail = array(
					'otp' => $otp,
				);

				$reg_id = $this->beats_model->update_data('Officer', $user_detail, array('Officer_id' => $check_user['0']['Officer_id']));
				// $msgy= base_url('/signupref/').$reg_id;
				//$msgy = base_url('Userupdate/').$otp.'/'.$user_id;


				// $owneremail = "ict@ribs.com.ng";
				// $subacct = "ABSAS";
				// $subacctpwd = "absas2020!";
				// $sendto = $Mbl;  /* destination number */
				// $sender = "ABSAS";   /* sender id */
				$message = 'your verification code is ' . $otp;   /* message to be sent */
				$this->sendsmsnew($Mbl, $message);
				/* create the required URL */
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

				// 

				//print_r($response);

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
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('phone' => $_POST['user_phone'], 'Kin_Phone' => $_POST['user_kinPhone']));

			if (!empty($check_user)) {

				echo json_encode(array('status' => true, 'message' => 'Successfull .', 'Details' => $check_user['0']['Officer_id']));
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

			$check_user =  $this->beats_model->select_data('*', 'Officer', array('phone' => $_POST['user_phone'], 'otp' => $_POST['otp']));

			if (!empty($check_user)) {
				$reg_id = $this->beats_model->update_data('Officer', array('otp' => 'expire'), array('Officer_id' => $check_user['0']['Officer_id']));

				echo json_encode(array('status' => true, 'message' => 'Successfull .', 'Details' => $check_user['0']['Officer_id']));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}


	public function UpdatePassword()
	{
		if (isset($_POST['user_id']) && isset($_POST['password'])) {
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['user_id']));
			if (!empty($check_user)) {

				$updt_id = $this->beats_model->update_data('Officer', array('password' => $_POST['password']), array('Officer_id' => $_POST['user_id']));
				echo json_encode(array('status' => true, 'message' => 'Successful.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data Found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
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

	public function SOScreate()
	{
		if (isset($_POST['SOS_category'])  && isset($_POST['current_location']) && isset($_POST['user_id']) && isset($_POST['Name']) && isset($_POST['Phone_Number']) && isset($_POST['lat']) && isset($_POST['lang'])) {
			$check_cat =  $this->beats_model->select_data('*', 'sos_category', array('sos_category_id' => $_POST['SOS_category']));

			//echo  trim($_POST['current_location']);
			// 		echo 	$stripped = str_replace(' ', '_', $_POST['current_location']);
			// 			die;

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
					'SOS_Source' => 1,
					'created_at' => date("Y/m/d h:i:s A"),
					'created_dateat' => date("Y/m/d"),


				);
				$reg_id = $this->beats_model->insert_data('SOSManagement', $user_detail);

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
					'SOS_Source' => 1,
					'created_at' => date("Y/m/d h:i:s A"),
					'created_dateat' => date("Y/m/d"),
				);
				$reg_id = $this->beats_model->insert_data('SOSManagement', $user_detail);


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

	public function RegisterOfficer()
	{

		if (
			isset($_POST['Full_Name'])  && isset($_POST['phone']) && isset($_POST['Rank']) && isset($_POST['Designation']) && isset($_POST['State_Deployment']) && isset($_POST['Place_Assignment'])
			&& isset($_POST['Police_service_Number']) && isset($_POST['Residential_Address']) && isset($_POST['Kin_Phone']) && isset($_POST['Password']) && isset($_FILES['profilepic']['name']) && isset($_POST['lga_state']) && isset($_POST['agency']) && isset($_POST['device_token'])
		) {

			$check_user =  $this->beats_model->select_data('*', 'Officer', array('phone' => $_POST['phone']));
			if (empty($check_user)) {


				$checkser =  $this->beats_model->select_data('*', 'Officer', array('Police_service_Number' => $_POST['Police_service_Number']));
				if (empty($checkser)) {

					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';

					$config['encrypt_name'] = TRUE;
					$new_name = time() . $_FILES['profilepic']['name'];
					$config['file_name'] = $new_name;
					//Load upload library and initialize configuration
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload('profilepic')) {
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
						$compeurl = base_url() . 'uploads/' . $picture;
					} else {
						$compeurl = '';
					}

					if ($_POST['Designation'] == 'Area Commander') {
						$POLICEINTERFACE = 2;
					} else if ($_POST['Designation'] == 'State Commissioner') {
						$POLICEINTERFACE = 3;
					} else if (
						$_POST['Designation'] == 'AIG Zone 1' || $_POST['Designation'] == 'AIG Zone 2' || $_POST['Designation'] == 'AIG Zone 3' || $_POST['Designation'] == 'AIG Zone 4'
						|| $_POST['Designation'] == 'AIG Zone 5' || $_POST['Designation'] == 'AIG Zone 6' || $_POST['Designation'] == 'AIG Zone 7' || $_POST['Designation'] == 'AIG Zone 8' ||
						$_POST['Designation'] == 'AIG Zone 9' || $_POST['Designation'] == 'AIG Zone 10' || $_POST['Designation'] == 'AIG Zone 11' || $_POST['Designation'] == 'AIG Zone 12'
					) {
						$POLICEINTERFACE = 4;
					} else if ($_POST['Designation'] == 'DIG') {
						$POLICEINTERFACE = 5;
					} else if ($_POST['Designation'] == 'IG') {
						$POLICEINTERFACE = 6;
					} else if ($_POST['Designation'] == 'DPO') {
						$POLICEINTERFACE = 1;
					} else {
						$POLICEINTERFACE = 1;
					}
					$verifycode = rand(1000000, 9999999);
					$user_detail = array(
						'Full_Name' => $_POST['Full_Name'],
						'phone' => $_POST['phone'],
						'Rank' => $_POST['Rank'],
						'Designation' => $_POST['Designation'],
						'State_Deployment' => $_POST['State_Deployment'],
						'Place_Assignment' => $_POST['Place_Assignment'],
						'Police_service_Number' => $_POST['Police_service_Number'],
						'Residential_Address' => $_POST['Residential_Address'],
						'Kin_Phone' => $_POST['Kin_Phone'],
						'Password' => $_POST['Password'],
						'fcm_tokenid' => $_POST['device_token'],
						'profilepic' => $compeurl,
						'created_date' => date('d/m/Y h:i:s A'),
						'POLICE_INTERFACE_id' => $POLICEINTERFACE,
						'verify_code' => $verifycode
					);

					$reg_id = $this->beats_model->insert_data('Officer', $user_detail);
					$meta_detail = array(
						'user_type' => '2',
						'user_id' => $reg_id,
						'lga_state' => $_POST['lga_state'],
						'blood_group' => $_POST['blood_group'],
						'geno_type' => $_POST['geno_type'],
						'agency' => $_POST['agency'],
						'allergies' => $_POST['allergies']
					);






					// $user_detail = array(
					// 	'verify_code' => $verifycode,
					// );
					// $reg_id1 = $this->beats_model->update_data('Officer', $user_detail, array('Officer_id' => $reg_id));



					$meta_id = $this->beats_model->insert_data('user_officer_meta', $meta_detail);
					$check_user1 =  $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $reg_id));
					$check_meta_user1 =  $this->beats_model->select_data('*', 'user_officer_meta', array('meta_id' => $meta_id));
					unset($check_meta_user1[0]['Officer_id']);
					unset($check_meta_user1[0]['created_date']);
					unset($check_meta_user1[0]['update_date']);
					$new_user = array_merge($check_user1[0], $check_meta_user1[0]);
					echo json_encode(array('status' => true, 'message' => 'Registration Successful.', 'Details' => $new_user));
				} else {
					echo json_encode(array('status' => false, 'message' => 'Police service Number Already Exits.'));
				}
			} else {
				echo json_encode(array('status' => false, 'message' => 'Already Exits Phone.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Login()
	{

		if (isset($_POST['phone']) && isset($_POST['Password']) && isset($_POST['device_token'])) {
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('phone' => $_POST['phone'], 'Password' => $_POST['Password']));
			if (!empty($check_user)) {
				$this->beats_model->update_data('Officer', array('fcm_tokenid' => $_POST['device_token'], 'update_date' => date("Y-m-d H:i:s")), array('Officer_id' => $check_user[0]['Officer_id']));
				if ($check_user[0]['verify_code'] != 'verified' || $check_user[0]['verify_code'] == '') {
					$verifycode = rand(1000000, 9999999);
					$user_detail = array(
						'verify_code' => $verifycode,
					);
					$this->beats_model->update_data('Officer', $user_detail, array('Officer_id' => $check_user[0]['Officer_id']));
					// echo json_encode(array('status' => true, 'message' => 'This user has not been verified.', 'Details' => array('verification_code' => $verifycode)));
					// die();
					$check_user[0]['verify_code'] = $verifycode;
				}
				//die;

				$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $check_user[0]['Officer_id'], 'user_type' => 2));

				$meta_user = array();

				if (!empty($check_meta_user)) {
					$meta_detail = array(
						'user_type' => '2',
						'lga_state' => $check_meta_user[0]['lga_state'],
						'blood_group' => $check_meta_user[0]['blood_group'],
						'geno_type' => $check_meta_user[0]['geno_type'],
						'agency' => $check_meta_user[0]['agency'],
						'allergies' => $check_meta_user[0]['allergies']
					);
				} else {
					$meta_detail = array(
						'user_type' => '2',
						'lga_state' => '',
						'blood_group' => '',
						'geno_type' => '',
						'agency' => '',
						'allergies' => ''
					);
				}
				$new_check_user = array_merge($check_user[0], $meta_detail);


				$user_log =  $this->beats_model->select_data('*', 'user_auth_logs', array('user_id' => $check_user[0]['Officer_id'], 'user_type' => 2, 'is_login' => 1));

				if (!empty($user_log)) {
					// if (!empty(&& ($user_log[0]['imei'] != $_POST['imei'])) {
					echo json_encode(array('status' => false, 'message' => 'User Already Login Other Device. Please Logout Other Device.', 'log_id' => $user_log[0]['log_id']));
					die();
					// }
				} else {
					$auth_logs = array(
						'user_type' => '2',
						'user_id' => $check_user[0]['Officer_id'],
						'device_type' => $_POST['device_type'],
						'is_login' => 1,
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
					$officer_token = $this->beats_model->update_data('Officer', array('fcm_tokenid' => $_POST['device_token'], 'update_date' => date("Y-m-d H:i:s")), array('Officer_id' => $check_user[0]['Officer_id']));
					echo json_encode(array('status' => true, 'message' => 'User Login Successful.', 'Details' => $new_check_user));
					die();
				}
				// echo json_encode(array('status' => true, 'message' => 'Officer Login Successful.', 'Details' => $new_check_user));
			} else {
				echo json_encode(array('status' => false, 'message' => 'Ohhh ! Wrong Credential.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function LoginTest()
	{

		if (isset($_POST['phone']) && isset($_POST['Password'])) {
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('phone' => $_POST['phone'], 'Password' => $_POST['Password']));
			if (!empty($check_user)) {
				if ($check_user[0]['verify_code'] != 'verified') {
					$verifycode = rand(1000000, 9999999);
					$user_detail = array(
						'verify_code' => $verifycode,
					);
					$this->beats_model->update_data('Officer', $user_detail, array('Officer_id' => $check_user[0]['Officer_id']));
					echo json_encode(array('status' => true, 'message' => 'This user has not been verified.', 'Details' => array('verification_code' => $verifycode)));
					die();
				}
				die;

				$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $check_user[0]['Officer_id'], 'user_type' => 2));

				$meta_user = array();

				if (!empty($check_meta_user)) {
					$meta_detail = array(
						'user_type' => '2',
						'lga_state' => $check_meta_user[0]['lga_state'],
						'blood_group' => $check_meta_user[0]['blood_group'],
						'geno_type' => $check_meta_user[0]['geno_type'],
						'agency' => $check_meta_user[0]['agency'],
						'allergies' => $check_meta_user[0]['allergies']
					);
				} else {
					$meta_detail = array(
						'user_type' => '2',
						'lga_state' => '',
						'blood_group' => '',
						'geno_type' => '',
						'agency' => '',
						'allergies' => ''
					);
				}
				$new_check_user = array_merge($check_user[0], $meta_detail);


				$user_log =  $this->beats_model->select_data('*', 'user_auth_logs', array('user_id' => $check_user[0]['Officer_id'], 'user_type' => 2, 'is_login' => 1));

				if (!empty($user_log)) {
					// if (!empty(&& ($user_log[0]['imei'] != $_POST['imei'])) {
					echo json_encode(array('status' => false, 'message' => 'User Already Login Other Device. Please Logout Other Device.', 'log_id' => $user_log[0]['log_id']));
					die();
					// }
				} else {
					$auth_logs = array(
						'user_type' => '2',
						'user_id' => $check_user[0]['Officer_id'],
						'device_type' => $_POST['device_type'],
						'is_login' => 1,
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
					$officer_token = $this->beats_model->update_data('Officer', array('fcm_tokenid' => $_POST['device_token']), array('Officer_id' => $check_user[0]['Officer_id']));
					echo json_encode(array('status' => true, 'message' => 'User Login Successful.', 'Details' => $new_check_user));
					die();
				}
				// echo json_encode(array('status' => true, 'message' => 'Officer Login Successful.', 'Details' => $new_check_user));
			} else {
				echo json_encode(array('status' => false, 'message' => 'Ohhh ! Wrong Credential.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function Logout()
	{

		if ((isset($_POST['phone']) && isset($_POST['Password'])) || isset($_POST['Officer_id']) || isset($_POST['log_id'])) {
			$flag = 1;

			if (isset($_POST['log_id'])) {
				$user_log_ns =  $this->beats_model->select_data('*', 'user_auth_logs', array('log_id' => $_POST['log_id'], 'is_login' => '1'));
				if (!empty($user_log_ns)) {
					$updt_meta_id = $this->beats_model->update_data('user_auth_logs', array('is_login' => 0, 'updated_at' => date("Y-m-d H:i:s")), array('log_id' => $_POST['log_id']));
					$this->sendPushNotiNew("New device login detected!", "AB-SAS", array($user_log_ns[0]['device_token']), "3");
					echo json_encode(array('status' => true, 'message' => 'User Logout Successful.'));
					die();
				} else {
					echo json_encode(array('status' => true, 'message' => 'User Already Logout Successful.'));
					die();
				}
			}


			if (isset($_POST['Officer_id'])) {
				$condition = array('Officer_id' => $_POST['Officer_id']);
				$flag = 1;
			} else {
				$condition = array('phone' => $_POST['phone'], 'Password' => $_POST['Password']);
				$flag = 2;
			}
			$check_user =  $this->beats_model->select_data('*', 'Officer', $condition);

			if (!empty($check_user)) {
				$user_log =  $this->beats_model->select_data('*', 'user_auth_logs', array('user_id' => $check_user[0]['Officer_id'], 'user_type' => 2, 'is_login' => 1));
				if (!empty($user_log)) {
					$updt_meta_id = $this->beats_model->update_data('user_auth_logs', array('is_login' => 0, 'updated_at' => date("Y-m-d H:i:s")), array('log_id' => $user_log[0]['log_id']));
					if ($flag == 2) {
						$this->sendPushNotiNew("New device login detected!", "AB-SAS", array($user_log[0]['device_token']), "3");
					}
				} else {
					echo json_encode(array('status' => true, 'message' => 'Officer Already Logout Successful.'));
					die();
				}
				echo json_encode(array('status' => true, 'message' => 'Officer Logout Successful.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'Ohhh ! Wrong Credential.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function FcmUpdate()
	{
		if (isset($_POST['Officer_id']) && isset($_POST['fcm_tokenid'])) {

			$check_user =  $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));

			if (count($check_user) > 0) {
				$reg_id = $this->beats_model->update_data('Officer', array('fcm_tokenid' => $_POST['fcm_tokenid']), array('Officer_id' => $_POST['Officer_id']));
				echo json_encode(array('status' => true, 'message' => ' Successfull Update.'));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Designation()
	{
		$check_user =  $this->beats_model->select_data('Designation_id,Designation_name', 'OfficerDesignation', '', '', array('rankOrder', 'ASC'));

		if (count($check_user) > 0) {

			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}
	public function PlaceAssignment()
	{


		$check_user =  $this->beats_model->select_data('PlaceAssignment_id,PlaceAssignment_name', 'PlaceAssignment', '', '', array('PlaceAssignment_name', 'ASC'));

		if (count($check_user) > 0) {

			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}
	public function State()
	{


		$check_user =  $this->beats_model->select_data('DISTINCT(STATE) as STATE, ', 'state_zone', '', '', array('STATE', 'ASC'));

		if (count($check_user) > 0) {

			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}
	public function Rank()
	{


		$check_user =  $this->beats_model->select_data('*', 'Rank', '', '', array('Rank_id', 'ASC'));

		if (count($check_user) > 0) {

			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}
	public function PropertyList()
	{


		$check_user =  $this->beats_model->select_data('*', 'Property_Profile', '', '', array('Property_id', 'DESC'));

		if (count($check_user) > 0) {

			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}
	public function VehicleList()
	{


		$check_user =  $this->beats_model->select_data('*', 'Vehicle_Profile', '', '', array('Vehicle_id', 'DESC'));

		if (count($check_user) > 0) {

			echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.'));
		}
	}
	// 	public function Nearby(){

	// 	if(isset($_POST['Unit_id'])) {
	// 			$check_user =  $this->beats_model->select_data('*','PoliceUnit',array('UnitName'=>$_POST['Unit_id']),'',array('PoliceUnit_id','DESC'));

	// 			    if(count($check_user)>0){

	// 					echo json_encode(array('status' => true , 'message' => ' Successfull.', 'Details' => $check_user));
	// 			    }else{
	// 			     	echo json_encode(array('status' => false , 'message' => 'No data found.'));   
	// 			    }
	// 	}else{
	// 			echo json_encode(array('status' => false , 'message' => 'All fields are required.'));
	// 		}

	// 	}

	public function PoliceVerify()
	{

		if (isset($_POST['PoliceNumber'])) {
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('phone' => $_POST['PoliceNumber']));

			if (count($check_user) > 0) {

				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $check_user));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function AccountDetails()
	{

		if (isset($_POST['Officer_id'])) {
			$check_user =  $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));
			$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $_POST['Officer_id'], 'user_type' => 2));



			if (count($check_user) > 0) {

				$meta_user = array();

				if (!empty($check_meta_user)) {
					$meta_detail = array(
						'user_type' => '2',
						'lga_state' => $check_meta_user[0]['lga_state'],
						'blood_group' => $check_meta_user[0]['blood_group'],
						'geno_type' => $check_meta_user[0]['geno_type'],
						'agency' => $check_meta_user[0]['agency'],
						'allergies' => $check_meta_user[0]['allergies']
					);
				} else {
					$meta_detail = array(
						'user_type' => '2',
						'lga_state' => '',
						'blood_group' => '',
						'geno_type' => '',
						'agency' => '',
						'allergies' => ''
					);
				}
				$new_check_user = array_merge($check_user[0], $meta_detail);

				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $new_check_user));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function ListSOS()
	{

		if (isset($_POST['Officer_id'])) {

			error_reporting(0);
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));

			// if ($check_type['0']['officer_category'] == 0) {
			// 	$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			// 	$state = $check_user_meta[0]['lga_state'];
			// 	$a = "SOSManagement.current_location like '%" . $state . "%'";
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// } else {
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', '', '', array('SOS_id', 'DESC'), '', $dt);
			// }

			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', '', '', array('SOS_id', 'DESC'), '', $dt);



			if (!empty($check_user)) {
				$newarr = array();

				foreach ($check_user as $resmt) {
					$fs = $this->Nearbysos($check_type['0']['Officer_id'], $resmt['lat'], $resmt['lang'], $check_type['0']['officer_category']);
					if ($fs == 1) {
						if (!empty($resmt['images'])) {
							$newimg = json_decode($resmt['images']);
							$imgarray = array();
							if (!empty($newimg)) {
								foreach ($newimg as $itm) {
									$user_img = array(
										'image' => $itm
									);
									array_push($imgarray, $user_img);
								}
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

	public function ListSOSNew()
	{

		if (isset($_POST['Officer_id'])) {
			$cat = $this->beats_model->select_data('*', 'sos_category', "sos_category_name like '%" . $_POST['sos_category'] . "%'");
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));

			// if ($check_type['0']['officer_category'] == 0) {
			// 	$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			// 	$state = $check_user_meta[0]['lga_state'];
			// 	$a = "SOSManagement.current_location like '%" . $state . "%' and SOSManagement.SOS_category = '" . $cat[0]['sos_category_id'] . "'";
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// } else {
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$a = "SOSManagement.SOS_category = '" . $cat[0]['sos_category_id'] . "'";
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// }

			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$a = "SOSManagement.SOS_category = '" . $cat[0]['sos_category_id'] . "'";
			$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);




			if (!empty($check_user)) {
				$newarr = array();

				foreach ($check_user as $resmt) {
					$fs = $this->Nearbysos($check_type['0']['Officer_id'], $resmt['lat'], $resmt['lang'], $check_type['0']['officer_category']);
					if ($fs == 1) {
						if (!empty($resmt['images'])) {
							$newimg = json_decode($resmt['images']);
							$imgarray = array();
							if (!empty($newimg)) {
								foreach ($newimg as $itm) {
									$user_img = array(
										'image' => $itm
									);
									array_push($imgarray, $user_img);
								}
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
	public function SOSDetails()
	{

		if (isset($_POST['SOS_id'])) {

			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', array('SOSManagement.SOS_id' => $_POST['SOS_id']), '', '', '', $dt);


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
						// $nefimeimg=implode(',',$newimg);
					} else {
						$imgarray = array();
					}

					//   $feedmedia=json_decode($resmt['feedbackMedia']);
					//   $imgarray1=array();
					//   if(!empty($feedmedia)){
					//       foreach($feedmedia as $itm1){
					//        $user_img1 = array(

					// 	'image' =>$itm1
					// 	);
					// 	array_push($imgarray1,$user_img1);
					//   }

					//   }else{
					//        $imgarray1=array();
					//   }

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

							//        if(!empty($feed['feedbackMedia'])){
							//       foreach(json_decode($feed['feedbackMedia']) as $itm2){

							// 	array_push($feedmarray,$itm2);
							//   }

							//   }else{
							//        $feedmarray=array();
							//   } 

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
						'Media' => $imgarray
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
	public function FiledReportsiWitness()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=iWitness.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,iWitness.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'iWitness', array('iWitness.user_type' => '1'), '', array('iWitness_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,iWitness.*,('user') as type", 'iWitness', array('iWitness.user_type' => '0'), '', array('iWitness_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=iWitness.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,iWitness.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'iWitness', array('iWitness.user_type' => '1', 'iWitness.Location' => "$state"), '', array('iWitness_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,iWitness.*,('user') as type", 'iWitness', array('iWitness.user_type' => '0', 'iWitness.Location' => "$state"), '', array('iWitness_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
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
	public function FiledReportsiWitnessNew($officer_id, $startdate, $enddate)
	{
		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "iWitness.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=iWitness.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,iWitness.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'), '', $dt);

			$date_s = "iWitness.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,iWitness.*', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "iWitness.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=iWitness.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,iWitness.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'), '', $dt);

			$date_s = "iWitness.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,iWitness.*', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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

				// $check_feedbac = $this->beats_model->select_data('feedback_date', 'iWitnessFeedback', array('iWitness_id' => $resmt['iWitness_id']));

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
				// if ($curDate > $mostRecent1) {
				// 	$mostRecent1 = $curDate;
				// }
			}

			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}

			echo json_encode(array('status' => true, 'message' => 'Successful.', 'mostRecent' => $newarr[0]['date_time'], 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsOfficer_Abuse()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == '1') {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Officer_Abuse.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Officer_Abuse.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Officer_Abuse', array('Officer_Abuse.user_type' => '1'), '', array('OfficerAbuse_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Officer_Abuse.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Officer_Abuse.*,('user') as type", 'Officer_Abuse', array('Officer_Abuse.user_type' => '0'), '', array('OfficerAbuse_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Officer_Abuse.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Officer_Abuse.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Officer_Abuse', array('Officer_Abuse.user_type' => '1', 'Officer_Abuse.Location' => "$state"), '', array('OfficerAbuse_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Officer_Abuse.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Officer_Abuse.*,('user') as type", 'Officer_Abuse', array('Officer_Abuse.user_type' => '0', 'Officer_Abuse.Location' => "$state"), '', array('OfficerAbuse_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			}

			// $check_user = $this->beats_model->select_data('*' , 'Officer_Abuse','','',array('OfficerAbuse_id','DESC'));
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsOfficer_AbuseNew($officer_id, $startdate, $enddate)
	{



		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Officer_Abuse.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Officer_Abuse.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Officer_Abuse.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'), '', $dt);

			$date_s = "Officer_Abuse.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Officer_Abuse.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Officer_Abuse.*', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Officer_Abuse.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Officer_Abuse.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Officer_Abuse.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'), '', $dt);

			$date_s = "Officer_Abuse.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Officer_Abuse.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Officer_Abuse.*', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
		}



		// $check_user = $this->beats_model->select_data('*' , 'Officer_Abuse','','',array('OfficerAbuse_id','DESC'));
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
					'date_time_new' => $this->getDayNew($resmt['OfficerAbuse_date'] . ' ' . substr($resmt['OfficerAbuse_tym'], 0, -3) . " " . substr($resmt['OfficerAbuse_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsCommend_Officer()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Commend_Officer.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Commend_Officer.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Commend_Officer', array('Commend_Officer.user_type' => '1'), '', array('CommendOffice_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Commend_Officer.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Commend_Officer.*,('user') as type", 'Commend_Officer', array('Commend_Officer.user_type' => '0'), '', array('CommendOffice_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Commend_Officer.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Commend_Officer.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Commend_Officer', array('Commend_Officer.user_type' => '1', 'Commend_Officer.Location' => "$state"), '', array('CommendOffice_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Commend_Officer.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Commend_Officer.*,('user') as type", 'Commend_Officer', array('Commend_Officer.user_type' => '0', 'Commend_Officer.Location' => "$state"), '', array('CommendOffice_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			}
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsCommend_OfficerNew($officer_id, $startdate, $enddate)
	{


		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Commend_Officer.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Commend_Officer.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Commend_Officer.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'), '', $dt);

			$date_s = "Commend_Officer.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Commend_Officer.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Commend_Officer.*', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Commend_Officer.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Commend_Officer.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Commend_Officer.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'), '', $dt);

			$date_s = "Commend_Officer.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Commend_Officer.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Commend_Officer.*', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
		}

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
					'date_time_new' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsStolenVehicle_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=StolenVehicle_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,StolenVehicle_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'StolenVehicle_report', array('StolenVehicle_report.user_type' => '1'), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=StolenVehicle_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,StolenVehicle_report.*,('user') as type", 'StolenVehicle_report', array('StolenVehicle_report.user_type' => '0'), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=StolenVehicle_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,StolenVehicle_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'StolenVehicle_report', array('StolenVehicle_report.user_type' => '1', 'StolenVehicle_report.Vehicle_lastlocation' => "$state"), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=StolenVehicle_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,StolenVehicle_report.*,('user') as type", 'StolenVehicle_report', array('StolenVehicle_report.user_type' => '0', 'StolenVehicle_report.Vehicle_lastlocation' => "$state"), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsStolenVehicle_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "StolenVehicle_report.user_type = '1' AND Vehicle_lastlocation Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=StolenVehicle_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,StolenVehicle_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'), '', $dt);

			$date_s = "StolenVehicle_report.user_type = '0' AND Vehicle_lastlocation Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=StolenVehicle_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,StolenVehicle_report.*', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "StolenVehicle_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=StolenVehicle_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,StolenVehicle_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'), '', $dt);

			$date_s = "StolenVehicle_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=StolenVehicle_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,StolenVehicle_report.*', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['StolenVehicle_report_date'] . ' ' . substr($resmt['StolenVehicle_report_tym'], 0, -3) . " " . substr($resmt['StolenVehicle_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsMissing_Persons_report()
	{

		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$date_s = "Missing_Persons_report.user_type = '1'";
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Missing_Persons_report.user_id')));
				$check_user1 = $this->beats_model->select_data('Officer.*,Missing_Persons_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Missing_Persons_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Missing_Persons_report.*,('user') as type", 'Missing_Persons_report', array('Missing_Persons_report.user_type' => '0'), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];

				$date_s = "Missing_Persons_report.user_type = '1' AND Last_Seen_Location Like" . "'%" . $state . '%' . "'";
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Missing_Persons_report.user_id')));
				$check_user1 = $this->beats_model->select_data('Officer.*,Missing_Persons_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'), '', $dt);

				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Missing_Persons_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Missing_Persons_report.*,('user') as type", 'Missing_Persons_report', array('Missing_Persons_report.user_type' => '0', 'Missing_Persons_report.Last_Seen_Location' => "$state"), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsMissing_Persons_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Missing_Persons_report.user_type = '1' AND Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Missing_Persons_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Missing_Persons_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'), '', $dt);

			$date_s = "Missing_Persons_report.user_type = '0' AND Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Missing_Persons_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Missing_Persons_report.*', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Missing_Persons_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Missing_Persons_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Missing_Persons_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'), '', $dt);

			$date_s = "Missing_Persons_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Missing_Persons_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Missing_Persons_report.*', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Missing_Persons_report_Date'] . ' ' . substr($resmt['Missing_Persons_report_tym'], 0, -3) . " " . substr($resmt['Missing_Persons_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsLodgecomplaint_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Lodgecomplaint_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Lodgecomplaint_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_type' => '1'), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Lodgecomplaint_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Lodgecomplaint_report.*,('user') as type", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_type' => '0'), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Lodgecomplaint_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Lodgecomplaint_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_type' => '1', 'Lodgecomplaint_report.Location' => "$state"), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Lodgecomplaint_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Lodgecomplaint_report.*,('user') as type", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_type' => '0', 'Lodgecomplaint_report.Location' => "$state"), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsLodgecomplaint_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Lodgecomplaint_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Lodgecomplaint_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Lodgecomplaint_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);

			$date_s = "Lodgecomplaint_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Lodgecomplaint_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Lodgecomplaint_report.*', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Lodgecomplaint_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Lodgecomplaint_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Lodgecomplaint_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);

			$date_s = "Lodgecomplaint_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Lodgecomplaint_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Lodgecomplaint_report.*', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Lodgecomplaint_report_Date'] . ' ' . substr($resmt['Lodgecomplaint_report_tym'], 0, -3) . " " . substr($resmt['Lodgecomplaint_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsGun_Violence_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Gun_Violence_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Gun_Violence_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Gun_Violence_report', array('Gun_Violence_report.user_type' => '1'), '', array('GunViolence_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Gun_Violence_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Gun_Violence_report.*,('user') as type", 'Gun_Violence_report', array('Gun_Violence_report.user_type' => '0'), '', array('GunViolence_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Gun_Violence_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Gun_Violence_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Gun_Violence_report', array('Gun_Violence_report.user_type' => '1', 'Gun_Violence_report.Location' => "$state"), '', array('GunViolence_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Gun_Violence_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Gun_Violence_report.*,('user') as type", 'Gun_Violence_report', array('Gun_Violence_report.user_type' => '0', 'Gun_Violence_report.Location' => "$state"), '', array('GunViolence_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsGun_Violence_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Gun_Violence_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Gun_Violence_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Gun_Violence_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'), '', $dt);

			$date_s = "Gun_Violence_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Gun_Violence_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Gun_Violence_report.*', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Gun_Violence_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Gun_Violence_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Gun_Violence_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'), '', $dt);

			$date_s = "Gun_Violence_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Gun_Violence_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Gun_Violence_report.*', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['GunViolence_Date'] . ' ' . substr($resmt['GunViolence_tym'], 0, -3) . " " . substr($resmt['GunViolence_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsDrug_Abuse_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Drug_Abuse_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Drug_Abuse_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Drug_Abuse_report', array('Drug_Abuse_report.user_type' => '1'), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Drug_Abuse_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Drug_Abuse_report.*,('user') as type", 'Drug_Abuse_report', array('Drug_Abuse_report.user_type' => '0'), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Drug_Abuse_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Drug_Abuse_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Drug_Abuse_report', array('Drug_Abuse_report.user_type' => '1', 'Drug_Abuse_report.Location' => "$state"), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Drug_Abuse_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Drug_Abuse_report.*,('user') as type", 'Drug_Abuse_report', array('Drug_Abuse_report.user_type' => '0', 'Drug_Abuse_report.Location' => "$state"), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsDrug_Abuse_reportNew($officer_id, $startdate, $enddate)
	{
		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Drug_Abuse_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Drug_Abuse_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Drug_Abuse_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'), '', $dt);

			$date_s = "Drug_Abuse_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Drug_Abuse_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Drug_Abuse_report.*', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Drug_Abuse_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Drug_Abuse_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Drug_Abuse_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'), '', $dt);

			$date_s = "Drug_Abuse_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Drug_Abuse_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Drug_Abuse_report.*', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsDomestic_Violence_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Domestic_Violence_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Domestic_Violence_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Domestic_Violence_report', array('Domestic_Violence_report.user_type' => '1'), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Domestic_Violence_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Domestic_Violence_report.*,('user') as type", 'Domestic_Violence_report', array('Domestic_Violence_report.user_type' => '0'), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Domestic_Violence_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Domestic_Violence_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Domestic_Violence_report', array('Domestic_Violence_report.user_type' => '1', 'Domestic_Violence_report.Location' => "$state"), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Domestic_Violence_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Domestic_Violence_report.*,('user') as type", 'Domestic_Violence_report', array('Domestic_Violence_report.user_type' => '0', 'Domestic_Violence_report.Location' => "$state"), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsDomestic_Violence_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Domestic_Violence_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Domestic_Violence_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Domestic_Violence_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'), '', $dt);

			$date_s = "Domestic_Violence_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Domestic_Violence_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Domestic_Violence_report.*', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Domestic_Violence_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Domestic_Violence_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Domestic_Violence_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'), '', $dt);

			$date_s = "Domestic_Violence_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Domestic_Violence_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Domestic_Violence_report.*', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsTerrorist_Attack_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Terrorist_Attack_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Terrorist_Attack_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Terrorist_Attack_report', array('Terrorist_Attack_report.user_type' => '1'), '', array('TerroristAttack_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Terrorist_Attack_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Terrorist_Attack_report.*,('user') as type", 'Terrorist_Attack_report', array('Terrorist_Attack_report.user_type' => '0'), '', array('TerroristAttack_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Terrorist_Attack_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Terrorist_Attack_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Terrorist_Attack_report', array('Terrorist_Attack_report.user_type' => '1', 'Terrorist_Attack_report.Location' => "$state"), '', array('TerroristAttack_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Terrorist_Attack_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Terrorist_Attack_report.*,('user') as type", 'Terrorist_Attack_report', array('Terrorist_Attack_report.user_type' => '0', 'Terrorist_Attack_report.Location' => "$state"), '', array('TerroristAttack_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsTerrorist_Attack_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Terrorist_Attack_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Terrorist_Attack_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Terrorist_Attack_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'), '', $dt);

			$date_s = "Terrorist_Attack_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Terrorist_Attack_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Terrorist_Attack_report.*', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Terrorist_Attack_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Terrorist_Attack_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Terrorist_Attack_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'), '', $dt);

			$date_s = "Terrorist_Attack_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Terrorist_Attack_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Terrorist_Attack_report.*', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsRape_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Rape_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Rape_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Rape_report', array('Rape_report.user_type' => '1'), '', array('Rape_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Rape_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Rape_report.*,('user') as type", 'Rape_report', array('Rape_report.user_type' => '0'), '', array('Rape_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Rape_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Rape_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Rape_report', array('Rape_report.user_type' => '1', 'Rape_report.Location' => "$state"), '', array('Rape_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Rape_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Rape_report.*,('user') as type", 'Rape_report', array('Rape_report.user_type' => '0', 'Rape_report.Location' => "$state"), '', array('Rape_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
						'time' => $resmt['Rape_report_Date'],
						'date' => $resmt['Rape_report_tym'],
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
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}

				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsRape_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Rape_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Rape_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Rape_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'), '', $dt);

			$date_s = "Rape_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Rape_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Rape_report.*', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Rape_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Rape_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Rape_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'), '', $dt);

			$date_s = "Rape_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Rape_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Rape_report.*', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
		}

		if (!empty($check_user)) {
			$newarr = array();
			foreach ($check_user as $resmt) {
				// if(!empty(json_decode($resmt['media']))){
				//   $newimg=json_decode($resmt['media']);
				//  $imgarray=array();

				//   foreach($newimg as $itm){
				//        $user_img = array(
				// 	'image' =>$itm,
				// 	);
				// 	array_push($imgarray,$user_img);
				//   }
				//             $nefimeimg=implode(',',$newimg);
				//   }else{
				//         $imgarray=array();
				//   }

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
					'time' => $resmt['Rape_report_Date'],
					'date' => $resmt['Rape_report_tym'],
					'date_time_new' => $this->getDayNew($resmt['Rape_report_Date'] . ' ' . substr($resmt['Rape_report_tym'], 0, -3) . " " . substr($resmt['Rape_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
					//'Media' => $imgarray,
					'feedback' => $feedback,
					//'feedbackMedia' => $imgarray1,
					'Status ' => $resmt['Rape_report_status'],
					'created_at' => $this->getDayNew($resmt['created_at']),
					'user_name' => $resmt['user_name'],
					'user_phone' => $resmt['user_phone'],



				);
				array_push($newarr, $user_detail);
			}
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsKidnap_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$date_s = "Kidnap_report.user_type = '1'";
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Kidnap_report.user_id')));
				$check_user1 = $this->beats_model->select_data('Officer.*,Kidnap_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'), '', $dt);


				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Kidnap_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Kidnap_report.*,('user') as type", 'Kidnap_report', array('Kidnap_report.user_type' => '0'), '', array('Kidnap_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$date_s = "Kidnap_report.user_type = '1' AND Last_Seen_Location Like" . "'%" . $state . '%' . "'";
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Kidnap_report.user_id')));
				$check_user1 = $this->beats_model->select_data('Officer.*,Kidnap_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'), '', $dt);

				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Kidnap_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Kidnap_report.*,('user') as type", 'Kidnap_report', array('Kidnap_report.user_type' => '0', 'Kidnap_report.Last_Seen_Location' => "$state"), '', array('Kidnap_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
						'Missing_Persons_report_id' => $resmt['Kidnap_report_id'],
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsKidnap_reportNew($officer_id, $startdate, $enddate)
	{
		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Kidnap_report.user_type = '1' AND Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Kidnap_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Kidnap_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'), '', $dt);

			$date_s = "Kidnap_report.user_type = '0' AND Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Kidnap_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Kidnap_report.*', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Kidnap_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Kidnap_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Kidnap_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'), '', $dt);

			$date_s = "Kidnap_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Kidnap_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Kidnap_report.*', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'Missing_Persons_report_id' => $resmt['Kidnap_report_id'],
					'Full_Name' => $resmt['Full_Name'],
					'Age' => $resmt['Age'],
					'Sex' => $resmt['Sex'],
					'Description' => $resmt['Description'],
					'Last_Seen_Location' => $resmt['Last_Seen_Location'],
					'Spoken_Language' => $resmt['Spoken_Language'],
					'time' => $resmt['Kidnap_report_tym'],
					'date' => $resmt['Kidnap_report_Date'],
					'date_time_new' => $this->getDayNew($resmt['Kidnap_report_Date'] . ' ' . substr($resmt['Kidnap_report_tym'], 0, -3) . " " . substr($resmt['Kidnap_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsRobbery_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Robbery_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Robbery_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Robbery_report', array('Robbery_report.user_type' => '1'), '', array('Robbery_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Robbery_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Robbery_report.*,('user') as type", 'Robbery_report', array('Robbery_report.user_type' => '0'), '', array('Robbery_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Robbery_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Robbery_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Robbery_report', array('Robbery_report.user_type' => '1', 'Robbery_report.Location' => "$state"), '', array('Robbery_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Robbery_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Robbery_report.*,('user') as type", 'Robbery_report', array('Robbery_report.user_type' => '0', 'Robbery_report.Location' => "$state"), '', array('Robbery_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsRobbery_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Robbery_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Robbery_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Robbery_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'), '', $dt);

			$date_s = "Robbery_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Robbery_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Robbery_report.*', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Robbery_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Robbery_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Robbery_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'), '', $dt);

			$date_s = "Robbery_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Robbery_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Robbery_report.*', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Robbery_report_Date'] . ' ' . substr($resmt['Robbery_report_tym'], 0, -3) . " " . substr($resmt['Robbery_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsBurglary_report()
	{

		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Burglary_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Burglary_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Burglary_report', array('Burglary_report.user_type' => '1'), '', array('Burglary_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Burglary_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Burglary_report.*,('user') as type", 'Burglary_report', array('Burglary_report.user_type' => '0'), '', array('Burglary_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Burglary_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Burglary_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Burglary_report', array('Burglary_report.user_type' => '1', 'Burglary_report.Location' => "$state"), '', array('Burglary_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Burglary_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Burglary_report.*,('user') as type", 'Burglary_report', array('Burglary_report.user_type' => '0', 'Burglary_report.Location' => "$state"), '', array('Burglary_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsBurglary_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Burglary_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Burglary_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Burglary_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'), '', $dt);

			$date_s = "Burglary_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Burglary_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Burglary_report.*', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Burglary_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Burglary_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Burglary_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'), '', $dt);

			$date_s = "Burglary_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Burglary_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Burglary_report.*', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time' => $this->getDayNew($resmt['created_at']),
					'date_time_new' => $this->getDayNew($resmt['Burglary_report_Date'] . ' ' . substr($resmt['Burglary_report_tym'], 0, -3) . " " . substr($resmt['Burglary_report_tym'], -2, 5)),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsCybercrimeFraud_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=CybercrimeFraud_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,CybercrimeFraud_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'CybercrimeFraud_report', array('CybercrimeFraud_report.user_type' => '1'), '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=CybercrimeFraud_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,CybercrimeFraud_report.*,('user') as type", 'CybercrimeFraud_report', array('CybercrimeFraud_report.user_type' => '0'), '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=CybercrimeFraud_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,CybercrimeFraud_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'CybercrimeFraud_report', array('CybercrimeFraud_report.user_type' => '1', 'CybercrimeFraud_report.Location' => "$state"), '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=CybercrimeFraud_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,CybercrimeFraud_report.*,('user') as type", 'CybercrimeFraud_report', array('CybercrimeFraud_report.user_type' => '0', 'CybercrimeFraud_report.Location' => "$state"), '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsCybercrimeFraud_reportNew($officer_id, $startdate, $enddate)
	{
		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "CybercrimeFraud_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=CybercrimeFraud_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,CybercrimeFraud_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);

			$date_s = "CybercrimeFraud_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=CybercrimeFraud_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,CybercrimeFraud_report.*', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "CybercrimeFraud_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=CybercrimeFraud_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,CybercrimeFraud_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);

			$date_s = "CybercrimeFraud_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=CybercrimeFraud_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,CybercrimeFraud_report.*', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['CybercrimeFraud_report_Date'] . ' ' . substr($resmt['CybercrimeFraud_report_tym'], 0, -3) . " " . substr($resmt['CybercrimeFraud_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsSubmit_Tip_report()
	{

		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Submit_Tip_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Submit_Tip_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Submit_Tip_report', array('Submit_Tip_report.user_type' => '1'), '', array('Submit_Tip_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Submit_Tip_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Submit_Tip_report.*,('user') as type", 'Submit_Tip_report', array('Submit_Tip_report.user_type' => '0'), '', array('Submit_Tip_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Submit_Tip_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Submit_Tip_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Submit_Tip_report', array('Submit_Tip_report.user_type' => '1', 'Submit_Tip_report.Location' => "$state"), '', array('Submit_Tip_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Submit_Tip_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Submit_Tip_report.*,('user') as type", 'Submit_Tip_report', array('Submit_Tip_report.user_type' => '0', 'Submit_Tip_report.Location' => "$state"), '', array('Submit_Tip_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsSubmit_Tip_reportNew($officer_id, $startdate, $enddate)
	{
		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Submit_Tip_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Submit_Tip_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Submit_Tip_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'), '', $dt);

			$date_s = "Submit_Tip_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Submit_Tip_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Submit_Tip_report.*', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Submit_Tip_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Submit_Tip_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Submit_Tip_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'), '', $dt);

			$date_s = "Submit_Tip_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Submit_Tip_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Submit_Tip_report.*', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsOthers_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Others_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Others_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Others_report', array('Others_report.user_type' => '1'), '', array('Others_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Others_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Others_report.*,('user') as type", 'Others_report', array('Others_report.user_type' => '0'), '', array('Others_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Others_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Others_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Others_report', array('Others_report.user_type' => '1', 'Others_report.Location' => "$state"), '', array('Others_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Others_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Others_report.*,('user') as type", 'Others_report', array('Others_report.user_type' => '0', 'Others_report.Location' => "$state"), '', array('Others_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsOthers_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Others_report.user_type = '1' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Others_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Others_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'), '', $dt);

			$date_s = "Others_report.user_type = '0' AND Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Others_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Others_report.*', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Others_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Others_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Others_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'), '', $dt);

			$date_s = "Others_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Others_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Others_report.*', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Date'] . ' ' . substr($resmt['tym'], 0, -3) . " " . substr($resmt['tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}
	public function FiledReportsVandalism_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Vandalism_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Vandalism_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Vandalism_report', array('Vandalism_report.user_type' => '1'), '', array('Vandalism_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vandalism_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Vandalism_report.*,('user') as type", 'Vandalism_report', array('Vandalism_report.user_type' => '0'), '', array('Vandalism_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Vandalism_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Vandalism_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Vandalism_report', array('Vandalism_report.user_type' => '1', 'Vandalism_report.Name' => "$state"), '', array('Vandalism_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vandalism_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Vandalism_report.*,('user') as type", 'Vandalism_report', array('Vandalism_report.user_type' => '0', 'Vandalism_report.Name' => "$state"), '', array('Vandalism_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsVandalism_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Vandalism_report.user_type = '1' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Vandalism_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Vandalism_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'), '', $dt);

			$date_s = "Vandalism_report.user_type = '0' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vandalism_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Vandalism_report.*', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Vandalism_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Vandalism_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Vandalism_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'), '', $dt);

			$date_s = "Vandalism_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vandalism_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Vandalism_report.*', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Vandalism_report_Date'] . ' ' . substr($resmt['Vandalism_report_tym'], 0, -3) . " " . substr($resmt['Vandalism_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}

	public function FiledReportsFire_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Fire_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Fire_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Fire_report', array('Fire_report.user_type' => '1'), '', array('Fire_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Fire_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Fire_report.*,('user') as type", 'Fire_report', array('Fire_report.user_type' => '0'), '', array('Fire_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Fire_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Fire_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Fire_report', array('Fire_report.user_type' => '1', 'Fire_report.Name' => "$state"), '', array('Fire_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Fire_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Fire_report.*,('user') as type", 'Fire_report', array('Fire_report.user_type' => '0', 'Fire_report.Name' => "$state"), '', array('Fire_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsFire_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Fire_report.user_type = '1' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Fire_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Fire_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'), '', $dt);

			$date_s = "Fire_report.user_type = '0' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Fire_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Fire_report.*', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Fire_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Fire_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Fire_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'), '', $dt);

			$date_s = "Fire_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Fire_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Fire_report.*', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Fire_report_Date'] . ' ' . substr($resmt['Fire_report_tym'], 0, -3) . " " . substr($resmt['Fire_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}

	public function FiledReportsAccident_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Accident_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Accident_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Accident_report', array('Accident_report.user_type' => '1'), '', array('Accident_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Accident_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Accident_report.*,('user') as type", 'Accident_report', array('Accident_report.user_type' => '0'), '', array('Accident_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Accident_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Accident_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Accident_report', array('Accident_report.user_type' => '1', 'Accident_report.Name' => "$state"), '', array('Accident_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Accident_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Accident_report.*,('user') as type", 'Accident_report', array('Accident_report.user_type' => '0', 'Accident_report.Name' => "$state"), '', array('Accident_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsAccident_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Accident_report.user_type = '1' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Accident_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Accident_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'), '', $dt);

			$date_s = "Accident_report.user_type = '0' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Accident_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Accident_report.*', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Accident_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Accident_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Accident_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'), '', $dt);

			$date_s = "Accident_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Accident_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Accident_report.*', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Accident_report_Date'] . ' ' . substr($resmt['Accident_report_tym'], 0, -3) . " " . substr($resmt['Accident_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}

	public function FiledReportsMedical_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Medical_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Medical_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Medical_report', array('Medical_report.user_type' => '1'), '', array('Medical_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Medical_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Medical_report.*,('user') as type", 'Medical_report', array('Medical_report.user_type' => '0'), '', array('Medical_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Medical_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Medical_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Medical_report', array('Medical_report.user_type' => '1', 'Medical_report.Name' => "$state"), '', array('Medical_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Medical_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Medical_report.*,('user') as type", 'Medical_report', array('Medical_report.user_type' => '0', 'Medical_report.Name' => "$state"), '', array('Medical_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsMedical_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Medical_report.user_type = '1' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Medical_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Medical_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'), '', $dt);

			$date_s = "Medical_report.user_type = '0' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Medical_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Medical_report.*', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Medical_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Medical_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Medical_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'), '', $dt);

			$date_s = "Medical_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Medical_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Medical_report.*', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Medical_report_Date'] . ' ' . substr($resmt['Medical_report_tym'], 0, -3) . " " . substr($resmt['Medical_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}

	public function FiledReportsRiot_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Riot_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Riot_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Riot_report', array('Riot_report.user_type' => '1'), '', array('Riot_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Riot_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Riot_report.*,('user') as type", 'Riot_report', array('Riot_report.user_type' => '0'), '', array('Riot_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Riot_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Riot_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Riot_report', array('Riot_report.user_type' => '1', 'Riot_report.Name' => "$state"), '', array('Riot_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Riot_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Riot_report.*,('user') as type", 'Riot_report', array('Riot_report.user_type' => '0', 'Riot_report.Name' => "$state"), '', array('Riot_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsRiot_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Riot_report.user_type = '1' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Riot_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Riot_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'), '', $dt);

			$date_s = "Riot_report.user_type = '0' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Riot_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Riot_report.*', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Riot_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Riot_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Riot_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'), '', $dt);

			$date_s = "Riot_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Riot_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Riot_report.*', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Riot_report_Date'] . ' ' . substr($resmt['Riot_report_tym'], 0, -3) . " " . substr($resmt['Riot_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}

	public function FiledReportsEnvironmental_Hazard_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Environmental_Hazard_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Environmental_Hazard_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_type' => '1'), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Environmental_Hazard_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Environmental_Hazard_report.*,('user') as type", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_type' => '0'), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Environmental_Hazard_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Environmental_Hazard_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_type' => '1', 'Environmental_Hazard_report.Name' => "$state"), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Environmental_Hazard_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Environmental_Hazard_report.*,('user') as type", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_type' => '0', 'Environmental_Hazard_report.Name' => "$state"), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsEnvironmental_Hazard_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Environmental_Hazard_report.user_type = '1' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Environmental_Hazard_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Environmental_Hazard_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);

			$date_s = "Environmental_Hazard_report.user_type = '0' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Environmental_Hazard_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Environmental_Hazard_report.*', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Environmental_Hazard_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Environmental_Hazard_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Environmental_Hazard_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);

			$date_s = "Environmental_Hazard_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Environmental_Hazard_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Environmental_Hazard_report.*', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Environmental_Hazard_report_Date'] . ' ' . substr($resmt['Environmental_Hazard_report_tym'], 0, -3) . " " . substr($resmt['Environmental_Hazard_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}

	public function FiledReportsChild_Abuse_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Child_Abuse_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Child_Abuse_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Child_Abuse_report', array('Child_Abuse_report.user_type' => '1'), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Child_Abuse_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Child_Abuse_report.*,('user') as type", 'Child_Abuse_report', array('Child_Abuse_report.user_type' => '0'), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Child_Abuse_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Child_Abuse_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Child_Abuse_report', array('Child_Abuse_report.user_type' => '1', 'Child_Abuse_report.Name' => "$state"), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Child_Abuse_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Child_Abuse_report.*,('user') as type", 'Child_Abuse_report', array('Child_Abuse_report.user_type' => '0', 'Child_Abuse_report.Name' => "$state"), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsChild_Abuse_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Child_Abuse_report.user_type = '1' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Child_Abuse_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Child_Abuse_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'), '', $dt);

			$date_s = "Child_Abuse_report.user_type = '0' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Child_Abuse_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Child_Abuse_report.*', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Child_Abuse_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Child_Abuse_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Child_Abuse_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'), '', $dt);

			$date_s = "Child_Abuse_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Child_Abuse_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Child_Abuse_report.*', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Child_Abuse_report_Date'] . ' ' . substr($resmt['Child_Abuse_report_tym'], 0, -3) . " " . substr($resmt['Child_Abuse_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}

	public function FiledReportsHuman_Trafficking_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Human_Trafficking_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Human_Trafficking_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Human_Trafficking_report', array('Human_Trafficking_report.user_type' => '1'), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Human_Trafficking_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Human_Trafficking_report.*,('user') as type", 'Human_Trafficking_report', array('Human_Trafficking_report.user_type' => '0'), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Human_Trafficking_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Human_Trafficking_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Human_Trafficking_report', array('Human_Trafficking_report.user_type' => '1', 'Human_Trafficking_report.Name' => "$state"), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Human_Trafficking_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Human_Trafficking_report.*,('user') as type", 'Human_Trafficking_report', array('Human_Trafficking_report.user_type' => '0', 'Human_Trafficking_report.Name' => "$state"), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsHuman_Trafficking_reportNew($officer_id, $startdate, $enddate)
	{

		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Human_Trafficking_report.user_type = '1' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Human_Trafficking_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Human_Trafficking_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);

			$date_s = "Human_Trafficking_report.user_type = '0' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Human_Trafficking_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Human_Trafficking_report.*', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Human_Trafficking_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Human_Trafficking_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Human_Trafficking_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);

			$date_s = "Human_Trafficking_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Human_Trafficking_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Human_Trafficking_report.*', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Human_Trafficking_report_Date'] . ' ' . substr($resmt['Human_Trafficking_report_tym'], 0, -3) . " " . substr($resmt['Human_Trafficking_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}

	public function FiledReportsBlow_Whistle_report()
	{
		if (isset($_REQUEST['officer_id']) && !empty($_REQUEST['officer_id'])) {
			$user_id = $_REQUEST['officer_id'];
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $user_id));
			if ($check_type['0']['officer_category'] == 1) {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Blow_Whistle_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Blow_Whistle_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Blow_Whistle_report', array('Blow_Whistle_report.user_type' => '1'), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Blow_Whistle_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Blow_Whistle_report.*,('user') as type", 'Blow_Whistle_report', array('Blow_Whistle_report.user_type' => '0'), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Blow_Whistle_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Blow_Whistle_report.*,('officer') as type, (Full_Name) as user_name, (phone) as user_phone", 'Blow_Whistle_report', array('Blow_Whistle_report.user_type' => '1', 'Blow_Whistle_report.Name' => "$state"), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
				$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Blow_Whistle_report.user_id')));
				$check_user2 = $this->beats_model->select_data("user_signup.*,Blow_Whistle_report.*,('user') as type", 'Blow_Whistle_report', array('Blow_Whistle_report.user_type' => '0', 'Blow_Whistle_report.Name' => "$state"), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
				$check_user = array_merge($check_user1, $check_user2);
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
				// arsort($newarr);
				$newarrs = $newarr;
				arsort($newarrs);
				$newarr = array();
				foreach ($newarrs as $ns) {
					array_push($newarr, $ns);
				}
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}
	public function FiledReportsBlow_Whistle_reportNew($officer_id, $startdate, $enddate)
	{
		$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $officer_id));
		if ($check_type['0']['officer_category'] == 0) {
			$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			$state = $check_user_meta[0]['lga_state'];

			$date_s = "Blow_Whistle_report.user_type = '1' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Blow_Whistle_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Blow_Whistle_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);

			$date_s = "Blow_Whistle_report.user_type = '0' AND Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Blow_Whistle_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Blow_Whistle_report.*', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);

			$check_user = array_merge($check_user1, $check_user2);
		} else {
			$date_s = "Blow_Whistle_report.user_type = '1' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Blow_Whistle_report.user_id')));
			$check_user1 = $this->beats_model->select_data('Officer.*,Blow_Whistle_report.*,(Officer.Full_Name) as user_name, (Officer.phone) as user_phone', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);

			$date_s = "Blow_Whistle_report.user_type = '0' AND date(created_at) BETWEEN date('" . $startdate . "') AND date('" . $enddate . "')";
			$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Blow_Whistle_report.user_id')));
			$check_user2 = $this->beats_model->select_data('user_signup.*,Blow_Whistle_report.*', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
			$check_user = array_merge($check_user1, $check_user2);
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
					'date_time_new' => $this->getDayNew($resmt['Blow_Whistle_report_Date'] . ' ' . substr($resmt['Blow_Whistle_report_tym'], 0, -3) . " " . substr($resmt['Blow_Whistle_report_tym'], -2, 5)),
					'date_time' => $this->getDayNew($resmt['created_at']),
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
			// arsort($newarr);
			$newarrs = $newarr;
			arsort($newarrs);
			$newarr = array();
			foreach ($newarrs as $ns) {
				array_push($newarr, $ns);
			}
			echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $newarr));
		} else {
			echo json_encode(array('status' => false, 'message' => 'No data found.')); // wrong details
		}
	}

	public  function getAllenotice($user_id, $enotice_type)
	{
		$qr = "user_id = '" . $user_id . "' and enotice_type = '" . $enotice_type . "'";
		$check_enotis = $this->beats_model->select_data('*,(DATE_FORMAT(created_at,"%W %d/%m/%Y %l:%i %p")) as date_time_notice', 'Officerenotice_all', $qr, '', array('enotice_all_id', 'desc'));
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
							'Document' => $resmt['Document'],
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
							'Document' => $resmt['Document']
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

	public function Nearby()
	{
		if (isset($_POST['UnitType']) && isset($_POST['Latitude']) && isset($_POST['Longitude'])) {
			$check_user = $this->beats_model->select_data('*', 'PoliceUnit', '', array(1, 0), array('PoliceUnit_id', 'DESC'));

			if (!empty($check_user)) {
				echo json_encode(array('status' => true, 'message' => 'Successful.', 'Details' => $check_user));
			} else {


				echo json_encode(array('status' => true, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function Reports()
	{

		if (isset($_POST['Officer_id'])) {


			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));

			if ($check_type['0']['POLICE_INTERFACE_id'] == 2 || $check_type['0']['POLICE_INTERFACE_id'] == 3) {

				$stated = $check_type['0']['State_Deployment'];

				$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));


				$a = "current_location Like" . "'%" . $stated . '%' . "'";

				$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			} else {

				$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));


				$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', '', '', array('SOS_id', 'DESC'), '', $dt);
			}


			// echo $this->db->last_query();
			// die;

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
						// $nefimeimg=implode(',',$newimg);
					} else {
						$imgarray = array();
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
						'update_at' => $resmt['update_at'],
						'SOS_staus' => $resmt['SOS_staus'],

						'Media' => $imgarray


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


	public function SearchFiledReport()
	{

		if (isset($_POST['cat_id']) && isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['officer_id'])) {
			$_POST['Officer_id'] = $_POST['officer_id'];
			switch (trim($_POST['cat_id'])) {
				case "1":
					$lang = "iWitness";
					$this->FiledReportsiWitnessNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "2":
					$lang = "StolenVehicle_report";
					$this->FiledReportsStolenVehicle_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "3":
					$lang = "Missing_Persons_report";
					$this->FiledReportsMissing_Persons_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "4":
					$lang = "Lodgecomplaint_report";
					$this->FiledReportsLodgecomplaint_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "5":
					$lang = "Gun_Violence_report";
					$this->FiledReportsGun_Violence_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "6":
					$lang = "Drug_Abuse_report";
					$this->FiledReportsDrug_Abuse_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "7":
					$lang = "Domestic_Violence_report";
					$this->FiledReportsDomestic_Violence_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "8":
					$lang = "Rape_report";
					$this->FiledReportsRape_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "9":
					$lang = "Kidnap_report";
					$this->FiledReportsKidnap_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "10":
					$lang = "Robbery_report";
					$this->FiledReportsRobbery_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "11":
					$lang = "Burglary_report";
					$this->FiledReportsBurglary_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "12":
					$lang = "Submit_Tip_report";
					$this->FiledReportsSubmit_Tip_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "13":
					$lang = "Vandalism_report";
					$this->FiledReportsVandalism_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "14":
					$lang = "Fire_report";
					$this->FiledReportsFire_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "15":
					$lang = "Accident_report";
					$this->FiledReportsAccident_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "16":
					$lang = "Medical_report";
					$this->FiledReportsMedical_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "17":
					$lang = "Riot_report";
					$this->FiledReportsRiot_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "18":
					$lang = "Environmental_Hazard_report";
					$this->FiledReportsEnvironmental_Hazard_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "19":
					$lang = "Child_Abuse_report";
					$this->FiledReportsChild_Abuse_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "20":
					$lang = "Human_Trafficking_report";
					$this->FiledReportsHuman_Trafficking_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "21":
					$lang = "Blow_Whistle_report";
					$this->FiledReportsBlow_Whistle_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "22":
					$lang = "Officer_Abuse";
					$this->FiledReportsOfficer_AbuseNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "23":
					$lang = "Commend_Officer";
					$this->FiledReportsCommend_OfficerNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "24":
					$lang = "Terrorist_Attack_report";
					$this->FiledReportsTerrorist_Attack_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "25":
					$lang = "CybercrimeFraud_report";
					$this->FiledReportsCybercrimeFraud_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				case "26":
					$lang = "Others_report";
					$this->FiledReportsOthers_reportNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
					break;
				default:
					$lang = "iWitness";
					$this->FiledReportsiWitnessNew($_POST['Officer_id'], $_POST['startdate'], $_POST['enddate']);
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}



	public function SearchReports()
	{

		if (isset($_POST['Officer_id']) && isset($_POST['fday']) && isset($_POST['fmonth']) && isset($_POST['fyear']) && isset($_POST['tday']) && isset($_POST['tmonth']) && isset($_POST['tyear'])) {


			// $dts = array('multiple', array(array('user_officer_meta', 'user_officer_meta.user_id=Officer.Officer_id', '')));
			$check_type = $this->beats_model->select_data('*', 'Officer', "Officer_id = '" . $_POST['Officer_id'] . "'", '', array('Officer.Officer_id', 'DESC'), '', '');
			// print_r($check_type);
			// echo $this->db->last_query();
			// die;
			// $check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));

			// if ($check_type['0']['POLICE_INTERFACE_id'] == 2 || $check_type['0']['POLICE_INTERFACE_id'] == 3) {
			// 	$stated = $check_type['0']['State_Deployment'];
			// 	$a = "current_location Like" . "'%" . $stated . '%' . "'";
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// } else {
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', '', '', array('SOS_id', 'DESC'), '', $dt);
			// }
			$start = $_POST['fyear'] . '/' . $_POST['fmonth'] . '/' . $_POST['fday'];
			$end = $_POST['tyear'] . '/' . $_POST['tmonth'] . '/' . $_POST['tday'];
			$dss = " SOSManagement.created_dateat BETWEEN '" . date("Y/m/d", strtotime($start)) . "'" . " AND '" . date("Y/m/d", strtotime($end)) . "'";
			// if ($check_type[0]['officer_category'] == 1) {
			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $dss, '', array('SOS_id', 'DESC'), '', $dt);

			// } else {

			// 	$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			// 	$a = "SOSManagement.current_location Like" . "'%" . $check_user_meta[0]['lga_state'] . '%' . "' and " . $dss;
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// }



			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					$fs = $this->Nearbysos($check_type['0']['Officer_id'], $resmt['lat'], $resmt['lang'], $check_type['0']['officer_category']);
					if ($fs == 1) {
						if (!empty($resmt['images'])) {
							$newimg = json_decode($resmt['images']);
							$imgarray = array();
							if (!empty($newimg)) {
								foreach ($newimg as $itm) {
									$user_img = array(
										'image' => $itm
									);
									array_push($imgarray, $user_img);
								}
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

									$feedname = (!empty($check_name) ? $check_name[0]['Full_Name'] : '');
									if (!empty($check_name)) {
										$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_name['0']['Officer_id']));
										$rank = $check_name[0]['Rank'];
										$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
									} else {
										$rank = '';
										$agency = '';
									}
								} else {
									$feedname = 'Admin';
									$rank = '';
									$agency = '';
								}

								if (!empty(json_decode($feed['feedbackMedia']))) {
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
							'Media' => $imgarray
						);
						array_push($newarr, $user_detail);
					}
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


	public function Analytics()
	{

		if (isset($_POST['Officer_id'])) {


			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));

			if ($check_type['0']['POLICE_INTERFACE_id'] == 2 || $check_type['0']['POLICE_INTERFACE_id'] == 3) {

				$stated = $check_type['0']['State_Deployment'];
				$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
				$a = "current_location Like" . "'%" . $stated . '%' . "'";
				$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			} else {
				$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
				$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', '', '', array('SOS_id', 'DESC'), '', $dt);
			}


			// echo $this->db->last_query();
			// die;

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
						// $nefimeimg=implode(',',$newimg);
					} else {
						$imgarray = array();
					}

					$user_detail = array(
						'SOS_id' =>	$resmt['SOS_id'],
						'created_at' =>	$resmt['created_at'],
						'ttl_sos' =>	2,


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

	public function SearchAnalyticsfield()
	{

		if (isset($_POST['Officer_id']) && isset($_POST['startdate']) && isset($_POST['enddate'])) {


			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));
			$newarr = array();
			// if ($check_type['0']['POLICE_INTERFACE_id'] == 2 || $check_type['0']['POLICE_INTERFACE_id'] == 3) {
			if ($check_type['0']['officer_category'] == 1) {

				$date_s = "date(created_at) BETWEEN date('" . date("Y-m-d", strtotime(str_replace('%2F', '-', $_POST['startdate']))) . "') AND date('" . date("Y-m-d", strtotime(urldecode(str_replace('%2F', '-', $_POST['enddate'])))) . "')";
				$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
				$data['result1'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'));
				$data['result2'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'));
				$data['result3'] = $this->beats_model->select_data('*,(Vehicle_lastlocation) as GeoLocationnew', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'));
				$data['result4'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'));
				$data['result5'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'));
				$data['result6'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'));
				$data['result7'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'));
				$data['result8'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'));
				$data['result9'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'));
				$data['result10'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'));
				$data['result11'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'));
				$data['result12'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'));
				$data['result13'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'));
				$data['result14'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'));
				$data['result15'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'));
				$data['result16'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'));
				$data['result17'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'));
				$data['result18'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'));
				$data['result19'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'));
				$data['result20'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'));
				$data['result21'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'));
				$data['result22'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'));
				$data['result23'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'));
				$data['result24'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'));
				$data['result25'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'));
			} else {

				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$state = $check_user_meta[0]['lga_state'];

				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
				
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result1'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result2'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'));
				$date_s = "Vehicle_lastlocation Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result3'] = $this->beats_model->select_data('*,(Vehicle_lastlocation) as GeoLocationnew', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'));
				$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result4'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result5'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result6'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result7'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result8'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result9'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result10'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'));
				$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result11'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result12'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result13'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result14'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result15'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'));
				$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result16'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'));
				$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result17'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'));
				$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result18'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'));
				$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result19'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'));
				$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result20'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'));
				$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result21'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'));
				$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result22'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'));
				$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result23'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'));
				$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result24'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'));
				$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . str_replace('%2F', '-', $_POST['startdate']) . "') AND date('" . str_replace('%2F', '-', $_POST['enddate']) . "')";
				$data['result25'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'));
			}



			$user_detail = array(
				'type' => 'iWitness',
				'ttl_sos' => count($data['result']),
			);
			array_push($newarr, $user_detail);

			$user_detail1 = array(
				'type' => 'Officer Conduct',
				'ttl_sos' => count($data['result1']),
			);
			array_push($newarr, $user_detail1);
			$user_detail2 = array(
				'type' => 'Commend Officer',
				'ttl_sos' => count($data['result2']),
			);
			array_push($newarr, $user_detail2);
			$user_detail3 = array(
				'type' => 'Stolen vehicle',
				'ttl_sos' => count($data['result3']),
			);
			array_push($newarr, $user_detail3);
			$user_detail4 = array(
				'type' => 'Missing Persons',
				'ttl_sos' => count($data['result4']),
			);
			array_push($newarr, $user_detail4);
			$user_detail5 = array(
				'type' => 'Lodge a complaint',
				'ttl_sos' => count($data['result5']),
			);
			array_push($newarr, $user_detail5);
			$user_detail6 = array(
				'type' => 'Gun Violence',
				'ttl_sos' => count($data['result6']),
			);
			array_push($newarr, $user_detail6);
			$user_detail7 = array(
				'type' => 'Drug Abuse',
				'ttl_sos' => count($data['result7']),
			);
			array_push($newarr, $user_detail7);
			$user_detail8 = array(
				'type' => 'Domestic Violence',
				'ttl_sos' => count($data['result8']),
			);
			array_push($newarr, $user_detail8);

			$user_detail9 = array(
				'type' => 'Terrorist Attack',
				'ttl_sos' => count($data['result9']),
			);
			array_push($newarr, $user_detail9);

			$user_detail10 = array(
				'type' => 'Rape',
				'ttl_sos' => count($data['result10']),
			);
			array_push($newarr, $user_detail10);
			$user_detail11 = array(
				'type' => 'Kidnap',
				'ttl_sos' => count($data['result11']),
			);
			array_push($newarr, $user_detail11);
			$user_detail12 = array(
				'type' => 'Robbery',
				'ttl_sos' => count($data['result12']),
			);
			array_push($newarr, $user_detail12);
			$user_detail13 = array(
				'type' => 'Burglary',
				'ttl_sos' => count($data['result13']),
			);
			array_push($newarr, $user_detail13);
			$user_detail14 = array(
				'type' => 'Cybercrime',
				'ttl_sos' => count($data['result14']),
			);
			array_push($newarr, $user_detail14);
			$user_detail15 = array(
				'type' => 'Submit a Tip',
				'ttl_sos' => count($data['result15']),
			);
			array_push($newarr, $user_detail15);
			$user_detail16 = array(
				'type' => 'Other Reports',
				'ttl_sos' => count($data['result16']),
			);
			array_push($newarr, $user_detail16);

			$user_detail17 = array(
				'type' => 'Vandalism Reports',
				'ttl_sos' => count($data['result17']),
			);
			array_push($newarr, $user_detail17);
			$user_detail18 = array(
				'type' => 'Fire Report',
				'ttl_sos' => count($data['result18']),
			);
			array_push($newarr, $user_detail18);
			$user_detail19 = array(
				'type' => 'Accident Report',
				'ttl_sos' => count($data['result19']),
			);
			array_push($newarr, $user_detail19);
			$user_detail20 = array(
				'type' => 'Medical Reports',
				'ttl_sos' => count($data['result20']),
			);
			array_push($newarr, $user_detail20);
			$user_detail21 = array(
				'type' => 'Riot Reports',
				'ttl_sos' => count($data['result21']),
			);
			array_push($newarr, $user_detail21);
			$user_detail22 = array(
				'type' => 'Environmental Hazard Reports',
				'ttl_sos' => count($data['result22']),
			);
			array_push($newarr, $user_detail22);
			$user_detail23 = array(
				'type' => 'Child Abuse Reports',
				'ttl_sos' => count($data['result23']),
			);
			array_push($newarr, $user_detail23);
			$user_detail24 = array(
				'type' => 'Human Trafficking Reports',
				'ttl_sos' => count($data['result24']),
			);
			array_push($newarr, $user_detail24);
			$user_detail25 = array(
				'type' => 'Blow Whistle Reports',
				'ttl_sos' => count($data['result25']),
			);
			array_push($newarr, $user_detail25);



			// echo $this->db->last_query();
			// die;




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

		if (isset($_POST['Officer_id'])) {
			$fl = 0;
			if (isset($_POST['type']) && !empty($_POST['type'])) {
				$fl = ($_POST['type'] == 1) ? 1 : 0;
			}


			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));
			$newarr = array();
			if ($fl == 0) {
				if ($check_type['0']['officer_category'] == 1) {
					$date_s = "";
					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=iWitness.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,iWitness.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'iWitness', array('iWitness.user_type' => '1'), '', array('iWitness_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,iWitness.*,('user') as type", 'iWitness', array('iWitness.user_type' => '0'), '', array('iWitness_id', 'DESC'), '', $dt);
					$data['result'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=StolenVehicle_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,StolenVehicle_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'StolenVehicle_report', array('StolenVehicle_report.user_type' => '1'), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=StolenVehicle_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,StolenVehicle_report.*,('user') as type", 'StolenVehicle_report', array('StolenVehicle_report.user_type' => '0'), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
					$data['result3'] = array_merge($check_user1, $check_user2);


					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Missing_Persons_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Missing_Persons_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Missing_Persons_report', array('Missing_Persons_report.user_type' => '1'), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Missing_Persons_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Missing_Persons_report.*,('user') as type", 'Missing_Persons_report', array('Missing_Persons_report.user_type' => '0'), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
					$data['result4'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Lodgecomplaint_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Lodgecomplaint_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_type' => '1'), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Lodgecomplaint_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Lodgecomplaint_report.*,('user') as type", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_type' => '0'), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
					$data['result5'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Gun_Violence_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Gun_Violence_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Gun_Violence_report', array('Gun_Violence_report.user_type' => '1'), '', array('GunViolence_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Gun_Violence_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Gun_Violence_report.*,('user') as type", 'Gun_Violence_report', array('Gun_Violence_report.user_type' => '0'), '', array('GunViolence_id', 'DESC'), '', $dt);
					$data['result6'] = array_merge($check_user1, $check_user2);


					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Drug_Abuse_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Drug_Abuse_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Drug_Abuse_report', array('Drug_Abuse_report.user_type' => '1'), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Drug_Abuse_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Drug_Abuse_report.*,('user') as type", 'Drug_Abuse_report', array('Drug_Abuse_report.user_type' => '0'), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
					$data['result7'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Domestic_Violence_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Domestic_Violence_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Domestic_Violence_report', array('Domestic_Violence_report.user_type' => '1'), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Domestic_Violence_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Domestic_Violence_report.*,('user') as type", 'Domestic_Violence_report', array('Domestic_Violence_report.user_type' => '0'), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
					$data['result8'] = array_merge($check_user1, $check_user2);


					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Rape_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Rape_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Rape_report', array('Rape_report.user_type' => '1'), '', array('Rape_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Rape_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Rape_report.*,('user') as type", 'Rape_report', array('Rape_report.user_type' => '0'), '', array('Rape_report_id', 'DESC'), '', $dt);
					$data['result10'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Kidnap_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Kidnap_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Kidnap_report', array('Kidnap_report.user_type' => '1'), '', array('Kidnap_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Kidnap_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Kidnap_report.*,('user') as type", 'Kidnap_report', array('Kidnap_report.user_type' => '0'), '', array('Kidnap_report_id', 'DESC'), '', $dt);
					$data['result11'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Robbery_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Robbery_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Robbery_report', array('Robbery_report.user_type' => '1'), '', array('Robbery_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Robbery_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Robbery_report.*,('user') as type", 'Robbery_report', array('Robbery_report.user_type' => '0'), '', array('Robbery_report_id', 'DESC'), '', $dt);
					$data['result12'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Burglary_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Burglary_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Burglary_report', array('Burglary_report.user_type' => '1'), '', array('Burglary_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Burglary_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Burglary_report.*,('user') as type", 'Burglary_report', array('Burglary_report.user_type' => '0'), '', array('Burglary_report_id', 'DESC'), '', $dt);
					$data['result13'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Submit_Tip_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Submit_Tip_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Submit_Tip_report', array('Submit_Tip_report.user_type' => '1'), '', array('Submit_Tip_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Submit_Tip_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Submit_Tip_report.*,('user') as type", 'Submit_Tip_report', array('Submit_Tip_report.user_type' => '0'), '', array('Submit_Tip_id', 'DESC'), '', $dt);
					$data['result15'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Vandalism_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Vandalism_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Vandalism_report', array('Vandalism_report.user_type' => '1'), '', array('Vandalism_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vandalism_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Vandalism_report.*,('user') as type", 'Vandalism_report', array('Vandalism_report.user_type' => '0'), '', array('Vandalism_report_id', 'DESC'), '', $dt);
					$data['result17'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Fire_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Fire_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Fire_report', array('Fire_report.user_type' => '1'), '', array('Fire_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Fire_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Fire_report.*,('user') as type", 'Fire_report', array('Fire_report.user_type' => '0'), '', array('Fire_report_id', 'DESC'), '', $dt);
					$data['result18'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Accident_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Accident_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Accident_report', array('Accident_report.user_type' => '1'), '', array('Accident_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Accident_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Accident_report.*,('user') as type", 'Accident_report', array('Accident_report.user_type' => '0'), '', array('Accident_report_id', 'DESC'), '', $dt);
					$data['result19'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Medical_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Medical_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Medical_report', array('Medical_report.user_type' => '1'), '', array('Medical_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Medical_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Medical_report.*,('user') as type", 'Medical_report', array('Medical_report.user_type' => '0'), '', array('Medical_report_id', 'DESC'), '', $dt);
					$data['result20'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Riot_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Riot_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Riot_report', array('Riot_report.user_type' => '1'), '', array('Riot_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Riot_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Riot_report.*,('user') as type", 'Riot_report', array('Riot_report.user_type' => '0'), '', array('Riot_report_id', 'DESC'), '', $dt);
					$data['result21'] = array_merge($check_user1, $check_user2);


					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Environmental_Hazard_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Environmental_Hazard_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_type' => '1'), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Environmental_Hazard_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Environmental_Hazard_report.*,('user') as type", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_type' => '0'), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
					$data['result22'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Child_Abuse_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Child_Abuse_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Child_Abuse_report', array('Child_Abuse_report.user_type' => '1'), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Child_Abuse_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Child_Abuse_report.*,('user') as type", 'Child_Abuse_report', array('Child_Abuse_report.user_type' => '0'), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
					$data['result23'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Human_Trafficking_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Human_Trafficking_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Human_Trafficking_report', array('Human_Trafficking_report.user_type' => '1'), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Human_Trafficking_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Human_Trafficking_report.*,('user') as type", 'Human_Trafficking_report', array('Human_Trafficking_report.user_type' => '0'), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
					$data['result24'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Blow_Whistle_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Blow_Whistle_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Blow_Whistle_report', array('Blow_Whistle_report.user_type' => '1'), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Blow_Whistle_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Blow_Whistle_report.*,('user') as type", 'Blow_Whistle_report', array('Blow_Whistle_report.user_type' => '0'), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
					$data['result25'] = array_merge($check_user1, $check_user2);
				} else {
					$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
					$state = $check_user_meta[0]['lga_state'];

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=iWitness.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,iWitness.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'iWitness', array('iWitness.user_type' => '1', 'iWitness.Location' => "$state"), '', array('iWitness_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,iWitness.*,('user') as type", 'iWitness', array('iWitness.user_type' => '0', 'iWitness.Location' => "$state"), '', array('iWitness_id', 'DESC'), '', $dt);
					$data['result'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=StolenVehicle_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,StolenVehicle_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'StolenVehicle_report', array('StolenVehicle_report.user_type' => '1', 'StolenVehicle_report.Vehicle_lastlocation' => "$state"), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=StolenVehicle_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,StolenVehicle_report.*,('user') as type", 'StolenVehicle_report', array('StolenVehicle_report.user_type' => '0', 'StolenVehicle_report.Vehicle_lastlocation' => "$state"), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
					$data['result3'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Missing_Persons_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Missing_Persons_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Missing_Persons_report', array('Missing_Persons_report.user_type' => '1', 'Missing_Persons_report.Last_Seen_Location' => "$state"), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Missing_Persons_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Missing_Persons_report.*,('user') as type", 'Missing_Persons_report', array('Missing_Persons_report.user_type' => '0', 'Missing_Persons_report.Last_Seen_Location' => "$state"), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
					$data['result4'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Lodgecomplaint_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Lodgecomplaint_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_type' => '1', 'Lodgecomplaint_report.Location' => "$state"), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Lodgecomplaint_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Lodgecomplaint_report.*,('user') as type", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_type' => '0', 'Lodgecomplaint_report.Location' => "$state"), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
					$data['result5'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Gun_Violence_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Gun_Violence_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Gun_Violence_report', array('Gun_Violence_report.user_type' => '1', 'Gun_Violence_report.Location' => "$state"), '', array('GunViolence_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Gun_Violence_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Gun_Violence_report.*,('user') as type", 'Gun_Violence_report', array('Gun_Violence_report.user_type' => '0', 'Gun_Violence_report.Location' => "$state"), '', array('GunViolence_id', 'DESC'), '', $dt);
					$data['result6'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Drug_Abuse_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Drug_Abuse_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Drug_Abuse_report', array('Drug_Abuse_report.user_type' => '1', 'Drug_Abuse_report.Location' => "$state"), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Drug_Abuse_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Drug_Abuse_report.*,('user') as type", 'Drug_Abuse_report', array('Drug_Abuse_report.user_type' => '0', 'Drug_Abuse_report.Location' => "$state"), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
					$data['result7'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Domestic_Violence_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Domestic_Violence_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Domestic_Violence_report', array('Domestic_Violence_report.user_type' => '1', 'Domestic_Violence_report.Location' => "$state"), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Domestic_Violence_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Domestic_Violence_report.*,('user') as type", 'Domestic_Violence_report', array('Domestic_Violence_report.user_type' => '0', 'Domestic_Violence_report.Location' => "$state"), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
					$data['result8'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Rape_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Rape_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Rape_report', array('Rape_report.user_type' => '1', 'Rape_report.Location' => "$state"), '', array('Rape_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Rape_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Rape_report.*,('user') as type", 'Rape_report', array('Rape_report.user_type' => '0', 'Rape_report.Location' => "$state"), '', array('Rape_report_id', 'DESC'), '', $dt);
					$data['result10'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Kidnap_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Kidnap_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Kidnap_report', array('Kidnap_report.user_type' => '1', 'Kidnap_report.Last_Seen_Location' => "$state"), '', array('Kidnap_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Kidnap_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Kidnap_report.*,('user') as type", 'Kidnap_report', array('Kidnap_report.user_type' => '0', 'Kidnap_report.Last_Seen_Location' => "$state"), '', array('Kidnap_report_id', 'DESC'), '', $dt);
					$data['result11'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Robbery_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Robbery_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Robbery_report', array('Robbery_report.user_type' => '1', 'Robbery_report.Location' => "$state"), '', array('Robbery_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Robbery_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Robbery_report.*,('user') as type", 'Robbery_report', array('Robbery_report.user_type' => '0', 'Robbery_report.Location' => "$state"), '', array('Robbery_report_id', 'DESC'), '', $dt);
					$data['result12'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Burglary_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Burglary_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Burglary_report', array('Burglary_report.user_type' => '1', 'Burglary_report.Location' => "$state"), '', array('Burglary_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Burglary_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Burglary_report.*,('user') as type", 'Burglary_report', array('Burglary_report.user_type' => '0', 'Burglary_report.Location' => "$state"), '', array('Burglary_report_id', 'DESC'), '', $dt);
					$data['result13'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Submit_Tip_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Submit_Tip_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Submit_Tip_report', array('Submit_Tip_report.user_type' => '1', 'Submit_Tip_report.Location' => "$state"), '', array('Submit_Tip_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Submit_Tip_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Submit_Tip_report.*,('user') as type", 'Submit_Tip_report', array('Submit_Tip_report.user_type' => '0', 'Submit_Tip_report.Location' => "$state"), '', array('Submit_Tip_id', 'DESC'), '', $dt);
					$data['result15'] = array_merge($check_user1, $check_user2);


					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Vandalism_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Vandalism_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Vandalism_report', array('Vandalism_report.user_type' => '1', 'Vandalism_report.Name' => "$state"), '', array('Vandalism_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vandalism_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Vandalism_report.*,('user') as type", 'Vandalism_report', array('Vandalism_report.user_type' => '0', 'Vandalism_report.Name' => "$state"), '', array('Vandalism_report_id', 'DESC'), '', $dt);
					$data['result17'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Fire_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Fire_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Fire_report', array('Fire_report.user_type' => '1', 'Fire_report.Name' => "$state"), '', array('Fire_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Fire_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Fire_report.*,('user') as type", 'Fire_report', array('Fire_report.user_type' => '0', 'Fire_report.Name' => "$state"), '', array('Fire_report_id', 'DESC'), '', $dt);
					$data['result18'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Accident_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Accident_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Accident_report', array('Accident_report.user_type' => '1', 'Accident_report.Name' => "$state"), '', array('Accident_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Accident_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Accident_report.*,('user') as type", 'Accident_report', array('Accident_report.user_type' => '0', 'Accident_report.Name' => "$state"), '', array('Accident_report_id', 'DESC'), '', $dt);
					$data['result19'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Medical_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Medical_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Medical_report', array('Medical_report.user_type' => '1', 'Medical_report.Name' => "$state"), '', array('Medical_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Medical_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Medical_report.*,('user') as type", 'Medical_report', array('Medical_report.user_type' => '0', 'Medical_report.Name' => "$state"), '', array('Medical_report_id', 'DESC'), '', $dt);
					$data['result20'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Riot_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Riot_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Riot_report', array('Riot_report.user_type' => '1', 'Riot_report.Name' => "$state"), '', array('Riot_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Riot_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Riot_report.*,('user') as type", 'Riot_report', array('Riot_report.user_type' => '0', 'Riot_report.Name' => "$state"), '', array('Riot_report_id', 'DESC'), '', $dt);
					$data['result21'] = array_merge($check_user1, $check_user2);


					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Environmental_Hazard_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Environmental_Hazard_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_type' => '1', 'Environmental_Hazard_report.Name' => "$state"), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Environmental_Hazard_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Environmental_Hazard_report.*,('user') as type", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_type' => '0', 'Environmental_Hazard_report.Name' => "$state"), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
					$data['result22'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Child_Abuse_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Child_Abuse_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Child_Abuse_report', array('Child_Abuse_report.user_type' => '1', 'Child_Abuse_report.Name' => "$state"), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Child_Abuse_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Child_Abuse_report.*,('user') as type", 'Child_Abuse_report', array('Child_Abuse_report.user_type' => '0', 'Child_Abuse_report.Name' => "$state"), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
					$data['result23'] = array_merge($check_user1, $check_user2);

					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Human_Trafficking_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Human_Trafficking_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Human_Trafficking_report', array('Human_Trafficking_report.user_type' => '1', 'Human_Trafficking_report.Name' => "$state"), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Human_Trafficking_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Human_Trafficking_report.*,('user') as type", 'Human_Trafficking_report', array('Human_Trafficking_report.user_type' => '0', 'Human_Trafficking_report.Name' => "$state"), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
					$data['result24'] = array_merge($check_user1, $check_user2);


					$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Blow_Whistle_report.user_id')));
					$check_user1 = $this->beats_model->select_data("Officer.*,Blow_Whistle_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Blow_Whistle_report', array('Blow_Whistle_report.user_type' => '1', 'Blow_Whistle_report.Name' => "$state"), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
					$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Blow_Whistle_report.user_id')));
					$check_user2 = $this->beats_model->select_data("user_signup.*,Blow_Whistle_report.*,('user') as type", 'Blow_Whistle_report', array('Blow_Whistle_report.user_type' => '0', 'Blow_Whistle_report.Name' => "$state"), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
					$data['result25'] = array_merge($check_user1, $check_user2);
				}
			} else {
				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=iWitness.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,iWitness.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'iWitness', array('iWitness.user_type' => '1', 'iWitness.user_id' => $_POST['Officer_id']), '', array('iWitness_id', 'DESC'), '', $dt);
				$data['result'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=StolenVehicle_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,StolenVehicle_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'StolenVehicle_report', array('StolenVehicle_report.user_type' => '1', 'StolenVehicle_report.user_id' => $_POST['Officer_id']), '', array('StolenVehicle_report_id', 'DESC'), '', $dt);
				$data['result3'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Missing_Persons_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Missing_Persons_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Missing_Persons_report', array('Missing_Persons_report.user_type' => '1', 'Missing_Persons_report.user_id' => $_POST['Officer_id']), '', array('Missing_Persons_report_id', 'DESC'), '', $dt);
				$data['result4'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Lodgecomplaint_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Lodgecomplaint_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Lodgecomplaint_report', array('Lodgecomplaint_report.user_type' => '1', 'Lodgecomplaint_report.user_id' => $_POST['Officer_id']), '', array('Lodgecomplaint_report_id', 'DESC'), '', $dt);
				$data['result5'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Gun_Violence_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Gun_Violence_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Gun_Violence_report', array('Gun_Violence_report.user_type' => '1', '.Gun_Violence_report.user_id' => $_POST['Officer_id']), '', array('GunViolence_id', 'DESC'), '', $dt);
				$data['result6'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Drug_Abuse_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Drug_Abuse_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Drug_Abuse_report', array('Drug_Abuse_report.user_type' => '1', 'Drug_Abuse_report.user_id' => $_POST['Officer_id']), '', array('DrugAbuse_report_id', 'DESC'), '', $dt);
				$data['result7'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Domestic_Violence_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Domestic_Violence_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Domestic_Violence_report', array('Domestic_Violence_report.user_type' => '1', 'Domestic_Violence_report.user_id' => $_POST['Officer_id']), '', array('DomesticViolence_report_id', 'DESC'), '', $dt);
				$data['result8'] = $check_user1;


				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Rape_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Rape_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Rape_report', array('Rape_report.user_type' => '1', 'Rape_report.user_id' => $_POST['Officer_id']), '', array('Rape_report_id', 'DESC'), '', $dt);
				$data['result10'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Kidnap_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Kidnap_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Kidnap_report', array('Kidnap_report.user_type' => '1', 'Kidnap_report.user_id' => $_POST['Officer_id']), '', array('Kidnap_report_id', 'DESC'), '', $dt);
				$data['result11'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Robbery_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Robbery_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Robbery_report', array('Robbery_report.user_type' => '1', 'Robbery_report.user_id' => $_POST['Officer_id']), '', array('Robbery_report_id', 'DESC'), '', $dt);
				$data['result12'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Burglary_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Burglary_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Burglary_report', array('Burglary_report.user_type' => '1', 'Burglary_report.user_id' => $_POST['Officer_id']), '', array('Burglary_report_id', 'DESC'), '', $dt);
				$data['result13'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Submit_Tip_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Submit_Tip_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Submit_Tip_report', array('Submit_Tip_report.user_type' => '1', 'Submit_Tip_report.user_id' => $_POST['Officer_id']), '', array('Submit_Tip_id', 'DESC'), '', $dt);
				$data['result15'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Vandalism_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Vandalism_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Vandalism_report', array('Vandalism_report.user_type' => '1', 'Vandalism_report.user_id' => $_POST['Officer_id']), '', array('Vandalism_report_id', 'DESC'), '', $dt);
				$data['result17'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Fire_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Fire_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Fire_report', array('Fire_report.user_type' => '1', 'Fire_report.user_id' => $_POST['Officer_id']), '', array('Fire_report_id', 'DESC'), '', $dt);
				$data['result18'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Accident_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Accident_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Accident_report', array('Accident_report.user_type' => '1', 'Accident_report.user_id' => $_POST['Officer_id']), '', array('Accident_report_id', 'DESC'), '', $dt);
				$data['result19'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Medical_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Medical_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Medical_report', array('Medical_report.user_type' => '1', 'Medical_report.user_id' => $_POST['Officer_id']), '', array('Medical_report_id', 'DESC'), '', $dt);
				$data['result20'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Riot_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Riot_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Riot_report', array('Riot_report.user_type' => '1', 'Riot_report.user_id' => $_POST['Officer_id']), '', array('Riot_report_id', 'DESC'), '', $dt);
				$data['result21'] = $check_user1;


				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Environmental_Hazard_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Environmental_Hazard_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Environmental_Hazard_report', array('Environmental_Hazard_report.user_type' => '1', 'Environmental_Hazard_report.user_id' => $_POST['Officer_id']), '', array('Environmental_Hazard_report_id', 'DESC'), '', $dt);
				$data['result22'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Child_Abuse_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Child_Abuse_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Child_Abuse_report', array('Child_Abuse_report.user_type' => '1', 'Child_Abuse_report.user_id' => $_POST['Officer_id']), '', array('Child_Abuse_report_id', 'DESC'), '', $dt);
				$data['result23'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Human_Trafficking_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Human_Trafficking_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Human_Trafficking_report', array('Human_Trafficking_report.user_type' => '1', 'Human_Trafficking_report.user_id' => $_POST['Officer_id']), '', array('Human_Trafficking_report_id', 'DESC'), '', $dt);
				$data['result24'] = $check_user1;

				$dt = array('multiple', array(array('Officer', 'Officer.Officer_id=Blow_Whistle_report.user_id')));
				$check_user1 = $this->beats_model->select_data("Officer.*,Blow_Whistle_report.*,('officer') as type, (Officer.Full_Name) as user_name, (Officer.phone) as user_phone", 'Blow_Whistle_report', array('Blow_Whistle_report.user_type' => '1', 'Blow_Whistle_report.user_id' => $_POST['Officer_id']), '', array('Blow_Whistle_report_id', 'DESC'), '', $dt);
				$data['result25'] = $check_user1;
			}

			if (!empty($data['result'])) {
				$dataid0 = array();
				foreach ($data['result'] as $ns) {
					array_push($dataid0, $ns['iWitness_id']);
				}
				arsort($dataid0);
				$dataid0 = key($dataid0);
			}

			$user_detail = array(
				'type' => 'iWitness',
				'ttl_sos' => count($data['result']),
				'mostRecent' => (count($data['result']) != 0) ? $this->getDayNew($data['result'][$dataid0]['created_at']) : "",
				'mostRecent1' => (count($data['result']) != 0) ? date('l d/m/Y', strtotime($data['result'][$dataid0]['iWitness_date'])) . ' ' . substr_replace($data['result'][$dataid0]['iWitness_tym'], ' ', (strlen($data['result'][$dataid0]['iWitness_tym']) == 8) ? 5 : 4, -2) : "",

			);
			array_push($newarr, $user_detail);

			if (!empty($data['result3'])) {
				$dataid3 = array();
				foreach ($data['result3'] as $ns) {
					array_push($dataid3, $ns['StolenVehicle_report_id']);
				}
				arsort($dataid3);
				$dataid3 = key($dataid3);
			}

			$user_detail3 = array(
				'type' => 'Stolen vehicle',
				'ttl_sos' => count($data['result3']),
				'mostRecent' => (count($data['result3']) != 0) ? $this->getDayNew($data['result3'][$dataid3]['created_at']) : "",
				'mostRecent1' => (count($data['result3']) != 0) ? date('l d/m/Y', strtotime($data['result3'][$dataid3]['StolenVehicle_report_date'])) . ' ' . substr_replace($data['result3'][$dataid3]['StolenVehicle_report_tym'], ' ', (strlen($data['result3'][$dataid3]['StolenVehicle_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail3);

			if (!empty($data['result4'])) {
				$dataid4 = array();
				foreach ($data['result4'] as $ns) {
					array_push($dataid4, $ns['Missing_Persons_report_id']);
				}
				arsort($dataid4);
				$dataid4 = key($dataid4);
			}

			$user_detail4 = array(
				'type' => 'Missing Persons',
				'ttl_sos' => count($data['result4']),
				'mostRecent' => (count($data['result4']) != 0) ? $this->getDayNew($data['result4'][$dataid4]['created_at']) : "",
				'mostRecent1' => (count($data['result4']) != 0) ? date('l d/m/Y', strtotime($data['result4'][$dataid4]['Missing_Persons_report_Date'])) . ' ' . substr_replace($data['result4'][$dataid4]['Missing_Persons_report_tym'], ' ', (strlen($data['result4'][$dataid4]['Missing_Persons_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail4);

			if (!empty($data['result5'])) {
				$dataid5 = array();
				foreach ($data['result5'] as $ns) {
					array_push($dataid5, $ns['Lodgecomplaint_report_id']);
				}
				arsort($dataid5);
				$dataid5 = key($dataid5);
			}

			$user_detail5 = array(
				'type' => 'Lodge a complaint',
				'ttl_sos' => count($data['result5']),
				'mostRecent' => (count($data['result5']) != 0) ? $this->getDayNew($data['result5'][$dataid5]['created_at']) : "",
				'mostRecent1' => (count($data['result5']) != 0) ? date('l d/m/Y', strtotime($data['result5'][$dataid5]['Lodgecomplaint_report_Date'])) . ' ' . substr_replace($data['result5'][$dataid5]['Lodgecomplaint_report_tym'], ' ', (strlen($data['result5'][$dataid5]['Lodgecomplaint_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail5);

			if (!empty($data['result6'])) {
				$dataid6 = array();
				foreach ($data['result6'] as $ns) {
					array_push($dataid6, $ns['GunViolence_id']);
				}
				arsort($dataid6);
				$dataid6 = key($dataid6);
			}

			$user_detail6 = array(
				'type' => 'Gun Violence',
				'ttl_sos' => count($data['result6']),
				'mostRecent' => (count($data['result6']) != 0) ? $this->getDayNew($data['result6'][$dataid6]['created_at']) : "",
				'mostRecent1' => (count($data['result6']) != 0) ? date('l d/m/Y', strtotime($data['result6'][$dataid6]['GunViolence_Date'])) . ' ' . substr_replace($data['result6'][$dataid6]['GunViolence_tym'], ' ', (strlen($data['result6'][$dataid6]['GunViolence_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail6);

			if (!empty($data['result7'])) {
				$dataid7 = array();
				foreach ($data['result7'] as $ns) {
					array_push($dataid7, $ns['DrugAbuse_report_id']);
				}
				arsort($dataid7);
				$dataid7 = key($dataid7);
			}

			$user_detail7 = array(
				'type' => 'Drug Abuse',
				'ttl_sos' => count($data['result7']),
				'mostRecent' => (count($data['result7']) != 0) ? $this->getDayNew($data['result7'][$dataid7]['created_at']) : "",
				'mostRecent1' => (count($data['result7']) != 0) ? date('l d/m/Y', strtotime($data['result7'][$dataid7]['Date'])) . ' ' . substr_replace($data['result7'][$dataid7]['tym'], ' ', (strlen($data['result7'][$dataid7]['tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail7);

			if (!empty($data['result8'])) {
				$dataid8 = array();
				foreach ($data['result8'] as $ns) {
					array_push($dataid8, $ns['DomesticViolence_report_id']);
				}
				arsort($dataid8);
				$dataid8 = key($dataid8);
			}

			$user_detail8 = array(
				'type' => 'Domestic Violence',
				'ttl_sos' => count($data['result8']),
				'mostRecent' => (count($data['result8']) != 0) ? $this->getDayNew($data['result8'][$dataid8]['created_at']) : "",
				'mostRecent1' => (count($data['result8']) != 0) ? date('l d/m/Y', strtotime($data['result8'][$dataid8]['Date'])) . ' ' . substr_replace($data['result8'][$dataid8]['tym'], ' ', (strlen($data['result8'][$dataid8]['tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail8);

			if (!empty($data['result10'])) {
				$dataid10 = array();
				foreach ($data['result10'] as $ns) {
					array_push($dataid10, $ns['Rape_report_id']);
				}
				arsort($dataid10);
				$dataid10 = key($dataid10);
			}

			$user_detail10 = array(
				'type' => 'Rape',
				'ttl_sos' => count($data['result10']),
				'mostRecent' => (count($data['result10']) != 0) ? $this->getDayNew($data['result10'][$dataid10]['created_at']) : "",
				'mostRecent1' => (count($data['result10']) != 0) ? date('l d/m/Y', strtotime($data['result10'][$dataid10]['Rape_report_Date'])) . ' ' . substr_replace($data['result10'][$dataid10]['Rape_report_tym'], ' ', (strlen($data['result10'][$dataid10]['Rape_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail10);

			if (!empty($data['result11'])) {
				$dataid11 = array();
				foreach ($data['result11'] as $ns) {
					array_push($dataid11, $ns['Kidnap_report_id']);
				}
				arsort($dataid11);
				$dataid11 = key($dataid11);
			}

			$user_detail11 = array(
				'type' => 'Kidnap',
				'ttl_sos' => count($data['result11']),
				'mostRecent' => (count($data['result11']) != 0) ? $this->getDayNew($data['result11'][$dataid11]['created_at']) : "",
				'mostRecent1' => (count($data['result11']) != 0) ? date('l d/m/Y', strtotime($data['result11'][$dataid11]['Kidnap_report_Date'])) . ' ' . substr_replace($data['result11'][$dataid11]['Kidnap_report_tym'], ' ', (strlen($data['result11'][$dataid11]['Kidnap_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail11);

			if (!empty($data['result12'])) {
				$dataid12 = array();
				foreach ($data['result12'] as $ns) {
					array_push($dataid12, $ns['Robbery_report_id']);
				}
				arsort($dataid12);
				$dataid12 = key($dataid12);
			}

			$user_detail12 = array(
				'type' => 'Robbery',
				'ttl_sos' => count($data['result12']),
				'mostRecent' => (count($data['result12']) != 0) ? $this->getDayNew($data['result12'][$dataid12]['created_at']) : "",
				'mostRecent1' => (count($data['result12']) != 0) ? date('l d/m/Y', strtotime($data['result12'][$dataid12]['Robbery_report_Date'])) . ' ' . substr_replace($data['result12'][$dataid12]['Robbery_report_tym'], ' ', (strlen($data['result12'][$dataid12]['Robbery_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail12);

			if (!empty($data['result13'])) {
				$dataid13 = array();
				foreach ($data['result13'] as $ns) {
					array_push($dataid13, $ns['Burglary_report_id']);
				}
				arsort($dataid13);
				$dataid13 = key($dataid13);
			}

			$user_detail13 = array(
				'type' => 'Burglary',
				'ttl_sos' => count($data['result13']),
				'mostRecent' => (count($data['result13']) != 0) ? $this->getDayNew($data['result13'][$dataid13]['created_at']) : "",
				'mostRecent1' => (count($data['result13']) != 0) ? date('l d/m/Y', strtotime($data['result13'][$dataid13]['Burglary_report_Date'])) . ' ' . substr_replace($data['result13'][$dataid13]['Burglary_report_tym'], ' ', (strlen($data['result13'][$dataid13]['Burglary_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail13);

			if (!empty($data['result15'])) {
				$dataid15 = array();
				foreach ($data['result15'] as $ns) {
					array_push($dataid15, $ns['Submit_Tip_id']);
				}
				arsort($dataid15);
				$dataid15 = key($dataid15);
			}

			$user_detail15 = array(
				'type' => 'Submit a Tip',
				'ttl_sos' => count($data['result15']),
				'mostRecent' => (count($data['result15']) != 0) ? $this->getDayNew($data['result15'][$dataid15]['created_at']) : "",
				'mostRecent1' => (count($data['result15']) != 0) ? date('l d/m/Y', strtotime($data['result15'][$dataid15]['Date'])) . ' ' . substr_replace($data['result15'][$dataid15]['tym'], ' ', (strlen($data['result15'][$dataid15]['tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail15);

			if (!empty($data['result17'])) {
				$dataid17 = array();
				foreach ($data['result17'] as $ns) {
					array_push($dataid17, $ns['Vandalism_report_id']);
				}
				arsort($dataid17);
				$dataid17 = key($dataid17);
			}

			$user_detail17 = array(
				'type' => 'Vandalism',
				'ttl_sos' => count($data['result17']),
				'mostRecent' => (count($data['result17']) != 0) ? $this->getDayNew($data['result17'][$dataid17]['created_at']) : "",
				'mostRecent1' => (count($data['result17']) != 0) ? date('l d/m/Y', strtotime($data['result17'][$dataid17]['Vandalism_report_Date'])) . ' ' . substr_replace($data['result17'][$dataid17]['Vandalism_report_tym'], ' ', (strlen($data['result17'][$dataid17]['Vandalism_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail17);

			if (!empty($data['result18'])) {
				$dataid18 = array();
				foreach ($data['result18'] as $ns) {
					array_push($dataid18, $ns['Fire_report_id']);
				}
				arsort($dataid18);
				$dataid18 = key($dataid18);
			}

			$user_detail18 = array(
				'type' => 'Fire',
				'ttl_sos' => count($data['result18']),
				'mostRecent' => (count($data['result18']) != 0) ? $this->getDayNew($data['result18'][$dataid18]['created_at']) : "",
				'mostRecent1' => (count($data['result18']) != 0) ? date('l d/m/Y', strtotime($data['result18'][$dataid18]['Fire_report_Date'])) . ' ' . substr_replace($data['result18'][$dataid18]['Fire_report_tym'], ' ', (strlen($data['result18'][$dataid18]['Fire_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail18);

			if (!empty($data['result19'])) {
				$dataid19 = array();
				foreach ($data['result19'] as $ns) {
					array_push($dataid19, $ns['Accident_report_id']);
				}
				arsort($dataid19);
				$dataid19 = key($dataid19);
			}

			$user_detail19 = array(
				'type' => 'Accident',
				'ttl_sos' => count($data['result19']),
				'mostRecent' => (count($data['result19']) != 0) ? $this->getDayNew($data['result19'][$dataid19]['created_at']) : "",
				'mostRecent1' => (count($data['result19']) != 0) ? date('l d/m/Y', strtotime($data['result19'][$dataid19]['Accident_report_Date'])) . ' ' . substr_replace($data['result19'][$dataid19]['Accident_report_tym'], ' ', (strlen($data['result19'][$dataid19]['Accident_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail19);

			if (!empty($data['result20'])) {
				$dataid20 = array();
				foreach ($data['result20'] as $ns) {
					array_push($dataid20, $ns['Medical_report_id']);
				}
				arsort($dataid20);
				$dataid20 = key($dataid20);
			}

			$user_detail20 = array(
				'type' => 'Medical',
				'ttl_sos' => count($data['result20']),
				'mostRecent' => (count($data['result20']) != 0) ? $this->getDayNew($data['result20'][$dataid20]['created_at']) : "",
				'mostRecent1' => (count($data['result20']) != 0) ? date('l d/m/Y', strtotime($data['result20'][$dataid20]['Medical_report_Date'])) . ' ' . substr_replace($data['result20'][$dataid20]['Medical_report_tym'], ' ', (strlen($data['result20'][$dataid20]['Medical_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail20);

			if (!empty($data['result21'])) {
				$dataid21 = array();
				foreach ($data['result21'] as $ns) {
					array_push($dataid21, $ns['Riot_report_id']);
				}
				arsort($dataid21);
				$dataid21 = key($dataid21);
			}

			$user_detail21 = array(
				'type' => 'Riot',
				'ttl_sos' => count($data['result21']),
				'mostRecent' => (count($data['result21']) != 0) ? $this->getDayNew($data['result21'][$dataid21]['created_at']) : "",
				'mostRecent1' => (count($data['result21']) != 0) ? date('l d/m/Y', strtotime($data['result21'][$dataid21]['Riot_report_Date'])) . ' ' . substr_replace($data['result21'][$dataid21]['Riot_report_tym'], ' ', (strlen($data['result21'][$dataid21]['Riot_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail21);

			if (!empty($data['result22'])) {
				$dataid22 = array();
				foreach ($data['result22'] as $ns) {
					array_push($dataid22, $ns['Environmental_Hazard_report_id']);
				}
				arsort($dataid22);
				$dataid22 = key($dataid22);
			}

			$user_detail22 = array(
				'type' => 'Environmental Hazard',
				'ttl_sos' => count($data['result22']),
				'mostRecent' => (count($data['result22']) != 0) ? $this->getDayNew($data['result22'][$dataid22]['created_at']) : "",
				'mostRecent1' => (count($data['result22']) != 0) ? date('l d/m/Y', strtotime($data['result22'][$dataid22]['Environmental_Hazard_report_Date'])) . ' ' . substr_replace($data['result22'][$dataid22]['Environmental_Hazard_report_tym'], ' ', (strlen($data['result22'][$dataid22]['Environmental_Hazard_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail22);

			if (!empty($data['result23'])) {
				$dataid23 = array();
				foreach ($data['result23'] as $ns) {
					array_push($dataid23, $ns['Child_Abuse_report_id']);
				}
				arsort($dataid23);
				$dataid23 = key($dataid23);
			}

			$user_detail23 = array(
				'type' => 'Child Abuse',
				'ttl_sos' => count($data['result23']),
				'mostRecent' => (count($data['result23']) != 0) ? $this->getDayNew($data['result23'][$dataid23]['created_at']) : "",
				'mostRecent1' => (count($data['result23']) != 0) ? date('l d/m/Y', strtotime($data['result23'][$dataid23]['Child_Abuse_report_Date'])) . ' ' . substr_replace($data['result23'][$dataid23]['Child_Abuse_report_tym'], ' ', (strlen($data['result23'][$dataid23]['Child_Abuse_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail23);

			if (!empty($data['result24'])) {
				$dataid24 = array();
				foreach ($data['result24'] as $ns) {
					array_push($dataid24, $ns['Human_Trafficking_report_id']);
				}
				arsort($dataid24);
				$dataid24 = key($dataid24);
			}

			$user_detail24 = array(
				'type' => 'Human Trafficking',
				'ttl_sos' => count($data['result24']),
				'mostRecent' => (count($data['result24']) != 0) ? $this->getDayNew($data['result24'][$dataid24]['created_at']) : "",
				'mostRecent1' => (count($data['result24']) != 0) ? date('l d/m/Y', strtotime($data['result24'][$dataid24]['Human_Trafficking_report_Date'])) . ' ' . substr_replace($data['result24'][$dataid24]['Human_Trafficking_report_tym'], ' ', (strlen($data['result24'][$dataid24]['Human_Trafficking_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail24);

			if (!empty($data['result25'])) {
				$dataid25 = array();
				foreach ($data['result25'] as $ns) {
					array_push($dataid25, $ns['Blow_Whistle_report_id']);
				}
				arsort($dataid25);
				$dataid25 = key($dataid25);
			}

			$user_detail25 = array(
				'type' => 'Blow Whistle',
				'ttl_sos' => count($data['result25']),
				'mostRecent' => (count($data['result25']) != 0) ? $this->getDayNew($data['result25'][$dataid25]['created_at']) : "",
				'mostRecent1' => (count($data['result25']) != 0) ? date('l d/m/Y', strtotime($data['result25'][$dataid25]['Blow_Whistle_report_Date'])) . ' ' . substr_replace($data['result25'][$dataid25]['Blow_Whistle_report_tym'], ' ', (strlen($data['result25'][$dataid25]['Blow_Whistle_report_tym']) == 8) ? 5 : 4, -2) : "",
			);
			array_push($newarr, $user_detail25);


			if (count($newarr) > 0) {

				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	function date_compare($a, $b)
	{
		$t1 = strtotime($a['created_date']);
		$t2 = strtotime($b['created_date']);
		// return $t1 - $t2;
		return $t1 < $t2 ? -1 : 1;
	}
	public function SearchAnalytics()
	{

		if (isset($_POST['Officer_id']) && isset($_POST['startdate']) && isset($_POST['enddate'])) {


			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));
			$newarr = array();
			// if ($check_type['0']['POLICE_INTERFACE_id'] == 2 || $check_type['0']['POLICE_INTERFACE_id'] == 3) {

			$dss = " SOSManagement.created_dateat BETWEEN '" . date("Y/m/d", strtotime($_POST['startdate'])) . "' AND '" . date("Y/m/d", strtotime($_POST['enddate'])) . "'";

			$check_cate = $this->beats_model->select_data('*', 'sos_category', "sos_category_id NOT IN (3,6)");
			foreach ($check_cate as $cat) {
				$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
				$a = "SOSManagement.SOS_category= " . $cat['sos_category_id'] . " and " . $dss;
				$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
				$i = 0;
				foreach ($check_user as $resmt) {

					$fs = $this->Nearbysos($check_type['0']['Officer_id'], $resmt['lat'], $resmt['lang'], $check_type['0']['officer_category']);
					if ($fs == 1) {
						$i++;
					}
				}
				$user_detail = array(
					'type' => $cat['sos_category_name'],
					'ttl_sos' =>	$i,
				);
				array_push($newarr, $user_detail);
			}

			/* if ($check_type['0']['officer_category'] == 1) {
				$check_cate = $this->beats_model->select_data('*', 'sos_category', "sos_category_id NOT IN (3,6)");
				foreach ($check_cate as $cat) {
					$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
					$a = "SOSManagement.SOS_category= " . $cat['sos_category_id'] . " and " . $dss;
					$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
					$user_detail = array(
						'type' => $cat['sos_category_name'],
						'ttl_sos' =>	count($check_user),
					);
					array_push($newarr, $user_detail);
				}
			} else {
				$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
				$stated = $check_user_meta['0']['lga_state'];
				$check_cate = $this->beats_model->select_data('*', 'sos_category');
				foreach ($check_cate as $cat) {
					$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
					$a = "SOSManagement.SOS_category= " . $cat['sos_category_id'] . " AND current_location Like" . "'%" . $stated . '%' . "'" . " and " . $dss;
					$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
					$user_detail = array(
						'type' => $cat['sos_category_name'],
						'ttl_sos' =>	count($check_user),
					);
					array_push($newarr, $user_detail);
				}
			} */


			// echo $this->db->last_query();
			// die;




			if (count($newarr) > 0) {

				echo json_encode(array('status' => true, 'message' => ' Successfull.', 'Details' => $newarr));
			} else {
				echo json_encode(array('status' => false, 'message' => 'No data found.'));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function ResponseMonitoring()
	{

		if (isset($_POST['Officer_id'])) {
			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));

			// if ($check_type1['0']['officer_category'] == 1) {
			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', '', '', array('SOS_id', 'DESC'), '', $dt);
			// } else {
			// 	$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type1[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			// 	$stated = $check_user_meta['0']['lga_state'];
			// 	$a = " SOSManagement.current_location Like" . "'%" . $stated . '%' . "'";
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// }

			$newarr = array();
			if (!empty($check_user)) {
				foreach ($check_user as $resmt) {
					// $fs = $this->Nearbysos($check_type['0']['Officer_id'], $resmt['lat'], $resmt['lang'], $check_type['0']['officer_category']);
					// if ($fs == 1) {
					//new 26_
					if ($check_type['0']['officer_category'] == 1) {
						$check_feed = $this->beats_model->select_data('*', 'SOSFeedback', array('SOS_id' => $resmt['SOS_id']), '', array('sosfeedback_id', 'ASC'));
					} else {
						$check_feed = $this->beats_model->select_data('*', 'SOSFeedback', array('SOS_id' => $resmt['SOS_id'], 'user_type' => $check_type['0']['Officer_id']), '', array('sosfeedback_id', 'ASC'));
					}

					$agency = '';
					if (!empty($check_feed)) {
						if ($check_feed['0']['user_type'] != 0) {
							$check_officer = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $check_feed['0']['user_type']));
							// $check_officer = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $resmt['0']['user_type']));
							// if(!empty($check_officer)){
							$officername = (!empty($check_officer) ? $check_officer['0']['Full_Name'] : '');
							$officerrank = (!empty($check_officer) ? $check_officer['0']['Rank'] : '');
							$phone = (!empty($check_officer) ? $check_officer['0']['phone'] : '');
							if (!empty($check_officer)) {
								$check_meta = $this->beats_model->select_data('*', 'user_officer_meta', array('user_type' => '2', 'user_id' => $check_officer['0']['Officer_id']));
								$agency = (!empty($check_meta) ? $check_meta[0]['agency'] : '');
							}
							$responsetime = "";
							// }
						} else {
							$officername = 'Admin';
							$officerrank = "admin";
							$phone = "admin";
							$agency = "admin";
							$responsetime = "admin";
						}

						$timeFirstfeedback = $check_feed['0']['feedback_date'];
						$officername = $officername;
						$officerrank = $officerrank;
						$phone = $phone;
						$responsetime = $responsetime;
					} else {
						$timeFirstfeedback = "";
						$officername = "";
						$officerrank = "";
						$phone = "";
						$responsetime = "";
					}

					$user_detail = array(
						'type' =>	$resmt['sos_category_name'],
						'created_at' =>	$this->getDayNew($resmt['created_at']),
						'timeFirstfeedback' => $this->getDayNew($timeFirstfeedback),
						'officername' => $officername,
						'officerrank' => $officerrank,
						'phone' => $phone,
						'agency' => $agency,
						'responsetime' => $responsetime,
					);
					if (!empty($user_detail['officername'])) {
						array_push($newarr, $user_detail);
					}
					// }
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

	public function ResponseOfficersSOS()
	{

		if (isset($_POST['Officer_id'])) {


			$check_type = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));

			// if ($check_type['0']['POLICE_INTERFACE_id'] == 2 || $check_type['0']['POLICE_INTERFACE_id'] == 3) {
			// 	$stated = $check_type['0']['State_Deployment'];
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$a = "SOSManagement.usertype = 1 and SOSManagement.current_location Like" . "'%" . $stated . '%' . "'";
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// } else {

			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', "SOSManagement.usertype = 1", '', array('SOS_id', 'DESC'), '', $dt);
			// }

			// $stated = $check_type['0']['State_Deployment'];

			// if ($check_type[0]['officer_category'] == '1') {
			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// $check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', "SOSManagement.usertype = 1", '', array('SOS_id', 'DESC'), '', $dt);
			//new
			$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', array('SOSManagement.usertype' => '1'), '', array('SOS_id', 'DESC'), '', $dt);
			// } else {
			// 	$check_user_meta = $this->beats_model->select_data('*', 'user_officer_meta', "user_type = 2 and user_id = '" . $check_type[0]['Officer_id'] . "'", '', array('meta_id', 'DESC'), '', '');
			// 	$stated = $check_user_meta[0]['lga_state'];
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$a = "SOSManagement.usertype = 1 and SOSManagement.current_location Like '%" . $stated . "'";
			// 	$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			// 	$check_user = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// }


			// echo $this->db->last_query();
			// die;

			if (!empty($check_user)) {
				$newarr = array();
				foreach ($check_user as $resmt) {
					$fs = $this->Nearbysos($check_type['0']['Officer_id'], $resmt['lat'], $resmt['lang'], $check_type['0']['officer_category']);
					if ($fs == 1) {
						if (!empty($resmt['images'])) {
							$newimg = json_decode($resmt['images']);
							$imgarray = array();
							if (!empty($newimg)) {
								foreach ($newimg as $itm) {
									$user_img = array(

										'image' => $itm
									);
									array_push($imgarray, $user_img);
								}
							}
							// $nefimeimg=implode(',',$newimg);
						} else {
							$imgarray = array();
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
							'update_at' => $resmt['update_at'],
							'update_at_new' => $this->getDayNew($resmt['update_at']),
							'created_at' => $this->getDayNew($resmt['created_at']),
							'created_at_new' => $resmt['created_at'],
							'SOS_staus' => $resmt['SOS_staus'],

							'Media' => $imgarray


						);
						array_push($newarr, $user_detail);
					}
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



	public function verifyshortcode()
	{
		if (isset($_POST['phone_number']) && isset($_POST['message']) && isset($_POST['code'])) {

			$check_user =  $this->beats_model->select_data('*', 'Officer', array('phone' => $_POST['user_phone'], 'verify_code' => $_POST['code']));
			if (!empty($check_user)) {

				$this->sendPushNoti1("Shortcode Verification", "Verify officer shortcode successfull", array($check_user[0]['fcm_tokenid']), "10");

				$Mbl = $check_user[0]['phone'];
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
				$this->beats_model->update_data('Officer', $user_detail, array('Officer_id' => $check_user[0]['Officer_id']));
				echo json_encode(array('status' => true, 'message' => 'Verify Officer shortcode successfull.', 'Details' => array()));
			} else {
				echo json_encode(array('status' => false, 'message' => "Doesn't officer citizen shortcode."));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function generateverifyshortcode()
	{
		if (isset($_POST['phone_number']) && !empty($_POST['phone_number'])) {

			$check_user =  $this->beats_model->select_data('*', 'Officer', array('phone' => $_POST['phone_number']));
			if (!empty($check_user)) {


				$verifycode = rand(1000000, 9999999);
				$user_detail = array(
					'verify_code' => $verifycode,
				);

				$reg_id1 = $this->beats_model->update_data('Officer', $user_detail, array('Officer_id' => $check_user[0]['Officer_id']));
				$this->sendPushNoti("Shortcode Generated", "New officer shortcode generated successfull : $verifycode", array($check_user[0]['fcm_tokenid']), "11");

				$Mbl = $_POST['phone_number'];
				// $owneremail = "ict@ribs.com.ng";
				// $subacct = "ABSAS";
				// $subacctpwd = "absas2020!";
				// $sendto = $Mbl;
				// $sender = "ABSAS";
				$message = 'your verification new code successfully generated : ' . $verifycode;
				$this->sendsmsnew($Mbl, $message);
				//$url = "http://www.smslive247.com/http/index.aspx?"  . "cmd=sendquickmsg"  . "&owneremail=" . UrlEncode($owneremail)  . "&subacct=" . UrlEncode($subacct)  . "&subacctpwd=" . UrlEncode($subacctpwd)  . "&message=" . UrlEncode($message) . "&sender=" . UrlEncode($sender) . "&sendto=" . UrlEncode($sendto);

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

				echo json_encode(array('status' => true, 'message' => 'New verification officer shortcode successfull generated.', 'Details' => $user_detail));
			} else {
				echo json_encode(array('status' => false, 'message' => "Doesn't generat officer shortcode."));
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'All fields are required.'));
		}
	}

	public function paginat($limit = '', $page = '')
	{
		$page = (!empty($page) ? $page : 1);
		$limit = ((!empty($limit) && $limit > 0) ? $limit : 30);
		$start = ($page - 1) * $limit;
		// $pagination = ''; //array($limit, $start);
		return array($limit, $start);
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

	public function getDayNew($date_str = '')
	{
		if (empty($date_str)) {
			return '';
		}
		$dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$dow_numeric = date("w", strtotime($date_str));;
		return $dowMap[$dow_numeric] . ' ' . date("d/m/Y h:i A", strtotime($date_str));
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
			if ($itm['officer_category'] == 1) {
				$flg = 1;
			}
		}
		return $flg;
	}
}

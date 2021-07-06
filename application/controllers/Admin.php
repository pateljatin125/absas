<?php
defined('BASEPATH') or exit('No direct script access allowed');
// define('API_ACCESS_KEY', 'AAAA4ZU5p6M:APA91bHmTFQvfxwZZKEC4XzKRKT7RWTngm-uVv-JzOCozyI0ae0tmHVB77D13DHgX48v65omrnZ-tAbJn-Rp6bUhRMDcBu6hwSaX8s4Z9vEaQSYSwJHUEiwj_m7m1MlhDRNeO5QsMqQa');
define('API_ACCESS_KEY', 'AAAA3JWXjJo:APA91bG0NUlZyUjyTs8IN48IL1WP6-b5wrFHojihqXVTBJF4RJla3l17QHQLncvFSHVAcIbEKMCVvvPuDxmbXNPbYHuEkgsanF91PfNNIxdJiLREeNe3b1e3g_6InDk911v7sDdNAsMc');
define("LGA_ST", serialize(array(
	"Aba North",
	"Aba South",
	"Arochukwu",
	"Bende",
	"Ikwuano",
	"Isiala Ngwa North",
	"Isiala Ngwa South",
	"Isuikwuato",
	"Obi Ngwa",
	"Ohafia",
	"Osisioma Ngwa",
	"Ugwunagbo",
	"Ukwa East",
	"Ukwa West",
	"Umuahia North",
	"Umuahia South",
	"Umu Nneochi",
)));

define("BLOOD_GP", serialize(array("A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-")));
define("GENO_TY", serialize(array("AA", "AS", "AC", "SS")));
define("AGENCY", serialize(array("Police", "DSS", "NSCDC", "Army", "Navy", "FRSC", "Government Appointee", "CSO", "Commissioner for Health", "LGA Chairman", "Fire Service", "Medical", "Others")));

class Admin extends CI_Controller
{
	public function __Construct()
	{
		parent::__Construct();
		$this->load->library('session');
		if (!$this->session->userdata('username')) {
			redirect(base_url('AdminLogin'));
		}
	}

	function logout()
	{
		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'logout',
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);
		$this->session->sess_destroy();
		redirect(base_url('AdminLogin'));
	}

	public function CrimeMap()
	{
		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', '', '', array('SOS_id', 'DESC'), '', $dt);

		$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');
		$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', '', '', array('iWitness_id', 'DESC'));
		$data['result1'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Officer_Abuse', '', '', array('OfficerAbuse_id', 'DESC'));
		$data['result2'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Commend_Officer', '', '', array('CommendOffice_id', 'DESC'));
		$data['result3'] = $this->beats_model->select_data('*,(Vehicle_lastlocation) as GeoLocationnew', 'StolenVehicle_report', '', '', array('StolenVehicle_report_id', 'DESC'));
		$data['result4'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Missing_Persons_report', '', '', array('Missing_Persons_report_id', 'DESC'));
		$data['result5'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Lodgecomplaint_report', '', '', array('Lodgecomplaint_report_id', 'DESC'));
		$data['result6'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Gun_Violence_report', '', '', array('GunViolence_id', 'DESC'));
		$data['result7'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Drug_Abuse_report', '', '', array('DrugAbuse_report_id', 'DESC'));
		$data['result8'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Domestic_Violence_report', '', '', array('DomesticViolence_report_id', 'DESC'));
		$data['result9'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Terrorist_Attack_report', '', '', array('TerroristAttack_report_id', 'DESC'));
		$data['result10'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Rape_report', '', '', array('Rape_report_id', 'DESC'));
		$data['result11'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Kidnap_report', '', '', array('Kidnap_report_id', 'DESC'));
		$data['result12'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Robbery_report', '', '', array('Robbery_report_id', 'DESC'));
		$data['result13'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Burglary_report', '', '', array('Burglary_report_id', 'DESC'));
		$data['result14'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'CybercrimeFraud_report', '', '', array('CybercrimeFraud_report_id', 'DESC'));
		$data['result15'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Submit_Tip_report', '', '', array('Submit_Tip_id', 'DESC'));
		$data['result16'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Others_report', '', '', array('Others_report_id', 'DESC'));
		$data['result17'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Vandalism_report', '', '', array('Vandalism_report_id', 'DESC'));
		$data['result18'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Fire_report', '', '', array('Fire_report_id', 'DESC'));
		$data['result19'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Accident_report', '', '', array('Accident_report_id', 'DESC'));
		$data['result20'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Medical_report', '', '', array('Medical_report_id', 'DESC'));
		$data['result21'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Riot_report', '', '', array('Riot_report_id', 'DESC'));
		$data['result22'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Environmental_Hazard_report', '', '', array('Environmental_Hazard_report_id', 'DESC'));
		$data['result23'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Child_Abuse_report', '', '', array('Child_Abuse_report_id', 'DESC'));
		$data['result24'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Human_Trafficking_report', '', '', array('Human_Trafficking_report_id', 'DESC'));
		$data['result25'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Blow_Whistle_report', '', '', array('Blow_Whistle_report_id', 'DESC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));


		$this->load->view('Admin/CrimeMap', $data);
	}

	public function updateprofile()
	{

		$dataset = array(
			'email' => $_POST['email'],
			'password' => $_POST['passwrd'],
		);
		$reg_id = $this->beats_model->update_data('admin', $dataset, array('id' => trim($_POST['admin_id'])));
		echo $reg_id;
		die;
		$this->session->set_userdata('username', $_POST['email']);
		$this->session->set_flashdata('success', 'Successfull Update'); // wrong details
		$data['admin'] = $this->beats_model->select_data('*', 'admin');

		//$this->load->view('Admin/profile',$data);
		redirect(base_url('/adminprofile'));
	}

	public function Enoticenotification($title, $message)
	{

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
		for ($i = 0; $i < $ttlfcm; $i++) {
			array_push($registration_id, $numdriver[$i]['fcm_tokenid']);
		}
		// define('API_ACCESS_KEY', 'AAAA4ZU5p6M:APA91bHmTFQvfxwZZKEC4XzKRKT7RWTngm-uVv-JzOCozyI0ae0tmHVB77D13DHgX48v65omrnZ-tAbJn-Rp6bUhRMDcBu6hwSaX8s4Z9vEaQSYSwJHUEiwj_m7m1MlhDRNeO5QsMqQa');
		$fcmMsg = array(
			'body' => $message,
			'title' => $title,
			'sound' => "default",
			'color' => "#203E78"
		);
		$fcmFields = array(
			'registration_ids' => $registration_id,
			'priority' => 'high',
			'data'    => $fcmMsg,
			//'notification' => $fcmMsg
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
		curl_close($ch);
	}

	public function smsenot($title, $message, $number)
	{

		$Mbl = $number;
		// $owneremail = "ict@ribs.com.ng";
		// $subacct = "ABSAS";
		// $subacctpwd = "absas2020!";
		// $sendto = $Mbl;
		// $sender = "ABSAS";
		$message = $title . ' : ' . $message;
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

	public function EnoticenotificationNew($title, $message, $data)
	{

		$dataset = array(
			'password' => 0,
		);

		$utype = "3";
		if ($data['user_type'] == "citizens_only") {
			$utype = "1";
		} else if ($data['user_type'] == "officers_only") {
			$utype = "2";
		} else {
			$utype = "3";
		}
		$numdriver = $numdriver2 = array();
		// user_type , t_lga, agencies, t_phone_number
		if ($utype == "1" || $utype == "3") {
			$qrcd = "user_officer_meta.user_type = '1' and";
			if (!empty($data['t_lga'])) {
				$qrcd .= " user_officer_meta.lga_state like '%" . $data['t_lga'] . "%' and";
			}
			// if (!empty($data['t_phone_number'])) {
			// 	$qrcd .= " user_signup.user_phone like '%" . $data['t_phone_number'] . "%' and";
			// }
			$qr = substr($qrcd, 0, -3);
			$dt = array('multiple', array(array('user_officer_meta', 'user_officer_meta.user_id=user_signup.user_id', 'left')));
			$numdriver = $this->beats_model->select_data('user_officer_meta.*,user_signup.*,"user" as type', 'user_signup', $qr, '', array('user_signup.user_id', 'DESC'), '', $dt);
		}
		// else {
		// 	echo  "data1";
		// }

		if ($utype == "2" || $utype == "3") {
			$qrcd = "user_officer_meta.user_type = '2' and";
			if (!empty($data['t_lga'])) {
				$qrcd .= " user_officer_meta.lga_state like '%" . $data['t_lga'] . "%' and";
			}
			if (!empty($data['agencies'])) {
				$qrcd .= " user_officer_meta.agency like '%" . $data['agencies'] . "%' and";
			}
			// if (!empty($data['t_phone_number'])) {
			// 	$qrcd .= " Officer.phone like '%" . $data['t_phone_number'] . "%' and";
			// }
			$qr = substr($qrcd, 0, -3);
			$dt = array('multiple', array(array('user_officer_meta', 'user_officer_meta.user_id=Officer.Officer_id', 'left')));
			$numdriver2 = $this->beats_model->select_data('user_officer_meta.*,Officer.*,"officer" as type', 'Officer', $qr, '', array('Officer.Officer_id', 'DESC'), '', $dt);
		}
		// else {
		// 	echo  "data2";
		// }


		$numdrivernew = array_merge($numdriver, $numdriver2);

		// echo "<pre>";
		// print_r($numdrivernew);
		// echo "</pre>";

		$user_detail1 = array(
			'titile' => $title,
			'message' => $message,
			'user_id' => 0,
			'notificationdate' => date("Y-m-d H:i:s")
		);
		// if ($utype == "1" || $utype == "3") {
		// 	$userNoti = $this->beats_model->insert_data('UserNotification_all', $user_detail1);
		// }
		// if ($utype == "2" || $utype == "3") {
		// 	$officerNoti = $this->beats_model->insert_data('OfficerNotification_all', $user_detail1);
		// }
		$ttlfcm = count($numdrivernew);
		$registration_id = array();

		for ($i = 0; $i < $ttlfcm; $i++) {
			if ($numdrivernew[$i]['type'] == "officer") {
				$user_detail1 = array(
					'titile' => $title,
					'message' => $message,
					'user_id' => $numdrivernew[$i]['Officer_id'],
					'notificationdate' => date("Y-m-d H:i:s")
				);
				// $this->smsenot($title, $message, $numdrivernew[$i]['phone']);
				$officerNoti = $this->beats_model->insert_data('OfficerNotification_all', $user_detail1);
				$en_data = array(
					'enotice_type' => $data['enotice_type'],
					'enotice_id' => $data['enotice_id'],
					'user_id' => $numdrivernew[$i]['Officer_id'],
					'created_at' => date("Y-m-d H:i:s"),
				);
				$officerNotien = $this->beats_model->insert_data('Officerenotice_all', $en_data);
			} else {
				$user_detail1 = array(
					'titile' => $title,
					'message' => $message,
					'user_id' => $numdrivernew[$i]['user_id'],
					'notificationdate' => date("Y-m-d H:i:s")
				);
				// $this->smsenot($title, $message, $numdrivernew[$i]['user_phone']);
				$userNoti = $this->beats_model->insert_data('UserNotification_all', $user_detail1);
				$en_data = array(
					'enotice_type' => $data['enotice_type'],
					'enotice_id' => $data['enotice_id'],
					'user_id' => $numdrivernew[$i]['user_id'],
					'created_at' => date("Y-m-d H:i:s"),
				);
				$userNotien = $this->beats_model->insert_data('Userenotice_all', $en_data);
			}
			array_push($registration_id, $numdrivernew[$i]['fcm_tokenid']);
		}


		// define('API_ACCESS_KEY', 'AAAA4ZU5p6M:APA91bHmTFQvfxwZZKEC4XzKRKT7RWTngm-uVv-JzOCozyI0ae0tmHVB77D13DHgX48v65omrnZ-tAbJn-Rp6bUhRMDcBu6hwSaX8s4Z9vEaQSYSwJHUEiwj_m7m1MlhDRNeO5QsMqQa');
		$fcmMsg = array(
			'body' => $message,
			'title' => $title,
			'sound' => "default",
			'color' => "#203E78",
			'enotice_id' => $data['enotice_id'],
			'image'=> "https://absas.com.ng/Admin/assets/admin/img/asas_logo.png"
		);
		$fcmFields = array(
			'registration_ids' => $registration_id,
			'priority' => 'high',
			'data'    => $fcmMsg,
			//'notification' => $fcmMsg
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
		// echo "<pre>";
		// print_r($registration_id);
		// echo "</pre>";
		// print_r($result);
		curl_close($ch);
		// die;
	}

	public function Home()
	{
		$data['user'] = $this->beats_model->select_data('COUNT(user_id) AS users', 'user_signup');
		$this->load->view('Admin/home', $data);
	}

	public function adminprofile()
	{
		
		$data['admin'] = $this->beats_model->select_data('*', 'admin',array('email' => $this->session->userdata('username')));
		$this->load->view('Admin/profile', $data);
	}

	public function lgaall()
	{
		$lgas =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => $_POST['state']));
		echo '<option value=" "> Select LGA</option>';
		foreach ($lgas as $itm) {
			echo '<option value="' . $itm['LGA'] . '"> ' . $itm['LGA'] . '</option>';
		}
	}

	public function CreateUnit()
	{
		$user_detail = array(
			'UnitName' => $_POST['UnitName'],
			'Street' => $_POST['Street'],
			'City' => $_POST['City'],
			'State' => $_POST['State'],
			'LGA' => $_POST['LGA'],
			'Latitude' => $_POST['Latitude'],
			'Longitude' => $_POST['Longitude'],
			'VehicleType' => $_POST['VehicleType'],
			'PlateNumber' => $_POST['PlateNumber'],
			'DepartmentAssigned' => $_POST['DepartmentAssigned'],
			'PatrolLocations' => json_encode(array_filter($_POST['PatrolLocations'])),
			'ContactNumber' => $_POST['ContactNumber'],
			'Specialidentifier' => $_POST['Specialidentifier'],
			'HeadUnit' => $_POST['HeadUnit'],
			'UnitType' => $_POST['UnitType'],
		);

		$reg_id = $this->beats_model->insert_data('PoliceUnit', $user_detail);
		redirect(base_url('/PoliceUnit'));
	}

	public function OfficerUnit()
	{
		$dt = array('multiple', array(array('PoliceUnitType', 'PoliceUnitType.PoliceUnitType_id=EMERGENCY_NUMBERS.emergency_type_id', 'left')));
		$data['result'] = $this->beats_model->select_data('PoliceUnitType.*,EMERGENCY_NUMBERS.*', 'EMERGENCY_NUMBERS', '', '', array('EMERGENCY_id', 'DESC'), '', $dt);

		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE,Zone', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['unit_types'] =  $this->beats_model->select_data('*', 'PoliceUnitType', 'PoliceUnitType_id NOT IN (1,2,3,4,5,6,7,8)', '', array('PoliceUnitType_id', 'ASC'));
		$this->load->view('Admin/OfficerUnit', $data);
	}
	public function OfficerUnitdel()
	{
		$EMERGENCY_id = $_POST['EMERGENCY_id'];

		$res = $this->beats_model->delete_data('EMERGENCY_NUMBERS', array('EMERGENCY_id' => $EMERGENCY_id));
	}
	public function CreateOfficerUnit()
	{
		$user_detail = array(
			'STATE' => $_POST['State'],
			'NUM' => $_POST['NUM'],
			'ZONE' => $_POST['ZONE'],
			'emergency_type_id' => $_POST['emergency_type_id']
		);
		$reg_id = $this->beats_model->insert_data('EMERGENCY_NUMBERS', $user_detail);
		redirect(base_url('/OfficerUnit'));
	}
	public function UpdateOfficerUnit()
	{
		$user_detail = array(
			// 'EMERGENCY_id' => $_POST['EMERGENCY_id'],
			'STATE' => $_POST['edState'],
			'NUM' => $_POST['NUM'],
			'ZONE' => $_POST['ZONE'],
			'emergency_type_id' => $_POST['emergency_type_id']
		);

		$updt_id = $this->beats_model->update_data('EMERGENCY_NUMBERS', $user_detail, array('EMERGENCY_id' => $_POST['EMERGENCY_id']));
		redirect(base_url('/OfficerUnit'));
	}

	//public function SmsPhoneVal($keywords, $sim, $sender, $message, $ref, $msgdate, $entrydate)
	public function SmsPhoneValbb()
	{
		//SMS PHONE VALIDATION
		/*
	if(!empty($_REQUEST['keyword'])){$keyword = $_REQUEST['keyword'];}
    $sim= $_REQUEST['sim'];
    $sender= $_REQUEST['sender'];
    $message= $_REQUEST['message'];
    $ref = $_REQUEST['ref'];
    $msgdate= $_REQUEST['date'];
    date_default_timezone_set("Africa/Lagos");
    $entrydate = date('Y-m-d H:i:s');
    
    
    //$recField = "keyword, sim, sender, message, ref, msgdate, entrydate";
    //$recData = "'$keyword', '$sim', '$sender', '$message', '$ref', '$msgdate', '$entrydate'";
	
	 if(!empty($sender))
	 {
	     $tableData = array('keyword' => $keyword, 'sim' => $sim, 'sender' => $sender, 'message' => $message, 'ref' => $ref, 'msgdate' => $msgdate, 'entryDate' => $entrydate);
	     $this->beats_model->insert_data("shortcode_sms", $tableData);
	 }
	
	echo json_encode(array('status' => true, 'message' => 'Successful'));
	*/

		echo "YOU ARE WELCOME";
	}

	public function OfficerUnitview()
	{
		$EMERGENCY_id = $_POST['EMERGENCY_id'];
		$dt = array('multiple', array(array('PoliceUnitType', 'PoliceUnitType.PoliceUnitType_id=EMERGENCY_NUMBERS.emergency_type_id', 'left')));
		$res = $this->beats_model->select_data('PoliceUnitType.*,EMERGENCY_NUMBERS.*', 'EMERGENCY_NUMBERS', array('EMERGENCY_id' => $EMERGENCY_id), '', array('EMERGENCY_id', 'DESC'), '', $dt);

		foreach ($res as $re) {
			$as1 = $re['EMERGENCY_id'];
			$as2 = $re['STATE'];
			$as3 = $re['NUM'];
			$as4 = $re['ZONE'];
			$as5 = $re['emergency_type_id'];
			$as6 = $re['PoliceUnitType_name'];
			echo '<div class="col-12 col-md-12">
					<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Emergency ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">LGA:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Number:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Agency Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
									
									</div>';
		}
	}

	public function OfficerUnitEdit()
	{
		$state_new =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$unit_types =  $this->beats_model->select_data('*', 'PoliceUnitType', 'PoliceUnitType_id NOT IN (1,2,3,4,5,6,7,8)', '', array('PoliceUnitType_id', 'ASC'));
		$dt = array('multiple', array(array('PoliceUnitType', 'PoliceUnitType.PoliceUnitType_id=EMERGENCY_NUMBERS.emergency_type_id', 'left')));
		$result = $this->beats_model->select_data('PoliceUnitType.*,EMERGENCY_NUMBERS.*', 'EMERGENCY_NUMBERS', array('EMERGENCY_id' =>  $_POST['EMERGENCY_id']), '', array('EMERGENCY_id', 'DESC'), '', $dt);

		$state =  $this->beats_model->select_data('DISTINCT(STATE) as STATE,Zone ', 'state_zone', '', '', array('STATE', 'ASC'));


		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">LGA</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<input type="hidden" class="form-control" name="EMERGENCY_id" id="EMERGENCY_id" value="' . $result['0']['EMERGENCY_id'] . '" required/>
														
														<input type="hidden" class="form-control" name="ZONE" id="edZONE" value="' . $result['0']['ZONE'] . '" required/>
														<select class="form-control" name="edState" id="edState" required>
														<option value="">Select LGA</option>
														';
		foreach ($state_new as $itm) {
			echo '<option class="' . $itm['Zone'] . '" value="' . $itm['LGA'] . '" ';
			if ($result['0']['STATE'] == $itm['LGA']) {
				echo 'selected';
			}
			echo '>' . $itm['LGA'] . '</option>';
		}
		echo '</select>                                
                                                    </div>                                            
                                                 
                                                </div>
											</div>';

		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Agency</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
																									
														<select class="form-control" name="emergency_type_id" id="emergency_type_id" required>
														<option value="">Select Unit Type</option>	
														';
		foreach ($unit_types as $itm) {
			echo '<option value="' . $itm['PoliceUnitType_id'] . '" ';
			if ($result['0']['emergency_type_id'] == $itm['PoliceUnitType_id']) {
				echo 'selected';
			}
			echo '>' . $itm['PoliceUnitType_name'] . '</option>';
		}
		echo '</select>                                
                                                    </div>                                            
                                                 
                                                </div>
											</div>';

		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="NUM" id="NUM"  value="' . $result['0']['NUM'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
											</div>											
										   ';
		echo '<script> $("#edState").change(function() {                          
											var end = $(\'select[name="edState"] :selected\').attr(\'class\');           
											$("#edZONE").attr(\'value\', end);
										});</script>';
	}

	public function PoliceUnit()
	{
		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE,Zone', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['unit_types'] =  $this->beats_model->select_data('*', 'PoliceUnitType', 'PoliceUnitType_id NOT IN (1,2,3,4,5,6,7,8)', '', array('PoliceUnitType_id', 'ASC'));
		$data['result'] = $this->beats_model->select_data('*', 'PoliceUnit ');
		$this->load->view('Admin/PoliceUnit', $data);
	}

	public function PoliceUnitdel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('PoliceUnit', array('PoliceUnit_id' => $id));
	}
	public function UpdatePoliceUnit()
	{

		$user_detail = array(
			'UnitName' => $_POST['UnitName'],
			'Street' => $_POST['Street'],
			'City' => $_POST['City'],
			'State' => $_POST['State'],
			'LGA' => $_POST['LGA'],
			'Latitude' => $_POST['Latitude'],
			'Longitude' => $_POST['Longitude'],
			'VehicleType' => $_POST['VehicleType'],
			'PlateNumber' => $_POST['PlateNumber'],
			'DepartmentAssigned' => $_POST['DepartmentAssigned'],
			'PatrolLocations' => json_encode(array_filter($_POST['PatrolLocations'])),
			'ContactNumber' => $_POST['ContactNumber'],
			'Specialidentifier' => $_POST['Specialidentifier'],
			'HeadUnit' => $_POST['HeadUnit'],
			'UnitType' => $_POST['UnitType'],
		);

		$updt_id = $this->beats_model->update_data('PoliceUnit', $user_detail, array('PoliceUnit_id' => $_POST['PoliceUnit_id']));
		redirect(base_url('/PoliceUnit'));
	}

	public function PoliceUnitview()
	{
		$id = $_POST['id'];
		$res = $this->beats_model->select_data('*', 'PoliceUnit', array('PoliceUnit_id' => $id));

		foreach ($res as $re) {
			$as1 = $re['PoliceUnit_id'];
			$as2 = $re['UnitName'];
			$as3 = $re['Street'];
			$as4 = $re['LGA'];
			$as5 = $re['City'];
			$as6 = $re['State'];
			$as7 = $re['Latitude'];
			$as8 = $re['Longitude'];
			$as9 = $re['UnitType'];
			$as10 = $re['VehicleType'];
			$as11 = $re['PlateNumber'];
			$as12 = $re['DepartmentAssigned'];
			$as13 = $re['PatrolLocations'];
			$as14 = $re['ContactNumber'];
			$as15 = $re['Specialidentifier'];
			$as16 = $re['HeadUnit'];
			$as17 = $re['created_at'];
			echo '<div class="col-12 col-md-12">
					<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">UnitName:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Street:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">LGA:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">City:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">State:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											   ' . $as6 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Latitude :</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>	<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Longitude:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">UnitType:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as9 . '
																					</span>
										</div>
									</div>';
			if (!empty($as10)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">VehicleType:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as10 . '
																					</span>
										</div>
									</div>';
			}
			if (!empty($as11)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">PlateNumber:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as11 . '
																					</span>
										</div>
									</div>';
			}
			if (!empty($as12)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">DepartmentAssigned:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>';
			}
			if (!empty($as13)) {
				$lsdata = json_decode($as13);
				if (!empty($lsdata[0])) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">PatrolLocations:</div>
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;word-wrap: break-word;">
					<ul>';
					foreach ($lsdata as $ls) {
						echo "<li>$ls</li>";
					}
					echo '</ul>
					</div>
					</div>';
				}
			}
			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ContactNumber:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as14 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Specialidentifier:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as15 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">HeadUnit:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as16 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as17 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function PoliceUnitEdit()
	{

		$result = $this->beats_model->select_data('*', 'PoliceUnit', array('PoliceUnit_id' => $_POST['id']));

		$state_new =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$state =  $this->beats_model->select_data('DISTINCT(STATE) as STATE,Zone', 'state_zone', '', '', array('STATE', 'ASC'));

		$lgas =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => $result['0']['State']));
		$unit_types =  $this->beats_model->select_data('*', 'PoliceUnitType', 'PoliceUnitType_id NOT IN (1,2,3,4,5,6,7,8)', '', array('PoliceUnitType_id', 'ASC'));


		echo '<div class="form-group">
    <label class="col-md-3 control-label">Unit Name</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="UnitName" id="UnitName" value="' . $result['0']['UnitName'] . '" required />
            <input type="hidden" class="form-control" name="PoliceUnit_id" id="PoliceUnit_id" value="' . $result['0']['PoliceUnit_id'] . '" required />
            <input type="hidden" class="form-control" name="State" id="State" value="Abia" readonly required />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Unit Address</label>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Street</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="Street" id="Street" value="' . $result['0']['Street'] . '" required />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">City</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="City" id="City" value="' . $result['0']['City'] . '" required />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">LGA</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <select class="form-control" name="LGA" id="statelga">
                <option value="">Select LGA</option>';
		foreach ($state_new as $itm) {
			echo '<option value="' . $itm['LGA'] . '" ' . ($result[0]['LGA'] == $itm['LGA'] ? 'selected' : '') . '>' . $itm['LGA'] . '</option>';
		}
		echo '</select>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Latitude</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="Latitude" id="Latitude" value="' . $result['0']['Latitude'] . '" required />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Longitude</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="Longitude" id="Longitude" value="' . $result['0']['Longitude'] . '" required />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Unit Type</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>';
		// echo  '<select class="form-control" name="UnitType" id="UnitType" onchange="unittype1(this.value)">';
		echo '<select class="form-control" name="UnitType" id="UnitType"">
                <option value="">Select Unit Type</option>';
		foreach ($unit_types as $itm) {
			echo '<option value="' . $itm['PoliceUnitType_name'] . '" ' . ($result[0]['UnitType'] == $itm['PoliceUnitType_name'] ? 'selected' : '') . '>' . $itm['PoliceUnitType_name'] . '</option>';
		}
		echo '</select>
        </div>
    </div>
</div>';
		/* echo '<div class="form-group" style="display:none;" id="VehicleType1">
    <label class="col-md-3 control-label">Vehicle Type</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="VehicleType" value="' . $result['0']['VehicleType'] . '" required />
        </div>
    </div>
</div>
<div class="form-group" style="display:none;" id="PlateNumber1">
    <label class="col-md-3 control-label">Plate Number</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="PlateNumber" id="" value="' . $result['0']['PlateNumber'] . '" required />
        </div>
    </div>
</div>
<div class="form-group" style="display:none;" id="DepartmentAssigned1">
    <label class="col-md-3 control-label">Unit/Department Assigned</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="DepartmentAssigned" value="' . $result['0']['DepartmentAssigned'] . '" required />
        </div>
    </div>
</div>
<div class="form-group" style="display:none;" id="PatrolLocations1">
    <label class="col-md-3 control-label">Patrol Locations</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="PatrolLocations" value="' . $result['0']['PatrolLocations'] . '" required />
        </div>
	</div>
	<a href="javascript:void(0)" onclick="addlocation()" style="margin-right: 80px;width: 10px;float: right;margin-top:10px;"><span class="input-group-addon">ADD More</span></a>
</div>
<div id="adt"></div><br>';
 */
		echo '<div class="form-group">
    <label class="col-md-3 control-label">Contact Number</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="ContactNumber" id="ContactNumber" value="' . $result['0']['ContactNumber'] . '" required />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Special identifier</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="Specialidentifier" id="Specialidentifier" value="' . $result['0']['Specialidentifier'] . '" required />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Head of Unit</label>
    <div class="col-md-9">
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
            <input type="text" class="form-control" name="HeadUnit" id="HeadUnit" value="' . $result['0']['HeadUnit'] . '" required />
        </div>
    </div>
</div>';
	}


	public function Reporttype()
	{

		$id = $_POST['id'];
		$type = $_POST['type'];
		if ($id == 0) {
			$soscategory =  $this->beats_model->select_data('*', 'sos_category');

			echo '<option value="">Select Type</option>';

			foreach ($soscategory as $itm) {

				echo '<option value="' . $itm['sos_category_id'] . '">' . $itm['sos_category_name'] . '</option>';
			}
		} else {
			$filedcategory =  $this->beats_model->select_data('*', 'FiledReports_category');
			echo '<option value="">Select Type</option>';

			$count = 1;
			foreach ($filedcategory as $itm) {

				echo '<option value="' . $count . '">' . $itm['FiledReport_name'] . '</option>';
				$count++;
			}
		}
	}

	public function CrimemapPopularity()
	{
		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$a = " created_dateat BETWEEN '" . date("Y/m/d", strtotime($_POST['startdate'])) . "'" . " AND '" . date("Y/m/d", strtotime($_POST['enddate'])) . "'";
		if ($_POST['typer'] == 0) {
			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			//  $this->session->set_flashdata('success', count($data['resultsos']).' result found.');

		} else {
			$date_s = "date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
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
		}
		$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$this->load->view('Admin/CrimemapPopularity', $data);
	}
	public function CrimemapState()
	{
		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		if ($_POST['typer'] == 0) {
			$a = " ( created_dateat BETWEEN '" . date("Y/m/d", strtotime($_POST['startdate'])) . "'" . " AND '" . date("Y/m/d", strtotime($_POST['enddate'])) . "' ) AND ( SOS_category =" . $_POST['reporttype'] . " AND current_location Like" . "'%" . $_POST['State'] . '%' . "' )";
			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// $this->session->set_flashdata('success', count($data['resultsos']).' result found.');
		} else {
			$date_s = "date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
			$state = $_POST['State'];

			switch (trim($_POST['reporttype'])) {
				case "1":
					$lang = "iWitness";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
					break;
				case "2":
					$lang = "Officer_Abuse";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result1'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'));
					break;
				case "3":
					$lang = "Commend_Officer";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result2'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'));
					break;
				case "4":
					$lang = "StolenVehicle_report";
					$date_s = "Vehicle_lastlocation Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result3'] = $this->beats_model->select_data('*,(Vehicle_lastlocation) as GeoLocationnew', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'));
					break;
				case "5":
					$lang = "Missing_Persons_report";
					$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result4'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'));
					break;
				case "6":
					$lang = "Lodgecomplaint_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result5'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'));
					break;
				case "7":
					$lang = "Gun_Violence_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result6'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'));
					break;
				case "8":
					$lang = "Drug_Abuse_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result7'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'));
					break;
				case "9":
					$lang = "Domestic_Violence_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result8'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'));
					break;
				case "10":
					$lang = "Terrorist_Attack_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result9'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'));
					break;
				case "11":
					$lang = "Rape_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result10'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'));
					break;
				case "12":
					$lang = "Kidnap_report";
					$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result11'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'));
					break;
				case "13":
					$lang = "Robbery_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result12'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'));
					break;
				case "14":
					$lang = "Burglary_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result13'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'));
					break;
				case "15":
					$lang = "CybercrimeFraud_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result14'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'));
					break;
				case "16":
					$lang = "Submit_Tip_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result15'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'));
					break;
				case "17":
					$lang = "Others_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result16'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'));
					break;
				case "18":
					$lang = "Vandalism_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result17'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'));
					break;
				case "19":
					$lang = "Fire_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result18'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'));
					break;
				case "20":
					$lang = "Accident_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result19'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'));
					break;
				case "21":
					$lang = "Medical_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result20'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'));
					break;
				case "22":
					$lang = "Riot_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result21'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'));
					break;
				case "23":
					$lang = "Environmental_Hazard_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result22'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'));
					break;
				case "24":
					$lang = "Child_Abuse_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result23'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'));
					break;
				case "25":
					$lang = "Human_Trafficking_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result24'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'));
					break;
				case "26":
					$lang = "Blow_Whistle_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result25'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'));
					break;
				default:
					$lang = "iWitness";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
			}
		}
		$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));

		$this->load->view('Admin/CrimemapState', $data);
	}
	public function CrimemapResponsetime()
	{
		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		if ($_POST['typer'] == 0) {
			$a = " ( created_dateat BETWEEN '" . date("Y/m/d", strtotime($_POST['startdate'])) . "'" . " AND '" . date("Y/m/d", strtotime($_POST['enddate'])) . "' ) AND ( SOS_category =" . $_POST['reporttype'] . " AND current_location Like" . "'%" . $_POST['State'] . '%' . "' )";
			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			// $this->session->set_flashdata('success', count($data['resultsos']).' result found.');
		} else {
			$date_s = "date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
			$state = $_POST['State'];

			switch (trim($_POST['reporttype'])) {
				case "1":
					$lang = "iWitness";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
					break;
				case "2":
					$lang = "Officer_Abuse";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result1'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'));
					break;
				case "3":
					$lang = "Commend_Officer";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result2'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'));
					break;
				case "4":
					$lang = "StolenVehicle_report";
					$date_s = "Vehicle_lastlocation Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result3'] = $this->beats_model->select_data('*,(Vehicle_lastlocation) as GeoLocationnew', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'));
					break;
				case "5":
					$lang = "Missing_Persons_report";
					$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result4'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'));
					break;
				case "6":
					$lang = "Lodgecomplaint_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result5'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'));
					break;
				case "7":
					$lang = "Gun_Violence_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result6'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'));
					break;
				case "8":
					$lang = "Drug_Abuse_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result7'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'));
					break;
				case "9":
					$lang = "Domestic_Violence_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result8'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'));
					break;
				case "10":
					$lang = "Terrorist_Attack_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result9'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'));
					break;
				case "11":
					$lang = "Rape_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result10'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'));
					break;
				case "12":
					$lang = "Kidnap_report";
					$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result11'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'));
					break;
				case "13":
					$lang = "Robbery_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result12'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'));
					break;
				case "14":
					$lang = "Burglary_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result13'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'));
					break;
				case "15":
					$lang = "CybercrimeFraud_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result14'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'));
					break;
				case "16":
					$lang = "Submit_Tip_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result15'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'));
					break;
				case "17":
					$lang = "Others_report";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result16'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'));
					break;
				case "18":
					$lang = "Vandalism_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result17'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'));
					break;
				case "19":
					$lang = "Fire_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result18'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'));
					break;
				case "20":
					$lang = "Accident_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result19'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'));
					break;
				case "21":
					$lang = "Medical_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result20'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'));
					break;
				case "22":
					$lang = "Riot_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result21'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'));
					break;
				case "23":
					$lang = "Environmental_Hazard_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result22'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'));
					break;
				case "24":
					$lang = "Child_Abuse_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result23'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'));
					break;
				case "25":
					$lang = "Human_Trafficking_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result24'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'));
					break;
				case "26":
					$lang = "Blow_Whistle_report";
					$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result25'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'));
					break;
				default:
					$lang = "iWitness";
					$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
					$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
			}
		}
		$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));

		$this->load->view('Admin/CrimemapState', $data);
	}
	public function CrimemapLocation()
	{
		$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));

		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));

		$a = " ( created_dateat BETWEEN '" . date("Y/m/d", strtotime($_POST['startdate'])) . "'" . " AND '" . date("Y/m/d", strtotime($_POST['enddate'])) . "' ) AND ( SOS_category =" . $_POST['reporttype'] . ")";
		if ($_POST['typer'] == 0) {
			$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
			$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $a, '', array('SOS_id', 'DESC'), '', $dt);
			//$this->session->set_flashdata('success', count($data['resultsos']).' result found.');
		} else {
			$date_s = "date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
			switch (trim($_POST['reporttype'])) {
				case "1":
					$lang = "iWitness";
					$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
					break;
				case "2":
					$lang = "Officer_Abuse";
					$data['result1'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'));
					break;
				case "3":
					$lang = "Commend_Officer";
					$data['result2'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'));
					break;
				case "4":
					$lang = "StolenVehicle_report";
					$data['result3'] = $this->beats_model->select_data('*,(Vehicle_lastlocation) as GeoLocationnew', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'));
					break;
				case "5":
					$lang = "Missing_Persons_report";
					$data['result4'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'));
					break;
				case "6":
					$lang = "Lodgecomplaint_report";
					$data['result5'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'));
					break;
				case "7":
					$lang = "Gun_Violence_report";
					$data['result6'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'));
					break;
				case "8":
					$lang = "Drug_Abuse_report";
					$data['result7'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'));
					break;
				case "9":
					$lang = "Domestic_Violence_report";
					$data['result8'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'));
					break;
				case "10":
					$lang = "Terrorist_Attack_report";
					$data['result9'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'));
					break;
				case "11":
					$lang = "Rape_report";
					$data['result10'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'));
					break;
				case "12":
					$lang = "Kidnap_report";
					$data['result11'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'));
					break;
				case "13":
					$lang = "Robbery_report";
					$data['result12'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'));
					break;
				case "14":
					$lang = "Burglary_report";
					$data['result13'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'));
					break;
				case "15":
					$lang = "CybercrimeFraud_report";
					$data['result14'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'));
					break;
				case "16":
					$lang = "Submit_Tip_report";
					$data['result15'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'));
					break;
				case "17":
					$lang = "Others_report";
					$data['result16'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'));
					break;
				case "18":
					$lang = "Vandalism_report";
					$data['result17'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'));
					break;
				case "19":
					$lang = "Fire_report";
					$data['result18'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'));
					break;
				case "20":
					$lang = "Accident_report";
					$data['result19'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'));
					break;
				case "21":
					$lang = "Medical_report";
					$data['result20'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'));
					break;
				case "22":
					$lang = "Riot_report";
					$data['result21'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'));
					break;
				case "23":
					$lang = "Environmental_Hazard_report";
					$data['result22'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'));
					break;
				case "24":
					$lang = "Child_Abuse_report";
					$data['result23'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'));
					break;
				case "25":
					$lang = "Human_Trafficking_report";
					$data['result24'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'));
					break;
				case "26":
					$lang = "Blow_Whistle_report";
					$data['result25'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'));
					break;
				default:
					$lang = "iWitness";
					$data['result'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
			}
		}
		$this->load->view('Admin/CrimemapLocation', $data);
	}

	public function FiledReportsPopularity()
	{
		$date_s = "date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result0'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
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

		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$date_s = "date(SOSManagement.created_dateat) = date('" . date('Y-m-d') . "') ";
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $date_s, '', array('SOS_id', 'DESC'), '', $dt);

		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['soscategory'] =  $this->beats_model->select_data('*', 'sos_category');
		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');

		$data['startdate'] = $_POST['startdate'];
		$data['enddate'] = $_POST['enddate'];
		$data['result'] = $this->beats_model->select_data('*', 'Others_report', '', '', array('Others_report_id', 'DESC'));

		$rsdata = array();
		$i = 0;
		foreach ($data['filedcategory'] as $catr) {
			$r = 'result' . $i;
			if (!empty($data[$r])) {
				$ds = array(
					'FiledReport_name' => $catr['FiledReport_name'],
					'FiledReports_tablename' => $catr['FiledReports_tablename'],
					'data_new' => $data[$r]
				);
				array_push($rsdata, $ds);
			}
			$i++;
		}
		$result_new = array();
		$result_new_1 = array();
		foreach ($data['state_new'] as $itm) {
			foreach ($data['filedcategory'] as $k => $catr) {
				if ($this->is_in_array($rsdata, trim('FiledReports_tablename'), trim($catr['FiledReports_tablename'])) === 'yes') {
					foreach ($rsdata as $rs) {
						$i = 0;
						if ($rs['FiledReports_tablename'] == $catr['FiledReports_tablename']) {
							foreach ($rs['data_new'] as $rsdata_new) {
								if (strripos(' ' . $rsdata_new['GeoLocationnew'], $itm['LGA'])) {
									$i++;
								}
							}
						}
						$result_new['report_category_name'] = $rs['FiledReport_name'];
						$result_new['STATE'] = $itm['LGA'];
						$result_new['Frequency'] = $i;
						$result_new['Duration'] = $_POST['startdate'] . ' to ' . $_POST['enddate'];
						if ($i != 0) {
							array_push($result_new_1, $result_new);
						}
					}
				}
			}
		}


		$data['result_new'] = $result_new_1;

		$this->load->view('Admin/FiledReportsPopularity', $data);
	}
	public function FiledReportsState()
	{

		$state = ($_POST['State'] == 'Select Local Government' ? '' : $_POST['State']);
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result0'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result1'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result2'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'));
		$date_s = "Vehicle_lastlocation Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result3'] = $this->beats_model->select_data('*,(Vehicle_lastlocation) as GeoLocationnew', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'));
		$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result4'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result5'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result6'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'));
		$data['result7'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'));
		$data['result8'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'));
		$data['result9'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'));
		$data['result10'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'));
		$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result11'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result12'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'));
		$data['result13'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'));
		$data['result14'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'));
		$data['result15'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'));
		$data['result16'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'));

		$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result17'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'));
		$data['result18'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'));
		$data['result19'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'));
		$data['result20'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'));
		$data['result21'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'));
		$data['result22'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'));
		$data['result23'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'));
		$data['result24'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'));
		$data['result25'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'));

		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$date_s = "date(SOSManagement.created_dateat) = date('" . date('Y-m-d') . "') ";
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $date_s, '', array('SOS_id', 'DESC'), '', $dt);

		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['soscategory'] =  $this->beats_model->select_data('*', 'sos_category');
		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');

		$data['startdate'] = $_POST['startdate'];
		$data['enddate'] = $_POST['enddate'];
		$data['result'] = $this->beats_model->select_data('*', 'Others_report', '', '', array('Others_report_id', 'DESC'));

		$rsdata = array();

		if ($_POST['reporttype'] == "Select Type") {
			$i = 0;
			foreach ($data['filedcategory'] as $catr) {
				$r = 'result' . $i;
				if (!empty($data[$r])) {
					$ds = array(
						'FiledReport_name' => $catr['FiledReport_name'],
						'FiledReports_tablename' => $catr['FiledReports_tablename'],
						'data_new' => $data[$r]
					);
					array_push($rsdata, $ds);
				}
				$i++;
			}
		} else {
			$reporttype = ($_POST['reporttype'] == "Select Type") ? 0 : $_POST['reporttype'];
			$r = 'result' . ($reporttype - 1);
			if (!empty($data[$r])) {
				$ds = array(
					'FiledReport_name' => $data['filedcategory'][$reporttype - 1]['FiledReport_name'],
					'FiledReports_tablename' => $data['filedcategory'][$reporttype - 1]['FiledReports_tablename'],
					'data_new' => $data[$r]
				);
				array_push($rsdata, $ds);
			}
		}
		$result_new = array();
		$result_new_1 = array();
		foreach ($data['state_new'] as $itm) {
			foreach ($data['filedcategory'] as $k => $catr) {
				if ($this->is_in_array($rsdata, trim('FiledReports_tablename'), trim($catr['FiledReports_tablename'])) === 'yes') {
					foreach ($rsdata as $rs) {
						$i = 0;
						if ($rs['FiledReports_tablename'] == $catr['FiledReports_tablename']) {
							foreach ($rs['data_new'] as $rsdata_new) {
								if (strripos(' ' . $rsdata_new['GeoLocationnew'], $itm['LGA'])) {
									$i++;
								}
							}
						}
						$result_new['report_category_name'] = $rs['FiledReport_name'];
						$result_new['STATE'] = $itm['LGA'];
						$result_new['Frequency'] = $i;
						$result_new['Duration'] = $_POST['startdate'] . ' to ' . $_POST['enddate'];
						if ($i != 0) {
							array_push($result_new_1, $result_new);
						}
					}
				}
			}
		}

		$data['result_new'] = $result_new_1;

		$this->load->view('Admin/FiledReportsState', $data);
	}
	public function FiledReportsResponsetime()
	{

		$date_s = "date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";

		if (trim($_POST['State']) != "Select Local Government") {
			$state = (trim($_POST['State']) == "Select Local Government" ? '' : $_POST['State']);
			$date_s = "GeoLocation Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		}
		$state = ($_POST['State'] == 'Select Local Government' ? '' : $_POST['State']);
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result0'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result1'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Officer_Abuse', $date_s, '', array('OfficerAbuse_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result2'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Commend_Officer', $date_s, '', array('CommendOffice_id', 'DESC'));
		$date_s = "Vehicle_lastlocation Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result3'] = $this->beats_model->select_data('*,(Vehicle_lastlocation) as GeoLocationnew', 'StolenVehicle_report', $date_s, '', array('StolenVehicle_report_id', 'DESC'));
		$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result4'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Missing_Persons_report', $date_s, '', array('Missing_Persons_report_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result5'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Lodgecomplaint_report', $date_s, '', array('Lodgecomplaint_report_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result6'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Gun_Violence_report', $date_s, '', array('GunViolence_id', 'DESC'));
		$data['result7'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Drug_Abuse_report', $date_s, '', array('DrugAbuse_report_id', 'DESC'));
		$data['result8'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Domestic_Violence_report', $date_s, '', array('DomesticViolence_report_id', 'DESC'));
		$data['result9'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Terrorist_Attack_report', $date_s, '', array('TerroristAttack_report_id', 'DESC'));
		$data['result10'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Rape_report', $date_s, '', array('Rape_report_id', 'DESC'));
		$date_s = "Last_Seen_Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result11'] = $this->beats_model->select_data('*,(Last_Seen_Location) as GeoLocationnew', 'Kidnap_report', $date_s, '', array('Kidnap_report_id', 'DESC'));
		$date_s = "Location Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result12'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Robbery_report', $date_s, '', array('Robbery_report_id', 'DESC'));
		$data['result13'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Burglary_report', $date_s, '', array('Burglary_report_id', 'DESC'));
		$data['result14'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'CybercrimeFraud_report', $date_s, '', array('CybercrimeFraud_report_id', 'DESC'));
		$data['result15'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Submit_Tip_report', $date_s, '', array('Submit_Tip_id', 'DESC'));
		$data['result16'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'Others_report', $date_s, '', array('Others_report_id', 'DESC'));

		$date_s = "Name Like" . "'%" . $state . '%' . "' AND date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result17'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Vandalism_report', $date_s, '', array('Vandalism_report_id', 'DESC'));
		$data['result18'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Fire_report', $date_s, '', array('Fire_report_id', 'DESC'));
		$data['result19'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Accident_report', $date_s, '', array('Accident_report_id', 'DESC'));
		$data['result20'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Medical_report', $date_s, '', array('Medical_report_id', 'DESC'));
		$data['result21'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Riot_report', $date_s, '', array('Riot_report_id', 'DESC'));
		$data['result22'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Environmental_Hazard_report', $date_s, '', array('Environmental_Hazard_report_id', 'DESC'));
		$data['result23'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Child_Abuse_report', $date_s, '', array('Child_Abuse_report_id', 'DESC'));
		$data['result24'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Human_Trafficking_report', $date_s, '', array('Human_Trafficking_report_id', 'DESC'));
		$data['result25'] = $this->beats_model->select_data('*,(Name) as GeoLocationnew', 'Blow_Whistle_report', $date_s, '', array('Blow_Whistle_report_id', 'DESC'));

		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$date_s = "date(SOSManagement.created_dateat) = date('" . date('Y-m-d') . "') ";
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $date_s, '', array('SOS_id', 'DESC'), '', $dt);

		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['soscategory'] =  $this->beats_model->select_data('*', 'sos_category');
		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');

		$data['startdate'] = $_POST['startdate'];
		$data['enddate'] = $_POST['enddate'];
		$data['result'] = $this->beats_model->select_data('*', 'Others_report', '', '', array('Others_report_id', 'DESC'));
		$data['State'] = $_POST['State'] ==  "Select Local Government" ? '' : $_POST['State'];

		$rsdata = array();

		if ($_POST['reporttype'] == "Select Type") {

			$i = 0;
			foreach ($data['filedcategory'] as $catr) {
				$r = 'result' . $i;
				if (!empty($data[$r])) {
					$ds = array(
						'FiledReport_name' => $catr['FiledReport_name'],
						'FiledReports_tablename' => $catr['FiledReports_tablename'],
						'data_new' => $data[$r]
					);
					array_push($rsdata, $ds);
				}
				$i++;
			}
		} else {
			$reporttype = ($_POST['reporttype'] == "Select Type") ? 0 : $_POST['reporttype'];

			$r = 'result' . ($reporttype - 1);
			if (!empty($data[$r])) {
				$ds = array(
					'FiledReport_name' => $data['filedcategory'][$reporttype - 1]['FiledReport_name'],
					'FiledReports_tablename' => $data['filedcategory'][$reporttype - 1]['FiledReports_tablename'],
					'data_new' => $data[$r]
				);
				array_push($rsdata, $ds);
			}
		}


		$result_new = array();
		$result_new_1 = array();
		foreach ($data['state_new'] as $itm) {
			foreach ($data['filedcategory'] as $k => $catr) {
				if ($this->is_in_array($rsdata, trim('FiledReports_tablename'), trim($catr['FiledReports_tablename'])) === 'yes') {
					foreach ($rsdata as $rs) {
						$i = 0;
						if ($rs['FiledReports_tablename'] == $catr['FiledReports_tablename']) {
							foreach ($rs['data_new'] as $rsdata_new) {
								if (strripos(' ' . $rsdata_new['GeoLocationnew'], $itm['LGA'])) {
									$i++;
								}
							}
						}
						$result_new['report_category_name'] = $rs['FiledReport_name'];
						$result_new['STATE'] = $itm['LGA'];
						$result_new['Frequency'] = $i;
						$result_new['Duration'] = $_POST['startdate'] . ' to ' . $_POST['enddate'];
						if ($i != 0) {
							array_push($result_new_1, $result_new);
						}
					}
				}
			}
		}

		// print_r($result_new_1);

		$data['result_new'] = $rsdata;

		$this->load->view('Admin/FiledReportsResponsetime', $data);
	}
	public function FiledReportsLocation()
	{
		$date_s = "date(created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		$data['result0'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
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

		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$date_s = "date(SOSManagement.created_dateat) = date('" . date('Y-m-d') . "') ";
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $date_s, '', array('SOS_id', 'DESC'), '', $dt);

		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['soscategory'] =  $this->beats_model->select_data('*', 'sos_category');
		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');

		$data['startdate'] = $_POST['startdate'];
		$data['enddate'] = $_POST['enddate'];
		$data['result'] = $this->beats_model->select_data('*', 'Others_report', '', '', array('Others_report_id', 'DESC'));
		$reporttype = $_POST['reporttype'];

		$rsdata = array();

		if ($_POST['reporttype'] == "Select Type") {

			$i = 0;
			foreach ($data['filedcategory'] as $catr) {
				$r = 'result' . $i;
				if (!empty($data[$r])) {
					$ds = array(
						'FiledReport_name' => $catr['FiledReport_name'],
						'FiledReports_tablename' => $catr['FiledReports_tablename'],
						'data_new' => $data[$r]
					);
					array_push($rsdata, $ds);
				}
				$i++;
			}
		} else {
			$reporttype = ($_POST['reporttype'] == "Select Type") ? 0 : $_POST['reporttype'];
			$r = 'result' . ($reporttype - 1);
			if (!empty($data[$r])) {
				$ds = array(
					'FiledReport_name' => $data['filedcategory'][$reporttype - 1]['FiledReport_name'],
					'FiledReports_tablename' => $data['filedcategory'][$reporttype - 1]['FiledReports_tablename'],
					'data_new' => $data[$r]
				);
				array_push($rsdata, $ds);
			}
		}
		$result_new = array();
		$result_new_1 = array();
		foreach ($data['state_new'] as $itm) {
			foreach ($data['filedcategory'] as $k => $catr) {
				if ($this->is_in_array($rsdata, trim('FiledReports_tablename'), trim($catr['FiledReports_tablename'])) === 'yes') {
					foreach ($rsdata as $rs) {
						$i = 0;
						if ($rs['FiledReports_tablename'] == $catr['FiledReports_tablename']) {
							foreach ($rs['data_new'] as $rsdata_new) {
								if (strripos(' ' . $rsdata_new['GeoLocationnew'], $itm['LGA'])) {
									$i++;
								}
							}
						}
						$result_new['report_category_name'] = $rs['FiledReport_name'];
						$result_new['STATE'] = $itm['LGA'];
						$result_new['Frequency'] = $i;
						$result_new['Duration'] = $_POST['startdate'] . ' to ' . $_POST['enddate'];
						if ($i != 0) {
							array_push($result_new_1, $result_new);
						}
					}
				}
			}
		}

		$data['result_new'] = $result_new_1;

		$this->load->view('Admin/FiledReportsLocation', $data);
	}
	//print_r(is_in_array($test, 'name', 'Smith'));
	public function is_in_array($array, $key, $key_value)
	{
		$within_array = 'no';
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				$within_array = $this->is_in_array($v, $key, $key_value);
				if ($within_array == 'yes') {
					break;
				}
			} else {
				if ($v == $key_value && $k == $key) {
					$within_array = 'yes';
					break;
				}
			}
		}
		return $within_array;
	}


	public function SoSReportsPopularity()
	{
		// $date_s = "date(SOSManagement.created_at) >= date('".$_POST['startdate']."') AND date(SOSManagement.created_at) <= date('".$_POST['enddate']."')";
		$date_s = "date(SOSManagement.created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";

		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $date_s, '', array('SOS_id', 'DESC'), '', $dt);
		// print_r($data['resultsos']);
		// echo $this->db->last_query();
		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['soscategory'] =  $this->beats_model->select_data('*', 'sos_category');
		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');

		$data['startdate'] = $_POST['startdate'];
		$data['enddate'] = $_POST['enddate'];


		$result_new = array();
		$result_new_1 = array();
		foreach ($data['state_new'] as $itm) {
			foreach ($data['soscategory'] as $k => $catr) {
				$i = 0;
				if ($this->is_in_array($data['resultsos'], 'sos_category_name', $catr['sos_category_name']) == 'yes') {
					foreach ($data['resultsos'] as $k => $rssos) {
						if ($rssos['sos_category_name'] == $catr['sos_category_name']) {
							if (strripos(' ' . $rssos['current_location'], $itm['LGA'])) {
								$i++;
							}
						}
					}
					$result_new['sos_category_name'] = $catr['sos_category_name'];
					$result_new['STATE'] = $itm['LGA'];
					$result_new['Frequency'] = $i;
					$result_new['Duration'] = $_POST['startdate'] . ' to ' . $_POST['enddate'];
					if ($i != 0) {
						array_push($result_new_1, $result_new);
					}
				}
			}
		}

		$data['result_new'] = $result_new_1;
		$data['result_new_1'] = $this->sosfilers();

		$this->load->view('Admin/SoSReportsPopularity', $data);
	}

	public function SOSReportsLocation()
	{

		$reporttype = $_POST['reporttype'];


		if ($reporttype == "Select Type") {
			$date_s = "date(SOSManagement.created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		} else {
			$date_s = "SOSManagement.SOS_category = '" . $reporttype . "' AND date(SOSManagement.created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		}


		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $date_s, '', array('SOS_id', 'DESC'), '', $dt);

		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['soscategory'] =  $this->beats_model->select_data('*', 'sos_category');
		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');

		$data['startdate'] = $_POST['startdate'];
		$data['enddate'] = $_POST['enddate'];


		$result_new = array();
		$result_new_1 = array();
		foreach ($data['state_new'] as $itm) {
			foreach ($data['soscategory'] as $k => $catr) {
				$i = 0;
				if ($this->is_in_array($data['resultsos'], 'sos_category_name', $catr['sos_category_name']) == 'yes') {
					foreach ($data['resultsos'] as $k => $rssos) {
						if ($rssos['sos_category_name'] == $catr['sos_category_name']) {
							if (strripos(' ' . $rssos['current_location'], $itm['LGA'])) {
								$i++;
							}
						}
					}
					$result_new['sos_category_name'] = $catr['sos_category_name'];
					$result_new['STATE'] = $itm['LGA'];
					$result_new['Frequency'] = $i;
					$result_new['Duration'] = $_POST['startdate'] . ' to ' . $_POST['enddate'];
					if ($i != 0) {
						array_push($result_new_1, $result_new);
					}
				}
			}
		}

		$data['result_new'] = $result_new_1;
		$data['result_new_1'] = $this->sosfilers();

		$this->load->view('Admin/SOSReportsLocation', $data);
	}

	public function SOSReportsState()
	{

		$reporttype = $_POST['reporttype'];
		$State = $_POST['State'];

		if ($reporttype == "Select Type") {
			$date_s = "SOSManagement.current_location Like" . "'%" . $State . '%' . "' AND date(SOSManagement.created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		} else {
			$date_s = "SOSManagement.current_location Like" . "'%" . $State . '%' . "' AND SOSManagement.SOS_category = '" . $reporttype . "' AND date(SOSManagement.created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		}


		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $date_s, '', array('SOS_id', 'DESC'), '', $dt);

		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['soscategory'] =  $this->beats_model->select_data('*', 'sos_category');
		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');

		$data['startdate'] = $_POST['startdate'];
		$data['enddate'] = $_POST['enddate'];

		$result_new = array();
		$result_new_1 = array();
		foreach ($data['state_new'] as $itm) {
			foreach ($data['soscategory'] as $k => $catr) {
				$i = 0;
				if ($this->is_in_array($data['resultsos'], 'sos_category_name', $catr['sos_category_name']) == 'yes') {
					foreach ($data['resultsos'] as $k => $rssos) {
						if ($rssos['sos_category_name'] == $catr['sos_category_name']) {
							if (strripos(' ' . $rssos['current_location'], $itm['LGA'])) {
								$i++;
							}
						}
					}
					$result_new['sos_category_name'] = $catr['sos_category_name'];
					$result_new['STATE'] = $itm['LGA'];
					$result_new['Frequency'] = $i;
					$result_new['Duration'] = $_POST['startdate'] . ' to ' . $_POST['enddate'];
					if ($i != 0) {
						array_push($result_new_1, $result_new);
					}
				}
			}
		}

		$data['result_new'] = $result_new_1;
		$data['result_new_1'] = $this->sosfilers();


		$this->load->view('Admin/SOSReportsState', $data);
	}
	public function SOSReportsResponsetime()
	{

		$reporttype = $_POST['reporttype'];
		$State = $_POST['State'];

		if ($reporttype == "Select Type") {
			$date_s = "SOSManagement.current_location Like" . "'%" . $State . '%' . "' AND date(SOSManagement.created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		} else {
			$date_s = "SOSManagement.current_location Like" . "'%" . $State . '%' . "' AND SOSManagement.SOS_category = '" . $reporttype . "' AND date(SOSManagement.created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";
		}
		// $date_s = "SOSManagement.current_location Like" . "'%" . $State . '%' . "' AND SOSManagement.SOS_category = '" . $reporttype . "' AND date(SOSManagement.created_at) BETWEEN date('" . $_POST['startdate'] . "') AND date('" . $_POST['enddate'] . "')";

		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $date_s, '', array('SOS_id', 'DESC'), '', $dt);

		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['soscategory'] =  $this->beats_model->select_data('*', 'sos_category');
		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');

		$data['startdate'] = $_POST['startdate'];
		$data['enddate'] = $_POST['enddate'];
		$data['reporttype'] = $_POST['reporttype'];
		$data['State'] = $_POST['State'];


		$result_new = array();
		$result_new_1 = array();
		foreach ($data['state_new'] as $itm) {
			foreach ($data['soscategory'] as $k => $catr) {
				$i = 0;
				if ($this->is_in_array($data['resultsos'], 'sos_category_name', $catr['sos_category_name']) == 'yes') {

					foreach ($data['resultsos'] as $k => $rssos) {
						if ($rssos['sos_category_name'] == $catr['sos_category_name']) {
							if (strripos(' ' . $rssos['current_location'], $itm['LGA'])) {
								$i++;
							}
						}
					}
					$result_new['sos_category_name'] = $catr['sos_category_name'];
					$result_new['STATE'] = $itm['LGA'];
					$result_new['Frequency'] = $i;
					$result_new['Duration'] = $_POST['startdate'] . ' to ' . $_POST['enddate'];
					if ($i != 0) {
						array_push($result_new_1, $result_new);
					}
				}
			}
		}

		$data['result_new'] = $result_new_1;
		$data['result_new_1'] = $this->sosfilers();

		$this->load->view('Admin/SOSReportsResponsetime', $data);
	}

	public function FiledReport()
	{

		$data['result'] = $this->beats_model->select_data('*', 'iWitness', '', '', array('iWitness_id', 'DESC'));
		$data['result1'] = $this->beats_model->select_data('*', 'Officer_Abuse', '', '', array('OfficerAbuse_id', 'DESC'));
		$data['result2'] = $this->beats_model->select_data('*', 'Commend_Officer', '', '', array('CommendOffice_id', 'DESC'));
		$data['result3'] = $this->beats_model->select_data('*', 'StolenVehicle_report', '', '', array('StolenVehicle_report_id', 'DESC'));
		$data['result4'] = $this->beats_model->select_data('*', 'Missing_Persons_report', '', '', array('Missing_Persons_report_id', 'DESC'));
		$data['result5'] = $this->beats_model->select_data('*', 'Lodgecomplaint_report', '', '', array('Lodgecomplaint_report_id', 'DESC'));
		$data['result6'] = $this->beats_model->select_data('*', 'Gun_Violence_report', '', '', array('GunViolence_id', 'DESC'));
		$data['result7'] = $this->beats_model->select_data('*', 'Drug_Abuse_report', '', '', array('DrugAbuse_report_id', 'DESC'));
		$data['result8'] = $this->beats_model->select_data('*', 'Domestic_Violence_report', '', '', array('DomesticViolence_report_id', 'DESC'));
		$data['result9'] = $this->beats_model->select_data('*', 'Terrorist_Attack_report', '', '', array('TerroristAttack_report_id', 'DESC'));
		$data['result10'] = $this->beats_model->select_data('*', 'Rape_report', '', '', array('Rape_report_id', 'DESC'));
		$data['result11'] = $this->beats_model->select_data('*', 'Kidnap_report', '', '', array('Kidnap_report_id', 'DESC'));
		$data['result12'] = $this->beats_model->select_data('*', 'Robbery_report', '', '', array('Robbery_report_id', 'DESC'));
		$data['result13'] = $this->beats_model->select_data('*', 'Burglary_report', '', '', array('Burglary_report_id', 'DESC'));
		$data['result14'] = $this->beats_model->select_data('*', 'CybercrimeFraud_report', '', '', array('CybercrimeFraud_report_id', 'DESC'));
		$data['result15'] = $this->beats_model->select_data('*', 'Submit_Tip_report', '', '', array('Submit_Tip_id', 'DESC'));
		$data['result16'] = $this->beats_model->select_data('*', 'Others_report', '', '', array('Others_report_id', 'DESC'));

		$data['result17'] = $this->beats_model->select_data('*', 'Vandalism_report', '', '', array('Vandalism_report_id', 'DESC'));
		$data['result18'] = $this->beats_model->select_data('*', 'Fire_report', '', '', array('Fire_report_id', 'DESC'));
		$data['result19'] = $this->beats_model->select_data('*', 'Accident_report', '', '', array('Accident_report_id', 'DESC'));
		$data['result20'] = $this->beats_model->select_data('*', 'Medical_report', '', '', array('Medical_report_id', 'DESC'));
		$data['result21'] = $this->beats_model->select_data('*', 'Riot_report', '', '', array('Riot_report_id', 'DESC'));
		$data['result22'] = $this->beats_model->select_data('*', 'Environmental_Hazard_report', '', '', array('Environmental_Hazard_report_id', 'DESC'));
		$data['result23'] = $this->beats_model->select_data('*', 'Child_Abuse_report', '', '', array('Child_Abuse_report_id', 'DESC'));
		$data['result24'] = $this->beats_model->select_data('*', 'Human_Trafficking_report', '', '', array('Human_Trafficking_report_id', 'DESC'));
		$data['result25'] = $this->beats_model->select_data('*', 'Blow_Whistle_report', '', '', array('Blow_Whistle_report_id', 'DESC'));

		$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');




		$data['nsresult0'] = $this->beats_model->select_data('count(*) as total', 'iWitness', 'is_read = 1', '', array('iWitness_id', 'DESC'));
		$data['nsresult1'] = $this->beats_model->select_data('count(*) as total', 'Officer_Abuse', 'is_read = 1', '', array('OfficerAbuse_id', 'DESC'));
		$data['nsresult2'] = $this->beats_model->select_data('count(*) as total', 'Commend_Officer', 'is_read = 1', '', array('CommendOffice_id', 'DESC'));
		$data['nsresult3'] = $this->beats_model->select_data('count(*) as total', 'StolenVehicle_report', 'is_read = 1', '', array('StolenVehicle_report_id', 'DESC'));
		$data['nsresult4'] = $this->beats_model->select_data('count(*) as total', 'Missing_Persons_report', 'is_read = 1', '', array('Missing_Persons_report_id', 'DESC'));
		$data['nsresult5'] = $this->beats_model->select_data('count(*) as total', 'Lodgecomplaint_report', 'is_read = 1', '', array('Lodgecomplaint_report_id', 'DESC'));
		$data['nsresult6'] = $this->beats_model->select_data('count(*) as total', 'Gun_Violence_report', 'is_read = 1', '', array('GunViolence_id', 'DESC'));
		$data['nsresult7'] = $this->beats_model->select_data('count(*) as total', 'Drug_Abuse_report', 'is_read = 1', '', array('DrugAbuse_report_id', 'DESC'));
		$data['nsresult8'] = $this->beats_model->select_data('count(*) as total', 'Domestic_Violence_report', 'is_read = 1', '', array('DomesticViolence_report_id', 'DESC'));
		$data['nsresult9'] = $this->beats_model->select_data('count(*) as total', 'Terrorist_Attack_report', 'is_read = 1', '', array('TerroristAttack_report_id', 'DESC'));
		$data['nsresult10'] = $this->beats_model->select_data('count(*) as total', 'Rape_report', 'is_read = 1', '', array('Rape_report_id', 'DESC'));
		$data['nsresult11'] = $this->beats_model->select_data('count(*) as total', 'Kidnap_report', 'is_read = 1', '', array('Kidnap_report_id', 'DESC'));
		$data['nsresult12'] = $this->beats_model->select_data('count(*) as total', 'Robbery_report', 'is_read = 1', '', array('Robbery_report_id', 'DESC'));
		$data['nsresult13'] = $this->beats_model->select_data('count(*) as total', 'Burglary_report', 'is_read = 1', '', array('Burglary_report_id', 'DESC'));
		$data['nsresult14'] = $this->beats_model->select_data('count(*) as total', 'CybercrimeFraud_report', 'is_read = 1', '', array('CybercrimeFraud_report_id', 'DESC'));
		$data['nsresult15'] = $this->beats_model->select_data('count(*) as total', 'Submit_Tip_report', 'is_read = 1', '', array('Submit_Tip_id', 'DESC'));
		$data['nsresult16'] = $this->beats_model->select_data('count(*) as total', 'Others_report', 'is_read = 1', '', array('Others_report_id', 'DESC'));

		$data['nsresult17'] = $this->beats_model->select_data('count(*) as total', 'Vandalism_report', 'is_read = 1', '', array('Vandalism_report_id', 'DESC'));
		$data['nsresult18'] = $this->beats_model->select_data('count(*) as total', 'Fire_report', 'is_read = 1', '', array('Fire_report_id', 'DESC'));
		$data['nsresult19'] = $this->beats_model->select_data('count(*) as total', 'Accident_report', 'is_read = 1', '', array('Accident_report_id', 'DESC'));
		$data['nsresult20'] = $this->beats_model->select_data('count(*) as total', 'Medical_report', 'is_read = 1', '', array('Medical_report_id', 'DESC'));
		$data['nsresult21'] = $this->beats_model->select_data('count(*) as total', 'Riot_report', 'is_read = 1', '', array('Riot_report_id', 'DESC'));
		$data['nsresult22'] = $this->beats_model->select_data('count(*) as total', 'Environmental_Hazard_report', 'is_read = 1', '', array('Environmental_Hazard_report_id', 'DESC'));
		$data['nsresult23'] = $this->beats_model->select_data('count(*) as total', 'Child_Abuse_report', 'is_read = 1', '', array('Child_Abuse_report_id', 'DESC'));
		$data['nsresult24'] = $this->beats_model->select_data('count(*) as total', 'Human_Trafficking_report', 'is_read = 1', '', array('Human_Trafficking_report_id', 'DESC'));
		$data['nsresult25'] = $this->beats_model->select_data('count(*) as total', 'Blow_Whistle_report', 'is_read = 1', '', array('Blow_Whistle_report_id', 'DESC'));


		$rsdata = array();
		$total = 0;
		$i = 0;
		foreach ($data['filedcategory'] as $catr) {
			$r = 'nsresult' . $i;
			$ds = array(
				'FiledReport_name' => $catr['FiledReport_name'],
				'FiledReports_tablename' => $catr['FiledReports_tablename'],
				'total' => $data[$r][0]['total']
			);
			array_push($rsdata, $ds);
			$total = $total + $data[$r][0]['total'];

			$i++;
		}
		// print_r($rsdata);
		$data['total'] = $total;



		$this->load->view('Admin/FiledReport', $data);
	}


	public function sosfilers()
	{
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');
		$date_s = "date(created_at) = date('" . date('Y-m-d') . "') ";
		$data['result0'] = $this->beats_model->select_data('*,(Location) as GeoLocationnew', 'iWitness', $date_s, '', array('iWitness_id', 'DESC'));
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
		// echo $this->db->last_query();
		$rsdata = array();
		$i = 0;
		foreach ($data['filedcategory'] as $catr) {
			$r = 'result' . $i;
			if (!empty($data[$r])) {
				$ds = array(
					'FiledReport_name' => $catr['FiledReport_name'],
					'FiledReports_tablename' => $catr['FiledReports_tablename'],
					'data_new' => $data[$r]
				);
				array_push($rsdata, $ds);
			}
			$i++;
		}
		$result_new = array();
		$result_new_1 = array();
		foreach ($data['state_new'] as $itm) {
			foreach ($data['filedcategory'] as $k => $catr) {
				if ($this->is_in_array($rsdata, trim('FiledReports_tablename'), trim($catr['FiledReports_tablename'])) === 'yes') {
					foreach ($rsdata as $rs) {
						$i = 0;
						if ($rs['FiledReports_tablename'] == $catr['FiledReports_tablename']) {
							foreach ($rs['data_new'] as $rsdata_new) {
								if (strripos(' ' . $rsdata_new['GeoLocationnew'], $itm['LGA'])) {
									$i++;
								}
							}
						}
						$result_new['report_category_name'] = $rs['FiledReport_name'];
						$result_new['STATE'] = $itm['LGA'];
						$result_new['Frequency'] = $i;
						$result_new['Duration'] = '';
						if ($i != 0) {
							array_push($result_new_1, $result_new);
						}
					}
				}
			}
		}

		return $result_new_1;
	}

	public function Report()
	{

		$date_s = "date(SOSManagement.created_dateat) = date('" . date('Y-m-d') . "') ";
		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$data['resultsos'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', $date_s, '', array('SOS_id', 'DESC'), '', $dt);
		$date_s = "date(created_at) = date('" . date('Y-m-d') . "') ";

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
		$data['state_new'] =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));

		$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');



		$data['state'] =  $this->beats_model->select_data('DISTINCT(STATE) as STATE', 'state_zone', '', '', array('STATE', 'ASC'));
		$data['soscategory'] =  $this->beats_model->select_data('*', 'sos_category');
		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');

		$data['result_new'] = $this->sosfilers();


		$this->load->view('Admin/Report_new', $data);
	}
	public function SOSStatus()
	{


		$data = array('SOS_staus' => $_POST['status'], 'update_at' => date("Y-m-d H:i:s"));
		$res = $this->beats_model->update_data('SOSManagement', $data, array('SOS_id' => trim($_POST['SOSid'])));
		// 	echo $this->db->last_query();

		echo $_POST['status'];
	}

	public function iWitnessStatus()
	{

		switch (trim($_POST['cat_id'])) {
			case "1":
				$lang = "iWitness";
				$id = "iWitness_id";
				$status = "iWitness_status";
				break;
			case "2":
				$lang = "Officer_Abuse";
				$id = "OfficerAbuse_id";
				$status = "OfficerAbuse_status";
				break;
			case "3":
				$lang = "Commend_Officer";
				$id = "CommendOffice_id";
				$status = "CommendOffice_status";
				break;
			case "4":
				$lang = "StolenVehicle_report";
				$id = "StolenVehicle_report_id";
				$status = "StolenVehicle_report_status";
				break;
			case "5":
				$lang = "Missing_Persons_report";
				$id = "Missing_Persons_report_id";
				$status = "Missing_Persons_report_status";
				break;
			case "6":
				$lang = "Lodgecomplaint_report";
				$id = "Lodgecomplaint_report_id";
				$status = "Lodgecomplaint_report_status";
				break;
			case "7":
				$lang = "Gun_Violence_report";
				$id = "GunViolence_id";
				$status = "GunViolence_status";
				break;
			case "8":
				$lang = "Drug_Abuse_report";
				$id = "DrugAbuse_report_id";
				$status = "DrugAbuse_report_status";
				break;
			case "9":
				$lang = "Domestic_Violence_report";
				$id = "DomesticViolence_report_id";
				$status = "DomesticViolence_report_status";
				break;
			case "10":
				$lang = "Terrorist_Attack_report";
				$id = "TerroristAttack_report_id";
				$status = "TerroristAttack_report_status";
				break;
			case "11":
				$lang = "Rape_report";
				$id = "Rape_report_id";
				$status = "Rape_report_status";
				break;
			case "12":
				$lang = "Kidnap_report";
				$id = "Kidnap_report_id";
				$status = "Kidnap_report_status";
				break;
			case "13":
				$lang = "Robbery_report";
				$id = "Robbery_report_id";
				$status = "Robbery_report_status";
				break;
			case "14":
				$lang = "Burglary_report";
				$id = "Burglary_report_id";
				$status = "Burglary_report_status";
				break;
			case "15":
				$lang = "CybercrimeFraud_report";
				$id = "CybercrimeFraud_report_id";
				$status = "CybercrimeFraud_report_status";
				break;
			case "16":
				$lang = "Submit_Tip_report";
				$id = "Submit_Tip_id";
				$status = "Submit_Tip_status";
				break;
			case "17":
				$lang = "Others_report";
				$id = "Others_report_id";
				$status = "Others_report_status";
				break;
			case "18":
				$lang = "Vandalism_report";
				$id = "Vandalism_report_id";
				$status = "Vandalism_report_status";
				break;
			case "19":
				$lang = "Fire_report";
				$id = "Fire_report_id";
				$status = "Fire_report_status";
				break;
			case "20":
				$lang = "Accident_report";
				$id = "Accident_report_id";
				$status = "Accident_report_status";
				break;
			case "21":
				$lang = "Medical_report";
				$id = "Medical_report_id";
				$status = "Medical_report_status";
				break;
			case "22":
				$lang = "Riot_report";
				$id = "Riot_report_id";
				$status = "Riot_report_status";
				break;
			case "23":
				$lang = "Environmental_Hazard_report";
				$id = "Environmental_Hazard_report_id";
				$status = "Environmental_Hazard_report_status";
				break;
			case "24":
				$lang = "Child_Abuse_report";
				$id = "Child_Abuse_report_id";
				$status = "Child_Abuse_report_status";
				break;
			case "25":
				$lang = "Human_Trafficking_report";
				$id = "Human_Trafficking_report_id";
				$status = "Human_Trafficking_report_status";
				break;
			case "26":
				$lang = "Blow_Whistle_report";
				$id = "Blow_Whistle_report_id";
				$status = "Blow_Whistle_report_status";
				break;
			default:
				$lang = "iWitness";
				$id = "iWitness_id";
				$status = "iWitness_status";
		}

		$res = $this->beats_model->update_data($lang, array($status => $_POST['status'], 'update_at' => date('Y-m-d H:i:s')), array($id => trim($_POST['SOSid'])));
		// 	$data=array('iWitness_status'=>$_POST['status']);
		// 	$res=$this->beats_model->update_data('iWitness',$data,array('iWitness_id'=>trim($_POST['SOSid'])));
		// 	echo $this->db->last_query();

		echo $_POST['status'];
	}

	public function OfficerStatus()
	{

		$res = $this->beats_model->update_data('Officer', array('Officer_status' => $_POST['status']), array('Officer_id' => trim($_POST['Officer_id'])));

		echo $_POST['status'];
	}

	public function SOSManagement()
	{
		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));


		$data['newsos'] = $this->beats_model->select_data('count(*) as newsos', 'SOSManagement', 'is_read = 1', '', array('SOS_id', 'DESC'), '', '');
		$data['result'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', '', '', array('SOS_id', 'DESC'), '', $dt);

		$this->load->view('Admin/SOSManagement', $data);
	}
	public function SOSreaded()
	{
		// $data = array('is_read' => $_POST['isread'], 'update_at' => date("Y-m-d H:i:s"));
		$data = array('is_read' => '0', 'update_at' => date("Y-m-d H:i:s"));
		$res = $this->beats_model->update_data('SOSManagement', $data, array('SOS_id' => trim($_POST['sos_id'])));
		$res_new = $this->beats_model->select_data('count(*) as newsos', 'SOSManagement', 'is_read = 1', '', array('SOS_id', 'DESC'), '', '');
		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Read SOS ID Number '.$_POST['sos_id'],
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		print_r($res_new[0]['newsos']);
		die();
	}

	public function Filereaded()
	{

		// $data = array('is_read' => $_POST['isread'], 'update_at' => date("Y-m-d H:i:s"));
		switch (trim($_POST['report_id'])) {
			case "1":
				$lang = "iWitness";
				$id = "iWitness_id";
				$status = "is_read";
				break;
			case "2":
				$lang = "Officer_Abuse";
				$id = "OfficerAbuse_id";
				$status = "is_read";
				break;
			case "3":
				$lang = "Commend_Officer";
				$id = "CommendOffice_id";
				$status = "is_read";
				break;
			case "4":
				$lang = "StolenVehicle_report";
				$id = "StolenVehicle_report_id";
				$status = "is_read";
				break;
			case "5":
				$lang = "Missing_Persons_report";
				$id = "Missing_Persons_report_id";
				$status = "is_read";
				break;
			case "6":
				$lang = "Lodgecomplaint_report";
				$id = "Lodgecomplaint_report_id";
				$status = "is_read";
				break;
			case "7":
				$lang = "Gun_Violence_report";
				$id = "GunViolence_id";
				$status = "is_read";
				break;
			case "8":
				$lang = "Drug_Abuse_report";
				$id = "DrugAbuse_report_id";
				$status = "is_read";
				break;
			case "9":
				$lang = "Domestic_Violence_report";
				$id = "DomesticViolence_report_id";
				$status = "is_read";
				break;
			case "10":
				$lang = "Terrorist_Attack_report";
				$id = "TerroristAttack_report_id";
				$status = "is_read";
				break;
			case "11":
				$lang = "Rape_report";
				$id = "Rape_report_id";
				$status = "is_read";
				break;
			case "12":
				$lang = "Kidnap_report";
				$id = "Kidnap_report_id";
				$status = "is_read";
				break;
			case "13":
				$lang = "Robbery_report";
				$id = "Robbery_report_id";
				$status = "is_read";
				break;
			case "14":
				$lang = "Burglary_report";
				$id = "Burglary_report_id";
				$status = "is_read";
				break;
			case "15":
				$lang = "CybercrimeFraud_report";
				$id = "CybercrimeFraud_report_id";
				$status = "is_read";
				break;
			case "16":
				$lang = "Submit_Tip_report";
				$id = "Submit_Tip_id";
				$status = "is_read";
				break;
			case "17":
				$lang = "Others_report";
				$id = "Others_report_id";
				$status = "is_read";
				break;
			case "18":
				$lang = "Vandalism_report";
				$id = "Vandalism_report_id";
				$status = "is_read";
				break;
			case "19":
				$lang = "Fire_report";
				$id = "Fire_report_id";
				$status = "is_read";
				break;
			case "20":
				$lang = "Accident_report";
				$id = "Accident_report_id";
				$status = "is_read";
				break;
			case "21":
				$lang = "Medical_report";
				$id = "Medical_report_id";
				$status = "is_read";
				break;
			case "22":
				$lang = "Riot_report";
				$id = "Riot_report_id";
				$status = "is_read";
				break;
			case "23":
				$lang = "Environmental_Hazard_report";
				$id = "Environmental_Hazard_report_id";
				$status = "is_read";
				break;
			case "24":
				$lang = "Child_Abuse_report";
				$id = "Child_Abuse_report_id";
				$status = "is_read";
				break;
			case "25":
				$lang = "Human_Trafficking_report";
				$id = "Human_Trafficking_report_id";
				$status = "is_read";
				break;
			case "26":
				$lang = "Blow_Whistle_report";
				$id = "Blow_Whistle_report_id";
				$status = "is_read";
				break;
			default:
				$lang = "iWitness";
				$id = "iWitness_id";
				$status = "is_read";
		}

		$res = $this->beats_model->update_data($lang, array($status => 0), array($id => trim($_POST['record_id'])));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Read '. $lang .' report number '.$_POST['record_id'],
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		$data['filedcategory'] =  $this->beats_model->select_data('*', 'FiledReports_category');
		$data['result0'] = $this->beats_model->select_data('count(*) as total', 'iWitness', 'is_read = 1', '', array('iWitness_id', 'DESC'));
		$data['result1'] = $this->beats_model->select_data('count(*) as total', 'Officer_Abuse', 'is_read = 1', '', array('OfficerAbuse_id', 'DESC'));
		$data['result2'] = $this->beats_model->select_data('count(*) as total', 'Commend_Officer', 'is_read = 1', '', array('CommendOffice_id', 'DESC'));
		$data['result3'] = $this->beats_model->select_data('count(*) as total', 'StolenVehicle_report', 'is_read = 1', '', array('StolenVehicle_report_id', 'DESC'));
		$data['result4'] = $this->beats_model->select_data('count(*) as total', 'Missing_Persons_report', 'is_read = 1', '', array('Missing_Persons_report_id', 'DESC'));
		$data['result5'] = $this->beats_model->select_data('count(*) as total', 'Lodgecomplaint_report', 'is_read = 1', '', array('Lodgecomplaint_report_id', 'DESC'));
		$data['result6'] = $this->beats_model->select_data('count(*) as total', 'Gun_Violence_report', 'is_read = 1', '', array('GunViolence_id', 'DESC'));
		$data['result7'] = $this->beats_model->select_data('count(*) as total', 'Drug_Abuse_report', 'is_read = 1', '', array('DrugAbuse_report_id', 'DESC'));
		$data['result8'] = $this->beats_model->select_data('count(*) as total', 'Domestic_Violence_report', 'is_read = 1', '', array('DomesticViolence_report_id', 'DESC'));
		$data['result9'] = $this->beats_model->select_data('count(*) as total', 'Terrorist_Attack_report', 'is_read = 1', '', array('TerroristAttack_report_id', 'DESC'));
		$data['result10'] = $this->beats_model->select_data('count(*) as total', 'Rape_report', 'is_read = 1', '', array('Rape_report_id', 'DESC'));
		$data['result11'] = $this->beats_model->select_data('count(*) as total', 'Kidnap_report', 'is_read = 1', '', array('Kidnap_report_id', 'DESC'));
		$data['result12'] = $this->beats_model->select_data('count(*) as total', 'Robbery_report', 'is_read = 1', '', array('Robbery_report_id', 'DESC'));
		$data['result13'] = $this->beats_model->select_data('count(*) as total', 'Burglary_report', 'is_read = 1', '', array('Burglary_report_id', 'DESC'));
		$data['result14'] = $this->beats_model->select_data('count(*) as total', 'CybercrimeFraud_report', 'is_read = 1', '', array('CybercrimeFraud_report_id', 'DESC'));
		$data['result15'] = $this->beats_model->select_data('count(*) as total', 'Submit_Tip_report', 'is_read = 1', '', array('Submit_Tip_id', 'DESC'));
		$data['result16'] = $this->beats_model->select_data('count(*) as total', 'Others_report', 'is_read = 1', '', array('Others_report_id', 'DESC'));

		$data['result17'] = $this->beats_model->select_data('count(*) as total', 'Vandalism_report', 'is_read = 1', '', array('Vandalism_report_id', 'DESC'));
		$data['result18'] = $this->beats_model->select_data('count(*) as total', 'Fire_report', 'is_read = 1', '', array('Fire_report_id', 'DESC'));
		$data['result19'] = $this->beats_model->select_data('count(*) as total', 'Accident_report', 'is_read = 1', '', array('Accident_report_id', 'DESC'));
		$data['result20'] = $this->beats_model->select_data('count(*) as total', 'Medical_report', 'is_read = 1', '', array('Medical_report_id', 'DESC'));
		$data['result21'] = $this->beats_model->select_data('count(*) as total', 'Riot_report', 'is_read = 1', '', array('Riot_report_id', 'DESC'));
		$data['result22'] = $this->beats_model->select_data('count(*) as total', 'Environmental_Hazard_report', 'is_read = 1', '', array('Environmental_Hazard_report_id', 'DESC'));
		$data['result23'] = $this->beats_model->select_data('count(*) as total', 'Child_Abuse_report', 'is_read = 1', '', array('Child_Abuse_report_id', 'DESC'));
		$data['result24'] = $this->beats_model->select_data('count(*) as total', 'Human_Trafficking_report', 'is_read = 1', '', array('Human_Trafficking_report_id', 'DESC'));
		$data['result25'] = $this->beats_model->select_data('count(*) as total', 'Blow_Whistle_report', 'is_read = 1', '', array('Blow_Whistle_report_id', 'DESC'));


		$rsdata = array();
		$total = 0;
		$i = 0;
		foreach ($data['filedcategory'] as $catr) {
			$r = 'result' . $i;
			$ds = array(
				'FiledReport_name' => $catr['FiledReport_name'],
				'FiledReports_tablename' => $catr['FiledReports_tablename'],
				'total' => $data[$r][0]['total']
			);
			array_push($rsdata, $ds);
			$total = $total + $data[$r][0]['total'];

			$i++;
		}

		// json_encode(array('alltotal' => $total, 'rptotal' => $rsdata));
		print_r(json_encode(array('alltotal' => $total, 'rptotal' => $rsdata)));
		die();
	}

	public function ViewSOS($id)
	{
		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));


		$data['newsos'] = $this->beats_model->select_data('count(*) as newsos', 'SOSManagement', 'is_read = 1', '', array('SOS_id', 'DESC'), '', '');

		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$data['result'] = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', array('SOSManagement.user_id' => $id, 'SOSManagement.usertype' => '0'), '', array('SOSManagement.SOS_id', 'DESC'), '', $dt);

		$this->load->view('Admin/SOSManagement', $data);
	}



	public function ViewFieldReport($id)
	{

		$data['result'] = $this->beats_model->select_data('*', 'iWitness', '', '', array('iWitness_id', 'DESC'));
		$data['result1'] = $this->beats_model->select_data('*', 'Officer_Abuse', '', '', array('OfficerAbuse_id', 'DESC'));
		$data['result2'] = $this->beats_model->select_data('*', 'Commend_Officer', '', '', array('CommendOffice_id', 'DESC'));
		$data['result3'] = $this->beats_model->select_data('*', 'StolenVehicle_report', '', '', array('StolenVehicle_report_id', 'DESC'));
		$data['result4'] = $this->beats_model->select_data('*', 'Missing_Persons_report', '', '', array('Missing_Persons_report_id', 'DESC'));
		$data['result5'] = $this->beats_model->select_data('*', 'Lodgecomplaint_report', '', '', array('Lodgecomplaint_report_id', 'DESC'));
		$data['result6'] = $this->beats_model->select_data('*', 'Gun_Violence_report', '', '', array('GunViolence_id', 'DESC'));
		$data['result7'] = $this->beats_model->select_data('*', 'Drug_Abuse_report', '', '', array('DrugAbuse_report_id', 'DESC'));
		$data['result8'] = $this->beats_model->select_data('*', 'Domestic_Violence_report', '', '', array('DomesticViolence_report_id', 'DESC'));
		$data['result9'] = $this->beats_model->select_data('*', 'Terrorist_Attack_report', '', '', array('TerroristAttack_report_id', 'DESC'));
		$data['result10'] = $this->beats_model->select_data('*', 'Rape_report', '', '', array('Rape_report_id', 'DESC'));
		$data['result11'] = $this->beats_model->select_data('*', 'Kidnap_report', '', '', array('Kidnap_report_id', 'DESC'));
		$data['result12'] = $this->beats_model->select_data('*', 'Robbery_report', '', '', array('Robbery_report_id', 'DESC'));
		$data['result13'] = $this->beats_model->select_data('*', 'Burglary_report', '', '', array('Burglary_report_id', 'DESC'));
		$data['result14'] = $this->beats_model->select_data('*', 'CybercrimeFraud_report', '', '', array('CybercrimeFraud_report_id', 'DESC'));
		$data['result15'] = $this->beats_model->select_data('*', 'Submit_Tip_report', '', '', array('Submit_Tip_id', 'DESC'));
		$data['result16'] = $this->beats_model->select_data('*', 'Others_report', '', '', array('Others_report_id', 'DESC'));

		$data['result17'] = $this->beats_model->select_data('*', 'Vandalism_report', '', '', array('Vandalism_report_id', 'DESC'));
		$data['result18'] = $this->beats_model->select_data('*', 'Fire_report', '', '', array('Fire_report_id', 'DESC'));
		$data['result19'] = $this->beats_model->select_data('*', 'Accident_report', '', '', array('Accident_report_id', 'DESC'));
		$data['result20'] = $this->beats_model->select_data('*', 'Medical_report', '', '', array('Medical_report_id', 'DESC'));
		$data['result21'] = $this->beats_model->select_data('*', 'Riot_report', '', '', array('Riot_report_id', 'DESC'));
		$data['result22'] = $this->beats_model->select_data('*', 'Environmental_Hazard_report', '', '', array('Environmental_Hazard_report_id', 'DESC'));
		$data['result23'] = $this->beats_model->select_data('*', 'Child_Abuse_report', '', '', array('Child_Abuse_report_id', 'DESC'));
		$data['result24'] = $this->beats_model->select_data('*', 'Human_Trafficking_report', '', '', array('Human_Trafficking_report_id', 'DESC'));
		$data['result25'] = $this->beats_model->select_data('*', 'Blow_Whistle_report', '', '', array('Blow_Whistle_report_id', 'DESC'));

		// $data['nsresult0'] = $this->beats_model->select_data('*', 'iWitness', array('user_id' => $id), '', array('iWitness_id', 'DESC'));
		$data['filedcategory'] = $this->beats_model->select_data('*', 'FiledReports_category');
		$data['nsresult0'] = $this->beats_model->select_data('count(*) as total', 'iWitness', array('user_id' => $id), '', array('iWitness_id', 'DESC'));
		$data['nsresult1'] = $this->beats_model->select_data('count(*) as total', 'Officer_Abuse', array('user_id' => $id), '', array('OfficerAbuse_id', 'DESC'));
		$data['nsresult2'] = $this->beats_model->select_data('count(*) as total', 'Commend_Officer', array('user_id' => $id), '', array('CommendOffice_id', 'DESC'));
		$data['nsresult3'] = $this->beats_model->select_data('count(*) as total', 'StolenVehicle_report', array('user_id' => $id), '', array('StolenVehicle_report_id', 'DESC'));
		$data['nsresult4'] = $this->beats_model->select_data('count(*) as total', 'Missing_Persons_report', array('user_id' => $id), '', array('Missing_Persons_report_id', 'DESC'));
		$data['nsresult5'] = $this->beats_model->select_data('count(*) as total', 'Lodgecomplaint_report', array('user_id' => $id), '', array('Lodgecomplaint_report_id', 'DESC'));
		$data['nsresult6'] = $this->beats_model->select_data('count(*) as total', 'Gun_Violence_report', array('user_id' => $id), '', array('GunViolence_id', 'DESC'));
		$data['nsresult7'] = $this->beats_model->select_data('count(*) as total', 'Drug_Abuse_report', array('user_id' => $id), '', array('DrugAbuse_report_id', 'DESC'));
		$data['nsresult8'] = $this->beats_model->select_data('count(*) as total', 'Domestic_Violence_report', array('user_id' => $id), '', array('DomesticViolence_report_id', 'DESC'));
		$data['nsresult9'] = $this->beats_model->select_data('count(*) as total', 'Terrorist_Attack_report', array('user_id' => $id), '', array('TerroristAttack_report_id', 'DESC'));
		$data['nsresult10'] = $this->beats_model->select_data('count(*) as total', 'Rape_report', array('user_id' => $id), '', array('Rape_report_id', 'DESC'));
		$data['nsresult11'] = $this->beats_model->select_data('count(*) as total', 'Kidnap_report', array('user_id' => $id), '', array('Kidnap_report_id', 'DESC'));
		$data['nsresult12'] = $this->beats_model->select_data('count(*) as total', 'Robbery_report', array('user_id' => $id), '', array('Robbery_report_id', 'DESC'));
		$data['nsresult13'] = $this->beats_model->select_data('count(*) as total', 'Burglary_report', array('user_id' => $id), '', array('Burglary_report_id', 'DESC'));
		$data['nsresult14'] = $this->beats_model->select_data('count(*) as total', 'CybercrimeFraud_report', array('user_id' => $id), '', array('CybercrimeFraud_report_id', 'DESC'));
		$data['nsresult15'] = $this->beats_model->select_data('count(*) as total', 'Submit_Tip_report', array('user_id' => $id), '', array('Submit_Tip_id', 'DESC'));
		$data['nsresult16'] = $this->beats_model->select_data('count(*) as total', 'Others_report', array('user_id' => $id), '', array('Others_report_id', 'DESC'));

		$data['nsresult17'] = $this->beats_model->select_data('count(*) as total', 'Vandalism_report', array('user_id' => $id), '', array('Vandalism_report_id', 'DESC'));
		$data['nsresult18'] = $this->beats_model->select_data('count(*) as total', 'Fire_report', array('user_id' => $id), '', array('Fire_report_id', 'DESC'));
		$data['nsresult19'] = $this->beats_model->select_data('count(*) as total', 'Accident_report', array('user_id' => $id), '', array('Accident_report_id', 'DESC'));
		$data['nsresult20'] = $this->beats_model->select_data('count(*) as total', 'Medical_report', array('user_id' => $id), '', array('Medical_report_id', 'DESC'));
		$data['nsresult21'] = $this->beats_model->select_data('count(*) as total', 'Riot_report', array('user_id' => $id), '', array('Riot_report_id', 'DESC'));
		$data['nsresult22'] = $this->beats_model->select_data('count(*) as total', 'Environmental_Hazard_report', array('user_id' => $id), '', array('Environmental_Hazard_report_id', 'DESC'));
		$data['nsresult23'] = $this->beats_model->select_data('count(*) as total', 'Child_Abuse_report', array('user_id' => $id), '', array('Child_Abuse_report_id', 'DESC'));
		$data['nsresult24'] = $this->beats_model->select_data('count(*) as total', 'Human_Trafficking_report', array('user_id' => $id), '', array('Human_Trafficking_report_id', 'DESC'));
		$data['nsresult25'] = $this->beats_model->select_data('count(*) as total', 'Blow_Whistle_report', array('user_id' => $id), '', array('Blow_Whistle_report_id', 'DESC'));


		$rsdata = array();
		$total = 0;
		$i = 0;
		foreach ($data['filedcategory'] as $catr) {
			$r = 'nsresult' . $i;
			$ds = array(
				'FiledReport_name' => $catr['FiledReport_name'],
				'FiledReports_tablename' => $catr['FiledReports_tablename'],
				'total' => $data[$r][0]['total']
			);
			array_push($rsdata, $ds);
			$total = $total + $data[$r][0]['total'];

			$i++;
		}
		// print_r($rsdata);
		$data['total'] = $total;

		$this->load->view('Admin/FiledReport', $data);
	}

	public function ReportCategory()
	{
		// echo 1;
		// die;
		$tablefield = $this->beats_model->select_data('*', 'FiledReports_category', array('FiledReports_id' => $_POST['id']));
		$result = $this->beats_model->select_data('*', $tablefield['0']['FiledReports_tablename']);
		// $check_language1 = $check_language[0]['language_id'];
		// switch ($check_language1) {
		// 	case "1":
		// 		$lang = "HINDI";
		// 		break;
		// 	case "2":
		// 		$lang = "ENGLISH";
		// 		break;
		// 	case "3":
		// 		$lang = "TELUGU";
		// 		break;
		// 	case "4":
		// 		$lang = "TAMIL";
		// 		break;
		// 	case "5":
		// 		$lang = "KANNADA";
		// 		break;
		// 	case "6":
		// 		$lang = "MALAYALAM";
		// 		break;
		// 	case "7":
		// 		$lang = "MARATHI";
		// 		break;
		// 	case "8":
		// 		$lang = "PUNJABI";
		// 		break;
		// 	case "9":
		// 		$lang = "BENGALI";
		// 		break;
		// 	case "10":
		// 		$lang = "GUJRATI";
		// 		break;

		// 	default:
		// 		$lang = "HINDI";
		// }

		$count = 1;
		echo '<table id="customers2" class="table datatable"><thead>
                                            <tr>
                                                <th>SrNo.</th>
                                                <th>OfficerAbuse_id</th>
                                                <th>Description</th>
                                                  <th>Officer_name</th>
                                                 <th>Location</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>';

		foreach ($result as $itm) {
			if ($itm['OfficerAbuse_status'] == 1) {
				$staus = '<a href="javascript:void(0);" onclick="changeBannerStatus(0,' . $itm['OfficerAbuse_id'] . ');"><img src="' . base_url() . 'images/bullet_green.png" width="32" height="32" title="click to Change Status." /></a>';
			} else {
				$staus = '<a href="javascript:void(0);" onclick="changeBannerStatus(1,' . $itm['OfficerAbuse_id'] . ');"><img src="' . base_url() . 'images/bullet_red.png" width="32" height="32" title="click to Change Status." /> </a>';
			}

			echo '<tbody><tr class="">
           <td>' . $count . '</td>
           <td>' . $itm['OfficerAbuse_id'] . '</td>
           <td>' . $itm['Description'] . '</td>
           <td>' . $itm['Officer_name'] . '</td>
           <td>' . $itm['Location'] . '</td>
          <td id="status_' . $itm['OfficerAbuse_id'] . '">' . $staus . '</td>
                                                
           <td>
           <a title="Give Feedback" href="#" data-toggle="modal" data-target="#exampleModal1"  onclick="return SOSFeedback(' . $itm['OfficerAbuse_id'] . ')"><span class="fa fa-pencil-square-o "></span></a>
                                      
                                       
                                       <a title="View Details" href="#" data-toggle="modal" data-target="#exampleModal"  onclick="return FiledReportview(' . $itm['OfficerAbuse_id'] . ')"><span class="fa fa-eye "></span></a>
                                                                                            
           
           
           </td>
           </tr></tbody>';
			$count++;
		}
		echo '</table>';
	}

	public function ViewUserLog()
	{
		$log_id = $_POST['log_id'];
		$user_type = $_POST['user_type'];
		if ($user_type == 1) {



			$data_e = $this->db->select(
				'us.*, 
				um.log_id, 
				um.user_type, 
				um.device_type, 
				um.is_login, 
				um.imei, 
				um.device_version, 
				um.device_manufacturer, 
				um.device_uuid, 
				um.device_platform, 
				um.device_modelNo, 
				um.device_token, 
				um.created_at as login_time, 
				um.updated_at as logout_time,
				um.expires_at'
			)->from('user_auth_logs as um')
				->where('um.log_id =', $log_id)
				->join('user_signup as us', 'us.user_id = um.user_id')
				->order_by('um.log_id', "desc")
				->get();
		} else {
			$data_e = $this->db->select(
				'us.*, 
						um.log_id, 
						um.user_type, 
						um.device_type, 
						um.is_login, 
						um.imei, 
						um.device_version, 
						um.device_manufacturer, 
						um.device_uuid, 
						um.device_platform, 
						um.device_modelNo, 
						um.device_token, 
						um.created_at as login_time, 
						um.updated_at as logout_time,
						um.expires_at'
			)->from('user_auth_logs as um')
				->where('um.log_id =', $log_id)
				->join('Officer as us', 'us.Officer_id = um.user_id')
				->order_by('um.log_id', "desc")
				->get();
		}

		$res = $data_e->result();
		foreach ($res as $re) {

			echo '<div class="col-12 col-md-12">
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
								' . ($user_type == 1 ? "User" : "Officer") . ' Name:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . ($user_type == 1 ? $re->user_name : $re->Full_Name) . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
								User Phone:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . ($user_type == 1 ? $re->user_phone : $re->phone) . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							Device Rype:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . ($re->device_type == 1 ? "Android" : "IOS") . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							IMEI:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . $re->imei . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							Device Version:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . $re->device_version . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							Device Manufacturer:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . $re->device_manufacturer . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							Device UUID:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . $re->device_uuid . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							Device Platform:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . $re->device_platform . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							Device ModelNo:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . $re->device_modelNo . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							Device Token:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;word-wrap: break-word;">
								<span>' . $re->device_token . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							Login Time:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . $re->login_time . '</span>
							</div>
						</div>
						<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
							<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">
							Logout Time:
							</div>
							<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
								<span style="float:left;">' . $re->logout_time . '</span>
							</div>
						</div>
				</div>';
		}
	}
	public function userlogdel()
	{

		$log_id = $_POST['log_id'];
		$user_type = $_POST['user_type'];
		$res = $this->beats_model->delete_data('user_auth_logs', array('log_id' => $log_id));
	}


	public function Userlog()
	{
		$data_e = $this->db->select(
			'us.*, 
		um.log_id, 
		um.user_type, 
		um.device_type, 
		um.is_login, 
		um.imei, 
		um.device_version, 
		um.device_manufacturer, 
		um.device_uuid, 
		um.device_platform, 
		um.device_modelNo, 
		um.device_token, 
		um.created_at as login_time, 
		um.updated_at as logout_time,
		um.expires_at'
		)
			->from('user_signup as us')
			->join('user_auth_logs as um', 'us.user_id = um.user_id and um.user_type = 1')
			->order_by('um.log_id', "desc")
			->get();
		$data['result_new'] = $data_e->result();
		// print_r('test');
		// echo "<pre>";
		// print_r($data['result_new']);
		// echo "</pre>";
		$this->load->view('Admin/Userlog', $data);
	}

	public function Officerlog()
	{
		$data_e = $this->db->select(
			'us.*, 
		um.log_id, 
		um.user_type, 
		um.device_type, 
		um.is_login, 
		um.imei, 
		um.device_version, 
		um.device_manufacturer, 
		um.device_uuid, 
		um.device_platform, 
		um.device_modelNo, 
		um.device_token, 
		um.created_at as login_time, 
		um.updated_at as logout_time,
		um.expires_at'
		)
			->from('Officer as us')
			->join('user_auth_logs as um', 'us.Officer_id = um.user_id and um.user_type = 2')
			->order_by('um.log_id', "desc")
			->get();
		$data['result_new'] = $data_e->result();

		$this->load->view('Admin/Officerlog', $data);
	}

	public function Registeredusers()
	{

		$data_e = $this->db->select('us.*, um.meta_id, um.user_type, um.lga_state, um.lga_state, um.blood_group, um.geno_type, um.allergies')
			->from('user_signup as us')
			->where('us.user_status', 0)
			->join('user_officer_meta as um', 'us.user_id = um.user_id and um.user_type = 1', 'LEFT')
			->get();
		$data['result_new'] = $data_e->result();
		$data['result'] = $this->beats_model->select_data('*', 'user_signup', array('user_status' => 0));
		$this->load->view('Admin/Registeredusers', $data);
	}
	public function Updateuser()
	{
		$data = array(
			'user_name' => $_POST['user_name'],
			'user_phone' => $_POST['user_phone'],
			'password' => $_POST['password'],
			'user_kinPhone' => $_POST['user_kinPhone'],

		);
		$res = $this->beats_model->update_data('user_signup', $data, array('user_id' => trim($_POST['user_id'])));
		$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => trim($_POST['user_id']), 'user_type' => 1));


		$meta_detail = array(
			'user_type' => '1',
			'user_id' => trim($_POST['user_id']),
			'lga_state' => $_POST['lga_state'],
			'blood_group' => (isset($_POST['blood_group']) && !empty($_POST['blood_group']) ? $_POST['blood_group'] : ''),
			'geno_type' => (isset($_POST['geno_type']) && !empty($_POST['geno_type']) ? $_POST['geno_type'] : ''),
			'agency' => '',
			'allergies' => $_POST['allergies'],
			'update_date' => date("Y-m-d H:i:s")
		);

		if (!empty($check_meta_user)) {
			$updt_meta_id = $this->beats_model->update_data('user_officer_meta', $meta_detail, array('meta_id' => $check_meta_user[0]['meta_id']));
		} else {
			$meta_id = $this->beats_model->insert_data('user_officer_meta', $meta_detail);
		}

		redirect(base_url('Registeredusers'));
	}
	public function userdel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('user_signup', array('user_id' => $id));

		$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => trim($_POST['id']), 'user_type' => 1));
		if (!empty($check_meta_user)) {
			$res = $this->beats_model->delete_data('user_officer_meta', array('meta_id' => $check_meta_user[0]['meta_id']));
		}

		//echo base_url('ManageDeal');
	}
	public function UserEdit()
	{
		$id = $_POST['match_id'];
		$res = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $id));

		$res_new = $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $id, 'user_type' => 1));

		$user_meta = array(
			'user_type' => '1',
			'lga_state' => (!empty($res_new) ? $res_new[0]['lga_state'] : ''),
			'blood_group' => (!empty($res_new) ? $res_new[0]['blood_group'] : ''),
			'geno_type' => (!empty($res_new) ? $res_new[0]['geno_type'] : ''),
			'agency' => '',
			'allergies' => (!empty($res_new) ? $res_new[0]['allergies'] : '')
		);
		$LGA_ST = unserialize(LGA_ST);
		$BLOOD_GP = unserialize(BLOOD_GP);
		$GENO_TY = unserialize(GENO_TY);

		$res[0] = array_merge($res[0], $user_meta);
		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">User Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="user_name" id="user_name" value="' . $res['0']['user_name'] . '"  required/>
                                                         <input type="hidden" class="form-control" name="user_id" id="user_id" value="' . $res['0']['user_id'] . '"  required/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Unique Code</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="tel" class="form-control" name="unique_code" id="unique_code" value="' . $res['0']['unique_code'] . '"/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">User Phone</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="tel" class="form-control" name="user_phone" id="user_phone" value="' . $res['0']['user_phone'] . '"  required/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Password</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="password" class="form-control" name="password" id="password-field" value="' . $res['0']['password'] . '"  required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <i id="pass-status" class="fa fa-eye" aria-hidden="true" onClick="viewPassword()"></i>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">kinPhone</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="tel" class="form-control" name="user_kinPhone" id="user_kinPhone"  value="' . $res['0']['user_kinPhone'] . '" required/>
                                                    </div>                                            
                                                 
                                                </div>
											</div>
											<div class="form-group">
                                                <label class="col-md-3 control-label">LGA State</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        												
														<select class="form-control" name="lga_state" id="lga_state" required>
														<option value=""> Select LGA State</option>';
		foreach ($LGA_ST as $lga) {
			$sl = $lga == $res['0']['lga_state'] ? 'Selected' : '';
			echo '<option value="' . $lga . '" ' . $sl . '>' . $lga . '</option>';
		}
		echo '</select>

														</div>
                                                </div>
											</div>

										<div class="form-group">
                                                <label class="col-md-3 control-label">Blood Group</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														
														
														<select class="form-control" name="blood_group" id="blood_group" required>
														<option value=""> Select Blood Group</option>';
		foreach ($BLOOD_GP as $bgp) {
			$sl = $bgp == $res['0']['blood_group'] ? 'Selected' : '';
			echo '<option value="' . $bgp . '" ' . $sl . '>' . $bgp . '</option>';
		}
		echo '</select></div>                                            
                                                 
                                                </div>
											</div>
											<div class="form-group">
                                                <label class="col-md-3 control-label">Geno Type</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        
														<select class="form-control" name="geno_type" id="geno_type" required>
														<option value=""> Select Geno Type</option>';
		foreach ($GENO_TY as $gty) {
			$sl = $gty == $res['0']['geno_type'] ? 'Selected' : '';
			echo '<option value="' . $gty . '" ' . $sl . '>' . $gty . '</option>';
		}
		echo '</select></div>                                            
                                                 
                                                </div>
											</div>
											<div class="form-group">
                                                <label class="col-md-3 control-label">Allergies</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<textarea  name="allergies" id="allergies"rows="2" cols="40" required>' . $res['0']['allergies'] . '</textarea>														
                                                    </div>
                                                </div>
                                            </div>
											';
	}
	public function Verifiedusers()
	{
		$data_e = $this->db->select('us.*, um.meta_id, um.user_type, um.lga_state, um.lga_state, um.blood_group, um.geno_type, um.allergies')
			->from('user_signup as us')
			->where('us.user_status', 1)
			->join('user_officer_meta as um', 'us.user_id = um.user_id and um.user_type = 1', 'LEFT')
			->get();
		$data['result_new'] = $data_e->result();
		$data['result'] = $this->beats_model->select_data('*', 'user_signup', array('user_status' => 1));
		$this->load->view('Admin/Verifiedusers', $data);
	}

	public function Anonymoususers()
	{
		$a = "AnonymousID != ' ' ";
		$data['result'] = $this->beats_model->select_data('*', 'user_signup', $a);

		//  echo $this->db->last_query();
		//  die;
		$this->load->view('Admin/Anonymoususer', $data);
	}




	public function RegisteredOfficer()
	{
		$data_e = $this->db->select('os.*, um.meta_id, um.user_type, um.lga_state, um.lga_state, um.blood_group, um.geno_type, um.allergies')
			->from('Officer as os')
			->where('os.Officer_status', 0)
			->order_by("os.Officer_id", "DESC")
			->join('user_officer_meta as um', 'os.Officer_id = um.user_id and um.user_type = 2', 'LEFT')
			->get();
		$data['result_new'] = $data_e->result();

		$data['result'] = $this->beats_model->select_data('*', 'Officer', array('Officer_status' => 0), '', array('Officer_id', 'DESC'));
		$this->load->view('Admin/RegisteredOfficer', $data);
	}
	public function VerifiedOfficer()
	{
		$data_e = $this->db->select('os.*, um.meta_id, um.user_type, um.lga_state, um.lga_state, um.blood_group, um.geno_type, um.allergies')
			->from('Officer as os')
			->where('os.Officer_status', 1)
			->order_by("os.Officer_id", "DESC")
			->join('user_officer_meta as um', 'os.Officer_id = um.user_id and um.user_type = 2', 'LEFT')
			->get();
		$data['result_new'] = $data_e->result();

		$data['result'] = $this->beats_model->select_data('*', 'Officer', array('Officer_status' => 1), '', array('Officer_id', 'DESC'));
		$this->load->view('Admin/VerifiedOfficer', $data);
	}
	public function Officerdel()
	{
		$res = $this->beats_model->delete_data('Officer', array('Officer_id' => $_POST['id']));
		$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => trim($_POST['id']), 'user_type' => 2));
		if (!empty($check_meta_user)) {
			$res = $this->beats_model->delete_data('user_officer_meta', array('meta_id' => $check_meta_user[0]['meta_id']));
		}
	}
	public function UpdateOfficer()
	{

		if (!empty($_FILES['profilepic']['name'])) {
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
			} else {
				$picture = '';
			}
			$compeurl = base_url() . 'uploads/' . $picture;
			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'phone' => $_POST['phone'],
				'Rank' => $_POST['Rank'],
				'Designation' => $_POST['Designation'],
				// 'State_Deployment' => $_POST['State_Deployment'],
				'Place_Assignment' => $_POST['Place_Assignment'],
				'Police_service_Number' => $_POST['Police_service_Number'],
				'Residential_Address' => $_POST['Residential_Address'],
				'Kin_Phone' => $_POST['Kin_Phone'],
				'Password' => $_POST['Password'],
				'profilepic' => $compeurl,
				'officer_category' => $_POST['officer_category'],


			);
		} else {
			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'phone' => $_POST['phone'],
				'Rank' => $_POST['Rank'],
				'Designation' => $_POST['Designation'],
				// 'State_Deployment' => $_POST['State_Deployment'],
				'Place_Assignment' => $_POST['Place_Assignment'],
				'Police_service_Number' => $_POST['Police_service_Number'],
				'Residential_Address' => $_POST['Residential_Address'],
				'Kin_Phone' => $_POST['Kin_Phone'],
				'Password' => $_POST['Password'],
				'officer_category' => $_POST['officer_category'],



			);
		}
		$res = $this->beats_model->update_data('Officer', $user_detail, array('Officer_id' => trim($_POST['Officer_id'])));

		$check_meta_user =  $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => trim($_POST['Officer_id']), 'user_type' => 2));

		$meta_detail = array(
			'user_type' => '2',
			'user_id' => trim($_POST['Officer_id']),
			'lga_state' => $_POST['lga_state'],
			'blood_group' => (isset($_POST['blood_group']) && !empty($_POST['blood_group']) ? $_POST['blood_group'] : ''),
			'geno_type' => (isset($_POST['geno_type']) && !empty($_POST['geno_type']) ? $_POST['geno_type'] : ''),
			'agency' => (isset($_POST['agency']) && !empty($_POST['agency']) ? $_POST['agency'] : ''),
			'allergies' => $_POST['allergies'],
			'update_date' => date("Y-m-d H:i:s")
		);

		if (!empty($check_meta_user)) {
			$updt_meta_id = $this->beats_model->update_data('user_officer_meta', $meta_detail, array('meta_id' => $check_meta_user[0]['meta_id']));
		} else {
			$meta_id = $this->beats_model->insert_data('user_officer_meta', $meta_detail);
		}

		redirect(base_url('RegisteredOfficer'));
	}
	public function EditOfficer()
	{

		$res = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $_POST['Officer_id']));
		$check_user =  $this->beats_model->select_data('Designation_id,Designation_name', 'OfficerDesignation', '', '', array('Designation_name', 'ASC'));
		$check_user1 =  $this->beats_model->select_data('DISTINCT(STATE) as STATE, ', 'state_zone', '', '', array('STATE', 'ASC'));
		$check_user2 =  $this->beats_model->select_data('*', 'Rank', '', '', array('Rank_name', 'ASC'));
		$check_user3 =  $this->beats_model->select_data('PlaceAssignment_id,PlaceAssignment_name', 'PlaceAssignment', '', '', array('PlaceAssignment_name', 'ASC'));


		$res_new = $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $_POST['Officer_id'], 'user_type' => 2));

		$user_meta = array(
			'user_type' => '2',
			'lga_state' => (!empty($res_new) ? $res_new[0]['lga_state'] : ''),
			'blood_group' => (!empty($res_new) ? $res_new[0]['blood_group'] : ''),
			'geno_type' => (!empty($res_new) ? $res_new[0]['geno_type'] : ''),
			'agency' => (!empty($res_new) ? $res_new[0]['agency'] : ''),
			'allergies' => (!empty($res_new) ? $res_new[0]['allergies'] : '')
		);
		$LGA_ST = unserialize(LGA_ST);
		$BLOOD_GP = unserialize(BLOOD_GP);
		$GENO_TY = unserialize(GENO_TY);
		$AGENCY = unserialize(AGENCY);

		$res[0] = array_merge($res[0], $user_meta);


		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Full_Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Full_Name" id="Full_Name"  value="' . $res['0']['Full_Name'] . '"/>
                                                        <input type="hidden" class="form-control" name="Officer_id" id="Officer_id"  value="' . $res['0']['Officer_id'] . '"/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">phone</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="phone" id="phone"  value="' . $res['0']['phone'] . '"/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Rank</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Rank" id="Rank"  value="' . $res['0']['Rank'] . '"/>
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Designation</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Designation" id="Designation"  value="' . $res['0']['Designation'] . '"/>
                                                 </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Place_Assignment</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Place_Assignment" id="Place_Assignment"  value="' . $res['0']['Place_Assignment'] . '"/>
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Service_Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Police_service_Number" id="Police_service_Number"  value="' . $res['0']['Police_service_Number'] . '"/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Residential_Address</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Residential_Address" id="Residential_Address"  value="' . $res['0']['Residential_Address'] . '"/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Kin_Phone</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Kin_Phone" id="Kin_Phone"  value="' . $res['0']['Kin_Phone'] . '"/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Password</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="password" class="form-control" name="Password" id="password-field"  value="' . $res['0']['Password'] . '"/>
                                                    </div>                                            
                                                </div>
                                                <div class="col-md-1">
                                                    <i id="pass-status" class="fa fa-eye" aria-hidden="true" onClick="viewPassword()"></i>
                                                </div>
											</div>';
		//    echo  '<div class="form-group">
		//         <label class="col-md-3 control-label">profilepic</label>
		//         <div class="col-md-9">                                            
		//             <div class="input-group">

		//                 <img src="' . $res['0']['profilepic'] . '" class="form-control" style="height:100px"  />
		//             </div>                                            

		//         </div>
		// 	</div>';
		echo  '<div class="form-group">
                                                <label class="col-md-3 control-label">profilepic</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                       
													<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
													<img src="' . $res['0']['profilepic'] . '" style="float:left;height: 100px;">
																								
												</div>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>';
		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Change profilepic</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="file" class="form-control" name="profilepic" id="profilepic" />
                                                    </div>
                                                </div>
											</div>';
		echo '<div class="form-group">
											<label class="col-md-3 control-label">Category</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
																									
													<select class="form-control" name="officer_category" id="officer_category" required>
													<option value="0" ' . ($res['0']['officer_category'] == 0 ? "Selected" : "") . '>LGA</option>
													<option value="1" ' . ($res['0']['officer_category'] == 1 ? "Selected" : "") . '>State</option>
		</select>

													</div>
											</div>
										</div>';
		echo '<div class="form-group">
											<label class="col-md-3 control-label">LGA State</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
																									
													<select class="form-control" name="lga_state" id="lga_state" required>
													<option value=""> Select LGA State</option>';
		foreach ($LGA_ST as $lga) {
			$sl = $lga == $res['0']['lga_state'] ? 'Selected' : '';
			echo '<option value="' . $lga . '" ' . $sl . '>' . $lga . '</option>';
		}
		echo '</select>

													</div>
											</div>
										</div>';
		echo '
										<div class="form-group">
                                                <label class="col-md-3 control-label">Blood Group</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														
														
														<select class="form-control" name="blood_group" id="blood_group" required>
														<option value=""> Select Blood Group</option>';
		foreach ($BLOOD_GP as $bgp) {
			$sl = $bgp == $res['0']['blood_group'] ? 'Selected' : '';
			echo '<option value="' . $bgp . '" ' . $sl . '>' . $bgp . '</option>';
		}
		echo '</select></div>                                            
                                                 
                                                </div>
											</div>
											<div class="form-group">
											<label class="col-md-3 control-label">Geno Type</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													
													<select class="form-control" name="geno_type" id="geno_type" required>
													<option value=""> Select Geno Type</option>';
		foreach ($GENO_TY as $gty) {
			$sl = $gty == $res['0']['geno_type'] ? 'Selected' : '';
			echo '<option value="' . $gty . '" ' . $sl . '>' . $gty . '</option>';
		}
		echo '</select></div>                                            
											 
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Agency</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													
													<select class="form-control" name="agency" id="agency" required>
													<option value=""> Select Agency</option>';
		foreach ($AGENCY as $ag) {
			$sl = $ag == $res['0']['agency'] ? 'Selected' : '';
			echo '<option value="' . $ag . '" ' . $sl . '>' . $ag . '</option>';
		}
		echo '</select></div>                                            
											 
											</div>
										</div>
										<div class="form-group">
										<label class="col-md-3 control-label">Allergies</label>
										<div class="col-md-9">                                            
											<div class="input-group">
												<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
												<textarea  name="allergies" id="allergies"rows="2" cols="50" required>' . $res['0']['allergies'] . '</textarea>														
											</div>
										</div>
									</div>';
	}
	public function FeedbackSOS()
	{

		$sos_id = $_POST['SOS_id'];
		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));
		$sosReport = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', array('SOS_id' => trim($_POST['SOS_id'])), '', array('SOS_id', 'DESC'), '', $dt);
		// $sosReport = $this->beats_model->select_data('SOSManagement.*', 'SOSManagement', array('SOS_id' => trim($_POST['SOS_id'])), '', '', '');
		//    echo $sosReport[0]['feedback'];die;
		$feedback = $_POST['feedback'] . '  ' . $sosReport[0]['feedback'];
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
				'SOS_id' => $_POST['SOS_id'],
				'feedback_date' => date('Y-m-d H:i:s'),



			);
		} else {
			$user_detail = array(
				'feedback' => $_POST['feedback'],
				'SOS_id' => $_POST['SOS_id'],
				'feedback_date' => date('Y-m-d H:i:s'),
			);
		}

		$reg_id = $this->beats_model->insert_data('SOSFeedback', $user_detail);

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Feedback Given on SOS ID Number '.$sos_id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);



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

		// $nsdata = array("sos_id" => $_POST['SOS_id'], "sos_category" => $sosReport[0]['sos_category_name'], "sos_category_id" => $ctid);

		if ($sosReport['0']['usertype'] == 1) {
			$nsdata = array("sos_id" => $_POST['SOS_id'], "sos_category" => $sosReport[0]['sos_category_name'], "sos_category_id" => $ctid, 'userType' => 'officer');
		} else {
			$nsdata = array("sos_id" => $_POST['SOS_id'], "sos_category" => $sosReport[0]['sos_category_name'], "sos_category_id" => $ctid, 'userType' => 'citizen');
		}

		$this->sendPushNotiSOS("SOS Feedback", "Feedback for sos", $registration_id, $sosReport['0']['user_id'], "4", $nsdata);

		// echo $this->db->last_query();
		//  die;
		redirect(base_url('SOSManagement'));
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
		// 	print_r($error_msg);
		// }
		// print_r($result);
		curl_close($ch);
		// die;
	}


	public function FeedbackFiledReport()
	{

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
		//    echo $sosReport[0]['feedback'];die;
		$feedback = $_POST['feedback'] . '  ' . $sosReport[0]['feedback'];
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
				'feedback_date' => date('Y-m-d H:i:s'),
			);
		} else {
			$user_detail = array(
				'feedback' => $_POST['feedback'],
				"$id" => $_POST['report_id'],
				'feedback_date' => date('Y-m-d H:i:s'),
			);
		}


		//$res=$this->beats_model->update_data($lang.'Feedback',$user_detail));
		$reg_id = $this->beats_model->insert_data($lang . 'Feedback', $user_detail);
		//  echo $this->db->last_query();
		// die;

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Feedback given on '. $lang .' report number '.$_POST['report_id'],
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

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
		redirect(base_url('FiledReport'));
	}

	public function sendPushNotiFiled($title, $message, $registration_id, $userid, $data, $type)
	{

		$user_detail = array(
			'titile' => $title,
			'message' => $message,
			'user_id' => $userid,
			'notificationdate' => date("Y-m-d H:i:s")
		);
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
		$user_detail1 = array(
			'titile' => $title,
			'message' => $message,
			'user_id' => 0,
			'notificationdate' => date("Y-m-d H:i:s")
		);
		$reg_id = $this->beats_model->insert_data('UserNotification_all', $user_detail);
		$reg_id = $this->beats_model->insert_data('OfficerNotification_all', $user_detail1);

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
		curl_close($ch);

		// print_r($result);
		// die;

	}
	public function iWitness()
	{
		$id = $_POST['iWitness_id'];

		//$res = $this->beats_model->select_data('sos_category.*,SOSManagement.*' , 'SOSManagement',array('SOSManagement.SOS_id' => $id),'','','',$dt);	

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=iWitness.user_id')));

		$res = $this->beats_model->select_data('*', 'iWitness', array('iWitness.iWitness_id' => $id));

		// 		echo $this->db->last_query();
		// 		die;
		foreach ($res as $re) {

			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			//  echo $this->db->last_query();
			//  die;
			$checkfeed = $this->beats_model->select_data('*', 'iWitnessFeedback', array('iWitness_id' => $re['iWitness_id']));
			$as1 = $re['iWitness_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['iWitness_date'];
			$as5 = $re['iWitness_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['Media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];
			//$as11=$re['SOS_staus'];
			//$as12=$re['created_at'];


			//  $newarimg=json_decode($re['Deal_imgVideo']);

			//$as7=$newarimg['1'];





			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">iWitness_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">iWitness_date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">iWitness_tym:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport1()
	{
		$id = $_POST['id'];

		//$res = $this->beats_model->select_data('sos_category.*,SOSManagement.*' , 'SOSManagement',array('SOSManagement.SOS_id' => $id),'','','',$dt);	

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Officer_Abuse.user_id')));

		$res = $this->beats_model->select_data('*', 'Officer_Abuse', array('Officer_Abuse.OfficerAbuse_id' => $id));

		// 		echo $this->db->last_query();
		// 		die;
		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Officer_AbuseFeedback', array('OfficerAbuse_id' => $re['OfficerAbuse_id']));
			$as1 = $re['OfficerAbuse_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['OfficerAbuse_date'];
			$as5 = $re['OfficerAbuse_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['Media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['Officer_name'];
			//$as11=$re['SOS_staus'];
			//$as12=$re['created_at'];


			//  $newarimg=json_decode($re['Deal_imgVideo']);

			//$as7=$newarimg['1'];
			$as13 = $re['GeoLocation'];





			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">OfficerAbuse_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Officer_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport2()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Commend_Officer.user_id')));

		$res = $this->beats_model->select_data('*', 'Commend_Officer', array('Commend_Officer.CommendOffice_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Commend_OfficerFeedback', array('CommendOffice_id' => $re['CommendOffice_id']));

			$as1 = $re['CommendOffice_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['CommendOffice_date'];
			$as5 = $re['CommendOffice_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['Media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['Officer_name'];
			$as13 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Officer_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			foreach ($as9 as $itm) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}
	public function viewreport3()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=StolenVehicle_report.user_id')));

		$res = $this->beats_model->select_data('*', 'StolenVehicle_report', array('StolenVehicle_report.StolenVehicle_report_id' => $id));

		foreach ($res as $re) {

			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}
			$checkfeed = $this->beats_model->select_data('*', 'StolenVehicle_reportFeedback', array('StolenVehicle_report_id' => $re['StolenVehicle_report_id']));

			$as1 = $re['StolenVehicle_report_id'];
			$as2 = $re['Vehicle_make'];
			$as3 = $re['Vehicle_model'];
			$as4 = $re['Vehicle_lastlocation'];
			$as5 = $re['Plate_Number'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['Engine_Number'];
			$as13 = $re['Vehicle_Color'];
			$as14 = $re['StolenVehicle_report_date'];
			$as15 = $re['StolenVehicle_report_tym'];
			$as16 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_make:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_model:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_lastlocation:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Plate_Number:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Engine_Number:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_Color:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as14 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as15 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as16 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			foreach ($as9 as $itm) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}
	public function viewreport4()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Missing_Persons_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Missing_Persons_report', array('Missing_Persons_report.Missing_Persons_report_id' => $id));

		foreach ($res as $re) {


			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}
			$checkfeed = $this->beats_model->select_data('*', 'Missing_Persons_reportFeedback', array('Missing_Persons_report_id' => $re['Missing_Persons_report_id']));

			$as1 = $re['Missing_Persons_report_id'];
			$as2 = $re['Full_Name'];
			$as3 = $re['Age'];
			$as4 = $re['Sex'];
			$as5 = $re['Description'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['Spoken_Language'];
			$as13 = $re['Last_Seen_Location'];
			$as14 = $re['Missing_Persons_report_Date'];
			$as15 = $re['Missing_Persons_report_tym'];
			$as16 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Full_Name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Age:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Sex:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Spoken_Language:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Last_Seen_Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as14 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as15 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as16 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			foreach ($as9 as $itm) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}
	public function viewreport5()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Lodgecomplaint_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Lodgecomplaint_report', array('Lodgecomplaint_report.Lodgecomplaint_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Lodgecomplaint_reportFeedback', array('Lodgecomplaint_report_id' => $re['Lodgecomplaint_report_id']));

			$as1 = $re['Lodgecomplaint_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Lodgecomplaint_report_Date'];
			$as5 = $re['Lodgecomplaint_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];
			$as13 = $re['Location'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Complaint:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport6()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Gun_Violence_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Gun_Violence_report', array('Gun_Violence_report.GunViolence_id' => $id));

		foreach ($res as $re) {

			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Gun_Violence_reportFeedback', array('GunViolence_id' => $re['GunViolence_id']));

			$as1 = $re['GunViolence_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['GunViolence_Date'];
			$as5 = $re['GunViolence_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];

			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}
	public function viewreport7()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Drug_Abuse_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Drug_Abuse_report', array('Drug_Abuse_report.DrugAbuse_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Drug_Abuse_reportFeedback', array('DrugAbuse_report_id' => $re['DrugAbuse_report_id']));

			$as1 = $re['DrugAbuse_report_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['Date'];
			$as5 = $re['tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport8()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Domestic_Violence_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Domestic_Violence_report', array('Domestic_Violence_report.DomesticViolence_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Domestic_Violence_reportFeedback', array('DomesticViolence_report_id' => $re['DomesticViolence_report_id']));

			$as1 = $re['DomesticViolence_report_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['Date'];
			$as5 = $re['tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport9()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Terrorist_Attack_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Terrorist_Attack_report', array('Terrorist_Attack_report.TerroristAttack_report_id' => $id));

		foreach ($res as $re) {

			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}
			$checkfeed = $this->beats_model->select_data('*', 'Terrorist_Attack_reportFeedback', array('TerroristAttack_report_id' => $re['TerroristAttack_report_id']));

			$as1 = $re['TerroristAttack_report_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['Date'];
			$as5 = $re['tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport10()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Rape_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Rape_report', array('Rape_report.Rape_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Rape_reportFeedback', array('Rape_report_id' => $re['Rape_report_id']));

			$as1 = $re['Rape_report_id'];
			$as2 = $re['Victim_Name'];
			$as3 = $re['Age'];
			$as4 = $re['Sex'];
			$as5 = $re['Description'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			//  $as9=json_decode($re['Media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['Location'];
			$as13 = $re['Rape_report_Date'];
			$as14 = $re['Rape_report_tym'];
			$as15 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Victim_Name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Age:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Sex:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as14 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as15 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			// 	foreach($as9 as $itm){
			// 		echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
			// 		<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
			// 		<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
			// 			<span style="float:left;">

			// 			  <img src="'.$itm.'" alt="Smiley face" height="60" width="60"> 
			// 													</span>
			// 		</div>
			// 	</div>';
			// 	}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport11()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Kidnap_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Kidnap_report', array('Kidnap_report.Kidnap_report_id' => $id));

		foreach ($res as $re) {

			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Kidnap_reportFeedback', array('Kidnap_report_id' => $re['Kidnap_report_id']));

			$as1 = $re['Kidnap_report_id'];
			$as2 = $re['Full_Name'];
			$as3 = $re['Age'];
			$as4 = $re['Sex'];
			$as5 = $re['Description'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['Last_Seen_Location'];
			$as13 = $re['Spoken_Language'];
			$as14 = $re['Kidnap_report_Date'];
			$as15 = $re['Kidnap_report_tym'];
			$as16 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Full_Name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Age:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Sex:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Last_Seen_Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>	<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Spoken_Language:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as14 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as15 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as16 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}
	public function viewreport12()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Robbery_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Robbery_report', array('Robbery_report.Robbery_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Robbery_reportFeedback', array('Robbery_report_id' => $re['Robbery_report_id']));
			$as1 = $re['Robbery_report_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['Robbery_report_Date'];
			$as5 = $re['Robbery_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];

			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport13()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Burglary_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Burglary_report', array('Burglary_report.Burglary_report_id' => $id));

		foreach ($res as $re) {

			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Burglary_reportFeedback', array('Burglary_report_id' => $re['Burglary_report_id']));
			$as1 = $re['Burglary_report_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['Burglary_report_Date'];
			$as5 = $re['Burglary_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['Items'];
			$as13 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Items:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as12 . '</span>
										</div>
										</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}
	public function viewreport14()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=CybercrimeFraud_report.user_id')));

		$res = $this->beats_model->select_data('*', 'CybercrimeFraud_report', array('CybercrimeFraud_report.CybercrimeFraud_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = $userdet['0']['user_name'];
				$phone = $userdet['0']['user_phone'];
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = $userdet['0']['Full_Name'];
				$phone = $userdet['0']['phone'];
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'CybercrimeFraud_reportFeedback', array('CybercrimeFraud_report_id' => $re['CybercrimeFraud_report_id']));

			$as1 = $re['CybercrimeFraud_report_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['CybercrimeFraud_report_Date'];
			$as5 = $re['CybercrimeFraud_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">iWitness_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">iWitness_date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">iWitness_tym:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport15()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Submit_Tip_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Submit_Tip_report', array('Submit_Tip_report.Submit_Tip_id' => $id));

		foreach ($res as $re) {

			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = (!empty($userdet) ? $userdet['0']['user_name'] : '');
				$phone = (!empty($userdet) ? $userdet['0']['user_phone'] : '');
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = (!empty($userdet) ? $userdet['0']['Full_Name'] : '');
				$phone = (!empty($userdet) ? $userdet['0']['phone'] : '');
				$type = "Police Officer";
			}
			$checkfeed = $this->beats_model->select_data('*', 'Submit_Tip_reportFeedback', array('Submit_Tip_id' => $re['Submit_Tip_id']));

			$as1 = $re['Submit_Tip_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['Date'];
			$as5 = $re['tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}
	public function viewreport16()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Others_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Others_report', array('Others_report.Others_report_id' => $id));

		foreach ($res as $re) {

			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Others_reportFeedback', array('Others_report_id' => $re['Others_report_id']));
			$as1 = $re['Others_report_id'];
			$as2 = $re['Description'];
			$as3 = $re['Location'];
			$as4 = $re['Date'];
			$as5 = $re['tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $type . '
																					</span>
										</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">';
			if (!empty($checkfeed)) {
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = $checkofferc['0']['Full_Name'];
					} else {
						$usertyp = 'Admin';
					}
					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<span style="float:left;">
											    ' . $checkfeed1['feedback'] . ' (' . $usertyp . '.' . $checkfeed1['feedback_date'] . ')
											    
																					</span>';
					if (!empty($newfedim)) {
						foreach ($newfedim as $itm3) {

							echo '<img src="' . $itm3 . '" style="height: 60px;">';
						}
					}
				}
			}

			echo '</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function viewreport17()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vandalism_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Vandalism_report', array('Vandalism_report.Vandalism_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Vandalism_reportFeedback', array('Vandalism_report_id' => $re['Vandalism_report_id']));

			$as1 = $re['Vandalism_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Vandalism_report_Date'];
			$as5 = $re['Vandalism_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as1 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as2 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as3 . '</span>
            </div>
            </div>            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as4 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as5 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $type . '
            </span>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as6 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as12 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as7 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as8 . '
            </span>
            </div>
            </div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
                <span style="float:left;">' . $as10 . '</span>
            </div>
            </div>';

			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>
									<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;">' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;">' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>
									       <td style="padding: 5px;display: inline-block;">';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}


			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as9 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}


			echo '</div>';
		}
	}

	public function viewreport18()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Fire_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Fire_report', array('Fire_report.Fire_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Fire_reportFeedback', array('Fire_report_id' => $re['Fire_report_id']));

			$as1 = $re['Fire_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Fire_report_Date'];
			$as5 = $re['Fire_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as1 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as2 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as3 . '</span>
            </div>
            </div>            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as4 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as5 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $type . '
            </span>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as6 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as12 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as7 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as8 . '
            </span>
            </div>
            </div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
                <span style="float:left;">' . $as10 . '</span>
            </div>
            </div>';

			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>
									<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;">' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;">' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>
									       <td style="padding: 5px;display: inline-block;">';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}


			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as9 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}


			echo '</div>';
		}
	}

	public function viewreport19()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Accident_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Accident_report', array('Accident_report.Accident_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Accident_reportFeedback', array('Accident_report_id' => $re['Accident_report_id']));

			$as1 = $re['Accident_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Accident_report_Date'];
			$as5 = $re['Accident_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as1 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as2 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as3 . '</span>
            </div>
            </div>            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as4 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as5 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $type . '
            </span>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as6 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as12 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as7 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as8 . '
            </span>
            </div>
            </div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
                <span style="float:left;">' . $as10 . '</span>
            </div>
            </div>';

			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>
									<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;">' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;">' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>
									       <td style="padding: 5px;display: inline-block;">';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}


			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as9 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}


			echo '</div>';
		}
	}

	public function viewreport20()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Medical_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Medical_report', array('Medical_report.Medical_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Medical_reportFeedback', array('Medical_report_id' => $re['Medical_report_id']));

			$as1 = $re['Medical_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Medical_report_Date'];
			$as5 = $re['Medical_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as1 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as2 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as3 . '</span>
            </div>
            </div>            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as4 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as5 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $type . '
            </span>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as6 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as12 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as7 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as8 . '
            </span>
            </div>
            </div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
                <span style="float:left;">' . $as10 . '</span>
            </div>
            </div>';

			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>
									<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;">' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;">' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>
									       <td style="padding: 5px;display: inline-block;">';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}


			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as9 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}


			echo '</div>';
		}
	}

	public function viewreport21()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Riot_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Riot_report', array('Riot_report.Riot_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Riot_reportFeedback', array('Riot_report_id' => $re['Riot_report_id']));

			$as1 = $re['Riot_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Riot_report_Date'];
			$as5 = $re['Riot_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as1 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as2 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as3 . '</span>
            </div>
            </div>            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as4 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as5 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $type . '
            </span>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as6 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as12 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as7 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as8 . '
            </span>
            </div>
            </div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
                <span style="float:left;">' . $as10 . '</span>
            </div>
            </div>';

			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>
									<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;">' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;">' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>
									       <td style="padding: 5px;display: inline-block;">';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}


			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as9 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}


			echo '</div>';
		}
	}

	public function viewreport22()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Environmental_Hazard_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Environmental_Hazard_report', array('Environmental_Hazard_report.Environmental_Hazard_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Environmental_Hazard_reportFeedback', array('Environmental_Hazard_report_id' => $re['Environmental_Hazard_report_id']));

			$as1 = $re['Environmental_Hazard_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Environmental_Hazard_report_Date'];
			$as5 = $re['Environmental_Hazard_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as1 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as2 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as3 . '</span>
            </div>
            </div>            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as4 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as5 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $type . '
            </span>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as6 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as12 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as7 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as8 . '
            </span>
            </div>
            </div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
                <span style="float:left;">' . $as10 . '</span>
            </div>
            </div>';

			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>
									<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;">' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;">' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>
									       <td style="padding: 5px;display: inline-block;">';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}


			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as9 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}


			echo '</div>';
		}
	}

	public function viewreport23()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Child_Abuse_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Child_Abuse_report', array('Child_Abuse_report.Child_Abuse_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Child_Abuse_reportFeedback', array('Child_Abuse_report_id' => $re['Child_Abuse_report_id']));

			$as1 = $re['Child_Abuse_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Child_Abuse_report_Date'];
			$as5 = $re['Child_Abuse_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as1 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as2 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as3 . '</span>
            </div>
            </div>            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as4 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as5 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $type . '
            </span>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as6 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as12 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as7 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as8 . '
            </span>
            </div>
            </div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
                <span style="float:left;">' . $as10 . '</span>
            </div>
            </div>';

			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>
									<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;">' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;">' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>
									       <td style="padding: 5px;display: inline-block;">';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}


			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as9 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}


			echo '</div>';
		}
	}

	public function viewreport24()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Human_Trafficking_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Human_Trafficking_report', array('Human_Trafficking_report.Human_Trafficking_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Human_Trafficking_reportFeedback', array('Human_Trafficking_report_id' => $re['Human_Trafficking_report_id']));

			$as1 = $re['Human_Trafficking_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Human_Trafficking_report_Date'];
			$as5 = $re['Human_Trafficking_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as1 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as2 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as3 . '</span>
            </div>
            </div>            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as4 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as5 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $type . '
            </span>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as6 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as12 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as7 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as8 . '
            </span>
            </div>
            </div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
                <span style="float:left;">' . $as10 . '</span>
            </div>
            </div>';

			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>
									<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;">' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;">' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>
									       <td style="padding: 5px;display: inline-block;">';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}


			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as9 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}


			echo '</div>';
		}
	}

	public function viewreport25()
	{
		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Blow_Whistle_report.user_id')));

		$res = $this->beats_model->select_data('*', 'Blow_Whistle_report', array('Blow_Whistle_report.Blow_Whistle_report_id' => $id));

		foreach ($res as $re) {
			if ($re['user_type'] == 0) {
				$userdet = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['user_name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['user_phone'] : '';
				$type = "Citizen";
			} else {
				$userdet = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $re['user_id']));
				$name = !empty($userdet) ? $userdet['0']['Full_Name'] : '';
				$phone = !empty($userdet) ? $userdet['0']['phone'] : '';
				$type = "Police Officer";
			}

			$checkfeed = $this->beats_model->select_data('*', 'Blow_Whistle_reportFeedback', array('Blow_Whistle_report_id' => $re['Blow_Whistle_report_id']));

			$as1 = $re['Blow_Whistle_report_id'];
			$as2 = $re['Name'];
			$as3 = $re['Complaint'];
			$as4 = $re['Blow_Whistle_report_Date'];
			$as5 = $re['Blow_Whistle_report_tym'];
			$as6 = $re['user_id'];
			$as7 = $name;
			$as8 = $phone;
			$as9 = json_decode($re['media']);
			$as10 = $re['created_at'];
			$as11 = $re['feedback'];
			$as12 = $re['GeoLocation'];


			echo '<div class="col-12 col-md-12">
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as1 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as2 . '</span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">' . $as3 . '</span>
            </div>
            </div>            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as4 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as5 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Type:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $type . '
            </span>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_id:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as6 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user location:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as12 . '
            </span>
            </div>
            </div>
            
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_name:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as7 . '
            </span>
            </div>
            </div>
            <div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user_phone:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
            <span style="float:left;">
            ' . $as8 . '
            </span>
            </div>
            </div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
            <div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
            <div style="text-align:left;width:60%;float:left;padding:5px 10px;">
                <span style="float:left;">' . $as10 . '</span>
            </div>
            </div>';

			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>
									<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;">' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;">' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>
									       <td style="padding: 5px;display: inline-block;">';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}


			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as9 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}


			echo '</div>';
		}
	}

	public function SOSview()
	{

		$id = $_POST['SOS_id'];
		//$res = $this->beats_model->select_data('*' , 'Officer',array('Officer_id' => $id));
		$dt = array('multiple', array(array('sos_category', 'sos_category.sos_category_id=SOSManagement.SOS_category')));


		$res = $this->beats_model->select_data('sos_category.*,SOSManagement.*', 'SOSManagement', array('SOSManagement.SOS_id' => $id), '', '', '', $dt);




		foreach ($res as $re) {
			$checkfeed = $this->beats_model->select_data('*', 'SOSFeedback', array('SOS_id' => $re['SOS_id']));
			if ($re['SOS_staus'] == 0) {
				$as10 = 'Active';
			} else {
				$as10 = 'Resolved';
			}

			$as1 = $re['SOS_id'];
			$as2 = $re['sos_category_name'];
			$as3 = $re['current_location'];
			$as4 = $re['Name'];
			$as5 = $re['Phone_Number'];
			$as6 = $re['lat'];
			$as7 = $re['lang'];
			$as8 = $re['created_at'];
			$as9 = $re['update_at'];

			$as11 = $re['feedback'];
			$as12 = json_decode($re['feedbackMedia']);
			//$as11=$re['SOS_staus'];
			//$as12=$re['created_at'];


			$newarimg = json_decode($re['images']);

			//$as7=$newarimg['1'];

			echo '<div class="col-12 col-md-12">
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">SOS_id:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;">' . $as1 . '</span>
					</div>
				</div>
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">sos_category_name:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;">' . $as2 . '</span>
					</div>
				</div>
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">current_location:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;">' . $as3 . '</span>
					</div>
            	</div>
            	<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Name:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;">' . $as4 . '</span>
					</div>
				</div>
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Phone_Number:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;">' . $as5 . '</span>
					</div>
				</div>
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">lat:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;">' . $as6 . '</span>
					</div>
				</div>
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">lang:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					    <span style="float:left;">' . $as7 . '</span>
				    </div>
				</div>
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;">' . $as8 . '</span>
					</div>
				</div>
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">update_at:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;">' . $as9 . '</span>
					</div>
				</div>
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">SOS_staus:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;">' . $as10 . '</span>
					</div>
				</div>
				<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
					<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Map Laoction:</div>
					<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
						<span style="float:left;"><a target="_blank" href="https://www.google.com/maps/search/?api=1&query=' . $as6 . ',' . $as7 . '"> <img src="' . base_url() . 'images/map-ls.png" width="32" height="32" title="Click to open map location." /></a></span>
					</div>
				</div>';
			if (!empty($checkfeed)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					<div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">feedback:</div>';
				// print_r($checkfeed);
				$i = 1;
				foreach ($checkfeed as $checkfeed1) {
					if ($checkfeed1['user_type'] != 0) {
						$checkofferc = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $checkfeed1['user_type']));
						$usertyp = (!empty($checkofferc) ? $checkofferc['0']['Full_Name'] : '');
					} else {
						$usertyp = 'Admin';
					}

					$newfedim = json_decode($checkfeed1['feedbackMedia']);
					echo '<div style="text-align:left;width:100%;float:left;padding:2.5px 2.5px;">';
					echo '<table style="width: 100%;border-bottom: 1px solid black;border-top: 1px solid black;">  
							<tbody>
								<tr>
									<th rowspan="' . (!empty($newfedim) ? 4 : 3) . '" style="text-align: center;border-right: 1px solid black;width: 10px;">' . $i . '</th>    
								</tr>
								<tr>	
								<td style="border-top: 1px solid black;border-bottom: 1px solid black;padding: 5px;"><span style="font-weight: bold;">Name : </span>' . $usertyp . ' On ' . $checkfeed1['feedback_date'] . '</td>    
								</tr>
								<tr>									
									<td style="border-bottom: 1px solid black;padding: 5px;word-wrap: break-word;"><div style="width: 470px;"><span style="font-weight: bold;">Feedback : </span>' . $checkfeed1['feedback'] . '</div></td>    
								</tr>';
					if (!empty($newfedim)) {
						echo '<tr>	
											
									       <td style="padding: 5px;display: inline-block;"><span style="font-weight: bold;">Feedback Media : </span><br>';
						foreach ($newfedim as $itm3) {
							$ext = pathinfo($itm3, PATHINFO_EXTENSION);
							$newmg1 = $itm3;
							if ($ext == 'mp4' || $ext == '3gp') {
								$newmg1 = 'images/video-player.png';
							}
							if ($ext == 'mp3') {
								$newmg1 = 'images/icons8-itunes-100.png';
							}

							echo '<a target="_blank" href="' . $itm3 . '" >
												<img src="' . $newmg1 . '" style="height: 60px;width: 80px;margin: 2.5px;">
											</a>';
						}
						echo '</td>
									</tr>';
					}

					echo '</tbody>
						</table>';
					echo '</div>';
					$i++;
				}
				echo '</div>';
			}
			if (!empty($as12)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Feedback Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as12 as $newarimg2) {
					$ext = pathinfo($newarimg2, PATHINFO_EXTENSION);
					$newmg1 = $newarimg2;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg2 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									</a>
						</span>';
				}
				echo '	</div>
						</div>';
			}
			if (!empty($newarimg)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($newarimg as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}
			echo '</div>';
		}
	}




	public function ViewOfficer()
	{
		$id = $_POST['Officer_id'];
		$res = $this->beats_model->select_data('*', 'Officer', array('Officer_id' => $id));


		$res_new = $this->beats_model->select_data('*', 'user_officer_meta', array('user_id' => $_POST['Officer_id'], 'user_type' => 2));

		$user_meta = array(
			'user_type' => '2',
			'lga_state' => (!empty($res_new) ? $res_new[0]['lga_state'] : ''),
			'blood_group' => (!empty($res_new) ? $res_new[0]['blood_group'] : ''),
			'geno_type' => (!empty($res_new) ? $res_new[0]['geno_type'] : ''),
			'agency' => (!empty($res_new) ? $res_new[0]['agency'] : ''),
			'allergies' => (!empty($res_new) ? $res_new[0]['allergies'] : '')
		);
		// $LGA_ST = unserialize(LGA_ST);
		// $BLOOD_GP = unserialize(BLOOD_GP);
		// $GENO_TY = unserialize(GENO_TY);
		// $AGENCY = unserialize(AGENCY);

		$res[0] = array_merge($res[0], $user_meta);


		foreach ($res as $re) {
			$as1 = $re['Officer_id'];
			$as2 = $re['Full_Name'];
			$as3 = $re['phone'];
			$as4 = $re['Rank'];
			$as5 = $re['Designation'];
			$as6 = $re['State_Deployment'];
			$as7 = $re['Place_Assignment'];
			$as8 = $re['Police_service_Number'];
			$as9 = $re['Residential_Address'];
			$as10 = $re['Kin_Phone'];
			$as11 = $re['Officer_status'];
			$as12 = $re['created_date'];
			$as13 = $re['profilepic'];
			$as14 = $re['lga_state'];
			$as15 = $re['blood_group'];
			$as16 = $re['geno_type'];
			$as17 = $re['agency'];
			$as18 = $re['allergies'];
			$as19 = $re['officer_category'] == 1 ? 'State' : 'LGA';


			//  $newarimg=json_decode($re['Deal_imgVideo']);

			//$as7=$newarimg['1'];

			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Officer_id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Full_Name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Rank:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Designation:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
										
							
								<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Service_Number:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Residential_Address:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as9 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Kin_Phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as10 . '
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Officer_status:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as11 . '
																					</span>
										</div>
									</div>	<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
									
									
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Place_Assignment:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as7 . '											</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Officer Photo:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<img src="' . $as13 . '" style="float:left;height: 100px;">
																						
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Category:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as19 . '											</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">LGA State:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as14 . '											</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Blood Group:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as15 . '											</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Geno Type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as16 . '											</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Agency:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as17 . '											</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Allergies:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as18 . '											</span>
										</div>
									</div>
									</div>';
		}
	}



	public function WantedPersons()
	{
		$data['state_new'] = $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['result'] = $this->beats_model->select_data('*', 'Wanted_Persons', '', '', array('WantedPerson_id', 'desc'));
		$this->load->view('Admin/WantedPersons', $data);
	}
	public function WantedPersonssAdd()
	{

		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
		$config['encrypt_name'] = TRUE;
		$new_name = time() . $_FILES['user_pic']['name'];
		$config['file_name'] = $new_name;
		//Load upload library and initialize configuration
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload('user_pic')) {
			$uploadData = $this->upload->data();
			$picture = $uploadData['file_name'];
			$compeurl = base_url() . 'uploads/' . $picture;
		} else {
			$compeurl = '';
		}

		$new_name = time() . $_FILES['doc']['name'];
		$config['file_name'] = $new_name;
		//Load upload library and initialize configuration
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload('doc')) {
			$uploadData = $this->upload->data();
			$picture = $uploadData['file_name'];
			$docurl = base_url() . 'uploads/' . $picture;
		} else {
			$docurl = '';
		}


		$user_detail = array(
			'Full_Name' => $_POST['Full_Name'],
			'Age' => $_POST['Age'],
			'Sex' => $_POST['Sex'],
			'Description' => $_POST['Description'],
			'Last_Seen_Location' => $_POST['Last_Seen_Location'],
			'Spoken_Language' => $_POST['Spoken_Language'],
			'Crime_Committed' => $_POST['Crime_Committed'],
			'Last_Seen_Location' => $_POST['Last_Seen_Location'],
			'Picture_of_Victim' => $compeurl,
			'Document' => $docurl,
			// 	 'Person_img' => $compeurl1,
		);

		$reg_id = $this->beats_model->insert_data('Wanted_Persons', $user_detail);

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Created enotice Wanted Persons. ID '.$reg_id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		$ds = array_merge($_POST, array("enotice_id" => $reg_id, "enotice_type" => 1));
		
		$dataset['message'] = 'eNotice for Wanted Persons';
		//$this->Enoticenotification();
	    $messageNotification = "Name: ".$_POST['Full_Name'] ."\n Sex: ".$_POST['Sex'] ."\n Last seen location: ".$_POST['Location'] ."\r\n ".$_POST['Description'];
		$this->EnoticenotificationNew("eNotice for Missing Persons", $messageNotification, $ds);

		redirect(base_url('/WantedPersons'));
	}

	public function WantedPersonsdel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('Wanted_Persons', array('WantedPerson_id' => $id));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Deleted enotice Wanted Persons. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

	}
	public function WantedPersonsstatus()
	{

		$res = $this->beats_model->update_data('Wanted_Persons', array('WantedPerson_status' => $_POST['status']), array('WantedPerson_id' => trim($_POST['id'])));

		$date = date('Y-m-d H:i:s');
		if($_POST['status'] == 1)
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Activated enotice Wanted Persons. ID '. $_POST['id'],
				'time' => $date
			);
		}
		else
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Deactivated enotice Wanted Persons. ID '. $_POST['id'],
				'time' => $date
			);
		}
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		echo $_POST['status'];
	}
	public function WantedPersonsUpdate()
		{	
			$config['upload_path'] = 'uploads/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['encrypt_name'] = TRUE;
	
		if (!empty($_FILES['user_pic']['name']) && !empty($_FILES['doc']['name'])) {
			
			$new_name = time() . $_FILES['user_pic']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('user_pic')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$compeurl = base_url() . 'uploads/' . $picture;
			} else {
				$compeurl = '';
			}
	
			$new_name = time() . $_FILES['doc']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('doc')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$docurl = base_url() . 'uploads/' . $picture;
			} else {
				$docurl = '';
			}
	
	
	
			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'Age' => $_POST['Age'],
				'Sex' => $_POST['Sex'],
				'Description' => $_POST['Description'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Spoken_Language' => $_POST['Spoken_Language'],
				'Crime_Committed' => $_POST['Crime_Committed'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Picture_of_Victim' => $compeurl,
				'Document' => $docurl,
				// 	 'Person_img' => $compeurl1,
			);
		}
		elseif(!empty($_FILES['doc']['name'])){

			$new_name = time() . $_FILES['doc']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('doc')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$docurl = base_url() . 'uploads/' . $picture;
			} else {
				$docurl = '';
			}

			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'Age' => $_POST['Age'],
				'Sex' => $_POST['Sex'],
				'Description' => $_POST['Description'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Spoken_Language' => $_POST['Spoken_Language'],
				'Crime_Committed' => $_POST['Crime_Committed'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Document' => $docurl,
				// 	 'Person_img' => $compeurl1,
			);
		}
		elseif(!empty($_FILES['user_pic']['name'])){

			$new_name = time() . $_FILES['user_pic']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('user_pic')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$compeurl = base_url() . 'uploads/' . $picture;
			} else {
				$compeurl = '';
			}

			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'Age' => $_POST['Age'],
				'Sex' => $_POST['Sex'],
				'Description' => $_POST['Description'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Spoken_Language' => $_POST['Spoken_Language'],
				'Crime_Committed' => $_POST['Crime_Committed'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Picture_of_Victim' => $compeurl,

				// 	 'Person_img' => $compeurl1,
			);
		}
		else {
			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'Age' => $_POST['Age'],
				'Sex' => $_POST['Sex'],
				'Description' => $_POST['Description'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Spoken_Language' => $_POST['Spoken_Language'],
				'Crime_Committed' => $_POST['Crime_Committed'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],



			);
		}

		$updt_id = $this->beats_model->update_data('Wanted_Persons', $user_detail, array('WantedPerson_id' => $_POST['WantedPerson_id']));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Updated enotice Wanted Persons. ID '.$_POST['WantedPerson_id'],
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		//echo $this->db->last_query();

		redirect(base_url('/WantedPersons'));
	}

	public function WantedPersonsview()
	{

		$id = $_POST['id'];

		//$res=$this->beats_model->delete_data('Stolen_Vehicle',array('StolenVehicle_id'=>$id));
		$res = $this->beats_model->select_data('*', 'Wanted_Persons', array('WantedPerson_id' => $id));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Viewed enotice Wanted Persons. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		foreach ($res as $re) {

			if ($re['WantedPerson_status'] == 0) {
				$status = 'ATLARGE';
			} else {
				$status = 'CAUGHT';
			}

			$as1 = $re['WantedPerson_id'];
			$as2 = $re['Full_Name'];
			$as3 = $re['Age'];
			$as4 = $re['Sex'];
			$as5 = $re['Description'];


			$as8 = $re['created_at'];

			$as6 = $re['Last_Seen_Location'];
			$as7 = $re['Spoken_Language'];

			$as11 = $re['Crime_Committed'];

			$as12 = $status;

			if($re['Document'] == '' || $re['Document'] == NULL)
			{
				$download = '';
			}
			else
			{
				$download = 'DOWNLOAD';
			}

			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Full_Name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Age:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Sex:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Last_Seen_Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Spoken_Language:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
								
									
									
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Crime_Committed:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as11 . '
																					</span>
										</div>
									</div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $re['Picture_of_Victim'] . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Document:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <a href="' . $re['Document'] . '" alt="Document" download>'.$download.'</a>
																					</span>
										</div>
									</div>';			

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Status:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  ' . $as12 . '
																					</span>
										</div>
									</div><div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as8 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function WantedPersonsedit()
	{
		$result = $this->beats_model->select_data('*', 'Wanted_Persons', array('WantedPerson_id' => $_POST['WantedPerson_id']));
		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Full_Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Full_Name" id="Full_Name" value="' . $result['0']['Full_Name'] . '" required/>
                                                         <input type="hidden" class="form-control" name="WantedPerson_id" id="WantedPerson_id" value="' . $result['0']['WantedPerson_id'] . '" required/>
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Age</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Age" id="Age" value="' . $result['0']['Age'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Sex</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Sex" id="Sex" value="' . $result['0']['Sex'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            	<div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <textarea class="form-control" name="Description" id="Description"  required>' . $result['0']['Description'] . '</textarea>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Last_Seen_Location</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Last_Seen_Location" id="Last_Seen_Location" value="' . $result['0']['Last_Seen_Location'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Spoken_Language</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Spoken_Language" id="Spoken_Language" value="' . $result['0']['Spoken_Language'] . '"  required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Crime_Committed</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Crime_Committed" id="Crime_Committed" value="' . $result['0']['Crime_Committed'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div><div class="form-group"><label class="col-md-3 control-label">Picture_of_Victim</label><div class="col-md-3">                                            
                                                    <div class="input-group">
                                                        <img src="' . $result['0']['Picture_of_Victim'] . '" style="height: 70px;">
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div></div><div class="form-group">
                                                <label class="col-md-3 control-label">Change Picture</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="file" class="form-control" name="user_pic" id="Picture_of_Victim" accept="image/x-png,image/gif,image/jpeg" />
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
											</div>
											<div class="form-group">
                                                <label class="col-md-3 control-label">Update Document</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="file" class="form-control" name="doc" id="doc" accept="image/x-png,image/gif,image/jpeg,application/pdf" />
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>';
	}


	public function MissingPersons()
	{
		$data['state_new'] = $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['result'] = $this->beats_model->select_data('*', 'Missing_Persons', '', '', array('MissingPersons_id', 'desc'));
		$this->load->view('Admin/MissingPersons', $data);
	}
	public function MissingPersonsAdd()
	{


		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';

		$config['encrypt_name'] = TRUE;
		$new_name = time() . $_FILES['user_pic']['name'];
		$config['file_name'] = $new_name;
		//Load upload library and initialize configuration
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload('user_pic')) {
			$uploadData = $this->upload->data();
			$picture = $uploadData['file_name'];
			$compeurl = base_url() . 'uploads/' . $picture;
		} else {
			$compeurl = '';
		}

		$new_name = time() . $_FILES['doc']['name'];
		$config['file_name'] = $new_name;
		//Load upload library and initialize configuration
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload('doc')) {
			$uploadData = $this->upload->data();
			$picture = $uploadData['file_name'];
			$docurl = base_url() . 'uploads/' . $picture;
		} else {
			$docurl = '';
		}

		
		$user_detail = array(
			'Full_Name' => $_POST['Full_Name'],
			'Age' => $_POST['Age'],
			'Sex' => $_POST['Sex'],
			'Description' => $_POST['Description'],
			'Last_Seen_Location' => $_POST['Last_Seen_Location'],
			'Spoken_Language' => $_POST['Spoken_Language'],
			'MissingPersons_Date' => $_POST['MissingPersons_Date'],
			'MissingPersons_tym' => $_POST['MissingPersons_tym'],
			//   'Crime_Committed' => $_POST['Crime_Committed'],
			'Last_Seen_Location' => $_POST['Last_Seen_Location'],
			'Picture_of_Victim' => $compeurl,
			'Document' => $docurl,
			// 	 'Person_img' => $compeurl1,
		);


		$reg_id = $this->beats_model->insert_data('Missing_Persons', $user_detail);

		
		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Created enotice Missing Persons. ID '.$reg_id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		$ds = array_merge($_POST, array("enotice_id" => $reg_id, "enotice_type" => 2));
		
		$messageNotification = $_POST['Full_Name'] ."\n Sex: ".$_POST['Sex'] ."\n Last seen location: ".$_POST['Location'] ."\r\n ".$_POST['Description'];
		$this->EnoticenotificationNew("eNotice for Missing Persons", $messageNotification, $ds);

		redirect(base_url('/MissingPersons'));
	}

	public function MissingPersonsdel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('Missing_Persons', array('MissingPersons_id' => $id));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Deleted enotice Missing Persons. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);
	}
	public function MissingPersonsstatus()
	{

		$res = $this->beats_model->update_data('Missing_Persons', array('MissingPersons_status' => $_POST['status']), array('MissingPersons_id' => trim($_POST['id'])));

		$date = date('Y-m-d H:i:s');
		if($_POST['status'] == 1)
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Activated enotice Missing Persons. ID '. $_POST['id'],
				'time' => $date
			);
		}
		else
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Deactivated enotice Missing Persons. ID '. $_POST['id'],
				'time' => $date
			);
		}
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		echo $_POST['status'];
	}
	public function MissingPersonsUpdate()
	{
		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
		$config['encrypt_name'] = TRUE;

		if (!empty($_FILES['user_pic']['name']) && !empty($_FILES['doc']['name'])) {

			$new_name = time() . $_FILES['user_pic']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('user_pic')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$compeurl = base_url() . 'uploads/' . $picture;
			} else {
				$compeurl = '';
			}

			$new_name = time() . $_FILES['doc']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('doc')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$docurl = base_url() . 'uploads/' . $picture;
			} else {
				$docurl = '';
			}


			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'Age' => $_POST['Age'],
				'Sex' => $_POST['Sex'],
				'Description' => $_POST['Description'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Spoken_Language' => $_POST['Spoken_Language'],
				'MissingPersons_Date' => $_POST['MissingPersons_Date'],
				'MissingPersons_tym' => $_POST['MissingPersons_tym'],

				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Picture_of_Victim' => $compeurl,
				'Document' => $docurl,


			);
		}
		elseif(!empty($_FILES['doc']['name'])){

			$new_name = time() . $_FILES['doc']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('doc')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$docurl = base_url() . 'uploads/' . $picture;
			} else {
				$docurl = '';
			}

			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'Age' => $_POST['Age'],
				'Sex' => $_POST['Sex'],
				'Description' => $_POST['Description'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Spoken_Language' => $_POST['Spoken_Language'],
				'MissingPersons_Date' => $_POST['MissingPersons_Date'],
				'MissingPersons_tym' => $_POST['MissingPersons_tym'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Document' => $docurl,

			);

		}
		elseif(!empty($_FILES['user_pic']['name'])){

			$new_name = time() . $_FILES['user_pic']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('user_pic')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$compeurl = base_url() . 'uploads/' . $picture;
			} else {
				$compeurl = '';
			}

			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'Age' => $_POST['Age'],
				'Sex' => $_POST['Sex'],
				'Description' => $_POST['Description'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Spoken_Language' => $_POST['Spoken_Language'],
				'MissingPersons_Date' => $_POST['MissingPersons_Date'],
				'MissingPersons_tym' => $_POST['MissingPersons_tym'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Picture_of_Victim' => $compeurl,


			);
		}
		else {
			$user_detail = array(
				'Full_Name' => $_POST['Full_Name'],
				'Age' => $_POST['Age'],
				'Sex' => $_POST['Sex'],
				'Description' => $_POST['Description'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],
				'Spoken_Language' => $_POST['Spoken_Language'],
				'MissingPersons_Date' => $_POST['MissingPersons_Date'],
				'MissingPersons_tym' => $_POST['MissingPersons_tym'],
				'Last_Seen_Location' => $_POST['Last_Seen_Location'],



			);
		}

		$updt_id = $this->beats_model->update_data('Missing_Persons', $user_detail, array('MissingPersons_id' => $_POST['MissingPersons_id']));


		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Updated enotice Missing Persons. ID '.$_POST['MissingPersons_id'],
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);


		//echo $this->db->last_query();

		redirect(base_url('/MissingPersons'));
	}

	public function MissingPersonsview()
	{

		$id = $_POST['id'];

		//$res=$this->beats_model->delete_data('Stolen_Vehicle',array('StolenVehicle_id'=>$id));
		$res = $this->beats_model->select_data('*', 'Missing_Persons', array('MissingPersons_id' => $id));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Viewed enotice Missing Persons. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		foreach ($res as $re) {
			if ($re['MissingPersons_status'] == 0) {
				$status = 'MISSING';
			} else {
				$status = 'FOUND';
			}


			$as1 = $re['MissingPersons_id'];
			$as2 = $re['Full_Name'];
			$as3 = $re['Age'];
			$as4 = $re['Sex'];
			$as5 = $re['Description'];
			//  $as6=$re['user_id'];
			//  $as7=$re['user_name'];
			//  $as8=$re['user_phone'];

			$as8 = $re['created_at'];

			$as6 = $re['Last_Seen_Location'];
			$as7 = $re['Spoken_Language'];
			$as9 = $re['MissingPersons_Date'];
			$as10 = $re['MissingPersons_tym'];
			$as11 = $status;

			if($re['Document'] == '' || $re['Document'] == NULL)
			{
				$download = '';
			}
			else
			{
				$download = 'DOWNLOAD';
			}

			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Full_Name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Age:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Sex:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Last_Seen_Location:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Spoken_Language:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as9 . '
																					</span>
										</div>
									</div>
									
									
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as10 . '
																					</span>
										</div>
									</div><div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Status:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as11 . '
																					</span>
										</div>
									</div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $re['Picture_of_Victim'] . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Document:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <a href="' . $re['Document'] . '" alt="Document" download>'.$download.'</a>
																					</span>
										</div>
									</div>';			


			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as8 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function MissingPersonsedit()
	{
		$result = $this->beats_model->select_data('*', 'Missing_Persons', array('MissingPersons_id' => $_POST['MissingPersons_id']));
		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Full_Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Full_Name" id="Full_Name" value="' . $result['0']['Full_Name'] . '" required/>
                                                         <input type="hidden" class="form-control" name="MissingPersons_id" id="MissingPersons_id" value="' . $result['0']['MissingPersons_id'] . '" required/>
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Age</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Age" id="Age" value="' . $result['0']['Age'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Sex</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Sex" id="Sex" value="' . $result['0']['Sex'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            	<div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <textarea class="form-control" name="Description" id="Description"  required>' . $result['0']['Description'] . '</textarea>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Last_Seen_Location</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Last_Seen_Location" id="Last_Seen_Location" value="' . $result['0']['Last_Seen_Location'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Spoken_Language</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Spoken_Language" id="Spoken_Language" value="' . $result['0']['Spoken_Language'] . '"  required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">MissingPersons_Date</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="date" class="form-control" name="MissingPersons_Date" id="MissingPersons_Date"  value="' . $result['0']['MissingPersons_Date'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">MissingPersons_tym</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="time" class="form-control" name="MissingPersons_tym" id="MissingPersons_tym" value="' . $result['0']['MissingPersons_tym'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div><div class="form-group"><label class="col-md-3 control-label">Picture_of_Victim</label><div class="col-md-3">                                            
                                                    <div class="input-group">
                                                        <img src="' . $result['0']['Picture_of_Victim'] . '" style="height: 70px;">
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div></div><div class="form-group">
                                                <label class="col-md-3 control-label">Change Picture</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="file" class="form-control" name="user_pic" id="Picture_of_Victim"  accept="image/x-png,image/gif,image/jpeg"/>
                                                        
                                                        <div id="aptid"></div>
                                                    </div>                                            
                                                 
                                                </div>
											</div>
											<div class="form-group">
											<label class="col-md-3 control-label">Update Document</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													<input type="file" class="form-control" name="doc" id="doc" accept="image/x-png,image/gif,image/jpeg,application/pdf" />
													
													
												</div>                                            
											 
											</div>
										</div>';
	}

	public function StolenVehicle()
	{
		$data['state_new'] = $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['result'] = $this->beats_model->select_data('*', 'Stolen_Vehicle', '', '', array('StolenVehicle_id', 'desc'));
		$this->load->view('Admin/StolenVehicle', $data);
	}
	public function StolenVehicleAdd()
	{

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


				// code by invito

				$config['upload_path'] = 'uploads/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
				$config['encrypt_name'] = TRUE;
				$new_name = time() . $_FILES['doc']['name'];
				$config['file_name'] = $new_name;
				//Load upload library and initialize configuration
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('doc')) {
					$uploadData = $this->upload->data();
					$picture = $uploadData['file_name'];
					$docurl = base_url() . 'uploads/' . $picture;
				} else {
					$docurl = '';
				}
		
				// code by invito


		$user_detail = array(
			'Vehicle_make' => $_POST['Vehicle_make'],
			'Vehicle_model' => $_POST['Vehicle_model'],
			'Vehicle_year' => $_POST['Vehicle_year'],
			'Vehicle_lastlocation' => $_POST['Vehicle_lastlocation'],
			'Plate_Number' => $_POST['Plate_Number'],
			'Engine_Number' => $_POST['Engine_Number'],
			'Vehicle_Color' => $_POST['Vehicle_Color'],
			'StolenVehicle_report_date' => $_POST['StolenVehicle_report_date'],
			'StolenVehicle_report_tym' => $_POST['StolenVehicle_report_tym'],
			'StolenVehicle_img' => json_encode($images),
			'Document' => $docurl,


		);

		$reg_id = $this->beats_model->insert_data('Stolen_Vehicle', $user_detail);

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Created enotice Stolen Vehicle. ID '.$reg_id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		$ds = array_merge($_POST, array("enotice_id" => $reg_id, "enotice_type" => 4));
	    $messageNotification = "Vehicle : ".$_POST['Vehicle_make'] ."\n Vehicle model: ".$_POST['Vehicle_model'] ."\n Last location: ".$_POST['Vehicle_lastlocation'] ."\r\n Plate number".$_POST['Plate_Number'];
		$this->EnoticenotificationNew("eNotice for Stolen Vehicle", array_reverse($dataset), $ds);

		redirect(base_url('/StolenVehicle'));
	}

	public function StolenVehicledel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('Stolen_Vehicle', array('StolenVehicle_id' => $id));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Deleted enotice Stolen Vehicle. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

	}
	public function StolenVehiclestatus()
	{

		$res = $this->beats_model->update_data('Stolen_Vehicle', array('StolenVehicle_status' => $_POST['status']), array('StolenVehicle_id' => trim($_POST['id'])));

		$date = date('Y-m-d H:i:s');
		if($_POST['status'] == 1)
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Activated enotice Stolen Vehicle. ID '. $_POST['id'],
				'time' => $date
			);
		}
		else
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Deactivated enotice Stolen Vehicle. ID '. $_POST['id'],
				'time' => $date
			);
		}
		$this->beats_model->insert_data('subadmin_logs',$dataset);


		echo $_POST['status'];
	}
	public function StolenVehicleUpdate()
	{
		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
		$config['encrypt_name'] = TRUE;

		if(!empty($_FILES['doc']['name']))
		{
			$new_name = time() . $_FILES['doc']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('doc')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$docurl = base_url() . 'uploads/' . $picture;
			} else {
				$docurl = '';
			}

			$user_detail = array(
				'Vehicle_make' => $_POST['Vehicle_make'],
				'Vehicle_model' => $_POST['Vehicle_model'],
				'Vehicle_year' => $_POST['Vehicle_year'],
				'Vehicle_lastlocation' => $_POST['Vehicle_lastlocation'],
				'Plate_Number' => $_POST['Plate_Number'],
				'Engine_Number' => $_POST['Engine_Number'],
				'Vehicle_Color' => $_POST['Vehicle_Color'],
				'StolenVehicle_report_date' => $_POST['StolenVehicle_report_date'],
				'StolenVehicle_report_tym' => $_POST['StolenVehicle_report_tym'],
				'Document' => $docurl,

			);
		}

		else
		{
			$user_detail = array(
				'Vehicle_make' => $_POST['Vehicle_make'],
				'Vehicle_model' => $_POST['Vehicle_model'],
				'Vehicle_year' => $_POST['Vehicle_year'],
				'Vehicle_lastlocation' => $_POST['Vehicle_lastlocation'],
				'Plate_Number' => $_POST['Plate_Number'],
				'Engine_Number' => $_POST['Engine_Number'],
				'Vehicle_Color' => $_POST['Vehicle_Color'],
				'StolenVehicle_report_date' => $_POST['StolenVehicle_report_date'],
				'StolenVehicle_report_tym' => $_POST['StolenVehicle_report_tym'],




			);
		}
		$updt_id = $this->beats_model->update_data('Stolen_Vehicle', $user_detail, array('StolenVehicle_id' => $_POST['StolenVehicle_id']));


		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Updated enotice Stolen Vehicle. ID '.$_POST['StolenVehicle_id'],
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);


		//echo $this->db->last_query();

		redirect(base_url('/StolenVehicle'));
	}

	public function StolenVehicleview()
	{

		$id = $_POST['id'];

		//$res=$this->beats_model->delete_data('Stolen_Vehicle',array('StolenVehicle_id'=>$id));
		$res = $this->beats_model->select_data('*', 'Stolen_Vehicle', array('StolenVehicle_id' => $id));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Viewed enotice Stolen Vehicle. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);


		foreach ($res as $re) {

			if ($re['StolenVehicle_status'] == 0) {
				$status = 'MISSING';
			} else {
				$status = 'RECOVERED';
			}
			$as1 = $re['StolenVehicle_id'];
			$as2 = $re['Vehicle_make'];
			$as3 = $re['Vehicle_model'];
			$as4 = $re['Vehicle_lastlocation'];
			$as5 = $re['Plate_Number'];
			//  $as6=$re['user_id'];
			//  $as7=$re['user_name'];
			//  $as8=$re['user_phone'];
			$as9 = json_decode($re['StolenVehicle_img']);
			$as10 = $re['created_at'];

			$as12 = $re['Engine_Number'];
			$as13 = $re['Vehicle_Color'];
			$as14 = $re['StolenVehicle_report_date'];
			$as15 = $re['StolenVehicle_report_tym'];
			$as16 = $status;

			if($re['Document'] == '' || $re['Document'] == NULL)
			{
				$download = '';
			}
			else
			{
				$download = 'DOWNLOAD';
			}

			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_make:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_model:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
								
								
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_lastlocation:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as4 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Plate_Number:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Engine_Number:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_Color:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as14 . '
																					</span>
										</div>
									</div>
									
									
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as15 . '
																					</span>
										</div>
									</div><div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Status:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as16 . '
																					</span>
										</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}
			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
			<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Document:</div>
			<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
				<span style="float:left;">
				
				  <a href="' . $re['Document'] . '" alt="Document" download>'.$download.'</a>
														</span>
			</div>
			</div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function StolenVehicledit()
	{
		$result = $this->beats_model->select_data('*', 'Stolen_Vehicle', array('StolenVehicle_id' => $_POST['StolenVehicle_id']));
		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Vehicle_make</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Vehicle_make" id="Vehicle_make" value="' . $result['0']['Vehicle_make'] . '" required/>
                                                         <input type="hidden" class="form-control" name="StolenVehicle_id" id="StolenVehicle_id"  value="' . $result['0']['StolenVehicle_id'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Vehicle_model</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Vehicle_model" id="Vehicle_model" value="' . $result['0']['Vehicle_model'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Vehicle_year</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Vehicle_year" id="Vehicle_year" value="' . $result['0']['Vehicle_year'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            	<div class="form-group">
                                                <label class="col-md-3 control-label">Vehicle_lastlocation</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <textarea class="form-control" name="Vehicle_lastlocation" id="Vehicle_lastlocation"  required>' . $result['0']['Vehicle_lastlocation'] . '</textarea>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Plate_Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Plate_Number" id="Plate_Number" value="' . $result['0']['StolenVehicle_id'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Engine_Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Engine_Number" id="Engine_Number" value="' . $result['0']['Engine_Number'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Vehicle_Color</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Vehicle_Color" id="Vehicle_Color" value="' . $result['0']['Vehicle_Color'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Date</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="date" class="form-control" name="StolenVehicle_report_date" id="StolenVehicle_report_date" value="' . $result['0']['StolenVehicle_report_date'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Time</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="time" class="form-control" name="StolenVehicle_report_tym" id="StolenVehicle_report_tym" value="' . $result['0']['StolenVehicle_report_tym'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
											</div>
											<div class="form-group">
											<label class="col-md-3 control-label">Update Document</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													<input type="file" class="form-control" name="doc" id="doc" accept="image/x-png,image/gif,image/jpeg,application/pdf" />
													
													
												</div>                                            
											
											</div>
										</div>';


		$imgl = json_decode($result['0']['StolenVehicle_img']);
		$count = 1;
		foreach ($imgl as $itm) {
			echo '<div class="form-group"><label class="col-md-3 control-label">Media' . $count . '</label><div class="col-md-3">                                            
                                                    <div class="input-group">
                                                        <img src="' . $itm . '" style="height: 70px;" accept="image/x-png,image/gif,image/jpeg">
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div></div>';
			$count++;
		}

	}


	public function PublicEvents()
	{
		$data['state_new'] = $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['result'] = $this->beats_model->select_data('*', 'Public_Events', '', '', array('PublicEvent_id', 'desc'));
		$this->load->view('Admin/PublicEvents', $data);
	}
	public function PublicEventsAdd()
	{

		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
		$config['encrypt_name'] = TRUE;
		$new_name = time() . $_FILES['doc']['name'];
		$config['file_name'] = $new_name;
		//Load upload library and initialize configuration
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload('doc')) {
			$uploadData = $this->upload->data();
			$picture = $uploadData['file_name'];
			$docurl = base_url() . 'uploads/' . $picture;
		} else {
			$docurl = '';
		}

		$user_detail = array(
			'Event_Name' => $_POST['Event_Name'],
			'Event_Description' => $_POST['Event_Description'],
			'Event_tym' => $_POST['Event_tym'],
			'Event_address' => $_POST['Event_address'],
			'Event_date' => $_POST['Event_date'],
			'Document' => $docurl,
		);

		$reg_id = $this->beats_model->insert_data('Public_Events', $user_detail);

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Created enotice Public Events. ID '.$reg_id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);


		$ds = array_merge($_POST, array("enotice_id" => $reg_id, "enotice_type" => 3));
		$messageNotification = $_POST['Event_Name'] ."\n".$_POST['Event_Description'];
		$this->EnoticenotificationNew("eNotice for Public Events", $messageNotification, $ds);

		redirect(base_url('/PublicEvents'));
	}
	public function PublicEventsdel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('Public_Events', array('PublicEvent_id' => $id));

		
		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Deleted enotice Public Events. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

	}
	public function PublicEventsstatus()
	{

		$res = $this->beats_model->update_data('Public_Events', array('Event_status' => $_POST['status']), array('PublicEvent_id' => trim($_POST['id'])));

		$date = date('Y-m-d H:i:s');
		if($_POST['status'] == 1)
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Activated enotice Public Events. ID '. $_POST['id'],
				'time' => $date
			);
		}
		else
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Deactivated enotice Public Events. ID '. $_POST['id'],
				'time' => $date
			);
		}
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		echo $_POST['status'];
	}
	public function PublicEventsUpdate()
	{

		if(!empty($_FILES['doc']['name']))
		{
			$config['upload_path'] = 'uploads/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['encrypt_name'] = TRUE;
			$new_name = time() . $_FILES['doc']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('doc')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$docurl = base_url() . 'uploads/' . $picture;
			} else {
				$docurl = '';
			}

			$user_detail = array(
				'Event_Name' => $_POST['Event_Name'],
				'Event_Description' => $_POST['Event_Description'],
				'Event_tym' => $_POST['Event_tym'],
				'Event_address' => $_POST['Event_address'],
				'Event_date' => $_POST['Event_date'],
				'Document' => $docurl,
	
			);
		}
		else
		{
			$user_detail = array(
				'Event_Name' => $_POST['Event_Name'],
				'Event_Description' => $_POST['Event_Description'],
				'Event_tym' => $_POST['Event_tym'],
				'Event_address' => $_POST['Event_address'],
				'Event_date' => $_POST['Event_date'],
	
			);
		}
		

		$updt_id = $this->beats_model->update_data('Public_Events', $user_detail, array('PublicEvent_id' => $_POST['PublicEvent_id']));


		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Updated enotice Public Events. ID '.$_POST['PublicEvent_id'],
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		//echo $this->db->last_query();

		redirect(base_url('/PublicEvents'));
	}

	public function PublicEventsdit()
	{
		$result = $this->beats_model->select_data('*', 'Public_Events', array('PublicEvent_id' => $_POST['PublicEvent_id']));
		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Event_Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Event_Name" id="Event_Name"  value="' . $result['0']['Event_Name'] . '" required/>
                                                        
                                                        <input type="hidden" class="form-control" name="PublicEvent_id" id="PublicEvent_id"  value="' . $result['0']['PublicEvent_id'] . '" required/>
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            
                                            
                                            	<div class="form-group">
                                                <label class="col-md-3 control-label">Event_Description</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <textarea class="form-control" name="Event_Description" id="Event_Description"  required>' . $result['0']['Event_Description'] . '</textarea>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Event_address</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Event_address" id="Event_address" value="' . $result['0']['Event_address'] . '"  required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Event_date</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="date" class="form-control" name="Event_date" id="Event_date" value="' . $result['0']['Event_date'] . '"  required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Event_tym</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="time" class="form-control" name="Event_tym" id="Event_tym" value="' . $result['0']['Event_tym'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
											</div>
											<div class="form-group">
                                                <label class="col-md-3 control-label">Update Document</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="file" class="form-control" name="doc" id="doc" accept="image/x-png,image/gif,image/jpeg,application/pdf" />
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>';
	}
	public function SecurityTips()
	{
		$data['state_new'] = $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['result'] = $this->beats_model->select_data('*', 'Security_Tips', '', '', array('SecurityTips_id', 'desc'), '', '');
		$this->load->view('Admin/SecurityTips', $data);
	}

	public function SecurityTipsAdd()
	{

		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
		$config['encrypt_name'] = TRUE;

		$new_name = time() . $_FILES['doc']['name'];
		$config['file_name'] = $new_name;
		//Load upload library and initialize configuration
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload('doc')) {
			$uploadData = $this->upload->data();
			$picture = $uploadData['file_name'];
			$docurl = base_url() . 'uploads/' . $picture;
		} else {
			$docurl = '';
		}

		$user_detail = array(
			'Title' => $_POST['Title'],
			'Message' => $_POST['Message'],
			'SecurityTips_date' => $_POST['SecurityTips_date'],
			'SecurityTips_tym' => $_POST['SecurityTips_tym'],
			'Document' => $docurl,

		);

		$reg_id = $this->beats_model->insert_data('Security_Tips', $user_detail);

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Created enotice Security Tips. ID '.$reg_id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);


		$ds = array_merge($_POST, array("enotice_id" => $reg_id, "enotice_type" => 5));
	    $messageNotification = $_POST['Title'] ."\n".$_POST['Message'];
		$this->EnoticenotificationNew("eNotice for Security Tips", $messageNotification, $ds);

		redirect(base_url('/SecurityTips'));
	}
	public function SecurityTipdel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('Security_Tips', array('SecurityTips_id' => $id));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Deleted enotice Security Tips. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

	}
	public function SecurityTipstatus()
	{

		$res = $this->beats_model->update_data('Security_Tips', array('SecurityTips_status' => $_POST['status']), array('SecurityTips_id' => trim($_POST['id'])));

		$date = date('Y-m-d H:i:s');
		if($_POST['status'] == 1)
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Activated enotice Security Tips. ID '. $_POST['id'],
				'time' => $date
			);
		}
		else
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Deactivated enotice Security Tips. ID '. $_POST['id'],
				'time' => $date
			);
		}
		$this->beats_model->insert_data('subadmin_logs',$dataset);


		echo $_POST['status'];
	}
	public function SecurityTipsUpdate()
	{

		if(!empty($_FILES['doc']['name'])){

			$new_name = time() . $_FILES['doc']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('doc')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$docurl = base_url() . 'uploads/' . $picture;
			} else {
				$docurl = '';
			}

			$user_detail = array(
				'Title' => $_POST['Title'],
				'Message' => $_POST['Message'],
				'SecurityTips_date' => $_POST['SecurityTips_date'],
				'SecurityTips_tym' => $_POST['SecurityTips_tym'],
				'Document' => $docurl,
	
			);

		}
		else
		{

			$user_detail = array(
				'Title' => $_POST['Title'],
				'Message' => $_POST['Message'],
				'SecurityTips_date' => $_POST['SecurityTips_date'],
				'SecurityTips_tym' => $_POST['SecurityTips_tym'],
	
	
			);

		}


		

		$updt_id = $this->beats_model->update_data('Security_Tips', $user_detail, array('SecurityTips_id' => $_POST['SecurityTips_id']));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Updated enotice Security Tips. ID '.$_POST['SecurityTips_id'],
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);


		redirect(base_url('/SecurityTips'));
	}

	public function SecurityTipedit()
	{
		$result = $this->beats_model->select_data('*', 'Security_Tips', array('SecurityTips_id' => $_POST['SecurityTips_id']));
		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Title</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Title" id="Title"  value="' . $result['0']['Title'] . '" required/>
                                                         <input type="hidden" class="form-control" name="SecurityTips_id" id="SecurityTips_id"  value="' . $result['0']['SecurityTips_id'] . '" required/>
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            
                                            	<div class="form-group">
                                                <label class="col-md-3 control-label">Message</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <textarea class="form-control" name="Message" id="Message"  required>' . $result['0']['Message'] . '</textarea>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">date</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="date" class="form-control" name="SecurityTips_date" id="SecurityTips_date" value="' . $result['0']['SecurityTips_date'] . '"  required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Time</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="time" class="form-control" name="SecurityTips_tym" id="SecurityTips_tym" value="' . $result['0']['SecurityTips_tym'] . '" required/>
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div>
											</div>
											<div class="form-group">
											<label class="col-md-3 control-label">Update Document</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													<input type="file" class="form-control" name="doc" id="doc" accept="image/x-png,image/gif,image/jpeg,application/pdf" />
													
													
												</div>                                            
											 
											</div>
										</div>
											';
	}
	public function VehicleProfile()
	{
		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vehicle_Profile.user_id')));

		$data['result'] = $this->beats_model->select_data('user_signup.*,Vehicle_Profile.*', 'Vehicle_Profile', '', '', array('Vehicle_Profile.Vehicle_id', 'desc'), '', $dt);


		$this->load->view('Admin/VehicleProfile', $data);
	}


	public function UpdateVehicleProfile()
	{




		$user_detail = array(
			'Vehicle_make' => $_POST['Vehicle_make'],
			'Vehicle_model' => $_POST['Vehicle_model'],
			'Plate_Number' => $_POST['Plate_Number'],
			'Engine_Number' => $_POST['Engine_Number'],
			'Vehicle_Color' => $_POST['Vehicle_Color'],
			//      'Vehicle_img' => json_encode($images),
			// 	 'Proof_of_Ownership' => $compeurl,
			// 	 'user_id' => $_POST['user_id'],


		);

		$updt_id = $this->beats_model->update_data('Vehicle_Profile', $user_detail, array('Vehicle_id' => $_POST['Vehicle_id']));
		//echo $this->db->last_query();

		redirect(base_url('/VehicleProfile'));
	}

	public function Vehicleprofileview()
	{

		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vehicle_Profile.user_id')));

		$res = $this->beats_model->select_data('user_signup.*,Vehicle_Profile.*', 'Vehicle_Profile', array('Vehicle_Profile.Vehicle_id' => $id), '', array('Vehicle_Profile.Vehicle_id', 'desc'), '', $dt);


		foreach ($res as $re) {

			$ptrnsfer = $this->beats_model->select_data('*', 'Transfer_Vehicle', array('Vehicle_id' => $re['Vehicle_id']));
			if (!empty($ptrnsfer)) {

				$new_Name = $ptrnsfer['0']['new_Name'];
				$new_phone = $ptrnsfer['0']['new_phone'];
				$Reason_Transfer = $ptrnsfer['0']['Reason_Transfer'];
			}

			$as1 = $re['Vehicle_uniquely'];
			$as2 = $re['Vehicle_make'];
			$as3 = $re['Vehicle_model'];
			//  $as4=$re['Vehicle_lastlocation'];
			$as5 = $re['Plate_Number'];
			$as6 = $re['user_id'];
			$as7 = $re['user_name'];
			$as8 = $re['user_phone'];
			$as9 = json_decode($re['Vehicle_img']);
			$as10 = $re['created_at'];

			$as12 = $re['Engine_Number'];
			$as13 = $re['Vehicle_Color'];
			$as14 = $re['Proof_of_Ownership'];
			$as15 = $re['qrcodeimg'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">QR Code:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    <img src="' . $as15 . '" alt="QR Code" width="150"> 
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_make:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_model:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Plate_Number:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Engine_Number:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_Color:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as13 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Proof_of_Ownership:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    <img src="' . $as14 . '" alt="Smiley face" height="60" width="60">
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>	<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
									
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user Phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Vehicle_img:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}

			if (!empty($ptrnsfer)) {

				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Transfer name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											 ' . $new_Name . '
																					</span>
										</div>
									</div><div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Transfer Phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											 ' . $new_phone . '
																					</span>
										</div>
									</div><div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Reason Transfer:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											 ' . $Reason_Transfer . '
																					</span>
										</div>
									</div>';
			}

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function Vehicleprofiledit()
	{
		//$result = $this->beats_model->select_data('*' , 'Stolen_Vehicle',array('StolenVehicle_id'=>$_POST['StolenVehicle_id']));
		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Vehicle_Profile.user_id')));

		$result = $this->beats_model->select_data('user_signup.*,Vehicle_Profile.*', 'Vehicle_Profile', array('Vehicle_Profile.Vehicle_id' => $_POST['Vehicle_id']), '', array('Vehicle_Profile.Vehicle_id', 'desc'), '', $dt);

		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Vehicle_make</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Vehicle_make" id="Vehicle_make" value="' . $result['0']['Vehicle_make'] . '" required/>
                                                         <input type="hidden" class="form-control" name="Vehicle_id" id="Vehicle_id"  value="' . $result['0']['Vehicle_id'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Vehicle_model</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Vehicle_model" id="Vehicle_model" value="' . $result['0']['Vehicle_model'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            
                                            	
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Plate_Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Plate_Number" id="Plate_Number" value="' . $result['0']['Plate_Number'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Engine_Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Engine_Number" id="Engine_Number" value="' . $result['0']['Engine_Number'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Vehicle_Color</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Vehicle_Color" id="Vehicle_Color" value="' . $result['0']['Vehicle_Color'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Proof_of_Ownership</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        
                                                        
                                                        <img src="' . $result['0']['Proof_of_Ownership'] . '" style="height: 70px;">
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>';
		if (!empty($result['0']['Vehicle_img'])) {

			$imgl = json_decode($result['0']['Vehicle_img']);
			$count = 1;
			foreach ($imgl as $itm) {
				echo '<div class="form-group"><label class="col-md-3 control-label">Vehicle_img' . $count . '</label><div class="col-md-3">                                            
                                                    <div class="input-group">
                                                        <img src="' . $itm . '" style="height: 70px;">
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div></div>';
				$count++;
			}
		}
	}
	public function Vehicleprofiledel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('Vehicle_Profile', array('Vehicle_id' => $id));
	}



	public function PropertyProfile()
	{
		$dt = array('multiple', array(array('Propertytype', 'Propertytype.Propertytype_id=Property_Profile.Property_type')));
		$data['result'] = $this->beats_model->select_data('Propertytype.*,Property_Profile.*', 'Property_Profile', '', '', array('Property_Profile.Property_id', 'desc'), '', $dt);
		$this->load->view('Admin/PropertyProfile', $data);
	}

	public function Propertyprofiledel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('Property_Profile', array('Property_id' => $id));
	}
	public function UpdatePropertyProfile()
	{




		$user_detail = array(
			'Property_type' => $_POST['Property_type'],
			'Serial_Number' => $_POST['Serial_Number'],
			'Brand' => $_POST['Brand'],
			'Color' => $_POST['Color'],




		);

		$updt_id = $this->beats_model->update_data('Property_Profile', $user_detail, array('Property_id' => $_POST['Property_id']));
		//echo $this->db->last_query();

		redirect(base_url('/PropertyProfile'));
	}

	public function PropertyProfileview()
	{

		$id = $_POST['id'];

		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Property_Profile.user_id')));

		$res = $this->beats_model->select_data('user_signup.*,Property_Profile.*', 'Property_Profile', array('Property_Profile.Property_id' => $id), '', array('Property_Profile.Property_id', 'desc'), '', $dt);


		foreach ($res as $re) {

			$ptype = $this->beats_model->select_data('*', 'Propertytype', array('Propertytype_id' => $re['Property_type']));

			$ptrnsfer = $this->beats_model->select_data('*', 'Transfer_Property', array('Property_id' => $re['Property_id']));
			if (!empty($ptrnsfer)) {

				$new_Name = $ptrnsfer['0']['new_Name'];
				$new_phone = $ptrnsfer['0']['new_phone'];
				$Reason_Transfer = $ptrnsfer['0']['Reason_Transfer'];
			}

			$as1 = $re['property_uniquely'];
			$as2 = $ptype['0']['type_name'];
			$as3 = $re['Serial_Number'];
			//  $as4=$re['Vehicle_lastlocation'];
			$as5 = $re['Brand'];
			$as6 = $re['user_id'];
			$as7 = $re['user_name'];
			$as8 = $re['user_phone'];
			$as9 = json_decode($re['Property_img']);
			$as10 = $re['created_at'];

			$as12 = $re['Color'];
			//$as13=$re['Vehicle_Color'];
			$as14 = $re['Proof_of_Ownership'];
			$as15 = $re['qrcodeimg'];


			echo '<div class="col-12 col-md-12">
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as1 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">QR Code:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    <img src="' . $as15 . '" alt="QR Code" width="150"> 
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Property_type:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as2 . '</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Serial_Number:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">' . $as3 . '</span>
										</div>
										</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Brand:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as5 . '
																					</span>
										</div>
									</div>
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Color:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as12 . '
																					</span>
										</div>
									</div>
									
									<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Proof_of_Ownership:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    <img src="' . $as14 . '" alt="Smiley face" height="60" width="60">
																					</span>
										</div>
									</div>
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user id:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as6 . '
																					</span>
										</div>
									</div>	<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as7 . '
																					</span>
										</div>
									</div>
									
									
										<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">user Phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											    ' . $as8 . '
																					</span>
										</div>
									</div>';
			if (!empty($as9)) {
				foreach ($as9 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Property_img:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											  <img src="' . $itm . '" alt="Smiley face" height="60" width="60"> 
																					</span>
										</div>
									</div>';
				}
			}
			if (!empty($ptrnsfer)) {

				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Transfer name:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											 ' . $new_Name . '
																					</span>
										</div>
									</div><div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Transfer Phone:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											 ' . $new_phone . '
																					</span>
										</div>
									</div><div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Reason Transfer:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											
											 ' . $Reason_Transfer . '
																					</span>
										</div>
									</div>';
			}



			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677;">
										<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">created_at:</div>
										<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
											<span style="float:left;">
											' . $as10 . '											</span>
										</div>
									</div>
									</div>';
		}
	}

	public function PropertyProfileedit()
	{
		//$result = $this->beats_model->select_data('*' , 'Stolen_Vehicle',array('StolenVehicle_id'=>$_POST['StolenVehicle_id']));
		$dt = array('multiple', array(array('user_signup', 'user_signup.user_id=Property_Profile.user_id')));

		$result = $this->beats_model->select_data('user_signup.*,Property_Profile.*', 'Property_Profile', array('Property_Profile.Property_id' => $_POST['Property_id']), '', array('Property_Profile.Property_id', 'desc'), '', $dt);


		$ptype = $this->beats_model->select_data('*', 'Propertytype');



		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Property_type</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        
                                                        <select name="Property_type" id="Property_type" class="form-control">';
		foreach ($ptype as $itm) {
			echo '<option value="' . $itm['Propertytype_id'] . '"';
			if ($result['0']['Property_type'] == $itm['Propertytype_id']) {
				echo 'selected';
			}
			echo '>' . $itm['type_name'] . '</option>';
		}


		echo '</select>
                                                       
                                                         <input type="hidden" class="form-control" name="Property_id" id="Property_id"  value="' . $result['0']['Property_id'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Serial_Number</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Serial_Number" id="Serial_Number" value="' . $result['0']['Serial_Number'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            
                                            	
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Brand</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Brand" id="Brand" value="' . $result['0']['Brand'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Color</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name="Color" id="Color" value="' . $result['0']['Color'] . '" required/>
                                                        
                                                       
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>
                                           
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Proof_of_Ownership</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        
                                                        
                                                        <img src="' . $result['0']['Proof_of_Ownership'] . '" style="height: 70px;">
                                                        
                                                    </div>                                            
                                                 
                                                </div>
                                            </div>';
		if (!empty($result['0']['Property_img'])) {

			$imgl = json_decode($result['0']['Property_img']);
			$count = 1;
			foreach ($imgl as $itm) {
				echo '<div class="form-group"><label class="col-md-3 control-label">Property_img' . $count . '</label><div class="col-md-3">                                            
                                                    <div class="input-group">
                                                        <img src="' . $itm . '" style="height: 70px;">
                                                        
                                                        
                                                    </div>                                            
                                                 
                                                </div></div>';
				$count++;
			}
		}
	}

	public function TrafficReports()
	{
		$AGENCY = unserialize(AGENCY);

		$data['state_new'] = $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$data['result'] = $this->beats_model->select_data('*', 'Traffic_Reports', '', '', array('TrafficReport_id', 'desc'));
		$this->load->view('Admin/TrafficReports', $data);
	}
	public function TrafficReportsAdd()
	{
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
				$images_seen[] = base_url() . 'uploads/' . $picture;
			}
		}

		// code by invito

		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
		$config['encrypt_name'] = TRUE;
		$new_name = time() . $_FILES['doc']['name'];
		$config['file_name'] = $new_name;
		//Load upload library and initialize configuration
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload('doc')) {
			$uploadData = $this->upload->data();
			$picture = $uploadData['file_name'];
			$docurl = base_url() . 'uploads/' . $picture;
		} else {
			$docurl = '';
		}

		// code by invito

		$user_detail = array(
			'area' => $_POST['area'],
			'traffic_level' => $_POST['traffic_level'],
			'recommendation' => $_POST['recommendation'],
			'time' => $_POST['time'],
			'date' => $_POST['date'],
			'images' => json_encode($images_seen),
			'Document' => $docurl,
		);

		$reg_id = $this->beats_model->insert_data('Traffic_Reports', $user_detail);

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Created enotice Traffic Report. ID '.$reg_id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		$ds = array_merge($_POST, array("enotice_id" => $reg_id, "enotice_type" => 6));
	   $messageNotification = $_POST['area'] ."\n".$_POST['recommendation'];
		$this->EnoticenotificationNew("eNotice for Traffic Repport", $messageNotification, $ds);

		redirect(base_url('/TrafficReports'));
	}

	public function TrafficReportsdel()
	{
		$id = $_POST['id'];
		$res = $this->beats_model->delete_data('Traffic_Reports', array('TrafficReport_id' => $id));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Deleted enotice Traffic Report. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);
	}

	public function TrafficReportsstatus()
	{
		$res = $this->beats_model->update_data('Traffic_Reports', array('TrafficReport_status' => $_POST['status']), array('TrafficReport_id' => trim($_POST['id'])));

		$date = date('Y-m-d H:i:s');
		if($_POST['status'] == 1)
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Activated enotice Traffic Report. ID '. $_POST['id'],
				'time' => $date
			);
		}
		else
		{
			$dataset = array(
				'user_id' => $this->session->userdata('user_id'),
				'user_name' => $this->session->userdata('username'),
				'login_ip' => $_SERVER['REMOTE_ADDR'],
				'activity' => 'Deactivated enotice Traffic Report. ID '. $_POST['id'],
				'time' => $date
			);
		}
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		echo $_POST['status'];
	}
	public function TrafficReportsUpdate()
	{
		// $files = $_FILES;
		// $count = count($_FILES['images']['name']);
		// for ($i = 0; $i < $count; $i++) {
		// 	$_FILES['images']['name'] = time() . $files['images']['name'][$i];
		// 	$_FILES['images']['type'] = $files['images']['type'][$i];
		// 	$_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];
		// 	$_FILES['images']['error'] = $files['images']['error'][$i];
		// 	$_FILES['images']['size'] = $files['images']['size'][$i];
		// 	$config['upload_path'] = 'uploads/';
		// 	$config['allowed_types'] = 'gif|jpg|png|jpeg|mp4|3gp';
		// 	$config['max_size'] = '';
		// 	$config['remove_spaces'] = true;
		// 	$config['overwrite'] = false;
		// 	$config['max_width'] = '';
		// 	$config['max_height'] = '';
		// 	$config['encrypt_name'] = TRUE;
		// 	$this->load->library('upload', $config);
		// 	$this->upload->initialize($config);
		// 	if ($this->upload->do_upload()) {
		// 		$uploadData = $this->upload->data();
		// 		$picture = $uploadData['file_name'];
		// 		$fileName = time() . $files['images']['name'][$i];
		// 		$images[] = base_url() . 'uploads/' . $picture;
		// 	}
		// }
		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
		$config['encrypt_name'] = TRUE;

		if(!empty($_FILES['doc']['name']))
		{
			$new_name = time() . $_FILES['doc']['name'];
			$config['file_name'] = $new_name;
			//Load upload library and initialize configuration
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('doc')) {
				$uploadData = $this->upload->data();
				$picture = $uploadData['file_name'];
				$docurl = base_url() . 'uploads/' . $picture;
			} else {
				$docurl = '';
				$user_detail = array(
					'area' => $_POST['area'],
					'traffic_level' => $_POST['traffic_level'],
					'recommendation' => $_POST['recommendation'],
					'time' => $_POST['time'],
					'date' => $_POST['date'],
					'Document' => $docurl,
					// 'images' => json_encode($images),
				);
			}
		}
		else
		{
			$user_detail = array(
				'area' => $_POST['area'],
				'traffic_level' => $_POST['traffic_level'],
				'recommendation' => $_POST['recommendation'],
				'time' => $_POST['time'],
				'date' => $_POST['date'],
				// 'images' => json_encode($images),
			);
		}


		$updt_id = $this->beats_model->update_data('Traffic_Reports', $user_detail, array('TrafficReport_id' => $_POST['TrafficReport_id']));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Updated enotice Traffic Report. ID '.$_POST['TrafficReport_id'],
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);


		redirect(base_url('/TrafficReports'));
	}

	public function TrafficReportsview()
	{

		$id = $_POST['id'];
		$res = $this->beats_model->select_data('*', 'Traffic_Reports', array('TrafficReport_id' => $id));

		$date = date('Y-m-d H:i:s');
		$dataset = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_name' => $this->session->userdata('username'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'activity' => 'Viewed enotice Traffic Report. ID '.$id,
			'time' => $date
		);
		$this->beats_model->insert_data('subadmin_logs',$dataset);

		foreach ($res as $re) {

			if ($re['TrafficReport_status'] == 0) {
				$status = 'UnClear';
			} else {
				$status = 'Clear';
			}
			$as1 = $re['TrafficReport_id'];
			$as2 = $re['area'];
			$as3 = $re['traffic_level'];
			$as4 = $re['recommendation'];
			$as5 = $re['time'];
			$as6 = $re['date'];
			$as7 = json_decode($re['images']);
			$as8 = $re['created_at'];
			$as9 = $re['updated_at'];
			$as10 = $status;

			if($re['Document'] == '' || $re['Document'] == NULL)
			{
				$download = '';
			}
			else
			{
				$download = 'DOWNLOAD';
			}

			echo '
			<div class="col-12 col-md-12">
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">' . $as1 . '</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Area:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">' . $as2 . '</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Trafic Level:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">' . $as3 . '</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Recommendation:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as4 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Date:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as5 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Time:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as6 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Status:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as10 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Created At:</div>SOSManagement
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as8 . '
					</span>
				</div>
			</div>';
			if (!empty($as9)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Updated At:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
				<span style="float:left;">
				' . $as9 . '
				</span>
				</div>
				</div>';
			}

			if (!empty($as7)) {
				foreach ($as7 as $itm) {
					echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
		
						<img src="' . $itm . '" alt="Smiley face" height="60" width="60">
					</span>
				</div>
			</div>';
				}
			}
			echo '</div>';

			echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
			<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Document:</div>
			<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
				<span style="float:left;">
				
				  <a href="' . $re['Document'] . '" alt="Document" download>'.$download.'</a>
														</span>
			</div>
		</div>';	
		}
	}

	public function TrafficReportsedit()
	{
		$result = $this->beats_model->select_data('*', 'Traffic_Reports', array('TrafficReport_id' => $_POST['TrafficReport_id']));
		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Area</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <textarea class="form-control" name="area" id="area" required>' . $result['0']['area'] . '</textarea>
                                                         <input type="hidden" class="form-control" name="TrafficReport_id" id="TrafficReport_id"  value="' . $result['0']['TrafficReport_id'] . '" required/>                                                                                                             
                                                    </div>                                                                                   
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                                            <label class="col-md-3 control-label">Traffic Level</label>
                                                                            <div class="col-md-9">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                                                    <select class="form-control" name="traffic_level" id="traffic_level" required>
                                                                                        <option value="">Select Type</option>';
?>
		<option value="High" <?php echo ($result['0']['traffic_level'] == "High" ? "selected" : ""); ?>>High</option>
		<option value="Intermediate" <?php echo ($result['0']['traffic_level'] == "Intermediate" ? "selected" : ""); ?>>Intermediate</option>
		<option value="Low" <?php echo ($result['0']['traffic_level'] == "Low" ? "selected" : ""); ?>>Low</option>
<?php echo '</select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
																		<div class="form-group">
																		<label class="col-md-3 control-label">Recommendation</label>
																		<div class="col-md-9">
																			<div class="input-group">
																				<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
																				<textarea class="form-control" name="recommendation" id="recommendation" required>' . $result['0']['recommendation'] . '</textarea>
																			</div>
																		</div>
																	</div>
																	<div class="form-group">
																		<label class="col-md-3 control-label">Date</label>
																		<div class="col-md-9">
																			<div class="input-group">
																				<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
																				<input type="date" class="form-control" name="date" id="date" value="' . $result['0']['date'] . '" required />
																			</div>
																		</div>
																	</div>
																	<div class="form-group">
																		<label class="col-md-3 control-label">Time</label>
																		<div class="col-md-9">
																			<div class="input-group">
																				<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
																				<input type="time" class="form-control" name="time" id="time" value="' . $result['0']['time'] . '" required />
																			</div>
																		</div>
																	</div>
																	<div class="form-group">
																		<label class="col-md-3 control-label">Update Document</label>
																		<div class="col-md-9">                                            
																			<div class="input-group">
																				<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
																				<input type="file" class="form-control" name="doc" id="doc" accept="image/x-png,image/gif,image/jpeg,application/pdf" />
																				
																				
																			</div>                                            
																		
																		</div>
																	</div>';
		// echo '<div class="form-group">
		// <label class="col-md-3 control-label">Picture Of Seen </label>
		// <div class="col-md-3">
		//  <div class="input-group">
		// 	<input type="file" class="form-control" name="images_seen[]" id="images_seen" value="" accept="image/x-png,image/gif,image/jpeg,image/jpg" multiple />
		// </div></div></div>';
	}

	public function eDirectory()
	{
		$dt = array('multiple', array(array('business_category', 'business_category.business_id=user_directories.business_id', 'left'), array('user_signup', 'user_signup.user_id=user_directories.user_id', 'left')));
		$data['result'] = $this->beats_model->select_data('business_category.*,user_directories.*,user_signup.user_name,user_signup.user_phone', 'user_directories', '', '', array('user_directories.is_promoted' => 'DESC', 'user_directories.business_type' => 'DESC', 'user_directories.directory_id' => 'DESC', 'user_directories.place' => 'DESC'), '', $dt);
		// echo $this->db->last_query();
		$data['business_category'] = $this->beats_model->select_data('*', 'business_category');
		$this->load->view('Admin/eDirectory', $data);
	}
	public function eDirectorydel()
	{
		$id = $_POST['id'];
		$res = $this->beats_model->delete_data('user_directories', array('directory_id' => $id));
	}

	public function eDirectoryUpdate()
	{

		$business_category =  $this->beats_model->select_data('*', 'business_category', "business_name Like '%" . $_POST['business_category'] . "%' ");
		$user_detail = array(
			'name' => $_POST['name'],
			// 'business_id' => $business_category[0]['business_id'],
			'business_id' =>  $_POST['business_category'],
			// 'user_id' => $_POST['user_id'],
			'place' => $_POST['place'],
			'address' => $_POST['address'],
			'business_type' => $_POST['business_type'],
			'description' => $_POST['description'],
			'phone_number' => $_POST['phone_number'],
		);

		$updt_id = $this->beats_model->update_data('user_directories', $user_detail, array('directory_id' => $_POST['directory_id']));
		redirect(base_url('/eDirectory'));
	}
	public function eDirectorystatus()
	{
		$res = $this->beats_model->update_data('user_directories', array('is_active' => $_POST['status']), array('directory_id' => trim($_POST['id'])));
		echo $_POST['status'];
	}

	public function eDirectoryPromote()
	{
		$res = $this->beats_model->update_data('user_directories', array('is_promoted' => $_POST['status']), array('directory_id' => trim($_POST['id'])));
		echo $_POST['status'];
	}

	public function eDirectoryview()
	{

		$id = $_POST['id'];

		$dt = array('multiple', array(array('business_category', 'business_category.business_id=user_directories.business_id', 'left')));
		$res = $this->beats_model->select_data('business_category.*,user_directories.*', 'user_directories', "directory_id = '" . $id . "'", '', array('directory_id', 'DESC'), '', $dt);

		foreach ($res as $re) {
			$user_name = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $re['user_id']), '', array('user_id', 'DESC'), '', '');
			if ($re['is_active'] == 0) {
				$status = 'Active';
			} else {
				$status = 'Deactive';
			}
			$as1 = $re['directory_id'];
			$as2 = $re['name'];
			$as3 = $re['business_name'];
			$as4 = $re['place'];
			$as5 = $re['address'];
			$as6 = $re['description'];
			$as7 = $re['phone_number'];
			$as8 = $user_name[0]['user_name'];
			$as9 = $user_name[0]['user_phone'];
			$as10 = $status;
			$as11 = $this->getDayNew($re['created_at']);
			$as12 = $this->getDayNew($re['updated_at']);
			$as13 = ($re['is_promoted'] == 1 ? 'Promoted' : 'Unpromoted');
			$as14 = ($re['business_type'] == 1 ? 'Regular' : 'Premium');
			$as15 = json_decode($re['images']);

			echo '
			<div class="col-12 col-md-12">
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">ID:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">' . $as1 . '</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Name:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">' . $as2 . '</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; border-bottom:none;">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Business Category:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">' . $as3 . '</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Place:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as4 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Address:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as5 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Description:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as6 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Phone Number:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as7 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Status:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as10 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">User Name:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as8 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">User Phone Number:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as9 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Business Status:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as13 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Business Type:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as14 . '
					</span>
				</div>
			</div>
			<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Created At:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
					<span style="float:left;">
						' . $as11 . '
					</span>
				</div>
			</div>';
			if (!empty($as12)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
				<div style="text-align:left;width:40%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Updated At:</div>
				<div style="text-align:left;width:60%;float:left;padding:5px 10px;">
				<span style="float:left;">
				' . $as12 . '
				</span>
				</div>
				</div>';
			}
			if (!empty($as15)) {
				echo '<div style="text-align:left;width:100%;float:left;border:1px solid #5d6677; ">
					       <div style="text-align:left;width:100%;float:left;padding:5px 10px;background-color:#EAEAEA;font-weight:bold;">Media:</div>
						   <div style="text-align:left;width:100%;float:left;padding:5px 10px;">';
				foreach ($as15 as $newarimg1) {
					$ext = pathinfo($newarimg1, PATHINFO_EXTENSION);
					$newmg1 = $newarimg1;
					if ($ext == 'mp4' || $ext == '3gp') {
						$newmg1 = 'images/video-player.png';
					}
					if ($ext == 'mp3') {
						$newmg1 = 'images/icons8-itunes-100.png';
					}
					echo '<span style="float:left;padding:2.5px 2.5px;">
								<a target="_blank" href="' . $newarimg1 . '">
										<img src="' . $newmg1 . '" style="height: 60px;width: 90px;">
									
								</a></span>';
				}
				echo '	</div>
						</div>';
			}
			echo '</div>';
		}
	}

	public function eDirectoryedit()
	{
		$business_category =  $this->beats_model->select_data('*', 'business_category');
		$dt = array('multiple', array(array('business_category', 'business_category.business_id=user_directories.business_id', 'left')));
		$result = $this->beats_model->select_data('business_category.*,user_directories.*', 'user_directories', "directory_id = '" . $_POST['directory_id'] . "'", '', array('directory_id', 'DESC'), '', $dt);
		$state_new =  $this->beats_model->select_data('*', 'state_zone', array('STATE' => 'Abia'), '', array('STATE', 'ASC'));
		$user_name = $this->beats_model->select_data('*', 'user_signup', array('user_id' => $result[0]['user_id']), '', array('user_id', 'DESC'), '', '');

		echo '
		<div class="form-group">
                                                <label class="col-md-3 control-label">name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <textarea class="form-control" name="name" id="area" required>' . $result['0']['name'] . '</textarea>
                                                        <input type="hidden" class="form-control" name="directory_id" id="directory_id"  value="' . $result['0']['directory_id'] . '" required/>                                                                                                             
                                                        
                                                    </div>                                                                                   
                                                </div>
                                            </div>	
		
											<div class="form-group">
											<label class="col-md-3 control-label">Business Category</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													
													<select class="form-control" name="business_category" id="business_category" required>
													<option value="">Select Business Category</option>
													';
		foreach ($business_category as $itm) {
			echo '<option value="' . $itm['business_id'] . '" ';
			if ($result['0']['business_id'] == $itm['business_id']) {
				echo 'selected';
			}
			echo '>' . $itm['business_name'] . '</option>';
		}
		echo '</select>                                
												</div>                                            
											 
											</div>
										</div>
		<div class="form-group">
                                                <label class="col-md-3 control-label">State</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
														<select class="form-control" name="place" id="place" required>
														<option value="">Select Place</option>
														';
		foreach ($state_new as $itm) {
			echo '<option value="' . $itm['LGA'] . '" ';
			if ($result['0']['place'] == $itm['LGA']) {
				echo 'selected';
			}
			echo '>' . $itm['LGA'] . '</option>';
		}
		echo '</select>                                
                                                    </div>                                            
                                                 
                                                </div>
											</div>';
		echo '<div class="form-group">
											<label class="col-md-3 control-label">User Name</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													<input type="text" class="form-control" name="user_name" id="user_name"  value="' . $user_name['0']['user_name'] . '" readonly required/>
													<input type="hidden" class="form-control" name="user_id" id="user_id"  value="' . $user_name['0']['user_id'] . '" required/>
													
												   
												</div>                                            
											 
											</div>
										</div>';
		echo '<div class="form-group">
		<label class="col-md-3 control-label">Business Type</label>
		<div class="col-md-9">                                            
			<div class="input-group">
				<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
				<select class="form-control" name="business_type" id="business_type" required>
				<option value="1" ' . ($result[0]['business_type'] == 1 ? "selected" : "") . ' >Regular</option>
				<option value="2" ' . ($result[0]['business_type'] == 2 ? "selected" : "") . ' >Premium</option>
				</select>                                
			</div>                                            
		 
		</div>
	</div>';
		echo '<div class="form-group">
											<label class="col-md-3 control-label">Phone Number</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													<input type="text" class="form-control" name="phone_number" id="phone_number"  value="' . $user_name['0']['user_phone'] . '" required/>
												</div>                                            
											</div>
										</div>											
										<div class="form-group">
											<label class="col-md-3 control-label">Address</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													
													<textarea class="form-control" name="address" id="address" required>' . $result['0']['address'] . '</textarea>
													</div>                                            
											</div>
										</div>											
										<div class="form-group">
											<label class="col-md-3 control-label">Description</label>
											<div class="col-md-9">                                            
												<div class="input-group">
													<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
													
													<textarea class="form-control" name="description" id="description" required>' . $result['0']['description'] . '</textarea>
													</div>                                            
											</div>
										</div>											
									   ';
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


// -----------------------------------------------   Code by Invito / rummy   ----------------------------------------------


// ----------------------- Sub admin code  ----------------------

	public function sub_admins()
	{
		if($this->session->userdata('role') == 1)
		{
			redirect(base_url());
		}
		$data['admin'] = $this->beats_model->select_data('*', 'admin',array('role' => '1'));
		// print_r($_SESSION);
		$this->load->view('Admin/sub-admins', $data);
		
	}

	public function subadmin_status()
	{

		$res = $this->beats_model->update_data('admin', array('is_active' => $_POST['status']), array('id' => trim($_POST['id'])));

		echo $_POST['status'];
	}
	
	public function update_subadmin()
	{
		if($this->session->userdata('role') == 1)
		{
			redirect(base_url());
		}
		$dataset = array(
			'email' => $_POST['email'],
			'password' => $_POST['passwrd'],
		);
		$reg_id = $this->beats_model->update_data('admin', $dataset, array('id' => trim($_POST['admin_id'])));
		// $this->session->set_userdata('username', $_POST['email']);
		$this->session->set_flashdata('success', 'Successfull Update'); // wrong details		
		$data['admin'] = $this->beats_model->select_data('*', 'admin',array('role' => '1'));


		//$this->load->view('Admin/profile',$data);
		redirect(base_url('/sub-admins'));
	}

	public function delete_subadmin()
	{
		if($this->session->userdata('role') == 1)
		{
			redirect(base_url());
		}
		$id = $_GET['id'];
		$this->beats_model->delete_data('admin',array('id' => $id));
		$this->session->set_flashdata('success', 'Successfull Delete'); // wrong details		
		$data['admin'] = $this->beats_model->select_data('*', 'admin',array('role' => '1'));
		redirect(base_url('/sub-admins'));
		
	}

	public function addsubadmin()
	{
		if($this->session->userdata('role') == 1)
		{
			redirect(base_url());
		}
		$dataset = array(
			'email' => $_POST['email'],
			'password' => $_POST['passwrd'],
		);
		$emailcheck = $this->beats_model->select_data('*','admin',array('email' => $_POST['email']));
		if(count($emailcheck) > 0)
		{
			$this->session->set_flashdata('error', 'Admin already exist');
			redirect(base_url('/sub-admins'));
		}
		$this->beats_model->insert_data('admin',$dataset);
		redirect(base_url('/sub-admins'));
	}


// ----------------------- Unit type CRUD code  -----------------------------


	public function PoliceUnittype(){
		// echo "yes";
		$data['Unittypes'] = $this->beats_model->select_data('*','PoliceUnitType','PoliceUnitType_id NOT IN (1,2,3,4,5,6,7,8)');
		$this->load->view('Admin/Unittype',$data);
	}

	public function UnitTypeStatus()
	{
		$res = $this->beats_model->update_data('PoliceUnitType', array('PoliceUnitType_status' => $_POST['status']), array('PoliceUnitType_id' => trim($_POST['id'])));
		echo $_POST['status'];
	}

	public function Create_PoliceUnittype()
	{
		$this->session->set_flashdata('success', 'Unit Type created');
		$this->beats_model->insert_data('PoliceUnitType',array('PoliceUnitType_name' => $_POST['UnitTypeName']));
		redirect(base_url('/police-unit-type'));
	}

	public function PoliceUnitTypedel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('PoliceUnitType', array('PoliceUnitType_id' => $id));
		$this->session->set_flashdata('success', 'Unit Type Deleted');
	}

	public function PoliceUnitTypeEdit()
	{
		$result = $this->beats_model->select_data('*', 'PoliceUnitType', array('PoliceUnitType_id' => $_POST['id']));
		echo '<div class="form-group">
    			<label class="col-md-4 control-label">Unit Type Name</label>
					<div class="col-md-8">
						<div class="input-group">
							<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
							<input type="hidden" class="form-control" name="id" id="UnitId" value="' . $result['0']['PoliceUnitType_id'] . '" />
							<input type="text" class="form-control" name="UnitTypeName" id="UnitName" value="' . $result['0']['PoliceUnitType_name'] . '" required />
						</div>
					</div>
				</div>';

	}

	public function UpdatePoliceUnitType()
	{
		$this->beats_model->update_data('PoliceUnitType', array('PoliceUnitType_name' => $_POST['UnitTypeName']), array('PoliceUnitType_id' => $_POST['id']));
		$this->session->set_flashdata('success', 'Unit Type Updated');
		redirect(base_url('/police-unit-type'));
	}


// ----------------------- Appsetings CRUD code  -----------------------------


	public function AppSettings()
	{
		$data['AppSettings'] = $this->beats_model->select_data('*','tbl_appsettings');
		$this->load->view('Admin/AppSettings',$data);
	}

	public function UpdateSettings()
	{
		$this->beats_model->update_data('tbl_appsettings',array('stateName' => $_POST['stateName'] , 'projCompany' => $_POST['projCompany'] , 'smsNumber' => $_POST['smsNumber'] , 'appName' => $_POST['appName']), array('tblSno' => $_POST['tblSno']));
		$this->session->set_flashdata('success', 'Application Settings Updated');
		redirect(base_url('/application-settings'));
	}
	
	// ----------------------- Agency CRUD code  -----------------------------
	


	public function AppAgency()
	{
		$data['AppAgency'] = $this->beats_model->select_data('*','agency');
		$this->load->view('Admin/AppAgency',$data);
	}
	
	public function Agencylist()
	{
		$data['AppAgency'] = $this->beats_model->select_data('*','agency','','',array('id','desc'));
		$this->load->view('Admin/AgencyList', $data);
	}
	
		public function Updateagency()
	{
		if($this->session->userdata('role') == 1)
		{
			redirect(base_url());
		}
			$agency_detail = array(
			'name' => $_POST['name'],
		   );
		    
		$updateAgency = $this->beats_model->update_data('agency', $agency_detail, array('id' => $_POST['agencyId']));
		$this->session->set_flashdata('success', 'Successfull Update'); // wrong details
		echo true;
	}
	
	public function saveAgency()
	{
		if($this->session->userdata('role') == 1)
		{
			redirect(base_url());
		}
			$dataset = array(
			'name' => $_POST['name'],
		   );
	   	$this->beats_model->insert_data('agency',$dataset);
     	echo true;
	}
	
	
	
	public function Agencydel()
	{
		$id = $_POST['id'];

		$res = $this->beats_model->delete_data('agency', array('id' => $id));

		echo true;
	}
	
	
	public function Addagency()
	{
    echo '<div class="form-group">
        <label class="col-md-3 control-label">Name</label>
        <div class="col-md-9">                                            
            <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                <input type="hidden" class="form-control" name="gency_id" id="gency_id" value=""  required/>
                <input type="tel" class="form-control" name="name" id="name" value=""  required/>
            </div>  
        </div>
    </div>';
	}



    public function AgencyEdit()
	{
		$id = $_POST['match_id'];
		$res = $this->beats_model->select_data('*', 'agency', array('id' => $id));

		$user_meta = array(
			'id' => $id,
		 	'name' => (!empty($res) ? $res[0]['name'] : ''));
		
		$LGA_ST = unserialize(LGA_ST);
		$BLOOD_GP = unserialize(BLOOD_GP);
		$GENO_TY = unserialize(GENO_TY);

		$res[0] = array_merge($res[0], $user_meta);
		echo '<div class="form-group">
                                                <label class="col-md-3 control-label">Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="hidden" class="form-control" name="gency_id" id="gency_id" value="' . $res['0']['id'] . '"  required/>
                                                        <input type="tel" class="form-control" name="name" id="name" value="' . $res['0']['name'] . '"  required/>
                                                    </div>  
                                                </div>
                                            </div>
											';
	}

// ----------------------- Sub admin logs Code  -----------------------------

	public function SubadminLogs()
	{
		if($this->session->userdata('role') == 1)
		{
			redirect(base_url());
		}
		$data['logs'] = $this->beats_model->select_data('*','subadmin_logs','user_id !=1','',array('id','desc'));
		$this->load->view('Admin/Subadminlogs',$data);
	}
}

<?php
	defined('BASEPATH') OR exit('no direct script access allowed'); 
	
	function titleval(){
		
		return 'mywebsite';
	}
	function dateFormate1($findDate1){
		date_default_timezone_set('Asia/Kolkata');	
		$full1 = explode("/",$findDate1);			
		$d1 = $full1[0]; 
		$m1 = $full1[1]; 
		$y1 = $full1[2]; 
		
		$date1 = $y1."-".$m1."-".$d1;
		$originalDate1 = $date1;
		$newDate1 = date("Y-m-d", strtotime($originalDate1));
		
		return $newDate1;
	}
	
	function dateFormate2($findDate1){
		date_default_timezone_set('Asia/Kolkata');
		$newDate1 = date("d-m-Y H:i:s", strtotime($findDate1));		
		return $newDate1;
	}
	
	function todayFullDate(){
		date_default_timezone_set('Asia/Kolkata');
		$newDate1 = date("d-m-Y H:i:s");		
		return $newDate1;
	}
	
	
	function dateFormate3($fromDate){
		$full1 = explode("-",$fromDate);			
		$y1 = $full1[0]; 
		$m1 = $full1[1]; 
		$d1 = $full1[2]; 		
		$date1 = $d1."/".$m1."/".$y1;
		
		return $date1;
	}
	
	function sessionval(){
		$userid = "";		
		if(isset($_SESSION['userid']) != '') {		
	
			$userid = $_SESSION['userid'];	
		}	
		if($userid){			
			return $userid;			
		}else{			
			$userid = "";			
			return $userid;
		}	
	}
	function sessionnameval(){
		$username = "";		
		if(isset($_SESSION['username']) != '') {		
	
			$username = $_SESSION['username'];	
		}	
		if($username){			
			return $username;			
		}else{			
			$username = "";			
			return $username;
		}	
	}
	
	//Date format
    function getCurrentDate()
    {
    	date_default_timezone_set('Africa/Lagos');
    	$currentTime = date('Y-m-d');
    	
    	return $currentTime;
    }
?>	